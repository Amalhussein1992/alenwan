# دليل إعداد قاعدة بيانات MySQL
# MySQL Database Setup Guide

## الخطوة 1: إنشاء قاعدة البيانات
## Step 1: Create the Database

### الطريقة الأولى: من خلال phpMyAdmin
1. افتح phpMyAdmin من متصفحك: `http://localhost/phpmyadmin`
2. انقر على "New" أو "جديد" في القائمة اليسرى
3. أدخل اسم قاعدة البيانات: `alenwan`
4. اختر Collation: `utf8mb4_unicode_ci` (مهم للدعم العربي)
5. انقر على "Create" أو "إنشاء"

### الطريقة الثانية: من خلال سطر الأوامر MySQL
```sql
CREATE DATABASE alenwan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### الطريقة الثالثة: من خلال أمر artisan
```bash
# سيتم استخدام هذا الأمر بعد تحديث ملف .env
php artisan db:create alenwan
```

---

## الخطوة 2: تحديث ملف .env
## Step 2: Update .env File

قم بتحديث الإعدادات التالية في ملف `.env`:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alenwan
DB_USERNAME=root
DB_PASSWORD=

# إذا كنت تستخدم XAMPP على Windows:
# If you're using XAMPP on Windows:
DB_HOST=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=

# إذا كنت تستخدم MAMP على Mac:
# If you're using MAMP on Mac:
DB_HOST=localhost
DB_PORT=8889
DB_USERNAME=root
DB_PASSWORD=root

# إذا كنت تستخدم سيرفر حقيقي:
# If you're using a real server:
DB_HOST=your_server_ip
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

---

## الخطوة 3: تشغيل الـ Migrations
## Step 3: Run Migrations

```bash
# انتقل إلى مجلد المشروع
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel

# امسح الكاش
php artisan config:clear
php artisan cache:clear

# تشغيل الـ migrations
php artisan migrate

# إذا واجهت مشاكل، استخدم Fresh (يحذف كل البيانات)
php artisan migrate:fresh
```

---

## الخطوة 4: إضافة البيانات الأولية
## Step 4: Seed Initial Data

سنقوم بإنشاء Seeder لإضافة اللغات وإعدادات التطبيق الافتراضية.

---

## الخطوة 5: إنشاء حساب Admin
## Step 5: Create Admin Account

```bash
php artisan app:create-admin-user
```

معلومات تسجيل الدخول:
- البريد الإلكتروني: admin@alenwan.com
- كلمة المرور: Admin@2025

---

## تحقق من نجاح الإعداد
## Verify Setup Success

### 1. تحقق من الجداول المُنشأة:
```bash
php artisan db:show
php artisan db:table users
```

### 2. قائمة الجداول المتوقعة (15 جدول):
- users
- password_reset_tokens
- sessions
- categories
- movies
- series
- seasons
- episodes
- settings
- sliders
- app_notifications
- subscription_plans
- languages
- app_configs
- personal_access_tokens

### 3. تشغيل لوحة التحكم:
```bash
php artisan serve
```

ثم افتح المتصفح: `http://localhost:8000/admin`

---

## نقل البيانات من SQLite إلى MySQL (إذا كانت لديك بيانات)
## Migrate Data from SQLite to MySQL (if you have existing data)

```bash
# تصدير البيانات من SQLite
php artisan db:seed --class=ExportDataSeeder

# استيراد البيانات إلى MySQL
php artisan migrate:fresh --seed
```

---

## إعدادات MySQL الموصى بها
## Recommended MySQL Settings

في ملف `my.cnf` أو `my.ini`:

```ini
[mysqld]
# دعم كامل للـ UTF-8
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# زيادة حجم الحزمة للفيديوهات
max_allowed_packet=256M

# تحسين الأداء
innodb_buffer_pool_size=256M
innodb_log_file_size=64M
```

---

## استكشاف الأخطاء
## Troubleshooting

### خطأ: Access denied for user
```bash
# تأكد من اسم المستخدم وكلمة المرور في .env
# تأكد من أن MySQL يعمل
# في Windows XAMPP:
net start mysql
```

### خطأ: SQLSTATE[HY000] [1049] Unknown database
```bash
# قم بإنشاء قاعدة البيانات أولاً من phpMyAdmin
# أو استخدم الأمر SQL المذكور أعلاه
```

### خطأ: Syntax error or access violation
```bash
# امسح الكاش وأعد المحاولة
php artisan config:clear
php artisan migrate:fresh
```

### خطأ: Connection refused
```bash
# تأكد من أن MySQL يعمل
# تحقق من المنفذ (Port) في .env
# جرّب 127.0.0.1 بدلاً من localhost
```

---

## الأوامر المفيدة
## Useful Commands

```bash
# عرض حالة قاعدة البيانات
php artisan db:show

# عرض جدول معين
php artisan db:table users

# إعادة تعيين قاعدة البيانات
php artisan migrate:fresh

# إعادة تعيين مع البيانات الأولية
php artisan migrate:fresh --seed

# عمل نسخة احتياطية (يتطلب تثبيت package)
php artisan backup:run

# استعادة نسخة احتياطية
mysql -u root -p alenwan < backup.sql
```

---

## الخطوات التالية
## Next Steps

1. ✅ إنشاء قاعدة البيانات MySQL
2. ✅ تحديث ملف .env
3. ✅ تشغيل Migrations
4. ✅ إضافة البيانات الأولية
5. ✅ إنشاء حساب Admin
6. ⏳ رفع المشروع على السيرفر
7. ⏳ ربط التطبيق Flutter بـ API

---

## ملاحظات مهمة
## Important Notes

1. **النسخ الاحتياطي**: قم دائماً بعمل نسخة احتياطية قبل تشغيل `migrate:fresh`
2. **الأمان**: غيّر كلمات المرور الافتراضية على السيرفر الحقيقي
3. **UTF-8**: تأكد من استخدام `utf8mb4` لدعم اللغة العربية والإيموجي
4. **الأداء**: استخدم Indexes على الأعمدة المستخدمة في البحث
5. **الصيانة**: راجع Logs بانتظام

---

## الدعم الفني
## Technical Support

إذا واجهت أي مشاكل:
1. تحقق من ملف `storage/logs/laravel.log`
2. تأكد من إصدارات PHP وMySQL متوافقة
3. تحقق من صلاحيات المجلدات

متطلبات النظام:
- PHP >= 8.2
- MySQL >= 5.7 أو MariaDB >= 10.3
- Composer
- Extensions: PDO, mbstring, OpenSSL, JSON
