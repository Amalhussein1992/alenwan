<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $admin = User::where('email', 'admin@alenwan.com')->first();

    if (!$admin) {
        echo "❌ Admin user not found!\n";
        exit(1);
    }

    // New secure password
    $newPassword = 'Alenwan@Admin2025!';
    $admin->password = Hash::make($newPassword);
    $admin->save();

    echo "✅ Admin password changed successfully!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📧 Email: admin@alenwan.com\n";
    echo "🔒 Password: {$newPassword}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "⚠️  IMPORTANT: Save this password securely!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
