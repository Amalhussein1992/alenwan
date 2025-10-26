@extends('admin.layouts.app')

@section('title', __('admin.add_new_series'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.add_new_series') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="/admin/series">{{ __('admin.series') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="/admin/series" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_series') }}
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.series.store') }}" enctype="multipart/form-data">
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
                        <label class="form-label">{{ __('admin.series_title') }} *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{ __('admin.enter_series_title') }}" value="{{ old('title') }}" required
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
                            <label class="form-label">{{ __('admin.release_year') }}</label>
                            <input type="number" name="release_year" class="form-control @error('release_year') is-invalid @enderror"
                                   placeholder="2024" value="{{ old('release_year', date('Y')) }}"
                                   min="1900" max="{{ date('Y') + 5 }}" style="border-radius: 10px;">
                            @error('release_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('admin.total_seasons') }}</label>
                            <input type="number" name="total_seasons" class="form-control @error('total_seasons') is-invalid @enderror"
                                   placeholder="1" value="{{ old('total_seasons', 1) }}" min="1"
                                   style="border-radius: 10px;">
                            @error('total_seasons')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('admin.rating') }}</label>
                            <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror"
                                   placeholder="8.5" value="{{ old('rating') }}" min="0" max="10" step="0.1"
                                   style="border-radius: 10px;">
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.tags') }}</label>
                        <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror"
                               placeholder="{{ __('admin.tags_placeholder') }}" value="{{ old('tags') }}"
                               style="border-radius: 10px;">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.trailer_url') }}</label>
                        <input type="url" name="trailer_url" class="form-control @error('trailer_url') is-invalid @enderror"
                               placeholder="https://youtube.com/watch?v=..." value="{{ old('trailer_url') }}"
                               style="border-radius: 10px;">
                        @error('trailer_url')
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
                </div>

                <!-- Series Poster -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-image me-2 text-danger"></i>{{ __('admin.series_poster') }}
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
                            <a href="/admin/series" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn-modern btn-success-modern">
                                <i class="fas fa-check me-2"></i>{{ __('admin.add_series') }}
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
    // Preview poster image
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
