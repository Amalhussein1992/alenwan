<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $plans = [
            [
                'id' => 'free',
                'name' => 'Free',
                'description' => 'Access to free content only',
                'price' => 0,
                'currency' => 'USD',
                'period' => 'lifetime',
                'features' => [
                    'Access to free movies and series',
                    'Access to free sports content',
                    'Basic streaming quality',
                    'Limited downloads per day',
                    'Ads supported'
                ],
                'max_devices' => 2,
                'download_limit' => 5,
                'streaming_quality' => 'standard',
            ],
            [
                'id' => 'basic',
                'name' => 'Basic',
                'description' => 'Essential entertainment package',
                'price' => 9.99,
                'currency' => 'USD',
                'period' => 'monthly',
                'features' => [
                    'Access to free and basic content',
                    'HD streaming quality',
                    'Unlimited downloads',
                    'Ad-free experience',
                    'Access to basic sports events'
                ],
                'max_devices' => 3,
                'download_limit' => -1, // unlimited
                'streaming_quality' => 'hd',
            ],
            [
                'id' => 'premium',
                'name' => 'Premium',
                'description' => 'Complete entertainment experience',
                'price' => 19.99,
                'currency' => 'USD',
                'period' => 'monthly',
                'features' => [
                    'Access to all content up to premium tier',
                    'Full HD streaming quality',
                    'Unlimited downloads',
                    'Ad-free experience',
                    'Access to premium sports and live events',
                    'Offline viewing',
                    'Multiple user profiles'
                ],
                'max_devices' => 5,
                'download_limit' => -1,
                'streaming_quality' => 'full_hd',
            ],
            [
                'id' => 'platinum',
                'name' => 'Platinum',
                'description' => 'Ultimate entertainment package',
                'price' => 29.99,
                'currency' => 'USD',
                'period' => 'monthly',
                'features' => [
                    'Access to all content including platinum exclusives',
                    '4K Ultra HD streaming quality',
                    'Unlimited downloads',
                    'Ad-free experience',
                    'Access to all sports and live events',
                    'Offline viewing',
                    'Multiple user profiles',
                    'Early access to new releases',
                    'Premium customer support'
                ],
                'max_devices' => 10,
                'download_limit' => -1,
                'streaming_quality' => '4k',
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $plans
        ]);
    }

    public function current(Request $request)
    {
        $user = $request->user();

        $subscription = [
            'tier' => $user->subscription_tier,
            'expires_at' => $user->subscription_expires_at,
            'is_active' => $user->hasActiveSubscription(),
            'days_remaining' => $user->subscription_expires_at ?
                now()->diffInDays($user->subscription_expires_at, false) : null,
            'auto_renew' => false, // This would come from payment provider
        ];

        // Get current plan details
        $plans = $this->getPlansArray();
        $currentPlan = collect($plans)->firstWhere('id', $user->subscription_tier);

        return response()->json([
            'status' => 'success',
            'data' => [
                'subscription' => $subscription,
                'plan' => $currentPlan,
                'usage' => [
                    'devices_count' => $user->devices()->where('is_active', true)->count(),
                    'max_devices' => $user->max_devices,
                    'downloads_today' => $user->downloads()
                        ->whereDate('created_at', today())
                        ->count(),
                ]
            ]
        ]);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|in:basic,premium,platinum',
            'payment_method' => 'required|string',
            'payment_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $planId = $request->plan_id;

        // In a real application, you would integrate with a payment provider
        // like Stripe, PayPal, etc. Here we'll simulate the subscription

        $plans = $this->getPlansArray();
        $plan = collect($plans)->firstWhere('id', $planId);

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid plan selected'
            ], 400);
        }

        // Simulate payment processing
        // In reality, you would:
        // 1. Charge the payment method
        // 2. Create subscription record with payment provider
        // 3. Handle webhooks for subscription status updates

        $expiresAt = now()->addDays(30); // Monthly subscription
        $maxDevices = $plan['max_devices'];

        $user->update([
            'subscription_tier' => $planId,
            'subscription_expires_at' => $expiresAt,
            'max_devices' => $maxDevices,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription activated successfully',
            'data' => [
                'tier' => $user->subscription_tier,
                'expires_at' => $user->subscription_expires_at,
                'plan' => $plan,
            ]
        ]);
    }

    public function cancel(Request $request)
    {
        $user = $request->user();

        if ($user->subscription_tier === 'free') {
            return response()->json([
                'status' => 'error',
                'message' => 'No active subscription to cancel'
            ], 400);
        }

        // In a real application, you would cancel the subscription with the payment provider
        // and set it to not auto-renew, but keep access until the current period ends

        $user->update([
            'subscription_tier' => 'free',
            'subscription_expires_at' => null,
            'max_devices' => 2,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription cancelled successfully',
            'data' => [
                'tier' => $user->subscription_tier,
                'expires_at' => $user->subscription_expires_at,
            ]
        ]);
    }

    public function upgrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_plan_id' => 'required|in:basic,premium,platinum',
            'payment_method' => 'sometimes|string',
            'payment_token' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $newPlanId = $request->new_plan_id;
        $currentPlanId = $user->subscription_tier;

        $plans = $this->getPlansArray();
        $tierHierarchy = ['free' => 0, 'basic' => 1, 'premium' => 2, 'platinum' => 3];

        if ($tierHierarchy[$newPlanId] <= $tierHierarchy[$currentPlanId]) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot upgrade to a lower or same tier'
            ], 400);
        }

        $newPlan = collect($plans)->firstWhere('id', $newPlanId);

        // Calculate prorated amount and process payment
        // In reality, you would handle prorated billing here

        $user->update([
            'subscription_tier' => $newPlanId,
            'max_devices' => $newPlan['max_devices'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription upgraded successfully',
            'data' => [
                'old_tier' => $currentPlanId,
                'new_tier' => $user->subscription_tier,
                'plan' => $newPlan,
            ]
        ]);
    }

    public function validateAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content_type' => 'required|in:movie,series,sport,cartoon,documentary,channel',
            'content_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $contentType = $request->content_type;
        $contentId = $request->content_id;

        // Get the content model
        $modelClass = $this->getContentModel($contentType);
        $content = $modelClass::find($contentId);

        if (!$content) {
            return response()->json([
                'status' => 'error',
                'message' => 'Content not found'
            ], 404);
        }

        $canAccess = $user ? $user->canAccessContent($content->subscription_tier) :
                           ($content->subscription_tier === 'free');

        return response()->json([
            'status' => 'success',
            'data' => [
                'can_access' => $canAccess,
                'content_tier' => $content->subscription_tier,
                'user_tier' => $user ? $user->subscription_tier : 'free',
                'subscription_active' => $user ? $user->hasActiveSubscription() : false,
            ]
        ]);
    }

    public function history(Request $request)
    {
        $user = $request->user();

        // In a real application, this would come from payment provider records
        $history = [
            [
                'id' => 1,
                'plan' => 'premium',
                'amount' => 19.99,
                'currency' => 'USD',
                'status' => 'completed',
                'period_start' => now()->subMonth(),
                'period_end' => now(),
                'created_at' => now()->subMonth(),
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $history
        ]);
    }

    private function getPlansArray()
    {
        return [
            [
                'id' => 'free',
                'name' => 'Free',
                'max_devices' => 2,
            ],
            [
                'id' => 'basic',
                'name' => 'Basic',
                'max_devices' => 3,
            ],
            [
                'id' => 'premium',
                'name' => 'Premium',
                'max_devices' => 5,
            ],
            [
                'id' => 'platinum',
                'name' => 'Platinum',
                'max_devices' => 10,
            ]
        ];
    }

    private function getContentModel($type)
    {
        return match($type) {
            'movie' => \App\Models\Movie::class,
            'series' => \App\Models\Series::class,
            'sport' => \App\Models\Sport::class,
            'cartoon' => \App\Models\Cartoon::class,
            'documentary' => \App\Models\Documentary::class,
            'channel' => \App\Models\Channel::class,
            default => null
        };
    }
}