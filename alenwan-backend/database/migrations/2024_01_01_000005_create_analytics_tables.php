<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsTables extends Migration
{
    public function up()
    {
        // Analytics events
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->string('event_type'); // view, click, play, pause, complete, etc.
            $table->string('event_category'); // video, ui, navigation, etc.
            $table->string('event_action');
            $table->string('event_label')->nullable();
            $table->decimal('event_value', 10, 2)->nullable();
            $table->nullableMorphs('trackable');
            $table->json('properties')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type')->nullable();
            $table->string('app_version')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('created_at');

            $table->index(['user_id', 'event_type']);
            $table->index(['event_category', 'event_action']);
            $table->index('created_at');
            $table->index('session_id');
        });

        // Content analytics
        Schema::create('content_analytics', function (Blueprint $table) {
            $table->id();
            $table->morphs('content');
            $table->date('date');
            $table->bigInteger('views')->default(0);
            $table->bigInteger('unique_views')->default(0);
            $table->bigInteger('watch_time')->default(0); // in seconds
            $table->decimal('avg_watch_duration', 10, 2)->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0);
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('dislikes')->default(0);
            $table->bigInteger('shares')->default(0);
            $table->bigInteger('comments')->default(0);
            $table->bigInteger('downloads')->default(0);
            $table->decimal('engagement_rate', 5, 2)->default(0);
            $table->json('demographics')->nullable();
            $table->json('traffic_sources')->nullable();
            $table->json('devices')->nullable();
            $table->timestamps();

            $table->unique(['content_type', 'content_id', 'date']);
            $table->index('date');
        });

        // User analytics
        Schema::create('user_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('watch_time')->default(0); // in minutes
            $table->integer('content_watched')->default(0);
            $table->integer('episodes_watched')->default(0);
            $table->json('genres_watched')->nullable();
            $table->json('categories_watched')->nullable();
            $table->json('preferred_quality')->nullable();
            $table->json('watch_patterns')->nullable(); // time of day patterns
            $table->json('device_usage')->nullable();
            $table->decimal('avg_session_duration', 10, 2)->default(0);
            $table->integer('sessions_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->index('date');
        });

        // Revenue analytics
        Schema::create('revenue_analytics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->decimal('subscription_revenue', 12, 2)->default(0);
            $table->decimal('one_time_revenue', 12, 2)->default(0);
            $table->decimal('refunds', 12, 2)->default(0);
            $table->integer('new_subscriptions')->default(0);
            $table->integer('cancelled_subscriptions')->default(0);
            $table->integer('renewed_subscriptions')->default(0);
            $table->integer('active_subscribers')->default(0);
            $table->decimal('arpu', 10, 2)->default(0); // Average Revenue Per User
            $table->decimal('ltv', 10, 2)->default(0); // Lifetime Value
            $table->decimal('churn_rate', 5, 2)->default(0);
            $table->json('revenue_by_plan')->nullable();
            $table->json('revenue_by_country')->nullable();
            $table->json('payment_methods')->nullable();
            $table->timestamps();

            $table->unique('date');
        });

        // Recommendation engine data
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('genre_scores')->nullable();
            $table->json('category_scores')->nullable();
            $table->json('actor_scores')->nullable();
            $table->json('director_scores')->nullable();
            $table->json('language_preferences')->nullable();
            $table->json('quality_preferences')->nullable();
            $table->json('content_type_preferences')->nullable();
            $table->decimal('avg_watch_duration', 10, 2)->default(0);
            $table->string('preferred_watch_time')->nullable();
            $table->json('disliked_genres')->nullable();
            $table->json('disliked_content')->nullable();
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });

        // Content similarity scores
        Schema::create('content_similarities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('similar_content_id')->constrained('contents')->onDelete('cascade');
            $table->decimal('similarity_score', 5, 4); // 0.0000 to 1.0000
            $table->string('similarity_type'); // genre, cast, director, tags, collaborative
            $table->timestamps();

            $table->unique(['content_id', 'similar_content_id', 'similarity_type']);
            $table->index(['content_id', 'similarity_score']);
        });

        // Trending content
        Schema::create('trending_contents', function (Blueprint $table) {
            $table->id();
            $table->morphs('trendable');
            $table->string('period'); // daily, weekly, monthly
            $table->decimal('trend_score', 10, 2);
            $table->integer('views')->default(0);
            $table->integer('engagement')->default(0);
            $table->decimal('velocity', 10, 2)->default(0); // rate of growth
            $table->integer('rank')->default(0);
            $table->string('category')->nullable();
            $table->string('region')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->unique(['trendable_type', 'trendable_id', 'period', 'date']);
            $table->index(['period', 'date', 'rank']);
        });

        // A/B testing
        Schema::create('ab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->json('variants'); // {A: "variant_a", B: "variant_b"}
            $table->string('metric'); // conversion, engagement, retention
            $table->integer('sample_size')->default(0);
            $table->decimal('confidence_level', 5, 2)->default(95.00);
            $table->enum('status', ['draft', 'running', 'paused', 'completed']);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->json('results')->nullable();
            $table->string('winner')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        // A/B test participants
        Schema::create('ab_test_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('ab_tests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('variant');
            $table->boolean('converted')->default(false);
            $table->json('metrics')->nullable();
            $table->timestamps();

            $table->unique(['test_id', 'user_id']);
            $table->index(['test_id', 'variant']);
        });

        // Performance metrics
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('metric_type'); // api_response, page_load, video_buffer
            $table->string('endpoint')->nullable();
            $table->decimal('value', 10, 2); // milliseconds, seconds, etc.
            $table->string('unit');
            $table->json('metadata')->nullable();
            $table->timestamp('recorded_at');

            $table->index(['metric_type', 'recorded_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_metrics');
        Schema::dropIfExists('ab_test_participants');
        Schema::dropIfExists('ab_tests');
        Schema::dropIfExists('trending_contents');
        Schema::dropIfExists('content_similarities');
        Schema::dropIfExists('user_preferences');
        Schema::dropIfExists('revenue_analytics');
        Schema::dropIfExists('user_analytics');
        Schema::dropIfExists('content_analytics');
        Schema::dropIfExists('analytics_events');
    }
}