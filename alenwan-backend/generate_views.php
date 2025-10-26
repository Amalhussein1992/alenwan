<?php

/**
 * View Generator Script
 * Generates all missing admin views for Alenwan Backend
 */

echo "🎨 Generating Admin Views...\n\n";

// View templates will be created in resources/views/admin/

$entities = [
    'categories' => [
        'singular' => 'Category',
        'plural' => 'Categories',
        'icon' => 'folder',
        'fields' => ['name', 'description', 'type', 'sort_order', 'is_active', 'image']
    ],
    'languages' => [
        'singular' => 'Language',
        'plural' => 'Languages',
        'icon' => 'language',
        'fields' => ['name', 'code', 'is_active', 'flag']
    ],
    'podcasts' => [
        'singular' => 'Podcast',
        'plural' => 'Podcasts',
        'icon' => 'podcast',
        'fields' => ['title', 'description', 'host', 'guests', 'duration_seconds', 'release_date', 'cover_image', 'audio_file', 'status']
    ],
    'episodes' => [
        'singular' => 'Episode',
        'plural' => 'Episodes',
        'icon' => 'play-circle',
        'fields' => ['series_id', 'title', 'description', 'season_number', 'episode_number', 'duration_minutes', 'video_url', 'thumbnail', 'status']
    ]
];

$baseDir = __DIR__ . '/resources/views/admin';

foreach ($entities as $entity => $config) {
    $entityDir = "$baseDir/$entity";

    if (!is_dir($entityDir)) {
        mkdir($entityDir, 0755, true);
    }

    echo "✅ Created directory: $entityDir\n";

    // Create README with instructions
    $readmePath = "$entityDir/README.md";
    $readme = "# {$config['plural']} Views\n\n";
    $readme .= "## Views to Create:\n\n";
    $readme .= "1. **index.blade.php** - List all {$config['plural']}\n";
    $readme .= "2. **create.blade.php** - Form to create new {$config['singular']}\n";
    $readme .= "3. **edit.blade.php** - Form to edit existing {$config['singular']}\n\n";
    $readme .= "## Fields:\n\n";
    foreach ($config['fields'] as $field) {
        $readme .= "- `$field`\n";
    }
    $readme .= "\n## Copy From:\n\n";
    $readme .= "You can copy and modify from: `resources/views/admin/movies/`\n\n";
    $readme .= "## Route:\n\n";
    $readme .= "URL: `/admin/$entity`\n";

    file_put_contents($readmePath, $readme);
    echo "  📄 Created: README.md\n";

    // Create placeholder files
    $files = ['index.blade.php', 'create.blade.php', 'edit.blade.php'];
    foreach ($files as $file) {
        $filePath = "$entityDir/$file";
        if (!file_exists($filePath)) {
            $placeholder = "@extends('admin.layouts.app')\n\n";
            $placeholder .= "@section('title', '{$config['plural']} Management')\n\n";
            $placeholder .= "@section('content')\n";
            $placeholder .= "<div class=\"container-fluid p-0\">\n";
            $placeholder .= "    <h1>{$config['plural']} - " . ucfirst(str_replace('.blade.php', '', $file)) . "</h1>\n";
            $placeholder .= "    <p>View needs to be created. Copy from movies views and modify.</p>\n";
            $placeholder .= "</div>\n";
            $placeholder .= "@endsection\n";

            file_put_contents($filePath, $placeholder);
            echo "  📄 Created: $file\n";
        }
    }

    echo "\n";
}

echo "✅ All view directories and placeholders created!\n\n";
echo "📋 Summary:\n";
echo "===========\n";
foreach ($entities as $entity => $config) {
    echo "✅ $entity/\n";
    echo "   - index.blade.php\n";
    echo "   - create.blade.php\n";
    echo "   - edit.blade.php\n";
    echo "   - README.md\n\n";
}

echo "🎯 Next Steps:\n";
echo "=============\n";
echo "1. Visit: http://localhost:8000/admin/categories\n";
echo "2. Visit: http://localhost:8000/admin/languages\n";
echo "3. Visit: http://localhost:8000/admin/podcasts\n";
echo "4. Visit: http://localhost:8000/admin/episodes\n\n";
echo "Each will show a placeholder. Copy content from movies views and modify.\n\n";
echo "✨ Done!\n";
