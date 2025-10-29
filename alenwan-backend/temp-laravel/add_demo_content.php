<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Language;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Podcast;
use App\Models\Sport;
use App\Models\Documentary;
use App\Models\Cartoon;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Channel;
use App\Models\LiveStream;

echo "🎬 إضافة محتوى تجريبي لمنصة Alenwan...\n\n";

// Get or create categories
echo "📁 إنشاء التصنيفات...\n";
$categories = [
    ['name' => 'Action', 'name_ar' => 'أكشن', 'slug' => 'action'],
    ['name' => 'Drama', 'name_ar' => 'دراما', 'slug' => 'drama'],
    ['name' => 'Comedy', 'name_ar' => 'كوميديا', 'slug' => 'comedy'],
    ['name' => 'Documentary', 'name_ar' => 'وثائقي', 'slug' => 'documentary'],
    ['name' => 'Sports', 'name_ar' => 'رياضة', 'slug' => 'sports'],
    ['name' => 'Kids', 'name_ar' => 'أطفال', 'slug' => 'kids'],
    ['name' => 'Technology', 'name_ar' => 'تقنية', 'slug' => 'technology'],
    ['name' => 'Education', 'name_ar' => 'تعليم', 'slug' => 'education'],
];

foreach ($categories as $cat) {
    Category::firstOrCreate(['slug' => $cat['slug']], $cat);
}
echo "✅ تم إنشاء " . count($categories) . " تصنيف\n\n";

// Get or create languages
echo "🌍 إنشاء اللغات...\n";
$languages = [
    ['name' => 'Arabic', 'code' => 'ar', 'is_active' => true],
    ['name' => 'English', 'code' => 'en', 'is_active' => true],
    ['name' => 'French', 'code' => 'fr', 'is_active' => true],
    ['name' => 'Spanish', 'code' => 'es', 'is_active' => true],
];

foreach ($languages as $lang) {
    Language::firstOrCreate(['code' => $lang['code']], $lang);
}
echo "✅ تم إنشاء " . count($languages) . " لغة\n\n";

// Get IDs
$actionCat = Category::where('slug', 'action')->first();
$dramaCat = Category::where('slug', 'drama')->first();
$comedyCat = Category::where('slug', 'comedy')->first();
$docCat = Category::where('slug', 'documentary')->first();
$sportsCat = Category::where('slug', 'sports')->first();
$kidsCat = Category::where('slug', 'kids')->first();
$techCat = Category::where('slug', 'technology')->first();
$eduCat = Category::where('slug', 'education')->first();

$arLang = Language::where('code', 'ar')->first();
$enLang = Language::where('code', 'en')->first();

// Add Movies
echo "🎬 إضافة الأفلام...\n";
$movies = [
    [
        'title' => ['ar' => 'محاربو الصحراء', 'en' => 'Desert Warriors'],
        'description' => ['ar' => 'قصة ملحمية عن الشجاعة والبقاء في الصحراء العربية.', 'en' => 'An epic tale of courage and survival in the Arabian desert.'],
        'slug' => 'desert-warriors',
        'poster' => 'https://picsum.photos/seed/movie1/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
        'duration' => 135,
        'release_year' => 2024,
        'rating' => 8.5,
        'category_id' => $actionCat->id,
        'director' => ['ar' => 'أحمد محمد', 'en' => 'Ahmed Mohamed'],
        'genres' => ['action', 'adventure'],
        'cast' => ['Actor 1', 'Actor 2', 'Actor 3'],
        'is_premium' => true,
        'is_active' => true,
        'is_featured' => true,
        'views_count' => 15420,
    ],
    [
        'title' => ['ar' => 'الضحكة الأخيرة', 'en' => 'The Last Laugh'],
        'description' => ['ar' => 'كوميديا مؤثرة عن العائلة والفرص الثانية.', 'en' => 'A heartwarming comedy about family and second chances.'],
        'slug' => 'the-last-laugh',
        'poster' => 'https://picsum.photos/seed/movie2/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
        'duration' => 98,
        'release_year' => 2023,
        'rating' => 7.8,
        'category_id' => $comedyCat->id,
        'director' => ['ar' => 'سارة أحمد', 'en' => 'Sarah Ahmed'],
        'genres' => ['comedy', 'family'],
        'cast' => ['Actor A', 'Actor B'],
        'is_premium' => false,
        'is_active' => true,
        'is_featured' => false,
        'views_count' => 8750,
    ],
    [
        'title' => ['ar' => 'حكايات منتصف الليل', 'en' => 'Midnight Tales'],
        'description' => ['ar' => 'دراما مشوقة تستكشف أعماق المشاعر الإنسانية.', 'en' => 'A gripping drama that explores the depths of human emotions.'],
        'slug' => 'midnight-tales',
        'poster' => 'https://picsum.photos/seed/movie3/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
        'duration' => 142,
        'release_year' => 2024,
        'rating' => 9.1,
        'category_id' => $dramaCat->id,
        'director' => ['ar' => 'خالد عمر', 'en' => 'Khaled Omar'],
        'genres' => ['drama', 'mystery'],
        'cast' => ['Star 1', 'Star 2', 'Star 3'],
        'is_premium' => true,
        'is_active' => true,
        'is_featured' => true,
        'views_count' => 22340,
    ],
];

