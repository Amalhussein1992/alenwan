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
        Schema::create('cartoons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('poster')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->year('year')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');
            $table->string('age_rating')->nullable()->comment('G, PG, PG-13, etc.');
            $table->integer('season_number')->nullable();
            $table->integer('episode_number')->nullable();
            $table->date('release_date')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->boolean('is_series')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'is_published']);
            $table->index(['is_series', 'season_number']);
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartoons');
    }
};
