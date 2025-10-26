<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'poster_path',
        'video_path',
        'status',
        'subscription_tier',
        'release_year',
        'duration_minutes',
        'director',
        'topics',
        'playback',
        'vimeo_video_id',
        'views_count',
        'category_id',
        'language_id',
    ];

    protected $casts = [
        'topics' => 'array',
        'playback' => 'array',
        'views_count' => 'integer',
        'duration_minutes' => 'integer',
        'release_year' => 'integer',
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

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }

    // Accessors
    public function getHlsUrlAttribute()
    {
        return $this->playback['hls'] ?? '';
    }

    public function getMp4UrlAttribute()
    {
        return $this->playback['mp4'] ?? '';
    }

    public function getBestPlayableUrlAttribute()
    {
        $raw = $this->video_path ?? '';
        $hls = $this->hls_url;
        $mp4 = $this->mp4_url;

        $urls = [$mp4, $hls, $raw];
        return collect($urls)->filter()->first() ?? '';
    }

    public function getHasVideoAttribute()
    {
        return !empty($this->hls_url) || !empty($this->mp4_url) || !empty($this->video_path);
    }

    public function getTopicsListAttribute()
    {
        return collect($this->topics)->implode(', ');
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

    public function scopeByDirector($query, $director)
    {
        return $query->where('director', 'like', "%{$director}%");
    }

    public function scopeByTopic($query, $topic)
    {
        return $query->whereJsonContains('topics', $topic);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('release_year', 'desc');
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('release_year', $year);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}