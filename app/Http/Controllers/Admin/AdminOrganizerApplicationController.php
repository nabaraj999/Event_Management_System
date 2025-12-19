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
    $temporaryPassword = Str::random(12);

    $application->update([
        'status'   => 'approved',
        'password' => Hash::make($temporaryPassword), // Manual hash – safe
        // Optional: reset freeze if any
        'is_frozen' => false,
    ]);

    Mail::to($application->email)->send(
        new OrganizerApprovedMail($application, $temporaryPassword)
    );

    return redirect()->route('admin.organizer-applications.index')
        ->with('success', "Application from {$application->organization_name} approved successfully!");
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
