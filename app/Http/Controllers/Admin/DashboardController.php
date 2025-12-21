<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User; // Assuming users are attendees
use App\Models\OrganizerApplication; // Your organizer model
use App\Models\BookingTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalEvents = Event::count();
        $pendingEvents = Event::where('status', 'draft')->count(); // Adjust if pending is separate
        $totalOrganizers = OrganizerApplication::where('status', 'approved')->count();
        $totalUsers = User::count();

        // Revenue (assume stored in USD or base, convert to NPR)
        $exchangeRate = 144.50; // Approximate USD to NPR as of Dec 2025
        $totalRevenueUSD = BookingTicket::sum('sub_total');
        $totalRevenueNPR = $totalRevenueUSD * $exchangeRate;

        // Placeholder growth (replace with real calculations)
        $eventsGrowth = 18;
        $organizersGrowth = 12;
        $usersGrowth = 9.2;
        $revenueGrowth = 23;

        // Recent Events (with organizer relation - add belongsTo in Event model if needed)
        $recentEvents = Event::with('organizer')->latest()->take(5)->get();

        // Monthly Revenue Chart Data (last 12 months)
        $monthlyRevenue = BookingTicket::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(sub_total) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $monthlyRevenueLabels[] = Carbon::now()->subMonths($i)->format('M Y');
            $monthlyRevenueData[] = ($monthlyRevenue[$month] ?? 0) * $exchangeRate;
        }

        // Events by Status
        $eventsByStatus = [
            Event::where('status', 'published')->count(),
            Event::where('status', 'draft')->count(),
            Event::where('status', 'cancelled')->count(),
            Event::where('status', 'completed')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalEvents',
            'pendingEvents',
            'totalOrganizers',
            'totalUsers',
            'totalRevenueNPR',
            'eventsGrowth',
            'organizersGrowth',
            'usersGrowth',
            'revenueGrowth',
            'recentEvents',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'eventsByStatus'
        ));
    }
}
