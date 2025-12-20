<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrgEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('organizer_id', Auth::guard('organizer')->id());

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
        }

        $events = $query->with('category')->latest()->paginate(12);

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        // Only active categories belonging to organizer OR global (organizer_id null)
        $categories = EventCategory::visibleToOrganizer()
                                   ->where('is_active', true)
                                   ->orderBy('sort_order')
                                   ->get();

        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:event_categories,id',
            'location'          => 'required|string|max:255',
            'venue'             => 'nullable|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'short_description' => 'nullable|string',
            'content'           => 'nullable|string',
            'banner_image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'thumbnail'         => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status'            => 'required|in:draft,published,cancelled,completed',
            'is_featured'       => 'boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string',
        ]);

        $validated['organizer_id'] = Auth::guard('organizer')->id();
        $validated['is_featured'] = $request->has('is_featured');

        // Upload images
        $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        $validated['thumbnail'] = $request->file('thumbnail')->store('events/thumbnails', 'public');

        Event::create($validated);

        return redirect()->route('org.events.index')
                         ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        if ($event->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $categories = EventCategory::visibleToOrganizer()
                                   ->where('is_active', true)
                                   ->orderBy('sort_order')
                                   ->get();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:event_categories,id',
            'location'          => 'required|string|max:255',
            'venue'             => 'nullable|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'short_description' => 'nullable|string',
            'content'           => 'nullable|string',
            'banner_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status'            => 'required|in:draft,published,cancelled,completed',
            'is_featured'       => 'boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        // Handle image updates
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) Storage::disk('public')->delete($event->banner_image);
            $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) Storage::disk('public')->delete($event->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('events/thumbnails', 'public');
        }

        $event->update($validated);

        return redirect()->route('org.events.index')
                         ->with('admin
admin
admin
admin
adminsuccess', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        if ($event->banner_image) Storage::disk('public')->delete($event->banner_image);
        if ($event->thumbnail) Storage::disk('public')->delete($event->thumbnail);

        $event->delete();

        return back()->with('success', 'Event deleted successfully!');
    }
}
