<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingTicket;
use App\Models\Event;
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

        // Check if organizer has created any events
        $hasEvents = Event::where('organizer_id', $organizerId)->exists();

        // Total Paid Revenue
        $totalRevenue = Booking::join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.payment_status', 'paid')
            ->sum('bookings.total_amount');

        // Total Bookings (all statuses)
        $totalBookings = Booking::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->count();

        // Total Tickets Sold
        $totalTicketsSold = BookingTicket::join('bookings', 'booking_ticket.booking_id', '=', 'bookings.id')
            ->join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->sum('booking_ticket.quantity');

        // Average Ticket Price
        $avgTicketPrice = $totalTicketsSold > 0
            ? round($totalRevenue / $totalTicketsSold, 2)
            : 0;

        // Top 5 Performing Categories by Revenue
        $topCategories = Event::where('organizer_id', $organizerId)
            ->withCount(['bookings as paid_bookings_count' => fn($q) => $q->where('payment_status', 'paid')])
            ->withSum(['bookings as revenue' => fn($q) => $q->where('payment_status', 'paid')], 'total_amount')
            ->with(['category' => fn($q) => $q->select('id', 'name')])
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Top User Interests (from people who booked your events)
        $topInterests = UserInterest::join('bookings', 'user_interests.user_id', '=', 'bookings.user_id')
            ->join('events', 'bookings.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->select('user_interests.interest', DB::raw('COUNT(*) as count'))
            ->groupBy('user_interests.interest')
            ->orderByDesc('count')
            ->limit(6)
            ->pluck('interest');

        return [
            'has_events'         => $hasEvents,
            'total_revenue'      => $totalRevenue,
            'total_bookings'     => $totalBookings,
            'total_tickets_sold' => $totalTicketsSold,
            'avg_ticket_price'   => $avgTicketPrice,
            'top_categories'     => $topCategories,
            'top_interests'      => $topInterests,
            'organizer_name'     => $this->organizer->contact_person,
        ];
    }
}
