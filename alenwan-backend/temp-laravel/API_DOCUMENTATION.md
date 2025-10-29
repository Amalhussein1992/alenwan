# 🚀 Alenwan API Documentation

## 📋 Base Information

- **Base URL (Development):** `http://localhost:8000/api`
- **Base URL (Production):** `https://api.alenwan.com/api`
- **Response Format:** JSON
- **Language Support:** Arabic (ar) & English (en)
- **Date:** October 28, 2025

---

## 🌐 API Endpoints

### 1. App Configuration & Settings

#### 1.1 Get All Settings
```
GET /api/config/settings
```

**Response:**
```json
{
  "success": true,
  "data": {
    "general": [...],
    "app": [...],
    "payment": [...],
    "theme": [...]
  }
}
```

#### 1.2 Get Languages
```
GET /api/config/languages
```

**Response:**
```json
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
      "is_active": true,
      "order": 1
    }
  ]
}
```

#### 1.3 Get Sliders/Banners
```
GET /api/config/sliders
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Welcome Banner",
      "image": "https://...",
      "link": "/movie/123",
      "order": 1
    }
  ]
}
```

---

### 2. Categories

#### 2.1 Get All Categories
```
GET /api/categories
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name_ar": "أكشن",
      "name_en": "Action",
      "slug": "action",
      "icon": "🎬",
      "order": 1
    }
  ]
}
```

#### 2.2 Get Single Category
```
GET /api/categories/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name_ar": "أكشن",
    "name_en": "Action",
    "slug": "action",
    "icon": "🎬",
    "description_ar": "...",
    "description_en": "..."
  }
}
```

---

### 3. Movies

#### 3.1 Get All Movies (Paginated)
```
GET /api/movies?page=1&per_page=20
```

**Query Parameters:**
- `page` (optional): Page number (default: 1)
- `per_page` (optional): Items per page (default: 20)
- `category_id` (optional): Filter by category
- `search` (optional): Search query
- `sort` (optional): Sort by (latest, popular, rating)

**Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title_ar": "فيلم رائع",
        "title_en": "Amazing Movie",
        "description_ar": "...",
        "description_en": "...",
        "poster": "https://...",
        "banner": "https://...",
        "video_url": "https://player.vimeo.com/video/...",
        "trailer_url": "https://...",
        "duration": 120,
        "year": 2024,
        "rating": 8.5,
        "views": 1500,
        "is_featured": true,
        "is_premium": false,
        "category": {
          "id": 1,
          "name_ar": "أكشن",
          "name_en": "Action"
        }
      }
    ],
    "total": 50,
    "per_page": 20,
    "last_page": 3
  }
}
```

#### 3.2 Get Single Movie
```
GET /api/movies/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title_ar": "فيلم رائع",
    "title_en": "Amazing Movie",
    "description_ar": "...",
    "description_en": "...",
    "poster": "https://...",
    "banner": "https://...",
    "video_url": "https://player.vimeo.com/video/...",
    "trailer_url": "https://...",
    "duration": 120,
    "year": 2024,
    "rating": 8.5,
    "views": 1501,
    "is_featured": true,
    "is_premium": false,
    "cast": ["Actor 1", "Actor 2"],
    "director": "Director Name",
    "category": {...}
  }
}
```

**Note:** This endpoint automatically increments the view count.

#### 3.3 Get Featured Movies
```
GET /api/movies/featured/list
```

**Response:**
```json
{
  "success": true,
  "data": [...]
}
```

#### 3.4 Get Trending Movies
```
GET /api/movies/trending/list
```

**Response:**
```json
{
  "success": true,
  "data": [...]
}
```

---

### 4. Series

#### 4.1 Get All Series (Paginated)
```
GET /api/series?page=1&per_page=20
```

**Query Parameters:**
- `page` (optional): Page number
- `per_page` (optional): Items per page
- `category_id` (optional): Filter by category
- `search` (optional): Search query

**Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title_ar": "مسلسل رائع",
        "title_en": "Amazing Series",
        "poster": "https://...",
        "rating": 9.0,
        "year": 2024,
        "total_seasons": 3,
        "category": {...}
      }
    ],
    "total": 30,
    "per_page": 20
  }
}
```

#### 4.2 Get Single Series (with Seasons & Episodes)
```
GET /api/series/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title_ar": "مسلسل رائع",
    "title_en": "Amazing Series",
    "description_ar": "...",
    "description_en": "...",
    "poster": "https://...",
    "banner": "https://...",
    "rating": 9.0,
    "year": 2024,
    "views": 5000,
    "category": {...},
    "seasons": [
      {
        "id": 1,
        "season_number": 1,
        "title_ar": "الموسم الأول",
        "title_en": "Season 1",
        "episodes": [
          {
            "id": 1,
            "episode_number": 1,
            "title_ar": "الحلقة الأولى",
            "title_en": "Episode 1",
            "video_url": "https://...",
            "duration": 45,
            "views": 1200
          }
        ]
      }
    ]
  }
}
```

#### 4.3 Get Episodes of Specific Season
```
GET /api/series/{series_id}/seasons/{season_id}/episodes
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "episode_number": 1,
      "title_ar": "الحلقة الأولى",
      "title_en": "Episode 1",
      "description_ar": "...",
      "description_en": "...",
      "video_url": "https://...",
      "duration": 45,
      "views": 1200
    }
  ]
}
```

