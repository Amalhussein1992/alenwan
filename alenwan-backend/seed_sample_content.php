<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Seeding sample content...\n\n";

$now = date('Y-m-d H:i:s');

// Sample Movies
echo "Adding movies...\n";
$movies = [
    [
        'title' => 'The Matrix',
        'title_ar' => 'ماتريكس',
        'description' => 'A computer hacker learns about the true nature of his reality.',
        'description_ar' => 'قصة هاكر كمبيوتر يكتشف الحقيقة حول واقعه',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
        'duration' => 136,
        'release_year' => 1999,
        'rating' => 8.7,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Inception',
        'title_ar' => 'البداية',
        'description' => 'A thief who steals corporate secrets through dream-sharing technology.',
        'description_ar' => 'لص يسرق أسرار الشركات من خلال تقنية مشاركة الأحلام',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg',
        'duration' => 148,
        'release_year' => 2010,
        'rating' => 8.8,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Interstellar',
        'title_ar' => 'بين النجوم',
        'description' => 'A team of explorers travel through a wormhole in space.',
        'description_ar' => 'فريق من المستكشفين يسافرون عبر ثقب دودي في الفضاء',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
        'duration' => 169,
        'release_year' => 2014,
        'rating' => 8.6,
        'status' => 'published',
        'subscription_tier' => 'free'
    ]
];

