@extends('admin.layouts.app')

@section('title', __('admin.banners_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Enhanced Header Section -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">
                    <i class="fas fa-images me-2" style="color: #f59e0b;"></i>{{ __('admin.banners_management') }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.banners') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-info-modern me-2" onclick="previewBanners()">
                    <i class="fas fa-eye me-2"></i>{{ __('admin.preview_all') }}
                </button>
                <button class="btn-modern btn-success-modern" onclick="showCreateModal()">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_banner') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-images text-primary fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Banners</h6>
                            <h3 class="mb-0">24</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-toggle-on text-success fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active</h6>
                            <h3 class="mb-0">18</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock text-warning fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Scheduled</h6>
                            <h3 class="mb-0">3</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chart-line text-info fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Click Rate</h6>
                            <h3 class="mb-0">4.2%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Types Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#hero-banners">
                <i class="fas fa-home me-2"></i>Hero Banners
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#slider-banners">
                <i class="fas fa-sliders-h me-2"></i>Slider Banners
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#promo-banners">
                <i class="fas fa-tags me-2"></i>Promotional
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#category-banners">
                <i class="fas fa-th-large me-2"></i>Category Banners
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Hero Banners Tab -->
        <div class="tab-pane fade show active" id="hero-banners">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3" id="heroBannersGrid">
                        <!-- Hero Banner Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="banner-card position-relative">
                                <img src="https://via.placeholder.com/800x400/6366f1/ffffff?text=Hero+Banner+1"
                                     class="img-fluid rounded" alt="Hero Banner">
                                <div class="banner-overlay">
                                    <div class="banner-info">
                                        <h5 class="text-white mb-2">Summer Sale 2024</h5>
                                        <p class="text-white-50 small mb-2">Homepage - Top Section</p>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-success">Active</span>
                                            <span class="badge bg-info">12.5k Views</span>
                                        </div>
                                    </div>
                                    <div class="banner-actions">
                                        <button class="btn btn-sm btn-light" onclick="editBanner(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="duplicateBanner(1)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="toggleBanner(1)">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBanner(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- More banner cards -->
                        <div class="col-md-6 col-lg-4">
                            <div class="banner-card position-relative">
                                <img src="https://via.placeholder.com/800x400/10b981/ffffff?text=Hero+Banner+2"
                                     class="img-fluid rounded" alt="Hero Banner">
                                <div class="banner-overlay">
                                    <div class="banner-info">
                                        <h5 class="text-white mb-2">New Releases</h5>
                                        <p class="text-white-50 small mb-2">Homepage - Featured</p>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-success">Active</span>
                                            <span class="badge bg-info">8.3k Views</span>
                                        </div>
                                    </div>
                                    <div class="banner-actions">
                                        <button class="btn btn-sm btn-light" onclick="editBanner(2)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="duplicateBanner(2)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="toggleBanner(2)">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBanner(2)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="banner-card position-relative">
                                <img src="https://via.placeholder.com/800x400/f59e0b/ffffff?text=Hero+Banner+3"
                                     class="img-fluid rounded" alt="Hero Banner">
                                <div class="banner-overlay">
                                    <div class="banner-info">
                                        <h5 class="text-white mb-2">Premium Content</h5>
                                        <p class="text-white-50 small mb-2">Homepage - Premium Section</p>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-warning">Scheduled</span>
                                            <span class="badge bg-info">Starts Tomorrow</span>
                                        </div>
                                    </div>
                                    <div class="banner-actions">
                                        <button class="btn btn-sm btn-light" onclick="editBanner(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="duplicateBanner(3)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="toggleBanner(3)">
                                            <i class="fas fa-toggle-off"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBanner(3)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Banners Tab -->
        <div class="tab-pane fade" id="slider-banners">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Title</th>
                                    <th>Position</th>
                                    <th>Target</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://via.placeholder.com/150x75/ef4444/ffffff?text=Slider+1"
                                             class="rounded" width="100" alt="Slider">
                                    </td>
                                    <td>
                                        <strong>Action Movies Collection</strong>
                                        <br><small class="text-muted">Added: 2 days ago</small>
                                    </td>
                                    <td><span class="badge bg-primary">Position 1</span></td>
                                    <td>Movies Category</td>
                                    <td>5 seconds</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-outline-warning"><i class="fas fa-arrows-alt"></i></button>
                                            <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://via.placeholder.com/150x75/3b82f6/ffffff?text=Slider+2"
                                             class="rounded" width="100" alt="Slider">
                                    </td>
                                    <td>
                                        <strong>Weekend Special</strong>
                                        <br><small class="text-muted">Added: 1 week ago</small>
                                    </td>
                                    <td><span class="badge bg-primary">Position 2</span></td>
                                    <td>Subscription Page</td>
                                    <td>7 seconds</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-outline-warning"><i class="fas fa-arrows-alt"></i></button>
                                            <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotional Banners Tab -->
        <div class="tab-pane fade" id="promo-banners">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        @for($i = 1; $i <= 6; $i++)
                        <div class="col-md-4">
                            <div class="promo-banner-card">
                                <img src="https://via.placeholder.com/400x200/{{ ['10b981', 'f59e0b', '6366f1', 'ef4444', '8b5cf6', '06b6d4'][($i-1) % 6] }}/ffffff?text=Promo+{{ $i }}"
                                     class="img-fluid rounded mb-3" alt="Promo Banner">
                                <h6>Special Offer #{{ $i }}</h6>
                                <p class="text-muted small">Valid until: Dec 31, 2024</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-info me-2">{{ rand(100, 999) }} Clicks</span>
                                        <span class="badge bg-success">{{ rand(10, 50) }} Conversions</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary"><i class="fas fa-chart-bar"></i></button>
                                        <button class="btn btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Banners Tab -->
        <div class="tab-pane fade" id="category-banners">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Category-Specific Banners</h5>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>Add Category Banner
                                </button>
                            </div>
                        </div>

                        <!-- Category Banner Cards -->
                        <div class="col-md-6">
                            <div class="category-banner-card p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/100x100/ef4444/ffffff?text=Movies"
                                         class="rounded me-3" width="80" alt="Movies">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Movies Category</h6>
                                        <p class="text-muted small mb-2">3 Active Banners</p>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Manage</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="category-banner-card p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/100x100/3b82f6/ffffff?text=Series"
                                         class="rounded me-3" width="80" alt="Series">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Series Category</h6>
                                        <p class="text-muted small mb-2">5 Active Banners</p>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-info" style="width: 90%"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Manage</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="category-banner-card p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/100x100/10b981/ffffff?text=Sports"
                                         class="rounded me-3" width="80" alt="Sports">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Sports Category</h6>
                                        <p class="text-muted small mb-2">2 Active Banners</p>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-warning" style="width: 40%"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Manage</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="category-banner-card p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/100x100/f59e0b/ffffff?text=Kids"
                                         class="rounded me-3" width="80" alt="Kids">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Kids Category</h6>
                                        <p class="text-muted small mb-2">4 Active Banners</p>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Manage</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Banner Performance Analytics
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="bannerPerformanceChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>Create New Banner
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bannerForm">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Banner Details -->
                            <div class="card mb-3">
                                <div class="card-header">Banner Information</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Banner Title</label>
                                        <input type="text" class="form-control" placeholder="Enter banner title">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Banner Type</label>
                                            <select class="form-select">
                                                <option>Hero Banner</option>
                                                <option>Slider Banner</option>
                                                <option>Promotional Banner</option>
                                                <option>Category Banner</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Target Page</label>
                                            <select class="form-select">
                                                <option>Homepage</option>
                                                <option>Movies</option>
                                                <option>Series</option>
                                                <option>Sports</option>
                                                <option>Subscription</option>
                                                <option>External URL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Target URL/Content ID</label>
                                        <input type="text" class="form-control" placeholder="e.g., /movies/123 or https://...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Banner description..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Upload -->
                            <div class="card">
                                <div class="card-header">Banner Media</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Desktop Image</label>
                                            <div class="border rounded p-3 text-center bg-light">
                                                <i class="fas fa-desktop fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-2">Recommended: 1920x600px</p>
                                                <input type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mobile Image</label>
                                            <div class="border rounded p-3 text-center bg-light">
                                                <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-2">Recommended: 768x400px</p>
                                                <input type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Settings -->
                            <div class="card mb-3">
                                <div class="card-header">Display Settings</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Position/Order</label>
                                        <input type="number" class="form-control" value="1" min="1">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Display Duration (seconds)</label>
                                        <input type="number" class="form-control" value="5" min="1">
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Auto-play in slider</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Show on mobile</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Show on desktop</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="card mb-3">
                                <div class="card-header">Schedule</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="datetime-local" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">End Date</label>
                                        <input type="datetime-local" class="form-control">
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">No end date</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card">
                                <div class="card-header">Status</div>
                                <div class="card-body">
                                    <select class="form-select">
                                        <option value="active" selected>Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveBanner()">
                    <i class="fas fa-save me-2"></i>Save Banner
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banner Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="bannerPreviewCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/1920x600/6366f1/ffffff?text=Banner+Preview+1"
                                 class="d-block w-100" alt="Banner 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1920x600/10b981/ffffff?text=Banner+Preview+2"
                                 class="d-block w-100" alt="Banner 2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/1920x600/f59e0b/ffffff?text=Banner+Preview+3"
                                 class="d-block w-100" alt="Banner 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerPreviewCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerPreviewCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.banner-card {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    transition: transform 0.3s;
}

.banner-card:hover {
    transform: translateY(-5px);
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s;
}

.banner-card:hover .banner-overlay {
    opacity: 1;
}

.banner-info {
    margin-top: auto;
}

.banner-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.promo-banner-card {
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    transition: box-shadow 0.3s;
}

.promo-banner-card:hover {
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.category-banner-card {
    transition: background-color 0.3s;
}

.category-banner-card:hover {
    background-color: #f8f9fa;
}
</style>

<script>
// Banner Management Functions
function showCreateModal() {
    document.getElementById('bannerForm').reset();
    document.querySelector('#bannerModal .modal-title').innerHTML = '<i class="fas fa-plus me-2"></i>Create New Banner';
    new bootstrap.Modal(document.getElementById('bannerModal')).show();
}

function editBanner(id) {
    document.querySelector('#bannerModal .modal-title').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Banner';
    new bootstrap.Modal(document.getElementById('bannerModal')).show();
}

function saveBanner() {
    alert('Banner saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('bannerModal')).hide();
}

function deleteBanner(id) {
    if (confirm('Are you sure you want to delete this banner?')) {
        alert('Banner deleted successfully!');
    }
}

function toggleBanner(id) {
    alert('Banner status toggled!');
}

function duplicateBanner(id) {
    alert('Banner duplicated successfully!');
}

function previewBanners() {
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

// Initialize Performance Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bannerPerformanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Impressions',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4
            }, {
                label: 'Clicks',
                data: [480, 760, 600, 1000, 880, 1200, 1120],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4
            }, {
                label: 'Conversions',
                data: [48, 76, 60, 100, 88, 120, 112],
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection