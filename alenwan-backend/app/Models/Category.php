<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}