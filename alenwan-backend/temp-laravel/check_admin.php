<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Checking admin user...\n\n";

$user = User::where('email', 'admin@alenwan.com')->first();

if ($user) {
    echo "✅ User found!\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
    echo "Has Password: " . (!empty($user->password) ? 'Yes' : 'No') . "\n";
    echo "Password Hash: " . substr($user->password, 0, 20) . "...\n\n";

    // Test password
    echo "Testing password 'password'...\n";
    if (Hash::check('password', $user->password)) {
        echo "✅ Password matches!\n";
    } else {
        echo "❌ Password does NOT match!\n";
        echo "Updating password...\n";
        $user->password = Hash::make('password');
        $user->save();
        echo "✅ Password updated!\n";
    }
} else {
    echo "❌ User not found!\n";
}
