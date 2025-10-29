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
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // {ar: "", en: ""}
            $table->json('body'); // {ar: "", en: ""}
            $table->string('image')->nullable();
            $table->string('type')->default('general'); // general, movie, series, category, promotion
            $table->unsignedBigInteger('movie_id')->nullable();
            $table->unsignedBigInteger('series_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('url')->nullable();
            $table->boolean('send_to_all')->default(true);
            $table->json('user_ids')->nullable(); // [1,2,3] if not send_to_all
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->integer('sent_count')->default(0);
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_notifications');
    }
};
