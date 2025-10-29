<?php
/**
 * Fix open_basedir restriction issue
 * This clears all view caches and optimizes the application
 */

define('SECURITY_KEY', 'FixOpenBasedir2025!');

// Only allow execution if the security key is provided
if (!isset($_GET['key']) || $_GET['key'] !== SECURITY_KEY) {
    die('Access denied. Please provide the correct security key.');
}

echo "<h1>Fixing open_basedir restriction...</h1>";

// Change to the Laravel root directory
chdir(__DIR__);

// Define Laravel paths
$basePath = __DIR__;
$storagePath = $basePath . '/storage';
$bootstrapCachePath = $basePath . '/bootstrap/cache';

// Function to recursively delete directory contents
function deleteDirectoryContents($dir, $keepGitignore = true) {
    if (!is_dir($dir)) {
        return "Directory not found: $dir<br>";
    }

    $output = "Cleaning: $dir<br>";
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        if ($keepGitignore && $item->getFilename() === '.gitignore') {
            continue;
        }

        if ($item->isDir()) {
            @rmdir($item->getRealPath());
        } else {
            @unlink($item->getRealPath());
        }
    }

    return $output;
}

echo "<h2>Step 1: Clearing View Cache</h2>";
$viewCachePath = $storagePath . '/framework/views';
echo deleteDirectoryContents($viewCachePath);

echo "<h2>Step 2: Clearing Compiled Views</h2>";
$compiledPath = $storagePath . '/framework/views';
if (is_dir($compiledPath)) {
    $files = glob($compiledPath . '/*');
    foreach ($files as $file) {
        if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            @unlink($file);
            echo "Deleted: " . basename($file) . "<br>";
        }
    }
}

echo "<h2>Step 3: Clearing Bootstrap Cache</h2>";
$configCache = $bootstrapCachePath . '/config.php';
$routesCache = $bootstrapCachePath . '/routes-v7.php';
$servicesCache = $bootstrapCachePath . '/services.php';
$packagesCache = $bootstrapCachePath . '/packages.php';

$cacheFiles = [
    $configCache => 'Config cache',
    $routesCache => 'Routes cache',
    $servicesCache => 'Services cache',
    $packagesCache => 'Packages cache'
];

foreach ($cacheFiles as $file => $name) {
    if (file_exists($file)) {
        @unlink($file);
        echo "✅ Deleted: $name<br>";
    } else {
        echo "⚪ Not found: $name<br>";
    }
}

echo "<h2>Step 4: Clearing Application Cache</h2>";
$appCachePath = $storagePath . '/framework/cache';
echo deleteDirectoryContents($appCachePath);

echo "<h2>Step 5: Clearing Session Files</h2>";
$sessionsPath = $storagePath . '/framework/sessions';
echo deleteDirectoryContents($sessionsPath);

echo "<h2>Step 6: Executing Artisan Commands</h2>";

// Run artisan commands
$commands = [
    'config:clear' => 'Clear configuration cache',
    'cache:clear' => 'Clear application cache',
    'route:clear' => 'Clear route cache',
    'view:clear' => 'Clear compiled views',
    'optimize:clear' => 'Clear all optimization caches'
];

foreach ($commands as $command => $description) {
    echo "<br><strong>$description...</strong><br>";
    exec("php artisan $command 2>&1", $output, $returnCode);

    if ($returnCode === 0) {
        echo "✅ Success<br>";
    } else {
        echo "❌ Failed: " . implode('<br>', $output) . "<br>";
    }
    $output = [];
}

echo "<h2>✅ All Done!</h2>";
echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; border-left: 4px solid #28a745;'>";
echo "<h3>Success! Caches Cleared</h3>";
echo "<p>Now try to access the admin panel:</p>";
echo "<a href='/admin/login' style='display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Admin Login</a>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 5px; border-left: 4px solid #ffc107; margin-top: 20px;'>";
echo "<h3>⚠️ Important: Delete This File!</h3>";
echo "<p>For security reasons, please delete this file (<code>fix_openbasedir.php</code>) from your server immediately.</p>";
echo "</div>";

echo "<hr>";
echo "<p><small>Execution completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1, h2 { color: #333; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
</body>
</html>
