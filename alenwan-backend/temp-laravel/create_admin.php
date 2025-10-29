<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Creating admin user...\n";

// Delete existing admin if exists
User::where('email', 'admin@alenwan.com')->delete();

// Create new admin
$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@alenwan.com',
    'password' => Hash::make('password'),
    'is_admin' => true,
    'email_verified_at' => now(),
]);

echo "✅ Admin user created successfully!\n";
echo "Email: admin@alenwan.com\n";
echo "Password: password\n";
echo "Admin: " . ($admin->is_admin ? 'Yes' : 'No') . "\n";
