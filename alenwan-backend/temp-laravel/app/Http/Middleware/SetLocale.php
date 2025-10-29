<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, fallback to default
        $locale = Session::get('locale', config('app.locale', 'ar'));

        // Validate locale is supported
        $supportedLocales = ['ar', 'en'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'ar';
        }

        // Set application locale
        app()->setLocale($locale);

        return $next($request);
    }
}
