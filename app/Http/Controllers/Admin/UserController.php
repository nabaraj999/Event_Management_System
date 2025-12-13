<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(Request $request)
{
    $query = User::query()->with('interests');

    // Search by ID
    if ($request->filled('user_id')) {
        $query->where('id', $request->user_id);
    }

    // Search by Name
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Sorting
    $sort = $request->get('sort', 'latest'); // default: latest

    switch ($sort) {
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        case 'email_asc':
            $query->orderBy('email', 'asc');
            break;
        case 'email_desc':
            $query->orderBy('email', 'desc');
            break;
        case 'interests_desc':
            $query->withCount('interests')->orderBy('interests_count', 'desc');
            break;
        case 'interests_asc':
            $query->withCount('interests')->orderBy('interests_count', 'asc');
            break;
        case 'oldest':
            $query->oldest();
            break;
        default: // latest
            $query->latest();
            break;
    }

    $users = $query->paginate(15)->withQueryString(); // preserves search & sort params

    return view('admin.users.index', compact('users'));
}
    public function show(User $user)
    {
        // Load user with interests
        $user->load('interests');

        return view('admin.users.show', compact('user'));
    }
}
