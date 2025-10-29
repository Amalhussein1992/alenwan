<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'category_id',
        'vimeo_id',
        'vimeo_url',
        'video_url',
        'thumbnail',
        'poster',
        'duration',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'release_year',
        'rating',
        'imdb_id',
        'genres',
        'cast',
        'director',
        'is_premium',
        'is_active',
        'is_featured',
        'views_count',
    ];

    public $translatable = ['title', 'description', 'director'];

    protected $casts = [
        'genres' => 'array',
        'cast' => 'array',
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'duration' => 'integer',
        'rating' => 'decimal:1',
    ];

    // العلاقات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Helper Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function isAvailableForUser($user = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->is_premium) {
            return true;
        }

        return $user && $user->is_premium;
    }
}
