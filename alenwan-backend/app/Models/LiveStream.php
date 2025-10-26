<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'youtube_stream_key',
        'youtube_video_id',
        'stream_url',
        'status',
        'scheduled_start',
        'actual_start',
        'actual_end',
        'viewers_count',
        'max_viewers',
        'channel_id',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'viewers_count' => 'integer',
        'max_viewers' => 'integer',
    ];

    // Relationships
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    // Accessors
    public function getIsLiveAttribute()
    {
        return $this->status === 'live';
    }

    public function getIsScheduledAttribute()
    {
        return $this->status === 'scheduled';
    }

    public function getIsEndedAttribute()
    {
        return $this->status === 'ended';
    }

    public function getDurationAttribute()
    {
        if (!$this->actual_start || !$this->actual_end) {
            return null;
        }

        return $this->actual_end->diffInMinutes($this->actual_start);
    }

    public function getYoutubeWatchUrlAttribute()
    {
        if (!$this->youtube_video_id) {
            return null;
        }

        return "https://www.youtube.com/watch?v={$this->youtube_video_id}";
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_video_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->youtube_video_id}";
    }

    // Scopes
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
                     ->where('scheduled_start', '>', now());
    }

    public function scopeStartingSoon($query, $minutes = 30)
    {
        return $query->where('status', 'scheduled')
                     ->whereBetween('scheduled_start', [now(), now()->addMinutes($minutes)]);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('scheduled_start', 'desc');
    }

    // Methods
    public function startStream()
    {
        $this->update([
            'status' => 'live',
            'actual_start' => now(),
        ]);

        $this->channel->setLiveStatus(true);
    }

    public function endStream()
    {
        $this->update([
            'status' => 'ended',
            'actual_end' => now(),
        ]);

        $this->channel->setLiveStatus(false);
    }

    public function incrementViewers()
    {
        $this->increment('viewers_count');

        if ($this->viewers_count > $this->max_viewers) {
            $this->update(['max_viewers' => $this->viewers_count]);
        }
    }

    public function decrementViewers()
    {
        if ($this->viewers_count > 0) {
            $this->decrement('viewers_count');
        }
    }
}