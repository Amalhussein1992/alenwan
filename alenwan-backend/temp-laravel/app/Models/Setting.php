<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'label',
        'description',
        'group',
        'order',
    ];

    protected $casts = [
        'label' => 'array',
        'description' => 'array',
    ];
}
