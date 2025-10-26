@extends('admin.layouts.app')

@section('title', __('admin.channels_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Enhanced Header Section -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">
                    <i class="fas fa-satellite-dish me-2" style="color: #667eea;"></i>{{ __('admin.channels_management') }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.channels') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-info-modern me-2" onclick="importM3U()">
                    <i class="fas fa-file-import me-2"></i>{{ __('admin.import_m3u') }}
                </button>
                <button class="btn-modern btn-secondary-modern me-2" onclick="syncEPG()">
                    <i class="fas fa-sync me-2"></i>{{ __('admin.sync_epg') }}
                </button>
                <a href="{{ route('admin.channels.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_channel') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-tv text-white"></i>
                </div>
                <div class="stat-value">486</div>
                <div class="stat-label">{{ __('admin.total_channels') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ __('admin.this_week', ['count' => 24]) }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-signal text-white"></i>
                </div>
                <div class="stat-value">412</div>
                <div class="stat-label">{{ __('admin.active_channels') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-check-circle"></i>
                    <span>84.8% {{ __('admin.online') }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="stat-value">74</div>
                <div class="stat-label">{{ __('admin.offline_channels') }}</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-up"></i>
                    <span>15.2% {{ __('admin.offline') }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-globe text-white"></i>
                </div>
                <div class="stat-value">52</div>
                <div class="stat-label">{{ __('admin.countries') }}</div>
                <div class="stat-change">
                    <i class="fas fa-flag"></i>
                    <span>{{ __('admin.global_coverage') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="card-modern mb-4">
        <ul class="nav nav-pills overflow-auto flex-nowrap" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#all-channels">
                    <i class="fas fa-list me-2"></i>{{ __('admin.all_channels') }}
                    <span class="badge bg-primary ms-2">486</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#news">
                    <i class="fas fa-newspaper me-2"></i>{{ __('admin.news') }}
                    <span class="badge bg-secondary ms-2">82</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#sports">
                    <i class="fas fa-football-ball me-2"></i>{{ __('admin.sports') }}
                    <span class="badge bg-secondary ms-2">64</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#entertainment">
                    <i class="fas fa-film me-2"></i>{{ __('admin.entertainment') }}
                    <span class="badge bg-secondary ms-2">145</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kids">
                    <i class="fas fa-child me-2"></i>{{ __('admin.kids') }}
                    <span class="badge bg-secondary ms-2">38</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#music">
                    <i class="fas fa-music me-2"></i>{{ __('admin.music') }}
                    <span class="badge bg-secondary ms-2">45</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#documentary">
                    <i class="fas fa-book me-2"></i>{{ __('admin.documentary') }}
                    <span class="badge bg-secondary ms-2">28</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#regional">
                    <i class="fas fa-map-marker-alt me-2"></i>{{ __('admin.regional') }}
                    <span class="badge bg-secondary ms-2">84</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="all-channels">
            <!-- Search and Filters -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search channels...">
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select">
                                <option>All Countries</option>
                                <option>USA</option>
                                <option>UK</option>
                                <option>Canada</option>
                                <option>India</option>
                                <option>Germany</option>
                                <option>France</option>
                                <option>Spain</option>
                                <option>Italy</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select">
                                <option>All Languages</option>
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                                <option>Arabic</option>
                                <option>Hindi</option>
                                <option>Chinese</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select">
                                <option>All Quality</option>
                                <option>4K UHD</option>
                                <option>Full HD</option>
                                <option>HD</option>
                                <option>SD</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select">
                                <option>All Status</option>
                                <option>Online</option>
                                <option>Offline</option>
                                <option>Maintenance</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Channels Grid View -->
            <div class="row g-3 mb-4" id="channelsGrid">
                @for($i = 1; $i <= 12; $i++)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="channel-card">
                        <div class="channel-logo">
                            <img src="https://via.placeholder.com/200x120/{{ ['667eea', 'ef4444', '10b981', 'f59e0b', '6366f1', 'ec4899'][($i-1) % 6] }}/ffffff?text=Channel+{{ $i }}"
                                 alt="Channel {{ $i }}" class="img-fluid">
                            <div class="channel-status {{ $i % 5 == 0 ? 'offline' : 'online' }}">
                                <i class="fas fa-circle"></i>
                            </div>
                            @if($i <= 3)
                            <div class="channel-quality">
                                <span class="badge bg-warning">HD</span>
                            </div>
                            @endif
                        </div>
                        <div class="channel-info">
                            <h6 class="channel-name">{{ ['CNN International', 'ESPN Sports', 'HBO Max', 'Discovery Channel', 'Cartoon Network', 'MTV Music'][($i-1) % 6] }}</h6>
                            <p class="channel-category">
                                <i class="fas fa-tag me-1"></i>
                                {{ ['News', 'Sports', 'Entertainment', 'Documentary', 'Kids', 'Music'][($i-1) % 6] }}
                            </p>
                            <div class="channel-details">
                                <span class="text-muted small">
                                    <i class="fas fa-globe me-1"></i>USA
                                </span>
                                <span class="text-muted small ms-2">
                                    <i class="fas fa-language me-1"></i>EN
                                </span>
                            </div>
                            <div class="channel-actions mt-2">
                                <button class="btn btn-sm btn-outline-primary" onclick="editChannel({{ $i }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info" onclick="viewEPG({{ $i }})" title="EPG">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" onclick="testStream({{ $i }})" title="Test">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteChannel({{ $i }})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- List View (Alternative) -->
            <div class="card border-0 shadow-sm d-none" id="channelsList">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>Logo</th>
                                    <th>Channel Name</th>
                                    <th>Category</th>
                                    <th>Country</th>
                                    <th>Language</th>
                                    <th>Quality</th>
                                    <th>Status</th>
                                    <th>Viewers</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 10; $i++)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/40x30/{{ ['667eea', 'ef4444', '10b981'][($i-1) % 3] }}/ffffff?text=Ch{{ $i }}"
                                             alt="Logo" class="rounded">
                                    </td>
                                    <td>
                                        <strong>{{ ['BBC News', 'Sky Sports', 'National Geographic'][($i-1) % 3] }}</strong>
                                        <br><small class="text-muted">Channel {{ 100 + $i }}</small>
                                    </td>
                                    <td><span class="badge bg-primary">{{ ['News', 'Sports', 'Documentary'][($i-1) % 3] }}</span></td>
                                    <td>
                                        <img src="https://flagcdn.com/16x12/{{ ['gb', 'us', 'ca'][($i-1) % 3] }}.png" alt="Flag" class="me-1">
                                        {{ ['UK', 'USA', 'Canada'][($i-1) % 3] }}
                                    </td>
                                    <td>English</td>
                                    <td><span class="badge bg-warning">HD</span></td>
                                    <td>
                                        @if($i % 4 == 0)
                                        <span class="badge bg-danger">Offline</span>
                                        @else
                                        <span class="badge bg-success">Online</span>
                                        @endif
                                    </td>
                                    <td>{{ rand(100, 9999) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="EPG">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="Test">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- View Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="btn-group">
                    <button class="btn btn-outline-primary active" onclick="toggleView('grid')">
                        <i class="fas fa-th"></i> Grid
                    </button>
                    <button class="btn btn-outline-primary" onclick="toggleView('list')">
                        <i class="fas fa-list"></i> List
                    </button>
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">4</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Other Category Tabs -->
        <div class="tab-pane fade" id="news">
            <div class="alert alert-info">
                <i class="fas fa-newspaper me-2"></i>
                Showing 82 news channels from around the world
            </div>
        </div>

        <div class="tab-pane fade" id="sports">
            <div class="alert alert-info">
                <i class="fas fa-football-ball me-2"></i>
                Showing 64 sports channels with live events
            </div>
        </div>
    </div>

    <!-- EPG Schedule Section -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Today's EPG Schedule
            </h5>
        </div>
        <div class="card-body">
            <div class="epg-timeline">
                <div class="epg-header">
                    <div class="epg-time-slots">
                        @for($hour = 0; $hour < 24; $hour += 2)
                        <div class="time-slot">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</div>
                        @endfor
                    </div>
                </div>
                <div class="epg-channels">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="epg-channel-row">
                        <div class="epg-channel-info">
                            <img src="https://via.placeholder.com/30x20/{{ ['667eea', 'ef4444', '10b981', 'f59e0b', '6366f1'][($i-1) % 5] }}/ffffff?text=Ch{{ $i }}"
                                 alt="Channel" class="me-2">
                            <span>Channel {{ $i }}</span>
                        </div>
                        <div class="epg-programs">
                            <div class="epg-program" style="width: 8.33%;">News</div>
                            <div class="epg-program" style="width: 16.66%;">Morning Show</div>
                            <div class="epg-program current" style="width: 12.5%;">Live Sports</div>
                            <div class="epg-program" style="width: 20.83%;">Movie: Action Film</div>
                            <div class="epg-program" style="width: 12.5%;">Documentary</div>
                            <div class="epg-program" style="width: 29.18%;">Evening Entertainment</div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Channel Modal -->
<div class="modal fade" id="channelModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-satellite-dish me-2"></i>Add New Channel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="channelForm">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header">Channel Information</div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Channel Name</label>
                                            <input type="text" class="form-control" placeholder="e.g., CNN International">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Channel Number</label>
                                            <input type="number" class="form-control" placeholder="e.g., 101">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Category</label>
                                            <select class="form-select">
                                                <option>News</option>
                                                <option>Sports</option>
                                                <option>Entertainment</option>
                                                <option>Kids</option>
                                                <option>Music</option>
                                                <option>Documentary</option>
                                                <option>Movies</option>
                                                <option>Regional</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Country</label>
                                            <select class="form-select">
                                                <option>United States</option>
                                                <option>United Kingdom</option>
                                                <option>Canada</option>
                                                <option>India</option>
                                                <option>Germany</option>
                                                <option>France</option>
                                                <option>Spain</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Language</label>
                                            <select class="form-select">
                                                <option>English</option>
                                                <option>Spanish</option>
                                                <option>French</option>
                                                <option>German</option>
                                                <option>Arabic</option>
                                                <option>Hindi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Time Zone</label>
                                            <select class="form-select">
                                                <option>UTC</option>
                                                <option>EST</option>
                                                <option>PST</option>
                                                <option>GMT</option>
                                                <option>IST</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" placeholder="Channel description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stream Configuration -->
                            <div class="card">
                                <div class="card-header">Stream Configuration</div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Stream URL</label>
                                            <input type="text" class="form-control" placeholder="http://stream.example.com/channel.m3u8">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Stream Type</label>
                                            <select class="form-select">
                                                <option>HLS (m3u8)</option>
                                                <option>MPEG-DASH</option>
                                                <option>RTMP</option>
                                                <option>HTTP</option>
                                                <option>UDP</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Video Quality</label>
                                            <select class="form-select">
                                                <option>4K UHD (2160p)</option>
                                                <option>Full HD (1080p)</option>
                                                <option>HD (720p)</option>
                                                <option>SD (480p)</option>
                                                <option>Auto</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Backup Stream URL (Optional)</label>
                                            <input type="text" class="form-control" placeholder="Backup stream URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">User Agent (Optional)</label>
                                            <input type="text" class="form-control" placeholder="Custom user agent">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Referrer (Optional)</label>
                                            <input type="text" class="form-control" placeholder="HTTP referrer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Channel Logo -->
                            <div class="card mb-3">
                                <div class="card-header">Channel Logo</div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <img src="https://via.placeholder.com/150x100/e5e7eb/9ca3af?text=Logo"
                                             alt="Logo Preview" class="img-fluid rounded" id="logoPreview">
                                    </div>
                                    <input type="file" class="form-control mb-2" accept="image/*">
                                    <small class="text-muted">Recommended: 200x120px, PNG or JPG</small>
                                </div>
                            </div>

                            <!-- EPG Settings -->
                            <div class="card mb-3">
                                <div class="card-header">EPG Configuration</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">EPG Source</label>
                                        <select class="form-select">
                                            <option>No EPG</option>
                                            <option>XMLTV URL</option>
                                            <option>API Endpoint</option>
                                            <option>Manual Entry</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">EPG URL</label>
                                        <input type="text" class="form-control" placeholder="EPG data source">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">EPG Channel ID</label>
                                        <input type="text" class="form-control" placeholder="Channel ID in EPG">
                                    </div>
                                </div>
                            </div>

                            <!-- Access Control -->
                            <div class="card mb-3">
                                <div class="card-header">Access Control</div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Public Channel</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Premium Only</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Age Restricted</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Geo-Blocked</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card">
                                <div class="card-header">Status</div>
                                <div class="card-body">
                                    <select class="form-select">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                        <option>Maintenance</option>
                                        <option>Testing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="testChannelStream()">
                    <i class="fas fa-play me-2"></i>Test Stream
                </button>
                <button type="button" class="btn btn-primary" onclick="saveChannel()">
                    <i class="fas fa-save me-2"></i>Save Channel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- EPG Viewer Modal -->
<div class="modal fade" id="epgModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-alt me-2"></i>EPG Schedule
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="epg-viewer">
                    <!-- EPG content will be loaded here -->
                    <p>Loading EPG data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Channel Card Styles */
.channel-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.channel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.channel-logo {
    position: relative;
    padding-top: 60%; /* 5:3 Aspect Ratio */
    overflow: hidden;
    background: #f3f4f6;
}

.channel-logo img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.channel-status {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 10px;
}

.channel-status.online {
    color: #10b981;
}

.channel-status.offline {
    color: #ef4444;
}

.channel-quality {
    position: absolute;
    top: 10px;
    left: 10px;
}

.channel-info {
    padding: 1rem;
}

.channel-name {
    font-weight: 600;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.channel-category {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.channel-details {
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
}

.channel-actions {
    display: flex;
    gap: 0.25rem;
}

.channel-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

/* EPG Timeline Styles */
.epg-timeline {
    overflow-x: auto;
    border: 1px solid var(--border-color);
    border-radius: 8px;
}

.epg-header {
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-color);
}

.epg-time-slots {
    display: flex;
    padding-left: 150px;
}

.time-slot {
    flex: 0 0 8.33%;
    padding: 0.5rem;
    text-align: center;
    border-right: 1px solid var(--border-color);
    font-size: 0.875rem;
    font-weight: 600;
}

.epg-channel-row {
    display: flex;
    border-bottom: 1px solid var(--border-color);
}

.epg-channel-info {
    width: 150px;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    font-weight: 500;
    border-right: 1px solid var(--border-color);
    background: var(--bg-secondary);
}

.epg-channel-info img {
    height: 20px;
}

.epg-programs {
    display: flex;
    flex: 1;
}

.epg-program {
    padding: 0.5rem;
    border-right: 1px solid var(--border-color);
    font-size: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    background: var(--card-bg);
    transition: background 0.3s;
}

.epg-program:hover {
    background: var(--bg-secondary);
}

.epg-program.current {
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid var(--primary-color);
    font-weight: 600;
}

/* Gradient Header */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .channel-actions {
        flex-wrap: wrap;
    }

    .epg-channel-info {
        width: 100px;
        font-size: 0.75rem;
    }

    .epg-program {
        font-size: 0.625rem;
    }

    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
}

@media (max-width: 576px) {
    .channel-card {
        margin-bottom: 1rem;
    }

    .channel-actions .btn {
        padding: 0.2rem 0.4rem;
    }
}
</style>

<script>
// Channel Management Functions
function editChannel(id) {
    document.querySelector('#channelModal .modal-title').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Channel';
    new bootstrap.Modal(document.getElementById('channelModal')).show();
}

function deleteChannel(id) {
    if (confirm('Are you sure you want to delete this channel?')) {
        alert('Channel deleted successfully!');
    }
}

function saveChannel() {
    alert('Channel saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('channelModal')).hide();
}

function viewEPG(id) {
    new bootstrap.Modal(document.getElementById('epgModal')).show();
}

function testStream(id) {
    alert('Testing stream for channel ' + id + '...');
    // In real implementation, this would open a video player or test the stream
}

function testChannelStream() {
    alert('Testing channel stream...');
}

function importM3U() {
    alert('Opening M3U import dialog...');
}

function syncEPG() {
    alert('Syncing EPG data...');
}

function toggleView(view) {
    const grid = document.getElementById('channelsGrid');
    const list = document.getElementById('channelsList');
    const buttons = document.querySelectorAll('.btn-group .btn');

    buttons.forEach(btn => btn.classList.remove('active'));

    if (view === 'grid') {
        grid.classList.remove('d-none');
        list.classList.add('d-none');
        buttons[0].classList.add('active');
    } else {
        grid.classList.add('d-none');
        list.classList.remove('d-none');
        buttons[1].classList.add('active');
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection