<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MoviesController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\CartoonsController;
use App\Http\Controllers\Admin\DocumentariesController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\EpisodesController;
use App\Http\Controllers\Admin\LiveStreamsController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PodcastsController;
use App\Http\Controllers\Admin\SettingsController;

// Admin routes
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // Movies
    Route::resource('movies', MoviesController::class)->names([
        'index' => 'admin.movies.index',
        'create' => 'admin.movies.create',
        'store' => 'admin.movies.store',
        'show' => 'admin.movies.show',
        'edit' => 'admin.movies.edit',
        'update' => 'admin.movies.update',
        'destroy' => 'admin.movies.destroy',
    ]);
    Route::post('/movies/bulk-action', [MoviesController::class, 'bulkAction'])->name('admin.movies.bulk-action');

    // Series
    Route::resource('series', SeriesController::class)->names([
        'index' => 'admin.series.index',
        'create' => 'admin.series.create',
        'store' => 'admin.series.store',
        'show' => 'admin.series.show',
        'edit' => 'admin.series.edit',
        'update' => 'admin.series.update',
        'destroy' => 'admin.series.destroy',
    ]);

    // Episodes
    Route::resource('episodes', EpisodesController::class)->names([
        'index' => 'admin.episodes.index',
        'create' => 'admin.episodes.create',
        'store' => 'admin.episodes.store',
        'show' => 'admin.episodes.show',
        'edit' => 'admin.episodes.edit',
        'update' => 'admin.episodes.update',
        'destroy' => 'admin.episodes.destroy',
    ]);

    // Cartoons
    Route::resource('cartoons', CartoonsController::class)->names([
        'index' => 'admin.cartoons.index',
        'create' => 'admin.cartoons.create',
        'store' => 'admin.cartoons.store',
        'show' => 'admin.cartoons.show',
        'edit' => 'admin.cartoons.edit',
        'update' => 'admin.cartoons.update',
        'destroy' => 'admin.cartoons.destroy',
    ]);

    // Documentaries
    Route::resource('documentaries', DocumentariesController::class)->names([
        'index' => 'admin.documentaries.index',
        'create' => 'admin.documentaries.create',
        'store' => 'admin.documentaries.store',
        'show' => 'admin.documentaries.show',
        'edit' => 'admin.documentaries.edit',
        'update' => 'admin.documentaries.update',
        'destroy' => 'admin.documentaries.destroy',
    ]);

    // Sports
    Route::resource('sports', SportsController::class)->names([
        'index' => 'admin.sports.index',
        'create' => 'admin.sports.create',
        'store' => 'admin.sports.store',
        'show' => 'admin.sports.show',
        'edit' => 'admin.sports.edit',
        'update' => 'admin.sports.update',
        'destroy' => 'admin.sports.destroy',
    ]);

    // Podcasts
    Route::resource('podcasts', PodcastsController::class)->names([
        'index' => 'admin.podcasts.index',
        'create' => 'admin.podcasts.create',
        'store' => 'admin.podcasts.store',
        'show' => 'admin.podcasts.show',
        'edit' => 'admin.podcasts.edit',
        'update' => 'admin.podcasts.update',
        'destroy' => 'admin.podcasts.destroy',
    ]);

    // Live Streams
    Route::resource('livestreams', LiveStreamsController::class)->names([
        'index' => 'admin.livestreams.index',
        'create' => 'admin.livestreams.create',
        'store' => 'admin.livestreams.store',
        'show' => 'admin.livestreams.show',
        'edit' => 'admin.livestreams.edit',
        'update' => 'admin.livestreams.update',
        'destroy' => 'admin.livestreams.destroy',
    ]);

    // Categories
    Route::resource('categories', CategoriesController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Languages
    Route::resource('languages', LanguagesController::class)->names([
        'index' => 'admin.languages.index',
        'create' => 'admin.languages.create',
        'store' => 'admin.languages.store',
        'show' => 'admin.languages.show',
        'edit' => 'admin.languages.edit',
        'update' => 'admin.languages.update',
        'destroy' => 'admin.languages.destroy',
    ]);

    // Subscription Plans
    Route::resource('subscription-plans', SubscriptionPlanController::class)->names([
        'index' => 'admin.subscription-plans.index',
        'create' => 'admin.subscription-plans.create',
        'store' => 'admin.subscription-plans.store',
        'show' => 'admin.subscription-plans.show',
        'edit' => 'admin.subscription-plans.edit',
        'update' => 'admin.subscription-plans.update',
        'destroy' => 'admin.subscription-plans.destroy',
    ]);

    // Users
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
});

// Root redirect
Route::get('/', function () {
    return redirect('/admin/dashboard');
});