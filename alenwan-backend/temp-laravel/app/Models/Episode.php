<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Episode extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'season_id',
        'title',
        'description',
        'episode_number',
        'vimeo_id',
        'vimeo_url',
        'video_url',
        'thumbnail',
        'duration',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'release_date',
        'is_active',
        'views_count',
        'order',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'is_active' => 'boolean',
        'episode_number' => 'integer',
        'duration' => 'integer',
        'views_count' => 'integer',
        'order' => 'integer',
        'release_date' => 'date',
    ];

    // العلاقات
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function series()
    {
        return $this->hasOneThrough(Series::class, Season::class, 'id', 'id', 'season_id', 'series_id');
    }

    // Helper Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
