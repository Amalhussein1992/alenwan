@extends('admin.layouts.app')

@section('title', __('admin.edit_category'))

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
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.edit_category') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="/admin/categories">{{ __('admin.categories') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.edit') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="/admin/categories" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_categories') }}
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8">
                <!-- Basic Information -->
                <div class="card-modern mb-4 animate-slide-in">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>{{ __('admin.basic_information') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.category_name_english') }} *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="{{ __('admin.enter_category_name') }}" value="{{ old('name', $category->name) }}" required
                               style="border-radius: 10px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.category_name_arabic') }}</label>
                        <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                               placeholder="#/.D '3E 'DA&)" value="{{ old('name_ar', $category->name_ar) }}" dir="rtl"
                               style="border-radius: 10px;">
                        @error('name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description_english') }}</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="{{ __('admin.enter_description') }}" style="border-radius: 10px;">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description_arabic') }}</label>
                        <textarea name="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror"
                                  placeholder="#/.D H5A 'DA&)" dir="rtl" style="border-radius: 10px;">{{ old('description_ar', $category->description_ar) }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.parent_category') }}</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror"
                                    style="border-radius: 10px;">
                                <option value="">{{ __('admin.none_top_level') }}</option>
                                @foreach(\App\Models\Category::whereNull('parent_id')->where('id', '!=', $category->id)->orderBy('name')->get() as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.sort_order') }}</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                   placeholder="0" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                                   style="border-radius: 10px;">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.icon') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 10px 0 0 10px;">
                                <i class="fas {{ $category->icon ?? 'fa-folder' }}" id="iconPreview"></i>
                            </span>
                            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                   placeholder="fa-folder" value="{{ old('icon', $category->icon ?? 'fa-folder') }}"
                                   onkeyup="updateIconPreview(this.value)" style="border-radius: 0 10px 10px 0;">
                        </div>
                        <small class="text-muted">{{ __('admin.use_font_awesome_icons') }}</small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.color') }}</label>
                        <input type="color" name="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                               value="{{ old('color', $category->color ?? '#667eea') }}" style="border-radius: 10px; width: 100px; height: 50px;">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.1s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-search me-2 text-info"></i>{{ __('admin.seo_settings') }}
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.url_slug') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 10px 0 0 10px;">{{ url('/categories/') }}/</span>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                   placeholder="category-slug" value="{{ old('slug', $category->slug) }}"
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
                                  style="border-radius: 10px;">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.meta_keywords') }}</label>
                        <input type="text" name="meta_keywords" class="form-control"
                               placeholder="{{ __('admin.meta_keywords_placeholder') }}" value="{{ old('meta_keywords', $category->meta_keywords) }}"
                               style="border-radius: 10px;">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-xl-4">
                <!-- Publishing Options -->
                <div class="card-modern mb-4 animate-slide-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-cog me-2 text-warning"></i>{{ __('admin.publishing_options') }}
                    </h5>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">
                                <i class="fas fa-check-circle text-success me-1"></i>{{ __('admin.active') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured"
                                   {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFeatured">
                                <i class="fas fa-star text-warning me-1"></i>{{ __('admin.featured_category') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Category Image -->
                <div class="card-modern animate-slide-in" style="animation-delay: 0.3s;">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-image me-2 text-danger"></i>{{ __('admin.category_image') }}
                    </h5>

                    <div class="upload-area text-center" onclick="document.getElementById('imageFile').click()">
                        @if($category->image)
                            <img id="imagePreview" src="{{ asset('storage/' . $category->image) }}" alt="{{ __('admin.image_preview') }}"
                                 style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem;">
                        @else
                            <img id="imagePreview" src="https://via.placeholder.com/400x300" alt="{{ __('admin.image_preview') }}"
                                 style="max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem;">
                        @endif
                        <p class="mb-2">{{ __('admin.click_upload_image') }}</p>
                        <p class="text-muted small">{{ __('admin.recommended_400x300') }}</p>
                        <input type="file" name="image" id="imageFile" class="d-none"
                               accept="image/*" onchange="previewImage(this)">
                    </div>
                    @error('image')
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
                            <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                    <i class="fas fa-trash me-2"></i>{{ __('admin.delete') }}
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="/admin/categories" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                            </a>
                            <button type="submit" class="btn-modern btn-success-modern">
                                <i class="fas fa-check me-2"></i>{{ __('admin.update_category') }}
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
    // Preview image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Update icon preview
    function updateIconPreview(iconClass) {
        const preview = document.getElementById('iconPreview');
        preview.className = 'fas ' + iconClass;
    }

    // Auto-generate slug from name
    document.querySelector('input[name="name"]').addEventListener('blur', function() {
        const slugInput = document.querySelector('input[name="slug"]');
        if (!slugInput.value) {
            const slug = this.value.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        }
    });
</script>
@endsection
