@extends('admin.layouts.app')

@section('title', __('admin.cartoons_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Enhanced Header Section -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">
                    <i class="fas fa-palette me-2" style="color: #fbbf24;"></i>{{ __('admin.cartoons_management') }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.cartoons') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-info-modern me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-import me-2"></i>{{ __('admin.bulk_import') }}
                </button>
                <a href="{{ route('admin.cartoons.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_cartoon') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">342</div>
                        <div class="stat-label">{{ __('admin.total_cartoons') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);">
                        <i class="fas fa-film text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">48</div>
                        <div class="stat-label">{{ __('admin.cartoon_series') }}</div>
                        <small class="text-muted">{{ __('admin.with_episodes', ['count' => '1,245']) }}</small>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-tv text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">24</div>
                        <div class="stat-label">{{ __('admin.popular_cartoons') }}</div>
                        <small class="text-muted">{{ __('admin.trending_this_week') }}</small>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-fire text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">15.2K</div>
                        <div class="stat-label">{{ __('admin.kid_viewers') }}</div>
                        <small class="text-success"><i class="fas fa-arrow-up"></i> +8.5%</small>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Age Rating Tabs -->
    <div class="card-modern mb-4">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#all-ages">
                    <i class="fas fa-smile me-2"></i>{{ __('admin.all_ages') }}
                    <span class="badge bg-primary ms-2">128</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#age-3-5">
                    <i class="fas fa-baby me-2"></i>{{ __('admin.ages_3_5') }}
                    <span class="badge bg-info ms-2">86</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#age-6-8">
                    <i class="fas fa-child me-2"></i>{{ __('admin.ages_6_8') }}
                    <span class="badge bg-warning ms-2">72</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#age-9-12">
                    <i class="fas fa-user-friends me-2"></i>{{ __('admin.ages_9_12') }}
                    <span class="badge bg-success ms-2">56</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#educational">
                    <i class="fas fa-graduation-cap me-2"></i>{{ __('admin.educational') }}
                    <span class="badge bg-purple ms-2">42</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="all-ages">
            <!-- Popular Cartoons Section -->
            <div class="card-modern mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-fire me-2" style="color: #ef4444;"></i>{{ __('admin.trending_cartoons') }}
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>{{ __('admin.all_categories') }}</option>
                            <option>{{ __('admin.adventure') }}</option>
                            <option>{{ __('admin.comedy') }}</option>
                            <option>{{ __('admin.educational') }}</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Cartoon Card 1 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="cartoon-card">
                                <div class="cartoon-poster position-relative">
                                    <img src="https://via.placeholder.com/300x450/fbbf24/ffffff?text=Cartoon+1"
                                         class="img-fluid rounded" alt="Cartoon">
                                    <div class="age-badge">3+</div>
                                    <div class="play-overlay">
                                        <button class="btn btn-white rounded-circle">
                                            <i class="fas fa-play text-primary"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cartoon-info mt-2">
                                    <h6 class="mb-1">Super Adventure Friends</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-success">{{ __('admin.series') }}</span>
                                            <span class="badge bg-info">{{ __('admin.season_episode', ['season' => 3, 'episode' => 12]) }}</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star text-warning"></i> 4.8
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="btn-group btn-group-sm w-100">
                                            <button class="btn btn-outline-primary" onclick="editCartoon(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="viewEpisodes(1)">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-success" onclick="viewStats(1)">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteCartoon(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cartoon Card 2 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="cartoon-card">
                                <div class="cartoon-poster position-relative">
                                    <img src="https://via.placeholder.com/300x450/3b82f6/ffffff?text=Cartoon+2"
                                         class="img-fluid rounded" alt="Cartoon">
                                    <div class="age-badge">6+</div>
                                    <div class="play-overlay">
                                        <button class="btn btn-white rounded-circle">
                                            <i class="fas fa-play text-primary"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cartoon-info mt-2">
                                    <h6 class="mb-1">Magic School Bus Returns</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-purple">Educational</span>
                                            <span class="badge bg-info">26 Eps</span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star text-warning"></i> 4.9
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="btn-group btn-group-sm w-100">
                                            <button class="btn btn-outline-primary" onclick="editCartoon(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="viewEpisodes(2)">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-success" onclick="viewStats(2)">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteCartoon(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- More cartoon cards... -->
                        @for($i = 3; $i <= 8; $i++)
                        <div class="col-md-6 col-lg-3">
                            <div class="cartoon-card">
                                <div class="cartoon-poster position-relative">
                                    <img src="https://via.placeholder.com/300x450/{{ ['10b981', 'ef4444', '8b5cf6', 'f59e0b', '06b6d4', 'ec4899'][($i-3) % 6] }}/ffffff?text=Cartoon+{{ $i }}"
                                         class="img-fluid rounded" alt="Cartoon">
                                    <div class="age-badge">{{ [3, 6, 9, 12][($i-3) % 4] }}+</div>
                                    <div class="play-overlay">
                                        <button class="btn btn-white rounded-circle">
                                            <i class="fas fa-play text-primary"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cartoon-info mt-2">
                                    <h6 class="mb-1">Cartoon Title {{ $i }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-{{ ['success', 'info', 'warning', 'primary'][($i-3) % 4] }}">
                                                {{ ['Series', 'Movie', 'Special', 'Short'][($i-3) % 4] }}
                                            </span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star text-warning"></i> {{ number_format(rand(40, 50) / 10, 1) }}
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="btn-group btn-group-sm w-100">
                                            <button class="btn btn-outline-primary" onclick="editCartoon({{ $i }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="viewEpisodes({{ $i }})">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-success" onclick="viewStats({{ $i }})">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteCartoon({{ $i }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Cartoon Series Table -->
            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-tv me-2" style="color: #10b981;"></i>{{ __('admin.cartoon_series') }}
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto; border-radius: 10px;">
                            <option>{{ __('admin.all_categories') }}</option>
                            <option>{{ __('admin.adventure') }}</option>
                            <option>{{ __('admin.comedy') }}</option>
                            <option>{{ __('admin.educational') }}</option>
                            <option>{{ __('admin.fantasy') }}</option>
                        </select>
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                            <input type="search" class="form-control form-control-sm ps-5" style="width: 250px; border-radius: 10px;" placeholder="{{ __('admin.search_cartoons') }}">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" class="form-check-input" id="selectAllCartoons">
                                    </th>
                                    <th width="80">{{ __('admin.poster') }}</th>
                                    <th>{{ __('admin.title') }}</th>
                                    <th>{{ __('admin.type') }}</th>
                                    <th>{{ __('admin.seasons') }}</th>
                                    <th>{{ __('admin.episodes') }}</th>
                                    <th>{{ __('admin.age_rating') }}</th>
                                    <th>{{ __('admin.views') }}</th>
                                    <th>{{ __('admin.status') }}</th>
                                    <th class="text-center">{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/50x75/fbbf24/ffffff?text=C1"
                                             class="rounded" alt="Poster">
                                    </td>
                                    <td>
                                        <strong>Paw Patrol</strong>
                                        <br><small class="text-muted">Adventure, Rescue</small>
                                    </td>
                                    <td><span class="badge bg-success">Series</span></td>
                                    <td>8</td>
                                    <td>208</td>
                                    <td><span class="badge bg-info">3+</span></td>
                                    <td>2.5M</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Episodes">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/50x75/3b82f6/ffffff?text=C2"
                                             class="rounded" alt="Poster">
                                    </td>
                                    <td>
                                        <strong>SpongeBob SquarePants</strong>
                                        <br><small class="text-muted">Comedy, Adventure</small>
                                    </td>
                                    <td><span class="badge bg-success">Series</span></td>
                                    <td>13</td>
                                    <td>286</td>
                                    <td><span class="badge bg-warning">6+</span></td>
                                    <td>4.1M</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Episodes">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/50x75/10b981/ffffff?text=C3"
                                             class="rounded" alt="Poster">
                                    </td>
                                    <td>
                                        <strong>Dora the Explorer</strong>
                                        <br><small class="text-muted">Educational, Adventure</small>
                                    </td>
                                    <td><span class="badge bg-purple">Educational</span></td>
                                    <td>8</td>
                                    <td>178</td>
                                    <td><span class="badge bg-info">3+</span></td>
                                    <td>3.2M</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Episodes">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Age-specific tabs content... -->
        <div class="tab-pane fade" id="age-3-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Content for Ages 3-5</h5>
                    <p>Preschool content with simple stories and bright colors...</p>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="educational">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Educational Content</h5>
                    <p>Learning-focused cartoons and educational series...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Cartoon Modal -->
<div class="modal fade" id="cartoonModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-film me-2"></i>Add New Cartoon
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="cartoonForm">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header">Basic Information</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Enter cartoon title">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Type</label>
                                            <select class="form-select" onchange="toggleSeriesFields(this.value)">
                                                <option value="movie">Movie</option>
                                                <option value="series">Series</option>
                                                <option value="short">Short Film</option>
                                                <option value="special">TV Special</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Age Rating</label>
                                            <select class="form-select">
                                                <option>All Ages</option>
                                                <option>3+</option>
                                                <option>6+</option>
                                                <option>9+</option>
                                                <option>12+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Categories</label>
                                        <select class="form-select" multiple style="height: 100px;">
                                            <option>Adventure</option>
                                            <option>Comedy</option>
                                            <option>Educational</option>
                                            <option>Fantasy</option>
                                            <option>Musical</option>
                                            <option>Science Fiction</option>
                                            <option>Superhero</option>
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="4" placeholder="Enter cartoon description..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Series Information (shown only for series) -->
                            <div class="card mb-3" id="seriesInfo" style="display: none;">
                                <div class="card-header">Series Information</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Number of Seasons</label>
                                            <input type="number" class="form-control" value="1" min="1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Episodes per Season</label>
                                            <input type="number" class="form-control" placeholder="e.g., 26">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Episode Duration (minutes)</label>
                                        <input type="number" class="form-control" value="22">
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="card">
                                <div class="card-header">Media Files</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Poster Image</label>
                                            <div class="border rounded p-3 text-center bg-light">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <p class="text-muted small mb-2">Recommended: 300x450px</p>
                                                <input type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Banner Image</label>
                                            <div class="border rounded p-3 text-center bg-light">
                                                <i class="fas fa-panorama fa-3x text-muted mb-2"></i>
                                                <p class="text-muted small mb-2">Recommended: 1920x600px</p>
                                                <input type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Parental Features -->
                            <div class="card mb-3">
                                <div class="card-header">Parental Features</div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Safe for Kids Mode</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">No Ads During Playback</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Educational Content</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Parental Lock Required</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Learning Tags -->
                            <div class="card mb-3">
                                <div class="card-header">Learning Tags</div>
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Numbers & Counting</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Letters & Reading</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Colors & Shapes</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Science & Nature</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Social Skills</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Problem Solving</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Video Source -->
                            <div class="card mb-3">
                                <div class="card-header">Video Source</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Source Type</label>
                                        <select class="form-select">
                                            <option>Vimeo</option>
                                            <option>YouTube Kids</option>
                                            <option>Direct Upload</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Video ID/URL</label>
                                        <input type="text" class="form-control" placeholder="Enter video ID or URL">
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card">
                                <div class="card-header">Status</div>
                                <div class="card-body">
                                    <select class="form-select">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                        <option>Coming Soon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveCartoon()">
                    <i class="fas fa-save me-2"></i>Save Cartoon
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Episodes Modal -->
<div class="modal fade" id="episodesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Episodes Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <h6>Season 1 Episodes</h6>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Episode
                    </button>
                </div>
                <div class="list-group">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Episode {{ $i }}: Adventure Time</h6>
                                <small class="text-muted">Duration: 22 min | Views: {{ rand(1000, 9999) }}</small>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-purple {
    background-color: #8b5cf6;
}

.cartoon-card {
    height: 100%;
    transition: transform 0.3s;
}

.cartoon-card:hover {
    transform: translateY(-5px);
}

.cartoon-poster {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
}

.age-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #fbbf24;
    color: #000;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-weight: bold;
    font-size: 0.875rem;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.cartoon-card:hover .play-overlay {
    opacity: 1;
}

.rating {
    font-size: 0.875rem;
    font-weight: 600;
}

.cartoon-info h6 {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>

<script>
function editCartoon(id) {
    document.querySelector('#cartoonModal .modal-title').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Cartoon';
    new bootstrap.Modal(document.getElementById('cartoonModal')).show();
}

function deleteCartoon(id) {
    if (confirm('Are you sure you want to delete this cartoon?')) {
        alert('Cartoon deleted successfully!');
    }
}

function viewEpisodes(id) {
    new bootstrap.Modal(document.getElementById('episodesModal')).show();
}

function viewStats(id) {
    alert('Opening statistics for cartoon ' + id);
}

function saveCartoon() {
    alert('Cartoon saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('cartoonModal')).hide();
}

function toggleSeriesFields(type) {
    const seriesInfo = document.getElementById('seriesInfo');
    if (type === 'series') {
        seriesInfo.style.display = 'block';
    } else {
        seriesInfo.style.display = 'none';
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection