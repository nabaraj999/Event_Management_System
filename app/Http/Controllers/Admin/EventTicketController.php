<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use App\Models\Event;
use Illuminate\Http\Request;

class EventTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $tickets = EventTicket::with('event')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%") // Fixed: was searching 'title'
                    ->orWhere('id', $search)
                    ->orWhereHas('event', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Better than appends()

        return view('admin.event_tickets.index', compact('tickets', 'search'));
    }

    public function create()
    {
        $events = Event::where('status', 'published')->pluck('title', 'id');
        return view('admin.event_tickets.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after_or_equal:sale_start',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle checkbox (not sent if unchecked)
        $validated['is_active'] = $request->has('is_active');

        EventTicket::create($validated);

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function edit(EventTicket $eventTicket)
    {
        $events = Event::where('status', 'published')->pluck('title', 'id');
        return view('admin.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255', // ← FIXED: was 'requiredandr'
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after_or_equal:sale_start',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle checkbox properly
        $validated['is_active'] = $request->has('is_active');

        // Optional: Prevent reducing total_seats below sold_seats
        if ($request->total_seats < $eventTicket->sold_seats) {
            return back()->withErrors(['total_seats' => 'Total seats cannot be less than already sold seats (' . $eventTicket->sold_seats . ').']);
        }

        $eventTicket->update($validated);

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(EventTicket $eventTicket)
    {
        // Optional: Prevent delete if tickets already sold
        if ($eventTicket->sold_seats > 0) {
            return back()->with('error', 'Cannot delete ticket with sold seats.');
        }

        $eventTicket->delete();

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
