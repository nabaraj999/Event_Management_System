<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventTicketController extends Controller
{
    // app/Http/Controllers/EventTicketController.php

    public function index(Request $request)
    {
        $search = $request->get('search');

      $tickets = EventTicket::with('event')
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)                        // ← 10 per page
            ->appends(['search' => $search]);     // ← Keeps search term in URL

        return view('admin.event_tickets.index', compact('tickets'));
    }

    public function create()
    {
        $events = Event::pluck('name', 'id');
        return view('admin.event_tickets.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
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

        EventTicket::create($request->all());

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function edit(EventTicket $eventTicket)
    {
        $events = Event::pluck('name', 'id');
        return view('admin.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'requiredandr|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after_or_equal:sale_start',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $eventTicket->update($request->all());

        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(EventTicket $eventTicket)
    {
        $eventTicket->delete();
        return redirect()->route('admin.event-tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
