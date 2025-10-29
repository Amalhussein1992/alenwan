-- ===================================================
-- Alenwan Database Creation Script
-- نص إنشاء قاعدة بيانات علنوان
-- ===================================================

-- 1. إنشاء قاعدة البيانات
-- Create Database
CREATE DATABASE IF NOT EXISTS alenwan
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 2. استخدام قاعدة البيانات
-- Use Database
USE alenwan;

-- 3. إنشاء مستخدم خاص بقاعدة البيانات (اختياري)
-- Create dedicated database user (optional)
-- CREATE USER IF NOT EXISTS 'alenwan_user'@'localhost' IDENTIFIED BY 'your_secure_password';
-- GRANT ALL PRIVILEGES ON alenwan.* TO 'alenwan_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ===================================================
-- ملاحظات مهمة / Important Notes
-- ===================================================
--
-- 1. UTF-8 Support (دعم اللغة العربية):
--    - CHARACTER SET utf8mb4 يدعم جميع أحرف Unicode
--    - COLLATE utf8mb4_unicode_ci للفرز الصحيح للنصوص
--
-- 2. بعد تشغيل هذا الملف، قم بتشغيل:
--    After running this file, execute:
--    php artisan migrate
--    php artisan db:seed
--
-- 3. للتحقق من إنشاء قاعدة البيانات:
--    To verify database creation:
--    SHOW DATABASES;
--    USE alenwan;
--    SHOW TABLES;
--
-- 4. لاستيراد هذا الملف من سطر الأوامر:
--    To import this file from command line:
--    mysql -u root -p < CREATE_DATABASE.sql
--
-- 5. أو من phpMyAdmin:
--    Or from phpMyAdmin:
--    - افتح phpMyAdmin
--    - اذهب إلى تبويب SQL
--    - انسخ والصق هذا الكود
--    - اضغط تنفيذ / Execute
--
-- ===================================================

-- التحقق من نجاح العملية
-- Verify success
SELECT
    'Database created successfully! / تم إنشاء قاعدة البيانات بنجاح!' AS status,
    'Next step: Run php artisan migrate / الخطوة التالية: قم بتشغيل' AS next_step;
