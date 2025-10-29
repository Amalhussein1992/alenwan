@echo off
echo ================================================
echo   Alenwan Backend - Deployment Preparation
echo ================================================
echo.

echo [1/6] Cleaning cache and temporary files...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo Done!
echo.

echo [2/6] Optimizing autoloader...
composer dump-autoload --optimize
echo Done!
echo.

echo [3/6] Creating production caches...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo Done!
echo.

echo [4/6] Optimizing for production...
php artisan optimize
echo Done!
echo.

echo [5/6] Removing development dependencies...
echo (Skipped - Run 'composer install --no-dev' manually on server)
echo.

echo [6/6] Creating deployment info file...
echo Deployment prepared on: %date% %time% > deployment-info.txt
echo Environment: Production >> deployment-info.txt
echo PHP Version: >> deployment-info.txt
php -v >> deployment-info.txt
echo Done!
echo.

echo ================================================
echo   Preparation Complete!
echo ================================================
echo.
echo Next steps:
echo 1. Compress the 'temp-laravel' folder to 'alenwan-backend.zip'
echo 2. Upload to your server
echo 3. Follow DEPLOYMENT_GUIDE.md instructions
echo.
echo Important files to check:
echo - .env (update for production)
echo - composer.json
echo - All files in storage/ and bootstrap/cache/
echo.

pause
