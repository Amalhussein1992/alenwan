@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="users-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-users"></i> {{ __('admin.users') }}</h2>
                <p class="text-muted">Manage all registered users and their subscriptions</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Add New User
                </button>
                <button class="btn btn-success" id="exportUsers">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>45,678</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-content">
                    <h3>12,340</h3>
                    <p>Active Subscribers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>1,890</h3>
                    <p>Trial Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="stats-content">
                    <h3>156</h3>
                    <p>New This Week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="row">
            <div class="col-md-4">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="userSearch" placeholder="Search users..." class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="subscriptionFilter">
                    <option value="">All Plans</option>
                    <option value="premium">Premium</option>
                    <option value="standard">Standard</option>
                    <option value="basic">Basic</option>
                    <option value="trial">Trial</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="created_desc">Newest First</option>
                    <option value="created_asc">Oldest First</option>
                    <option value="name_asc">Name A-Z</option>
                    <option value="name_desc">Name Z-A</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" id="clearFilters">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="users-grid" id="usersGrid">
        <!-- User Card 1 -->
        <div class="user-card" data-status="active" data-subscription="premium">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=John+Doe&size=60&background=667eea&color=fff" alt="User">
                <div class="status-badge active"></div>
            </div>
            <div class="user-info">
                <h5>John Doe</h5>
                <p class="email">john.doe@example.com</p>
                <div class="user-meta">
                    <span class="badge bg-success">Premium</span>
                    <span class="join-date">Joined: Jan 15, 2024</span>
                </div>
                <div class="subscription-info">
                    <small>Expires: Dec 15, 2024</small>
                    <div class="progress-bar">
                        <div class="progress" style="width: 75%;"></div>
                    </div>
                </div>
            </div>
            <div class="user-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="viewUser(1)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="editUser(1)">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="suspendUser(1)">
                    <i class="fas fa-ban"></i>
                </button>
            </div>
        </div>

        <!-- User Card 2 -->
        <div class="user-card" data-status="active" data-subscription="standard">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&size=60&background=f093fb&color=fff" alt="User">
                <div class="status-badge active"></div>
            </div>
            <div class="user-info">
                <h5>Sarah Wilson</h5>
                <p class="email">sarah.wilson@example.com</p>
                <div class="user-meta">
                    <span class="badge bg-warning">Standard</span>
                    <span class="join-date">Joined: Feb 20, 2024</span>
                </div>
                <div class="subscription-info">
                    <small>Expires: Jan 20, 2025</small>
                    <div class="progress-bar">
                        <div class="progress" style="width: 85%;"></div>
                    </div>
                </div>
            </div>
            <div class="user-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="viewUser(2)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="editUser(2)">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="suspendUser(2)">
                    <i class="fas fa-ban"></i>
                </button>
            </div>
        </div>

        <!-- User Card 3 -->
        <div class="user-card" data-status="suspended" data-subscription="basic">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=Mike+Johnson&size=60&background=ff6b6b&color=fff" alt="User">
                <div class="status-badge suspended"></div>
            </div>
            <div class="user-info">
                <h5>Mike Johnson</h5>
                <p class="email">mike.johnson@example.com</p>
                <div class="user-meta">
                    <span class="badge bg-secondary">Basic</span>
                    <span class="join-date">Joined: Mar 10, 2024</span>
                </div>
                <div class="suspension-info">
                    <small class="text-danger">Suspended: Violation of terms</small>
                </div>
            </div>
            <div class="user-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="viewUser(3)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="activateUser(3)">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(3)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- User Card 4 -->
        <div class="user-card" data-status="active" data-subscription="trial">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=Emma+Davis&size=60&background=4ecdc4&color=fff" alt="User">
                <div class="status-badge trial"></div>
            </div>
            <div class="user-info">
                <h5>Emma Davis</h5>
                <p class="email">emma.davis@example.com</p>
                <div class="user-meta">
                    <span class="badge bg-info">Trial</span>
                    <span class="join-date">Joined: May 01, 2024</span>
                </div>
                <div class="subscription-info">
                    <small>Trial ends: May 08, 2024</small>
                    <div class="progress-bar">
                        <div class="progress trial" style="width: 20%;"></div>
                    </div>
                </div>
            </div>
            <div class="user-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="viewUser(4)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="upgradeUser(4)">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button class="btn btn-sm btn-outline-warning" onclick="extendTrial(4)">
                    <i class="fas fa-clock"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        <nav aria-label="Users pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
