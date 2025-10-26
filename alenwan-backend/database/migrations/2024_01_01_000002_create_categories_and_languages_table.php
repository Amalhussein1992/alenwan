<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['movie', 'series', 'sport', 'cartoon', 'documentary', 'live']);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 5); // en, ar, fr, etc.
            $table->string('native_name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_rtl')->default(false);
            $table->timestamps();
        });

        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->integer('duration_days');
            $table->integer('max_devices')->default(2);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('categories');
    }
};