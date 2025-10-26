<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\SportsController;
use App\Http\Controllers\Api\CartoonsController;
use App\Http\Controllers\Api\DocumentariesController;
use App\Http\Controllers\Api\LiveStreamController;
use App\Http\Controllers\Api\FavoritesController;
use App\Http\Controllers\Api\DownloadsController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\TapPaymentController;
use App\Http\Controllers\Api\PaymentController;

// Simple connection test route
Route::get('/test-api', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working!',
        'timestamp' => now(),
        'version' => 'v1'
    ]);
});

// Test routes for connection
Route::group(['prefix' => 'v1/test'], function () {
    Route::get('/connection', [TestController::class, 'test']);
    Route::get('/movies', [TestController::class, 'movies']);
    Route::get('/subscription-plans', [TestController::class, 'subscription_plans']);
});

// Public routes (no authentication required)
Route::group(['prefix' => 'v1'], function () {

    // Content API routes
    Route::get('/content/movies', [ContentController::class, 'getMovies']);
    Route::get('/content/series', [ContentController::class, 'getSeries']);
    Route::get('/content/live-streams', [ContentController::class, 'getLiveStreams']);
    Route::get('/content/channels', [ContentController::class, 'getChannels']);
    Route::get('/content/banners', [ContentController::class, 'getBanners']);
    Route::get('/content/categories', [ContentController::class, 'getCategories']);
    Route::get('/content/search', [ContentController::class, 'search']);

    // Authentication routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/social-login', [AuthController::class, 'socialLogin']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

    // TEMPORARY: Mock auth/me endpoint for testing (bypass Sanctum)
    Route::get('/auth/me', function (Request $request) {
        try {
            // Return mock user profile data for testing
            return response()->json([
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@alenwan.com',
                'phone' => '+970599123456',
                'role' => 'user',
                'profile_image' => 'https://ui-avatars.com/api/?name=Test+User&background=6366F1&color=fff',
                'subscription' => [
                    'is_active' => true,
                    'tier' => 'premium',
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                    'max_devices' => 3,
                ],
                'preferences' => [
                    'language' => 'ar',
                    'notifications' => true,
                    'auto_play' => true,
                ],
                'created_at' => date('Y-m-d H:i:s', strtotime('-60 days')),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    });

    // Public content routes (limited access for non-authenticated users)
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);
    Route::get('/movies/featured', [MovieController::class, 'featured']);
    Route::get('/movies/trending', [MovieController::class, 'trending']);
    Route::get('/movies/recent', [MovieController::class, 'recent']);
    Route::get('/movies/category/{categoryId}', [MovieController::class, 'byCategory']);
    Route::get('/movies/categories', [MovieController::class, 'categories']);
    Route::get('/movies/languages', [MovieController::class, 'languages']);

    Route::get('/series', [SeriesController::class, 'index']);
    Route::get('/series/{id}', [SeriesController::class, 'show']);
    Route::get('/series/{id}/episodes', [SeriesController::class, 'episodes']);
    Route::get('/series/{seriesId}/episodes/{episodeId}', [SeriesController::class, 'episode']);
    Route::get('/series/featured', [SeriesController::class, 'featured']);
    Route::get('/series/trending', [SeriesController::class, 'trending']);
    Route::get('/series/recent', [SeriesController::class, 'recent']);
    Route::get('/series/category/{categoryId}', [SeriesController::class, 'byCategory']);
    Route::get('/series/categories', [SeriesController::class, 'categories']);
    Route::get('/series/languages', [SeriesController::class, 'languages']);

    Route::get('/sports', [SportsController::class, 'index']);
    Route::get('/sports/{id}', [SportsController::class, 'show']);
    Route::get('/sports/live', [SportsController::class, 'live']);
    Route::get('/sports/upcoming', [SportsController::class, 'upcoming']);
    Route::get('/sports/featured', [SportsController::class, 'featured']);
    Route::get('/sports/category/{categoryId}', [SportsController::class, 'byCategory']);
    Route::get('/sports/categories', [SportsController::class, 'categories']);
    Route::get('/sports/languages', [SportsController::class, 'languages']);
    Route::get('/sports/match-types', [SportsController::class, 'matchTypes']);

    Route::get('/cartoons', [CartoonsController::class, 'index']);
    Route::get('/cartoons/{id}', [CartoonsController::class, 'show']);
    Route::get('/cartoons/featured', [CartoonsController::class, 'featured']);
    Route::get('/cartoons/recent', [CartoonsController::class, 'recent']);
    Route::get('/cartoons/category/{categoryId}', [CartoonsController::class, 'byCategory']);
    Route::get('/cartoons/age-rating/{ageRating}', [CartoonsController::class, 'byAgeRating']);
    Route::get('/cartoons/categories', [CartoonsController::class, 'categories']);
    Route::get('/cartoons/languages', [CartoonsController::class, 'languages']);
    Route::get('/cartoons/age-ratings', [CartoonsController::class, 'ageRatings']);

    Route::get('/documentaries', [DocumentariesController::class, 'index']);
    Route::get('/documentaries/{id}', [DocumentariesController::class, 'show']);
    Route::get('/documentaries/featured', [DocumentariesController::class, 'featured']);
    Route::get('/documentaries/recent', [DocumentariesController::class, 'recent']);
    Route::get('/documentaries/category/{categoryId}', [DocumentariesController::class, 'byCategory']);
    Route::get('/documentaries/director/{director}', [DocumentariesController::class, 'byDirector']);
    Route::get('/documentaries/topic/{topic}', [DocumentariesController::class, 'byTopic']);
    Route::get('/documentaries/categories', [DocumentariesController::class, 'categories']);
    Route::get('/documentaries/languages', [DocumentariesController::class, 'languages']);
    Route::get('/documentaries/directors', [DocumentariesController::class, 'directors']);
    Route::get('/documentaries/topics', [DocumentariesController::class, 'topics']);

    Route::get('/live/channels', [LiveStreamController::class, 'channels']);
    Route::get('/live/channels/{id}', [LiveStreamController::class, 'channel']);
    Route::get('/live/streams', [LiveStreamController::class, 'liveStreams']);
    Route::get('/live/upcoming', [LiveStreamController::class, 'upcomingStreams']);
    Route::get('/live/streams/{streamId}', [LiveStreamController::class, 'stream']);
    Route::get('/live/channels/{channelId}/schedule', [LiveStreamController::class, 'channelSchedule']);
    Route::get('/live/categories', [LiveStreamController::class, 'categories']);
    Route::get('/live/languages', [LiveStreamController::class, 'languages']);

    Route::get('/subscription/plans', [SubscriptionController::class, 'plans']);

    // Tap Payments - Webhook (public endpoint)
    Route::post('/payment/tap/webhook', [TapPaymentController::class, 'webhook']);

    // Coupon Validation
    Route::post('/coupon/validate', function (Request $request) {
        $couponCode = strtoupper($request->code);
        $validCoupons = [
            'WELCOME50' => ['discount' => 50, 'type' => 'percentage'],
            'SUMMER2024' => ['discount' => 10, 'type' => 'fixed'],
            'FREETRIAL7' => ['discount' => 7, 'type' => 'free_days'],
        ];

        if (isset($validCoupons[$couponCode])) {
            return response()->json([
                'success' => true,
                'valid' => true,
                'coupon' => array_merge(['code' => $couponCode], $validCoupons[$couponCode]),
                'message' => 'Coupon applied successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'valid' => false,
            'message' => 'Invalid or expired coupon code'
        ], 400);
    });

    // Vimeo Integration
    Route::get('/vimeo/video/{id}', function ($id) {
        return response()->json([
            'success' => true,
            'data' => [
                'vimeo_id' => $id,
                'stream_url' => "https://player.vimeo.com/video/{$id}",
                'download_url' => null,
                'qualities' => ['360p', '540p', '720p', '1080p', '4K'],
                'subtitles' => [
                    'en' => "https://vimeo.com/subtitles/{$id}/en.vtt",
                    'ar' => "https://vimeo.com/subtitles/{$id}/ar.vtt",
                ],
                'audio_tracks' => [
                    'en' => "https://vimeo.com/audio/{$id}/en.mp3",
                    'ar' => "https://vimeo.com/audio/{$id}/ar.mp3",
                ]
            ]
        ]);
    });

    // Audio Translations
    Route::get('/content/audio/{contentId}/{language}', function ($contentId, $language) {
        return response()->json([
            'success' => true,
            'data' => [
                'content_id' => $contentId,
                'language' => $language,
                'audio_url' => "https://cdn.alenwan.com/audio/{$contentId}_{$language}.mp3",
                'duration' => 7200,
                'voice_type' => 'neural',
                'generated_at' => now()->toIso8601String(),
            ]
        ]);
    });

    // Language Support with RTL
    Route::get('/languages', function () {
        return response()->json([
            'success' => true,
            'data' => [
                ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_rtl' => false, 'is_default' => true],
                ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية', 'is_rtl' => true, 'is_default' => false],
                ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_rtl' => false, 'is_default' => false],
                ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_rtl' => false, 'is_default' => false],
                ['code' => 'he', 'name' => 'Hebrew', 'native_name' => 'עברית', 'is_rtl' => true, 'is_default' => false],
                ['code' => 'fa', 'name' => 'Persian', 'native_name' => 'فارسی', 'is_rtl' => true, 'is_default' => false],
            ]
        ]);
    });

    // App Configuration for Flutter
    Route::get('/app/config', function (Request $request) {
        $language = $request->header('Accept-Language', 'en');
        return response()->json([
            'success' => true,
            'data' => [
                'app_version' => '2.0.0',
                'force_update' => false,
                'maintenance_mode' => false,
                'features' => [
                    'google_pay' => true,
                    'apple_pay' => true,
                    'audio_translations' => true,
                    'offline_download' => true,
                    'live_streaming' => true,
                    'vimeo_integration' => true,
                ],
                'payment_methods' => [
                    'google_pay' => ['enabled' => true, 'merchant_id' => 'BCR2DN4T...'],
                    'apple_pay' => ['enabled' => true, 'merchant_id' => 'merchant.com.alenwan'],
                ],
                'vimeo_config' => [
                    'player_url' => 'https://player.vimeo.com',
                    'api_url' => 'https://api.vimeo.com',
                ],
                'default_language' => $language,
                'is_rtl' => in_array($language, ['ar', 'he', 'fa']),
            ]
        ]);
    });

    // Google Sign-In
    Route::post('/auth/google', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Google sign-in successful',
            'user' => [
                'id' => 'user_google_' . uniqid(),
                'name' => $request->name,
                'email' => $request->email,
                'profile_picture' => $request->photo_url,
                'provider' => 'google',
                'language' => $request->language ?? 'en',
                'is_rtl' => in_array($request->language ?? 'en', ['ar', 'he', 'fa']),
            ],
            'token' => 'Bearer ' . bin2hex(random_bytes(32))
        ]);
    });

    // Apple Sign-In
    Route::post('/auth/apple', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Apple sign-in successful',
            'user' => [
                'id' => 'user_apple_' . uniqid(),
                'name' => $request->name,
                'email' => $request->email,
                'provider' => 'apple',
                'language' => $request->language ?? 'en',
                'is_rtl' => in_array($request->language ?? 'en', ['ar', 'he', 'fa']),
            ],
            'token' => 'Bearer ' . bin2hex(random_bytes(32))
        ]);
    });
});

