<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use App\Models\Booking;
use App\Models\BookingTicket;
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
    public function store(Request $request)
    {
        $request->validate([
            'event_ticket_id' => 'required|exists:event_tickets,id',
            'quantity'        => 'required|integer|min:1|max:20',
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'payment_method'  => 'required|in:khalti,esewa',
        ]);

        $eventTicket = EventTicket::findOrFail($request->event_ticket_id);
        $quantity = (int) $request->quantity;

        // Recalculate remaining seats with current pending/paid bookings
        $bookedQuantity = BookingTicket::where('event_ticket_id', $eventTicket->id)
            ->join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->whereIn('bookings.payment_status', ['pending', 'paid'])
            ->sum('booking_ticket.quantity');

        $remaining = $eventTicket->total_seats - ($eventTicket->sold_seats + $bookedQuantity);

        if ($quantity > $remaining) {
            return back()->withInput()->with('error', "Only {$remaining} ticket(s) available. Please reduce quantity.");
        }

        // Check sale period again
        $now = Carbon::now();
        if (($eventTicket->sale_start && $now->lt($eventTicket->sale_start)) ||
            ($eventTicket->sale_end && $now->gt($eventTicket->sale_end))) {
            return back()->withInput()->with('error', 'Ticket sale period has ended or not started yet.');
        }

        $totalAmount = $quantity * $eventTicket->price;

        // Use transaction to ensure data consistency
        return DB::transaction(function () use ($request, $eventTicket, $quantity, $totalAmount) {
            $booking = Booking::create([
                'user_id'         => Auth::id(),
                'event_id'        => $eventTicket->event_id,
                'full_name'       => $request->full_name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'address'         => $request->address ?? null,
                'total_amount'    => $totalAmount,
                'payment_method'  => $request->payment_method,
                'payment_status'  => 'pending',
                'status'          => 'pending',
            ]);

            BookingTicket::create([
                'booking_id'        => $booking->id,
                'event_ticket_id'   => $eventTicket->id,
                'quantity'          => $quantity,
                'price_at_booking'  => $eventTicket->price,
                'sub_total'         => $totalAmount,
            ]);

            // Redirect to payment gateway
            if ($request->payment_method === 'khalti') {
                return redirect()->route('payment.khalti.initiate', $booking);
            }

            if ($request->payment_method === 'esewa') {
                return redirect()->route('payment.esewa.initiate', $booking);
            }

            // Fallback
            return redirect()->route('booking.success')->with('warning', 'Payment method not implemented yet.');
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
