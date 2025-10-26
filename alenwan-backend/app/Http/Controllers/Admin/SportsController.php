<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Sport;

class SportsController extends Controller
{
    public function index(Request $request)
    {
        $query = Sport::with(['category', 'language'])->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('match_type', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $sports = $query->paginate(15);

        return view('admin.sports.index', compact('sports'));
    }

    public function create()
    {
        return view('admin.sports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport_type' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
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
            $posterPath = $request->file('poster')->store('sports/posters', 'public');
        }

        $sport = Sport::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'match_type' => $request->sport_type,
            'event_date' => $request->event_date,
            'duration_minutes' => $request->duration,
            'rating' => $request->rating,
            'poster_path' => $posterPath,
            'video_path' => $request->video_url,
            'status' => $request->status ?? 'draft',
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Sports content created successfully!');
    }

    public function show(Sport $sport)
    {
        return view('admin.sports.show', compact('sport'));
    }

    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', compact('sport'));
    }

    public function update(Request $request, Sport $sport)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport_type' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($request->hasFile('poster')) {
            if ($sport->poster_path) {
                Storage::disk('public')->delete($sport->poster_path);
            }
            $sport->poster_path = $request->file('poster')->store('sports/posters', 'public');
        }

        $sport->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'match_type' => $request->sport_type,
            'event_date' => $request->event_date,
            'duration_minutes' => $request->duration,
            'rating' => $request->rating,
            'video_path' => $request->video_url,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Sports content updated successfully!');
    }

    public function destroy(Sport $sport)
    {
        if ($sport->poster_path) {
            Storage::disk('public')->delete($sport->poster_path);
        }

        $sport->delete();

        return redirect()->route('admin.sports.index')
            ->with('success', 'Sports content deleted successfully!');
    }
}
