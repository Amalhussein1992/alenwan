<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\MoviesController;
use App\Http\Controllers\Admin\PodcastsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\EpisodesController;
use App\Http\Controllers\Admin\DocumentariesController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\CartoonsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TranslationsController;
use App\Http\Controllers\Admin\LiveStreamsController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::get('/', function () {
    return view('landing');
})->middleware('setLocale')->name('landing');

Route::get('/test-connection', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel backend is working!',
        'timestamp' => now()
    ]);
});

// Admin Authentication Routes (no middleware required)
Route::prefix('admin')->name('admin.')->middleware(['web', 'setLocale'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->middleware(['guest', 'throttle:5,1']);
});

// Protected Admin Routes - Requires Authentication and Admin Role
Route::prefix('admin')->name('admin.')->middleware(['web', 'setLocale', 'auth', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('/', function() {
        $movies = collect();
        return view('admin.dashboard.index', compact('movies'));
    })->name('dashboard');

    Route::get('/dashboard', function() {
        $movies = collect();
        return view('admin.dashboard.index', compact('movies'));
    })->name('dashboard.alt');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/export', [AnalyticsController::class, 'exportReport'])->name('analytics.export');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/save', [SettingsController::class, 'save'])->name('settings.save');
    Route::post('/settings/test-connection', [SettingsController::class, 'testConnection'])->name('settings.test-connection');
    Route::post('/settings/generate-api-key', [SettingsController::class, 'generateApiKey'])->name('settings.generate-api-key');
    Route::post('/switch-language', [SettingsController::class, 'switchLanguage'])->name('switch-language');

    // Movies CRUD routes
    Route::resource('movies', MoviesController::class);
    Route::post('/movies/bulk-action', [MoviesController::class, 'bulkAction'])->name('movies.bulk-action');

    // Podcasts CRUD routes
    Route::resource('podcasts', PodcastsController::class);
    Route::post('/podcasts/bulk-action', [PodcastsController::class, 'bulkAction'])->name('podcasts.bulk-action');

    // Categories CRUD routes
    Route::resource('categories', CategoriesController::class);

    // Languages CRUD routes
    Route::resource('languages', LanguagesController::class);

    // Series CRUD routes
    Route::resource('series', SeriesController::class);

    // Episodes CRUD routes
    Route::resource('episodes', EpisodesController::class);

    // Documentaries CRUD routes
    Route::resource('documentaries', DocumentariesController::class);

    // Sports CRUD routes
    Route::resource('sports', SportsController::class);

    // Cartoons CRUD routes
    Route::resource('cartoons', CartoonsController::class);

    // Live Streams Management
    Route::resource('livestreams', LiveStreamsController::class);

    // Channels Management
    Route::get('/channels', function () {
        $channels = collect();
        return view('admin.channels.index', compact('channels'));
    })->name('channels.index');
    Route::get('/channels/create', function () { return view('admin.channels.create'); })->name('channels.create');

    // Categories Management
    Route::get('/categories', function () {
        $categories = collect();
        return view('admin.categories.index', compact('categories'));
    })->name('categories.index');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    // Subscriptions Management
    Route::get('/subscriptions', function () {
        $subscriptions = collect();
        return view('admin.subscriptions.index', compact('subscriptions'));
    })->name('subscriptions.index');

    // Subscription Plans Management
    Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);
    // Coupons Management
    Route::get('/coupons', function () {
        $coupons = collect();
        return view('admin.coupons.index', compact('coupons'));
    })->name('coupons.index');

    // Settings Management
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    Route::get('/settings/general', function () {
        return view('admin.settings.index');
    })->name('settings.general');
    Route::get('/settings/payment', function () {
        return view('admin.settings.index');
    })->name('settings.payment');
    Route::get('/settings/vimeo', function () {
        return view('admin.settings.index');
    })->name('settings.vimeo');
    Route::get('/settings/languages', function () {
        return view('admin.settings.index');
    })->name('settings.languages');
    Route::get('/settings/api', function () {
        return view('admin.settings.index');
    })->name('settings.api');
    Route::get('/settings/appearance', function () {
        return view('admin.settings.appearance');
    })->name('settings.appearance');
    Route::get('/settings/security', function () {
        return view('admin.settings.index');
    })->name('settings.security');
    // Banners Management
    Route::get('/banners', function () {
        $banners = collect();
        return view('admin.banners.index', compact('banners'));
    })->name('banners.index');
    Route::get('/banners/create', function () { return view('admin.banners.create'); })->name('banners.create');
    Route::post('/banners', function () {
        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    })->name('banners.store');
    Route::delete('/banners/{id}', function ($id) {
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    })->name('banners.destroy');

    // Translations Management
    Route::get('/translations', [TranslationsController::class, 'index'])->name('translations.index');
    Route::post('/translations/save', [TranslationsController::class, 'save'])->name('translations.save');
    Route::get('/translations/export/{language}', [TranslationsController::class, 'export'])->name('translations.export');
    Route::post('/translations/import', [TranslationsController::class, 'import'])->name('translations.import');

    // Profile Management
    Route::get('/profile', function () {
        return view('admin.profile.index');
    })->name('profile.index');
    Route::post('/profile/update', function () {
        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully!');
    })->name('profile.update');
});
