# 💻 أمثلة برمجية - Code Examples

## 🎬 إدارة الأفلام - Movies Management

### إنشاء فيلم جديد
```php
use App\Models\Movie;
use App\Models\Category;

$movie = Movie::create([
    'title' => [
        'ar' => 'فيلم رائع',
        'en' => 'Amazing Movie'
    ],
    'description' => [
        'ar' => 'وصف الفيلم بالعربي',
        'en' => 'Movie description in English'
    ],
    'slug' => 'amazing-movie',
    'category_id' => 1,
    'video_url' => 'https://player.vimeo.com/video/123456789',
    'vimeo_id' => '123456789',
    'vimeo_url' => 'https://vimeo.com/123456789',
    'duration' => 120, // دقيقة
    'release_year' => 2024,
    'rating' => 8.5,
    'is_premium' => false,
    'is_active' => true,
    'is_featured' => true,
]);
```

### جلب الأفلام المميزة
```php
$featuredMovies = Movie::where('is_featured', true)
    ->where('is_active', true)
    ->with('category')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();

foreach ($featuredMovies as $movie) {
    echo $movie->title . " - " . $movie->category->name;
}
```

### البحث عن فيلم
```php
$searchQuery = 'action';

$movies = Movie::where(function($query) use ($searchQuery) {
        $query->whereJsonContains('title->ar', $searchQuery)
              ->orWhereJsonContains('title->en', $searchQuery);
    })
    ->where('is_active', true)
    ->paginate(20);
```

### زيادة عدد المشاهدات
```php
$movie = Movie::find(1);
$movie->incrementViews();
```

---

## 📺 إدارة المسلسلات - Series Management

### إنشاء مسلسل مع مواسم وحلقات
```php
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;

// إنشاء المسلسل
$series = Series::create([
    'title' => [
        'ar' => 'مسلسل مثير',
        'en' => 'Exciting Series'
    ],
    'description' => [
        'ar' => 'وصف المسلسل',
        'en' => 'Series description'
    ],
    'slug' => 'exciting-series',
    'category_id' => 2,
    'status' => 'ongoing',
    'is_premium' => true,
    'is_active' => true,
]);

// إنشاء الموسم الأول
$season1 = Season::create([
    'series_id' => $series->id,
    'title' => [
        'ar' => 'الموسم الأول',
        'en' => 'Season 1'
    ],
    'season_number' => 1,
    'is_active' => true,
]);

// إضافة حلقات للموسم
for ($i = 1; $i <= 10; $i++) {
    Episode::create([
        'season_id' => $season1->id,
        'title' => [
            'ar' => "الحلقة {$i}",
            'en' => "Episode {$i}"
        ],
        'episode_number' => $i,
        'video_url' => "https://player.vimeo.com/video/12345678{$i}",
        'duration' => 45,
        'is_active' => true,
    ]);
}
```

### جلب مسلسل مع جميع حلقاته
```php
$series = Series::with(['seasons' => function($query) {
        $query->orderBy('season_number');
    }, 'seasons.episodes' => function($query) {
        $query->orderBy('episode_number');
    }])
    ->find(1);

// عرض البنية
foreach ($series->seasons as $season) {
    echo $season->title . "\n";

    foreach ($season->episodes as $episode) {
        echo "  - " . $episode->title . "\n";
    }
}
```

### الحصول على آخر حلقة تمت إضافتها
```php
$latestEpisode = Episode::whereHas('season.series', function($query) use ($seriesId) {
        $query->where('id', $seriesId);
    })
    ->orderBy('created_at', 'desc')
    ->first();
```

---

## 🏷️ إدارة الفئات - Categories Management

### إنشاء فئة
```php
use App\Models\Category;

$category = Category::create([
    'name' => [
        'ar' => 'أكشن',
        'en' => 'Action'
    ],
    'description' => [
        'ar' => 'أفلام الإثارة والحركة',
        'en' => 'Thriller and action movies'
    ],
    'slug' => 'action',
    'icon' => 'fa-fire',
    'is_active' => true,
    'order' => 1,
]);
```

