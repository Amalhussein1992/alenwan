# 🚀 دليل ربط تطبيق Flutter مع الباك اند

## 📋 نظرة عامة

هذا الدليل يشرح كيفية ربط تطبيق Flutter (Alenwan) مع Laravel Backend بشكل كامل.

---

## ✅ ما تم إنجازه في الباك اند

### 1. ✅ API Routes متكاملة
تم إنشاء ملف `routes/api.php` يحتوي على جميع الـ endpoints المطلوبة:
- إعدادات التطبيق
- اللغات
- الفئات
- الأفلام
- المسلسلات والحلقات
- البحث
- خطط الاشتراك
- الصفحة الرئيسية

### 2. ✅ دعم اللغات المتعددة
- جدول Languages يحتوي على: العربية، الإنجليزية، الفرنسية، وغيرها
- جميع المحتويات تحتوي على حقول عربية وإنجليزية:
  - `title_ar` / `title_en`
  - `description_ar` / `description_en`
  - `name_ar` / `name_en`

### 3. ✅ لوحة تحكم Filament كاملة
- إدارة الإعدادات (Settings)
- إدارة اللغات (Languages)
- إدارة المحتوى (Movies, Series, etc.)
- إدارة المستخدمين
- الإحصائيات

---

## 🌐 معلومات الـ API

### Base URLs:
```
Development: http://localhost:8000/api
Production:  https://api.alenwan.com/api
```

### تنسيق الاستجابة:
جميع الـ responses بصيغة JSON:
```json
{
  "success": true,
  "data": {...}
}
```

---

## 📱 خطوات الربط مع Flutter

### الخطوة 1: تثبيت المكتبات المطلوبة

في ملف `pubspec.yaml`:
```yaml
dependencies:
  flutter:
    sdk: flutter
  http: ^1.1.0           # للطلبات HTTP
  provider: ^6.1.1       # لإدارة الحالة
  shared_preferences: ^2.2.2  # للتخزين المحلي
  cached_network_image: ^3.3.0  # للصور
  flutter_localization: ^0.2.0  # للترجمة
```

ثم نفذ:
```bash
flutter pub get
```

---

### الخطوة 2: إنشاء API Service

