<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\TicketConfirmation;
use App\Models\EventTicket;
use App\Models\Booking;
use App\Models\BookingTicket;
use App\Services\KhaltiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View; // Add this for rendering the view
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show booking form
     */
    public function create(EventTicket $eventTicket)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book tickets.');
        }

        $bookedQuantity = BookingTicket::where('event_ticket_id', $eventTicket->id)
            ->join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->whereIn('bookings.payment_status', ['pending', 'paid'])
            ->sum('booking_ticket.quantity');

        $remaining = $eventTicket->total_seats - ($eventTicket->sold_seats + $bookedQuantity);

        $now = Carbon::now();
        $isOnSale = true;

        if ($eventTicket->sale_start && $now->lt($eventTicket->sale_start)) {
            $isOnSale = false;
        }
        if ($eventTicket->sale_end && $now->gt($eventTicket->sale_end)) {
            $isOnSale = false;
        }

        if ($remaining <= 0 || !$isOnSale) {
            $message = $remaining <= 0
                ? 'This ticket is sold out.'
                : 'This ticket is not currently available for sale.';

            return redirect()->back()->with('error', $message);
        }

        $eventTicket->load('event');

        return view('frontend.event.create', compact('eventTicket', 'remaining'));
    }

    /**
     * Create booking and redirect to Khalti
     */
    public function store(Request $request, KhaltiService $khalti)
    {
        $request->validate([
            'event_ticket_id' => 'required|exists:event_tickets,id',
            'quantity' => 'required|integer|min:1|max:20',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:khalti',
        ]);

        $eventTicket = EventTicket::findOrFail($request->event_ticket_id);
        $quantity = (int)$request->quantity;

        $bookedQuantity = BookingTicket::where('event_ticket_id', $eventTicket->id)
            ->join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->whereIn('bookings.payment_status', ['pending', 'paid'])
            ->sum('booking_ticket.quantity');

        $remaining = $eventTicket->total_seats - ($eventTicket->sold_seats + $bookedQuantity);

        if ($quantity > $remaining) {
            return back()->withInput()->with('error', "Only {$remaining} ticket(s) available.");
        }

        $totalAmount = $quantity * $eventTicket->price;

        return DB::transaction(function () use ($request, $eventTicket, $quantity, $totalAmount, $khalti) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'event_id' => $eventTicket->event_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            BookingTicket::create([
                'booking_id' => $booking->id,
                'event_ticket_id' => $eventTicket->id,
                'quantity' => $quantity,
                'price_at_booking' => $eventTicket->price,
                'sub_total' => $totalAmount,
            ]);

            $payload = [
                'return_url' => route('booking.success'),
                'website_url' => config('services.khalti.website_url'),
                'amount' => (int)($totalAmount * 100), // paisa
                'purchase_order_id' => 'booking-' . $booking->id,
                'purchase_order_name' => $eventTicket->name . ' - ' . $eventTicket->event->title,
                'customer_info' => [
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ],
            ];

            $response = $khalti->initiatePayment($payload);

            if (isset($response['payment_url']) && isset($response['pidx'])) {
                $booking->update(['transaction_id' => $response['pidx']]);
                return redirect()->away($response['payment_url']);
            }

            throw new \Exception('Khalti payment initiation failed: ' . json_encode($response));
        });
    }

    /**
     * Khalti callback - Verify and confirm payment
     */
  /**
 * Khalti callback - Verify and confirm payment
 */
public function success(Request $request, KhaltiService $khalti)
{
    $pidx = $request->query('pidx');

    if (!$pidx) {
        return view('frontend.event.cancel')->with('error', 'Invalid payment callback.');
    }

    $booking = Booking::where('transaction_id', $pidx)
        ->where('payment_status', 'pending')
        ->first();

    if (!$booking) {
        return view('frontend.event.cancel')->with('error', 'Booking not found or already processed.');
    }

    // Verify with Khalti lookup API
    $lookup = $khalti->lookupPayment($pidx);

    // Always save the raw response for debugging
    $booking->payment_response = $lookup;
    $booking->save();

    Log::info('Khalti Payment Lookup', ['pidx' => $pidx, 'response' => $lookup]);

    if (isset($lookup['status']) && $lookup['status'] === 'Completed') {
        DB::transaction(function () use ($booking, $lookup, $khalti) {
            $booking->payment_status = 'paid';
            $booking->status = 'confirmed';

            if (isset($lookup['transaction_id'])) {
                $booking->transaction_id = $lookup['transaction_id'];
            }

            // Generate unique secure token for QR code verification
            $booking->ticket_token = Str::random(40);
            $booking->save();

            // Load relationships needed for email and views
            $booking->load(['bookingTickets.eventTicket.event', 'event']);

            // Confirm seats (increment sold_seats)
            $bookingTicket = BookingTicket::where('booking_id', $booking->id)->first();
            if ($bookingTicket) {
                EventTicket::where('id', $bookingTicket->event_ticket_id)
                    ->increment('sold_seats', $bookingTicket->quantity);
            }

            // Generate QR Code
           $verificationUrl = route('verify.ticket', $booking->ticket_token);

           $qrCodePng = (string) QrCode::format('png')
    ->size(400)
    ->errorCorrection('H')
    ->generate($verificationUrl);

            // Send confirmation email using the proper Mailable
            Mail::to($booking->email)->send(new TicketConfirmation($booking, $qrCodePng));
        });

        return view('frontend.event.success', compact('booking'))
            ->with('message', 'Payment successful! Your ticket with QR code has been sent to your email.');
    }

    // Payment failed or not completed
    $booking->payment_status = 'failed';
    $booking->status = 'cancelled';
    $booking->save();

    $errorMsg = $lookup['message'] ?? 'Payment could not be verified.';
    return view('frontend.event.cancel')->with('error', $errorMsg);
}
    /**
     * User cancelled payment on Khalti
     */
    public function cancel(Request $request)
    {
        $pidx = $request->query('pidx');

        if ($pidx) {
            $booking = Booking::where('transaction_id', $pidx)->first();
            if ($booking && $booking->payment_status === 'pending') {
                $booking->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }
        }

        return view('frontend.event.cancel')->with('error', 'Payment was cancelled.');
    }

    /**
     * Verify ticket via QR code scan
     */
    public function verifyTicket($token)
    {
        $booking = Booking::where('ticket_token', $token)->first();

        if (!$booking) {
            return view('frontend.event.ticket-invalid')->with('error', 'Invalid ticket QR code.');
        }

        if ($booking->payment_status !== 'paid' || $booking->status !== 'confirmed') {
            return view('frontend.event.ticket-invalid')->with('error', 'This ticket is not paid or confirmed.');
        }

        if ($booking->is_checked_in) {
            return view('frontend.event.ticket-already-used')->with('message', 'This ticket has already been checked in.');
        }

        // Public view - show ticket details
        return view('frontend.event.ticket-valid', compact('booking'));
    }
}
