@extends('admin.layouts.app')

@section('title', 'Subscription Plans')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.subscription_plans_title') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.subscription_plans') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.subscription-plans.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.create_new_plan') }}
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
                        <div class="stat-value">{{ $stats['active_plans'] }}</div>
                        <div class="stat-label">{{ __('admin.active_plans') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $stats['total_plans'] }}</div>
                        <div class="stat-label">{{ __('admin.total_plans') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">${{ number_format($plans->sum('price'), 2) }}</div>
                        <div class="stat-label">{{ __('admin.total_revenue_potential') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">${{ number_format($plans->avg('price'), 2) }}</div>
                        <div class="stat-label">{{ __('admin.average_price') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Subscription Plans Grid -->
    <div class="row g-4">
        @forelse($plans as $plan)
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100" style="position: relative;">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-box" style="font-size: 3rem; color: var(--text-secondary);"></i>
                    </div>
                    <h3 style="color: var(--text-primary); font-weight: 700;">{{ $plan->name }}</h3>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary);">${{ number_format($plan->price, 2) }}</span>
                        <span class="text-muted ms-2">{{ __('admin.per_month') }}</span>
                    </div>
                </div>

                <p class="text-muted mb-4">{{ $plan->description }}</p>

                @if($plan->features)
                <ul class="list-unstyled mb-4">
                    @foreach($plan->features as $feature)
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }} me-2">
                            {{ $plan->is_active ? __('admin.active') : __('admin.inactive') }}
                        </span>
                        <span class="badge bg-info">{{ $plan->max_devices }} {{ __('admin.devices') }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                        </a>
                        <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>No subscription plans found. <a href="{{ route('admin.subscription-plans.create') }}">Create one now</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- OLD HARDCODED PLANS - REMOVED -->
    <div class="row g-4" style="display: none;">
        <!-- Basic Plan -->
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100" style="position: relative;">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-box" style="font-size: 3rem; color: var(--text-secondary);"></i>
                    </div>
                    <h3 style="color: var(--text-primary); font-weight: 700;">{{ __('admin.basic_plan') }}</h3>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary);">$9.99</span>
                        <span class="text-muted ms-2">{{ __('admin.per_month') }}</span>
                    </div>
                </div>

                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.hd_streaming') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.screen_at_time') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.mobile_tablet') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.limited_downloads') }}</span>
                    </li>
                    <li class="mb-3 text-muted">
                        <i class="fas fa-times-circle me-2"></i>
                        <span>{{ __('admin.4k_ultra_hd') }}</span>
                    </li>
                </ul>

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="badge bg-success me-2">{{ __('admin.active') }}</span>
                        <span class="badge bg-info">3,245 {{ __('admin.subscribers') }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.subscription-plans.edit', 1) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                        </a>
                        <form action="{{ route('admin.subscription-plans.destroy', 1) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Plan (Most Popular) -->
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100" style="position: relative; border: 2px solid var(--primary-color);">
                <div class="position-absolute top-0 start-50 translate-middle">
                    <span class="badge text-white" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); padding: 0.5rem 1.5rem; border-radius: 50px;">
                        <i class="fas fa-star me-1"></i>{{ __('admin.most_popular') }}
                    </span>
                </div>

                <div class="text-center mb-4 mt-3">
                    <div class="mb-3">
                        <i class="fas fa-gem" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h3 style="color: var(--text-primary); font-weight: 700;">{{ __('admin.premium_plan') }}</h3>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color);">$15.99</span>
                        <span class="text-muted ms-2">{{ __('admin.per_month') }}</span>
                    </div>
                </div>

                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.4k_ultra_hd') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>4 {{ __('admin.screens_at_time') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.all_devices') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.unlimited_downloads') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.family_profiles') }} (6)</span>
                    </li>
                </ul>

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="badge bg-success me-2">{{ __('admin.active') }}</span>
                        <span class="badge bg-info">7,892 {{ __('admin.subscribers') }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.subscription-plans.edit', 2) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                        </a>
                        <form action="{{ route('admin.subscription-plans.destroy', 2) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enterprise Plan -->
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100" style="position: relative;">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-briefcase" style="font-size: 3rem; color: var(--text-secondary);"></i>
                    </div>
                    <h3 style="color: var(--text-primary); font-weight: 700;">{{ __('admin.enterprise_plan') }}</h3>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary);">$29.99</span>
                        <span class="text-muted ms-2">{{ __('admin.per_month') }}</span>
                    </div>
                </div>

                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.everything_in_premium') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>8 {{ __('admin.screens_at_time') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.priority_support') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.early_access') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.no_ads') }}</span>
                    </li>
                </ul>

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="badge bg-success me-2">{{ __('admin.active') }}</span>
                        <span class="badge bg-info">1,678 {{ __('admin.subscribers') }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.subscription-plans.edit', 3) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                        </a>
                        <form action="{{ route('admin.subscription-plans.destroy', 3) }}" method="POST" class="flex-fill" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Free Plan -->
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100" style="position: relative;">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-gift" style="font-size: 3rem; color: var(--text-secondary);"></i>
                    </div>
                    <h3 style="color: var(--text-primary); font-weight: 700;">{{ __('admin.free_plan') }}</h3>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary);">$0</span>
                        <span class="text-muted ms-2">{{ __('admin.per_month') }}</span>
                    </div>
                </div>

                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.sd_streaming') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.screen_at_time') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>{{ __('admin.limited_content') }}</span>
                    </li>
                    <li class="mb-3 text-muted">
                        <i class="fas fa-times-circle me-2"></i>
                        <span>{{ __('admin.downloads') }}</span>
                    </li>
                    <li class="mb-3 text-muted">
                        <i class="fas fa-times-circle me-2"></i>
                        <span>{{ __('admin.ad_free') }}</span>
                    </li>
                </ul>

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="badge bg-success me-2">Active</span>
                        <span class="badge bg-info">15,432 users</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.subscription-plans.edit', 4) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                        </a>
                        <button class="btn btn-outline-secondary btn-sm flex-fill" disabled>
                            <i class="fas fa-lock me-1"></i>{{ __('admin.default') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Comparison Table -->
    <div class="card-modern mt-4">
        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.plans_comparison') }}</h5>
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>{{ __('admin.feature') }}</th>
                        <th class="text-center">{{ __('admin.free_plan') }}</th>
                        <th class="text-center">{{ __('admin.basic_plan') }}</th>
                        <th class="text-center" style="background: rgba(162, 1, 54, 0.05);">{{ __('admin.premium_plan') }}</th>
                        <th class="text-center">{{ __('admin.enterprise_plan') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ __('admin.price') }}</td>
                        <td class="text-center">$0/month</td>
                        <td class="text-center">$9.99/month</td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><strong>$15.99/month</strong></td>
                        <td class="text-center">$29.99/month</td>
                    </tr>
                    <tr>
                        <td>{{ __('admin.video_quality') }}</td>
                        <td class="text-center">SD</td>
                        <td class="text-center">HD</td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><strong>4K Ultra HD</strong></td>
                        <td class="text-center">4K Ultra HD</td>
                    </tr>
                    <tr>
                        <td>{{ __('admin.screens') }}</td>
                        <td class="text-center">1</td>
                        <td class="text-center">1</td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><strong>4</strong></td>
                        <td class="text-center">8</td>
                    </tr>
                    <tr>
                        <td>{{ __('admin.downloads') }}</td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center">{{ __('admin.limited_downloads') }}</td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><strong>{{ __('admin.unlimited_downloads') }}</strong></td>
                        <td class="text-center">{{ __('admin.unlimited_downloads') }}</td>
                    </tr>
                    <tr>
                        <td>Ad-free</td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><strong><i class="fas fa-check text-success"></i></strong></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td>Priority Support</td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center" style="background: rgba(162, 1, 54, 0.05);"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
