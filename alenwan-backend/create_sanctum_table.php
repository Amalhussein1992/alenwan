<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Create personal_access_tokens table for Sanctum
    if (!Schema::hasTable('personal_access_tokens')) {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        echo "✅ Created 'personal_access_tokens' table for Sanctum\n";
    } else {
        echo "ℹ️  'personal_access_tokens' table already exists\n";
    }

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✓ Sanctum is ready to create tokens!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
