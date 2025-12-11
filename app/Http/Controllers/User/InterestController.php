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

        // Always delete previous interests first
        UserInterest::where('user_id', $user->id)->delete();

        $hasSelections = false;

        // Handle selected categories
        if (!empty($validated['category_ids'])) {
            foreach ($validated['category_ids'] as $categoryId) {
                $category = EventCategory::find($categoryId);
                if ($category) {
                    UserInterest::create([
                        'user_id' => $user->id,
                        'interest' => $category->name,
                        'category_id' => $category->id,
                        'has_completed_or_skipped_interests' => true,
                    ]);
                    $hasSelections = true;
                }
            }
        }

        // Handle custom interests
        if (!empty($validated['custom_interests'])) {
            $customInterests = array_filter(array_map('trim', explode(',', $validated['custom_interests'])));
            foreach ($customInterests as $interest) {
                UserInterest::create([
                    'user_id' => $user->id,
                    'interest' => $interest,
                    'category_id' => null,
                    'has_completed_or_skipped_interests' => true,
                ]);
                $hasSelections = true;
            }
        }

        // If user skipped (no selections), create a marker row
        if (!$hasSelections) {
            UserInterest::create([
                'user_id' => $user->id,
                'interest' => 'skipped',
                'category_id' => null,
                'has_completed_or_skipped_interests' => true,
            ]);
        }

        return redirect()->route('home')->with('success', 'Preferences saved! You won\'t see this again.');
    }
}
