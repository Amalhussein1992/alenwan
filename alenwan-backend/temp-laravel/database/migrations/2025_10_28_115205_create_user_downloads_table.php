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
        Schema::create('user_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('downloadable_type');
            $table->unsignedBigInteger('downloadable_id');
            $table->string('quality')->default('720p');
            $table->bigInteger('file_size')->nullable();
            $table->string('download_url')->nullable();
            $table->enum('status', ['pending', 'downloading', 'completed', 'failed'])->default('pending');
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['downloadable_type', 'downloadable_id']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_downloads');
    }
};
