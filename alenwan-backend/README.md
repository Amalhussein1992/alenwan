# 🎬 Alenwan Backend - Laravel Filament Admin Panel

Backend system for Alenwan streaming application built with Laravel 11 and Filament 3.

## ✨ Features

- 🎥 **Content Management**: Manage movies, series, seasons, and episodes
- 🌍 **Multilingual**: Arabic & English support using Spatie Translatable
- 📹 **Vimeo Integration**: Seamless video integration with Vimeo API
- 👥 **User Management**: Admin panel with role-based access
- 💳 **Subscription System**: Premium content management
- 📊 **Modern Admin UI**: Beautiful admin interface with Filament
- 🔒 **Secure**: Built-in authentication and authorization

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- SQLite (included) or MySQL/PostgreSQL
- Node.js & NPM (optional, for asset compilation)

## 🚀 Installation

### 1. Navigate to Project
```bash
cd alenwan-backend/temp-laravel
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
```

Edit `.env` and add your Vimeo credentials:
```env
VIMEO_CLIENT_ID=your_client_id
VIMEO_CLIENT_SECRET=your_client_secret
VIMEO_ACCESS_TOKEN=your_access_token
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Create Admin User
```bash
php artisan admin:create
```

### 7. Start Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000/admin

## 📁 Project Structure

```
alenwan-backend/
├── temp-laravel/              # Main Laravel project
│   ├── app/
│   │   ├── Models/           # Database models
│   │   │   ├── User.php
│   │   │   ├── Category.php
│   │   │   ├── Movie.php
│   │   │   ├── Series.php
│   │   │   ├── Season.php
│   │   │   └── Episode.php
│   │   │
│   │   ├── Services/         # Business logic
│   │   │   └── VimeoService.php
│   │   │
│   │   └── Console/Commands/
│   │       └── CreateAdminUser.php
│   │
│   ├── database/
│   │   └── migrations/       # Database migrations
│   │
│   ├── routes/
│   │   ├── web.php
│   │   └── api.php          # API routes for mobile app
│   │
│   └── config/
│       └── services.php     # External services config
│
├── LARAVEL_FILAMENT_GUIDE_AR.md    # Arabic documentation
└── FILAMENT_SETUP_COMPLETE.md      # Technical documentation
```

## 📚 Database Schema

### Tables

| Table | Description |
|-------|-------------|
| `users` | User accounts with admin & premium fields |
| `categories` | Content categories (multilingual) |
| `movies` | Movie content with Vimeo integration |
| `series` | TV series information |
| `seasons` | Series seasons |
| `episodes` | Series episodes with Vimeo links |

See detailed schema in [LARAVEL_FILAMENT_GUIDE_AR.md](LARAVEL_FILAMENT_GUIDE_AR.md)

## 🎯 Creating Filament Resources

Generate admin interfaces for your models:

```bash
# Categories
php artisan make:filament-resource Category --generate

# Movies
php artisan make:filament-resource Movie --generate --soft-deletes

# Series
php artisan make:filament-resource Series --generate --soft-deletes

# Seasons
php artisan make:filament-resource Season --generate

# Episodes
php artisan make:filament-resource Episode --generate --soft-deletes
```

## 🔧 Vimeo Setup

1. Create app at: https://developer.vimeo.com/
2. Get your credentials:
   - Client ID
   - Client Secret
   - Access Token
3. Add to `.env` file

### Using Vimeo Service

```php
use App\Services\VimeoService;

$vimeo = new VimeoService();

// Get video details
$video = $vimeo->getVideo('VIDEO_ID');

// Extract ID from URL
$id = $vimeo->extractVideoId('https://vimeo.com/123456789');

// Get embed URL
$embedUrl = $vimeo->getEmbedUrl('VIDEO_ID');

// Get thumbnail
$thumbnail = $vimeo->getThumbnail('VIDEO_ID');
```

## 🌐 Multilingual Content

The system uses JSON fields for multilingual content:

```php
// Create category in both languages
$category = Category::create([
    'name' => [
        'ar' => 'أكشن',
        'en' => 'Action'
    ],
    'description' => [
        'ar' => 'أفلام الإثارة',
        'en' => 'Action movies'
    ],
    'slug' => 'action',
]);

// Get translated name
echo $category->name; // Uses app locale
echo $category->getTranslation('name', 'ar'); // أكشن
echo $category->getTranslation('name', 'en'); // Action
```

## 🔐 Admin Access

**URL:** http://localhost:8000/admin

**Default Credentials:**
- Email: admin@alenwan.com
- Password: password

*Change these after first login!*

## 📱 API for Mobile App

Create API endpoints in `routes/api.php`:

```php
// Authentication
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout

// Content
GET    /api/categories
GET    /api/movies
GET    /api/movies/{id}
GET    /api/series
GET    /api/series/{id}

// User
GET    /api/user/watchlist
POST   /api/movies/{id}/view
```

Use Laravel Sanctum for API authentication.

## 🛠️ Useful Commands

```bash
# Create new admin user
php artisan admin:create

# Create Filament resource
php artisan make:filament-resource ModelName

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Generate app key
php artisan key:generate
```

## 📖 Documentation

- **Arabic Guide**: [LARAVEL_FILAMENT_GUIDE_AR.md](LARAVEL_FILAMENT_GUIDE_AR.md) - Complete Arabic documentation
- **Technical Guide**: [FILAMENT_SETUP_COMPLETE.md](FILAMENT_SETUP_COMPLETE.md) - Technical setup details
- **Laravel Docs**: https://laravel.com/docs
- **Filament Docs**: https://filamentphp.com/docs

## 🔍 Troubleshooting

### Permission Denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Class Not Found
```bash
composer dump-autoload
```

### Admin Panel Not Loading
```bash
php artisan filament:upgrade
php artisan optimize:clear
```

### Database Locked (SQLite)
Check that no other process is using the database file.

## 🚦 Next Steps

1. ✅ System is installed
2. ⬜ Create admin user
3. ⬜ Generate Filament resources
4. ⬜ Add sample data
5. ⬜ Customize admin panel
6. ⬜ Create API endpoints
7. ⬜ Connect with Flutter app

## 📊 System Status

| Component | Status |
|-----------|--------|
| Laravel Installation | ✅ Complete |
| Filament Setup | ✅ Complete |
| Database Schema | ✅ Complete |
| Models & Relationships | ✅ Complete |
| Multilingual Support | ✅ Complete |
| Vimeo Integration | ✅ Complete |
| Admin Command | ✅ Complete |
| Filament Resources | ⬜ Pending |
| API Endpoints | ⬜ Pending |
| Sample Data | ⬜ Pending |

## 🤝 Support

For issues or questions:
1. Check documentation files
2. Review Laravel & Filament official docs
3. Check logs in `storage/logs/`

## 📝 License

This project is private and confidential.

---

**Built with:**
- Laravel 11
- Filament 3
- Spatie Laravel Translatable
- Vimeo API

**Created:** October 28, 2025
**Version:** 1.0.0

