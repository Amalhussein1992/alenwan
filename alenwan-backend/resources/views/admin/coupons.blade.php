@extends('admin.layouts.app')

@section('title', 'Coupons Management')

@section('content')
<div class="coupons-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-tags"></i> {{ __('admin.coupons') }}</h2>
                <p class="text-muted">Manage discount coupons and promotional codes</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="createCoupon()">
                    <i class="fas fa-plus"></i> Create Coupon
                </button>
                <button class="btn btn-success" onclick="bulkGenerate()">
                    <i class="fas fa-layer-group"></i> Bulk Generate
                </button>
            </div>
        </div>
    </div>

    <!-- Coupon Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stats-content">
                    <h3>156</h3>
                    <p>Active Coupons</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stats-content">
                    <h3>$45.2K</h3>
                    <p>Discounts Given</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>2.3K</h3>
                    <p>Redemptions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>23</h3>
                    <p>Expiring Soon</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Grid -->
    <div class="coupons-grid">
        <div class="coupon-card active">
            <div class="coupon-header">
                <div class="coupon-code">WELCOME50</div>
                <div class="coupon-discount">50% OFF</div>
            </div>
            <div class="coupon-info">
                <h5>Welcome Discount</h5>
                <p class="coupon-description">Special discount for new subscribers</p>
                <div class="coupon-details">
                    <div class="detail-item">
                        <strong>Usage:</strong> 156 / 500
                    </div>
                    <div class="detail-item">
                        <strong>Valid Until:</strong> Dec 31, 2024
                    </div>
                    <div class="progress-bar">
                        <div class="progress" style="width: 31.2%;"></div>
                    </div>
                </div>
            </div>
            <div class="coupon-actions">
                <button class="btn btn-sm btn-primary" onclick="editCoupon(1)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="duplicateCoupon(1)">
                    <i class="fas fa-copy"></i> Duplicate
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deactivateCoupon(1)">
                    <i class="fas fa-pause"></i> Pause
                </button>
            </div>
        </div>

        <div class="coupon-card limited">
            <div class="coupon-header">
                <div class="coupon-code">FLASH25</div>
                <div class="coupon-discount">25% OFF</div>
                <div class="limited-badge">Limited Time</div>
            </div>
            <div class="coupon-info">
                <h5>Flash Sale</h5>
                <p class="coupon-description">Limited time flash sale promotion</p>
                <div class="coupon-details">
                    <div class="detail-item">
                        <strong>Usage:</strong> 89 / 100
                    </div>
                    <div class="detail-item">
                        <strong>Valid Until:</strong> Today 11:59 PM
                    </div>
                    <div class="progress-bar">
                        <div class="progress warning" style="width: 89%;"></div>
                    </div>
                </div>
            </div>
            <div class="coupon-actions">
                <button class="btn btn-sm btn-primary" onclick="editCoupon(2)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-warning" onclick="extendCoupon(2)">
                    <i class="fas fa-clock"></i> Extend
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deactivateCoupon(2)">
                    <i class="fas fa-stop"></i> Stop
                </button>
            </div>
        </div>

        <div class="coupon-card expired">
            <div class="coupon-header">
                <div class="coupon-code">SUMMER20</div>
                <div class="coupon-discount">20% OFF</div>
                <div class="expired-badge">Expired</div>
            </div>
            <div class="coupon-info">
                <h5>Summer Special</h5>
                <p class="coupon-description">Summer vacation special offer</p>
                <div class="coupon-details">
                    <div class="detail-item">
                        <strong>Usage:</strong> 445 / 1000
                    </div>
                    <div class="detail-item">
                        <strong>Expired:</strong> Aug 31, 2024
                    </div>
                    <div class="progress-bar">
                        <div class="progress expired" style="width: 44.5%;"></div>
                    </div>
                </div>
            </div>
            <div class="coupon-actions">
                <button class="btn btn-sm btn-outline-success" onclick="reactivateCoupon(3)">
                    <i class="fas fa-redo"></i> Reactivate
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStats(3)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteCoupon(3)">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <div class="coupon-card premium">
            <div class="coupon-header">
                <div class="coupon-code">VIP30</div>
                <div class="coupon-discount">30% OFF</div>
                <div class="premium-badge">VIP Only</div>
            </div>
            <div class="coupon-info">
                <h5>VIP Member Exclusive</h5>
                <p class="coupon-description">Exclusive discount for VIP members</p>
                <div class="coupon-details">
                    <div class="detail-item">
                        <strong>Usage:</strong> 12 / ∞
                    </div>
                    <div class="detail-item">
                        <strong>Valid Until:</strong> Never Expires
                    </div>
                    <div class="progress-bar">
                        <div class="progress premium" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="coupon-actions">
                <button class="btn btn-sm btn-primary" onclick="editCoupon(4)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-info" onclick="manageVIPList(4)">
                    <i class="fas fa-crown"></i> VIP List
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStats(4)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.coupons-management {
    padding: 2rem;
    background: #000000;
    color: #ffffff;
}

