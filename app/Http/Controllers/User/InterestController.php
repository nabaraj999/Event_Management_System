<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function index()
{
    $categories = EventCategory::all();  // Fetch predefined categories
    return view('interests.index', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'categories' => 'array|nullable',  // Optional array of category IDs
        'categories.*' => 'exists:event_categories,id',
        'custom_interests' => 'string|nullable|max:255',  // Comma-separated custom strings
    ]);

    $user = Auth::user();
    $user->userInterests()->delete();  // Clear existing for fresh start

    // Save selected categories (as foreign keys, with interest null)
    if ($request->has('categories')) {
        foreach ($request->categories as $categoryId) {
            UserInterest::create([
                'user_id' => $user->id,
                'category_id' => $categoryId,
                // 'interest' remains null for these
            ]);
        }
    }

    // Save custom interests (as strings, with category_id null)
    if ($request->has('custom_interests') && !empty($request->custom_interests)) {
        $customArray = array_map('trim', explode(',', $request->custom_interests));
        foreach ($customArray as $custom) {
            if (!empty($custom)) {
                UserInterest::create([
                    'user_id' => $user->id,
                    'interest' => $custom,
                    // 'category_id' remains null for these
                ]);
            }
        }
    }

    return redirect()->route('dashboard')->with('success', 'Interests updated!');
}
}
