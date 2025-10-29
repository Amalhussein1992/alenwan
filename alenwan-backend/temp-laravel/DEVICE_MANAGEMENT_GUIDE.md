# 📱 دليل إدارة الأجهزة - Device Management

## 📋 نظرة عامة

نظام متكامل لإدارة الأجهزة المتصلة لكل مستخدم مع التحكم الكامل من لوحة التحكم.

---

## ✅ المميزات

- ✅ تسجيل الأجهزة تلقائياً عند تسجيل الدخول
- ✅ حد أقصى للأجهزة (مجاني: 2، Premium: 5)
- ✅ تفعيل/إلغاء تفعيل الأجهزة
- ✅ عرض آخر نشاط للجهاز
- ✅ معلومات تفصيلية عن كل جهاز
- ✅ إدارة كاملة من لوحة التحكم
- ✅ API endpoints للتطبيق

---

## 🗄️ بنية قاعدة البيانات

```sql
CREATE TABLE user_devices (
    id BIGINT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    device_name VARCHAR(255),     -- "iPhone 13 Pro"
    device_type VARCHAR(255),     -- mobile, tablet, tv, web
    device_id VARCHAR(255) UNIQUE, -- UUID unique
    os VARCHAR(255),              -- iOS, Android
    os_version VARCHAR(255),      -- "16.0"
    app_version VARCHAR(255),     -- "1.0.0"
    ip_address VARCHAR(255),
    fcm_token VARCHAR(255),       -- للإشعارات
    is_active BOOLEAN DEFAULT true,
    last_active_at TIMESTAMP,
    last_login_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🔧 إضافة API Endpoints

أضف هذا الكود إلى `routes/api.php`:

```php
use App\Models\UserDevice;
use Illuminate\Support\Str;

// Device Management Endpoints (Protected)
Route::middleware('auth:sanctum')->prefix('devices')->group(function () {

    // Register/Update Device
    Route::post('/register', function (Request $request) {
        $request->validate([
            'device_name' => 'required|string|max:255',
            'device_type' => 'required|in:mobile,tablet,tv,web',
            'device_id' => 'required|string|max:255',
            'os' => 'required|string|max:255',
            'os_version' => 'nullable|string|max:255',
            'app_version' => 'nullable|string|max:255',
            'fcm_token' => 'nullable|string|max:255',
        ]);

        $user = $request->user();

        // Check if device already exists
        $device = UserDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            // Update existing device
            $device->update([
                'device_name' => $request->device_name,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'ip_address' => $request->ip(),
                'fcm_token' => $request->fcm_token,
                'last_login_at' => now(),
                'last_active_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Device updated successfully',
                'data' => $device
            ]);
        }

        // Check device limit
        if (!$user->canAddDevice()) {
            return response()->json([
                'success' => false,
                'message' => 'Device limit reached',
                'max_devices' => $user->getMaxDevices(),
                'active_devices' => $user->activeDevices()->count(),
                'upgrade_required' => !$user->is_premium,
            ], 403);
        }

        // Register new device
        $device = UserDevice::create([
            'user_id' => $user->id,
            'device_name' => $request->device_name,
            'device_type' => $request->device_type,
            'device_id' => $request->device_id,
            'os' => $request->os,
            'os_version' => $request->os_version,
            'app_version' => $request->app_version,
            'ip_address' => $request->ip(),
            'fcm_token' => $request->fcm_token,
            'is_active' => true,
            'last_login_at' => now(),
            'last_active_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device registered successfully',
            'data' => $device,
            'remaining_slots' => $user->getRemainingDeviceSlots(),
        ], 201);
    });

    // Get User's Devices
    Route::get('/', function (Request $request) {
        $devices = $request->user()->devices()
            ->orderBy('last_active_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $devices,
            'max_devices' => $request->user()->getMaxDevices(),
            'active_devices' => $request->user()->activeDevices()->count(),
            'remaining_slots' => $request->user()->getRemainingDeviceSlots(),
        ]);
    });

    // Update Device Activity (Heartbeat)
    Route::post('/heartbeat', function (Request $request) {
        $request->validate([
            'device_id' => 'required|string|exists:user_devices,device_id',
        ]);

        $device = UserDevice::where('device_id', $request->device_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        // Check if device is active
        if (!$device->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Device has been deactivated',
                'device_deactivated' => true,
            ], 403);
        }

        $device->updateLastActive();

        return response()->json([
            'success' => true,
            'message' => 'Activity updated'
        ]);
    });

    // Remove Device
    Route::delete('/{device_id}', function (Request $request, $device_id) {
        $device = UserDevice::where('device_id', $device_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device removed successfully',
            'remaining_slots' => $request->user()->getRemainingDeviceSlots(),
        ]);
    });

    // Deactivate Device
    Route::post('/{device_id}/deactivate', function (Request $request, $device_id) {
        $device = UserDevice::where('device_id', $device_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $device->deactivate();

        return response()->json([
            'success' => true,
            'message' => 'Device deactivated successfully'
        ]);
    });

    // Get Current Device Info
    Route::get('/current', function (Request $request) {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $device = UserDevice::where('device_id', $request->device_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $device,
            'is_active' => $device->is_active,
        ]);
    });
});
```

---

## 📱 استخدام API من Flutter

### 1. تسجيل الجهاز عند تسجيل الدخول

```dart
import 'dart:io';
import 'package:device_info_plus/device_info_plus.dart';
import 'package:package_info_plus/package_info_plus.dart';

