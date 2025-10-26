<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('youtube_channel_id')->nullable();
            $table->string('thumbnail');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('subscribers_count')->default(0);
            $table->timestamps();

            $table->index('is_active');
        });

        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('stream_url');
            $table->string('channel_name');
            $table->enum('source_type', ['youtube', 'vimeo', 'custom'])->default('youtube');
            $table->datetime('starts_at');
            $table->datetime('ends_at')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->integer('viewers_count')->default(0);
            $table->string('video_url')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->json('chat_settings')->nullable();

            // Foreign keys
            $table->foreignId('channel_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index(['status', 'starts_at']);
            $table->index(['channel_id', 'status']);
            $table->index('is_paid');
        });

        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->datetime('match_date')->nullable();
            $table->string('team_a')->nullable();
            $table->string('team_b')->nullable();
            $table->string('league')->nullable();
            $table->json('playback')->nullable();
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            $table->index(['status', 'match_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sports');
        Schema::dropIfExists('live_streams');
        Schema::dropIfExists('channels');
    }
};