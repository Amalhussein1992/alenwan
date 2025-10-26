<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Add is_active column if it doesn't exist
    if (!Schema::hasColumn('users', 'is_active')) {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(1)->after('password');
        });
        echo "✅ Added 'is_active' column to users table\n";
    } else {
        echo "ℹ️  'is_active' column already exists\n";
    }

    // Update all existing users to be active
    $updated = DB::table('users')->update(['is_active' => 1]);
    echo "✅ Updated $updated users to active status\n";

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✓ All users are now active!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
