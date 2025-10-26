<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'cover_image',
        'audio_path',
        'status',
        'duration_seconds',
        'release_date',
        'host',
        'guests',
        'tags',
        'plays_count',
        'likes_count',
        'season_number',
        'episode_number',
        'category_id',
        'language_id',
    ];

    protected $casts = [
        'guests' => 'array',
        'tags' => 'array',
        'plays_count' => 'integer',
        'likes_count' => 'integer',
        'release_date' => 'date',
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

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('plays_count', 'desc');
    }

    // Methods
    public function incrementPlays()
    {
        $this->increment('plays_count');
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    // Accessor for formatted duration
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_seconds) {
            return '0:00';
        }

        $hours = floor($this->duration_seconds / 3600);
        $minutes = floor(($this->duration_seconds % 3600) / 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
