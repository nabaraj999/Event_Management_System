<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication;
use Illuminate\Http\Request;

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
        $application->update(['status' => 'approved']);

        // Optional: Send email to organizer
        // Mail::to($application->email)->send(new OrganizerApprovedMail($application));

        return redirect()->route('admin.organizer-applications.index')
            ->with('success', "Application from {$application->organization_name} has been APPROVED.");
    }

    public function reject(OrganizerApplication $application)
    {
        $application->update(['status' => 'rejected']);

        // Optional: Send rejection email
        // Mail::to($application->email)->send(new OrganizerRejectedMail($application));

        return redirect()->route('admin.organizer-applications.index')
            ->with('success', "Application from {$application->organization_name} has been REJECTED.");
    }
}
