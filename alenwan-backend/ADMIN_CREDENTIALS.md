# 🔐 بيانات تسجيل الدخول - Admin Account

## ✅ تم إنشاء الحساب بنجاح!

---

## 👤 معلومات الحساب الإداري

### بيانات تسجيل الدخول:

```
الاسم:         Admin
البريد:        admin@alenwan.com
كلمة المرور:    Admin@2025
الصلاحيات:     مدير (Admin)
الاشتراك:      Premium
```

---

## 🌐 روابط الدخول

### للتطوير المحلي:
```
URL: http://localhost:8000/admin
Email: admin@alenwan.com
Password: Admin@2025
```

### للسيرفر (بعد الرفع):
```
URL: https://api.alenwan.com/admin
Email: admin@alenwan.com
Password: Admin@2025
```

**⚠️ مهم:** غيّر كلمة المرور بعد أول تسجيل دخول!

---

## 🚀 كيفية تسجيل الدخول

### الطريقة 1: محلياً (Local)

1. شغّل السيرفر:
```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel
php artisan serve
```

2. افتح المتصفح:
```
http://localhost:8000/admin
```

3. أدخل البيانات:
```
Email: admin@alenwan.com
Password: Admin@2025
```

4. اضغط "تسجيل الدخول"

---

## 🔒 الأمان

### ⚠️ تحذيرات مهمة:

1. **لا تشارك هذا الملف** مع أحد
2. **غيّر كلمة المرور** فوراً بعد الرفع على السيرفر
3. **احذف هذا الملف** بعد حفظ البيانات في مكان آمن
4. **لا ترفع هذا الملف** على Git

### 🔐 كلمة مرور قوية موصى بها:

عند تغيير كلمة المرور، استخدم:
- 12 حرف على الأقل
- أحرف كبيرة وصغيرة
- أرقام ورموز
- مثال: `MyAl3nw@n$2025!Str0ng`

---

## 📝 تغيير كلمة المرور

### من لوحة التحكم:
1. سجل دخول
2. اذهب لـ Profile/Settings
3. غيّر كلمة المرور

### من Tinker:
```bash
php artisan tinker

$user = User::where('email', 'admin@alenwan.com')->first();
$user->password = bcrypt('NEW_PASSWORD_HERE');
$user->save();
```

---

## 👥 إنشاء مستخدمين إضافيين

### من لوحة التحكم:
بعد إنشاء Filament Resources للـ Users

### من Command Line:
```bash
php artisan admin:create

# أو من Tinker:
php artisan tinker

User::create([
    'name' => 'اسم المستخدم',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'is_admin' => true,
    'is_premium' => true,
]);
```

---

## 🛠️ استكشاف الأخطاء

### مشكلة: لا يمكن تسجيل الدخول

**الحل 1:** تأكد من البيانات
```bash
php artisan tinker
User::where('email', 'admin@alenwan.com')->first();
```

**الحل 2:** أعد إنشاء المستخدم
```bash
php artisan tinker
User::where('email', 'admin@alenwan.com')->delete();

User::create([
    'name' => 'Admin',
    'email' => 'admin@alenwan.com',
    'password' => bcrypt('Admin@2025'),
    'is_admin' => true,
    'is_premium' => true,
]);
```

**الحل 3:** امسح الكاش
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 📊 معلومات الحساب

```
User ID: سيتم توليده تلقائياً
Created: الآن
Permissions:
  ✓ Full Admin Access
  ✓ Premium Content
  ✓ Manage Users
  ✓ Manage Content
  ✓ View Statistics
  ✓ System Settings
```

---

## 🎯 الخطوات التالية

### بعد تسجيل الدخول:

1. ✅ غيّر كلمة المرور
2. ✅ أنشئ Filament Resources
3. ✅ أضف فئات
4. ✅ أضف محتوى تجريبي
5. ✅ اختبر جميع المميزات

---

## 📞 معلومات إضافية

### حسابات أخرى (إذا احتجت):

يمكنك إنشاء حسابات إضافية بنفس الطريقة:

**مدير ثاني:**
```
Email: manager@alenwan.com
Password: Manager@2025
```

**حساب تجريبي:**
```
Email: test@alenwan.com
Password: Test@2025
is_admin: false
is_premium: true
```

---

## ⚠️ تذكير مهم

**احذف هذا الملف بعد:**
1. حفظ البيانات في مكان آمن
2. تغيير كلمة المرور
3. تسجيل الدخول الناجح

**أو على الأقل:**
أضفه لـ `.gitignore` حتى لا يُرفع على Git

---

## 📋 ملخص سريع

```
✅ الحساب: تم إنشاؤه بنجاح
✅ البريد: admin@alenwan.com
✅ كلمة المرور: Admin@2025
✅ الصلاحيات: مدير كامل
✅ جاهز: للاستخدام الآن

🔗 الرابط: http://localhost:8000/admin
```

---

**🎉 مبروك! يمكنك الآن تسجيل الدخول والبدء في إدارة المحتوى!**

---

**تاريخ الإنشاء:** 28 أكتوبر 2025
**الحالة:** ✅ نشط وجاهز

