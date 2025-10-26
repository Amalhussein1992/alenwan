<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscriptionPlan;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Create payment intent for subscription
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|in:stripe,paypal,apple_pay,google_pay'
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        try {
            // Initialize Stripe (you'll need to install stripe-php package)
            if ($request->payment_method === 'stripe') {
                return $this->createStripePaymentIntent($user, $plan);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Payment method not supported yet'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Stripe payment intent
     */
    private function createStripePaymentIntent($user, $plan)
    {
        // This would use the Stripe SDK
        // For now, return a mock response
        $paymentIntentId = 'pi_' . uniqid();

        // Store payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $plan->price * 100, // Stripe uses cents
            'currency' => $plan->currency,
            'payment_method' => 'stripe',
            'payment_intent_id' => $paymentIntentId,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'client_secret' => $paymentIntentId . '_secret_' . uniqid(),
                'payment_id' => $payment->id,
                'amount' => $plan->price,
                'currency' => $plan->currency
            ]
        ]);
    }

    /**
     * Confirm payment and activate subscription
     */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'payment_intent_id' => 'required|string'
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        $user = Auth::user();

        if ($payment->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            // Verify payment with Stripe
            $verified = $this->verifyStripePayment($payment, $request->payment_intent_id);

            if ($verified) {
                // Update payment status
                $payment->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);

                // Update user subscription
                $plan = $payment->subscriptionPlan;
                $user->update([
                    'subscription_tier' => $plan->tier,
                    'subscription_expires_at' => now()->addDays($plan->duration_days),
                    'subscription_auto_renew' => true
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment confirmed and subscription activated',
                    'data' => [
                        'subscription_tier' => $user->subscription_tier,
                        'expires_at' => $user->subscription_expires_at
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment confirmation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Stripe payment
     */
    private function verifyStripePayment($payment, $paymentIntentId)
    {
        // This would use Stripe API to verify the payment
        // For development, return true
        return $payment->payment_intent_id === $paymentIntentId;
    }

    /**
     * Handle Stripe webhook
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            // Verify webhook signature (implement with Stripe SDK)
            $event = $this->verifyStripeWebhook($payload, $signature);

            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $this->handlePaymentSuccess($event['data']['object']);
                    break;

                case 'payment_intent.payment_failed':
                    $this->handlePaymentFailure($event['data']['object']);
                    break;

                case 'invoice.payment_succeeded':
                    $this->handleSubscriptionRenewal($event['data']['object']);
                    break;

                default:
                    // Unhandled event type
                    break;
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Webhook processing failed'
            ], 400);
        }
    }

    /**
     * Handle successful payment
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $payment = Payment::where('payment_intent_id', $paymentIntent['id'])->first();

        if ($payment && $payment->status === 'pending') {
            $payment->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Activate subscription
            $user = $payment->user;
            $plan = $payment->subscriptionPlan;

            $user->update([
                'subscription_tier' => $plan->tier,
                'subscription_expires_at' => now()->addDays($plan->duration_days),
                'subscription_auto_renew' => true
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $payment = Payment::where('payment_intent_id', $paymentIntent['id'])->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $paymentIntent['last_payment_error']['message'] ?? 'Unknown error'
            ]);
        }
    }

    /**
     * Handle subscription renewal
     */
    private function handleSubscriptionRenewal($invoice)
    {
        // Handle automatic subscription renewals
        // Implementation depends on your subscription model
    }

    /**
     * Verify Stripe webhook signature
     */
    private function verifyStripeWebhook($payload, $signature)
    {
        // This would use Stripe SDK to verify webhook
        // For development, return decoded payload
        return json_decode($payload, true);
    }

    /**
     * Get payment history
     */
    public function getPaymentHistory(Request $request)
    {
        $user = Auth::user();

        $payments = Payment::where('user_id', $user->id)
                          ->with('subscriptionPlan')
                          ->latest()
                          ->paginate($request->per_page ?? 10);

        return response()->json([
            'status' => 'success',
            'data' => $payments
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();

        if ($user->subscription_tier === 'free') {
            return response()->json([
                'status' => 'error',
                'message' => 'No active subscription to cancel'
            ], 400);
        }

        $user->update([
            'subscription_auto_renew' => false,
            'subscription_cancelled_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription cancelled. Access will continue until ' . $user->subscription_expires_at->format('Y-m-d')
        ]);
    }
}