<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryLimitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_profile_id',
        'requested_limit',
        'payment_proof_path',
        'status',
        'admin_notes',
    ];

    /**
     * Get the professional profile associated with this request.
     */
    public function professionalProfile(): BelongsTo
    {
        return $this->belongsTo(ProfessionalProfile::class);
    }

    protected static function booted()
    {
        static::updated(function ($request) {
            if ($request->isDirty('status') && $request->status === 'approved') {
                if ($request->professionalProfile) {
                    $request->professionalProfile->update([
                        'gallery_limit_override' => $request->requested_limit,
                    ]);
                }
            }
        });
    }

    // ── State Helpers ────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending_review';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
