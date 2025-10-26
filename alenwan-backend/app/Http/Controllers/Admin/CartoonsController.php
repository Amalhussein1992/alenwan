<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cartoon;

class CartoonsController extends Controller
{
    public function index(Request $request)
    {
        $query = Cartoon::with(['category', 'language'])->orderBy('created_at', 'desc');

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

        $cartoons = $query->paginate(15);
        return view('admin.cartoons.index', compact('cartoons'));
    }

    public function create()
    {
        return view('admin.cartoons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_rating' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'duration' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('cartoons/posters', 'public');
        }

        Cartoon::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'age_rating' => $request->age_rating,
            'release_year' => $request->release_year,
            'duration_minutes' => $request->duration,
            'rating' => $request->rating,
            'poster_path' => $posterPath,
            'video_path' => $request->video_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.cartoons.index')
            ->with('success', 'Cartoon created successfully!');
    }

    public function show(Cartoon $cartoon)
    {
        return view('admin.cartoons.show', compact('cartoon'));
    }

    public function edit(Cartoon $cartoon)
    {
        return view('admin.cartoons.edit', compact('cartoon'));
    }

    public function update(Request $request, Cartoon $cartoon)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_rating' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'duration' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($request->hasFile('poster')) {
            if ($cartoon->poster_path) {
                Storage::disk('public')->delete($cartoon->poster_path);
            }
            $cartoon->poster_path = $request->file('poster')->store('cartoons/posters', 'public');
        }

        $cartoon->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'age_rating' => $request->age_rating,
            'release_year' => $request->release_year,
            'duration_minutes' => $request->duration,
            'rating' => $request->rating,
            'video_path' => $request->video_url,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.cartoons.index')
            ->with('success', 'Cartoon updated successfully!');
    }

    public function destroy(Cartoon $cartoon)
    {
        if ($cartoon->poster_path) {
            Storage::disk('public')->delete($cartoon->poster_path);
        }
        $cartoon->delete();

        return redirect()->route('admin.cartoons.index')
            ->with('success', 'Cartoon deleted successfully!');
    }
}
