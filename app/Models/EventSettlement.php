<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSettlement extends Model
{
    protected $fillable = [
        'event_id', 'revenue_invoice_id', 'gross_revenue', 'commission',
        'net_payable', 'settlement_invoice_id', 'settlement_proof',
        'settled_at', 'settled_by', 'notes'
    ];
    protected $casts = [
        'settled_at' => 'datetime',
    ];

    protected $dates = ['settled_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function settledBy()
    {
        return $this->belongsTo(Admin::class, 'settled_by'); // assuming you have Admin model
    }

    public function getSettlementProofUrlAttribute()
    {
        return $this->settlement_proof ? asset('storage/' . $this->settlement_proof) : null;
    }

   
}
