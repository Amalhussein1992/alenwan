@extends('admin.layouts.app')

@section('title', __('admin.movies_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.movies_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.movies') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-secondary-modern me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter me-2"></i>{{ __('admin.filter') }}
                </button>
                <button class="btn-modern btn-info-modern me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload me-2"></i>{{ __('admin.import') }}
                </button>
                <a href="{{ route('admin.movies.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_movie') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ \App\Models\Movie::count() }}</div>
                        <div class="stat-label">{{ __('admin.total_movies') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-film text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ \App\Models\Movie::where('status', 'published')->count() }}</div>
                        <div class="stat-label">Published</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ \App\Models\Movie::where('rating', '>=', 8)->count() }}</div>
                        <div class="stat-label">High Rated</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-star text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ \App\Models\Movie::where('status', 'draft')->count() }}</div>
                        <div class="stat-label">Drafts</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card-modern">
        <!-- Search and Actions Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2 align-items-center">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search movies..." style="width: 300px; border-radius: 10px;">
                </div>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>All Status</option>
                    <option>Published</option>
                    <option>Draft</option>
                    <option>Archived</option>
                </select>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>All Quality</option>
                    <option>4K</option>
                    <option>FHD</option>
                    <option>HD</option>
                    <option>SD</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-th me-1"></i>Grid View
                </button>
                <button class="btn btn-outline-secondary btn-sm active">
                    <i class="fas fa-list me-1"></i>List View
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form id="bulkForm" method="POST" action="{{ route('admin.movies.bulk-action') }}">
            @csrf
            <div class="mb-3 d-flex gap-2">
                <select name="action" class="form-select" style="width: 200px; border-radius: 10px;">
                    <option value="">-- Bulk Actions --</option>
                    <option value="delete">🗑️ Delete Selected</option>
                    <option value="publish">✅ Publish Selected</option>
                    <option value="archive">📦 Archive Selected</option>
                    <option value="feature">⭐ Feature Selected</option>
                </select>
                <button type="submit" class="btn-modern btn-primary-modern btn-sm">Apply</button>
            </div>

            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="30">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th width="80">Poster</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Quality</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Featured</th>
                            <th width="100" class="text-center">Premium</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DEBUG: Total movies = {{ $movies->total() }}, Count = {{ $movies->count() }} --}}
                        @forelse($movies as $movie)
                        <tr class="align-middle">
                            <td>
                                <input type="checkbox" class="form-check-input movie-checkbox"
                                       name="movie_ids[]" value="{{ $movie->id }}">
                            </td>
                            <td>
                                @if($movie->poster_path)
                                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                                         style="width: 50px; height: 70px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="bg-gradient text-white text-center"
                                         style="width: 50px; height: 70px; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-film"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <strong style="color: var(--text-primary);">{{ $movie->title }}</strong>
                                        @if($movie->title_ar)
                                            <br><small style="color: var(--text-secondary);">{{ $movie->title_ar }}</small>
                                        @endif
                                        <br>
                                        <div class="mt-1">
                                            <small class="text-muted me-2"><i class="fas fa-eye me-1"></i>{{ $movie->views_count ?? 0 }} views</small>
                                            <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $movie->duration_minutes ?? '-' }} min</small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    {{ $movie->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $movie->release_year ?? '-' }}</span>
                            </td>
                            <td>
                                @if($movie->rating)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span class="fw-semibold">{{ $movie->rating }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $qualityColors = [
                                        '4K' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                        'FHD' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                                        'HD' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                                        'SD' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
                                    ];
                                    $quality = $movie->quality ?? 'HD';
                                    $bgColor = $qualityColors[$quality] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                                @endphp
                                <span class="badge rounded-pill text-white" style="background: {{ $bgColor }}">{{ $quality }}</span>
                            </td>
                            <td>
                                @if($movie->status == 'published')
                                    <span class="badge rounded-pill bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Published
                                    </span>
                                @elseif($movie->status == 'draft')
                                    <span class="badge rounded-pill bg-warning">
                                        <i class="fas fa-edit me-1"></i>Draft
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-dark">
                                        <i class="fas fa-archive me-1"></i>Archived
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input toggle-featured" type="checkbox"
                                           data-id="{{ $movie->id }}" {{ $movie->is_featured ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input toggle-premium" type="checkbox"
                                           data-id="{{ $movie->id }}" {{ $movie->is_premium ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('admin.movies.show', $movie) }}" class="dropdown-item">
                                                <i class="fas fa-eye me-2 text-info"></i>View Details
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.movies.edit', $movie) }}" class="dropdown-item">
                                                <i class="fas fa-edit me-2 text-primary"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-copy me-2 text-success"></i>Duplicate
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.movies.destroy', $movie) }}"
                                                  method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-film text-muted" style="font-size: 4rem;"></i>
                                </div>
                                <h5 style="color: var(--text-primary);">No movies found</h5>
                                <p style="color: var(--text-secondary);">Start by adding your first movie to the collection.</p>
                                <a href="{{ route('admin.movies.create') }}" class="btn-modern btn-primary-modern mt-3">
                                    <i class="fas fa-plus me-2"></i>Add Your First Movie
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        @if(method_exists($movies, 'links'))
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div>
                <span style="color: var(--text-secondary);">
                    Showing {{ $movies->firstItem() ?? 0 }} - {{ $movies->lastItem() ?? 0 }} of {{ $movies->total() }} movies
                </span>
            </div>
            <div>
                {{ $movies->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Movies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('admin.movies.index') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quality</label>
                        <select name="quality" class="form-select">
                            <option value="">All</option>
                            <option value="SD">SD</option>
                            <option value="HD">HD</option>
                            <option value="FHD">Full HD</option>
                            <option value="4K">4K</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="">All</option>
                            <option value="featured">Featured Only</option>
                            <option value="premium">Premium Only</option>
                            <option value="free">Free Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.movie-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Toggle featured status
    document.querySelectorAll('.toggle-featured').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const movieId = this.dataset.id;
            const isFeatured = this.checked;

            fetch(`/admin/movies/${movieId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_featured: isFeatured })
            });
        });
    });

    // Toggle premium status
    document.querySelectorAll('.toggle-premium').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const movieId = this.dataset.id;
            const isPremium = this.checked;

            fetch(`/admin/movies/${movieId}/toggle-premium`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_premium: isPremium })
            });
        });
    });
</script>
@endsection