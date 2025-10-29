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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('poster')->nullable();
            $table->string('video_url')->nullable();
            $table->string('stream_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('set null');
            $table->string('sport_type')->nullable()->comment('football, basketball, etc.');
            $table->string('league')->nullable();
            $table->string('league_ar')->nullable();
            $table->string('teams')->nullable();
            $table->string('teams_ar')->nullable();
            $table->dateTime('match_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('venue_ar')->nullable();
            $table->boolean('is_live')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->index(['sport_type', 'is_published']);
            $table->index(['is_live', 'match_date']);
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
