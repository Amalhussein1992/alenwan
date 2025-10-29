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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_name'); // e.g., "iPhone 13", "Samsung Galaxy S21"
            $table->string('device_type'); // mobile, tablet, tv, web
            $table->string('device_id')->unique(); // Unique identifier for the device
            $table->string('os'); // iOS, Android, Web, etc.
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('fcm_token')->nullable(); // For push notifications
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_active_at')->useCurrent();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index('device_id');
            $table->index('last_active_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
