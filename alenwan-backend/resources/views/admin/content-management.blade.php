@extends('admin.layouts.app')

@section('title', 'Content Management')
@section('page-title', 'Content Management')

@section('content')
<div class="content-management">
    <!-- Quick Actions Bar -->
    <div class="quick-actions">
        <button class="action-btn primary" onclick="openUploadModal()">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Upload Content</span>
        </button>
        <button class="action-btn secondary" onclick="openBulkImport()">
            <i class="fas fa-file-import"></i>
            <span>Bulk Import</span>
        </button>
        <button class="action-btn success" onclick="openScheduler()">
            <i class="fas fa-calendar-plus"></i>
            <span>Schedule Release</span>
        </button>
        <button class="action-btn warning" onclick="openMetadataEditor()">
            <i class="fas fa-edit"></i>
            <span>Edit Metadata</span>
        </button>
        <button class="action-btn info" onclick="openAnalytics()">
            <i class="fas fa-chart-line"></i>
            <span>Analytics</span>
        </button>
    </div>

    <!-- Content Filters -->
    <div class="content-filters">
        <div class="filter-group">
            <select class="filter-select">
                <option>All Content Types</option>
                <option>Movies</option>
                <option>TV Series</option>
                <option>Documentaries</option>
                <option>Live Streams</option>
                <option>Sports</option>
            </select>
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option>All Genres</option>
                <option>Action</option>
                <option>Comedy</option>
                <option>Drama</option>
                <option>Horror</option>
                <option>Sci-Fi</option>
            </select>
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option>All Status</option>
                <option>Published</option>
                <option>Draft</option>
                <option>Scheduled</option>
                <option>Archived</option>
            </select>
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option>All Ratings</option>
                <option>G</option>
                <option>PG</option>
                <option>PG-13</option>
                <option>R</option>
                <option>NC-17</option>
            </select>
        </div>
        <div class="filter-group search-group">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search content..." class="search-input">
        </div>
    </div>

    <!-- View Toggle -->
    <div class="view-controls">
        <div class="view-toggle">
            <button class="view-btn active" data-view="grid">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="view-btn" data-view="list">
                <i class="fas fa-list"></i>
            </button>
            <button class="view-btn" data-view="kanban">
                <i class="fas fa-columns"></i>
            </button>
        </div>
        <div class="sort-controls">
            <select class="sort-select">
                <option>Latest Added</option>
                <option>Most Viewed</option>
                <option>Highest Rated</option>
                <option>Revenue</option>
                <option>Title (A-Z)</option>
            </select>
        </div>
    </div>

    <!-- Content Grid View -->
    <div class="content-grid" id="gridView">
        <!-- Movie Card -->
        <div class="content-card movie">
            <div class="card-media">
                <img src="https://via.placeholder.com/300x450" alt="The Dark Knight">
                <div class="card-overlay">
                    <button class="play-btn"><i class="fas fa-play"></i></button>
                </div>
                <div class="card-badges">
                    <span class="badge-4k">4K</span>
                    <span class="badge-hdr">HDR</span>
                    <span class="badge-new">NEW</span>
                </div>
                <div class="card-rating">
                    <i class="fas fa-star"></i> 9.0
                </div>
            </div>
            <div class="card-content">
                <h4>The Dark Knight</h4>
                <p class="card-meta">2008 • 2h 32m • Action, Drama</p>
                <div class="card-stats">
                    <span><i class="fas fa-eye"></i> 245.8K</span>
                    <span><i class="fas fa-heart"></i> 189.2K</span>
                    <span><i class="fas fa-download"></i> 45.6K</span>
                </div>
                <div class="card-actions">
                    <button class="btn-icon" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon" title="Analytics">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                    <button class="btn-icon" title="Preview">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" title="More">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="card-status published">
                <span class="status-dot"></span> Published
            </div>
        </div>

        <!-- Series Card -->
        <div class="content-card series">
            <div class="card-media">
                <img src="https://via.placeholder.com/300x450" alt="Breaking Bad">
                <div class="card-overlay">
                    <button class="play-btn"><i class="fas fa-play"></i></button>
                </div>
                <div class="card-badges">
                    <span class="badge-seasons">5 Seasons</span>
                    <span class="badge-episodes">62 Episodes</span>
                </div>
                <div class="card-rating">
                    <i class="fas fa-star"></i> 9.5
                </div>
            </div>
            <div class="card-content">
                <h4>Breaking Bad</h4>
                <p class="card-meta">2008-2013 • Drama, Crime</p>
                <div class="card-stats">
                    <span><i class="fas fa-eye"></i> 523.4K</span>
                    <span><i class="fas fa-heart"></i> 412.8K</span>
                    <span><i class="fas fa-download"></i> 98.3K</span>
                </div>
                <div class="card-actions">
                    <button class="btn-icon" title="Manage Episodes">
                        <i class="fas fa-list-ul"></i>
                    </button>
                    <button class="btn-icon" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon" title="Analytics">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                    <button class="btn-icon" title="More">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="card-status published">
                <span class="status-dot"></span> Published
            </div>
        </div>

        <!-- Live Stream Card -->
        <div class="content-card live">
            <div class="card-media">
                <img src="https://via.placeholder.com/300x450" alt="CNN Live">
                <div class="card-overlay">
                    <button class="play-btn"><i class="fas fa-broadcast-tower"></i></button>
                </div>
                <div class="card-badges">
                    <span class="badge-live pulse">LIVE</span>
                    <span class="badge-viewers">12.3K watching</span>
                </div>
            </div>
            <div class="card-content">
                <h4>CNN International</h4>
                <p class="card-meta">24/7 News Channel</p>
                <div class="card-stats">
                    <span><i class="fas fa-users"></i> 12.3K</span>
                    <span><i class="fas fa-signal"></i> HD</span>
                    <span><i class="fas fa-globe"></i> Global</span>
                </div>
                <div class="card-actions">
                    <button class="btn-icon" title="Stream Settings">
                        <i class="fas fa-cog"></i>
                    </button>
                    <button class="btn-icon" title="Analytics">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                    <button class="btn-icon" title="Monitor">
                        <i class="fas fa-desktop"></i>
                    </button>
                    <button class="btn-icon" title="More">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="card-status streaming">
                <span class="status-dot pulse"></span> Streaming
            </div>
        </div>

        <!-- Scheduled Content -->
        <div class="content-card scheduled">
            <div class="card-media">
                <img src="https://via.placeholder.com/300x450" alt="Upcoming Movie">
                <div class="card-overlay">
                    <div class="countdown">
                        <i class="fas fa-clock"></i>
                        <span>Releases in 2 days</span>
                    </div>
                </div>
                <div class="card-badges">
                    <span class="badge-upcoming">UPCOMING</span>
                </div>
            </div>
            <div class="card-content">
                <h4>Dune: Part Two</h4>
                <p class="card-meta">2024 • Sci-Fi, Adventure</p>
                <div class="card-stats">
                    <span><i class="fas fa-calendar"></i> Mar 1, 2024</span>
                    <span><i class="fas fa-clock"></i> 12:00 AM</span>
                </div>
                <div class="card-actions">
                    <button class="btn-icon" title="Edit Schedule">
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                    <button class="btn-icon" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon" title="Preview">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" title="More">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="card-status scheduled">
                <span class="status-dot"></span> Scheduled
            </div>
        </div>
    </div>

    <!-- Kanban View (Hidden by default) -->
    <div class="kanban-view" id="kanbanView" style="display: none;">
        <div class="kanban-column">
            <div class="kanban-header">
                <h3>Draft</h3>
                <span class="count">8</span>
            </div>
            <div class="kanban-items" data-status="draft">
                <div class="kanban-item" draggable="true">
                    <img src="https://via.placeholder.com/60x90" alt="">
                    <div class="item-content">
                        <h5>Inception</h5>
                        <p>Sci-Fi • 2010</p>
                        <div class="item-badges">
                            <span class="badge-4k">4K</span>
                            <span class="badge-hdr">HDR</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kanban-column">
            <div class="kanban-header">
                <h3>In Review</h3>
                <span class="count">12</span>
            </div>
            <div class="kanban-items" data-status="review">
                <!-- Kanban items here -->
            </div>
        </div>
        <div class="kanban-column">
            <div class="kanban-header">
                <h3>Scheduled</h3>
                <span class="count">5</span>
            </div>
            <div class="kanban-items" data-status="scheduled">
                <!-- Kanban items here -->
            </div>
        </div>
        <div class="kanban-column">
            <div class="kanban-header">
                <h3>Published</h3>
                <span class="count">156</span>
            </div>
            <div class="kanban-items" data-status="published">
                <!-- Kanban items here -->
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal-overlay" id="uploadModal">
        <div class="modal-content large">
            <div class="modal-header">
                <h3>Upload New Content</h3>
                <button class="close-btn" onclick="closeModal('uploadModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="upload-area" id="dropZone">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Drag & Drop files here</h4>
                <p>or click to browse</p>
                <button class="browse-btn">Choose Files</button>
                <input type="file" id="fileInput" multiple hidden>
            </div>
            <div class="upload-progress" style="display: none;">
                <div class="progress-item">
                    <div class="progress-info">
                        <span class="file-name">movie.mp4</span>
                        <span class="file-size">1.2 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 65%;"></div>
                    </div>
                    <span class="progress-percent">65%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-management {
    padding: 2rem;
    background: #000000;
    min-height: 100vh;
}

