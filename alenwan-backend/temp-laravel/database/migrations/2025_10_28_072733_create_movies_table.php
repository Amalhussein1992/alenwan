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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // متعدد اللغات: {ar: "", en: ""}
            $table->json('description')->nullable(); // متعدد اللغات
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Vimeo Integration
            $table->string('vimeo_id')->nullable();
            $table->string('vimeo_url')->nullable();
            $table->text('video_url'); // URL للفيديو
            $table->string('thumbnail')->nullable();
            $table->string('poster')->nullable();

            // Movie Details
            $table->integer('duration')->nullable(); // بالدقائق
            $table->year('release_year')->nullable();
            $table->decimal('rating', 3, 1)->default(0); // 0.0 to 10.0
            $table->string('imdb_id')->nullable();
            $table->json('genres')->nullable(); // مصفوفة من الأنواع
            $table->json('cast')->nullable(); // مصفوفة من أسماء الممثلين
            $table->json('director')->nullable(); // متعدد اللغات

            // Access Control
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
        Schema::dropIfExists('movies');
    }
};
