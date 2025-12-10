<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class UserEventCategoryController extends Controller
{
   public function index()
    {
        $categories = EventCategory::where('is_active', true)
                                  ->orderBy('sort_order')
                                  ->get();

        return view('dashboard', compact('categories'));
    }
}
