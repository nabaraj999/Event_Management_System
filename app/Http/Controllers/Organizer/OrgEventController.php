<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrgEventController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = Auth::guard('organizer')->id();

        $query = Event::where('organizer_id', $organizerId)
                      ->with('category')
                      ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(10)->withQueryString();

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $organizerId = Auth::guard('organizer')->id();

        $request->validate([
            'title'             => [
                'required',
                'string',
                'max:255',
                Rule::unique('events', 'title')->where('organizer_id', $organizerId)
            ],
            'slug'              => 'nullable|string|max:255|unique:events,slug',
            'category_id'       => 'required|exists:event_categories,id',
            'short_description' => 'required|string|max:500',
            'content'           => 'required|string|min:20',
            'location'          => 'nullable|string|max:255|required_without:venue',
            'venue'             => 'nullable|string|max:255|required_without:location',
            'start_date'        => 'required|date|after_or_equal:now',
            'end_date'          => 'nullable|date|after:start_date',
            'banner_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail'         => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'            => 'required|in:draft,published,cancelled',
            'is_featured'       => 'boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',
        ]);

        $banner = $request->file('banner_image')->store('events/banners', 'public');
        $thumb  = $request->file('thumbnail')->store('events/thumbnails', 'public');

        $event = Event::create([
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
            'is_featured'       => $request->boolean('is_featured', false),
            'organizer_id'      => $organizerId,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Event created successfully!',
                'redirect' => route('org.events.index')
            ], 201);
        }

        return redirect()
            ->route('org.events.index')
            ->with('swal_success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);

        $categories = EventCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $request->validate([
            'title'             => [
                'required',
                'string',
                'max:255',
                Rule::unique('events', 'title')
                    ->where('organizer_id', $event->organizer_id)
                    ->ignore($event->id),
            ],
            'slug'              => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('events', 'slug')->ignore($event->id),
            ],
            'category_id'       => 'required|exists:event_categories,id',
            'short_description' => 'required|string|max:500',
            'content'           => 'required|string|min:20',
            'location'          => 'nullable|string|max:255|required_without:venue',
            'venue'             => 'nullable|string|max:255|required_without:location',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after:start_date',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status'            => 'required|in:draft,published,cancelled',
            'is_featured'       => 'boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $event->banner_image = $request->file('banner_image')->store('events/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) {
                Storage::disk('public')->delete($event->thumbnail);
            }
            $event->thumbnail = $request->file('thumbnail')->store('events/thumbnails', 'public');
        }

        $event->update($request->only([
            'title', 'slug', 'category_id', 'short_description', 'content',
            'location', 'venue', 'start_date', 'end_date', 'status', 'is_featured'
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Event updated successfully!',
                'redirect' => route('org.events.index')
            ]);
        }

        return redirect()
            ->route('org.events.index')
            ->with('swal_success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);

        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }
        if ($event->thumbnail) {
            Storage::disk('public')->delete($event->thumbnail);
        }

        $event->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Event deleted successfully']);
        }

        return back()->with('swal_success', 'Event deleted permanently!');
    }

    /**
     * Ensure the event belongs to the current organizer
     */
    private function authorizeEvent(Event $event)
    {
        if ($event->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403, 'You do not have permission to access this event.');
        }
    }
}
