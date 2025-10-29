# ✅ قائمة التحقق قبل رفع المشروع

## 📋 قبل البدء - تأكد من هذه النقاط

### 🔧 على جهازك المحلي:

#### 1. المشروع يعمل بدون أخطاء
```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel
php artisan serve
```
- [ ] السيرفر يعمل بدون أخطاء
- [ ] يمكن الوصول لـ http://localhost:8000
- [ ] Admin Panel يفتح: http://localhost:8000/admin

#### 2. قاعدة البيانات سليمة
```bash
php artisan migrate:status
```
- [ ] جميع Migrations تم تشغيلها
- [ ] بدون أخطاء في قاعدة البيانات

#### 3. مستخدم Admin موجود
```bash
php artisan tinker
User::where('is_admin', true)->count();
```
- [ ] يوجد مستخدم admin واحد على الأقل
- [ ] يمكن تسجيل الدخول به

#### 4. إعدادات .env صحيحة محلياً
- [ ] APP_KEY موجود
- [ ] DB_CONNECTION صحيح
- [ ] VIMEO credentials (إذا موجودة)

---

## 🚀 متطلبات السيرفر

### خيارات الاستضافة:

#### الخيار الأول: Laravel Forge (الأسهل) ⭐ موصى به
**التكلفة:** ~$21/شهر
- [ ] حساب Laravel Forge جاهز
- [ ] حساب DigitalOcean جاهز
- [ ] Domain جاهز (مثل: api.alenwan.com)

#### الخيار الثاني: VPS يدوياً (للمحترفين)
**التكلفة:** ~$8/شهر
- [ ] VPS جاهز (DigitalOcean, Linode, إلخ)
- [ ] خبرة في Linux
- [ ] Domain جاهز

---

## 📝 قبل الرفع مباشرة

### 1. تحضير Git Repository

```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel

# إنشاء .gitignore
echo "/vendor
/node_modules
/.env
/storage/*.key
/public/hot
/public/storage
" > .gitignore

# Git Init
git init
git add .
git commit -m "Initial commit: Alenwan Backend"

# ربط مع GitHub
git remote add origin https://github.com/YOUR_USERNAME/alenwan-backend.git
git push -u origin main
```

- [ ] Repository على GitHub جاهز
- [ ] الكود تم رفعه
- [ ] `.env` غير مرفوع (مهم!)

### 2. تحضير ملف .env للسيرفر

أنشئ ملف: `.env.production` (لا ترفعه لـ Git!)

```env
APP_NAME=Alenwan
APP_ENV=production
APP_KEY=  # سيتم توليده على السيرفر
APP_DEBUG=false
APP_URL=https://api.alenwan.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alenwan
DB_USERNAME=alenwan_user
DB_PASSWORD=STRONG_PASSWORD_HERE

VIMEO_CLIENT_ID=your_vimeo_client_id
VIMEO_CLIENT_SECRET=your_vimeo_client_secret
VIMEO_ACCESS_TOKEN=your_vimeo_access_token

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

- [ ] ملف `.env.production` جاهز
- [ ] كلمات مرور قوية
- [ ] APP_DEBUG=false

### 3. Domain جاهز

- [ ] اشتريت Domain (أو subdomain)
- [ ] لديك وصول لإدارة DNS
- [ ] جاهز لإضافة A Record

---

## 🎯 خطة الرفع

### إذا اخترت Laravel Forge:

#### المرحلة 1: إعداد السيرفر (15 دقيقة)
- [ ] إنشاء حساب Forge
- [ ] ربط DigitalOcean
- [ ] إنشاء سيرفر جديد
- [ ] انتظار اكتمال الإعداد

#### المرحلة 2: إعداد الموقع (10 دقائق)
- [ ] إنشاء Site جديد
- [ ] ربط Git Repository
- [ ] تحديث Environment Variables
- [ ] Deploy أول

#### المرحلة 3: قاعدة البيانات (5 دقائق)
- [ ] تشغيل Migrations
- [ ] إنشاء Admin User
- [ ] اختبار الاتصال

#### المرحلة 4: SSL وDomain (5 دقائق)
- [ ] ربط Domain
- [ ] تفعيل SSL
- [ ] اختبار HTTPS

---

## ✅ بعد الرفع - الاختبار

### 1. اختبار أساسي:
```
زيارة الموقع:
✓ https://api.alenwan.com
✓ https://api.alenwan.com/admin

