<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Series::with(['category', 'language'])->published();

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

        $series = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $series,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $series = Series::with(['category', 'language', 'episodes' => function($query) {
            $query->published()->orderBy('season_number')->orderBy('episode_number');
        }])->find($id);

        if (!$series) {
            return response()->json([
                'status' => 'error',
                'message' => 'Series not found'
            ], 404);
        }

        if ($series->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Series not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($series->subscription_tier);
        } else {
            $canAccess = $series->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content',
                'data' => [
                    'required_tier' => $series->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $series->incrementViews();
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $series->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'series' => $series,
                'is_favorited' => $isFavorited,
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function episodes(Request $request, $id)
    {
        $user = $request->user();
        $series = Series::findOrFail($id);

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($series->subscription_tier);
        } else {
            $canAccess = $series->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content'
            ], 403);
        }

        $query = Episode::where('series_id', $id)->published();

        // Filter by season if provided
        if ($request->has('season') && $request->season) {
            $query->bySeason($request->season);
        }

        $episodes = $query->orderBy('season_number')
                         ->orderBy('episode_number')
                         ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'series' => $series->only(['id', 'title', 'total_seasons', 'total_episodes']),
                'episodes' => $episodes,
            ]
        ]);
    }

    public function episode(Request $request, $seriesId, $episodeId)
    {
        $user = $request->user();
        $series = Series::findOrFail($seriesId);
        $episode = Episode::where('series_id', $seriesId)->findOrFail($episodeId);

        if ($episode->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Episode not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($series->subscription_tier);
        } else {
            $canAccess = $series->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content'
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $episode->incrementViews();
            $series->incrementViews();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'series' => $series->only(['id', 'title', 'subscription_tier']),
                'episode' => $episode,
                'next_episode' => $episode->getNextEpisode(),
                'previous_episode' => $episode->getPreviousEpisode(),
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function getStreamingUrl(Request $request, $seriesId, $episodeId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required'
            ], 401);
        }

        $series = Series::findOrFail($seriesId);
        $episode = Episode::where('series_id', $seriesId)->findOrFail($episodeId);

        // Check subscription access
        if (!$user->canAccessContent($series->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $series->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_urls' => [
                    'hls' => $episode->hls_url,
                    'mp4' => $episode->mp4_url,
                    'best' => $episode->best_playable_url,
                ],
                'episode' => $episode->only(['id', 'title', 'duration_minutes', 'episode_identifier']),
                'series' => $series->only(['id', 'title']),
            ]
        ]);
    }

    public function downloadLink(Request $request, $seriesId, $episodeId)
    {
        $user = $request->user();

        if (!$user || !$user->hasActiveSubscription()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Active subscription required for downloads'
            ], 403);
        }

        $series = Series::findOrFail($seriesId);
        $episode = Episode::where('series_id', $seriesId)->findOrFail($episodeId);

        // Check subscription access
        if (!$user->canAccessContent($series->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription tier insufficient for this content'
            ], 403);
        }

        // Create download record
        $download = $episode->downloads()->create([
            'user_id' => $user->id,
            'file_path' => $episode->best_playable_url,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download initiated',
            'data' => [
                'download_id' => $download->id,
                'download_url' => $episode->best_playable_url,
                'episode' => $episode->only(['id', 'title', 'duration_minutes', 'episode_identifier']),
                'series' => $series->only(['id', 'title']),
            ]
        ]);
    }

    public function featured(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $featured = Series::with(['category', 'language'])
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

        $trending = Series::with(['category', 'language'])
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

        $recent = Series::with(['category', 'language'])
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
        $category = Category::where('type', 'series')->findOrFail($categoryId);
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $series = Series::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byCategory($categoryId)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category,
                'series' => $series,
            ]
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $series = Series::findOrFail($id);

        $favorite = $series->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $series->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'series_id' => $series->id,
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'series')
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