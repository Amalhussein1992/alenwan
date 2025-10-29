# 🚀 تحديثات Flutter App - الاتصال بالسيرفر

## ✅ التحديثات التي تم تنفيذها

### 1️⃣ تحديث API URL ليشير إلى السيرفر الحقيقي

**الملف:** `lib/config.dart`

**التغييرات:**
```dart
// تم تغيير من:
static const bool isProduction = false;

// إلى:
static const bool isProduction = true;

// الآن التطبيق يستخدم:
static const String productionDomain = "https://www.alenwanapp.net";
```

---

### 2️⃣ تفعيل وضع الضيف (Guest Mode)

#### في `lib/config.dart`:
```dart
// تمت إضافة:
static const bool enableGuestMode = true; // السماح بالدخول كضيف
```

#### في `lib/views/auth/login_screen.dart`:
تمت إضافة زر "تصفح كضيف" في شاشة تسجيل الدخول:

```dart
// Guest Mode Button
TextButton.icon(
  onPressed: () {
    // Navigate to main app as guest
    Navigator.pushReplacementNamed(context, AppRoutes.main);
  },
  icon: const Icon(Icons.visibility_outlined, size: 20),
  label: const Text('تصفح كضيف'),
  style: TextButton.styleFrom(
    foregroundColor: ProfessionalTheme.primaryBrand,
    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
    shape: RoundedRectangleBorder(
      borderRadius: BorderRadius.circular(ProfessionalTheme.radiusM),
      side: BorderSide(
        color: ProfessionalTheme.primaryBrand.withOpacity(0.5),
      ),
    ),
  ),
),
```

---

## 🎯 كيف يعمل التطبيق الآن؟

### عند تشغيل التطبيق:

1. **شاشة تسجيل الدخول تظهر 4 خيارات:**
   - ✅ تسجيل الدخول بالبريد الإلكتروني
   - ✅ تسجيل الدخول بـ Google
   - ✅ تسجيل الدخول بالهاتف
   - ✅ **تصفح كضيف** (جديد! 🆕)

2. **عند الضغط على "تصفح كضيف":**
   - ينتقل المستخدم مباشرة إلى الصفحة الرئيسية
   - يستطيع مشاهدة جميع المحتوى المتاح
   - يستطيع تصفح الأفلام والمسلسلات
   - يمكنه تشغيل الفيديوهات التجريبية

3. **التطبيق متصل بالسيرفر:**
   ```
   https://www.alenwanapp.net/api
   ```

---

## 📋 خطوات التشغيل

### 1️⃣ تشغيل سكريبت إعداد قاعدة البيانات (إذا لم يتم بعد):

أولاً يجب رفع وتشغيل السكريبت على السيرفر:

1. **ارفع الملف:**
   ```
   setup_database_production.php
   ```

2. **افتح في المتصفح:**
   ```
   https://www.alenwanapp.net/setup_database_production.php
   ```

3. **أدخل مفتاح الأمان:** `Alenwan2025Setup!`

4. **اضغط "ابدأ الإعداد الآن"**

5. **انتظر حتى تكتمل العملية** (1-2 دقيقة)

6. **⚠️ احذف الملف بعد الانتهاء!**

---

### 2️⃣ تشغيل Flutter App:

```bash
# اذهب إلى مجلد المشروع
cd C:\Users\HP\Desktop\flutter\alenwan

# تثبيت Dependencies (إذا لزم)
flutter pub get

# تشغيل التطبيق
flutter run
```

---

## 🧪 اختبار التطبيق

### ✅ الاختبارات المطلوبة:

#### 1. **اختبار الاتصال بالسيرفر:**
- شغّل التطبيق
- يجب أن يتصل بـ `https://www.alenwanapp.net/api`

#### 2. **اختبار وضع الضيف:**
- في شاشة تسجيل الدخول
- اضغط على "تصفح كضيف"
- يجب أن ينتقل للصفحة الرئيسية

#### 3. **اختبار عرض المحتوى:**
- في الصفحة الرئيسية
- يجب أن تظهر:
  - ✅ 5 أفلام تجريبية
  - ✅ 3 مسلسلات
  - ✅ الفئات والتصنيفات

#### 4. **اختبار تشغيل الفيديو:**
- اضغط على أي فيلم أو مسلسل
- يجب أن يفتح المشغل
- (الفيديوهات التجريبية تشير إلى YouTube placeholder)

---

## 📊 المحتوى التجريبي المتوفر

بعد تشغيل السكريبت على السيرفر، سيكون لديك:

### الأفلام (Movies):
- Sample Movie 1
- Sample Movie 2
- Sample Movie 3
- Sample Movie 4
- Sample Movie 5

