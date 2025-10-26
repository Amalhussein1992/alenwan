<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->year('release_year')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->integer('duration_minutes')->nullable();
            $table->string('trailer_url')->nullable();
            $table->json('cast')->nullable();
            $table->json('genres')->nullable();
            $table->json('playback')->nullable(); // Vimeo URLs, HLS, MP4, etc.
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index(['status', 'subscription_tier']);
            $table->index(['category_id', 'language_id']);
            $table->index('release_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};