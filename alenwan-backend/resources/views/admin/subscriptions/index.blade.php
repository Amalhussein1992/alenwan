@extends('admin.layouts.app')

@section('title', __('admin.subscription_plans_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.subscription_plans') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.subscription_plans') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-secondary-modern me-2" onclick="viewAnalytics()">
                    <i class="fas fa-chart-line me-2"></i>{{ __('admin.analytics') }}
                </button>
                <button class="btn-modern btn-success-modern" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_plan') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Revenue Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">$89,456</div>
                        <div class="stat-label">{{ __('admin.monthly_revenue') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive mt-2">
                    <i class="fas fa-arrow-up"></i>
                    <span>12.5% from last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">12,845</div>
                        <div class="stat-label">{{ __('admin.active_subscribers') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive mt-2">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.2% growth</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">$6.95</div>
                        <div class="stat-label">{{ __('admin.average_revenue_user') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
                <div class="stat-change positive mt-2">
                    <i class="fas fa-arrow-up"></i>
                    <span>3.8% increase</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">89.2%</div>
                        <div class="stat-label">{{ __('admin.retention_rate') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-user-check text-white"></i>
                    </div>
                </div>
                <div class="stat-change negative mt-2">
                    <i class="fas fa-arrow-down"></i>
                    <span>1.2% from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Plans Cards -->
    <div class="row mb-4">
        @php
            $plans = [
                [
                    'name' => 'Free',
                    'price' => 0,
                    'period' => 'Forever',
                    'color' => 'linear-gradient(135deg, #6b7280 0%, #4b5563 100%)',
                    'subscribers' => 32456,
                    'features' => [
                        'Limited content access',
                        'SD quality streaming',
                        'Ads supported',
                        '1 device at a time',
                        'No downloads'
                    ],
                    'popular' => false
                ],
                [
                    'name' => 'Basic',
                    'price' => 4.99,
                    'period' => 'month',
                    'color' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
                    'subscribers' => 5678,
                    'features' => [
                        'Full content library',
                        'HD quality streaming',
                        'No ads',
                        '2 devices simultaneously',
                        '10 downloads/month',
                        'Basic support'
                    ],
                    'popular' => false
                ],
                [
                    'name' => 'Premium',
                    'price' => 9.99,
                    'period' => 'month',
                    'color' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)',
                    'subscribers' => 4567,
                    'features' => [
                        'Everything in Basic',
                        'Full HD + 4K streaming',
                        '4 devices simultaneously',
                        'Unlimited downloads',
                        'Priority support',
                        'Early access to new content'
                    ],
                    'popular' => true
                ],
                [
                    'name' => 'Premium Plus',
                    'price' => 14.99,
                    'period' => 'month',
                    'color' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                    'subscribers' => 2600,
                    'features' => [
                        'Everything in Premium',
                        'Ultra HD + HDR streaming',
                        '6 devices simultaneously',
                        'Family sharing (5 profiles)',
                        'Exclusive content',
                        'VIP support 24/7',
                        'Live TV channels'
                    ],
                    'popular' => false
                ]
            ];
        @endphp

        @foreach($plans as $plan)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 {{ $plan['popular'] ? 'border-primary border-2' : '' }}" style="border-radius: 16px; position: relative; overflow: visible;">
                @if($plan['popular'])
                <div class="position-absolute" style="top: -15px; right: 20px; z-index: 10;">
                    <span class="badge bg-primary px-3 py-2">
                        <i class="fas fa-star me-1"></i>MOST POPULAR
                    </span>
                </div>
                @endif

                <div class="card-header text-white text-center py-4" style="background: {{ $plan['color'] }}; border-radius: 16px 16px 0 0;">
                    <h4 class="mb-0">{{ $plan['name'] }}</h4>
                    <div class="mt-3">
                        <span class="display-4 fw-bold">${{ $plan['price'] }}</span>
                        @if($plan['price'] > 0)
                            <span class="fs-6">/ {{ $plan['period'] }}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-white text-dark">{{ number_format($plan['subscribers']) }} subscribers</span>
                    </div>
                </div>

                <div class="card-body">
                    <h6 class="mb-3">{{ __('admin.features') }}:</h6>
                    <ul class="list-unstyled">
                        @foreach($plan['features'] as $feature)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span style="color: var(--text-primary);">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer bg-transparent border-0 pb-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="editPlan('{{ $plan['name'] }}')">
                            <i class="fas fa-edit me-1"></i>{{ __('admin.edit_plan') }}
                        </button>
                        <button class="btn btn-outline-secondary" onclick="viewSubscribers('{{ $plan['name'] }}')">
                            <i class="fas fa-users me-1"></i>{{ __('admin.view_subscribers') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Subscriptions -->
    <div class="card-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                <i class="fas fa-history text-primary me-2"></i>{{ __('admin.recent_subscriptions') }}
            </h5>
            <button class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download me-1"></i>{{ __('admin.export') }}
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>{{ __('admin.user') }}</th>
                        <th>{{ __('admin.plan') }}</th>
                        <th>{{ __('admin.start_date') }}</th>
                        <th>{{ __('admin.end_date') }}</th>
                        <th>{{ __('admin.amount') }}</th>
                        <th>{{ __('admin.payment_method') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th class="text-center">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 8; $i++)
                    <tr class="align-middle">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=random"
                                     alt="User" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                <div>
                                    <strong style="color: var(--text-primary);">User Name {{ $i }}</strong>
                                    <br><small style="color: var(--text-secondary);">user{{ $i }}@example.com</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $planTypes = ['Basic', 'Premium', 'Premium Plus'];
                                $planType = $planTypes[($i - 1) % 3];
                            @endphp
                            <span class="badge bg-primary">{{ $planType }}</span>
                        </td>
                        <td>{{ date('M d, Y', strtotime('-' . (30 - $i) . ' days')) }}</td>
                        <td>{{ date('M d, Y', strtotime('+' . $i . ' days')) }}</td>
                        <td class="fw-bold text-success">${{ [4.99, 9.99, 14.99][($i - 1) % 3] }}</td>
                        <td>
                            <i class="fab fa-cc-{{ ['visa', 'mastercard', 'paypal'][($i - 1) % 3] }} me-1"></i>
                            •••• {{ 1000 + $i }}
                        </td>
                        <td>
                            @if($i <= 6)
                                <span class="badge bg-success">{{ __('admin.active') }}</span>
                            @elseif($i == 7)
                                <span class="badge bg-warning">{{ __('admin.expiring_soon') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('admin.expired') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>{{ __('admin.view_details') }}</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-receipt me-2"></i>{{ __('admin.invoice') }}</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-redo me-2"></i>{{ __('admin.renew') }}</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('admin.create_new_subscription_plan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.plan_name') }} *</label>
                            <input type="text" class="form-control" placeholder="e.g., Premium" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.price') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 10px 0 0 10px;">$</span>
                                <input type="number" class="form-control" placeholder="9.99" step="0.01" style="border-radius: 0 10px 10px 0;" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.billing_period') }} *</label>
                            <select class="form-select" style="border-radius: 10px;" required>
                                <option>{{ __('admin.monthly') }}</option>
                                <option>{{ __('admin.quarterly') }}</option>
                                <option>{{ __('admin.yearly') }}</option>
                                <option>{{ __('admin.lifetime') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.trial_days') }}</label>
                            <input type="number" class="form-control" placeholder="7" value="0" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.features') }}</label>
                        <div id="featuresContainer">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Enter feature" style="border-radius: 10px 0 0 10px;">
                                <button class="btn btn-outline-danger" type="button" style="border-radius: 0 10px 10px 0;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFeature()">
                            <i class="fas fa-plus me-1"></i>{{ __('admin.add_feature') }}
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Max Devices</label>
                            <input type="number" class="form-control" value="1" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Download Limit</label>
                            <input type="number" class="form-control" placeholder="Unlimited = 0" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Video Quality</label>
                            <select class="form-select" style="border-radius: 10px;">
                                <option>SD</option>
                                <option>HD</option>
                                <option>Full HD</option>
                                <option>4K</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="isPopular">
                        <label class="form-check-label" for="isPopular">
                            {{ __('admin.mark_as_popular') }}
                        </label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="isActive" checked>
                        <label class="form-check-label" for="isActive">
                            {{ __('admin.active') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('admin.create_plan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editPlan(planName) {
        alert('Edit plan: ' + planName);
    }

    function viewSubscribers(planName) {
        alert('View subscribers for: ' + planName);
    }

    function viewAnalytics() {
        window.location.href = '/admin/subscriptions/analytics';
    }

    function addFeature() {
        const container = document.getElementById('featuresContainer');
        const featureInput = document.createElement('div');
        featureInput.className = 'input-group mb-2';
        featureInput.innerHTML = `
            <input type="text" class="form-control" placeholder="Enter feature" style="border-radius: 10px 0 0 10px;">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()" style="border-radius: 0 10px 10px 0;">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(featureInput);
    }
</script>
@endsection