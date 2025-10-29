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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم القناة
            $table->string('slug')->unique(); // معرف فريد
            $table->text('description')->nullable(); // الوصف
            $table->string('logo')->nullable(); // شعار القناة
            $table->string('banner')->nullable(); // صورة الغلاف

            // معلومات YouTube
            $table->string('youtube_channel_id')->nullable(); // معرف قناة اليوتيوب
            $table->string('youtube_channel_url')->nullable(); // رابط قناة اليوتيوب
            $table->string('youtube_live_stream_id')->nullable(); // معرف البث المباشر

            // معلومات Vimeo
            $table->string('vimeo_channel_id')->nullable(); // معرف قناة Vimeo
            $table->string('vimeo_channel_url')->nullable(); // رابط قناة Vimeo
            $table->string('vimeo_live_event_id')->nullable(); // معرف الحدث المباشر

            // التصنيفات والعلاقات
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            // معلومات إضافية
            $table->enum('platform', ['youtube', 'vimeo', 'both'])->default('youtube'); // المنصة
            $table->integer('subscribers_count')->default(0); // عدد المشتركين
            $table->integer('views_count')->default(0); // عدد المشاهدات
            $table->integer('videos_count')->default(0); // عدد الفيديوهات

            // الحالة والإعدادات
            $table->boolean('is_live')->default(false); // بث مباشر حالياً
            $table->boolean('is_premium')->default(false); // قناة مميزة
            $table->boolean('is_active')->default(true); // نشطة
            $table->boolean('is_featured')->default(false); // مميزة في الصفحة الرئيسية
            $table->integer('order')->default(0); // الترتيب

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('platform');
            $table->index('is_live');
            $table->index('is_active');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
