@extends('admin.layouts.app')

@section('title', 'Video Banners Management')

@section('content')
<div class="banners-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-images"></i> {{ __('admin.banners') }}</h2>
                <p class="text-muted">Manage promotional video banners and hero content</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="createBanner()">
                    <i class="fas fa-plus"></i> Create Banner
                </button>
                <button class="btn btn-success" onclick="previewBanners()">
                    <i class="fas fa-eye"></i> Preview All
                </button>
            </div>
        </div>
    </div>

    <!-- Banner Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-images"></i>
                </div>
                <div class="stats-content">
                    <h3>12</h3>
                    <p>Active Banners</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <div class="stats-content">
                    <h3>89.2K</h3>
                    <p>Total Clicks</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stats-content">
                    <h3>12.5%</h3>
                    <p>Click Rate</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stats-content">
                    <h3>2.3M</h3>
                    <p>Impressions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Positions -->
    <div class="banner-positions mb-4">
        <h4><i class="fas fa-layer-group"></i> Banner Positions</h4>
        <div class="position-grid">
            <div class="position-slot hero">
                <div class="position-header">
                    <h5>Hero Banner</h5>
                    <span class="position-size">1920x600</span>
                </div>
                <div class="position-content">
                    <div class="banner-preview">
                        <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=400&h=150&fit=crop" alt="Hero Banner">
                        <div class="banner-overlay">
                            <h6>Latest Blockbuster Movies</h6>
                            <p>Watch Now</p>
                        </div>
                    </div>
                    <div class="banner-actions">
                        <button class="btn btn-sm btn-primary" onclick="editBanner('hero')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="viewStats('hero')">
                            <i class="fas fa-chart-bar"></i> Stats
                        </button>
                    </div>
                </div>
            </div>

            <div class="position-slot sidebar">
                <div class="position-header">
                    <h5>Sidebar Banner</h5>
                    <span class="position-size">300x600</span>
                </div>
                <div class="position-content">
                    <div class="banner-preview">
                        <img src="https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=150&h=240&fit=crop" alt="Sidebar Banner">
                        <div class="banner-overlay">
                            <h6>Premium Plans</h6>
                            <p>50% Off</p>
                        </div>
                    </div>
                    <div class="banner-actions">
                        <button class="btn btn-sm btn-primary" onclick="editBanner('sidebar')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="viewStats('sidebar')">
                            <i class="fas fa-chart-bar"></i> Stats
                        </button>
                    </div>
                </div>
            </div>

            <div class="position-slot footer">
                <div class="position-header">
                    <h5>Footer Banner</h5>
                    <span class="position-size">1200x200</span>
                </div>
                <div class="position-content">
                    <div class="banner-preview">
                        <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=300&h=100&fit=crop" alt="Footer Banner">
                        <div class="banner-overlay">
                            <h6>Download Our App</h6>
                            <p>Available Now</p>
                        </div>
                    </div>
                    <div class="banner-actions">
                        <button class="btn btn-sm btn-primary" onclick="editBanner('footer')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="viewStats('footer')">
                            <i class="fas fa-chart-bar"></i> Stats
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Library -->
    <div class="banner-library">
        <h4><i class="fas fa-folder-open"></i> Banner Library</h4>
        <div class="banners-grid">
            <div class="banner-card active">
                <div class="banner-thumbnail">
                    <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=300&h=180&fit=crop" alt="Movie Banner">
                    <div class="banner-status active">Active</div>
                    <div class="banner-type">Hero</div>
                </div>
                <div class="banner-info">
                    <h5>Summer Blockbusters 2024</h5>
                    <p class="banner-description">Promotional banner for summer movie releases</p>
                    <div class="banner-stats">
                        <div class="stat">
                            <strong>45.2K</strong>
                            <span>Clicks</span>
                        </div>
                        <div class="stat">
                            <strong>8.9%</strong>
                            <span>CTR</span>
                        </div>
                    </div>
                    <div class="banner-schedule">
                        <small><i class="fas fa-calendar"></i> Runs until: Dec 31, 2024</small>
                    </div>
                </div>
                <div class="banner-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="editBanner(1)">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-warning" onclick="pauseBanner(1)">
                        <i class="fas fa-pause"></i> Pause
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="duplicateBanner(1)">
                        <i class="fas fa-copy"></i> Clone
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBanner(1)">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>

            <div class="banner-card scheduled">
                <div class="banner-thumbnail">
                    <img src="https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=300&h=180&fit=crop" alt="Tech Banner">
                    <div class="banner-status scheduled">Scheduled</div>
                    <div class="banner-type">Sidebar</div>
                </div>
                <div class="banner-info">
                    <h5>Tech Documentaries</h5>
                    <p class="banner-description">Upcoming tech documentary collection</p>
                    <div class="banner-stats">
                        <div class="stat">
                            <strong>0</strong>
                            <span>Clicks</span>
                        </div>
                        <div class="stat">
                            <strong>0%</strong>
                            <span>CTR</span>
                        </div>
                    </div>
                    <div class="banner-schedule">
                        <small><i class="fas fa-clock"></i> Starts: Jan 1, 2025</small>
                    </div>
                </div>
                <div class="banner-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="editBanner(2)">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="activateNow(2)">
                        <i class="fas fa-play"></i> Start Now
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="previewBanner(2)">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBanner(2)">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>

            <div class="banner-card paused">
                <div class="banner-thumbnail">
                    <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=300&h=180&fit=crop" alt="Sports Banner">
                    <div class="banner-status paused">Paused</div>
                    <div class="banner-type">Footer</div>
                </div>
                <div class="banner-info">
                    <h5>Sports Championship</h5>
                    <p class="banner-description">Live sports streaming promotion</p>
                    <div class="banner-stats">
                        <div class="stat">
                            <strong>12.8K</strong>
                            <span>Clicks</span>
                        </div>
                        <div class="stat">
                            <strong>6.2%</strong>
                            <span>CTR</span>
                        </div>
                    </div>
                    <div class="banner-schedule">
                        <small><i class="fas fa-pause-circle"></i> Paused 2 days ago</small>
                    </div>
                </div>
                <div class="banner-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="editBanner(3)">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="resumeBanner(3)">
                        <i class="fas fa-play"></i> Resume
                    </button>
                    <button class="btn btn-sm btn-outline-info" onclick="viewAnalytics(3)">
                        <i class="fas fa-chart-line"></i> Analytics
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBanner(3)">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.banners-management {
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

