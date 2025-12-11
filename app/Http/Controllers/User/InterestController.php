<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:event_categories,id',
            'custom_interests' => 'nullable|string',
        ]);

        // Handle selected categories
        if (!empty($validated['category_ids'])) {
            foreach ($validated['category_ids'] as $categoryId) {
                $category = EventCategory::find($categoryId);
                if ($category) {
                    UserInterest::create([
                        'user_id' => $user->id,
                        'interest' => $category->name,
                        'category_id' => $category->id,
                    ]);
                }
            }
        }

        // Handle custom interests
        if (!empty($validated['custom_interests'])) {
            $customInterests = array_map('trim', explode(',', $validated['custom_interests']));
            foreach ($customInterests as $interest) {
                if (!empty($interest)) {
                    UserInterest::create([
                        'user_id' => $user->id,
                        'interest' => $interest,
                        'category_id' => null,
                    ]);
                }
            }
        }

        return redirect()->route('home')->with('success', 'Interests saved successfully!');
    }
}
