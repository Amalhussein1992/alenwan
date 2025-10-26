<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Sport;
use App\Models\Cartoon;
use App\Models\Documentary;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'premium_users' => User::where('subscription_tier', '!=', 'free')->count(),
            'total_movies' => Movie::count(),
            'total_series' => Series::count(),
            'total_sports' => Sport::count(),
            'total_cartoons' => Cartoon::count(),
            'total_documentaries' => Documentary::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_content' => Movie::latest()->take(5)->get(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    // User Management
    public function getUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('subscription_tier')) {
            $query->where('subscription_tier', $request->subscription_tier);
        }

        $users = $query->latest()
                      ->paginate($request->per_page ?? 20);

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'subscription_tier' => 'sometimes|in:free,basic,premium,platinum',
            'is_active' => 'sometimes|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'subscription_tier', 'is_active']));

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete admin user'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }

    // Content Management
    public function addMovie(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_path' => 'required|url',
            'banner_path' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'vimeo_video_id' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'rating' => 'nullable|numeric|min:0|max:10',
            'subscription_tier' => 'required|in:free,basic,premium,platinum',
            'category_id' => 'required|exists:categories,id',
            'language_id' => 'required|exists:languages,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $movie = Movie::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Movie added successfully',
            'data' => $movie
        ], 201);
    }

    public function updateMovie(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'poster_path' => 'sometimes|url',
            'banner_path' => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'vimeo_video_id' => 'nullable|string',
            'duration_minutes' => 'sometimes|integer|min:1',
            'release_year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 10),
            'rating' => 'nullable|numeric|min:0|max:10',
            'subscription_tier' => 'sometimes|in:free,basic,premium,platinum',
            'category_id' => 'sometimes|exists:categories,id',
            'language_id' => 'sometimes|exists:languages,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Movie updated successfully',
            'data' => $movie
        ]);
    }

    public function deleteMovie($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Movie deleted successfully'
        ]);
    }

    // Analytics
    public function getAnalytics(Request $request)
    {
        $period = $request->period ?? '30'; // days

        $analytics = [
            'user_registrations' => User::where('created_at', '>=', now()->subDays($period))->count(),
            'content_views' => $this->getContentViews($period),
            'subscription_conversions' => User::where('subscription_tier', '!=', 'free')
                                             ->where('updated_at', '>=', now()->subDays($period))
                                             ->count(),
            'revenue_estimate' => $this->calculateRevenue($period),
            'top_content' => $this->getTopContent($period),
            'user_activity' => $this->getUserActivity($period),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    private function getContentViews($period)
    {
        // This would need to be implemented based on your view tracking system
        return [
            'movies' => Movie::sum('views_count'),
            'series' => Series::sum('views_count'),
            'sports' => Sport::sum('views_count'),
            'cartoons' => Cartoon::sum('views_count'),
            'documentaries' => Documentary::sum('views_count'),
        ];
    }

    private function calculateRevenue($period)
    {
        $tiers = [
            'basic' => 9.99,
            'premium' => 19.99,
            'platinum' => 29.99,
        ];

        $revenue = 0;
        foreach ($tiers as $tier => $price) {
            $users = User::where('subscription_tier', $tier)->count();
            $revenue += $users * $price;
        }

        return $revenue;
    }

    private function getTopContent($period)
    {
        return [
            'movies' => Movie::orderBy('views_count', 'desc')->take(5)->get(['id', 'title', 'views_count']),
            'series' => Series::orderBy('views_count', 'desc')->take(5)->get(['id', 'title', 'views_count']),
        ];
    }

    private function getUserActivity($period)
    {
        return [
            'active_users' => User::where('last_active_at', '>=', now()->subDays($period))->count(),
            'new_users' => User::where('created_at', '>=', now()->subDays($period))->count(),
        ];
    }
}