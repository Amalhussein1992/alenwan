<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'banner_path',
        'status',
        'subscription_tier',
        'is_live',
        'category_id',
        'language_id',
        'sort_order',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function liveStreams()
    {
        return $this->hasMany(LiveStream::class);
    }

    public function currentLiveStream()
    {
        return $this->hasOne(LiveStream::class)->where('status', 'live');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLive($query)
    {
        return $query->where('is_live', true);
    }

    public function scopeForSubscriptionTier($query, $tier)
    {
        $tierHierarchy = ['free' => 0, 'basic' => 1, 'premium' => 2, 'platinum' => 3];
        $userLevel = $tierHierarchy[$tier] ?? 0;

        return $query->whereIn('subscription_tier', array_keys(array_filter($tierHierarchy, fn($level) => $level <= $userLevel)));
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLanguage($query, $languageId)
    {
        return $query->where('language_id', $languageId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Methods
    public function setLiveStatus($isLive)
    {
        $this->update(['is_live' => $isLive]);
    }
}