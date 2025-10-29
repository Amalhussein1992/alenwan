<?php
/**
 * EMERGENCY FIX for Admin 500 Error
 *
 * Upload to: /public_html/emergency_fix.php
 * Access via: https://www.alenwanapp.net/emergency_fix.php
 *
 * After fix, DELETE this file for security!
 */

// Add output immediately
header('Content-Type: text/plain; charset=utf-8');
ob_implicit_flush(true);
ob_end_flush();

echo "========================================\n";
echo "   EMERGENCY FIX - Admin 500 Error\n";
echo "========================================\n\n";

try {
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "✅ Laravel loaded successfully\n\n";

    // Test database connection
    echo "Step 1/6: Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✅ Database connected!\n\n";

    // Check and fix users table
    echo "Step 2/6: Checking users table...\n";
    if (!Schema::hasTable('users')) {
        echo "❌ ERROR: users table does not exist!\n";
        echo "   Please run: php artisan migrate --force\n\n";
        exit(1);
    }
    echo "✅ users table exists\n\n";

    // Add role column
    echo "Step 3/6: Checking role column...\n";
    if (!Schema::hasColumn('users', 'role')) {
        echo "⚠️  role column missing, adding it now...\n";
        Schema::table('users', function ($table) {
            $table->string('role')->default('user')->after('password');
            $table->index('role');
        });
        echo "✅ role column added!\n\n";
    } else {
        echo "✅ role column exists\n\n";
    }

    // Check sessions table
    echo "Step 4/6: Checking sessions table...\n";
    if (!Schema::hasTable('sessions')) {
        echo "⚠️  sessions table missing, creating it...\n";
        Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        echo "✅ sessions table created!\n\n";
    } else {
        echo "✅ sessions table exists\n\n";
    }

    // Create/update admin user
    echo "Step 5/6: Creating admin user...\n";
    $admin = DB::table('users')->where('email', 'admin@alenwan.com')->first();

    if ($admin) {
        echo "⚠️  Admin user exists, updating...\n";
        DB::table('users')
            ->where('email', 'admin@alenwan.com')
            ->update([
                'role' => 'admin',
                'password' => Hash::make('Alenwan@Admin2025!'),
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]);
        echo "✅ Admin user updated!\n\n";
    } else {
        echo "⚠️  Admin user not found, creating...\n";
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Admin user created!\n\n";
    }

    // Clear cache
    echo "Step 6/6: Clearing cache...\n";
    Artisan::call('cache:clear');
    echo "  ✓ Cache cleared\n";

    Artisan::call('config:clear');
    echo "  ✓ Config cleared\n";

    Artisan::call('route:clear');
    echo "  ✓ Routes cleared\n";

    Artisan::call('view:clear');
    echo "  ✓ Views cleared\n";

    Artisan::call('config:cache');
    echo "  ✓ Config cached\n";

    echo "\n";

    echo "========================================\n";
    echo "🎉 FIX COMPLETED SUCCESSFULLY!\n";
    echo "========================================\n\n";

    echo "Admin Login Details:\n";
    echo "-------------------\n";
    echo "URL: https://www.alenwanapp.net/admin/login\n";
    echo "Email: admin@alenwan.com\n";
    echo "Password: Alenwan@Admin2025!\n\n";

    echo "⚠️  IMPORTANT: DELETE THIS FILE NOW!\n";
    echo "   Run: rm /public_html/emergency_fix.php\n\n";

    echo "Now try: https://www.alenwanapp.net/admin/login\n";

} catch (\Exception $e) {
    echo "\n❌ ERROR OCCURRED:\n";
    echo "==================\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n";
    echo $e->getTraceAsString() . "\n";
}
