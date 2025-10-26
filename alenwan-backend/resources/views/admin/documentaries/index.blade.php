@extends('admin.layouts.app')

@section('title', __('admin.documentaries_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.documentaries_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.documentaries') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.documentaries.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_documentary') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="stat-value">{{ \App\Models\Documentary::count() }}</div>
                <div class="stat-label">{{ __('admin.total_documentaries') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-book fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="stat-value">{{ \App\Models\Documentary::where('status', 'published')->count() }}</div>
                <div class="stat-label">{{ __('admin.published') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="stat-value">{{ \App\Models\Documentary::where('status', 'draft')->count() }}</div>
                <div class="stat-label">{{ __('admin.drafts') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-edit fa-3x text-warning"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="stat-value">{{ \App\Models\Documentary::sum('views_count') }}</div>
                <div class="stat-label">{{ __('admin.total_views') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-eye fa-3x text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card-modern mb-4 animate-slide-in">
        <form method="GET" action="{{ route('admin.documentaries.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search_documentaries') }}"
                               value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" style="border-radius: 10px;">
                        <option value="all">{{ __('admin.all_statuses') }}</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>{{ __('admin.archived') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-select" style="border-radius: 10px;">
                        <option value="">{{ __('admin.all_categories') }}</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">
                        <i class="fas fa-filter me-2"></i>{{ __('admin.filter') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Documentaries Table -->
    <div class="card-modern animate-slide-in">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background: var(--bg-secondary);">
                    <tr>
                        <th style="padding: 1rem;">{{ __('admin.documentary') }}</th>
                        <th>{{ __('admin.director') }}</th>
                        <th>{{ __('admin.category') }}</th>
                        <th>{{ __('admin.year') }}</th>
                        <th>{{ __('admin.views') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th>{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentaries as $documentary)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($documentary->poster_path)
                                    <img src="{{ asset('storage/' . $documentary->poster_path) }}"
                                         alt="{{ $documentary->title }}"
                                         style="width: 60px; height: 90px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                @else
                                    <div style="width: 60px; height: 90px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-book text-white fa-2x"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; margin-bottom: 4px;">{{ $documentary->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($documentary->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $documentary->director ?? '-' }}</td>
                        <td>
                            @if($documentary->category)
                                <span class="badge bg-info">{{ $documentary->category->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $documentary->release_year ?? '-' }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye text-primary me-2"></i>
                                <span>{{ number_format($documentary->views_count) }}</span>
                            </div>
                        </td>
                        <td>
                            @if($documentary->status == 'published')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>{{ __('admin.published') }}
                                </span>
                            @elseif($documentary->status == 'draft')
                                <span class="badge bg-warning">
                                    <i class="fas fa-edit me-1"></i>{{ __('admin.draft') }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-archive me-1"></i>{{ __('admin.archived') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.documentaries.edit', $documentary->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="{{ __('admin.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.documentaries.destroy', $documentary->id) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="{{ __('admin.delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('admin.no_documentaries_found') }}</p>
                            <a href="{{ route('admin.documentaries.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>{{ __('admin.add_first_documentary') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($documentaries->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $documentaries->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
