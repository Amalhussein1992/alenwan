# 🚀 دليل رفع المشروع على السيرفر - Production Deployment

## ✅ قائمة التحقق قبل الرفع

### 1. التأكد من جاهزية المشروع محلياً:
- [ ] المشروع يعمل على localhost بدون أخطاء
- [ ] تم إنشاء مستخدم admin وتجربة تسجيل الدخول
- [ ] قاعدة البيانات تعمل بشكل صحيح
- [ ] Filament Resources تم إنشاؤها (أو جاهز لإنشائها على السيرفر)
- [ ] تم اختبار Vimeo API (إذا كنت تستخدمه)

### 2. متطلبات السيرفر:
- [ ] PHP 8.2 أو أحدث
- [ ] Composer
- [ ] MySQL/MariaDB أو PostgreSQL (بدلاً من SQLite)
- [ ] SSL Certificate (لـ HTTPS)
- [ ] Domain/Subdomain جاهز

---

## 🖥️ اختيار نوع السيرفر

### الخيار 1: استضافة مشتركة (Shared Hosting) ❌ غير موصى به
- محدودة جداً
- صعوبة في التحكم
- **لا ننصح بها للإنتاج**

### الخيار 2: VPS (Virtual Private Server) ✅ موصى به
**الخيارات الشهيرة:**
- **DigitalOcean** - $6/شهر (سهل للمبتدئين)
- **Linode/Akamai** - $5/شهر
- **Vultr** - $6/شهر
- **AWS Lightsail** - $5/شهر

### الخيار 3: استضافة متخصصة في Laravel ✅✅ الأسهل
- **Laravel Forge** + DigitalOcean - $15/شهر
- **Ploi.io** + DigitalOcean - $10/شهر
- **RunCloud** + VPS - $8/شهر

---

## 📋 الطريقة الموصى بها: Laravel Forge

### لماذا Laravel Forge؟
✅ سهل جداً للمبتدئين
✅ يهتم بكل الإعدادات تلقائياً
✅ SSL مجاني تلقائي
✅ Backups سهلة
✅ Deploy بضغطة زر
✅ دعم ممتاز

### التكلفة:
- Laravel Forge: $15/شهر
- DigitalOcean VPS: $6/شهر
- **الإجمالي: $21/شهر**

---

## 🚀 خطوات الرفع باستخدام Laravel Forge

### الخطوة 1: إنشاء حساب Forge

1. اذهب إلى: https://forge.laravel.com
2. اشترك في الخطة (تجربة مجانية لمدة 5 أيام)
3. اربط حسابك مع DigitalOcean:
   - اذهب لـ Account → Server Providers
   - اضغط Connect To Digital Ocean
   - أدخل API Token من DigitalOcean

### الخطوة 2: إنشاء سيرفر جديد

1. في Forge، اضغط "Create Server"
2. املأ البيانات:
   - **Provider**: DigitalOcean
   - **Server Name**: alenwan-production
   - **Region**: اختر الأقرب لك (Frankfurt لأوروبا/الشرق الأوسط)
   - **Server Size**: Basic ($6/mo) كافي للبداية
   - **PHP Version**: 8.2 أو 8.3
   - **Database**: MySQL 8.0

3. اضغط "Create Server" وانتظر 5-10 دقائق

### الخطوة 3: إنشاء Site جديد

1. بعد إنشاء السيرفر، اضغط على اسم السيرفر
2. اذهب لـ "Sites" → "New Site"
3. املأ البيانات:
   - **Root Domain**: api.alenwan.com (أو أي domain تريده)
   - **Project Type**: Laravel
   - **Web Directory**: `/public`

4. اضغط "Add Site"

### الخطوة 4: ربط Git Repository

1. في صفحة الـ Site، اذهب لـ "Git Repository"
2. اختر:
   - **Source Control Provider**: GitHub (أو GitLab/Bitbucket)
   - **Repository**: username/alenwan-backend
   - **Branch**: main أو master

3. اضغط "Install Repository"

### الخطوة 5: إعداد Environment Variables

1. في صفحة الـ Site، اذهب لـ "Environment"
2. عدّل ملف `.env`:

```env
APP_NAME=Alenwan
APP_ENV=production
APP_KEY=base64:WILL_BE_GENERATED
APP_DEBUG=false
APP_URL=https://api.alenwan.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forge
DB_USERNAME=forge
DB_PASSWORD=YOUR_DB_PASSWORD

# Vimeo
VIMEO_CLIENT_ID=your_vimeo_client_id
VIMEO_CLIENT_SECRET=your_vimeo_client_secret
VIMEO_ACCESS_TOKEN=your_vimeo_access_token

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

3. اضغط "Save"

### الخطوة 6: إعداد SSL (مجاني)

1. في صفحة الـ Site، اذهب لـ "SSL"
2. اختر "LetsEncrypt"
3. اضغط "Obtain Certificate"
4. انتظر دقيقة واحدة
5. ✅ SSL جاهز!

### الخطوة 7: Deploy الأول

1. في صفحة الـ Site، اضغط "Deploy Now"
2. انتظر حتى ينتهي (2-3 دقائق)
3. ✅ الموقع الآن على الهواء!

### الخطوة 8: تشغيل Migrations

1. في صفحة الـ Site، اذهب لـ "Commands"
2. نفّذ الأوامر التالية:

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### الخطوة 9: إنشاء Admin User

```bash
php artisan admin:create
```

أدخل البيانات عندما يُطلب منك.

---

## 🔧 الطريقة اليدوية (بدون Forge)

إذا كنت تريد إعداد كل شيء يدوياً على VPS:

### الخطوة 1: إعداد السيرفر

```bash
# تحديث النظام
sudo apt update && sudo apt upgrade -y

