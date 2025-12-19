<?php

namespace App\Http\Controllers\Organizer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboardController extends Controller
{
  public function index()
    {
        $organizer = Auth::guard('organizer')->user();

        return view('organizer.dashboard', compact('organizer'));
    }
}
