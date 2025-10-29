-- ====================================
-- FIX ADMIN USER - SIMPLE SQL SOLUTION
-- ====================================
--
-- Instructions:
-- 1. Open PHPMyAdmin
-- 2. Select database: alenwan_streaming
-- 3. Go to SQL tab
-- 4. Copy and paste this entire file
-- 5. Click "Go" or "Execute"
--
-- ====================================

-- Create or Update Admin User
-- Password: Alenwan@Admin2025!
INSERT INTO users (
    name,
    email,
    email_verified_at,
    password,
    is_admin,
    created_at,
    updated_at
)
VALUES (
    'Admin',
    'admin@alenwan.com',
    NOW(),
    '$2y$12$Gc.oWMRnyHv80P57l0AVGe4xQoPbwY9dbCLVKWHHSRGMGUdZxFBZC',
    1,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    is_admin = 1,
    password = '$2y$12$Gc.oWMRnyHv80P57l0AVGe4xQoPbwY9dbCLVKWHHSRGMGUdZxFBZC',
    email_verified_at = NOW(),
    updated_at = NOW();

-- Verify the admin user was created
SELECT
    id,
    name,
    email,
    is_admin,
    email_verified_at,
    created_at
FROM users
WHERE email = 'admin@alenwan.com';

-- ====================================
-- SUCCESS!
-- ====================================
--
-- Now you can login at:
-- https://www.alenwanapp.net/admin/login
--
-- Credentials:
-- Email: admin@alenwan.com
-- Password: Alenwan@Admin2025!
--
-- ====================================
