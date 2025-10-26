@extends('admin.layouts.app')

@section('title', 'Sports Management')

@section('content')
<div class="content-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-football-ball"></i> {{ __('admin.sports') }}</h2>
                <p class="text-muted">Manage sports content, live events, and highlights</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="addContent()">
                    <i class="fas fa-plus"></i> Add Sports Content
                </button>
                <button class="btn btn-danger" onclick="goLive()">
                    <i class="fas fa-broadcast-tower"></i> Go Live
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-futbol"></i>
                </div>
                <div class="stats-content">
                    <h3>89</h3>
                    <p>Live Events</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-video"></i>
                </div>
                <div class="stats-content">
                    <h3>456</h3>
                    <p>Highlights</p>
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
                    <p>Live Viewers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stats-content">
                    <h3>12</h3>
                    <p>Scheduled Today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sports Content Grid -->
    <div class="content-grid">
        <div class="content-card live">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1459865264687-595d652de67e?w=300&h=200&fit=crop" alt="Football Match">
                <div class="live-badge">🔴 LIVE</div>
                <div class="viewer-count">45.2K viewers</div>
            </div>
            <div class="content-info">
                <h5>Champions League Final</h5>
                <p class="category">⚽ Football</p>
                <p class="match-info">Barcelona vs Real Madrid</p>
                <div class="time-info">
                    <i class="fas fa-clock"></i> Started 45 min ago
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-danger" onclick="stopLive(1)">
                    <i class="fas fa-stop"></i> Stop
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewLiveStats(1)">
                    <i class="fas fa-chart-bar"></i> Stats
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=300&h=200&fit=crop" alt="Basketball Game">
                <div class="duration-badge">2h 15m</div>
            </div>
            <div class="content-info">
                <h5>NBA Finals Game 7</h5>
                <p class="category">🏀 Basketball</p>
                <p class="match-info">Lakers vs Celtics</p>
                <div class="time-info">
                    <i class="fas fa-calendar"></i> Tomorrow 8:00 PM
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(2)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-success" onclick="startLive(2)">
                    <i class="fas fa-play"></i> Start
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=300&h=200&fit=crop" alt="Tennis Match">
                <div class="duration-badge">3h 42m</div>
            </div>
            <div class="content-info">
                <h5>Wimbledon Final</h5>
                <p class="category">🎾 Tennis</p>
                <p class="match-info">Djokovic vs Federer</p>
                <div class="time-info">
                    <i class="fas fa-clock"></i> Ended 2 hours ago
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
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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

.content-card.live {
    border: 2px solid #ef4444;
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3);
}

.content-poster {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.content-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.live-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.viewer-count {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
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
    margin: 0 0 0.5rem 0;
}

.match-info {
    color: #333;
    font-weight: 500;
    margin: 0 0 0.75rem 0;
}

.time-info {
    color: #888;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.time-info i {
    margin-right: 0.5rem;
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
    alert('Opening new sports content form...');
}

function goLive() {
    alert('Starting live broadcast...');
}

function editContent(id) {
    alert(`Editing sports content ID: ${id}`);
}

function viewStats(id) {
    alert(`Viewing stats for content ID: ${id}`);
}

function viewLiveStats(id) {
    alert(`Viewing live stats for content ID: ${id}`);
}

function startLive(id) {
    if (confirm('Start live broadcast for this event?')) {
        alert(`Live broadcast started for content ID: ${id}`);
    }
}

function stopLive(id) {
    if (confirm('Stop live broadcast? This will end the stream for all viewers.')) {
        alert(`Live broadcast stopped for content ID: ${id}`);
    }
}
</script>
@endsection