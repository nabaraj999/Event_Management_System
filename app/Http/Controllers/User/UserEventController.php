<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
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
            $query->orderBy('start_date', 'asc'); // Soonest first
        } elseif ($sort === 'oldest') {
            $query->orderBy('start_date', 'desc');
        } else {
            $query->orderBy('start_date', 'asc');
        }

        $events = $query->paginate(12)->withQueryString();

        $categories = EventCategory::where('is_active', true)
                                   ->orderBy('sort_order')
                                   ->orderBy('name')
                                   ->get();

        return view('frontend.event.index', compact('events', 'categories', 'sort'));
    }

    public function show(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404);
        }

        // Load active tickets + category
        $event->load([
            'tickets' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('sort_order')
                      ->orderBy('price');
            },
            'category',
            'organizer' // if you have organizer relation
        ]);

        // === RELATED / RECOMMENDED EVENTS ===
        $relatedEvents = collect();

        if (Auth::check()) {
            // Use your smart recommendation service
            $relatedEvents = $this->recommendationService->getRelatedRecommendations(Auth::user(), $event);
        }

        // Fallback: Same category events
        if ($relatedEvents->isEmpty() && $event->category_id) {
            $relatedEvents = Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->where('category_id', $event->category_id)
                ->where('id', '!=', $event->id)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        // Final fallback: Popular upcoming events
        if ($relatedEvents->isEmpty()) {
            $relatedEvents = Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->where('id', '!=', $event->id)
                ->orderByDesc('is_featured')
                ->orderBy('start_date')
                ->limit(6)
                ->get();
        }

        // Pass BOTH event and relatedEvents
        return view('frontend.event.show', compact('event', 'relatedEvents'));
    }
}
