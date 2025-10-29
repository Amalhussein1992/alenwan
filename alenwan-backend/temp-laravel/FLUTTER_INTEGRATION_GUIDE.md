# دليل التكامل الشامل - Flutter مع Laravel Backend

## نظرة عامة
هذا الدليل الشامل يوضح كيفية ربط تطبيق Flutter (alenwan) مع Laravel Backend بشكل كامل.

---

## 🔐 المصادقة (Authentication)

### 1. تسجيل مستخدم جديد

**Endpoint:** `POST /api/auth/register`

**Flutter Code:**
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

Future<Map<String, dynamic>> register({
  required String name,
  required String email,
  required String password,
  required String passwordConfirmation,
  String? phone,
}) async {
  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/register'),
    headers: {'Content-Type': 'application/json'},
    body: json.encode({
      'name': name,
      'email': email,
      'password': password,
      'password_confirmation': passwordConfirmation,
      'phone': phone,
    }),
  );

  if (response.statusCode == 201) {
    final data = json.decode(response.body);
    // Save token
    await saveToken(data['data']['token']);
    return data;
  } else {
    throw Exception('Registration failed');
  }
}
```

---

### 2. تسجيل الدخول العادي

**Endpoint:** `POST /api/auth/login`

```dart
Future<Map<String, dynamic>> login({
  required String email,
  required String password,
}) async {
  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/login'),
    headers: {'Content-Type': 'application/json'},
    body: json.encode({
      'email': email,
      'password': password,
    }),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    await saveToken(data['data']['token']);
    return data;
  } else {
    throw Exception('Login failed');
  }
}
```

---

### 3. تسجيل الدخول بجوجل ✅

**Endpoint:** `POST /api/auth/login/google`

**Dependencies:**
```yaml
dependencies:
  google_sign_in: ^6.1.5
```

**Flutter Code:**
```dart
import 'package:google_sign_in/google_sign_in.dart';

class GoogleAuthService {
  final GoogleSignIn _googleSignIn = GoogleSignIn(
    scopes: ['email', 'profile'],
  );

  Future<Map<String, dynamic>> signInWithGoogle() async {
    try {
      final GoogleSignInAccount? googleUser = await _googleSignIn.signIn();

      if (googleUser == null) {
        throw Exception('Google sign in cancelled');
      }

      final GoogleSignInAuthentication googleAuth =
          await googleUser.authentication;

      // Send to backend
      final response = await http.post(
        Uri.parse('http://your-api-url.com/api/auth/login/google'),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({
          'google_id': googleUser.id,
          'email': googleUser.email,
          'name': googleUser.displayName,
          'avatar': googleUser.photoUrl,
        }),
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        await saveToken(data['data']['token']);
        return data;
      } else {
        throw Exception('Google login failed');
      }
    } catch (e) {
      throw Exception('Google sign in error: $e');
    }
  }
}
```

---

### 4. تسجيل الدخول برقم الهاتف (OTP) ✅

**Step 1: طلب OTP**

**Endpoint:** `POST /api/auth/login/phone`

```dart
Future<void> sendOTP(String phone) async {
  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/login/phone'),
    headers: {'Content-Type': 'application/json'},
    body: json.encode({'phone': phone}),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    print('OTP sent successfully');
    // In debug mode, you'll get the OTP in response
    if (data['data']['otp'] != null) {
      print('OTP: ${data['data']['otp']}');
    }
  } else {
    throw Exception('Failed to send OTP');
  }
}
```

**Step 2: التحقق من OTP**

**Endpoint:** `POST /api/auth/login/phone/verify`

```dart
Future<Map<String, dynamic>> verifyOTP({
  required String phone,
  required String otp,
  String? name,
}) async {
  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/login/phone/verify'),
    headers: {'Content-Type': 'application/json'},
    body: json.encode({
      'phone': phone,
      'otp': otp,
      'name': name,
    }),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    await saveToken(data['data']['token']);
    return data;
  } else {
    throw Exception('OTP verification failed');
  }
}
```

**UI Example:**
```dart
class PhoneLoginScreen extends StatefulWidget {
  @override
  _PhoneLoginScreenState createState() => _PhoneLoginScreenState();
}

