<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // User Information
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->nullable()->constrained()->onDelete('set null');

            // Transaction Details
            $table->string('transaction_id')->unique(); // Internal transaction ID
            $table->string('payment_gateway'); // stripe, paypal, paymob, apple_pay, google_pay
            $table->string('gateway_transaction_id')->nullable(); // Gateway's transaction ID

            // Payment Information
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD'); // USD, EUR, SAR, EGP
            $table->decimal('gateway_fee', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2); // amount - gateway_fee

            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending');

            // Payment Method Details
            $table->string('payment_method')->nullable(); // card, wallet, bank_transfer
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable(); // visa, mastercard, amex

            // Additional Information
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Store additional data
            $table->json('gateway_response')->nullable(); // Full gateway response

            // Refund Information
            $table->boolean('is_refunded')->default(false);
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->text('refund_reason')->nullable();

            // IP and Device Information
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_type')->nullable(); // ios, android, web

            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('payment_gateway');
            $table->index('status');
            $table->index('transaction_id');
            $table->index('gateway_transaction_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
