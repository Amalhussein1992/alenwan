# 🚀 تعليمات إعداد قاعدة البيانات على السيرفر

## 📋 المشكلة الحالية

Backend مرفوع على السيرفر بنجاح، لكن قاعدة البيانات فارغة ويحتاج إلى:
- ✅ تشغيل Migrations (إنشاء الجداول)
- ✅ تشغيل Seeders (إضافة البيانات الأساسية)
- ✅ إضافة محتوى تجريبي

---

## 🎯 الحل السريع (موصى به)

### الطريقة 1: استخدام السكريبت الجاهز

تم إنشاء سكريبت `setup_database_production.php` الذي يقوم بكل شيء تلقائياً!

#### الخطوات:

1. **ارفع الملف على السيرفر:**
   ```
   setup_database_production.php
   ```

   ضعه في نفس المجلد الذي يحتوي على `artisan`

2. **افتح المتصفح:**
   ```
   https://www.alenwanapp.net/setup_database_production.php
   ```

3. **أدخل مفتاح الأمان:**
   ```
   Alenwan2025Setup!
   ```

4. **اضغط على "ابدأ الإعداد الآن"**

5. **انتظر 1-2 دقيقة** حتى تكتمل العملية

6. **⚠️ مهم جداً:** احذف الملف بعد الانتهاء!
   ```
   احذف: setup_database_production.php
   ```

---

## 🛠️ الطريقة 2: يدوياً عبر SSH/Terminal

إذا كان لديك وصول SSH:

```bash
# 1. اذهب إلى مجلد المشروع
cd /path/to/your/project

# 2. تشغيل Migrations
php artisan migrate --force

# 3. تشغيل Seeders
php artisan db:seed --class=CategorySeeder --force
php artisan db:seed --class=LanguageSeeder --force
php artisan db:seed --class=SubscriptionPlanSeeder --force

# 4. إنشاء Admin (إذا لم يكن موجوداً)
php artisan tinker
# ثم نفّذ:
# User::create(['name'=>'Admin','email'=>'admin@alenwan.com','password'=>Hash::make('Alenwan@Admin2025!'),'role'=>'admin','email_verified_at'=>now()]);
# exit

# 5. مسح Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 6. تحسين الأداء
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🛠️ الطريقة 3: عبر cPanel Terminal

إذا كنت تستخدم cPanel:

1. **افتح cPanel**
2. **ابحث عن Terminal**
3. **اذهب إلى مجلد المشروع:**
   ```bash
   cd public_html
   # أو
   cd domains/alenwanapp.net/public_html
   ```

4. **نفّذ نفس الأوامر من الطريقة 2 أعلاه**

---

## ✅ التحقق من نجاح الإعداد

بعد تشغيل السكريبت أو الأوامر اليدوية، اختبر:

### 1. **API Ping:**
```
https://www.alenwanapp.net/api/ping
```
يجب أن يعيد:
```json
{
    "success": true,
    "message": "Alenwan API is running",
    "version": "1.1.0"
}
```

### 2. **API Categories:**
```
https://www.alenwanapp.net/api/categories
```
يجب أن يعيد قائمة بالتصنيفات (لا يكون `[]` فارغ)

### 3. **API Movies:**
```
https://www.alenwanapp.net/api/movies
```
يجب أن يعيد قائمة بالأفلام (5 أفلام على الأقل)

### 4. **Admin Panel:**
```
https://www.alenwanapp.net/admin
```
سجّل دخول بـ:
- Email: `admin@alenwan.com`
- Password: `Alenwan@Admin2025!`

---

## 📊 ما الذي سيتم إضافته؟

عند تشغيل السكريبت:

### 1. **التصنيفات (Categories):**
- أكشن
- دراما
- كوميديا
- رعب
- رومانسي
- وثائقي
- رياضة
- وأكثر...

### 2. **اللغات (Languages):**
- العربية
- الإنجليزية
- الفرنسية
- الإسبانية
- وأكثر...

### 3. **خطط الاشتراك (Subscription Plans):**
- خطة شهرية
- خطة ربع سنوية
- خطة سنوية

### 4. **المحتوى التجريبي:**
- **5 أفلام** مع صور وأوصاف
- **3 مسلسلات** مع **15 حلقة** (5 حلقات لكل مسلسل)

### 5. **مستخدم Admin:**
- Email: `admin@alenwan.com`
- Password: `Alenwan@Admin2025!`

---

## 🆘 حل المشاكل الشائعة

### المشكلة: "خطأ 500" عند فتح السكريبت

**الحل:**
1. تحقق من أن ملف `.env` موجود وصحيح
2. تحقق من أن إعدادات قاعدة البيانات في `.env` صحيحة:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

### المشكلة: "فشل الاتصال بقاعدة البيانات"

**الحل:**
1. تأكد من أن قاعدة البيانات موجودة في cPanel → MySQL Databases
2. تحقق من اسم المستخدم وكلمة المرور
3. تأكد من أن المستخدم لديه جميع الصلاحيات على القاعدة

### المشكلة: "Class not found"

**الحل:**
```bash
# شغّل Composer Autoload
composer dump-autoload
```

### المشكلة: "Permission denied"

**الحل:**
```bash
# اضبط الصلاحيات
chmod -R 755 storage bootstrap/cache
```

---

## 🔒 ملاحظات أمنية مهمة

### ⚠️ بعد الانتهاء من الإعداد:

1. **احذف ملف السكريبت:**
   ```
   ❌ احذف: setup_database_production.php
   ```

2. **غيّر كلمة مرور Admin:**
   - سجّل دخول إلى `/admin`
   - اذهب إلى الإعدادات
   - غيّر كلمة المرور

3. **تأكد من `.env`:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

4. **تفعيل SSL/HTTPS:**
   - تأكد من أن الموقع يعمل على HTTPS
   - تحديث `APP_URL` في `.env`:
     ```env
     APP_URL=https://www.alenwanapp.net
     ```

---

## 📱 تحديث Flutter App

بعد نجاح إعداد Backend:

### في ملف `lib/config/api_config.dart`:

```dart
class ApiConfig {
  static const String baseUrl = 'https://www.alenwanapp.net/api';

