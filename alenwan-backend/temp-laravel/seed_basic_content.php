<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🚀 Starting basic content seeding...\n\n";

// Count existing content
$moviesCount = DB::table('movies')->count();
$seriesCount = DB::table('series')->count();

echo "📊 Current counts:\n";
echo "  Movies: $moviesCount\n";
echo "  Series: $seriesCount\n";

if ($moviesCount >= 5 && $seriesCount >= 2) {
    echo "\n✅ Content already exists! Skipping seeding.\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📊 Summary:\n";
    echo "  • Movies: " . DB::table('movies')->count() . "\n";
    echo "  • Series: " . DB::table('series')->count() . "\n";
    echo "  • Episodes: " . DB::table('episodes')->count() . "\n";
    echo "  • Podcasts: " . DB::table('podcasts')->count() . "\n";
    echo "  • Sports: " . DB::table('sports')->count() . "\n";
    echo "  • Documentaries: " . DB::table('documentaries')->count() . "\n";
    echo "  • Cartoons: " . DB::table('cartoons')->count() . "\n";
    echo "  • Live Streams: " . DB::table('live_streams')->count() . "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    exit(0);
}

echo "\n✅ Content seeded successfully!\n";
echo "Your platform now has rich demo content ready for testing!\n";