# تثبيت PHP 8.2
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath php8.2-redis -y

# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# تثبيت MySQL
sudo apt install mysql-server -y

# تثبيت Nginx
sudo apt install nginx -y

# تثبيت Redis
sudo apt install redis-server -y
```

### الخطوة 2: إعداد MySQL

```bash
sudo mysql_secure_installation

# دخول MySQL
sudo mysql

# إنشاء قاعدة بيانات
CREATE DATABASE alenwan;
CREATE USER 'alenwan_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON alenwan.* TO 'alenwan_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### الخطوة 3: رفع المشروع

```bash
# إنشاء مجلد
sudo mkdir -p /var/www/alenwan
cd /var/www/alenwan

# رفع الملفات (من جهازك)
# استخدم SFTP أو Git

# إذا استخدمت Git:
git clone https://github.com/username/alenwan-backend.git .

# تثبيت Dependencies
composer install --no-dev --optimize-autoloader

# نسخ .env
cp .env.example .env
nano .env  # عدّل البيانات

# Generate Key
php artisan key:generate

# Permissions
sudo chown -R www-data:www-data /var/www/alenwan
sudo chmod -R 755 /var/www/alenwan
sudo chmod -R 775 /var/www/alenwan/storage
sudo chmod -R 775 /var/www/alenwan/bootstrap/cache

# Migrations
php artisan migrate --force

# Storage Link
php artisan storage:link

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create Admin
php artisan admin:create
```

### الخطوة 4: إعداد Nginx

```bash
sudo nano /etc/nginx/sites-available/alenwan
```

أضف:

```nginx
server {
    listen 80;
    server_name api.alenwan.com;
    root /var/www/alenwan/temp-laravel/public;

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
sudo ln -s /etc/nginx/sites-available/alenwan /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### الخطوة 5: إعداد SSL (Certbot)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d api.alenwan.com
```

---

## 📱 ربط Domain

### في مزود الـ Domain (Namecheap, GoDaddy, إلخ):

أضف A Record:
```
Type: A
Host: api
Value: IP_ADDRESS_OF_YOUR_SERVER
TTL: Automatic
```

انتظر 5-30 دقيقة حتى ينتشر DNS.

---

## 🔐 الأمان - مهم جداً!

### 1. في ملف .env على السيرفر:

```env
APP_ENV=production
APP_DEBUG=false  # مهم جداً!
```

### 2. إعداد Firewall:

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 3. Fail2Ban (حماية من هجمات Brute Force):

```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

---

## 🔄 Auto Deployment (اختياري)

### إعداد GitHub Webhook:

في Laravel Forge أو يدوياً:

1. إنشاء Deploy Script:

```bash
cd /var/www/alenwan
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
```

2. في GitHub → Settings → Webhooks
3. أضف URL من Forge أو السيرفر

---

## 📊 المراقبة والصيانة

### 1. Logs:

```bash
# Laravel Logs
tail -f /var/www/alenwan/storage/logs/laravel.log

# Nginx Logs
tail -f /var/log/nginx/error.log
```

### 2. Backups (مهم جداً!):

```bash
# Database Backup
mysqldump -u alenwan_user -p alenwan > backup_$(date +%Y%m%d).sql

# في Forge: Backups تلقائية يومية
```

### 3. المراقبة:

استخدم خدمات مثل:
- **UptimeRobot** (مجاني) - يتحقق من توفر الموقع
- **Laravel Telescope** - مراقبة داخلية
- **Sentry** - تتبع الأخطاء

---

## ✅ قائمة التحقق النهائية

بعد الرفع، تأكد من:

- [ ] الموقع يعمل: https://api.alenwan.com
- [ ] SSL نشط (قفل أخضر)
- [ ] Admin Panel يعمل: https://api.alenwan.com/admin
- [ ] تسجيل الدخول يعمل
- [ ] API Endpoints تعمل
- [ ] Vimeo Integration يعمل
- [ ] Logs نظيفة (بدون أخطاء)
- [ ] Backups مفعّلة
- [ ] Firewall مفعّل
- [ ] APP_DEBUG=false

---

## 🆘 حل المشاكل الشائعة

### مشكلة: 500 Internal Server Error
```bash
# تحقق من Logs
tail -f storage/logs/laravel.log

# تحقق من Permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### مشكلة: Database Connection Failed
```bash
# تحقق من .env
cat .env | grep DB_

# اختبر الاتصال
php artisan tinker
DB::connection()->getPdo();
```

### مشكلة: Mix Manifest Not Found
```bash
# إذا كنت تستخدم Vite/Mix
npm install
npm run build
```

---

## 💰 التكاليف المتوقعة

### البداية (شهرياً):
- **VPS**: $6
- **Domain**: $1-2/شهر ($12-15 سنوياً)
- **SSL**: مجاني (Let's Encrypt)
- **الإجمالي**: ~$8/شهر

### مع Laravel Forge:
- **Forge**: $15
- **VPS**: $6
- **Domain**: $1-2
- **الإجمالي**: ~$23/شهر

### عند النمو:
- قد تحتاج VPS أكبر ($12-24/شهر)
- CDN مثل Cloudflare (مجاني للبداية)
- Backups إضافية ($1-5/شهر)

---

## 📞 الدعم

إذا واجهت مشاكل:
1. راجع Laravel Logs
2. راجع Nginx Logs
3. ابحث في Google عن رسالة الخطأ
4. استخدم Laravel Documentation

---

## 🎯 الخطوة التالية

**الآن:** أنت جاهز للرفع! اختر الطريقة المناسبة لك:
- **سهلة:** Laravel Forge (موصى به)
- **متقدمة:** يدوياً على VPS

**بعد الرفع:** اربط الـ API مع تطبيق Flutter

---

**حظاً موفقاً! 🚀**

