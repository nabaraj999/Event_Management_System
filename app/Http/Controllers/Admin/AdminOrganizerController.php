<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerApplication; // Adjust if your model name is different
use Illuminate\Http\Request;

class AdminOrganizerController extends Controller
{
    // List all organizers with search & filter
    public function index(Request $request)
    {
        $query = OrganizerApplication::query();

        // Search by name, email, organization
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_frozen', $request->status == 'active' ? 1 : 0);
        }

        $organizers = $query->latest()->paginate(15);

        return view('admin.organizers.index', compact('organizers'));
    }

    // Show detailed view of one organizer
    public function show($id)
    {
        $organizer = OrganizerApplication::findOrFail($id);
        return view('admin.organizers.show', compact('organizer'));
    }

    // Toggle active/inactive status (is_frozen)
    public function toggleStatus(Request $request, $id)
    {
        $organizer = OrganizerApplication::findOrFail($id);

        // Toggle the is_frozen value
        $organizer->is_frozen = !$organizer->is_frozen;
        $organizer->save();

        $status = $organizer->is_frozen ? 'Active' : 'Inactive';

        return back()->with('success', "Organizer status changed to <strong>{$status}</strong> successfully.");
    }
}
