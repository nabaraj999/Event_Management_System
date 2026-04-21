<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\OrganizerApplication;
use App\Services\EventRecommendationService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected EventRecommendationService $recommendationService;

    public function __construct(EventRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index()
    {
        $categories = EventCategory::where('is_active', true)
                           ->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->get();

        $organizers = OrganizerApplication::active()
            ->whereNotNull('profile_image')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $user = Auth::user();
        $showInterestModal = $user && $user->interests()->count() === 0;

        if (!$user) {
            // Guest → Featured events
            $events = Event::visibleToUsers()
                ->upcoming()
                ->where('is_featured', true)
                ->orderBy('start_date')
                ->limit(6)
                ->get();
        } else {
            $events = $this->recommendationService->getHomeRecommendations($user);
        }

        return view('dashboard', compact('events', 'organizers', 'categories', 'showInterestModal'));
    }
}
