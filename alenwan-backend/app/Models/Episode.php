<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
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
        'season_number',
        'episode_number',
        'duration_minutes',
        'air_date',
        'playback',
        'vimeo_video_id',
        'views_count',
        'series_id',
    ];

    protected $casts = [
        'playback' => 'array',
        'views_count' => 'integer',
        'season_number' => 'integer',
        'episode_number' => 'integer',
        'duration_minutes' => 'integer',
        'air_date' => 'date',
    ];

    // Relationships
    public function series()
    {
        return $this->belongsTo(Series::class);
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

    public function getEpisodeIdentifierAttribute()
    {
        return "S{$this->season_number}E{$this->episode_number}";
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeBySeason($query, $seasonNumber)
    {
        return $query->where('season_number', $seasonNumber);
    }

    public function scopeOrderedByEpisode($query)
    {
        return $query->orderBy('season_number')->orderBy('episode_number');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('air_date', 'desc');
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getNextEpisode()
    {
        return Episode::where('series_id', $this->series_id)
            ->where(function($query) {
                $query->where('season_number', '>', $this->season_number)
                      ->orWhere(function($q) {
                          $q->where('season_number', $this->season_number)
                            ->where('episode_number', '>', $this->episode_number);
                      });
            })
            ->orderBy('season_number')
            ->orderBy('episode_number')
            ->first();
    }

    public function getPreviousEpisode()
    {
        return Episode::where('series_id', $this->series_id)
            ->where(function($query) {
                $query->where('season_number', '<', $this->season_number)
                      ->orWhere(function($q) {
                          $q->where('season_number', $this->season_number)
                            ->where('episode_number', '<', $this->episode_number);
                      });
            })
            ->orderBy('season_number', 'desc')
            ->orderBy('episode_number', 'desc')
            ->first();
    }
}