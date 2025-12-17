<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class MainEventCategoryController extends Controller
{
    /**
     * Display a listing of active event categories (for homepage/section)
     */
    public function index()
{
    $eventCategories = EventCategory::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    return view('frontend.event-categories.index', compact('eventCategories'));
    // Replace 'your-view-name' with the actual blade file name, e.g., 'welcome', 'home', 'pages.home'
}

public function show($slug)
{
    $category = EventCategory::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

    // REMOVE or FIX the 'is_published' line
    $events = $category->events()
        // ->where('is_published', true)   ← DELETE THIS LINE
        ->latest()
        ->paginate(12);

    $relatedCategories = EventCategory::where('is_active', true)
        ->where('id', '!=', $category->id)
        ->orderBy('sort_order')
        ->limit(6)
        ->get();

    return view('frontend.event-categories.show', compact('category', 'events', 'relatedCategories'));
}
    /**
     * Display events belonging to a specific category (by slug)
     */

}
