@extends('admin.layouts.app')

@section('title', __('admin.categories_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.categories_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.categories') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-success-modern" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_category') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="stat-value">24</div>
                <div class="stat-label">{{ __('admin.total_categories') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-folder fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="stat-value">18</div>
                <div class="stat-label">{{ __('admin.active_categories') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="stat-value">3,456</div>
                <div class="stat-label">{{ __('admin.total_content_items') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-film fa-3x text-primary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="stat-value">6</div>
                <div class="stat-label">{{ __('admin.parent_categories') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-sitemap fa-3x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row">
        @php
            $categories = [
                ['name' => 'Action', 'icon' => 'fa-bolt', 'color' => '#ef4444', 'items' => 245, 'status' => 'active', 'parent' => null],
                ['name' => 'Comedy', 'icon' => 'fa-laugh', 'color' => '#f59e0b', 'items' => 189, 'status' => 'active', 'parent' => null],
                ['name' => 'Drama', 'icon' => 'fa-theater-masks', 'color' => '#8b5cf6', 'items' => 312, 'status' => 'active', 'parent' => null],
                ['name' => 'Horror', 'icon' => 'fa-ghost', 'color' => '#6b7280', 'items' => 98, 'status' => 'active', 'parent' => null],
                ['name' => 'Romance', 'icon' => 'fa-heart', 'color' => '#ec4899', 'items' => 156, 'status' => 'active', 'parent' => null],
                ['name' => 'Sci-Fi', 'icon' => 'fa-rocket', 'color' => '#3b82f6', 'items' => 203, 'status' => 'active', 'parent' => null],
                ['name' => 'Thriller', 'icon' => 'fa-user-secret', 'color' => '#1f2937', 'items' => 178, 'status' => 'active', 'parent' => null],
                ['name' => 'Documentary', 'icon' => 'fa-video', 'color' => '#10b981', 'items' => 186, 'status' => 'active', 'parent' => null],
                ['name' => 'Animation', 'icon' => 'fa-magic', 'color' => '#f97316', 'items' => 234, 'status' => 'active', 'parent' => null],
                ['name' => 'Adventure', 'icon' => 'fa-compass', 'color' => '#0ea5e9', 'items' => 267, 'status' => 'active', 'parent' => null],
                ['name' => 'Crime', 'icon' => 'fa-user-ninja', 'color' => '#dc2626', 'items' => 145, 'status' => 'active', 'parent' => null],
                ['name' => 'Fantasy', 'icon' => 'fa-dragon', 'color' => '#7c3aed', 'items' => 198, 'status' => 'active', 'parent' => null],
                ['name' => 'Western', 'icon' => 'fa-hat-cowboy', 'color' => '#92400e', 'items' => 45, 'status' => 'inactive', 'parent' => null],
                ['name' => 'Musical', 'icon' => 'fa-music', 'color' => '#c026d3', 'items' => 67, 'status' => 'active', 'parent' => null],
                ['name' => 'War', 'icon' => 'fa-fighter-jet', 'color' => '#4b5563', 'items' => 89, 'status' => 'active', 'parent' => null],
                ['name' => 'Sports', 'icon' => 'fa-football-ball', 'color' => '#16a34a', 'items' => 123, 'status' => 'active', 'parent' => null],
                ['name' => 'Kids', 'icon' => 'fa-child', 'color' => '#fbbf24', 'items' => 456, 'status' => 'active', 'parent' => null],
                ['name' => 'Family', 'icon' => 'fa-users', 'color' => '#06b6d4', 'items' => 234, 'status' => 'active', 'parent' => null],
            ];
        @endphp

        @foreach($categories as $index => $category)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 category-card" style="border-radius: 16px; cursor: pointer; transition: all 0.3s;">
                <div class="card-body text-center">
                    <div class="category-icon mb-3" style="width: 80px; height: 80px; margin: 0 auto; background: {{ $category['color'] }}20; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas {{ $category['icon'] }} fa-2x" style="color: {{ $category['color'] }}"></i>
                    </div>
                    <h5 class="mb-2" style="color: var(--text-primary);">{{ $category['name'] }}</h5>
                    <p class="text-muted small mb-2">{{ $category['items'] }} items</p>

                    @if($category['status'] == 'active')
                        <span class="badge bg-success mb-3">{{ __('admin.active') }}</span>
                    @else
                        <span class="badge bg-secondary mb-3">{{ __('admin.inactive') }}</span>
                    @endif

                    <div class="d-flex gap-1 justify-content-center">
                        <button class="btn btn-sm btn-outline-primary" onclick="editCategory({{ $index }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory({{ $index }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleStatus({{ $index }})">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('admin.add_new_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.category_name_english') }} *</label>
                        <input type="text" class="form-control" placeholder="{{ __('admin.enter_category_name') }}" style="border-radius: 10px;" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.category_name_arabic') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('admin.enter_category_name_arabic') }}" dir="rtl" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.parent_category') }}</label>
                        <select class="form-select" style="border-radius: 10px;">
                            <option value="">{{ __('admin.none_top_level') }}</option>
                            <option>{{ __('admin.movies') }}</option>
                            <option>{{ __('admin.series') }}</option>
                            <option>{{ __('admin.live_tv') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.icon') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-folder" id="iconPreview"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="fa-folder" value="fa-folder"
                                   onchange="updateIconPreview(this.value)" style="border-radius: 0 10px 10px 0;">
                        </div>
                        <small class="text-muted">{{ __('admin.use_font_awesome_icons') }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.color') }}</label>
                        <input type="color" class="form-control form-control-color" value="#667eea" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.description') }}</label>
                        <textarea class="form-control" rows="3" placeholder="{{ __('admin.category_description') }}" style="border-radius: 10px;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.sort_order') }}</label>
                        <input type="number" class="form-control" value="0" style="border-radius: 10px;">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="isActive" checked>
                        <label class="form-check-label" for="isActive">
                            {{ __('admin.active') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('admin.add_category') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    function editCategory(id) {
        // Open edit modal
        alert('Edit category ' + id);
    }

    function deleteCategory(id) {
        if(confirm('{{ __('admin.confirm_delete_category') }}')) {
            alert('{{ __('admin.delete_category') }} ' + id);
        }
    }

    function toggleStatus(id) {
        alert('Toggle status for category ' + id);
    }

    function updateIconPreview(iconClass) {
        document.getElementById('iconPreview').className = 'fas ' + iconClass;
    }
</script>
@endsection