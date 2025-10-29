# 📦 دليل ضغط ورفع المشروع على السيرفر

## ✅ الملفات الجاهزة للنشر

جميع الملفات المطلوبة موجودة في المجلد:
```
C:\Users\HP\Desktop\flutter\alenwan-backend\temp-laravel\
```

---

## 📋 الخطوة 1: الملفات التي يجب ضغطها

### ✅ الملفات المطلوبة (يجب تضمينها):
```
✓ app/                  - كود التطبيق
✓ bootstrap/            - ملفات التشغيل
✓ config/              - إعدادات Laravel
✓ database/            - Migrations & Seeders
✓ public/              - الملفات العامة
✓ resources/           - Views & Assets
✓ routes/              - ملفات التوجيه
✓ storage/             - مجلد التخزين
✓ vendor/              - مكتبات PHP (مهم جداً!)
✓ .htaccess.root       - ملف Apache
✓ artisan              - أداة Laravel CLI
✓ composer.json        - تبعيات PHP
✓ composer.lock        - نسخ التبعيات
✓ .env.production.example - مثال الإعدادات

✓ START_DEPLOYMENT_HERE.md       - دليل البدء السريع
✓ DEPLOYMENT_GUIDE.md            - الدليل الشامل
✓ QUICK_DEPLOYMENT_CHECKLIST.md - قائمة التحقق
```

### ❌ الملفات التي يجب استثناؤها (لا تضغطها):
```
✗ .env                 - يحتوي معلومات محلية
✗ .git/                - ملفات Git (إن وجدت)
✗ node_modules/        - مكتبات Node (إن وجدت)
✗ storage/logs/*.log   - ملفات اللوج القديمة
✗ *.md (عدا الأدلة)    - ملفات التوثيق غير الضرورية
```

---

## 💻 الخطوة 2: طريقة الضغط

### طريقة 1: استخدام Windows Explorer (الأسهل)

1. **افتح المجلد:**
   ```
   C:\Users\HP\Desktop\flutter\alenwan-backend\
   ```

2. **انقر بزر الماوس الأيمن على مجلد `temp-laravel`**

3. **اختر: Send to → Compressed (zipped) folder**

4. **سمّ الملف المضغوط:**
   ```
   alenwan-backend.zip
   ```

5. **✅ تم! الآن لديك ملف zip جاهز للرفع**

---

### طريقة 2: استخدام WinRAR/7-Zip (أفضل للملفات الكبيرة)

#### باستخدام WinRAR:
1. انقر بزر الماوس الأيمن على مجلد `temp-laravel`
2. اختر: **Add to archive...**
3. في نافذة الإعدادات:
   - Archive name: `alenwan-backend.rar` أو `.zip`
   - Archive format: **ZIP** (للتوافق مع جميع السيرفرات)
   - Compression method: **Normal**
4. اضغط **OK**

#### باستخدام 7-Zip:
1. انقر بزر الماوس الأيمن على مجلد `temp-laravel`
2. اختر: **7-Zip → Add to archive...**
3. في نافذة الإعدادات:
   - Archive format: **zip**
   - Compression level: **Normal**
4. اضغط **OK**

---

## 📊 حجم الملف المتوقع

