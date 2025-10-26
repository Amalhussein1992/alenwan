@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="activity-logs-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-history"></i>
                Activity Logs
            </h1>
            <p class="page-description">Monitor all system activities and user actions</p>
        </div>

        <div class="header-actions">
            <button class="btn btn-outline" onclick="exportLogs()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-outline" onclick="refreshLogs()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value" data-target="458392">0</div>
                <div class="stat-label">Total Activities</div>
                <div class="stat-period">Last 30 days</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value" data-target="12847">0</div>
                <div class="stat-label">Active Users</div>
                <div class="stat-period">Today</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon security">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value" data-target="238">0</div>
                <div class="stat-label">Security Events</div>
                <div class="stat-period">Last 24 hours</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon errors">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value" data-target="47">0</div>
                <div class="stat-label">Errors</div>
                <div class="stat-period">Last hour</div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-container">
        <div class="filter-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search by user, action, or IP address..." id="logSearch">
            </div>

            <div class="date-filter">
                <input type="datetime-local" id="startDate" placeholder="Start Date">
                <span class="date-separator">to</span>
                <input type="datetime-local" id="endDate" placeholder="End Date">
            </div>
        </div>

        <div class="filter-tags">
            <button class="tag-btn active" data-filter="all">
                <i class="fas fa-globe"></i> All Activities
            </button>
            <button class="tag-btn" data-filter="auth">
                <i class="fas fa-lock"></i> Authentication
            </button>
            <button class="tag-btn" data-filter="content">
                <i class="fas fa-film"></i> Content
            </button>
            <button class="tag-btn" data-filter="payment">
                <i class="fas fa-credit-card"></i> Payments
            </button>
            <button class="tag-btn" data-filter="admin">
                <i class="fas fa-user-shield"></i> Admin Actions
            </button>
            <button class="tag-btn" data-filter="api">
                <i class="fas fa-code"></i> API Calls
            </button>
            <button class="tag-btn" data-filter="errors">
                <i class="fas fa-bug"></i> Errors
            </button>
        </div>

        <div class="advanced-filters">
            <select id="userFilter" class="filter-select">
                <option value="">All Users</option>
                <option value="admin">Admin Users</option>
                <option value="premium">Premium Users</option>
                <option value="free">Free Users</option>
            </select>

            <select id="severityFilter" class="filter-select">
                <option value="">All Severities</option>
                <option value="info">Info</option>
                <option value="warning">Warning</option>
                <option value="error">Error</option>
                <option value="critical">Critical</option>
            </select>

            <select id="deviceFilter" class="filter-select">
                <option value="">All Devices</option>
                <option value="web">Web</option>
                <option value="mobile">Mobile</option>
                <option value="tablet">Tablet</option>
                <option value="tv">Smart TV</option>
            </select>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="timeline-container">
        <div class="timeline-header">
            <h3>Activity Timeline</h3>
            <div class="view-toggle">
                <button class="view-btn active" data-view="timeline">
                    <i class="fas fa-stream"></i> Timeline
                </button>
                <button class="view-btn" data-view="table">
                    <i class="fas fa-table"></i> Table
                </button>
                <button class="view-btn" data-view="grid">
                    <i class="fas fa-th"></i> Grid
                </button>
            </div>
        </div>

        <!-- Timeline View -->
        <div class="timeline-view" id="timelineView">
            <!-- Today -->
            <div class="timeline-date">
                <div class="date-marker">Today</div>
            </div>

            <div class="timeline-item">
                <div class="timeline-time">2 min ago</div>
                <div class="timeline-connector">
                    <div class="timeline-dot success"></div>
                    <div class="timeline-line"></div>
                </div>
                <div class="timeline-content">
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-user">
                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=A20136&color=fff" alt="User">
                                <div class="user-info">
                                    <span class="user-name">John Doe</span>
                                    <span class="user-role">Premium User</span>
                                </div>
                            </div>
                            <div class="activity-badge success">
                                <i class="fas fa-check"></i> Success
                            </div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-action">
                                <i class="fas fa-play-circle"></i>
                                Started watching "Inception"
                            </div>
                            <div class="activity-details">
                                <span class="detail-item">
                                    <i class="fas fa-desktop"></i> Chrome Browser
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i> New York, USA
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-wifi"></i> IP: 192.168.1.1
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-time">15 min ago</div>
                <div class="timeline-connector">
                    <div class="timeline-dot warning"></div>
                    <div class="timeline-line"></div>
                </div>
                <div class="timeline-content">
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-user">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=A20136&color=fff" alt="User">
                                <div class="user-info">
                                    <span class="user-name">Sarah Smith</span>
                                    <span class="user-role">Standard User</span>
                                </div>
                            </div>
                            <div class="activity-badge warning">
                                <i class="fas fa-exclamation"></i> Warning
                            </div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-action">
                                <i class="fas fa-credit-card"></i>
                                Payment failed - Insufficient funds
                            </div>
                            <div class="activity-details">
                                <span class="detail-item">
                                    <i class="fas fa-dollar-sign"></i> Amount: $14.99
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-credit-card"></i> Card ending: ****4242
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-time">1 hour ago</div>
                <div class="timeline-connector">
                    <div class="timeline-dot info"></div>
                    <div class="timeline-line"></div>
                </div>
                <div class="timeline-content">
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-user">
                                <div class="system-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">System</span>
                                    <span class="user-role">Automated Process</span>
                                </div>
                            </div>
                            <div class="activity-badge info">
                                <i class="fas fa-info"></i> Info
                            </div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-action">
                                <i class="fas fa-database"></i>
                                Database backup completed successfully
                            </div>
                            <div class="activity-details">
                                <span class="detail-item">
                                    <i class="fas fa-hdd"></i> Size: 2.4 GB
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-clock"></i> Duration: 3m 24s
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-time">2 hours ago</div>
                <div class="timeline-connector">
                    <div class="timeline-dot error"></div>
                    <div class="timeline-line"></div>
                </div>
                <div class="timeline-content">
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-user">
                                <img src="https://ui-avatars.com/api/?name=Mike+Wilson&background=A20136&color=fff" alt="User">
                                <div class="user-info">
                                    <span class="user-name">Mike Wilson</span>
                                    <span class="user-role">Free User</span>
                                </div>
                            </div>
                            <div class="activity-badge error">
                                <i class="fas fa-times"></i> Error
                            </div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-action">
                                <i class="fas fa-ban"></i>
                                Login failed - Too many attempts
                            </div>
                            <div class="activity-details">
                                <span class="detail-item">
                                    <i class="fas fa-mobile-alt"></i> iOS App
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i> London, UK
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-lock"></i> Account temporarily locked
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yesterday -->
            <div class="timeline-date">
                <div class="date-marker">Yesterday</div>
            </div>

            <div class="timeline-item">
                <div class="timeline-time">8:30 PM</div>
                <div class="timeline-connector">
                    <div class="timeline-dot success"></div>
                    <div class="timeline-line"></div>
                </div>
                <div class="timeline-content">
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-user">
                                <img src="https://ui-avatars.com/api/?name=Admin&background=A20136&color=fff" alt="Admin">
                                <div class="user-info">
                                    <span class="user-name">Admin</span>
                                    <span class="user-role">Super Admin</span>
                                </div>
                            </div>
                            <div class="activity-badge success">
                                <i class="fas fa-check"></i> Success
                            </div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-action">
                                <i class="fas fa-upload"></i>
                                Uploaded 25 new movies to catalog
                            </div>
                            <div class="activity-details">
                                <span class="detail-item">
                                    <i class="fas fa-film"></i> Category: Action
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-hdd"></i> Total Size: 45 GB
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View (Hidden by default) -->
        <div class="table-view" id="tableView" style="display: none;">
            <table class="logs-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>IP Address</th>
                        <th>Device</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Load More -->
    <div class="load-more-container">
        <button class="btn btn-outline" onclick="loadMoreLogs()">
            <i class="fas fa-plus"></i> Load More Activities
        </button>
    </div>
