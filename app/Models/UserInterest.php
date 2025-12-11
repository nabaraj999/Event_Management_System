<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    use HasFactory;

    protected $table = 'user_interests';

    protected $fillable = [
        'user_id',
        'interest',
        'category_id',
        'has_completed_or_skipped_interests', // Add this
    ];

    protected $casts = [
        'has_completed_or_skipped_interests' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    // Scope to check if user has completed or skipped interests
    public function scopeHasCompletedOrSkipped($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->where('has_completed_or_skipped_interests', true)
                     ->exists();
    }
}
