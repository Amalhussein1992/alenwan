<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->dateTime('event_date')->nullable();
            $table->string('match_type')->nullable();
            $table->json('teams')->nullable();
            $table->enum('subscription_tier', ['free', 'basic', 'premium', 'platinum'])->default('free');
            $table->integer('duration_minutes')->nullable();
            $table->json('playback')->nullable();
            $table->string('vimeo_video_id')->nullable();
            $table->integer('views_count')->default(0);
            $table->decimal('rating', 3, 1)->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            $table->index(['status', 'event_date']);
            $table->index(['category_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