  // باقي الإعدادات...
}
```

### اختبار الاتصال:

1. شغّل التطبيق
2. جرّب تسجيل الدخول
3. تحقق من ظهور المحتوى (الأفلام والمسلسلات)

---

## ✅ قائمة تحقق نهائية

- [ ] تم رفع `setup_database_production.php` على السيرفر
- [ ] تم فتح السكريبت في المتصفح
- [ ] تم إدخال مفتاح الأمان الصحيح
- [ ] تم تشغيل الإعداد بنجاح
- [ ] تم حذف ملف السكريبت
- [ ] تم اختبار `/api/ping` ✓
- [ ] تم اختبار `/api/categories` ✓
- [ ] تم اختبار `/api/movies` ✓
- [ ] تم الدخول إلى `/admin` ✓
- [ ] تم تغيير كلمة مرور Admin
- [ ] تم تحديث `baseUrl` في Flutter App
- [ ] تم اختبار التطبيق مع Backend الجديد

---

## 🎉 بعد الانتهاء

عندما تكتمل جميع الخطوات أعلاه، يكون لديك:

✅ Backend يعمل 100% على `https://www.alenwanapp.net`
✅ API جاهز للاستخدام
✅ قاعدة بيانات مع محتوى تجريبي
✅ لوحة تحكم Admin جاهزة
✅ Flutter App متصل بالـ Backend

**🚀 مبروك! منصة Alenwan جاهزة للعمل!**

---

## 📞 هل تحتاج مساعدة؟

إذا واجهت أي مشكلة:

1. راجع قسم "حل المشاكل الشائعة" أعلاه
2. تحقق من ملف Logs:
   ```
   storage/logs/laravel.log
   ```
3. تأكد من إعدادات `.env` صحيحة

---

**آخر تحديث:** 2025-10-29
**الحالة:** ✅ جاهز للتنفيذ