أنشئ ملف `lib/services/api_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  // غيّر هذا الرابط حسب بيئتك
  static const String baseUrl = 'http://localhost:8000/api';

  // للإنتاج استخدم:
  // static const String baseUrl = 'https://api.alenwan.com/api';

  // Headers عامة
  static Map<String, String> get headers => {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  // ============================================
  // 1. إعدادات التطبيق واللغات
  // ============================================

  // جلب اللغات المتاحة
  static Future<List<dynamic>> getLanguages() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/config/languages'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load languages');
      }
    } catch (e) {
      print('Error fetching languages: $e');
      rethrow;
    }
  }

  // جلب إعدادات التطبيق
  static Future<Map<String, dynamic>> getSettings() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/config/settings'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load settings');
      }
    } catch (e) {
      print('Error fetching settings: $e');
      rethrow;
    }
  }

  // جلب البنرات
  static Future<List<dynamic>> getSliders() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/config/sliders'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load sliders');
      }
    } catch (e) {
      print('Error fetching sliders: $e');
      rethrow;
    }
  }

  // ============================================
  // 2. الفئات
  // ============================================

  static Future<List<dynamic>> getCategories() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/categories'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load categories');
      }
    } catch (e) {
      print('Error fetching categories: $e');
      rethrow;
    }
  }

  // ============================================
  // 3. الأفلام
  // ============================================

  static Future<Map<String, dynamic>> getMovies({
    int page = 1,
    int perPage = 20,
    int? categoryId,
    String? search,
    String sort = 'latest',
  }) async {
    try {
      // بناء الـ URL مع المعاملات
      var uri = Uri.parse('$baseUrl/movies');
      var queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
        'sort': sort,
      };

      if (categoryId != null) {
        queryParams['category_id'] = categoryId.toString();
      }

      if (search != null && search.isNotEmpty) {
        queryParams['search'] = search;
      }

      uri = uri.replace(queryParameters: queryParams);

      final response = await http.get(uri, headers: headers);

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load movies');
      }
    } catch (e) {
      print('Error fetching movies: $e');
      rethrow;
    }
  }

  // جلب فيلم واحد
  static Future<Map<String, dynamic>> getMovie(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/movies/$id'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load movie');
      }
    } catch (e) {
      print('Error fetching movie: $e');
      rethrow;
    }
  }

  // جلب الأفلام المميزة
  static Future<List<dynamic>> getFeaturedMovies() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/movies/featured/list'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load featured movies');
      }
    } catch (e) {
      print('Error fetching featured movies: $e');
      rethrow;
    }
  }

  // جلب الأفلام الرائجة
  static Future<List<dynamic>> getTrendingMovies() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/movies/trending/list'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load trending movies');
      }
    } catch (e) {
      print('Error fetching trending movies: $e');
      rethrow;
    }
  }

  // ============================================
  // 4. المسلسلات
  // ============================================

  static Future<Map<String, dynamic>> getSeries({
    int page = 1,
    int perPage = 20,
    int? categoryId,
    String? search,
  }) async {
    try {
      var uri = Uri.parse('$baseUrl/series');
      var queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };

      if (categoryId != null) {
        queryParams['category_id'] = categoryId.toString();
      }

      if (search != null && search.isNotEmpty) {
        queryParams['search'] = search;
      }

      uri = uri.replace(queryParameters: queryParams);

      final response = await http.get(uri, headers: headers);

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load series');
      }
    } catch (e) {
      print('Error fetching series: $e');
      rethrow;
    }
  }

  // جلب مسلسل واحد مع المواسم والحلقات
  static Future<Map<String, dynamic>> getSeriesDetails(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/series/$id'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load series details');
      }
    } catch (e) {
      print('Error fetching series details: $e');
      rethrow;
    }
  }

  // جلب حلقة واحدة
  static Future<Map<String, dynamic>> getEpisode(int episodeId) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/series/episodes/$episodeId'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load episode');
      }
    } catch (e) {
      print('Error fetching episode: $e');
      rethrow;
    }
  }

  // ============================================
  // 5. البحث
  // ============================================

  static Future<Map<String, dynamic>> search({
    required String query,
    String type = 'all', // all, movies, series
  }) async {
    try {
      final uri = Uri.parse('$baseUrl/search').replace(
        queryParameters: {
          'q': query,
          'type': type,
        },
      );

      final response = await http.get(uri, headers: headers);

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to search');
      }
    } catch (e) {
      print('Error searching: $e');
      rethrow;
    }
  }

  // ============================================
  // 6. خطط الاشتراك
  // ============================================

  static Future<List<dynamic>> getSubscriptionPlans() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/subscriptions/plans'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load subscription plans');
      }
    } catch (e) {
      print('Error fetching subscription plans: $e');
      rethrow;
    }
  }

  // ============================================
  // 7. الصفحة الرئيسية
  // ============================================

  static Future<Map<String, dynamic>> getHomeData() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/home'),
        headers: headers,
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'];
      } else {
        throw Exception('Failed to load home data');
      }
    } catch (e) {
      print('Error fetching home data: $e');
      rethrow;
    }
  }

  // ============================================
  // 8. فحص الاتصال
  // ============================================

  static Future<bool> ping() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/ping'),
        headers: headers,
      );

      return response.statusCode == 200;
    } catch (e) {
      print('Error pinging API: $e');
      return false;
    }
  }
}
```

---

### الخطوة 3: إنشاء Models

مثال: `lib/models/movie.dart`

```dart
class Movie {
  final int id;
  final String titleAr;
  final String titleEn;
  final String? descriptionAr;
  final String? descriptionEn;
  final String poster;
  final String? banner;
  final String videoUrl;
  final int? duration;
  final int? year;
  final double? rating;
  final int views;
  final bool isFeatured;
  final bool isPremium;

  Movie({
    required this.id,
    required this.titleAr,
    required this.titleEn,
    this.descriptionAr,
    this.descriptionEn,
    required this.poster,
    this.banner,
    required this.videoUrl,
    this.duration,
    this.year,
    this.rating,
    required this.views,
    required this.isFeatured,
    required this.isPremium,
  });

  factory Movie.fromJson(Map<String, dynamic> json) {
    return Movie(
      id: json['id'],
      titleAr: json['title_ar'] ?? '',
      titleEn: json['title_en'] ?? '',
      descriptionAr: json['description_ar'],
      descriptionEn: json['description_en'],
      poster: json['poster'] ?? '',
      banner: json['banner'],
      videoUrl: json['video_url'] ?? '',
      duration: json['duration'],
      year: json['year'],
      rating: json['rating']?.toDouble(),
      views: json['views'] ?? 0,
      isFeatured: json['is_featured'] ?? false,
      isPremium: json['is_premium'] ?? false,
    );
  }

  // للحصول على العنوان حسب اللغة
  String getTitle(String languageCode) {
    return languageCode == 'ar' ? titleAr : titleEn;
  }

  // للحصول على الوصف حسب اللغة
  String? getDescription(String languageCode) {
    return languageCode == 'ar' ? descriptionAr : descriptionEn;
  }
}
```

