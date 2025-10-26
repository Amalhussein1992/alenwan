<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SportsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Sport::with(['category', 'language'])->published();

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

        if ($request->has('match_type') && $request->match_type) {
            $query->where('match_type', $request->match_type);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereJsonContains('teams', ['name' => $request->search]);
            });
        }

        // Apply date filters
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
                case 'today':
                    $query->whereDate('event_date', today());
                    break;
                case 'this_week':
                    $query->whereBetween('event_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'recent');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'event_date':
                $query->orderBy('event_date', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->recent();
        }

        $sports = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $sports,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $sport = Sport::with(['category', 'language'])->find($id);

        if (!$sport) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sports event not found'
            ], 404);
        }

        if ($sport->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Sports event not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($sport->subscription_tier);
        } else {
            $canAccess = $sport->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content',
                'data' => [
                    'required_tier' => $sport->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $sport->incrementViews();
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $sport->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'sport' => $sport,
                'is_favorited' => $isFavorited,
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function live(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $liveEvents = Sport::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->where('event_date', '<=', now())
            ->where('event_date', '>=', now()->subHours(3)) // Events that started within last 3 hours
            ->orderBy('event_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $liveEvents,
        ]);
    }

    public function upcoming(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $upcomingEvents = Sport::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->upcoming()
            ->orderBy('event_date', 'asc')
            ->limit(20)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $upcomingEvents,
        ]);
    }

    public function featured(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $featured = Sport::with(['category', 'language'])
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

    public function byCategory(Request $request, $categoryId)
    {
        $category = Category::where('type', 'sport')->findOrFail($categoryId);
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $sports = Sport::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byCategory($categoryId)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category,
                'sports' => $sports,
            ]
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $sport = Sport::findOrFail($id);

        $favorite = $sport->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $sport->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'sport_id' => $sport->id,
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

        $sport = Sport::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($sport->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $sport->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_urls' => [
                    'hls' => $sport->hls_url,
                    'mp4' => $sport->mp4_url,
                    'best' => $sport->best_playable_url,
                ],
                'sport' => $sport->only(['id', 'title', 'duration_minutes', 'teams', 'event_date']),
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

        $sport = Sport::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($sport->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription tier insufficient for this content'
            ], 403);
        }

        // Create download record
        $download = $sport->downloads()->create([
            'user_id' => $user->id,
            'file_path' => $sport->best_playable_url,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download initiated',
            'data' => [
                'download_id' => $download->id,
                'download_url' => $sport->best_playable_url,
                'sport' => $sport->only(['id', 'title', 'duration_minutes', 'teams', 'event_date']),
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'sport')
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

    public function matchTypes()
    {
        $matchTypes = Sport::select('match_type')
            ->distinct()
            ->whereNotNull('match_type')
            ->orderBy('match_type')
            ->pluck('match_type');

        return response()->json([
            'status' => 'success',
            'data' => $matchTypes,
        ]);
    }
}