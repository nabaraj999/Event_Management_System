<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'event_id',
        'full_name',
        'email',
        'phone',
        'address',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'transaction_id',
        'payment_response',
        'slug',               // ← add this
    ];

    // Optional: Cast fields
    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_response' => 'array', // since we store JSON
        'checked_in_at' => 'datetime',
    ];


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(BookingTicket::class);
    }

    // Helper: Get formatted status badge
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeAttribute()
    {
        return match ($this->payment_status) {
            'pending' => 'bg-orange-100 text-orange-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }


public function bookingTickets()
{
    return $this->hasMany(BookingTicket::class);
}
public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            // Option 1: Use transaction_id directly as slug (clean & simple)
            if (empty($booking->slug) && !empty($booking->transaction_id)) {
                $booking->slug = $booking->transaction_id;  // e.g. "khalti-abc123xyz"
            }

            // Option 2: Make it more readable / prefixed (recommended)
            // if (empty($booking->slug) && !empty($booking->transaction_id)) {
            //     $prefix = strtoupper(substr($booking->payment_method ?? 'pay', 0, 3)); // KHA, ESE, etc.
            //     $booking->slug = $prefix . '-' . $booking->transaction_id;
            //     // or: 'BK-' . Str::upper(Str::random(4)) . '-' . $booking->transaction_id;
            // }

            // Fallback if no transaction_id yet (rare, but safe)
            if (empty($booking->slug)) {
                $booking->slug = 'bk-' . Str::upper(Str::random(10));
            }
        });

        // Optional: If transaction_id can change (very rare), sync slug
        static::updating(function ($booking) {
            if ($booking->isDirty('transaction_id') && !empty($booking->transaction_id)) {
                $booking->slug = $booking->transaction_id; // or prefixed version
            }
        });
    }
}
