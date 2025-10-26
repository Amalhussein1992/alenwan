@extends('admin.layouts.app')

@section('title', 'Subscriptions Management')

@section('content')
<div class="subscriptions-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-credit-card"></i> {{ __('admin.subscriptions') }}</h2>
                <p class="text-muted">Manage subscription plans and user subscriptions</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="createPlan()">
                    <i class="fas fa-plus"></i> Create Plan
                </button>
                <button class="btn btn-success" onclick="exportSubscriptions()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Revenue Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stats-content">
                    <h3>$156,780</h3>
                    <p>Monthly Revenue</p>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i> +12.5%
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>12,340</h3>
                    <p>Active Subscribers</p>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i> +8.3%
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-content">
                    <h3>340</h3>
                    <p>Expiring Soon</p>
                </div>
                <div class="stats-trend neutral">
                    <i class="fas fa-clock"></i> 7 days
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-content">
                    <h3>89.5%</h3>
                    <p>Retention Rate</p>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i> +2.1%
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-section">
        <ul class="nav nav-pills mb-4" id="subscriptionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="plans-tab" data-bs-toggle="pill" data-bs-target="#plans" type="button" role="tab">
                    <i class="fas fa-list"></i> Subscription Plans
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="subscribers-tab" data-bs-toggle="pill" data-bs-target="#subscribers" type="button" role="tab">
                    <i class="fas fa-users"></i> Subscribers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="analytics-tab" data-bs-toggle="pill" data-bs-target="#analytics" type="button" role="tab">
                    <i class="fas fa-chart-bar"></i> Analytics
                </button>
            </li>
        </ul>

        <div class="tab-content" id="subscriptionTabContent">
            <!-- Plans Tab -->
            <div class="tab-pane fade show active" id="plans" role="tabpanel">
                <div class="plans-grid">
                    <!-- Basic Plan -->
                    <div class="plan-card basic">
                        <div class="plan-header">
                            <div class="plan-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <h4>Basic</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>
                                <span class="amount">9.99</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <div class="feature">
                                <i class="fas fa-check"></i> HD Streaming
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> 1 Device
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> Basic Library
                            </div>
                            <div class="feature">
                                <i class="fas fa-times"></i> Offline Downloads
                            </div>
                        </div>
                        <div class="plan-stats">
                            <div class="stat">
                                <strong>2,456</strong>
                                <span>Subscribers</span>
                            </div>
                            <div class="stat">
                                <strong>$24,472</strong>
                                <span>Monthly Revenue</span>
                            </div>
                        </div>
                        <div class="plan-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editPlan('basic')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="viewPlanAnalytics('basic')">
                                <i class="fas fa-chart-line"></i> Analytics
                            </button>
                        </div>
                    </div>

                    <!-- Standard Plan -->
                    <div class="plan-card standard popular">
                        <div class="popular-badge">Most Popular</div>
                        <div class="plan-header">
                            <div class="plan-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>Standard</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>
                                <span class="amount">15.99</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <div class="feature">
                                <i class="fas fa-check"></i> Full HD Streaming
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> 3 Devices
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> Complete Library
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> Offline Downloads
                            </div>
                        </div>
                        <div class="plan-stats">
                            <div class="stat">
                                <strong>7,892</strong>
                                <span>Subscribers</span>
                            </div>
                            <div class="stat">
                                <strong>$126,235</strong>
                                <span>Monthly Revenue</span>
                            </div>
                        </div>
                        <div class="plan-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editPlan('standard')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="viewPlanAnalytics('standard')">
                                <i class="fas fa-chart-line"></i> Analytics
                            </button>
                        </div>
                    </div>

                    <!-- Premium Plan -->
                    <div class="plan-card premium">
                        <div class="plan-header">
                            <div class="plan-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h4>Premium</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>
                                <span class="amount">24.99</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <div class="feature">
                                <i class="fas fa-check"></i> 4K Ultra HD
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> 6 Devices
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> Exclusive Content
                            </div>
                            <div class="feature">
                                <i class="fas fa-check"></i> Priority Support
                            </div>
                        </div>
                        <div class="plan-stats">
                            <div class="stat">
                                <strong>1,992</strong>
                                <span>Subscribers</span>
                            </div>
                            <div class="stat">
                                <strong>$49,775</strong>
                                <span>Monthly Revenue</span>
                            </div>
                        </div>
                        <div class="plan-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editPlan('premium')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="viewPlanAnalytics('premium')">
                                <i class="fas fa-chart-line"></i> Analytics
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscribers Tab -->
            <div class="tab-pane fade" id="subscribers" role="tabpanel">
                <div class="filters-section mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="subscriberSearch" placeholder="Search subscribers..." class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="planFilter">
                                <option value="">All Plans</option>
                                <option value="basic">Basic</option>
                                <option value="standard">Standard</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="sortBy">
                                <option value="recent">Most Recent</option>
                                <option value="expiring">Expiring Soon</option>
                                <option value="revenue">Highest Value</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        </div>
                    </div>
                </div>

                <div class="subscribers-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Subscriber</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Started</th>
                                    <th>Expires</th>
                                    <th>Revenue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="subscriber-info">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe&size=40" class="subscriber-avatar" alt="User">
                                            <div>
                                                <strong>John Doe</strong>
                                                <br><small>john.doe@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">Standard</span></td>
                                    <td><span class="status-badge active">Active</span></td>
                                    <td>Jan 15, 2024</td>
                                    <td>Dec 15, 2024</td>
                                    <td><strong>$175.89</strong></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewSubscriber(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="renewSubscription(1)">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="cancelSubscription(1)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="subscriber-info">
                                            <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&size=40" class="subscriber-avatar" alt="User">
                                            <div>
                                                <strong>Sarah Wilson</strong>
                                                <br><small>sarah.wilson@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Premium</span></td>
                                    <td><span class="status-badge active">Active</span></td>
                                    <td>Feb 20, 2024</td>
                                    <td>Jan 20, 2025</td>
                                    <td><strong>$249.88</strong></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewSubscriber(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="renewSubscription(2)">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="cancelSubscription(2)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="subscriber-info">
                                            <img src="https://ui-avatars.com/api/?name=Mike+Johnson&size=40" class="subscriber-avatar" alt="User">
                                            <div>
                                                <strong>Mike Johnson</strong>
                                                <br><small>mike.johnson@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">Basic</span></td>
                                    <td><span class="status-badge expired">Expired</span></td>
                                    <td>Mar 10, 2024</td>
                                    <td>May 10, 2024</td>
                                    <td><strong>$19.98</strong></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewSubscriber(3)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="renewSubscription(3)">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="sendReminderEmail(3)">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div class="tab-pane fade" id="analytics" role="tabpanel">
                <div class="analytics-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h5><i class="fas fa-chart-line"></i> Revenue Trend</h5>
                                <div class="chart-placeholder">
                                    <canvas id="revenueChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h5><i class="fas fa-chart-pie"></i> Plan Distribution</h5>
                                <div class="chart-placeholder">
                                    <canvas id="planChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="chart-card">
                                <h5><i class="fas fa-users"></i> Subscriber Growth</h5>
                                <div class="chart-placeholder">
                                    <canvas id="growthChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.subscriptions-management {
    padding: 2rem;
}

.page-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

.page-header h2 {
    color: #333;
    margin-bottom: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.stats-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
    position: relative;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.5rem;
}

.stats-content {
    flex: 1;
}

.stats-content h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
}

