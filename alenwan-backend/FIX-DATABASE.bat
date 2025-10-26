@echo off
title Fix PHP Database Extensions
color 0A

echo ================================================
echo    PHP Database Extensions Auto-Fixer
echo ================================================
echo.

echo This will enable MySQL and SQLite extensions in PHP
echo.

echo Checking administrator privileges...
net session >nul 2>&1
if %errorLevel% == 0 (
    echo [OK] Running as Administrator
    echo.
    goto :run_fix
) else (
    echo [ERROR] This script requires Administrator privileges!
    echo.
    echo Please:
    echo 1. Right-click on this file: FIX-DATABASE.bat
    echo 2. Select "Run as administrator"
    echo.
    pause
    exit /b 1
)

:run_fix
echo Starting fix...
echo.

powershell -ExecutionPolicy Bypass -File "%~dp0fix-php-extensions.ps1"

echo.
echo ================================================
echo    Fix Complete!
echo ================================================
echo.
echo Next steps:
echo 1. Restart your web server (XAMPP Apache)
echo 2. Run: php artisan migrate
echo.
pause
