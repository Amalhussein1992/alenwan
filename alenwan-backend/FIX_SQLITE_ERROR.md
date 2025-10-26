# Fix SQLite Driver Error

## Error You're Getting:
```
could not find driver (Connection: sqlite)
```

## Solution: Enable SQLite in PHP

### Option 1: Automatic (Recommended)

**Run this PowerShell command as Administrator:**

```powershell
cd C:\Users\HP\Desktop\flutter\alenwan-backend
powershell -ExecutionPolicy Bypass -File enable-sqlite.ps1
```

### Option 2: Manual Steps

1. **Open php.ini file:**
   - Location: `C:\Program Files\Php\php.ini`
   - Right-click → Open with Notepad (as Administrator)

2. **Find and edit these lines** (use Ctrl+F to search):

   **Find this:**
   ```ini
   ;extension=pdo_sqlite
   ```
   **Change to:**
   ```ini
   extension=pdo_sqlite
   ```

   **Find this:**
   ```ini
   ;extension=sqlite3
   ```
   **Change to:**
   ```ini
   extension=sqlite3
   ```

   *(Just remove the semicolon `;` at the beginning)*

3. **Save the file** (Ctrl+S)

4. **Restart your web server:**
   - If using XAMPP: Stop and Start Apache
   - If using built-in PHP server: Stop (Ctrl+C) and restart

5. **Verify SQLite is enabled:**
   ```bash
   php -m
   ```
   You should see `pdo_sqlite` and `sqlite3` in the list

6. **Run migrations:**
   ```bash
   cd C:\Users\HP\Desktop\flutter\alenwan-backend
   php artisan migrate
   ```

## Verification

After enabling SQLite, test with:

```bash
php -r "echo class_exists('PDO') && in_array('sqlite', PDO::getAvailableDrivers()) ? 'SQLite is enabled!' : 'SQLite not found!';"
```

Should output: `SQLite is enabled!`

## Alternative: Use MySQL Instead

If you have trouble enabling SQLite, you can use MySQL instead:

1. **Update `.env` file:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=alenwan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Create database in phpMyAdmin:**
   - Open: http://localhost/phpmyadmin
   - Click "New"
   - Database name: `alenwan`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## Still Having Issues?

### Check PHP version:
```bash
php -v
```
(Should be PHP 8.0 or higher)

### Check if php.ini is being loaded:
```bash
php --ini
```

### Clear Laravel cache:
```bash
php artisan config:clear
php artisan cache:clear
```

## Next Steps After Fix

Once SQLite is enabled and migrations run successfully:

1. **Test database connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   # Should not throw any errors
   ```

2. **Add a test movie:**
   ```bash
   php artisan tinker
   >>> App\Models\Movie::create(['title' => 'Test Movie', 'status' => 'published']);
   >>> App\Models\Movie::all();
   ```

3. **All forms will now save data to the database!** ✅

## Quick Reference

**php.ini location:** `C:\Program Files\Php\php.ini`

**Lines to change:**
- `;extension=pdo_sqlite` → `extension=pdo_sqlite`
- `;extension=sqlite3` → `extension=sqlite3`

**After changes:** Restart web server and run `php artisan migrate`
