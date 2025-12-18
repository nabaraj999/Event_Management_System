<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of bookings with filters and search.
     */
    public function index(Request $request)
{
    $query = $request->query('query');

    $bookings = Booking::query()
        ->with('event')
        ->when($query, function ($q) use ($query) {
            return $q->where(function ($sq) use ($query) {
                $sq->where('id', 'like', "%{$query}%")
                   ->orWhere('full_name', 'like', "%{$query}%")
                   ->orWhere('email', 'like', "%{$query}%")
                   ->orWhere('phone', 'like', "%{$query}%")
                   ->orWhere('ticket_token', 'like', "%{$query}%");
            });
        })
        ->latest()
        ->paginate(15);

    return view('admin.bookings.index', compact('bookings'));
}
    /**
     * Display the specified booking details.
     */
   public function show(Booking $booking)
{
    $booking->load([
        'user',
        'event',
        'bookingTickets.eventTicket',
    ]);

    $totalTickets = $booking->bookingTickets->sum('quantity');

    return view('admin.bookings.show', compact('booking', 'totalTickets'));
}

    /**
 * Manually check-in a booking
 */
public function checkIn(Booking $booking)
{
    // Security: Only allow if payment is paid and not already checked in
    if ($booking->payment_status !== 'paid') {
        return redirect()->back()->with('error', 'Cannot check in: Payment is not completed.');
    }

    if ($booking->is_checked_in) {
        return redirect()->back()->with('info', 'Attendee is already checked in.');
    }

    // Perform check-in
    $booking->update([
        'is_checked_in' => true,
        'checked_in_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Attendee successfully checked in!');
}
}
