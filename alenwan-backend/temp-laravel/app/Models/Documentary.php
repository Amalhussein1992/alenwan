<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documentary extends Model
{
    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'poster',
        'video_url',
        'duration',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'year',
        'category_id',
        'language_id',
        'director',
        'director_ar',
        'producer',
        'producer_ar',
        'release_date',
        'rating',
        'is_premium',
        'is_published',
        'views_count',
        'likes_count',
    ];

    protected $casts = [
        'release_date' => 'date',
        'year' => 'integer',
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
        'duration' => 'integer',
        'rating' => 'decimal:1',
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
