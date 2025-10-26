@extends('admin.layouts.app')

@section('title', __('admin.add_new_language'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.add_new_language') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="/admin/languages">{{ __('admin.languages') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="/admin/languages" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_languages') }}
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.languages.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8">
                <!-- Basic Information -->
                <div class="card-modern mb-4 animate-slide-in">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>{{ __('admin.basic_information') }}
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.language_name_english') }} *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="English" value="{{ old('name') }}" required
                                   style="border-radius: 10px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.language_code') }} *</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                   placeholder="en" value="{{ old('code') }}" required maxlength="5"
                                   style="border-radius: 10px;">
                            <small class="text-muted">{{ __('admin.iso_639_code') }} (e.g., en, ar, fr, es)</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.native_name') }}</label>
                        <input type="text" name="native_name" class="form-control @error('native_name') is-invalid @enderror"
                               placeholder="English (Native: English)" value="{{ old('native_name') }}"
                               style="border-radius: 10px;">
                        <small class="text-muted">{{ __('admin.language_in_native_script') }}</small>
                        @error('native_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.direction') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_rtl" id="isRtl"
                                   {{ old('is_rtl') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isRtl">
                                <i class="fas fa-arrow-left text-warning me-1"></i>{{ __('admin.right_to_left') }} (RTL)
                            </label>
                        </div>
                        <small class="text-muted">{{ __('admin.check_for_rtl_languages') }}</small>
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
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">
                                <i class="fas fa-check-circle text-success me-1"></i>{{ __('admin.active') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Language Flag -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-flag me-2 text-danger"></i>{{ __('admin.language_flag') }}
                    </h5>

                    <div class="upload-area text-center" onclick="document.getElementById('flagFile').click()">
                        <img id="flagPreview" src="https://via.placeholder.com/200x150" alt="{{ __('admin.flag_preview') }}"
                             style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem;">
                        <p class="mb-2">{{ __('admin.click_upload_flag') }}</p>
                        <p class="text-muted small">{{ __('admin.recommended_svg_or_png') }}</p>
                        <input type="file" name="flag_icon" id="flagFile" class="d-none"
                               accept="image/*" onchange="previewFlag(this)">
                    </div>
                    @error('flag_icon')
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
                            <a href="/admin/languages" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn-modern btn-success-modern">
                                <i class="fas fa-check me-2"></i>{{ __('admin.add_language') }}
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
    // Preview flag
    function previewFlag(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('flagPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-generate code from name
    document.querySelector('input[name="name"]').addEventListener('blur', function() {
        const codeInput = document.querySelector('input[name="code"]');
        if (!codeInput.value) {
            const code = this.value.toLowerCase().substring(0, 2);
            codeInput.value = code;
        }
    });
</script>
@endsection
