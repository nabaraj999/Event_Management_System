<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'interests' => 'required|array|min:1',
            'interests.*' => 'string|max:255',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:event_categories,id',
        ]);

        foreach ($validated['interests'] as $key => $interest) {
            $categoryId = $validated['category_ids'][$key] ?? null;

            UserInterest::create([
                'user_id' => $user->id,
                'interest' => $interest,
                'category_id' => $categoryId,
            ]);
        }

        return redirect()->route('home')->with('success', 'Interests saved successfully!');
    }
}
