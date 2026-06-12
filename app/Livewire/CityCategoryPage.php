<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use App\Models\ProfessionalProfile;
use App\Models\Category;
use App\Models\City;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\SystemCacheService;

class CityCategoryPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $city;
    public $category;

    #[Url(as: 'district')]
    public ?int $district_id = null;

    #[Url(as: 'status')]
    public string $availability_status = '';

    public function mount($city, $category)
    {
        $this->city = Cache::rememberForever("city_slug_{$city}", function () use ($city) {
            return City::where('slug', $city)->firstOrFail();
        });

        $this->category = Cache::rememberForever("category_slug_{$category}", function () use ($category) {
            return Category::where('slug', $category)->firstOrFail();
        });
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['district_id', 'availability_status']);
        $this->resetPage();
    }

    public function toggleFavorite($profileId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('professional_profile_id', $profileId)->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'professional_profile_id' => $profileId
            ]);
        }
        
        unset($this->favoritedProfileIds);
    }

    #[Computed]
    public function favoritedProfileIds()
    {
        if (!Auth::check()) {
            return [];
        }
        return Favorite::where('user_id', Auth::id())->pluck('professional_profile_id')->toArray();
    }

    #[Computed]
    public function results()
    {
        $page = $this->getPage();
        
        $cacheKey = "city_category_page_results_{$this->city->id}_{$this->category->id}_{$this->district_id}_{$this->availability_status}_{$page}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () {
            $query = ProfessionalProfile::query()
                ->select([
                    'id', 'user_id', 'display_name', 'category_id', 'city_id', 'district_id',
                    'rating_avg', 'availability_status', 'profile_status', 'verification_status',
                    'is_featured', 'featured_until', 'whatsapp_clicks'
                ])
                ->with([
                    'user:id,name',
                    'category:id,name',
                    'city:id,name',
                ])
                ->where('category_id', $this->category->id)
                ->where('city_id', $this->city->id);

            if ($this->district_id && is_numeric($this->district_id)) {
                $validDistrict = \App\Models\District::where('id', $this->district_id)
                    ->where('city_id', $this->city->id)->exists();
                if ($validDistrict) {
                    $query->where('district_id', (int)$this->district_id);
                } else {
                    $this->district_id = null;
                }
            }

            if ($this->availability_status) {
                $query->where('availability_status', $this->availability_status);
            }

            // Enforce business rules
            $query->where('profile_status', 'active')
                ->whereNotNull('whatsapp_number')
                ->where('whatsapp_number', '!=', '');

            return $query
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
                ->latest()
                ->paginate(12);
        });
    }

    #[Computed]
    public function districts()
    {
        return SystemCacheService::getDistrictsByCity($this->city->id);
    }

    public function render()
    {
        $title = "أفضل {$this->category->name} في {$this->city->name}";
        $description = "ابحث عن أفضل {$this->category->name} في {$this->city->name} مع تقييمات حقيقية";

        return view('livewire.city-category-page')
            ->layout('components.layouts.app-shell')
            ->title($title)
            ->layoutData(['metaDescription' => $description]);
    }
}
