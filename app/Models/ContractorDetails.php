<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractorDetails extends Model
{
    protected $fillable = [
        'professional_profile_id',
        'business_name',
        'contractor_type',
        'team_size',
    ];

    /**
     * Get the professional profile that owns this contractor detail.
     */
    public function professionalProfile(): BelongsTo
    {
        return $this->belongsTo(ProfessionalProfile::class);
    }
}
