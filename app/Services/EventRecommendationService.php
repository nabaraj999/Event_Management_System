<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Collection;

class EventRecommendationService
{
    /**
     * Get 6 recommended events based on exact user state
     */
    public function getHomeRecommendations(User $user): Collection
    {
        $hasInterests = $user->interests()->exists();
        $hasBookings = $user->bookings()
            ->where('payment_status', 'paid')
            ->where('status', 'confirmed')
            ->exists();

        // Case 4: Has bookings → Full personalized (interests + history)
        if ($hasBookings) {
            return $this->getPersonalizedRecommendations($user);
        }

        // Case 2: Has interests but no bookings → Only interest-based
        if ($hasInterests) {
            return $this->getInterestBasedRecommendations($user);
        }

        // Case 3: No interests, no bookings → Latest NEW events (recently created)
        return $this->getLatestNewEvents();
    }

    /**
     * For Event Show page: Same logic as home, but exclude current event
     */
    public function getRelatedRecommendations(User $user, Event $currentEvent): Collection
    {
        $recommendations = $this->getHomeRecommendations($user);

        return $recommendations
            ->where('id', '!=', $currentEvent->id)
            ->take(6)
            ->values();
    }

    // ——————————————————————— Private Methods ———————————————————————

    private function getPersonalizedRecommendations(User $user): Collection
    {
        $categoryCounts = [];

        // Explicit: Interests (weight 2)
        foreach ($user->interests as $interest) {
            if ($interest->category_id) {
                $catId = $interest->category_id;
                $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 2;
            }
        }

        // Implicit: Past bookings (weight 1)
        $pastEvents = $user->bookings()
            ->where('payment_status', 'paid')
            ->where('status', 'confirmed')
            ->with('event')
            ->get()
            ->pluck('event');

        foreach ($pastEvents as $event) {
            if ($event?->category_id) {
                $catId = $event->category_id;
                $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 1;
            }
        }

        if (empty($categoryCounts)) {
            return $this->getFallbackEvents();
        }

        $events = Event::published()->upcoming()->with('category')->get();

        return $events
            ->map(function ($event) use ($categoryCounts) {
                $score = $categoryCounts[$event->category_id] ?? 0;
                if ($event->is_featured) $score += 3;
                $event->score = $score;
                return $event;
            })
            ->sortByDesc('score')
            ->take(6)
            ->values();
    }

    private function getInterestBasedRecommendations(User $user): Collection
    {
        $categoryIds = $user->interests()
            ->whereNotNull('category_id')
            ->pluck('category_id')
            ->unique();

        if ($categoryIds->isEmpty()) {
            return $this->getFallbackEvents();
        }

        return Event::published()
            ->upcoming()
            ->whereIn('category_id', $categoryIds)
            ->inRandomOrder() // diversity
            ->limit(6)
            ->get();
    }

    private function getLatestNewEvents(): Collection
    {
        return Event::published()
            ->orderByDesc('created_at') // newest first (recently added)
            ->limit(6)
            ->get();
    }

    private function getFallbackEvents(): Collection
    {
        return Event::published()
            ->upcoming()
            ->orderByDesc('is_featured')
            ->orderBy('start_date')
            ->limit(6)
            ->get();
    }
}
