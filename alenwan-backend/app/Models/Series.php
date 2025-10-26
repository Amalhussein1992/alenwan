<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'poster_url',
        'trailer_url',
        'status',
        'release_year',
        'rating',
        'imdb_rating',
        'subscription_tier',
        'cast',
        'genres',
        'views',
        'is_featured',
        'category_id',
        'language_id',
    ];

    protected $casts = [
        'cast' => 'array',
        'genres' => 'array',
        'rating' => 'decimal:1',
        'imdb_rating' => 'decimal:1',
        'views' => 'integer',
        'is_featured' => 'boolean',
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

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    // Accessors
    public function getLatestEpisodeAttribute()
    {
        return $this->episodes()->latest()->first();
    }

    public function getAvailableEpisodesAttribute()
    {
        return $this->episodes()->published()->count();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
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

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeHighRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Accessors for backward compatibility
    public function getPosterPathAttribute()
    {
        return $this->attributes['poster_url'] ?? '';
    }

    public function getViewsCountAttribute()
    {
        return $this->attributes['views'] ?? 0;
    }
}