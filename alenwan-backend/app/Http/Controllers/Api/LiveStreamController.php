<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\LiveStream;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveStreamController extends Controller
{
    public function channels(Request $request)
    {
        $user = $request->user();
        $query = Channel::with(['category', 'language', 'currentLiveStream'])->active();

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

        if ($request->has('live_only') && $request->live_only) {
            $query->live();
        }

        $channels = $query->ordered()->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $channels,
        ]);
    }

    public function channel(Request $request, $id)
    {
        $user = $request->user();
        $channel = Channel::with(['category', 'language', 'currentLiveStream'])->find($id);

        if (!$channel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Channel not found'
            ], 404);
        }

        if ($channel->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Channel not available'
            ], 403);
        }

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($channel->subscription_tier);
        } else {
            $canAccess = $channel->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this channel',
                'data' => [
                    'required_tier' => $channel->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        // Check if favorited
        $isFavorited = false;
        if ($user) {
            $isFavorited = $channel->favorites()->where('user_id', $user->id)->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'channel' => $channel,
                'is_favorited' => $isFavorited,
                'current_stream' => $channel->currentLiveStream,
            ]
        ]);
    }

    public function liveStreams(Request $request)
    {
        $user = $request->user();
        $query = LiveStream::with(['channel.category', 'channel.language'])->live();

        // Apply subscription tier filter through channel
        if ($user) {
            $userTier = $user->hasActiveSubscription() ? $user->subscription_tier : 'free';
            $query->whereHas('channel', function($q) use ($userTier) {
                $q->forSubscriptionTier($userTier);
            });
        } else {
            $query->whereHas('channel', function($q) {
                $q->forSubscriptionTier('free');
            });
        }

        $liveStreams = $query->orderBy('viewers_count', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $liveStreams,
        ]);
    }

    public function upcomingStreams(Request $request)
    {
        $user = $request->user();
        $query = LiveStream::with(['channel.category', 'channel.language'])->upcoming();

        // Apply subscription tier filter through channel
        if ($user) {
            $userTier = $user->hasActiveSubscription() ? $user->subscription_tier : 'free';
            $query->whereHas('channel', function($q) use ($userTier) {
                $q->forSubscriptionTier($userTier);
            });
        } else {
            $query->whereHas('channel', function($q) {
                $q->forSubscriptionTier('free');
            });
        }

        $upcomingStreams = $query->orderBy('scheduled_start', 'asc')
                                ->limit(20)
                                ->get();

        return response()->json([
            'status' => 'success',
            'data' => $upcomingStreams,
        ]);
    }

    public function stream(Request $request, $streamId)
    {
        $user = $request->user();
        $stream = LiveStream::with(['channel.category', 'channel.language'])->find($streamId);

        if (!$stream) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stream not found'
            ], 404);
        }

        // Check subscription access through channel
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($stream->channel->subscription_tier);
        } else {
            $canAccess = $stream->channel->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to access this stream',
                'data' => [
                    'required_tier' => $stream->channel->subscription_tier,
                    'user_tier' => $user ? $user->subscription_tier : 'free'
                ]
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'stream' => $stream,
                'channel' => $stream->channel,
            ]
        ]);
    }

    public function getStreamingUrl(Request $request, $streamId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required'
            ], 401);
        }

        $stream = LiveStream::with('channel')->findOrFail($streamId);

        // Check subscription access
        if (!$user->canAccessContent($stream->channel->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to stream this content',
                'data' => [
                    'required_tier' => $stream->channel->subscription_tier,
                    'user_tier' => $user->subscription_tier
                ]
            ], 403);
        }

        // Increment viewer count if stream is live
        if ($stream->is_live) {
            $stream->incrementViewers();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'streaming_urls' => [
                    'youtube_watch' => $stream->youtube_watch_url,
                    'youtube_embed' => $stream->youtube_embed_url,
                    'direct_stream' => $stream->stream_url,
                ],
                'stream' => $stream->only(['id', 'title', 'status', 'viewers_count']),
                'channel' => $stream->channel->only(['id', 'name']),
            ]
        ]);
    }

    public function joinStream(Request $request, $streamId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required'
            ], 401);
        }

        $stream = LiveStream::with('channel')->findOrFail($streamId);

        // Check if stream is live
        if (!$stream->is_live) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stream is not currently live'
            ], 400);
        }

        // Check subscription access
        if (!$user->canAccessContent($stream->channel->subscription_tier)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to join this stream'
            ], 403);
        }

        // Increment viewer count
        $stream->incrementViewers();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully joined the stream',
            'data' => [
                'stream' => $stream,
                'viewers_count' => $stream->viewers_count,
            ]
        ]);
    }

    public function leaveStream(Request $request, $streamId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required'
            ], 401);
        }

        $stream = LiveStream::findOrFail($streamId);

        // Decrement viewer count
        $stream->decrementViewers();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully left the stream',
            'data' => [
                'viewers_count' => $stream->viewers_count,
            ]
        ]);
    }

    public function toggleFavoriteChannel(Request $request, $channelId)
    {
        $user = $request->user();
        $channel = Channel::findOrFail($channelId);

        $favorite = $channel->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
            $channel->favorites()->create(['user_id' => $user->id]);
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'is_favorited' => $isFavorited,
                'channel_id' => $channel->id,
            ]
        ]);
    }

    public function channelSchedule(Request $request, $channelId)
    {
        $channel = Channel::findOrFail($channelId);
        $user = $request->user();

        // Check subscription access
        $canAccess = false;
        if ($user) {
            $canAccess = $user->canAccessContent($channel->subscription_tier);
        } else {
            $canAccess = $channel->subscription_tier === 'free';
        }

        if (!$canAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subscription required to view schedule'
            ], 403);
        }

        $schedule = LiveStream::where('channel_id', $channelId)
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('scheduled_start', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'channel' => $channel->only(['id', 'name', 'description']),
                'schedule' => $schedule,
            ]
        ]);
    }

    public function categories()
    {
        $categories = Category::where('type', 'channel')
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