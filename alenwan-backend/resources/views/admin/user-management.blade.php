@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="user-management-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                User Management
            </h1>
            <p class="page-description">Manage users, subscriptions, and permissions</p>
        </div>

        <div class="header-actions">
            <button class="btn btn-outline" onclick="exportUsers()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-primary" onclick="showAddUserModal()">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon users-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-target="125847">0</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 12.5%
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon active-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-target="98542">0</div>
                <div class="stat-label">Active Users</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 8.2%
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon premium-icon">
                <i class="fas fa-crown"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-target="45632">0</div>
                <div class="stat-label">Premium Users</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 23.8%
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon online-icon">
                <i class="fas fa-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-target="8456">0</div>
                <div class="stat-label">Online Now</div>
                <div class="stat-change">
                    <span class="live-indicator"></span> Live
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search by name, email, or ID..." id="userSearch">
        </div>

        <div class="filter-chips">
            <button class="chip active" data-filter="all">All Users</button>
            <button class="chip" data-filter="premium">Premium</button>
            <button class="chip" data-filter="free">Free Trial</button>
            <button class="chip" data-filter="suspended">Suspended</button>
            <button class="chip" data-filter="verified">Verified</button>
            <button class="chip" data-filter="new">New (7 days)</button>
        </div>

        <div class="advanced-filters">
            <button class="btn-filter" onclick="toggleAdvancedFilters()">
                <i class="fas fa-filter"></i> Advanced Filters
            </button>

            <div class="bulk-actions" style="display: none;">
                <button class="btn btn-outline" onclick="bulkAction('verify')">
                    <i class="fas fa-check"></i> Verify
                </button>
                <button class="btn btn-outline" onclick="bulkAction('suspend')">
                    <i class="fas fa-ban"></i> Suspend
                </button>
                <button class="btn btn-outline danger" onclick="bulkAction('delete')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Advanced Filters Panel (Hidden by default) -->
    <div class="advanced-filters-panel" id="advancedFiltersPanel" style="display: none;">
        <div class="filter-group">
            <label>Registration Date</label>
            <div class="date-range">
                <input type="date" id="dateFrom" placeholder="From">
                <span>to</span>
                <input type="date" id="dateTo" placeholder="To">
            </div>
        </div>

        <div class="filter-group">
            <label>Subscription Plan</label>
            <select id="planFilter">
                <option value="">All Plans</option>
                <option value="basic">Basic</option>
                <option value="standard">Standard</option>
                <option value="premium">Premium</option>
                <option value="family">Family</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Device Type</label>
            <select id="deviceFilter">
                <option value="">All Devices</option>
                <option value="mobile">Mobile</option>
                <option value="tablet">Tablet</option>
                <option value="desktop">Desktop</option>
                <option value="tv">Smart TV</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Country</label>
            <select id="countryFilter">
                <option value="">All Countries</option>
                <option value="US">United States</option>
                <option value="GB">United Kingdom</option>
                <option value="CA">Canada</option>
                <option value="AU">Australia</option>
            </select>
        </div>

        <div class="filter-actions">
            <button class="btn btn-outline" onclick="resetFilters()">Reset</button>
            <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                    </th>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Devices</th>
                    <th>Last Active</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <!-- Sample User Row -->
                <tr class="user-row">
                    <td>
                        <input type="checkbox" class="user-select" value="1">
                    </td>
                    <td>
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=A20136&color=fff" class="user-avatar">
                            <div class="user-details">
                                <div class="user-name">John Doe</div>
                                <div class="user-email">john.doe@example.com</div>
                            </div>
                            <div class="user-badges">
                                <span class="badge verified" title="Verified">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <span class="badge two-factor" title="2FA Enabled">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="plan-badge premium">Premium</span>
                    </td>
                    <td>
                        <span class="status-badge active">Active</span>
                    </td>
                    <td>
                        <div class="device-icons">
                            <i class="fas fa-mobile-alt" title="Mobile"></i>
                            <i class="fas fa-laptop" title="Desktop"></i>
                            <i class="fas fa-tv" title="Smart TV"></i>
                            <span class="device-count">3/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="last-active">
                            <span class="time">2 hours ago</span>
                            <span class="online-indicator active"></span>
                        </div>
                    </td>
                    <td>
                        <div class="date">Mar 15, 2024</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(1)" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(1)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="sendMessage(1)" title="Send Message">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <div class="dropdown">
                                <button class="btn-icon" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a onclick="resetPassword(1)"><i class="fas fa-key"></i> Reset Password</a>
                                    <a onclick="viewActivity(1)"><i class="fas fa-history"></i> View Activity</a>
                                    <a onclick="manageDevices(1)"><i class="fas fa-mobile-alt"></i> Manage Devices</a>
                                    <a onclick="suspendUser(1)" class="danger"><i class="fas fa-ban"></i> Suspend</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- More sample rows -->
                <tr class="user-row">
                    <td>
                        <input type="checkbox" class="user-select" value="2">
                    </td>
                    <td>
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=A20136&color=fff" class="user-avatar">
                            <div class="user-details">
                                <div class="user-name">Sarah Smith</div>
                                <div class="user-email">sarah.smith@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="plan-badge standard">Standard</span>
                    </td>
                    <td>
                        <span class="status-badge active">Active</span>
                    </td>
                    <td>
                        <div class="device-icons">
                            <i class="fas fa-mobile-alt" title="Mobile"></i>
                            <i class="fas fa-tablet-alt" title="Tablet"></i>
                            <span class="device-count">2/3</span>
                        </div>
                    </td>
                    <td>
                        <div class="last-active">
                            <span class="time">1 day ago</span>
                        </div>
                    </td>
                    <td>
                        <div class="date">Jan 8, 2024</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="sendMessage(2)">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <div class="dropdown">
                                <button class="btn-icon" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a onclick="resetPassword(2)"><i class="fas fa-key"></i> Reset Password</a>
                                    <a onclick="viewActivity(2)"><i class="fas fa-history"></i> View Activity</a>
                                    <a onclick="manageDevices(2)"><i class="fas fa-mobile-alt"></i> Manage Devices</a>
                                    <a onclick="suspendUser(2)" class="danger"><i class="fas fa-ban"></i> Suspend</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="user-row">
                    <td>
                        <input type="checkbox" class="user-select" value="3">
                    </td>
                    <td>
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=Mike+Wilson&background=A20136&color=fff" class="user-avatar">
                            <div class="user-details">
                                <div class="user-name">Mike Wilson</div>
                                <div class="user-email">mike.wilson@example.com</div>
                            </div>
                            <div class="user-badges">
                                <span class="badge warning" title="Trial Ending">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="plan-badge trial">Free Trial</span>
                    </td>
                    <td>
                        <span class="status-badge trial">Trial</span>
                    </td>
                    <td>
                        <div class="device-icons">
                            <i class="fas fa-mobile-alt" title="Mobile"></i>
                            <span class="device-count">1/1</span>
                        </div>
                    </td>
                    <td>
                        <div class="last-active">
                            <span class="time">3 days ago</span>
                        </div>
                    </td>
                    <td>
                        <div class="date">Sep 20, 2024</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(3)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="sendMessage(3)">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <div class="dropdown">
                                <button class="btn-icon" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a onclick="convertToPremium(3)"><i class="fas fa-crown"></i> Convert to Premium</a>
                                    <a onclick="extendTrial(3)"><i class="fas fa-clock"></i> Extend Trial</a>
                                    <a onclick="viewActivity(3)"><i class="fas fa-history"></i> View Activity</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <strong>1-10</strong> of <strong>125,847</strong> users
        </div>
        <div class="pagination">
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <span class="page-dots">...</span>
            <button class="page-btn">1258</button>
            <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal" id="userDetailsModal">
    <div class="modal-content large">
        <div class="modal-header">
            <h2>User Details</h2>
            <button class="close-btn" onclick="closeModal('userDetailsModal')">×</button>
        </div>
        <div class="modal-body">
            <div class="user-detail-tabs">
                <button class="tab active" onclick="switchTab('profile')">Profile</button>
                <button class="tab" onclick="switchTab('activity')">Activity</button>
                <button class="tab" onclick="switchTab('devices')">Devices</button>
                <button class="tab" onclick="switchTab('subscription')">Subscription</button>
                <button class="tab" onclick="switchTab('history')">Watch History</button>
            </div>
            <div class="tab-content" id="userDetailContent">
                <!-- Tab content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.user-management-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

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

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--surface-color);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
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

