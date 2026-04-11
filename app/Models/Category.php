<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * The "booted" method of the model.
     * Add global scope for sort_order ASC.
     * Add event listeners for auto-slug.
     */
    protected static function booted(): void
    {
        // Business Rule: Categories must be ordered by sort_order ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
        });

        // Auto Slug Logic on Creating
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name);
            }
        });

        // Auto Slug Logic on Updating
        static::updating(function (Category $category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name);
            }
        });

        // Cache Clearance Hook
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('categories.list');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('categories.list');
        });
    }

    /**
     * Generate a unique slug based on the given name.
     */
    public static function generateUniqueSlug(string $name): string
    {
        // Generate the slug, and provide an empty string for language to force it
        // Or if using default, Laravel's Str::slug supports Arabic in newer versions
        $slug = Str::slug($name, '-', 'ar');
        // fallback to standard if ar fails
        if (empty($slug)) {
            $slug = Str::slug($name);
        }

        $originalSlug = $slug;
        $count = 1;

        // Ensure uniqueness
        while (static::withoutGlobalScopes()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Relationship: Category has many Professional Profiles.
     */
    public function professionalProfiles(): HasMany
    {
        return $this->hasMany(ProfessionalProfile::class);
    }

    /**
     * Relationship: Category has many Public Requests.
     */
    public function publicRequests(): HasMany
    {
        return $this->hasMany(PublicRequest::class);
    }
}
