# PowerShell Script to Enable PHP Database Extensions
# Run this as Administrator

Write-Host "===============================================" -ForegroundColor Cyan
Write-Host "   PHP Database Extensions Enabler" -ForegroundColor Cyan
Write-Host "===============================================" -ForegroundColor Cyan
Write-Host ""

# Find php.ini location
Write-Host "Finding php.ini location..." -ForegroundColor Yellow
$phpIniPath = php --ini | Select-String "Loaded Configuration File:" | ForEach-Object { $_ -replace "Loaded Configuration File:\s*", "" }
$phpIniPath = $phpIniPath.Trim()

if (-not $phpIniPath -or $phpIniPath -eq "(none)") {
    Write-Host "ERROR: Could not find php.ini file!" -ForegroundColor Red
    Write-Host "Please ensure PHP is installed correctly." -ForegroundColor Red
    pause
    exit 1
}

Write-Host "Found php.ini at: $phpIniPath" -ForegroundColor Green
Write-Host ""

# Check if we can write to the file
try {
    $testWrite = [System.IO.File]::Open($phpIniPath, 'Open', 'Write')
    $testWrite.Close()
} catch {
    Write-Host "ERROR: Cannot write to php.ini file!" -ForegroundColor Red
    Write-Host "This script must be run as Administrator." -ForegroundColor Red
    Write-Host ""
    Write-Host "To run as Administrator:" -ForegroundColor Yellow
    Write-Host "1. Right-click on PowerShell" -ForegroundColor Yellow
    Write-Host "2. Select 'Run as Administrator'" -ForegroundColor Yellow
    Write-Host "3. Navigate to: cd C:\Users\HP\Desktop\flutter\alenwan-backend" -ForegroundColor Yellow
    Write-Host "4. Run: .\fix-php-extensions.ps1" -ForegroundColor Yellow
    pause
    exit 1
}

# Read php.ini content
$content = Get-Content $phpIniPath -Raw

# Check current state
Write-Host "Checking current extensions..." -ForegroundColor Yellow
$needsUpdate = $false

$extensions = @(
    "pdo_mysql",
    "mysqli",
    "pdo_sqlite",
    "sqlite3"
)

foreach ($ext in $extensions) {
    if ($content -match ";extension=$ext") {
        Write-Host "  ❌ $ext is DISABLED" -ForegroundColor Red
        $needsUpdate = $true
    } elseif ($content -match "^extension=$ext" -or $content -match "\nextension=$ext") {
        Write-Host "  ✅ $ext is ENABLED" -ForegroundColor Green
    } else {
        Write-Host "  ⚠️  $ext not found, will add it" -ForegroundColor Yellow
        $needsUpdate = $true
    }
}

if (-not $needsUpdate) {
    Write-Host ""
    Write-Host "All extensions are already enabled! ✅" -ForegroundColor Green
    Write-Host ""
    Write-Host "If you're still getting errors, try:" -ForegroundColor Yellow
    Write-Host "1. Restart Apache/web server" -ForegroundColor Yellow
    Write-Host "2. Run: php artisan config:clear" -ForegroundColor Yellow
    Write-Host "3. Run: php artisan migrate" -ForegroundColor Yellow
    pause
    exit 0
}

Write-Host ""
Write-Host "Creating backup..." -ForegroundColor Yellow
$backupPath = "$phpIniPath.backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
Copy-Item $phpIniPath $backupPath
Write-Host "Backup created at: $backupPath" -ForegroundColor Green
Write-Host ""

Write-Host "Enabling extensions..." -ForegroundColor Yellow

# Enable each extension
foreach ($ext in $extensions) {
    if ($content -match ";extension=$ext") {
        $content = $content -replace ";extension=$ext", "extension=$ext"
        Write-Host "  ✅ Enabled $ext" -ForegroundColor Green
    } elseif ($content -notmatch "extension=$ext") {
        # Extension line doesn't exist, add it
        # Find the extensions section and add it there
        if ($content -match "(\[PHP\].*?)(;.*?extension.*?)") {
            $content = $content -replace "(;.*?extension=.*?\r?\n)", "`$1extension=$ext`r`n"
        } else {
            $content += "`r`nextension=$ext"
        }
        Write-Host "  ✅ Added $ext" -ForegroundColor Green
    }
}

# Save changes
Set-Content -Path $phpIniPath -Value $content -NoNewline
Write-Host ""
Write-Host "Changes saved successfully! ✅" -ForegroundColor Green
Write-Host ""

# Verify changes
Write-Host "Verifying extensions..." -ForegroundColor Yellow
Write-Host ""

# Need to restart PHP to see changes
Write-Host "⚠️  Important: You must restart your web server!" -ForegroundColor Yellow
Write-Host ""
Write-Host "If using XAMPP:" -ForegroundColor Cyan
Write-Host "  1. Open XAMPP Control Panel" -ForegroundColor White
Write-Host "  2. Click 'Stop' for Apache and MySQL" -ForegroundColor White
Write-Host "  3. Wait 3 seconds" -ForegroundColor White
Write-Host "  4. Click 'Start' for MySQL" -ForegroundColor White
Write-Host "  5. Click 'Start' for Apache" -ForegroundColor White
Write-Host ""
Write-Host "If using 'php artisan serve':" -ForegroundColor Cyan
Write-Host "  1. Press Ctrl+C to stop" -ForegroundColor White
Write-Host "  2. Run: php artisan serve" -ForegroundColor White
Write-Host ""

Write-Host "After restarting, verify with:" -ForegroundColor Yellow
Write-Host "  php -r `"print_r(PDO::getAvailableDrivers());`"" -ForegroundColor White
Write-Host ""
Write-Host "Then run:" -ForegroundColor Yellow
Write-Host "  php artisan migrate" -ForegroundColor White
Write-Host ""

Write-Host "===============================================" -ForegroundColor Cyan
Write-Host "   Setup Complete!" -ForegroundColor Green
Write-Host "===============================================" -ForegroundColor Cyan
Write-Host ""

pause
