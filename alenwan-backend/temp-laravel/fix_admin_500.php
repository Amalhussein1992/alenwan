<?php
/**
 * Fix Admin 500 Error
 * Upload this to: /public_html/fix_admin_500.php
 * Then run: php fix_admin_500.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "===========================================\n";
echo "   Fixing Admin 500 Error\n";
echo "===========================================\n\n";

try {
    // Test database connection
    echo "🔌 Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✅ Database connected!\n\n";

    // Check if users table exists
    echo "📊 Checking users table...\n";
    $hasUsersTable = Schema::hasTable('users');
    echo $hasUsersTable ? "✅ users table exists\n" : "❌ users table MISSING\n";

    if ($hasUsersTable) {
        // Check role column
        echo "🔍 Checking role column...\n";
        $hasRoleColumn = Schema::hasColumn('users', 'role');
        echo $hasRoleColumn ? "✅ role column exists\n" : "❌ role column MISSING\n";

        if (!$hasRoleColumn) {
            echo "\n⚠️  Adding role column...\n";
            Schema::table('users', function ($table) {
                $table->string('role')->default('user')->after('password');
                $table->index('role');
            });
            echo "✅ role column added!\n";
        }
    }

    echo "\n";

    // Check critical tables
    echo "📋 Checking critical tables:\n";
    $tables = ['categories', 'movies', 'series', 'seasons', 'episodes', 'sessions'];
    foreach ($tables as $table) {
        $exists = Schema::hasTable($table);
        echo ($exists ? "✅" : "❌") . " $table\n";
    }

    echo "\n";

    // Clear all cache
    echo "🗑️  Clearing all cache...\n";
    Artisan::call('cache:clear');
    echo "  ✓ Application cache cleared\n";

    Artisan::call('config:clear');
    echo "  ✓ Config cache cleared\n";

    Artisan::call('route:clear');
    echo "  ✓ Route cache cleared\n";

    Artisan::call('view:clear');
    echo "  ✓ View cache cleared\n";

    echo "\n";

    // Optimize for production
    echo "⚡ Optimizing...\n";
    Artisan::call('config:cache');
    echo "  ✓ Config cached\n";

    Artisan::call('route:cache');
    echo "  ✓ Routes cached\n";

    echo "\n";

    // Check admin user
    echo "👤 Checking admin user...\n";
    $admin = DB::table('users')->where('email', 'admin@alenwan.com')->first();
    if ($admin) {
        echo "✅ Admin user exists (ID: {$admin->id})\n";
        if (isset($admin->role)) {
            echo "   Role: {$admin->role}\n";
        }
    } else {
        echo "⚠️  No admin user found\n";
        echo "   Creating admin user...\n";

        $hasRoleColumn = Schema::hasColumn('users', 'role');
        $userData = [
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($hasRoleColumn) {
            $userData['role'] = 'admin';
        }

        DB::table('users')->insert($userData);
        echo "✅ Admin user created!\n";
    }

    echo "\n===========================================\n";
    echo "🎉 Fix completed!\n";
    echo "===========================================\n\n";
    echo "Now try accessing:\n";
    echo "https://www.alenwanapp.net/admin/login\n\n";
    echo "Login credentials:\n";
    echo "Email: admin@alenwan.com\n";
    echo "Password: Alenwan@Admin2025!\n\n";

} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
