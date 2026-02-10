<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingTicket;
use App\Models\Event;
use App\Models\Setting;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventInsightsService
{
    protected $organizer;

    public function __construct()
    {
        $this->organizer = Auth::guard('organizer')->user();
    }

    public function getInsights()
    {
        $organizerId = $this->organizer->id;

        // ── Global toggle check ────────────────────────────────────────
        if (! Setting::isOrganizerAlgorithmEnabled()) {
            return $this->getBasicInsights($organizerId);
        }

        // ── Full smart insights when enabled ──────────────────────────

        $hasEvents = Event::where('organizer_id', $organizerId)->exists();

        $totalRevenue = Booking::join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.payment_status', 'paid')
            ->sum('bookings.total_amount');

        $totalBookings = Booking::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->count();

        $totalTicketsSold = BookingTicket::join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->sum('booking_ticket.quantity');

        $avgTicketPrice = $totalTicketsSold > 0
            ? round($totalRevenue / $totalTicketsSold, 2)
            : 0;

        // Top 5 categories (only if has paid bookings)
        $topCategories = collect();
        if ($totalRevenue > 0) {
            $topCategories = Event::where('organizer_id', $organizerId)
                ->withCount(['bookings as paid_bookings_count' => fn($q) => $q->where('payment_status', 'paid')])
                ->withSum(['bookings as revenue' => fn($q) => $q->where('payment_status', 'paid')], 'total_amount')
                ->with(['category' => fn($q) => $q->select('id', 'name')])
                ->orderByDesc('revenue')
                ->limit(5)
                ->get();
        }

        // Top interests from bookers (only compute if there are bookings)
        $topInterests = collect();
        if ($totalBookings > 0) {
            $topInterests = UserInterest::join('bookings', 'user_interests.user_id', '=', 'bookings.user_id')
                ->join('events', 'bookings.event_id', '=', 'events.id')
                ->where('events.organizer_id', $organizerId)
                ->select('user_interests.interest', DB::raw('COUNT(*) as count'))
                ->groupBy('user_interests.interest')
                ->orderByDesc('count')
                ->limit(6)
                ->pluck('interest');
        }

        return [
            'has_events'          => $hasEvents,
            'total_revenue'       => $totalRevenue,
            'total_bookings'      => $totalBookings,
            'total_tickets_sold'  => $totalTicketsSold,
            'avg_ticket_price'    => $avgTicketPrice,
            'top_categories'      => $topCategories,
            'top_interests'       => $topInterests,
            'organizer_name'      => $this->organizer->contact_person ?? 'Organizer',
            'algorithm_enabled'   => true,
        ];
    }

    /**
     * Fallback / simplified stats when organizer algorithm is disabled
     */
    private function getBasicInsights($organizerId)
    {
        $totalEvents = Event::where('organizer_id', $organizerId)->count();

        $totalRevenue = Booking::join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.payment_status', 'paid')
            ->sum('bookings.total_amount');

        $totalBookings = Booking::whereHas('event', fn($q) => $q->where('organizer_id', $organizerId))->count();

        $totalTicketsSold = BookingTicket::join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->sum('booking_ticket.quantity');

        return [
            'has_events'          => $totalEvents > 0,
            'total_events'        => $totalEvents,              // extra field for basic view
            'total_revenue'       => $totalRevenue,
            'total_bookings'      => $totalBookings,
            'total_tickets_sold'  => $totalTicketsSold,
            'avg_ticket_price'    => $totalTicketsSold > 0 ? round($totalRevenue / $totalTicketsSold, 2) : 0,
            'top_categories'      => collect(),                 // empty
            'top_interests'       => collect(),                 // empty
            'organizer_name'      => $this->organizer->contact_person ?? 'Organizer',
            'algorithm_enabled'   => false,
        ];
    }
}
