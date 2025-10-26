<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastsController extends Controller
{
    public function index(Request $request)
    {
        $query = Podcast::with(['category', 'language'])->orderBy('release_date', 'desc');

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('host', 'like', "%{$searchTerm}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $podcasts = $query->paginate(15);

        return view('admin.podcasts.index', compact('podcasts'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.podcasts.create', compact('categories', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'nullable|string',
            'duration_seconds' => 'nullable|integer|min:1',
            'release_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'nullable|file|mimes:mp3,wav,m4a|max:102400',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id',
            'season_number' => 'nullable|integer',
            'episode_number' => 'nullable|integer',
        ]);

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('podcasts/covers', 'public');
        }

        // Handle audio file upload
        $audioPath = null;
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('podcasts/audio', 'public');
        }

        // Process guests and tags
        $guests = [];
        if ($request->guests) {
            $guests = array_map('trim', explode(',', $request->guests));
        }

        $tags = [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $podcast = Podcast::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'cover_image' => $coverPath,
            'audio_path' => $audioPath,
            'status' => $request->status ?? 'draft',
            'duration_seconds' => $request->duration_seconds ?? null,
            'release_date' => $request->release_date ?? null,
            'host' => $request->host,
            'guests' => $guests,
            'tags' => $tags,
            'season_number' => $request->season_number ?? null,
            'episode_number' => $request->episode_number ?? null,
            'category_id' => $request->category_id ?? null,
            'language_id' => $request->language_id ?? null,
        ]);

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast created successfully!');
    }

    public function show($id)
    {
        $podcast = Podcast::with(['category', 'language'])->findOrFail($id);
        return view('admin.podcasts.show', compact('podcast'));
    }

    public function edit($id)
    {
        $podcast = Podcast::with(['category', 'language'])->findOrFail($id);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.podcasts.edit', compact('podcast', 'categories', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $podcast = Podcast::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'nullable|string',
            'duration_seconds' => 'nullable|integer|min:1',
            'release_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'nullable|file|mimes:mp3,wav,m4a|max:102400',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id',
            'season_number' => 'nullable|integer',
            'episode_number' => 'nullable|integer',
        ]);

        // Handle cover image upload
        $coverPath = $podcast->cover_image;
        if ($request->hasFile('cover_image')) {
            if ($podcast->cover_image) {
                Storage::disk('public')->delete($podcast->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('podcasts/covers', 'public');
        }

        // Handle audio file upload
        $audioPath = $podcast->audio_path;
        if ($request->hasFile('audio_file')) {
            if ($podcast->audio_path) {
                Storage::disk('public')->delete($podcast->audio_path);
            }
            $audioPath = $request->file('audio_file')->store('podcasts/audio', 'public');
        }

        // Process guests and tags
        $guests = $podcast->guests ?? [];
        if ($request->guests) {
            $guests = array_map('trim', explode(',', $request->guests));
        }

        $tags = $podcast->tags ?? [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $podcast->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'cover_image' => $coverPath,
            'audio_path' => $audioPath,
            'status' => $request->status ?? 'draft',
            'duration_seconds' => $request->duration_seconds ?? null,
            'release_date' => $request->release_date ?? null,
            'host' => $request->host,
            'guests' => $guests,
            'tags' => $tags,
            'season_number' => $request->season_number ?? null,
            'episode_number' => $request->episode_number ?? null,
            'category_id' => $request->category_id ?? null,
            'language_id' => $request->language_id ?? null,
        ]);

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast updated successfully!');
    }

    public function destroy($id)
    {
        $podcast = Podcast::findOrFail($id);

        // Delete cover image if exists
        if ($podcast->cover_image) {
            Storage::disk('public')->delete($podcast->cover_image);
        }

        // Delete audio file if exists
        if ($podcast->audio_path) {
            Storage::disk('public')->delete($podcast->audio_path);
        }

        $podcast->delete();

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No items selected'
            ], 400);
        }

        switch ($action) {
            case 'publish':
                Podcast::whereIn('id', $ids)->update(['status' => 'published']);
                break;
            case 'draft':
                Podcast::whereIn('id', $ids)->update(['status' => 'draft']);
                break;
            case 'delete':
                $podcasts = Podcast::whereIn('id', $ids)->get();
                foreach ($podcasts as $podcast) {
                    if ($podcast->cover_image) {
                        Storage::disk('public')->delete($podcast->cover_image);
                    }
                    if ($podcast->audio_path) {
                        Storage::disk('public')->delete($podcast->audio_path);
                    }
                }
                Podcast::whereIn('id', $ids)->delete();
                break;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully {$action}ed " . count($ids) . " podcasts"
        ]);
    }
}