.users-management {
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

.filters-section {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
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

.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.user-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.user-avatar {
    position: relative;
    align-self: flex-start;
}

.user-avatar img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #f8f9fa;
}

.status-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-badge.active {
    background: #10b981;
}

.status-badge.suspended {
    background: #ef4444;
}

.status-badge.trial {
    background: #f59e0b;
}

.user-info h5 {
    margin: 0 0 0.25rem 0;
    color: #333;
    font-weight: 600;
}

.user-info .email {
    margin: 0 0 0.5rem 0;
    color: #666;
    font-size: 0.9rem;
}

.user-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.join-date {
    font-size: 0.8rem;
    color: #888;
}

.subscription-info small {
    color: #666;
    display: block;
    margin-bottom: 0.25rem;
}

.suspension-info small {
    display: block;
    margin-bottom: 0.5rem;
}

.progress-bar {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.progress.trial {
    background: linear-gradient(90deg, #f59e0b, #f97316);
}

.user-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto;
}

.user-actions .btn {
    flex: 1;
    border-radius: 8px;
}

.pagination-section {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination .page-link {
    border-radius: 8px;
    margin: 0 2px;
    color: #667eea;
    border: 1px solid #e5e7eb;
}

.pagination .page-link:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.pagination .page-item.active .page-link {
    background: #667eea;
    border-color: #667eea;
}

@media (max-width: 768px) {
    .users-grid {
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
// Search functionality
document.getElementById('userSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const userCards = document.querySelectorAll('.user-card');

    userCards.forEach(card => {
        const userName = card.querySelector('h5').textContent.toLowerCase();
        const userEmail = card.querySelector('.email').textContent.toLowerCase();

        if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filter functionality
document.getElementById('statusFilter').addEventListener('change', function() {
    filterUsers();
});

document.getElementById('subscriptionFilter').addEventListener('change', function() {
    filterUsers();
});

function filterUsers() {
    const statusFilter = document.getElementById('statusFilter').value;
    const subscriptionFilter = document.getElementById('subscriptionFilter').value;
    const userCards = document.querySelectorAll('.user-card');

    userCards.forEach(card => {
        const userStatus = card.getAttribute('data-status');
        const userSubscription = card.getAttribute('data-subscription');

        let showCard = true;

        if (statusFilter && userStatus !== statusFilter) {
            showCard = false;
        }

        if (subscriptionFilter && userSubscription !== subscriptionFilter) {
            showCard = false;
        }

        card.style.display = showCard ? 'flex' : 'none';
    });
}

// Clear filters
document.getElementById('clearFilters').addEventListener('click', function() {
    document.getElementById('userSearch').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('subscriptionFilter').value = '';
    document.getElementById('sortBy').value = 'created_desc';

    document.querySelectorAll('.user-card').forEach(card => {
        card.style.display = 'flex';
    });
});

// User action functions
function viewUser(id) {
    alert(`Viewing user details for ID: ${id}`);
}

function editUser(id) {
    alert(`Opening edit form for user ID: ${id}`);
}

function suspendUser(id) {
    if (confirm('Are you sure you want to suspend this user?')) {
        alert(`User ${id} has been suspended`);
    }
}

function activateUser(id) {
    if (confirm('Are you sure you want to activate this user?')) {
        alert(`User ${id} has been activated`);
    }
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        alert(`User ${id} has been deleted`);
    }
}

function upgradeUser(id) {
    alert(`Opening subscription upgrade for user ID: ${id}`);
}

function extendTrial(id) {
    if (confirm('Extend trial period for this user?')) {
        alert(`Trial extended for user ID: ${id}`);
    }
}

// Export functionality
document.getElementById('exportUsers').addEventListener('click', function() {
    alert('Exporting user data...');
});
</script>
@endsection