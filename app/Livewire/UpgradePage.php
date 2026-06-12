<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfessionalProfile;
use App\Models\ContractorDetails;
use App\Actions\UpgradeToProvider;
use App\Services\SystemCacheService;

class UpgradePage extends Component
{
    use WithFileUploads;

    // ── Form State ──────────────────────────────────────────
    public string $provider_type = 'professional';

    // User fields (editable, prefilled from users table)
    public string $name = '';
    public string $phone = '';

    // Shared provider fields
    public string $display_name = '';
    public string $whatsapp_number = '';
    public ?string $secondary_phone = '';
    public string $category_id = '';
    public string $city_id = '';
    public ?string $district_id = '';
    public string $gender = '';
    public string $description = '';
    public string $availability_status = 'available';

    // Identity fields
    public string $identity_number = '';
    public $identity_image; // Livewire file upload

    // Contractor-only fields
    public string $business_name = '';
    public string $contractor_type = '';
    public ?string $team_size = '';

    // ── Internal State ──────────────────────────────────────
    public bool $isResubmission = false;
    public bool $isPending = false;
    public ?string $existingIdentityPath = null;

    // ── Mount ───────────────────────────────────────────────
    public function mount()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Block admin users.
        if ($user->isAdmin()) {
            return redirect()->route('home');
        }

        // Check for existing professional profile.
        $profile = $user->professionalProfile;

        if ($profile) {
            // Already approved or active — go to dashboard.
            if (in_array($profile->profile_status, ['active', 'inactive'])) {
                return redirect()->route('pro.dashboard')
                    ->with('info', 'ملفك المهني موجود بالفعل.');
            }

            // Suspended — block access.
            if ($profile->profile_status === 'suspended') {
                return redirect()->route('dashboard')
                    ->with('error', 'تم إيقاف حسابك مؤقتاً.');
            }

            // Pending review — show pending state.
            if ($profile->profile_status === 'pending_review') {
                $this->isPending = true;
                $this->loadExistingProfile($user, $profile);
                return;
            }

            // Rejected — allow resubmission.
            if ($profile->profile_status === 'rejected') {
                $this->isResubmission = true;
                $this->loadExistingProfile($user, $profile);
                return;
            }
        }

        // Fresh customer — prefill from users table.
        $this->name = $user->name;
        $this->phone = $user->phone;

        // Pre-select provider type from query param if present.
        $type = request()->query('type');
        if (in_array($type, ['professional', 'contractor'])) {
            $this->provider_type = $type;
        }
    }

    // ── Load Existing Data ──────────────────────────────────
    protected function loadExistingProfile($user, ProfessionalProfile $profile): void
    {
        $this->name = $user->name;
        $this->phone = $user->phone;

        $this->provider_type = $profile->provider_type ?? 'professional';
        $this->display_name = $profile->display_name ?? '';
        $this->whatsapp_number = $profile->whatsapp_number ?? '';
        $this->secondary_phone = $profile->secondary_phone ?? '';
        $this->category_id = (string) ($profile->category_id ?? '');
        $this->city_id = (string) ($profile->city_id ?? '');
        $this->district_id = (string) ($profile->district_id ?? '');
        $this->gender = $profile->gender ?? '';
        $this->description = $profile->description ?? '';
        $this->availability_status = $profile->availability_status ?? 'available';
        $this->identity_number = $profile->identity_number ?? '';
        $this->existingIdentityPath = $profile->identity_image_path;

        // Load contractor details if applicable.
        if ($profile->provider_type === 'contractor' && $profile->contractorDetails) {
            $this->business_name = $profile->contractorDetails->business_name ?? '';
            $this->contractor_type = $profile->contractorDetails->contractor_type ?? '';
            $this->team_size = (string) ($profile->contractorDetails->team_size ?? '');
        }
    }

    // ── Reactive Hooks ──────────────────────────────────────
    public function updatedCityId()
    {
        $this->district_id = '';
    }

    // ── Validation Rules ────────────────────────────────────
    protected function validationRules(): array
    {
        $rules = [
            'provider_type'      => 'required|in:professional,contractor',
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|regex:/^[0-9]{9}$/',
            'display_name'       => 'required|string|max:255',
            'whatsapp_number'    => 'required|numeric|digits_between:8,15',
            'secondary_phone'    => 'nullable|string|max:20',
            'category_id'        => ['required', \Illuminate\Validation\Rule::exists('categories', 'id')->where('is_active', true)],
            'city_id'            => 'required|exists:cities,id',
            'district_id'        => [
                'nullable',
                'exists:districts,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $district = \App\Models\District::find($value);
                        if ($district && $district->city_id != $this->city_id) {
                            $fail('الحي المختار لا ينتمي للمدينة المحددة.');
                        }
                    }
                },
            ],
            'gender'             => 'required|in:male,female',
            'description'        => 'required|string|max:5000',
            'availability_status' => 'required|in:available,busy,offline',
            'identity_number'    => 'required|string|max:20',
        ];

        // Identity image: required on first submission, optional on resubmission if already exists.
        if ($this->isResubmission && $this->existingIdentityPath) {
            $rules['identity_image'] = 'nullable|image|max:5120'; // 5MB max
        } else {
            $rules['identity_image'] = 'required|image|max:5120';
        }

        // Contractor-only validation.
        if ($this->provider_type === 'contractor') {
            $rules['business_name']    = 'required|string|max:255';
            $rules['contractor_type']  = 'required|in:individual,company,team';
            $rules['team_size']        = 'nullable|string|max:50';
        }

        return $rules;
    }

    protected function validationMessages(): array
    {
        return [
            'phone.regex' => 'رقم الجوال يجب أن يتكون من 9 أرقام.',
            'identity_image.required' => 'صورة الهوية مطلوبة.',
            'identity_image.image' => 'الملف يجب أن يكون صورة.',
            'identity_image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',
            'description.required' => 'الوصف مطلوب.',
        ];
    }

    // ── Submit ───────────────────────────────────────────────
    public function submit()
    {
        if ($this->isPending) {
            return;
        }

        $validated = $this->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Store identity image to private disk (not public).
        $identityImagePath = null;
        if ($this->identity_image) {
            $identityImagePath = $this->identity_image->store(
                'identity-documents',
                'local' // Private disk — not accessible via public URL.
            );
        }

        // Execute the atomic upgrade action.
        $action = new UpgradeToProvider();
        $action->execute($user, $validated, $identityImagePath);

        // Flash success message and redirect to professional dashboard.
        session()->flash('upgrade_success', 'تم إرسال طلب الترقية بنجاح! سيتم مراجعته من قبل الإدارة.');

        return redirect()->route('pro.dashboard');
    }

    // ── Render ───────────────────────────────────────────────
    #[Title('ترقية الحساب - MyMetier')]
    public function render()
    {
        $categories = SystemCacheService::getCategories();
        $cities = SystemCacheService::getCities();
        $districts = $this->city_id
            ? SystemCacheService::getDistrictsByCity($this->city_id)
            : collect();

        return view('livewire.upgrade-page', [
            'categories' => $categories,
            'cities'     => $cities,
            'districts'  => $districts,
            'user'       => Auth::user(),
        ])->layout('components.layouts.app-shell');
    }
}
