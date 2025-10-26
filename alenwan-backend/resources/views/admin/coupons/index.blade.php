@extends('admin.layouts.app')

@section('title', __('admin.coupons_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.coupons_promotions') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.coupons') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-info-modern me-2" onclick="generateBulkCoupons()">
                    <i class="fas fa-magic me-2"></i>{{ __('admin.generate_bulk') }}
                </button>
                <button class="btn-modern btn-success-modern" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.create_coupon') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">156</div>
                        <div class="stat-label">{{ __('admin.active_coupons') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-ticket-alt text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">$12,456</div>
                        <div class="stat-label">{{ __('admin.total_discounts_given') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">3,842</div>
                        <div class="stat-label">{{ __('admin.times_used') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">24.6%</div>
                        <div class="stat-label">{{ __('admin.conversion_rate') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-percentage text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="card-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2 align-items-center">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                    <input type="text" class="form-control ps-5" placeholder="{{ __('admin.search_coupons') }}" style="width: 300px; border-radius: 10px;">
                </div>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>{{ __('admin.all_status') }}</option>
                    <option>{{ __('admin.active') }}</option>
                    <option>{{ __('admin.expired') }}</option>
                    <option>{{ __('admin.scheduled') }}</option>
                </select>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>{{ __('admin.all_types') }}</option>
                    <option>{{ __('admin.percentage') }}</option>
                    <option>{{ __('admin.fixed_amount') }}</option>
                    <option>{{ __('admin.free_trial') }}</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>{{ __('admin.code') }}</th>
                        <th>{{ __('admin.description') }}</th>
                        <th>{{ __('admin.type') }}</th>
                        <th>{{ __('admin.value') }}</th>
                        <th>{{ __('admin.usage') }}</th>
                        <th>{{ __('admin.valid_period') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th class="text-center">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $coupons = [
                            ['code' => 'WELCOME50', 'desc' => 'New user discount', 'type' => 'Percentage', 'value' => '50%', 'used' => 234, 'limit' => 500, 'start' => '2024-01-01', 'end' => '2024-12-31', 'status' => 'active'],
                            ['code' => 'SUMMER2024', 'desc' => 'Summer promotion', 'type' => 'Fixed', 'value' => '$10', 'used' => 156, 'limit' => 200, 'start' => '2024-06-01', 'end' => '2024-08-31', 'status' => 'active'],
                            ['code' => 'PREMIUM30', 'desc' => 'Premium plan discount', 'type' => 'Percentage', 'value' => '30%', 'used' => 89, 'limit' => 100, 'start' => '2024-03-01', 'end' => '2024-03-31', 'status' => 'expired'],
                            ['code' => 'FREETRIAL7', 'desc' => '7 days free trial', 'type' => 'Free Trial', 'value' => '7 days', 'used' => 445, 'limit' => 1000, 'start' => '2024-01-01', 'end' => '2024-12-31', 'status' => 'active'],
                            ['code' => 'VIP2024', 'desc' => 'VIP member exclusive', 'type' => 'Percentage', 'value' => '75%', 'used' => 12, 'limit' => 50, 'start' => '2024-04-01', 'end' => '2024-04-30', 'status' => 'scheduled'],
                            ['code' => 'BLACKFRIDAY', 'desc' => 'Black Friday deal', 'type' => 'Percentage', 'value' => '80%', 'used' => 0, 'limit' => 5000, 'start' => '2024-11-29', 'end' => '2024-11-29', 'status' => 'scheduled'],
                        ];
                    @endphp

                    @foreach($coupons as $coupon)
                    <tr class="align-middle">
                        <td>
                            <input type="checkbox" class="form-check-input coupon-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="coupon-code-badge me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                    {{ $coupon['code'] }}
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyCoupon('{{ $coupon['code'] }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span style="color: var(--text-primary);">{{ $coupon['desc'] }}</span>
                        </td>
                        <td>
                            @if($coupon['type'] == 'Percentage')
                                <span class="badge bg-primary">{{ $coupon['type'] }}</span>
                            @elseif($coupon['type'] == 'Fixed')
                                <span class="badge bg-success">{{ $coupon['type'] }}</span>
                            @else
                                <span class="badge bg-info">{{ $coupon['type'] }}</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">{{ $coupon['value'] }}</strong>
                        </td>
                        <td>
                            <div>
                                <span class="fw-semibold">{{ $coupon['used'] }}/{{ $coupon['limit'] }}</span>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-primary" style="width: {{ ($coupon['used']/$coupon['limit']) * 100 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ date('M d, Y', strtotime($coupon['start'])) }} -
                                {{ date('M d, Y', strtotime($coupon['end'])) }}
                            </small>
                        </td>
                        <td>
                            @if($coupon['status'] == 'active')
                                <span class="badge bg-success">{{ __('admin.active') }}</span>
                            @elseif($coupon['status'] == 'expired')
                                <span class="badge bg-secondary">{{ __('admin.expired') }}</span>
                            @else
                                <span class="badge bg-warning">{{ __('admin.scheduled') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>{{ __('admin.analytics') }}</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>{{ __('admin.edit') }}</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>{{ __('admin.duplicate') }}</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>{{ __('admin.delete') }}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('admin.create_new_coupon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Code *</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase" placeholder="SUMMER2024" style="border-radius: 10px 0 0 10px;" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="generateCode()" style="border-radius: 0 10px 10px 0;">
                                    <i class="fas fa-random"></i> Generate
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type *</label>
                            <select class="form-select" style="border-radius: 10px;" required>
                                <option>Percentage Discount</option>
                                <option>Fixed Amount</option>
                                <option>Free Trial Days</option>
                                <option>Buy X Get Y</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Value *</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="50" style="border-radius: 10px 0 0 10px;" required>
                                <span class="input-group-text" style="border-radius: 0 10px 10px 0;">%</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" placeholder="100" style="border-radius: 10px;">
                            <small class="text-muted">Leave empty for unlimited</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date *</label>
                            <input type="datetime-local" class="form-control" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date *</label>
                            <input type="datetime-local" class="form-control" style="border-radius: 10px;" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="2" placeholder="Describe this coupon..." style="border-radius: 10px;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Applicable Plans</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="planFree">
                                    <label class="form-check-label" for="planFree">Free</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="planBasic" checked>
                                    <label class="form-check-label" for="planBasic">Basic</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="planPremium" checked>
                                    <label class="form-check-label" for="planPremium">Premium</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="planPlus" checked>
                                    <label class="form-check-label" for="planPlus">Premium Plus</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="newUsersOnly">
                                <label class="form-check-label" for="newUsersOnly">
                                    New users only
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="singleUse">
                                <label class="form-check-label" for="singleUse">
                                    Single use per user
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('admin.create_coupon') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function copyCoupon(code) {
        navigator.clipboard.writeText(code);
        alert('Coupon code copied: ' + code);
    }

    function generateCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for(let i = 0; i < 10; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.querySelector('input[placeholder="SUMMER2024"]').value = code;
    }

    function generateBulkCoupons() {
        alert('Bulk generation feature coming soon!');
    }
</script>
@endsection