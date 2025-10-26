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
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('audio_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('duration_seconds')->nullable();
            $table->date('release_date')->nullable();
            $table->string('host')->nullable();
            $table->json('guests')->nullable();
            $table->json('tags')->nullable();
            $table->integer('plays_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('season_number')->nullable();
            $table->integer('episode_number')->nullable();

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index(['status', 'release_date']);
            $table->index(['category_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcasts');
    }
};
