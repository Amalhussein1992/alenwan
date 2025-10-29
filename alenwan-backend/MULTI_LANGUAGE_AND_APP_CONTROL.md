# 🌍 دليل اللغات المتعددة والتحكم الكامل بالتطبيق

## ✅ تم إضافة جدولين جديدين قويين جداً!

---

## 📊 الجداول الجديدة

### 1. **Languages (اللغات)** 🌍

**الوصف:** نظام لغات متعدد مرن يدعم أي عدد من اللغات.

**الأعمدة (11):**
```php
✓ id
✓ name - الاسم بالإنجليزية (Arabic, English, French)
✓ native_name - الاسم باللغة الأصلية (العربية, English, Français)
✓ code - كود اللغة (ar, en, fr, es, de, etc.)
✓ flag - العلم (🇸🇦, 🇺🇸, 🇫🇷 أو مسار صورة)
✓ direction - الاتجاه (ltr أو rtl)
✓ is_default - اللغة الافتراضية
✓ is_active - نشط
✓ order - الترتيب
✓ timestamps
```

**اللغات المدعومة:**
```
🇸🇦 العربية (ar) - RTL - افتراضية
🇺🇸 English (en) - LTR
🇫🇷 Français (fr) - LTR
🇪🇸 Español (es) - LTR
🇩🇪 Deutsch (de) - LTR
🇹🇷 Türkçe (tr) - LTR
🇮🇹 Italiano (it) - LTR
🇵🇹 Português (pt) - LTR
🇷🇺 Русский (ru) - LTR
🇨🇳 中文 (zh) - LTR
🇯🇵 日本語 (ja) - LTR
🇰🇷 한국어 (ko) - LTR
```

**المميزات:**
- ✅ دعم أي عدد من اللغات
- ✅ تحديد اللغة الافتراضية
- ✅ دعم RTL و LTR
- ✅ أعلام اللغات (Emoji أو صور)
- ✅ تفعيل/تعطيل اللغات
- ✅ ترتيب قابل للتخصيص

---

### 2. **App Configs (إعدادات التطبيق)** ⚙️

**الوصف:** **التحكم الكامل** بكل شيء في التطبيق من الباك اند!

**الأقسام الرئيسية:**

#### 📱 معلومات التطبيق (7 حقول)
```
✓ app_name - اسم التطبيق
✓ app_version - النسخة (1.0.0)
✓ api_version - نسخة API
✓ app_description - وصف التطبيق
✓ app_logo - شعار التطبيق
✓ app_icon - أيقونة التطبيق
✓ splash_screen - شاشة البداية
```

#### 🎨 الألوان والثيم (6 حقول)
```
✓ primary_color - اللون الأساسي (#FF5722)
✓ secondary_color - اللون الثانوي (#FFC107)
✓ accent_color - لون التركيز (#03A9F4)
✓ background_color - لون الخلفية
✓ text_color - لون النص
✓ dark_mode_enabled - تفعيل الوضع الليلي
```

#### 🎯 التحكم بالمميزات (11 حقل)
```
✓ registration_enabled - تفعيل التسجيل
✓ social_login_enabled - تسجيل دخول اجتماعي
✓ guest_mode_enabled - وضع الضيف
✓ download_enabled - تفعيل التحميل
✓ sharing_enabled - تفعيل المشاركة
✓ comments_enabled - تفعيل التعليقات
✓ ratings_enabled - تفعيل التقييمات
✓ watchlist_enabled - قائمة المشاهدة
✓ continue_watching_enabled - متابعة المشاهدة
✓ search_enabled - البحث
✓ filters_enabled - الفلاتر
```

#### 📺 التحكم بالمحتوى (6 حقول)
```
✓ movies_enabled - تفعيل الأفلام
✓ series_enabled - تفعيل المسلسلات
✓ live_tv_enabled - تفعيل التلفزيون المباشر
✓ podcasts_enabled - تفعيل البودكاست
✓ featured_content_limit - حد المحتوى المميز (10)
✓ home_categories_limit - حد الفئات في الرئيسية (5)
```

#### 💳 الاشتراكات (4 حقول)
```
✓ free_content_enabled - محتوى مجاني
✓ premium_content_enabled - محتوى Premium
✓ free_trial_enabled - تجربة مجانية
✓ free_trial_days - عدد أيام التجربة (7)
```

#### ▶️ مشغل الفيديو (7 حقول)
```
✓ auto_play_next - تشغيل تلقائي للتالي
✓ skip_intro_enabled - تخطي المقدمة
✓ skip_intro_duration - مدة المقدمة (90 ثانية)
✓ video_qualities - الجودات المتاحة (JSON)
✓ default_quality - الجودة الافتراضية (auto)
✓ subtitles_enabled - الترجمات
✓ pip_mode_enabled - وضع الصورة في صورة
```