.banner-positions {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(162, 1, 54, 0.2);
}

.banner-positions h4 {
    color: #ffffff;
    margin-bottom: 1.5rem;
}

.position-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 2fr;
    gap: 1.5rem;
}

.position-slot {
    border: 2px dashed #e5e7eb;
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
    transition: border-color 0.3s ease;
}

.position-slot:hover {
    border-color: #A20136;
}

.position-header {
    margin-bottom: 1rem;
}

.position-header h5 {
    margin: 0;
    color: #333;
}

.position-size {
    color: #666;
    font-size: 0.8rem;
}

.banner-preview {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.banner-preview img {
    width: 100%;
    height: auto;
    display: block;
}

.banner-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 1rem;
    text-align: left;
}

.banner-overlay h6 {
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.banner-overlay p {
    margin: 0;
    font-size: 0.8rem;
    opacity: 0.9;
}

.banner-actions {
    display: flex;
    gap: 0.25rem;
    justify-content: center;
}

.banner-library {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.banner-library h4 {
    color: #333;
    margin-bottom: 1.5rem;
}

.banners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.banner-card {
    background: #f8f9fa;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease;
    border: 2px solid transparent;
}

.banner-card:hover {
    transform: translateY(-3px);
}

.banner-card.active {
    border-color: #10b981;
}

.banner-card.scheduled {
    border-color: #f59e0b;
}

.banner-card.paused {
    border-color: #6b7280;
}

.banner-thumbnail {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.banner-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-status {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.banner-status.active {
    background: #10b981;
    color: white;
}

.banner-status.scheduled {
    background: #f59e0b;
    color: white;
}

.banner-status.paused {
    background: #6b7280;
    color: white;
}

.banner-type {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
}

.banner-info {
    padding: 1.5rem;
}

.banner-info h5 {
    margin: 0 0 0.5rem 0;
    color: #333;
    font-weight: 600;
}

.banner-description {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
}

.banner-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.banner-stats .stat {
    text-align: center;
}

.banner-stats .stat strong {
    display: block;
    color: #333;
    font-size: 1.1rem;
}

.banner-stats .stat span {
    color: #666;
    font-size: 0.8rem;
}

.banner-schedule {
    margin-bottom: 1rem;
}

.banner-schedule small {
    color: #666;
}

.banner-actions {
    padding: 0 1.5rem 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .position-grid {
        grid-template-columns: 1fr;
    }

    .banners-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .banner-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function createBanner() {
    alert('Opening banner creation wizard...');
}

function previewBanners() {
    alert('Opening banner preview mode...');
}

function editBanner(id) {
    alert(`Editing banner ID/Position: ${id}`);
}

function viewStats(id) {
    alert(`Viewing statistics for banner: ${id}`);
}

function pauseBanner(id) {
    if (confirm('Pause this banner?')) {
        alert(`Banner ${id} paused`);
    }
}

function resumeBanner(id) {
    if (confirm('Resume this banner?')) {
        alert(`Banner ${id} resumed`);
    }
}

function activateNow(id) {
    if (confirm('Activate this banner now?')) {
        alert(`Banner ${id} activated`);
    }
}

function duplicateBanner(id) {
    alert(`Creating copy of banner ${id}...`);
}

function deleteBanner(id) {
    if (confirm('Delete this banner? This action cannot be undone.')) {
        alert(`Banner ${id} deleted`);
    }
}

function previewBanner(id) {
    alert(`Previewing banner ${id}...`);
}

function viewAnalytics(id) {
    alert(`Viewing detailed analytics for banner ${id}...`);
}
</script>
@endsection