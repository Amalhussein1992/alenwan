# PowerShell script to enable SQLite in PHP

$phpIniPath = "C:\Program Files\Php\php.ini"

Write-Host "Enabling SQLite extensions in PHP..." -ForegroundColor Green

# Read the php.ini file
$content = Get-Content $phpIniPath

# Enable pdo_sqlite extension
$content = $content -replace ';extension=pdo_sqlite', 'extension=pdo_sqlite'

# Enable sqlite3 extension
$content = $content -replace ';extension=sqlite3', 'extension=sqlite3'

# Save the changes
$content | Set-Content $phpIniPath

Write-Host "SQLite extensions have been enabled!" -ForegroundColor Green
Write-Host "Please restart your web server (Apache/nginx) for changes to take effect." -ForegroundColor Yellow

# Verify the changes
Write-Host "`nVerifying changes..." -ForegroundColor Cyan
Get-Content $phpIniPath | Select-String -Pattern "extension=(pdo_)?sqlite"

Write-Host "`nDone! Now run: php artisan migrate" -ForegroundColor Green
