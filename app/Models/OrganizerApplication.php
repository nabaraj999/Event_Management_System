<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrganizerApplication extends Authenticatable
{
    use Notifiable;

    protected $guard = 'organizer'; // Important for login

    protected $fillable = [
    'organization_name',
    'contact_person',
    'email',
    'phone',
    'address',
    'website',
    'company_type',
    'description',
    'status',
    'applied_at',
    'profile_image',
    'registration_document',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'applied_at' => 'datetime',  // ← This fixes the error
    ];

    // Hash password automatically
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
