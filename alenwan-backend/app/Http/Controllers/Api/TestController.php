<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Laravel backend is connected!',
            'data' => [
                'timestamp' => now(),
                'server' => 'Laravel 12',
                'app_name' => config('app.name')
            ]
        ]);
    }

    public function movies()
    {
        // Sample movie data
        $movies = [
            [
                'id' => 1,
                'title' => 'The Great Adventure',
                'description' => 'An epic journey across the mystical lands.',
                'poster_path' => 'https://picsum.photos/300/450?random=1',
                'banner_path' => 'https://picsum.photos/800/450?random=1',
                'subscription_tier' => 'free',
                'rating' => 4.5,
                'release_year' => 2024,
                'duration_minutes' => 120,
                'category' => ['id' => 1, 'name' => 'Action'],
                'language' => ['id' => 1, 'name' => 'English'],
                'views_count' => 1500,
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'
            ],
            [
                'id' => 2,
                'title' => 'Mystery of the Lost City',
                'description' => 'A thrilling mystery that will keep you guessing.',
                'poster_path' => 'https://picsum.photos/300/450?random=2',
                'banner_path' => 'https://picsum.photos/800/450?random=2',
                'subscription_tier' => 'premium',
                'rating' => 4.8,
                'release_year' => 2024,
                'duration_minutes' => 145,
                'category' => ['id' => 2, 'name' => 'Mystery'],
                'language' => ['id' => 1, 'name' => 'English'],
                'views_count' => 2300,
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $movies
        ]);
    }

    public function subscription_plans()
    {
        $plans = [
            [
                'id' => 'free',
                'name' => 'Free',
                'price' => 0,
                'currency' => 'USD',
                'features' => [
                    'Access to free content',
                    'Basic streaming quality',
                    'Limited downloads'
                ]
            ],
            [
                'id' => 'premium',
                'name' => 'Premium',
                'price' => 19.99,
                'currency' => 'USD',
                'features' => [
                    'Access to all content',
                    'HD streaming quality',
                    'Unlimited downloads',
                    'No ads'
                ]
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $plans
        ]);
    }
}