$stmt = $db->prepare("INSERT INTO movies (title, title_ar, description, description_ar, poster_url, duration, release_year, rating, status, subscription_tier, is_featured, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($movies as $movie) {
    $stmt->execute([
        $movie['title'],
        $movie['title_ar'],
        $movie['description'],
        $movie['description_ar'],
        $movie['poster_url'],
        $movie['duration'],
        $movie['release_year'],
        $movie['rating'],
        $movie['status'],
        $movie['subscription_tier'],
        $movie['is_featured'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($movies) . " movies\n";

// Sample Series
echo "Adding series...\n";
$series = [
    [
        'title' => 'Breaking Bad',
        'title_ar' => 'بريكنج باد',
        'description' => 'A chemistry teacher turned meth producer.',
        'description_ar' => 'قصة مدرس كيمياء يتحول إلى صانع مخدرات',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg',
        'release_year' => 2008,
        'rating' => 9.5,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Game of Thrones',
        'title_ar' => 'صراع العروش',
        'description' => 'Nine noble families fight for control over the lands of Westeros.',
        'description_ar' => 'تسع عائلات نبيلة تتقاتل من أجل السيطرة على أراضي ويستروس',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg',
        'release_year' => 2011,
        'rating' => 9.2,
        'status' => 'published',
        'subscription_tier' => 'free'
    ]
];

$stmt = $db->prepare("INSERT INTO series (title, title_ar, description, description_ar, poster_url, release_year, rating, status, subscription_tier, is_featured, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($series as $s) {
    $stmt->execute([
        $s['title'],
        $s['title_ar'],
        $s['description'],
        $s['description_ar'],
        $s['poster_url'],
        $s['release_year'],
        $s['rating'],
        $s['status'],
        $s['subscription_tier'],
        $s['is_featured'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($series) . " series\n";

// Sample Sports
echo "Adding sports...\n";
$sports = [
    [
        'title' => 'FIFA World Cup 2022 - Final',
        'title_ar' => 'كأس العالم 2022 - المباراة النهائية',
        'description' => 'Argentina vs France - World Cup Final',
        'description_ar' => 'الأرجنتين ضد فرنسا - نهائي كأس العالم',
        'poster_url' => 'https://via.placeholder.com/500x750/1E3A8A/FFFFFF?text=World+Cup',
        'match_date' => '2022-12-18 18:00:00',
        'sport_type' => 'football',
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'UEFA Champions League',
        'title_ar' => 'دوري أبطال أوروبا',
        'description' => 'Champions League highlights and matches',
        'description_ar' => 'أبرز مباريات دوري أبطال أوروبا',
        'poster_url' => 'https://via.placeholder.com/500x750/003366/FFFFFF?text=UCL',
        'sport_type' => 'football',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_live' => 0
    ]
];

$stmt = $db->prepare("INSERT INTO sports (title, title_ar, description, description_ar, poster_url, match_date, sport_type, status, subscription_tier, is_live, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($sports as $sport) {
    $stmt->execute([
        $sport['title'],
        $sport['title_ar'],
        $sport['description'],
        $sport['description_ar'],
        $sport['poster_url'],
        $sport['match_date'] ?? null,
        $sport['sport_type'],
        $sport['status'],
        $sport['subscription_tier'],
        $sport['is_live'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($sports) . " sports events\n";

// Sample Cartoons
echo "Adding cartoons...\n";
$cartoons = [
    [
        'title' => 'Toy Story',
        'title_ar' => 'حكاية لعبة',
        'description' => 'A cowboy doll is profoundly threatened when a new spaceman toy supplants him.',
        'description_ar' => 'دمية راعي البقر مهددة عندما تحل لعبة رائد فضاء جديد محله',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/uXDfjJbdP4ijW5hWSBrPrlKpxab.jpg',
        'duration' => 81,
        'release_year' => 1995,
        'rating' => 8.3,
        'age_rating' => 'G',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Finding Nemo',
        'title_ar' => 'البحث عن نيمو',
        'description' => 'A clownfish searches for his missing son.',
        'description_ar' => 'سمكة مهرج تبحث عن ابنها المفقود',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/eHuGQ10FUzK1mdOY69wF5pGgEf5.jpg',
        'duration' => 100,
        'release_year' => 2003,
        'rating' => 8.1,
        'age_rating' => 'G',
        'status' => 'published',
        'subscription_tier' => 'free'
    ]
];

$stmt = $db->prepare("INSERT INTO cartoons (title, title_ar, description, description_ar, poster_url, duration, release_year, rating, age_rating, status, subscription_tier, is_featured, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($cartoons as $cartoon) {
    $stmt->execute([
        $cartoon['title'],
        $cartoon['title_ar'],
        $cartoon['description'],
        $cartoon['description_ar'],
        $cartoon['poster_url'],
        $cartoon['duration'],
        $cartoon['release_year'],
        $cartoon['rating'],
        $cartoon['age_rating'],
        $cartoon['status'],
        $cartoon['subscription_tier'],
        $cartoon['is_featured'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($cartoons) . " cartoons\n";

// Sample Documentaries
echo "Adding documentaries...\n";
$documentaries = [
    [
        'title' => 'Planet Earth',
        'title_ar' => 'كوكب الأرض',
        'description' => 'A documentary series about nature and wildlife around the world.',
        'description_ar' => 'سلسلة وثائقية عن الطبيعة والحياة البرية حول العالم',
        'poster_url' => 'https://via.placeholder.com/500x750/2E7D32/FFFFFF?text=Planet+Earth',
        'duration' => 50,
        'release_year' => 2006,
        'rating' => 9.4,
        'director' => 'David Attenborough',
        'topic' => 'Nature',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'The Social Dilemma',
        'title_ar' => 'المعضلة الاجتماعية',
        'description' => 'Explores the dangerous human impact of social networking.',
        'description_ar' => 'يستكشف التأثير الخطير للشبكات الاجتماعية على البشر',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/4FdukXdPTcQx0O1u1wYGTaXJXzc.jpg',
        'duration' => 94,
        'release_year' => 2020,
        'rating' => 7.6,
        'topic' => 'Technology',
        'status' => 'published',
        'subscription_tier' => 'free'
    ]
];

$stmt = $db->prepare("INSERT INTO documentaries (title, title_ar, description, description_ar, poster_url, duration, release_year, rating, director, topic, status, subscription_tier, is_featured, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($documentaries as $doc) {
    $stmt->execute([
        $doc['title'],
        $doc['title_ar'],
        $doc['description'],
        $doc['description_ar'],
        $doc['poster_url'],
        $doc['duration'],
        $doc['release_year'],
        $doc['rating'],
        $doc['director'] ?? null,
        $doc['topic'] ?? null,
        $doc['status'],
        $doc['subscription_tier'],
        $doc['is_featured'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($documentaries) . " documentaries\n";

echo "\n✅ Sample content seeded successfully!\n";
echo "\nSummary:\n";
echo "- Movies: " . count($movies) . "\n";
echo "- Series: " . count($series) . "\n";
echo "- Sports: " . count($sports) . "\n";
echo "- Cartoons: " . count($cartoons) . "\n";
echo "- Documentaries: " . count($documentaries) . "\n";
