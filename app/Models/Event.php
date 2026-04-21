<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Boot method – Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    // Make slug unique (auto-append number if duplicate)
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        $uniqueSlug = $slug;

        $counter = 1;
        while (static::whereSlug($uniqueSlug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $uniqueSlug = $slug . '-' . $counter++;
        }

        $this->attributes['slug'] = $uniqueSlug;
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(EventTicket::class)->orderBy('sort_order');
    }

    public function activeTickets()
    {
        return $this->ticketTypes()->where('is_active', true);
    }

    public function totalRemainingSeats(): int
    {
        $total = $this->ticketTypes()->sum('total_seats');
        $sold = $this->ticketTypes()->sum('sold_seats');
        return $total - $sold;
    }

    public function isSoldOut(): bool
    {
        return $this->totalRemainingSeats() <= 0;
    }
    public function tickets()
    {
        return $this->hasMany(EventTicket::class, 'event_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function organizer()
    {
        return $this->belongsTo(OrganizerApplication::class);
    }
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopeNotEnded($query)
    {
        return $query->where(function ($query) {
            $query->where('start_date', '>=', now())
                ->orWhere(function ($subQuery) {
                    $subQuery->where('start_date', '<=', now())
                        ->where(function ($endQuery) {
                            $endQuery->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        });
                });
        });
    }

    public function scopeVisibleToUsers(Builder $query): Builder
    {
        return $query->published()
            ->whereHas('organizer', fn (Builder $organizerQuery) => $organizerQuery->active());
    }

    /**
     * Optional: Combine both for convenience
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->visibleToUsers()->upcoming();
    }

    public function organizerApplication()
    {
        return $this->belongsTo(OrganizerApplication::class, 'organizer_id');
    }
    /**
     * Get the settlement record for this event
     */
    public function settlement()
    {
        return $this->hasOne(EventSettlement::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';           // ← change this line
    }

public function getEffectiveStatusAttribute(): string
{
    if ($this->status !== 'published') {
        return $this->status;
    }

    $now = now();

    if ($now < $this->start_date) {
        return 'upcoming';
    }

    if ($this->end_date && $now->gt($this->end_date)) {
        return 'completed';
    }

    return 'ongoing';
}
//     protected static function booted()
// {
//     static::retrieved(function (Event $event) {
//         $now = now();

//         if ($event->status === 'published') {
//             if ($now->lt($event->start_date)) {
//                 $event->effective_status = 'upcoming';   // ok to keep if it's just accessor
//             } elseif ($event->end_date && $now->gt($event->end_date)) {
//                 $event->effective_status = 'completed';
//             } else {
//                 $event->effective_status = 'ongoing';
//             }

//             // REMOVE THESE LINES ↓↓↓
//             // if ($event->status !== $event->effective_status) {
//             //     $event->status = $event->effective_status;
//             //     $event->saveQuietly();
//             // }
//         }
//     });
// }
}
