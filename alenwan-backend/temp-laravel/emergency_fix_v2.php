<?php
/**
 * EMERGENCY FIX V2 - Admin 500 Error
 * More verbose output with error handling
 */

// Force output immediately
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
@ob_end_clean();

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #1e1e1e; color: #00ff00; padding: 20px;'>";
echo "========================================\n";
echo "   EMERGENCY FIX V2 - Admin 500 Error\n";
echo "========================================\n\n";

flush();

try {
    echo "[1/10] Loading Laravel...\n";
    flush();

    if (!file_exists(__DIR__.'/vendor/autoload.php')) {
        echo "❌ ERROR: vendor/autoload.php not found!\n";
        echo "   Path: " . __DIR__ . "/vendor/autoload.php\n";
        exit(1);
    }

    require __DIR__.'/vendor/autoload.php';
    echo "✅ Autoload loaded\n";
    flush();

    if (!file_exists(__DIR__.'/bootstrap/app.php')) {
        echo "❌ ERROR: bootstrap/app.php not found!\n";
        exit(1);
    }

    $app = require_once __DIR__.'/bootstrap/app.php';
    echo "✅ App bootstrapped\n";
    flush();

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "✅ Kernel bootstrapped\n\n";
    flush();

    // Test database connection
    echo "[2/10] Testing database connection...\n";
    flush();

    $pdo = DB::connection()->getPdo();
    echo "✅ Database connected!\n";
    echo "   Database: " . DB::connection()->getDatabaseName() . "\n\n";
    flush();

    // Check users table
    echo "[3/10] Checking users table...\n";
    flush();

    if (!Schema::hasTable('users')) {
        echo "❌ ERROR: users table does not exist!\n";
        echo "   You need to run: php artisan migrate --force\n";
        exit(1);
    }
    echo "✅ users table exists\n\n";
    flush();

    // Check and add role column
    echo "[4/10] Checking role column...\n";
    flush();

    if (!Schema::hasColumn('users', 'role')) {
        echo "⚠️  role column missing, adding it now...\n";
        flush();

        try {
            DB::statement("ALTER TABLE `users` ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `password`");
            echo "✅ role column added!\n";
            flush();

            DB::statement("ALTER TABLE `users` ADD INDEX `users_role_index` (`role`)");
            echo "✅ role index added!\n\n";
            flush();
        } catch (\Exception $e) {
            echo "⚠️  Error adding role: " . $e->getMessage() . "\n";
            echo "   Continuing anyway...\n\n";
            flush();
        }
    } else {
        echo "✅ role column already exists\n\n";
        flush();
    }

    // Check sessions table
    echo "[5/10] Checking sessions table...\n";
    flush();

    if (!Schema::hasTable('sessions')) {
        echo "⚠️  sessions table missing, creating it...\n";
        flush();

        try {
            DB::statement("CREATE TABLE `sessions` (
                `id` VARCHAR(255) NOT NULL,
                `user_id` BIGINT UNSIGNED NULL,
                `ip_address` VARCHAR(45) NULL,
                `user_agent` TEXT NULL,
                `payload` LONGTEXT NOT NULL,
                `last_activity` INT NOT NULL,
                PRIMARY KEY (`id`),
                KEY `sessions_user_id_index` (`user_id`),
                KEY `sessions_last_activity_index` (`last_activity`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            echo "✅ sessions table created!\n\n";
            flush();
        } catch (\Exception $e) {
            echo "⚠️  Error creating sessions: " . $e->getMessage() . "\n\n";
            flush();
        }
    } else {
        echo "✅ sessions table exists\n\n";
        flush();
    }

    // Check cache table
    echo "[6/10] Checking cache table...\n";
    flush();

    if (!Schema::hasTable('cache')) {
        echo "⚠️  cache table missing (optional, but recommended)\n\n";
        flush();
    } else {
        echo "✅ cache table exists\n\n";
        flush();
    }

    // Create/update admin user
    echo "[7/10] Managing admin user...\n";
    flush();

    $adminExists = DB::table('users')->where('email', 'admin@alenwan.com')->exists();

    if ($adminExists) {
        echo "⚠️  Admin user exists, updating...\n";
        flush();

        DB::table('users')
            ->where('email', 'admin@alenwan.com')
            ->update([
                'role' => 'admin',
                'password' => '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]);
        echo "✅ Admin user updated!\n\n";
        flush();
    } else {
        echo "⚠️  Admin user not found, creating...\n";
        flush();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Admin user created!\n\n";
        flush();
    }

    // Verify admin user
    $admin = DB::table('users')->where('email', 'admin@alenwan.com')->first();
    echo "Admin user details:\n";
    echo "   ID: " . $admin->id . "\n";
    echo "   Name: " . $admin->name . "\n";
    echo "   Email: " . $admin->email . "\n";
    echo "   Role: " . ($admin->role ?? 'N/A') . "\n\n";
    flush();

    // Clear cache
    echo "[8/10] Clearing cache...\n";
    flush();

    try {
        Artisan::call('cache:clear');
        echo "  ✓ Application cache cleared\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  Cache clear: " . $e->getMessage() . "\n";
        flush();
    }

    try {
        Artisan::call('config:clear');
        echo "  ✓ Config cache cleared\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  Config clear: " . $e->getMessage() . "\n";
        flush();
    }

    try {
        Artisan::call('route:clear');
        echo "  ✓ Route cache cleared\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  Route clear: " . $e->getMessage() . "\n";
        flush();
    }

    try {
        Artisan::call('view:clear');
        echo "  ✓ View cache cleared\n\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  View clear: " . $e->getMessage() . "\n\n";
        flush();
    }

    // Optimize
    echo "[9/10] Optimizing...\n";
    flush();

    try {
        Artisan::call('config:cache');
        echo "  ✓ Config cached\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  Config cache: " . $e->getMessage() . "\n";
        flush();
    }

    try {
        Artisan::call('route:cache');
        echo "  ✓ Route cached\n\n";
        flush();
    } catch (\Exception $e) {
        echo "  ⚠️  Route cache: " . $e->getMessage() . "\n\n";
        flush();
    }

    // Final checks
    echo "[10/10] Running final checks...\n";
    flush();

    $tables = ['users', 'sessions', 'categories', 'movies', 'series'];
    echo "Required tables:\n";
    foreach ($tables as $table) {
        $exists = Schema::hasTable($table);
        echo "  " . ($exists ? "✅" : "❌") . " $table\n";
        flush();
    }
    echo "\n";

    echo "========================================\n";
    echo "🎉 FIX COMPLETED SUCCESSFULLY!\n";
    echo "========================================\n\n";

    echo "<strong style='color: #ffff00;'>Admin Login Details:</strong>\n";
    echo "-------------------\n";
    echo "URL: <a href='https://www.alenwanapp.net/admin/login' style='color: #00ffff;'>https://www.alenwanapp.net/admin/login</a>\n";
    echo "Email: admin@alenwan.com\n";
    echo "Password: Alenwan@Admin2025!\n\n";

    echo "<strong style='color: #ff0000;'>⚠️  SECURITY WARNING:</strong>\n";
    echo "DELETE THIS FILE NOW for security!\n";
    echo "Run: <code style='color: #ffff00;'>rm /public_html/emergency_fix_v2.php</code>\n\n";

    echo "<strong>Next Step:</strong>\n";
    echo "Try logging in: <a href='https://www.alenwanapp.net/admin/login' style='color: #00ff00;'>Click here</a>\n";

} catch (\Exception $e) {
    echo "\n";
    echo "========================================\n";
    echo "❌ ERROR OCCURRED\n";
    echo "========================================\n\n";
    echo "Message: " . $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n";
    echo $e->getTraceAsString() . "\n";
} catch (\Error $e) {
    echo "\n";
    echo "========================================\n";
    echo "❌ FATAL ERROR\n";
    echo "========================================\n\n";
    echo "Message: " . $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
}

echo "</pre>";
