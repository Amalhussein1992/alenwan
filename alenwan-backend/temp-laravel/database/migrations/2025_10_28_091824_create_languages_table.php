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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Arabic, English, French, etc.
            $table->string('native_name'); // العربية, English, Français
            $table->string('code', 5)->unique(); // ar, en, fr
            $table->string('flag')->nullable(); // 🇸🇦, 🇺🇸, 🇫🇷 or image path
            $table->string('direction')->default('ltr'); // ltr or rtl
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
