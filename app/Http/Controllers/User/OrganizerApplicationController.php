<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication;
use Illuminate\Http\Request;

class OrganizerApplicationController extends Controller
{
    public function create()
    {
        return view('frontend.organizer.apply'); // your form blade file
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'organization_name' => 'required|string|max:255',
        'contact_person'    => 'required|string|max:255',   // ← Add this
        'phone'             => 'required|string|max:20',
        'email'             => 'required|email|unique:organizer_applications,email',
        'address'           => 'required|string|max:1000',
        'website'           => 'nullable|url|max:255',
        'company_type'      => 'required|string',
        'description'       => 'nullable|string|max:2000',
    ]);

    OrganizerApplication::create([
        'organization_name' => $validated['organization_name'],
        'contact_person'    => $validated['contact_person'],     // ← Add this line
        'phone'             => $validated['phone'],
        'email'             => $validated['email'],
        'address'           => $validated['address'],
        'website'           => $validated['website'] ?? null,
        'company_type'      => $validated['company_type'],
        'description'       => $validated['description'] ?? null,
        'status'            => 'pending',
        'applied_at'        => now(),
    ]);

    return redirect()->back()->with('success', 'Application submitted successfully! We will review it and get back to you soon.');
}
}
