<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Language;
use App\Models\Channel;
use App\Models\LiveStream;

echo "📺 إضافة القنوات والبثوث المباشرة...\n\n";

// Get categories and languages
$docCat = Category::where('slug', 'documentary')->first();
$sportsCat = Category::where('slug', 'sports')->first();
$eduCat = Category::where('slug', 'education')->first();
$arLang = Language::where('code', 'ar')->first();
$enLang = Language::where('code', 'en')->first();

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
        'youtube_live_stream_id' => 'jfKfPfyJRdk',
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
    $ch = Channel::firstOrCreate(['slug' => $channel['slug']], $channel);
    $channelObjects[] = $ch;
}
echo "✅ تم إضافة " . count($channels) . " قناة\n\n";

// Add Live Streams
echo "📡 إضافة البثوث المباشرة...\n";
$liveStreams = [
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
    LiveStream::firstOrCreate(['slug' => $stream['slug']], $stream);
}
echo "✅ تم إضافة " . count($liveStreams) . " بث مباشر\n\n";

echo "🎉 تم إضافة القنوات والبثوث المباشرة بنجاح!\n";
echo "✨ يمكنك الآن تصفحها في لوحة التحكم على http://localhost:8000/admin\n";
