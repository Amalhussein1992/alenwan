<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Sport;
use App\Models\Documentary;
use App\Models\Cartoon;
use App\Models\LiveStream;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

echo "🚀 Starting content seeding...\n\n";

// Get categories and languages
$categories = Category::all();
$languages = Language::all();

if ($categories->isEmpty() || $languages->isEmpty()) {
    echo "❌ Please seed categories and languages first!\n";
    exit(1);
}

$actionCategory = $categories->where('name->en', 'Action')->first() ?? $categories->first();
$dramaCategory = $categories->where('name->en', 'Drama')->first() ?? $categories->skip(1)->first();
$comedyCategory = $categories->where('name->en', 'Comedy')->first() ?? $categories->skip(2)->first();
$sportsCategory = $categories->where('name->en', 'Sports')->first() ?? $categories->skip(3)->first();

$arabicLang = $languages->where('code', 'ar')->first() ?? $languages->first();
$englishLang = $languages->where('code', 'en')->first() ?? $languages->skip(1)->first();

echo "📁 Categories found: " . $categories->count() . "\n";
echo "🌍 Languages found: " . $languages->count() . "\n\n";

// ========== MOVIES ==========
echo "🎬 Creating Movies...\n";
$movies = [
    [
        'title' => 'The Last Kingdom',
        'title_ar' => 'المملكة الأخيرة',
        'description' => 'An epic action movie about a warrior defending his kingdom',
        'description_ar' => 'فيلم أكشن ملحمي عن محارب يدافع عن مملكته',
        'duration' => 145,
        'release_year' => 2024,
        'rating' => 8.5,
        'quality' => '4K',
        'category_id' => $actionCategory->id,
    ],
    [
        'title' => 'Desert Storm',
        'title_ar' => 'عاصفة الصحراء',
        'description' => 'A thrilling adventure in the Arabian desert',
        'description_ar' => 'مغامرة مثيرة في الصحراء العربية',
        'duration' => 132,
        'release_year' => 2024,
        'rating' => 7.8,
        'quality' => 'HD',
        'category_id' => $actionCategory->id,
    ],
    [
        'title' => 'Family Bonds',
        'title_ar' => 'روابط عائلية',
        'description' => 'A touching drama about family relationships',
        'description_ar' => 'دراما مؤثرة عن العلاقات الأسرية',
        'duration' => 118,
        'release_year' => 2024,
        'rating' => 8.2,
        'quality' => 'HD',
        'category_id' => $dramaCategory->id,
    ],
    [
        'title' => 'Laugh Out Loud',
        'title_ar' => 'اضحك بصوت عالي',
        'description' => 'A hilarious comedy that will make you laugh',
        'description_ar' => 'كوميديا مضحكة ستجعلك تضحك',
        'duration' => 95,
        'release_year' => 2024,
        'rating' => 7.5,
        'quality' => 'HD',
        'category_id' => $comedyCategory->id,
    ],
    [
        'title' => 'Champions Rise',
        'title_ar' => 'صعود الأبطال',
        'description' => 'An inspiring sports movie about determination',
        'description_ar' => 'فيلم رياضي ملهم عن الإصرار',
        'duration' => 128,
        'release_year' => 2023,
        'rating' => 8.0,
        'quality' => '4K',
        'category_id' => $sportsCategory->id,
    ],
];

foreach ($movies as $movieData) {
    $slug = \Illuminate\Support\Str::slug($movieData['title']) . '-' . rand(1000, 9999);

    $movie = Movie::create([
        'title' => ['en' => $movieData['title'], 'ar' => $movieData['title_ar']],
        'slug' => $slug,
        'description' => ['en' => $movieData['description'], 'ar' => $movieData['description_ar']],
        'duration' => $movieData['duration'],
        'release_year' => $movieData['release_year'],
        'rating' => $movieData['rating'],
        'is_featured' => rand(0, 1),
        'is_trending' => rand(0, 1),
        'views_count' => rand(1000, 50000),
        'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
        'trailer_url' => 'https://sample-videos.com/video123/mp4/480/big_buck_bunny_480p_1mb.mp4',
        'thumbnail' => 'https://via.placeholder.com/300x450/667eea/ffffff?text=' . urlencode($movieData['title']),
        'poster' => 'https://via.placeholder.com/1920x1080/667eea/ffffff?text=' . urlencode($movieData['title']),
        'quality' => $movieData['quality'],
        'category_id' => $movieData['category_id'],
        'language_id' => rand(0, 1) ? $arabicLang->id : $englishLang->id,
        'is_published' => true,
    ]);

    echo "  ✓ Created movie: {$movieData['title']}\n";
}

