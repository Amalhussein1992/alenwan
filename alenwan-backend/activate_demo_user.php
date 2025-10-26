<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $result = DB::table('users')
        ->where('email', 'demo@alenwan.com')
        ->update([
            'is_active' => 1,
            'email_verified_at' => now()
        ]);

    if ($result) {
        echo "✅ Demo user activated successfully!\n";
        echo "Email: demo@alenwan.com\n";
        echo "Password: demo123\n";
        echo "Status: Active ✓\n";
    } else {
        echo "❌ User not found or already activated\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
