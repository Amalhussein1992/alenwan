@extends('admin.layouts.app')

@section('title', 'Edit Live Stream')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">Edit Live Stream</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.livestreams.index') }}">Live Streams</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.livestreams.index') }}" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>Back to Live Streams
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.livestreams.update', $livestream->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xl-8">
                <div class="card-modern mb-4 animate-slide-in">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Stream Title (English) *</label>
                        <input type="text" name="title" class="form-control" required style="border-radius: 10px;" value="{{ old('title', $livestream->title) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stream Title (Arabic)</label>
                        <input type="text" name="title_ar" class="form-control" dir="rtl" style="border-radius: 10px;" value="{{ old('title_ar', $livestream->title_ar) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description" rows="4" class="form-control" style="border-radius: 10px;">{{ old('description', $livestream->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Arabic)</label>
                        <textarea name="description_ar" rows="4" class="form-control" dir="rtl" style="border-radius: 10px;">{{ old('description_ar', $livestream->description_ar) }}</textarea>
                    </div>
                </div>

                <div class="card-modern mb-4">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-broadcast-tower me-2 text-success"></i>Stream Configuration
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">YouTube Video ID</label>
                        <input type="text" name="youtube_video_id" class="form-control" style="border-radius: 10px;" value="{{ old('youtube_video_id', $livestream->youtube_video_id) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stream URL</label>
                        <input type="url" name="stream_url" class="form-control" style="border-radius: 10px;" value="{{ old('stream_url', $livestream->stream_url) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">YouTube Stream Key</label>
                        <input type="text" name="youtube_stream_key" class="form-control" style="border-radius: 10px;" value="{{ old('youtube_stream_key', $livestream->youtube_stream_key) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Scheduled Start Time</label>
                        <input type="datetime-local" name="scheduled_start" class="form-control" style="border-radius: 10px;" value="{{ old('scheduled_start', $livestream->scheduled_start ? $livestream->scheduled_start->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card-modern mb-4">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-cog me-2 text-warning"></i>Publishing Options
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" style="border-radius: 10px;">
                            <option value="scheduled" {{ old('status', $livestream->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="live" {{ old('status', $livestream->status) == 'live' ? 'selected' : '' }}>Live</option>
                            <option value="ended" {{ old('status', $livestream->status) == 'ended' ? 'selected' : '' }}>Ended</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Channel</label>
                        <select name="channel_id" class="form-select" style="border-radius: 10px;">
                            <option value="">Select Channel</option>
                            @if(isset($channels))
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id', $livestream->channel_id) == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card-modern">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.livestreams.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-success-modern">
                            <i class="fas fa-check me-2"></i>Update Stream
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
