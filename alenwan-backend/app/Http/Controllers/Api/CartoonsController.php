<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cartoon;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartoonsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Cartoon::with(['category', 'language'])->published();

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

        if ($request->has('age_rating') && $request->age_rating) {
            $query->byAgeRating($request->age_rating);
        }

        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
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
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'year':
                $query->orderBy('release_year', 'desc');
                break;
            default:
                $query->recent();
        }

        $cartoons = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $cartoons,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $cartoon = Cartoon::with(['category', 'language'])->find($id);

        if (!$cartoon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cartoon not found'
            ], 404);
        }

        if ($cartoon->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cartoon not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($cartoon->subscription_tier);
        } else {
            $canAccess = $cartoon->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this content',
                'data' => [
                    'required_tier' => $cartoon->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Increment views if user is authenticated
        if ($user) {
            $cartoon->incrementViews();
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $cartoon->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'cartoon' => $cartoon,
                'is_favorited' => $isFavorited,
                'can_download' => $canAccess && $user && $user->hasActiveSubscription(),
            ]
        ]);
    }

    public function featured(Request $request)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $featured = Cartoon::with(['category', 'language'])
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

        $recent = Cartoon::with(['category', 'language'])
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
        $category = Category::where('type', 'cartoon')->findOrFail($categoryId);
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $cartoons = Cartoon::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byCategory($categoryId)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category,
                'cartoons' => $cartoons,
            ]
        ]);
    }

    public function byAgeRating(Request $request, $ageRating)
    {
        $user = $request->user();
        $userTier = $user ? ($user->hasActiveSubscription() ? $user->subscription_tier : 'free') : 'free';

        $cartoons = Cartoon::with(['category', 'language'])
            ->published()
            ->forSubscriptionTier($userTier)
            ->byAgeRating($ageRating)
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'age_rating' => $ageRating,
                'cartoons' => $cartoons,
            ]
        ]);
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $cartoon = Cartoon::findOrFail($id);

        $favorite = $cartoon->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $cartoon->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'cartoon_id' => $cartoon->id,
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

        $cartoon = Cartoon::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($cartoon->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $cartoon->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_urls' => [
                    'hls' => $cartoon->hls_url,
                    'mp4' => $cartoon->mp4_url,
                    'best' => $cartoon->best_playable_url,
                ],
                'cartoon' => $cartoon->only(['id', 'title', 'duration_minutes', 'age_rating']),
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

        $cartoon = Cartoon::findOrFail($id);

        // Check subscription access
        if (!$user->canAccessContent($cartoon->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription tier insufficient for this content'
            ], 403);
        }

        // Create download record
        $download = $cartoon->downloads()->create([
            'user_id' => $user->id,
            'file_path' => $cartoon->best_playable_url,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download initiated',
            'data' => [
                'download_id' => $download->id,
                'download_url' => $cartoon->best_playable_url,
                'cartoon' => $cartoon->only(['id', 'title', 'duration_minutes', 'age_rating']),
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'cartoon')
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

    public function ageRatings()
    {
        $ageRatings = Cartoon::select('age_rating')
            ->distinct()
            ->whereNotNull('age_rating')
            ->orderBy('age_rating')
            ->pluck('age_rating');

        return response()->json([
            'status' => 'success',
            'data' => $ageRatings,
        ]);
    }
}