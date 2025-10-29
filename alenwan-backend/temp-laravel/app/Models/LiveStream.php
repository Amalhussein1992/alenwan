<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class LiveStream extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'poster',
        'channel_id',
        'youtube_video_id',
        'youtube_embed_url',
        'youtube_watch_url',
        'vimeo_video_id',
        'vimeo_embed_url',
        'vimeo_player_url',
        'stream_url',
        'category_id',
        'language_id',
        'platform',
        'stream_type',
        'duration',
        'has_audio_translation',
        'audio_languages',
        'default_audio_language',
        'scheduled_start_time',
        'actual_start_time',
        'end_time',
        'views_count',
        'likes_count',
        'concurrent_viewers',
        'peak_viewers',
        'is_live_now',
        'is_premium',
        'is_published',
        'is_featured',
        'enable_chat',
        'enable_notifications',
        'tags',
        'meta_title',
        'meta_description',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'duration' => 'integer',
        'audio_languages' => 'array',
        'has_audio_translation' => 'boolean',
        'scheduled_start_time' => 'datetime',
        'actual_start_time' => 'datetime',
        'end_time' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'concurrent_viewers' => 'integer',
        'peak_viewers' => 'integer',
        'is_live_now' => 'boolean',
        'is_premium' => 'boolean',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'enable_chat' => 'boolean',
        'enable_notifications' => 'boolean',
        'tags' => 'array',
    ];

    // العلاقات
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    // Helper Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function isAvailableForUser($user = null)
    {
        if (!$this->is_published) {
            return false;
        }

        if (!$this->is_premium) {
            return true;
        }

        return $user && $user->is_premium;
    }

    public function getEmbedUrl()
    {
        if ($this->platform === 'youtube' && $this->youtube_video_id) {
            return $this->youtube_embed_url ?: "https://www.youtube.com/embed/{$this->youtube_video_id}";
        }

        if ($this->platform === 'vimeo' && $this->vimeo_video_id) {
            return $this->vimeo_embed_url ?: "https://player.vimeo.com/video/{$this->vimeo_video_id}";
        }

        return $this->stream_url;
    }

    public function getWatchUrl()
    {
        if ($this->platform === 'youtube' && $this->youtube_video_id) {
            return $this->youtube_watch_url ?: "https://www.youtube.com/watch?v={$this->youtube_video_id}";
        }

        if ($this->platform === 'vimeo' && $this->vimeo_video_id) {
            return $this->vimeo_player_url ?: "https://vimeo.com/{$this->vimeo_video_id}";
        }

        return $this->stream_url;
    }

    public function isLive()
    {
        return $this->is_live_now && $this->stream_type === 'live';
    }

    public function isUpcoming()
    {
        return $this->stream_type === 'upcoming' && $this->scheduled_start_time > now();
    }

    public function isRecorded()
    {
        return $this->stream_type === 'recorded';
    }

    // Scopes
    public function scopeLive($query)
    {
        return $query->where('is_live_now', true)->where('stream_type', 'live');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('stream_type', 'upcoming')->where('scheduled_start_time', '>', now());
    }

    public function scopeRecorded($query)
    {
        return $query->where('stream_type', 'recorded');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
