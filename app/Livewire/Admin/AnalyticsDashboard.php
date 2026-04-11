<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\AnalyticsEvent;
use App\Models\ProfessionalProfile;
use App\Models\Category;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Component
{
    #[Computed(cache: true, key: 'admin_analytics_metrics', duration: 60)]
    public function metrics()
    {
        return [
            'whatsapp_clicks' => AnalyticsEvent::where('event_type', 'whatsapp_click')->count(),
            'searches'        => AnalyticsEvent::where('event_type', 'search_performed')->count(),
            'profile_views'   => AnalyticsEvent::where('event_type', 'profile_view')->count(),
        ];
    }

    #[Computed(cache: true, key: 'admin_analytics_top_profiles', duration: 60)]
    public function topProfiles()
    {
        $topViews = AnalyticsEvent::where('event_type', 'profile_view')
            ->whereNotNull('entity_id')
            ->select('entity_id', DB::raw('count(*) as aggregate_views'))
            ->groupBy('entity_id')
            ->orderByDesc('aggregate_views')
            ->limit(5)
            ->get();

        $profileIds = $topViews->pluck('entity_id');
        
        $profiles = ProfessionalProfile::whereIn('id', $profileIds)
            ->get(['id', 'display_name'])
            ->keyBy('id');

        return $topViews->map(function ($stat) use ($profiles) {
            return (object)[
                'id' => $stat->entity_id,
                'name' => $profiles->has($stat->entity_id) ? $profiles[$stat->entity_id]->display_name : 'محذوف',
                'views' => $stat->aggregate_views,
            ];
        });
    }

    #[Computed(cache: true, key: 'admin_analytics_top_searches', duration: 60)]
    public function topSearches()
    {
        $searches = AnalyticsEvent::where('event_type', 'search_performed')
            ->whereNotNull('meta')
            ->latest()
            ->limit(1000)
            ->get(['meta']);

        $categoryCounts = [];
        $cityCounts = [];

        foreach ($searches as $event) {
            $catId = $event->meta['category_id'] ?? null;
            $cityId = $event->meta['city_id'] ?? null;

            if ($catId) $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 1;
            if ($cityId) $cityCounts[$cityId] = ($cityCounts[$cityId] ?? 0) + 1;
        }

        arsort($categoryCounts);
        arsort($cityCounts);

        $topCatId = array_key_first($categoryCounts);
        $topCityId = array_key_first($cityCounts);

        return (object)[
            'category_name' => $topCatId ? Category::find($topCatId)?->name ?? 'غير معروف' : 'لا يوجد',
            'category_count' => $topCatId ? $categoryCounts[$topCatId] : 0,
            'city_name' => $topCityId ? City::find($topCityId)?->name ?? 'غير معروف' : 'لا يوجد',
            'city_count' => $topCityId ? $cityCounts[$topCityId] : 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard')
            ->layout('components.layouts.app-shell', ['title' => 'لوحة التحليلات']);
    }
}
