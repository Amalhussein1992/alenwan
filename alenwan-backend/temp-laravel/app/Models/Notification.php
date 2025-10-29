<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'push_notifications';

    protected $fillable = [
        'title',
        'body',
        'image',
        'type',
        'movie_id',
        'series_id',
        'category_id',
        'url',
        'send_to_all',
        'user_ids',
        'scheduled_at',
        'sent_at',
        'is_sent',
        'sent_count',
    ];

    protected $casts = [
        'title' => 'array',
        'body' => 'array',
        'user_ids' => 'array',
        'send_to_all' => 'boolean',
        'is_sent' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