بعد الضغط، يجب أن يكون حجم الملف:
- **مع vendor/**: حوالي 40-60 MB
- **بدون vendor/**: حوالي 5-10 MB

> **ملاحظة:** إذا كان السيرفر يدعم Composer، يمكنك حذف مجلد `vendor/` قبل الضغط، وتشغيل `composer install` على السيرفر.

---

## 🌐 الخطوة 3: رفع الملف على السيرفر

### الطريقة 1: عبر cPanel File Manager

1. **سجل دخول إلى cPanel**
   ```
   https://yourdomain.com:2083
   ```

2. **افتح File Manager**

3. **اذهب إلى public_html**

4. **اضغط Upload في الأعلى**

5. **اسحب ملف `alenwan-backend.zip` وأفلته**
   - أو اضغط **Select File** واختر الملف

6. **انتظر حتى يكتمل الرفع** (قد يستغرق 5-15 دقيقة)

7. **✅ تم رفع الملف!**

---

### الطريقة 2: عبر FTP (FileZilla)

1. **حمّل FileZilla Client** إذا لم يكن لديك:
   - https://filezilla-project.org/download.php?type=client

2. **افتح FileZilla وأدخل معلومات الاتصال:**
   ```
   Host: ftp.yourdomain.com
   Username: your_ftp_username
   Password: your_ftp_password
   Port: 21
   ```

3. **اضغط Quickconnect**

4. **في الجانب الأيمن (Remote site)، اذهب إلى:**
   ```
   /public_html/
   ```

5. **في الجانب الأيسر (Local site)، اذهب إلى:**
   ```
   C:\Users\HP\Desktop\flutter\alenwan-backend\
   ```

6. **اسحب ملف `alenwan-backend.zip` من الجانب الأيسر إلى الأيمن**

7. **انتظر حتى يكتمل الرفع**

8. **✅ تم!**

---

### الطريقة 3: عبر SSH/SCP (للمحترفين)

```bash
# من PowerShell أو Command Prompt
scp C:\Users\HP\Desktop\flutter\alenwan-backend\alenwan-backend.zip root@your_server_ip:/var/www/

# أو باستخدام WinSCP (واجهة رسومية)
```

---

## 📦 الخطوة 4: فك الضغط على السيرفر

### في cPanel File Manager:

1. **في File Manager، حدد ملف `alenwan-backend.zip`**

2. **اضغط Extract في الأعلى**

3. **اختر المسار:** `/public_html/`

4. **اضغط Extract File(s)**

5. **✅ تم فك الضغط!**

---

### في Terminal (SSH):

```bash
cd /var/www/
unzip alenwan-backend.zip
mv temp-laravel alenwan-backend
```

---

## 🔧 الخطوة 5: بعد الرفع

بعد رفع وفك ضغط الملفات، اتبع الخطوات في:

### 📘 للمبتدئين (cPanel):
**افتح:** `START_DEPLOYMENT_HERE.md` - القسم A

### 📗 للمحترفين (VPS):
**افتح:** `START_DEPLOYMENT_HERE.md` - القسم B

---

## ✅ قائمة تحقق ما بعد الرفع

- [ ] تم رفع الملف على السيرفر
- [ ] تم فك الضغط بنجاح
- [ ] جميع المجلدات موجودة (app, config, public, etc.)
- [ ] مجلد vendor/ موجود (أو جاهز لتشغيل composer install)
- [ ] ملف .htaccess.root موجود
- [ ] أدلة النشر موجودة (START_DEPLOYMENT_HERE.md, etc.)

---

## 🆘 مشاكل شائعة

### المشكلة 1: "الملف كبير جداً للرفع"
**الحل:**
- ارفع بدون مجلد `vendor/`
- بعد الرفع، شغّل: `composer install --no-dev`

### المشكلة 2: "فشل الرفع بعد فترة"
**الحل:**
- استخدم FTP بدلاً من cPanel Upload
- أو قسّم المشروع لعدة ملفات zip

### المشكلة 3: "لا أستطيع فك الضغط"
**الحل:**
- تأكد من صلاحيات المجلد
- أو استخدم SSH: `unzip alenwan-backend.zip`

---

## 📞 الخطوة التالية

بعد إتمام الرفع بنجاح:

➡️ **افتح:** `START_DEPLOYMENT_HERE.md`
➡️ **اختر:** القسم A (cPanel) أو B (VPS)
➡️ **اتبع:** الخطوات خطوة بخطوة

---

## 🎯 معلومات مهمة

### بيانات الدخول الافتراضية:
```
Admin Email: admin@alenwan.com
Admin Password: Alenwan@Admin2025!
Database Password: Alenwan@2025SecurePass!
```

### ملفات الإعداد:
- `.env.production.example` - نموذج إعدادات الإنتاج
- `.htaccess.root` - إعدادات Apache
- `public/robots.txt` - إعدادات SEO

---

**🚀 بالتوفيق! المشروع جاهز 100% للنشر!**

---

**تاريخ آخر تحديث:** 2025-10-29
