<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\WebAppController;

Route::get('/', [WebAppController::class, 'index'])->name('home');

// Page routes
Route::get('/page/{slug}', [WebAppController::class, 'showPage'])->name('page.show');

// Language switcher route for admin panel
Route::post('/admin/switch-language', [LanguageController::class, 'switch'])
    ->name('filament.admin.switch-language')
    ->middleware(['web']);
