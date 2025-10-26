<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Adding more sample content...\n\n";

$now = date('Y-m-d H:i:s');

// Add more movies
echo "Adding more movies...\n";
$movies = [
    [
        'title' => 'The Dark Knight',
        'title_ar' => 'فارس الظلام',
        'description' => 'Batman faces the Joker, a criminal mastermind wreaking havoc in Gotham.',
        'description_ar' => 'باتمان يواجه الجوكر، عقل إجرامي يعيث فسادا في جوثام',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
        'duration' => 152,
        'release_year' => 2008,
        'rating' => 9.0,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Pulp Fiction',
        'title_ar' => 'الخيال اللبي',
        'description' => 'The lives of two mob hitmen, a boxer, and a pair of diner bandits intertwine.',
        'description_ar' => 'تتشابك حياة قاتلين مأجورين وملاكم وزوج من قطاع الطرق',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg',
        'duration' => 154,
        'release_year' => 1994,
        'rating' => 8.9,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Forrest Gump',
        'title_ar' => 'فورست غامب',
        'description' => 'The presidencies of Kennedy and Johnson unfold through the perspective of an Alabama man.',
        'description_ar' => 'تتكشف رئاسات كينيدي وجونسون من خلال منظور رجل من ألاباما',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg',
        'duration' => 142,
        'release_year' => 1994,
        'rating' => 8.8,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'The Shawshank Redemption',
        'title_ar' => 'الخلاص من شاوشانك',
        'description' => 'Two imprisoned men bond over years, finding redemption through acts of common decency.',
        'description_ar' => 'رجلان مسجونان يتواصلان على مدى سنوات، ويجدان الخلاص من خلال أعمال اللياقة المشتركة',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg',
        'duration' => 142,
        'release_year' => 1994,
        'rating' => 9.3,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'The Godfather',
        'title_ar' => 'العراب',
        'description' => 'The aging patriarch of an organized crime dynasty transfers control to his reluctant son.',
        'description_ar' => 'البطريرك المسن لسلالة الجريمة المنظمة ينقل السيطرة إلى ابنه المتردد',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg',
        'duration' => 175,
        'release_year' => 1972,
        'rating' => 9.2,
        'status' => 'published',
        'subscription_tier' => 'premium'
    ],
    [
        'title' => 'Titanic',
        'title_ar' => 'تايتانيك',
        'description' => 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious ill-fated R.M.S. Titanic.',
        'description_ar' => 'أرستقراطية تبلغ من العمر سبعة عشر عاما تقع في حب فنان طيب لكن فقير على متن سفينة تايتانيك الفاخرة',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg',
        'duration' => 194,
        'release_year' => 1997,
        'rating' => 7.9,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Avatar',
        'title_ar' => 'أفاتار',
        'description' => 'A paraplegic Marine dispatched to the moon Pandora on a unique mission.',
        'description_ar' => 'مشاة البحرية المشلول أرسل إلى القمر باندورا في مهمة فريدة من نوعها',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/jRXYjXNq0Cs2TcJjLkki24MLp7u.jpg',
        'duration' => 162,
        'release_year' => 2009,
        'rating' => 7.8,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Avengers: Endgame',
        'title_ar' => 'المنتقمون: نهاية اللعبة',
        'description' => 'After the devastating events, the Avengers assemble once more to reverse Thanos actions.',
        'description_ar' => 'بعد الأحداث المدمرة، يجتمع المنتقمون مرة أخرى لعكس أفعال ثانوس',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
        'duration' => 181,
        'release_year' => 2019,
        'rating' => 8.4,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Spider-Man: No Way Home',
        'title_ar' => 'الرجل العنكبوت: لا طريق للعودة',
        'description' => 'Peter Parker seeks help from Doctor Strange when his identity is revealed.',
        'description_ar' => 'بيتر باركر يطلب المساعدة من دكتور سترينج عندما تم الكشف عن هويته',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
        'duration' => 148,
        'release_year' => 2021,
        'rating' => 8.2,
        'status' => 'published',
        'subscription_tier' => 'premium'
    ],
    [
        'title' => 'Joker',
        'title_ar' => 'الجوكر',
        'description' => 'In Gotham City, mentally troubled comedian Arthur Fleck embarks on a downward spiral.',
        'description_ar' => 'في مدينة جوثام، الكوميدي المضطرب عقليا آرثر فليك يبدأ في دوامة هبوطية',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg',
        'duration' => 122,
        'release_year' => 2019,
        'rating' => 8.4,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
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
echo "✓ Added " . count($movies) . " more movies\n";

// Add more series
echo "Adding more series...\n";
$series = [
    [
        'title' => 'Stranger Things',
        'title_ar' => 'أشياء غريبة',
        'description' => 'When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces.',
        'description_ar' => 'عندما يختفي صبي صغير، يجب على والدته ورئيس الشرطة وأصدقائه مواجهة قوى خارقة مرعبة',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg',
        'release_year' => 2016,
        'rating' => 8.7,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'The Witcher',
        'title_ar' => 'الساحر',
        'description' => 'Geralt of Rivia, a solitary monster hunter, struggles to find his place in a world.',
        'description_ar' => 'جيرالت من ريفيا، صياد وحوش منفرد، يكافح للعثور على مكانه في العالم',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/7vjaCdMw15FEbXyLQTVa04URsPm.jpg',
        'release_year' => 2019,
        'rating' => 8.2,
        'status' => 'published',
        'subscription_tier' => 'premium',
        'is_featured' => 1
    ],
    [
        'title' => 'The Crown',
        'title_ar' => 'التاج',
        'description' => 'Follows the political rivalries and romance of Queen Elizabeth IIs reign.',
        'description_ar' => 'يتابع التنافسات السياسية والرومانسية لعهد الملكة إليزابيث الثانية',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/1M876KPjulVwppEpldhdc8V4o68.jpg',
        'release_year' => 2016,
        'rating' => 8.6,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Wednesday',
        'title_ar' => 'الأربعاء',
        'description' => 'Wednesday Addams attempts to master her emerging psychic ability.',
        'description_ar' => 'الأربعاء آدامز تحاول إتقان قدرتها النفسية الناشئة',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/9PFonBhy4cQy7Jz20NpMygczOkv.jpg',
        'release_year' => 2022,
        'rating' => 8.1,
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Money Heist',
        'title_ar' => 'بيت من ورق',
        'description' => 'An unusual group of robbers attempt to carry out the most perfect robbery.',
        'description_ar' => 'مجموعة غير عادية من اللصوص تحاول تنفيذ السرقة الأكثر كمالا',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg',
        'release_year' => 2017,
        'rating' => 8.2,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'The Last of Us',
        'title_ar' => 'آخرنا',
        'description' => 'After a global pandemic destroys civilization, a hardened survivor takes charge.',
        'description_ar' => 'بعد أن يدمر وباء عالمي الحضارة، يتولى ناج متشدد المسؤولية',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg',
        'release_year' => 2023,
        'rating' => 8.8,
        'status' => 'published',
        'subscription_tier' => 'premium',
        'is_featured' => 1
    ],
    [
        'title' => 'Friends',
        'title_ar' => 'الأصدقاء',
        'description' => 'Follows the personal and professional lives of six twenty to thirty-something friends.',
        'description_ar' => 'يتابع الحياة الشخصية والمهنية لستة أصدقاء في العشرينات والثلاثينيات',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/f496cm9enuEsZkSPzCwnTESEK5s.jpg',
        'release_year' => 1994,
        'rating' => 8.9,
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Peaky Blinders',
        'title_ar' => 'بيكي بلايندرز',
        'description' => 'A gangster family epic set in 1900s England.',
        'description_ar' => 'ملحمة عائلة عصابات تدور أحداثها في إنجلترا في القرن العشرين',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/vUUqzWa2LnHIVqkaKVlVGkVcZIW.jpg',
        'release_year' => 2013,
        'rating' => 8.8,
        'status' => 'published',
        'subscription_tier' => 'premium'
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
echo "✓ Added " . count($series) . " more series\n";

// Add more cartoons
echo "Adding more cartoons...\n";
$cartoons = [
    [
        'title' => 'The Lion King',
        'title_ar' => 'الأسد الملك',
        'description' => 'Lion prince Simba flees his kingdom after the murder of his father.',
        'description_ar' => 'الأمير الأسد سيمبا يهرب من مملكته بعد مقتل والده',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/sKCr78MXSLixwmZ8DyJLrpMsd15.jpg',
        'duration' => 88,
        'release_year' => 1994,
        'rating' => 8.5,
        'age_rating' => 'G',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Frozen',
        'title_ar' => 'ملكة الثلج',
        'description' => 'When their kingdom is trapped in eternal winter, Anna teams up with Kristoff.',
        'description_ar' => 'عندما تحبس مملكتهم في شتاء أبدي، تتعاون آنا مع كريستوف',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/kgwjIb2JDHRhNk13lmSxiClFjVk.jpg',
        'duration' => 102,
        'release_year' => 2013,
        'rating' => 7.4,
        'age_rating' => 'PG',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Moana',
        'title_ar' => 'موانا',
        'description' => 'A Polynesian girl sets sail in search of a fabled island.',
        'description_ar' => 'فتاة بولينيزية تبحر بحثا عن جزيرة أسطورية',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/4JeejGugONWpJkbnvL12hVoYEDa.jpg',
        'duration' => 107,
        'release_year' => 2016,
        'rating' => 7.6,
        'age_rating' => 'PG',
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Coco',
        'title_ar' => 'كوكو',
        'description' => 'A young boy dreams of becoming a musician despite his familys ban on music.',
        'description_ar' => 'صبي صغير يحلم بأن يصبح موسيقيا على الرغم من حظر عائلته على الموسيقى',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/gGEsBPAijhVUFoiNpgZXqRVWJt2.jpg',
        'duration' => 105,
        'release_year' => 2017,
        'rating' => 8.4,
        'age_rating' => 'PG',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Inside Out',
        'title_ar' => 'من الداخل إلى الخارج',
        'description' => 'After young Riley is uprooted from her Midwest life, her emotions conflict.',
        'description_ar' => 'بعد أن تم اقتلاع رايلي الصغيرة من حياتها في الغرب الأوسط، تتعارض عواطفها',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/2H1TmgdfNtsKlU9jKdeNyYL5y8T.jpg',
        'duration' => 95,
        'release_year' => 2015,
        'rating' => 8.1,
        'age_rating' => 'PG',
        'status' => 'published',
        'subscription_tier' => 'premium'
    ],
    [
        'title' => 'Zootopia',
        'title_ar' => 'زوتوبيا',
        'description' => 'In a city of anthropomorphic animals, a rookie bunny cop and a cynical con artist fox must work together.',
        'description_ar' => 'في مدينة من الحيوانات البشرية، يجب على شرطي أرنب مبتدئ وثعلب محتال ساخر العمل معا',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/hlK0e0wAQ3VLuJcsfIYPvTLS98Y.jpg',
        'duration' => 108,
        'release_year' => 2016,
        'rating' => 8.0,
        'age_rating' => 'PG',
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
echo "✓ Added " . count($cartoons) . " more cartoons\n";

// Add more documentaries
echo "Adding more documentaries...\n";
$documentaries = [
    [
        'title' => 'Our Planet',
        'title_ar' => 'كوكبنا',
        'description' => 'Documentary series focusing on the breadth of the diversity of habitats around the world.',
        'description_ar' => 'سلسلة وثائقية تركز على اتساع تنوع الموائل في جميع أنحاء العالم',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/szhjalHPAg875xN0FKS8C1xnaKX.jpg',
        'duration' => 50,
        'release_year' => 2019,
        'rating' => 9.3,
        'director' => 'David Attenborough',
        'topic' => 'Nature',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'Blue Planet II',
        'title_ar' => 'الكوكب الأزرق 2',
        'description' => 'David Attenborough returns to the worlds oceans in this sequel.',
        'description_ar' => 'يعود ديفيد أتينبورو إلى محيطات العالم في هذا التتمة',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/mz6CPpJkzR5OJWCdJQRYSAloRAp.jpg',
        'duration' => 60,
        'release_year' => 2017,
        'rating' => 9.1,
        'director' => 'David Attenborough',
        'topic' => 'Ocean',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_featured' => 1
    ],
    [
        'title' => 'The Last Dance',
        'title_ar' => 'الرقصة الأخيرة',
        'description' => 'Charting the rise of the 1990s Chicago Bulls.',
        'description_ar' => 'تتبع صعود فريق شيكاغو بولز في التسعينيات',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/fq0FiXdnAJV4pJmwV6HfmjEcVvj.jpg',
        'duration' => 60,
        'release_year' => 2020,
        'rating' => 9.1,
        'topic' => 'Sports',
        'status' => 'published',
        'subscription_tier' => 'premium'
    ],
    [
        'title' => 'Cosmos',
        'title_ar' => 'الكون',
        'description' => 'An exploration of our discovery of the laws of nature and coordinates in space and time.',
        'description_ar' => 'استكشاف اكتشافنا لقوانين الطبيعة والإحداثيات في الفضاء والزمان',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/4Qf7QFfQ9E2hC5iI5qk9mGWaCvp.jpg',
        'duration' => 45,
        'release_year' => 2014,
        'rating' => 9.2,
        'director' => 'Neil deGrasse Tyson',
        'topic' => 'Science',
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'Free Solo',
        'title_ar' => 'تسلق حر',
        'description' => 'Follow Alex Honnold as he attempts to climb El Capitan in Yosemite without a rope.',
        'description_ar' => 'تابع أليكس هونولد وهو يحاول تسلق إل كابيتان في يوسمايت بدون حبل',
        'poster_url' => 'https://image.tmdb.org/t/p/w500/v4QfYZMACODlWul9doN9RxE99ag.jpg',
        'duration' => 100,
        'release_year' => 2018,
        'rating' => 8.2,
        'topic' => 'Adventure',
        'status' => 'published',
        'subscription_tier' => 'premium',
        'is_featured' => 1
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
echo "✓ Added " . count($documentaries) . " more documentaries\n";

// Add more sports
echo "Adding more sports...\n";
$sports = [
    [
        'title' => 'Premier League 2023/24',
        'title_ar' => 'الدوري الإنجليزي الممتاز 2023/24',
        'description' => 'Premier League matches and highlights',
        'description_ar' => 'مباريات وأبرز أحداث الدوري الإنجليزي الممتاز',
        'poster_url' => 'https://via.placeholder.com/500x750/38003C/FFFFFF?text=Premier+League',
        'sport_type' => 'football',
        'status' => 'published',
        'subscription_tier' => 'premium',
        'is_live' => 0
    ],
    [
        'title' => 'La Liga Highlights',
        'title_ar' => 'أبرز أحداث الليغا',
        'description' => 'Best moments from Spanish La Liga',
        'description_ar' => 'أفضل اللحظات من الدوري الإسباني',
        'poster_url' => 'https://via.placeholder.com/500x750/FF6B00/FFFFFF?text=La+Liga',
        'sport_type' => 'football',
        'status' => 'published',
        'subscription_tier' => 'free'
    ],
    [
        'title' => 'NBA Finals 2023',
        'title_ar' => 'نهائيات NBA 2023',
        'description' => 'Basketball championship finals',
        'description_ar' => 'نهائيات بطولة كرة السلة',
        'poster_url' => 'https://via.placeholder.com/500x750/C8102E/FFFFFF?text=NBA',
        'sport_type' => 'basketball',
        'status' => 'published',
        'subscription_tier' => 'premium',
        'is_live' => 0
    ],
    [
        'title' => 'Wimbledon Tennis',
        'title_ar' => 'تنس ويمبلدون',
        'description' => 'Grand Slam tennis tournament',
        'description_ar' => 'بطولة جراند سلام للتنس',
        'poster_url' => 'https://via.placeholder.com/500x750/00533E/FFFFFF?text=Wimbledon',
        'sport_type' => 'tennis',
        'status' => 'published',
        'subscription_tier' => 'free',
        'is_live' => 0
    ],
    [
        'title' => 'UFC Fight Night',
        'title_ar' => 'ليلة قتال UFC',
        'description' => 'Mixed martial arts fighting championship',
        'description_ar' => 'بطولة فنون القتال المختلطة',
        'poster_url' => 'https://via.placeholder.com/500x750/D20A0A/FFFFFF?text=UFC',
        'sport_type' => 'mma',
        'status' => 'published',
        'subscription_tier' => 'premium'
    ]
];

$stmt = $db->prepare("INSERT INTO sports (title, title_ar, description, description_ar, poster_url, sport_type, status, subscription_tier, is_live, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($sports as $sport) {
    $stmt->execute([
        $sport['title'],
        $sport['title_ar'],
        $sport['description'],
        $sport['description_ar'],
        $sport['poster_url'],
        $sport['sport_type'],
        $sport['status'],
        $sport['subscription_tier'],
        $sport['is_live'] ?? 0,
        $now,
        $now
    ]);
}
echo "✓ Added " . count($sports) . " more sports events\n";

echo "\n✅ Additional content added successfully!\n";
echo "\nTotal new content added:\n";
echo "- Movies: " . count($movies) . "\n";
echo "- Series: " . count($series) . "\n";
echo "- Sports: " . count($sports) . "\n";
echo "- Cartoons: " . count($cartoons) . "\n";
echo "- Documentaries: " . count($documentaries) . "\n";

// Get totals from database
$totals = [
    'movies' => $db->query("SELECT COUNT(*) FROM movies")->fetchColumn(),
    'series' => $db->query("SELECT COUNT(*) FROM series")->fetchColumn(),
    'sports' => $db->query("SELECT COUNT(*) FROM sports")->fetchColumn(),
    'cartoons' => $db->query("SELECT COUNT(*) FROM cartoons")->fetchColumn(),
    'documentaries' => $db->query("SELECT COUNT(*) FROM documentaries")->fetchColumn(),
];

echo "\n📊 Total content in database:\n";
echo "- Movies: " . $totals['movies'] . "\n";
echo "- Series: " . $totals['series'] . "\n";
echo "- Sports: " . $totals['sports'] . "\n";
echo "- Cartoons: " . $totals['cartoons'] . "\n";
echo "- Documentaries: " . $totals['documentaries'] . "\n";