### المسلسلات (Series):
- Sample Series 1 (5 حلقات)
- Sample Series 2 (5 حلقات)
- Sample Series 3 (5 حلقات)

### التصنيفات (Categories):
- أكشن
- دراما
- كوميديا
- رعب
- رومانسي
- وثائقي
- رياضة
- وأكثر...

### اللغات (Languages):
- العربية
- الإنجليزية
- الفرنسية
- الإسبانية
- وأكثر...

---

## 🔧 حل المشاكل المحتملة

### المشكلة 1: "لا يوجد محتوى للعرض"

**السبب:** قاعدة البيانات على السيرفر فارغة

**الحل:**
1. شغّل `setup_database_production.php` على السيرفر
2. تأكد من اكتمال جميع الخطوات بنجاح

---

### المشكلة 2: "خطأ في الاتصال بالسيرفر"

**الحل:**
```dart
// تحقق من ملف lib/config.dart
static const bool isProduction = true; // يجب أن يكون true
static const String productionDomain = "https://www.alenwanapp.net";
```

---

### المشكلة 3: "زر تصفح كضيف لا يعمل"

**الحل:**
- تأكد من أن الملف `lib/views/auth/login_screen.dart` تم تحديثه
- أعد تشغيل التطبيق: `flutter run`

---

### المشكلة 4: "الفيديوهات لا تعمل"

**ملاحظة:** الفيديوهات التجريبية الحالية تشير إلى روابط placeholder

**لإضافة فيديوهات حقيقية:**
1. ادخل لوحة التحكم Admin:
   ```
   https://www.alenwanapp.net/admin
   Email: admin@alenwan.com
   Password: Alenwan@Admin2025!
   ```
2. حدّث روابط الفيديو للأفلام والمسلسلات
3. استخدم روابط Vimeo أو YouTube أو روابط مباشرة

---

## 🎬 إضافة محتوى حقيقي

### عبر لوحة التحكم Admin:

1. **سجّل دخول:**
   ```
   https://www.alenwanapp.net/admin
   Email: admin@alenwan.com
   Password: Alenwan@Admin2025!
   ```

2. **أضف أفلام جديدة:**
   - اذهب إلى Movies
   - اضغط "Create"
   - أدخل معلومات الفيلم
   - أضف رابط الفيديو الحقيقي
   - احفظ

3. **أضف مسلسلات:**
   - اذهب إلى Series
   - أنشئ مسلسل جديد
   - أضف الحلقات
   - احفظ

4. **أضف صور وملصقات:**
   - ارفع الصور عبر Admin Panel
   - أو استخدم روابط خارجية

---

## 📱 نشر التطبيق

### لبناء APK للأندرويد:

```bash
# بناء APK
flutter build apk --release

# الملف سيكون في:
# build/app/outputs/flutter-apk/app-release.apk
```

### لبناء IPA للـ iOS:

```bash
# بناء IPA
flutter build ios --release

# (يتطلب Mac و Xcode)
```

---

## ✅ قائمة التحقق النهائية

### على السيرفر:
- [ ] تم رفع Backend على `https://www.alenwanapp.net`
- [ ] تم تشغيل `setup_database_production.php`
- [ ] قاعدة البيانات تحتوي على محتوى تجريبي
- [ ] الـ Admin Panel يعمل
- [ ] الـ API endpoints تعمل

### في Flutter App:
- [ ] تم تحديث `lib/config.dart`
- [ ] `isProduction = true`
- [ ] تم إضافة زر "تصفح كضيف"
- [ ] تم تشغيل `flutter pub get`
- [ ] تم اختبار التطبيق
- [ ] وضع الضيف يعمل
- [ ] المحتوى يظهر من السيرفر

---

## 🎉 النتيجة النهائية

عند اكتمال جميع الخطوات:

✅ **Backend يعمل على:** `https://www.alenwanapp.net`
✅ **Flutter App متصل بالسيرفر**
✅ **وضع الضيف مفعّل**
✅ **المحتوى التجريبي جاهز**
✅ **المستخدمون يستطيعون تصفح المحتوى بدون تسجيل دخول**

**🚀 مبروك! التطبيق جاهز للعمل والاختبار!**

---

## 📞 الملفات المُحدَّثة

```
✅ lib/config.dart - تحديث API URL وتفعيل Guest Mode
✅ lib/views/auth/login_screen.dart - إضافة زر تصفح كضيف
```

---

## 🔄 الخطوة التالية

1. **شغّل السكريبت على السيرفر** (إذا لم يتم بعد)
2. **شغّل Flutter App**
3. **جرّب وضع الضيف**
4. **تحقق من ظهور المحتوى**
5. **أضف محتوى حقيقي عبر Admin Panel**

---

**تاريخ التحديث:** 2025-10-29
**الحالة:** ✅ جاهز للاختبار
