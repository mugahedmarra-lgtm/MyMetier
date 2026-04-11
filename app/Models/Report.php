<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
        'reason',
        'description',
        'status',
    ];

    /**
     * The "booted" method of the model.
     * Hooks for business rules.
     */
    protected static function booted(): void
    {
        static::creating(function (Report $report) {
            // Business Rule: user cannot spam reports (same item repeatedly)
            // Prevent if the user already has a pending or reviewing report for this exact item
            $existingReport = static::where('user_id', $report->user_id)
                ->where('reportable_id', $report->reportable_id)
                ->where('reportable_type', $report->reportable_type)
                ->whereIn('status', ['pending', 'reviewing'])
                ->exists();

            if ($existingReport) {
                throw new \Exception("You have already reported this item and it is under review.");
            }
        });
    }

    /**
     * Helper method to check if the report is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Helper method to check if the report is resolved.
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    /**
     * Helper method to check if the report is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Relationship: Report belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Polymorphic relation to the reported model.
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