// Protected routes (authentication required)
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    // Authentication routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    // Route::get('/auth/me', [AuthController::class, 'me']); // DISABLED: Using mock endpoint in public routes for testing
    Route::post('/auth/refresh-token', [AuthController::class, 'refreshToken']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::put('/auth/password', [AuthController::class, 'changePassword']);
    Route::delete('/auth/devices/{deviceId}', [AuthController::class, 'removeDevice']);

    // Streaming and download routes
    Route::get('/movies/{id}/stream', [MovieController::class, 'getStreamingUrl']);
    Route::post('/movies/{id}/download', [MovieController::class, 'downloadLink']);
    Route::post('/movies/{id}/favorite', [MovieController::class, 'toggleFavorite']);

    Route::get('/series/{seriesId}/episodes/{episodeId}/stream', [SeriesController::class, 'getStreamingUrl']);
    Route::post('/series/{seriesId}/episodes/{episodeId}/download', [SeriesController::class, 'downloadLink']);
    Route::post('/series/{id}/favorite', [SeriesController::class, 'toggleFavorite']);

    Route::get('/sports/{id}/stream', [SportsController::class, 'getStreamingUrl']);
    Route::post('/sports/{id}/download', [SportsController::class, 'downloadLink']);
    Route::post('/sports/{id}/favorite', [SportsController::class, 'toggleFavorite']);

    Route::get('/cartoons/{id}/stream', [CartoonsController::class, 'getStreamingUrl']);
    Route::post('/cartoons/{id}/download', [CartoonsController::class, 'downloadLink']);
    Route::post('/cartoons/{id}/favorite', [CartoonsController::class, 'toggleFavorite']);

    Route::get('/documentaries/{id}/stream', [DocumentariesController::class, 'getStreamingUrl']);
    Route::post('/documentaries/{id}/download', [DocumentariesController::class, 'downloadLink']);
    Route::post('/documentaries/{id}/favorite', [DocumentariesController::class, 'toggleFavorite']);

    // Tap Payment Routes (UAE - Apple Pay, Google Pay, Cards)
    Route::post('/payment/tap/charge', [TapPaymentController::class, 'createCharge']);
    Route::post('/payment/tap/tokenize-card', [TapPaymentController::class, 'tokenizeCard']);
    Route::post('/payment/tap/verify', [TapPaymentController::class, 'verifyPayment']);
    Route::get('/payment/tap/plans', [TapPaymentController::class, 'getPlans']);
    Route::get('/payment/tap/saved-cards', [TapPaymentController::class, 'getSavedCards']);

    // Legacy Payment Routes
    Route::post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent']);
    Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment']);
    Route::get('/payment/history', [PaymentController::class, 'getPaymentHistory']);
    Route::post('/subscription/cancel', [PaymentController::class, 'cancelSubscription']);

    // Live streaming routes
    Route::get('/live/streams/{streamId}/stream', [LiveStreamController::class, 'getStreamingUrl']);
    Route::post('/live/streams/{streamId}/join', [LiveStreamController::class, 'joinStream']);
    Route::post('/live/streams/{streamId}/leave', [LiveStreamController::class, 'leaveStream']);
    Route::post('/live/channels/{channelId}/favorite', [LiveStreamController::class, 'toggleFavoriteChannel']);

    // Favorites management
    Route::get('/favorites', [FavoritesController::class, 'index']);
    Route::get('/favorites/{type}', [FavoritesController::class, 'byType']);
    Route::get('/favorites/stats', [FavoritesController::class, 'stats']);
    Route::delete('/favorites/{id}', [FavoritesController::class, 'remove']);
    Route::delete('/favorites', [FavoritesController::class, 'clear']);

    // Downloads management
    Route::get('/downloads', [DownloadsController::class, 'index']);
    Route::get('/downloads/{id}', [DownloadsController::class, 'show']);
    Route::put('/downloads/{id}/progress', [DownloadsController::class, 'updateProgress']);
    Route::post('/downloads/{id}/retry', [DownloadsController::class, 'retry']);
    Route::post('/downloads/{id}/cancel', [DownloadsController::class, 'cancel']);
    Route::delete('/downloads/{id}', [DownloadsController::class, 'delete']);
    Route::get('/downloads/stats', [DownloadsController::class, 'stats']);
    Route::delete('/downloads/completed', [DownloadsController::class, 'clearCompleted']);
    Route::delete('/downloads/failed', [DownloadsController::class, 'clearFailed']);

    // Subscription management
    Route::get('/subscription/current', [SubscriptionController::class, 'current']);
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgrade']);
    Route::post('/subscription/validate-access', [SubscriptionController::class, 'validateAccess']);
    Route::get('/subscription/history', [SubscriptionController::class, 'history']);
});

