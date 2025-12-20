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

        $events = Event::where('organizer_id', $organizerId)
                       ->where('status', '!=', 'completed')
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
                    if (!Event::where('id', $value)->where('organizer_id', $organizerId)->exists()) {
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

        EventTicket::create($validated);

        return redirect()->route('org.event-tickets.index')
                         ->with('success', 'Ticket created successfully!');
    }

    public function edit(EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403);
        }

        $events = Event::where('organizer_id', $organizerId)
                       ->orderByDesc('start_date')
                       ->pluck('title', 'id');

        return view('organizer.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403);
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
            'total_seats'  => 'required|integer|min:' . $eventTicket->sold_seats, // can't reduce below sold
            'sale_start'   => 'nullable|date',
            'sale_end'     => 'nullable|date|after_or_equal:sale_start',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $eventTicket->update($validated);

        return redirect()->route('org.event-tickets.index')
                         ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(EventTicket $eventTicket)
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($eventTicket->event->organizer_id !== $organizerId) {
            abort(403);
        }

        $eventTicket->delete();

        return back()->with('success', 'Ticket deleted successfully!');
    }
}
