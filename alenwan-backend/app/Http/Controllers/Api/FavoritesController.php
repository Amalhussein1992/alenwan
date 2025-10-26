<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Sport;
use App\Models\Cartoon;
use App\Models\Documentary;
use App\Models\Channel;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Favorite::forUser($user->id)->with('favorable');

        // Filter by content type
        if ($request->has('type') && $request->type) {
            $query->byType($this->getModelClass($request->type));
        }

        $favorites = $query->recent()->paginate($request->get('per_page', 20));

        // Transform the response to group by type
        $groupedFavorites = $favorites->getCollection()->groupBy('favorable_type')->map(function ($items, $type) {
            return [
                'type' => $this->getTypeFromModel($type),
                'count' => $items->count(),
                'items' => $items->map(function ($favorite) {
                    return [
                        'id' => $favorite->id,
                        'favorited_at' => $favorite->created_at,
                        'content' => $favorite->favorable,
                    ];
                })
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => [
                'favorites' => $groupedFavorites,
                'pagination' => [
                    'current_page' => $favorites->currentPage(),
                    'last_page' => $favorites->lastPage(),
                    'per_page' => $favorites->perPage(),
                    'total' => $favorites->total(),
                ]
            ]
        ]);
    }

    public function byType(Request $request, $type)
    {
        $user = $request->user();

        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid content type'
            ], 400);
        }

        $favorites = Favorite::forUser($user->id)
            ->byType($modelClass)
            ->with('favorable')
            ->recent()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => [
                'type' => $type,
                'favorites' => $favorites->map(function ($favorite) {
                    return [
                        'id' => $favorite->id,
                        'favorited_at' => $favorite->created_at,
                        'content' => $favorite->favorable,
                    ];
                }),
                'pagination' => [
                    'current_page' => $favorites->currentPage(),
                    'last_page' => $favorites->lastPage(),
                    'per_page' => $favorites->perPage(),
                    'total' => $favorites->total(),
                ]
            ]
        ]);
    }

    public function stats(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total' => Favorite::forUser($user->id)->count(),
            'movies' => Favorite::forUser($user->id)->movies()->count(),
            'series' => Favorite::forUser($user->id)->series()->count(),
            'sports' => Favorite::forUser($user->id)->sports()->count(),
            'cartoons' => Favorite::forUser($user->id)->cartoons()->count(),
            'documentaries' => Favorite::forUser($user->id)->documentaries()->count(),
            'channels' => Favorite::forUser($user->id)->channels()->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    public function remove(Request $request, $id)
    {
        $user = $request->user();
        $favorite = Favorite::forUser($user->id)->findOrFail($id);

        $contentType = $this->getTypeFromModel($favorite->favorable_type);
        $favorite->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Removed from favorites',
            'data' => [
                'removed_id' => $id,
                'content_type' => $contentType,
            ]
        ]);
    }

    public function clear(Request $request)
    {
        $user = $request->user();
        $type = $request->get('type');

        $query = Favorite::forUser($user->id);

        if ($type) {
            $modelClass = $this->getModelClass($type);
            if (!$modelClass) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid content type'
                ], 400);
            }
            $query->byType($modelClass);
        }

        $count = $query->count();
        $query->delete();

        return response()->json([
            'status' => 'success',
            'message' => $type ? "Cleared all {$type} favorites" : 'Cleared all favorites',
            'data' => [
                'removed_count' => $count,
                'type' => $type,
            ]
        ]);
    }

    private function getModelClass($type)
    {
        return match($type) {
            'movies' => Movie::class,
            'series' => Series::class,
            'sports' => Sport::class,
            'cartoons' => Cartoon::class,
            'documentaries' => Documentary::class,
            'channels' => Channel::class,
            default => null
        };
    }

    private function getTypeFromModel($modelClass)
    {
        return match($modelClass) {
            Movie::class => 'movies',
            Series::class => 'series',
            Sport::class => 'sports',
            Cartoon::class => 'cartoons',
            Documentary::class => 'documentaries',
            Channel::class => 'channels',
            default => 'unknown'
        };
    }
}