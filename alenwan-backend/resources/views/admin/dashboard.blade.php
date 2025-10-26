@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Welcome to Alenwan Admin Panel</h5>
                <p class="card-text">This is your enhanced admin dashboard with multi-language support.</p>
                <p class="card-text">
                    <strong>Current Language:</strong>
                    @switch(app()->getLocale())
                        @case('ar') العربية (Arabic) @break
                        @case('fr') Français (French) @break
                        @case('es') Español (Spanish) @break
                        @default English @break
                    @endswitch
                    <br>
                    <strong>Direction:</strong> {{ app()->getLocale() === 'ar' ? 'RTL' : 'LTR' }}
                </p>
                <a href="{{ route('admin.settings') }}" class="btn btn-primary">
                    <i class="fas fa-cog me-2"></i>Go to Settings
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-film fa-3x text-primary mb-3"></i>
                <h5>{{ __('admin.movies') }}</h5>
                <p class="text-muted">Manage movies</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-tv fa-3x text-success mb-3"></i>
                <h5>{{ __('admin.series') }}</h5>
                <p class="text-muted">Manage series</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-3x text-info mb-3"></i>
                <h5>{{ __('admin.users') }}</h5>
                <p class="text-muted">Manage users</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-credit-card fa-3x text-warning mb-3"></i>
                <h5>{{ __('admin.subscriptions') }}</h5>
                <p class="text-muted">Manage subscriptions</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    background-color: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    box-shadow: 0 4px 15px rgba(162, 1, 54, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #ffffff;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(162, 1, 54, 0.3);
}

.card .card-body {
    color: #ffffff;
}

.card .card-title {
    color: #ffffff;
}

.card .card-text {
    color: rgba(255, 255, 255, 0.7);
}

.text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
}
</style>
@endpush
@endsection