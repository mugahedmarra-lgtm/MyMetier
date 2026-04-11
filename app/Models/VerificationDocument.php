<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationDocument extends Model
{
    protected $fillable = [
        'verification_request_id',
        'document_type',
        'file_path',
        'original_filename',
    ];

    /**
     * Valid document types accepted by the system.
     */
    public const DOCUMENT_TYPES = [
        'commercial_register' => 'السجل التجاري',
        'vocational_license' => 'رخصة مهنية',
        'national_id' => 'الهوية الوطنية',
        'payment_proof' => 'إيصال التحويل',
        'other' => 'أخرى',
    ];

    public function verificationRequest(): BelongsTo
    {
        return $this->belongsTo(VerificationRequest::class);
    }
}
