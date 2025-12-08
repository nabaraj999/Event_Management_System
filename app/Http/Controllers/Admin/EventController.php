<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:events,slug',
            'category_id'       => 'required|exists:event_categories,id',
            'short_description' => 'required|string|max:500',
            'content'           => 'required|string',
            'location'          => 'required|string|max:255',
            'venue'             => 'nullable|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'banner_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail'         => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'            => 'required|in:draft,published,cancelled,completed',
        ]);

        $banner = $request->file('banner_image')->store('events/banners', 'public');
        $thumb  = $request->file('thumbnail')->store('events/thumbnails', 'public');

        Event::create([
            'title'             => $request->title,
            'slug'              => $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->title),
            'category_id'       => $request->category_id,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'location'          => $request->location,
            'venue'             => $request->venue,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'banner_image'      => $banner,
            'thumbnail'         => $thumb,
            'status'            => $request->status,
            'is_featured'       => $request->has('is_featured'),
            'created_by'        => Auth::guard('admin')->id(),
            'updated_by'        => Auth::guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('swal_success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::where('is_active', true)->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:events,slug,' . $event->id,
            'category_id'       => 'required|exists:event_categories,id',
            'short_description' => 'required|string|max:500',
            'content'           => 'required|string',
            'location'          => 'required|string|max:255',
            'venue'             => 'nullable|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'            => 'required|in:draft,published,cancelled,completed',
        ]);

        if ($request->hasFile('banner_image')) {
            Storage::disk('public')->delete($event->banner_image);
            $event->banner_image = $request->file('banner_image')->store('events/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($event->thumbnail);
            $event->thumbnail = $request->file('thumbnail')->store('events/thumbnails', 'public');
        }

        $event->update($request->only([
            'title', 'slug', 'category_id', 'short_description', 'content',
            'location', 'venue', 'start_date', 'end_date', 'status', 'is_featured'
        ]));

        $event->updated_by = Auth::guard('admin')->id();
        $event->save();

        return redirect()
            ->route('admin.events.index')
            ->with('swal_success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        Storage::disk('public')->delete([$event->banner_image, $event->thumbnail]);
        $event->delete();

        return back()->with('swal_success', 'Event deleted permanently!');
    }
}
