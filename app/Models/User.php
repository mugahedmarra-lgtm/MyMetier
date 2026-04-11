<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;


#[Fillable(['name', 'phone', 'password', 'role', 'status', 'avatar', 'last_seen_at'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isProfessional(): bool
    {
        return $this->role === 'professional';
    }

    public function isContractor(): bool
    {
        return $this->role === 'contractor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the professional profile associated with the user.
     */
    public function professionalProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProfessionalProfile::class);
    }

    /**
     * Get the reviews written by the user.
     */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the favorites created by the user.
     */
    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Check if the user has favorited a specific professional profile.
     */
    public function hasFavorited(int|string $professionalId): bool
    {
        return $this->favorites()->where('professional_profile_id', $professionalId)->exists();
    }

    /**
     * Get the public requests created by the user.
     */
    public function publicRequests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PublicRequest::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }
}
