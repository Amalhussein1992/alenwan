<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sport extends Model
{
    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'poster',
        'video_url',
        'stream_url',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'category_id',
        'language_id',
        'sport_type',
        'league',
        'league_ar',
        'teams',
        'teams_ar',
        'match_date',
        'venue',
        'venue_ar',
        'is_live',
        'is_premium',
        'is_published',
        'views_count',
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'is_live' => 'boolean',
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
        'views_count' => 'integer',
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
