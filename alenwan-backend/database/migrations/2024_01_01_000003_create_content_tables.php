<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTables extends Migration
{
    public function up()
    {
        // Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['slug', 'is_active']);
        });

        // Genres
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
        });

        // Content (movies, series, documentaries)
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['movie', 'series', 'documentary', 'live', 'sports']);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('synopsis')->nullable();
            $table->string('poster')->nullable();
            $table->string('backdrop')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('trailer_thumbnail')->nullable();
            $table->integer('release_year')->nullable();
            $table->date('release_date')->nullable();
            $table->string('runtime')->nullable(); // in minutes
            $table->string('age_rating')->nullable(); // G, PG, PG-13, R
            $table->string('content_rating')->nullable(); // TV-Y, TV-14, TV-MA
            $table->json('languages')->nullable();
            $table->json('subtitles')->nullable();
            $table->json('audio_tracks')->nullable();
            $table->string('quality')->default('HD'); // SD, HD, FHD, 4K
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_coming_soon')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->bigInteger('views')->default(0);
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('dislikes')->default(0);
            $table->json('cast')->nullable();
            $table->json('crew')->nullable();
            $table->json('studios')->nullable();
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['type', 'is_active']);
            $table->index('slug');
            $table->index(['is_featured', 'is_trending', 'is_new']);
            $table->fullText(['title', 'description']);
        });

        // Content categories relationship
        Schema::create('content_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['content_id', 'category_id']);
        });

        // Content genres relationship
        Schema::create('content_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['content_id', 'genre_id']);
        });

        // Seasons (for series)
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->integer('season_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->date('air_date')->nullable();
            $table->integer('episode_count')->default(0);
            $table->boolean('is_complete')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['content_id', 'season_number']);
        });

        // Episodes
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('episode_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('runtime')->nullable(); // in minutes
            $table->date('air_date')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_active')->default(true);
            $table->bigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['content_id', 'season_id', 'episode_number']);
        });

        // Video sources
        Schema::create('video_sources', function (Blueprint $table) {
            $table->id();
            $table->morphs('videoable'); // content_id or episode_id
            $table->string('source_type'); // direct, embed, m3u8, dash, youtube, vimeo
            $table->string('quality'); // 360p, 480p, 720p, 1080p, 4K
            $table->text('url');
            $table->string('server_name')->nullable();
            $table->string('language')->default('en');
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_downloadable')->default(false);
            $table->bigInteger('file_size')->nullable(); // in bytes
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['videoable_type', 'videoable_id', 'is_active']);
        });

        // Download links
        Schema::create('download_links', function (Blueprint $table) {
            $table->id();
            $table->morphs('downloadable');
            $table->string('quality');
            $table->string('format'); // mp4, mkv, avi
            $table->text('url');
            $table->bigInteger('file_size')->nullable();
            $table->string('server_name')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->integer('download_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['downloadable_type', 'downloadable_id']);
        });

        // Live channels
        Schema::create('live_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('stream_url');
            $table->string('stream_type'); // m3u8, dash, rtmp
            $table->string('category'); // news, sports, entertainment, etc.
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->bigInteger('viewers')->default(0);
            $table->json('epg_data')->nullable(); // Electronic Program Guide
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['slug', 'is_active']);
            $table->index(['category', 'is_featured']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_channels');
        Schema::dropIfExists('download_links');
        Schema::dropIfExists('video_sources');
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('content_genres');
        Schema::dropIfExists('content_categories');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('categories');
    }
}