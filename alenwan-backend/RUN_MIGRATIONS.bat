@echo off
title Run Database Migrations
color 0A

echo ================================================
echo    Alenwan Database Setup
echo ================================================
echo.

echo Using XAMPP's PHP (has database drivers enabled)
echo.

cd /d "C:\Users\HP\Desktop\flutter\alenwan-backend"

echo Step 1: Clearing Laravel cache...
C:\xampp\php\php.exe artisan config:clear
echo.

echo Step 2: Running migrations...
echo.
C:\xampp\php\php.exe artisan migrate:fresh
echo.

echo Step 3: Seeding database with sample data...
echo.
C:\xampp\php\php.exe artisan db:seed
echo.

echo ================================================
echo    Setup Complete!
echo ================================================
echo.
echo Database now contains:
echo - Categories (12)
echo - Languages (4)
echo - Subscription Plans (4)
echo - Sample Movies (10)
echo - Admin User
echo.
echo Admin Login:
echo URL: http://localhost:8000/admin/login
echo Email: admin@alenwan.com
echo Password: admin123
echo.
echo All forms will now save to database!
echo.
pause
