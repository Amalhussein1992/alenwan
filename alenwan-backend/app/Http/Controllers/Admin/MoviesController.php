<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Movie;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        // Fetch movies from database
        $query = Movie::with(['category', 'language'])->orderBy('created_at', 'desc');

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('genres', 'like', "%{$searchTerm}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $movies = $query->paginate(15);

        // Debug: Log the count
        \Log::info('Movies count: ' . $movies->count());
        \Log::info('Movies total: ' . $movies->total());

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        \Log::info('=== STORE METHOD CALLED ===');
        \Log::info('Form data:', $request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        // Handle file upload
        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        // Save to database
        $genres = [];
        if ($request->tags) {
            $genres = array_map('trim', explode(',', $request->tags));
        }

        try {
            $movie = Movie::create([
                'title' => $request->title,
                'title_ar' => $request->title_ar,
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'genres' => $genres,
                'duration_minutes' => $request->duration ?? null,
                'release_year' => $request->release_year ?? null,
                'rating' => $request->rating ?? null,
                'poster_path' => $posterPath,
                'trailer_url' => $request->trailer_url,
                'video_path' => $request->video_url,
                'status' => $request->status ?? 'draft',
                'category_id' => $request->category_id ?? null,
                'language_id' => $request->language_id ?? null,
            ]);

            \Log::info('Movie created successfully', ['id' => $movie->id, 'title' => $movie->title]);

            return redirect()->route('admin.movies.index')
                ->with('success', 'Movie created successfully! ID: ' . $movie->id);
        } catch (\Exception $e) {
            \Log::error('Failed to create movie', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create movie: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $movie = Movie::with(['category', 'language'])->findOrFail($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit($id)
    {
        $movie = Movie::with(['category', 'language'])->findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        // Handle file upload
        $posterPath = $movie->poster_path;
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        // Update in database
        $genres = $movie->genres ?? [];
        if ($request->tags) {
            $genres = array_map('trim', explode(',', $request->tags));
        }

        $movie->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'genres' => $genres,
            'duration_minutes' => $request->duration ?? null,
            'release_year' => $request->release_year ?? null,
            'rating' => $request->rating ?? null,
            'poster_path' => $posterPath,
            'trailer_url' => $request->trailer_url,
            'video_path' => $request->video_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id ?? null,
            'language_id' => $request->language_id ?? null,
        ]);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        // Delete poster if exists
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted successfully!'
        ]);
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
                Movie::whereIn('id', $ids)->update(['status' => 'published']);
                break;
            case 'draft':
                Movie::whereIn('id', $ids)->update(['status' => 'draft']);
                break;
            case 'delete':
                $movies = Movie::whereIn('id', $ids)->get();
                foreach ($movies as $movie) {
                    if ($movie->poster_path) {
                        Storage::disk('public')->delete($movie->poster_path);
                    }
                }
                Movie::whereIn('id', $ids)->delete();
                break;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully {$action}ed " . count($ids) . " movies"
        ]);
    }
}