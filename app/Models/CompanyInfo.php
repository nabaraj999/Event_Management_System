<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;

    protected $table = 'company_infos'; // Explicitly define if needed

    /**
     * The attributes that are mass assignable.
     */
   // app/Models/CompanyInfo.php

protected $fillable = [
    'name', 'tagline', 'logo', 'favicon', 'bg_image', 'email', 'phone', 'location',
    'facebook', 'instagram', 'youtube', 'linkedin', 'twitter', 'tiktok',
    'about_us_title', 'about_us_description', 'about_us_image',
    'reg_no', 'pan_no', 'gst_no', 'company_start',
    'total_employees', 'total_events', 'satisfied_clients', 'net_worth',
    'website', 'address_full', 'map_link', 'is_active',
    'working_hours', 'extra_links'
];

protected $casts = [
    'working_hours' => 'array',
    'extra_links'   => 'array',
    'is_active'     => 'boolean',
];

    /**
     * Get the full URL for logo, favicon, bg_image, about_us_image
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getFaviconUrlAttribute()
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : null;
    }

    public function getBgImageUrlAttribute()
    {
        return $this->bg_image ? asset('storage/' . $this->bg_image) : null;
    }

    public function getAboutUsImageUrlAttribute()
    {
        return $this->about_us_image ? asset('storage/' . $this->about_us_image) : null;
    }

    /**
     * Scope to get only active company info
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper: Usually there's only one record, so get the first active one
     */
    public static function getActiveCompany()
    {
        return self::active()->first();
    }

    /**
     * Override the default toJson to include URL accessors
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['logo_url'] = $this->logo_url;
        $array['favicon_url'] = $this->favicon_url;
        $array['bg_image_url'] = $this->bg_image_url;
        $array['about_us_image_url'] = $this->about_us_image_url;

        return $array;
    }
}
