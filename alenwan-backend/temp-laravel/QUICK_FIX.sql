-- ============================================
-- Quick Fix for Admin 500 Error
-- Execute this SQL in phpMyAdmin
-- ============================================

-- 1. Add role column to users table
ALTER TABLE `users`
ADD COLUMN IF NOT EXISTS `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `password`,
ADD INDEX IF NOT EXISTS `users_role_index` (`role`);

-- 2. Create sessions table if not exists
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create or update admin user
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`)
VALUES (
    'Admin',
    'admin@alenwan.com',
    '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
    'admin',
    NOW(),
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `role` = 'admin',
    `password` = '$2y$12$LQv3c1yYqBWFWpeLElGhwO6B5YOXKxe1tYz8Yc1xU0hQ0y8KQqvG.',
    `updated_at` = NOW();

-- 4. Verify the fix
SELECT 'Admin user created/updated:' as status;
SELECT id, name, email, role, email_verified_at FROM users WHERE email = 'admin@alenwan.com';

SELECT 'Sessions table status:' as status;
SHOW TABLES LIKE 'sessions';

-- ============================================
-- After running this SQL, execute via SSH:
-- cd /public_html
-- php artisan cache:clear
-- php artisan config:cache
-- ============================================
