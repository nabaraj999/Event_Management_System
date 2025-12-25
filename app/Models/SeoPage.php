<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'page_key',
        'locale',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots',
        'extra_meta',
        'is_active',
    ];

    protected $casts = [
        'extra_meta' => 'array',
        'is_active'  => 'boolean',
    ];

    /**
     * Get SEO data for a specific page and locale.
     *
     * @param string $pageKey
     * @param string|null $locale
     * @return self|null
     */
    public static function getForPage(string $pageKey, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale() ?? 'en';

        return static::where('page_key', $pageKey)
                     ->where('locale', $locale)
                     ->where('is_active', true)
                     ->first();
    }
}