class DeviceManager {
  static Future<Map<String, String>> getDeviceInfo() async {
    final deviceInfo = DeviceInfoPlugin();
    final packageInfo = await PackageInfo.fromPlatform();

    String deviceName = '';
    String os = '';
    String osVersion = '';

    if (Platform.isAndroid) {
      AndroidDeviceInfo androidInfo = await deviceInfo.androidInfo;
      deviceName = '${androidInfo.brand} ${androidInfo.model}';
      os = 'Android';
      osVersion = androidInfo.version.release;
    } else if (Platform.isIOS) {
      IosDeviceInfo iosInfo = await deviceInfo.iosInfo;
      deviceName = '${iosInfo.name} (${iosInfo.model})';
      os = 'iOS';
      osVersion = iosInfo.systemVersion;
    }

    return {
      'device_name': deviceName,
      'device_type': Platform.isTablet ? 'tablet' : 'mobile',
      'os': os,
      'os_version': osVersion,
      'app_version': packageInfo.version,
    };
  }

  static Future<String> getDeviceId() async {
    // استخدم UUID من SharedPreferences أو أنشئ واحد جديد
    // يمكن استخدام package: uuid
    final prefs = await SharedPreferences.getInstance();
    String? deviceId = prefs.getString('device_id');

    if (deviceId == null) {
      deviceId = Uuid().v4();
      await prefs.setString('device_id', deviceId);
    }

    return deviceId;
  }

  static Future<void> registerDevice(String token) async {
    try {
      final deviceInfo = await getDeviceInfo();
      final deviceId = await getDeviceId();

      final response = await http.post(
        Uri.parse('$baseUrl/devices/register'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
        body: json.encode({
          'device_name': deviceInfo['device_name'],
          'device_type': deviceInfo['device_type'],
          'device_id': deviceId,
          'os': deviceInfo['os'],
          'os_version': deviceInfo['os_version'],
          'app_version': deviceInfo['app_version'],
          'fcm_token': await FirebaseMessaging.instance.getToken(),
        }),
      );

      final data = json.decode(response.body);

      if (response.statusCode == 403) {
        // Device limit reached
        // Show upgrade dialog
        _showDeviceLimitDialog(data);
      } else if (response.statusCode == 201 || response.statusCode == 200) {
        print('Device registered successfully');
      }
    } catch (e) {
      print('Error registering device: $e');
    }
  }
}
```

### 2. Heartbeat (تحديث النشاط)

```dart
class DeviceHeartbeat {
  static Timer? _timer;

  static void start(String token) {
    // إرسال heartbeat كل 5 دقائق
    _timer = Timer.periodic(Duration(minutes: 5), (timer) async {
      await _sendHeartbeat(token);
    });
  }

  static void stop() {
    _timer?.cancel();
  }

  static Future<void> _sendHeartbeat(String token) async {
    try {
      final deviceId = await DeviceManager.getDeviceId();

      final response = await http.post(
        Uri.parse('$baseUrl/devices/heartbeat'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
        body: json.encode({
          'device_id': deviceId,
        }),
      );

      final data = json.decode(response.body);

      if (response.statusCode == 403 && data['device_deactivated'] == true) {
        // الجهاز تم إلغاء تفعيله من لوحة التحكم
        // قم بتسجيل خروج المستخدم
        await _handleDeviceDeactivated();
      }
    } catch (e) {
      print('Heartbeat error: $e');
    }
  }

  static Future<void> _handleDeviceDeactivated() async {
    // تسجيل خروج المستخدم
    // عرض رسالة
    // الانتقال لشاشة تسجيل الدخول
  }
}
```

### 3. عرض قائمة الأجهزة

```dart
class DevicesScreen extends StatefulWidget {
  @override
  _DevicesScreenState createState() => _DevicesScreenState();
}

class _DevicesScreenState extends State<DevicesScreen> {
  List<Device> devices = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadDevices();
  }

  Future<void> _loadDevices() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/devices'),
        headers: {
          'Authorization': 'Bearer $token',
        },
      );

      final data = json.decode(response.body);