foreach ($movies as $movie) {
    Movie::create($movie);
}
echo "✅ تم إضافة " . count($movies) . " فيلم\n\n";

// Add Series
echo "📺 إضافة المسلسلات...\n";
$seriesList = [
    [
        'title' => ['ar' => 'أضواء المدينة', 'en' => 'City Lights'],
        'description' => ['ar' => 'مسلسل درامي حديث عن الحياة في المدينة الكبيرة.', 'en' => 'A modern drama series about life in the big city.'],
        'slug' => 'city-lights',
        'poster' => 'https://picsum.photos/seed/series1/800/1200',
        'release_year' => 2023,
        'rating' => 8.7,
        'category_id' => $dramaCat->id,
        'director' => ['ar' => 'محمد علي', 'en' => 'Mohamed Ali'],
        'genres' => ['drama', 'romance'],
        'cast' => ['Lead 1', 'Lead 2'],
        'status' => 'ongoing',
        'is_premium' => true,
        'is_active' => true,
        'is_featured' => true,
        'views_count' => 45000,
    ],
];

foreach ($seriesList as $seriesData) {
    Series::create($seriesData);
}
echo "✅ تم إضافة " . count($seriesList) . " مسلسل\n\n";

// Add Podcasts
echo "🎙️ إضافة البودكاست...\n";
$podcasts = [
    [
        'title' => 'Tech Talk Arabia',
        'title_ar' => 'حديث التقنية',
        'description' => 'Weekly discussions about technology and innovation in the Arab world.',
        'description_ar' => 'نقاشات أسبوعية حول التقنية والابتكار في العالم العربي.',
        'poster' => 'https://picsum.photos/seed/podcast1/800/800',
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        'duration' => 45,
        'host' => 'Ahmed Hassan',
        'host_ar' => 'أحمد حسن',
        'category_id' => $techCat->id,
        'language_id' => $arLang->id,
        'season_number' => 1,
        'episode_number' => 15,
        'release_date' => '2024-10-15',
        'is_premium' => false,
        'is_published' => true,
        'views_count' => 5600,
    ],
    [
        'title' => 'Learning Arabic',
        'title_ar' => 'تعلم العربية',
        'description' => 'Educational podcast for Arabic language learners.',
        'description_ar' => 'بودكاست تعليمي لمتعلمي اللغة العربية.',
        'poster' => 'https://picsum.photos/seed/podcast2/800/800',
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
        'duration' => 30,
        'host' => 'Sara Ahmed',
        'host_ar' => 'سارة أحمد',
        'category_id' => $eduCat->id,
        'language_id' => $arLang->id,
        'season_number' => 2,
        'episode_number' => 8,
        'release_date' => '2024-10-20',
        'is_premium' => true,
        'is_published' => true,
        'views_count' => 3200,
    ],
];

foreach ($podcasts as $podcast) {
    Podcast::create($podcast);
}
echo "✅ تم إضافة " . count($podcasts) . " بودكاست\n\n";

