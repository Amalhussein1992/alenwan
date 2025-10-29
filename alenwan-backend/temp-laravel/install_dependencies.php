<?php
/**
 * Install Missing Dependencies (Filament & Livewire)
 * Run this on production server to install all required packages
 */

define('SECURITY_KEY', 'InstallDeps2025!');

if (!isset($_GET['key']) || $_GET['key'] !== SECURITY_KEY) {
    die('Access denied. URL: ?key=InstallDeps2025!');
}

set_time_limit(600); // 10 minutes

?>
<!DOCTYPE html>
<html>
<head>
    <title>Install Dependencies</title>
    <style>
        body { font-family: Arial; max-width: 1000px; margin: 30px auto; padding: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; margin: 10px 0; border-left: 5px solid #28a745; border-radius: 5px; }
        .error { background: #f8d7da; padding: 15px; margin: 10px 0; border-left: 5px solid #dc3545; border-radius: 5px; }
        .warning { background: #fff3cd; padding: 15px; margin: 10px 0; border-left: 5px solid #ffc107; border-radius: 5px; }
        .info { background: #d1ecf1; padding: 15px; margin: 10px 0; border-left: 5px solid #17a2b8; border-radius: 5px; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-top: 30px; }
        code { background: #f4f4f4; padding: 3px 8px; border-radius: 3px; font-family: monospace; }
        pre { background: #2d3748; color: #48bb78; padding: 15px; border-radius: 8px; overflow-x: auto; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .loading { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <h1>📦 Installing Dependencies</h1>

<?php

$basePath = __DIR__;

echo "<div class='info'>";
echo "<h3>Base Path:</h3>";
echo "<code>$basePath</code>";
echo "</div>";

// Step 1: Check composer
echo "<h2>Step 1: Checking Composer</h2>";
exec('composer --version 2>&1', $composerOutput, $composerCode);
if ($composerCode === 0) {
    echo "<div class='success'>✅ Composer is installed<br>";
    echo "<code>" . implode('<br>', $composerOutput) . "</code>";
    echo "</div>";
} else {
    echo "<div class='error'>❌ Composer not found!<br>";
    echo "Please install Composer first: https://getcomposer.org</div>";
    die();
}

// Step 2: Check if vendor exists
echo "<h2>Step 2: Checking vendor directory</h2>";
$vendorPath = $basePath . '/vendor';
if (is_dir($vendorPath)) {
    echo "<div class='success'>✅ vendor directory exists</div>";
} else {
    echo "<div class='warning'>⚠️ vendor directory not found - will be created during install</div>";
}

// Step 3: Check composer.json
echo "<h2>Step 3: Checking composer.json</h2>";
$composerJsonPath = $basePath . '/composer.json';
if (file_exists($composerJsonPath)) {
    echo "<div class='success'>✅ composer.json exists</div>";

    $composerJson = json_decode(file_get_contents($composerJsonPath), true);

    echo "<div class='info'>";
    echo "<h4>Required Packages:</h4>";
    echo "<ul>";

    $requiredPackages = [
        'filament/filament' => 'Filament Admin Panel',
        'livewire/livewire' => 'Livewire Components',
    ];

    foreach ($requiredPackages as $package => $description) {
        if (isset($composerJson['require'][$package])) {
            echo "<li>✅ <code>$package</code> - $description</li>";
        } else {
            echo "<li>❌ <code>$package</code> - Missing!</li>";
        }
    }
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div class='error'>❌ composer.json not found!</div>";
    die();
}

// Step 4: Run composer install
echo "<h2>Step 4: Installing Dependencies</h2>";
echo "<div class='info'><p>This may take 2-5 minutes...</p><div class='loading'></div></div>";
echo "<pre>";

$command = 'cd ' . escapeshellarg($basePath) . ' && composer install --no-dev --optimize-autoloader 2>&1';
echo "Executing: <code>composer install --no-dev --optimize-autoloader</code><br><br>";

// Execute and stream output
$handle = popen($command, 'r');
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle);
        echo htmlspecialchars($buffer);
        flush();
        ob_flush();
    }
    $returnCode = pclose($handle);

    echo "</pre>";

    if ($returnCode === 0) {
        echo "<div class='success'>";
        echo "<h3>✅ Dependencies installed successfully!</h3>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ Installation failed with code: $returnCode</h3>";
        echo "<p>Please check the output above for errors.</p>";
        echo "</div>";
    }
} else {
    echo "</pre>";
    echo "<div class='error'>❌ Could not execute composer command</div>";
}

// Step 5: Verify installation
echo "<h2>Step 5: Verifying Installation</h2>";

$packagesToCheck = [
    'vendor/filament/filament/src/FilamentServiceProvider.php' => 'Filament',
    'vendor/livewire/livewire/src/LivewireServiceProvider.php' => 'Livewire',
];

echo "<div class='info'>";
echo "<h4>Checking installed packages:</h4>";
echo "<ul>";

$allInstalled = true;
foreach ($packagesToCheck as $file => $name) {
    $fullPath = $basePath . '/' . $file;
    if (file_exists($fullPath)) {
        echo "<li>✅ $name installed</li>";
    } else {
        echo "<li>❌ $name NOT found</li>";
        $allInstalled = false;
    }
}
echo "</ul>";
echo "</div>";

// Step 6: Run optimize
if ($allInstalled) {
    echo "<h2>Step 6: Optimizing Application</h2>";
    echo "<pre>";

    $optimizeCommands = [
        'composer dump-autoload --optimize',
        'php artisan optimize:clear',
        'php artisan filament:optimize',
    ];

    foreach ($optimizeCommands as $cmd) {
        echo "<br><strong>Running: $cmd</strong><br>";
        exec("cd " . escapeshellarg($basePath) . " && $cmd 2>&1", $output, $code);
        echo htmlspecialchars(implode("\n", $output));
        $output = [];
    }

    echo "</pre>";
}

// Final summary
echo "<h2>📊 Installation Summary</h2>";

if ($allInstalled) {
    echo "<div class='success'>";
    echo "<h3>🎉 Success! All dependencies are installed!</h3>";
    echo "<h4>Next Steps:</h4>";
    echo "<ol>";
    echo "<li>Try accessing the admin panel: <a href='/admin/login' target='_blank'>Admin Login</a></li>";
    echo "<li>Login with: <code>admin@alenwan.com</code> / <code>Alenwan@Admin2025!</code></li>";
    echo "<li><strong>DELETE THIS FILE:</strong> <code>install_dependencies.php</code></li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>⚠️ Installation Incomplete</h3>";
    echo "<p>Some packages could not be installed. Please:</p>";
    echo "<ol>";
    echo "<li>Check if you have enough disk space</li>";
    echo "<li>Verify composer.json is correct</li>";
    echo "<li>Try running manually via SSH: <code>composer install</code></li>";
    echo "<li>Contact your hosting support if the problem persists</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<div class='warning'>";
echo "<h3>🔒 Security Warning</h3>";
echo "<p><strong>IMPORTANT:</strong> Delete this file immediately after use!</p>";
echo "<p><code>install_dependencies.php</code></p>";
echo "</div>";

echo "<hr>";
echo "<p><small>Executed at: " . date('Y-m-d H:i:s') . "</small></p>";

?>
</body>
</html>
