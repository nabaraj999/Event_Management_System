<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication;
use App\Models\Event;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * Display a listing of all verified organizers.
     */
    public function index()
    {
        $organizers = OrganizerApplication::active()
            ->whereNotNull('profile_image')
            ->latest('profile_completed_at')
            ->paginate(12);

        return view('dashboard', compact('organizers'));
    }

    /**
     * Display the specified organizer's profile and their upcoming events.
     */
   public function show(OrganizerApplication $organizer)
{
    // $organizer is now automatically the model found by slug

    $events = Event::visibleToUsers()
        ->upcoming()
        ->where('organizer_id', $organizer->id)
        ->orderBy('start_date', 'asc')
        ->limit(10)
        ->get();

    $pageTitle = $organizer->organization_name . ' - Organizer Profile';

    return view('frontend.organizer.show', compact('organizer', 'events', 'pageTitle'));
}
}
