<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgEventCategoryController extends Controller
{
    /**
     * Display a listing of the organizer's categories.
     */
    public function index(Request $request)
    {
        $query = EventCategory::mine();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('sort_order', 'asc')->paginate(12);

        return view('organizer.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('organizer.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:fontawesome,heroicon,custom',
            'icon_name'   => 'required_if:icon_type,fontawesome,heroicon|nullable|string|max:255',
            'custom_svg'  => 'required_if:icon_type,custom|nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
        ]);

        EventCategory::create([
            'organizer_id' => Auth::guard('organizer')->id(),
            'name'         => $validated['name'],
            'description'  => $validated['description'],
            'icon_type'    => $validated['icon_type'],
            'icon_name'    => $validated['icon_type'] === 'custom' ? null : $validated['icon_name'],
            'custom_svg'   => $validated['icon_type'] === 'custom' ? $validated['custom_svg'] : null,
            'sort_order'   => $validated['sort_order'] ?? 0,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()
            ->route('org.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(EventCategory $category)
    {
        if ($category->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403, 'Unauthorized');
        }

        return view('organizer.categories.edit', compact('category'));
    }

    /**
     * Update the category.
     */
    public function update(Request $request, EventCategory $category)
    {
        if ($category->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:fontawesome,heroicon,custom',
            'icon_name'   => 'required_if:icon_type,fontawesome,heroicon|nullable|string|max:255',
            'custom_svg'  => 'required_if:icon_type,custom|nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
        ]);

        $category->update([
            'name'         => $validated['name'],
            'description'  => $validated['description'],
            'icon_type'    => $validated['icon_type'],
            'icon_name'    => $validated['icon_type'] === 'custom' ? null : $validated['icon_name'],
            'custom_svg'   => $validated['icon_type'] === 'custom' ? $validated['custom_svg'] : null,
            'sort_order'   => $validated['sort_order'] ?? 0,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()
            ->route('org.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete the category.
     */
    public function destroy(EventCategory $category)
    {
        if ($category->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403, 'Unauthorized');
        }

        // Optional: Prevent delete if used in events
        // if ($category->events()->exists()) {
        //     return back()->with('error', 'Cannot delete category used in events.');
        // }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}
