@extends('admin.layouts.app')

@section('title', __('admin.sports_management'))

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-football-ball me-2"></i>{{ __('admin.sports_management') }}
                    </h1>
                    <p class="text-muted">{{ __('admin.manage_live_sports_events') }}</p>
                </div>
                <div>
                    <button class="btn btn-outline-primary me-2" onclick="importSchedule()">
                        <i class="fas fa-file-import me-2"></i>{{ __('admin.import_schedule') }}
                    </button>
                    <a href="{{ route('admin.sports.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('admin.add_sport_event') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-alt text-primary fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('admin.total_events') }}</h6>
                            <h3 class="mb-0">156</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> {{ __('admin.this_week', ['count' => 12]) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded">
                            <i class="fas fa-broadcast-tower text-danger fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('admin.live_now') }}</h6>
                            <h3 class="mb-0">8</h3>
                            <div class="d-flex gap-1 mt-1">
                                <span class="badge bg-danger pulse">{{ __('admin.live') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock text-warning fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('admin.upcoming') }}</h6>
                            <h3 class="mb-0">24</h3>
                            <small class="text-muted">{{ __('admin.next_24_hours') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users text-success fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('admin.viewers') }}</h6>
                            <h3 class="mb-0">45.2K</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +5.2%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sport Categories Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#all-sports">
                <i class="fas fa-list me-2"></i>{{ __('admin.all_sports') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#football">
                <i class="fas fa-futbol me-2"></i>{{ __('admin.football') }}
                <span class="badge bg-primary ms-2">42</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#basketball">
                <i class="fas fa-basketball-ball me-2"></i>{{ __('admin.basketball') }}
                <span class="badge bg-primary ms-2">28</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tennis">
                <i class="fas fa-table-tennis me-2"></i>{{ __('admin.tennis') }}
                <span class="badge bg-primary ms-2">18</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cricket">
                <i class="fas fa-baseball-ball me-2"></i>{{ __('admin.cricket') }}
                <span class="badge bg-primary ms-2">15</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#boxing">
                <i class="fas fa-fist-raised me-2"></i>{{ __('admin.boxing') }}
                <span class="badge bg-primary ms-2">12</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#racing">
                <i class="fas fa-flag-checkered me-2"></i>{{ __('admin.racing') }}
                <span class="badge bg-primary ms-2">8</span>
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="all-sports">
            <!-- Live Events Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <span class="pulse-dot"></span>
                        {{ __('admin.live_events') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Live Event Card 1 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sport-event-card live-event">
                                <div class="event-header">
                                    <span class="badge bg-danger pulse">{{ __('admin.live') }}</span>
                                    <span class="sport-type"><i class="fas fa-futbol"></i> {{ __('admin.football') }}</span>
                                </div>
                                <div class="event-teams">
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/ef4444/ffffff?text=MU" alt="Team">
                                        <span>Manchester United</span>
                                    </div>
                                    <div class="score">
                                        <span class="score-display">2 - 1</span>
                                        <small class="text-muted">65'</small>
                                    </div>
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/3b82f6/ffffff?text=MC" alt="Team">
                                        <span>Manchester City</span>
                                    </div>
                                </div>
                                <div class="event-footer">
                                    <span class="viewers"><i class="fas fa-eye"></i> 12.5K {{ __('admin.watching') }}</span>
                                    <button class="btn btn-sm btn-danger">{{ __('admin.watch_now') }}</button>
                                </div>
                            </div>
                        </div>

                        <!-- Live Event Card 2 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sport-event-card live-event">
                                <div class="event-header">
                                    <span class="badge bg-danger pulse">LIVE</span>
                                    <span class="sport-type"><i class="fas fa-basketball-ball"></i> Basketball</span>
                                </div>
                                <div class="event-teams">
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/f59e0b/ffffff?text=LA" alt="Team">
                                        <span>LA Lakers</span>
                                    </div>
                                    <div class="score">
                                        <span class="score-display">88 - 92</span>
                                        <small class="text-muted">Q3</small>
                                    </div>
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/10b981/ffffff?text=BS" alt="Team">
                                        <span>Boston Celtics</span>
                                    </div>
                                </div>
                                <div class="event-footer">
                                    <span class="viewers"><i class="fas fa-eye"></i> 8.3K watching</span>
                                    <button class="btn btn-sm btn-danger">Watch Now</button>
                                </div>
                            </div>
                        </div>

                        <!-- Live Event Card 3 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sport-event-card live-event">
                                <div class="event-header">
                                    <span class="badge bg-danger pulse">LIVE</span>
                                    <span class="sport-type"><i class="fas fa-table-tennis"></i> Tennis</span>
                                </div>
                                <div class="event-teams">
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/8b5cf6/ffffff?text=ND" alt="Team">
                                        <span>N. Djokovic</span>
                                    </div>
                                    <div class="score">
                                        <span class="score-display">6-4, 5-3</span>
                                        <small class="text-muted">Set 2</small>
                                    </div>
                                    <div class="team">
                                        <img src="https://via.placeholder.com/40x40/06b6d4/ffffff?text=RF" alt="Team">
                                        <span>R. Federer</span>
                                    </div>
                                </div>
                                <div class="event-footer">
                                    <span class="viewers"><i class="fas fa-eye"></i> 5.7K watching</span>
                                    <button class="btn btn-sm btn-danger">Watch Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Upcoming Events
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Sport</th>
                                    <th>League/Tournament</th>
                                    <th>Date & Time</th>
                                    <th>Stream Source</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30x30/ef4444/ffffff?text=RM" class="rounded me-2" alt="Team">
                                            <span>Real Madrid vs Barcelona</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">Football</span></td>
                                    <td>La Liga</td>
                                    <td>Dec 10, 2024 - 20:00</td>
                                    <td><span class="badge bg-info">Vimeo Stream</span></td>
                                    <td><span class="badge bg-warning">Scheduled</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="editEvent(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="previewEvent(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteEvent(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30x30/3b82f6/ffffff?text=NY" class="rounded me-2" alt="Team">
                                            <span>NY Knicks vs Miami Heat</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">Basketball</span></td>
                                    <td>NBA</td>
                                    <td>Dec 10, 2024 - 22:30</td>
                                    <td><span class="badge bg-info">Vimeo Stream</span></td>
                                    <td><span class="badge bg-warning">Scheduled</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="editEvent(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="previewEvent(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteEvent(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30x30/10b981/ffffff?text=F1" class="rounded me-2" alt="Team">
                                            <span>Formula 1 - Abu Dhabi GP</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Racing</span></td>
                                    <td>Formula 1</td>
                                    <td>Dec 11, 2024 - 14:00</td>
                                    <td><span class="badge bg-info">Vimeo Stream</span></td>
                                    <td><span class="badge bg-warning">Scheduled</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="editEvent(3)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" onclick="previewEvent(3)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="deleteEvent(3)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Past Events -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Past Events (Replays Available)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @for($i = 1; $i <= 6; $i++)
                        <div class="col-md-6 col-lg-4">
                            <div class="past-event-card">
                                <div class="event-thumbnail position-relative">
                                    <img src="https://via.placeholder.com/400x225/{{ ['6366f1', 'ef4444', '10b981', 'f59e0b', '8b5cf6', '06b6d4'][($i-1) % 6] }}/ffffff?text=Match+{{ $i }}"
                                         class="img-fluid rounded" alt="Event">
                                    <div class="replay-badge">
                                        <i class="fas fa-play-circle"></i> Replay Available
                                    </div>
                                </div>
                                <div class="event-details mt-2">
                                    <h6>Championship Final {{ $i }}</h6>
                                    <p class="text-muted small mb-1">Dec {{ $i }}, 2024</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-secondary">{{ rand(1000, 9999) }} views</span>
                                        <button class="btn btn-sm btn-outline-primary">Watch Replay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Football Tab -->
        <div class="tab-pane fade" id="football">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Football Events</h5>
                    <p>Football specific content and matches...</p>
                </div>
            </div>
        </div>

        <!-- Basketball Tab -->
        <div class="tab-pane fade" id="basketball">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Basketball Events</h5>
                    <p>Basketball specific content and games...</p>
                </div>
            </div>
        </div>

        <!-- Other sport tabs... -->
    </div>
</div>

<!-- Create/Edit Event Modal -->
<div class="modal fade" id="sportEventModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-plus me-2"></i>Create Sport Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sportEventForm">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Event Details -->
                            <div class="card mb-3">
                                <div class="card-header">Event Information</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Event Title</label>
                                        <input type="text" class="form-control" placeholder="e.g., Real Madrid vs Barcelona">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sport Type</label>
                                            <select class="form-select">
                                                <option>Football</option>
                                                <option>Basketball</option>
                                                <option>Tennis</option>
                                                <option>Cricket</option>
                                                <option>Boxing</option>
                                                <option>Racing</option>
                                                <option>Golf</option>
                                                <option>Baseball</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">League/Tournament</label>
                                            <input type="text" class="form-control" placeholder="e.g., La Liga, NBA, Wimbledon">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Home Team/Player</label>
                                            <input type="text" class="form-control" placeholder="Team or player name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Away Team/Player</label>
                                            <input type="text" class="form-control" placeholder="Team or player name">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Event description..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Stream Settings -->
                            <div class="card">
                                <div class="card-header">Stream Configuration</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Stream Source</label>
                                        <select class="form-select" onchange="toggleStreamInput(this.value)">
                                            <option value="vimeo">Vimeo Live</option>
                                            <option value="youtube">YouTube Live</option>
                                            <option value="custom">Custom Stream URL</option>
                                            <option value="m3u8">M3U8 Stream</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Stream URL/ID</label>
                                        <input type="text" class="form-control" placeholder="Enter stream URL or ID">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Backup Stream URL</label>
                                            <input type="text" class="form-control" placeholder="Optional backup stream">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stream Quality</label>
                                            <select class="form-select">
                                                <option>Auto</option>
                                                <option>1080p</option>
                                                <option>720p</option>
                                                <option>480p</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Schedule -->
                            <div class="card mb-3">
                                <div class="card-header">Schedule</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Event Date</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Start Time</label>
                                        <input type="time" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Duration (minutes)</label>
                                        <input type="number" class="form-control" value="90">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Timezone</label>
                                        <select class="form-select">
                                            <option>UTC</option>
                                            <option>EST</option>
                                            <option>PST</option>
                                            <option>GMT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="card mb-3">
                                <div class="card-header">Event Media</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Event Poster</label>
                                        <input type="file" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Team/Player Logos</label>
                                        <input type="file" class="form-control" multiple>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card">
                                <div class="card-header">Status</div>
                                <div class="card-body">
                                    <select class="form-select mb-3">
                                        <option>Scheduled</option>
                                        <option>Live</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                        <option>Postponed</option>
                                    </select>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Allow replay after event</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Send notifications</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveEvent()">
                    <i class="fas fa-save me-2"></i>Save Event
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.pulse-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #fff;
    animation: pulse-dot 1.5s infinite;
    margin-right: 0.5rem;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.sport-event-card {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    height: 100%;
    transition: all 0.3s;
}

.sport-event-card.live-event {
    border-color: #ef4444;
    background: linear-gradient(135deg, rgba(239,68,68,0.05) 0%, transparent 100%);
}

.sport-event-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.event-teams {
    margin-bottom: 1rem;
}

.event-teams .team {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.event-teams .team img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.event-teams .score {
    text-align: center;
    margin: 1rem 0;
}

.score-display {
    font-size: 1.5rem;
    font-weight: bold;
}

.event-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.5rem;
    border-top: 1px solid #e5e7eb;
}

.past-event-card {
    height: 100%;
}

.event-thumbnail {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
}

.replay-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.viewers {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>

<script>
function editEvent(id) {
    document.querySelector('#sportEventModal .modal-title').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Sport Event';
    new bootstrap.Modal(document.getElementById('sportEventModal')).show();
}

function deleteEvent(id) {
    if (confirm('Are you sure you want to delete this event?')) {
        alert('Event deleted successfully!');
    }
}

function previewEvent(id) {
    alert('Opening event preview...');
}

function saveEvent() {
    alert('Event saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('sportEventModal')).hide();
}

function importSchedule() {
    alert('Opening schedule import dialog...');
}

function toggleStreamInput(source) {
    // Update placeholder based on stream source
    const input = document.querySelector('input[placeholder="Enter stream URL or ID"]');
    switch(source) {
        case 'vimeo':
            input.placeholder = 'Enter Vimeo video ID';
            break;
        case 'youtube':
            input.placeholder = 'Enter YouTube video ID';
            break;
        case 'custom':
            input.placeholder = 'Enter custom stream URL';
            break;
        case 'm3u8':
            input.placeholder = 'Enter M3U8 stream URL';
            break;
    }
}
</script>
@endsection