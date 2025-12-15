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
    $query = Booking::with(['user', 'event', 'bookingTickets.eventTicket'])
                    ->withCount('bookingTickets')
                    ->select('bookings.*');

    // Filter by Booking ID
    if ($request->filled('booking_id')) {
        $query->where('id', $request->booking_id);
    }

    // Search by User (full_name or email)
    if ($request->filled('user')) {
        $search = $request->user;
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Filter by Payment Status
    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    // Filter by Booking Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Sorting
    $sort = $request->get('sort', 'latest');
    switch ($sort) {
        case 'oldest':
            $query->oldest();
            break;
        case 'amount_desc':
            $query->orderByDesc('total_amount');
            break;
        case 'amount_asc':
            $query->orderBy('total_amount');
            break;
        case 'latest':
        default:
            $query->latest();
            break;
    }

    // Changed from 20 to 10
    $bookings = $query->paginate(10)->withQueryString();

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

        // Calculate total quantity
        $totalTickets = $booking->bookingTickets->sum('quantity');

        return view('admin.bookings.show', compact('booking', 'totalTickets'));
    }
}
