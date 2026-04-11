<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'provider_type',
        'category_id',
        'city_id',
        'district_id',
        'display_name',
        'description',
        'whatsapp_number',
        'secondary_phone',
        'gender',
        'identity_number',
        'identity_image_path',
        'identity_image_public_visible',
        'availability_status',
        'verification_status',
        'gallery_limit_override',
        'profile_status',
        'admin_notes',
        'is_featured',
        'featured_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'identity_number',
        'identity_image_path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating_avg' => 'float',
            'is_featured' => 'boolean',
            'featured_until' => 'datetime',
            'identity_image_public_visible' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include profiles that should appear in search.
     */
    public function scopeSearchable(Builder $query): void
    {
        $query->where('profile_status', 'active')
              ->whereNotNull('whatsapp_number')
              ->where('whatsapp_number', '!=', '');
    }

    public function isAvailable(): bool
    {
        return $this->availability_status === 'available';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function isActive(): bool
    {
        return $this->profile_status === 'active';
    }

    public function isFeatured(): bool
    {
        return $this->is_featured && $this->featured_until && $this->featured_until->isFuture();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): ?BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Relationship: Professional Profile has many Reviews.
     */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship: Professional Profile has many Favorites.
     */
    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Check if the professional profile is favorited by a specific user.
     */
    public function isFavoritedBy(int|string $userId): bool
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Relationship: Professional Profile has many Polymorphic Reports.
     */
    public function reports(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Relationship: Professional Profile has many Gallery Images.
     */
    public function gallery(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProfessionalGallery::class);
    }

    /**
     * Check if the professional profile has any gallery images.
     */
    public function hasGallery(): bool
    {
        return $this->gallery()->exists();
    }

    /**
     * Relationship: Professional Profile has one Contractor Details extension.
     */
    public function contractorDetails(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ContractorDetails::class);
    }

    /**
     * Check if this profile belongs to a professional.
     */
    public function isProfessional(): bool
    {
        return $this->provider_type === 'professional';
    }

    /**
     * Check if this profile belongs to a contractor.
     */
    public function isContractor(): bool
    {
        return $this->provider_type === 'contractor';
    }

    /**
     * Relationship: All verification request attempts (history).
     */
    public function verificationRequests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    /**
     * Relationship: The most recent verification request.
     */
    public function latestVerificationRequest(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VerificationRequest::class)->latestOfMany();
    }

    /**
     * Check if this profile is eligible to submit a new verification request.
     *
     * Rules:
     * - profile_status must be active
     * - verification_status must be unverified
     * - no existing pending_review verification request
     */
    public function canRequestVerification(): bool
    {
        if ($this->profile_status !== 'active') {
            return false;
        }

        if ($this->verification_status === 'verified') {
            return false;
        }

        return !$this->verificationRequests()
            ->where('status', 'pending_review')
            ->exists();
    }

    /**
     * Get the final gallery image limit for this profile.
     * Priority: Override -> Verified (10) -> Unverified (3).
     */
    public function getGalleryLimit(): int
    {
        if (!is_null($this->gallery_limit_override)) {
            return (int) $this->gallery_limit_override;
        }

        return $this->isVerified() ? 10 : 3;
    }

    /**
     * Get the current count of active (non-deleted) gallery images.
     */
    public function getGalleryImagesCount(): int
    {
        return $this->gallery()->count();
    }

    /**
     * Check if the profile has reached its exact gallery limit.
     */
    public function hasReachedGalleryLimit(): bool
    {
        return $this->getGalleryImagesCount() >= $this->getGalleryLimit();
    }

    /**
     * Check if the profile is allowed to upload more gallery images.
     */
    public function canUploadMoreGalleryImages(): bool
    {
        return !$this->hasReachedGalleryLimit();
    }
}
