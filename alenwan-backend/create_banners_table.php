<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Creating video_banners table...\n";

// Create video_banners table
$db->exec("
CREATE TABLE IF NOT EXISTS video_banners (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    title_ar VARCHAR(255),
    description TEXT,
    description_ar TEXT,
    video_url VARCHAR(500),
    thumbnail_url VARCHAR(500),
    content_type VARCHAR(50),
    content_id INTEGER,
    is_active BOOLEAN DEFAULT 1,
    priority INTEGER DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)
");

echo "✓ video_banners table created\n\n";

// Add sample banners
echo "Adding sample video banners...\n";
$now = date('Y-m-d H:i:s');

$banners = [
    [
        'title' => 'The Dark Knight',
        'title_ar' => 'فارس الظلام',
        'description' => 'Experience the epic Batman saga',
        'description_ar' => 'استمتع بملحمة باتمان الأسطورية',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
        'thumbnail_url' => 'https://picsum.photos/1920/1080?random=1',
        'content_type' => 'movie',
        'content_id' => 1,
        'is_active' => 1,
        'priority' => 10
    ],
    [
        'title' => 'Stranger Things',
        'title_ar' => 'أشياء غريبة',
        'description' => 'The supernatural thriller returns',
        'description_ar' => 'عودة مسلسل الإثارة الخارق',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
        'thumbnail_url' => 'https://picsum.photos/1920/1080?random=2',
        'content_type' => 'series',
        'content_id' => 2,
        'is_active' => 1,
        'priority' => 9
    ],
    [
        'title' => 'Premier League 2024',
        'title_ar' => 'الدوري الإنجليزي 2024',
        'description' => 'Watch live football action',
        'description_ar' => 'شاهد أحداث كرة القدم المباشرة',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
        'thumbnail_url' => 'https://picsum.photos/1920/1080?random=3',
        'content_type' => 'sport',
        'content_id' => 3,
        'is_active' => 1,
        'priority' => 8
    ],
    [
        'title' => 'The Lion King',
        'title_ar' => 'الأسد الملك',
        'description' => 'Classic Disney animated movie',
        'description_ar' => 'فيلم ديزني الكرتوني الكلاسيكي',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
        'thumbnail_url' => 'https://picsum.photos/1920/1080?random=4',
        'content_type' => 'cartoon',
        'content_id' => 4,
        'is_active' => 1,
        'priority' => 7
    ],
    [
        'title' => 'Our Planet',
        'title_ar' => 'كوكبنا',
        'description' => 'Stunning nature documentary',
        'description_ar' => 'وثائقي طبيعي مذهل',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
        'thumbnail_url' => 'https://picsum.photos/1920/1080?random=5',
        'content_type' => 'documentary',
        'content_id' => 5,
        'is_active' => 1,
        'priority' => 6
    ]
];

$stmt = $db->prepare("
    INSERT INTO video_banners (
        title, title_ar, description, description_ar,
        video_url, thumbnail_url, content_type, content_id,
        is_active, priority, created_at, updated_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($banners as $banner) {
    $stmt->execute([
        $banner['title'],
        $banner['title_ar'],
        $banner['description'],
        $banner['description_ar'],
        $banner['video_url'],
        $banner['thumbnail_url'],
        $banner['content_type'],
        $banner['content_id'],
        $banner['is_active'],
        $banner['priority'],
        $now,
        $now
    ]);
    echo "  ✓ Added banner: {$banner['title_ar']}\n";
}

echo "\n✓ All banners added successfully!\n";
echo "\nTotal banners: " . count($banners) . "\n";