#### 🔔 الإشعارات (4 حقول)
```
✓ push_notifications_enabled - إشعارات Push
✓ email_notifications_enabled - إشعارات Email
✓ new_content_notification - إشعار محتوى جديد
✓ subscription_expiry_notification - إشعار انتهاء الاشتراك
```

#### 📢 الإعلانات (6 حقول)
```
✓ ads_enabled - تفعيل الإعلانات
✓ ad_network - شبكة الإعلانات (admob, facebook)
✓ banner_ad_id - معرف إعلان البنر
✓ interstitial_ad_id - معرف الإعلان البيني
✓ rewarded_ad_id - معرف إعلان المكافأة
✓ ads_frequency - تكرار الإعلانات (كل X دقائق)
```

#### 🔗 روابط التواصل (7 حقول)
```
✓ facebook_url
✓ twitter_url
✓ instagram_url
✓ youtube_url
✓ support_email
✓ support_phone
✓ website_url
```

#### 📜 الصفحات القانونية (4 حقول)
```
✓ terms_of_service - شروط الخدمة
✓ privacy_policy - سياسة الخصوصية
✓ about_us - من نحن
✓ contact_info - معلومات الاتصال
```

#### 🔧 الصيانة والتحديثات (6 حقول)
```
✓ maintenance_mode - وضع الصيانة
✓ maintenance_message - رسالة الصيانة
✓ minimum_app_version - الحد الأدنى لنسخة التطبيق
✓ force_update - إجبار التحديث
✓ update_message - رسالة التحديث
✓ update_url - رابط التحديث
```

**الإجمالي: 70+ حقل للتحكم الكامل!**

---

## 🎯 كيفية استخدام App Configs

### السيناريو 1: تغيير ألوان التطبيق
```
1. افتح "إعدادات التطبيق" من لوحة التحكم
2. اذهب لقسم "الألوان والثيم"
3. غيّر primary_color إلى #E91E63 (وردي)
4. غيّر secondary_color إلى #9C27B0 (بنفسجي)
5. احفظ
6. التطبيق سيتحديث تلقائياً عند فتحه!
```

### السيناريو 2: تعطيل ميزة التعليقات
```
1. افتح "إعدادات التطبيق"
2. اذهب لقسم "التحكم بالمميزات"
3. أوقف comments_enabled
4. احفظ
5. زر التعليقات سيختفي من التطبيق فوراً!
```

### السيناريو 3: وضع الصيانة
```
1. افتح "إعدادات التطبيق"
2. اذهب لقسم "الصيانة"
3. فعّل maintenance_mode
4. اكتب رسالة: "التطبيق تحت الصيانة، نعتذر عن الإزعاج"
5. احفظ
6. جميع المستخدمين سيرون شاشة الصيانة!
```

### السيناريو 4: إجبار التحديث
```
1. افتح "إعدادات التطبيق"
2. minimum_app_version = "1.2.0"
3. force_update = true
4. update_message = "نسخة جديدة متاحة! حدّث الآن"
5. update_url = "https://play.google.com/store/apps/..."
6. المستخدمون بنسخ قديمة سيُجبرون على التحديث!
```

### السيناريو 5: تفعيل الإعلانات
```
1. افتح "إعدادات التطبيق"
2. ads_enabled = true
3. ad_network = "admob"
4. banner_ad_id = "ca-app-pub-xxxxx"
5. ads_frequency = 5 (كل 5 دقائق)
6. الإعلانات ستظهر في التطبيق!
```

---

## 🌐 API Endpoints

### للحصول على إعدادات التطبيق:

```http
GET /api/app-config

Response:
{
  "success": true,
  "data": {
    "app_name": "Alenwan",
    "app_version": "1.0.0",
    "primary_color": "#FF5722",
    "secondary_color": "#FFC107",
    "dark_mode_enabled": true,
    "features": {
      "registration_enabled": true,
      "download_enabled": true,
      "comments_enabled": false,
      "ratings_enabled": true,
      ...
    },
    "video_player": {
      "auto_play_next": true,
      "skip_intro_enabled": true,
      "skip_intro_duration": 90,
      "video_qualities": ["360p", "480p", "720p", "1080p"],
      "default_quality": "auto"
    },
    "ads": {
      "enabled": false,
      "network": null,
      ...
    },
    "maintenance": {
      "mode": false,
      "message": null
    }
  }
}
```

### للحصول على اللغات المتاحة:

```http
GET /api/languages

Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Arabic",
      "native_name": "العربية",
      "code": "ar",
      "flag": "🇸🇦",
      "direction": "rtl",
      "is_default": true,
      "is_active": true
    },
    {
      "id": 2,
      "name": "English",
      "native_name": "English",
      "code": "en",
      "flag": "🇺🇸",
      "direction": "ltr",
      "is_default": false,
      "is_active": true
    }
  ]
}
```

