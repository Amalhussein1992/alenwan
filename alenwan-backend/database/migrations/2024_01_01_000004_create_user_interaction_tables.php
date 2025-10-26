<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInteractionTables extends Migration
{
    public function up()
    {
        // Watch history
        Schema::create('watch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('watchable'); // content_id or episode_id
            $table->integer('watched_duration')->default(0); // in seconds
            $table->integer('total_duration')->nullable(); // in seconds
            $table->decimal('progress', 5, 2)->default(0); // percentage
            $table->boolean('is_completed')->default(false);
            $table->timestamp('last_watched_at');
            $table->json('metadata')->nullable(); // quality watched, device, etc.
            $table->timestamps();

            $table->index(['user_id', 'watchable_type', 'watchable_id']);
            $table->index(['user_id', 'last_watched_at']);
        });

        // Continue watching
        Schema::create('continue_watching', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('watchable');
            $table->integer('current_time')->default(0); // in seconds
            $table->integer('total_duration')->nullable();
            $table->decimal('progress', 5, 2)->default(0);
            $table->timestamp('last_watched_at');
            $table->timestamps();

            $table->unique(['user_id', 'watchable_type', 'watchable_id']);
            $table->index(['user_id', 'last_watched_at']);
        });

        // Watchlist/Favorites
        Schema::create('watchlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['watchlist', 'favorite']);
            $table->timestamps();

            $table->unique(['user_id', 'content_id', 'type']);
            $table->index(['user_id', 'type']);
        });

        // Ratings and reviews
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('rateable');
            $table->integer('rating'); // 1-5 or 1-10
            $table->text('review')->nullable();
            $table->boolean('is_spoiler')->default(false);
            $table->boolean('is_verified')->default(false); // verified purchase/watch
            $table->integer('helpful_count')->default(0);
            $table->integer('unhelpful_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'rateable_type', 'rateable_id']);
            $table->index(['rateable_type', 'rateable_id', 'is_active']);
        });

        // Rating helpfulness
        Schema::create('rating_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('rating_id')->constrained()->onDelete('cascade');
            $table->boolean('is_helpful');
            $table->timestamps();

            $table->unique(['user_id', 'rating_id']);
        });

        // Comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('commentable');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_spoiler')->default(false);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['commentable_type', 'commentable_id', 'is_active']);
            $table->index('parent_id');
        });

        // Comment likes
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->constrained()->onDelete('cascade');
            $table->boolean('is_like'); // true = like, false = dislike
            $table->timestamps();

            $table->unique(['user_id', 'comment_id']);
        });

        // User downloads
        Schema::create('user_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('downloadable');
            $table->string('quality');
            $table->bigInteger('file_size');
            $table->string('device_id')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['pending', 'downloading', 'completed', 'failed', 'expired']);
            $table->decimal('progress', 5, 2)->default(0);
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('expires_at');
        });

        // User notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // new_content, subscription, payment, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->string('action_url')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });

        // Push notifications
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('image')->nullable();
            $table->json('data')->nullable();
            $table->string('topic')->nullable(); // for topic-based notifications
            $table->enum('platform', ['all', 'ios', 'android', 'web'])->default('all');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->integer('sent_count')->default(0);
            $table->integer('read_count')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'scheduled_at']);
        });

        // Reports
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('reportable');
            $table->enum('reason', ['inappropriate', 'copyright', 'spam', 'misleading', 'violence', 'other']);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'resolved', 'dismissed'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['reportable_type', 'reportable_id']);
        });

        // User activity logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // watch, search, download, share, etc.
            $table->morphs('loggable')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_id')->nullable();
            $table->timestamp('created_at');

            $table->index(['user_id', 'action']);
            $table->index('created_at');
        });

        // Search history
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('query');
            $table->integer('results_count')->default(0);
            $table->json('filters')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('query');
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_histories');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('push_notifications');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('user_downloads');
        Schema::dropIfExists('comment_likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('rating_votes');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('watchlists');
        Schema::dropIfExists('continue_watching');
        Schema::dropIfExists('watch_histories');
    }
}