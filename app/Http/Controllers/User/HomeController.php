<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; // If not already imported
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::where('is_featured', true)
                       ->where('status', 'published')
                       ->where('start_date', '>=', now())
                       ->orderBy('start_date')
                       ->limit(3) // Matches your hardcoded example
                       ->get();

        $categories = EventCategory::where('is_active', true)
                                   ->orderBy('sort_order')
                                   ->get();

        return view('dashboard', compact('events', 'categories'));
    }
}
