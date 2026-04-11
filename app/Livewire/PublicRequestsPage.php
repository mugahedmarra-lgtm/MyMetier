<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PublicRequest;
use App\Models\Category;
use App\Models\City;
use App\Services\SystemCacheService;

class PublicRequestsPage extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryId = '';
    public $cityId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingCityId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = PublicRequest::query()
            ->select([
                'id',
                'user_id',
                'category_id',
                'city_id',
                'title',
                'description',
                'status',
                'created_at',
            ])
            ->with([
                'category:id,name', 
                'city:id,name', 
                'user:id,name'
            ])
            ->where('status', 'open');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryId && is_numeric($this->categoryId)) {
            $query->where('category_id', (int)$this->categoryId);
        }

        if ($this->cityId && is_numeric($this->cityId)) {
            $query->where('city_id', (int)$this->cityId);
        }

        $requests = $query->latest()->paginate(12);
        
        $categories = SystemCacheService::getCategories();
        $cities = SystemCacheService::getCities();

        return view('livewire.public-requests-page', [
            'requests' => $requests,
            'categories' => $categories,
            'cities' => $cities,
        ])->title('الطلبات العامة - MyMetier');
    }
}
