<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Season extends Model
{
    use HasTranslations;

    protected $fillable = [
        'series_id',
        'title',
        'description',
        'season_number',
        'thumbnail',
        'release_year',
        'is_active',
        'order',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'is_active' => 'boolean',
        'season_number' => 'integer',
        'order' => 'integer',
    ];

    // العلاقات
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number');
    }
}
