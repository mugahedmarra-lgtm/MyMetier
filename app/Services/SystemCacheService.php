<?php

namespace App\Services;

use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\DTO\CategoryDTO;
use App\DTO\CityDTO;
use App\DTO\DistrictDTO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SystemCacheService
{
    public static function getCategories()
    {
        $data = Cache::remember('categories.list', 3600, function () {
            return Category::active()->orderBy('sort_order', 'asc')->get(['id', 'name', 'icon'])->toArray();
        });
        return collect($data)->map(fn($item) => CategoryDTO::fromArray($item));
    }

    public static function getCities()
    {
        $data = Cache::remember('cities.list', 3600, function () {
            return City::active()->orderBy('sort_order', 'asc')->get(['id', 'name'])->toArray();
        });
        return collect($data)->map(fn($item) => CityDTO::fromArray($item));
    }

    public static function getDistrictsByCity($cityId)
    {
        if (empty($cityId)) {
            return collect();
        }

        $data = Cache::remember("districts_city_{$cityId}", 3600, function () use ($cityId) {
            return District::active()
                ->where('city_id', $cityId)
                ->orderBy('name')
                ->get(['id', 'name', 'city_id'])
                ->toArray();
        });
        
        return collect($data)->map(fn($item) => DistrictDTO::fromArray($item));
    }

    public static function getFeaturedProfessionals()
    {
        return Cache::remember('featured_homepage', 600, function () {
            $hasFeaturedColumns =
                Schema::hasColumn('professional_profiles', 'is_featured') &&
                Schema::hasColumn('professional_profiles', 'featured_until');

            if ($hasFeaturedColumns) {
                return \App\Models\ProfessionalProfile::query()
                    ->select([
                        'id',
                        'user_id',
                        'display_name',
                        'category_id',
                        'city_id',
                        'rating_avg',
                    ])
                    ->with([
                        'category:id,name',
                        'city:id,name',
                    ])
                    ->where('profile_status', 'active')
                    ->whereHas('category', fn ($query) => $query->where('is_active', true))
                    ->where('is_featured', 1)
                    ->where('featured_until', '>', now()->toDateTimeString())
                    ->selectRaw("
                        (
                            CASE WHEN verification_status = 'verified' THEN 50 ELSE 0 END +
                            (rating_avg * 10) +
                            whatsapp_clicks +
                            CASE 
                                WHEN availability_status = 'available' THEN 10 
                                WHEN availability_status = 'busy' THEN 5 
                                ELSE 0 
                            END
                        ) as ranking_score
                    ")
                    ->orderByDesc('ranking_score')
                    ->limit(6)
                    ->get()
                    ->map(function ($profile) {
                        return [
                            'id' => $profile->id,
                            'display_name' => $profile->display_name,
                            'category_name' => $profile->category->name ?? '',
                            'city_name' => $profile->city->name ?? '',
                            'rating_avg' => $profile->rating_avg,
                            'ranking_score' => $profile->ranking_score,
                        ];
                    })
                    ->toArray();
            }

            return \App\Models\ProfessionalProfile::query()
                ->with(['category', 'city'])
                ->where('profile_status', 'active')
                ->whereHas('category', fn ($query) => $query->where('is_active', true))
                ->latest()
                ->limit(20)
                ->get();
        });
    }

    public static function getPopularProfessionals()
    {
        return Cache::remember('popular_professionals', 600, function () {
            $hasFeaturedColumns =
                Schema::hasColumn('professional_profiles', 'is_featured') &&
                Schema::hasColumn('professional_profiles', 'featured_until');

            if ($hasFeaturedColumns) {
                return \App\Models\ProfessionalProfile::query()
                    ->select([
                        'id',
                        'user_id',
                        'display_name',
                        'category_id',
                        'city_id',
                        'rating_avg',
                        'is_featured',
                        'featured_until',
                    ])
                    ->with([
                        'user:id,name',
                        'category:id,name',
                        'city:id,name',
                    ])
                    ->where('profile_status', 'active')
                    ->whereHas('category', fn ($query) => $query->where('is_active', true))
                    ->whereNotNull('whatsapp_number')
                    ->where('whatsapp_number', '!=', '')
                    ->selectRaw("
                        (
                            CASE WHEN is_featured = 1 AND featured_until > '" . now()->toDateTimeString() . "' THEN 100 ELSE 0 END +
                            CASE WHEN verification_status = 'verified' THEN 50 ELSE 0 END +
                            (rating_avg * 10) +
                            whatsapp_clicks +
                            CASE 
                                WHEN availability_status = 'available' THEN 10 
                                WHEN availability_status = 'busy' THEN 5 
                                ELSE 0 
                            END
                        ) as ranking_score
                    ")
                    ->orderByDesc('ranking_score')
                    ->limit(8)
                    ->get()
                    ->map(function ($profile) {
                        return [
                            'id' => $profile->id,
                            'display_name' => $profile->display_name,
                            'category_name' => $profile->category->name ?? '',
                            'city_name' => $profile->city->name ?? '',
                            'rating_avg' => $profile->rating_avg,
                            'ranking_score' => $profile->ranking_score,
                            'is_featured' => $profile->isFeatured(),
                        ];
                    })
                    ->toArray();
            }

            return \App\Models\ProfessionalProfile::query()
                ->with(['category', 'city'])
                ->where('profile_status', 'active')
                ->whereHas('category', fn ($query) => $query->where('is_active', true))
                ->latest()
                ->limit(20)
                ->get();
        });
    }
}
