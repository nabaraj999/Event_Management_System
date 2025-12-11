<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function getRemainingSeatsAttribute()
    {
        return $this->total_seats - $this->sold_seats;
    }

    public function isAvailable()
    {
        return $this->is_active && $this->remaining_seats > 0;
    }
}