      setState(() {
        devices = (data['data'] as List)
            .map((json) => Device.fromJson(json))
            .toList();
        isLoading = false;
      });
    } catch (e) {
      print('Error loading devices: $e');
      setState(() => isLoading = false);
    }
  }

  Future<void> _removeDevice(String deviceId) async {
    try {
      await http.delete(
        Uri.parse('$baseUrl/devices/$deviceId'),
        headers: {
          'Authorization': 'Bearer $token',
        },
      );

      _loadDevices(); // Reload list
    } catch (e) {
      print('Error removing device: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return Center(child: CircularProgressIndicator());
    }

    return ListView.builder(
      itemCount: devices.length,
      itemBuilder: (context, index) {
        final device = devices[index];
        return ListTile(
          leading: Icon(_getDeviceIcon(device.deviceType)),
          title: Text(device.deviceName),
          subtitle: Text('${device.os} ${device.osVersion} • Last active: ${_formatDate(device.lastActiveAt)}'),
          trailing: device.isActive
              ? Icon(Icons.check_circle, color: Colors.green)
              : Icon(Icons.cancel, color: Colors.red),
          onLongPress: () => _removeDevice(device.deviceId),
        );
      },
    );
  }

  IconData _getDeviceIcon(String type) {
    switch (type) {
      case 'mobile':
        return Icons.phone_android;
      case 'tablet':
        return Icons.tablet;
      case 'tv':
        return Icons.tv;
      case 'web':
        return Icons.computer;
      default:
        return Icons.devices;
    }
  }
}
```

---

## 🎛️ إدارة من لوحة التحكم

### المميزات المتاحة:

1. **عرض جميع الأجهزة:**
   - اسم المستخدم
   - اسم الجهاز ونوعه
   - نظام التشغيل والإصدار
   - آخر نشاط
   - الحالة (نشط/غير نشط)

2. **تفعيل/إلغاء التفعيل:**
   - زر لكل جهاز
   - إجراءات جماعية
   - تأكيد قبل التنفيذ

3. **الفلاتر:**
   - حسب نوع الجهاز
   - حسب الحالة
   - حسب المستخدم

4. **حذف الأجهزة:**
   - حذف فردي أو جماعي
   - تأكيد قبل الحذف

---

## 🔒 الأمان

### حماية ضد الاستخدام غير المصرح:

```php
// في Middleware أو في كل request
$device = UserDevice::where('device_id', $request->header('X-Device-ID'))
    ->where('user_id', $request->user()->id)
    ->first();

if (!$device || !$device->is_active) {
    return response()->json([
        'success' => false,
        'message' => 'Device not authorized',
        'logout_required' => true,
    ], 401);
}
```

---

## 📊 حدود الأجهزة

```php
// في User Model
public function getMaxDevices(): int
{
    return $this->is_premium ? 5 : 2;
}

// Free users: 2 devices
// Premium users: 5 devices
```

---

## 🎯 سيناريوهات الاستخدام

### 1. تسجيل دخول من جهاز جديد
```
1. المستخدم يسجل الدخول
2. التطبيق يسجل الجهاز تلقائياً
3. إذا وصل للحد الأقصى، يعرض رسالة
4. المستخدم يمكنه حذف جهاز قديم
```

### 2. إلغاء تفعيل جهاز مسروق
```
1. المستخدم يبلغ عن سرقة
2. الأدمن يبحث عن أجهزة المستخدم
3. يلغي تفعيل الجهاز المسروق
4. الجهاز يتم تسجيل خروجه تلقائياً
```

### 3. ترقية لـ Premium
```
1. المستخدم يشترك في Premium
2. الحد الأقصى يزيد من 2 إلى 5
3. يمكنه إضافة أجهزة جديدة
```

---

## ✅ الخطوات النهائية

### 1. تشغيل Migration
```bash
php artisan migrate
```

### 2. مسح الكاش
```bash
php artisan optimize:clear
```

### 3. اختبار من لوحة التحكم
```
http://localhost:8000/admin/user-devices
```

### 4. اختبار API
```bash
curl -X POST http://localhost:8000/api/devices/register \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "device_name": "iPhone 13 Pro",
    "device_type": "mobile",
    "device_id": "unique-device-id-123",
    "os": "iOS",
    "os_version": "16.0",
    "app_version": "1.0.0"
  }'
```

---

## 🎉 النتيجة

الآن لديك:
- ✅ نظام كامل لإدارة الأجهزة
- ✅ حدود الأجهزة حسب الاشتراك
- ✅ تحكم كامل من لوحة التحكم
- ✅ API جاهزة للتطبيق
- ✅ حماية من الاستخدام غير المصرح
- ✅ تتبع النشاط والتسجيل

---

**آخر تحديث:** 28 أكتوبر 2025
