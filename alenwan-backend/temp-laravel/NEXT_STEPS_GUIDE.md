# دليل الخطوات التالية - منصة ألوان
# Next Steps Guide - Alenwan Platform

## 🎯 الأولوية القصوى / Top Priority

### 1. إنشاء API للتطبيقات المحمولة
### Create Mobile API Endpoints

#### الخطوة 1: تفعيل Laravel Sanctum
```bash
# Install Sanctum (already included in Laravel 11)
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Run migration
php artisan migrate
```

#### الخطوة 2: تحديث User Model
```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    // ... rest of the model
}
```

#### الخطوة 3: إنشاء API Controllers
```bash
# Authentication
php artisan make:controller Api/AuthController

# Content Controllers
php artisan make:controller Api/MovieController
php artisan make:controller Api/SeriesController
php artisan make:controller Api/PodcastController
php artisan make:controller Api/SportController
php artisan make:controller Api/DocumentaryController
php artisan make:controller Api/CartoonController
php artisan make:controller Api/LiveStreamController
php artisan make:controller Api/ChannelController

# User Interaction
php artisan make:controller Api/FavoriteController
php artisan make:controller Api/DownloadController

# Subscription
php artisan make:controller Api/SubscriptionController
php artisan make:controller Api/PaymentController

# General
php artisan make:controller Api/PageController
php artisan make:controller Api/SettingController
php artisan make:controller Api/SearchController
```

#### الخطوة 4: إنشاء API Resources
```bash
php artisan make:resource MovieResource
php artisan make:resource SeriesResource
php artisan make:resource EpisodeResource
php artisan make:resource PodcastResource
php artisan make:resource SportResource
php artisan make:resource DocumentaryResource
php artisan make:resource CartoonResource
php artisan make:resource LiveStreamResource
php artisan make:resource ChannelResource
php artisan make:resource UserResource
php artisan make:resource SubscriptionPlanResource
php artisan make:resource PageResource
```

---

## 📝 مثال كامل لـ API Controller

### Authentication Controller
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check max devices
        $maxDevices = \App\Models\AppSetting::get('max_devices_per_user', 3);
        $currentDevices = $user->tokens()->count();

        if ($currentDevices >= $maxDevices) {
            return response()->json([
                'message' => 'Maximum devices limit reached. Please logout from another device.',
            ], 403);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
```

### Movie Controller Example
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with(['category', 'language'])
            ->where('is_published', true);

        // Filtering
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('language_id')) {
            $query->where('language_id', $request->language_id);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title->ar', 'like', '%' . $request->search . '%')
                  ->orWhere('title->en', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 20);
        $movies = $query->paginate($perPage);

        return MovieResource::collection($movies);
    }

    public function show($id)
    {
        $movie = Movie::with(['category', 'language'])
            ->where('is_published', true)
            ->findOrFail($id);

        // Increment views
        $movie->increment('views_count');

        return new MovieResource($movie);
    }

    public function featured()
    {
        $movies = Movie::where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->limit(10)
            ->get();

        return MovieResource::collection($movies);
    }

    public function trending()
    {
        $movies = Movie::where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        return MovieResource::collection($movies);
    }
}
```

---

## 🛣️ API Routes

### في ملف routes/api.php
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\SeriesController;
// ... other controllers

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public content (no auth required)
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/movies/featured', [MovieController::class, 'featured']);
Route::get('/movies/trending', [MovieController::class, 'trending']);

Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/{id}', [SeriesController::class, 'show']);
Route::get('/series/{id}/episodes', [SeriesController::class, 'episodes']);

// ... similar routes for other content types

// Public settings & pages
Route::get('/settings/public', [SettingController::class, 'public']);
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

// Search
Route::get('/search', [SearchController::class, 'search']);

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{type}/{id}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{type}/{id}', [FavoriteController::class, 'destroy']);

    // Downloads
    Route::get('/downloads', [DownloadController::class, 'index']);
    Route::post('/downloads/{type}/{id}', [DownloadController::class, 'store']);
    Route::delete('/downloads/{id}', [DownloadController::class, 'destroy']);

    // Subscriptions
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans']);
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::get('/subscription/status', [SubscriptionController::class, 'status']);
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);

    // Payment
    Route::post('/payment/tap/checkout', [PaymentController::class, 'tapCheckout']);
    Route::post('/payment/stripe/checkout', [PaymentController::class, 'stripeCheckout']);
    Route::post('/payment/paypal/checkout', [PaymentController::class, 'paypalCheckout']);
});