// Add Sports
echo "⚽ إضافة المباريات الرياضية...\n";
$sports = [
    [
        'title' => 'Champions League Final',
        'title_ar' => 'نهائي دوري الأبطال',
        'description' => 'The biggest football match of the year.',
        'description_ar' => 'أكبر مباراة كرة قدم في العام.',
        'poster' => 'https://picsum.photos/seed/sport1/800/600',
        'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
        'sport_type' => 'football',
        'league' => 'UEFA Champions League',
        'league_ar' => 'دوري أبطال أوروبا',
        'teams' => 'Real Madrid vs Bayern Munich',
        'teams_ar' => 'ريال مدريد ضد بايرن ميونخ',
        'match_date' => '2024-11-15 20:00:00',
        'venue' => 'Wembley Stadium',
        'venue_ar' => 'ملعب ويمبلي',
        'category_id' => $sportsCat->id,
        'language_id' => $arLang->id,
        'is_live' => false,
        'is_premium' => true,
        'is_published' => true,
        'views_count' => 125000,
    ],
    [
        'title' => 'Basketball Championship',
        'title_ar' => 'بطولة كرة السلة',
        'description' => 'Exciting basketball action.',
        'description_ar' => 'إثارة كرة السلة.',
        'poster' => 'https://picsum.photos/seed/sport2/800/600',
        'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
        'sport_type' => 'basketball',
        'league' => 'NBA Finals',
        'league_ar' => 'نهائي الدوري الأمريكي',
        'teams' => 'Lakers vs Celtics',
        'teams_ar' => 'ليكرز ضد سيلتيكس',
        'match_date' => '2024-11-10 22:00:00',
        'venue' => 'Staples Center',
        'venue_ar' => 'ستيبلز سنتر',
        'category_id' => $sportsCat->id,
        'language_id' => $enLang->id,
        'is_live' => true,
        'is_premium' => true,
        'is_published' => true,
        'views_count' => 45000,
    ],
];

foreach ($sports as $sport) {
    Sport::create($sport);
}
echo "✅ تم إضافة " . count($sports) . " مباراة رياضية\n\n";

// Add Documentaries
echo "📽️ إضافة الوثائقيات...\n";
$documentaries = [
    [
        'title' => 'Wonders of Arabia',
        'title_ar' => 'عجائب الجزيرة العربية',
        'description' => 'Exploring the natural beauty and heritage of Arabia.',
        'description_ar' => 'استكشاف الجمال الطبيعي والتراث في الجزيرة العربية.',
        'poster' => 'https://picsum.photos/seed/doc1/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
        'duration' => 90,
        'year' => 2023,
        'director' => 'Khalid Omar',
        'director_ar' => 'خالد عمر',
        'producer' => 'National Geographic',
        'producer_ar' => 'ناشيونال جيوغرافيك',
        'rating' => 9.2,
        'category_id' => $docCat->id,
        'language_id' => $arLang->id,
        'release_date' => '2023-11-01',
        'is_premium' => true,
        'is_published' => true,
        'views_count' => 18500,
    ],
    [
        'title' => 'Ocean Mysteries',
        'title_ar' => 'أسرار المحيط',
        'description' => 'Dive into the depths of our oceans.',
        'description_ar' => 'اغوص في أعماق محيطاتنا.',
        'poster' => 'https://picsum.photos/seed/doc2/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
        'duration' => 75,
        'year' => 2024,
        'director' => 'Sarah Collins',
        'director_ar' => 'سارة كولينز',
        'producer' => 'BBC',
        'producer_ar' => 'بي بي سي',
        'rating' => 8.8,
        'category_id' => $docCat->id,
        'language_id' => $enLang->id,
        'release_date' => '2024-01-20',
        'is_premium' => false,
        'is_published' => true,
        'views_count' => 12300,
    ],
];

foreach ($documentaries as $doc) {
    Documentary::create($doc);
}
echo "✅ تم إضافة " . count($documentaries) . " وثائقي\n\n";

