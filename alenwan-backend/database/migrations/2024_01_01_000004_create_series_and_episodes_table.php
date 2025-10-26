<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->year('release_year')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->integer('total_episodes')->default(0);
            $table->json('cast')->nullable();
            $table->json('genres')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index(['status', 'subscription_tier']);
            $table->index(['category_id', 'language_id']);
        });

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained()->onDelete('cascade');
            $table->integer('episode_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url');
            $table->string('poster_url')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('playback')->nullable(); // Vimeo URLs, HLS, MP4, etc.
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['series_id', 'episode_number']);
            $table->unique(['series_id', 'episode_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('series');
    }
};