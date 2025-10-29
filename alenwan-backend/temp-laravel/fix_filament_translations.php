<?php

// تحميل Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>🔧 إصلاح ترجمات Filament</h2>";

// المسار الصحيح لترجمات Filament
$filamentLangPath = base_path('lang/vendor/filament-panels/ar');
$customLangPath = base_path('lang/ar');

try {
    // إنشاء المجلد إذا لم يكن موجوداً
    if (!file_exists($filamentLangPath)) {
        mkdir($filamentLangPath, 0755, true);
        echo "✅ تم إنشاء مجلد: {$filamentLangPath}<br>";
    }

    // محتوى ملف الترجمات
    $translations = <<<'PHP'
<?php

return [
    'direction' => 'rtl',

    'navigation' => [
        'groups' => [
            'content' => 'إدارة المحتوى',
            'users' => 'إدارة المستخدمين',
            'configuration' => 'الإعدادات',
            'reports' => 'التقارير والإحصائيات',
        ],
    ],

    'pages' => [
        'dashboard' => [
            'title' => 'لوحة التحكم',
        ],
        'analytics' => [
            'title' => 'التحليلات والإحصائيات',
            'navigation_label' => 'التحليلات',
            'heading' => 'التحليلات والإحصائيات',
        ],
    ],
];
PHP;

    // حفظ الملف
    $filePath = $filamentLangPath . '/panels.php';
    file_put_contents($filePath, $translations);
    echo "✅ تم إنشاء ملف الترجمات: {$filePath}<br>";

    // مسح الـ cache
    Artisan::call('cache:clear');
    echo "✅ تم مسح cache<br>";

    Artisan::call('config:clear');
    echo "✅ تم مسح config cache<br>";

    Artisan::call('view:clear');
    echo "✅ تم مسح view cache<br>";

    echo "<br><h3>🎉 تم إصلاح الترجمات بنجاح!</h3>";
    echo "<p>الآن اذهب إلى <a href='/admin'>لوحة التحكم</a> وحدّث الصفحة (Ctrl+Shift+R)</p>";

} catch (\Exception $e) {
    echo "❌ حدث خطأ: " . $e->getMessage();
    echo "<br><br>Stack Trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
}
