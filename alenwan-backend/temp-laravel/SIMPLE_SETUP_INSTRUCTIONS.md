# 🚀 إعداد قاعدة البيانات - الطريقة البسيطة

## المشكلة الحالية:
السكريبت `setup_database_production.php` يعمل لكن قاعدة البيانات لا تزال فارغة.

---

## ✅ الحل السريع - طريقتان:

---

## الطريقة 1️⃣: عبر Terminal/SSH (الأسرع!)

### إذا كان لديك وصول SSH أو cPanel Terminal:

```bash
# 1. اذهب إلى مجلد المشروع
cd /home/username/public_html
# أو
cd /var/www/html

# 2. شغّل الأوامر التالية بالترتيب:

# تشغيل Migrations
php artisan migrate --force

# إضافة Categories
php artisan tinker
```

ثم في Tinker اكتب:

```php
$categories = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Documentary', 'Sports'];
foreach ($categories as $cat) {
    DB::table('categories')->insert([
        'name' => json_encode(['en' => $cat, 'ar' => $cat]),
        'slug' => strtolower($cat),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

$languages = [
    ['code' => 'ar', 'name' => json_encode(['en' => 'Arabic', 'ar' => 'العربية'])],
    ['code' => 'en', 'name' => json_encode(['en' => 'English', 'ar' => 'الإنجليزية'])],
];
foreach ($languages as $lang) {
    DB::table('languages')->insert(array_merge($lang, ['created_at' => now(), 'updated_at' => now()]));
}

// إنشاء Admin
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@alenwan.com',
    'password' => Hash::make('Alenwan@Admin2025!'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);

// إضافة فيلم تجريبي
DB::table('movies')->insert([
    'title' => json_encode(['en' => 'Test Movie', 'ar' => 'فيلم تجريبي']),
    'slug' => 'test-movie-1',
    'description' => json_encode(['en' => 'Test', 'ar' => 'تجريبي']),
    'category_id' => 1,
    'language_id' => 1,
    'duration' => 120,
    'release_year' => 2024,
    'rating' => 4.5,
    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'thumbnail' => 'https://via.placeholder.com/300x450',
    'poster' => 'https://via.placeholder.com/1920x1080',
    'is_featured' => true,
    'is_published' => true,
    'created_at' => now(),
    'updated_at' => now(),
]);

// إضافة صفحة
DB::table('pages')->insert([
    'slug' => 'support',
    'title' => json_encode(['en' => 'Support', 'ar' => 'الدعم']),
    'content' => json_encode(['en' => '<h1>Support</h1>', 'ar' => '<h1>الدعم</h1>']),
    'is_published' => true,
    'created_at' => now(),
    'updated_at' => now(),
]);

exit
```

ثم:

```bash
# مسح Cache
php artisan cache:clear
php artisan config:clear
php artisan optimize
```

---

## الطريقة 2️⃣: عبر سكريبت PHP بسيط

### 1. ارفع الملف:
```
setup_quick.php
```

### 2. شغّله عبر SSH:
```bash
cd /home/username/public_html
php setup_quick.php
```

### أو عبر المتصفح (أقل أماناً):
```
قم بتعديل setup_quick.php:
أضف في أول الملف:
<?php
header('Content-Type: text/plain; charset=utf-8');
// باقي الكود...
```

ثم افتح:
```
https://www.alenwanapp.net/setup_quick.php
```

---

## الطريقة 3️⃣: يدوياً عبر phpMyAdmin

إذا لم تنجح الطرق السابقة:

### 1. افتح phpMyAdmin من cPanel

### 2. اختر قاعدة البيانات

### 3. نفّذ SQL التالي:

