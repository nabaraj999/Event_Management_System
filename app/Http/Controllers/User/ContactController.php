<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page
     */
    public function index()
    {
        // Get active company information
        $company = CompanyInfo::where('is_active', true)->first();

        if (!$company) {
            abort(404, 'Company information not found.');
        }

        return view('frontend.contact-us.index', compact('company'));
    }

    /**
     * Store the contact form submission
     */
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Save to database
        ContactMessage::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'message'    => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Return back with success message
        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}
