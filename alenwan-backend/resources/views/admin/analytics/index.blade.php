@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.analytics') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.analytics') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button class="btn btn-outline-primary active" data-period="week">{{ __('admin.week') }}</button>
                    <button class="btn btn-outline-primary" data-period="month">{{ __('admin.month') }}</button>
                    <button class="btn btn-outline-primary" data-period="year">{{ __('admin.year') }}</button>
                </div>
                <a href="{{ route('admin.analytics.export') }}" class="btn-modern btn-success-modern ms-2">
                    <i class="fas fa-download me-2"></i>{{ __('admin.export_report') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-4 g-3">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-2">{{ __('admin.total_users') }}</div>
                        <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>18.2% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-2">{{ __('admin.total_content') }}</div>
                        <div class="stat-value">{{ number_format($stats['total_movies'] + $stats['total_series'] + $stats['total_cartoons']) }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>12.5% {{ __('admin.from_last_week') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-2">{{ __('admin.new_users_month') }}</div>
                        <div class="stat-value">{{ number_format($stats['new_users_this_month']) }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>25.8% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="stat-label mb-2">{{ __('admin.live_streams') }}</div>
                        <div class="stat-value">{{ number_format($stats['total_livestreams']) }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.1% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4 g-3">
        <div class="col-lg-8">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.user_growth_trend') }}</h5>
                <canvas id="viewsTrendChart" height="80"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.device_breakdown') }}</h5>
                <canvas id="deviceChart" height="200"></canvas>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-mobile-alt text-primary me-2"></i>{{ __('admin.mobile') }}</span>
                        <strong>52%</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-desktop text-success me-2"></i>{{ __('admin.desktop') }}</span>
                        <strong>35%</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-tablet-alt text-warning me-2"></i>{{ __('admin.tablet') }}</span>
                        <strong>13%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4 g-3">
        <div class="col-lg-6">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.top_content') }}</h5>
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>{{ __('admin.title') }}</th>
                                <th>{{ __('admin.type') }}</th>
                                <th>{{ __('admin.views') }}</th>
                                <th>{{ __('admin.engagement') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topMovies as $index => $movie)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($index === 0)
                                        <div class="position-relative me-2">
                                            <i class="fas fa-crown text-warning" style="font-size: 0.8rem;"></i>
                                        </div>
                                        @endif
                                        <strong>{{ $movie->title }}</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">{{ __('admin.movie') }}</span></td>
                                <td>{{ number_format($movie->views ?? 0) }}</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ min(($movie->rating ?? 0) * 10, 100) }}%; background: var(--primary-color);"></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No movies available yet</td>
                            </tr>
                            @endforelse

                            @foreach($topSeries as $series)
                            <tr>
                                <td><strong>{{ $series->title }}</strong></td>
                                <td><span class="badge bg-success">{{ __('admin.tv_series') }}</span></td>
                                <td>{{ number_format($series->views ?? 0) }}</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ min(($series->rating ?? 0) * 10, 100) }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.geographic_distribution') }}</h5>
                <canvas id="geoChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- User Engagement -->
    <div class="row mb-4 g-3">
        <div class="col-lg-4">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.user_retention') }}</h5>
                <canvas id="retentionChart" height="200"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.content_distribution') }}</h5>
                <canvas id="subscriptionGrowthChart" height="200"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.revenue_by_plan') }}</h5>
                <canvas id="revenuePlanChart" height="200"></canvas>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('admin.premium_plan') }}</span>
                        <strong>$45.2K</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('admin.basic_plan') }}</span>
                        <strong>$28.5K</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">{{ __('admin.enterprise_plan') }}</span>
                        <strong>$15.8K</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
if (typeof Chart !== 'undefined') {
    const isRTL = document.documentElement.dir === 'rtl';
    if (isRTL) {
        Chart.defaults.font.family = 'Cairo, sans-serif';
    }

    // User Growth Chart
    const viewsCtx = document.getElementById('viewsTrendChart');
    if (viewsCtx) {
        new Chart(viewsCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($userGrowth, 'month')) !!},
                datasets: [{
                    label: '{{ __("admin.new_users") }}',
                    data: {!! json_encode(array_column($userGrowth, 'count')) !!},
                    borderColor: 'rgb(162, 1, 54)',
                    backgroundColor: 'rgba(162, 1, 54, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: isRTL }
                },
                scales: {
                    x: {
                        reverse: isRTL,
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        position: isRTL ? 'right' : 'left',
                        ticks: {
                            callback: function(value) {
                                return (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }

    // Device Breakdown Chart
    const deviceCtx = document.getElementById('deviceChart');
    if (deviceCtx) {
        new Chart(deviceCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['{{ __("admin.mobile") }}', '{{ __("admin.desktop") }}', '{{ __("admin.tablet") }}'],
                datasets: [{
                    data: [52, 35, 13],
                    backgroundColor: ['rgb(162, 1, 54)', 'rgb(16, 185, 129)', 'rgb(245, 158, 11)'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: isRTL }
                }
            }
        });
    }

    // Geographic Distribution Chart
    const geoCtx = document.getElementById('geoChart');
    if (geoCtx) {
        new Chart(geoCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['USA', 'UK', 'Canada', 'Germany', 'France', 'Spain', 'Italy', 'Australia'],
                datasets: [{
                    label: '{{ __("admin.users") }}',
                    data: [45000, 32000, 28000, 25000, 22000, 18000, 15000, 12000],
                    backgroundColor: 'rgba(162, 1, 54, 0.8)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: isRTL }
                },
                scales: {
                    x: {
                        reverse: isRTL,
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        position: isRTL ? 'right' : 'left'
                    }
                }
            }
        });
    }

    // Retention Chart
    const retentionCtx = document.getElementById('retentionChart');
    if (retentionCtx) {
        new Chart(retentionCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: '{{ __("admin.retention") }}',
                    data: [100, 85, 72, 68],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: isRTL }
                },
                scales: {
                    x: {
                        reverse: isRTL,
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        position: isRTL ? 'right' : 'left',
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // Content Distribution Chart
    const subGrowthCtx = document.getElementById('subscriptionGrowthChart');
    if (subGrowthCtx) {
        new Chart(subGrowthCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($contentDistribution, 'type')) !!},
                datasets: [{
                    label: '{{ __("admin.content_items") }}',
                    data: {!! json_encode(array_column($contentDistribution, 'count')) !!},
                    backgroundColor: 'rgba(162, 1, 54, 0.8)',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: isRTL }
                },
                scales: {
                    x: {
                        reverse: isRTL,
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        position: isRTL ? 'right' : 'left'
                    }
                }
            }
        });
    }

    // Revenue by Plan Chart
    const revenuePlanCtx = document.getElementById('revenuePlanChart');
    if (revenuePlanCtx) {
        new Chart(revenuePlanCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['{{ __("admin.premium_plan") }}', '{{ __("admin.basic_plan") }}', '{{ __("admin.enterprise_plan") }}'],
                datasets: [{
                    data: [45200, 28500, 15800],
                    backgroundColor: ['rgb(162, 1, 54)', 'rgb(16, 185, 129)', 'rgb(245, 158, 11)'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        rtl: isRTL,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': $' + context.parsed.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
}

// Period filter buttons
document.querySelectorAll('[data-period]').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active from all buttons
        document.querySelectorAll('[data-period]').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active to clicked button
        this.classList.add('active');

        const period = this.dataset.period;
        console.log('Loading analytics for period:', period);

        // In production, this would reload data via AJAX
        // For now, just show a message
        // alert('Loading ' + period + ' analytics...');
    });
});
</script>
@endsection
