<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizerApplicationController extends Controller
{
    public function create()
    {
        return view('frontend.organizer.apply'); // your form blade file
    }

    public function store(Request $request)
{


$validated = $request->validate([
    'organization_name' => ['required', 'string','min:2','max:255','regex:/^[\pL\pN\s\-\.&\'()]+$/u',],
    'contact_person' => ['required','string','min:3','max:255','regex:/^[\pL\pN\s\-\.\' ]+$/u', ],
    'phone' => ['required','string','regex:/^\+[1-9]\d{1,14}$/', 'max:20',],
    'email' => ['required','email:rfc,dns',  'max:255',Rule::unique('organizer_applications', 'email'),  ],
    'address' => [ 'required','string','min:10','max:1000',],
    'website' => ['nullable','url:http,https','max:255', ],
    'company_type' => [ 'required','string','in:LLC,private_limited,public_limited,Sole Proprietorship,ngo,event_agency,Other', ],
    'description' => ['nullable','string','min:50', 'max:2000',
    ],
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
