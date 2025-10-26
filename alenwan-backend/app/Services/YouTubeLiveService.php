<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouTubeLiveService
{
    private $apiKey;
    private $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    /**
     * Create a live broadcast
     */
    public function createLiveBroadcast($title, $description, $scheduledStartTime, $privacy = 'unlisted')
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/liveBroadcasts", [
                'part' => 'snippet,status,contentDetails',
                'snippet' => [
                    'title' => $title,
                    'description' => $description,
                    'scheduledStartTime' => $scheduledStartTime,
                ],
                'status' => [
                    'privacyStatus' => $privacy,
                ],
                'contentDetails' => [
                    'enableAutoStart' => false,
                    'enableAutoStop' => false,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'broadcast_id' => $data['id'],
                    'title' => $data['snippet']['title'],
                    'description' => $data['snippet']['description'],
                    'scheduled_start' => $data['snippet']['scheduledStartTime'],
                    'status' => $data['status']['lifeCycleStatus'],
                    'watch_url' => "https://www.youtube.com/watch?v={$data['id']}",
                    'embed_url' => "https://www.youtube.com/embed/{$data['id']}",
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to create YouTube live broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a live stream
     */
    public function createLiveStream($title, $description)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/liveStreams", [
                'part' => 'snippet,cdn,status',
                'snippet' => [
                    'title' => $title,
                    'description' => $description,
                ],
                'cdn' => [
                    'format' => '1080p',
                    'ingestionType' => 'rtmp',
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'stream_id' => $data['id'],
                    'title' => $data['snippet']['title'],
                    'description' => $data['snippet']['description'],
                    'stream_name' => $data['cdn']['ingestionInfo']['streamName'],
                    'ingestion_address' => $data['cdn']['ingestionInfo']['ingestionAddress'],
                    'backup_ingestion_address' => $data['cdn']['ingestionInfo']['backupIngestionAddress'] ?? null,
                    'status' => $data['status']['streamStatus'],
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to create YouTube live stream: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Bind a stream to a broadcast
     */
    public function bindStreamToBroadcast($broadcastId, $streamId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->post("{$this->baseUrl}/liveBroadcasts/bind", [
                'part' => 'id,contentDetails',
                'id' => $broadcastId,
                'streamId' => $streamId,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to bind stream to broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Start a live broadcast
     */
    public function startBroadcast($broadcastId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->post("{$this->baseUrl}/liveBroadcasts/transition", [
                'part' => 'status',
                'broadcastStatus' => 'live',
                'id' => $broadcastId,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to start YouTube broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * End a live broadcast
     */
    public function endBroadcast($broadcastId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->post("{$this->baseUrl}/liveBroadcasts/transition", [
                'part' => 'status',
                'broadcastStatus' => 'complete',
                'id' => $broadcastId,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to end YouTube broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get broadcast information
     */
    public function getBroadcastInfo($broadcastId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/liveBroadcasts", [
                'part' => 'snippet,status,contentDetails,statistics',
                'id' => $broadcastId,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (empty($data['items'])) {
                    return false;
                }

                $broadcast = $data['items'][0];

                return [
                    'broadcast_id' => $broadcast['id'],
                    'title' => $broadcast['snippet']['title'],
                    'description' => $broadcast['snippet']['description'],
                    'scheduled_start' => $broadcast['snippet']['scheduledStartTime'] ?? null,
                    'actual_start' => $broadcast['snippet']['actualStartTime'] ?? null,
                    'actual_end' => $broadcast['snippet']['actualEndTime'] ?? null,
                    'status' => $broadcast['status']['lifeCycleStatus'],
                    'privacy_status' => $broadcast['status']['privacyStatus'],
                    'recording_status' => $broadcast['status']['recordingStatus'] ?? null,
                    'concurrent_viewers' => $broadcast['statistics']['concurrentViewers'] ?? 0,
                    'watch_url' => "https://www.youtube.com/watch?v={$broadcast['id']}",
                    'embed_url' => "https://www.youtube.com/embed/{$broadcast['id']}",
                    'thumbnail' => $broadcast['snippet']['thumbnails']['default']['url'] ?? null,
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get YouTube broadcast info: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get stream information
     */
    public function getStreamInfo($streamId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->get("{$this->baseUrl}/liveStreams", [
                'part' => 'snippet,cdn,status',
                'id' => $streamId,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (empty($data['items'])) {
                    return false;
                }

                $stream = $data['items'][0];

                return [
                    'stream_id' => $stream['id'],
                    'title' => $stream['snippet']['title'],
                    'description' => $stream['snippet']['description'],
                    'stream_name' => $stream['cdn']['ingestionInfo']['streamName'],
                    'ingestion_address' => $stream['cdn']['ingestionInfo']['ingestionAddress'],
                    'status' => $stream['status']['streamStatus'],
                    'health_status' => $stream['status']['healthStatus']['status'] ?? 'unknown',
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get YouTube stream info: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get live chat messages
     */
    public function getLiveChatMessages($liveChatId, $pageToken = null)
    {
        try {
            $params = [
                'part' => 'snippet,authorDetails',
                'liveChatId' => $liveChatId,
                'key' => $this->apiKey,
            ];

            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            $response = Http::get("{$this->baseUrl}/liveChat/messages", $params);

            if ($response->successful()) {
                $data = $response->json();

                $messages = [];
                foreach ($data['items'] as $item) {
                    $messages[] = [
                        'id' => $item['id'],
                        'author_name' => $item['authorDetails']['displayName'],
                        'author_image' => $item['authorDetails']['profileImageUrl'],
                        'message' => $item['snippet']['displayMessage'],
                        'published_at' => $item['snippet']['publishedAt'],
                        'type' => $item['snippet']['type'],
                    ];
                }

                return [
                    'messages' => $messages,
                    'next_page_token' => $data['nextPageToken'] ?? null,
                    'polling_interval' => $data['pollingIntervalMillis'] ?? 5000,
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get YouTube live chat messages: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update broadcast information
     */
    public function updateBroadcast($broadcastId, $title = null, $description = null, $scheduledStartTime = null)
    {
        try {
            // First get the current broadcast data
            $currentData = $this->getBroadcastInfo($broadcastId);
            if (!$currentData) {
                return false;
            }

            $updateData = [
                'part' => 'snippet',
                'id' => $broadcastId,
                'snippet' => [
                    'title' => $title ?? $currentData['title'],
                    'description' => $description ?? $currentData['description'],
                ],
            ];

            if ($scheduledStartTime) {
                $updateData['snippet']['scheduledStartTime'] = $scheduledStartTime;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->put("{$this->baseUrl}/liveBroadcasts", $updateData);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to update YouTube broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a broadcast
     */
    public function deleteBroadcast($broadcastId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->delete("{$this->baseUrl}/liveBroadcasts", [
                'id' => $broadcastId,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to delete YouTube broadcast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get access token (this would typically be retrieved from database or OAuth flow)
     */
    private function getAccessToken()
    {
        // In a real application, you would retrieve this from:
        // 1. Database where you store user's OAuth tokens
        // 2. Refresh the token if expired
        // 3. Handle OAuth flow for new users

        return config('services.youtube.access_token');
    }

    /**
     * Generate embed code for a live stream
     */
    public function getEmbedCode($broadcastId, $width = 640, $height = 360, $autoplay = false)
    {
        $autoplayParam = $autoplay ? '&autoplay=1' : '';

        return "<iframe width=\"{$width}\" height=\"{$height}\" src=\"https://www.youtube.com/embed/{$broadcastId}?modestbranding=1{$autoplayParam}\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
    }

    /**
     * Check if YouTube service is properly configured
     */
    public function isConfigured()
    {
        return !empty($this->apiKey);
    }

    /**
     * Get channel information
     */
    public function getChannelInfo($channelId = 'mine')
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ])->get("{$this->baseUrl}/channels", [
                'part' => 'snippet,statistics,status',
                'id' => $channelId === 'mine' ? null : $channelId,
                'mine' => $channelId === 'mine' ? 'true' : null,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (empty($data['items'])) {
                    return false;
                }

                $channel = $data['items'][0];

                return [
                    'channel_id' => $channel['id'],
                    'title' => $channel['snippet']['title'],
                    'description' => $channel['snippet']['description'],
                    'thumbnail' => $channel['snippet']['thumbnails']['default']['url'],
                    'subscriber_count' => $channel['statistics']['subscriberCount'] ?? 0,
                    'video_count' => $channel['statistics']['videoCount'] ?? 0,
                    'view_count' => $channel['statistics']['viewCount'] ?? 0,
                ];
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to get YouTube channel info: ' . $e->getMessage());
            return false;
        }
    }
}