/* Quick Actions Bar */
.quick-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    color: white;
}

.action-btn i {
    font-size: 1.1rem;
}

.action-btn.primary {
    background: linear-gradient(135deg, #A20136, #8b0000);
}

.action-btn.secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

.action-btn.success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.action-btn.warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.action-btn.info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
}

/* Content Filters */
.content-filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    background: #141414;
    padding: 1.5rem;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.filter-select {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.filter-select:hover,
.filter-select:focus {
    background: rgba(162, 1, 54, 0.1);
    border-color: #A20136;
    outline: none;
}

.search-group {
    flex: 1;
    position: relative;
    min-width: 250px;
}

.search-group i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.5);
}

.search-input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border-radius: 10px;
    transition: all 0.3s;
}

.search-input:focus {
    background: rgba(162, 1, 54, 0.1);
    border-color: #A20136;
    outline: none;
}

/* View Controls */
.view-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
    background: #141414;
    padding: 0.5rem;
    border-radius: 10px;
}

.view-btn {
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.view-btn.active,
.view-btn:hover {
    background: #A20136;
    color: white;
}

.sort-select {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
}

.content-card {
    background: #141414;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(162, 1, 54, 0.3);
}

.card-media {
    position: relative;
    padding-bottom: 150%;
    overflow: hidden;
}

.card-media img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.content-card:hover .card-overlay {
    opacity: 1;
}

.play-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(162, 1, 54, 0.9);
    border: 3px solid white;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s;
}

