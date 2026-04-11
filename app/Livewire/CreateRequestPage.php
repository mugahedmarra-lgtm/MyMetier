<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\PublicRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Services\SystemCacheService;

class CreateRequestPage extends Component
{
    public $title = '';
    public $description = '';
    public $categoryId = '';
    public $cityId = '';
    public $districtId = '';

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function updatedCityId()
    {
        $this->districtId = '';
    }

    public function save()
    {
        if (!Auth::check()) return redirect()->route('login');

        $this->validate([
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'categoryId' => 'required|exists:categories,id',
            'cityId' => 'required|exists:cities,id',
            'districtId' => 'required|exists:districts,id',
        ]);

        PublicRequest::create([
            'user_id' => Auth::id(),
            'category_id' => $this->categoryId,
            'city_id' => $this->cityId,
            'district_id' => $this->districtId,
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'open',
        ]);

        session()->flash('success', 'تم طرح طلبك بنجاح. المهنيون سيتواصلون معك قريباً.');
        return redirect()->route('requests.index');
    }

    #[Title('نشر طلب جديد - MyMetier')]
    public function render()
    {
        $categories = SystemCacheService::getCategories();
        $cities = SystemCacheService::getCities();
        $districts = SystemCacheService::getDistrictsByCity($this->cityId);

        return view('livewire.create-request-page', [
            'categories' => $categories,
            'cities' => $cities,
            'districts' => $districts,
        ]);
    }
}
