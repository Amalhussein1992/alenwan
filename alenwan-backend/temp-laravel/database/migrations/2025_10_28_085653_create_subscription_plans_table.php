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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // {ar: "", en: ""}
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('USD');
            $table->integer('duration_days'); // 30, 90, 365
            $table->integer('duration_months')->nullable(); // 1, 3, 12
            $table->json('features')->nullable(); // ["feature1", "feature2"]
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('stripe_price_id')->nullable();
            $table->string('paypal_plan_id')->nullable();
            $table->string('paymob_plan_id')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
