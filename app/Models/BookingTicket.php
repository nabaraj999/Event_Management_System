<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTicket extends Model
{
    use HasFactory;

    protected $table = 'booking_ticket';

    protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
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
}
