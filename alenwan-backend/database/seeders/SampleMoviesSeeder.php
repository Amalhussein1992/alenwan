<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Seeder;

class SampleMoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and languages
        $categories = Category::all();
        $languages = Language::all();

        // Check if we have categories and languages
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        if ($languages->isEmpty()) {
            $this->command->warn('No languages found. Please run LanguageSeeder first.');
            return;
        }

        $movies = [
            [
                'title' => 'The Last Guardian',
                'description' => 'In a post-apocalyptic world, a lone warrior must protect the last surviving child who holds the key to humanity\'s future. An epic tale of sacrifice, courage, and redemption.',
                'poster_path' => '/posters/the-last-guardian.jpg',
                'banner_path' => '/banners/the-last-guardian.jpg',
                'video_path' => '/videos/the-last-guardian.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 8.5,
                'subscription_tier' => 'premium',
                'duration_minutes' => 142,
                'trailer_url' => 'https://youtube.com/watch?v=sample1',
                'cast' => ['Chris Hemsworth', 'Zendaya', 'Idris Elba', 'Viola Davis'],
                'genres' => ['Action', 'Sci-Fi', 'Drama'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/the-last-guardian/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/the-last-guardian.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 15420,
                'likes_count' => 1342,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Desert Storm',
                'description' => 'A gripping war drama set during the Gulf War. Follow a special forces team as they navigate through dangerous enemy territory to rescue hostages.',
                'poster_path' => '/posters/desert-storm.jpg',
                'banner_path' => '/banners/desert-storm.jpg',
                'video_path' => '/videos/desert-storm.mp4',
                'status' => 'published',
                'release_year' => 2023,
                'rating' => 7.8,
                'subscription_tier' => 'basic',
                'duration_minutes' => 128,
                'trailer_url' => 'https://youtube.com/watch?v=sample2',
                'cast' => ['Tom Hardy', 'Michael B. Jordan', 'Oscar Isaac'],
                'genres' => ['War', 'Action', 'Thriller'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/desert-storm/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/desert-storm.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 12890,
                'likes_count' => 987,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Love in Paris',
                'description' => 'A beautiful romantic comedy about two strangers who meet in Paris and fall in love during a magical summer. Their whirlwind romance takes unexpected turns.',
                'poster_path' => '/posters/love-in-paris.jpg',
                'banner_path' => '/banners/love-in-paris.jpg',
                'video_path' => '/videos/love-in-paris.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 7.2,
                'subscription_tier' => 'free',
                'duration_minutes' => 105,
                'trailer_url' => 'https://youtube.com/watch?v=sample3',
                'cast' => ['Emma Stone', 'Timothée Chalamet', 'Marion Cotillard'],
                'genres' => ['Romance', 'Comedy', 'Drama'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/love-in-paris/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/love-in-paris.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 23450,
                'likes_count' => 2145,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'fr')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Cyber Hunt',
                'description' => 'A brilliant hacker discovers a global conspiracy and must use his skills to expose the truth before it\'s too late. High-stakes digital warfare ensues.',
                'poster_path' => '/posters/cyber-hunt.jpg',
                'banner_path' => '/banners/cyber-hunt.jpg',
                'video_path' => '/videos/cyber-hunt.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 8.1,
                'subscription_tier' => 'premium',
                'duration_minutes' => 135,
                'trailer_url' => 'https://youtube.com/watch?v=sample4',
                'cast' => ['Rami Malek', 'Tilda Swinton', 'John Boyega'],
                'genres' => ['Thriller', 'Sci-Fi', 'Mystery'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/cyber-hunt/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/cyber-hunt.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 18765,
                'likes_count' => 1654,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'The Ancient Secret',
                'description' => 'An archaeological adventure that takes viewers on a journey through ancient civilizations. Discover hidden treasures and unlock mysteries of the past.',
                'poster_path' => '/posters/ancient-secret.jpg',
                'banner_path' => '/banners/ancient-secret.jpg',
                'video_path' => '/videos/ancient-secret.mp4',
                'status' => 'published',
                'release_year' => 2023,
                'rating' => 7.5,
                'subscription_tier' => 'basic',
                'duration_minutes' => 118,
                'trailer_url' => 'https://youtube.com/watch?v=sample5',
                'cast' => ['Harrison Ford', 'Alicia Vikander', 'Antonio Banderas'],
                'genres' => ['Adventure', 'Mystery', 'Action'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/ancient-secret/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/ancient-secret.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 14230,
                'likes_count' => 1198,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Night Shadows',
                'description' => 'A psychological horror film about a family that moves into a haunted mansion. As dark secrets unfold, they must confront their deepest fears.',
                'poster_path' => '/posters/night-shadows.jpg',
                'banner_path' => '/banners/night-shadows.jpg',
                'video_path' => '/videos/night-shadows.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 7.9,
                'subscription_tier' => 'premium',
                'duration_minutes' => 112,
                'trailer_url' => 'https://youtube.com/watch?v=sample6',
                'cast' => ['Lupita Nyong\'o', 'Daniel Kaluuya', 'Florence Pugh'],
                'genres' => ['Horror', 'Thriller', 'Mystery'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/night-shadows/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/night-shadows.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 19876,
                'likes_count' => 1765,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Racing Hearts',
                'description' => 'An adrenaline-pumping racing movie about a young driver who must prove himself in the world\'s most dangerous racing competition.',
                'poster_path' => '/posters/racing-hearts.jpg',
                'banner_path' => '/banners/racing-hearts.jpg',
                'video_path' => '/videos/racing-hearts.mp4',
                'status' => 'published',
                'release_year' => 2023,
                'rating' => 7.3,
                'subscription_tier' => 'basic',
                'duration_minutes' => 125,
                'trailer_url' => 'https://youtube.com/watch?v=sample7',
                'cast' => ['Vin Diesel', 'Gal Gadot', 'John Cena'],
                'genres' => ['Action', 'Sport', 'Drama'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/racing-hearts/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/racing-hearts.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 16543,
                'likes_count' => 1432,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'The Melody of Dreams',
                'description' => 'A musical drama about a talented musician who overcomes adversity to achieve her dreams. Featuring stunning musical performances.',
                'poster_path' => '/posters/melody-of-dreams.jpg',
                'banner_path' => '/banners/melody-of-dreams.jpg',
                'video_path' => '/videos/melody-of-dreams.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 8.3,
                'subscription_tier' => 'premium',
                'duration_minutes' => 138,
                'trailer_url' => 'https://youtube.com/watch?v=sample8',
                'cast' => ['Lady Gaga', 'Bradley Cooper', 'Beyoncé'],
                'genres' => ['Musical', 'Drama', 'Romance'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/melody-of-dreams/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/melody-of-dreams.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 21098,
                'likes_count' => 2234,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Warrior\'s Code',
                'description' => 'An epic martial arts film set in ancient China. A young warrior must master the ancient fighting techniques to save his village from invaders.',
                'poster_path' => '/posters/warriors-code.jpg',
                'banner_path' => '/banners/warriors-code.jpg',
                'video_path' => '/videos/warriors-code.mp4',
                'status' => 'published',
                'release_year' => 2023,
                'rating' => 8.0,
                'subscription_tier' => 'basic',
                'duration_minutes' => 132,
                'trailer_url' => 'https://youtube.com/watch?v=sample9',
                'cast' => ['Donnie Yen', 'Michelle Yeoh', 'Jackie Chan'],
                'genres' => ['Action', 'Martial Arts', 'Historical'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/warriors-code/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/warriors-code.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 17654,
                'likes_count' => 1543,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
            [
                'title' => 'Stellar Journey',
                'description' => 'A breathtaking space exploration epic. Join a crew of astronauts as they embark on humanity\'s first interstellar voyage to find a new home.',
                'poster_path' => '/posters/stellar-journey.jpg',
                'banner_path' => '/banners/stellar-journey.jpg',
                'video_path' => '/videos/stellar-journey.mp4',
                'status' => 'published',
                'release_year' => 2024,
                'rating' => 8.7,
                'subscription_tier' => 'premium',
                'duration_minutes' => 155,
                'trailer_url' => 'https://youtube.com/watch?v=sample10',
                'cast' => ['Matthew McConaughey', 'Anne Hathaway', 'Jessica Chastain'],
                'genres' => ['Sci-Fi', 'Adventure', 'Drama'],
                'playback' => [
                    'hls' => 'https://stream.alenwan.com/hls/stellar-journey/playlist.m3u8',
                    'mp4' => 'https://stream.alenwan.com/mp4/stellar-journey.mp4',
                ],
                'vimeo_video_id' => null,
                'views_count' => 25678,
                'likes_count' => 2876,
                'category_id' => $categories->where('type', 'movie')->first()?->id ?? $categories->first()->id,
                'language_id' => $languages->where('code', 'en')->first()?->id ?? $languages->first()->id,
            ],
        ];

        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }

        $this->command->info('Sample movies seeded successfully!');
        $this->command->info('Created 10 sample movies with various genres and ratings.');
    }
}
