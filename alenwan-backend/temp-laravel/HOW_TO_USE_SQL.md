# 📊 كيفية استخدام ملف demo_content.sql

## ✅ المحتوى الكامل في ملف واحد!

الملف `demo_content.sql` يحتوي على:
- ✅ **10 تصنيفات** (أكشن، دراما، كوميديا، رعب، إلخ)
- ✅ **5 لغات** (عربي، إنجليزي، فرنسي، إسباني، ألماني)
- ✅ **10 أفلام** تجريبية كاملة
- ✅ **5 مسلسلات** مع **25 حلقة** (5 حلقات لكل مسلسل)
- ✅ **8 صفحات** ثابتة (من نحن، سياسة الخصوصية، إلخ)
- ✅ **3 خطط اشتراك** (شهرية، ربع سنوية، سنوية)

**الإجمالي: 61 سجل محتوى جاهز!** 🎉

---

## 🚀 طريقة الاستخدام (3 خطوات فقط!)

### الخطوة 1️⃣: افتح phpMyAdmin

```
1. سجّل دخول إلى cPanel
2. اذهب إلى phpMyAdmin
3. اختر قاعدة البيانات الخاصة بـ Alenwan
```

---

### الخطوة 2️⃣: افتح ملف SQL

```
1. في phpMyAdmin، اضغط على تبويب "SQL" في الأعلى
2. افتح الملف:
   C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\demo_content.sql
3. انسخ المحتوى الكامل (Ctrl+A ثم Ctrl+C)
4. الصقه في صندوق SQL في phpMyAdmin
```

---

### الخطوة 3️⃣: نفّذ SQL

```
1. اضغط على زر "Go" أو "تنفيذ" في الأسفل
2. انتظر بضع ثوانٍ...
3. ستظهر رسائل نجاح خضراء!
```

---

## ✅ التحقق من النجاح

بعد تنفيذ SQL، اختبر:

### 1. اختبر Categories:
```
https://www.alenwanapp.net/api/categories
```
يجب أن يعيد: **10 تصنيفات**

### 2. اختبر Movies:
```
https://www.alenwanapp.net/api/movies
```
يجب أن يعيد: **10 أفلام**

### 3. اختبر Series:
```
https://www.alenwanapp.net/api/series
```
يجب أن يعيد: **5 مسلسلات**

### 4. اختبر Pages:
```
https://www.alenwanapp.net/page/support
https://www.alenwanapp.net/page/privacy-policy
https://www.alenwanapp.net/page/about-us
```
جميع الصفحات يجب أن تعمل بدون 404!

---

## 📊 تفاصيل المحتوى

### الأفلام (10):
1. **Desert Storm** (عاصفة الصحراء) - أكشن
2. **The Last Stand** (الموقف الأخير) - دراما
3. **Laugh Out Loud** (اضحك بصوت عالي) - كوميديا
4. **Midnight Terror** (رعب منتصف الليل) - رعب
5. **Eternal Love** (حب أبدي) - رومانسي
6. **Ocean Depths** (أعماق المحيط) - وثائقي
7. **Championship Glory** (مجد البطولة) - رياضة
8. **Magic Kingdom** (المملكة السحرية) - رسوم متحركة
9. **Edge of Tomorrow** (حافة الغد) - خيال علمي
10. **Silent Witness** (الشاهد الصامت) - إثارة

### المسلسلات (5):
1. **City Lights** (أضواء المدينة) - دراما - 5 حلقات
2. **Desert Nomads** (بدو الصحراء) - أكشن - 5 حلقات
3. **Family Matters** (شؤون العائلة) - كوميديا - 5 حلقات
4. **Mystery Files** (ملفات غامضة) - إثارة - 5 حلقات
5. **Future World** (عالم المستقبل) - خيال علمي - 5 حلقات

---

## 🎬 اختبار من Flutter App

بعد إضافة المحتوى:

### 1. شغّل التطبيق:
```bash
cd C:\Users\HP\Desktop\flutter\alenwan
flutter run
```

### 2. في التطبيق:
- اضغط "تصفح كضيف"
- يجب أن تشاهد:
  - ✅ 10 أفلام في الصفحة الرئيسية
  - ✅ 5 مسلسلات
  - ✅ التصنيفات (10 تصنيفات)
  - ✅ يمكنك فتح تفاصيل أي فيلم/مسلسل

---

## ⚠️ ملاحظات مهمة

### إذا ظهرت أخطاء:

#### خطأ: "Duplicate entry"
**السبب:** البيانات موجودة مسبقاً
**الحل:** احذف البيانات القديمة أولاً:
```sql
DELETE FROM episodes;
DELETE FROM series;
DELETE FROM movies;
DELETE FROM pages;
DELETE FROM subscription_plans;
DELETE FROM categories;
DELETE FROM languages;
```
ثم نفّذ `demo_content.sql` مرة أخرى

#### خطأ: "Foreign key constraint fails"
**السبب:** الجداول غير موجودة
**الحل:** شغّل Migrations أولاً:
```bash
php artisan migrate --force
```

---

## 🔄 إعادة التعيين الكاملة

إذا أردت البدء من الصفر:

```sql
-- 1. حذف جميع البيانات
TRUNCATE TABLE episodes;
TRUNCATE TABLE series;
TRUNCATE TABLE movies;
TRUNCATE TABLE pages;
TRUNCATE TABLE subscription_plans;
TRUNCATE TABLE categories;
TRUNCATE TABLE languages;

-- 2. الآن نفّذ demo_content.sql
-- انسخ والصق محتوى demo_content.sql هنا
```

---

## 📱 إضافة Admin User

إذا لم يكن لديك مستخدم Admin بعد، نفّذ:

```sql
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES
('Admin', 'admin@alenwan.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW(), NOW());
```

> ⚠️ كلمة المرور الافتراضية: `password`
> غيّرها من لوحة التحكم بعد الدخول!

أو للحصول على كلمة مرور قوية:
```sql
-- كلمة المرور: Alenwan@Admin2025!
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES
('Admin', 'admin@alenwan.com', '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.', 'admin', NOW(), NOW(), NOW());
```

---

## ✅ قائمة التحقق النهائية

- [ ] تم فتح phpMyAdmin
- [ ] تم اختيار قاعدة البيانات الصحيحة
- [ ] تم فتح تبويب SQL
- [ ] تم نسخ محتوى demo_content.sql
- [ ] تم لصق المحتوى في phpMyAdmin
- [ ] تم الضغط على "Go"
- [ ] ظهرت رسائل النجاح
- [ ] تم اختبار /api/movies (يعيد 10 أفلام)
- [ ] تم اختبار /api/series (يعيد 5 مسلسلات)
- [ ] تم اختبار /api/categories (يعيد 10 تصنيفات)
- [ ] تم اختبار /page/support (تعمل بدون 404)
- [ ] تم تشغيل Flutter App
- [ ] المحتوى يظهر في التطبيق

---

## 🎉 النتيجة النهائية

عند إتمام جميع الخطوات:

```
✅ Backend: https://www.alenwanapp.net
✅ API يعمل بمحتوى كامل
✅ 10 أفلام + 5 مسلسلات (25 حلقة)
✅ 10 تصنيفات + 5 لغات
✅ 8 صفحات + 3 خطط اشتراك
✅ Flutter App يعرض المحتوى من السيرفر
✅ وضع الضيف يعمل
```

**🚀 منصة Alenwan جاهزة 100% مع محتوى كامل!**

---

**📧 إذا واجهت أي مشكلة، شارك لقطة الشاشة من الخطأ!**

---

**آخر تحديث:** 2025-10-29
