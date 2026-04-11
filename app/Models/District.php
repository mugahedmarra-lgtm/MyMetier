<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class District extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'name',
        'slug',
        'is_active',
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
     * Add event listeners for auto-slug scoped to city.
     */
    protected static function booted(): void
    {
        static::creating(function (District $district) {
            if (empty($district->slug) && ! empty($district->city_id)) {
                $district->slug = static::generateUniqueSlug($district->name, $district->city_id);
            }
        });

        static::updating(function (District $district) {
            if ($district->isDirty('name') && empty($district->slug) && ! empty($district->city_id)) {
                $district->slug = static::generateUniqueSlug($district->name, $district->city_id);
            }
        });

        // Cache Clearance Hook
        static::saved(function (District $district) {
            if (!empty($district->city_id)) {
                \Illuminate\Support\Facades\Cache::forget("districts_city_{$district->city_id}");
            }
        });

        static::deleted(function (District $district) {
            if (!empty($district->city_id)) {
                \Illuminate\Support\Facades\Cache::forget("districts_city_{$district->city_id}");
            }
        });
    }

    /**
     * Generate a unique slug based on the given name and city_id.
     */
    public static function generateUniqueSlug(string $name, int|string $cityId): string
    {
        $slug = Str::slug($name, '-', 'ar');
        if (empty($slug)) {
            $slug = Str::slug($name);
        }

        $originalSlug = $slug;
        $count = 1;

        // Ensure uniqueness per city_id
        while (static::withoutGlobalScopes()->where('city_id', $cityId)->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Scope a query to only include active districts.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Relationship: District belongs to a City.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relationship: District has many Professional Profiles.
     */
    public function professionalProfiles(): HasMany
    {
        return $this->hasMany(ProfessionalProfile::class);
    }
}