### جلب فئة مع محتواها
```php
$category = Category::with(['movies', 'series'])
    ->find(1);

echo "Movies: " . $category->movies->count();
echo "Series: " . $category->series->count();
```

---

## 👥 إدارة المستخدمين - Users Management

### إنشاء مستخدم عادي
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'name' => 'Ahmed Ali',
    'email' => 'ahmed@example.com',
    'password' => Hash::make('password123'),
    'is_admin' => false,
    'is_premium' => false,
    'preferred_language' => 'ar',
]);
```

### إنشاء مستخدم مميز
```php
$premiumUser = User::create([
    'name' => 'Sara Mohammed',
    'email' => 'sara@example.com',
    'password' => Hash::make('password123'),
    'is_premium' => true,
    'subscription_ends_at' => now()->addMonth(),
]);
```

### التحقق من صلاحية الاشتراك
```php
$user = User::find(1);

if ($user->is_premium && $user->subscription_ends_at > now()) {
    echo "الاشتراك نشط";
} else {
    echo "الاشتراك منتهي";
}
```

### تجديد الاشتراك
```php
$user->update([
    'is_premium' => true,
    'subscription_ends_at' => now()->addMonth(),
]);
```

---

## 🎥 استخدام Vimeo Service

### الحصول على معلومات فيديو من Vimeo
```php
use App\Services\VimeoService;

$vimeoService = new VimeoService();

// من رابط Vimeo
$vimeoUrl = 'https://vimeo.com/123456789';
$videoId = $vimeoService->extractVideoId($vimeoUrl);

// جلب التفاصيل
$videoDetails = $vimeoService->getVideo($videoId);

if ($videoDetails) {
    $embedUrl = $vimeoService->getEmbedUrl($videoId);
    $thumbnail = $vimeoService->getThumbnail($videoId);
    $duration = $vimeoService->getDuration($videoId);

    echo "Embed URL: {$embedUrl}\n";
    echo "Thumbnail: {$thumbnail}\n";
    echo "Duration: {$duration} seconds\n";
}
```

### إنشاء فيلم من رابط Vimeo تلقائياً
```php
function createMovieFromVimeo($vimeoUrl, $categoryId, $titleAr, $titleEn)
{
    $vimeoService = new VimeoService();
    $videoId = $vimeoService->extractVideoId($vimeoUrl);

    if (!$videoId) {
        return null;
    }

    $videoDetails = $vimeoService->getVideo($videoId);

    $movie = Movie::create([
        'title' => [
            'ar' => $titleAr,
            'en' => $titleEn
        ],
        'slug' => Str::slug($titleEn),
        'category_id' => $categoryId,
        'vimeo_id' => $videoId,
        'vimeo_url' => $vimeoUrl,
        'video_url' => $vimeoService->getEmbedUrl($videoId),
        'thumbnail' => $vimeoService->getThumbnail($videoId),
        'duration' => ceil($vimeoService->getDuration($videoId) / 60),
        'is_active' => true,
    ]);

    return $movie;
}

// استخدام
$movie = createMovieFromVimeo(
    'https://vimeo.com/123456789',
    1,
    'فيلم رائع',
    'Amazing Movie'
);
```

---

## 📱 API Endpoints للتطبيق

### في ملف routes/api.php

```php
use App\Models\Category;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// الفئات
Route::get('/categories', function () {
    return Category::where('is_active', true)
        ->orderBy('order')
        ->get(['id', 'name', 'slug', 'icon']);
});

// الأفلام
Route::get('/movies', function (Request $request) {
    $query = Movie::with('category:id,name')
        ->where('is_active', true);

    // فلترة حسب الفئة
    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // فلترة حسب المميزة
    if ($request->has('featured')) {
        $query->where('is_featured', true);
    }

    // بحث
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereJsonContains('title->ar', $search)
              ->orWhereJsonContains('title->en', $search);
        });
    }

    return $query->orderBy('created_at', 'desc')
                 ->paginate(20);
});