// Add Cartoons
echo "🎨 إضافة الكارتون...\n";
$cartoons = [
    [
        'title' => 'Adventures of Ali',
        'title_ar' => 'مغامرات علي',
        'description' => 'Join Ali on his magical adventures across the Arabian lands.',
        'description_ar' => 'انضم إلى علي في مغامراته السحرية عبر الأراضي العربية.',
        'poster' => 'https://picsum.photos/seed/cartoon1/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
        'duration' => 22,
        'year' => 2024,
        'age_rating' => 'G',
        'rating' => 8.5,
        'category_id' => $kidsCat->id,
        'language_id' => $arLang->id,
        'is_series' => true,
        'season_number' => 1,
        'episode_number' => 12,
        'release_date' => '2024-05-01',
        'is_premium' => false,
        'is_published' => true,
        'views_count' => 25000,
    ],
    [
        'title' => 'Super Friends',
        'title_ar' => 'الأصدقاء الخارقون',
        'description' => 'Animated adventures of friendship and teamwork.',
        'description_ar' => 'مغامرات متحركة عن الصداقة والعمل الجماعي.',
        'poster' => 'https://picsum.photos/seed/cartoon2/800/1200',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
        'duration' => 25,
        'year' => 2023,
        'age_rating' => 'PG',
        'rating' => 7.9,
        'category_id' => $kidsCat->id,
        'language_id' => $arLang->id,
        'is_series' => true,
        'season_number' => 2,
        'episode_number' => 8,
        'release_date' => '2024-03-15',
        'is_premium' => true,
        'is_published' => true,
        'views_count' => 19500,
    ],
];

foreach ($cartoons as $cartoon) {
    Cartoon::create($cartoon);
}
echo "✅ تم إضافة " . count($cartoons) . " كارتون\n\n";


// Add Settings
echo "⚙️ إضافة الإعدادات...\n";
$settings = [
    [
        'key' => 'app_name',
        'value' => 'Alenwan',
        'type' => 'text',
        'group' => 'app',
        'label' => ['ar' => 'اسم التطبيق', 'en' => 'App Name'],
        'description' => ['ar' => 'اسم التطبيق الظاهر', 'en' => 'Display name of the app'],
        'order' => 1,
    ],
    [
        'key' => 'primary_color',
        'value' => '#A20136',
        'type' => 'color',
        'group' => 'theme',
        'label' => ['ar' => 'اللون الأساسي', 'en' => 'Primary Color'],
        'description' => ['ar' => 'اللون الأساسي للتطبيق', 'en' => 'Main color of the app'],
        'order' => 2,
    ],
    [
        'key' => 'max_devices',
        'value' => '3',
        'type' => 'number',
        'group' => 'general',
        'label' => ['ar' => 'الحد الأقصى للأجهزة', 'en' => 'Max Devices'],
        'description' => ['ar' => 'عدد الأجهزة المسموح بها لكل مستخدم', 'en' => 'Number of devices allowed per user'],
        'order' => 3,
    ],
    [
        'key' => 'enable_downloads',
        'value' => 'true',
        'type' => 'boolean',
        'group' => 'app',
        'label' => ['ar' => 'تفعيل التحميلات', 'en' => 'Enable Downloads'],
        'description' => ['ar' => 'السماح للمستخدمين بتحميل المحتوى', 'en' => 'Allow users to download content'],
        'order' => 4,
    ],
    [
        'key' => 'contact_email',
        'value' => 'support@alenwan.com',
        'type' => 'text',
        'group' => 'general',
        'label' => ['ar' => 'البريد الإلكتروني للدعم', 'en' => 'Support Email'],
        'description' => ['ar' => 'البريد الإلكتروني للتواصل', 'en' => 'Contact email address'],
        'order' => 5,
    ],
];

foreach ($settings as $setting) {
    Setting::firstOrCreate(['key' => $setting['key']], $setting);
}
echo "✅ تم إضافة " . count($settings) . " إعداد\n\n";

