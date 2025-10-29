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
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان البث
            $table->string('slug')->unique(); // معرف فريد
            $table->text('description')->nullable(); // الوصف
            $table->string('thumbnail')->nullable(); // صورة مصغرة
            $table->string('poster')->nullable(); // صورة الغلاف

            // العلاقة مع القناة
            $table->foreignId('channel_id')->constrained()->onDelete('cascade');

            // معلومات YouTube
            $table->string('youtube_video_id')->nullable(); // معرف الفيديو/البث
            $table->string('youtube_embed_url')->nullable(); // رابط التضمين
            $table->string('youtube_watch_url')->nullable(); // رابط المشاهدة

            // معلومات Vimeo
            $table->string('vimeo_video_id')->nullable(); // معرف الفيديو
            $table->string('vimeo_embed_url')->nullable(); // رابط التضمين
            $table->string('vimeo_player_url')->nullable(); // رابط المشغل

            // رابط مباشر للبث (احتياطي)
            $table->string('stream_url')->nullable();

            // التصنيفات والعلاقات
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            // معلومات البث
            $table->enum('platform', ['youtube', 'vimeo'])->default('youtube'); // المنصة
            $table->enum('stream_type', ['live', 'recorded', 'upcoming'])->default('live'); // نوع البث
            $table->integer('duration')->nullable(); // المدة بالدقائق (للمسجل)
            $table->dateTime('scheduled_start_time')->nullable(); // موعد البدء المجدول
            $table->dateTime('actual_start_time')->nullable(); // موعد البدء الفعلي
            $table->dateTime('end_time')->nullable(); // موعد الانتهاء

            // الإحصائيات
            $table->integer('views_count')->default(0); // عدد المشاهدات
            $table->integer('likes_count')->default(0); // عدد الإعجابات
            $table->integer('concurrent_viewers')->default(0); // المشاهدين الحاليين (للبث المباشر)
            $table->integer('peak_viewers')->default(0); // ذروة المشاهدين

            // الحالة والإعدادات
            $table->boolean('is_live_now')->default(false); // بث مباشر الآن
            $table->boolean('is_premium')->default(false); // بث مميز
            $table->boolean('is_published')->default(true); // منشور
            $table->boolean('is_featured')->default(false); // مميز
            $table->boolean('enable_chat')->default(true); // تفعيل الدردشة
            $table->boolean('enable_notifications')->default(true); // تفعيل الإشعارات

            // SEO
            $table->json('tags')->nullable(); // الوسوم
            $table->string('meta_title')->nullable(); // عنوان SEO
            $table->text('meta_description')->nullable(); // وصف SEO

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('channel_id');
            $table->index('platform');
            $table->index('stream_type');
            $table->index('is_live_now');
            $table->index('is_published');
            $table->index('scheduled_start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_streams');
    }
};
