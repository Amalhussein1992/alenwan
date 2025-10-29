# 🔧 إصلاح خطأ Role Column

## ❌ الخطأ الحالي:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'role' in 'INSERT INTO'
```

**السبب**: جدول `users` لا يحتوي على عمود `role`

---

## ✅ الحل (خياران):

### الحل 1️⃣: رفع الملفات المحدثة وتشغيل Migration (الأفضل!)

#### الخطوة 1: ارفع الملفات المحدثة إلى السيرفر

**الملفات المطلوبة:**

1. **DatabaseSeeder.php المحدث**
   ```
   المسار المحلي: C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\database\seeders\DatabaseSeeder.php
   المسار على السيرفر: /public_html/database/seeders/DatabaseSeeder.php
   ```

2. **Migration جديد لإضافة عمود role**
   ```
   المسار المحلي: C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\database\migrations\2025_10_29_000001_add_role_to_users_table.php
   المسار على السيرفر: /public_html/database/migrations/2025_10_29_000001_add_role_to_users_table.php
   ```

#### الخطوة 2: نفّذ Migration عبر SSH/Terminal

```bash
cd /home/username/public_html

# تشغيل Migration لإضافة عمود role
php artisan migrate --force

# تشغيل Seeders
php artisan db:seed --force
```

---

### الحل 2️⃣: إضافة عمود role يدوياً عبر phpMyAdmin (الأسرع!)

#### افتح phpMyAdmin وشغّل هذا SQL:

```sql
-- إضافة عمود role إلى جدول users
ALTER TABLE `users`
ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `password`,
ADD INDEX `users_role_index` (`role`);
```

#### ثم شغّل Seeder مرة أخرى:

```bash
php artisan db:seed --force
```

---

## 🎯 التحقق من النجاح:

بعد تطبيق أي من الحلين:

### 1. تحقق من عمود role:
```sql
DESCRIBE users;
```
يجب أن تشاهد عمود `role`

### 2. شغّل Seeder:
```bash
php artisan db:seed --force
```

### 3. اختبر API:
```
https://www.alenwanapp.net/api/movies
https://www.alenwanapp.net/api/categories
```

---

## 📊 ما الذي تم تحديثه؟

### في DatabaseSeeder.php:
```php
// الآن يتحقق من وجود عمود role قبل استخدامه
private function addAdminUser()
{
    $hasRoleColumn = Schema::hasColumn('users', 'role');

    $userData = [
        'name' => 'Admin',
        'email' => 'admin@alenwan.com',
        'password' => Hash::make('Alenwan@Admin2025!'),
        'email_verified_at' => now(),
    ];

    // إضافة role فقط إذا كان العمود موجود
    if ($hasRoleColumn) {
        $userData['role'] = 'admin';
    }

    User::updateOrCreate(['email' => 'admin@alenwan.com'], $userData);
}
```

### Migration الجديد:
- يضيف عمود `role` إلى جدول `users`
- القيمة الافتراضية: `'user'`
- مفهرس (indexed) لتحسين الأداء

---

## 🚀 التنفيذ الكامل (نسخ ولصق):

### عبر phpMyAdmin (الطريقة الأسرع):

```sql
-- الخطوة 1: إضافة عمود role
ALTER TABLE `users`
ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `password`,
ADD INDEX `users_role_index` (`role`);

-- الخطوة 2: تحديث المستخدم الموجود إلى admin (إن وجد)
UPDATE `users`
SET `role` = 'admin'
WHERE `email` = 'admin@alenwan.com';
```

ثم عبر SSH/Terminal:
```bash
cd /home/username/public_html
php artisan db:seed --force
```

---

## ✅ النتيجة المتوقعة:

```
🚀 Starting database seeding...
  Database\Seeders\LanguageSeeder .......... DONE
  Database\Seeders\AppConfigSeeder ......... DONE
  Database\Seeders\PagesSeeder ............. DONE
📁 Adding categories...
👤 Creating admin user...
💳 Adding subscription plans...
🎬 Adding demo movies...
📺 Adding demo series...
✅ All seeders completed successfully!
🎉 Database is ready with full demo content!
```

**بعدها ستعمل جميع APIs بشكل صحيح!** 🎉

---

**آخر تحديث:** 2025-10-29
