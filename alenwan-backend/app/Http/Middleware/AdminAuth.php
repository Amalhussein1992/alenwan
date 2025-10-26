<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is logged in
        if (!Session::get('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Please log in to access the admin panel.');
        }

        // Add admin info to view data
        view()->share('admin_user', [
            'name' => Session::get('admin_name', 'Admin'),
            'email' => Session::get('admin_email', 'admin@alenwan.com')
        ]);

        return $next($request);
    }
}