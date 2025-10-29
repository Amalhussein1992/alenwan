<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🎨 Creating Sliders for home page...\n\n";

$existing = DB::table('sliders')->count();
if ($existing > 0) {
    echo "✅ Sliders already exist ($existing sliders found)\n";
    exit(0);
}

// Get some movies for sliders
$movies = DB::table('movies')->limit(5)->get();

if ($movies->isEmpty()) {
    echo "⚠️ No movies found. Please seed content first.\n";
    exit(1);
}

$position = 1;
foreach ($movies as $movie) {
    try {
        DB::table('sliders')->insert([
            'title' => $movie->title,
            'description' => $movie->description,
            'image' => $movie->poster ?? $movie->thumbnail,
            'url' => '/movie/' . $movie->id,
            'is_active' => 1,
            'order' => $position++,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $title = json_decode($movie->title, true);
        echo "  ✓ Created slider for: " . ($title['en'] ?? $title['ar'] ?? 'Movie') . "\n";
    } catch (\Exception $e) {
        // Try simpler structure
        DB::table('sliders')->insert([
            'title' => $movie->title,
            'image' => $movie->poster ?? $movie->thumbnail,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "  ✓ Created slider (simple)\n";
    }
}

echo "\n✅ Sliders created successfully!\n";
echo "Total sliders: " . DB::table('sliders')->count() . "\n";
