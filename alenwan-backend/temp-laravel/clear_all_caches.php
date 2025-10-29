<?php
/**
 * ULTIMATE CACHE CLEANER
 * Clears ALL caches and view files to fix open_basedir issues
 */

define('SECURITY_KEY', 'ClearAllCaches2025!');

if (!isset($_GET['key']) || $_GET['key'] !== SECURITY_KEY) {
    die('Access denied. URL: ?key=ClearAllCaches2025!');
}

set_time_limit(300);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Clear All Caches</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; margin: 10px 0; border-left: 5px solid #28a745; }
        .warning { background: #fff3cd; padding: 15px; margin: 10px 0; border-left: 5px solid #ffc107; }
        .error { background: #f8d7da; padding: 15px; margin: 10px 0; border-left: 5px solid #dc3545; }
        .info { background: #d1ecf1; padding: 15px; margin: 10px 0; border-left: 5px solid #17a2b8; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>🧹 Ultimate Cache Cleaner</h1>

<?php

$basePath = __DIR__;
$totalDeleted = 0;

// Function to delete directory contents
function deleteAllFiles($dir, &$count) {
    if (!is_dir($dir)) {
        return "Directory not found: $dir";
    }

    $output = "<strong>Cleaning: " . basename($dir) . "</strong><br>";
    $files = glob($dir . '/*');

    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            if (@unlink($file)) {
                $count++;
                $output .= "✅ " . basename($file) . "<br>";
            }
        } elseif (is_dir($file)) {
            $output .= deleteAllFiles($file, $count);
            @rmdir($file);
        }
    }

    return $output;
}

echo "<h2>Step 1: Clearing Compiled Views</h2>";
echo "<div class='info'>";
$viewsPath = $basePath . '/storage/framework/views';
echo deleteAllFiles($viewsPath, $totalDeleted);
echo "</div>";

echo "<h2>Step 2: Clearing Cached Data</h2>";
echo "<div class='info'>";
$cachePath = $basePath . '/storage/framework/cache/data';
echo deleteAllFiles($cachePath, $totalDeleted);
echo "</div>";

echo "<h2>Step 3: Clearing Application Cache</h2>";
echo "<div class='info'>";
$appCachePath = $basePath . '/storage/framework/cache';
if (is_dir($appCachePath)) {
    $files = glob($appCachePath . '/*');
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            @unlink($file);
            $totalDeleted++;
            echo "✅ " . basename($file) . "<br>";
        }
    }
}
echo "</div>";

echo "<h2>Step 4: Clearing Bootstrap Cache</h2>";
echo "<div class='info'>";
$bootstrapCache = $basePath . '/bootstrap/cache';
$bootstrapFiles = [
    'config.php',
    'routes-v7.php',
    'services.php',
    'packages.php',
    'livewire-components.php'
];

foreach ($bootstrapFiles as $filename) {
    $file = $bootstrapCache . '/' . $filename;
    if (file_exists($file)) {
        @unlink($file);
        $totalDeleted++;
        echo "✅ $filename<br>";
    } else {
        echo "⚪ $filename (not found)<br>";
    }
}
echo "</div>";

echo "<h2>Step 5: Clearing Session Files</h2>";
echo "<div class='info'>";
$sessionsPath = $basePath . '/storage/framework/sessions';
echo deleteAllFiles($sessionsPath, $totalDeleted);
echo "</div>";

echo "<h2>Step 6: Running Artisan Commands</h2>";
echo "<div class='info'>";

$artisanCommands = [
    'config:clear',
    'cache:clear',
    'route:clear',
    'view:clear',
    'optimize:clear'
];

foreach ($artisanCommands as $cmd) {
    echo "<strong>php artisan $cmd</strong><br>";
    exec("php artisan $cmd 2>&1", $output, $code);

    if ($code === 0) {
        echo "✅ Success<br>";
    } else {
        echo "❌ Error: " . implode('<br>', $output) . "<br>";
    }
    $output = [];
    echo "<br>";
}
echo "</div>";

echo "<h2>📊 Summary</h2>";
echo "<div class='success'>";
echo "<h3>✅ Cleaning Complete!</h3>";
echo "<p><strong>Total files deleted:</strong> $totalDeleted</p>";
echo "<p>All caches have been cleared successfully.</p>";
echo "</div>";

echo "<div class='warning'>";
echo "<h3>🎯 Next Steps:</h3>";
echo "<ol>";
echo "<li>Try accessing: <a href='/admin/login' class='btn' target='_blank'>Admin Login</a></li>";
echo "<li>If it still fails, contact your hosting support about <code>open_basedir</code> restrictions</li>";
echo "<li><strong>DELETE THIS FILE NOW!</strong> <code>clear_all_caches.php</code></li>";
echo "</ol>";
echo "</div>";

echo "<div class='error'>";
echo "<h3>⚠️ SECURITY WARNING</h3>";
echo "<p><strong>DELETE THIS FILE IMMEDIATELY:</strong></p>";
echo "<p><code>clear_all_caches.php</code></p>";
echo "<p>Keeping this file on your server is a security risk!</p>";
echo "</div>";

echo "<hr>";
echo "<p><small>Executed at: " . date('Y-m-d H:i:s') . "</small></p>";

?>
</body>
</html>
