<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documentary;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentariesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Documentary::with(['category', 'language'])->published();

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

        if ($request->has('director') && $request->director) {
            $query->byDirector($request->director);
        }

        if ($request->has('topic') && $request->topic) {
            $query->byTopic($request->topic);
        }

        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('director', 'like', '%' . $request->search . '%')
                  ->orWhereJsonContains('topics', $request->search);
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'recent');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'year':
                $query->orderBy('release_year', 'desc');
                break;
            case 'director':
                $query->orderBy('director', 'asc');
                break;
            default:
                $query->recent();
        }

        $documentaries = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $documentaries,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $documentary = Documentary::with(['category', 'language'])->find($id);

        if (!$documentary) {
            return response()->json([
                'status' => 'error',
                'message' => 'Documentary not found'
            ], 404);
        }

        if ($documentary->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Documentary not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($documentary->subscription_tier);
        } else {
            $canAccess = $documentary->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content',
                'data' => [
                    'required_tier' => $documentary->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $documentary->incrementViews();
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $documentary->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'documentary' => $documentary,
                'is_favorited' => $isFavorited,
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function featured(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $featured = Documentary::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->popular()
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $featured,
        ]);
    }

    public function recent(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $recent = Documentary::with(['category', 'language'])
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
        $category = Category::where('type', 'documentary')->findOrFail($categoryId);
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $documentaries = Documentary::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byCategory($categoryId)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category,
                'documentaries' => $documentaries,
            ]
        ]);
    }

    public function byDirector(Request $request, $director)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $documentaries = Documentary::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byDirector($director)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'director' => $director,
                'documentaries' => $documentaries,
            ]
        ]);
    }

    public function byTopic(Request $request, $topic)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $documentaries = Documentary::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byTopic($topic)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'topic' => $topic,
                'documentaries' => $documentaries,
            ]
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $documentary = Documentary::findOrFail($id);

        $favorite = $documentary->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $documentary->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'documentary_id' => $documentary->id,
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

        $documentary = Documentary::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($documentary->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $documentary->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_urls' => [
                    'hls' => $documentary->hls_url,
                    'mp4' => $documentary->mp4_url,
                    'best' => $documentary->best_playable_url,
                ],
                'documentary' => $documentary->only(['id', 'title', 'duration_minutes', 'director', 'topics']),
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

        $documentary = Documentary::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($documentary->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription tier insufficient for this content'
            ], 403);
        }

        // Create download record
        $download = $documentary->downloads()->create([
            'user_id' => $user->id,
            'file_path' => $documentary->best_playable_url,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download initiated',
            'data' => [
                'download_id' => $download->id,
                'download_url' => $documentary->best_playable_url,
                'documentary' => $documentary->only(['id', 'title', 'duration_minutes', 'director', 'topics']),
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'documentary')
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

    public function directors()
    {
        $directors = Documentary::select('director')
            ->distinct()
            ->whereNotNull('director')
            ->orderBy('director')
            ->pluck('director');

        return response()->json([
            'status' => 'success',
            'data' => $directors,
        ]);
    }

    public function topics()
    {
        // Get all unique topics from all documentaries
        $allTopics = Documentary::whereNotNull('topics')
            ->pluck('topics')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'status' => 'success',
            'data' => $allTopics,
        ]);
    }
}