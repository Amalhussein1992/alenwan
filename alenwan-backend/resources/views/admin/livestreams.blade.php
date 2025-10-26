@extends('admin.layouts.app')

@section('title', 'Live Streams Management')

@section('content')
<div class="livestreams-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-broadcast-tower"></i> {{ __('admin.livestreams') }}</h2>
                <p class="text-muted">Manage live streaming channels and broadcasts</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-danger" onclick="startLiveStream()">
                    <i class="fas fa-video"></i> Go Live Now
                </button>
                <button class="btn btn-primary" onclick="createSchedule()">
                    <i class="fas fa-calendar-plus"></i> Schedule Stream
                </button>
            </div>
        </div>
    </div>

    <!-- Live Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card live-stat">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="stats-content">
                    <h3>12</h3>
                    <p>Live Now</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>45.8K</h3>
                    <p>Current Viewers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>8</h3>
                    <p>Scheduled Today</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-server"></i>
                </div>
                <div class="stats-content">
                    <h3>99.9%</h3>
                    <p>Server Uptime</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Streams Grid -->
    <div class="streams-grid">
        <div class="stream-card live">
            <div class="stream-thumbnail">
                <img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=400&h=225&fit=crop" alt="Live Stream">
                <div class="live-indicator">🔴 LIVE</div>
                <div class="viewer-count">12.5K</div>
                <div class="stream-duration">02:45:30</div>
            </div>
            <div class="stream-info">
                <h5>Breaking News Coverage</h5>
                <p class="stream-description">Live coverage of major news events with expert analysis</p>
                <div class="stream-meta">
                    <span class="category-badge news">📺 News</span>
                    <span class="quality-badge">HD</span>
                </div>
            </div>
            <div class="stream-actions">
                <button class="btn btn-sm btn-danger" onclick="stopStream(1)">
                    <i class="fas fa-stop"></i> Stop
                </button>
                <button class="btn btn-sm btn-outline-primary" onclick="streamSettings(1)">
                    <i class="fas fa-cog"></i> Settings
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewAnalytics(1)">
                    <i class="fas fa-chart-line"></i> Analytics
                </button>
            </div>
        </div>

        <div class="stream-card scheduled">
            <div class="stream-thumbnail">
                <img src="https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=400&h=225&fit=crop" alt="Scheduled Stream">
                <div class="scheduled-indicator">⏰ SCHEDULED</div>
                <div class="start-time">Starts in 2h 15m</div>
            </div>
            <div class="stream-info">
                <h5>Tech Talk with Experts</h5>
                <p class="stream-description">Weekly technology discussion with industry leaders</p>
                <div class="stream-meta">
                    <span class="category-badge tech">💻 Technology</span>
                    <span class="quality-badge">4K</span>
                </div>
            </div>
            <div class="stream-actions">
                <button class="btn btn-sm btn-success" onclick="startEarly(2)">
                    <i class="fas fa-play"></i> Start Early
                </button>
                <button class="btn btn-sm btn-outline-primary" onclick="editSchedule(2)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="cancelStream(2)">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>

        <div class="stream-card ended">
            <div class="stream-thumbnail">
                <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=400&h=225&fit=crop" alt="Ended Stream">
                <div class="ended-indicator">⏹️ ENDED</div>
                <div class="final-stats">2h 35m • 8.9K peak</div>
            </div>
            <div class="stream-info">
                <h5>Gaming Championship Finals</h5>
                <p class="stream-description">Epic gaming tournament with top players competing</p>
                <div class="stream-meta">
                    <span class="category-badge gaming">🎮 Gaming</span>
                    <span class="quality-badge">HD</span>
                </div>
            </div>
            <div class="stream-actions">
                <button class="btn btn-sm btn-primary" onclick="createHighlights(3)">
                    <i class="fas fa-cut"></i> Highlights
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewReplay(3)">
                    <i class="fas fa-redo"></i> Replay
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="downloadRecording(3)">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.livestreams-management {
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

.stats-card.live-stat {
    animation: pulse-glow 2s infinite;
}

@keyframes pulse-glow {
    0% { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    50% { box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3); }
    100% { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
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

.streams-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stream-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.stream-card:hover {
    transform: translateY(-5px);
}

.stream-card.live {
    border: 2px solid #ef4444;
    animation: live-glow 3s infinite;
}

@keyframes live-glow {
    0% { box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2); }
    50% { box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4); }
    100% { box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2); }
}

.stream-card.scheduled {
    border: 2px solid #f59e0b;
}

.stream-card.ended {
    border: 2px solid #6b7280;
    opacity: 0.85;
}

.stream-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.stream-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.live-indicator {
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

.scheduled-indicator {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #f59e0b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.ended-indicator {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #6b7280;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.viewer-count, .start-time, .final-stats {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
}

.stream-duration {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
}

.stream-info {
    padding: 1.5rem;
}

.stream-info h5 {
    margin: 0 0 0.5rem 0;
    color: #333;
    font-weight: 600;
}

.stream-description {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.stream-meta {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.category-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.category-badge.news {
    background: #dbeafe;
    color: #1e40af;
}

.category-badge.tech {
    background: #ecfdf5;
    color: #059669;
}

.category-badge.gaming {
    background: #fef3c7;
    color: #92400e;
}

.quality-badge {
    padding: 0.25rem 0.5rem;
    background: #f3f4f6;
    color: #374151;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: bold;
}

.stream-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.25rem;
}

.stream-actions .btn {
    flex: 1;
    border-radius: 8px;
    font-size: 0.8rem;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .streams-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
}
</style>

<script>
function startLiveStream() {
    alert('Starting new live stream...');
}

function createSchedule() {
    alert('Creating scheduled stream...');
}

function stopStream(id) {
    if (confirm('Stop this live stream? All viewers will be disconnected.')) {
        alert(`Live stream ${id} stopped`);
    }
}

function startEarly(id) {
    if (confirm('Start this scheduled stream now?')) {
        alert(`Stream ${id} started early`);
    }
}

function streamSettings(id) {
    alert(`Opening stream settings for ID: ${id}`);
}

function viewAnalytics(id) {
    alert(`Viewing analytics for stream ID: ${id}`);
}

function editSchedule(id) {
    alert(`Editing schedule for stream ID: ${id}`);
}

function cancelStream(id) {
    if (confirm('Cancel this scheduled stream?')) {
        alert(`Scheduled stream ${id} cancelled`);
    }
}

function createHighlights(id) {
    alert(`Creating highlights for stream ID: ${id}`);
}

function viewReplay(id) {
    alert(`Opening replay for stream ID: ${id}`);
}

function downloadRecording(id) {
    alert(`Downloading recording for stream ID: ${id}`);
}
</script>
@endsection