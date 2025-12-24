<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\BookingTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerSettlementController extends Controller
{
    public function index()
    {
        $organizer = Auth::guard('organizer')->user();

        $events = Event::with(['settlement'])
                       ->where('organizer_id', $organizer->id)
                       ->orderByDesc('created_at')
                       ->get();

        return view('organizer.settlements.index', compact('events'));
    }

    public function show(Event $event)
    {
        $organizer = Auth::guard('organizer')->user();

        if ($event->organizer_id !== $organizer->id) {
            abort(403, 'Unauthorized');
        }

        $event->load(['settlement', 'tickets']);

        // Calculate ticket sales
        $ticketSales = [];
        $totalGross = 0;

        foreach ($event->tickets as $ticket) {
            $sold = BookingTicket::whereHas('booking', fn($q) => $q->where('event_id', $event->id)
                                                                  ->where('payment_status', 'paid'))
                                 ->where('event_ticket_id', $ticket->id)
                                 ->sum('quantity');

            $subtotal = $sold * $ticket->price;
            $totalGross += $subtotal;

            $ticketSales[] = [
                'name'     => $ticket->name ?? 'General Ticket',
                'price'    => $ticket->price,
                'sold'     => $sold,
                'subtotal' => $subtotal,
            ];
        }

        $commission = $totalGross * 0.16;
        $netIncome = $totalGross - $commission;

        return view('organizer.settlements.show', compact(
            'event',
            'ticketSales',
            'totalGross',
            'commission',
            'netIncome'
        ));
    }
}
