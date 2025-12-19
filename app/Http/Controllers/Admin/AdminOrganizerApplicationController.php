<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrganizerApprovedMail;
use App\Mail\OrganizerRejectedMail;
use App\Models\OrganizerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Pest\Support\Str;

class AdminOrganizerApplicationController extends Controller
{
    public function index()
    {
        $applications = OrganizerApplication::latest('applied_at')->paginate(15);

        return view('admin.organizer-applications.index', compact('applications'));
    }

    public function show(OrganizerApplication $application)
    {
        return view('admin.organizer-applications.show', compact('application'));
    }

   public function approve(OrganizerApplication $application)
    {
        // Update application status
        $application->update(['status' => 'approved']);

        // Generate temporary password
        $temporaryPassword = Str::random(12);

        // Create Organizer account
        $organizer = OrganizerApplication::create([
            'name'              => $application->organization_name,
            'contact_person'    => $application->contact_person,
            'email'             => $application->email,
            'password'          => Hash::make($temporaryPassword),
            'phone'             => $application->phone,
            'company_type'      => $application->company_type,
            'website'           => $application->website,
            'address'           => $application->address,
            'description'       => $application->description,
            'profile_image'     => $application->profile_image,
            'registration_document' => $application->registration_document,
            // is_frozen defaults to false
        ]);

        // Send approval email with credentials
        Mail::to($application->email)->send(
            new OrganizerApprovedMail($organizer, $temporaryPassword)
        );

        return redirect()->route('admin.organizer-applications.index')
            ->with('success', "Application from {$application->organization_name} has been APPROVED and account created.");
    }

    public function reject(OrganizerApplication $application)
    {
        $application->update(['status' => 'rejected']);

        // Send rejection email
        Mail::to($application->email)->send(new OrganizerRejectedMail($application));

        return redirect()->route('admin.organizer-applications.index')
            ->with('success', "Application from {$application->organization_name} has been REJECTED.");
    }
}
