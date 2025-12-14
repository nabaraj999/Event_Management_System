<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()
                      ->where('status', 'published')
                      ->where('start_date', '>=', now());

        // Keyword Search
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('short_description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
                  // Removed 'long_description' because it doesn't exist in your table
            });
        }

        // Filter by categories
        if ($request->has('categories') && is_array($request->input('categories'))) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        // Filter by date range
        if ($request->filled('start_date_from')) {
            $query->whereDate('start_date', '>=', $request->input('start_date_from'));
        }
        if ($request->filled('start_date_to')) {
            $query->whereDate('start_date', '<=', $request->input('start_date_to'));
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('start_date', 'asc');   // Soonest upcoming first (most common)
        } elseif ($sort === 'oldest') {
            $query->orderBy('start_date', 'desc');  // Furthest future first
        } else {
            $query->orderBy('start_date', 'asc');
        }

        // Paginate with query string preservation
        $events = $query->paginate(12)->withQueryString();

        // Categories
        $categories = EventCategory::where('is_active', true)
                                   ->orderBy('sort_order')
                                   ->get();

        return view('frontend.event.index', compact('events', 'categories', 'sort'));
    }

    public function show(Event $event)
{
    if ($event->status !== 'published') {
        abort(404);
    }

    // Load ALL active tickets (no date filter here)
    $event->load(['tickets' => function ($query) {
        $query->where('is_active', true)
              ->orderBy('sort_order')
              ->orderBy('price');
    }]);

    $event->load('category');

    return view('frontend.event.show', compact('event'));
}
}
