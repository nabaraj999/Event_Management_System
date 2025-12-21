<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\TicketConfirmation;
use App\Models\Booking;
use App\Models\BookingTicket;
use App\Models\EventTicket;
use App\Services\KhaltiService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    /**
     * Show booking form for selected ticket
     */
    public function create(EventTicket $eventTicket)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book tickets.');
        }

      $bookedQuantity = BookingTicket::where('event_ticket_id', $eventTicket->id)
    ->join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id') // use actual table name
    ->whereIn('bookings.payment_status', ['pending', 'paid'])
    ->sum('booking_ticket.quantity'); // use actual table name

        $remaining = $eventTicket->total_seats - ($eventTicket->sold_seats + $bookedQuantity);

        $now = now();
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
     * Create booking and initiate Khalti payment
     */
   public function store(Request $request, KhaltiService $khalti)
{
    $request->validate([
        'event_ticket_id' => 'required|exists:event_tickets,id',
        'quantity'        => 'required|integer|min:1|max:20', // ← UNCOMMENT & KEEP THIS
        'full_name'       => 'required|string|max:255',
        'email'           => 'required|email|max:255',
        'phone'           => 'required|string|max:20',
        'payment_method'  => 'required|in:khalti',
    ]);

    $eventTicket = EventTicket::findOrFail($request->event_ticket_id);
    $quantity    = (int) $request->quantity; // ← This is needed!

    // Check available seats
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
        // 1. Create main booking (NO quantity here — correct!)
        $booking = Booking::create([
            'user_id'         => Auth::id(),
            'event_id'        => $eventTicket->event_id,
            'full_name'       => $request->full_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'total_amount'    => $totalAmount,
            'payment_method'  => $request->payment_method,
            'payment_status'  => 'pending',
            'status'          => 'pending',
        ]);

        // 2. Save quantity in the pivot table — THIS IS CRITICAL
        BookingTicket::create([
            'booking_id'       => $booking->id,
            'event_ticket_id'  => $eventTicket->id,
            'quantity'         => $quantity,                    // ← UNCOMMENT THIS
            'price_at_booking' => $eventTicket->price,
            'sub_total'        => $totalAmount,
        ]);

        // 3. Initiate Khalti payment
        $payload = [
            'return_url'         => route('booking.success'),
            'website_url'        => config('services.khalti.website_url'),
            'amount'             => (int) ($totalAmount * 100),
            'purchase_order_id'  => 'booking-' . $booking->id,
            'purchase_order_name' => $eventTicket->name . ' - ' . $eventTicket->event->title,
            'customer_info'      => [
                'name'  => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        $response = $khalti->initiatePayment($payload);

        if (isset($response['payment_url']) && isset($response['pidx'])) {
            $booking->transaction_id = $response['pidx'];
            $booking->save();

            return redirect()->away($response['payment_url']);
        }

        throw new \Exception('Khalti payment initiation failed: ' . json_encode($response));
    });
}

    /**
     * Khalti payment success callback
     */
    public function success(Request $request, KhaltiService $khalti)
    {
        $pidx = $request->query('pidx');

        if (!$pidx) {
            return view('frontend.event.cancel', ['error' => 'Invalid payment callback.']);
        }

        $booking = Booking::where('transaction_id', $pidx)
            ->where('payment_status', 'pending')
            ->first();

        if (!$booking) {
            return view('frontend.event.cancel', ['error' => 'Booking not found or already processed.']);
        }

        $lookup = $khalti->lookupPayment($pidx);

        $booking->payment_response = $lookup;
        $booking->save();

        Log::info('Khalti Payment Lookup', ['pidx' => $pidx, 'response' => $lookup]);

        if (isset($lookup['status']) && $lookup['status'] === 'Completed') {
            DB::transaction(function () use ($booking, $lookup) {
                $booking->payment_status = 'paid';
                $booking->status = 'confirmed';
                $booking->ticket_token = Str::random(40);

                if (isset($lookup['transaction_id'])) {
                    $booking->transaction_id = $lookup['transaction_id'];
                }
                $booking->save();

                $booking->load(['bookingTickets.eventTicket.event', 'event']);

                // Update sold seats
                $bookingTicket = BookingTicket::where('booking_id', $booking->id)->first();
                if ($bookingTicket) {
                    EventTicket::where('id', $bookingTicket->event_ticket_id)
                        ->increment('sold_seats', $bookingTicket->quantity);
                }

                // Generate QR & PDF
                $verificationUrl = route('verify.ticket', $booking->ticket_token);
                $qrCodePng = (string) QrCode::format('png')->size(300)->errorCorrection('H')->generate($verificationUrl);

                $pdf = Pdf::loadView('emails.ticket-pdf', [
                    'booking'   => $booking,
                    'qrCodePng' => $qrCodePng,
                ]);

                // Send email with PDF + QR PNG attached
                Mail::to($booking->email)->send(new TicketConfirmation(
                    $booking,
                    $qrCodePng,
                    $pdf->output()
                ));
            });

            return view('frontend.event.success', compact('booking'))
                ->with('message', 'Payment successful! Your ticket has been sent to your email.');
        }

        // Payment failed
        $booking->update([
            'payment_status' => 'failed',
            'status'         => 'cancelled',
        ]);

        $errorMsg = $lookup['message'] ?? 'Payment could not be verified.';
        return view('frontend.event.cancel', ['error' => $errorMsg]);
    }

    /**
     * Khalti payment cancelled
     */
    public function cancel(Request $request)
    {
        $pidx = $request->query('pidx');

        if ($pidx) {
            $booking = Booking::where('transaction_id', $pidx)->first();
            if ($booking && $booking->payment_status === 'pending') {
                $booking->update([
                    'payment_status' => 'failed',
                    'status'         => 'cancelled',
                ]);
            }
        }

        return view('frontend.event.cancel', ['error' => 'Payment was cancelled.']);
    }

    /**
     * Public ticket verification (from QR scan)
     */
    public function verifyTicket($token)
    {
        $booking = Booking::where('ticket_token', $token)->first();

        if (!$booking) {
            return view('frontend.event.ticket-invalid', ['error' => 'Invalid ticket QR code.']);
        }

        if ($booking->payment_status !== 'paid' || $booking->status !== 'confirmed') {
            return view('frontend.event.ticket-invalid', ['error' => 'This ticket is not paid or confirmed.']);
        }

        if ($booking->is_checked_in) {
            return view('frontend.event.ticket-already-used', ['message' => 'This ticket has already been checked in.']);
        }

        return view('frontend.event.ticket-valid', compact('booking'));
    }

    /**
     * Admin manual search for check-in
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $booking = Booking::where('ticket_token', $query)
            ->orWhere('full_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->with('event')
            ->first();

        if ($booking) {
            return response()->json([
                'success' => true,
                'booking' => [
                    'id'             => $booking->id,
                    'full_name'      => $booking->full_name,
                    'email'          => $booking->email,
                    'phone'          => $booking->phone ?? 'Not provided',
                    'ticket_token'   => $booking->ticket_token,
                    'quantity'       => $booking->quantity,
                    'event_title'    => $booking->event->title,
                    'booking_date'   => $booking->created_at->format('M d, Y'),
                    'payment_status' => ucfirst($booking->payment_status),
                    'is_checked_in'  => (bool) $booking->is_checked_in,
                    'checked_in_at'  => $booking->checked_in_at?->format('M d, Y h:i A'),
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }



public function history()
{
    $bookings = Auth::user()->bookings()
        ->with(['event', 'bookingTickets.eventTicket'])
        ->latest()
        ->paginate(10);

    return view('profile.history', compact('bookings'));
}


public function invoice($ticket_token)
{
    $booking = Auth::user()->bookings()
        ->with(['event', 'bookingTickets.eventTicket'])
        ->where('ticket_token', $ticket_token)
        ->firstOrFail();

    return view('profile.invoice', compact('booking'));
}
}
