<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');

        // Call basic seeders
        $this->call([
            LanguageSeeder::class,
            AppConfigSeeder::class,
            PagesSeeder::class,
        ]);

        // Add Categories
        $this->command->info('📁 Adding categories...');
        $this->addCategories();

        // Add Admin User
        $this->command->info('👤 Creating admin user...');
        $this->addAdminUser();

        // Add Subscription Plans
        $this->command->info('💳 Adding subscription plans...');
        $this->addSubscriptionPlans();

        // Add Demo Content
        $this->command->info('🎬 Adding demo movies...');
        $this->addDemoMovies();

        $this->command->info('📺 Adding demo series...');
        $this->addDemoSeries();

        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('🎉 Database is ready with full demo content!');
    }

    private function addCategories()
    {
        $categories = [
            ['name' => ['en' => 'Action', 'ar' => 'أكشن'], 'slug' => 'action'],
            ['name' => ['en' => 'Drama', 'ar' => 'دراما'], 'slug' => 'drama'],
            ['name' => ['en' => 'Comedy', 'ar' => 'كوميديا'], 'slug' => 'comedy'],
            ['name' => ['en' => 'Horror', 'ar' => 'رعب'], 'slug' => 'horror'],
            ['name' => ['en' => 'Romance', 'ar' => 'رومانسي'], 'slug' => 'romance'],
            ['name' => ['en' => 'Documentary', 'ar' => 'وثائقي'], 'slug' => 'documentary'],
            ['name' => ['en' => 'Sports', 'ar' => 'رياضة'], 'slug' => 'sports'],
            ['name' => ['en' => 'Animation', 'ar' => 'رسوم متحركة'], 'slug' => 'animation'],
            ['name' => ['en' => 'Thriller', 'ar' => 'إثارة'], 'slug' => 'thriller'],
            ['name' => ['en' => 'Sci-Fi', 'ar' => 'خيال علمي'], 'slug' => 'sci-fi'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                [
                    'name' => json_encode($category['name']),
                    'slug' => $category['slug'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function addAdminUser()
    {
        $userData = [
            'name' => 'Admin',
            'email' => 'admin@alenwan.com',
            'password' => Hash::make('Alenwan@Admin2025!'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ];

        User::updateOrCreate(
            ['email' => 'admin@alenwan.com'],
            $userData
        );
    }

    private function addSubscriptionPlans()
    {
        $plans = [
            [
                'name' => ['en' => 'Monthly Plan', 'ar' => 'الخطة الشهرية'],
                'description' => ['en' => 'Perfect for trying out our service', 'ar' => 'مثالية لتجربة خدمتنا'],
                'price' => 9.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'features' => ['en' => ['HD Quality', 'Unlimited Streaming', '3 Devices', 'No Ads'], 'ar' => ['جودة عالية', 'بث غير محدود', '3 أجهزة', 'بدون إعلانات']],
            ],
            [
                'name' => ['en' => 'Quarterly Plan', 'ar' => 'الخطة الربع سنوية'],
                'description' => ['en' => '3 months - Save 10%', 'ar' => '3 أشهر - وفر 10%'],
                'price' => 26.99,
                'currency' => 'USD',
                'duration_days' => 90,
                'features' => ['en' => ['HD Quality', 'Unlimited Streaming', '5 Devices', 'No Ads', 'Offline Downloads'], 'ar' => ['جودة عالية', 'بث غير محدود', '5 أجهزة', 'بدون إعلانات', 'تحميل للمشاهدة بدون إنترنت']],
            ],
            [
                'name' => ['en' => 'Yearly Plan', 'ar' => 'الخطة السنوية'],
                'description' => ['en' => '12 months - Save 25%', 'ar' => '12 شهر - وفر 25%'],
                'price' => 89.99,
                'currency' => 'USD',
                'duration_days' => 365,
                'features' => ['en' => ['4K Ultra HD', 'Unlimited Streaming', '10 Devices', 'No Ads', 'Offline Downloads', 'Early Access'], 'ar' => ['4K جودة فائقة', 'بث غير محدود', '10 أجهزة', 'بدون إعلانات', 'تحميل للمشاهدة بدون إنترنت', 'وصول مبكر']],
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('subscription_plans')->updateOrInsert(
                ['duration_days' => $plan['duration_days']],
                [
                    'name' => json_encode($plan['name']),
                    'description' => json_encode($plan['description']),
                    'price' => $plan['price'],
                    'currency' => $plan['currency'],
                    'duration_days' => $plan['duration_days'],
                    'features' => json_encode($plan['features']),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function addDemoMovies()
    {
        $categoryId = DB::table('categories')->first()->id ?? 1;

        $movies = [
            ['title' => ['en' => 'Desert Storm', 'ar' => 'عاصفة الصحراء'], 'slug' => 'desert-storm', 'rating' => 4.7],
            ['title' => ['en' => 'The Last Stand', 'ar' => 'الموقف الأخير'], 'slug' => 'the-last-stand', 'rating' => 4.5],
            ['title' => ['en' => 'Laugh Out Loud', 'ar' => 'اضحك بصوت عالي'], 'slug' => 'laugh-out-loud', 'rating' => 4.2],
            ['title' => ['en' => 'Midnight Terror', 'ar' => 'رعب منتصف الليل'], 'slug' => 'midnight-terror', 'rating' => 4.3],
            ['title' => ['en' => 'Eternal Love', 'ar' => 'حب أبدي'], 'slug' => 'eternal-love', 'rating' => 4.6],
            ['title' => ['en' => 'Ocean Depths', 'ar' => 'أعماق المحيط'], 'slug' => 'ocean-depths', 'rating' => 4.8],
            ['title' => ['en' => 'Championship Glory', 'ar' => 'مجد البطولة'], 'slug' => 'championship-glory', 'rating' => 4.4],
            ['title' => ['en' => 'Magic Kingdom', 'ar' => 'المملكة السحرية'], 'slug' => 'magic-kingdom', 'rating' => 4.9],
            ['title' => ['en' => 'Edge of Tomorrow', 'ar' => 'حافة الغد'], 'slug' => 'edge-of-tomorrow', 'rating' => 4.5],
            ['title' => ['en' => 'Silent Witness', 'ar' => 'الشاهد الصامت'], 'slug' => 'silent-witness', 'rating' => 4.4],
        ];

        foreach ($movies as $movie) {
            DB::table('movies')->updateOrInsert(
                ['slug' => $movie['slug']],
                [
                    'title' => json_encode($movie['title']),
                    'slug' => $movie['slug'],
                    'description' => json_encode(['en' => 'An amazing action-packed movie', 'ar' => 'فيلم رائع مليء بالإثارة']),
                    'category_id' => $categoryId,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'thumbnail' => 'https://via.placeholder.com/300x450.png?text=' . urlencode($movie['title']['en']),
                    'poster' => 'https://via.placeholder.com/1920x1080.png?text=' . urlencode($movie['title']['en']),
                    'duration' => 120,
                    'release_year' => 2024,
                    'rating' => $movie['rating'],
                    'is_premium' => false,
                    'is_active' => true,
                    'is_featured' => true,
                    'views_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function addDemoSeries()
    {
        $categoryId = DB::table('categories')->first()->id ?? 1;

        $seriesData = [
            ['title' => ['en' => 'City Lights', 'ar' => 'أضواء المدينة'], 'slug' => 'city-lights', 'rating' => 4.6],
            ['title' => ['en' => 'Desert Nomads', 'ar' => 'بدو الصحراء'], 'slug' => 'desert-nomads', 'rating' => 4.7],
            ['title' => ['en' => 'Family Matters', 'ar' => 'شؤون العائلة'], 'slug' => 'family-matters', 'rating' => 4.5],
            ['title' => ['en' => 'Mystery Files', 'ar' => 'ملفات غامضة'], 'slug' => 'mystery-files', 'rating' => 4.8],
            ['title' => ['en' => 'Future World', 'ar' => 'عالم المستقبل'], 'slug' => 'future-world', 'rating' => 4.9],
        ];

        foreach ($seriesData as $seriesInfo) {
            // Check if series already exists
            $existingSeries = DB::table('series')->where('slug', $seriesInfo['slug'])->first();

            if ($existingSeries) {
                $seriesId = $existingSeries->id;
            } else {
                $seriesId = DB::table('series')->insertGetId([
                    'title' => json_encode($seriesInfo['title']),
                    'slug' => $seriesInfo['slug'],
                    'description' => json_encode(['en' => 'An exciting series', 'ar' => 'مسلسل مثير ومشوق']),
                    'category_id' => $categoryId,
                    'thumbnail' => 'https://via.placeholder.com/300x450.png?text=' . urlencode($seriesInfo['title']['en']),
                    'poster' => 'https://via.placeholder.com/1920x1080.png?text=' . urlencode($seriesInfo['title']['en']),
                    'release_year' => 2024,
                    'rating' => $seriesInfo['rating'],
                    'status' => 'ongoing',
                    'is_premium' => false,
                    'is_active' => true,
                    'is_featured' => true,
                    'views_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Season 1
            $existingSeason = DB::table('seasons')
                ->where('series_id', $seriesId)
                ->where('season_number', 1)
                ->first();

            if ($existingSeason) {
                $seasonId = $existingSeason->id;
            } else {
                $seasonId = DB::table('seasons')->insertGetId([
                    'series_id' => $seriesId,
                    'title' => json_encode(['en' => 'Season 1', 'ar' => 'الموسم الأول']),
                    'description' => json_encode(['en' => 'First season', 'ar' => 'الموسم الأول']),
                    'season_number' => 1,
                    'thumbnail' => 'https://via.placeholder.com/300x450.png?text=S1',
                    'release_year' => 2024,
                    'is_active' => true,
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Add 5 episodes for season 1
            for ($i = 1; $i <= 5; $i++) {
                $existingEpisode = DB::table('episodes')
                    ->where('season_id', $seasonId)
                    ->where('episode_number', $i)
                    ->exists();

                if (!$existingEpisode) {
                    DB::table('episodes')->insert([
                        'season_id' => $seasonId,
                        'title' => json_encode(['en' => "Episode $i", 'ar' => "الحلقة $i"]),
                        'description' => json_encode(['en' => "Episode $i description", 'ar' => "وصف الحلقة $i"]),
                        'episode_number' => $i,
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'thumbnail' => 'https://via.placeholder.com/300x200.png?text=E' . $i,
                        'duration' => 45,
                        'release_date' => now()->subDays(30 - $i)->format('Y-m-d'),
                        'is_active' => true,
                        'views_count' => 0,
                        'order' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
