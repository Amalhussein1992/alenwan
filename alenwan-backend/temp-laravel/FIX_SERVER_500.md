# 🔧 حل مشكلة 500 Server Error

## ✅ تم حل المشكلة محلياً!

السيرفر المحلي يعمل الآن بنجاح على: `http://localhost:8000`

---

## 🚀 لحل المشكلة على السيرفر المباشر (alenwanapp.net)

### المشكلة الأساسية:
الـ Seeder كان يحاول استخدام حقل `role` لكن جدول Users يستخدم `is_admin`

### ✅ الحل (خياران):

---

## **الخيار 1: تحديث الـ Seeder (الأسرع)** ⭐

### 1. افتح ملف `DatabaseSeeder.php`:
المسار: `database/seeders/DatabaseSeeder.php`

### 2. ابحث عن هذا الكود (السطر 77-89):
```php
private function addAdminUser()
{
    User::updateOrCreate(
        ['email' => 'admin@alenwan.com'],
        [
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'role' => 'admin',  // ← المشكلة هنا
            'email_verified_at' => now(),
        ]
    );
}
```

### 3. غيّره إلى:
```php
private function addAdminUser()
{
    User::updateOrCreate(
        ['email' => 'admin@alenwan.com'],
        [
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'is_admin' => true,  // ← الحل
            'email_verified_at' => now(),
        ]
    );
}
```

### 4. ارفع الملف المعدّل على السيرفر

### 5. شغّل الـ Seeder مرة أخرى:
```bash
php artisan db:seed --force
```

---

## **الخيار 2: استخدام SQL مباشر (الأبسط)**

### 1. افتح PHPMyAdmin على السيرفر

### 2. اختر قاعدة بيانات `alenwan`

### 3. انسخ والصق هذا الكود في SQL tab:

```sql
-- إنشاء مستخدم Admin
INSERT INTO users (name, email, email_verified_at, password, is_admin, created_at, updated_at)
VALUES (
    'Admin',
    'admin@alenwan.com',
    NOW(),
    '$2y$12$Gc.oWMRnyHv80P57l0AVGe4xQoPbwY9dbCLVKWHHSRGMGUdZxFBZC',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    is_admin = 1,
    updated_at = NOW();

-- التحقق من إنشاء المستخدم
SELECT id, name, email, is_admin, created_at FROM users WHERE email = 'admin@alenwan.com';
```

### 4. اضغط "Go"

✅ الآن يمكنك تسجيل الدخول:
```
https://www.alenwanapp.net/admin/login
Email: admin@alenwan.com
Password: Alenwan@Admin2025!
```

---

## 🧪 اختبار السيرفر:

### 1. الصفحة الرئيسية:
```
https://www.alenwanapp.net/
```

### 2. API Categories:
```
https://www.alenwanapp.net/api/categories
```

### 3. Admin Panel:
```
https://www.alenwanapp.net/admin/login
```

---

## 📝 ملاحظات مهمة:

### الفرق بين المحلي والمباشر:

**المحلي (Local):**
- Database: SQLite (ملف)
- Session: File
- Cache: File
- Debug: ON

**المباشر (Production):**
- Database: MySQL
- Session: Database
- Cache: Database
- Debug: OFF

---

## 🔍 إذا استمر الخطأ 500:

### 1. تحقق من Logs:
```bash
tail -f storage/logs/laravel.log
```

### 2. تحقق من الصلاحيات:
```bash
chmod -R 755 storage bootstrap/cache
```

### 3. نظّف الـ Cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 4. تحقق من الـ .env:
- `DB_DATABASE` صحيح
- `DB_USERNAME` صحيح
- `DB_PASSWORD` صحيح
- قاعدة البيانات موجودة وفيها جداول

---

## ✅ الملفات المحدّثة محلياً:

1. ✅ `.env` - مضبوط على SQLite
2. ✅ `database/database.sqlite` - قاعدة بيانات جاهزة
3. ✅ Migrations - تم تشغيلها
4. ✅ Seeders - تم تشغيلها
5. ✅ Admin User - تم إنشاءه
6. ✅ Demo Content - 10 أفلام + 5 مسلسلات

---

## 🎉 السيرفر المحلي جاهز!

```bash
# لتشغيل السيرفر محلياً:
cd alenwan-backend/temp-laravel
php artisan serve

# ثم افتح:
http://localhost:8000
http://localhost:8000/admin/login
```

**البيانات:**
- Email: `admin@alenwan.com`
- Password: `Alenwan@Admin2025!`

---

**آخر تحديث:** 2025-10-29 04:15 AM
