# 🎥 دليل إعداد Vimeo API - خطوة بخطوة

## ما هو Vimeo؟

Vimeo هي منصة استضافة فيديو احترافية تتيح لك رفع ومشاركة الفيديوهات بجودة عالية.

---

## 📝 الحصول على بيانات الاعتماد

### الخطوة 1: إنشاء حساب Vimeo

1. اذهب إلى: https://vimeo.com
2. اضغط على "Sign up" (التسجيل)
3. أنشئ حسابك المجاني

### الخطوة 2: الذهاب إلى صفحة المطورين

1. بعد تسجيل الدخول، اذهب إلى: https://developer.vimeo.com
2. اضغط على "My Apps" (تطبيقاتي)

### الخطوة 3: إنشاء تطبيق جديد

1. اضغط على "Create App" (إنشاء تطبيق)
2. املأ البيانات التالية:
   - **App Name**: Alenwan App
   - **App Description**: Streaming application
   - **App URL**: http://localhost:8000 (أو رابط موقعك)

3. وافق على الشروط واضغط "Create App"

### الخطوة 4: الحصول على بيانات الاعتماد

بعد إنشاء التطبيق، ستجد:

#### 1. Client Identifier (Client ID)
```
مثال: a1b2c3d4e5f6g7h8i9j0
```

#### 2. Client Secrets (Client Secret)
```
مثال: xyz123abc456def789
```

#### 3. إنشاء Access Token

1. في صفحة التطبيق، اضغط على تبويب "Authentication"
2. مرر للأسفل إلى قسم "Generate an Access Token"
3. اختر الصلاحيات (Scopes):
   - ✅ Public (قراءة المعلومات العامة)
   - ✅ Private (قراءة الفيديوهات الخاصة)
   - ✅ Upload (رفع فيديوهات)
   - ✅ Edit (تعديل فيديوهات)
   - ✅ Delete (حذف فيديوهات)

4. اضغط "Generate Token"
5. انسخ الـ Access Token الذي سيظهر

```
مثال: a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
```

**⚠️ مهم جداً:**
- احتفظ بهذه البيانات في مكان آمن
- لا تشاركها مع أحد
- لن تتمكن من رؤية Access Token مرة أخرى

---

## 🔧 إضافة البيانات للمشروع

### في ملف .env

افتح ملف `.env` في مشروع Laravel وأضف:

```env
VIMEO_CLIENT_ID=your_client_id_here
VIMEO_CLIENT_SECRET=your_client_secret_here
VIMEO_ACCESS_TOKEN=your_access_token_here
```

**مثال:**
```env
VIMEO_CLIENT_ID=a1b2c3d4e5f6g7h8i9j0
VIMEO_CLIENT_SECRET=xyz123abc456def789
VIMEO_ACCESS_TOKEN=a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
```

---

## 🎬 رفع فيديو إلى Vimeo

### الطريقة 1: من موقع Vimeo

1. سجل الدخول إلى Vimeo
2. اضغط "New video" (فيديو جديد)
3. اختر الملف من جهازك
4. انتظر حتى يتم الرفع
5. بعد الرفع، اذهب إلى الفيديو وانسخ:
   - **Video ID**: الموجود في الرابط (مثلاً: 123456789)
   - **Video URL**: https://vimeo.com/123456789

### الطريقة 2: من خلال API (متقدم)

```php
use App\Services\VimeoService;

$vimeo = new VimeoService();

// رفع فيديو
$response = $vimeo->client->upload('/path/to/video.mp4', [
    'name' => 'اسم الفيديو',
    'description' => 'وصف الفيديو',
    'privacy' => [
        'view' => 'anybody' // يمكن للجميع المشاهدة
    ]
]);
```

---

## 🔗 استخدام روابط Vimeo في المشروع

### الحصول على معلومات فيديو

1. لديك رابط Vimeo: `https://vimeo.com/123456789`
2. في لوحة تحكم Filament، أضف الفيلم:
   - **Vimeo URL**: https://vimeo.com/123456789
   - سيقوم النظام تلقائياً بجلب:
     - الصورة المصغرة
     - مدة الفيديو
     - رابط المشاهدة

### رابط المشاهدة للتطبيق

النظام سيحول رابط Vimeo تلقائياً إلى:
```
https://player.vimeo.com/video/123456789
```

هذا الرابط يمكن استخدامه مباشرة في تطبيق Flutter.

---

## 🔐 إعدادات الخصوصية

### للفيديوهات العامة:
```
Privacy: Anyone
```

### للفيديوهات الخاصة (للمشتركين فقط):
```
Privacy: Only people with a password
Password: your_secret_password
```

ثم أضف كلمة المرور في كود التطبيق عند الاتصال بالفيديو.

---

## 📊 حدود الخطة المجانية

### Vimeo Basic (مجاني):
- ✅ 500 MB مساحة تخزين أسبوعياً
- ✅ 5 GB مساحة تخزين إجمالية
- ✅ رفع فيديوهات حتى 500 MB لكل فيديو
- ❌ بدون شعار Vimeo على اللاعب

### Vimeo Plus (مدفوع - $7/شهر):
- ✅ 5 GB مساحة أسبوعياً
- ✅ 250 GB إجمالية
- ✅ إزالة شعار Vimeo
- ✅ تحليلات متقدمة

### للمشاريع الكبيرة:
- Vimeo Pro: $20/شهر
- Vimeo Business: $50/شهر

---

## 🧪 اختبار الاتصال

### في Terminal:

```bash
cd alenwan-backend/temp-laravel
php artisan tinker
```

ثم:

```php
$vimeo = new App\Services\VimeoService();
$video = $vimeo->getVideo('123456789');
print_r($video);
```

إذا ظهرت معلومات الفيديو، التكامل يعمل بنجاح! ✅

---

## ❓ حل المشاكل

### مشكلة: "Invalid access token"
**الحل:**
- تأكد من نسخ Access Token بشكل صحيح
- تأكد من أن Token لم ينتهي
- أعد إنشاء Token جديد

### مشكلة: "Insufficient scope"
**الحل:**
- عند إنشاء Token، اختر جميع الصلاحيات المطلوبة
- أعد إنشاء Token مع الصلاحيات الصحيحة

### مشكلة: "Rate limit exceeded"
**الحل:**
- انتظر قليلاً (Vimeo API لديها حد أقصى للطلبات)
- استخدم Cache لتقليل عدد الطلبات

---

## 📚 موارد إضافية

- **Vimeo Developer Docs**: https://developer.vimeo.com/api/reference
- **API Explorer**: https://developer.vimeo.com/api/playground
- **الدعم الفني**: https://vimeo.com/help

---

## ✅ قائمة التحقق

- [ ] إنشاء حساب Vimeo
- [ ] إنشاء تطبيق للمطورين
- [ ] الحصول على Client ID
- [ ] الحصول على Client Secret
- [ ] إنشاء Access Token
- [ ] إضافة البيانات إلى .env
- [ ] اختبار الاتصال
- [ ] رفع فيديو تجريبي
- [ ] اختبار في التطبيق

---

## 💡 نصيحة

ابدأ بخطة Vimeo المجانية للتجربة، ثم انتقل للخطة المدفوعة عند الحاجة لمساحة أكبر أو مميزات إضافية.

---

**تحتاج مساعدة؟**
راجع الملفات الأخرى في المشروع أو تواصل مع فريق الدعم الفني.

