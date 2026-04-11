<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\ProfessionalProfile;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProfessionalProfilePage extends Component
{
    public $profile;
    public bool $isFavorited = false;

    public int $reviewRating = 0;
    public string $reviewComment = '';

    protected $rules = [
        'reviewRating' => 'required|integer|min:1|max:5',
        'reviewComment' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'reviewRating.required' => 'يرجى اختيار التقييم للخدمة بالنجوم أولاً.',
        'reviewRating.integer' => 'قيمة التقييم غير صالحة.',
    ];

    public function mount($id)
    {
        $this->profile = ProfessionalProfile::with([
            'user:id,name',
            'category:id,name',
            'city:id,name',
            'district:id,name',
            'gallery' => function ($query) {
                $query->select('id', 'professional_profile_id', 'image_path', 'title', 'sort_order')
                      ->orderBy('sort_order', 'asc');
            },
            'reviews' => function ($query) {
                $query->select('id', 'professional_profile_id', 'user_id', 'rating', 'comment', 'created_at')
                      ->with('user:id,name')
                      ->latest()
                      ->limit(10);
            }
        ])
        ->where('profile_status', 'active')
        ->findOrFail($id, [
            'id', 'user_id', 'display_name', 'description', 'category_id', 'city_id', 'district_id', 
            'whatsapp_number', 'rating_avg', 'availability_status', 'verification_status', 'views_count'
        ]);

        // Increment views count on load natively
        $this->profile->increment('views_count');

        if (function_exists('trackEvent')) {
            trackEvent('profile_view', 'profile', $this->profile->id);
        }

        if (Auth::check()) {
            $this->isFavorited = Favorite::where('user_id', Auth::id())
                ->where('professional_profile_id', $this->profile->id)->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isFavorited) {
            Favorite::where('user_id', Auth::id())
                ->where('professional_profile_id', $this->profile->id)->delete();
            $this->isFavorited = false;
            session()->flash('success', 'تمت الإزالة من المفضلة');
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'professional_profile_id' => $this->profile->id
            ]);
            $this->isFavorited = true;
            session()->flash('success', 'تمت الإضافة للمفضلة');
        }
    }

    public function trackWhatsappClick()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->profile->whatsapp_number) {
            $this->profile->increment('whatsapp_clicks');
            
            if (function_exists('trackEvent')) {
                trackEvent('whatsapp_click', 'profile', $this->profile->id);
            }
            
            $text = urlencode("السلام عليكم، شاهدت ملفك في منصة MyMetier وأحتاج خدمتك.");
            
            // Clean number preserving only digits
            $number = preg_replace('/[^0-9]/', '', $this->profile->whatsapp_number);
            $url = "https://wa.me/{$number}?text={$text}";
            
            return redirect()->away($url);
        }
    }

    #[Computed]
    public function hasReviewed()
    {
        if (!Auth::check()) return false;
        return Review::where('user_id', Auth::id())
            ->where('professional_profile_id', $this->profile->id)->exists();
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() === $this->profile->user_id) {
            session()->flash('error', 'عذراً.. لا يمكنك تقييم ملفك الشخصي.');
            return;
        }

        if ($this->hasReviewed) {
            session()->flash('error', 'لقد قمت بإضافة تقييم لهذا المهني مسبقاً.');
            return;
        }

        $this->validate();

        $review = new Review();
        $review->user_id = Auth::id();
        $review->professional_profile_id = $this->profile->id;
        $review->rating = $this->reviewRating;
        $review->comment = $this->reviewComment;
        $review->save();

        // Recalculate and update profile stats immediately
        $newAvg = Review::where('professional_profile_id', $this->profile->id)->avg('rating');
        $newCount = Review::where('professional_profile_id', $this->profile->id)->count();

        $this->profile->update([
            'rating_avg' => round((float)$newAvg, 2),
            'rating_count' => $newCount
        ]);

        $this->reset(['reviewRating', 'reviewComment']);
        
        // Refresh the profile relation so UI updates natively without full page reload
        $this->profile->load(['reviews' => function ($query) {
            $query->select('id', 'professional_profile_id', 'user_id', 'rating', 'comment', 'created_at')
                  ->with('user:id,name')
                  ->latest()
                  ->limit(10);
        }]);

        // Break cached computed property ensuring it refreshes
        unset($this->hasReviewed);

        session()->flash('success', 'تم إرسال تقييمك بنجاح، شكراً لك!');
    }

    /** @return \Illuminate\Contracts\View\View|\Livewire\Mechanisms\HandleComponents\ViewContext */
    public function render()
    {
        /** @var mixed $view */
        $view = view('livewire.professional-profile-page');
        
        return $view->title($this->profile->display_name . ' | MyMetier');
    }
}
