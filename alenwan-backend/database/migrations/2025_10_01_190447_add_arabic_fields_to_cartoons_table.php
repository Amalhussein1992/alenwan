<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('cartoons', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->text('description_ar')->nullable()->after('description');
        });
    }

    public function down(): void {
        Schema::table('cartoons', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });
    }
};
