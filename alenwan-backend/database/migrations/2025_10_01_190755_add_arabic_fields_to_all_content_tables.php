<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Movies
        if (!Schema::hasColumn('movies', 'title_ar')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // Series
        if (!Schema::hasColumn('series', 'title_ar')) {
            Schema::table('series', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // Episodes
        if (!Schema::hasColumn('episodes', 'title_ar')) {
            Schema::table('episodes', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // Documentaries
        if (!Schema::hasColumn('documentaries', 'title_ar')) {
            Schema::table('documentaries', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // Sports
        if (!Schema::hasColumn('sports', 'title_ar')) {
            Schema::table('sports', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // Podcasts
        if (!Schema::hasColumn('podcasts', 'title_ar')) {
            Schema::table('podcasts', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }

        // LiveStreams
        if (!Schema::hasColumn('live_streams', 'title_ar')) {
            Schema::table('live_streams', function (Blueprint $table) {
                $table->string('title_ar')->nullable()->after('title');
                $table->text('description_ar')->nullable()->after('description');
            });
        }
    }

    public function down(): void {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('documentaries', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('sports', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
    }
};
