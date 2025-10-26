<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_name',
        'device_type',
        'platform',
        'app_version',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getLastUsedHumanAttribute()
    {
        return $this->last_used_at?->diffForHumans();
    }

    public function getDeviceIconAttribute()
    {
        return match($this->device_type) {
            'mobile' => 'smartphone',
            'tablet' => 'tablet',
            'desktop' => 'computer',
            'tv' => 'tv',
            default => 'device_unknown'
        };
    }

    public function getDeviceDisplayNameAttribute()
    {
        return "{$this->device_name} ({$this->platform})";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('device_type', $type);
    }

    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeRecentlyUsed($query)
    {
        return $query->orderBy('last_used_at', 'desc');
    }

    public function scopeStaleDevices($query, $days = 30)
    {
        return $query->where('last_used_at', '<', now()->subDays($days));
    }

    // Methods
    public function updateLastUsed()
    {
        $this->update(['last_used_at' => now()]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function isStale($days = 30)
    {
        return $this->last_used_at < now()->subDays($days);
    }
}