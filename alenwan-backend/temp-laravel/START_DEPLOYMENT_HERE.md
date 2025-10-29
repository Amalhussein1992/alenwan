# 🚀 ابدأ النشر من هنا - دليل سريع

## ✅ تم تجهيز كل شيء! فقط اتبع الخطوات:

---

## 📦 الخطوة 1: تحضير الملفات (على جهازك)

### 1.1 ضغط المشروع:
```
1. انتقل إلى: C:\Users\HP\Desktop\flutter\alenwan-backend\
2. انقر بزر الماوس الأيمن على مجلد "temp-laravel"
3. اختر "Send to > Compressed (zipped) folder"
4. سمّه: alenwan-backend.zip
```

**أو استخدم WinRAR/7zip لضغط المجلد**

### 1.2 الملفات الجاهزة:
✅ `alenwan-backend.zip` - المشروع كامل
✅ `.env.production.example` - إعدادات الإنتاج
✅ `DEPLOYMENT_GUIDE.md` - الدليل الشامل
✅ `QUICK_DEPLOYMENT_CHECKLIST.md` - قائمة التحقق

---

## 🌐 الخطوة 2: اختر طريقة النشر

### الطريقة 1️⃣: cPanel (الأسهل - موصى به)
⏱️ **الوقت:** 20-30 دقيقة
💰 **التكلفة:** منخفضة
👍 **الأفضل لـ:** المبتدئين، Shared Hosting

**➡️ اذهب إلى القسم A أدناه**

### الطريقة 2️⃣: VPS/Cloud (الأقوى)
⏱️ **الوقت:** 40-60 دقيقة
💰 **التكلفة:** متوسطة-عالية
👍 **الأفضل لـ:** الأداء العالي، تحكم كامل

**➡️ اذهب إلى القسم B أدناه**

---

## 🅰️ القسم A: النشر على cPanel

### الخطوات السريعة:

#### 1️⃣ إنشاء قاعدة البيانات:
```
1. ادخل cPanel
2. اذهب إلى: MySQL Databases
3. أنشئ قاعدة بيانات: اسمها مثلاً alenwan_db
4. أنشئ مستخدم: اسمه مثلاً alenwan_user
5. اربط المستخدم بالقاعدة وأعطه ALL PRIVILEGES
6. احفظ البيانات:
   Database: username_alenwan_db
   User: username_alenwan_user
   Password: (كلمة المرور التي أنشأتها)
```

#### 2️⃣ رفع الملفات:
```
1. في cPanel > File Manager
2. اذهب إلى public_html
3. ارفع alenwan-backend.zip
4. فك الضغط (Extract)
5. انقل جميع الملفات من temp-laravel إلى public_html مباشرة
```

#### 3️⃣ إعداد .env:
```
1. في File Manager، افتح ملف .env
2. عدّل الأسطر التالية:

APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_DATABASE=username_alenwan_db
DB_USERNAME=username_alenwan_user
DB_PASSWORD=كلمة_مرور_قاعدة_البيانات

3. احفظ الملف
```

#### 4️⃣ إعداد .htaccess:
```
1. أنشئ ملف .htaccess في public_html
2. ضع فيه:

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

3. احفظ
```

#### 5️⃣ ضبط الصلاحيات:
```
في Terminal من cPanel:

chmod -R 755 storage bootstrap/cache
```

#### 6️⃣ تشغيل Migrations:
```
في Terminal:

php artisan migrate --force
```

#### 7️⃣ تفعيل SSL:
```
1. في cPanel > SSL/TLS
2. اختر Let's Encrypt
3. فعّل SSL لدومينك
```

#### 8️⃣ اختبار:
```
افتح المتصفح:
https://yourdomain.com/api/ping

يجب أن يظهر: {"message":"pong"}
```

---

## 🅱️ القسم B: النشر على VPS

### الخطوات السريعة:

#### 1️⃣ الاتصال بالسيرفر:
```bash
ssh root@your_server_ip
```

#### 2️⃣ تثبيت المتطلبات:
```bash
# تحديث النظام
apt update && apt upgrade -y

# تثبيت PHP 8.2
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring \
  php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip

# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# تثبيت MySQL
apt install -y mysql-server

# تثبيت Nginx
apt install -y nginx
```

#### 3️⃣ إنشاء قاعدة البيانات:
```bash
mysql -u root -p

CREATE DATABASE alenwan_db;
CREATE USER 'alenwan_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL ON alenwan_db.* TO 'alenwan_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### 4️⃣ رفع المشروع:
```bash
cd /var/www
# ارفع alenwan-backend.zip هنا
unzip alenwan-backend.zip
mv temp-laravel alenwan-backend

cd alenwan-backend
chmod -R 755 storage bootstrap/cache
```

#### 5️⃣ إعداد .env وتثبيت:
```bash
cp .env.production.example .env
nano .env
# (عدّل الإعدادات)

composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan optimize
```

#### 6️⃣ إعداد Nginx:
```bash
nano /etc/nginx/sites-available/alenwan
```

الصق:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/alenwan-backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

```bash
ln -s /etc/nginx/sites-available/alenwan /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

#### 7️⃣ SSL:
```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d yourdomain.com
```

---

## ✅ بعد النشر

### اختبار Backend:

1. **الصفحة الرئيسية:**
   ```
   https://yourdomain.com
   ```

2. **API:**
   ```
   https://yourdomain.com/api/ping
   ```

3. **لوحة التحكم:**
   ```
   https://yourdomain.com/admin
   Email: admin@alenwan.com
   Password: Alenwan@Admin2025!
   ```

### تحديث Flutter App:

في ملف `lib/config/api_config.dart`:

```dart
static const String baseUrl = 'https://yourdomain.com/api';
```

---

## 📞 المساعدة

### إذا واجهت مشاكل:

1. **راجع Logs:**
   ```
   storage/logs/laravel.log
   ```

2. **راجع الأدلة:**
   - `DEPLOYMENT_GUIDE.md` - الدليل الشامل الكامل
   - `QUICK_DEPLOYMENT_CHECKLIST.md` - قائمة التحقق

3. **مشاكل شائعة:**
   - خطأ 500: تحقق من الصلاحيات والـ .env
   - قاعدة البيانات: تحقق من بيانات الاتصال
   - SSL: استخدم Let's Encrypt

---

## 🎊 تهانينا!

عند اكتمال الخطوات، يكون لديك:
✅ Backend يعمل على السيرفر
✅ API جاهز للتطبيق
✅ لوحة تحكم Admin
✅ SSL مفعّل
✅ قاعدة بيانات جاهزة

**🚀 Backend جاهز 100% على السيرفر!**

---

**آخر تحديث:** 2025-10-29