#### 4.4 Get Single Episode
```
GET /api/series/episodes/{episode_id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "episode_number": 1,
    "title_ar": "الحلقة الأولى",
    "title_en": "Episode 1",
    "description_ar": "...",
    "description_en": "...",
    "video_url": "https://...",
    "thumbnail": "https://...",
    "duration": 45,
    "views": 1201,
    "season": {
      "id": 1,
      "season_number": 1,
      "series": {
        "id": 1,
        "title_ar": "مسلسل رائع",
        "title_en": "Amazing Series"
      }
    }
  }
}
```

---

### 5. Search

#### 5.1 Global Search
```
GET /api/search?q=action&type=all
```

**Query Parameters:**
- `q` (required): Search query
- `type` (optional): Search type (all, movies, series) - default: all

**Response:**
```json
{
  "success": true,
  "query": "action",
  "data": {
    "movies": [
      {
        "id": 1,
        "title_ar": "فيلم أكشن",
        "title_en": "Action Movie",
        "poster": "https://...",
        "rating": 8.5,
        "year": 2024
      }
    ],
    "series": [
      {
        "id": 1,
        "title_ar": "مسلسل أكشن",
        "title_en": "Action Series",
        "poster": "https://...",
        "rating": 9.0,
        "year": 2024
      }
    ]
  }
}
```

---

### 6. Subscription Plans

#### 6.1 Get All Plans
```
GET /api/subscriptions/plans
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name_ar": "باقة شهرية",
      "name_en": "Monthly Plan",
      "description_ar": "...",
      "description_en": "...",
      "price": 9.99,
      "currency": "USD",
      "duration_days": 30,
      "features": ["HD Quality", "Multiple Devices", "No Ads"],
      "is_popular": true,
      "is_active": true
    }
  ]
}
```

#### 6.2 Get Single Plan
```
GET /api/subscriptions/plans/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name_ar": "باقة شهرية",
    "name_en": "Monthly Plan",
    "price": 9.99,
    ...
  }
}
```

---

### 7. Home Page / Dashboard

#### 7.1 Get Home Page Data
```
GET /api/home
```

**Response:**
```json
{
  "success": true,
  "data": {
    "sliders": [...],
    "featured_movies": [...],
    "trending_movies": [...],
    "latest_series": [...],
    "categories": [...]
  }
}
```

**Note:** This endpoint returns all data needed for the app home screen in a single request.

---

### 8. Health Check

#### 8.1 Ping API
```
GET /api/ping
```

**Response:**
```json
{
  "success": true,
  "message": "Alenwan API is running",
  "timestamp": "2025-10-28T10:30:00.000000Z",
  "version": "1.0.0"
}
```

---

## 🔐 Authentication (Coming Soon)

Authentication endpoints will be added for:
- User registration
- Login
- Password reset
- Profile management
- Favorites
- Watch history
- Downloads

---

## 📱 Integration with Flutter App

### Example: Fetching Movies in Flutter

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'http://localhost:8000/api';

  Future<List<Movie>> getMovies({int page = 1}) async {
    final response = await http.get(
      Uri.parse('$baseUrl/movies?page=$page'),
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return (data['data']['data'] as List)
          .map((movie) => Movie.fromJson(movie))
          .toList();
    } else {
      throw Exception('Failed to load movies');
    }
  }

  Future<List<Language>> getLanguages() async {
    final response = await http.get(
      Uri.parse('$baseUrl/config/languages'),
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return (data['data'] as List)
          .map((lang) => Language.fromJson(lang))
          .toList();
    } else {
      throw Exception('Failed to load languages');
    }
  }
}
```

---

## 📊 Response Structure

All API responses follow this structure:

### Success Response
```json
{
  "success": true,
  "data": {...}
}
```

### Error Response (Coming Soon)
```json
{
  "success": false,
  "message": "Error message here",
  "errors": {...}
}
```

---

## 🌍 Multi-Language Support

All content has Arabic and English fields:
- `title_ar` / `title_en`
- `description_ar` / `description_en`
- `name_ar` / `name_en`

The app should display content based on user's selected language.

---

## 🔄 Pagination

Paginated endpoints return:
```json
{
  "current_page": 1,
  "data": [...],
  "first_page_url": "...",
  "last_page": 5,
  "last_page_url": "...",
  "next_page_url": "...",
  "per_page": 20,
  "prev_page_url": null,
  "total": 100
}
```

---

## ✅ Testing API Endpoints

### Using curl:
```bash
# Test ping
curl http://localhost:8000/api/ping

# Get languages
curl http://localhost:8000/api/config/languages

# Get movies
curl http://localhost:8000/api/movies

# Search
curl "http://localhost:8000/api/search?q=action"
```

### Using Postman:
1. Import the base URL: `http://localhost:8000/api`
2. Create requests for each endpoint
3. Test with different parameters

---

## 🚀 Next Steps

1. ✅ API Routes Created
2. ✅ Language Support Added
3. ✅ Multi-language Content Support
4. ⏳ Add Authentication (JWT or Sanctum)
5. ⏳ Add User Favorites
6. ⏳ Add Watch History
7. ⏳ Add Download Management
8. ⏳ Add Payment Integration

---

## 📞 Support

For API issues or questions, check:
- Admin Panel: `http://localhost:8000/admin`
- Log files: `storage/logs/laravel.log`

---

**Last Updated:** October 28, 2025
**Version:** 1.0.0
