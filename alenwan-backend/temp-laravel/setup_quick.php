<?php
/**
 * Quick Database Setup Script
 * Run this via: php setup_quick.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "===========================================\n";
echo "   Alenwan Database Quick Setup\n";
echo "===========================================\n\n";

try {
    // Test database connection
    echo "🔌 Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✅ Database connected successfully!\n\n";

    // Run migrations
    echo "📊 Running migrations...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();
    echo "✅ Migrations completed!\n\n";

    // Add Categories
    echo "📁 Adding categories...\n";
    $categories = ['Action', 'Drama', 'Comedy', 'Horror', 'Romance', 'Documentary', 'Sports', 'Animation', 'Thriller', 'Sci-Fi'];
    foreach ($categories as $cat) {
        $exists = DB::table('categories')->where('name->en', $cat)->exists();
        if (!$exists) {
            DB::table('categories')->insert([
                'name' => json_encode(['en' => $cat, 'ar' => $cat]),
                'slug' => strtolower($cat),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "  ✅ Added: $cat\n";
        }
    }
    echo "\n";

    // Add Languages
    echo "🌍 Adding languages...\n";
    $languages = [
        ['code' => 'ar', 'name' => ['en' => 'Arabic', 'ar' => 'العربية']],
        ['code' => 'en', 'name' => ['en' => 'English', 'ar' => 'الإنجليزية']],
        ['code' => 'fr', 'name' => ['en' => 'French', 'ar' => 'الفرنسية']],
    ];
    foreach ($languages as $lang) {
        $exists = DB::table('languages')->where('code', $lang['code'])->exists();
        if (!$exists) {
            DB::table('languages')->insert([
                'code' => $lang['code'],
                'name' => json_encode($lang['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "  ✅ Added: {$lang['name']['en']}\n";
        }
    }
    echo "\n";

    // Create Admin User
    echo "👤 Creating admin user...\n";
    $admin = \App\Models\User::where('email', 'admin@alenwan.com')->first();
    if (!$admin) {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        echo "✅ Admin user created!\n";
    } else {
        echo "✅ Admin user already exists!\n";
    }
    echo "\n";

    // Add Sample Movies
    echo "🎬 Adding sample movies...\n";
    $categoryId = DB::table('categories')->first()->id ?? null;
    $languageId = DB::table('languages')->first()->id ?? null;

    if ($categoryId && $languageId) {
        for ($i = 1; $i <= 5; $i++) {
            $exists = DB::table('movies')->where('slug', 'sample-movie-'.$i)->exists();
            if (!$exists) {
                DB::table('movies')->insert([
                    'title' => json_encode(['en' => "Sample Movie $i", 'ar' => "فيلم تجريبي $i"]),
                    'slug' => 'sample-movie-'.$i,
                    'description' => json_encode(['en' => "Description $i", 'ar' => "وصف $i"]),
                    'category_id' => $categoryId,
                    'language_id' => $languageId,
                    'duration' => 120,
                    'release_year' => 2024,
                    'rating' => 4.5,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'thumbnail' => 'https://via.placeholder.com/300x450.png?text=Movie+'.$i,
                    'poster' => 'https://via.placeholder.com/1920x1080.png?text=Movie+'.$i,
                    'is_featured' => true,
                    'is_published' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                echo "  ✅ Added: Sample Movie $i\n";
            }
        }
    }
    echo "\n";

    // Add Pages
    echo "📄 Adding pages...\n";
    $pages = [
        ['slug' => 'support', 'title' => ['en' => 'Support', 'ar' => 'الدعم']],
        ['slug' => 'privacy-policy', 'title' => ['en' => 'Privacy Policy', 'ar' => 'سياسة الخصوصية']],
        ['slug' => 'terms-conditions', 'title' => ['en' => 'Terms & Conditions', 'ar' => 'الشروط والأحكام']],
    ];
    foreach ($pages as $page) {
        $exists = DB::table('pages')->where('slug', $page['slug'])->exists();
        if (!$exists) {
            DB::table('pages')->insert([
                'slug' => $page['slug'],
                'title' => json_encode($page['title']),
                'content' => json_encode(['en' => '<h1>'.$page['title']['en'].'</h1>', 'ar' => '<h1>'.$page['title']['ar'].'</h1>']),
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "  ✅ Added: {$page['slug']}\n";
        }
    }
    echo "\n";

    // Clear cache
    echo "🗑️ Clearing cache...\n";
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    echo "✅ Cache cleared!\n\n";

    // Optimize
    echo "⚡ Optimizing...\n";
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    echo "✅ Optimized!\n\n";

    echo "===========================================\n";
    echo "🎉 Setup completed successfully!\n";
    echo "===========================================\n\n";
    echo "Admin Login:\n";
    echo "URL: https://www.alenwanapp.net/admin\n";
    echo "Email: admin@alenwan.com\n";
    echo "Password: Alenwan@Admin2025!\n\n";

} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