---

## 📱 كيف يعمل في Flutter

### 1. جلب الإعدادات عند بدء التطبيق:
```dart
class AppConfigService {
  static AppConfig? _config;

  static Future<void> init() async {
    final response = await http.get('/api/app-config');
    _config = AppConfig.fromJson(response.data);

    // تطبيق الألوان
    ThemeData theme = ThemeData(
      primaryColor: Color(_config!.primaryColor),
      secondary Color: Color(_config!.secondaryColor),
    );

    // التحقق من الصيانة
    if (_config!.maintenanceMode) {
      navigateToMaintenancePage();
    }

    // التحقق من النسخة
    if (_config!.forceUpdate &&
        currentAppVersion < _config!.minimumAppVersion) {
      navigateToUpdatePage();
    }
  }
}
```

### 2. استخدام الإعدادات في التطبيق:
```dart
// إخفاء/إظهار مميزات حسب الإعدادات
if (AppConfig.instance.downloadEnabled) {
  IconButton(
    icon: Icon(Icons.download),
    onPressed: () => downloadMovie(),
  )
}

if (AppConfig.instance.commentsEnabled) {
  CommentsWidget()
}

if (AppConfig.instance.ratingsEnabled) {
  RatingWidget()
}
```

### 3. اختيار اللغة:
```dart
class LanguageSelector extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      itemCount: languages.length,
      itemBuilder: (context, index) {
        final lang = languages[index];
        return ListTile(
          leading: Text(lang.flag),
          title: Text(lang.nativeName),
          onTap: () => changeLanguage(lang.code),
        );
      },
    );
  }
}
```

---

## 🔧 إعداد MySQL

### الخطوة 1: تحديث ملف .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alenwan
DB_USERNAME=root
DB_PASSWORD=your_password
```

### الخطوة 2: إنشاء قاعدة البيانات

```sql
CREATE DATABASE alenwan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### الخطوة 3: تشغيل Migrations

```bash
# مسح الكاش أولاً
php artisan config:clear
php artisan cache:clear

# تشغيل Migrations
php artisan migrate:fresh

# أو إذا كانت البيانات موجودة بالفعل
php artisan migrate
```

### الخطوة 4: إنشاء Admin

```bash
php artisan admin:create
```

### الخطوة 5: إضافة بيانات أولية للغات

```bash
php artisan tinker

# إضافة العربية
Language::create([
    'name' => 'Arabic',
    'native_name' => 'العربية',
    'code' => 'ar',
    'flag' => '🇸🇦',
    'direction' => 'rtl',
    'is_default' => true,
    'is_active' => true,
    'order' => 1
]);

# إضافة الإنجليزية
Language::create([
    'name' => 'English',
    'native_name' => 'English',
    'code' => 'en',
    'flag' => '🇺🇸',
    'direction' => 'ltr',
    'is_default' => false,
    'is_active' => true,
    'order' => 2
]);

# إضافة إعدادات التطبيق الافتراضية
AppConfig::create([
    'app_name' => 'Alenwan',
    'app_version' => '1.0.0',
    'primary_color' => '#FF5722',
    'secondary_color' => '#FFC107',
    'dark_mode_enabled' => true,
    'registration_enabled' => true,
    'movies_enabled' => true,
    'series_enabled' => true,
    // ... باقي الحقول تأخذ القيم الافتراضية
]);
```

---

## 📊 الإحصائيات النهائية

```
الجداول: 15 جدول (+2)
الأعمدة: 230+ عمود (+80)
Resources: 12 resource (+2)
التحكم الكامل: ✅
دعم لغات متعددة: ✅
```

---

## ✅ الخلاصة

**الآن يمكنك التحكم بـ:**

✅ **كل شيء في التطبيق** من الباك اند بدون تحديث التطبيق!
✅ **الألوان والثيم** - غيّرها متى شئت
✅ **المميزات** - فعّل أو عطّل أي ميزة
✅ **المحتوى** - تحكم بأنواع المحتوى المعروض
✅ **الإعلانات** - تحكم كامل بالإعلانات
✅ **الصيانة** - وضع صيانة بضغطة زر
✅ **التحديثات** - إجبار المستخدمين على التحديث
✅ **اللغات** - دعم أي عدد من اللغات
✅ **الاشتراكات** - تحكم بالتجربة المجانية
✅ **مشغل الفيديو** - كل الإعدادات قابلة للتخصيص

---

**🎉 الآن لديك تحكم 100% في التطبيق من الباك اند! 🎉**

**تاريخ الإنشاء:** 28 أكتوبر 2025