// Payment callbacks (public)
Route::post('/payment/tap/callback', [PaymentController::class, 'tapCallback']);
Route::post('/payment/stripe/webhook', [PaymentController::class, 'stripeWebhook']);
Route::post('/payment/paypal/webhook', [PaymentController::class, 'paypalWebhook']);
```

---

## 🔒 Security Configuration

### 1. CORS Configuration
في ملف `config/cors.php`:
```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // في الإنتاج، حدد النطاقات المسموحة
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

### 2. Rate Limiting
في ملف `app/Providers/RouteServiceProvider.php`:
```php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    RateLimiter::for('auth', function (Request $request) {
        return Limit::perMinute(5)->by($request->ip());
    });
}
```

### 3. API Middleware
في ملف `routes/api.php`:
```php
Route::middleware(['throttle:auth'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
```

---

## 💳 Payment Integration

### TAP Payment Example
```bash
composer require tap-payments/tap-php
```

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;

class PaymentController extends Controller
{
    public function tapCheckout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = \App\Models\SubscriptionPlan::findOrFail($request->plan_id);
        $user = $request->user();

        // TAP Payment configuration
        $tapSecretKey = AppSetting::get('tap_secret_key');
        $tapMode = AppSetting::get('tap_mode', 'test');

        // Create charge
        $charge = [
            'amount' => $plan->price,
            'currency' => AppSetting::get('currency', 'SAR'),
            'customer' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'source' => ['id' => 'src_all'],
            'redirect' => [
                'url' => route('payment.callback'),
            ],
            'metadata' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ],
        ];

        // Call TAP API
        // ... implementation

        return response()->json([
            'checkout_url' => $checkoutUrl,
            'charge_id' => $chargeId,
        ]);
    }
}
```

---

## 📊 Database Optimization

### Add Indexes
```bash
php artisan make:migration add_performance_indexes
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Movies
        Schema::table('movies', function (Blueprint $table) {
            $table->index(['is_published', 'created_at']);
            $table->index(['is_featured', 'views_count']);
            $table->index(['category_id', 'language_id']);
        });

        // Similar for other tables...
    }
};
```

---

## 🧪 Testing

### Feature Test Example
```bash
php artisan make:test Api/AuthTest
```

```php
<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
            'device_name' => 'iPhone',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'token',
            ]);
    }
}
```

---

## 🚀 الأوامر السريعة / Quick Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed

# Run tests
php artisan test

# Generate API documentation
php artisan route:list --json > api-routes.json
```

---

## 📱 Flutter Integration Example

```dart
// lib/services/api_service.dart
import 'package:dio/dio.dart';

class ApiService {
  static const String baseUrl = 'https://api.alenwan.com';
  final Dio _dio = Dio();

  ApiService() {
    _dio.options.baseUrl = baseUrl;
    _dio.options.headers = {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    };
  }

  // Authentication
  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await _dio.post('/api/login', data: {
      'email': email,
      'password': password,
      'device_name': 'mobile',
    });
    return response.data;
  }

  // Get movies
  Future<List<Movie>> getMovies({int page = 1}) async {
    final response = await _dio.get('/api/movies', queryParameters: {
      'page': page,
      'per_page': 20,
    });
    return (response.data['data'] as List)
        .map((json) => Movie.fromJson(json))
        .toList();
  }
}
```

---

## ✅ Checklist للبدء

```
1. [ ] تفعيل Sanctum
2. [ ] إنشاء API Controllers
3. [ ] إنشاء API Resources
4. [ ] تحديد API Routes
5. [ ] إضافة Rate Limiting
6. [ ] تكوين CORS
7. [ ] تفعيل بوابات الدفع
8. [ ] كتابة Tests
9. [ ] إعداد Production Server
10. [ ] نشر التطبيق
```

---

**ملاحظة:** هذا دليل مبسط للبدء. يمكن توسيع كل قسم حسب الحاجة.
