<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VimeoService
{
    private $accessToken;
    private $baseUrl = 'https://api.vimeo.com';

    public function __construct()
    {
        $this->accessToken = config('services.vimeo.access_token');
    }

    /**
     * Upload a video to Vimeo
     */
    public function uploadVideo($videoPath, $title, $description = '', $privacy = 'unlisted')
    {
        try {
            // Step 1: Create the video record
            $createResponse = $this->createVideoRecord($title, $description, $privacy);

            if (!$createResponse || !isset($createResponse['upload']['upload_link'])) {
                throw new \Exception('Failed to create video record on Vimeo');
            }

            $videoId = $this->extractVideoId($createResponse['uri']);
            $uploadLink = $createResponse['upload']['upload_link'];

            // Step 2: Upload the video file
            $uploadSuccess = $this->uploadVideoFile($uploadLink, $videoPath);

            if (!$uploadSuccess) {
                throw new \Exception('Failed to upload video file to Vimeo');
            }

            // Step 3: Return video information
            return [
                'video_id' => $videoId,
                'vimeo_url' => "https://vimeo.com/{$videoId}",
                'embed_url' => "https://player.vimeo.com/video/{$videoId}",
                'status' => 'uploading',
                'upload_link' => $uploadLink,
            ];

        } catch (\Exception $e) {
            Log::error('Vimeo upload failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get video information from Vimeo
     */
    public function getVideoInfo($videoId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ])->get("{$this->baseUrl}/videos/{$videoId}");

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'video_id' => $videoId,
                    'name' => $data['name'] ?? '',
                    'description' => $data['description'] ?? '',
                    'duration' => $data['duration'] ?? 0,
                    'status' => $data['status'] ?? 'unknown',
                    'thumbnail' => $data['pictures']['sizes'][0]['link'] ?? '',
                    'embed_url' => "https://player.vimeo.com/video/{$videoId}",
                    'vimeo_url' => $data['link'] ?? '',
                    'width' => $data['width'] ?? 0,
                    'height' => $data['height'] ?? 0,
                    'files' => $this->extractVideoFiles($data),
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get Vimeo video info: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update video information on Vimeo
     */
    public function updateVideo($videoId, $title = null, $description = null, $privacy = null)
    {
        try {
            $data = [];

            if ($title) {
                $data['name'] = $title;
            }

            if ($description) {
                $data['description'] = $description;
            }

            if ($privacy) {
                $data['privacy'] = ['view' => $privacy];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ])->patch("{$this->baseUrl}/videos/{$videoId}", $data);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to update Vimeo video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete video from Vimeo
     */
    public function deleteVideo($videoId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
            ])->delete("{$this->baseUrl}/videos/{$videoId}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to delete Vimeo video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get video playback URLs
     */
    public function getPlaybackUrls($videoId)
    {
        try {
            $videoInfo = $this->getVideoInfo($videoId);

            if (!$videoInfo) {
                return false;
            }

            return $videoInfo['files'];
        } catch (\Exception $e) {
            Log::error('Failed to get Vimeo playback URLs: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a video record on Vimeo
     */
    private function createVideoRecord($title, $description, $privacy)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/me/videos", [
            'name' => $title,
            'description' => $description,
            'privacy' => [
                'view' => $privacy,
                'embed' => 'public',
            ],
            'upload' => [
                'approach' => 'post',
                'size' => filesize(request()->file('video')->getPathname()),
            ],
        ]);

        return $response->successful() ? $response->json() : false;
    }

    /**
     * Upload video file to Vimeo
     */
    private function uploadVideoFile($uploadLink, $videoPath)
    {
        try {
            $response = Http::withBody(
                file_get_contents($videoPath),
                'video/mp4'
            )->put($uploadLink);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to upload video file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extract video ID from Vimeo URI
     */
    private function extractVideoId($uri)
    {
        return str_replace('/videos/', '', $uri);
    }

    /**
     * Extract video files from Vimeo response
     */
    private function extractVideoFiles($data)
    {
        $files = [];

        if (isset($data['files'])) {
            foreach ($data['files'] as $file) {
                $files[] = [
                    'quality' => $file['quality'] ?? 'unknown',
                    'type' => $file['type'] ?? 'unknown',
                    'width' => $file['width'] ?? 0,
                    'height' => $file['height'] ?? 0,
                    'link' => $file['link'] ?? '',
                    'size' => $file['size'] ?? 0,
                ];
            }
        }

        // Add HLS stream if available
        if (isset($data['play']['hls']['link'])) {
            $files['hls'] = $data['play']['hls']['link'];
        }

        // Add DASH stream if available
        if (isset($data['play']['dash']['link'])) {
            $files['dash'] = $data['play']['dash']['link'];
        }

        return $files;
    }

    /**
     * Get upload quota information
     */
    public function getUploadQuota()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
            ])->get("{$this->baseUrl}/me");

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'free' => $data['upload_quota']['space']['free'] ?? 0,
                    'used' => $data['upload_quota']['space']['used'] ?? 0,
                    'max' => $data['upload_quota']['space']['max'] ?? 0,
                    'quota_used_percent' => $data['upload_quota']['quota']['used'] ?? 0,
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get Vimeo upload quota: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate embed code for a video
     */
    public function getEmbedCode($videoId, $width = 640, $height = 360, $autoplay = false)
    {
        $autoplayParam = $autoplay ? '&autoplay=1' : '';

        return "<iframe src=\"https://player.vimeo.com/video/{$videoId}?title=0&byline=0&portrait=0{$autoplayParam}\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen></iframe>";
    }

    /**
     * Check if Vimeo service is properly configured
     */
    public function isConfigured()
    {
        return !empty($this->accessToken);
    }
}