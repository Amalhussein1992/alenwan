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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // متعدد اللغات
            $table->string('slug')->unique();
            $table->json('content'); // متعدد اللغات
            $table->json('meta_title')->nullable(); // متعدد اللغات
            $table->json('meta_description')->nullable(); // متعدد اللغات
            $table->json('meta_keywords')->nullable(); // متعدد اللغات

            // Page Type
            $table->enum('type', [
                'about',           // من نحن
                'features',        // الميزات
                'pricing',         // الأسعار
                'support',         // الدعم
                'help_center',     // مركز المساعدة
                'faq',             // الأسئلة الشائعة
                'contact',         // اتصل بنا
                'terms',           // الشروط والأحكام
                'privacy',         // سياسة الخصوصية
                'security',        // الأمان والخصوصية
                'cancellation',    // سياسة الإلغاء
                'refund',          // سياسة الاسترداد
                'subscription_delete', // سياسة حذف الاشتراك
                'custom'           // صفحة مخصصة
            ])->default('custom');

            // Display Settings
            $table->string('icon')->nullable(); // أيقونة الصفحة
            $table->string('banner_image')->nullable(); // صورة البانر
            $table->integer('order')->default(0); // الترتيب

            // Status
            $table->boolean('is_published')->default(true);
            $table->boolean('show_in_menu')->default(true); // عرض في القائمة
            $table->boolean('show_in_footer')->default(true); // عرض في الفوتر

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('type');
            $table->index('is_published');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
