# دليل Laravel Filament - نظام إدارة تطبيق Alenwan

## 📋 نظرة عامة

تم إنشاء نظام إدارة متكامل باستخدام Laravel Filament لإدارة محتوى تطبيق Alenwan. النظام يدعم:

✅ إدارة الأفلام والمسلسلات
✅ دعم لغتين (عربي/إنجليزي)
✅ تكامل مع Vimeo API
✅ إدارة الفئات والمحتوى
✅ نظام اشتراكات المستخدمين
✅ لوحة تحكم إدارية متقدمة

---

## 📁 هيكل المشروع

```
alenwan-backend/
└── temp-laravel/           # مشروع Laravel الرئيسي
    ├── app/
    │   ├── Models/         # نماذج قاعدة البيانات
    │   │   ├── User.php
    │   │   ├── Category.php
    │   │   ├── Movie.php
    │   │   ├── Series.php
    │   │   ├── Season.php
    │   │   └── Episode.php
    │   │
    │   ├── Services/
    │   │   └── VimeoService.php  # خدمة التكامل مع Vimeo
    │   │
    │   └── Console/Commands/
    │       └── CreateAdminUser.php
    │
    ├── database/
    │   └── migrations/     # ملفات الهجرة
    │
    └── config/
        └── services.php    # إعدادات الخدمات الخارجية
```

---

## 🗄️ قاعدة البيانات

### الجداول الرئيسية:

#### 1. **users** - المستخدمون
```
- id
- name
- email
- password
- is_admin (مدير)
- is_premium (مشترك مميز)
- subscription_ends_at (تاريخ انتهاء الاشتراك)
- phone
- avatar
- preferred_language (ar/en)
```

#### 2. **categories** - الفئات
```
- id
- name (JSON: {ar: "", en: ""})
- description (JSON)
- slug
- icon
- is_active
- order
```

#### 3. **movies** - الأفلام
```
- id
- title (JSON متعدد اللغات)
- description (JSON)
- slug
- category_id
- vimeo_id
- vimeo_url
- video_url
- thumbnail
- poster
- duration (بالدقائق)
- release_year
- rating (0.0-10.0)
- imdb_id
- genres (JSON array)
- cast (JSON array)
- director (JSON)
- is_premium (محتوى مدفوع)
- is_active
- is_featured (مميز)
- views_count
```

#### 4. **series** - المسلسلات
```
- id
- title (JSON)
- description (JSON)
- slug
- category_id
- thumbnail
- poster
- release_year
- rating
- imdb_id
- genres (JSON)
- cast (JSON)
- director (JSON)
- status (ongoing/completed/upcoming)
- is_premium
- is_active
- is_featured
- views_count
```

#### 5. **seasons** - المواسم
```
- id
- series_id
- title (JSON)
- description (JSON)
- season_number
- thumbnail
- release_year
- is_active
- order
```

#### 6. **episodes** - الحلقات
```
- id
- season_id
- title (JSON)
- description (JSON)
- episode_number
- vimeo_id
- vimeo_url
- video_url
- thumbnail
- duration
- release_date
- is_active
- views_count
- order
```

---

## 🔧 الإعداد والتشغيل

### 1. نقل المشروع

```bash
# انقل محتويات temp-laravel إلى مجلد alenwan-backend
cd alenwan-backend
# أو استخدم temp-laravel مباشرة
```

### 2. إعداد ملف .env

أنشئ ملف `.env` من `.env.example`:

```bash
cp .env.example .env
```

ثم أضف إعدادات Vimeo:

```env
# قاعدة البيانات (SQLite مثبت مسبقاً)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# Vimeo API
VIMEO_CLIENT_ID=your_vimeo_client_id
VIMEO_CLIENT_SECRET=your_vimeo_client_secret
VIMEO_ACCESS_TOKEN=your_vimeo_access_token

# إعدادات التطبيق
APP_NAME=Alenwan
APP_URL=http://localhost:8000
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en
```

### 3. تشغيل Migrations

```bash
php artisan migrate
```

### 4. إنشاء مستخدم إداري

```bash
php artisan admin:create
```

سيطلب منك:
- الاسم (افتراضي: Admin)
- البريد الإلكتروني (افتراضي: admin@alenwan.com)
- كلمة المرور (افتراضية: password)

### 5. تشغيل السيرفر

```bash
php artisan serve
```

الآن يمكنك الوصول إلى:
- **لوحة التحكم**: http://localhost:8000/admin
- **تسجيل الدخول**: باستخدام البريد الإلكتروني وكلمة المرور

---

## 🎬 استخدام Vimeo Service

### الحصول على بيانات الاعتماد من Vimeo:

1. اذهب إلى: https://developer.vimeo.com/
2. أنشئ تطبيق جديد
3. احصل على:
   - Client ID
   - Client Secret
   - Access Token

### أمثلة الاستخدام:

```php
use App\Services\VimeoService;

$vimeoService = new VimeoService();

// الحصول على تفاصيل فيديو
$video = $vimeoService->getVideo('123456789');

// استخراج ID من رابط
$videoId = $vimeoService->extractVideoId('https://vimeo.com/123456789');

// الحصول على رابط التضمين
$embedUrl = $vimeoService->getEmbedUrl('123456789');

// الحصول على الصورة المصغرة
$thumbnail = $vimeoService->getThumbnail('123456789');

// الحصول على مدة الفيديو
$duration = $vimeoService->getDuration('123456789');
```