.play-btn:hover {
    transform: scale(1.1);
    background: #A20136;
}

.card-badges {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.card-badges span {
    padding: 0.25rem 0.5rem;
    background: rgba(0, 0, 0, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
}

.badge-4k {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.badge-hdr {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.badge-new {
    background: linear-gradient(135deg, #10b981, #059669);
}

.badge-live {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    animation: pulse 2s infinite;
}

.card-rating {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.8);
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    color: #f59e0b;
    font-weight: 600;
}

.card-content {
    padding: 1rem;
}

.card-content h4 {
    color: white;
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
}

.card-meta {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    margin: 0 0 1rem 0;
}

.card-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.card-stats span {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.85rem;
}

.card-stats i {
    margin-right: 0.25rem;
    color: #A20136;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-icon:hover {
    background: #A20136;
    color: white;
    border-color: #A20136;
}

.card-status {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    background: rgba(0, 0, 0, 0.8);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
}

.card-status.published .status-dot {
    background: #10b981;
}

.card-status.streaming .status-dot {
    background: #ef4444;
    animation: pulse 2s infinite;
}

.card-status.scheduled .status-dot {
    background: #f59e0b;
}

/* Kanban View */
.kanban-view {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.kanban-column {
    background: #141414;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    overflow: hidden;
}

.kanban-header {
    padding: 1rem;
    background: linear-gradient(135deg, rgba(162, 1, 54, 0.2), rgba(139, 0, 0, 0.2));
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.kanban-header h3 {
    color: white;
    margin: 0;
    font-size: 1rem;
}

.kanban-header .count {
    background: #A20136;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
}

.kanban-items {
    padding: 1rem;
    min-height: 400px;
}

.kanban-item {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 0.75rem;
    margin-bottom: 0.75rem;
    cursor: move;
    transition: all 0.3s;
    display: flex;
    gap: 0.75rem;
}

.kanban-item:hover {
    background: rgba(162, 1, 54, 0.1);
    transform: translateX(5px);
}

.kanban-item img {
    width: 60px;
    height: 90px;
    object-fit: cover;
    border-radius: 6px;
}

.item-content h5 {
    color: white;
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.item-content p {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0 0.5rem 0;
    font-size: 0.75rem;
}

.item-badges {
    display: flex;
    gap: 0.25rem;
}

.item-badges span {
    padding: 0.15rem 0.35rem;
    background: rgba(162, 1, 54, 0.2);
    border: 1px solid rgba(162, 1, 54, 0.3);
    border-radius: 4px;
    font-size: 0.65rem;
    color: #ff69b4;
}

/* Upload Modal */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-overlay.show {
    display: flex;
}

.modal-content {
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow: auto;
}

.modal-content.large {
    max-width: 800px;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    color: white;
    margin: 0;
}

.close-btn {
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.3s;
}

.close-btn:hover {
    color: white;
}

.upload-area {
    padding: 3rem;
    text-align: center;
    border: 2px dashed rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    margin: 1.5rem;
    transition: all 0.3s;
}

.upload-area.dragover {
    border-color: #A20136;
    background: rgba(162, 1, 54, 0.1);
}

.upload-area i {
    font-size: 4rem;
    color: #A20136;
    margin-bottom: 1rem;
}

.upload-area h4 {
    color: white;
    margin: 0 0 0.5rem 0;
}

.upload-area p {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0 1.5rem 0;
}

.browse-btn {
    background: linear-gradient(135deg, #A20136, #8b0000);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.browse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(162, 1, 54, 0.3);
}

/* Animations */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
    }
}

/* Responsive */
@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .kanban-view {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    .kanban-view {
        grid-template-columns: 1fr;
    }

    .quick-actions {
        flex-direction: column;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// View Toggle
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const view = this.dataset.view;
        document.getElementById('gridView').style.display = view === 'grid' ? 'grid' : 'none';
        document.getElementById('kanbanView').style.display = view === 'kanban' ? 'grid' : 'none';
    });
});

// Drag and Drop for Upload
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    handleFiles(files);
});

dropZone.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    console.log('Files to upload:', files);
    // Show progress bars
    document.querySelector('.upload-progress').style.display = 'block';
}

// Kanban Drag and Drop
let draggedItem = null;

document.querySelectorAll('.kanban-item').forEach(item => {
    item.addEventListener('dragstart', function() {
        draggedItem = this;
        this.style.opacity = '0.5';
    });

    item.addEventListener('dragend', function() {
        this.style.opacity = '';
        draggedItem = null;
    });
});

document.querySelectorAll('.kanban-items').forEach(column => {
    column.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    column.addEventListener('drop', function(e) {
        e.preventDefault();
        if (draggedItem) {
            this.appendChild(draggedItem);
        }
    });
});

// Modal Functions
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

function openBulkImport() {
    alert('Bulk Import feature coming soon!');
}

function openScheduler() {
    alert('Schedule Release feature coming soon!');
}

function openMetadataEditor() {
    alert('Metadata Editor feature coming soon!');
}

function openAnalytics() {
    window.location.href = '{{ route("admin.analytics") }}';
}
</script>
@endsection