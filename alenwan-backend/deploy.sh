#!/bin/bash

# Alenwan Backend Deployment Script
# Usage: ./deploy.sh [environment]
# Example: ./deploy.sh production

set -e

ENVIRONMENT=${1:-production}
PROJECT_DIR="/var/www/alenwan"
BACKUP_DIR="/var/backups/alenwan"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "🚀 Starting Alenwan Backend Deployment..."
echo "Environment: $ENVIRONMENT"
echo "Timestamp: $TIMESTAMP"

# Create backup
echo "📦 Creating backup..."
mkdir -p $BACKUP_DIR
if [ -d "$PROJECT_DIR" ]; then
    tar -czf "$BACKUP_DIR/backup_$TIMESTAMP.tar.gz" -C "$PROJECT_DIR" .
    echo "✅ Backup created: $BACKUP_DIR/backup_$TIMESTAMP.tar.gz"
fi

# Pull latest code
echo "📥 Pulling latest code..."
cd $PROJECT_DIR
git pull origin main

# Install/Update dependencies
echo "📚 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Copy environment file
echo "⚙️ Setting up environment..."
if [ "$ENVIRONMENT" = "production" ]; then
    cp .env.production .env
else
    cp .env.staging .env
fi

# Generate application key if not exists
php artisan key:generate --no-interaction

# Clear and cache config
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache configurations for production
if [ "$ENVIRONMENT" = "production" ]; then
    echo "💾 Caching configurations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed initial data if needed
if [ "$ENVIRONMENT" = "production" ] && [ ! -f "/tmp/seeded" ]; then
    echo "🌱 Seeding initial data..."
    php artisan db:seed --force
    touch /tmp/seeded
fi

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data $PROJECT_DIR
chmod -R 755 $PROJECT_DIR
chmod -R 775 $PROJECT_DIR/storage
chmod -R 775 $PROJECT_DIR/bootstrap/cache

# Create symbolic links for storage
php artisan storage:link

# Restart services
echo "🔄 Restarting services..."
systemctl reload nginx
systemctl restart php8.2-fpm

# Run health check
echo "🏥 Running health check..."
sleep 5
if curl -f -s http://localhost/api/health > /dev/null; then
    echo "✅ Health check passed"
else
    echo "❌ Health check failed"
    exit 1
fi

# Clean old backups (keep last 5)
echo "🧹 Cleaning old backups..."
cd $BACKUP_DIR
ls -t backup_*.tar.gz | tail -n +6 | xargs -r rm

echo "🎉 Deployment completed successfully!"
echo "🌐 Application is now live at: https://yourdomain.com"

# Send deployment notification (optional)
if command -v curl &> /dev/null; then
    curl -X POST "https://hooks.slack.com/services/YOUR/SLACK/WEBHOOK" \
         -H 'Content-type: application/json' \
         --data "{\"text\":\"🚀 Alenwan Backend deployed successfully to $ENVIRONMENT at $TIMESTAMP\"}" || true
fi