<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'city_id',
        'district_id',
        'title',
        'description',
        'status',
    ];

    /**
     * Helper method to check if the request is open.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Helper method to check if the request is closed.
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Scope a query to only include open requests.
     */
    public function scopeOpen(Builder $query): void
    {
        $query->where('status', 'open');
    }

    /**
     * Scope a query to order the requests by latest.
     */
    public function scopeLatest(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }

    /**
     * Relationship: PublicRequest belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: PublicRequest belongs to a Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: PublicRequest belongs to a City.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relationship: PublicRequest belongs to a District.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Relationship: Public Request has many Polymorphic Reports.
     */
    public function reports(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
