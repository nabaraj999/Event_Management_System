<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'slug',
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
    public function getRouteKeyName()
    {
        return 'slug'; // ← this enables model binding with slug
    }

    protected static function booted()
    {
        static::creating(function ($page) {
            if (empty($page->slug) && !empty($page->page_key)) {
                $page->generateUniqueSlug();
            }
        });

        static::updating(function ($page) {
            // Regenerate only if page_key changed and slug was not manually set
            if ($page->isDirty('page_key') && !$page->isDirty('slug')) {
                $page->generateUniqueSlug();
            }
        });
    }

    public function generateUniqueSlug()
    {
        $source = $this->page_key; // or you can use meta_title if preferred

        $base = Str::slug($source ?: 'page-' . Str::random(6));
        $slug = $base;
        $counter = 1;

        while (self::where('slug', $slug)
                   ->where('id', '!=', $this->id ?? 0)
                   ->exists()) {
            $slug = $base . '-' . $counter++;
        }

        $this->slug = $slug;
    }

}
