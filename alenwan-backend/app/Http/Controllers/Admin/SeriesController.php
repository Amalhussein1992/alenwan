<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Series::with(['category', 'language'])->withCount(['episodes'])->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $series = $query->paginate(15);

        return view('admin.series.index', compact('series'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.series.create', compact('categories', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('series/posters', 'public');
        }

        $genres = [];
        if ($request->tags) {
            $genres = array_map('trim', explode(',', $request->tags));
        }

        Series::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'genres' => $genres,
            'release_year' => $request->release_year ?? null,
            'rating' => $request->rating ?? null,
            'poster_path' => $posterPath,
            'trailer_url' => $request->trailer_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id ?? null,
            'language_id' => $request->language_id ?? null,
        ]);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series created successfully!');
    }

    public function show($id)
    {
        $series = Series::with(['category', 'language', 'episodes'])->findOrFail($id);
        return view('admin.series.show', compact('series'));
    }

    public function edit($id)
    {
        $series = Series::with(['category', 'language'])->findOrFail($id);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.series.edit', compact('series', 'categories', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $series = Series::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id',
        ]);

        $posterPath = $series->poster_path;
        if ($request->hasFile('poster')) {
            if ($series->poster_path) {
                Storage::disk('public')->delete($series->poster_path);
            }
            $posterPath = $request->file('poster')->store('series/posters', 'public');
        }

        $genres = $series->genres ?? [];
        if ($request->tags) {
            $genres = array_map('trim', explode(',', $request->tags));
        }

        $series->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'genres' => $genres,
            'release_year' => $request->release_year ?? null,
            'rating' => $request->rating ?? null,
            'poster_path' => $posterPath,
            'trailer_url' => $request->trailer_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id ?? null,
            'language_id' => $request->language_id ?? null,
        ]);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series updated successfully!');
    }

    public function destroy($id)
    {
        $series = Series::findOrFail($id);

        if ($series->poster_path) {
            Storage::disk('public')->delete($series->poster_path);
        }

        $series->delete();

        return redirect()->route('admin.series.index')
            ->with('success', 'Series deleted successfully!');
    }
}
