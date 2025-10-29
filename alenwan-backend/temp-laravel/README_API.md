# ألوان API - Documentation 🎬

> منصة البث الأولى للمحتوى العربي والعالمي

## 🚀 Quick Start

### Base URL
```
Development: http://localhost:8000/api
Production:  https://api.alenwan.com/api
```

---

## 🔐 Authentication Endpoints

### Register
```http
POST /auth/register
Content-Type: application/json

{
  "name": "User Name",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+966501234567"
}
```

### Login (Email/Password)
```http
POST /auth/login

{
  "email": "user@example.com",
  "password": "password123"
}
```

### Login with Google ✅
```http
POST /auth/login/google

{
  "google_id": "google-user-id",
  "email": "user@gmail.com",
  "name": "User Name",
  "avatar": "https://..."
}
```

### Login with Phone (OTP) ✅
```http
# Step 1: Send OTP
POST /auth/login/phone
{
  "phone": "+966501234567"
}

# Step 2: Verify OTP
POST /auth/login/phone/verify
{
  "phone": "+966501234567",
  "otp": "1234",
  "name": "User Name"
}
```

### Login as Guest ✅
```http
POST /auth/login/guest

{
  "device_id": "unique-device-id"
}
```

### Delete Account ✅
```http
DELETE /auth/delete-account
Authorization: Bearer {token}

{
  "password": "user_password"
}
```

### Other Auth Endpoints
```http
POST   /auth/logout              # Logout
GET    /auth/profile             # Get profile
PUT    /auth/profile             # Update profile
POST   /auth/convert-guest       # Convert guest to user
POST   /auth/change-password     # Change password
```

---

## 📄 Pages Endpoints

### Get All Pages
```http
GET /pages
GET /pages?type=about
GET /pages?menu=true
GET /pages?footer=true
```

### Get Single Page
```http
GET /pages/{slug}

Example: GET /pages/about-us
```

### Get Menu/Footer Pages
```http
GET /pages/menu
GET /pages/footer
```

### Search Pages
```http
GET /pages/search?q=privacy
```

---

## 🎬 Content Endpoints

### Movies
```http
GET /movies                    # List all movies
GET /movies/{id}              # Get single movie
GET /movies/trending          # Trending movies
GET /movies/latest            # Latest movies
```

### Series
```http
GET /series                   # List all series
GET /series/{id}             # Get single series
GET /series/{id}/seasons/{season_id}/episodes
```

### Categories
```http
GET /categories              # List all categories
GET /categories/{id}/content # Content by category
```

---

## ⚙️ Config Endpoints

```http
GET /config/settings         # App settings
GET /config/languages        # Available languages
GET /config/sliders          # Banners/Sliders
```

---

## 📱 Available Pages

| Page | Slug | Type |
|------|------|------|
| من نحن | `about-us` | about |
| الميزات | `features` | features |
| الأسعار | `pricing` | pricing |
| الدعم الفني | `support` | support |
| الأسئلة الشائعة | `faq` | faq |
| اتصل بنا | `contact-us` | contact |
| الشروط والأحكام | `terms-conditions` | terms |
| سياسة الخصوصية | `privacy-policy` | privacy |
| سياسة الإلغاء | `cancellation-policy` | cancellation |

---

## 🔑 Authentication

All protected endpoints require Bearer token:

```http
Authorization: Bearer YOUR_TOKEN_HERE
```

Get token from login/register response:
```json
{
  "success": true,
  "data": {
    "user": {...},
    "token": "your-token-here"
  }
}
```

---

## 📊 Response Format

### Success Response
```json
{
  "success": true,
  "data": {
    "key": "value"
  },
  "message": "Operation successful"
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Validation error"]
  }
}
```

---

## 🌍 Multi-Language Support

All content supports Arabic and English:

```json
{
  "title": {
    "ar": "العنوان بالعربية",
    "en": "Title in English"
  },
  "content": {
    "ar": "المحتوى بالعربية",
    "en": "Content in English"
  }
}
```

---

## 📚 Documentation Files

- **PAGES_DOCUMENTATION.md** - دليل إدارة الصفحات
- **FLUTTER_INTEGRATION_GUIDE.md** - دليل التكامل الشامل مع Flutter
- **COMPLETE_IMPLEMENTATION_SUMMARY.md** - ملخص كامل للتنفيذ

---

## 🛠️ Admin Panel

Access Filament admin panel:
```
http://localhost:8000/admin
```

Features:
- ✅ إدارة الصفحات
- ✅ إدارة المحتوى
- ✅ إحصائيات الأرباح
- ✅ إدارة المستخدمين
- ✅ إدارة الاشتراكات

---

## 📞 Support

- **Email:** support@alenwan.com
- **Phone:** +966 50 123 4567
- **Hours:** Sunday - Thursday (9 AM - 6 PM)

---

## 🎯 Features

- ✅ Multi-language (Arabic/English)
- ✅ Google Sign-In
- ✅ Phone OTP Authentication
- ✅ Guest Mode
- ✅ Account Deletion
- ✅ Static Pages Management
- ✅ Revenue Analytics
- ✅ RESTful API
- ✅ Secure Authentication (Sanctum)

---

**Version:** 1.1.0
**Last Updated:** 2025-10-28
**Status:** Production Ready ✅
