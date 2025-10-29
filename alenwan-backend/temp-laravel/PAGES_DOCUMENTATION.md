# نظام إدارة الصفحات - ألوان

## نظرة عامة
تم إضافة نظام كامل لإدارة الصفحات الثابتة مثل (من نحن، الشروط والأحكام، سياسة الخصوصية، إلخ) مع دعم كامل للغتين العربية والإنجليزية.

---

## المميزات

### 1. لوحة التحكم (Filament)
✅ إدارة كاملة للصفحات من لوحة التحكم
✅ محرر نصوص غني (Rich Editor) للمحتوى
✅ دعم متعدد اللغات (عربي/إنجليزي)
✅ إمكانية رفع صور البانر
✅ ترتيب الصفحات بالسحب والإفلات
✅ تحكم في نشر/إخفاء الصفحات
✅ إضافة أيقونات للصفحات
✅ SEO مدمج (Meta Title, Description, Keywords)

### 2. API للتطبيق
✅ استرجاع جميع الصفحات المنشورة
✅ استرجاع صفحة واحدة بواسطة Slug
✅ استرجاع الصفحات حسب النوع
✅ صفحات القائمة (Menu)
✅ صفحات التذييل (Footer)
✅ بحث في الصفحات

---

## الوصول إلى لوحة التحكم

### الطريقة 1: Filament Panel (الموصى بها)
1. قم بتسجيل الدخول إلى لوحة التحكم:
   ```
   http://localhost:8000/admin
   ```

2. ستجد قسم "الصفحات" في القائمة الجانبية تحت "إدارة المحتوى"

3. يمكنك:
   - عرض جميع الصفحات
   - إضافة صفحة جديدة
   - تعديل الصفحات الموجودة
   - حذف الصفحات
   - ترتيب الصفحات

---

## API Endpoints

### 1. استرجاع جميع الصفحات
```http
GET /api/pages
```

**Query Parameters:**
- `type` - تصفية حسب النوع (about, terms, privacy, etc.)
- `menu` - إظهار صفحات القائمة فقط (true/false)
- `footer` - إظهار صفحات التذييل فقط (true/false)

**مثال:**
```bash
curl http://localhost:8000/api/pages
curl http://localhost:8000/api/pages?type=about
curl http://localhost:8000/api/pages?menu=true
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": {
        "ar": "من نحن",
        "en": "About Us"
      },
      "slug": "about-us",
      "type": "about",
      "icon": "fas fa-info-circle",
      "banner_image": "http://localhost:8000/storage/pages/banner.jpg",
      "order": 1,
      "show_in_menu": true,
      "show_in_footer": true,
      "meta_title": {...},
      "meta_description": {...}
    }
  ]
}
```

---

### 2. استرجاع صفحة واحدة بواسطة Slug
```http
GET /api/pages/{slug}
```

**مثال:**
```bash
curl http://localhost:8000/api/pages/about-us
curl http://localhost:8000/api/pages/privacy-policy
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": {
      "ar": "من نحن",
      "en": "About Us"
    },
    "slug": "about-us",
    "content": {
      "ar": "<h2>مرحباً بكم في ألوان</h2><p>...</p>",
      "en": "<h2>Welcome to Alenwan</h2><p>...</p>"
    },
    "type": "about",
    "icon": "fas fa-info-circle",
    "banner_image": "http://localhost:8000/storage/pages/banner.jpg",
    "meta_title": {...},
    "meta_description": {...},
    "meta_keywords": {...},
    "created_at": "2025-01-15T10:00:00Z",
    "updated_at": "2025-01-15T10:00:00Z"
  }
}
```

---

### 3. استرجاع الصفحات حسب النوع
```http
GET /api/pages/type/{type}
```

**الأنواع المتاحة:**
- `about` - من نحن
- `terms` - الشروط والأحكام
- `privacy` - سياسة الخصوصية
- `contact` - اتصل بنا
- `faq` - الأسئلة الشائعة
- `cancellation` - سياسة الإلغاء
- `refund` - سياسة الاسترداد
- `custom` - صفحة مخصصة

**مثال:**
```bash
curl http://localhost:8000/api/pages/type/terms
```

---

### 4. صفحات القائمة (Menu)
```http
GET /api/pages/menu
```

**مثال:**
```bash
curl http://localhost:8000/api/pages/menu
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": {"ar": "من نحن", "en": "About Us"},
      "slug": "about-us",
      "type": "about",
      "icon": "fas fa-info-circle",
      "order": 1
    }
  ]
}
```

---

### 5. صفحات التذييل (Footer)
```http
GET /api/pages/footer
```

**مثال:**
```bash
curl http://localhost:8000/api/pages/footer
```

---

### 6. البحث في الصفحات
```http
GET /api/pages/search?q={query}
```

**مثال:**
```bash
curl http://localhost:8000/api/pages/search?q=privacy
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 3,
      "title": {"ar": "سياسة الخصوصية", "en": "Privacy Policy"},
      "slug": "privacy-policy",
      "type": "privacy",
      "icon": "fas fa-shield-alt"
    }
  ]
}
```

