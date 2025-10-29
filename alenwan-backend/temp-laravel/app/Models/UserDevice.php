<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'device_name',
        'device_type',
        'device_id',
        'os',
        'os_version',
        'app_version',
        'ip_address',
        'fcm_token',
        'is_active',
        'last_active_at',
        'last_login_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_active_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the user that owns the device
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only active devices
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Update last active timestamp
     */
    public function updateLastActive()
    {
        $this->update(['last_active_at' => now()]);
    }

    /**
     * Deactivate the device
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Activate the device
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Get device type icon
     */
    public function getDeviceIcon(): string
    {
        return match($this->device_type) {
            'mobile' => '📱',
            'tablet' => '📱',
            'tv' => '📺',
            'web' => '💻',
            default => '📱',
        };
    }
}
