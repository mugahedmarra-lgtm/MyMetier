<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfessionalProfile;
use App\Models\ProfessionalGallery;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\GalleryLimitRequest;
use App\Services\SystemCacheService;

class ProfessionalDashboard extends Component
{
    use WithFileUploads;

    public $profile;
    public $activeTab = 'profile'; // 'profile', 'gallery'

    // Profile Fields
    public $display_name;
    public $description;
    public $category_id;
    public $city_id;
    public $district_id;
    public $whatsapp_number;
    public $availability_status;

    // Gallery Upload Fields
    public $newImage;
    public $imageTitle = '';
    public $imageSortOrder = 0;

    // Gallery Limit Request Fields
    public $requestedLimit = 15;
    public $paymentProofImage;

    public function mount()
    {
        $user = Auth::user();

        // 1. Authorization Gate
        if (!$user || !in_array($user->role, ['professional', 'contractor'])) {
            return redirect()->route('home');
        }

        // 2. Load Profile Data
        $this->profile = ProfessionalProfile::where('user_id', $user->id)->first();

        if ($this->profile) {
            $this->display_name = $this->profile->display_name;
            $this->description = $this->profile->description;
            $this->category_id = $this->profile->category_id;
            $this->city_id = $this->profile->city_id;
            $this->district_id = $this->profile->district_id;
            $this->whatsapp_number = $this->profile->whatsapp_number;
            $this->availability_status = $this->profile->availability_status;
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updatedCityId()
    {
        // Reset district when city naturally changes to prevent orphan constraints
        $this->district_id = '';
    }

    public function updateProfile()
    {
        if (!$this->profile) return;

        $this->validate([
            'display_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|numeric|digits_between:8,15',
            'category_id' => ['required', \Illuminate\Validation\Rule::exists('categories', 'id')->where('is_active', true)],
            'city_id' => 'required|exists:cities,id',
            'district_id' => [
                'required',
                'exists:districts,id',
                function ($attribute, $value, $fail) {
                    $district = \App\Models\District::find($value);
                    if ($district && $district->city_id != $this->city_id) {
                        $fail('الحي المختار لا ينتمي للمدينة المحددة.');
                    }
                },
            ],
            'availability_status' => 'required|in:available,busy,offline',
            'description' => 'nullable|string',
        ]);

        $this->profile->update([
            'display_name' => $this->display_name,
            'whatsapp_number' => $this->whatsapp_number,
            'category_id' => $this->category_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'availability_status' => $this->availability_status,
            'description' => $this->description,
        ]);

        session()->flash('profile_success', 'تم حفظ التعديلات بنجاح.');
    }

    public function uploadImage()
    {
        if (!$this->profile) return;

        if (!$this->profile->canUploadMoreGalleryImages()) {
            $this->addError('newImage', 'لقد وصلت إلى الحد الأقصى المسموح به لعدد الصور في المعرض.');
            return;
        }

        $this->validate([
            'newImage' => 'required|image|max:2048', // Allow images up to 2MB safely
            'imageTitle' => 'nullable|string|max:255',
            'imageSortOrder' => 'nullable|numeric',
        ]);

        $path = $this->newImage->store('galleries', 'public');

        ProfessionalGallery::create([
            'professional_profile_id' => $this->profile->id,
            'image_path' => $path,
            'title' => $this->imageTitle,
            'sort_order' => $this->imageSortOrder ?: 0,
        ]);

        $this->reset(['newImage', 'imageTitle', 'imageSortOrder']);
        session()->flash('gallery_success', 'تم رفع الصورة وإضافتها إلى المعرض بنجاح.');
    }

    public function deleteImage($id)
    {
        if (!$this->profile) return;

        $image = ProfessionalGallery::where('id', $id)
            ->where('professional_profile_id', $this->profile->id)
            ->first();

        if ($image) {
            $image->delete();
        }
    }

    public function submitLimitIncreaseRequest()
    {
        if (!$this->profile) return;

        // Block multiple pending requests
        $hasPending = GalleryLimitRequest::where('professional_profile_id', $this->profile->id)
            ->where('status', 'pending_review')
            ->exists();

        if ($hasPending) {
            $this->addError('requestedLimit', 'لديك طلب زيادة قيد المراجعة بالفعل. الرجاء الانتظار حتى يتم الرد عليه.');
            return;
        }

        $this->validate([
            'requestedLimit' => 'required|in:15,25,40',
            'paymentProofImage' => 'required|image|max:5120', // allow 5MB max safely
        ]);

        $path = $this->paymentProofImage->store('payment-proofs', 'local');

        GalleryLimitRequest::create([
            'professional_profile_id' => $this->profile->id,
            'requested_limit' => $this->requestedLimit,
            'payment_proof_path' => $path,
            'status' => 'pending_review',
        ]);

        $this->reset(['requestedLimit', 'paymentProofImage']);
        session()->flash('limit_request_success', 'تم إرسال طلب زيادة سعة المعرض بنجاح. سيتم مراجعته من قبل الإدارة.');
    }

    public function render()
    {
        $categories = SystemCacheService::getCategories();
        $cities = SystemCacheService::getCities();
        $districts = SystemCacheService::getDistrictsByCity($this->city_id);

        $gallery = collect();
        $galleryLimit = 3;
        $currentGalleryCount = 0;
        $canUpload = false;

        $hasPendingLimitRequest = false;
        if ($this->profile) {
            $gallery = ProfessionalGallery::where('professional_profile_id', $this->profile->id)
                ->orderBy('sort_order', 'asc')
                ->get();
                
            $galleryLimit = $this->profile->getGalleryLimit();
            $currentGalleryCount = $this->profile->getGalleryImagesCount();
            $canUpload = $this->profile->canUploadMoreGalleryImages();
            
            $hasPendingLimitRequest = GalleryLimitRequest::where('professional_profile_id', $this->profile->id)
                ->where('status', 'pending_review')
                ->exists();
        }

        return view('livewire.professional-dashboard', [
            'categories' => $categories,
            'cities' => $cities,
            'districts' => $districts,
            'gallery' => $gallery,
            'galleryLimit' => $galleryLimit,
            'currentGalleryCount' => $currentGalleryCount,
            'canUpload' => $canUpload,
            'hasPendingLimitRequest' => $hasPendingLimitRequest,
            'user' => Auth::user(),
        ])->layout('components.layouts.app-shell')->title('لوحة الحرفي - MyMetier');
    }
}
