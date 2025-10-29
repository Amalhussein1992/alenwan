<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_premium',
        'subscription_ends_at',
        'phone',
        'avatar',
        'preferred_language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_premium' => 'boolean',
            'subscription_ends_at' => 'datetime',
        ];
    }

    /**
     * Get user's devices
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Get user's active devices
     */
    public function activeDevices()
    {
        return $this->hasMany(UserDevice::class)->where('is_active', true);
    }

    /**
     * Get max allowed devices based on subscription
     */
    public function getMaxDevices(): int
    {
        return $this->is_premium ? 5 : 2; // Premium: 5 devices, Free: 2 devices
    }

    /**
     * Check if user can add more devices
     */
    public function canAddDevice(): bool
    {
        $activeDevicesCount = $this->activeDevices()->count();
        return $activeDevicesCount < $this->getMaxDevices();
    }

    /**
     * Get remaining device slots
     */
    public function getRemainingDeviceSlots(): int
    {
        $activeDevicesCount = $this->activeDevices()->count();
        return max(0, $this->getMaxDevices() - $activeDevicesCount);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->is_premium &&
               ($this->subscription_ends_at === null || $this->subscription_ends_at->isFuture());
    }
}
