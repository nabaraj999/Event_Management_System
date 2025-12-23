<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\BookingTicket;
use App\Models\EventSettlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettlementController extends Controller
{
    /**
     * Show all events for settlement selection
     */
    public function index()
    {
        $events = Event::with(['organizerApplication', 'settlement'])
                       ->select('id', 'title', 'organizer_id')
                       ->orderByDesc('created_at')
                       ->get();

        return view('admin.settlements.index', compact('events'));
    }

    /**
     * Show settlement details (supports GET)
     */
    public function showSettlement(Request $request)
    {
        $eventId = $request->query('event_id') ?? $request->input('event_id');

        if (!$eventId) {
            return redirect()->route('admin.settlements.index')
                             ->with('error', 'Please select an event.');
        }

        $event = Event::with(['organizerApplication', 'tickets', 'settlement'])
                      ->findOrFail($eventId);

        if (!$event->organizerApplication) {
            return back()->with('error', 'Organizer information not found for this event.');
        }

        $organizer = $event->organizerApplication;

        // Calculate ticket sales
        $ticketSales = [];
        $totalGross = 0;

        foreach ($event->tickets as $ticket) {
            $sold = BookingTicket::whereHas('booking', function ($q) use ($event) {
                $q->where('event_id', $event->id)
                  ->where('payment_status', 'paid');
            })
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
        $netPayable = $totalGross - $commission;

        $settlement = $event->settlement;

        return view('admin.settlements.show', compact(
            'event',
            'organizer',
            'ticketSales',
            'totalGross',
            'commission',
            'netPayable',
            'settlement'
        ));
    }

    /**
     * Store settlement (upload proof)
     */
    public function storeSettlement(Request $request)
    {
        $request->validate([
            'event_id'              => 'required|exists:events,id',
            'settlement_invoice_id' => 'required|string|max:100',
            'settlement_proof'      => 'required|file|mimes:pdf|max:10240',
            'notes'                 => 'nullable|string',
        ]);

        $event = Event::findOrFail($request->event_id);

        $totalGross = 0;
        foreach ($event->tickets as $ticket) {
            $sold = BookingTicket::whereHas('booking', fn($q) => $q->where('event_id', $event->id)
                                                                  ->where('payment_status', 'paid'))
                                 ->where('event_ticket_id', $ticket->id)
                                 ->sum('quantity');
            $totalGross += $sold * $ticket->price;
        }

        $commission = $totalGross * 0.16;
        $netPayable = $totalGross - $commission;

        $path = $request->file('settlement_proof')->store('settlements/proofs', 'public');

        EventSettlement::updateOrCreate(
            ['event_id' => $event->id],
            [
                'revenue_invoice_id'    => $event->settlement?->revenue_invoice_id ?? 'INV-' . rand(100000, 999999),
                'gross_revenue'         => $totalGross,
                'commission'            => $commission,
                'net_payable'           => $netPayable,
                'settlement_invoice_id' => $request->settlement_invoice_id,
                'settlement_proof'      => $path,
                'settled_at'            => now(),
                'settled_by'            => Auth::guard('admin')->id(),
                'notes'                 => $request->notes,
            ]
        );

        return back()->with('success', 'Settlement completed successfully!');
    }
}
