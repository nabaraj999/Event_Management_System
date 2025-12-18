<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTicket extends Model
{
    use HasFactory;

   protected $table = 'booking_ticket'; // ← THIS IS THE ONLY LINE YOU NEED TO ADD/FIX

    protected $guarded = [];

    protected $casts = [
        'price_at_booking' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function eventTicket()
    {
        return $this->belongsTo(EventTicket::class, 'event_ticket_id');
    }
    public function bookingItems()
    {
        return $this->hasMany(BookingTicket::class, 'event_ticket_id');
    }

    // Helper to get current remaining seats
   public function getBookedQuantityAttribute()
    {
        return $this->bookingTickets()
            ->whereHas('booking', fn($q) => $q->whereIn('payment_status', ['pending', 'paid']))
            ->sum('quantity');
    }
    public function getRemainingSeatsAttribute()
    {
        return $this->total_seats - ($this->sold_seats + $this->getBookedQuantityAttribute());
    }
}
