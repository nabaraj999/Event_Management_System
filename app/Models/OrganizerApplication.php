<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrganizerApplication extends Authenticatable
{
    use Notifiable;

    protected $guard = 'organizer';

    protected $fillable = [
        'organization_name',
        'contact_person',
        'email',
        'phone',
        'password',                  // Needed for approval update
        'address',
        'website',
        'company_type',
        'description',
        'status',
        'applied_at',
        'profile_image',
        'registration_document',
        'is_frozen',                 // ← Added: for freezing logic
        'profile_completed_at',      // ← Added: to track completion
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'address' => 'array',
        'profile_completed_at' => 'datetime',
        'is_frozen' => 'boolean',
        'email_verified_at' => 'datetime', // optional, if you add verification later
    ];

    // REMOVED the setPasswordAttribute mutator completely!
    // We hash manually in controller → safer and cleaner

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
        // If your foreign key is different (e.g., user_id), change it:
        // return $this->hasMany(Event::class, 'user_id');
    }
    // In app/Models/Organizer.php
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'organizer_id');
        //                                      ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        // Wrong foreign key!
    }

    public function getFormattedAddressAttribute(): string
{
    $addr = $this->address ?? [];
    $parts = array_filter([
        $addr['street'] ?? $addr['address_line_1'] ?? $addr['address'] ?? null,
        $addr['city'] ?? null,
        $addr['state'] ?? $addr['province'] ?? null,
        $addr['zip'] ?? $addr['postal_code'] ?? null,
        $addr['country'] ?? null,
    ]);
    return $parts ? implode(', ', $parts) : 'Location not specified';
}
}
