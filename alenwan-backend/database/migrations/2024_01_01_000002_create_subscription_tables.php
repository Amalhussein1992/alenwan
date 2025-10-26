<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTables extends Migration
{
    public function up()
    {
        // Subscription plans
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2);
            $table->decimal('price_lifetime', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->json('features');
            $table->integer('max_devices')->default(5);
            $table->integer('max_downloads')->default(0); // 0 = unlimited
            $table->integer('max_profiles')->default(5);
            $table->boolean('supports_4k')->default(false);
            $table->boolean('supports_hdr')->default(false);
            $table->boolean('supports_offline')->default(false);
            $table->boolean('no_ads')->default(true);
            $table->integer('trial_days')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_monthly_id')->nullable();
            $table->string('stripe_price_yearly_id')->nullable();
            $table->string('apple_product_id')->nullable();
            $table->string('google_product_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index(['is_active', 'sort_order']);
        });

        // User subscriptions
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans');
            $table->enum('billing_cycle', ['monthly', 'yearly', 'lifetime']);
            $table->enum('status', ['trial', 'active', 'cancelled', 'expired', 'past_due']);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('payment_method')->nullable(); // stripe, apple, google
            $table->string('stripe_subscription_id')->nullable();
            $table->string('apple_transaction_id')->nullable();
            $table->string('google_order_id')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('ends_at');
        });

        // Payment methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['card', 'paypal', 'apple_pay', 'google_pay', 'crypto']);
            $table->string('provider'); // stripe, paypal, etc.
            $table->string('provider_payment_method_id')->nullable();
            $table->string('brand')->nullable(); // visa, mastercard, etc.
            $table->string('last_four')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('email')->nullable(); // for paypal
            $table->string('wallet_address')->nullable(); // for crypto
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });

        // Payment transactions
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods');
            $table->string('transaction_id')->unique();
            $table->enum('type', ['subscription', 'one_time', 'refund', 'charge_back']);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded']);
            $table->decimal('amount', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency', 3);
            $table->string('payment_provider'); // stripe, paypal, apple, google
            $table->string('provider_transaction_id')->nullable();
            $table->string('provider_receipt_url')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('transaction_id');
            $table->index('created_at');
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained('payment_transactions');
            $table->string('invoice_number')->unique();
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled']);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency', 3);
            $table->json('billing_address')->nullable();
            $table->json('items');
            $table->text('notes')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('pdf_url')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('invoice_number');
        });

        // Coupons and discounts
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description');
            $table->enum('type', ['percentage', 'fixed', 'trial_extension']);
            $table->decimal('value', 10, 2);
            $table->integer('trial_days')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->integer('usage_per_user')->default(1);
            $table->json('applicable_plans')->nullable(); // null = all plans
            $table->timestamp('valid_from');
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['code', 'is_active']);
            $table->index(['valid_from', 'valid_until']);
        });

        // Discount usage tracking
        Schema::create('discount_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discount_id')->constrained('discount_codes');
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions');
            $table->decimal('discount_amount', 10, 2);
            $table->string('currency', 3);
            $table->timestamps();

            $table->index(['user_id', 'discount_id']);
            $table->unique(['user_id', 'discount_id', 'subscription_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_usages');
        Schema::dropIfExists('discount_codes');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('user_subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
}