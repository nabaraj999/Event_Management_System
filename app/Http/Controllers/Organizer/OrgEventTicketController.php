<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgEventTicketController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = Auth::guard('organizer')->id();

        $query = EventTicket::with('event')
            ->whereHas('event', fn($q) => $q->where('organizer_id', $organizerId));

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhereHas('event', fn($q) => $q->where('title', 'like', "%{$request->search}%"));
            });
        }

        $tickets = $query->orderBy('sort_order')->paginate(15);

        return view('organizer.event_tickets.index', compact('tickets'));
    }

    public function create()
    {
        $organizerId = Auth::guard('organizer')->id();

        // Only upcoming or ongoing events (not completed/cancelled/past)
        $events = Event::where('organizer_id', $organizerId)
            ->where('status', 'published') // or whatever statuses you allow
            ->where(function ($q) {
                $q->where('start_date', '>=', now())           // upcoming
                  ->orWhere(function ($sub) {
                      $sub->where('start_date', '<=', now())
                          ->where(function ($end) {
                              $end->whereNull('end_date')
                                  ->orWhere('end_date', '>=', now());
                          });
                  });
            })
            ->orderByDesc('start_date')
            ->pluck('title', 'id');

        return view('organizer.event_tickets.create', compact('events'));
    }

    public function store(Request $request)
    {
        $organizerId = Auth::guard('organizer')->id();

        $validated = $request->validate([
            'event_id'     => [
                'required',
                'exists:events,id',
                function ($attribute, $value, $fail) use ($organizerId) {
                    if (!Event::where('id', $value)
                              ->where('organizer_id', $organizerId)
                              ->exists()) {
                        $fail('You can only create tickets for your own events.');
                    }
                }
            ],
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'total_seats'  => 'required|integer|min:1',
            'sale_start'   => 'nullable|date',
            'sale_end'     => 'nullable|date|after_or_equal:sale_start',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sold_seats'] = 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Load event to validate dates
        $event = Event::findOrFail($validated['event_id']);

        // Prevent sale starting after event begins
        if (!empty($validated['sale_start']) && $validated['sale_start'] > $event->start_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_start' => "Sale cannot start after the event begins ({$event->start_date->format('d M Y')})."
                ]);
        }

        // Prevent sale ending after event ends
        if (!empty($validated['sale_end']) && $validated['sale_end'] > $event->end_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_end' => "Sale cannot end after the event finishes ({$event->end_date->format('d M Y')})."
                ]);
        }

        // Smart defaults if dates are blank
        if (empty($validated['sale_start'])) {
            $validated['sale_start'] = now(); // or $event->start_date->subDays(14)
        }

        if (empty($validated['sale_end'])) {
            $validated['sale_end'] = $event->start_date->subDay()->endOfDay();
        }

        EventTicket::create($validated);

        return redirect()->route('org.event-tickets.index')
                         ->with('success', 'Ticket created successfully!');
    }

    public function edit(EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403, 'You can only edit tickets for your own events.');
        }

        // Same filter as create: upcoming or ongoing events
        $events = Event::where('organizer_id', $organizerId)
            ->where(function ($q) {
                $q->where('start_date', '>=', now())
                  ->orWhere(function ($sub) {
                      $sub->where('start_date', '<=', now())
                          ->where(function ($end) {
                              $end->whereNull('end_date')
                                  ->orWhere('end_date', '>=', now());
                          });
                  });
            })
            ->orderByDesc('start_date')
            ->pluck('title', 'id');

        return view('organizer.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403, 'You can only update tickets for your own events.');
        }

        $validated = $request->validate([
            'event_id'     => [
                'required',
                'exists:events,id',
                function ($attribute, $value, $fail) use ($organizerId) {
                    if (!Event::where('id', $value)->where('organizer_id', $organizerId)->exists()) {
                        $fail('Invalid event selected.');
                    }
                }
            ],
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'total_seats'  => 'required|integer|min:' . $eventTicket->sold_seats,
            'sale_start'   => 'nullable|date',
            'sale_end'     => 'nullable|date|after_or_equal:sale_start',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Load the (possibly new) event
        $event = Event::findOrFail($validated['event_id']);

        // Same date validation as in store
        if (!empty($validated['sale_start']) && $validated['sale_start'] > $event->start_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_start' => "Sale cannot start after the event begins ({$event->start_date->format('d M Y')})."
                ]);
        }

        if (!empty($validated['sale_end']) && $validated['sale_end'] > $event->end_date) {
            return back()
                ->withInput()
                ->withErrors([
                    'sale_end' => "Sale cannot end after the event finishes ({$event->end_date->format('d M Y')})."
                ]);
        }

        // Defaults if cleared
        if (empty($validated['sale_start'])) {
            $validated['sale_start'] = now();
        }

        if (empty($validated['sale_end'])) {
            $validated['sale_end'] = $event->start_date->subDay()->endOfDay();
        }

        $eventTicket->update($validated);

        return redirect()->route('org.event-tickets.index')
                         ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403, 'You can only delete tickets for your own events.');
        }

        // Optional: prevent delete if tickets sold
        if ($eventTicket->sold_seats > 0) {
            return back()->with('error', 'Cannot delete ticket with sold seats.');
        }

        $eventTicket->delete();

        return back()->with('success', 'Ticket deleted successfully!');
    }
}