---

## 🌐 نظام التعدد اللغوي

النظام يستخدم `spatie/laravel-translatable` لدعم اللغات المتعددة.

### كيفية استخدام الترجمة في الكود:

```php
// إنشاء فئة بلغتين
$category = Category::create([
    'name' => [
        'ar' => 'أكشن',
        'en' => 'Action'
    ],
    'description' => [
        'ar' => 'أفلام الإثارة والحركة',
        'en' => 'Action and thriller movies'
    ],
    'slug' => 'action',
]);

// الحصول على الترجمة حسب اللغة الحالية
echo $category->name; // سيعرض النص بلغة التطبيق الحالية

// الحصول على ترجمة محددة
echo $category->getTranslation('name', 'ar'); // أكشن
echo $category->getTranslation('name', 'en'); // Action
```

---

## 📝 إنشاء Filament Resources

لإنشاء واجهة إدارة لأي Model:

```bash
# مثال: إنشاء Resource للأفلام
php artisan make:filament-resource Movie --generate

# مثال: إنشاء Resource للفئات
php artisan make:filament-resource Category --generate
```

### مثال Resource للأفلام:

```php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Models\Movie;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title.ar')
                ->label('العنوان بالعربي')
                ->required(),

            Forms\Components\TextInput::make('title.en')
                ->label('العنوان بالإنجليزي')
                ->required(),

            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),

            Forms\Components\TextInput::make('vimeo_url')
                ->label('رابط Vimeo'),

            Forms\Components\FileUpload::make('thumbnail')
                ->image(),

            Forms\Components\Toggle::make('is_premium')
                ->label('محتوى مدفوع'),

            Forms\Components\Toggle::make('is_active')
                ->label('مفعّل')
                ->default(true),
        ]);
    }
}
```

---

## 🔐 الأمان والصلاحيات

### التحقق من صلاحيات المستخدم:

```php
// في Filament Resource
public static function canViewAny(): bool
{
    return auth()->user()->is_admin;
}

// في Controller
if (auth()->user()->is_admin) {
    // السماح بالوصول
}
```

---

## 📊 أمثلة على الاستعلامات

### الحصول على الأفلام المميزة:

```php
$featuredMovies = Movie::where('is_featured', true)
    ->where('is_active', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### الحصول على مسلسل مع جميع مواسمه وحلقاته:

```php
$series = Series::with(['seasons.episodes'])
    ->where('id', $seriesId)
    ->first();

// عرض الحلقات
foreach ($series->seasons as $season) {
    echo $season->title;
    foreach ($season->episodes as $episode) {
        echo $episode->title;
    }
}
```

### التحقق من إمكانية الوصول للمحتوى:

```php
$movie = Movie::find(1);
$user = auth()->user();

if ($movie->isAvailableForUser($user)) {
    // السماح بالمشاهدة
}
```

---

## 🚀 خطوات ما بعد الإعداد

1. **إنشاء Filament Resources**:
   ```bash
   php artisan make:filament-resource Category --generate
   php artisan make:filament-resource Movie --generate
   php artisan make:filament-resource Series --generate
   ```

2. **إضافة بيانات تجريبية**:
   - استخدم Seeders أو أضف البيانات من لوحة التحكم

3. **تخصيص لوحة التحكم**:
   - عدّل `app/Providers/Filament/AdminPanelProvider.php`
   - أضف ألوان مخصصة، شعار، إلخ.

4. **إنشاء API للتطبيق**:
   - أضف Controllers في `app/Http/Controllers/Api/`
   - أضف Routes في `routes/api.php`

---

## 📚 موارد إضافية

- **Filament Docs**: https://filamentphp.com/docs
- **Laravel Docs**: https://laravel.com/docs
- **Spatie Translatable**: https://github.com/spatie/laravel-translatable
- **Vimeo API**: https://developer.vimeo.com/api/reference

---

## ⚠️ ملاحظات مهمة

1. **الأمان**: تأكد من تغيير `APP_KEY` في `.env`
2. **النسخ الاحتياطي**: احتفظ بنسخة احتياطية من قاعدة البيانات
3. **بيانات Vimeo**: احفظ بيانات الاعتماد بشكل آمن
4. **الصلاحيات**: تأكد من أن مجلد `storage` قابل للكتابة

---

## 🐛 حل المشاكل الشائعة

### مشكلة: "Class not found"
```bash
composer dump-autoload
```

### مشكلة: "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
```

### مشكلة: عدم ظهور لوحة التحكم
```bash
php artisan filament:upgrade
php artisan cache:clear
php artisan config:clear
```

---

## 📞 الدعم

لأي استفسارات أو مشاكل:
1. راجع ملفات التوثيق
2. تحقق من Logs في `storage/logs/`
3. استخدم `php artisan tinker` للاختبار

---

**تم إنشاء النظام بواسطة:** Claude AI
**التاريخ:** 28 أكتوبر 2025
**الإصدار:** 1.0.0

