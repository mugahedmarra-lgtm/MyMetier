<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'professional_profile_id',
        'rating',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * The "booted" method of the model.
     * Hooks for rating calculations and business rules.
     */
    protected static function booted(): void
    {
        static::creating(function (Review $review) {
            // Business Rule: user cannot review himself
            $professional = ProfessionalProfile::find($review->professional_profile_id);
            if ($professional && $professional->user_id === $review->user_id) {
                throw new \Exception("A user cannot review their own professional profile.");
            }
        });

        // Event hooks to update rating statistics when review changes
        static::saved(function (Review $review) {
            static::updateProfessionalRatings($review->professional_profile_id);
        });

        static::deleted(function (Review $review) {
            static::updateProfessionalRatings($review->professional_profile_id);
        });

        static::restored(function (Review $review) {
            static::updateProfessionalRatings($review->professional_profile_id);
        });
    }

    /**
     * Calculate and update rating_avg and rating_count on professional profile.
     */
    public static function updateProfessionalRatings(int|string $professionalProfileId): void
    {
        $stats = static::where('professional_profile_id', $professionalProfileId)
            ->selectRaw('count(id) as total_reviews, avg(rating) as average_rating')
            ->first();

        ProfessionalProfile::where('id', $professionalProfileId)->update([
            'rating_count' => $stats->total_reviews ?? 0,
            'rating_avg' => $stats->average_rating ? round($stats->average_rating, 2) : 0,
        ]);
    }

    /**
     * Relationship: Review belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Review belongs to a Professional Profile.
     */
    public function professionalProfile(): BelongsTo
    {
        return $this->belongsTo(ProfessionalProfile::class);
    }

    /**
     * Relationship: Review has many Polymorphic Reports.
     */
    public function reports(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