```sql
-- إضافة Categories
INSERT INTO categories (name, slug, created_at, updated_at) VALUES
('{"en":"Action","ar":"أكشن"}', 'action', NOW(), NOW()),
('{"en":"Drama","ar":"دراما"}', 'drama', NOW(), NOW()),
('{"en":"Comedy","ar":"كوميديا"}', 'comedy', NOW(), NOW()),
('{"en":"Horror","ar":"رعب"}', 'horror', NOW(), NOW()),
('{"en":"Romance","ar":"رومانسي"}', 'romance', NOW(), NOW());

-- إضافة Languages
INSERT INTO languages (code, name, created_at, updated_at) VALUES
('ar', '{"en":"Arabic","ar":"العربية"}', NOW(), NOW()),
('en', '{"en":"English","ar":"الإنجليزية"}', NOW(), NOW()),
('fr', '{"en":"French","ar":"الفرنسية"}', NOW(), NOW());

-- إضافة Admin User
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES
('Admin', 'admin@alenwan.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW(), NOW());
-- ملاحظة: كلمة المرور هنا هي "password" - غيّرها من لوحة التحكم

-- إضافة فيلم تجريبي
INSERT INTO movies (title, slug, description, category_id, language_id, duration, release_year, rating, video_url, thumbnail, poster, is_featured, is_published, created_at, updated_at) VALUES
('{"en":"Test Movie","ar":"فيلم تجريبي"}', 'test-movie', '{"en":"Test description","ar":"وصف تجريبي"}', 1, 1, 120, 2024, 4.5, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450', 'https://via.placeholder.com/1920x1080', 1, 1, NOW(), NOW());

-- إضافة صفحة
INSERT INTO pages (slug, title, content, is_published, created_at, updated_at) VALUES
('support', '{"en":"Support","ar":"الدعم"}', '{"en":"<h1>Support</h1>","ar":"<h1>الدعم</h1>"}', 1, NOW(), NOW());
```

---

## ✅ التحقق من النجاح:

بعد تطبيق أي من الطرق أعلاه، اختبر:

### 1. اختبر API:
```
https://www.alenwanapp.net/api/categories
```
يجب أن يعيد قائمة التصنيفات

### 2. اختبر Movies:
```
https://www.alenwanapp.net/api/movies
```
يجب أن يعيد على الأقل فيلم واحد

### 3. اختبر Pages:
```
https://www.alenwanapp.net/page/support
```
يجب أن تعمل بدون خطأ 404

### 4. اختبر Admin:
```
https://www.alenwanapp.net/admin
Email: admin@alenwan.com
Password: Alenwan@Admin2025!
```

---

## 🔍 التشخيص:

### إذا لم تظهر البيانات، تحقق من:

#### 1. هل Migrations تمت؟
```bash
php artisan migrate:status
```

#### 2. هل الجداول موجودة؟
عبر phpMyAdmin:
- categories ✅
- languages ✅
- movies ✅
- users ✅
- pages ✅

#### 3. هل يوجد بيانات؟
```bash
php artisan tinker
DB::table('categories')->count();
DB::table('movies')->count();
exit
```

---

## 📞 الدعم السريع:

### الطريقة الأسرع والأضمن:

```bash
# نسخ ولصق هذه الأوامر في Terminal:

cd /home/username/public_html

php artisan migrate --force

php artisan tinker <<EOF
DB::table('categories')->insert(['name' => '{"en":"Action","ar":"أكشن"}', 'slug' => 'action', 'created_at' => now(), 'updated_at' => now()]);
DB::table('languages')->insert(['code' => 'ar', 'name' => '{"en":"Arabic","ar":"العربية"}', 'created_at' => now(), 'updated_at' => now()]);
\App\Models\User::create(['name' => 'Admin', 'email' => 'admin@alenwan.com', 'password' => Hash::make('Alenwan@Admin2025!'), 'role' => 'admin', 'email_verified_at' => now()]);
DB::table('movies')->insert(['title' => '{"en":"Movie 1","ar":"فيلم 1"}', 'slug' => 'movie-1', 'description' => '{"en":"Test","ar":"تجريبي"}', 'category_id' => 1, 'language_id' => 1, 'duration' => 120, 'release_year' => 2024, 'rating' => 4.5, 'video_url' => 'https://test.com', 'thumbnail' => 'https://via.placeholder.com/300', 'poster' => 'https://via.placeholder.com/1920', 'is_featured' => true, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()]);
EOF

php artisan cache:clear
php artisan config:cache
```

---

**🎯 الطريقة 1 (Terminal/SSH) هي الأسرع والأفضل!**

**📧 إذا واجهت مشاكل، شارك لقطة شاشة من الأخطاء.**

---

**آخر تحديث:** 2025-10-29
