<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'professional_profile_id',
        'image_path',
        'title',
        'sort_order',
    ];

    /**
     * The "booted" method of the model.
     * Hooks for business rules and default ordering.
     */
    protected static function booted(): void
    {
        // Global scope: order by sort_order ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
        });
    }

    /**
     * Relationship: ProfessionalGallery belongs to a Professional Profile.
     */
    public function professionalProfile(): BelongsTo
    {
        return $this->belongsTo(ProfessionalProfile::class);
    }
}
