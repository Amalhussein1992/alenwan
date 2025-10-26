<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favorable_type',
        'favorable_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('favorable_type', $type);
    }

    public function scopeMovies($query)
    {
        return $query->where('favorable_type', Movie::class);
    }

    public function scopeSeries($query)
    {
        return $query->where('favorable_type', Series::class);
    }

    public function scopeSports($query)
    {
        return $query->where('favorable_type', Sport::class);
    }

    public function scopeCartoons($query)
    {
        return $query->where('favorable_type', Cartoon::class);
    }

    public function scopeDocumentaries($query)
    {
        return $query->where('favorable_type', Documentary::class);
    }

    public function scopeChannels($query)
    {
        return $query->where('favorable_type', Channel::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}