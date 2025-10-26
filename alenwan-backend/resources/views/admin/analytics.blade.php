@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')
@section('page-title', 'Analytics Dashboard')

@section('content')
<div class="analytics-dashboard">
    <!-- Top Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card gradient-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="counter" data-target="125463">0</h3>
                    <p>Total Users</p>
                    <span class="badge badge-light">+12.5% <i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="stat-chart">
                    <canvas id="usersSparkline"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card gradient-success">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <h3>$<span class="counter" data-target="458960">0</span></h3>
                    <p>Monthly Revenue</p>
                    <span class="badge badge-light">+8.3% <i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="stat-chart">
                    <canvas id="revenueSparkline"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card gradient-warning">
                <div class="stat-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="counter" data-target="892450">0</h3>
                    <p>Total Views</p>
                    <span class="badge badge-light">+23.1% <i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="stat-chart">
                    <canvas id="viewsSparkline"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card gradient-info">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3><span class="counter" data-target="4256">0</span>h</h3>
                    <p>Watch Time</p>
                    <span class="badge badge-light">+5.7% <i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="stat-chart">
                    <canvas id="watchTimeSparkline"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Revenue Overview</h5>
                    <div class="chart-controls">
                        <button class="btn btn-sm btn-outline-secondary active" data-range="7d">7 Days</button>
                        <button class="btn btn-sm btn-outline-secondary" data-range="30d">30 Days</button>
                        <button class="btn btn-sm btn-outline-secondary" data-range="90d">90 Days</button>
                        <button class="btn btn-sm btn-outline-secondary" data-range="1y">1 Year</button>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Content Distribution</h5>
                    <button class="btn btn-sm btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                </div>
                <div class="chart-body">
                    <canvas id="contentPieChart" height="200"></canvas>
                    <div class="chart-legend mt-3">
                        <div class="legend-item">
                            <span class="legend-color" style="background: #A20136;"></span>
                            <span>Movies (42%)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #8b0000;"></span>
                            <span>Series (28%)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #dc143c;"></span>
                            <span>Live TV (20%)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background: #ff69b4;"></span>
                            <span>Sports (10%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Engagement & Geographic Distribution -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>User Engagement</h5>
                    <select class="form-select form-select-sm">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                    </select>
                </div>
                <div class="chart-body">
                    <canvas id="engagementChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Geographic Distribution</h5>
                    <button class="btn btn-sm btn-primary">View Details</button>
                </div>
                <div class="chart-body">
                    <div id="worldMap" style="height: 300px;"></div>
                    <div class="country-stats mt-3">
                        <div class="country-item">
                            <img src="https://flagcdn.com/w40/us.png" alt="US">
                            <span>United States</span>
                            <strong>32.5%</strong>
                        </div>
                        <div class="country-item">
                            <img src="https://flagcdn.com/w40/gb.png" alt="UK">
                            <span>United Kingdom</span>
                            <strong>18.2%</strong>
                        </div>
                        <div class="country-item">
                            <img src="https://flagcdn.com/w40/ca.png" alt="CA">
                            <span>Canada</span>
                            <strong>12.7%</strong>
                        </div>
                        <div class="country-item">
                            <img src="https://flagcdn.com/w40/au.png" alt="AU">
                            <span>Australia</span>
                            <strong>9.3%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Activity & Top Content -->
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="activity-card">
                <div class="card-header">
                    <h5>Real-time Activity</h5>
                    <span class="live-indicator">
                        <span class="pulse"></span> Live
                    </span>
                </div>
                <div class="activity-feed">
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=A20136&color=fff" alt="">
                        </div>
                        <div class="activity-content">
                            <p><strong>John Doe</strong> started watching <em>The Matrix</em></p>
                            <span class="time">Just now</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=A20136&color=fff" alt="">
                        </div>
                        <div class="activity-content">
                            <p><strong>Jane Smith</strong> subscribed to Premium Plan</p>
                            <span class="time">2 min ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=A20136&color=fff" alt="">
                        </div>
                        <div class="activity-content">
                            <p><strong>Mike Johnson</strong> rated <em>Breaking Bad</em> ⭐⭐⭐⭐⭐</p>
                            <span class="time">5 min ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&background=A20136&color=fff" alt="">
                        </div>
                        <div class="activity-content">
                            <p><strong>Sarah Wilson</strong> downloaded <em>Inception</em></p>
                            <span class="time">8 min ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="content-table-card">
                <div class="card-header">
                    <h5>Top Performing Content</h5>
                    <div class="filter-tabs">
                        <button class="tab-btn active">Movies</button>
                        <button class="tab-btn">Series</button>
                        <button class="tab-btn">Live TV</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Content</th>
                                <th>Views</th>
                                <th>Rating</th>
                                <th>Revenue</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="content-info">
                                        <img src="https://via.placeholder.com/50x75" alt="" class="content-thumb">
                                        <div>
                                            <strong>The Dark Knight</strong>
                                            <span class="text-muted">Action, Drama</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>245.8K</strong>
                                    <span class="change positive">+12.5%</span>
                                </td>
                                <td>
                                    <div class="rating">
                                        <span class="stars">⭐ 4.8</span>
                                        <span class="count">(18.2K)</span>
                                    </div>
                                </td>
                                <td>
                                    <strong>$45,890</strong>
                                </td>
                                <td>
                                    <div class="mini-chart">
                                        <canvas class="trend-chart" data-values="[10,15,12,18,22,28,35]"></canvas>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="content-info">
                                        <img src="https://via.placeholder.com/50x75" alt="" class="content-thumb">
                                        <div>
                                            <strong>Inception</strong>
                                            <span class="text-muted">Sci-Fi, Thriller</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>198.3K</strong>
                                    <span class="change positive">+8.3%</span>
                                </td>
                                <td>
                                    <div class="rating">
                                        <span class="stars">⭐ 4.7</span>
                                        <span class="count">(15.7K)</span>
                                    </div>
                                </td>
                                <td>
                                    <strong>$38,450</strong>
                                </td>
                                <td>
                                    <div class="mini-chart">
                                        <canvas class="trend-chart" data-values="[15,18,16,20,22,25,30]"></canvas>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="content-info">
                                        <img src="https://via.placeholder.com/50x75" alt="" class="content-thumb">
                                        <div>
                                            <strong>Interstellar</strong>
                                            <span class="text-muted">Sci-Fi, Adventure</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>176.9K</strong>
                                    <span class="change negative">-2.1%</span>
                                </td>
                                <td>
                                    <div class="rating">
                                        <span class="stars">⭐ 4.6</span>
                                        <span class="count">(14.3K)</span>
                                    </div>
                                </td>
                                <td>
                                    <strong>$32,180</strong>
                                </td>
                                <td>
                                    <div class="mini-chart">
                                        <canvas class="trend-chart" data-values="[20,22,18,16,15,14,12]"></canvas>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Device & Subscription Analytics -->
    <div class="row">
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Device Usage</h5>
                    <span class="subtitle">Platform distribution</span>
                </div>
                <div class="chart-body">
                    <div class="device-stats">
                        <div class="device-item">
                            <div class="device-icon mobile">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="device-info">
                                <h6>Mobile</h6>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: 45%;"></div>
                                </div>
                                <span>45% (56.8K users)</span>
                            </div>
                        </div>
                        <div class="device-item">
                            <div class="device-icon desktop">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <div class="device-info">
                                <h6>Desktop</h6>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: 30%;"></div>
                                </div>
                                <span>30% (37.6K users)</span>
                            </div>
                        </div>
                        <div class="device-item">
                            <div class="device-icon tablet">
                                <i class="fas fa-tablet-alt"></i>
                            </div>
                            <div class="device-info">
                                <h6>Tablet</h6>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: 15%;"></div>
                                </div>
                                <span>15% (18.9K users)</span>
                            </div>
                        </div>
                        <div class="device-item">
                            <div class="device-icon tv">
                                <i class="fas fa-tv"></i>
                            </div>
                            <div class="device-info">
                                <h6>Smart TV</h6>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: 10%;"></div>
                                </div>
                                <span>10% (12.6K users)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5>Subscription Analytics</h5>
                    <span class="subtitle">Plan distribution & churn</span>
                </div>
                <div class="chart-body">
                    <canvas id="subscriptionChart" height="150"></canvas>
                    <div class="subscription-stats mt-3">
                        <div class="stat-row">
                            <span>Churn Rate</span>
                            <strong class="text-danger">2.3%</strong>
                        </div>
                        <div class="stat-row">
                            <span>LTV</span>
                            <strong class="text-success">$126.50</strong>
                        </div>
                        <div class="stat-row">
                            <span>ARPU</span>
                            <strong class="text-info">$14.99</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.analytics-dashboard {
    padding: 2rem;
    background: #000000;
    min-height: 100vh;
}

/* Stat Cards */
.stat-card {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(162, 1, 54, 0.3);
}

.gradient-primary {
    background: linear-gradient(135deg, #A20136 0%, #8b0000 100%);
}

.gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.gradient-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.stat-icon {
    position: absolute;
    right: 1.5rem;
    top: 1.5rem;
    font-size: 3rem;
    opacity: 0.3;
    color: #ffffff;
}

.stat-content h3 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #ffffff;
    margin: 0;
}

.stat-content p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0.5rem 0;
    font-size: 0.9rem;
}

