@extends('admin.layouts.app')

@section('title', 'Series Management')

@section('content')
<div class="series-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-tv"></i> {{ __('admin.series') }}</h2>
                <p class="text-muted">Manage TV series, seasons, and episodes</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="addNewSeries()">
                    <i class="fas fa-plus"></i> Add New Series
                </button>
                <button class="btn btn-success" onclick="importSeries()">
                    <i class="fas fa-upload"></i> Import
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-tv"></i>
                </div>
                <div class="stats-content">
                    <h3>340</h3>
                    <p>Total Series</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stats-content">
                    <h3>2,890</h3>
                    <p>Total Seasons</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stats-content">
                    <h3>18,560</h3>
                    <p>Total Episodes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>45</h3>
                    <p>Ongoing Series</p>
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
                    <input type="text" id="seriesSearch" placeholder="Search series..." class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="genreFilter">
                    <option value="">All Genres</option>
                    <option value="drama">Drama</option>
                    <option value="comedy">Comedy</option>
                    <option value="action">Action</option>
                    <option value="thriller">Thriller</option>
                    <option value="sci-fi">Sci-Fi</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="created_desc">Newest First</option>
                    <option value="created_asc">Oldest First</option>
                    <option value="title_asc">Title A-Z</option>
                    <option value="rating_desc">Highest Rated</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Series Grid -->
    <div class="series-grid" id="seriesGrid">
        <!-- Series Card 1 -->
        <div class="series-card" data-status="ongoing" data-genre="drama">
            <div class="series-poster">
                <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=300&h=400&fit=crop" alt="Breaking Bad">
                <div class="series-status ongoing">Ongoing</div>
                <div class="episode-count">5 Seasons • 62 Episodes</div>
            </div>
            <div class="series-info">
                <h5>Breaking Bad</h5>
                <p class="series-description">A high school chemistry teacher turned methamphetamine manufacturer...</p>
                <div class="series-meta">
                    <span class="genre-badge drama">Drama</span>
                    <div class="rating">
                        <i class="fas fa-star"></i> 9.5
                    </div>
                </div>
                <div class="series-progress">
                    <div class="progress-info">
                        <small>Season 5 - Episode 8</small>
                        <small>Next: May 15, 2024</small>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" style="width: 85%;"></div>
                    </div>
                </div>
            </div>
            <div class="series-actions">
                <button class="btn btn-sm btn-primary" onclick="manageSeries(1)">
                    <i class="fas fa-cog"></i> Manage
                </button>
                <button class="btn btn-sm btn-success" onclick="addEpisode(1)">
                    <i class="fas fa-plus"></i> Episode
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewAnalytics(1)">
                    <i class="fas fa-chart-bar"></i>
                </button>
            </div>
        </div>

        <!-- Series Card 2 -->
        <div class="series-card" data-status="completed" data-genre="comedy">
            <div class="series-poster">
                <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=300&h=400&fit=crop" alt="The Office">
                <div class="series-status completed">Completed</div>
                <div class="episode-count">9 Seasons • 201 Episodes</div>
            </div>
            <div class="series-info">
                <h5>The Office</h5>
                <p class="series-description">A mockumentary sitcom about office employees in Scranton, Pennsylvania...</p>
                <div class="series-meta">
                    <span class="genre-badge comedy">Comedy</span>
                    <div class="rating">
                        <i class="fas fa-star"></i> 8.7
                    </div>
                </div>
                <div class="series-completion">
                    <small class="text-success">✓ Series Complete</small>
                    <small>Ended: May 16, 2013</small>
                </div>
            </div>
            <div class="series-actions">
                <button class="btn btn-sm btn-primary" onclick="manageSeries(2)">
                    <i class="fas fa-cog"></i> Manage
                </button>
                <button class="btn btn-sm btn-info" onclick="viewSeries(2)">
                    <i class="fas fa-eye"></i> View
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewAnalytics(2)">
                    <i class="fas fa-chart-bar"></i>
                </button>
            </div>
        </div>

        <!-- Series Card 3 -->
        <div class="series-card" data-status="ongoing" data-genre="action">
            <div class="series-poster">
                <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=300&h=400&fit=crop" alt="Stranger Things">
                <div class="series-status ongoing">Ongoing</div>
                <div class="episode-count">4 Seasons • 34 Episodes</div>
            </div>
            <div class="series-info">
                <h5>Stranger Things</h5>
                <p class="series-description">A group of kids in 1980s Indiana face supernatural mysteries...</p>
                <div class="series-meta">
                    <span class="genre-badge action">Action</span>
                    <div class="rating">
                        <i class="fas fa-star"></i> 8.9
                    </div>
                </div>
                <div class="series-progress">
                    <div class="progress-info">
                        <small>Season 4 - Complete</small>
                        <small>Season 5 in production</small>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" style="width: 90%;"></div>
                    </div>
                </div>
            </div>
            <div class="series-actions">
                <button class="btn btn-sm btn-primary" onclick="manageSeries(3)">
                    <i class="fas fa-cog"></i> Manage
                </button>
                <button class="btn btn-sm btn-success" onclick="addEpisode(3)">
                    <i class="fas fa-plus"></i> Episode
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="viewAnalytics(3)">
                    <i class="fas fa-chart-bar"></i>
                </button>
            </div>
        </div>

        <!-- Series Card 4 -->
        <div class="series-card" data-status="draft" data-genre="thriller">
            <div class="series-poster">
                <img src="https://images.unsplash.com/photo-1489599004687-2e76e8a80b78?w=300&h=400&fit=crop" alt="New Series">
                <div class="series-status draft">Draft</div>
                <div class="episode-count">0 Seasons • 0 Episodes</div>
            </div>
            <div class="series-info">
                <h5>Dark Mysteries</h5>
                <p class="series-description">A psychological thriller series about unsolved cases...</p>
                <div class="series-meta">
                    <span class="genre-badge thriller">Thriller</span>
                    <div class="rating">
                        <i class="fas fa-star-o"></i> Not Rated
                    </div>
                </div>
                <div class="series-draft">
                    <small class="text-warning">⚠ In Development</small>
                    <small>Created: May 01, 2024</small>
                </div>
            </div>
            <div class="series-actions">
                <button class="btn btn-sm btn-success" onclick="continueDraft(4)">
                    <i class="fas fa-edit"></i> Continue
                </button>
                <button class="btn btn-sm btn-primary" onclick="publishSeries(4)">
                    <i class="fas fa-upload"></i> Publish
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteDraft(4)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        <nav aria-label="Series pagination">
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
.series-management {
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

.series-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.series-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.series-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.series-poster {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.series-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.series-card:hover .series-poster img {
    transform: scale(1.05);
}

.series-status {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.series-status.ongoing {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.series-status.completed {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.series-status.cancelled {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.series-status.draft {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.episode-count {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
}

.series-info {
    padding: 1.5rem;
}

.series-info h5 {
    margin: 0 0 0.5rem 0;
    color: #333;
    font-weight: 600;
}

.series-description {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.series-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.genre-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.genre-badge.drama {
    background: #fef3c7;
    color: #92400e;
}

.genre-badge.comedy {
    background: #dcfce7;
    color: #166534;
}

.genre-badge.action {
    background: #fecaca;
    color: #991b1b;
}

.genre-badge.thriller {
    background: #e0e7ff;
    color: #3730a3;
}

.rating {
    color: #fbbf24;
    font-weight: bold;
}

.series-progress, .series-completion, .series-draft {
    margin-bottom: 1rem;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.progress-info small {
    color: #666;
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

.series-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

.series-actions .btn {
    flex: 1;
    border-radius: 8px;
    font-size: 0.8rem;
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
    .series-grid {
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
document.getElementById('seriesSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const seriesCards = document.querySelectorAll('.series-card');

    seriesCards.forEach(card => {
        const seriesTitle = card.querySelector('h5').textContent.toLowerCase();
        const seriesDescription = card.querySelector('.series-description').textContent.toLowerCase();

        if (seriesTitle.includes(searchTerm) || seriesDescription.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filter functionality
document.getElementById('statusFilter').addEventListener('change', function() {
    filterSeries();
});

document.getElementById('genreFilter').addEventListener('change', function() {
    filterSeries();
});

function filterSeries() {
    const statusFilter = document.getElementById('statusFilter').value;
    const genreFilter = document.getElementById('genreFilter').value;
    const seriesCards = document.querySelectorAll('.series-card');

    seriesCards.forEach(card => {
        const seriesStatus = card.getAttribute('data-status');
        const seriesGenre = card.getAttribute('data-genre');

        let showCard = true;

        if (statusFilter && seriesStatus !== statusFilter) {
            showCard = false;
        }

        if (genreFilter && seriesGenre !== genreFilter) {
            showCard = false;
        }

        card.style.display = showCard ? 'block' : 'none';
    });
}

// Clear filters
function clearFilters() {
    document.getElementById('seriesSearch').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('genreFilter').value = '';
    document.getElementById('sortBy').value = 'created_desc';

    document.querySelectorAll('.series-card').forEach(card => {
        card.style.display = 'block';
    });
}

// Series action functions
function addNewSeries() {
    alert('Opening new series creation form...');
}

function importSeries() {
    alert('Opening series import wizard...');
}

function manageSeries(id) {
    alert(`Opening series management for ID: ${id}`);
}

function addEpisode(id) {
    alert(`Adding new episode to series ID: ${id}`);
}

function viewSeries(id) {
    alert(`Viewing series details for ID: ${id}`);
}

function viewAnalytics(id) {
    alert(`Viewing analytics for series ID: ${id}`);
}

function continueDraft(id) {
    alert(`Continuing draft series ID: ${id}`);
}

function publishSeries(id) {
    if (confirm('Are you sure you want to publish this series?')) {
        alert(`Series ${id} has been published`);
    }
}

function deleteDraft(id) {
    if (confirm('Are you sure you want to delete this draft? This action cannot be undone.')) {
        alert(`Draft series ${id} has been deleted`);
    }
}
</script>
@endsection