// Backward compatibility routes (without /v1/ prefix)
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/series', [SeriesController::class, 'index']);
Route::get('/sports', [SportsController::class, 'index']);
Route::get('/cartoons', [CartoonsController::class, 'index']);
Route::get('/documentaries', [DocumentariesController::class, 'index']);

// Additional backward compatibility routes
Route::get('/livestreams', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => [
            'current_page' => 1,
            'data' => [],
            'total' => 0
        ]
    ]);
});

Route::get('/channels', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => []
    ]);
});

Route::get('/subscriptions', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => []
    ]);
});

Route::get('/recommendations/{userId}', function (Request $request, $userId) {
    return response()->json([
        'status' => 'success',
        'data' => []
    ]);
});

// Video Banner API
Route::get('/video-banner/active', function (Request $request) {
    try {
        $db = new PDO('sqlite:' . database_path('database.sqlite'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->query("
            SELECT * FROM video_banners
            WHERE is_active = 1
            ORDER BY priority DESC
            LIMIT 5
        ");

        $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return response()->json([
            'status' => 'success',
            'data' => $banners
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Recent Items API
Route::get('/recent-items', function (Request $request) {
    try {
        $db = new PDO('sqlite:' . database_path('database.sqlite'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get mix of recent content from all categories
        $recentMovies = $db->query("
            SELECT *, 'movie' as content_type FROM movies
            ORDER BY created_at DESC LIMIT 3
        ")->fetchAll(PDO::FETCH_ASSOC);

        $recentSeries = $db->query("
            SELECT *, 'series' as content_type FROM series
            ORDER BY created_at DESC LIMIT 2
        ")->fetchAll(PDO::FETCH_ASSOC);

        $recentContent = array_merge($recentMovies, $recentSeries);

        return response()->json([
            'status' => 'success',
            'data' => $recentContent
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Platinum/Premium Content API
Route::get('/platinum', function (Request $request) {
    try {
        $db = new PDO('sqlite:' . database_path('database.sqlite'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get premium content from all categories
        $premiumMovies = $db->query("
            SELECT *, 'movie' as content_type FROM movies
            WHERE subscription_tier IN ('premium', 'platinum')
            ORDER BY rating DESC LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);

        $premiumSeries = $db->query("
            SELECT *, 'series' as content_type FROM series
            WHERE subscription_tier IN ('premium', 'platinum')
            ORDER BY rating DESC LIMIT 3
        ")->fetchAll(PDO::FETCH_ASSOC);

        $premiumContent = array_merge($premiumMovies, $premiumSeries);

        return response()->json([
            'status' => 'success',
            'data' => $premiumContent
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// User Profile API
Route::get('/profile', function (Request $request) {
    try {
        // Return mock profile data for testing
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => 2,
                'name' => 'Test User',
                'email' => 'test@alenwan.com',
                'role' => 'user',
                'profile_image' => 'https://ui-avatars.com/api/?name=Test+User',
                'subscription_tier' => 'premium',
                'subscription_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'is_active' => true,
                'max_devices' => 3,
                'preferences' => json_encode(['language' => 'ar', 'notifications' => true]),
                'has_active_subscription' => true,
            ]
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Enhanced Recommendations API (AI-like based on user behavior)
Route::get('/smart-recommendations', function (Request $request) {
    try {
        $db = new PDO('sqlite:' . database_path('database.sqlite'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get highly rated content (simulating AI recommendations)
        $recommendations = [];

        // Top rated movies
        $topMovies = $db->query("
            SELECT *, 'movie' as content_type FROM movies
            WHERE rating >= 8.0
            ORDER BY rating DESC, views DESC
            LIMIT 4
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Top rated series
        $topSeries = $db->query("
            SELECT *, 'series' as content_type FROM series
            WHERE rating >= 8.0
            ORDER BY rating DESC
            LIMIT 3
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Featured content
        $featured = $db->query("
            SELECT *, 'featured' as content_type FROM movies
            WHERE is_featured = 1
            ORDER BY views DESC
            LIMIT 3
        ")->fetchAll(PDO::FETCH_ASSOC);

        $recommendations = [
            'top_picks' => array_merge($topMovies, $topSeries),
            'featured' => $featured,
            'trending' => $topMovies // Using top movies as trending for now
        ];

        return response()->json([
            'status' => 'success',
            'data' => $recommendations
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// My Subscription API - Get current user's subscription details
Route::get('/my-subscription', function (Request $request) {
    try {
        // For now, return mock subscription data for testing
        // In production, this would verify the token and get real user data

        $subscriptionData = [
            'subscription_tier' => 'premium',
            'subscription_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'is_active' => true,
            'days_remaining' => 30,
            'auto_renew' => false,
            'can_upgrade' => true,
            'plan_name' => 'Premium Monthly',
            'price' => '9.99'
        ];

        return response()->json([
            'status' => 'success',
            'data' => $subscriptionData
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'API endpoint not found'
    ], 404);
});