---

## الصفحات الافتراضية

تم إضافة الصفحات التالية بشكل افتراضي:

1. **من نحن** (about-us)
   - يحتوي على معلومات عن المنصة والرؤية والمهمة

2. **الشروط والأحكام** (terms-conditions)
   - شروط استخدام الخدمة والاشتراك

3. **سياسة الخصوصية** (privacy-policy)
   - كيفية جمع واستخدام المعلومات الشخصية

4. **سياسة الإلغاء** (cancellation-policy)
   - كيفية إلغاء الاشتراك

5. **اتصل بنا** (contact-us)
   - معلومات التواصل ووسائل الاتصال

---

## استخدام الصفحات في Flutter

### مثال: عرض قائمة الصفحات
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

Future<List<Page>> fetchPages() async {
  final response = await http.get(
    Uri.parse('http://localhost:8000/api/pages?menu=true')
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return (data['data'] as List)
        .map((page) => Page.fromJson(page))
        .toList();
  } else {
    throw Exception('Failed to load pages');
  }
}
```

### مثال: عرض صفحة واحدة
```dart
Future<Page> fetchPage(String slug) async {
  final response = await http.get(
    Uri.parse('http://localhost:8000/api/pages/$slug')
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return Page.fromJson(data['data']);
  } else {
    throw Exception('Page not found');
  }
}
```

### مثال: عرض محتوى HTML في Flutter
```dart
import 'package:flutter_html/flutter_html.dart';

Widget buildPageContent(String htmlContent) {
  return Html(
    data: htmlContent,
    style: {
      "h2": Style(fontSize: FontSize(24)),
      "p": Style(fontSize: FontSize(16)),
    },
  );
}
```

---

## إضافة صفحة جديدة من لوحة التحكم

1. انتقل إلى **الصفحات** في لوحة التحكم
2. اضغط على **إضافة صفحة جديدة**
3. املأ الحقول التالية:
   - **نوع الصفحة**: اختر النوع المناسب
   - **الرابط (Slug)**: سيتم إنشاؤه تلقائياً أو أدخله يدوياً
   - **الأيقونة**: أيقونة Font Awesome (مثل: fas fa-info-circle)
   - **الترتيب**: رقم الترتيب

4. في تبويب **العربية**:
   - العنوان بالعربية
   - المحتوى بالعربية
   - وصف SEO

5. في تبويب **English**:
   - العنوان بالإنجليزية
   - المحتوى بالإنجليزية
   - وصف SEO

6. ارفع **صورة البانر** (اختياري)

7. حدد خيارات النشر:
   - ✅ منشور
   - ✅ عرض في القائمة
   - ✅ عرض في التذييل

8. اضغط **حفظ**

---

## الملفات المضافة

### Controllers
- `app/Http/Controllers/Admin/PagesController.php` - Controller للوحة التحكم
- `app/Http/Controllers/Api/PageController.php` - API Controller

### Models
- `app/Models/Page.php` - Model للصفحات (موجود مسبقاً)

### Filament Resources
- `app/Filament/Resources/PageResource.php` - Filament Resource

### Migrations
- `database/migrations/2025_10_28_201857_create_pages_table.php`

### Seeders
- `database/seeders/PagesSeeder.php` - بيانات تجريبية

### Views (اختياري)
- `resources/views/admin/pages/index.blade.php`
- `resources/views/admin/pages/create.blade.php`
- `resources/views/admin/pages/edit.blade.php`

### Routes
- `routes/web.php` - Routes للوحة التحكم
- `routes/api.php` - API Routes

---

## نصائح وأفضل الممارسات

1. **استخدم Slug واضح**: استخدم slugs واضحة وسهلة التذكر مثل `about-us` بدلاً من `page-1`

2. **SEO**: املأ دائماً Meta Title و Meta Description لتحسين محركات البحث

3. **الصور**: استخدم صور بحجم مناسب (1920x600 للبانر)

4. **المحتوى**: استخدم HTML نظيف ومنظم

5. **الترتيب**: استخدم أرقام الترتيب بفارق 10 (10, 20, 30) لسهولة إعادة الترتيب لاحقاً

6. **الاختبار**: اختبر الصفحات في كلا اللغتين قبل النشر

---

## الأسئلة الشائعة

**س: كيف أضيف نوع صفحة جديد؟**
ج: قم بتحديث الـ enum في migration وأضف النوع في `Page::getTypes()`

**س: كيف أحذف صفحة؟**
ج: الحذف هو Soft Delete، يمكن استعادة الصفحة لاحقاً

**س: هل يمكن إضافة المزيد من اللغات؟**
ج: نعم، قم بتحديث Model لإضافة اللغات الجديدة في `$translatable`

**س: كيف أخفي صفحة من القائمة؟**
ج: قم بإلغاء تفعيل "عرض في القائمة" من إعدادات الصفحة

---

## الدعم

للمزيد من المساعدة، تواصل مع فريق التطوير.
