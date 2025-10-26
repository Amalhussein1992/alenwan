<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    $result = DB::table('users')->insert([
        'name' => 'Demo User',
        'email' => 'demo@alenwan.com',
        'password' => Hash::make('demo123'),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    if ($result) {
        echo "✅ Demo user created successfully!\n";
        echo "Email: demo@alenwan.com\n";
        echo "Password: demo123\n";
    } else {
        echo "❌ Failed to create user\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
