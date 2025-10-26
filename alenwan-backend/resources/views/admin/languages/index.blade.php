@extends('admin.layouts.app')

@section('title', __('admin.languages_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.languages_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.languages') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.languages.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_language') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="stat-value">{{ \App\Models\Language::count() }}</div>
                <div class="stat-label">{{ __('admin.total_languages') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-language fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="stat-value">{{ \App\Models\Language::where('is_active', true)->count() }}</div>
                <div class="stat-label">{{ __('admin.active_languages') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="stat-value">{{ \App\Models\Movie::whereNotNull('language_id')->distinct('language_id')->count('language_id') }}</div>
                <div class="stat-label">{{ __('admin.languages_with_content') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-film fa-3x text-primary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="stat-value">{{ \App\Models\Language::where('is_rtl', true)->count() }}</div>
                <div class="stat-label">{{ __('admin.rtl_languages') }}</div>
                <div class="stat-icon position-absolute end-0 top-0 m-3" style="opacity: 0.2;">
                    <i class="fas fa-align-right fa-3x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card-modern mb-4 animate-slide-in">
        <form method="GET" action="{{ route('admin.languages.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search_languages') }}"
                               value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" style="border-radius: 10px;">
                        <option value="all">{{ __('admin.all_statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('admin.active') }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('admin.inactive') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="rtl" class="form-select" style="border-radius: 10px;">
                        <option value="all">{{ __('admin.all_directions') }}</option>
                        <option value="1" {{ request('rtl') == '1' ? 'selected' : '' }}>{{ __('admin.rtl_only') }}</option>
                        <option value="0" {{ request('rtl') == '0' ? 'selected' : '' }}>{{ __('admin.ltr_only') }}</option>
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

    <!-- Languages Table -->
    <div class="card-modern animate-slide-in">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background: var(--bg-secondary);">
                    <tr>
                        <th style="padding: 1rem;">{{ __('admin.language') }}</th>
                        <th>{{ __('admin.code') }}</th>
                        <th>{{ __('admin.native_name') }}</th>
                        <th>{{ __('admin.direction') }}</th>
                        <th>{{ __('admin.content_count') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th>{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($languages as $language)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($language->flag_icon)
                                    <img src="{{ asset('storage/' . $language->flag_icon) }}"
                                         alt="{{ $language->name }}"
                                         style="width: 32px; height: 24px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                @else
                                    <i class="fas fa-flag" style="font-size: 24px; margin-right: 10px; color: #ccc;"></i>
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $language->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $language->code }}</span>
                        </td>
                        <td>{{ $language->native_name ?? '-' }}</td>
                        <td>
                            @if($language->is_rtl)
                                <span class="badge bg-warning">
                                    <i class="fas fa-arrow-left me-1"></i>RTL
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="fas fa-arrow-right me-1"></i>LTR
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-film text-primary me-2"></i>
                                <span>{{ $language->movies_count + $language->series_count + $language->podcasts_count }}</span>
                            </div>
                        </td>
                        <td>
                            @if($language->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>{{ __('admin.active') }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times-circle me-1"></i>{{ __('admin.inactive') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.languages.edit', $language->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="{{ __('admin.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.languages.destroy', $language->id) }}"
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
                            <i class="fas fa-language fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('admin.no_languages_found') }}</p>
                            <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>{{ __('admin.add_first_language') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($languages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $languages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
