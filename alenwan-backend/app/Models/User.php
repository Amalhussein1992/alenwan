<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Simple token generation (alternative to Sanctum)
    public function createToken($name)
    {
        $token = Str::random(64);
        $this->update(['remember_token' => $token]);
        return (object)['plainTextToken' => $token];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
        'subscription_tier',
        'subscription_expires_at',
        'is_active',
        'max_devices',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'subscription_expires_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    // Subscription helpers
    public function hasActiveSubscription(): bool
    {
        return $this->subscription_tier !== 'free' &&
               $this->subscription_expires_at &&
               $this->subscription_expires_at->isFuture();
    }

    public function canAccessContent(string $tier): bool
    {
        $tierHierarchy = ['free' => 0, 'basic' => 1, 'premium' => 2, 'platinum' => 3];
        $userTier = $this->hasActiveSubscription() ? $this->subscription_tier : 'free';

        return ($tierHierarchy[$userTier] ?? 0) >= ($tierHierarchy[$tier] ?? 0);
    }

    public function canAddDevice(): bool
    {
        return $this->devices()->where('is_active', true)->count() < $this->max_devices;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithActiveSubscription($query)
    {
        return $query->where('subscription_tier', '!=', 'free')
                     ->where('subscription_expires_at', '>', now());
    }
}
