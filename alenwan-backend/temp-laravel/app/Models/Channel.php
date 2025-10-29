<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Channel extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'youtube_channel_id',
        'youtube_channel_url',
        'youtube_live_stream_id',
        'vimeo_channel_id',
        'vimeo_channel_url',
        'vimeo_live_event_id',
        'category_id',
        'language_id',
        'platform',
        'subscribers_count',
        'views_count',
        'videos_count',
        'is_live',
        'is_premium',
        'is_active',
        'is_featured',
        'order',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'subscribers_count' => 'integer',
        'views_count' => 'integer',
        'videos_count' => 'integer',
        'is_live' => 'boolean',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    // العلاقات
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

    public function activeLiveStreams()
    {
        return $this->hasMany(LiveStream::class)->where('is_live_now', true);
    }

    public function recordedStreams()
    {
        return $this->hasMany(LiveStream::class)->where('stream_type', 'recorded');
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

    public function getYoutubeEmbedUrl()
    {
        if ($this->youtube_live_stream_id) {
            return "https://www.youtube.com/embed/{$this->youtube_live_stream_id}";
        }
        return null;
    }

    public function getVimeoEmbedUrl()
    {
        if ($this->vimeo_live_event_id) {
            return "https://player.vimeo.com/video/{$this->vimeo_live_event_id}";
        }
        return null;
    }
}
