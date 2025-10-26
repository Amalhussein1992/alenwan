<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Check if language is set in query parameter
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        } else {
            $locale = Session::get('locale', config('app.locale'));
        }

        // Validate locale
        $supportedLanguages = ['en', 'ar', 'fr', 'es'];
        if (!in_array($locale, $supportedLanguages)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}