<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings() ?? new Setting(); // fallback if no row

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
{
    $request->validate([
        'user_algorithm'      => ['sometimes', 'boolean'],
        'organizer_algorithm' => ['sometimes', 'boolean'],
    ]);

    $data = $request->only(['user_algorithm', 'organizer_algorithm']);

    $updated = Setting::updateToggles($data);   // ← no second argument anymore

    if ($updated) {
        return redirect()
            ->back()
            ->with('success', 'Settings updated successfully.');
    }

    return redirect()
        ->back()
        ->with('error', 'Failed to update settings.');
}
}
