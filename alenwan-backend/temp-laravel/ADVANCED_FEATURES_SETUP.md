# 🚀 دليل إضافة الميزات المتقدمة - Alenwan Backend

## 📋 نظرة عامة

هذا الدليل يشرح كيفية إضافة جميع الميزات المتقدمة للنظام:
- ✅ Authentication (Laravel Sanctum)
- ✅ User Favorites
- ✅ Watch History
- ✅ Downloads Management
- ✅ Payment Integration
- ✅ Push Notifications
- ✅ Analytics & Reports

---

## 🔐 1. Authentication مع Laravel Sanctum

### الخطوة 1: تثبيت Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### الخطوة 2: تعديل User Model

أضف إلى `app/Models/User.php`:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'preferred_language',
        'is_admin',
        'is_premium',
        'subscription_ends_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_premium' => 'boolean',
        'password' => 'hashed',
    ];

    // Check if user has active subscription
    public function hasActiveSubscription(): bool
    {
        return $this->is_premium &&
               ($this->subscription_ends_at === null || $this->subscription_ends_at->isFuture());
    }
}
```

### الخطوة 3: إضافة Authentication Routes

أضف إلى `routes/api.php`:

```php
// Authentication Endpoints
Route::prefix('auth')->group(function () {
    // Register
    Route::post('/register', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'preferred_language' => 'nullable|string|in:ar,en',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'preferred_language' => $request->preferred_language ?? 'ar',
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    });

    // Login
    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    })->middleware('auth:sanctum');

    // Get User Profile
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    })->middleware('auth:sanctum');

    // Update Profile
    Route::put('/profile', function (Request $request) {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'avatar' => 'sometimes|nullable|url',
            'preferred_language' => 'sometimes|string|in:ar,en',
        ]);

        $user->update($request->only(['name', 'phone', 'avatar', 'preferred_language']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    })->middleware('auth:sanctum');

    // Change Password
    Route::post('/change-password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->update(['password' => bcrypt($request->new_password)]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    })->middleware('auth:sanctum');
});
```

---

## ⭐ 2. User Favorites

### الخطوة 1: تشغيل Migration

قم بتعديل ملف المايجريشن `database/migrations/2025_10_28_115203_create_favorites_table.php`:

```php
Schema::create('favorites', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('favoritable_type'); // Movie, Series, Episode
    $table->unsignedBigInteger('favoritable_id');
    $table->timestamps();

    $table->index(['favoritable_type', 'favoritable_id']);
    $table->unique(['user_id', 'favoritable_type', 'favoritable_id']);
});
```

ثم:
```bash
php artisan migrate
```

### الخطوة 2: إنشاء Model

`app/Models/Favorite.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    // Polymorphic relation
    public function favoritable()
    {
        return $this->morphTo();
    }

    // User relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### الخطوة 3: إضافة API Routes

```php
// Favorites Endpoints (Protected)
Route::middleware('auth:sanctum')->prefix('favorites')->group(function () {
    // Get user favorites
    Route::get('/', function (Request $request) {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with('favoritable')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $favorites
        ]);
    });

    // Add to favorites
    Route::post('/', function (Request $request) {
        $request->validate([
            'type' => 'required|in:movie,series,episode',
            'id' => 'required|integer',
        ]);

        $typeMap = [
            'movie' => Movie::class,
            'series' => Series::class,
            'episode' => Episode::class,
        ];

        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'favoritable_type' => $typeMap[$request->type],
            'favoritable_id' => $request->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to favorites',
            'data' => $favorite
        ], 201);
    });

    // Remove from favorites
    Route::delete('/{id}', function (Request $request, $id) {
        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from favorites'
        ]);
    });

    // Check if item is favorite
    Route::post('/check', function (Request $request) {
        $request->validate([
            'type' => 'required|in:movie,series,episode',
            'id' => 'required|integer',
        ]);

        $typeMap = [
            'movie' => Movie::class,
            'series' => Series::class,
            'episode' => Episode::class,
        ];

        $isFavorite = Favorite::where('user_id', $request->user()->id)
            ->where('favoritable_type', $typeMap[$request->type])
            ->where('favoritable_id', $request->id)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite
        ]);
    });
});
```

---

## 📺 3. Watch History

### الخطوة 1: تعديل Migration

في `database/migrations/2025_10_28_115204_create_watch_history_table.php`:

```php
Schema::create('watch_history', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('watchable_type'); // Movie, Episode
    $table->unsignedBigInteger('watchable_id');
    $table->integer('watch_duration')->default(0); // in seconds
    $table->integer('total_duration')->default(0); // in seconds
    $table->integer('progress_percentage')->default(0); // 0-100
    $table->boolean('completed')->default(false);
    $table->timestamp('last_watched_at')->useCurrent();
    $table->timestamps();

    $table->index(['watchable_type', 'watchable_id']);
    $table->index(['user_id', 'last_watched_at']);
});
```

### الخطوة 2: Model

