<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Podcast extends Model
{
    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'poster',
        'audio_url',
        'video_url',
        'duration',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'category_id',
        'language_id',
        'host',
        'host_ar',
        'release_date',
        'season_number',
        'episode_number',
        'is_premium',
        'is_published',
        'views_count',
        'likes_count',
    ];

    protected $casts = [
        'release_date' => 'date',
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
        'duration' => 'integer',
        'season_number' => 'integer',
        'episode_number' => 'integer',
        'views_count' => 'integer',
        'likes_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
