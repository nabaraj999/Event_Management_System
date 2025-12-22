<?php

namespace App\Services;

use App\Models\Event;

// App/Models/User.php or App/Services/RecommendationService.php

class RecommendationService
{
public function getRecommendedEvents($limit = 10)
{
    // Step 1: Get user's category preferences
    $categoryCounts = [];

    // Explicit interests (higher weight)
    $explicitInterests = $this->interests()->with('category')->get();
    foreach ($explicitInterests as $ui) {
        if ($ui->category) {
            $catId = $ui->category_id;
            $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 2; // weight x2
        }
        // Optional: if no category_id, fuzzy match string 'interest' later
    }

    // Implicit from bookings (only successful)
    $pastEvents = $this->bookings()
        ->where('payment_status', 'paid')
        ->where('status', 'confirmed')
        ->with('event.category')
        ->get()
        ->pluck('event');

    foreach ($pastEvents as $event) {
        if ($event->category) {
            $catId = $event->category_id;
            $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 1;
        }
    }

    // If no preferences, return featured/popular
    if (empty($categoryCounts)) {
        return Event::where('is_featured', true)
            ->orWhere('popularity_score', '>', 50) // or whatever you have
            ->latest()
            ->take($limit)
            ->get();
    }

    // Step 2: Get upcoming events and score them
    $events = Event::upcoming() // assume you have a scope for future events
        ->with('category')
        ->get();

    $scoredEvents = $events->map(function ($event) use ($categoryCounts) {
        $score = $categoryCounts[$event->category_id] ?? 0;

        // Optional boosts:
        // $score += $event->is_featured ? 5 : 0;
        // $score += $event->popularity_score ?? 0;

        $event->recommendation_score = $score;
        return $event;
    })->sortByDesc('recommendation_score')->take($limit);

    return $scoredEvents->values();
}
}
