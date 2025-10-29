<?php
/**
 * Recreate bootstrap/cache directory
 * Use this if you accidentally deleted the bootstrap/cache folder
 */

define('SECURITY_KEY', 'RecreateCache2025!');

if (!isset($_GET['key']) || $_GET['key'] !== SECURITY_KEY) {
    die('Access denied. Please provide security key in URL: ?key=RecreateCache2025!');
}

echo "<h1>Recreating bootstrap/cache directory...</h1>";

$basePath = __DIR__;
$bootstrapPath = $basePath . '/bootstrap';
$cachePath = $bootstrapPath . '/cache';

echo "<div style='font-family: Arial; padding: 20px; background: #f5f5f5;'>";

// Step 1: Check if bootstrap exists
echo "<h2>Step 1: Checking bootstrap directory...</h2>";
if (!is_dir($bootstrapPath)) {
    echo "❌ ERROR: bootstrap directory not found!<br>";
    die();
}
echo "✅ bootstrap directory exists<br><br>";

// Step 2: Create cache directory
echo "<h2>Step 2: Creating cache directory...</h2>";
if (is_dir($cachePath)) {
    echo "⚠️ cache directory already exists<br>";
} else {
    if (mkdir($cachePath, 0775, true)) {
        echo "✅ cache directory created successfully<br>";
    } else {
        echo "❌ Failed to create cache directory<br>";
        echo "Please create it manually via FTP or File Manager<br>";
    }
}
echo "<br>";

// Step 3: Create .gitignore
echo "<h2>Step 3: Creating .gitignore...</h2>";
$gitignorePath = $cachePath . '/.gitignore';
$gitignoreContent = "*\n!.gitignore\n";
if (file_put_contents($gitignorePath, $gitignoreContent)) {
    echo "✅ .gitignore created<br>";
} else {
    echo "⚠️ Could not create .gitignore (not critical)<br>";
}
echo "<br>";

// Step 4: Set permissions
echo "<h2>Step 4: Setting permissions...</h2>";
if (chmod($cachePath, 0775)) {
    echo "✅ Permissions set to 775<br>";
} else {
    echo "⚠️ Could not set permissions automatically<br>";
    echo "Please set permissions manually: 775<br>";
}
echo "<br>";

// Step 5: Create initial cache files
echo "<h2>Step 5: Creating cache files...</h2>";

$cacheFiles = [
    'packages.php' => "<?php return array();",
    'services.php' => "<?php return array();",
];

foreach ($cacheFiles as $filename => $content) {
    $filePath = $cachePath . '/' . $filename;
    if (file_exists($filePath)) {
        echo "⚠️ $filename already exists<br>";
    } else {
        if (file_put_contents($filePath, $content)) {
            chmod($filePath, 0664);
            echo "✅ $filename created<br>";
        } else {
            echo "❌ Failed to create $filename<br>";
        }
    }
}
echo "<br>";

// Step 6: Verify structure
echo "<h2>Step 6: Verifying structure...</h2>";
$requiredPaths = [
    $cachePath => 'bootstrap/cache directory',
    $gitignorePath => 'bootstrap/cache/.gitignore file',
];

$allGood = true;
foreach ($requiredPaths as $path => $name) {
    if (file_exists($path)) {
        echo "✅ $name exists<br>";
    } else {
        echo "❌ $name missing<br>";
        $allGood = false;
    }
}
echo "<br>";

// Final status
if ($allGood) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; border-left: 5px solid #28a745;'>";
    echo "<h2>✅ Success!</h2>";
    echo "<p>bootstrap/cache directory has been recreated successfully!</p>";
    echo "<h3>Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Try accessing: <a href='/admin/login' target='_blank'>Admin Login</a></li>";
    echo "<li>If you still get errors, run: <code>php artisan optimize:clear</code></li>";
    echo "<li><strong>Delete this file for security!</strong></li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px; border-left: 5px solid #dc3545;'>";
    echo "<h2>⚠️ Partial Success</h2>";
    echo "<p>Some files could not be created. Please:</p>";
    echo "<ol>";
    echo "<li>Create the directory manually via File Manager: <code>bootstrap/cache</code></li>";
    echo "<li>Set permissions to 775</li>";
    echo "<li>Try again</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<hr>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; border-left: 5px solid #ffc107; margin-top: 20px;'>";
echo "<h3>⚠️ Security Warning</h3>";
echo "<p><strong>DELETE THIS FILE NOW:</strong> <code>recreate_bootstrap_cache.php</code></p>";
echo "</div>";

echo "</div>";
?>
