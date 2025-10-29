<?php

/**
 * Quick Admin User Creator for Production
 *
 * This script creates an admin user directly in the database
 * without needing to run full migrations or seeders.
 *
 * Usage: Upload this file to your server and access it via browser:
 * https://www.alenwanapp.net/create_admin_quick.php
 */

// Security: Change this key!
define('SECURITY_KEY', 'Alenwan2025CreateAdmin!');

// Database credentials (will be read from .env or set manually)
$dbHost = '127.0.0.1';
$dbName = 'alenwan';
$dbUser = 'root';
$dbPass = 'Alenwan@2025SecurePass!';

// Try to read from .env file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $envFile = file_get_contents(__DIR__ . '/.env');
    if (preg_match('/DB_HOST=(.*)/', $envFile, $matches)) {
        $dbHost = trim($matches[1]);
    }
    if (preg_match('/DB_DATABASE=(.*)/', $envFile, $matches)) {
        $dbName = trim($matches[1]);
    }
    if (preg_match('/DB_USERNAME=(.*)/', $envFile, $matches)) {
        $dbUser = trim($matches[1]);
    }
    if (preg_match('/DB_PASSWORD=(.*)/', $envFile, $matches)) {
        $dbPass = trim($matches[1]);
    }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin User - Alenwan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border: none;
            border-radius: 15px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user-shield"></i> إنشاء مستخدم Admin</h3>
                        <small>Alenwan Admin Creator</small>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $key = $_POST['security_key'] ?? '';

                            if ($key !== SECURITY_KEY) {
                                echo '<div class="alert alert-danger">❌ مفتاح الأمان خاطئ!</div>';
                            } else {
                                try {
                                    $pdo = new PDO(
                                        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
                                        $dbUser,
                                        $dbPass,
                                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                                    );

                                    // Check if table exists
                                    $tableExists = $pdo->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;

                                    if (!$tableExists) {
                                        echo '<div class="alert alert-danger">❌ جدول المستخدمين غير موجود! يرجى تشغيل Migrations أولاً.</div>';
                                    } else {
                                        // Check if user already exists
                                        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                                        $stmt->execute(['admin@alenwan.com']);
                                        $existingUser = $stmt->fetch();

                                        if ($existingUser) {
                                            // Update existing user
                                            $stmt = $pdo->prepare("
                                                UPDATE users
                                                SET is_admin = 1,
                                                    password = ?,
                                                    email_verified_at = NOW(),
                                                    updated_at = NOW()
                                                WHERE email = ?
                                            ");
                                            $password = password_hash('Alenwan@Admin2025!', PASSWORD_BCRYPT);
                                            $stmt->execute([$password, 'admin@alenwan.com']);

                                            echo '<div class="alert alert-success">
                                                <h5>✅ تم تحديث المستخدم بنجاح!</h5>
                                                <hr>
                                                <p><strong>البريد الإلكتروني:</strong> admin@alenwan.com</p>
                                                <p><strong>كلمة المرور:</strong> Alenwan@Admin2025!</p>
                                                <hr>
                                                <a href="/admin/login" class="btn btn-primary">تسجيل الدخول الآن</a>
                                            </div>';
                                        } else {
                                            // Create new user
                                            $stmt = $pdo->prepare("
                                                INSERT INTO users
                                                (name, email, password, is_admin, email_verified_at, created_at, updated_at)
                                                VALUES (?, ?, ?, 1, NOW(), NOW(), NOW())
                                            ");
                                            $password = password_hash('Alenwan@Admin2025!', PASSWORD_BCRYPT);
                                            $stmt->execute(['Admin', 'admin@alenwan.com', $password]);

                                            echo '<div class="alert alert-success">
                                                <h5>✅ تم إنشاء المستخدم بنجاح!</h5>
                                                <hr>
                                                <p><strong>البريد الإلكتروني:</strong> admin@alenwan.com</p>
                                                <p><strong>كلمة المرور:</strong> Alenwan@Admin2025!</p>
                                                <hr>
                                                <a href="/admin/login" class="btn btn-primary">تسجيل الدخول الآن</a>
                                            </div>';
                                        }

                                        echo '<div class="alert alert-warning mt-3">
                                            ⚠️ <strong>مهم للأمان:</strong><br>
                                            يرجى حذف هذا الملف (create_admin_quick.php) من السيرفر الآن!
                                        </div>';
                                    }

                                } catch (PDOException $e) {
                                    echo '<div class="alert alert-danger">
                                        ❌ <strong>خطأ في الاتصال بقاعدة البيانات:</strong><br>
                                        ' . htmlspecialchars($e->getMessage()) . '
                                    </div>';
                                }
                            }
                        } else {
                            ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label">مفتاح الأمان:</label>
                                    <input type="password" name="security_key" class="form-control"
                                           placeholder="أدخل مفتاح الأمان" required>
                                    <small class="text-muted">
                                        المفتاح: <code>Alenwan2025CreateAdmin!</code>
                                    </small>
                                </div>

                                <div class="alert alert-info">
                                    <h6>📋 معلومات Admin سيتم إنشاؤها:</h6>
                                    <ul class="mb-0">
                                        <li><strong>Email:</strong> admin@alenwan.com</li>
                                        <li><strong>Password:</strong> Alenwan@Admin2025!</li>
                                        <li><strong>Role:</strong> Administrator</li>
                                    </ul>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    ✨ إنشاء/تحديث Admin
                                </button>
                            </form>

                            <hr class="my-4">

                            <div class="alert alert-secondary">
                                <h6>ℹ️ معلومات قاعدة البيانات:</h6>
                                <small>
                                    <strong>Host:</strong> <?= htmlspecialchars($dbHost) ?><br>
                                    <strong>Database:</strong> <?= htmlspecialchars($dbName) ?><br>
                                    <strong>User:</strong> <?= htmlspecialchars($dbUser) ?>
                                </small>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <p class="text-center text-white mt-3">
                    <small>Alenwan Platform © 2025</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
