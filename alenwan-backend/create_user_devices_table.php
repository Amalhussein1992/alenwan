<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Create user_devices table
    if (!Schema::hasTable('user_devices')) {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_id')->unique();
            $table->string('device_name');
            $table->string('device_type')->default('mobile');
            $table->string('platform')->default('android');
            $table->string('device_token')->nullable();
            $table->string('fingerprint')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        echo "✅ Created 'user_devices' table\n";
    } else {
        echo "ℹ️  'user_devices' table already exists\n";
    }

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✓ Database ready for device management!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