class _PhoneLoginScreenState extends State<PhoneLoginScreen> {
  final _phoneController = TextEditingController();
  final _otpController = TextEditingController();
  bool _otpSent = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('تسجيل الدخول برقم الهاتف')),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          children: [
            TextField(
              controller: _phoneController,
              decoration: InputDecoration(
                labelText: 'رقم الهاتف',
                prefixText: '+966 ',
              ),
              keyboardType: TextInputType.phone,
            ),
            SizedBox(height: 16),
            if (_otpSent) ...[
              TextField(
                controller: _otpController,
                decoration: InputDecoration(labelText: 'رمز التحقق'),
                keyboardType: TextInputType.number,
                maxLength: 4,
              ),
              ElevatedButton(
                onPressed: () async {
                  await verifyOTP(
                    phone: _phoneController.text,
                    otp: _otpController.text,
                  );
                  // Navigate to home
                },
                child: Text('تحقق'),
              ),
            ] else ...[
              ElevatedButton(
                onPressed: () async {
                  await sendOTP(_phoneController.text);
                  setState(() => _otpSent = true);
                },
                child: Text('إرسال رمز التحقق'),
              ),
            ],
          ],
        ),
      ),
    );
  }
}
```

---

### 5. الدخول كضيف ✅

**Endpoint:** `POST /api/auth/login/guest`

```dart
import 'package:device_info_plus/device_info_plus.dart';
import 'package:uuid/uuid.dart';

Future<Map<String, dynamic>> loginAsGuest() async {
  // Generate or get stored device ID
  final deviceId = await getDeviceId();

  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/login/guest'),
    headers: {'Content-Type': 'application/json'},
    body: json.encode({'device_id': deviceId}),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    await saveToken(data['data']['token']);
    await saveDeviceId(data['data']['device_id']);
    return data;
  } else {
    throw Exception('Guest login failed');
  }
}

Future<String> getDeviceId() async {
  final prefs = await SharedPreferences.getInstance();
  String? deviceId = prefs.getString('device_id');

  if (deviceId == null) {
    deviceId = Uuid().v4();
    await prefs.setString('device_id', deviceId);
  }

  return deviceId;
}
```

**تحويل الضيف إلى مستخدم عادي:**

**Endpoint:** `POST /api/auth/convert-guest` (requires authentication)

```dart
Future<void> convertGuestToUser({
  required String name,
  required String email,
  required String password,
  required String passwordConfirmation,
}) async {
  final token = await getToken();

  final response = await http.post(
    Uri.parse('http://your-api-url.com/api/auth/convert-guest'),
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
    },
    body: json.encode({
      'name': name,
      'email': email,
      'password': password,
      'password_confirmation': passwordConfirmation,
    }),
  );

  if (response.statusCode != 200) {
    throw Exception('Conversion failed');
  }
}
```

---

### 6. حذف الحساب ✅

**Endpoint:** `DELETE /api/auth/delete-account` (requires authentication)

```dart
Future<void> deleteAccount(String password) async {
  final token = await getToken();

  // Show confirmation dialog
  final confirmed = await showDialog<bool>(
    context: context,
    builder: (context) => AlertDialog(
      title: Text('حذف الحساب'),
      content: Text('هل أنت متأكد من حذف حسابك؟ هذا الإجراء لا يمكن التراجع عنه.'),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context, false),
          child: Text('إلغاء'),
        ),
        TextButton(
          onPressed: () => Navigator.pop(context, true),
          style: TextButton.styleFrom(foregroundColor: Colors.red),
          child: Text('حذف'),
        ),
      ],
    ),
  );

  if (confirmed != true) return;

  final response = await http.delete(
    Uri.parse('http://your-api-url.com/api/auth/delete-account'),
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
    },
    body: json.encode({'password': password}),
  );

  if (response.statusCode == 200) {
    await clearToken();
    // Navigate to login screen
  } else {
    throw Exception('Account deletion failed');
  }
}
```

---

## 📄 الصفحات الثابتة (Pages)

### 1. عرض جميع الصفحات في Footer/Menu

**Endpoint:** `GET /api/pages/footer` أو `GET /api/pages/menu`

```dart
class Page {
  final int id;
  final Map<String, String> title;
  final String slug;
  final String type;
  final String? icon;
  final int order;

  Page.fromJson(Map<String, dynamic> json)
      : id = json['id'],
        title = Map<String, String>.from(json['title']),
        slug = json['slug'],
        type = json['type'],
        icon = json['icon'],
        order = json['order'];
}

