# ✅ قائمة التحقق السريعة للنشر

## قبل الرفع على السيرفر:

### 1. الملفات المحلية
- [ ] تشغيل `prepare-deployment.bat`
- [ ] مراجعة ملف `.env.production.example`
- [ ] ضغط المشروع إلى `alenwan-backend.zip`
- [ ] التأكد من حذف:
  - [ ] `node_modules/` (إن وجد)
  - [ ] ملفات `.log`
  - [ ] ملفات التطوير غير الضرورية

### 2. معلومات السيرفر الجاهزة
- [ ] بيانات الدخول للسيرفر (SSH/FTP/cPanel)
- [ ] اسم النطاق (Domain)
- [ ] بيانات قاعدة البيانات:
  ```
  DB Name: _____________
  DB User: _____________
  DB Password: _____________
  DB Host: localhost (عادة)
  ```

## على السيرفر:

### 3. إعداد السيرفر
- [ ] PHP 8.1+ مثبت
- [ ] MySQL/MariaDB مثبت
- [ ] Composer مثبت (أو ارفع مجلد vendor)
- [ ] جميع PHP Extensions المطلوبة مفعلة
- [ ] SSL Certificate مثبت

### 4. إعداد المشروع
- [ ] رفع الملفات
- [ ] إنشاء قاعدة البيانات
- [ ] إعداد ملف `.env`
- [ ] تنفيذ: `composer install --no-dev`
- [ ] تنفيذ: `php artisan migrate --force`
- [ ] ضبط الصلاحيات:
  ```bash
  chmod -R 755 storage bootstrap/cache
  ```

### 5. إعداد Web Server

#### إذا كنت تستخدم cPanel:
- [ ] إعداد `.htaccess` في الجذر
- [ ] التأكد من أن `public/` هو Document Root
- [ ] تفعيل SSL

#### إذا كنت تستخدم Nginx:
- [ ] إعداد ملف config
- [ ] اختبار: `nginx -t`
- [ ] إعادة تشغيل: `systemctl reload nginx`
- [ ] إعداد SSL مع Certbot

### 6. التحسينات
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan optimize`

### 7. البيانات الأولية
- [ ] تشغيل Seeders:
  ```bash
  php artisan db:seed --class=CategorySeeder
  php artisan db:seed --class=LanguageSeeder
  php artisan db:seed --class=SubscriptionPlanSeeder
  ```
- [ ] أو استيراد SQL dump من phpMyAdmin

### 8. اختبار الموقع
- [ ] الصفحة الرئيسية تعمل: `https://yourdomain.com`
- [ ] API تعمل: `https://yourdomain.com/api/ping`
- [ ] لوحة التحكم تعمل: `https://yourdomain.com/admin`
- [ ] تسجيل الدخول إلى Admin:
  ```
  Email: admin@alenwan.com
  Password: Alenwan@Admin2025!
  ```

### 9. إعدادات الأمان
- [ ] تحديث كلمة مرور Admin
- [ ] التأكد من `APP_DEBUG=false`
- [ ] التأكد من `APP_ENV=production`
- [ ] التأكد من SSL يعمل (HTTPS)
- [ ] التأكد من صلاحيات الملفات صحيحة

### 10. التكامل مع التطبيق
- [ ] تحديث `API_URL` في Flutter app
- [ ] تحديث `TAP_PUBLIC_KEY` في Flutter app
- [ ] اختبار الاتصال من التطبيق
- [ ] اختبار تسجيل الدخول
- [ ] اختبار عرض المحتوى

## بعد النشر:

### 11. المراقبة
- [ ] إعداد Error Monitoring (Sentry/Bugsnag)
- [ ] إعداد Uptime Monitoring
- [ ] مراجعة Logs يومياً أول أسبوع
- [ ] إعداد Backup تلقائي

### 12. الأداء
- [ ] اختبار سرعة الموقع
- [ ] تفعيل Caching إذا لزم
- [ ] تحسين الصور
- [ ] استخدام CDN للملفات الثابتة (اختياري)

## ملاحظات مهمة:

### ⚠️ لا تنسى:
1. **تغيير كلمة مرور Admin** بعد أول دخول
2. **تحديث TAP Payment** للمفاتيح الحقيقية عند الجاهزية
3. **إعداد Backup منتظم** للملفات وقاعدة البيانات
4. **مراجعة Logs** في `storage/logs/laravel.log`

### 📞 في حالة المشاكل:
1. تحقق من `storage/logs/laravel.log`
2. راجع `DEPLOYMENT_GUIDE.md`
3. راجع قسم "حل المشاكل الشائعة"

---

**✅ عند إتمام جميع النقاط أعلاه، Backend جاهز 100%!**
