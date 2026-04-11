<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\DTO\CategoryDTO;
use App\DTO\CityDTO;
use App\DTO\DistrictDTO;
use App\Services\SystemCacheService;

class HomePage extends Component
{
    public $categoryId = '';
    public $cityId = '';
    public $districtId = '';

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
        return SystemCacheService::getDistrictsByCity($this->cityId);
    }

    public function updatedCityId($value)
    {
        if (empty($value)) {
            $this->districtId = '';
        } else {
            $districts = $this->districts;
            if ($this->districtId && !$districts->contains(fn($d) => $d->id == $this->districtId)) {
                $this->districtId = '';
            }
        }
    }

    public function search()
    {
        // Build query string filtering out empty values
        $params = array_filter([
            'category' => $this->categoryId,
            'city' => $this->cityId,
            'district' => $this->districtId,
        ]);

        return redirect()->to('/search?' . http_build_query($params));
    }

    #[Computed]
    public function featuredProfessionals()
    {
        return SystemCacheService::getFeaturedProfessionals();
    }

    #[Computed]
    public function popularProfessionals()
    {
        return SystemCacheService::getPopularProfessionals();
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('components.layouts.app-shell')
            ->title('ابحث عن مهني - الرئيسية');
    }
}
