@extends('admin.layouts.app')

@section('title', 'Create Subscription Plan')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.create_subscription_plan') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.subscription-plans.index') }}">{{ __('admin.subscription_plans') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px;">
            <strong>{{ __('admin.validation_errors') }}</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Create Form -->
    <div class="card-modern">
        <form action="{{ route('admin.subscription-plans.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Plan Details -->
                <div class="col-md-8">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.plan_details') }}</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('admin.plan_name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('admin.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">{{ __('admin.price') }} ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="duration_days" class="form-label">{{ __('admin.duration_days') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration_days') is-invalid @enderror" id="duration_days" name="duration_days" value="{{ old('duration_days', 30) }}" required>
                            @error('duration_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="max_devices" class="form-label">{{ __('admin.max_screens') }}</label>
                        <input type="number" class="form-control @error('max_devices') is-invalid @enderror" id="max_devices" name="max_devices" value="{{ old('max_devices', 1) }}">
                        @error('max_devices')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="features" class="form-label">{{ __('admin.features') }}</label>
                        <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features" rows="5" placeholder="Enter features, one per line">{{ old('features') }}</textarea>
                        <small class="text-muted">{{ __('admin.enter_one_feature_per_line') }}</small>
                        @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Plan Settings -->
                <div class="col-md-4">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.settings') }}</h5>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ __('admin.active') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn-modern btn-success-modern">
                    <i class="fas fa-save me-2"></i>{{ __('admin.create_plan') }}
                </button>
                <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