.stats-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.stats-trend {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 0.8rem;
    font-weight: bold;
}

.stats-trend.positive {
    color: #10b981;
}

.stats-trend.neutral {
    color: #f59e0b;
}

.tabs-section .nav-pills .nav-link {
    border-radius: 10px;
    margin-right: 0.5rem;
    color: #666;
    background: #f8f9fa;
    border: none;
    padding: 0.75rem 1.5rem;
}

.tabs-section .nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.plan-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.plan-card.popular {
    border: 2px solid #667eea;
}

.popular-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    font-weight: bold;
    border-bottom-left-radius: 15px;
}

.plan-header {
    text-align: center;
    margin-bottom: 2rem;
}

.plan-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
}

.plan-card.basic .plan-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.plan-card.standard .plan-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.plan-card.premium .plan-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.plan-header h4 {
    margin: 0 0 1rem 0;
    color: #333;
    font-weight: bold;
}

.plan-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.25rem;
}

.plan-price .currency {
    font-size: 1.2rem;
    color: #666;
}

.plan-price .amount {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
}

.plan-price .period {
    font-size: 1rem;
    color: #666;
}

.plan-features {
    margin-bottom: 2rem;
}

.plan-features .feature {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    color: #333;
}

.plan-features .feature i {
    margin-right: 0.75rem;
    width: 16px;
}

