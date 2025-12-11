<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
{
    $events = Event::where('is_featured', true)
                   ->where('status', 'published')
                   ->where('start_date', '>=', now())
                   ->orderBy('start_date')
                   ->limit(3)
                   ->get();

    $categories = EventCategory::where('is_active', true)
                               ->orderBy('sort_order')
                               ->get();

    $showInterestModal = auth()->check() && auth()->user()->interests()->count() === 0;

    return view('dashboard', compact('events', 'categories', 'showInterestModal'));
}
}
