# ⚡ الخطوة التالية العاجلة

## 🎯 الوضع الحالي

✅ **Backend مرفوع بنجاح على:** `https://www.alenwanapp.net/`
✅ **الصفحة الرئيسية تعمل** بشكل ممتاز!
✅ **SSL/HTTPS مفعّل**

⚠️ **لكن:** قاعدة البيانات فارغة ويحتاج إلى إعداد!

---

## 🚀 الخطوة التالية (5 دقائق فقط!)

### الطريقة الأسهل والأسرع:

#### 1️⃣ ارفع هذا الملف على السيرفر:
```
setup_database_production.php
```

**كيف؟**
- عبر cPanel File Manager
- أو عبر FTP
- ضعه في نفس المجلد الذي يحتوي على ملف `artisan`

---

#### 2️⃣ افتح المتصفح واذهب إلى:
```
https://www.alenwanapp.net/setup_database_production.php
```

---

#### 3️⃣ أدخل مفتاح الأمان:
```
Alenwan2025Setup!
```

---

#### 4️⃣ اضغط "ابدأ الإعداد الآن"

انتظر 1-2 دقيقة... سيقوم السكريبت بـ:
- ✅ إنشاء جداول قاعدة البيانات
- ✅ إضافة التصنيفات واللغات
- ✅ إضافة خطط الاشتراك
- ✅ إنشاء مستخدم Admin
- ✅ إضافة 5 أفلام تجريبية
- ✅ إضافة 3 مسلسلات (15 حلقة)
- ✅ تحسين الأداء

---

#### 5️⃣ بعد الانتهاء - احذف الملف!
```
❌ احذف: setup_database_production.php
```
(مهم للأمان!)

---

## ✅ اختبر النتيجة:

### بعد تشغيل السكريبت، افتح:

1. **Admin Panel:**
   ```
   https://www.alenwanapp.net/admin

   Email: admin@alenwan.com
   Password: Alenwan@Admin2025!
   ```

2. **API Movies:**
   ```
   https://www.alenwanapp.net/api/movies
   ```
   يجب أن تشاهد 5 أفلام!

3. **API Categories:**
   ```
   https://www.alenwanapp.net/api/categories
   ```
   يجب أن تشاهد قائمة التصنيفات!

---

## 📱 بعد ذلك: حدّث Flutter App

في ملف `lib/config/api_config.dart`:

```dart
static const String baseUrl = 'https://www.alenwanapp.net/api';
```

---

## 🎉 ثم...

**🚀 مبروك! منصة Alenwan جاهزة 100%!**

---

## 📋 الملفات المهمة:

- ✅ `setup_database_production.php` - السكريبت الرئيسي (ارفعه أولاً!)
- 📖 `DATABASE_SETUP_INSTRUCTIONS.md` - دليل مفصل (للمساعدة إذا احتجت)

---

**⏱️ الوقت المتوقع: 5-10 دقائق فقط!**
