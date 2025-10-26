@extends('admin.layouts.app')

@section('title', __('admin.add_new_movie'))

@section('content')
<div class="container-fluid p-0">
    <!-- Alert Container -->
    <div class="alert-container mb-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.add_new_movie') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="/admin/movies">{{ __('admin.movies') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="/admin/movies" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_movies') }}
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
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
                        <label class="form-label">{{ __('admin.movie_title_english') }} *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{ __('admin.enter_movie_title') }}" value="{{ old('title') }}" required
                               style="border-radius: 10px;">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.movie_title_arabic') }}</label>
                        <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror"
                               placeholder="أدخل عنوان الفيلم" value="{{ old('title_ar') }}" dir="rtl"
                               style="border-radius: 10px;">
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description_english') }}</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="{{ __('admin.enter_description') }}" style="border-radius: 10px;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description_arabic') }}</label>
                        <textarea name="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror"
                                  placeholder="أدخل وصف الفيلم" dir="rtl" style="border-radius: 10px;">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.release_year') }}</label>
                            <input type="number" name="release_year" class="form-control @error('release_year') is-invalid @enderror"
                                   placeholder="2024" value="{{ old('release_year', date('Y')) }}"
                                   min="1900" max="{{ date('Y') + 5 }}" style="border-radius: 10px;">
                            @error('release_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.duration_minutes') }}</label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                   placeholder="120" value="{{ old('duration') }}" min="1"
                                   style="border-radius: 10px;">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.director') }}</label>
                            <input type="text" name="director" class="form-control @error('director') is-invalid @enderror"
                                   placeholder="{{ __('admin.director_name') }}" value="{{ old('director') }}"
                                   style="border-radius: 10px;">
                            @error('director')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.imdb_rating') }}</label>
                            <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror"
                                   placeholder="8.5" value="{{ old('rating') }}" min="0" max="10" step="0.1"
                                   style="border-radius: 10px;">
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.cast') }}</label>
                        <input type="text" name="cast" class="form-control @error('cast') is-invalid @enderror"
                               placeholder="{{ __('admin.cast_placeholder') }}" value="{{ old('cast') }}"
                               style="border-radius: 10px;">
                        @error('cast')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                </div>

                <!-- Media Files -->
                <div class="card-modern mb-4 animate-slide-in" style="animation-delay: 0.1s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-video me-2 text-success"></i>{{ __('admin.media_files') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.video_source') }} *</label>
                        <select name="video_source" id="videoSource" class="form-select" style="border-radius: 10px;">
                            <option value="url">{{ __('admin.direct_url') }}</option>
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="upload">{{ __('admin.upload_file') }}</option>
                            <option value="m3u8">{{ __('admin.m3u8_stream') }}</option>
                        </select>
                    </div>

                    <div class="mb-3" id="videoUrlInput">
                        <label class="form-label">{{ __('admin.video_url') }} *</label>
                        <input type="text" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                               placeholder="https://example.com/movie.mp4" value="{{ old('video_url') }}"
                               style="border-radius: 10px;">
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 d-none" id="videoFileInput">
                        <label class="form-label">{{ __('admin.upload_video_file') }}</label>
                        <div class="upload-area" onclick="document.getElementById('videoFile').click()">
                            <i class="fas fa-cloud-upload-alt mb-3" style="font-size: 3rem; color: var(--primary-color);"></i>
                            <p class="mb-2">{{ __('admin.drop_video_file') }}</p>
                            <p class="text-muted small">MP4, MKV, AVI (Max: 2GB)</p>
                            <input type="file" name="video_file" id="videoFile" class="d-none"
                                   accept="video/*" onchange="displayFileName(this, 'videoFileName')">
                            <div id="videoFileName" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.trailer_url') }}</label>
                        <input type="text" name="trailer_url" class="form-control @error('trailer_url') is-invalid @enderror"
                               placeholder="https://youtube.com/watch?v=..." value="{{ old('trailer_url') }}"
                               style="border-radius: 10px;">
                        @error('trailer_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.subtitles') }}</label>
                            <input type="file" name="subtitle_file" class="form-control"
                                   accept=".srt,.vtt" style="border-radius: 10px;">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.subtitle_language') }}</label>
                            <select name="subtitle_lang" class="form-select" style="border-radius: 10px;">
                                <option value="">{{ __('admin.select_language') }}</option>
                                <option value="en">{{ __('admin.english') }}</option>
                                <option value="ar">{{ __('admin.arabic') }}</option>
                                <option value="es">{{ __('admin.spanish') }}</option>
                                <option value="fr">{{ __('admin.french') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-search me-2 text-info"></i>{{ __('admin.seo_settings') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.url_slug') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 10px 0 0 10px;">{{ url('/movies/') }}/</span>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                   placeholder="movie-title" value="{{ old('slug') }}"
                                   style="border-radius: 0 10px 10px 0;">
                        </div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.meta_description') }}</label>
                        <textarea name="meta_description" rows="2" class="form-control"
                                  placeholder="{{ __('admin.meta_description_placeholder') }}"
                                  style="border-radius: 10px;">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.meta_keywords') }}</label>
                        <input type="text" name="meta_keywords" class="form-control"
                               placeholder="{{ __('admin.meta_keywords_placeholder') }}" value="{{ old('meta_keywords') }}"
                               style="border-radius: 10px;">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-xl-4">
                <!-- Publishing Options -->
                <div class="card-modern mb-4 animate-slide-in" style="animation-delay: 0.3s;">
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
                        <label class="form-label">{{ __('admin.category') }} *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                style="border-radius: 10px;" required>
                            <option value="">{{ __('admin.select_category') }}</option>
                            <option value="1">{{ __('admin.action') }}</option>
                            <option value="2">{{ __('admin.comedy') }}</option>
                            <option value="3">{{ __('admin.drama') }}</option>
                            <option value="4">{{ __('admin.horror') }}</option>
                            <option value="5">{{ __('admin.sci_fi') }}</option>
                            <option value="6">{{ __('admin.romance') }}</option>
                            <option value="7">{{ __('admin.thriller') }}</option>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.video_quality') }}</label>
                        <select name="quality" class="form-select" style="border-radius: 10px;">
                            <option value="SD" {{ old('quality') == 'SD' ? 'selected' : '' }}>SD (480p)</option>
                            <option value="HD" {{ old('quality') == 'HD' ? 'selected' : '' }}>HD (720p)</option>
                            <option value="FHD" {{ old('quality') == 'FHD' ? 'selected' : '' }}>Full HD (1080p)</option>
                            <option value="4K" {{ old('quality') == '4K' ? 'selected' : '' }}>4K (2160p)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured"
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFeatured">
                                <i class="fas fa-star text-warning me-1"></i>{{ __('admin.featured_movie') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_premium" id="isPremium"
                                   {{ old('is_premium') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isPremium">
                                <i class="fas fa-crown text-primary me-1"></i>{{ __('admin.premium_only') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="allow_download" id="allowDownload"
                                   {{ old('allow_download') ? 'checked' : '' }}>
                            <label class="form-check-label" for="allowDownload">
                                <i class="fas fa-download text-success me-1"></i>{{ __('admin.allow_download') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Movie Poster -->
                <div class="card-modern mb-4 animate-slide-in" style="animation-delay: 0.4s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-image me-2 text-danger"></i>{{ __('admin.movie_poster') }}
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

                <!-- Backdrop Image -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.5s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-panorama me-2 text-purple"></i>{{ __('admin.backdrop_image') }}
                    </h5>

                    <div class="upload-area text-center" onclick="document.getElementById('backdropFile').click()">
                        <img id="backdropPreview" src="https://via.placeholder.com/1920x1080" alt="{{ __('admin.backdrop_preview') }}"
                             style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem;">
                        <p class="mb-2">{{ __('admin.click_upload_backdrop') }}</p>
                        <p class="text-muted small">{{ __('admin.recommended_1920x1080') }}</p>
                        <input type="file" name="backdrop" id="backdropFile" class="d-none"
                               accept="image/*" onchange="previewBackdrop(this)">
                    </div>
                    @error('backdrop')
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
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="saveDraft()">
                                <i class="fas fa-save me-2"></i>{{ __('admin.save_as_draft') }}
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="previewMovie()">
                                <i class="fas fa-eye me-2"></i>{{ __('admin.preview') }}
                            </button>
                        </div>
                        <div>
                            <a href="/admin/movies" class="btn btn-outline-danger me-2">
                                <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                            </a>
                            <button type="submit" class="btn-modern btn-success-modern">
                                <i class="fas fa-check me-2"></i>{{ __('admin.add_movie') }}
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

    .text-purple {
        color: #8b5cf6;
    }
</style>
@endsection

@section('scripts')
<script>
    // Form submission with validation and feedback
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Movie added successfully!');
                setTimeout(() => {
                    window.location.href = data.redirect || '/admin/movies';
                }, 1500);
            } else {
                showAlert('danger', data.message || 'Failed to save movie. Please check the form.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while saving the movie.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.alert-container').innerHTML = alertHtml;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Toggle video input based on source
    document.getElementById('videoSource').addEventListener('change', function() {
        const urlInput = document.getElementById('videoUrlInput');
        const fileInput = document.getElementById('videoFileInput');

        if (this.value === 'upload') {
            urlInput.classList.add('d-none');
            fileInput.classList.remove('d-none');
        } else {
            urlInput.classList.remove('d-none');
            fileInput.classList.add('d-none');
        }
    });

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

    // Preview backdrop image
    function previewBackdrop(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('backdropPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Display file name
    function displayFileName(input, targetId) {
        const fileName = input.files[0]?.name;
        if (fileName) {
            document.getElementById(targetId).innerHTML = `<span class="badge bg-success">${fileName}</span>`;
        }
    }

    // Save as draft
    function saveDraft() {
        document.querySelector('select[name="status"]').value = 'draft';
        document.querySelector('form').submit();
    }

    // Preview movie (placeholder)
    function previewMovie() {
        alert("{{ __('admin.preview_coming_soon') }}");
    }

    // Auto-generate slug from title
    document.querySelector('input[name="title"]').addEventListener('blur', function() {
        const slug = this.value.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.querySelector('input[name="slug"]').value = slug;
    });
</script>
@endsection