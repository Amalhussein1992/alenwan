<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodesController extends Controller
{
    public function index(Request $request)
    {
        $query = Episode::with('series')->orderBy('season_number')->orderBy('episode_number');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('series_id') && $request->series_id) {
            $query->where('series_id', $request->series_id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $episodes = $query->paginate(15);
        $allSeries = Series::orderBy('title')->get();

        return view('admin.episodes.index', compact('episodes', 'allSeries'));
    }

    public function create()
    {
        $series = Series::orderBy('title')->get();
        return view('admin.episodes.create', compact('series'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'series_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'season_number' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('episodes/thumbnails', 'public');
        }

        Episode::create([
            'series_id' => $request->series_id,
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'season_number' => $request->season_number,
            'episode_number' => $request->episode_number,
            'duration_minutes' => $request->duration_minutes ?? null,
            'video_path' => $request->video_url,
            'thumbnail_path' => $thumbnailPath,
            'status' => $request->status ?? 'draft',
        ]);

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode created successfully!');
    }

    public function edit($id)
    {
        $episode = Episode::with('series')->findOrFail($id);
        $series = Series::orderBy('title')->get();

        return view('admin.episodes.edit', compact('episode', 'series'));
    }

    public function update(Request $request, $id)
    {
        $episode = Episode::findOrFail($id);

        $request->validate([
            'series_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'season_number' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $thumbnailPath = $episode->thumbnail_path;
        if ($request->hasFile('thumbnail')) {
            if ($episode->thumbnail_path) {
                Storage::disk('public')->delete($episode->thumbnail_path);
            }
            $thumbnailPath = $request->file('thumbnail')->store('episodes/thumbnails', 'public');
        }

        $episode->update([
            'series_id' => $request->series_id,
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'season_number' => $request->season_number,
            'episode_number' => $request->episode_number,
            'duration_minutes' => $request->duration_minutes ?? null,
            'video_path' => $request->video_url,
            'thumbnail_path' => $thumbnailPath,
            'status' => $request->status ?? 'draft',
        ]);

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode updated successfully!');
    }

    public function destroy($id)
    {
        $episode = Episode::findOrFail($id);

        if ($episode->thumbnail_path) {
            Storage::disk('public')->delete($episode->thumbnail_path);
        }

        $episode->delete();

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode deleted successfully!');
    }
}