</div>

<!-- Real-time Activity Feed -->
<div class="activity-feed-widget">
    <div class="widget-header">
        <h4>Live Activity</h4>
        <span class="live-indicator"></span>
    </div>
    <div class="widget-body" id="liveActivityFeed">
        <!-- Live activities will appear here -->
    </div>
</div>

<style>
.activity-logs-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 2rem;
    font-weight: bold;
    color: white;
    margin: 0;
}

.page-description {
    color: #888;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Stats Overview */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(162, 1, 54, 0.2);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-icon.users {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    color: white;
}

.stat-icon.security {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.stat-icon.errors {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff4757 100%);
    color: white;
}

.stat-details {
    flex: 1;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: white;
    margin-bottom: 0.25rem;
}

.stat-label {
    color: #888;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.stat-period {
    color: #666;
    font-size: 0.75rem;
}

/* Filters Container */
.filters-container {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.filter-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 300px;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 10px;
    color: white;
}

.date-filter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-filter input {
    padding: 0.75rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 10px;
    color: white;
}

.date-separator {
    color: #888;
}

.filter-tags {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.tag-btn {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #333;
    border-radius: 20px;
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.tag-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.tag-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.advanced-filters {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-select {
    padding: 0.5rem 1rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 10px;
    color: white;
    min-width: 150px;
}

/* Timeline Container */
.timeline-container {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.timeline-header h3 {
    margin: 0;
    color: white;
    font-size: 1.2rem;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: none;
    border-radius: 8px;
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.view-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.view-btn.active {
    background: var(--primary-color);
    color: white;
}

/* Timeline View */
.timeline-view {
    position: relative;
}

.timeline-date {
    margin: 2rem 0 1rem;
}

.date-marker {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: rgba(162, 1, 54, 0.1);
    border: 1px solid var(--primary-color);
    border-radius: 20px;
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.9rem;
}

.timeline-item {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-time {
    width: 80px;
    text-align: right;
    color: #888;
    font-size: 0.85rem;
    padding-top: 0.5rem;
}

.timeline-connector {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.timeline-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-top: 0.5rem;
    z-index: 2;
}

.timeline-dot.success {
    background: #4ade80;
    box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2);
}

.timeline-dot.warning {
    background: #fb923c;
    box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.2);
}

.timeline-dot.info {
    background: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
}

.timeline-dot.error {
    background: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
}

.timeline-line {
    width: 2px;
    flex: 1;
    background: #333;
    margin-top: 0.5rem;
}

.timeline-content {
    flex: 1;
}

/* Activity Card */
.activity-card {
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.activity-card:hover {
    background: rgba(0, 0, 0, 0.5);
    transform: translateX(5px);
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.activity-user {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.activity-user img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
}

.system-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #888;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    color: white;
    font-weight: 500;
    font-size: 0.9rem;
}

.user-role {
    color: #888;
    font-size: 0.75rem;
}

.activity-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.activity-badge.success {
    background: rgba(74, 222, 128, 0.2);
    color: #4ade80;
}

.activity-badge.warning {
    background: rgba(251, 146, 60, 0.2);
    color: #fb923c;
}

.activity-badge.info {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.activity-badge.error {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.activity-body {
    margin-left: 3rem;
}

.activity-action {
    color: white;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.activity-details {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.detail-item {
    color: #888;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Activity Feed Widget */
.activity-feed-widget {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 320px;
    background: var(--surface-color);
    border: 1px solid #333;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    z-index: 100;
    transition: transform 0.3s ease;
}

.activity-feed-widget:hover {
    transform: translateY(-5px);
}

.widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #333;
}

.widget-header h4 {
    margin: 0;
    color: white;
    font-size: 0.9rem;
}

.live-indicator {
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.widget-body {
    max-height: 300px;
    overflow-y: auto;
    padding: 0.5rem;
}

/* Load More Container */
.load-more-container {
    text-align: center;
    padding: 2rem;
}

/* Animations */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(74, 222, 128, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(74, 222, 128, 0);
    }
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-outline {
    background: transparent;
    color: white;
    border: 1px solid #333;
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }

    .filter-row {
        flex-direction: column;
    }

    .search-box {
        min-width: 100%;
    }

    .timeline-item {
        flex-direction: column;
        gap: 0.5rem;
    }

    .timeline-time {
        width: auto;
        text-align: left;
    }

    .timeline-connector {
        display: none;
    }

    .activity-feed-widget {
        display: none;
    }
}
</style>

<script>
// Counter animation
function animateCounters() {
    const counters = document.querySelectorAll('.stat-value');
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.target);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        updateCounter();
    });
}

// View toggle
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const view = this.dataset.view;
        document.getElementById('timelineView').style.display = view === 'timeline' ? 'block' : 'none';
        document.getElementById('tableView').style.display = view === 'table' ? 'block' : 'none';
    });
});

// Filter tags
document.querySelectorAll('.tag-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tag-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        filterLogs(this.dataset.filter);
    });
});

