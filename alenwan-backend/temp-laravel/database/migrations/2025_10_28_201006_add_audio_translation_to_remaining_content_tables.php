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
        // Add audio translation fields to series table (if not exists)
        if (!Schema::hasColumn('series', 'has_audio_translation')) {
            Schema::table('series', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('views_count');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to episodes table (if not exists)
        if (!Schema::hasColumn('episodes', 'has_audio_translation')) {
            Schema::table('episodes', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('duration');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to podcasts table (if not exists)
        if (!Schema::hasColumn('podcasts', 'has_audio_translation')) {
            Schema::table('podcasts', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('video_url');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to sports table (if not exists)
        if (!Schema::hasColumn('sports', 'has_audio_translation')) {
            Schema::table('sports', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('stream_url');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to documentaries table (if not exists)
        if (!Schema::hasColumn('documentaries', 'has_audio_translation')) {
            Schema::table('documentaries', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('video_url');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to cartoons table (if not exists)
        if (!Schema::hasColumn('cartoons', 'has_audio_translation')) {
            Schema::table('cartoons', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('video_url');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }

        // Add audio translation fields to live_streams table (if not exists)
        if (!Schema::hasColumn('live_streams', 'has_audio_translation')) {
            Schema::table('live_streams', function (Blueprint $table) {
                $table->boolean('has_audio_translation')->default(false)->after('stream_url');
                $table->json('audio_languages')->nullable()->after('has_audio_translation');
                $table->string('default_audio_language')->default('ar')->after('audio_languages');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('series', 'has_audio_translation')) {
            Schema::table('series', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('episodes', 'has_audio_translation')) {
            Schema::table('episodes', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('podcasts', 'has_audio_translation')) {
            Schema::table('podcasts', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('sports', 'has_audio_translation')) {
            Schema::table('sports', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('documentaries', 'has_audio_translation')) {
            Schema::table('documentaries', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('cartoons', 'has_audio_translation')) {
            Schema::table('cartoons', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }

        if (Schema::hasColumn('live_streams', 'has_audio_translation')) {
            Schema::table('live_streams', function (Blueprint $table) {
                $table->dropColumn(['has_audio_translation', 'audio_languages', 'default_audio_language']);
            });
        }
    }
};
