<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'flag_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function series()
    {
        return $this->hasMany(Series::class);
    }

    public function sports()
    {
        return $this->hasMany(Sport::class);
    }

    public function cartoons()
    {
        return $this->hasMany(Cartoon::class);
    }

    public function documentaries()
    {
        return $this->hasMany(Documentary::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}