<?php

namespace App\Services;

use Vimeo\Vimeo;
use Illuminate\Support\Facades\Log;

class VimeoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token')
        );
    }

    /**
     * Get video details from Vimeo
     *
     * @param string $videoId
     * @return array|null
     */
    public function getVideo(string $videoId)
    {
        try {
            $response = $this->client->request("/videos/{$videoId}");

            if ($response['status'] === 200) {
                return $response['body'];
            }

            Log::error('Vimeo API Error', ['response' => $response]);
            return null;
        } catch (\Exception $e) {
            Log::error('Vimeo Service Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user videos from Vimeo
     *
     * @param int $page
     * @param int $perPage
     * @return array|null
     */
    public function getUserVideos(int $page = 1, int $perPage = 25)
    {
        try {
            $response = $this->client->request('/me/videos', [
                'page' => $page,
                'per_page' => $perPage
            ], 'GET');

            if ($response['status'] === 200) {
                return $response['body'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Vimeo Service Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract video ID from Vimeo URL
     *
     * @param string $url
     * @return string|null
     */
    public function extractVideoId(string $url)
    {
        // Support multiple URL formats
        // https://vimeo.com/123456789
        // https://player.vimeo.com/video/123456789

        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return $matches[1];
        }

        if (preg_match('/player\.vimeo\.com\/video\/(\d+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get embed URL for video
     *
     * @param string $videoId
     * @return string
     */
    public function getEmbedUrl(string $videoId)
    {
        return "https://player.vimeo.com/video/{$videoId}";
    }

    /**
     * Get video thumbnail
     *
     * @param string $videoId
     * @return string|null
     */
    public function getThumbnail(string $videoId)
    {
        $video = $this->getVideo($videoId);

        if ($video && isset($video['pictures']['sizes'])) {
            // Get the largest thumbnail
            $thumbnails = $video['pictures']['sizes'];
            return end($thumbnails)['link'] ?? null;
        }

        return null;
    }

    /**
     * Get video duration in seconds
     *
     * @param string $videoId
     * @return int|null
     */
    public function getDuration(string $videoId)
    {
        $video = $this->getVideo($videoId);

        return $video['duration'] ?? null;
    }
}