`app/Models/WatchHistory.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id',
        'watch_duration',
        'total_duration',
        'progress_percentage',
        'completed',
        'last_watched_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_watched_at' => 'datetime',
    ];

    public function watchable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### الخطوة 3: API Routes

```php
// Watch History Endpoints
Route::middleware('auth:sanctum')->prefix('watch-history')->group(function () {
    // Get watch history
    Route::get('/', function (Request $request) {
        $history = WatchHistory::where('user_id', $request->user()->id)
            ->with('watchable')
            ->orderBy('last_watched_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    });

    // Update watch progress
    Route::post('/update', function (Request $request) {
        $request->validate([
            'type' => 'required|in:movie,episode',
            'id' => 'required|integer',
            'watch_duration' => 'required|integer|min:0',
            'total_duration' => 'required|integer|min:1',
        ]);

        $typeMap = [
            'movie' => Movie::class,
            'episode' => Episode::class,
        ];

        $progressPercentage = ($request->watch_duration / $request->total_duration) * 100;
        $completed = $progressPercentage >= 90; // Consider 90% as completed

        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'watchable_type' => $typeMap[$request->type],
                'watchable_id' => $request->id,
            ],
            [
                'watch_duration' => $request->watch_duration,
                'total_duration' => $request->total_duration,
                'progress_percentage' => $progressPercentage,
                'completed' => $completed,
                'last_watched_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Watch progress updated',
            'data' => $history
        ]);
    });

    // Get continue watching
    Route::get('/continue-watching', function (Request $request) {
        $continueWatching = WatchHistory::where('user_id', $request->user()->id)
            ->where('completed', false)
            ->where('progress_percentage', '>', 0)
            ->with('watchable')
            ->orderBy('last_watched_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $continueWatching
        ]);
    });
});
```

---

## 📥 4. Downloads Management

### Migration

`database/migrations/2025_10_28_115205_create_user_downloads_table.php`:

```php
Schema::create('user_downloads', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('downloadable_type'); // Movie, Episode
    $table->unsignedBigInteger('downloadable_id');
    $table->string('quality')->default('720p'); // 480p, 720p, 1080p
    $table->bigInteger('file_size')->nullable(); // in bytes
    $table->string('download_url')->nullable();
    $table->enum('status', ['pending', 'downloading', 'completed', 'failed'])->default('pending');
    $table->integer('progress_percentage')->default(0);
    $table->timestamp('expires_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();

    $table->index(['downloadable_type', 'downloadable_id']);
    $table->index(['user_id', 'status']);
});
```

### Model & Routes

`app/Models/UserDownload.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDownload extends Model
{
    protected $fillable = [
        'user_id',
        'downloadable_type',
        'downloadable_id',
        'quality',
        'file_size',
        'download_url',
        'status',
        'progress_percentage',
        'expires_at',
        'completed_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function downloadable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### API Routes:

```php
// Downloads Endpoints
Route::middleware('auth:sanctum')->prefix('downloads')->group(function () {
    // Get user downloads
    Route::get('/', function (Request $request) {
        $downloads = UserDownload::where('user_id', $request->user()->id)
            ->with('downloadable')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $downloads
        ]);
    });

    // Request download
    Route::post('/', function (Request $request) {
        $request->validate([
            'type' => 'required|in:movie,episode',
            'id' => 'required|integer',
            'quality' => 'required|in:480p,720p,1080p',
        ]);

        // Check if user has premium subscription
        if (!$request->user()->hasActiveSubscription()) {
            return response()->json([
                'success' => false,
                'message' => 'Premium subscription required for downloads'
            ], 403);
        }

        $typeMap = [
            'movie' => Movie::class,
            'episode' => Episode::class,
        ];

        $download = UserDownload::create([
            'user_id' => $request->user()->id,
            'downloadable_type' => $typeMap[$request->type],
            'downloadable_id' => $request->id,
            'quality' => $request->quality,
            'status' => 'pending',
            'expires_at' => now()->addDays(7), // Download expires in 7 days
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Download requested successfully',
            'data' => $download
        ], 201);
    });

    // Delete download
    Route::delete('/{id}', function (Request $request, $id) {
        $download = UserDownload::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $download->delete();

        return response()->json([
            'success' => true,
            'message' => 'Download deleted'
        ]);
    });
});
```

---

## 💳 5. Payment Integration

### Migration

`database/migrations/2025_10_28_115206_create_payments_table.php`:

```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subscription_plan_id')->nullable()->constrained()->onDelete('set null');
    $table->string('transaction_id')->unique();
    $table->string('payment_gateway'); // stripe, paypal, tap
    $table->decimal('amount', 10, 2);
    $table->string('currency', 3)->default('USD');
    $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
    $table->text('gateway_response')->nullable();
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();

    $table->index(['user_id', 'status']);
});
```

### Migration للاشتراكات

`database/migrations/2025_10_28_115207_create_user_subscriptions_table.php`:

```php
Schema::create('user_subscriptions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade');
    $table->foreignId('payment_id')->nullable()->constrained()->onDelete('set null');
    $table->timestamp('starts_at');
    $table->timestamp('ends_at');
    $table->boolean('is_active')->default(true);
    $table->boolean('auto_renew')->default(false);
    $table->timestamp('cancelled_at')->nullable();
    $table->timestamps();

    $table->index(['user_id', 'is_active']);
});
```

### Models

`app/Models/Payment.php` & `app/Models/UserSubscription.php`

### API Routes

```php
// Payment & Subscription Endpoints
Route::middleware('auth:sanctum')->group(function () {
    // Create payment intent
    Route::post('/payments/create-intent', function (Request $request) {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'payment_gateway' => 'required|in:stripe,paypal,tap',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        // Create payment record
        $payment = Payment::create([
            'user_id' => $request->user()->id,
            'subscription_plan_id' => $plan->id,
            'transaction_id' => 'TXN_' . time() . '_' . $request->user()->id,
            'payment_gateway' => $request->payment_gateway,
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'status' => 'pending',
        ]);

        // Here you would integrate with actual payment gateway
        // For now, return mock data
        return response()->json([
            'success' => true,
            'data' => [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                // payment_url would come from gateway
                'payment_url' => "https://payment.example.com/{$payment->transaction_id}",
            ]
        ]);
    });

    // Verify payment
    Route::post('/payments/verify', function (Request $request) {
        $request->validate([
            'transaction_id' => 'required|string',
        ]);

        $payment = Payment::where('transaction_id', $request->transaction_id)->firstOrFail();

        // Here you would verify with actual payment gateway
        // For now, simulate success
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Create subscription
        $plan = $payment->subscriptionPlan;
        $startsAt = now();
        $endsAt = $startsAt->copy()->addDays($plan->duration_days);

        $subscription = UserSubscription::create([
            'user_id' => $payment->user_id,
            'subscription_plan_id' => $plan->id,
            'payment_id' => $payment->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_active' => true,
        ]);

        // Update user premium status
        $payment->user->update([
            'is_premium' => true,
            'subscription_ends_at' => $endsAt,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified and subscription activated',
            'data' => [
                'payment' => $payment,
                'subscription' => $subscription,
            ]
        ]);
    });

    // Get user subscriptions
    Route::get('/subscriptions/my-subscriptions', function (Request $request) {
        $subscriptions = UserSubscription::where('user_id', $request->user()->id)
            ->with(['subscriptionPlan', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions
        ]);
    });
});
```

---

## 📊 6. Analytics & Reports

### إنشاء Resource في Filament

```bash
php artisan make:filament-page Analytics
```

في `app/Filament/Pages/Analytics.php`:

```php
<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Payment;

class Analytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Analytics';

    protected static string $view = 'filament.pages.analytics';

    protected static ?string $navigationGroup = 'Reports';

    public function getStats(): array
    {
        return [
            'total_users' => User::count(),
            'premium_users' => User::where('is_premium', true)->count(),
            'total_movies' => Movie::count(),
            'total_series' => Series::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'today_signups' => User::whereDate('created_at', today())->count(),
        ];
    }
}
```

---

## 🔔 7. Push Notifications

### تثبيت Firebase

```bash
composer require kreait/firebase-php
```

### إنشاء Notification Service

`app/Services/PushNotificationService.php`:

```php
<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(storage_path('app/firebase-credentials.json'));

        $this->messaging = $firebase->createMessaging();
    }

    public function sendToUser($userId, $title, $body, $data = [])
    {
        // Get user's FCM token from database
        $user = User::find($userId);

        if (!$user || !$user->fcm_token) {
            return false;
        }

        $message = CloudMessage::withTarget('token', $user->fcm_token)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ])
            ->withData($data);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            \Log::error('Push notification failed: ' . $e->getMessage());
            return false;
        }
    }
}
```

---

## ✅ تشغيل جميع المايجريشنز

```bash
php artisan migrate
```

---

## 📱 مثال استخدام في Flutter

```dart
// Login
final response = await http.post(
  Uri.parse('$baseUrl/auth/login'),
  headers: {'Content-Type': 'application/json'},
  body: json.encode({
    'email': 'user@example.com',
    'password': 'password123',
  }),
);

final data = json.decode(response.body);
final token = data['data']['token'];

// استخدام Token في الطلبات
final moviesResponse = await http.get(
  Uri.parse('$baseUrl/favorites'),
  headers: {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  },
);
```

---

## 🎉 النتيجة النهائية

بعد تنفيذ جميع هذه الخطوات، سيكون لديك:

- ✅ نظام مصادقة كامل
- ✅ إدارة المفضلة
- ✅ تتبع المشاهدة
- ✅ إدارة التنزيلات
- ✅ دفع واشتراكات
- ✅ إشعارات فورية
- ✅ تقارير وتحليلات

---

**آخر تحديث:** 28 أكتوبر 2025
