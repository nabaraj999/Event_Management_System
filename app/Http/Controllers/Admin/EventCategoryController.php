<?php
// app/Http/Controllers/Admin/EventCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventCategoryController extends Controller
{
   public function index(Request $request)
{
    $search = $request->get('search');

    $categories = EventCategory::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(10); // Only 10 per page

    // Keep search term in pagination links
    $categories->appends(['search' => $search]);

    return view('admin.categories.index', compact('categories'));
}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:event_categories,name',
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:fontawesome,heroicon,custom',
            'icon_name'   => 'required|string|max:100',
            'custom_svg'  => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        EventCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
            'icon_type'   => $request->icon_type,
            'icon_name'   => $request->icon_name,
            'custom_svg'  => $request->icon_type === 'custom' ? $request->custom_svg : null,
            'is_active'   => $request->boolean('is_active', true),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(EventCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, EventCategory $category)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:event_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon_type'   => 'required|in:fontawesome,heroicon,custom',
            'icon_name'   => 'required|string|max:100',
            'custom_svg'  => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'icon_type'   => $request->icon_type,
            'icon_name'   => $request->icon_name,
            'custom_svg'  => $request->icon_type === 'custom' ? $request->custom_svg : null,
            'is_active'   => $request->boolean('is_active'),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(EventCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
