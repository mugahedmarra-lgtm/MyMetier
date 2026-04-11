<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use App\Models\ProfessionalProfile;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\DTO\CategoryDTO;
use App\DTO\CityDTO;
use App\DTO\DistrictDTO;
use App\Services\SystemCacheService;

class SearchPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'category', history: true)]
    public ?int $category_id = null;

    #[Url(as: 'city', history: true)]
    public ?int $city_id = null;

    #[Url(as: 'district', history: true)]
    public ?int $district_id = null;

    #[Url(as: 'status', history: true)]
    public string $availability_status = '';

    #[Url(as: 'sort', history: true)]
    public string $sort = 'best';

    public string $lastTrackedSearchToken = '';

    public function rendering()
    {
        $currentToken = md5(serialize([
            $this->category_id,
            $this->city_id,
            $this->district_id,
            $this->availability_status,
            $this->getPage()
        ]));

        if ($this->lastTrackedSearchToken !== $currentToken) {
            $this->lastTrackedSearchToken = $currentToken;
            
            if (function_exists('trackEvent')) {
                trackEvent(
                    'search_performed',
                    'search',
                    null,
                    array_filter([
                        'category_id' => $this->category_id,
                        'city_id' => $this->city_id,
                        'district_id' => $this->district_id,
                        'availability_status' => $this->availability_status,
                        'page' => $this->getPage()
                    ])
                );
            }
        }
    }

    /**
     * Reset pagination when any filter changes.
     */
    public function updated()
    {
        $this->resetPage();
    }

    /**
     * Dispatch event to scroll to top after page change.
     */
    public function updatedPage()
    {
        $this->dispatch('scroll-to-top');
    }

    /**
     * Clear the district when city changes.
     */
    public function updatedCityId()
    {
        $this->district_id = null;
    }

    /**
     * Reset all filters.
     */
    public function clearFilters()
    {
        $this->reset(['search', 'category_id', 'city_id', 'district_id', 'availability_status', 'sort']);
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
        
        unset($this->favoritedProfileIds); // Refresh computed property
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
        $query = ProfessionalProfile::query()
            ->select([
                'id',
                'user_id',
                'display_name',
                'description',
                'category_id',
                'city_id',
                'district_id',
                'rating_avg',
                'availability_status',
                'profile_status',
                'verification_status',
                'is_featured',
                'featured_until',
            ])
            ->with([
                'user:id,name,avatar',
                'category:id,name',
                'city:id,name',
            ])
            ->searchable();

        if ($this->category_id && is_numeric($this->category_id)) {
            $query->where('category_id', (int)$this->category_id);
        }

        if ($this->city_id && is_numeric($this->city_id)) {
            $query->where('city_id', (int)$this->city_id);
        }

        if ($this->district_id && is_numeric($this->district_id)) {
            if ($this->city_id) {
                // Ensure district belongs to city
                $validDistrict = \App\Models\District::where('id', $this->district_id)
                    ->where('city_id', $this->city_id)->exists();
                if ($validDistrict) {
                    $query->where('district_id', (int)$this->district_id);
                } else {
                    $this->district_id = null; // Reset
                }
            } else {
                // District without city is invalid
                $this->district_id = null;
            }
        }

        if ($this->availability_status) {
            $query->where('availability_status', $this->availability_status);
        }

        if (!empty($this->search)) {
            $query->where('display_name', 'like', '%' . $this->search . '%');
        }

        // Enforce business rules
        $query->where('profile_status', 'active')
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->whereNotNull('whatsapp_number')
            ->where('whatsapp_number', '!=', '')
            ->whereNotNull('category_id')
            ->whereNotNull('city_id');

        if ($this->sort === 'highest_rated') {
            return $query->orderByDesc('rating_avg')->latest()->paginate(10);
        } elseif ($this->sort === 'newest') {
            return $query->latest()->paginate(10);
        }

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
            ->paginate(10);
    }

    #[Computed]
    public function categories()
    {
        return SystemCacheService::getCategories();
    }

    #[Computed]
    public function cities()
    {
        return SystemCacheService::getCities();
    }

    #[Computed]
    public function districts()
    {
        return SystemCacheService::getDistrictsByCity($this->city_id);
    }

    #[Layout('components.layouts.app-shell')]
    #[Title('نتائج البحث - MyMetier')]
    public function render()
    {
        return view('livewire.search-page');
    }
}
