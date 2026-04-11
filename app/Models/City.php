<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
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
        // Sort cities by sort_order ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
        });

        static::creating(function (City $city) {
            if (empty($city->slug)) {
                $city->slug = static::generateUniqueSlug($city->name);
            }
        });

        static::updating(function (City $city) {
            if ($city->isDirty('name') && empty($city->slug)) {
                $city->slug = static::generateUniqueSlug($city->name);
            }
        });

        // Cache Clearance Hook
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('cities.list');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('cities.list');
        });
    }

    /**
     * Generate a unique slug based on the given name.
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name, '-', 'ar');
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
     * Scope a query to only include active cities.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Relationship: City has many Districts.
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * Relationship: City has many Professional Profiles.
     */
    public function professionalProfiles(): HasMany
    {
        return $this->hasMany(ProfessionalProfile::class);
    }
}
