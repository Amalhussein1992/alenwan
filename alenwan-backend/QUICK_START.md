# 🚀 Quick Start Guide - Alenwan Backend

## البدء السريع - 5 دقائق فقط!

### الخطوة 1: التحضير
```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel
```

### الخطوة 2: نسخ ملف البيئة
```bash
# إذا لم يكن موجوداً
copy .env.example .env
```

### الخطوة 3: تعديل ملف .env
افتح `.env` وأضف بيانات Vimeo:

```env
VIMEO_CLIENT_ID=your_client_id_here
VIMEO_CLIENT_SECRET=your_secret_here
VIMEO_ACCESS_TOKEN=your_token_here
```

### الخطوة 4: إنشاء مستخدم إداري
```bash
php artisan admin:create
```

أدخل:
- الاسم: Admin
- البريد: admin@alenwan.com
- كلمة المرور: password

### الخطوة 5: تشغيل السيرفر
```bash
php artisan serve
```

### الخطوة 6: الدخول للوحة التحكم
افتح المتصفح: http://localhost:8000/admin

سجل الدخول بالبيانات التي أدخلتها في الخطوة 4

---

## ✅ تم! الآن ماذا؟

### إنشاء صفحات الإدارة

```bash
# صفحة الفئات
php artisan make:filament-resource Category --generate

# صفحة الأفلام
php artisan make:filament-resource Movie --generate --soft-deletes

# صفحة المسلسلات
php artisan make:filament-resource Series --generate --soft-deletes
```

بعد كل أمر، قم بتحديث المتصفح وستجد القائمة الجديدة في لوحة التحكم!

---

## 🎬 إضافة محتوى تجريبي

### 1. إضافة فئة:
في لوحة التحكم → Categories → New
- Name (AR): أكشن
- Name (EN): Action
- Slug: action
- اضغط Create

### 2. إضافة فيلم:
في لوحة التحكم → Movies → New
- Title (AR): فيلم تجريبي
- Title (EN): Test Movie
- Category: اختر أكشن
- Video URL: https://player.vimeo.com/video/123456789
- اضغط Create

---

## 📱 ربطه بتطبيق Flutter

### إنشاء API Endpoints

أنشئ ملف: `routes/api.php`

```php
use App\Models\Category;
use App\Models\Movie;

Route::get('/categories', function () {
    return Category::where('is_active', true)
        ->orderBy('order')
        ->get();
});

Route::get('/movies', function () {
    return Movie::with('category')
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->paginate(20);
});

Route::get('/movies/{id}', function ($id) {
    return Movie::with('category')->findOrFail($id);
});
```

### اختبار API

افتح: http://localhost:8000/api/categories

---

## 🔥 نصائح سريعة

### تنظيف الكاش
```bash
php artisan optimize:clear
```

### رؤية الأخطاء
```bash
# في ملف .env
APP_DEBUG=true
```

### تغيير اللغة
```bash
# في ملف .env
APP_LOCALE=ar      # عربي
APP_LOCALE=en      # إنجليزي
```

---

## ❓ مشاكل شائعة

### المشكلة: لا يمكن تسجيل الدخول
**الحل:**
```bash
php artisan migrate:fresh
php artisan admin:create
```

### المشكلة: صفحة بيضاء
**الحل:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### المشكلة: خطأ في الصلاحيات
**الحل:**
```bash
# في Git Bash أو PowerShell
chmod -R 775 storage bootstrap/cache
```

---

## 📚 المزيد من المعلومات

- **الدليل الكامل بالعربي**: [LARAVEL_FILAMENT_GUIDE_AR.md](LARAVEL_FILAMENT_GUIDE_AR.md)
- **التفاصيل التقنية**: [FILAMENT_SETUP_COMPLETE.md](FILAMENT_SETUP_COMPLETE.md)
- **الملف الرئيسي**: [README.md](README.md)

---

## 🎉 تهانينا!

لديك الآن نظام إدارة محتوى متكامل جاهز للاستخدام!

**الخطوات التالية:**
1. ✅ أضف بيانات تجريبية
2. ✅ اختبر النظام
3. ✅ أنشئ API للتطبيق
4. ✅ اربطه مع Flutter

**تحتاج مساعدة؟**
راجع الملفات الموثقة في المجلد.

