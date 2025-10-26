@extends('admin.layouts.app')

@section('title', __('admin.add_new_sports'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.add_new_sports') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="/admin/sports">{{ __('admin.sports') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="/admin/sports" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_sports') }}
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sports.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8">
                <!-- Basic Information -->
                <div class="card-modern mb-4 animate-slide-in">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>{{ __('admin.basic_information') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.event_title') }} *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{ __('admin.enter_event_title') }}" value="{{ old('title') }}" required
                               style="border-radius: 10px;">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description') }}</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="{{ __('admin.enter_description') }}" style="border-radius: 10px;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('admin.sport_type') }}</label>
                            <input type="text" name="sport_type" class="form-control @error('sport_type') is-invalid @enderror"
                                   placeholder="Football, Basketball, etc." value="{{ old('sport_type') }}"
                                   style="border-radius: 10px;">
                            @error('sport_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('admin.event_date') }}</label>
                            <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                                   value="{{ old('event_date') }}" style="border-radius: 10px;">
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('admin.duration_minutes') }}</label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                   placeholder="90" value="{{ old('duration') }}" min="1"
                                   style="border-radius: 10px;">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.video_url') }}</label>
                        <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                               placeholder="https://example.com/sports-event.mp4" value="{{ old('video_url') }}"
                               style="border-radius: 10px;">
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-xl-4">
                <!-- Publishing Options -->
                <div class="card-modern mb-4 animate-slide-in" style="animation-delay: 0.1s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-cog me-2 text-warning"></i>{{ __('admin.publishing_options') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.status') }}</label>
                        <select name="status" class="form-select" style="border-radius: 10px;">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>{{ __('admin.archived') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.category') }}</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                style="border-radius: 10px;">
                            <option value="">{{ __('admin.select_category') }}</option>
                            @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.language') }}</label>
                        <select name="language_id" class="form-select @error('language_id') is-invalid @enderror"
                                style="border-radius: 10px;">
                            <option value="">{{ __('admin.select_language') }}</option>
                            @foreach(\App\Models\Language::where('is_active', true)->orderBy('name')->get() as $language)
                                <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('language_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.rating') }}</label>
                        <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror"
                               placeholder="8.5" value="{{ old('rating') }}" min="0" max="10" step="0.1"
                               style="border-radius: 10px;">
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Event Poster -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-image me-2 text-danger"></i>{{ __('admin.event_poster') }}
                    </h5>

                    <div class="upload-area text-center" onclick="document.getElementById('posterFile').click()">
                        <img id="posterPreview" src="https://via.placeholder.com/300x450" alt="{{ __('admin.poster_preview') }}"
                             style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem;">
                        <p class="mb-2">{{ __('admin.click_upload_poster') }}</p>
                        <p class="text-muted small">{{ __('admin.recommended_300x450') }}</p>
                        <input type="file" name="poster" id="posterFile" class="d-none"
                               accept="image/*" onchange="previewPoster(this)">
                    </div>
                    @error('poster')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card-modern animate-fade-in">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="/admin/sports" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn-modern btn-success-modern">
                                <i class="fas fa-check me-2"></i>{{ __('admin.add_sports') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: var(--primary-color);
        background: var(--bg-secondary);
    }
</style>
@endsection

@section('scripts')
<script>
    function previewPoster(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('posterPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
