@extends('admin.layouts.app')

@section('title', 'Cartoons Management')

@section('content')
<div class="content-management">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-child"></i> {{ __('admin.cartoons') }}</h2>
                <p class="text-muted">Manage animated content and kids' entertainment</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="addContent()">
                    <i class="fas fa-plus"></i> Add Cartoon
                </button>
                <button class="btn btn-warning" onclick="manageParentalControls()">
                    <i class="fas fa-shield-alt"></i> Parental Controls
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-film"></i>
                </div>
                <div class="stats-content">
                    <h3>234</h3>
                    <p>Total Cartoons</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3>45.6K</h3>
                    <p>Kid Viewers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3>2.5h</h3>
                    <p>Avg. Watch Time</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stats-content">
                    <h3>4.8</h3>
                    <p>Parent Rating</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Age Group Filter -->
    <div class="filters-section mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="age-filter-buttons">
                    <button class="btn btn-outline-primary active" data-age="all">All Ages</button>
                    <button class="btn btn-outline-primary" data-age="0-3">0-3 Years</button>
                    <button class="btn btn-outline-primary" data-age="4-7">4-7 Years</button>
                    <button class="btn btn-outline-primary" data-age="8-12">8-12 Years</button>
                    <button class="btn btn-outline-primary" data-age="13+">13+ Years</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartoons Content Grid -->
    <div class="content-grid">
        <div class="content-card" data-age="4-7">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=300&h=400&fit=crop" alt="Kids Cartoon">
                <div class="age-badge">4-7</div>
                <div class="episodes-count">52 episodes</div>
            </div>
            <div class="content-info">
                <h5>Adventures in Learning</h5>
                <p class="category">🎨 Educational</p>
                <div class="content-tags">
                    <span class="tag educational">Educational</span>
                    <span class="tag safe">Safe Content</span>
                </div>
                <div class="rating">
                    <i class="fas fa-heart"></i> 4.9 (Parent Reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(1)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewParentalInfo(1)">
                    <i class="fas fa-info-circle"></i> Info
                </button>
            </div>
        </div>

        <div class="content-card" data-age="8-12">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1607736854138-ca7b6b7d1503?w=300&h=400&fit=crop" alt="Adventure Cartoon">
                <div class="age-badge">8-12</div>
                <div class="episodes-count">24 episodes</div>
            </div>
            <div class="content-info">
                <h5>Space Rangers Academy</h5>
                <p class="category">🚀 Adventure</p>
                <div class="content-tags">
                    <span class="tag adventure">Adventure</span>
                    <span class="tag science">Science</span>
                </div>
                <div class="rating">
                    <i class="fas fa-heart"></i> 4.7 (Parent Reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(2)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewParentalInfo(2)">
                    <i class="fas fa-info-circle"></i> Info
                </button>
            </div>
        </div>

        <div class="content-card" data-age="0-3">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1589934390308-afa2d20dd3c5?w=300&h=400&fit=crop" alt="Baby Cartoon">
                <div class="age-badge">0-3</div>
                <div class="episodes-count">30 episodes</div>
            </div>
            <div class="content-info">
                <h5>Baby's First Words</h5>
                <p class="category">👶 Toddler</p>
                <div class="content-tags">
                    <span class="tag toddler">Toddler</span>
                    <span class="tag learning">Learning</span>
                </div>
                <div class="rating">
                    <i class="fas fa-heart"></i> 4.8 (Parent Reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(3)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewParentalInfo(3)">
                    <i class="fas fa-info-circle"></i> Info
                </button>
            </div>
        </div>

        <div class="content-card" data-age="13+">
            <div class="content-poster">
                <img src="https://images.unsplash.com/photo-1607214308955-7787b818819e?w=300&h=400&fit=crop" alt="Teen Cartoon">
                <div class="age-badge">13+</div>
                <div class="episodes-count">18 episodes</div>
            </div>
            <div class="content-info">
                <h5>Teen Heroes United</h5>
                <p class="category">⚡ Action</p>
                <div class="content-tags">
                    <span class="tag action">Action</span>
                    <span class="tag teen">Teen</span>
                </div>
                <div class="rating">
                    <i class="fas fa-heart"></i> 4.6 (Parent Reviews)
                </div>
            </div>
            <div class="content-actions">
                <button class="btn btn-sm btn-primary" onclick="editContent(4)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="viewParentalInfo(4)">
                    <i class="fas fa-info-circle"></i> Info
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

.filters-section {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.age-filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.age-filter-buttons .btn {
    border-radius: 25px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.age-filter-buttons .btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.content-card {
    background: white;
    border-radius: 20px;
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
    filter: saturate(1.1) brightness(1.1);
}

.age-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.episodes-count {
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

.content-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.tag {
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
}

.tag.educational {
    background: #dbeafe;
    color: #1e40af;
}

.tag.safe {
    background: #dcfce7;
    color: #166534;
}

.tag.adventure {
    background: #fef3c7;
    color: #92400e;
}

.tag.science {
    background: #e0e7ff;
    color: #3730a3;
}

.tag.toddler {
    background: #fce7f3;
    color: #be185d;
}

.tag.learning {
    background: #ecfdf5;
    color: #059669;
}

.tag.action {
    background: #fecaca;
    color: #991b1b;
}

.tag.teen {
    background: #e0e7ff;
    color: #4338ca;
}

.rating {
    color: #ef4444;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.rating i {
    margin-right: 0.25rem;
}

.content-actions {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

.content-actions .btn {
    flex: 1;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .age-filter-buttons {
        justify-content: center;
    }
}
</style>

<script>
// Age filter functionality
document.querySelectorAll('.age-filter-buttons .btn').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.age-filter-buttons .btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        this.classList.add('active');

        // Get age filter
        const ageFilter = this.getAttribute('data-age');
        const contentCards = document.querySelectorAll('.content-card');

        contentCards.forEach(card => {
            if (ageFilter === 'all' || card.getAttribute('data-age') === ageFilter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

function addContent() {
    alert('Opening new cartoon creation form...');
}

function manageParentalControls() {
    alert('Opening parental controls settings...');
}

function editContent(id) {
    alert(`Editing cartoon content ID: ${id}`);
}

function viewParentalInfo(id) {
    alert(`Viewing parental information for content ID: ${id}`);
}
</script>
@endsection