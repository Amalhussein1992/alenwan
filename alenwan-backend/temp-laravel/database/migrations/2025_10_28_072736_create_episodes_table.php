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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->json('title'); // متعدد اللغات
            $table->json('description')->nullable();
            $table->integer('episode_number');

            // Vimeo Integration
            $table->string('vimeo_id')->nullable();
            $table->string('vimeo_url')->nullable();
            $table->text('video_url');
            $table->string('thumbnail')->nullable();

            // Episode Details
            $table->integer('duration')->nullable(); // بالدقائق
            $table->date('release_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('views_count')->default(0);
            $table->integer('order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
