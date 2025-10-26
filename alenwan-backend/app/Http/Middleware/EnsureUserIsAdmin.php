<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Check if user has admin role/permission
        // You can customize this based on your user roles implementation
        $user = auth()->user();

        // For now, we'll check if user email is admin (you should implement proper role system)
        // Option 1: Check by email domain
        // if (!str_ends_with($user->email, '@admin.com')) {
        //     abort(403, 'Unauthorized access.');
        // }

        // Option 2: Check if user has 'role' column
        if (isset($user->role) && $user->role !== 'admin') {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
