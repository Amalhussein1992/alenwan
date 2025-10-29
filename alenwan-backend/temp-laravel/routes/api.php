<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\AuthController;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SubscriptionPlan;

/*
|--------------------------------------------------------------------------
| API Routes - Alenwan Backend
|--------------------------------------------------------------------------
|
| Here are the API routes for the Alenwan mobile application.
| All endpoints return JSON responses with Arabic/English support.
|
*/

// ============================================
// 1. APP CONFIGURATION & SETTINGS
// ============================================

Route::prefix('config')->group(function () {
    // Get all app settings
    Route::get('/settings', function () {
        return response()->json([
            'success' => true,
            'data' => Setting::orderBy('group')->orderBy('order')->get()->groupBy('group')
        ]);
    });

    // Get languages
    Route::get('/languages', function () {
        return response()->json([
            'success' => true,
            'data' => Language::where('is_active', true)->orderBy('order')->get()
        ]);
    });

    // Get sliders/banners
    Route::get('/sliders', function () {
        return response()->json([
            'success' => true,
            'data' => Slider::where('is_active', true)
                ->orderBy('order')
                ->get(['id', 'title', 'image', 'link', 'order'])
        ]);
    });
});

// ============================================
// 2. CATEGORIES
// ============================================

Route::prefix('categories')->group(function () {
    // Get all categories
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'data' => Category::where('is_active', true)
                ->orderBy('order')
                ->get(['id', 'name_ar', 'name_en', 'slug', 'icon', 'order'])
        ]);
    });

    // Get single category
    Route::get('/{id}', function ($id) {
        $category = Category::where('is_active', true)->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    });
});

// ============================================
// 3. MOVIES
// ============================================

Route::prefix('movies')->group(function () {
    // Get all movies (with pagination)
    Route::get('/', function (Request $request) {
        $query = Movie::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate($request->get('per_page', 20))
        ]);
    });

    // Get single movie
    Route::get('/{id}', function ($id) {
        $movie = Movie::with('category')->where('is_active', true)->findOrFail($id);

        // Increment views
        $movie->increment('views');

        return response()->json([
            'success' => true,
            'data' => $movie
        ]);
    });

    // Get featured movies
    Route::get('/featured/list', function () {
        return response()->json([
            'success' => true,
            'data' => Movie::with('category')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        ]);
    });

    // Get trending movies
    Route::get('/trending/list', function () {
        return response()->json([
            'success' => true,
            'data' => Movie::with('category')
                ->where('is_active', true)
                ->orderBy('views', 'desc')
                ->limit(10)
                ->get()
        ]);
    });
});

// ============================================
// 4. SERIES
// ============================================

Route::prefix('series')->group(function () {
    // Get all series (with pagination)
    Route::get('/', function (Request $request) {
        $query = Series::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%");
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('created_at', 'desc')
                ->paginate($request->get('per_page', 20))
        ]);
    });

    // Get single series with seasons and episodes
    Route::get('/{id}', function ($id) {
        $series = Series::with([
            'category',
            'seasons' => function ($query) {
                $query->orderBy('season_number');
            },
            'seasons.episodes' => function ($query) {
                $query->where('is_active', true)->orderBy('episode_number');
            }
        ])->where('is_active', true)->findOrFail($id);

        // Increment views
        $series->increment('views');

        return response()->json([
            'success' => true,
            'data' => $series
        ]);
    });

    // Get episodes of a specific season
    Route::get('/{series_id}/seasons/{season_id}/episodes', function ($series_id, $season_id) {
        $episodes = Episode::where('season_id', $season_id)
            ->where('is_active', true)
            ->orderBy('episode_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $episodes
        ]);
    });

    // Get single episode
    Route::get('/episodes/{episode_id}', function ($episode_id) {
        $episode = Episode::with(['season.series'])->findOrFail($episode_id);

        // Increment views
        $episode->increment('views');

        return response()->json([
            'success' => true,
            'data' => $episode
        ]);
    });
});

// ============================================
// 5. SEARCH
// ============================================

Route::get('/search', function (Request $request) {
    $search = $request->get('q', '');
    $type = $request->get('type', 'all'); // all, movies, series

    $results = [];

    if ($type === 'all' || $type === 'movies') {
        $results['movies'] = Movie::where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('title_ar', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%")
                  ->orWhere('description_ar', 'LIKE', "%{$search}%")
                  ->orWhere('description_en', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'title_ar', 'title_en', 'poster', 'rating', 'year']);
    }

    if ($type === 'all' || $type === 'series') {
        $results['series'] = Series::where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('title_ar', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%")
                  ->orWhere('description_ar', 'LIKE', "%{$search}%")
                  ->orWhere('description_en', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'title_ar', 'title_en', 'poster', 'rating', 'year']);
    }

    return response()->json([
        'success' => true,
        'query' => $search,
        'data' => $results
    ]);
});

// ============================================
// 6. SUBSCRIPTION PLANS
// ============================================

Route::prefix('subscriptions')->group(function () {
    // Get all plans
    Route::get('/plans', function () {
        return response()->json([
            'success' => true,
            'data' => SubscriptionPlan::where('is_active', true)
                ->orderBy('price')
                ->get()
        ]);
    });

    // Get single plan
    Route::get('/plans/{id}', function ($id) {
        return response()->json([
            'success' => true,
            'data' => SubscriptionPlan::where('is_active', true)->findOrFail($id)
        ]);
    });
});

// ============================================
// 7. HOME PAGE / DASHBOARD
// ============================================

Route::get('/home', function () {
    return response()->json([
        'success' => true,
        'data' => [
            'sliders' => Slider::where('is_active', true)
                ->orderBy('order')
                ->limit(5)
                ->get(['id', 'title', 'image', 'link']),

            'featured_movies' => Movie::with('category')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),

            'trending_movies' => Movie::with('category')
                ->where('is_active', true)
                ->orderBy('views', 'desc')
                ->limit(10)
                ->get(),

            'latest_series' => Series::with('category')
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),

            'categories' => Category::where('is_active', true)
                ->orderBy('order')
                ->get(['id', 'name_ar', 'name_en', 'icon']),
        ]
    ]);
});

// ============================================
// 8. HEALTH CHECK
// ============================================

// ============================================
// 6. PAGES (About, Terms, Privacy, etc.)
// ============================================

Route::prefix('pages')->group(function () {
    // Get all pages
    Route::get('/', [PageController::class, 'index']);

    // Get menu pages
    Route::get('/menu', [PageController::class, 'menu']);

    // Get footer pages
    Route::get('/footer', [PageController::class, 'footer']);

    // Get pages by type
    Route::get('/type/{type}', [PageController::class, 'byType']);

    // Search pages
    Route::get('/search', [PageController::class, 'search']);

    // Get single page by slug
    Route::get('/{slug}', [PageController::class, 'show']);
});

// ============================================
// 7. AUTHENTICATION & USER MANAGEMENT
// ============================================

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/google', [AuthController::class, 'loginWithGoogle']);
    Route::post('/login/phone', [AuthController::class, 'loginWithPhone']);
    Route::post('/login/phone/verify', [AuthController::class, 'verifyPhoneOTP']);
    Route::post('/login/guest', [AuthController::class, 'loginAsGuest']);
});

// Protected authentication routes
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/convert-guest', [AuthController::class, 'convertGuestToUser']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::delete('/delete-account', [AuthController::class, 'deleteAccount']);
});

// ============================================
// 8. HEALTH CHECK
// ============================================

Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'Alenwan API is running',
        'timestamp' => now()->toIso8601String(),
        'version' => '1.1.0'
    ]);
});
