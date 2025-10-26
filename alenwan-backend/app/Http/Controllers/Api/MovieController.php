<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Movie::with(['category', 'language'])->published();

        // Apply subscription tier filter
        if ($user) {
            $userTier = $user->hasActiveSubscription() ? $user->subscription_tier : 'free';
            $query->forSubscriptionTier($userTier);
        } else {
            $query->forSubscriptionTier('free');
        }

        // Apply filters
        if ($request->has('category_id') && $request->category_id) {
            $query->byCategory($request->category_id);
        }

        if ($request->has('language_id') && $request->language_id) {
            $query->byLanguage($request->language_id);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'recent');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'rating':
                $query->highRated();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'year':
                $query->orderBy('release_year', 'desc');
                break;
            default:
                $query->recent();
        }

        $movies = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $movies,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $movie = Movie::with(['category', 'language'])->find($id);

        if (!$movie) {
            return response()->json([
                'status' => 'error',
                'message' => 'Movie not found'
            ], 404);
        }

        if ($movie->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Movie not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($movie->subscription_tier);
        } else {
            $canAccess = $movie->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content',
                'data' => [
                    'required_tier' => $movie->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $movie->incrementViews();
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $movie->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'movie' => $movie,
                'is_favorited' => $isFavorited,
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function featured(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $featured = Movie::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->where('rating', '>=', 4.0)
            ->popular()
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $featured,
        ]);
    }

    public function trending(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $trending = Movie::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->where('created_at', '>=', now()->subDays(30))
            ->popular()
            ->limit(15)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $trending,
        ]);
    }

    public function recent(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $recent = Movie::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->recent()
            ->limit(20)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $recent,
        ]);
    }

    public function byCategory(Request $request, $categoryId)
    {
        $category = Category::where('type', 'movie')->findOrFail($categoryId);
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $movies = Movie::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byCategory($categoryId)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category,
                'movies' => $movies,
            ]
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $movie = Movie::findOrFail($id);

        $favorite = $movie->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $movie->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'movie_id' => $movie->id,
            ]
        ]);
    }

    public function getStreamingUrl(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required'
            ], 401);
        }

        $movie = Movie::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($movie->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $movie->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_url' => $movie->video_url,
                'movie' => $movie->only(['id', 'title', 'duration']),
            ]
        ]);
    }

    public function downloadLink(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || !$user->hasActiveSubscription()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Active subscription required for downloads'
            ], 403);
        }

        $movie = Movie::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($movie->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription tier insufficient for this content'
            ], 403);
        }

        // Create download record
        $download = $movie->downloads()->create([
            'user_id' => $user->id,
            'file_path' => $movie->video_url,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download initiated',
            'data' => [
                'download_id' => $download->id,
                'download_url' => $movie->video_url,
                'movie' => $movie->only(['id', 'title', 'duration']),
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'movie')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }

    public function languages()
    {
        $languages = Language::where('is_active', true)->get();

        return response()->json([
            'status' => 'success',
            'data' => $languages,
        ]);
    }
}