تسجيل الدخول:
✓ Email & Password يعملان
✓ Dashboard يظهر

API:
✓ https://api.alenwan.com/api/categories
```

- [ ] الموقع يفتح
- [ ] SSL نشط (قفل أخضر)
- [ ] Admin Panel يعمل
- [ ] تسجيل الدخول يعمل

### 2. اختبار متقدم:

```bash
# على السيرفر
php artisan tinker

# اختبار Database
DB::connection()->getPdo();

# اختبار Models
Category::count();
Movie::count();
User::where('is_admin', true)->count();
```

- [ ] Database Connection يعمل
- [ ] Models تعمل
- [ ] بدون أخطاء

### 3. مراجعة Logs:

```bash
tail -f storage/logs/laravel.log
```

- [ ] بدون أخطاء خطيرة
- [ ] Warnings مقبولة

---

## 🔐 الأمان - مهم جداً!

### قبل فتح الموقع للعامة:

- [ ] `APP_DEBUG=false` في .env
- [ ] `APP_ENV=production` في .env
- [ ] Firewall مفعّل على السيرفر
- [ ] SSH بـ key فقط (بدون password)
- [ ] Database password قوي
- [ ] تم تغيير كلمة مرور admin الافتراضية

---

## 📊 الخطوات التالية

### بعد الرفع الناجح:

#### 1. إنشاء Filament Resources
```bash
php artisan make:filament-resource Category --generate
php artisan make:filament-resource Movie --generate
php artisan make:filament-resource Series --generate
```

#### 2. إضافة محتوى تجريبي
- افتح Admin Panel
- أضف فئات
- أضف أفلام ومسلسلات

#### 3. إنشاء API Endpoints
- أنشئ Controllers
- أضف Routes
- اختبر من Postman

#### 4. ربط مع Flutter App
- غيّر Base URL في التطبيق
- اختبر الاتصال
- اختبر جميع المزايا

---

## 🆘 خطة B - إذا حدثت مشاكل

### لديك نسخة احتياطية من:
- [ ] قاعدة البيانات المحلية
- [ ] ملفات المشروع
- [ ] ملف .env

### خطوات الإنقاذ:
1. تحقق من Logs
2. راجع Documentation
3. ابحث عن الخطأ في Google
4. جرب على سيرفر تجريبي أولاً

---

## 📞 معلومات مهمة للحفظ

### بيانات الوصول (احفظها بأمان!):

```
Server IP: _______________
Domain: api.alenwan.com
Database Name: _______________
Database User: _______________
Database Password: _______________

Admin Email: _______________
Admin Password: _______________

SSH Key Location: _______________
```

### خدمات خارجية:

```
Laravel Forge:
Email: _______________
Password: _______________

DigitalOcean:
Email: _______________
API Token: _______________

Vimeo API:
Client ID: _______________
Client Secret: _______________
Access Token: _______________
```

---

## ⏱️ الوقت المتوقع

### مع Laravel Forge:
- إعداد أولي: 15 دقيقة
- إعداد الموقع: 10 دقائق
- تجربة واختبار: 15 دقيقة
- **الإجمالي: ~40 دقيقة**

### يدوياً على VPS:
- إعداد السيرفر: 1-2 ساعة
- رفع المشروع: 30 دقيقة
- إعداد SSL: 15 دقيقة
- اختبار: 15 دقيقة
- **الإجمالي: ~2-3 ساعات**

---

## 🎯 هل أنت مستعد؟

### إذا كانت جميع النقاط التالية ✅:

- [x] المشروع يعمل محلياً
- [x] Git Repository جاهز
- [x] قررت نوع الاستضافة
- [x] Domain جاهز (أو ستشتريه)
- [x] ملف .env.production جاهز
- [x] Vimeo API جاهز

**إذاً أنت جاهز للرفع! 🚀**

---

## 📖 الخطوة التالية

افتح: **[DEPLOYMENT_GUIDE_AR.md](DEPLOYMENT_GUIDE_AR.md)**

واختر الطريقة المناسبة لك:
- Laravel Forge (سهلة)
- VPS يدوياً (متقدمة)

---

**نصيحة:** ابدأ بـ Laravel Forge إذا كانت هذه أول مرة تنشر مشروع Laravel!

