<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class OrganizerProfileController extends Controller
{
    // Main profile page - always shows view with conditional buttons
    public function show()
    {
        $organizer = Auth::guard('organizer')->user();
        return view('organizer.profile.show', compact('organizer'));
    }

    // Full edit - only if NOT frozen (admin not approved yet)
    public function edit()
    {
        $organizer = Auth::guard('organizer')->user();

        if ($organizer->is_frozen) {
            return redirect()->route('org.profile.show')
                ->with('error', 'Your profile has been approved and is now locked. You cannot make changes except email and password.');
        }

        return view('organizer.profile.edit', compact('organizer'));
    }

    // Update full profile - only if NOT frozen
    public function update(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        if ($organizer->is_frozen) {
            return redirect()->route('org.profile.show')
                ->with('error', 'Profile is locked after admin approval.');
        }

        $request->validate([
            'organization_name'     => 'required|string|max:255',
            'contact_person'        => 'required|string|max:255',
            'phone'                 => 'required|string|max:20',
            'address'               => 'required|string',
            'website'               => 'nullable|url',
            'company_type'          => 'required|in:private_limited,public_limited,ngo,non_profit,sole_proprietorship',
            'description'           => 'nullable|string',
            'profile_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'registration_document' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except(['profile_image', 'registration_document']);

        if ($request->hasFile('profile_image')) {
            if ($organizer->profile_image) {
                Storage::disk('public')->delete($organizer->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('organizers/profile', 'public');
        }

        if ($request->hasFile('registration_document')) {
            if ($organizer->registration_document) {
                Storage::disk('public')->delete($organizer->registration_document);
            }
            $data['registration_document'] = $request->file('registration_document')->store('organizers/documents', 'public');
        }

        $organizer->update($data);

        return redirect()->route('org.profile.show')
            ->with('success', 'Profile updated successfully. Awaiting admin approval.');
    }

    // New: Settings page for Email & Password (always allowed)
    public function settings()
    {
        $organizer = Auth::guard('organizer')->user();
        return view('organizer.profile.settings', compact('organizer'));
    }

    // Update Email & Password
    public function updateSettings(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        $request->validate([
            'email' => 'required|email|unique:organizer_applications,email,' . $organizer->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = ['email' => $request->email];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $organizer->update($data);

        return redirect()->route('org.profile.show')
            ->with('success', 'Email and/or password updated successfully.');
    }
}
