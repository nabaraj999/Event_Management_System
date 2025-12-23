<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\BookingTicket;
use App\Models\CompanyInfo; // Your company settings model
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventReportController extends Controller
{
    public function index()
    {
        $events = Event::with('organizerApplication')
                       ->select('id', 'title', 'organizer_id')
                       ->orderBy('title')
                       ->get();

        return view('admin.reports.events.index', compact('events'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::with(['organizerApplication', 'tickets'])->findOrFail($request->event_id);

        // Safety: if organizer not found
        if (!$event->organizerApplication) {
            return back()->with('error', 'Organizer not found for this event.');
        }

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

        // 16% flat commission
        $commissionRate = 0.16;
        $commission = $totalGross * $commissionRate;
        $netIncome = $totalGross - $commission;

        // Generate unique invoice number
        $invoice_no = 'INV-' . rand(100000, 999999);

        // Fetch company info (logo, address, etc.)
        $company = CompanyInfo::first(); // Assumes one record

        $data = [
            'event'          => $event,
            'organizer'      => $event->organizerApplication,
            'ticketSales'    => $ticketSales,
            'totalGross'     => $totalGross,
            'commission'     => $commission,
            'netIncome'      => $netIncome,
            'generated_at'   => now()->format('d F Y'),
            'invoice_no'     => $invoice_no,
            'company'        => $company, // ← Now fully passed!
        ];

        $pdf = Pdf::loadView('admin.reports.events.pdf', $data)
                  ->setPaper('a4', 'portrait')
                  ->setOptions([
                      'defaultFont'       => 'DejaVu Sans',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled'   => true, // Crucial for loading logo from storage
                  ]);

        $safeTitle = str_replace([' ', '/', '\\'], '_', $event->title);
        $fileName = "Invoice_{$invoice_no}_{$safeTitle}.pdf";

        return $pdf->download($fileName);
    }
}
