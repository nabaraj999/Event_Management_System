<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EventTicket extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['remaining_seats'];

    public function event()
    {
        return $this->belongsTo(Event::class);
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
