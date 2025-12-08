<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}
