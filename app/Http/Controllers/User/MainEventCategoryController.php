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
        // Or whatever your dashboard view path is, e.g., 'dashboard'
    }

    /**
     * Display events belonging to a specific category (by slug)
     */
    
}