Future<List<Page>> getFooterPages() async {
  final response = await http.get(
    Uri.parse('http://your-api-url.com/api/pages/footer'),
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

**UI Example - Footer:**
```dart
class AppFooter extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<Page>>(
      future: getFooterPages(),
      builder: (context, snapshot) {
        if (!snapshot.hasData) return CircularProgressIndicator();

        final pages = snapshot.data!;
        final locale = Localizations.localeOf(context).languageCode;

        return Container(
          padding: EdgeInsets.all(24),
          color: Colors.grey[900],
          child: Column(
            children: [
              Text(
                'ألوان - منصة البث الأولى للمحتوى العربي والعالمي',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
                textAlign: TextAlign.center,
              ),
              SizedBox(height: 24),
              Text(
                'روابط سريعة',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
              SizedBox(height: 16),
              Wrap(
                spacing: 16,
                runSpacing: 8,
                alignment: WrapAlignment.center,
                children: pages.map((page) {
                  return GestureDetector(
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (_) => PageDetailScreen(slug: page.slug),
                        ),
                      );
                    },
                    child: Text(
                      page.title[locale] ?? page.title['ar']!,
                      style: TextStyle(
                        color: Colors.grey[400],
                        fontSize: 12,
                      ),
                    ),
                  );
                }).toList(),
              ),
              SizedBox(height: 24),
              Text(
                'تابعنا',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
              SizedBox(height: 16),
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  IconButton(
                    icon: Icon(Icons.facebook, color: Colors.blue),
                    onPressed: () {},
                  ),
                  IconButton(
                    icon: Icon(Icons.alternate_email, color: Colors.lightBlue),
                    onPressed: () {},
                  ),
                  IconButton(
                    icon: Icon(Icons.camera_alt, color: Colors.pink),
                    onPressed: () {},
                  ),
                ],
              ),
            ],
          ),
        );
      },
    );
  }
}
```

---

### 2. عرض صفحة واحدة

**Endpoint:** `GET /api/pages/{slug}`

```dart
class PageDetail {
  final int id;
  final Map<String, String> title;
  final String slug;
  final Map<String, String> content;
  final String? bannerImage;

  PageDetail.fromJson(Map<String, dynamic> json)
      : id = json['id'],
        title = Map<String, String>.from(json['title']),
        slug = json['slug'],
        content = Map<String, String>.from(json['content']),
        bannerImage = json['banner_image'];
}

Future<PageDetail> getPage(String slug) async {
  final response = await http.get(
    Uri.parse('http://your-api-url.com/api/pages/$slug'),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return PageDetail.fromJson(data['data']);
  } else {
    throw Exception('Page not found');
  }
}
```

**UI Example:**
```dart
import 'package:flutter_html/flutter_html.dart';

class PageDetailScreen extends StatelessWidget {
  final String slug;

  const PageDetailScreen({required this.slug});

  @override
  Widget build(BuildContext context) {
    final locale = Localizations.localeOf(context).languageCode;

    return Scaffold(
      appBar: AppBar(title: Text('Loading...')),
      body: FutureBuilder<PageDetail>(
        future: getPage(slug),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          }

          final page = snapshot.data!;

          return SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                if (page.bannerImage != null)
                  Image.network(
                    page.bannerImage!,
                    height: 200,
                    fit: BoxFit.cover,
                  ),
                Padding(
                  padding: EdgeInsets.all(16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        page.title[locale] ?? page.title['ar']!,
                        style: Theme.of(context).textTheme.headlineMedium,
                      ),
                      SizedBox(height: 16),
                      Html(
                        data: page.content[locale] ?? page.content['ar']!,
                        style: {
                          'body': Style(
                            fontSize: FontSize(16),
                            lineHeight: LineHeight(1.6),
                          ),
                          'h2': Style(
                            fontSize: FontSize(24),
                            fontWeight: FontWeight.bold,
                          ),
                          'h3': Style(
                            fontSize: FontSize(20),
                            fontWeight: FontWeight.w600,
                          ),
                        },
                      ),
                    ],
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}
```

---

## 🎬 المحتوى (Content)

### عرض المحتوى من الباك اند ✅

**التأكد من ظهور المحتوى:**

جميع endpoints المحتوى موجودة بالفعل في `/api` مثل:
- `GET /api/movies` - الأفلام
- `GET /api/series` - المسلسلات
- `GET /api/categories` - التصنيفات
- `GET /api/config/settings` - الإعدادات

**Example:**
```dart
Future<List<Movie>> getMovies() async {
  final response = await http.get(
    Uri.parse('http://your-api-url.com/api/movies'),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return (data['data'] as List)
        .map((movie) => Movie.fromJson(movie))
        .toList();
  } else {
    throw Exception('Failed to load movies');
  }
}
```

---

## 🔧 إعدادات مهمة

### 1. حفظ Token

```dart
import 'package:shared_preferences/shared_preferences.dart';

Future<void> saveToken(String token) async {
  final prefs = await SharedPreferences.getInstance();
  await prefs.setString('auth_token', token);
}

Future<String?> getToken() async {
  final prefs = await SharedPreferences.getInstance();
  return prefs.getString('auth_token');
}

Future<void> clearToken() async {
  final prefs = await SharedPreferences.getInstance();
  await prefs.remove('auth_token');
}
```

---

### 2. HTTP Service مع Token

```dart
class ApiService {
  static const String baseUrl = 'http://your-api-url.com/api';

  static Future<Map<String, String>> getHeaders() async {
    final token = await getToken();
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  static Future<http.Response> get(String endpoint) async {
    final headers = await getHeaders();
    return http.get(
      Uri.parse('$baseUrl/$endpoint'),
      headers: headers,
    );
  }

  static Future<http.Response> post(
    String endpoint,
    Map<String, dynamic> body,
  ) async {
    final headers = await getHeaders();
    return http.post(
      Uri.parse('$baseUrl/$endpoint'),
      headers: headers,
      body: json.encode(body),
    );
  }
}
```

---

## 📦 Dependencies المطلوبة

```yaml
dependencies:
  flutter:
    sdk: flutter

  # HTTP & API
  http: ^1.1.0
  dio: ^5.3.3 # Alternative to http

  # Local Storage
  shared_preferences: ^2.2.2

  # Authentication
  google_sign_in: ^6.1.5
  firebase_auth: ^4.15.0 # Optional for phone auth

  # UI
  flutter_html: ^3.0.0-beta.2
  cached_network_image: ^3.3.0

  # Device Info
  device_info_plus: ^9.1.1
  uuid: ^4.2.2

  # State Management (Choose one)
  provider: ^6.1.1
  # or
  riverpod: ^2.4.9
  # or
  bloc: ^8.1.2
```

---

## 🚀 بدء التشغيل السريع

### 1. تحديث API URL

في `lib/config/api_config.dart`:
```dart
class ApiConfig {
  static const String baseUrl = 'http://192.168.1.100:8000/api';
  // For production:
  // static const String baseUrl = 'https://api.alenwan.com/api';
}
```

### 2. إنشاء Auth Service

```dart
class AuthService {
  Future<bool> isLoggedIn() async {
    final token = await getToken();
    return token != null;
  }

  Future<User?> getCurrentUser() async {
    if (!await isLoggedIn()) return null;

    final response = await ApiService.get('auth/profile');
    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return User.fromJson(data['data']['user']);
    }
    return null;
  }
}
```

### 3. Main App Structure

```dart
void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Alenwan',
      home: FutureBuilder<bool>(
        future: AuthService().isLoggedIn(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return SplashScreen();
          }

          if (snapshot.data == true) {
            return HomeScreen();
          } else {
            return LoginScreen();
          }
        },
      ),
    );
  }
}
```

---

## 📱 صفحة تسجيل الدخول الكاملة

```dart
class LoginScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Padding(
          padding: EdgeInsets.all(24),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.asset('assets/logo.png', height: 100),
              SizedBox(height: 48),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (_) => EmailLoginScreen()),
                  );
                },
                child: Text('تسجيل الدخول بالإيميل'),
              ),
              SizedBox(height: 16),
              ElevatedButton.icon(
                onPressed: () async {
                  await GoogleAuthService().signInWithGoogle();
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (_) => HomeScreen()),
                  );
                },
                icon: Icon(Icons.g_mobiledata),
                label: Text('تسجيل الدخول بجوجل'),
              ),
              SizedBox(height: 16),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (_) => PhoneLoginScreen()),
                  );
                },
                child: Text('تسجيل الدخول برقم الهاتف'),
              ),
              SizedBox(height: 32),
              TextButton(
                onPressed: () async {
                  await loginAsGuest();
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (_) => HomeScreen()),
                  );
                },
                child: Text('الدخول كضيف'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

---

## ✅ Checklist للتأكد من التكامل

- [x] API URL محدث في التطبيق
- [x] تسجيل الدخول يعمل بشكل صحيح
- [x] تسجيل الدخول بجوجل مفعّل
- [x] تسجيل الدخول برقم الهاتف يعمل
- [x] الدخول كضيف متاح
- [x] حذف الحساب يعمل
- [x] عرض الصفحات من Footer
- [x] عرض المحتوى (أفلام، مسلسلات) من Backend
- [x] حفظ Token بشكل آمن
- [x] Logout يعمل بشكل صحيح

---

## 📞 الدعم الفني

للمزيد من المساعدة:
- Email: support@alenwan.com
- Documentation: Check PAGES_DOCUMENTATION.md

---

تم بواسطة ألوان - منصة البث الأولى 🎬