---

### الخطوة 4: استخدام API في الصفحات

مثال: `lib/screens/home_screen.dart`

```dart
import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/movie.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  bool isLoading = true;
  List<Movie> featuredMovies = [];
  List<Movie> trendingMovies = [];

  @override
  void initState() {
    super.initState();
    loadHomeData();
  }

  Future<void> loadHomeData() async {
    try {
      setState(() => isLoading = true);

      // جلب البيانات من API
      final homeData = await ApiService.getHomeData();

      // تحويل البيانات إلى Models
      setState(() {
        featuredMovies = (homeData['featured_movies'] as List)
            .map((json) => Movie.fromJson(json))
            .toList();

        trendingMovies = (homeData['trending_movies'] as List)
            .map((json) => Movie.fromJson(json))
            .toList();

        isLoading = false;
      });
    } catch (e) {
      print('Error loading home data: $e');
      setState(() => isLoading = false);

      // عرض رسالة خطأ للمستخدم
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('فشل في تحميل البيانات')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }

    return Scaffold(
      appBar: AppBar(title: Text('Alenwan')),
      body: SingleChildScrollView(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // البنرات
            _buildSliderSection(),

            // الأفلام المميزة
            _buildMovieSection('أفلام مميزة', featuredMovies),

            // الأفلام الرائجة
            _buildMovieSection('الأفلام الرائجة', trendingMovies),
          ],
        ),
      ),
    );
  }

  Widget _buildMovieSection(String title, List<Movie> movies) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Padding(
          padding: EdgeInsets.all(16),
          child: Text(
            title,
            style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
          ),
        ),
        SizedBox(
          height: 200,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            itemCount: movies.length,
            itemBuilder: (context, index) {
              final movie = movies[index];
              return GestureDetector(
                onTap: () {
                  // الانتقال لصفحة تفاصيل الفيلم
                },
                child: Container(
                  width: 150,
                  margin: EdgeInsets.only(left: 10),
                  child: Column(
                    children: [
                      Image.network(
                        movie.poster,
                        height: 150,
                        width: 150,
                        fit: BoxFit.cover,
                      ),
                      SizedBox(height: 5),
                      Text(
                        movie.getTitle('ar'),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ],
                  ),
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildSliderSection() {
    // تنفيذ البنرات هنا
    return Container();
  }
}
```

---

## 🌍 دعم اللغات المتعددة

### في Flutter:

```dart
class LanguageProvider extends ChangeNotifier {
  String _currentLanguage = 'ar'; // افتراضياً عربي

  String get currentLanguage => _currentLanguage;

  void changeLanguage(String languageCode) {
    _currentLanguage = languageCode;
    notifyListeners();
  }

  // استخدام هذا عند عرض المحتوى
  String getLocalizedText(String? arText, String? enText) {
    return _currentLanguage == 'ar' ? (arText ?? '') : (enText ?? '');
  }
}
```

---

## ✅ قائمة فحص التكامل

- [x] ✅ إنشاء API endpoints
- [x] ✅ دعم اللغات المتعددة
- [x] ✅ توثيق API
- [ ] ⏳ Authentication (تسجيل دخول/تسجيل)
- [ ] ⏳ User favorites
- [ ] ⏳ Watch history
- [ ] ⏳ Downloads management
- [ ] ⏳ Payment integration

---

## 🧪 اختبار التكامل

### 1. اختبار من المتصفح:
```
http://localhost:8000/api/ping
http://localhost:8000/api/config/languages
http://localhost:8000/api/categories
http://localhost:8000/api/movies
```

### 2. اختبار من Flutter:
```dart
void testApiConnection() async {
  bool isConnected = await ApiService.ping();
  print('API Connected: $isConnected');

  if (isConnected) {
    var languages = await ApiService.getLanguages();
    print('Languages: $languages');
  }
}
```

---

## 📞 الدعم

في حال واجهت مشاكل:
1. تأكد من تشغيل Laravel Server: `php artisan serve`
2. تحقق من الـ URL في ApiService
3. راجع ملف الـ logs: `storage/logs/laravel.log`
4. تأكد من الاتصال بالإنترنت

---

**آخر تحديث:** 28 أكتوبر 2025
