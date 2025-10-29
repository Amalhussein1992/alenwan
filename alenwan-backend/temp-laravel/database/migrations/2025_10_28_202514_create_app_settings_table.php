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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // المفتاح الفريد
            $table->text('value')->nullable(); // القيمة
            $table->string('type')->default('string'); // نوع البيانات: string, number, boolean, json, file
            $table->string('group')->default('general'); // المجموعة: general, payment, email, api, app, social
            $table->json('label')->nullable(); // التسمية متعددة اللغات
            $table->json('description')->nullable(); // الوصف متعدد اللغات
            $table->boolean('is_public')->default(false); // هل هو عام (يظهر في API)
            $table->boolean('is_encrypted')->default(false); // هل هو مشفر
            $table->integer('order')->default(0); // الترتيب
            $table->timestamps();

            // Indexes
            $table->index('key');
            $table->index('group');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
