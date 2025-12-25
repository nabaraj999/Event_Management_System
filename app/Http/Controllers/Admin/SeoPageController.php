<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class SeoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = SeoPage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('page_key', 'LIKE', "%{$search}%")
                  ->orWhere('meta_title', 'LIKE', "%{$search}%")
                  ->orWhere('meta_keywords', 'LIKE', "%{$search}%");
            });
        }

        $seoPages = $query->orderBy('page_key')->paginate(15);

        return view('admin.seo.index', compact('seoPages'));
    }

    public function create()
    {
        return view('admin.seo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_key'         => 'required|string|max:100|unique:seo_pages,page_key,NULL,id,locale,en',
            'meta_title'       => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords'    => 'nullable|string|max:1000',
            'og_title'         => 'nullable|string|max:255',
            'og_description'   => 'nullable|string|max:1000',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'canonical_url'    => 'nullable|url:http,https',
            'robots'           => ['required', Rule::in(['index,follow', 'noindex,follow', 'index,nofollow', 'noindex,nofollow'])],
            'is_active'        => 'sometimes|boolean',
        ]);

        $data = $request->only([
            'page_key', 'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'canonical_url', 'robots'
        ]);

        $data['locale']    = 'en'; // Fixed for now, ready for multi-lang later
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo-og', 'public');
        }

        SeoPage::create($data);

        return redirect()->route('admin.seo.index')
                         ->with('swal_success', "SEO page '{$request->page_key}' created successfully!");
    }

    public function edit(SeoPage $seoPage)
    {
        return view('admin.seo.edit', compact('seoPage'));
    }

    public function update(Request $request, SeoPage $seoPage)
    {
        $request->validate([
            'meta_title'       => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords'    => 'nullable|string|max:1000',
            'og_title'         => 'nullable|string|max:255',
            'og_description'   => 'nullable|string|max:1000',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'canonical_url'    => 'nullable|url:http,https',
            'robots'           => ['required', Rule::in(['index,follow', 'noindex,follow', 'index,nofollow', 'noindex,nofollow'])],
            'is_active'        => 'sometimes|boolean',
        ]);

        $data = $request->only([
            'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'canonical_url', 'robots'
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('og_image')) {
            // Delete old image if exists
            if ($seoPage->og_image) {
                Storage::disk('public')->delete($seoPage->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('seo-og', 'public');
        }

        $seoPage->update($data);

        return redirect()->route('admin.seo.index')
                         ->with('swal_success', "SEO settings for '{$seoPage->page_key}' updated successfully!");
    }

    // Optional: Add destroy method
    public function destroy(SeoPage $seoPage)
    {
        if ($seoPage->og_image) {
            Storage::disk('public')->delete($seoPage->og_image);
        }

        $seoPage->delete();

        return back()->with('swal_success', "SEO page '{$seoPage->page_key}' deleted successfully!");
    }
}