// Search functionality
document.getElementById('logSearch').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    searchLogs(query);
});

// Filter functions
function filterLogs(filter) {
    console.log('Filtering logs by:', filter);
    // Implement actual filtering logic
}

function searchLogs(query) {
    console.log('Searching logs:', query);
    // Implement actual search logic
}

function exportLogs() {
    console.log('Exporting logs...');
}

function refreshLogs() {
    console.log('Refreshing logs...');
    location.reload();
}

function loadMoreLogs() {
    console.log('Loading more logs...');
    // Implement pagination logic
}

// Live activity feed simulation
function addLiveActivity() {
    const feed = document.getElementById('liveActivityFeed');
    const activities = [
        { user: 'New User', action: 'registered', type: 'success' },
        { user: 'John Doe', action: 'started watching', type: 'info' },
        { user: 'Sarah Smith', action: 'upgraded plan', type: 'success' },
        { user: 'Mike Wilson', action: 'login failed', type: 'error' }
    ];

    const activity = activities[Math.floor(Math.random() * activities.length)];
    const activityEl = document.createElement('div');
    activityEl.className = 'live-activity-item';
    activityEl.innerHTML = `
        <div class="live-activity">
            <span class="activity-user">${activity.user}</span>
            <span class="activity-action">${activity.action}</span>
        </div>
    `;

    feed.insertBefore(activityEl, feed.firstChild);

    // Remove old activities
    if (feed.children.length > 5) {
        feed.removeChild(feed.lastChild);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();

    // Simulate live activities
    setInterval(addLiveActivity, 5000);
});
</script>
@endsection