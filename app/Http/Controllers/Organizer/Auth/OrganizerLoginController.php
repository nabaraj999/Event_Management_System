<?php

namespace App\Http\Controllers\Organizer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrganizerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('organizer.auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('organizer')->attempt($credentials, $request->filled('remember'))) {
        $organizer = Auth::guard('organizer')->user();

        if ($organizer->status !== 'approved') {
            Auth::guard('organizer')->logout();
            return back()->withErrors(['email' => 'Your application is not approved yet.']);
        }

        if ($organizer->is_frozen) {
            Auth::guard('organizer')->logout();
            return back()->withErrors(['email' => 'Your account is frozen. Please complete your profile.']);
        }

        return redirect()->intended(route('org.dashboard'));
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
}

    public function logout(Request $request)
    {
        Auth::guard('organizer')->logout();
        return redirect()->route('org.login');
    }
}
