<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\OrganizerApplication;
use App\Services\EventRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    protected EventRecommendationService $recommendationService;

    public function __construct(EventRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Display a listing of upcoming published events with filters.
     */
   public function index(Request $request)
{
    // Base query: only published, upcoming events from ACTIVE organizers
    $query = Event::query()
        ->with(['category', 'organizer'])
        ->where('status', 'published')
        ->where('start_date', '>=', now())
        ->whereHas('organizer', function ($q) {
            $q->where('status', 'approved')
              ->where('is_frozen', true);  // Active only (your admin logic)
        });

    // Keyword search
    if ($request->filled('query')) {
        $searchTerm = $request->input('query');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('short_description', 'like', "%{$searchTerm}%")
              ->orWhere('location', 'like', "%{$searchTerm}%")
              ->orWhere('venue', 'like', "%{$searchTerm}%");
        });
    }

    // Category filter
    if ($request->has('categories') && is_array($request->input('categories'))) {
        $query->whereIn('category_id', $request->input('categories'));
    }

    // Organizer filter - now works perfectly because base events are already from active organizers
    if ($request->has('organizers') && is_array($request->input('organizers'))) {
        $query->whereIn('organizer_id', $request->input('organizers'));
    }

    // Date range
    if ($request->filled('start_date_from')) {
        $query->whereDate('start_date', '>=', $request->input('start_date_from'));
    }

    if ($request->filled('start_date_to')) {
        $query->whereDate('start_date', '<=', $request->input('start_date_to'));
    }

    // Sorting
    $sort = $request->input('sort', 'newest');
    $query->orderBy('start_date', $sort === 'oldest' ? 'desc' : 'asc');

    // Paginate
    $events = $query->paginate(12)->withQueryString();

    // Active categories
    $categories = EventCategory::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    // Active organizers only (with upcoming event count)
    $organizers = OrganizerApplication::where('status', 'approved')
        ->where('is_frozen', true)  // Active only
        ->withCount([
            'events as upcoming_events_count' => fn($q) =>
                $q->where('status', 'published')
                  ->where('start_date', '>=', now())
        ])
        ->orderBy('organization_name')
        ->get();

    return view('frontend.event.index', compact('events', 'categories', 'organizers', 'sort'));
}

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Only allow published and upcoming/present events
        if ($event->status !== 'published' || $event->start_date < now()) {
            abort(404);
        }

        // Load relations
        $event->load([
            'tickets' => fn($q) => $q->where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->orderBy('price'),
            'category',
            'organizer'
        ]);

        // Recommended / Related Events
        $relatedEvents = collect();

        if (Auth::check()) {
            $relatedEvents = $this->recommendationService->getRelatedRecommendations(Auth::user(), $event);
        }

        // Fallback: Same category
        if ($relatedEvents->isEmpty() && $event->category_id) {
            $relatedEvents = Event::published()
                ->upcoming()
                ->where('category_id', $event->category_id)
                ->where('id', '!=', $event->id)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        // Final fallback: Featured or recent upcoming
        if ($relatedEvents->isEmpty()) {
            $relatedEvents = Event::published()
                ->upcoming()
                ->where('id', '!=', $event->id)
                ->orderByDesc('is_featured')
                ->orderBy('start_date')
                ->limit(6)
                ->get();
        }

        return view('frontend.event.show', compact('event', 'relatedEvents'));
    }
}
