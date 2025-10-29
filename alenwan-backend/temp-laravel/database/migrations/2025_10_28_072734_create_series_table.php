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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // متعدد اللغات
            $table->json('description')->nullable(); // متعدد اللغات
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Series Details
            $table->string('thumbnail')->nullable();
            $table->string('poster')->nullable();
            $table->year('release_year')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->string('imdb_id')->nullable();
            $table->json('genres')->nullable();
            $table->json('cast')->nullable();
            $table->json('director')->nullable(); // متعدد اللغات

            // Status
            $table->enum('status', ['ongoing', 'completed', 'upcoming'])->default('ongoing');
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
