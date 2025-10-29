# 📤 الملفات التي يجب رفعها على السيرفر

## ⚠️ هام جداً: يجب رفع هذه الملفات

---

## 1️⃣ **الملف الرئيسي (الأهم!):**

### `setup_database_production.php`
**الموقع المحلي:**
```
C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\setup_database_production.php
```

**ارفعه إلى:**
```
/public_html/setup_database_production.php
```

**ثم افتح:**
```
https://www.alenwanapp.net/setup_database_production.php
```

---

## 2️⃣ **ملفات Seeders المُحدَّثة:**

### `database/seeders/DatabaseSeeder.php`
**الموقع المحلي:**
```
C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\database\seeders\DatabaseSeeder.php
```

**ارفعه إلى:**
```
/public_html/database/seeders/DatabaseSeeder.php
```

---

## 📋 خطوات الرفع التفصيلية:

### الطريقة 1: عبر cPanel File Manager

#### الخطوة 1: رفع setup_database_production.php
```
1. افتح cPanel
2. اذهب إلى File Manager
3. انتقل إلى: public_html
4. اضغط Upload
5. اختر الملف:
   C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\setup_database_production.php
6. انتظر حتى يكتمل الرفع
```

#### الخطوة 2: رفع DatabaseSeeder.php
```
1. في File Manager، انتقل إلى:
   public_html/database/seeders/
2. اضغط Upload
3. اختر الملف:
   C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\database\seeders\DatabaseSeeder.php
4. انتظر حتى يكتمل الرفع
5. ستحل الملف الجديد محل القديم
```

---

### الطريقة 2: عبر FTP (FileZilla)

#### الخطوة 1: رفع setup_database_production.php
```
1. افتح FileZilla
2. اتصل بالسيرفر
3. في الجانب الأيمن (Remote): اذهب إلى /public_html/
4. في الجانب الأيسر (Local): اذهب إلى:
   C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\
5. اسحب ملف setup_database_production.php من اليسار إلى اليمين
```

#### الخطوة 2: رفع DatabaseSeeder.php
```
1. في الجانب الأيمن (Remote): اذهب إلى:
   /public_html/database/seeders/
2. في الجانب الأيسر (Local): اذهب إلى:
   C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\database\seeders\
3. اسحب ملف DatabaseSeeder.php من اليسار إلى اليمين
4. اختر "Overwrite" لاستبدال الملف القديم
```

---

## ✅ التحقق من الرفع الناجح:

### بعد رفع الملفات:

#### 1. تحقق من setup_database_production.php:
```
افتح في المتصفح:
https://www.alenwanapp.net/setup_database_production.php

يجب أن تظهر صفحة HTML جميلة باللغة العربية
```

#### 2. تحقق من DatabaseSeeder.php:
```
عبر cPanel File Manager أو FTP:
تأكد من أن الملف موجود في:
/public_html/database/seeders/DatabaseSeeder.php

تاريخ التعديل يجب أن يكون اليوم
```

---

## 🚀 بعد رفع الملفات:

### شغّل السكريبت:

```
1. افتح: https://www.alenwanapp.net/setup_database_production.php
2. أدخل المفتاح: Alenwan2025Setup!
3. اضغط "ابدأ الإعداد الآن"
4. انتظر 1-2 دقيقة
5. ستظهر رسائل النجاح الخضراء
6. احذف الملف: setup_database_production.php
```

---

## 📊 ماذا سيحدث عند تشغيل السكريبت؟

السكريبت سيقوم بـ:

### ✅ الخطوة 1: Migrations
- إنشاء جميع جداول قاعدة البيانات

### ✅ الخطوة 2: Categories
- أكشن
- دراما
- كوميديا
- رعب
- رومانسي
- وثائقي
- رياضة
- + المزيد...

### ✅ الخطوة 3: Languages
- العربية
- الإنجليزية
- الفرنسية
- الإسبانية
- + المزيد...

### ✅ الخطوة 4: Subscription Plans
- الخطة الشهرية ($9.99)
- الخطة السنوية ($99.99)

### ✅ الخطوة 5: Admin User
```
Email: admin@alenwan.com
Password: Alenwan@Admin2025!
```

### ✅ الخطوة 6: Sample Content
- 5 أفلام تجريبية
- 3 مسلسلات (15 حلقة)

### ✅ الخطوة 7: Pages
- من نحن
- سياسة الخصوصية
- الشروط والأحكام
- الدعم
- الأسئلة الشائعة
- اتصل بنا
- الميزات
- الأسعار

### ✅ الخطوة 8: Cache Clear
- مسح جميع الـ Cache

### ✅ الخطوة 9: Optimization
- تحسين الأداء

---

## ⚠️ ملاحظات مهمة:

### 1. الملفات المطلوب رفعها فقط:
```
✅ setup_database_production.php (جديد - لم يكن موجوداً)
✅ database/seeders/DatabaseSeeder.php (تحديث ملف موجود)
```

### 2. لا تحتاج لرفع:
```
❌ vendor/ (موجود مسبقاً)
❌ app/ (موجود مسبقاً)
❌ config/ (موجود مسبقاً)
```

### 3. بعد التشغيل:
```
⚠️ احذف: setup_database_production.php (للأمان!)
```

---

## 🆘 إذا واجهت مشاكل:

### المشكلة 1: "لا أستطيع فتح setup_database_production.php"

**الحل:**
```
تأكد من أن الملف في المكان الصحيح:
/public_html/setup_database_production.php

وليس:
/public_html/temp-laravel/setup_database_production.php
```

### المشكلة 2: "خطأ 500"

**الحل:**
```
تحقق من:
1. صلاحيات الملف (يجب أن تكون 644)
2. ملف .env موجود وصحيح
3. قاعدة البيانات موجودة
```

### المشكلة 3: "Class not found"

**الحل:**
```
تأكد من رفع DatabaseSeeder.php في المكان الصحيح:
/public_html/database/seeders/DatabaseSeeder.php
```

---

## 📞 خطوات سريعة (للنسخ واللصق):

```
1. افتح cPanel File Manager
2. اذهب إلى public_html
3. Upload → اختر setup_database_production.php
4. اذهب إلى database/seeders/
5. Upload → اختر DatabaseSeeder.php → Overwrite
6. افتح المتصفح
7. اذهب إلى: https://www.alenwanapp.net/setup_database_production.php
8. أدخل: Alenwan2025Setup!
9. اضغط "ابدأ الإعداد الآن"
10. انتظر حتى ترى: "🎉 تم إعداد قاعدة البيانات بنجاح!"
11. احذف setup_database_production.php
```

---

## ✅ قائمة التحقق:

- [ ] تم رفع setup_database_production.php
- [ ] تم رفع DatabaseSeeder.php
- [ ] تم فتح setup_database_production.php في المتصفح
- [ ] تم إدخال مفتاح الأمان
- [ ] تم الضغط على "ابدأ الإعداد الآن"
- [ ] ظهرت رسائل النجاح الخضراء
- [ ] تم اختبار /api/movies (يعيد بيانات)
- [ ] تم اختبار /api/categories (يعيد بيانات)
- [ ] تم اختبار /page/support (لا يعطي 404)
- [ ] تم حذف setup_database_production.php

---

**🚀 عند إتمام جميع النقاط أعلاه، Backend جاهز 100%!**

---

**آخر تحديث:** 2025-10-29
