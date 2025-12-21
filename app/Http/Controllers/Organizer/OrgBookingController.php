<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgBookingController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = Auth::guard('organizer')->id();

        $query = Booking::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->with(['event', 'bookingTickets.eventTicket']);

        if ($request->filled('query')) {
            $search = $request->query;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('ticket_token', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('organizer.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($booking->event->organizer_id !== $organizerId) {
            abort(403, 'Unauthorized');
        }

        return view('organizer.bookings.show', compact('booking'));
    }

    // Optional: Manual check-in by organizer
    public function checkIn(Booking $booking)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($booking->event->organizer_id !== $organizerId) {
            abort(403);
        }

        if ($booking->is_checked_in) {
            return back()->with('info', 'Already checked in.');
        }

        if ($booking->payment_status !== 'paid') {
            return back()->with('error', 'Cannot check in unpaid booking.');
        }

        $booking->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Attendee checked in successfully!');
    }
}
