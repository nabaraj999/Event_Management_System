<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EventTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'total_seats',
        'sale_start',
        'sale_end',
        'is_active',
        'sort_order',
    ];

    // THIS IS THE KEY FIX
    protected $casts = [
        'price'      => 'decimal:2',
        'total_seats' => 'integer',
        'sold_seats' => 'integer',
        'sale_start' => 'datetime',
        'sale_end'   => 'datetime',
        'is_active'  => 'boolean',
    ];

    protected $guarded = [];

    protected $appends = ['remaining_seats'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function bookingTickets(): HasMany
    {
        return $this->hasMany(BookingTicket::class, 'event_ticket_id');
    }

    public function getPendingReservedSeatsCount(): int
    {
        return (int) $this->bookingTickets()
            ->whereHas('booking', fn ($query) => $query->where('payment_status', 'pending'))
            ->sum('quantity');
    }

    public function getCommittedSeatsCount(): int
    {
        return $this->sold_seats + $this->getPendingReservedSeatsCount();
    }

    public function getRemainingSeatsAttribute(): int
    {
        return max(0, $this->total_seats - $this->getCommittedSeatsCount());
    }

    public function isOnSale(?\Illuminate\Support\Carbon $at = null): bool
    {
        $at ??= now();

        if (! $this->is_active) {
            return false;
        }

        if ($this->sale_start && $at->lt($this->sale_start)) {
            return false;
        }

        if ($this->sale_end && $at->gt($this->sale_end)) {
            return false;
        }

        return true;
    }

    public function isAvailable(?\Illuminate\Support\Carbon $at = null): bool
    {
        return $this->isOnSale($at) && $this->remaining_seats > 0;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function ($ticket) {
            if (empty($ticket->slug) && !empty($ticket->name)) {
                $base = Str::slug($ticket->name);
                $slug = $base;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $count++;
                }

                $ticket->slug = $slug;
            }
        });
        static::updating(function ($ticket) {
            if ($ticket->isDirty('name')) {
                $base = Str::slug($ticket->name);
                $slug = $base;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $ticket->id)->exists()) {
                    $slug = $base . '-' . $count++;
                }

                $ticket->slug = $slug;
            }
        });
    }
}
