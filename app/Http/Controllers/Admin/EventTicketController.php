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
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('event', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.event_tickets.index', compact('tickets', 'search'));
    }

    public function create()
    {
        $events = Event::query()
            ->where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->pluck('title', 'id');

        return view('admin.event_tickets.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'     => 'required|exists:events,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'total_seats'  => 'required|integer|min:1',
            'sale_start'   => 'nullable|date',
            'sale_end'     => 'nullable|date|after_or_equal:sale_start',
            'is_active'    => 'sometimes|boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Load event to validate against its dates
        $event = Event::findOrFail($validated['event_id']);

        // Prevent sale starting after event begins
        if (!empty($validated['sale_start']) && $validated['sale_start'] > $event->start_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_start' => "Sale start cannot be after the event begins ({$event->start_date->format('d M Y')})."
                ]);
        }

        // Prevent sale ending after event ends
        if ($event->end_date && !empty($validated['sale_end']) && $validated['sale_end'] > $event->end_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_end' => "Sale end cannot be after the event finishes ({$event->end_date->format('d M Y')})."
                ]);
        }

        // Set smart defaults if dates are empty
        if (empty($validated['sale_start'])) {
            $validated['sale_start'] = now(); // or ->subDays(14) for more conservative
        }

        if (empty($validated['sale_end'])) {
            $validated['sale_end'] = $event->start_date->copy()->subDay()->endOfDay();
        }

        EventTicket::create($validated);

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function edit(EventTicket $eventTicket)
    {
        $events = Event::query()
            ->where(function ($query) use ($eventTicket) {
                $query->where('id', $eventTicket->event_id)
                      ->orWhere(function ($q) {
                          $q->where('status', 'published')
                            ->where('start_date', '>', now());
                      });
            })
            ->orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$eventTicket->event_id])
            ->orderBy('start_date', 'asc')
            ->pluck('title', 'id');

        return view('admin.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        $validated = $request->validate([
            'event_id'     => 'required|exists:events,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'total_seats'  => 'required|integer|min:1',
            'sale_start'   => 'nullable|date',
            'sale_end'     => 'nullable|date|after_or_equal:sale_start',
            'is_active'    => 'sometimes|boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Prevent reducing total seats below sold amount
        if ($validated['total_seats'] < $eventTicket->getCommittedSeatsCount()) {
            return back()->withErrors([
                'total_seats' => "Total seats cannot be less than committed seats ({$eventTicket->getCommittedSeatsCount()})."
            ]);
        }

        // Load the (possibly new) event
        $event = Event::findOrFail($validated['event_id']);

        // Same date validation as in store()
        if (!empty($validated['sale_start']) && $validated['sale_start'] > $event->start_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_start' => "Sale start cannot be after the event begins ({$event->start_date->format('d M Y')})."
                ]);
        }

        if ($event->end_date && !empty($validated['sale_end']) && $validated['sale_end'] > $event->end_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_end' => "Sale end cannot be after the event finishes ({$event->end_date->format('d M Y')})."
                ]);
        }

        // Update defaults if cleared
        if (empty($validated['sale_start'])) {
            $validated['sale_start'] = now();
        }

        if (empty($validated['sale_end'])) {
            $validated['sale_end'] = $event->start_date->copy()->subDay()->endOfDay();
        }

        $eventTicket->update($validated);

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(EventTicket $eventTicket)
    {
        if ($eventTicket->getCommittedSeatsCount() > 0) {
            return back()->with('error', 'Cannot delete ticket with committed seats.');
        }

        $eventTicket->delete();

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
