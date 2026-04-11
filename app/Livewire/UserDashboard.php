<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\PublicRequest;
use App\Models\Review;
use App\Models\Category;
use App\Models\City;
use App\Models\District;

class UserDashboard extends Component
{
    public $activeTab = 'favorites'; // 'favorites', 'requests', 'reviews'

    // Editing request state
    public $editingRequestId = null;
    public $requestTitle = '';
    public $requestDescription = '';
    public $requestCategoryId = '';
    public $requestCityId = '';
    public $requestDistrictId = '';

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->cancelEditRequest(); // ensure form collapses on swap
    }

    public function removeFavorite($favoriteId)
    {
        Favorite::where('id', $favoriteId)->where('user_id', Auth::id())->delete();
    }

    public function closeRequest($requestId)
    {
        PublicRequest::where('id', $requestId)
            ->where('user_id', Auth::id())
            ->where('status', 'open')
            ->update(['status' => 'closed']);
    }

    public function editRequest($requestId)
    {
        $req = PublicRequest::where('id', $requestId)
            ->where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();

        if (!$req) {
            return redirect('/');
        }

        $this->editingRequestId = $req->id;
        $this->requestTitle = $req->title;
        $this->requestDescription = $req->description;
        $this->requestCategoryId = $req->category_id;
        $this->requestCityId = $req->city_id;
        $this->requestDistrictId = $req->district_id;
    }

    public function updatedRequestCityId()
    {
        $this->requestDistrictId = ''; // Reset district when city changes during request edit
    }

    public function updateRequest()
    {
        $this->validate([
            'requestTitle' => 'required|string|max:255',
            'requestDescription' => 'required|string',
            'requestCategoryId' => 'required|exists:categories,id',
            'requestCityId' => 'required|exists:cities,id',
            'requestDistrictId' => 'nullable|exists:districts,id',
        ]);

        $req = PublicRequest::where('id', $this->editingRequestId)
            ->where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();

        if (!$req) {
            return redirect('/');
        }

        $req->update([
            'title' => $this->requestTitle,
            'description' => $this->requestDescription,
            'category_id' => $this->requestCategoryId,
            'city_id' => $this->requestCityId,
            'district_id' => $this->requestDistrictId ?: null,
        ]);

        $this->cancelEditRequest();
    }

    public function cancelEditRequest()
    {
        $this->editingRequestId = null;
        $this->reset(['requestTitle', 'requestDescription', 'requestCategoryId', 'requestCityId', 'requestDistrictId']);
    }

    public function render()
    {
        $user = Auth::user();

        $favorites = Favorite::with([
            'professionalProfile:id,user_id,display_name,category_id,city_id,rating_avg,is_featured,featured_until',
            'professionalProfile.category:id,name', 
            'professionalProfile.city:id,name'
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->get(['id', 'professional_profile_id', 'user_id']);

        $requests = PublicRequest::with(['category:id,name', 'city:id,name'])
            ->where('user_id', $user->id)
            ->latest()
            ->get(['id', 'title', 'status', 'created_at', 'category_id', 'city_id']);

        $reviews = Review::with(['professionalProfile:id,display_name'])
            ->where('user_id', $user->id)
            ->latest()
            ->get(['id', 'professional_profile_id', 'rating', 'comment', 'created_at']);

        $categories = collect();
        $cities = collect();
        $districts = collect();

        // Load editing options gracefully
        if ($this->editingRequestId) {
            $categories = Category::active()->orderBy('sort_order')->get();
            $cities = City::active()->orderBy('sort_order')->get();
            if ($this->requestCityId) {
                $districts = District::active()->where('city_id', $this->requestCityId)->get();
            }
        }

        return view('livewire.user-dashboard', [
            'favorites' => $favorites,
            'requests' => $requests,
            'reviews' => $reviews,
            'user' => $user,
            'categories' => $categories,
            'cities' => $cities,
            'districts' => $districts,
        ])->layout('components.layouts.app-shell')
          ->title('لوحة التحكم - MyMetier');
    }
}
