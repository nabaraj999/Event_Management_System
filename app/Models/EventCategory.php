<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'slug',
        'description',
        'icon_type',
        'icon_name',
        'custom_svg',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto slug
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Render correct icon
    public function renderIcon($class = 'w-10 h-10 text-[#FF7A28]')
    {
        return match ($this->icon_type) {
            'fontawesome' => $this->fontawesome($this->icon_name, $class),
            'heroicon'    => $this->heroicon($this->icon_name, $class),
            'custom'      => $this->custom_svg ?? '<div class="w-10 h-10 bg-gray-300 rounded"></div>',
            default       => $this->fontawesome('fa-solid fa-folder', $class),
        };
    }

    private function fontawesome($fullClass, $extraClass = '')
    {
        // $fullClass example: "fa-solid fa-heart"
        return "<i class=\"{$fullClass} {$extraClass}\"></i>";
    }

    private function heroicon($name, $class)
    {
        return "<x-heroicon-o-{$name} class=\"{$class}\" />";
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id'); // Adjust Event model name and foreign key
    }
    public function organizer()
    {
        return $this->belongsTo(OrganizerApplication::class, 'organizer_id');
    }
    // Scope for global (admin) categories
    public function scopeGlobal($query)
    {
        return $query->whereNull('organizer_id');
    }
    public function scopeMine($query)
    {
        $organizerId = Auth::guard('organizer')->id();
        return $query->where('organizer_id', $organizerId);
    }
    public function scopeVisibleToOrganizer($query)
    {
        $organizerId = Auth::guard('organizer')->id();
        return $query->where(function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId)
              ->orWhereNull('organizer_id');
        });
    }
}
