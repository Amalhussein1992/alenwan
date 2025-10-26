<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cartoons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->year('release_year')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('age_rating')->nullable();
            $table->json('playback')->nullable();
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            $table->index(['status', 'age_rating']);
        });

        Schema::create('documentaries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->year('release_year')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('director')->nullable();
            $table->json('topics')->nullable();
            $table->json('playback')->nullable();
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            $table->index(['status', 'release_year']);
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('favorable_type'); // Movie, Series, Sport, etc.
            $table->unsignedBigInteger('favorable_id');
            $table->timestamps();

            $table->unique(['user_id', 'favorable_type', 'favorable_id']);
            $table->index(['favorable_type', 'favorable_id']);
        });

        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('downloadable_type'); // Movie, Episode, etc.
            $table->unsignedBigInteger('downloadable_id');
            $table->string('file_path');
            $table->bigInteger('file_size')->default(0);
            $table->enum('status', ['pending', 'downloading', 'completed', 'failed'])->default('pending');
            $table->integer('progress')->default(0);
            $table->datetime('downloaded_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['downloadable_type', 'downloadable_id']);
        });

        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_id')->unique();
            $table->string('device_name');
            $table->string('device_type'); // mobile, tablet, desktop, tv
            $table->string('platform'); // android, ios, web, etc.
            $table->string('app_version')->nullable();
            $table->timestamp('last_used_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_devices');
        Schema::dropIfExists('downloads');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('documentaries');
        Schema::dropIfExists('cartoons');
    }
};