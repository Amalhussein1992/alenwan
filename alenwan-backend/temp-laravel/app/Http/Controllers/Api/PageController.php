<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Get all published pages
     */
    public function index(Request $request)
    {
        $query = Page::published();

        // Filter by type if provided
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter for menu pages
        if ($request->boolean('menu')) {
            $query->where('show_in_menu', true);
        }

        // Filter for footer pages
        if ($request->boolean('footer')) {
            $query->where('show_in_footer', true);
        }

        $pages = $query->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $pages->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'type' => $page->type,
                    'icon' => $page->icon,
                    'banner_image' => $page->banner_image ? asset('storage/' . $page->banner_image) : null,
                    'order' => $page->order,
                    'show_in_menu' => $page->show_in_menu,
                    'show_in_footer' => $page->show_in_footer,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                ];
            })
        ]);
    }

    /**
     * Get a single page by slug
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->published()
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'type' => $page->type,
                'icon' => $page->icon,
                'banner_image' => $page->banner_image ? asset('storage/' . $page->banner_image) : null,
                'order' => $page->order,
                'show_in_menu' => $page->show_in_menu,
                'show_in_footer' => $page->show_in_footer,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
                'created_at' => $page->created_at->toIso8601String(),
                'updated_at' => $page->updated_at->toIso8601String(),
            ]
        ]);
    }

    /**
     * Get pages by type
     */
    public function byType($type)
    {
        $pages = Page::published()
            ->where('type', $type)
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pages->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => $page->content,
                    'type' => $page->type,
                    'icon' => $page->icon,
                    'banner_image' => $page->banner_image ? asset('storage/' . $page->banner_image) : null,
                    'order' => $page->order,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                ];
            })
        ]);
    }

    /**
     * Get menu pages
     */
    public function menu()
    {
        $pages = Page::published()
            ->inMenu()
            ->ordered()
            ->get(['id', 'title', 'slug', 'type', 'icon', 'order']);

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    /**
     * Get footer pages
     */
    public function footer()
    {
        $pages = Page::published()
            ->inFooter()
            ->ordered()
            ->get(['id', 'title', 'slug', 'type', 'icon', 'order']);

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    /**
     * Search pages
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $pages = Page::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%");
            })
            ->ordered()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pages->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'type' => $page->type,
                    'icon' => $page->icon,
                ];
            })
        ]);
    }
}
