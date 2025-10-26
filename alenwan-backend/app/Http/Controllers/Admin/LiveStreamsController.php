<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveStream;
use App\Models\Channel;
use Illuminate\Http\Request;

class LiveStreamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LiveStream::with('channel')->orderBy('scheduled_start', 'desc');

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

        $livestreams = $query->paginate(15);

        return view('admin.livestreams.index', compact('livestreams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $channels = Channel::where('is_active', true)->orderBy('name')->get();
        return view('admin.livestreams.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'nullable|url',
            'youtube_video_id' => 'nullable|string|max:255',
            'youtube_stream_key' => 'nullable|string|max:255',
            'scheduled_start' => 'nullable|date',
            'status' => 'required|in:scheduled,live,ended',
            'channel_id' => 'nullable|exists:channels,id',
        ]);

        LiveStream::create([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'stream_url' => $request->stream_url,
            'youtube_video_id' => $request->youtube_video_id,
            'youtube_stream_key' => $request->youtube_stream_key,
            'scheduled_start' => $request->scheduled_start,
            'status' => $request->status ?? 'scheduled',
            'channel_id' => $request->channel_id,
            'viewers_count' => 0,
            'max_viewers' => 0,
        ]);

        return redirect()->route('admin.livestreams.index')
            ->with('success', 'Live stream created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $livestream = LiveStream::with('channel')->findOrFail($id);
        return view('admin.livestreams.show', compact('livestream'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $livestream = LiveStream::with('channel')->findOrFail($id);
        $channels = Channel::where('is_active', true)->orderBy('name')->get();
        return view('admin.livestreams.edit', compact('livestream', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $livestream = LiveStream::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'nullable|url',
            'youtube_video_id' => 'nullable|string|max:255',
            'youtube_stream_key' => 'nullable|string|max:255',
            'scheduled_start' => 'nullable|date',
            'status' => 'required|in:scheduled,live,ended',
            'channel_id' => 'nullable|exists:channels,id',
        ]);

        $livestream->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'stream_url' => $request->stream_url,
            'youtube_video_id' => $request->youtube_video_id,
            'youtube_stream_key' => $request->youtube_stream_key,
            'scheduled_start' => $request->scheduled_start,
            'status' => $request->status,
            'channel_id' => $request->channel_id,
        ]);

        return redirect()->route('admin.livestreams.index')
            ->with('success', 'Live stream updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livestream = LiveStream::findOrFail($id);
        $livestream->delete();

        return redirect()->route('admin.livestreams.index')
            ->with('success', 'Live stream deleted successfully!');
    }
}
