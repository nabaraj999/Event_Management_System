<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'user_algorithm',
        'organizer_algorithm',
        // Do NOT include 'updated_by' here
    ];

    protected $casts = [
        'user_algorithm'      => 'boolean',
        'organizer_algorithm' => 'boolean',
    ];

    public static function getSettings(): ?self
    {
        return self::first();
    }

    public static function isUserAlgorithmEnabled(): bool
    {
        $settings = self::getSettings();
        return $settings ? $settings->user_algorithm : true;
    }

    public static function isOrganizerAlgorithmEnabled(): bool
    {
        $settings = self::getSettings();
        return $settings ? $settings->organizer_algorithm : true;
    }

    /**
     * IMPORTANT: Remove the $updatedBy parameter and any assignment to updated_by
     */
    public static function updateToggles(array $data): bool
    {
        $settings = self::getSettings();

        if (!$settings) {
            return false;
        }

        if (array_key_exists('user_algorithm', $data)) {
            $settings->user_algorithm = (bool) $data['user_algorithm'];
        }

        if (array_key_exists('organizer_algorithm', $data)) {
            $settings->organizer_algorithm = (bool) $data['organizer_algorithm'];
        }

        // Do NOT set updated_by here
        // if ($updatedBy !== null) { $settings->updated_by = $updatedBy; }

        return $settings->save();
    }
}
