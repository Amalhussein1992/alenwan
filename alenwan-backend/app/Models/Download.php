<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'downloadable_type',
        'downloadable_id',
        'file_path',
        'file_size',
        'status',
        'progress',
        'downloaded_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'progress' => 'integer',
        'downloaded_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function downloadable()
    {
        return $this->morphTo();
    }

    // Accessors
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    public function getIsFailedAttribute()
    {
        return $this->status === 'failed';
    }

    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    public function getIsDownloadingAttribute()
    {
        return $this->status === 'downloading';
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDownloading($query)
    {
        return $query->where('status', 'downloading');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('downloadable_type', $type);
    }

    public function scopeMovies($query)
    {
        return $query->where('downloadable_type', Movie::class);
    }

    public function scopeEpisodes($query)
    {
        return $query->where('downloadable_type', Episode::class);
    }

    public function scopeSports($query)
    {
        return $query->where('downloadable_type', Sport::class);
    }

    public function scopeCartoons($query)
    {
        return $query->where('downloadable_type', Cartoon::class);
    }

    public function scopeDocumentaries($query)
    {
        return $query->where('downloadable_type', Documentary::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
            'downloaded_at' => now(),
        ]);
    }

    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }

    public function updateProgress($progress)
    {
        $this->update([
            'progress' => min(100, max(0, $progress)),
            'status' => $progress >= 100 ? 'completed' : 'downloading',
        ]);

        if ($progress >= 100) {
            $this->update(['downloaded_at' => now()]);
        }
    }
}