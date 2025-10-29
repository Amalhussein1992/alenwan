<?php
/**
 * Production Database Setup Script
 * رفع هذا الملف على السيرفر وتشغيله من المتصفح لإعداد قاعدة البيانات
 *
 * الاستخدام:
 * 1. ارفع هذا الملف إلى جذر المشروع
 * 2. افتح: https://www.alenwanapp.net/setup_database_production.php
 * 3. اتبع التعليمات
 */

// تعطيل حد زمن التنفيذ
set_time_limit(300);

// بدء الجلسة
session_start();

// متغير للتحقق من الأمان - يجب تغييره
$SECURITY_KEY = 'Alenwan2025Setup!'; // غيّر هذا المفتاح قبل الرفع

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعداد قاعدة البيانات - Alenwan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .setup-container { max-width: 800px; margin: 0 auto; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #667eea; font-weight: 700; }
        .step { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .step h3 { color: #764ba2; margin-bottom: 15px; }
        .btn-run { background: #667eea; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 600; }
        .btn-run:hover { background: #764ba2; color: white; }
        .output { background: #000; color: #0f0; padding: 20px; border-radius: 8px; font-family: monospace; max-height: 400px; overflow-y: auto; }
        .success { color: #28a745; font-weight: 600; }
        .error { color: #dc3545; font-weight: 600; }
        .warning { color: #ffc107; font-weight: 600; }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="header">
            <h1>🚀 إعداد قاعدة البيانات - Alenwan</h1>
            <p class="text-muted">سكريبت إعداد قاعدة البيانات للإنتاج</p>
        </div>

        <?php
        // التحقق من الأمان
        if (isset($_POST['security_key'])) {
            if ($_POST['security_key'] !== $SECURITY_KEY) {
                echo '<div class="alert alert-danger">❌ مفتاح الأمان غير صحيح!</div>';
                exit;
            }
            $_SESSION['authenticated'] = true;
        }

        if (!isset($_SESSION['authenticated'])) {
            ?>
            <div class="step">
                <h3>🔒 التحقق الأمني</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">أدخل مفتاح الأمان:</label>
                        <input type="password" name="security_key" class="form-control" required>
                        <small class="text-muted">المفتاح الافتراضي: Alenwan2025Setup!</small>
                    </div>
                    <button type="submit" class="btn btn-run">تحقق</button>
                </form>
            </div>
            <?php
            exit;
        }

        // تضمين Laravel
        require __DIR__.'/vendor/autoload.php';
        $app = require_once __DIR__.'/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        echo '<div class="alert alert-success">✅ تم تحميل Laravel بنجاح!</div>';

        // اختبار الاتصال بقاعدة البيانات
        try {
            DB::connection()->getPdo();
            echo '<div class="alert alert-success">✅ الاتصال بقاعدة البيانات ناجح!</div>';
        } catch (\Exception $e) {
            echo '<div class="alert alert-danger">❌ فشل الاتصال بقاعدة البيانات: ' . $e->getMessage() . '</div>';
            echo '<p class="text-danger">تحقق من إعدادات .env الخاصة بقاعدة البيانات</p>';
            exit;
        }

        // إذا تم الضغط على زر التشغيل
        if (isset($_POST['run_setup'])) {
            echo '<div class="output">';

            try {
                echo "🔄 بدء إعداد قاعدة البيانات...\n\n";

                // 1. تشغيل Migrations
                echo "📊 الخطوة 1: تشغيل Migrations...\n";
                Artisan::call('migrate', ['--force' => true]);
                echo Artisan::output();
                echo "✅ تم تشغيل Migrations بنجاح!\n\n";

                // 2. تشغيل CategorySeeder
                echo "📁 الخطوة 2: إضافة التصنيفات...\n";
                Artisan::call('db:seed', ['--class' => 'CategorySeeder', '--force' => true]);
                echo Artisan::output();
                echo "✅ تم إضافة التصنيفات!\n\n";

                // 3. تشغيل LanguageSeeder
                echo "🌍 الخطوة 3: إضافة اللغات...\n";
                Artisan::call('db:seed', ['--class' => 'LanguageSeeder', '--force' => true]);
                echo Artisan::output();
                echo "✅ تم إضافة اللغات!\n\n";

                // 4. إضافة خطط الاشتراك
                echo "💳 الخطوة 4: إضافة خطط الاشتراك...\n";

                // إنشاء خطط الاشتراك مباشرة
                $plans = [
                    [
                        'name' => ['en' => 'Monthly Plan', 'ar' => 'الخطة الشهرية'],
                        'description' => ['en' => 'Monthly subscription', 'ar' => 'اشتراك شهري'],
                        'price' => 9.99,
                        'currency' => 'USD',
                        'duration_days' => 30,
                        'features' => json_encode([
                            'en' => ['HD Quality', 'Unlimited Streaming', '3 Devices'],
                            'ar' => ['جودة عالية', 'بث غير محدود', '3 أجهزة']
                        ]),
                        'is_active' => true,
                    ],
                    [
                        'name' => ['en' => 'Yearly Plan', 'ar' => 'الخطة السنوية'],
                        'description' => ['en' => 'Yearly subscription - Save 20%', 'ar' => 'اشتراك سنوي - وفر 20%'],
                        'price' => 99.99,
                        'currency' => 'USD',
                        'duration_days' => 365,
                        'features' => json_encode([
                            'en' => ['HD Quality', 'Unlimited Streaming', '5 Devices', 'Offline Downloads'],
                            'ar' => ['جودة عالية', 'بث غير محدود', '5 أجهزة', 'تحميل للمشاهدة بدون إنترنت']
                        ]),
                        'is_active' => true,
                    ],
                ];

                foreach ($plans as $planData) {
                    $exists = DB::table('subscription_plans')->where('name->en', $planData['name']['en'])->exists();
                    if (!$exists) {
                        DB::table('subscription_plans')->insert([
                            'name' => json_encode($planData['name']),
                            'description' => json_encode($planData['description']),
                            'price' => $planData['price'],
                            'currency' => $planData['currency'],
                            'duration_days' => $planData['duration_days'],
                            'features' => $planData['features'],
                            'is_active' => $planData['is_active'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        echo "  ✅ تم إنشاء خطة: {$planData['name']['ar']}\n";
                    }
                }
                echo "✅ تم إضافة خطط الاشتراك!\n\n";

                // 5. إنشاء مستخدم Admin إذا لم يكن موجوداً
                echo "👤 الخطوة 5: التحقق من مستخدم Admin...\n";
                $admin = \App\Models\User::where('email', 'admin@alenwan.com')->first();
                if (!$admin) {
                    $admin = \App\Models\User::create([
                        'name' => 'Admin',
                        'email' => 'admin@alenwan.com',
                        'password' => Hash::make('Alenwan@Admin2025!'),
                        'role' => 'admin',
                        'email_verified_at' => now(),
                    ]);
                    echo "✅ تم إنشاء مستخدم Admin جديد!\n";
                } else {
                    echo "✅ مستخدم Admin موجود مسبقاً!\n";
                }
                echo "\n";

                // 6. إضافة محتوى تجريبي
                echo "🎬 الخطوة 6: إضافة محتوى تجريبي...\n";

                // الحصول على التصنيفات واللغات
                $categories = \App\Models\Category::all();
                $languages = \App\Models\Language::all();

                if ($categories->isEmpty() || $languages->isEmpty()) {
                    echo "⚠️ تحذير: لا توجد تصنيفات أو لغات. تخطي إضافة المحتوى.\n";
                } else {
                    $categoryId = $categories->first()->id;
                    $languageId = $languages->first()->id;

                    // إضافة أفلام تجريبية
                    $movieCount = \App\Models\Movie::count();
                    if ($movieCount < 5) {
                        for ($i = 1; $i <= 5; $i++) {
                            \App\Models\Movie::create([
                                'title' => ['en' => "Sample Movie $i", 'ar' => "فيلم تجريبي $i"],
                                'slug' => 'sample-movie-' . $i . '-' . rand(1000, 9999),
                                'description' => ['en' => "Description for sample movie $i", 'ar' => "وصف الفيلم التجريبي $i"],
                                'category_id' => $categoryId,
                                'language_id' => $languageId,
                                'duration' => rand(90, 180),
                                'release_year' => rand(2020, 2024),
                                'rating' => rand(30, 50) / 10,
                                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                                'thumbnail' => 'https://via.placeholder.com/300x450.png?text=Movie+' . $i,
                                'poster' => 'https://via.placeholder.com/1920x1080.png?text=Movie+' . $i,
                                'is_featured' => $i <= 3,
                                'is_published' => true,
                            ]);
                        }
                        echo "✅ تم إضافة 5 أفلام تجريبية!\n";
                    } else {
                        echo "✅ الأفلام موجودة مسبقاً ($movieCount فيلم)!\n";
                    }

                    // إضافة مسلسلات تجريبية
                    $seriesCount = \App\Models\Series::count();
                    if ($seriesCount < 3) {
                        for ($i = 1; $i <= 3; $i++) {
                            $series = \App\Models\Series::create([
                                'title' => ['en' => "Sample Series $i", 'ar' => "مسلسل تجريبي $i"],
                                'slug' => 'sample-series-' . $i . '-' . rand(1000, 9999),
                                'description' => ['en' => "Description for sample series $i", 'ar' => "وصف المسلسل التجريبي $i"],
                                'category_id' => $categoryId,
                                'language_id' => $languageId,
                                'release_year' => rand(2020, 2024),
                                'rating' => rand(35, 50) / 10,
                                'thumbnail' => 'https://via.placeholder.com/300x450.png?text=Series+' . $i,
                                'poster' => 'https://via.placeholder.com/1920x1080.png?text=Series+' . $i,
                                'is_featured' => true,
                                'is_published' => true,
                            ]);

                            // إضافة حلقات للمسلسل
                            for ($e = 1; $e <= 5; $e++) {
                                \App\Models\Episode::create([
                                    'series_id' => $series->id,
                                    'title' => ['en' => "Episode $e", 'ar' => "الحلقة $e"],
                                    'slug' => 'episode-' . $e . '-' . rand(1000, 9999),
                                    'description' => ['en' => "Episode $e description", 'ar' => "وصف الحلقة $e"],
                                    'season_number' => 1,
                                    'episode_number' => $e,
                                    'duration' => rand(40, 60),
                                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                                    'thumbnail' => 'https://via.placeholder.com/300x200.png?text=Episode+' . $e,
                                    'is_published' => true,
                                ]);
                            }
                        }
                        echo "✅ تم إضافة 3 مسلسلات (15 حلقة)!\n";
                    } else {
                        echo "✅ المسلسلات موجودة مسبقاً ($seriesCount مسلسل)!\n";
                    }
                }
                echo "\n";

                // 7. إنشاء الصفحات الثابتة
                echo "📄 الخطوة 7: إنشاء الصفحات الثابتة...\n";

                $pagesData = [
                    [
                        'slug' => 'about-us',
                        'title' => ['en' => 'About Us', 'ar' => 'من نحن'],
                        'content' => [
                            'en' => '<h1>About Alenwan</h1><p>Alenwan is the first Arabic streaming platform offering exclusive movies, series, and entertainment content.</p>',
                            'ar' => '<h1>عن Alenwan</h1><p>Alenwan هي منصة البث الأولى للمحتوى العربي الحصري من أفلام ومسلسلات وبرامج ترفيهية.</p>'
                        ],
                    ],
                    [
                        'slug' => 'privacy-policy',
                        'title' => ['en' => 'Privacy Policy', 'ar' => 'سياسة الخصوصية'],
                        'content' => [
                            'en' => '<h1>Privacy Policy</h1><p>We respect your privacy and protect your personal data.</p>',
                            'ar' => '<h1>سياسة الخصوصية</h1><p>نحن نحترم خصوصيتك ونحمي بياناتك الشخصية.</p>'
                        ],
                    ],
                    [
                        'slug' => 'terms-conditions',
                        'title' => ['en' => 'Terms & Conditions', 'ar' => 'الشروط والأحكام'],
                        'content' => [
                            'en' => '<h1>Terms & Conditions</h1><p>By using Alenwan, you agree to our terms and conditions.</p>',
                            'ar' => '<h1>الشروط والأحكام</h1><p>باستخدامك لمنصة Alenwan، فإنك توافق على شروطنا وأحكامنا.</p>'
                        ],
                    ],
                    [
                        'slug' => 'support',
                        'title' => ['en' => 'Support', 'ar' => 'الدعم'],
                        'content' => [
                            'en' => '<h1>Support Center</h1><p>Need help? Contact our support team.</p>',
                            'ar' => '<h1>مركز الدعم</h1><p>تحتاج مساعدة؟ اتصل بفريق الدعم لدينا.</p>'
                        ],
                    ],
                    [
                        'slug' => 'faq',
                        'title' => ['en' => 'FAQ', 'ar' => 'الأسئلة الشائعة'],
                        'content' => [
                            'en' => '<h1>Frequently Asked Questions</h1><p>Find answers to common questions.</p>',
                            'ar' => '<h1>الأسئلة الشائعة</h1><p>ابحث عن إجابات للأسئلة الشائعة.</p>'
                        ],
                    ],
                    [
                        'slug' => 'contact-us',
                        'title' => ['en' => 'Contact Us', 'ar' => 'اتصل بنا'],
                        'content' => [
                            'en' => '<h1>Contact Us</h1><p>Get in touch with us.</p>',
                            'ar' => '<h1>اتصل بنا</h1><p>تواصل معنا.</p>'
                        ],
                    ],
                    [
                        'slug' => 'features',
                        'title' => ['en' => 'Features', 'ar' => 'الميزات'],
                        'content' => [
                            'en' => '<h1>Features</h1><p>Discover amazing features of Alenwan platform.</p>',
                            'ar' => '<h1>الميزات</h1><p>اكتشف الميزات الرائعة لمنصة Alenwan.</p>'
                        ],
                    ],
                    [
                        'slug' => 'pricing',
                        'title' => ['en' => 'Pricing', 'ar' => 'الأسعار'],
                        'content' => [
                            'en' => '<h1>Pricing Plans</h1><p>Choose the perfect plan for you.</p>',
                            'ar' => '<h1>خطط الأسعار</h1><p>اختر الخطة المثالية لك.</p>'
                        ],
                    ],
                ];

                foreach ($pagesData as $pageData) {
                    // التحقق من وجود الصفحة
                    $exists = DB::table('pages')->where('slug', $pageData['slug'])->exists();
                    if (!$exists) {
                        DB::table('pages')->insert([
                            'slug' => $pageData['slug'],
                            'title' => json_encode($pageData['title']),
                            'content' => json_encode($pageData['content']),
                            'is_published' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        echo "  ✅ تم إنشاء صفحة: {$pageData['slug']}\n";
                    } else {
                        echo "  ⏭️ الصفحة موجودة: {$pageData['slug']}\n";
                    }
                }
                echo "✅ تم إنشاء جميع الصفحات الثابتة!\n\n";

                // 8. مسح Cache
                echo "🗑️ الخطوة 8: مسح Cache...\n";
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                echo "✅ تم مسح Cache بنجاح!\n\n";

                // 9. تحسين الأداء
                echo "⚡ الخطوة 9: تحسين الأداء...\n";
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('view:cache');
                echo "✅ تم تحسين الأداء!\n\n";

                echo "🎉 تم إعداد قاعدة البيانات بنجاح!\n\n";
                echo "📋 معلومات الدخول:\n";
                echo "URL: https://www.alenwanapp.net/admin\n";
                echo "Email: admin@alenwan.com\n";
                echo "Password: Alenwan@Admin2025!\n\n";
                echo "⚠️ مهم: احذف هذا الملف بعد الانتهاء من الإعداد!\n";

            } catch (\Exception $e) {
                echo "\n❌ حدث خطأ: " . $e->getMessage() . "\n";
                echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
            }

            echo '</div>';

            echo '<div class="alert alert-warning mt-3">';
            echo '<strong>⚠️ مهم جداً:</strong> احذف هذا الملف (setup_database_production.php) من السيرفر الآن!';
            echo '</div>';

        } else {
            // عرض النموذج
            ?>
            <div class="step">
                <h3>📋 الخطوات التي سيتم تنفيذها:</h3>
                <ol>
                    <li>✅ تشغيل Migrations (إنشاء جداول قاعدة البيانات)</li>
                    <li>✅ إضافة التصنيفات (Categories)</li>
                    <li>✅ إضافة اللغات (Languages)</li>
                    <li>✅ إضافة خطط الاشتراك (Subscription Plans)</li>
                    <li>✅ إنشاء مستخدم Admin</li>
                    <li>✅ إضافة محتوى تجريبي (5 أفلام + 3 مسلسلات)</li>
                    <li>✅ إنشاء الصفحات الثابتة (من نحن، سياسة الخصوصية، إلخ)</li>
                    <li>✅ مسح Cache</li>
                    <li>✅ تحسين الأداء</li>
                </ol>
            </div>

            <div class="alert alert-info">
                <strong>ℹ️ ملاحظة:</strong> هذه العملية قد تستغرق 1-2 دقيقة. لا تغلق الصفحة!
            </div>

            <form method="POST">
                <button type="submit" name="run_setup" class="btn btn-run btn-lg w-100">
                    🚀 ابدأ الإعداد الآن
                </button>
            </form>

            <div class="alert alert-warning mt-3">
                <strong>⚠️ تحذير:</strong> احذف هذا الملف بعد الانتهاء من الإعداد لأسباب أمنية!
            </div>
            <?php
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
