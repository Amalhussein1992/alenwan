@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <h1 class="h3 mb-2" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.dashboard_overview') }}</h1>
                <p class="text-muted mb-0 d-none d-sm-block">{{ __('admin.welcome_back') }}</p>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
                    <button class="btn btn-primary-modern btn-sm btn-md-lg">
                        <i class="fas fa-download me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">{{ __('admin.export_report') }}</span>
                        <span class="d-inline d-sm-none">{{ __('admin.export') }}</span>
                    </button>
                    <button class="btn btn-success-modern btn-sm btn-md-lg">
                        <i class="fas fa-plus me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">{{ __('admin.add_content') }}</span>
                        <span class="d-inline d-sm-none">{{ __('admin.add') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in">
                <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                    <i class="fas fa-film text-white"></i>
                </div>
                <div class="stat-value">1,245</div>
                <div class="stat-label">{{ __('admin.total_movies') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>12% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="stat-value">45.2K</div>
                <div class="stat-label">{{ __('admin.active_users') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.5% {{ __('admin.from_last_week') }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-crown text-white"></i>
                </div>
                <div class="stat-value">12.8K</div>
                <div class="stat-label">{{ __('admin.premium_users') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>15% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-dollar-sign text-white"></i>
                </div>
                <div class="stat-value">$89.5K</div>
                <div class="stat-label">{{ __('admin.monthly_revenue') }}</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span>3% {{ __('admin.from_last_month') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-xl-8">
            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.revenue_analytics') }}</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary active">{{ __('admin.week') }}</button>
                        <button class="btn btn-outline-primary">{{ __('admin.month') }}</button>
                        <button class="btn btn-outline-primary">{{ __('admin.year') }}</button>
                    </div>
                </div>
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-3">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.content_distribution') }}</h5>
                <canvas id="contentChart" height="200"></canvas>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-circle text-primary me-2"></i>{{ __('admin.movies') }}</span>
                        <strong>45%</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-circle text-success me-2"></i>{{ __('admin.series') }}</span>
                        <strong>25%</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-circle text-warning me-2"></i>{{ __('admin.live_tv') }}</span>
                        <strong>20%</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-circle text-info me-2"></i>{{ __('admin.others') }}</span>
                        <strong>10%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content & Activities -->
    <div class="row">
        <div class="col-12 col-xl-8 mb-3">
            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.recent_content') }}</h5>
                    <a href="/admin/movies" class="text-primary text-decoration-none">
                        {{ __('admin.view_all') }} <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>{{ __('admin.content') }}</th>
                                <th>{{ __('admin.type') }}</th>
                                <th>{{ __('admin.views') }}</th>
                                <th>{{ __('admin.rating') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40x60" alt="Poster" class="me-3" style="border-radius: 8px;">
                                        <div>
                                            <strong>The Matrix Resurrections</strong>
                                            <br><small class="text-muted">2021</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">{{ __('admin.movie') }}</span></td>
                                <td>45.2K</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span>4.8</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">{{ __('admin.published') }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40x60" alt="Poster" class="me-3" style="border-radius: 8px;">
                                        <div>
                                            <strong>Stranger Things</strong>
                                            <br><small class="text-muted">Season 4</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">{{ __('admin.tv_series') }}</span></td>
                                <td>89.1K</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span>4.9</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">{{ __('admin.published') }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40x60" alt="Poster" class="me-3" style="border-radius: 8px;">
                                        <div>
                                            <strong>Planet Earth III</strong>
                                            <br><small class="text-muted">Documentary</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">{{ __('admin.documentary') }}</span></td>
                                <td>23.5K</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span>4.7</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning">{{ __('admin.draft') }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40x60" alt="Poster" class="me-3" style="border-radius: 8px;">
                                        <div>
                                            <strong>UEFA Champions League</strong>
                                            <br><small class="text-muted">Live Stream</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-danger">{{ __('admin.live') }}</span></td>
                                <td>156K</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span>5.0</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-danger">{{ __('admin.live') }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-3">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.recent_activities') }}</h5>
                <div class="activity-timeline">
                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1"><strong>{{ __('admin.new_user_registered') }}</strong></p>
                            <small class="text-muted">John Doe joined as premium member</small>
                            <br><small class="text-muted">2 {{ __('admin.minutes_ago') }}</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="fas fa-film"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1"><strong>{{ __('admin.new_movie_added') }}</strong></p>
                            <small class="text-muted">Spider-Man: No Way Home</small>
                            <br><small class="text-muted">15 {{ __('admin.minutes_ago') }}</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1"><strong>{{ __('admin.subscription_upgraded') }}</strong></p>
                            <small class="text-muted">Sarah upgraded to Premium Plus</small>
                            <br><small class="text-muted">1 {{ __('admin.hour_ago') }}</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="fas fa-tv"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1"><strong>{{ __('admin.new_episode_released') }}</strong></p>
                            <small class="text-muted">Breaking Bad S5E10</small>
                            <br><small class="text-muted">2 {{ __('admin.hours_ago') }}</small>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <div class="activity-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1"><strong>{{ __('admin.live_stream_started') }}</strong></p>
                            <small class="text-muted">NBA Finals Game 7</small>
                            <br><small class="text-muted">3 {{ __('admin.hours_ago') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.quick_actions') }}</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="/admin/movies/create" class="text-decoration-none">
                            <div class="p-3 border rounded-3 text-center hover-shadow" style="transition: all 0.3s;">
                                <i class="fas fa-plus-circle text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6 class="mb-0">{{ __('admin.add_movie') }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/admin/series/create" class="text-decoration-none">
                            <div class="p-3 border rounded-3 text-center hover-shadow" style="transition: all 0.3s;">
                                <i class="fas fa-tv text-success mb-2" style="font-size: 2rem;"></i>
                                <h6 class="mb-0">{{ __('admin.add_series') }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/admin/users" class="text-decoration-none">
                            <div class="p-3 border rounded-3 text-center hover-shadow" style="transition: all 0.3s;">
                                <i class="fas fa-users text-info mb-2" style="font-size: 2rem;"></i>
                                <h6 class="mb-0">{{ __('admin.manage_users') }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/admin/settings" class="text-decoration-none">
                            <div class="p-3 border rounded-3 text-center hover-shadow" style="transition: all 0.3s;">
                                <i class="fas fa-cog text-warning mb-2" style="font-size: 2rem;"></i>
                                <h6 class="mb-0">{{ __('admin.settings') }}</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
</style>
@endsection

@section('scripts')
<script>
    // Check if Chart.js is loaded
    if (typeof Chart !== 'undefined') {
        // Set default font for RTL languages
        const isRTL = document.documentElement.dir === 'rtl';
        if (isRTL) {
            Chart.defaults.font.family = 'Cairo, sans-serif';
        }

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['{{ __("admin.monday") }}', '{{ __("admin.tuesday") }}', '{{ __("admin.wednesday") }}', '{{ __("admin.thursday") }}', '{{ __("admin.friday") }}', '{{ __("admin.saturday") }}', '{{ __("admin.sunday") }}'],
                    datasets: [{
                        label: '{{ __("admin.revenue") }}',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: 'rgb(162, 1, 54)',
                        backgroundColor: 'rgba(162, 1, 54, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }, {
                        label: '{{ __("admin.subscriptions") }}',
                        data: [8000, 12000, 10000, 18000, 15000, 22000, 20000],
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: isRTL,
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            rtl: isRTL,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += '$' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            reverse: isRTL,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            position: isRTL ? 'right' : 'left',
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Content Distribution Chart
        const contentCtx = document.getElementById('contentChart');
        if (contentCtx) {
            new Chart(contentCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("admin.movies") }}', '{{ __("admin.series") }}', '{{ __("admin.live_tv") }}', '{{ __("admin.others") }}'],
                    datasets: [{
                        data: [45, 25, 20, 10],
                        backgroundColor: [
                            'rgb(162, 1, 54)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)',
                            'rgb(59, 130, 246)'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            rtl: isRTL,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    } else {
        console.error('Chart.js is not loaded');
    }
</script>
@endsection