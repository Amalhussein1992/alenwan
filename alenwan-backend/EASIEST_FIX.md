# EASIEST FIX - Enable Database Drivers NOW!

## Problem
Your php.ini has these lines DISABLED (see the `;` semicolon):
```ini
;extension=mysqli
;extension=pdo_mysql
;extension=pdo_sqlite
;extension=sqlite3
```

They need to be ENABLED (remove the `;`):
```ini
extension=mysqli
extension=pdo_mysql
extension=pdo_sqlite
extension=sqlite3
```

## SOLUTION 1: Use phpinfo() Method (EASIEST!)

### Step 1: Create a phpinfo file
1. Open Notepad
2. Copy and paste this:
```php
<?php phpinfo(); ?>
```
3. Save as: `C:\xampp\htdocs\info.php`

### Step 2: Open in browser
1. Open: http://localhost/info.php
2. Press Ctrl+F and search for: "Loaded Configuration File"
3. You'll see the exact path to php.ini

### Step 3: Edit that php.ini
1. Open that exact file in Notepad AS ADMINISTRATOR:
   - Windows key → type "notepad"
   - RIGHT-CLICK → "Run as administrator"
   - File → Open → (navigate to the path you found)
2. Press Ctrl+F and search for: `;extension=pdo_mysql`
3. Remove the `;` from ALL these lines:
   ```
   ;extension=mysqli         → extension=mysqli
   ;extension=pdo_mysql      → extension=pdo_mysql
   ;extension=pdo_sqlite     → extension=pdo_sqlite
   ;extension=sqlite3        → extension=sqlite3
   ```
4. Save (Ctrl+S)

### Step 4: Restart Apache
1. XAMPP Control Panel → Stop Apache
2. Wait 2 seconds
3. Start Apache

### Step 5: Test
```bash
php -r "print_r(PDO::getAvailableDrivers());"
```
Should show: mysql, sqlite

### Step 6: Run migrations!
```bash
php artisan migrate
```

---

## SOLUTION 2: Use XAMPP's PHP (Alternative)

If Solution 1 doesn't work, XAMPP has its own PHP with extensions already enabled!

### Step 1: Use XAMPP's PHP
1. Open Command Prompt
2. Run:
```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend
C:\xampp\php\php.exe artisan migrate
```

### Step 2: Make it permanent
1. Add XAMPP PHP to PATH:
   - Windows key → "Environment Variables"
   - Edit "Path" variable
   - Add: `C:\xampp\php`
   - Move it to the TOP of the list
   - Click OK
2. Restart Command Prompt
3. Now `php artisan migrate` will use XAMPP's PHP

---

## SOLUTION 3: Direct File Edit (No Admin Needed)

### Step 1: Copy php.ini to project
```bash
copy "C:\Program Files\Php\php.ini" "C:\Users\HP\Desktop\flutter\alenwan-backend\php.ini"
```

### Step 2: Edit the copy (no admin needed!)
1. Open: `C:\Users\HP\Desktop\flutter\alenwan-backend\php.ini`
2. Find and remove `;` from:
   ```
   ;extension=mysqli
   ;extension=pdo_mysql
   ;extension=pdo_sqlite
   ;extension=sqlite3
   ```
3. Save

### Step 3: Use this php.ini
```bash
php -c php.ini artisan migrate
```

---

## Which Solution to Use?

- **Solution 1**: Best if you have admin rights
- **Solution 2**: Best if XAMPP is installed (easiest!)
- **Solution 3**: Best if you can't get admin rights

---

## After Success

You'll see:
```
Migration table created successfully.
Migrating: 2024_01_01_000001_create_users_table
Migrated:  2024_01_01_000001_create_users_table
...
```

Then run:
```bash
php artisan db:seed
```

To get:
- ✅ 12 categories
- ✅ 4 subscription plans
- ✅ 4 languages
- ✅ 10 sample movies
- ✅ Admin user (admin@alenwan.com / admin123)

All forms will then save to database! 🎉
