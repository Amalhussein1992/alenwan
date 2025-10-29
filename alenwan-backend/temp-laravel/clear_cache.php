<?php
/**
 * Simple Cache Clear
 * Upload to: /httpdocs/public/clear_cache.php
 * Access via: https://www.alenwanapp.net/clear_cache.php
 * Then DELETE this file!
 */

// Go up one directory to reach Laravel root
chdir(__DIR__ . '/..');

if (file_exists('artisan')) {
    echo "<pre>";
    echo "Clearing cache...\n\n";

    exec('php artisan cache:clear 2>&1', $output1);
    echo implode("\n", $output1) . "\n\n";

    exec('php artisan config:clear 2>&1', $output2);
    echo implode("\n", $output2) . "\n\n";

    exec('php artisan config:cache 2>&1', $output3);
    echo implode("\n", $output3) . "\n\n";

    echo "✅ Cache cleared!\n\n";
    echo "Now try: <a href='/admin/login'>Admin Login</a>\n";
    echo "\n⚠️  DELETE this file: /httpdocs/public/clear_cache.php\n";
    echo "</pre>";
} else {
    echo "Error: artisan file not found in parent directory!";
    echo "<br>Current dir: " . getcwd();
}
