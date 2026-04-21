<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Collection;

class EventRecommendationService
{
    /**
     * Get recommended events for home page
     * Respects the global user_algorithm toggle from settings table
     */
    public function getHomeRecommendations(User $user): Collection
    {
        // Check global toggle first
        if (! Setting::isUserAlgorithmEnabled()) {
            return $this->getSimpleLatestEvents(3);
        }

        // Algorithm is enabled → proceed with original logic
        $hasInterests = $user->interests()->exists();
        $hasBookings = $user->bookings()
            ->where('payment_status', 'paid')
            ->where('status', 'confirmed')
            ->exists();

        // Case: Has confirmed bookings → Full personalized
        if ($hasBookings) {
            return $this->getPersonalizedRecommendations($user);
        }

        // Case: Has interests but no bookings
        if ($hasInterests) {
            return $this->getInterestBasedRecommendations($user);
        }

        // Case: No interests, no bookings → Latest new events
        return $this->getLatestNewEvents();
    }

    /**
     * For event show page: same logic, but exclude current event
     */
    public function getRelatedRecommendations(User $user, Event $currentEvent): Collection
    {
        $recommendations = $this->getHomeRecommendations($user)
            ->where('id', '!=', $currentEvent->id);

        return $recommendations
            ->take(6)           // keep 6 max even when algorithm off (but usually will be ≤3)
            ->values();
    }

    // ──────────────────────────────────────────────
    //   When algorithm is OFF → always 3 latest
    // ──────────────────────────────────────────────
    private function getSimpleLatestEvents(int $limit = 3): Collection
    {
        return Event::published()
            ->visibleToUsers()
            ->upcoming()
            ->orderByDesc('created_at')     // most recently created first
            ->limit($limit)
            ->get();
    }

    // ──────────────────────────────────────────────
    //   Your original methods (unchanged)
    // ──────────────────────────────────────────────

    private function getPersonalizedRecommendations(User $user): Collection
    {
        $categoryCounts = [];

        // Explicit interests (weight 2)
        foreach ($user->interests as $interest) {
            if ($interest->category_id) {
                $catId = $interest->category_id;
                $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 2;
            }
        }

        // Past bookings (weight 1)
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

        $events = Event::visibleToUsers()->upcoming()->with('category')->get();

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
            ->visibleToUsers()
            ->upcoming()
            ->whereIn('category_id', $categoryIds)
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

    private function getLatestNewEvents(): Collection
    {
        return Event::published()
            ->visibleToUsers()
            ->upcoming()
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();
    }

    private function getFallbackEvents(): Collection
    {
        return Event::published()
            ->visibleToUsers()
            ->upcoming()
            ->orderByDesc('is_featured')
            ->orderBy('start_date')
            ->limit(6)
            ->get();
    }
}
