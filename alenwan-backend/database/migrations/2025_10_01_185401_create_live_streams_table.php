<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_stream_key')->nullable();
            $table->string('youtube_video_id')->nullable();
            $table->string('stream_url')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->dateTime('scheduled_start')->nullable();
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->integer('viewers_count')->default(0);
            $table->integer('max_viewers')->default(0);
            $table->foreignId('channel_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
            $table->index(['status', 'scheduled_start']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('live_streams');
    }
};
