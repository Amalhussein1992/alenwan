<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    /**
     * Get all movies
     */
    public function getMovies(): JsonResponse
    {
        $movies = [
            [
                'id' => 1,
                'title' => 'The Matrix Resurrections',
                'description' => 'Return to a world of two realities: one, everyday life; the other, what lies behind it.',
                'poster' => 'https://image.tmdb.org/t/p/w500/8c4a8kE7PizaGQQnditMmI1xbRp.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/eNI7PtK6DEYgZmHWP9gQNuff8pv.jpg',
                'rating' => 6.7,
                'year' => 2021,
                'duration' => 148,
                'genre' => ['Action', 'Science Fiction'],
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                'is_premium' => false,
            ],
            [
                'id' => 2,
                'title' => 'Spider-Man: No Way Home',
                'description' => 'Peter Parker seeks help from Doctor Strange which leads to dangerous consequences.',
                'poster' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/iQFcwSGbZXMkeyKrxbPnwnRo5fl.jpg',
                'rating' => 8.3,
                'year' => 2021,
                'duration' => 148,
                'genre' => ['Action', 'Adventure', 'Science Fiction'],
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
                'is_premium' => true,
            ],
            [
                'id' => 3,
                'title' => 'Dune',
                'description' => 'Paul Atreides unites with the Fremen to prevent a terrible future.',
                'poster' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/jYEW5xZkZk2WTrdbMGAPFuBqbDc.jpg',
                'rating' => 8.0,
                'year' => 2021,
                'duration' => 155,
                'genre' => ['Science Fiction', 'Adventure'],
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                'is_premium' => false,
            ],
            [
                'id' => 4,
                'title' => 'The Batman',
                'description' => 'Batman ventures into Gotham\'s underworld to unmask the truth.',
                'poster' => 'https://image.tmdb.org/t/p/w500/74xTEgt7R36Fpooo50r9T25onhq.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/xHrp2pq73oi9D64xigPjWW1wcz1.jpg',
                'rating' => 7.9,
                'year' => 2022,
                'duration' => 176,
                'genre' => ['Crime', 'Mystery', 'Thriller'],
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
                'is_premium' => true,
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $movies,
            'count' => count($movies)
        ]);
    }

    /**
     * Get all series
     */
    public function getSeries(): JsonResponse
    {
        $series = [
            [
                'id' => 1,
                'title' => 'Stranger Things',
                'description' => 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments.',
                'poster' => 'https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/56v2KjBlU4XaOv9rVYEQypROD7P.jpg',
                'rating' => 8.7,
                'year' => 2016,
                'seasons' => 4,
                'episodes' => 42,
                'genre' => ['Drama', 'Mystery', 'Sci-Fi'],
                'is_premium' => false,
            ],
            [
                'id' => 2,
                'title' => 'The Witcher',
                'description' => 'Geralt of Rivia, a mutated monster-hunter, struggles to find his place in a world.',
                'poster' => 'https://image.tmdb.org/t/p/w500/7vjaCdMw15FEbXyLQTVa04URsPm.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/1R68vl3dFECIuYNs6GHY0b0fHRq.jpg',
                'rating' => 8.2,
                'year' => 2019,
                'seasons' => 3,
                'episodes' => 24,
                'genre' => ['Action', 'Adventure', 'Fantasy'],
                'is_premium' => true,
            ],
            [
                'id' => 3,
                'title' => 'Wednesday',
                'description' => 'Wednesday Addams investigates a murder mystery at Nevermore Academy.',
                'poster' => 'https://image.tmdb.org/t/p/w500/9PFonBhy4cQy7Jz20NpMygczOkv.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/iHSwvRVsRyxpX7FE7GbviaDvgGZ.jpg',
                'rating' => 8.5,
                'year' => 2022,
                'seasons' => 1,
                'episodes' => 8,
                'genre' => ['Comedy', 'Crime', 'Fantasy'],
                'is_premium' => false,
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $series,
            'count' => count($series)
        ]);
    }

    /**
     * Get all live streams
     */
    public function getLiveStreams(): JsonResponse
    {
        $streams = [
            [
                'id' => 1,
                'title' => 'CNN International',
                'description' => '24/7 News Coverage',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/CNN.svg/200px-CNN.svg.png',
                'category' => 'News',
                'stream_url' => 'https://cnn-cnninternational-1-gb.samsung.wurl.com/manifest/playlist.m3u8',
                'is_live' => true,
                'viewers' => 12453,
            ],
            [
                'id' => 2,
                'title' => 'BBC News',
                'description' => 'Breaking News & Analysis',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/BBC_News_2019.svg/200px-BBC_News_2019.svg.png',
                'category' => 'News',
                'stream_url' => 'http://1111296894.rsc.cdn77.org/LS-ATL-54548-11/index.m3u8',
                'is_live' => true,
                'viewers' => 8932,
            ],
            [
                'id' => 3,
                'title' => 'Sky Sports',
                'description' => 'Live Sports Events',
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b0/Sky_Sports_logo_2020.svg/200px-Sky_Sports_logo_2020.svg.png',
                'category' => 'Sports',
                'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                'is_live' => true,
                'viewers' => 25674,
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $streams,
            'count' => count($streams)
        ]);
    }

    /**
     * Get all channels
     */
    public function getChannels(): JsonResponse
    {
        $channels = [
            [
                'id' => 1,
                'name' => 'HBO Max',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/HBO_Max_Logo.svg/200px-HBO_Max_Logo.svg.png',
                'category' => 'Entertainment',
                'country' => 'USA',
                'language' => 'English',
                'is_hd' => true,
                'is_premium' => true,
                'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
            ],
            [
                'id' => 2,
                'name' => 'National Geographic',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Natgeologo.svg/200px-Natgeologo.svg.png',
                'category' => 'Documentary',
                'country' => 'USA',
                'language' => 'English',
                'is_hd' => true,
                'is_premium' => false,
                'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4',
            ],
            [
                'id' => 3,
                'name' => 'Cartoon Network',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/Cartoon_Network_2010_logo.svg/200px-Cartoon_Network_2010_logo.svg.png',
                'category' => 'Kids',
                'country' => 'USA',
                'language' => 'English',
                'is_hd' => true,
                'is_premium' => false,
                'stream_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerMeltdowns.mp4',
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $channels,
            'count' => count($channels)
        ]);
    }

    /**
     * Get home page banners
     */
    public function getBanners(): JsonResponse
    {
        $banners = [
            [
                'id' => 1,
                'title' => 'Avatar: The Way of Water',
                'subtitle' => 'Now Streaming',
                'image' => 'https://image.tmdb.org/t/p/original/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg',
                'action_url' => '/movie/1',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'title' => 'The Last of Us',
                'subtitle' => 'New Episodes Every Sunday',
                'image' => 'https://image.tmdb.org/t/p/original/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg',
                'action_url' => '/series/1',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'title' => 'Live Sports',
                'subtitle' => 'UEFA Champions League',
                'image' => 'https://image.tmdb.org/t/p/original/628Dep6AxEtDxjZoGP78TsOxYbK.jpg',
                'action_url' => '/live/1',
                'is_active' => true,
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $banners,
            'count' => count($banners)
        ]);
    }

    /**
     * Get categories
     */
    public function getCategories(): JsonResponse
    {
        $categories = [
            ['id' => 1, 'name' => 'Action', 'icon' => 'action', 'color' => '#FF5722'],
            ['id' => 2, 'name' => 'Comedy', 'icon' => 'comedy', 'color' => '#FFC107'],
            ['id' => 3, 'name' => 'Drama', 'icon' => 'drama', 'color' => '#9C27B0'],
            ['id' => 4, 'name' => 'Horror', 'icon' => 'horror', 'color' => '#F44336'],
            ['id' => 5, 'name' => 'Romance', 'icon' => 'romance', 'color' => '#E91E63'],
            ['id' => 6, 'name' => 'Sci-Fi', 'icon' => 'scifi', 'color' => '#2196F3'],
            ['id' => 7, 'name' => 'Thriller', 'icon' => 'thriller', 'color' => '#37474F'],
            ['id' => 8, 'name' => 'Documentary', 'icon' => 'documentary', 'color' => '#4CAF50'],
            ['id' => 9, 'name' => 'Kids', 'icon' => 'kids', 'color' => '#FF9800'],
            ['id' => 10, 'name' => 'Sports', 'icon' => 'sports', 'color' => '#00BCD4'],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $categories,
            'count' => count($categories)
        ]);
    }

    /**
     * Search content
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        // Mock search results
        $results = [
            'movies' => [
                [
                    'id' => 1,
                    'title' => 'The Matrix',
                    'poster' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
                    'year' => 1999,
                    'rating' => 8.7,
                ],
            ],
            'series' => [
                [
                    'id' => 1,
                    'title' => 'Breaking Bad',
                    'poster' => 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg',
                    'year' => 2008,
                    'rating' => 9.5,
                ],
            ],
            'channels' => [],
        ];

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'results' => $results,
        ]);
    }
}