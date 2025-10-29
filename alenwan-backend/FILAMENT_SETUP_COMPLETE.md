# ✅ Laravel Filament Backend - Setup Complete

## 📦 What Has Been Installed

### Core Packages:
- ✅ Laravel 11.x
- ✅ Filament 3.3.x (Admin Panel)
- ✅ Spatie Laravel Translatable 6.x
- ✅ Vimeo API 4.x

### Database Structure Created:
- ✅ Users table (with admin & premium fields)
- ✅ Categories table (multilingual)
- ✅ Movies table (with Vimeo integration)
- ✅ Series table
- ✅ Seasons table
- ✅ Episodes table (with Vimeo integration)

### Models Created:
- ✅ User (with admin/premium support)
- ✅ Category (with translations)
- ✅ Movie (with translations & soft deletes)
- ✅ Series (with translations & soft deletes)
- ✅ Season (with translations)
- ✅ Episode (with translations & soft deletes)

### Services:
- ✅ VimeoService (complete API integration)

### Commands:
- ✅ `php artisan admin:create` - Create admin users

---

## 🚀 Quick Start

### 1. Move to Laravel Directory
```bash
cd alenwan-backend/temp-laravel
```

### 2. Configure Environment
```bash
# Copy .env.example if not exists
cp .env.example .env

# Set up database (SQLite already configured)
# Add Vimeo credentials
```

### 3. Run Migrations (If Not Done)
```bash
php artisan migrate
```

### 4. Create Admin User
```bash
php artisan admin:create
```

Use these credentials:
- Email: admin@alenwan.com
- Password: password (or your choice)

### 5. Start Server
```bash
php artisan serve
```

### 6. Access Admin Panel
Open: http://localhost:8000/admin

---

## 🎨 Creating Filament Resources

### For Categories:
```bash
php artisan make:filament-resource Category --generate
```

### For Movies:
```bash
php artisan make:filament-resource Movie --generate --soft-deletes
```

### For Series:
```bash
php artisan make:filament-resource Series --generate --soft-deletes
```

---

## 📝 Example: Movie Resource

Create `app/Filament/Resources/MovieResource.php`:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Models\Movie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationLabel = 'الأفلام';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات أساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title.ar')
                            ->label('العنوان (عربي)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description.ar')
                            ->label('الوصف (عربي)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (English)')
                            ->rows(3),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('category_id')
                            ->label('الفئة')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('فيديو Vimeo')
                    ->schema([
                        Forms\Components\TextInput::make('vimeo_url')
                            ->label('رابط Vimeo')
                            ->url()
                            ->suffixIcon('heroicon-m-globe-alt'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('رابط الفيديو المباشر')
                            ->required()
                            ->url(),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('صورة مصغرة')
                            ->image()
                            ->directory('movies/thumbnails'),

                        Forms\Components\FileUpload::make('poster')
                            ->label('ملصق')
                            ->image()
                            ->directory('movies/posters'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('تفاصيل الفيلم')
                    ->schema([
                        Forms\Components\TextInput::make('duration')
                            ->label('المدة (بالدقائق)')
                            ->numeric()
                            ->suffix('دقيقة'),

                        Forms\Components\TextInput::make('release_year')
                            ->label('سنة الإصدار')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 5),

                        Forms\Components\TextInput::make('rating')
                            ->label('التقييم')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.1)
                            ->suffix('/ 10'),

                        Forms\Components\TextInput::make('imdb_id')
                            ->label('IMDB ID')
                            ->placeholder('tt1234567'),

                        Forms\Components\TagsInput::make('genres')
                            ->label('الأنواع')
                            ->placeholder('أضف نوع'),

                        Forms\Components\TagsInput::make('cast')
                            ->label('الممثلون')
                            ->placeholder('أضف ممثل'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_premium')
                            ->label('محتوى مدفوع')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('مفعّل')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('مميز')
                            ->default(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('صورة')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->badge()
                    ->color(fn ($state) => $state >= 7 ? 'success' : ($state >= 5 ? 'warning' : 'danger'))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_premium')
                    ->label('مدفوع')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعّل')
                    ->boolean(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('الفئة'),

                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label('محتوى مدفوع'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('مميز'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
```

---

## 🔧 Vimeo Integration Example

### In Your Movie Creation:

```php
use App\Services\VimeoService;

public function createMovieFromVimeo($vimeoUrl)
{
    $vimeoService = new VimeoService();

    // Extract video ID
    $videoId = $vimeoService->extractVideoId($vimeoUrl);

    // Get video details
    $videoDetails = $vimeoService->getVideo($videoId);

    // Create movie
    $movie = Movie::create([
        'title' => [
            'ar' => 'عنوان الفيلم',
            'en' => $videoDetails['name'] ?? 'Movie Title'
        ],
        'vimeo_id' => $videoId,
        'vimeo_url' => $vimeoUrl,
        'video_url' => $vimeoService->getEmbedUrl($videoId),
        'thumbnail' => $vimeoService->getThumbnail($videoId),
        'duration' => ceil($vimeoService->getDuration($videoId) / 60), // Convert to minutes
        'category_id' => 1,
        // ... other fields
    ]);

    return $movie;
}
```

---

## 📱 API Endpoints (To Be Created)

Recommended structure for mobile app:

```
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout

GET    /api/categories
GET    /api/movies
GET    /api/movies/{id}
GET    /api/series
GET    /api/series/{id}
GET    /api/series/{id}/seasons/{seasonId}/episodes

GET    /api/featured
GET    /api/trending

POST   /api/movies/{id}/view
POST   /api/subscription/create
```

---

## 🎯 Next Steps

1. **Create Filament Resources** for all models
2. **Add Sample Data** (Categories, Movies, Series)
3. **Customize Admin Panel** colors and branding
4. **Create API Controllers** for mobile app
5. **Setup Authentication** (Laravel Sanctum)
6. **Configure File Storage** (for thumbnails/posters)
7. **Setup Cache** for better performance

---

## 🔐 Admin Panel Access

After running `php artisan admin:create`:

**URL:** http://localhost:8000/admin
**Email:** admin@alenwan.com (or your choice)
**Password:** password (or your choice)

---

## 📚 Useful Commands

```bash
# Create Filament Resource
php artisan make:filament-resource ModelName --generate

# Create Filament Widget
php artisan make:filament-widget StatsOverview

# Create Filament Page
php artisan make:filament-page Settings

# Clear Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimize
php artisan optimize
```

---

## 🌍 Environment Variables Required

Add to `.env`:

```env
# App
APP_NAME=Alenwan
APP_URL=http://localhost:8000

# Database (SQLite already setup)
DB_CONNECTION=sqlite

# Vimeo (Get from https://developer.vimeo.com)
VIMEO_CLIENT_ID=your_client_id
VIMEO_CLIENT_SECRET=your_client_secret
VIMEO_ACCESS_TOKEN=your_access_token

# Localization
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en
```

---

## ✅ Setup Checklist

- [x] Laravel Installed
- [x] Filament Installed & Configured
- [x] Database Tables Created
- [x] Models with Relationships Created
- [x] Multilingual Support Added
- [x] Vimeo Service Created
- [x] Admin Command Created
- [ ] Create Admin User
- [ ] Create Filament Resources
- [ ] Add Sample Data
- [ ] Customize Admin Panel
- [ ] Create API Endpoints
- [ ] Connect with Flutter App

---

**Project Location:** `C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel`
**Admin Panel:** http://localhost:8000/admin
**Documentation:** See LARAVEL_FILAMENT_GUIDE_AR.md

---

🎉 **Backend is ready to use!** Start by creating an admin user and then create Filament Resources.

