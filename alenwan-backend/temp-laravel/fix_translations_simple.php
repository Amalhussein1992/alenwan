<?php

echo "<h2>🔧 إصلاح ترجمات Filament</h2>";

try {
    // المسار الأساسي
    $basePath = __DIR__;

    // مسار مجلد الترجمات
    $langPath = $basePath . '/lang/vendor/filament-panels';
    $arPath = $langPath . '/ar';

    echo "المسار الأساسي: {$basePath}<br>";
    echo "مسار الترجمات: {$arPath}<br><br>";

    // إنشاء المجلدات
    if (!is_dir($langPath)) {
        mkdir($langPath, 0755, true);
        echo "✅ تم إنشاء مجلد: {$langPath}<br>";
    }

    if (!is_dir($arPath)) {
        mkdir($arPath, 0755, true);
        echo "✅ تم إنشاء مجلد: {$arPath}<br>";
    }

    // محتوى ملف الترجمات
    $translations = "<?php\n\nreturn [\n    'direction' => 'rtl',\n];\n";

    // حفظ الملف
    $filePath = $arPath . '/panels.php';
    $result = file_put_contents($filePath, $translations);

    if ($result !== false) {
        echo "✅ تم إنشاء ملف الترجمات: {$filePath}<br>";
        echo "حجم الملف: {$result} بايت<br>";
    } else {
        echo "❌ فشل في إنشاء الملف<br>";
    }

    // نسخ ملف الترجمات المخصص
    $customFilePath = $basePath . '/lang/ar/filament.php';
    $targetFilePath = $arPath . '/filament.php';

    if (file_exists($customFilePath)) {
        copy($customFilePath, $targetFilePath);
        echo "✅ تم نسخ الترجمات المخصصة إلى: {$targetFilePath}<br>";
    } else {
        echo "⚠️ ملف الترجمات المخصص غير موجود: {$customFilePath}<br>";
    }

    echo "<br><h3>🎉 تم الانتهاء!</h3>";
    echo "<p><a href='/admin'>اذهب إلى لوحة التحكم</a> وحدّث الصفحة (Ctrl+Shift+R)</p>";
    echo "<br><p style='color: red;'><strong>⚠️ احذف هذا الملف بعد الانتهاء للأمان!</strong></p>";

} catch (Exception $e) {
    echo "❌ حدث خطأ: " . $e->getMessage();
    echo "<br><br>Stack Trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
}
