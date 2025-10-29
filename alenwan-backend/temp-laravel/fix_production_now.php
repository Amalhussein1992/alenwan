<?php
/**
 * 🔧 Production Server Fix Script
 * يحل مشكلة 500 Server Error على www.alenwanapp.net
 *
 * رفع هذا الملف على السيرفر وتشغيله من المتصفح
 */

define('SECURITY_KEY', 'FixAlenwan2025!');

// Read Database Configuration from .env file
$envPath = __DIR__ . '/.env';
$config = [
    'host' => 'localhost',
    'dbname' => 'alenwan_streaming',
    'username' => 'admin_alenwan',
    'password' => '%Aa23z8e2',
    'charset' => 'utf8mb4'
];

// Try to read from .env if it exists
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $envLines = explode("\n", $envContent);

    foreach ($envLines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;

        if (strpos($line, 'DB_HOST=') === 0) {
            $config['host'] = trim(substr($line, 8));
        } elseif (strpos($line, 'DB_DATABASE=') === 0) {
            $config['dbname'] = trim(substr($line, 12));
        } elseif (strpos($line, 'DB_USERNAME=') === 0) {
            $config['username'] = trim(substr($line, 12));
        } elseif (strpos($line, 'DB_PASSWORD=') === 0) {
            $config['password'] = trim(substr($line, 12));
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 إصلاح السيرفر - Alenwan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            border: none;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 25px;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .step {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        .success { border-left-color: #28a745; background: #d4edda; }
        .error { border-left-color: #dc3545; background: #f8d7da; }
        .warning { border-left-color: #ffc107; background: #fff3cd; }
        .btn-fix {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            transition: all 0.3s;
        }
        .btn-fix:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
        }
        .code-block {
            background: #2d3748;
            color: #48bb78;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        🔧 إصلاح مشكلة 500 Server Error
                        <div style="font-size: 0.9rem; margin-top: 10px; opacity: 0.9;">
                            Alenwan Production Fix Script
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $key = $_POST['security_key'] ?? '';

                            if ($key !== SECURITY_KEY) {
                                echo '<div class="step error">
                                    <h5>❌ مفتاح الأمان خاطئ!</h5>
                                    <p>المفتاح الصحيح: <code>FixAlenwan2025!</code></p>
                                </div>';
                            } else {
                                echo '<div class="step">
                                    <h5>🚀 بدء عملية الإصلاح...</h5>
                                </div>';

                                try {
                                    // الاتصال بقاعدة البيانات
                                    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
                                    $pdo = new PDO($dsn, $config['username'], $config['password'], [
                                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                                    ]);

                                    echo '<div class="step success">
                                        <h5>✅ الخطوة 1: تم الاتصال بقاعدة البيانات</h5>
                                        <small>Database: ' . htmlspecialchars($config['dbname']) . '</small>
                                    </div>';

                                    // التحقق من جدول users
                                    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
                                    if ($stmt->rowCount() == 0) {
                                        echo '<div class="step error">
                                            <h5>❌ جدول المستخدمين غير موجود!</h5>
                                            <p>يرجى تشغيل Migrations أولاً:</p>
                                            <div class="code-block">php artisan migrate --force</div>
                                        </div>';
                                    } else {
                                        echo '<div class="step success">
                                            <h5>✅ الخطوة 2: جدول المستخدمين موجود</h5>
                                        </div>';

                                        // التحقق من عمود is_admin
                                        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
                                        $hasIsAdmin = $stmt->rowCount() > 0;

                                        if (!$hasIsAdmin) {
                                            echo '<div class="step warning">
                                                <h5>⚠️ عمود is_admin غير موجود</h5>
                                                <p>يرجى تشغيل هذا Migration:</p>
                                                <div class="code-block">php artisan migrate --force</div>
                                            </div>';
                                        } else {
                                            echo '<div class="step success">
                                                <h5>✅ الخطوة 3: عمود is_admin موجود</h5>
                                            </div>';

                                            // إنشاء/تحديث مستخدم Admin
                                            $password = password_hash('Alenwan@Admin2025!', PASSWORD_BCRYPT);

                                            // التحقق من وجود المستخدم
                                            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                                            $stmt->execute(['admin@alenwan.com']);
                                            $existingUser = $stmt->fetch();

                                            if ($existingUser) {
                                                // تحديث المستخدم الموجود
                                                $stmt = $pdo->prepare("
                                                    UPDATE users
                                                    SET is_admin = 1,
                                                        password = ?,
                                                        email_verified_at = NOW(),
                                                        updated_at = NOW()
                                                    WHERE email = ?
                                                ");
                                                $stmt->execute([$password, 'admin@alenwan.com']);

                                                echo '<div class="step success">
                                                    <h5>✅ الخطوة 4: تم تحديث مستخدم Admin</h5>
                                                    <p>User ID: ' . $existingUser['id'] . '</p>
                                                </div>';
                                            } else {
                                                // إنشاء مستخدم جديد
                                                $stmt = $pdo->prepare("
                                                    INSERT INTO users
                                                    (name, email, password, is_admin, email_verified_at, created_at, updated_at)
                                                    VALUES (?, ?, ?, 1, NOW(), NOW(), NOW())
                                                ");
                                                $stmt->execute(['Admin', 'admin@alenwan.com', $password]);

                                                echo '<div class="step success">
                                                    <h5>✅ الخطوة 4: تم إنشاء مستخدم Admin جديد</h5>
                                                    <p>User ID: ' . $pdo->lastInsertId() . '</p>
                                                </div>';
                                            }

                                            // عرض معلومات الدخول
                                            echo '<div class="card mt-4" style="border: 3px solid #28a745;">
                                                <div class="card-body text-center">
                                                    <h3 class="text-success mb-4">🎉 تم الإصلاح بنجاح!</h3>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>📧 البريد الإلكتروني:</h6>
                                                            <div class="code-block">admin@alenwan.com</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>🔑 كلمة المرور:</h6>
                                                            <div class="code-block">Alenwan@Admin2025!</div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <a href="/admin/login" class="btn btn-fix mb-3">
                                                        🚀 تسجيل الدخول الآن
                                                    </a>

                                                    <div class="alert alert-warning mt-3">
                                                        <strong>⚠️ مهم للأمان:</strong><br>
                                                        يرجى حذف هذا الملف <code>fix_production_now.php</code> من السيرفر فوراً!
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                    }

                                } catch (PDOException $e) {
                                    echo '<div class="step error">
                                        <h5>❌ خطأ في قاعدة البيانات</h5>
                                        <p><strong>الرسالة:</strong></p>
                                        <div class="code-block" style="color: #fc8181;">'
                                            . htmlspecialchars($e->getMessage()) .
                                        '</div>
                                        <hr>
                                        <h6>💡 الحلول المقترحة:</h6>
                                        <ol>
                                            <li>تأكد من صحة بيانات الاتصال بقاعدة البيانات في ملف .env</li>
                                            <li>تأكد أن قاعدة البيانات <code>alenwan_streaming</code> موجودة</li>
                                            <li>شغّل Migrations: <code>php artisan migrate --force</code></li>
                                        </ol>
                                    </div>';
                                }
                            }
                        } else {
                            // النموذج
                            ?>
                            <div class="alert alert-info">
                                <h5>ℹ️ معلومات السيرفر:</h5>
                                <ul class="mb-0">
                                    <li><strong>URL:</strong> https://www.alenwanapp.net</li>
                                    <li><strong>Database:</strong> <?= $config['dbname'] ?></li>
                                    <li><strong>User:</strong> <?= $config['username'] ?></li>
                                </ul>
                            </div>

                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">مفتاح الأمان:</label>
                                    <input type="password" name="security_key" class="form-control form-control-lg"
                                           placeholder="أدخل مفتاح الأمان" required>
                                    <small class="text-muted">
                                        المفتاح: <code>FixAlenwan2025!</code>
                                    </small>
                                </div>

                                <div class="step">
                                    <h6>✨ سيقوم هذا السكريبت بـ:</h6>
                                    <ol class="mb-0">
                                        <li>الاتصال بقاعدة البيانات</li>
                                        <li>التحقق من وجود جدول المستخدمين</li>
                                        <li>التحقق من عمود is_admin</li>
                                        <li>إنشاء/تحديث مستخدم Admin</li>
                                        <li>تفعيل صلاحيات المدير</li>
                                    </ol>
                                </div>

                                <button type="submit" class="btn btn-fix w-100">
                                    🔧 إصلاح المشكلة الآن
                                </button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <p class="text-center text-white">
                    <small>Alenwan Platform © 2025 | Made with ❤️</small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
