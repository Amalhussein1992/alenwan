<?php
/**
 * Plesk Migration & Setup Script
 * Upload to: /httpdocs/plesk_installer.php
 * Access: https://www.alenwanapp.net/plesk_installer.php
 *
 * ⚠️ DELETE THIS FILE AFTER USE!
 */

set_time_limit(300); // 5 minutes
ini_set('max_execution_time', 300);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Plesk Laravel Installer</title>
    <style>
        body {
            background: #1a1a1a;
            color: #00ff00;
            font-family: 'Courier New', monospace;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #0a0a0a;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,255,0,0.3);
        }
        h1 {
            color: #00ffff;
            text-align: center;
            border-bottom: 2px solid #00ff00;
            padding-bottom: 10px;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            background: #1a1a1a;
            border-left: 4px solid #00ff00;
        }
        .success { color: #00ff00; }
        .error { color: #ff0000; }
        .warning { color: #ffff00; }
        .info { color: #00ffff; }
        pre {
            background: #000;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        button {
            background: #00ff00;
            color: #000;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 5px;
        }
        button:hover {
            background: #00ffff;
        }
        .danger {
            background: #ff0000;
        }
        .danger:hover {
            background: #ff5555;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 Plesk Laravel Setup & Migration</h1>

<?php
// Change to Laravel root
$laravelRoot = dirname(__FILE__);
if (basename($laravelRoot) === 'public') {
    $laravelRoot = dirname($laravelRoot);
}
chdir($laravelRoot);

echo "<div class='step'>";
echo "<h3>📂 Directory Information</h3>";
echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";
echo "<p><strong>Artisan Exists:</strong> " . (file_exists('artisan') ? '✅ Yes' : '❌ No') . "</p>";
echo "<p><strong>Vendor Exists:</strong> " . (file_exists('vendor/autoload.php') ? '✅ Yes' : '❌ No') . "</p>";
echo "<p><strong>.env Exists:</strong> " . (file_exists('.env') ? '✅ Yes' : '❌ No') . "</p>";
echo "</div>";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    echo "<div class='step'>";
    echo "<h3>🔧 Executing: " . htmlspecialchars($action) . "</h3>";
    echo "<pre>";

    switch ($action) {
        case 'check_db':
            echo "<span class='info'>Testing Database Connection...</span>\n\n";
            try {
                require 'vendor/autoload.php';
                $app = require_once 'bootstrap/app.php';
                $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
                $kernel->bootstrap();

                DB::connection()->getPdo();
                echo "<span class='success'>✅ Database Connected Successfully!</span>\n";
                echo "Database: " . DB::connection()->getDatabaseName() . "\n\n";

                echo "Tables in database:\n";
                $tables = DB::select('SHOW TABLES');
                foreach ($tables as $table) {
                    $tableName = array_values((array)$table)[0];
                    echo "  • $tableName\n";
                }
            } catch (Exception $e) {
                echo "<span class='error'>❌ Database Error:</span>\n";
                echo $e->getMessage();
            }
            break;

        case 'migrate':
            echo "<span class='info'>Running Migrations...</span>\n\n";
            exec('php artisan migrate --force 2>&1', $output, $return);
            echo implode("\n", $output);
            echo "\n\n";
            echo $return === 0 ? "<span class='success'>✅ Migrations completed!</span>" : "<span class='error'>❌ Migration failed with code: $return</span>";
            break;

        case 'seed':
            echo "<span class='info'>Running Database Seeders...</span>\n\n";
            exec('php artisan db:seed --force 2>&1', $output, $return);
            echo implode("\n", $output);
            echo "\n\n";
            echo $return === 0 ? "<span class='success'>✅ Seeding completed!</span>" : "<span class='error'>❌ Seeding failed with code: $return</span>";
            break;

        case 'clear_cache':
            echo "<span class='info'>Clearing All Cache...</span>\n\n";

            exec('php artisan cache:clear 2>&1', $out1);
            echo "Cache: " . implode("\n", $out1) . "\n";

            exec('php artisan config:clear 2>&1', $out2);
            echo "Config: " . implode("\n", $out2) . "\n";

            exec('php artisan route:clear 2>&1', $out3);
            echo "Routes: " . implode("\n", $out3) . "\n";

            exec('php artisan view:clear 2>&1', $out4);
            echo "Views: " . implode("\n", $out4) . "\n\n";

            echo "<span class='success'>✅ All cache cleared!</span>";
            break;

        case 'optimize':
            echo "<span class='info'>Optimizing Application...</span>\n\n";

            exec('php artisan config:cache 2>&1', $out1);
            echo "Config cache: " . implode("\n", $out1) . "\n";

            exec('php artisan route:cache 2>&1', $out2);
            echo "Route cache: " . implode("\n", $out2) . "\n";

            exec('php artisan optimize 2>&1', $out3);
            echo "Optimize: " . implode("\n", $out3) . "\n\n";

            echo "<span class='success'>✅ Optimization completed!</span>";
            break;

        case 'fix_permissions':
            echo "<span class='info'>Fixing File Permissions...</span>\n\n";

            exec('chmod -R 755 storage 2>&1', $out1);
            echo "Storage: " . implode("\n", $out1) . "\n";

            exec('chmod -R 755 bootstrap/cache 2>&1', $out2);
            echo "Bootstrap cache: " . implode("\n", $out2) . "\n\n";

            echo "<span class='success'>✅ Permissions fixed!</span>";
            break;

        case 'add_admin':
            echo "<span class='info'>Creating Admin User...</span>\n\n";
            try {
                require 'vendor/autoload.php';
                $app = require_once 'bootstrap/app.php';
                $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
                $kernel->bootstrap();

                // Check if role column exists
                if (!Schema::hasColumn('users', 'role')) {
                    DB::statement("ALTER TABLE users ADD COLUMN role VARCHAR(50) DEFAULT 'user' AFTER password");
                    echo "✅ Added 'role' column to users table\n\n";
                }

                // Create or update admin
                $admin = DB::table('users')->where('email', 'admin@alenwan.com')->first();
                if ($admin) {
                    DB::table('users')->where('email', 'admin@alenwan.com')->update([
                        'role' => 'admin',
                        'password' => '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
                        'updated_at' => now(),
                    ]);
                    echo "<span class='success'>✅ Admin user updated!</span>\n";
                } else {
                    DB::table('users')->insert([
                        'name' => 'Admin',
                        'email' => 'admin@alenwan.com',
                        'password' => '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
                        'role' => 'admin',
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    echo "<span class='success'>✅ Admin user created!</span>\n";
                }

                $admin = DB::table('users')->where('email', 'admin@alenwan.com')->first();
                echo "\nAdmin Details:\n";
                echo "  ID: {$admin->id}\n";
                echo "  Name: {$admin->name}\n";
                echo "  Email: {$admin->email}\n";
                echo "  Role: " . ($admin->role ?? 'N/A') . "\n";

            } catch (Exception $e) {
                echo "<span class='error'>❌ Error:</span>\n";
                echo $e->getMessage();
            }
            break;

        case 'full_setup':
            echo "<span class='info'>🚀 Running Full Setup...</span>\n\n";

            echo "Step 1: Migrations\n";
            echo str_repeat("=", 50) . "\n";
            exec('php artisan migrate --force 2>&1', $out1);
            echo implode("\n", $out1) . "\n\n";

            echo "Step 2: Seeders\n";
            echo str_repeat("=", 50) . "\n";
            exec('php artisan db:seed --force 2>&1', $out2);
            echo implode("\n", $out2) . "\n\n";

            echo "Step 3: Clear Cache\n";
            echo str_repeat("=", 50) . "\n";
            exec('php artisan cache:clear 2>&1', $out3);
            exec('php artisan config:clear 2>&1', $out4);
            echo "Cache cleared\n\n";

            echo "Step 4: Optimize\n";
            echo str_repeat("=", 50) . "\n";
            exec('php artisan config:cache 2>&1', $out5);
            exec('php artisan route:cache 2>&1', $out6);
            echo "Optimized\n\n";

            echo "<span class='success'>✅ Full setup completed!</span>\n";
            echo "\n<span class='warning'>⚠️  Now try: https://www.alenwanapp.net/admin/login</span>";
            break;
    }

    echo "</pre>";
    echo "</div>";
}
?>

    <div class='step'>
        <h3>🎛️ Control Panel</h3>
        <p>Choose an action to execute:</p>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="check_db">
            <button type="submit">🔍 Check Database</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="migrate">
            <button type="submit">📊 Run Migrations</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="add_admin">
            <button type="submit">👤 Create Admin User</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="seed">
            <button type="submit">🌱 Run Seeders</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="clear_cache">
            <button type="submit">🗑️ Clear Cache</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="optimize">
            <button type="submit">⚡ Optimize</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="fix_permissions">
            <button type="submit">🔐 Fix Permissions</button>
        </form>

        <form method="POST" style="display: inline;" onsubmit="return confirm('This will run ALL setup steps. Continue?')">
            <input type="hidden" name="action" value="full_setup">
            <button type="submit" class="danger">🚀 FULL SETUP (All Steps)</button>
        </form>
    </div>

    <div class='step'>
        <h3>📋 Admin Login Info</h3>
        <p><strong>URL:</strong> <a href="/admin/login" style="color: #00ffff;">https://www.alenwanapp.net/admin/login</a></p>
        <p><strong>Email:</strong> admin@alenwan.com</p>
        <p><strong>Password:</strong> Alenwan@Admin2025!</p>
    </div>

    <div class='step'>
        <h3 style="color: #ff0000;">⚠️ SECURITY WARNING</h3>
        <p>DELETE this file after completing setup!</p>
        <p><code>rm /httpdocs/plesk_installer.php</code></p>
    </div>

</div>
</body>
</html>
