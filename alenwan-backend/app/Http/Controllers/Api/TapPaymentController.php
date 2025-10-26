<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;

class TapPaymentController extends Controller
{
    private $tapApiKey;
    private $tapSecretKey;
    private $tapApiUrl;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['webhook']);
        $this->tapApiKey = env('TAP_API_KEY');
        $this->tapSecretKey = env('TAP_SECRET_KEY');
        $this->tapApiUrl = env('TAP_API_URL', 'https://api.tap.company/v2');
    }

    /**
     * Create Tap Payment Charge (For Apple Pay, Google Pay, Cards)
     */
    public function createCharge(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|in:apple_pay,google_pay,card',
            'save_card' => 'boolean',
            // For card payments
            'card_token' => 'required_if:payment_method,card',
            // For Apple Pay
            'apple_pay_token' => 'required_if:payment_method,apple_pay',
            // For Google Pay
            'google_pay_token' => 'required_if:payment_method,google_pay',
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        try {
            $chargeData = [
                'amount' => $plan->price,
                'currency' => $plan->currency ?? 'AED',
                'threeDSecure' => true,
                'save_card' => $request->save_card ?? false,
                'description' => "Subscription: {$plan->name} for {$user->name}",
                'statement_descriptor' => 'ALENWAN SUBSCRIPTION',
                'metadata' => [
                    'udf1' => 'Subscription Payment',
                    'udf2' => $plan->name,
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ],
                'reference' => [
                    'transaction' => 'txn_' . uniqid(),
                    'order' => 'ord_' . uniqid()
                ],
                'receipt' => [
                    'email' => true,
                    'sms' => false
                ],
                'customer' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => [
                        'country_code' => '971',
                        'number' => $user->phone ?? '501234567'
                    ]
                ],
                'source' => [
                    'id' => $this->getSourceId($request)
                ],
                'post' => [
                    'url' => env('APP_URL') . '/api/payment/tap/webhook'
                ],
                'redirect' => [
                    'url' => env('FRONTEND_URL') . '/payment/success'
                ]
            ];

            // Make API call to Tap
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tapApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->tapApiUrl . '/charges', $chargeData);

            if ($response->successful()) {
                $chargeResponse = $response->json();

                // Store payment record
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'amount' => $plan->price,
                    'currency' => $plan->currency ?? 'AED',
                    'payment_method' => $request->payment_method,
                    'payment_intent_id' => $chargeResponse['id'],
                    'status' => 'pending',
                    'payment_gateway' => 'tap',
                    'transaction_data' => json_encode($chargeResponse)
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment initiated successfully',
                    'data' => [
                        'charge_id' => $chargeResponse['id'],
                        'payment_id' => $payment->id,
                        'redirect_url' => $chargeResponse['transaction']['url'] ?? null,
                        'status' => $chargeResponse['status'],
                        'amount' => $plan->price,
                        'currency' => $plan->currency ?? 'AED'
                    ]
                ]);
            }

            Log::error('Tap Payment Failed', ['response' => $response->json()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment initiation failed',
                'errors' => $response->json()
            ], 400);

        } catch (\Exception $e) {
            Log::error('Tap Payment Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get source ID based on payment method
     */
    private function getSourceId($request)
    {
        switch ($request->payment_method) {
            case 'apple_pay':
                return $request->apple_pay_token;
            case 'google_pay':
                return $request->google_pay_token;
            case 'card':
                return $request->card_token;
            default:
                return 'src_all'; // Let Tap handle all payment methods
        }
    }

    /**
     * Tokenize Card (For storing cards securely)
     */
    public function tokenizeCard(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string',
            'exp_month' => 'required|integer|min:1|max:12',
            'exp_year' => 'required|integer|min:2024',
            'cvv' => 'required|string|size:3',
            'card_holder_name' => 'required|string'
        ]);

        try {
            $user = Auth::user();

            $cardData = [
                'type' => 'CARD',
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvv' => $request->cvv,
                    'name' => $request->card_holder_name,
                    'address' => [
                        'country' => 'AE'
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tapApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->tapApiUrl . '/tokens', $cardData);

            if ($response->successful()) {
                $tokenResponse = $response->json();

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'token' => $tokenResponse['id'],
                        'card' => [
                            'brand' => $tokenResponse['card']['brand'] ?? 'Unknown',
                            'last4' => $tokenResponse['card']['last_four'] ?? '****',
                            'exp_month' => $tokenResponse['card']['exp_month'],
                            'exp_year' => $tokenResponse['card']['exp_year']
                        ]
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Card tokenization failed',
                'errors' => $response->json()
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tokenization failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Payment Status
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'charge_id' => 'required|string'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tapApiKey,
            ])->get($this->tapApiUrl . '/charges/' . $request->charge_id);

            if ($response->successful()) {
                $charge = $response->json();
                $payment = Payment::where('payment_intent_id', $request->charge_id)->first();

                if ($payment) {
                    $this->updatePaymentStatus($payment, $charge);
                }

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'charge_status' => $charge['status'],
                        'payment_status' => $payment->status ?? 'not_found',
                        'subscription_active' => $payment && $payment->status === 'completed'
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
                'message' => 'Verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tap Webhook Handler
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('Tap Webhook Received', $payload);

            // Verify webhook signature (implement based on Tap documentation)
            $chargeId = $payload['id'] ?? null;
            $status = $payload['status'] ?? null;

            if (!$chargeId) {
                return response()->json(['status' => 'error'], 400);
            }

            $payment = Payment::where('payment_intent_id', $chargeId)->first();

            if ($payment) {
                $this->updatePaymentStatus($payment, $payload);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Tap Webhook Error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Update Payment Status
     */
    private function updatePaymentStatus($payment, $chargeData)
    {
        $status = $chargeData['status'];

        switch ($status) {
            case 'CAPTURED':
            case 'AUTHORIZED':
                $payment->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'transaction_data' => json_encode($chargeData)
                ]);

                // Activate subscription
                $this->activateSubscription($payment);
                break;

            case 'FAILED':
                $payment->update([
                    'status' => 'failed',
                    'failure_reason' => $chargeData['response']['message'] ?? 'Payment failed',
                    'transaction_data' => json_encode($chargeData)
                ]);
                break;

            case 'CANCELLED':
                $payment->update([
                    'status' => 'cancelled',
                    'transaction_data' => json_encode($chargeData)
                ]);
                break;

            default:
                $payment->update([
                    'transaction_data' => json_encode($chargeData)
                ]);
                break;
        }
    }

    /**
     * Activate User Subscription
     */
    private function activateSubscription($payment)
    {
        $user = $payment->user;
        $plan = $payment->subscriptionPlan;

        if (!$plan) {
            Log::error('Subscription plan not found for payment', ['payment_id' => $payment->id]);
            return;
        }

        $user->update([
            'subscription_tier' => $plan->tier,
            'subscription_plan_id' => $plan->id,
            'subscription_expires_at' => now()->addDays($plan->duration_days),
            'subscription_auto_renew' => true,
            'subscription_status' => 'active'
        ]);

        Log::info('Subscription activated', [
            'user_id' => $user->id,
            'plan' => $plan->name,
            'expires_at' => $user->subscription_expires_at
        ]);
    }

    /**
     * Get Saved Cards
     */
    public function getSavedCards()
    {
        $user = Auth::user();

        // Implement based on your database schema
        // This would fetch saved card tokens from your database

        return response()->json([
            'status' => 'success',
            'data' => [
                'cards' => []
            ]
        ]);
    }

    /**
     * Get Subscription Plans
     */
    public function getPlans()
    {
        $plans = SubscriptionPlan::where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $plans
        ]);
    }
}
