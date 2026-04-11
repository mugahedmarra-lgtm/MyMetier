<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AnalyticsEvent extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'event_type',
        'entity_type',
        'entity_id',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
