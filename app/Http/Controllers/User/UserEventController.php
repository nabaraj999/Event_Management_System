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
        $query = Event::query()
            ->with(['category', 'organizer']) // Eager load for performance
            ->where('status', 'published')
            ->where('start_date', '>=', now());

        // Keyword Search
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('short_description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('venue', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by categories
        if ($request->filled('categories') && is_array($request->input('categories'))) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        // Filter by organizers (fixed: use organizer_id from events table)
        if ($request->filled('organizers') && is_array($request->input('organizers'))) {
            $query->whereIn('organizer_id', $request->input('organizers'));
        }

        // Date range filtering
        if ($request->filled('start_date_from')) {
            $query->whereDate('start_date', '>=', $request->input('start_date_from'));
        }
        if ($request->filled('start_date_to')) {
            $query->whereDate('start_date', '<=', $request->input('start_date_to'));
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('start_date', 'asc'); // Soonest first
        } elseif ($sort === 'oldest') {
            $query->orderBy('start_date', 'desc'); // Latest first
        } else {
            $query->orderBy('start_date', 'asc'); // Default: soonest
        }

        $events = $query->paginate(12)->withQueryString();

        // Load active categories
        $categories = EventCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Load approved & active organizers who have upcoming events
        $organizers = OrganizerApplication::where('status', 'approved')
            ->where('is_frozen', false) // Note: I assume frozen = inactive, so use NOT frozen
            ->whereHas('events', function ($q) {
                $q->where('status', 'published')
                  ->where('start_date', '>=', now());
            })
            ->withCount(['events' => function ($q) {
                $q->where('status', 'published')->where('start_date', '>=', now());
            }])
            ->orderBy('organization_name')
            ->get();

        $sort = $sort; // Already defined, but pass explicitly

        return view('frontend.event.index', compact('events', 'categories', 'organizers', 'sort'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Abort if not published or in the past
        if ($event->status !== 'published' || $event->start_date < now()) {
            abort(404);
        }

        // Eager load necessary relations
        $event->load([
            'tickets' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('sort_order')
                      ->orderBy('price');
            },
            'category',
            'organizer'
        ]);

        // Increment view count (optional - if you have a views column)
        // $event->increment('views');

        // === RECOMMENDED / RELATED EVENTS ===
        $relatedEvents = collect();

        if (Auth::check()) {
            $relatedEvents = $this->recommendationService->getRelatedRecommendations(Auth::user(), $event);
        }

        // Fallback 1: Same category, upcoming, exclude current
        if ($relatedEvents->isEmpty() && $event->category_id) {
            $relatedEvents = Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->where('category_id', $event->category_id)
                ->where('id', '!=', $event->id)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        // Fallback 2: Featured or popular upcoming events
        if ($relatedEvents->isEmpty()) {
            $relatedEvents = Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->where('id', '!=', $event->id)
                ->orderByDesc('is_featured')
                ->orderBy('start_date')
                ->limit(6)
                ->get();
        }

        return view('frontend.event.show', compact('event', 'relatedEvents'));
    }
}