.page-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.page-header h2 {
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.stats-card {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(162, 1, 54, 0.2);
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
    color: #ffffff;
}

.stats-content p {
    margin: 0;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.coupons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.coupon-card {
    background: #141414;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(162, 1, 54, 0.2);
    transition: transform 0.3s ease;
    border: 2px solid transparent;
}

.coupon-card:hover {
    transform: translateY(-5px);
}

.coupon-card.active {
    border-color: #10b981;
}

.coupon-card.limited {
    border-color: #f59e0b;
}

.coupon-card.expired {
    border-color: #ef4444;
    opacity: 0.7;
}

.coupon-card.premium {
    border-color: #8b5cf6;
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
}

.coupon-header {
    background: linear-gradient(135deg, #A20136 0%, #8b0000 100%);
    color: white;
    padding: 1.5rem;
    text-align: center;
    position: relative;
}

.coupon-card.limited .coupon-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.coupon-card.expired .coupon-header {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.coupon-card.premium .coupon-header {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.coupon-code {
    font-size: 1.5rem;
    font-weight: bold;
    letter-spacing: 2px;
    margin-bottom: 0.5rem;
}

.coupon-discount {
    font-size: 1.2rem;
    font-weight: 600;
}

.limited-badge, .expired-badge, .premium-badge {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: bold;
}

.coupon-info {
    padding: 1.5rem;
}

.coupon-info h5 {
    margin: 0 0 0.5rem 0;
    color: #ffffff;
    font-weight: 600;
}

.coupon-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
}

.coupon-details {
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.detail-item strong {
    color: #ffffff;
}

.progress-bar {
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
    margin-top: 0.5rem;
}

.progress {
    height: 100%;
    background: linear-gradient(90deg, #A20136, #8b0000);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress.warning {
    background: linear-gradient(90deg, #f59e0b, #d97706);
}

.progress.expired {
    background: linear-gradient(90deg, #ef4444, #dc2626);
}

.progress.premium {
    background: linear-gradient(90deg, #8b5cf6, #7c3aed);
}

.coupon-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

.coupon-actions .btn {
    flex: 1;
    border-radius: 8px;
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .coupons-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
}
</style>

<script>
function createCoupon() {
    alert('Opening coupon creation form...');
}

function bulkGenerate() {
    alert('Opening bulk coupon generation...');
}

function editCoupon(id) {
    alert(`Editing coupon ID: ${id}`);
}

function duplicateCoupon(id) {
    alert(`Duplicating coupon ID: ${id}`);
}

function deactivateCoupon(id) {
    if (confirm('Deactivate this coupon?')) {
        alert(`Coupon ${id} deactivated`);
    }
}

function extendCoupon(id) {
    alert(`Extending expiry date for coupon ID: ${id}`);
}

function reactivateCoupon(id) {
    if (confirm('Reactivate this expired coupon?')) {
        alert(`Coupon ${id} reactivated`);
    }
}

function viewStats(id) {
    alert(`Viewing statistics for coupon ID: ${id}`);
}

function deleteCoupon(id) {
    if (confirm('Delete this coupon? This action cannot be undone.')) {
        alert(`Coupon ${id} deleted`);
    }
}

function manageVIPList(id) {
    alert(`Managing VIP list for coupon ID: ${id}`);
}
</script>
@endsection