// ========== SERIES ==========
echo "\n📺 Creating Series...\n";
$seriesData = [
    [
        'title' => 'Desert Warriors',
        'title_ar' => 'محاربو الصحراء',
        'description' => 'An epic series about tribal conflicts in the desert',
        'description_ar' => 'مسلسل ملحمي عن صراعات القبائل في الصحراء',
        'seasons_count' => 2,
        'category_id' => $actionCategory->id,
    ],
    [
        'title' => 'Modern Family',
        'title_ar' => 'عائلة عصرية',
        'description' => 'A comedy series about a contemporary Arab family',
        'description_ar' => 'مسلسل كوميدي عن عائلة عربية معاصرة',
        'seasons_count' => 3,
        'category_id' => $comedyCategory->id,
    ],
];

foreach ($seriesData as $seriesInfo) {
    $slug = \Illuminate\Support\Str::slug($seriesInfo['title']) . '-' . rand(1000, 9999);

    $series = Series::create([
        'title' => ['en' => $seriesInfo['title'], 'ar' => $seriesInfo['title_ar']],
        'slug' => $slug,
        'description' => ['en' => $seriesInfo['description'], 'ar' => $seriesInfo['description_ar']],
        'release_year' => 2024,
        'rating' => rand(75, 95) / 10,
        'is_featured' => rand(0, 1),
        'is_trending' => rand(0, 1),
        'views_count' => rand(5000, 100000),
        'thumbnail' => 'https://via.placeholder.com/300x450/764ba2/ffffff?text=' . urlencode($seriesInfo['title']),
        'poster' => 'https://via.placeholder.com/1920x1080/764ba2/ffffff?text=' . urlencode($seriesInfo['title']),
        'trailer_url' => 'https://sample-videos.com/video123/mp4/480/big_buck_bunny_480p_1mb.mp4',
        'category_id' => $seriesInfo['category_id'],
        'language_id' => $arabicLang->id,
        'is_published' => true,
    ]);

    echo "  ✓ Created series: {$seriesInfo['title']}\n";

    // Create seasons and episodes
    for ($s = 1; $s <= $seriesInfo['seasons_count']; $s++) {
        $season = Season::create([
            'series_id' => $series->id,
            'season_number' => $s,
            'title' => ['en' => "Season $s", 'ar' => "الموسم $s"],
            'description' => ['en' => "Season $s of {$seriesInfo['title']}", 'ar' => "الموسم $s من {$seriesInfo['title_ar']}"],
            'release_year' => 2024,
            'is_published' => true,
        ]);

        // Create 5 episodes per season
        for ($e = 1; $e <= 5; $e++) {
            $epSlug = $slug . '-s' . $s . '-e' . $e;
            Episode::create([
                'series_id' => $series->id,
                'season_id' => $season->id,
                'episode_number' => $e,
                'slug' => $epSlug,
                'title' => ['en' => "Episode $e", 'ar' => "الحلقة $e"],
                'description' => ['en' => "Episode $e of Season $s", 'ar' => "الحلقة $e من الموسم $s"],
                'duration' => rand(40, 60),
                'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
                'thumbnail' => 'https://via.placeholder.com/300x169/764ba2/ffffff?text=S' . $s . 'E' . $e,
                'is_published' => true,
                'views_count' => rand(1000, 10000),
            ]);
        }
        echo "    ✓ Created Season $s with 5 episodes\n";
    }
}

// ========== PODCASTS ==========
echo "\n🎙️ Creating Podcasts...\n";
for ($i = 1; $i <= 5; $i++) {
    $podSlug = 'podcast-episode-' . $i . '-' . rand(1000, 9999);
    Podcast::create([
        'title' => ['en' => "Podcast Episode $i", 'ar' => "حلقة بودكاست $i"],
        'slug' => $podSlug,
        'description' => ['en' => "Interesting podcast episode about various topics", 'ar' => "حلقة بودكاست مثيرة عن مواضيع متنوعة"],
        'host' => ['en' => "Host Name $i", 'ar' => "المقدم $i"],
        'duration' => rand(30, 90),
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        'thumbnail' => 'https://via.placeholder.com/300x300/667eea/ffffff?text=Podcast+' . $i,
        'release_date' => now()->subDays(rand(1, 30)),
        'is_featured' => rand(0, 1),
        'is_published' => true,
        'views_count' => rand(500, 5000),
        'category_id' => $categories->random()->id,
        'language_id' => $arabicLang->id,
    ]);
    echo "  ✓ Created podcast $i\n";
}

