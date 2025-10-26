@extends('admin.layouts.app')

@section('title', 'Documentaries Management')

@section('content')
<div class="content-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-book"></i> {{ __('admin.documentaries') }}</h2>
                <p class="text-muted">Manage documentary films and educational content</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="addContent()">
                    <i class="fas fa-plus"></i> Add Documentary
                </button>
                <button class="btn btn-success" onclick="importContent()">
                    <i class="fas fa-upload"></i> Import
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-content">
                    <h3>156</h3>
                    <p>Total Documentaries</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stats-content">
                    <h3>89.2K</h3>
                    <p>Total Views</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stats-content">
                    <h3>4.6</h3>
                    <p>Average Rating</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>345h</h3>
                    <p>Total Duration</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <div class="content-card">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=400&fit=crop" alt="Nature Documentary">
                <div class="duration-badge">95 min</div>
            </div>
            <div class="content-info">
                <h5>Planet Earth III</h5>
                <p class="category">Nature & Wildlife</p>
                <div class="rating">
                    <i class="fas fa-star"></i> 4.8 (2.3K reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(1)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStats(1)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1446776877081-d282a0f896e2?w=300&h=400&fit=crop" alt="History Documentary">
                <div class="duration-badge">120 min</div>
            </div>
            <div class="content-info">
                <h5>Ancient Civilizations</h5>
                <p class="category">History & Culture</p>
                <div class="rating">
                    <i class="fas fa-star"></i> 4.5 (1.8K reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(2)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStats(2)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1484662020986-75935d2ebc66?w=300&h=400&fit=crop" alt="Science Documentary">
                <div class="duration-badge">85 min</div>
            </div>
            <div class="content-info">
                <h5>Cosmos: Possible Worlds</h5>
                <p class="category">Science & Technology</p>
                <div class="rating">
                    <i class="fas fa-star"></i> 4.9 (3.1K reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(3)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStats(3)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.content-management {
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

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.content-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.content-card:hover {
    transform: translateY(-5px);
}

.content-poster {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.content-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.duration-badge {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
}

.content-info {
    padding: 1.5rem;
}

.content-info h5 {
    margin: 0 0 0.5rem 0;
    color: #333;
    font-weight: 600;
}

.content-info .category {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 0.75rem 0;
}

.rating {
    color: #fbbf24;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.content-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

.content-actions .btn {
    flex: 1;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
}
</style>

<script>
function addContent() {
    alert('Opening new documentary form...');
}

function importContent() {
    alert('Opening import wizard...');
}

function editContent(id) {
    alert(`Editing documentary ID: ${id}`);
}

function viewStats(id) {
    alert(`Viewing stats for documentary ID: ${id}`);
}
</script>
@endsection