.plan-features .feature i.fa-check {
    color: #10b981;
}

.plan-features .feature i.fa-times {
    color: #ef4444;
}

.plan-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.plan-stats .stat {
    text-align: center;
}

.plan-stats .stat strong {
    display: block;
    font-size: 1.2rem;
    color: #333;
}

.plan-stats .stat span {
    font-size: 0.8rem;
    color: #666;
}

.plan-actions {
    display: flex;
    gap: 0.5rem;
}

.plan-actions .btn {
    flex: 1;
    border-radius: 10px;
}

.filters-section {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    z-index: 2;
}

.search-box input {
    padding-left: 40px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.subscribers-table {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.subscribers-table .table {
    margin: 0;
}

.subscribers-table .table th {
    border-top: none;
    font-weight: 600;
    color: #333;
    padding: 1rem 0.75rem;
}

.subscribers-table .table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.subscriber-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.subscriber-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.expired {
    background: #fecaca;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
}

.chart-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.chart-card h5 {
    margin-bottom: 1rem;
    color: #333;
}

.chart-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
    background: #f8f9fa;
    border-radius: 10px;
    color: #666;
    font-style: italic;
}

@media (max-width: 768px) {
    .plans-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .filters-section .row > div {
        margin-bottom: 1rem;
    }
}
</style>

<script>
// Tab switching
document.querySelectorAll('#subscriptionTabs button').forEach(tab => {
    tab.addEventListener('click', function() {
        const targetId = this.getAttribute('data-bs-target');
        if (targetId === '#analytics') {
            // Initialize charts when analytics tab is shown
            initializeCharts();
        }
    });
});

// Plan management functions
function createPlan() {
    alert('Opening create plan form...');
}

function editPlan(planType) {
    alert(`Editing ${planType} plan...`);
}

function viewPlanAnalytics(planType) {
    alert(`Viewing analytics for ${planType} plan...`);
}

// Subscriber management functions
function viewSubscriber(id) {
    alert(`Viewing subscriber details for ID: ${id}`);
}

function renewSubscription(id) {
    if (confirm('Renew this subscription?')) {
        alert(`Subscription renewed for user ID: ${id}`);
    }
}

function cancelSubscription(id) {
    if (confirm('Are you sure you want to cancel this subscription?')) {
        alert(`Subscription cancelled for user ID: ${id}`);
    }
}

function sendReminderEmail(id) {
    alert(`Sending renewal reminder to user ID: ${id}`);
}

// Filter functions
function clearFilters() {
    document.getElementById('subscriberSearch').value = '';
    document.getElementById('planFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('sortBy').value = 'recent';
}

// Export function
function exportSubscriptions() {
    alert('Exporting subscription data...');
}

// Initialize charts (placeholder)
function initializeCharts() {
    // Placeholder for chart initialization
    document.querySelectorAll('.chart-placeholder').forEach(placeholder => {
        if (!placeholder.querySelector('canvas')) return;
        placeholder.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 200px; color: #666; font-style: italic;">Chart visualization would appear here</div>';
    });
}
</script>
@endsection