<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Sport;
use App\Models\Cartoon;
use App\Models\Documentary;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Download::forUser($user->id)->with('downloadable');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Filter by content type
        if ($request->has('type') && $request->type) {
            $modelClass = $this->getModelClass($request->type);
            if ($modelClass) {
                $query->byType($modelClass);
            }
        }

        $downloads = $query->recent()->paginate($request->get('per_page', 20));

        // Transform the response
        $transformedDownloads = $downloads->getCollection()->map(function ($download) {
            return [
                'id' => $download->id,
                'status' => $download->status,
                'progress' => $download->progress,
                'file_size' => $download->file_size,
                'file_size_human' => $download->file_size_human,
                'downloaded_at' => $download->downloaded_at,
                'created_at' => $download->created_at,
                'content_type' => $this->getTypeFromModel($download->downloadable_type),
                'content' => $download->downloadable,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'downloads' => $transformedDownloads,
                'pagination' => [
                    'current_page' => $downloads->currentPage(),
                    'last_page' => $downloads->lastPage(),
                    'per_page' => $downloads->perPage(),
                    'total' => $downloads->total(),
                ]
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $download = Download::forUser($user->id)->with('downloadable')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $download->id,
                'status' => $download->status,
                'progress' => $download->progress,
                'file_size' => $download->file_size,
                'file_size_human' => $download->file_size_human,
                'file_path' => $download->file_path,
                'downloaded_at' => $download->downloaded_at,
                'created_at' => $download->created_at,
                'content_type' => $this->getTypeFromModel($download->downloadable_type),
                'content' => $download->downloadable,
            ]
        ]);
    }

    public function updateProgress(Request $request, $id)
    {
        $user = $request->user();
        $download = Download::forUser($user->id)->findOrFail($id);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'progress' => 'required|integer|min:0|max:100',
            'file_size' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $download->updateProgress($request->progress);

        if ($request->has('file_size')) {
            $download->update(['file_size' => $request->file_size]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Download progress updated',
            'data' => [
                'id' => $download->id,
                'status' => $download->status,
                'progress' => $download->progress,
                'file_size' => $download->file_size,
            ]
        ]);
    }

    public function retry(Request $request, $id)
    {
        $user = $request->user();
        $download = Download::forUser($user->id)->findOrFail($id);

        if ($download->status !== 'failed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Download can only be retried if it has failed'
            ], 400);
        }

        $download->update([
            'status' => 'pending',
            'progress' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download queued for retry',
            'data' => [
                'id' => $download->id,
                'status' => $download->status,
                'progress' => $download->progress,
            ]
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $user = $request->user();
        $download = Download::forUser($user->id)->findOrFail($id);

        if (in_array($download->status, ['completed', 'failed'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot cancel a download that is already completed or failed'
            ], 400);
        }

        $download->markAsFailed();

        return response()->json([
            'status' => 'success',
            'message' => 'Download cancelled',
            'data' => [
                'id' => $download->id,
                'status' => $download->status,
            ]
        ]);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $download = Download::forUser($user->id)->findOrFail($id);

        $download->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Download record deleted'
        ]);
    }

    public function stats(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total' => Download::forUser($user->id)->count(),
            'completed' => Download::forUser($user->id)->completed()->count(),
            'pending' => Download::forUser($user->id)->pending()->count(),
            'downloading' => Download::forUser($user->id)->downloading()->count(),
            'failed' => Download::forUser($user->id)->failed()->count(),
            'total_size' => Download::forUser($user->id)->completed()->sum('file_size'),
        ];

        // Add human readable total size
        $stats['total_size_human'] = $this->formatBytes($stats['total_size']);

        // Group by content type
        $byType = [
            'movies' => Download::forUser($user->id)->movies()->count(),
            'episodes' => Download::forUser($user->id)->episodes()->count(),
            'sports' => Download::forUser($user->id)->sports()->count(),
            'cartoons' => Download::forUser($user->id)->cartoons()->count(),
            'documentaries' => Download::forUser($user->id)->documentaries()->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'overview' => $stats,
                'by_type' => $byType,
            ]
        ]);
    }

    public function clearCompleted(Request $request)
    {
        $user = $request->user();
        $count = Download::forUser($user->id)->completed()->count();
        Download::forUser($user->id)->completed()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cleared completed downloads',
            'data' => [
                'removed_count' => $count,
            ]
        ]);
    }

    public function clearFailed(Request $request)
    {
        $user = $request->user();
        $count = Download::forUser($user->id)->failed()->count();
        Download::forUser($user->id)->failed()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cleared failed downloads',
            'data' => [
                'removed_count' => $count,
            ]
        ]);
    }

    private function getModelClass($type)
    {
        return match($type) {
            'movies' => Movie::class,
            'episodes' => Episode::class,
            'sports' => Sport::class,
            'cartoons' => Cartoon::class,
            'documentaries' => Documentary::class,
            default => null
        };
    }

    private function getTypeFromModel($modelClass)
    {
        return match($modelClass) {
            Movie::class => 'movies',
            Episode::class => 'episodes',
            Sport::class => 'sports',
            Cartoon::class => 'cartoons',
            Documentary::class => 'documentaries',
            default => 'unknown'
        };
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}