.users-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.active-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.premium-icon {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.online-icon {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    color: white;
}

.stat-content {
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
}

.stat-change {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

.stat-change.positive {
    color: #4ade80;
}

.live-indicator {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

/* Filters Section */
.filters-section {
    background: var(--surface-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.search-box {
    position: relative;
    margin-bottom: 1rem;
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
    border-radius: 8px;
    color: white;
    font-size: 0.95rem;
}

.filter-chips {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.chip {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid #333;
    border-radius: 20px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chip:hover {
    background: rgba(255, 255, 255, 0.15);
}

.chip.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.advanced-filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-filter {
    padding: 0.5rem 1rem;
    background: transparent;
    border: 1px solid #333;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bulk-actions {
    display: flex;
    gap: 0.75rem;
}

/* Advanced Filters Panel */
.advanced-filters-panel {
    background: var(--surface-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    color: #888;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.date-range {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-range input,
.filter-group select {
    padding: 0.5rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 6px;
    color: white;
}

.filter-actions {
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #333;
}

/* Users Table */
.users-table-container {
    background: var(--surface-color);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: rgba(0, 0, 0, 0.3);
}

.users-table th {
    padding: 1rem;
    text-align: left;
    color: #888;
    font-weight: 500;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.user-row {
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: background 0.3s ease;
}

.user-row:hover {
    background: rgba(255, 255, 255, 0.02);
}

.users-table td {
    padding: 1rem;
    color: white;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-name {
    font-weight: 500;
    color: white;
}

.user-email {
    font-size: 0.85rem;
    color: #888;
}

.user-badges {
    display: flex;
    gap: 0.5rem;
    margin-left: auto;
}

.badge {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
}

.badge.verified {
    background: rgba(74, 222, 128, 0.2);
    color: #4ade80;
}

.badge.two-factor {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.badge.warning {
    background: rgba(251, 146, 60, 0.2);
    color: #fb923c;
}

/* Plan Badges */
.plan-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.plan-badge.premium {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.plan-badge.standard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.plan-badge.trial {
    background: rgba(251, 146, 60, 0.2);
    color: #fb923c;
    border: 1px solid #fb923c;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.active {
    background: rgba(74, 222, 128, 0.2);
    color: #4ade80;
}

.status-badge.trial {
    background: rgba(251, 146, 60, 0.2);
    color: #fb923c;
}

/* Device Icons */
.device-icons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.device-icons i {
    color: #888;
    font-size: 0.9rem;
}

.device-count {
    margin-left: 0.5rem;
    color: #888;
    font-size: 0.85rem;
}

/* Last Active */
.last-active {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.online-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4ade80;
}

.online-indicator.active {
    animation: pulse 2s infinite;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: rgba(255, 255, 255, 0.05);
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-icon:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

/* Dropdown */
.dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: var(--surface-color);
    border: 1px solid #333;
    border-radius: 8px;
    padding: 0.5rem 0;
    min-width: 180px;
    display: none;
    z-index: 100;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

.dropdown-menu.show {
    display: block;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

.dropdown-menu a:hover {
    background: rgba(255, 255, 255, 0.05);
}

.dropdown-menu a.danger {
    color: #ef4444;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
}

.pagination-info {
    color: #888;
    font-size: 0.9rem;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.page-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 0.75rem;
    background: var(--surface-color);
    border: 1px solid #333;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.page-btn:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.1);
}

.page-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-dots {
    display: flex;
    align-items: center;
    padding: 0 0.5rem;
    color: #888;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--surface-color);
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-content.large {
    max-width: 900px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #333;
}

.modal-header h2 {
    margin: 0;
    color: white;
}

.close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-body {
    padding: 1.5rem;
}

.user-detail-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid #333;
}

.tab {
    padding: 0.75rem 1rem;
    background: transparent;
    border: none;
    color: #888;
    cursor: pointer;
    position: relative;
    transition: color 0.3s ease;
}

.tab:hover {
    color: white;
}

.tab.active {
    color: var(--primary-color);
}

.tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--primary-color);
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
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(162, 1, 54, 0.3);
}

.btn-outline {
    background: transparent;
    color: white;
    border: 1px solid #333;
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.05);
}

.btn-outline.danger {
    color: #ef4444;
    border-color: #ef4444;
}

.btn-outline.danger:hover {
    background: rgba(239, 68, 68, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .users-table-container {
        overflow-x: auto;
    }

    .filter-chips {
        overflow-x: auto;
        flex-wrap: nowrap;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
        justify-content: center;
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

// Toggle advanced filters
function toggleAdvancedFilters() {
    const panel = document.getElementById('advancedFiltersPanel');
    panel.style.display = panel.style.display === 'none' ? 'grid' : 'none';
}

// Filter chips
document.querySelectorAll('.chip').forEach(chip => {
    chip.addEventListener('click', function() {
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        filterUsers(this.dataset.filter);
    });
});

// Select all checkbox
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-select');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);

    const bulkActions = document.querySelector('.bulk-actions');
    bulkActions.style.display = selectAll.checked ? 'flex' : 'none';
}

// Individual checkbox
document.querySelectorAll('.user-select').forEach(cb => {
    cb.addEventListener('change', function() {
        const anyChecked = document.querySelectorAll('.user-select:checked').length > 0;
        const bulkActions = document.querySelector('.bulk-actions');
        bulkActions.style.display = anyChecked ? 'flex' : 'none';
    });
});

// Dropdown toggle
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;

    // Close all other dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(d => {
        if (d !== dropdown) d.classList.remove('show');
    });

    dropdown.classList.toggle('show');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(d => {
            d.classList.remove('show');
        });
    }
});

// Search functionality
const searchInput = document.getElementById('userSearch');
searchInput.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    filterUsersBySearch(query);
});

// Filter functions
function filterUsers(filter) {
    console.log('Filtering by:', filter);
    // Implement actual filtering logic here
}

function filterUsersBySearch(query) {
    console.log('Searching for:', query);
    // Implement actual search logic here
}

function applyFilters() {
    const filters = {
        dateFrom: document.getElementById('dateFrom').value,
        dateTo: document.getElementById('dateTo').value,
        plan: document.getElementById('planFilter').value,
        device: document.getElementById('deviceFilter').value,
        country: document.getElementById('countryFilter').value
    };
    console.log('Applying filters:', filters);
    // Implement actual filter logic here
}

function resetFilters() {
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('planFilter').value = '';
    document.getElementById('deviceFilter').value = '';
    document.getElementById('countryFilter').value = '';
}

// User actions
function viewUser(id) {
    document.getElementById('userDetailsModal').classList.add('show');
    loadUserDetails(id);
}

function editUser(id) {
    console.log('Editing user:', id);
}

function sendMessage(id) {
    console.log('Sending message to user:', id);
}

function resetPassword(id) {
    if (confirm('Are you sure you want to reset the password for this user?')) {
        console.log('Resetting password for user:', id);
    }
}

function viewActivity(id) {
    console.log('Viewing activity for user:', id);
}

function manageDevices(id) {
    console.log('Managing devices for user:', id);
}

function suspendUser(id) {
    if (confirm('Are you sure you want to suspend this user?')) {
        console.log('Suspending user:', id);
    }
}

function convertToPremium(id) {
    console.log('Converting user to premium:', id);
}

function extendTrial(id) {
    console.log('Extending trial for user:', id);
}

function bulkAction(action) {
    const selected = document.querySelectorAll('.user-select:checked');
    const userIds = Array.from(selected).map(cb => cb.value);

    if (userIds.length === 0) {
        alert('Please select users first');
        return;
    }

    if (confirm(`Are you sure you want to ${action} ${userIds.length} users?`)) {
        console.log(`Bulk ${action} for users:`, userIds);
    }
}

function exportUsers() {
    console.log('Exporting users...');
}

function showAddUserModal() {
    console.log('Showing add user modal...');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

function switchTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    loadTabContent(tab);
}

function loadUserDetails(userId) {
    // Simulate loading user details
    console.log('Loading details for user:', userId);
}

function loadTabContent(tab) {
    // Simulate loading tab content
    console.log('Loading tab:', tab);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
});
</script>
@endsection