// تفاصيل فيلم
Route::get('/movies/{id}', function ($id) {
    $movie = Movie::with('category')
        ->where('is_active', true)
        ->findOrFail($id);

    // زيادة عدد المشاهدات
    $movie->incrementViews();

    return $movie;
});

// المسلسلات
Route::get('/series', function (Request $request) {
    $query = Series::with('category:id,name')
        ->where('is_active', true);

    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    return $query->orderBy('created_at', 'desc')
                 ->paginate(20);
});

// تفاصيل مسلسل مع المواسم
Route::get('/series/{id}', function ($id) {
    return Series::with([
            'category',
            'seasons' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('season_number');
            }
        ])
        ->where('is_active', true)
        ->findOrFail($id);
});

// حلقات موسم معين
Route::get('/seasons/{seasonId}/episodes', function ($seasonId) {
    $season = Season::with([
            'episodes' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('episode_number');
            }
        ])
        ->findOrFail($seasonId);

    return $season->episodes;
});

// تفاصيل حلقة
Route::get('/episodes/{id}', function ($id) {
    $episode = Episode::with('season.series')
        ->where('is_active', true)
        ->findOrFail($id);

    $episode->incrementViews();

    return $episode;
});

// الأفلام المميزة
Route::get('/featured', function () {
    return Movie::where('is_featured', true)
        ->where('is_active', true)
        ->with('category:id,name')
        ->take(10)
        ->get();
});

// الأكثر مشاهدة
Route::get('/trending', function () {
    return Movie::where('is_active', true)
        ->with('category:id,name')
        ->orderBy('views_count', 'desc')
        ->take(20)
        ->get();
});
```

---

## 🔐 API Authentication (Sanctum)

### تثبيت Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### في routes/api.php
```php
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// تسجيل
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
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
    ]);
});

// تسجيل الدخول
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['البيانات غير صحيحة.'],
        ]);
    }

    $token = $user->createToken('mobile-app')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});

// الروابط المحمية
Route::middleware('auth:sanctum')->group(function () {
    // معلومات المستخدم
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // تسجيل الخروج
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج']);
    });
});
```

---

## 🧪 أمثلة للاختبار

### في Tinker
```bash
php artisan tinker
```

```php
// إنشاء بيانات تجريبية
$category = App\Models\Category::create([
    'name' => ['ar' => 'كوميديا', 'en' => 'Comedy'],
    'slug' => 'comedy',
    'is_active' => true
]);

$movie = App\Models\Movie::create([
    'title' => ['ar' => 'فيلم مضحك', 'en' => 'Funny Movie'],
    'slug' => 'funny-movie',
    'category_id' => $category->id,
    'video_url' => 'https://player.vimeo.com/video/123',
    'is_active' => true
]);

// اختبار العلاقات
$movie->category->name; // عرض اسم الفئة
$category->movies->count(); // عدد الأفلام في الفئة
```

---

## 📊 Queries متقدمة

### أفلام فئة معينة بترتيب التقييم
```php
$topRatedMovies = Movie::where('category_id', 1)
    ->where('is_active', true)
    ->orderBy('rating', 'desc')
    ->take(10)
    ->get();
```

### مسلسلات قيد العرض
```php
$ongoingSeries = Series::where('status', 'ongoing')
    ->where('is_active', true)
    ->with('seasons')
    ->get();
```

### إحصائيات سريعة
```php
$stats = [
    'total_movies' => Movie::where('is_active', true)->count(),
    'total_series' => Series::where('is_active', true)->count(),
    'total_episodes' => Episode::where('is_active', true)->count(),
    'premium_movies' => Movie::where('is_premium', true)->count(),
    'total_views' => Movie::sum('views_count') + Episode::sum('views_count'),
];
```

---

**تذكر:** هذه أمثلة للاستخدام. يمكنك تعديلها حسب احتياجاتك!

