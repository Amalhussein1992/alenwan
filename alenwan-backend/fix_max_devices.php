<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Add max_devices column if it doesn't exist
    if (!Schema::hasColumn('users', 'max_devices')) {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('max_devices')->default(3)->after('password');
        });
        echo "✅ Added 'max_devices' column to users table\n";
    } else {
        echo "ℹ️  'max_devices' column already exists\n";
    }

    // Update all existing users to have max_devices = 3
    $updated = DB::table('users')->update(['max_devices' => 3]);
    echo "✅ Updated $updated users with max_devices = 3\n";

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✓ Users can now use up to 3 devices!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
