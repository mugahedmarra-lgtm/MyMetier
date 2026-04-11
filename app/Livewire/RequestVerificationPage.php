<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfessionalProfile;
use App\Models\VerificationRequest;
use App\Models\VerificationDocument;

class RequestVerificationPage extends Component
{
    use WithFileUploads;

    public ?ProfessionalProfile $profile = null;

    // Current state
    public bool $isEligible = false;
    public bool $hasPending = false;
    public bool $isVerified = false;
    public ?VerificationRequest $latestRequest = null;

    // Form: dynamic document rows
    public array $documentRows = [];

    // Form: dedicated payment proof
    public $paymentProof;

    protected array $messages = [
        'documentRows.*.file.required' => 'يجب إرفاق ملف المستند.',
        'documentRows.*.file.image' => 'يجب أن يكون الملف صورة.',
        'documentRows.*.file.max' => 'حجم الملف يجب أن لا يتجاوز 3 ميجابايت.',
        'documentRows.*.type.required' => 'يجب اختيار نوع المستند.',
        'documentRows.*.type.in' => 'نوع المستند غير صالح.',
        'paymentProof.required' => 'يجب إرفاق إيصال التحويل.',
        'paymentProof.image' => 'إيصال التحويل يجب أن يكون صورة.',
        'paymentProof.max' => 'حجم صورة الإيصال يجب أن لا يتجاوز 3 ميجابايت.',
    ];

    public function mount()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['professional', 'contractor'])) {
            return redirect()->route('home');
        }

        $this->profile = ProfessionalProfile::where('user_id', $user->id)->first();

        if (!$this->profile) {
            return redirect()->route('home');
        }

        $this->isVerified = $this->profile->verification_status === 'verified';

        $this->latestRequest = $this->profile->latestVerificationRequest;

        $this->hasPending = $this->latestRequest?->status === 'pending_review';

        $this->isEligible = $this->profile->canRequestVerification();

        // Initialize with one empty document row for fresh forms.
        if ($this->isEligible) {
            $this->addDocumentRow();
        }
    }

    /**
     * Add a new empty document upload row.
     */
    public function addDocumentRow(): void
    {
        if (count($this->documentRows) >= 5) {
            return; // Max 5 documents per request.
        }

        $this->documentRows[] = [
            'type' => '',
            'file' => null,
        ];
    }

    /**
     * Remove a document row by index.
     */
    public function removeDocumentRow(int $index): void
    {
        if (count($this->documentRows) <= 1) {
            return; // Must keep at least one row.
        }

        unset($this->documentRows[$index]);
        $this->documentRows = array_values($this->documentRows);
    }

    /**
     * Submit the verification request.
     */
    public function submit(): void
    {
        if (!$this->profile || !$this->isEligible) {
            session()->flash('error', 'لا يمكنك تقديم طلب توثيق في الوقت الحالي.');
            return;
        }

        // Re-verify eligibility at submission time (race-condition guard).
        if (!$this->profile->canRequestVerification()) {
            session()->flash('error', 'لا يمكنك تقديم طلب توثيق في الوقت الحالي.');
            return;
        }

        $this->validate([
            'documentRows' => 'required|array|min:1',
            'documentRows.*.type' => 'required|in:commercial_register,vocational_license,national_id,other',
            'documentRows.*.file' => 'required|image|max:3072',
            'paymentProof' => 'required|image|max:3072',
        ]);

        // Create the verification request.
        $verificationRequest = VerificationRequest::create([
            'professional_profile_id' => $this->profile->id,
            'status' => 'pending_review',
            'submitted_at' => now(),
        ]);

        // Store the dedicated payment proof
        $paymentProofPath = $this->paymentProof->store('verification-documents', 'local');
        VerificationDocument::create([
            'verification_request_id' => $verificationRequest->id,
            'document_type' => 'payment_proof',
            'file_path' => $paymentProofPath,
            'original_filename' => $this->paymentProof->getClientOriginalName(),
        ]);

        // Store each regular document on private disk.
        foreach ($this->documentRows as $row) {
            $file = $row['file'];
            $path = $file->store('verification-documents', 'local');

            VerificationDocument::create([
                'verification_request_id' => $verificationRequest->id,
                'document_type' => $row['type'],
                'file_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
            ]);
        }

        // Refresh state.
        $this->isEligible = false;
        $this->hasPending = true;
        $this->latestRequest = $verificationRequest;
        $this->documentRows = [];
        $this->paymentProof = null;

        session()->flash('success', 'تم إرسال طلب التوثيق بنجاح. سيتم مراجعته من قبل الإدارة.');
    }

    #[Layout('components.layouts.app-shell')]
    #[Title('طلب التوثيق - MyMetier')]
    public function render()
    {
        return view('livewire.request-verification-page');
    }
}