// ========== SPORTS ==========
echo "\n⚽ Creating Sports Content...\n";
for ($i = 1; $i <= 5; $i++) {
    $sportSlug = 'match-highlights-' . $i . '-' . rand(1000, 9999);
    Sport::create([
        'title' => ['en' => "Match Highlights $i", 'ar' => "ملخص المباراة $i"],
        'slug' => $sportSlug,
        'description' => ['en' => "Exciting match highlights", 'ar' => "ملخصات مباريات مثيرة"],
        'sport_type' => ['football', 'basketball', 'tennis'][rand(0, 2)],
        'duration' => rand(10, 30),
        'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
        'thumbnail' => 'https://via.placeholder.com/300x169/A20136/ffffff?text=Sports+' . $i,
        'match_date' => now()->subDays(rand(1, 7)),
        'is_live' => false,
        'is_featured' => rand(0, 1),
        'is_published' => true,
        'views_count' => rand(1000, 20000),
        'category_id' => $sportsCategory->id,
        'language_id' => $arabicLang->id,
    ]);
    echo "  ✓ Created sports content $i\n";
}

// ========== DOCUMENTARIES ==========
echo "\n📖 Creating Documentaries...\n";
for ($i = 1; $i <= 5; $i++) {
    $docSlug = 'documentary-' . $i . '-' . rand(1000, 9999);
    Documentary::create([
        'title' => ['en' => "Documentary $i: Nature & Science", 'ar' => "وثائقي $i: الطبيعة والعلوم"],
        'slug' => $docSlug,
        'description' => ['en' => "Educational documentary about nature and science", 'ar' => "وثائقي تعليمي عن الطبيعة والعلوم"],
        'duration' => rand(45, 90),
        'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
        'thumbnail' => 'https://via.placeholder.com/300x169/2ecc71/ffffff?text=Doc+' . $i,
        'release_year' => 2024,
        'director' => "Director $i",
        'is_featured' => rand(0, 1),
        'is_published' => true,
        'views_count' => rand(500, 10000),
        'category_id' => $categories->random()->id,
        'language_id' => rand(0, 1) ? $arabicLang->id : $englishLang->id,
    ]);
    echo "  ✓ Created documentary $i\n";
}

// ========== CARTOONS ==========
echo "\n🎨 Creating Cartoons...\n";
for ($i = 1; $i <= 5; $i++) {
    $cartoonSlug = 'cartoon-adventure-' . $i . '-' . rand(1000, 9999);
    Cartoon::create([
        'title' => ['en' => "Cartoon Adventure $i", 'ar' => "مغامرة كرتونية $i"],
        'slug' => $cartoonSlug,
        'description' => ['en' => "Fun cartoon for kids and family", 'ar' => "كرتون ممتع للأطفال والعائلة"],
        'duration' => rand(20, 45),
        'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
        'thumbnail' => 'https://via.placeholder.com/300x169/f39c12/ffffff?text=Cartoon+' . $i,
        'age_rating' => 'G',
        'is_featured' => rand(0, 1),
        'is_published' => true,
        'views_count' => rand(2000, 15000),
        'category_id' => $categories->random()->id,
        'language_id' => $arabicLang->id,
    ]);
    echo "  ✓ Created cartoon $i\n";
}

// ========== LIVE STREAMS ==========
echo "\n📡 Creating Live Streams...\n";
for ($i = 1; $i <= 3; $i++) {
    $liveSlug = 'live-channel-' . $i . '-' . rand(1000, 9999);
    LiveStream::create([
        'title' => ['en' => "Live Channel $i", 'ar' => "قناة مباشرة $i"],
        'slug' => $liveSlug,
        'description' => ['en' => "24/7 live streaming channel", 'ar' => "قناة بث مباشر على مدار الساعة"],
        'stream_url' => 'https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8',
        'thumbnail' => 'https://via.placeholder.com/300x169/e74c3c/ffffff?text=Live+' . $i,
        'is_live' => true,
        'is_featured' => rand(0, 1),
        'is_published' => true,
        'viewers_count' => rand(100, 5000),
        'category_id' => $categories->random()->id,
        'language_id' => $arabicLang->id,
    ]);
    echo "  ✓ Created live stream $i\n";
}

echo "\n✅ Content seeding completed successfully!\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 Summary:\n";
echo "  • Movies: " . Movie::count() . "\n";
echo "  • Series: " . Series::count() . "\n";
echo "  • Episodes: " . Episode::count() . "\n";
echo "  • Podcasts: " . Podcast::count() . "\n";
echo "  • Sports: " . Sport::count() . "\n";
echo "  • Documentaries: " . Documentary::count() . "\n";
echo "  • Cartoons: " . Cartoon::count() . "\n";
echo "  • Live Streams: " . LiveStream::count() . "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
