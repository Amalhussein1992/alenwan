<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'duration_days',
        'duration_months',
        'features',
        'is_popular',
        'is_active',
        'stripe_price_id',
        'paypal_plan_id',
        'paymob_plan_id',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'duration_months' => 'integer',
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