// Add Subscription Plans
echo "💳 إضافة خطط الاشتراك...\n";
$plans = [
    [
        'name' => json_encode(['ar' => 'الخطة الأساسية', 'en' => 'Basic Plan']),
        'description' => json_encode(['ar' => 'الوصول إلى جميع المحتوى المجاني مع الإعلانات', 'en' => 'Access to all free content with ads']),
        'price' => 0,
        'currency' => 'USD',
        'duration_days' => 30,
        'duration_months' => 1,
        'features' => json_encode([
            'ar' => ['محتوى مجاني فقط', 'جودة SD', 'مع إعلانات', 'جهاز واحد'],
            'en' => ['Free content only', 'SD quality', 'Ads supported', '1 device']
        ]),
        'is_popular' => false,
        'is_active' => true,
        'order' => 1,
    ],
    [
        'name' => json_encode(['ar' => 'المميزة الشهرية', 'en' => 'Premium Monthly']),
        'description' => json_encode(['ar' => 'وصول كامل لجميع المحتوى بدون إعلانات', 'en' => 'Full access to all content, ad-free']),
        'price' => 29.99,
        'currency' => 'USD',
        'duration_days' => 30,
        'duration_months' => 1,
        'features' => json_encode([
            'ar' => ['جميع المحتوى المميز', 'جودة Full HD', 'بدون إعلانات', 'دعم التحميل', '3 أجهزة'],
            'en' => ['All premium content', 'Full HD quality', 'No ads', 'Download support', '3 devices']
        ]),
        'is_popular' => true,
        'is_active' => true,
        'order' => 2,
    ],
    [
        'name' => json_encode(['ar' => 'المميزة السنوية', 'en' => 'Premium Yearly']),
        'description' => json_encode(['ar' => 'أفضل قيمة! وفّر 40% مع الخطة السنوية', 'en' => 'Best value! Save 40% with annual plan']),
        'price' => 199.99,
        'currency' => 'USD',
        'duration_days' => 365,
        'duration_months' => 12,
        'features' => json_encode([
            'ar' => ['جميع المحتوى المميز', 'جودة 4K', 'بدون إعلانات', 'دعم التحميل', '5 أجهزة', 'وصول مبكر للمحتوى الجديد'],
            'en' => ['All premium content', '4K quality', 'No ads', 'Download support', '5 devices', 'Early access to new content']
        ]),
        'is_popular' => true,
        'is_active' => true,
        'order' => 3,
    ],
];

foreach ($plans as $plan) {
    SubscriptionPlan::create($plan);
}
echo "✅ تم إضافة " . count($plans) . " خطة اشتراك\n\n";

// Add Channels
echo "📺 إضافة القنوات...\n";
$channels = [
    [
        'name' => ['ar' => 'قناة ألوان الإخبارية', 'en' => 'Alenwan News'],
        'slug' => 'alenwan-news',
        'description' => ['ar' => 'قناة إخبارية تبث على مدار الساعة', 'en' => '24/7 news channel'],
        'logo' => 'https://picsum.photos/seed/channel1/200/200',
        'banner' => 'https://picsum.photos/seed/channel1banner/1920/400',
        'youtube_channel_id' => 'UCxxxxxxxxxxxxxx',
        'youtube_channel_url' => 'https://www.youtube.com/@alenwannews',
        'youtube_live_stream_id' => 'jfKfPfyJRdk', // Example live stream
        'category_id' => $docCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'subscribers_count' => 150000,
        'views_count' => 5000000,
        'videos_count' => 500,
        'is_live' => true,
        'is_premium' => false,
        'is_active' => true,
        'is_featured' => true,
        'order' => 1,
    ],
    [
        'name' => ['ar' => 'قناة ألوان الرياضية', 'en' => 'Alenwan Sports'],
        'slug' => 'alenwan-sports',
        'description' => ['ar' => 'بث مباشر للمباريات والأحداث الرياضية', 'en' => 'Live sports events and matches'],
        'logo' => 'https://picsum.photos/seed/channel2/200/200',
        'banner' => 'https://picsum.photos/seed/channel2banner/1920/400',
        'youtube_channel_id' => 'UCyyyyyyyyyyyyyy',
        'youtube_channel_url' => 'https://www.youtube.com/@alenwansports',
        'category_id' => $sportsCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'subscribers_count' => 300000,
        'views_count' => 10000000,
        'videos_count' => 800,
        'is_live' => false,
        'is_premium' => true,
        'is_active' => true,
        'is_featured' => true,
        'order' => 2,
    ],
    [
        'name' => ['ar' => 'قناة التعليم والثقافة', 'en' => 'Education & Culture'],
        'slug' => 'education-culture',
        'description' => ['ar' => 'محتوى تعليمي وثقافي متنوع', 'en' => 'Diverse educational and cultural content'],
        'logo' => 'https://picsum.photos/seed/channel3/200/200',
        'banner' => 'https://picsum.photos/seed/channel3banner/1920/400',
        'vimeo_channel_id' => 'channels/xxxxx',
        'vimeo_channel_url' => 'https://vimeo.com/channels/education',
        'category_id' => $eduCat->id,
        'language_id' => $enLang->id,
        'platform' => 'vimeo',
        'subscribers_count' => 50000,
        'views_count' => 800000,
        'videos_count' => 200,
        'is_live' => false,
        'is_premium' => false,
        'is_active' => true,
        'is_featured' => false,
        'order' => 3,
    ],
];

