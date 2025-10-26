# 🚀 Alenwan Backend - Production Deployment Guide

## ✅ Production Readiness Status

### Completed Components
- ✅ Laravel 12 backend with full API architecture
- ✅ Complete database schema with migrations
- ✅ JWT authentication system with device management
- ✅ Subscription management (free, basic, premium, platinum)
- ✅ Admin panel with content management
- ✅ Payment gateway integration (Stripe ready)
- ✅ Vimeo & YouTube API integrations
- ✅ Production environment configuration
- ✅ CORS configuration
- ✅ Nginx configuration
- ✅ Docker setup
- ✅ Deployment scripts

### 🔧 Pre-Deployment Checklist

#### 1. Server Requirements
- [ ] PHP 8.2+ with extensions: PDO, mbstring, xml, gd, zip, redis
- [ ] MySQL 8.0+ or PostgreSQL 13+
- [ ] Redis 6.0+
- [ ] Nginx 1.20+
- [ ] SSL certificate (Let's Encrypt recommended)
- [ ] Domain name configured

#### 2. Environment Configuration
- [ ] Update `.env.production` with real values:
  ```bash
  # Generate secure APP_KEY
  php artisan key:generate --show

  # Set your domain
  APP_URL=https://yourdomain.com

  # Database credentials
  DB_HOST=your-db-host
  DB_DATABASE=alenwan_production
  DB_USERNAME=your-db-user
  DB_PASSWORD=your-secure-password

  # JWT Secret (generate secure random string)
  JWT_SECRET=your-256-bit-secret
  ```

#### 3. API Keys Setup
- [ ] **Vimeo API**: Get credentials from https://developer.vimeo.com/
  ```
  VIMEO_CLIENT_ID=your-client-id
  VIMEO_CLIENT_SECRET=your-client-secret
  VIMEO_ACCESS_TOKEN=your-access-token
  ```

- [ ] **YouTube API**: Get credentials from Google Cloud Console
  ```
  YOUTUBE_API_KEY=your-api-key
  YOUTUBE_CLIENT_ID=your-client-id
  YOUTUBE_CLIENT_SECRET=your-client-secret
  ```

- [ ] **Stripe Payment**: Get from https://dashboard.stripe.com/
  ```
  STRIPE_KEY=pk_live_...
  STRIPE_SECRET=sk_live_...
  STRIPE_WEBHOOK_SECRET=whsec_...
  ```

#### 4. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE alenwan_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'alenwan_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON alenwan_production.* TO 'alenwan_user'@'localhost';
FLUSH PRIVILEGES;

# Run migrations
php artisan migrate --force
php artisan db:seed --force
```

### 🚀 Deployment Options

#### Option 1: Traditional Server Deployment

1. **Clone Repository**
   ```bash
   cd /var/www
   git clone https://github.com/yourusername/alenwan-backend.git alenwan
   cd alenwan
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Environment Setup**
   ```bash
   cp .env.production .env
   php artisan key:generate
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   ```

4. **Set Permissions**
   ```bash
   chown -R www-data:www-data /var/www/alenwan
   chmod -R 755 /var/www/alenwan
   chmod -R 775 /var/www/alenwan/storage
   chmod -R 775 /var/www/alenwan/bootstrap/cache
   ```

5. **Configure Nginx**
   ```bash
   cp nginx.production.conf /etc/nginx/sites-available/alenwan
   ln -s /etc/nginx/sites-available/alenwan /etc/nginx/sites-enabled/
   nginx -t
   systemctl reload nginx
   ```

6. **SSL Certificate**
   ```bash
   certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

#### Option 2: Docker Deployment

1. **Build and Run**
   ```bash
   docker build -t alenwan-backend .
   docker run -d -p 80:80 -p 443:443 \
     --env-file .env.production \
     --name alenwan-api \
     alenwan-backend
   ```

2. **With Docker Compose**
   ```yaml
   # docker-compose.yml
   version: '3.8'
   services:
     app:
       build: .
       ports:
         - "80:80"
         - "443:443"
       env_file: .env.production
       depends_on:
         - mysql
         - redis

     mysql:
       image: mysql:8.0
       environment:
         MYSQL_DATABASE: alenwan_production
         MYSQL_USER: alenwan_user
         MYSQL_PASSWORD: ${DB_PASSWORD}
         MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}

     redis:
       image: redis:6-alpine
   ```

### 🔒 Security Hardening

#### Required Security Steps
- [ ] Generate strong JWT secret (256-bit)
- [ ] Enable HTTPS/SSL
- [ ] Configure rate limiting
- [ ] Set secure session cookies
- [ ] Enable CSRF protection
- [ ] Configure proper CORS origins
- [ ] Set up fail2ban for SSH protection
- [ ] Regular security updates

#### Environment Security
```bash
# Secure .env file
chown root:www-data .env
chmod 640 .env

# Disable debug mode
APP_DEBUG=false

# Set secure headers
SECURE_HEADERS_ENABLED=true
SESSION_SECURE_COOKIE=true
```

### 📱 Flutter App Integration

#### Update API Base URL
```dart
// lib/services/api_service.dart
static const String baseUrl = 'https://yourdomain.com';
```

#### Build for Production
```bash
# Web build
flutter build web --release

# Mobile builds
flutter build apk --release
flutter build ios --release
```

### 📊 Monitoring & Analytics

#### Essential Monitoring
- [ ] Set up application logging
- [ ] Monitor database performance
- [ ] Track API response times
- [ ] Monitor user activity
- [ ] Set up error tracking (Sentry)
- [ ] Configure uptime monitoring

#### Performance Optimization
- [ ] Enable Redis caching
- [ ] Configure CDN for static assets
- [ ] Set up database query optimization
- [ ] Enable Gzip compression
- [ ] Implement image optimization

### 🔄 Maintenance

#### Regular Tasks
- [ ] Database backups (daily)
- [ ] Security updates (weekly)
- [ ] Performance monitoring
- [ ] User analytics review
- [ ] Content moderation

#### Backup Strategy
```bash
# Automated database backup
0 2 * * * mysqldump -u backup_user -p$BACKUP_PASSWORD alenwan_production > /backups/alenwan_$(date +\%Y\%m\%d).sql

# File backup
0 3 * * * tar -czf /backups/files_$(date +\%Y\%m\%d).tar.gz /var/www/alenwan/storage
```

### 🆘 Troubleshooting

#### Common Issues
1. **500 Internal Server Error**
   - Check Laravel logs: `tail -f storage/logs/laravel.log`
   - Verify permissions: `chmod -R 775 storage bootstrap/cache`

2. **Database Connection Error**
   - Test connection: `php artisan tinker` then `DB::connection()->getPdo()`
   - Check credentials in `.env`

3. **API Routes Not Working**
   - Clear route cache: `php artisan route:clear`
   - Check nginx configuration

### 📞 Support & Updates

#### Version Control
- Use semantic versioning
- Tag releases: `git tag v1.0.0`
- Maintain changelog

#### Contact Information
- Developer: [Your Name]
- Email: [your-email@domain.com]
- Documentation: [docs-url]

---

## 🎉 Ready for Production!

Your Alenwan streaming platform is now production-ready with:
- ✅ Professional Laravel backend
- ✅ Complete Flutter frontend
- ✅ Payment processing
- ✅ Content management
- ✅ Admin dashboard
- ✅ Security hardening
- ✅ Deployment automation

**Estimated deployment time: 2-4 hours**