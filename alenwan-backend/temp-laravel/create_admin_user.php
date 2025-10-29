<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "👤 إنشاء مستخدم Admin...\n\n";

// Check if admin already exists
$existingAdmin = User::where('email', 'admin@alenwan.com')->first();

if ($existingAdmin) {
    echo "⚠️  المستخدم admin@alenwan.com موجود بالفعل!\n";
    echo "📧 البريد الإلكتروني: admin@alenwan.com\n";
    echo "🔑 كلمة المرور: password\n";
    exit;
}

// Create admin user
$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@alenwan.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'is_active' => true,
    'email_verified_at' => now(),
]);

echo "✅ تم إنشاء مستخدم Admin بنجاح!\n\n";
echo "📊 معلومات تسجيل الدخول:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📧 البريد الإلكتروني: admin@alenwan.com\n";
echo "🔑 كلمة المرور: password\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
echo "🌐 رابط لوحة التحكم: http://localhost:8000/admin\n";
echo "\n✨ يمكنك الآن تسجيل الدخول إلى لوحة التحكم!\n";
