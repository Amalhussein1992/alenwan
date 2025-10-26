# Form Data Storage Guide

## Where Form Data is Saved

All form data is saved in the **SQLite database** located at:
```
C:\Users\HP\Desktop\flutter\alenwan-backend\database\database.sqlite
```

## Database Tables Structure

Your database already has these migrations for storing form data:

### 1. **Users & Authentication**
- `users` - User accounts, profiles
- `password_reset_tokens` - Password resets
- `sessions` - Active sessions

### 2. **Content Tables**
- `movies` - Movie information
- `series` - TV series
- `episodes` - Series episodes
- `documentaries` - Documentary content
- `sports` - Sports content
- `cartoons` - Cartoon content
- `channels` - TV channels
- `livestreams` - Live streaming content

### 3. **Categories & Organization**
- `categories` - Content categories
- `languages` - Language options
- `banners` - Marketing banners

### 4. **Subscription & Payment**
- `subscription_plans` - Available plans
- `subscriptions` - User subscriptions
- `coupons` - Discount coupons

### 5. **Analytics & Tracking**
- `analytics` - Usage analytics
- `user_interactions` - User activity

## How to Save Form Data

### Step 1: Enable SQLite Extension

**For XAMPP on Windows:**
1. Open `php.ini` file (in XAMPP Control Panel → Apache → Config)
2. Find `;extension=pdo_sqlite` and remove the semicolon:
   ```ini
   extension=pdo_sqlite
   extension=sqlite3
   ```
3. Save and restart Apache

### Step 2: Run Migrations

```bash
# Create the database tables
php artisan migrate

# If there are errors, reset and migrate
php artisan migrate:fresh
```

### Step 3: Create Controllers

I'll create controllers for each form to handle data saving.

## Form → Controller → Database Flow

```
User fills form → Submit → Controller validates → Save to database → Return success
```

### Example: Movies Form

**1. Form submits to:** `POST /admin/movies`
**2. Controller:** `MoviesController@store`
**3. Saves to:** `movies` table
**4. Returns:** JSON success/error response

## Controller Examples

### MoviesController.php
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MoviesController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'director' => 'nullable|string',
            'rating' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Save to database
        $movie = Movie::create($validated);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => __('admin.movie_added_successfully'),
            'data' => $movie
        ]);
    }
}
```

### UsersController.php
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:6',
            'subscription_plan' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('admin.user_added_successfully'),
            'data' => $user
        ]);
    }
}
```

## Database Configuration

Your `.env` file is already configured for SQLite:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Quick Setup Commands

```bash
# 1. Install/enable SQLite in PHP (Windows XAMPP)
# Edit php.ini and enable: extension=pdo_sqlite

# 2. Create database tables
php artisan migrate

# 3. Clear config cache
php artisan config:clear

# 4. Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

## Forms → Database Mapping

| Form Page | Controller | Database Table | Fields |
|-----------|-----------|---------------|--------|
| movies/create | MoviesController@store | movies | title, description, release_year, duration, director, rating, category_id, status |
| users/index (Add User) | UsersController@store | users | name, email, phone, password, role |
| series/index | SeriesController@store | series | title, description, seasons, status, category_id |
| documentaries/index | DocumentariesController@store | documentaries | title, description, category, duration |
| livestreams/index | LivestreamsController@store | livestreams | title, stream_url, status, scheduled_at |
| categories/index | CategoriesController@store | categories | name, slug, parent_id, icon, color |
| subscriptions/index | SubscriptionsController@store | subscriptions | user_id, plan_id, start_date, end_date |
| coupons/index | CouponsController@store | coupons | code, type, value, usage_limit, expires_at |
| banners/index | BannersController@store | banners | title, image, link, position, status |
| profile/index | ProfileController@update | users | name, email, phone, password |

## Next Steps

1. ✅ Database structure exists (migrations created)
2. ⏳ Enable SQLite extension in PHP
3. ⏳ Run migrations to create tables
4. ⏳ Create controllers (I'll create them next)
5. ⏳ Update routes to point to controllers
6. ⏳ Test form submissions

## Testing Form Data

After setup, test by:
1. Fill out a form
2. Submit
3. Check database:
```bash
# View saved data
php artisan tinker
>>> App\Models\Movie::all();
>>> App\Models\User::all();
```

Or use a SQLite browser like:
- **DB Browser for SQLite** (https://sqlitebrowser.org/)
- Open: `database/database.sqlite`
