<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use App\Models\Booking;
use App\Models\BookingTicket;
use App\Services\KhaltiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the booking form for a specific ticket
     */
    public function create(EventTicket $eventTicket)
    {
        // Redirect if not logged in (middleware already handles, but extra safety)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book tickets.');
        }

        // Calculate remaining seats (considering pending bookings too to prevent overbooking)
        $bookedQuantity = BookingTicket::where('event_ticket_id', $eventTicket->id)
            ->join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->whereIn('bookings.payment_status', ['pending', 'paid'])
            ->sum('booking_ticket.quantity');

        $remaining = $eventTicket->total_seats - ($eventTicket->sold_seats + $bookedQuantity);

        // Check if ticket is currently on sale
        $now = Carbon::now();
        $isOnSale = true;

        if ($eventTicket->sale_start && $now->lt($eventTicket->sale_start)) {
            $isOnSale = false;
        }
        if ($eventTicket->sale_end && $now->gt($eventTicket->sale_end)) {
            $isOnSale = false;
        }

        // Block booking if not available
        if ($remaining <= 0 || !$isOnSale) {
            $message = $remaining <= 0
                ? 'This ticket is sold out.'
                : 'This ticket is not currently available for sale.';

            return redirect()->back()->with('error', $message);
        }

        // Load event for display
        $eventTicket->load('event');

       return view('frontend.event.create', compact('eventTicket', 'remaining'));
    }

    /**
     * Store the booking and prepare for payment
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

        // Recheck remaining seats
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
            // Create booking
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

            // Create booking ticket entry
            BookingTicket::create([
                'booking_id' => $booking->id,
                'event_ticket_id' => $eventTicket->id,
                'quantity' => $quantity,
                'price_at_booking' => $eventTicket->price,
                'sub_total' => $totalAmount,
            ]);

            // Initiate Khalti payment
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
     * Payment success page
     */
    public function success(Request $request)
    {
        // You can add logic later to verify payment here
        return view('frontend.event.success');
    }

    /**
     * Payment cancelled page
     */
    public function cancel(Request $request)
    {
        return view('frontend.event.cancel');
    }
}
