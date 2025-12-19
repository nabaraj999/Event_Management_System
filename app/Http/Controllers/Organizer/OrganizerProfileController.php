<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizerProfileController extends Controller
{
    public function edit()
    {
        $organizer = Auth::guard('organizer')->user();

        // If profile already completed → BLOCK access to edit form
        if (!is_null($organizer->profile_completed_at)) {
            return redirect()->route('org.dashboard')
                ->with('info', 'Your profile is already completed and locked. You cannot edit it anymore.');
        }

        // Only show edit form if not completed yet
        return view('organizer.profile.edit', compact('organizer'));
    }

    public function update(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        // Double-check: Block update if already completed
        if (!is_null($organizer->profile_completed_at)) {
            return redirect()->route('org.dashboard')
                ->with('error', 'Your profile is already completed and cannot be modified.');
        }

        $request->validate([
            'organization_name'     => 'required|string|max:255',
            'contact_person'        => 'required|string|max:255',
            'phone'                 => 'required|string|max:20',
            'address'               => 'required|string',
            'website'               => 'nullable|url',
            'company_type'          => 'required|string',
            'description'           => 'nullable|string',
            'profile_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'registration_document' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except(['profile_image', 'registration_document']);

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            if ($organizer->profile_image) {
                Storage::disk('public')->delete($organizer->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('organizers/profile', 'public');
        }

        // Handle Registration Document Upload
        if ($request->hasFile('registration_document')) {
            if ($organizer->registration_document) {
                Storage::disk('public')->delete($organizer->registration_document);
            }
            $data['registration_document'] = $request->file('registration_document')->store('organizers/documents', 'public');
        }

        $organizer->update($data);

        // Mark profile as completed and unfreeze
        $organizer->update([
            'profile_completed_at' => now(),
            'is_frozen' => false,
        ]);

        return redirect()->route('org.dashboard')
            ->with('success', 'Profile completed successfully! You can now create and manage events.');
    }
}
