<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
