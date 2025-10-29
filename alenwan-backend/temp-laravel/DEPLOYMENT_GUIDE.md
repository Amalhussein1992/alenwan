# 🚀 دليل رفع Alenwan Backend على السيرفر

**الإصدار:** 1.0
**التاريخ:** 2025-10-29

---

## 📋 جدول المحتويات

1. [متطلبات السيرفر](#متطلبات-السيرفر)
2. [طرق النشر المتاحة](#طرق-النشر-المتاحة)
3. [النشر على Shared Hosting](#النشر-على-shared-hosting)
4. [النشر على VPS](#النشر-على-vps)
5. [النشر باستخدام cPanel](#النشر-باستخدام-cpanel)
6. [الإعدادات بعد النشر](#الإعدادات-بعد-النشر)
7. [حل المشاكل الشائعة](#حل-المشاكل-الشائعة)

---

## 🖥️ متطلبات السيرفر

### الحد الأدنى:
```
✅ PHP 8.1 أو أحدث
✅ MySQL 5.7 أو MariaDB 10.3 أو أحدث
✅ Composer
✅ 2GB RAM
✅ 10GB Storage
✅ SSL Certificate (مطلوب للإنتاج)
```

### PHP Extensions المطلوبة:
```
✅ BCMath
✅ Ctype
✅ Fileinfo
✅ JSON
✅ Mbstring
✅ OpenSSL
✅ PDO
✅ PDO_MySQL
✅ Tokenizer
✅ XML
✅ GD أو Imagick
✅ CURL
✅ ZIP
```

### الموصى به:
```
⭐ PHP 8.2+
⭐ MySQL 8.0+
⭐ 4GB+ RAM
⭐ SSD Storage
⭐ Redis/Memcached (للتخزين المؤقت)
⭐ Nginx أو Apache
```

---

## 🎯 طرق النشر المتاحة

### 1️⃣ cPanel (الأسهل - موصى به للمبتدئين)
- ✅ سهل الاستخدام
- ✅ واجهة رسومية
- ✅ مناسب لـ Shared Hosting
- ⏱️ 20-30 دقيقة

### 2️⃣ VPS/Cloud Server (الأفضل للأداء)
- ✅ تحكم كامل
- ✅ أداء أفضل
- ✅ مرونة عالية
- ⏱️ 40-60 دقيقة

### 3️⃣ Shared Hosting (الأرخص)
- ✅ تكلفة منخفضة
- ⚠️ موارد محدودة
- ⏱️ 30-40 دقيقة

---

## 📦 الطريقة 1: النشر على cPanel (الأسهل)

### الخطوة 1: تجهيز الملفات

#### 1.1 إنشاء ملف .env للإنتاج:

```bash
# في جهازك المحلي
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel
cp .env .env.production
```

#### 1.2 تحديث .env.production:

```env
APP_NAME=Alenwan
APP_ENV=production
APP_KEY=base64:I6wA0nI3WijjRG4d/z8iDWCtRBlNXXVR7LzOVgBYq/M=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_strong_password

# سيتم تحديث هذه لاحقاً من cPanel
```

#### 1.3 ضغط المشروع:

```bash
# في PowerShell
cd C:\Users\HP\Desktop\flutter\alenwan-backend
Compress-Archive -Path temp-laravel\* -DestinationPath alenwan-backend.zip
```

**أو استخدم WinRAR/7zip:**
- انقر بزر الماوس الأيمن على مجلد `temp-laravel`
- اختر "Add to archive"
- احفظ باسم `alenwan-backend.zip`

### الخطوة 2: رفع على cPanel

#### 2.1 تسجيل الدخول:
```
🌐 https://yourdomain.com:2083
أو
🌐 https://yourdomain.com/cpanel
```

#### 2.2 إنشاء قاعدة بيانات:

1. **اذهب إلى:** MySQL Databases
2. **أنشئ قاعدة بيانات:**
   - Database Name: `alenwan_db`
   - انقر "Create Database"

3. **أنشئ مستخدم:**
   - Username: `alenwan_user`
   - Password: (كلمة مرور قوية)
   - انقر "Create User"

4. **اربط المستخدم بالقاعدة:**
   - اختر المستخدم والقاعدة
   - أعطه ALL PRIVILEGES
   - انقر "Make Changes"

📝 **احفظ هذه المعلومات:**
```
Database: username_alenwan_db
User: username_alenwan_user
Password: xxxxxxxxxx
Host: localhost
```

#### 2.3 رفع الملفات:

1. **اذهب إلى:** File Manager
2. **انتقل إلى:** public_html (أو المجلد المطلوب)
3. **ارفع:** `alenwan-backend.zip`
4. **فك الضغط:** انقر بزر الماوس الأيمن > Extract
5. **انقل الملفات:** انقل محتويات `temp-laravel` إلى `public_html`

#### 2.4 هيكل المجلدات النهائي:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← هذا المجلد الوحيد المرئي للمستخدمين
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
└── composer.json
```

⚠️ **مهم:** المجلد `public` فقط يجب أن يكون متاحاً للإنترنت!

### الخطوة 3: إعداد .htaccess

#### 3.1 في المجلد الرئيسي (public_html):

أنشئ ملف `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### 3.2 في مجلد public:

تأكد من وجود `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### الخطوة 4: إعداد .env

عدّل ملف `.env` في cPanel File Manager:

```env
APP_NAME=Alenwan
APP_ENV=production
APP_KEY=base64:I6wA0nI3WijjRG4d/z8iDWCtRBlNXXVR7LzOVgBYq/M=
APP_DEBUG=false
APP_TIMEZONE=Asia/Riyadh
APP_URL=https://yourdomain.com

APP_LOCALE=ar
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database - استخدم المعلومات من الخطوة 2.2
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_alenwan_db
DB_USERNAME=username_alenwan_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=10080
SESSION_ENCRYPT=true

CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail Settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# TAP Payment
TAP_SECRET_KEY=your_tap_secret_key_here
TAP_PUBLIC_KEY=your_tap_public_key_here
TAP_CURRENCY=KWD
TAP_MODE=test
```

### الخطوة 5: ضبط الصلاحيات

في Terminal من cPanel:

```bash
cd public_html

# صلاحيات المجلدات
chmod -R 755 storage bootstrap/cache
find storage -type d -exec chmod 755 {} \;
find bootstrap/cache -type d -exec chmod 755 {} \;

# صلاحيات الملفات
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;
```

### الخطوة 6: تثبيت Dependencies

#### 6.1 عبر Terminal (إذا متوفر):

```bash
cd public_html
composer install --optimize-autoloader --no-dev
```

#### 6.2 عبر SSH (إذا متوفر):

```bash
ssh username@yourdomain.com
cd public_html
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

⚠️ **إذا لم يكن Composer متاحاً:**
ارفع مجلد `vendor` كاملاً من جهازك المحلي!

### الخطوة 7: تشغيل Migrations

```bash
php artisan migrate --force
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=LanguageSeeder
php artisan db:seed --class=SubscriptionPlanSeeder
```

أو ارفع ملف SQL dump:

```bash
# في cPanel > phpMyAdmin
# استيراد ملف database.sql
```

### الخطوة 8: إعداد SSL

1. **في cPanel:** اذهب إلى SSL/TLS
2. **استخدم:** Let's Encrypt (مجاني)
3. **أو:** AutoSSL من cPanel
4. **فعّل:** Force HTTPS Redirect

### الخطوة 9: الاختبار

```bash
# اختبر الموقع
https://yourdomain.com

# اختبر API
https://yourdomain.com/api/ping

# اختبر Admin
https://yourdomain.com/admin
```

---

## 🖥️ الطريقة 2: النشر على VPS

### متطلبات:
- Ubuntu 22.04 LTS (موصى به)
- أو Debian 11
- أو CentOS 8

### الخطوة 1: الاتصال بالسيرفر

```bash
ssh root@your_server_ip
```

### الخطوة 2: تحديث النظام

```bash
apt update && apt upgrade -y
```

### الخطوة 3: تثبيت المتطلبات

```bash
# تثبيت PHP 8.2 والإضافات
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring \
  php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd \
  php8.2-tokenizer php8.2-fileinfo php8.2-cli

# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# تثبيت MySQL
apt install -y mysql-server

# تثبيت Nginx
apt install -y nginx

# تثبيت Certbot (للـ SSL)
apt install -y certbot python3-certbot-nginx
```

### الخطوة 4: إعداد MySQL

```bash
mysql_secure_installation

# إنشاء قاعدة البيانات
mysql -u root -p

CREATE DATABASE alenwan_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'alenwan_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON alenwan_db.* TO 'alenwan_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### الخطوة 5: إعداد المشروع

```bash
# إنشاء مستخدم للمشروع
adduser alenwan
usermod -aG www-data alenwan

# الانتقال للمجلد
cd /var/www

# استنساخ/رفع المشروع
# الطريقة 1: Git
git clone https://github.com/yourusername/alenwan-backend.git
cd alenwan-backend

# الطريقة 2: رفع ملف ZIP
# ارفع الملف ثم:
unzip alenwan-backend.zip
cd alenwan-backend

# الصلاحيات
chown -R alenwan:www-data /var/www/alenwan-backend
chmod -R 755 /var/www/alenwan-backend
chmod -R 775 /var/www/alenwan-backend/storage
chmod -R 775 /var/www/alenwan-backend/bootstrap/cache

# تثبيت Dependencies
composer install --optimize-autoloader --no-dev

# إعداد .env
cp .env.example .env
nano .env
# (عدّل الإعدادات)

# المفتاح والـ Migrations
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### الخطوة 6: إعداد Nginx

```bash
nano /etc/nginx/sites-available/alenwan
```

أضف:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/alenwan-backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# تفعيل الموقع
ln -s /etc/nginx/sites-available/alenwan /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

### الخطوة 7: إعداد SSL

```bash
certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### الخطوة 8: إعداد Cron Jobs

```bash
crontab -e
```

أضف:

```bash
* * * * * cd /var/www/alenwan-backend && php artisan schedule:run >> /dev/null 2>&1
```

---

## ✅ الإعدادات بعد النشر

### 1. تحسين الأداء:

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. إعداد Queue Worker (اختياري):

```bash
# إنشاء Supervisor config
nano /etc/supervisor/conf.d/alenwan-worker.conf
```

```ini
[program:alenwan-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/alenwan-backend/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=alenwan
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/alenwan-backend/storage/logs/worker.log
```

```bash
supervisorctl reread
supervisorctl update
supervisorctl start alenwan-worker:*
```

### 3. إعداد Backup تلقائي:

```bash
# إنشاء سكريبت Backup
nano /usr/local/bin/backup-alenwan.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u alenwan_user -p'password' alenwan_db > /backups/db_$DATE.sql
tar -czf /backups/files_$DATE.tar.gz /var/www/alenwan-backend
find /backups -type f -mtime +7 -delete
```

```bash
chmod +x /usr/local/bin/backup-alenwan.sh

# إضافة لـ Cron
crontab -e
0 2 * * * /usr/local/bin/backup-alenwan.sh
```

---

## 🔧 حل المشاكل الشائعة

### مشكلة: خطأ 500

**الحل:**
```bash
# تحقق من الـ Logs
tail -f storage/logs/laravel.log

# صلاحيات
chmod -R 775 storage bootstrap/cache

# امسح الـ Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### مشكلة: لا يعمل .env

**الحل:**
```bash
php artisan config:cache
php artisan config:clear
```

### مشكلة: خطأ قاعدة البيانات

**الحل:**
```bash
# تحقق من الاتصال
php artisan tinker
DB::connection()->getPdo();

# تحقق من .env
DB_HOST=localhost (وليس 127.0.0.1)
```

### مشكلة: الصور لا تظهر

**الحل:**
```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

---

## 📞 الدعم

للمساعدة:
- راجع `START_HERE.md`
- راجع Laravel Logs في `storage/logs/laravel.log`
- راجع Nginx/Apache logs

---

**✅ تم! Backend جاهز على السيرفر! 🚀**

تاريخ آخر تحديث: 2025-10-29
