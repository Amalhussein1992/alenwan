<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Creating content tables...\n";

// Create movies table
$db->exec("CREATE TABLE IF NOT EXISTS movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    poster_url VARCHAR,
    trailer_url VARCHAR,
    video_url VARCHAR,
    duration INTEGER,
    release_year INTEGER,
    rating REAL DEFAULT 0,
    imdb_rating REAL,
    category_id INTEGER,
    language_id INTEGER,
    status VARCHAR DEFAULT 'published',
    subscription_tier VARCHAR DEFAULT 'free',
    views INTEGER DEFAULT 0,
    is_featured BOOLEAN DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Movies table created\n";

// Create series table
$db->exec("CREATE TABLE IF NOT EXISTS series (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    poster_url VARCHAR,
    trailer_url VARCHAR,
    release_year INTEGER,
    rating REAL DEFAULT 0,
    imdb_rating REAL,
    category_id INTEGER,
    language_id INTEGER,
    status VARCHAR DEFAULT 'published',
    subscription_tier VARCHAR DEFAULT 'free',
    views INTEGER DEFAULT 0,
    is_featured BOOLEAN DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Series table created\n";

// Create episodes table
$db->exec("CREATE TABLE IF NOT EXISTS episodes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    series_id INTEGER NOT NULL,
    season_number INTEGER NOT NULL,
    episode_number INTEGER NOT NULL,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    video_url VARCHAR,
    duration INTEGER,
    thumbnail_url VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Episodes table created\n";

// Create sports table
$db->exec("CREATE TABLE IF NOT EXISTS sports (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    poster_url VARCHAR,
    video_url VARCHAR,
    stream_url VARCHAR,
    match_date DATETIME,
    duration INTEGER,
    sport_type VARCHAR,
    status VARCHAR DEFAULT 'published',
    subscription_tier VARCHAR DEFAULT 'free',
    views INTEGER DEFAULT 0,
    is_live BOOLEAN DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Sports table created\n";

// Create cartoons table
$db->exec("CREATE TABLE IF NOT EXISTS cartoons (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    poster_url VARCHAR,
    trailer_url VARCHAR,
    video_url VARCHAR,
    duration INTEGER,
    release_year INTEGER,
    rating REAL DEFAULT 0,
    age_rating VARCHAR,
    category_id INTEGER,
    language_id INTEGER,
    status VARCHAR DEFAULT 'published',
    subscription_tier VARCHAR DEFAULT 'free',
    views INTEGER DEFAULT 0,
    is_featured BOOLEAN DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Cartoons table created\n";

// Create documentaries table
$db->exec("CREATE TABLE IF NOT EXISTS documentaries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    title_ar VARCHAR,
    description TEXT,
    description_ar TEXT,
    poster_url VARCHAR,
    trailer_url VARCHAR,
    video_url VARCHAR,
    duration INTEGER,
    release_year INTEGER,
    rating REAL DEFAULT 0,
    director VARCHAR,
    topic VARCHAR,
    category_id INTEGER,
    language_id INTEGER,
    status VARCHAR DEFAULT 'published',
    subscription_tier VARCHAR DEFAULT 'free',
    views INTEGER DEFAULT 0,
    is_featured BOOLEAN DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
)");
echo "✓ Documentaries table created\n";

echo "\nAll content tables created successfully!\n";