.stat-content .badge {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
}

.stat-chart {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40px;
    opacity: 0.5;
}

/* Chart Cards */
.chart-card {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.chart-header h5 {
    color: #ffffff;
    margin: 0;
    font-weight: 600;
}

.chart-controls {
    display: flex;
    gap: 0.5rem;
}

.chart-controls button {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.6);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    transition: all 0.3s;
}

.chart-controls button.active,
.chart-controls button:hover {
    background: #A20136;
    border-color: #A20136;
    color: #ffffff;
}

/* Activity Feed */
.activity-card {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    overflow: hidden;
}

.activity-card .card-header {
    background: linear-gradient(135deg, #A20136 0%, #8b0000 100%);
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.activity-card h5 {
    color: #ffffff;
    margin: 0;
}

.live-indicator {
    display: flex;
    align-items: center;
    color: #ffffff;
    font-size: 0.875rem;
}

.pulse {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    margin-right: 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}

.activity-feed {
    padding: 1rem;
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: background 0.3s;
}

.activity-item:hover {
    background: rgba(162, 1, 54, 0.1);
}

.activity-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.activity-content p {
    color: #ffffff;
    margin: 0;
    font-size: 0.9rem;
}

.activity-content .time {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.75rem;
}

/* Content Table */
.content-table-card {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    overflow: hidden;
}

.content-table-card .card-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-tabs {
    display: flex;
    gap: 0.5rem;
}

.tab-btn {
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    transition: all 0.3s;
    cursor: pointer;
}

.tab-btn.active,
.tab-btn:hover {
    background: #A20136;
    color: #ffffff;
}

.content-table-card table {
    color: #ffffff;
}

.content-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.content-thumb {
    border-radius: 8px;
    width: 50px;
    height: 75px;
    object-fit: cover;
}

.change.positive {
    color: #10b981;
}

.change.negative {
    color: #ef4444;
}

.rating .stars {
    color: #f59e0b;
}

.rating .count {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.875rem;
}

/* Device Stats */
.device-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.device-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.device-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ffffff;
}

.device-icon.mobile {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.device-icon.desktop {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.device-icon.tablet {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.device-icon.tv {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.device-info {
    flex: 1;
}

.device-info h6 {
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}

.progress-bar-custom {
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin: 0.5rem 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #A20136, #ff69b4);
    border-radius: 4px;
    transition: width 0.3s ease;
}

/* Country Stats */
.country-stats {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.country-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: rgba(162, 1, 54, 0.1);
    border-radius: 10px;
    transition: all 0.3s;
}

.country-item:hover {
    background: rgba(162, 1, 54, 0.2);
    transform: translateX(5px);
}

.country-item img {
    width: 30px;
}

.country-item span {
    flex: 1;
    color: rgba(255, 255, 255, 0.8);
}

.country-item strong {
    color: #A20136;
    font-weight: 600;
}

/* Subscription Stats */
.subscription-stats {
    display: flex;
    justify-content: space-around;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-row {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.stat-row span {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.875rem;
}

.stat-row strong {
    font-size: 1.25rem;
    font-weight: 600;
}

/* Legend */
.chart-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

/* Counter Animation */
.counter {
    display: inline-block;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(162, 1, 54, 0.5);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(162, 1, 54, 0.7);
}

/* Responsive */
@media (max-width: 768px) {
    .analytics-dashboard {
        padding: 1rem;
    }

    .stat-card {
        margin-bottom: 1rem;
    }

    .filter-tabs {
        flex-direction: column;
        width: 100%;
    }

    .tab-btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.getAttribute('data-target');
            const data = +counter.innerText.replace(/,/g, '');
            const time = value / speed;

            if (data < value) {
                counter.innerText = Math.ceil(data + time).toLocaleString();
                setTimeout(animate, 1);
            } else {
                counter.innerText = value.toLocaleString();
            }
        }
        animate();
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenue',
                data: [320000, 380000, 420000, 390000, 460000, 520000, 580000],
                borderColor: '#A20136',
                backgroundColor: 'rgba(162, 1, 54, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Subscriptions',
                data: [280000, 320000, 360000, 340000, 400000, 450000, 490000],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'
                    }
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value) {
                            return '$' + (value/1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });

    // Content Pie Chart
    const pieCtx = document.getElementById('contentPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Movies', 'Series', 'Live TV', 'Sports'],
            datasets: [{
                data: [42, 28, 20, 10],
                backgroundColor: [
                    '#A20136',
                    '#8b0000',
                    '#dc143c',
                    '#ff69b4'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Engagement Chart
    const engagementCtx = document.getElementById('engagementChart').getContext('2d');
    new Chart(engagementCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Active Users',
                data: [45000, 52000, 48000, 58000, 62000, 75000, 82000],
                backgroundColor: 'rgba(162, 1, 54, 0.8)'
            }, {
                label: 'New Users',
                data: [5000, 6200, 5800, 7200, 8500, 12000, 15000],
                backgroundColor: 'rgba(16, 185, 129, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'
                    }
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value) {
                            return (value/1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });

    // Subscription Chart
    const subCtx = document.getElementById('subscriptionChart').getContext('2d');
    new Chart(subCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Basic',
                data: [15000, 16000, 15500, 16500],
                borderColor: '#f59e0b',
                tension: 0.4
            }, {
                label: 'Standard',
                data: [25000, 26500, 28000, 29000],
                borderColor: '#3b82f6',
                tension: 0.4
            }, {
                label: 'Premium',
                data: [35000, 38000, 42000, 45000],
                borderColor: '#A20136',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'
                    }
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value) {
                            return (value/1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });

    // Sparkline Charts
    const sparklineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        elements: {
            point: { radius: 0 }
        }
    };

    // Users Sparkline
    new Chart(document.getElementById('usersSparkline'), {
        type: 'line',
        data: {
            labels: ['', '', '', '', '', '', ''],
            datasets: [{
                data: [100, 120, 115, 134, 168, 182, 200],
                borderColor: '#ffffff',
                borderWidth: 2,
                fill: false
            }]
        },
        options: sparklineOptions
    });

    // Mini Trend Charts
    document.querySelectorAll('.trend-chart').forEach(canvas => {
        const values = JSON.parse(canvas.dataset.values);
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: values.map(() => ''),
                datasets: [{
                    data: values,
                    borderColor: '#10b981',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: sparklineOptions
        });
    });
});
</script>
@endpush
@endsection