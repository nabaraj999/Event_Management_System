<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class TicketScannerController extends Controller
{
    public function index()
    {
        return view('admin.bookings.ticket-scanner');
    }

    public function verify(Request $request)
{
    $token = $request->input('token');

    if (!$token) {
        return response()->json([
            'success' => false,
            'message' => 'No token provided.'
        ], 400);
    }

    $booking = Booking::where('ticket_token', $token)
        ->with(['event', 'bookingTickets.eventTicket'])
        ->first();

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid ticket. QR code not recognized.'
        ]);
    }

    if ($booking->payment_status !== 'paid' || $booking->status !== 'confirmed') {
        return response()->json([
            'success' => false,
            'message' => 'Ticket not paid or not confirmed.'
        ]);
    }

    if ($booking->is_checked_in) {
        return response()->json([
            'success' => false,
            'message' => 'This ticket has already been used.',
            'already_used' => true,
            'booking' => [
                'full_name' => $booking->full_name,
                'event' => $booking->event->title ?? 'N/A',
                'checked_in_at' => $booking->checked_in_at?->format('d M Y, h:i A'),
            ]
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Ticket valid!',
        'booking' => [
            'full_name' => $booking->full_name,
            'email' => $booking->email,
            'event' => $booking->event->title ?? 'N/A',
            'quantity' => $booking->bookingTickets->sum('quantity'),
        ]
    ]);
}

public function search(Request $request)
{
    $validated = $request->validate([
        'query' => 'required|string|max:255',
    ]);

    $query = trim($validated['query']);

    $booking = Booking::with(['event', 'bookingTickets'])
        ->where('ticket_token', $query)
        ->orWhere('full_name', 'like', "%{$query}%")
        ->orWhere('email', 'like', "%{$query}%")
        ->orWhere('phone', 'like', "%{$query}%")
        ->first();

    if (!$booking) {
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success' => true,
        'booking' => [
            'id'             => $booking->id,
            'full_name'      => $booking->full_name,
            'email'          => $booking->email,
            'phone'          => $booking->phone ?? 'Not provided',
            'ticket_token'   => $booking->ticket_token,
            'quantity'       => $booking->bookingTickets->sum('quantity'),
            'event_title'    => $booking->event->title ?? 'N/A',
            'booking_date'   => $booking->created_at->format('M d, Y'),
            'payment_status' => ucfirst($booking->payment_status),
            'is_checked_in'  => (bool) $booking->is_checked_in,
            'checked_in_at'  => $booking->checked_in_at?->format('M d, Y h:i A'),
        ],
    ]);
}

public function checkIn(Request $request)
{
    $request->validate(['token' => 'required']);

    $booking = Booking::where('ticket_token', $request->token)
        ->where('payment_status', 'paid')
        ->where('status', 'confirmed')
        ->where('is_checked_in', false)
        ->first();

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid, unpaid, or already checked-in ticket.'
        ], 400);
    }

    $booking->update([
        'is_checked_in' => true,
        'checked_in_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Checked in successfully!'
    ]);
}
}
