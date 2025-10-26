<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Documentary;

class DocumentariesController extends Controller
{
    public function index(Request $request)
    {
        $query = Documentary::with(['category', 'language'])->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('director', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $documentaries = $query->paginate(15);

        return view('admin.documentaries.index', compact('documentaries'));
    }

    public function create()
    {
        return view('admin.documentaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'director' => 'nullable|string|max:255',
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

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('documentaries/posters', 'public');
        }

        $topics = [];
        if ($request->tags) {
            $topics = array_map('trim', explode(',', $request->tags));
        }

        $documentary = Documentary::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'director' => $request->director,
            'topics' => $topics,
            'duration_minutes' => $request->duration,
            'release_year' => $request->release_year,
            'rating' => $request->rating,
            'poster_path' => $posterPath,
            'trailer_url' => $request->trailer_url,
            'video_path' => $request->video_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.documentaries.index')
            ->with('success', 'Documentary created successfully!');
    }

    public function show(Documentary $documentary)
    {
        return view('admin.documentaries.show', compact('documentary'));
    }

    public function edit(Documentary $documentary)
    {
        return view('admin.documentaries.edit', compact('documentary'));
    }

    public function update(Request $request, Documentary $documentary)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'director' => 'nullable|string|max:255',
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

        if ($request->hasFile('poster')) {
            if ($documentary->poster_path) {
                Storage::disk('public')->delete($documentary->poster_path);
            }
            $posterPath = $request->file('poster')->store('documentaries/posters', 'public');
            $documentary->poster_path = $posterPath;
        }

        $topics = [];
        if ($request->tags) {
            $topics = array_map('trim', explode(',', $request->tags));
        }

        $documentary->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'director' => $request->director,
            'topics' => $topics,
            'duration_minutes' => $request->duration,
            'release_year' => $request->release_year,
            'rating' => $request->rating,
            'trailer_url' => $request->trailer_url,
            'video_path' => $request->video_url,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.documentaries.index')
            ->with('success', 'Documentary updated successfully!');
    }

    public function destroy(Documentary $documentary)
    {
        if ($documentary->poster_path) {
            Storage::disk('public')->delete($documentary->poster_path);
        }

        $documentary->delete();

        return redirect()->route('admin.documentaries.index')
            ->with('success', 'Documentary deleted successfully!');
    }
}