$channelObjects = [];
foreach ($channels as $channel) {
    $ch = Channel::create($channel);
    $channelObjects[] = $ch;
}
echo "✅ تم إضافة " . count($channels) . " قناة\n\n";

// Add Live Streams
echo "📡 إضافة البثوث المباشرة...\n";
$liveStreams = [
    // Live streams for Alenwan News
    [
        'title' => ['ar' => 'بث مباشر - نشرة الأخبار', 'en' => 'Live - News Bulletin'],
        'slug' => 'live-news-bulletin',
        'description' => ['ar' => 'البث المباشر لنشرة الأخبار الرئيسية', 'en' => 'Live broadcast of main news bulletin'],
        'thumbnail' => 'https://picsum.photos/seed/live1/1280/720',
        'poster' => 'https://picsum.photos/seed/live1poster/1920/1080',
        'channel_id' => $channelObjects[0]->id,
        'youtube_video_id' => 'jfKfPfyJRdk',
        'youtube_embed_url' => 'https://www.youtube.com/embed/jfKfPfyJRdk',
        'youtube_watch_url' => 'https://www.youtube.com/watch?v=jfKfPfyJRdk',
        'category_id' => $docCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'stream_type' => 'live',
        'scheduled_start_time' => now(),
        'actual_start_time' => now(),
        'views_count' => 15000,
        'likes_count' => 850,
        'concurrent_viewers' => 5420,
        'peak_viewers' => 8900,
        'is_live_now' => true,
        'is_premium' => false,
        'is_published' => true,
        'is_featured' => true,
        'enable_chat' => true,
        'enable_notifications' => true,
        'tags' => ['أخبار', 'بث مباشر', 'news', 'live'],
    ],
    [
        'title' => ['ar' => 'تقرير خاص: الاقتصاد العالمي', 'en' => 'Special Report: Global Economy'],
        'slug' => 'global-economy-report',
        'description' => ['ar' => 'تقرير مسجل عن الوضع الاقتصادي العالمي', 'en' => 'Recorded report on global economic situation'],
        'thumbnail' => 'https://picsum.photos/seed/live2/1280/720',
        'poster' => 'https://picsum.photos/seed/live2poster/1920/1080',
        'channel_id' => $channelObjects[0]->id,
        'youtube_video_id' => 'aqz-KE-bpKQ',
        'youtube_embed_url' => 'https://www.youtube.com/embed/aqz-KE-bpKQ',
        'youtube_watch_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
        'category_id' => $docCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'stream_type' => 'recorded',
        'duration' => 45,
        'actual_start_time' => now()->subDays(2),
        'end_time' => now()->subDays(2)->addMinutes(45),
        'views_count' => 35000,
        'likes_count' => 1200,
        'is_live_now' => false,
        'is_premium' => false,
        'is_published' => true,
        'is_featured' => false,
        'enable_chat' => false,
        'enable_notifications' => true,
        'tags' => ['اقتصاد', 'تقرير', 'economy', 'report'],
    ],
    // Live streams for Alenwan Sports
    [
        'title' => ['ar' => 'مباراة كرة القدم - نهائي الكأس', 'en' => 'Football Match - Cup Final'],
        'slug' => 'cup-final-match',
        'description' => ['ar' => 'البث المباشر لنهائي كأس البطولة', 'en' => 'Live broadcast of cup final'],
        'thumbnail' => 'https://picsum.photos/seed/live3/1280/720',
        'poster' => 'https://picsum.photos/seed/live3poster/1920/1080',
        'channel_id' => $channelObjects[1]->id,
        'youtube_video_id' => '5qap5aO4i9A',
        'youtube_embed_url' => 'https://www.youtube.com/embed/5qap5aO4i9A',
        'youtube_watch_url' => 'https://www.youtube.com/watch?v=5qap5aO4i9A',
        'category_id' => $sportsCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'stream_type' => 'upcoming',
        'scheduled_start_time' => now()->addDays(3)->setTime(20, 0),
        'views_count' => 0,
        'likes_count' => 0,
        'is_live_now' => false,
        'is_premium' => true,
        'is_published' => true,
        'is_featured' => true,
        'enable_chat' => true,
        'enable_notifications' => true,
        'tags' => ['كرة قدم', 'نهائي', 'football', 'final'],
    ],
    [
        'title' => ['ar' => 'ملخص مباراة الأمس', 'en' => 'Yesterday Match Highlights'],
        'slug' => 'yesterday-match-highlights',
        'description' => ['ar' => 'أفضل اللحظات من مباراة الأمس', 'en' => 'Best moments from yesterday\'s match'],
        'thumbnail' => 'https://picsum.photos/seed/live4/1280/720',
        'poster' => 'https://picsum.photos/seed/live4poster/1920/1080',
        'channel_id' => $channelObjects[1]->id,
        'youtube_video_id' => 'LXb3EKWsInQ',
        'youtube_embed_url' => 'https://www.youtube.com/embed/LXb3EKWsInQ',
        'youtube_watch_url' => 'https://www.youtube.com/watch?v=LXb3EKWsInQ',
        'category_id' => $sportsCat->id,
        'language_id' => $arLang->id,
        'platform' => 'youtube',
        'stream_type' => 'recorded',
        'duration' => 15,
        'actual_start_time' => now()->subDay(),
        'end_time' => now()->subDay()->addMinutes(15),
        'views_count' => 125000,
        'likes_count' => 8500,
        'is_live_now' => false,
        'is_premium' => true,
        'is_published' => true,
        'is_featured' => true,
        'enable_chat' => false,
        'enable_notifications' => true,
        'tags' => ['ملخص', 'مباراة', 'highlights', 'match'],
    ],
    // Live streams for Education & Culture
    [
        'title' => ['ar' => 'محاضرة: تاريخ الحضارات', 'en' => 'Lecture: History of Civilizations'],
        'slug' => 'history-civilizations-lecture',
        'description' => ['ar' => 'محاضرة تعليمية عن تاريخ الحضارات القديمة', 'en' => 'Educational lecture on ancient civilizations'],
        'thumbnail' => 'https://picsum.photos/seed/live5/1280/720',
        'poster' => 'https://picsum.photos/seed/live5poster/1920/1080',
        'channel_id' => $channelObjects[2]->id,
        'vimeo_video_id' => '76979871',
        'vimeo_embed_url' => 'https://player.vimeo.com/video/76979871',
        'vimeo_player_url' => 'https://vimeo.com/76979871',
        'category_id' => $eduCat->id,
        'language_id' => $enLang->id,
        'platform' => 'vimeo',
        'stream_type' => 'recorded',
        'duration' => 60,
        'actual_start_time' => now()->subWeek(),
        'end_time' => now()->subWeek()->addHour(),
        'views_count' => 8500,
        'likes_count' => 420,
        'is_live_now' => false,
        'is_premium' => false,
        'is_published' => true,
        'is_featured' => false,
        'enable_chat' => false,
        'enable_notifications' => true,
        'tags' => ['تعليم', 'تاريخ', 'education', 'history'],
    ],
];

foreach ($liveStreams as $stream) {
    LiveStream::create($stream);
}
echo "✅ تم إضافة " . count($liveStreams) . " بث مباشر\n\n";

echo "🎉 تم إضافة جميع المحتوى التجريبي بنجاح!\n\n";
echo "📊 ملخص المحتوى المضاف:\n";
echo "   - " . count($categories) . " تصنيف\n";
echo "   - " . count($languages) . " لغة\n";
echo "   - " . count($movies) . " فيلم\n";
echo "   - " . count($seriesList) . " مسلسل\n";
echo "   - " . count($podcasts) . " بودكاست\n";
echo "   - " . count($sports) . " مباراة رياضية\n";
echo "   - " . count($documentaries) . " وثائقي\n";
echo "   - " . count($cartoons) . " كارتون\n";
echo "   - " . count($channels) . " قناة\n";
echo "   - " . count($liveStreams) . " بث مباشر\n";
echo "   - " . count($settings) . " إعداد\n";
echo "   - " . count($plans) . " خطة اشتراك\n";
echo "\n✨ يمكنك الآن تصفح المحتوى في لوحة التحكم على http://localhost:8000/admin\n";
