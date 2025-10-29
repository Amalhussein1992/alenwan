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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();

            // Gateway Information
            $table->string('name'); // Stripe, PayPal, Paymob, Apple Pay, Google Pay
            $table->string('slug')->unique(); // stripe, paypal, paymob, apple_pay, google_pay
            $table->text('description')->nullable();
            $table->string('logo')->nullable();

            // Status
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);
            $table->integer('order')->default(0);

            // API Credentials (Encrypted)
            $table->text('api_key')->nullable(); // Public key / Client ID
            $table->text('api_secret')->nullable(); // Secret key / Client Secret
            $table->text('webhook_secret')->nullable(); // Webhook signing secret
            $table->text('additional_config')->nullable(); // JSON for extra configs

            // Supported Features
            $table->boolean('supports_subscription')->default(true);
            $table->boolean('supports_refund')->default(true);
            $table->boolean('supports_webhook')->default(true);

            // Currency & Fees
            $table->json('supported_currencies')->nullable(); // ["USD", "EUR", "SAR", "EGP"]
            $table->string('default_currency', 3)->default('USD');
            $table->decimal('transaction_fee_percentage', 5, 2)->default(0); // 2.9%
            $table->decimal('transaction_fee_fixed', 10, 2)->default(0); // $0.30

            // Limits
            $table->decimal('min_amount', 10, 2)->nullable();
            $table->decimal('max_amount', 10, 2)->nullable();

            // URLs
            $table->string('success_url')->nullable();
            $table->string('cancel_url')->nullable();
            $table->string('webhook_url')->nullable();

            // Statistics
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->integer('successful_transactions')->default(0);
            $table->integer('failed_transactions')->default(0);

            // Additional Settings
            $table->json('allowed_countries')->nullable(); // ["US", "SA", "EG"]
            $table->json('allowed_payment_methods')->nullable(); // ["card", "wallet"]
            $table->text('instructions')->nullable(); // Setup instructions

            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
