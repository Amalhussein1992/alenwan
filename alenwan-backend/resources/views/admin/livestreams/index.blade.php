@extends('admin.layouts.app')

@section('title', __('admin.livestreams_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.livestreams_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.livestreams') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-danger me-2" onclick="startBroadcast()">
                    <i class="fas fa-broadcast-tower me-2"></i>{{ __('admin.start_broadcast') }}
                </button>
                <a href="{{ route('admin.livestreams.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus me-2"></i>{{ __('admin.add_new_stream') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Live Status Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="border-left-color: #ef4444;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">
                            <span class="badge bg-danger pulse-animation">12 {{ __('admin.live') }}</span>
                        </div>
                        <div class="stat-label">{{ __('admin.currently_broadcasting') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-broadcast-tower text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">45.2K</div>
                        <div class="stat-label">{{ __('admin.live_viewers') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">24</div>
                        <div class="stat-label">{{ __('admin.scheduled_today') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">156</div>
                        <div class="stat-label">{{ __('admin.total_channels') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="fas fa-satellite-dish text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Live Streams -->
    <div class="card-modern mb-4">
        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
            <span class="badge bg-danger pulse-animation me-2">{{ __('admin.live_now') }}</span>
            {{ __('admin.active_broadcasts') }}
        </h5>

        <div class="row">
            @php
                $liveStreams = [
                    ['channel' => 'Sports HD', 'event' => 'UEFA Champions League - Real Madrid vs Barcelona', 'viewers' => 15234, 'quality' => '4K', 'uptime' => '45:32'],
                    ['channel' => 'News 24/7', 'event' => 'Breaking News - Live Coverage', 'viewers' => 8456, 'quality' => 'FHD', 'uptime' => '2:15:45'],
                    ['channel' => 'Music TV', 'event' => 'Live Concert - Summer Festival 2024', 'viewers' => 12890, 'quality' => 'FHD', 'uptime' => '1:30:22'],
                    ['channel' => 'Game Zone', 'event' => 'E-Sports Championship Finals', 'viewers' => 9876, 'quality' => '4K', 'uptime' => '3:45:12'],
                ];
            @endphp

            @foreach($liveStreams as $stream)
            <div class="col-xl-6 mb-3">
                <div class="card border-danger" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1" style="color: var(--text-primary);">{{ $stream['channel'] }}</h6>
                                <p class="text-muted mb-0">{{ $stream['event'] }}</p>
                            </div>
                            <span class="badge bg-danger pulse-animation">{{ __('admin.live') }}</span>
                        </div>

                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="text-muted small">{{ __('admin.viewers') }}</div>
                                <div class="fw-bold">
                                    <i class="fas fa-eye text-success me-1"></i>{{ number_format($stream['viewers']) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small">{{ __('admin.quality') }}</div>
                                <div class="fw-bold">
                                    <span class="badge bg-primary">{{ $stream['quality'] }}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small">{{ __('admin.uptime') }}</div>
                                <div class="fw-bold">
                                    <i class="fas fa-clock text-warning me-1"></i>{{ $stream['uptime'] }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info flex-grow-1" onclick="viewAnalytics('{{ $stream['channel'] }}')">
                                <i class="fas fa-chart-line me-1"></i>{{ __('admin.analytics') }}
                            </button>
                            <button class="btn btn-sm btn-outline-warning flex-grow-1" onclick="openSettings('{{ $stream['channel'] }}')">
                                <i class="fas fa-cog me-1"></i>{{ __('admin.settings') }}
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="stopStream('{{ $stream['channel'] }}')">
                                <i class="fas fa-stop"></i> {{ __('admin.stop') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Scheduled Streams -->
    <div class="card-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                <i class="fas fa-calendar-alt text-primary me-2"></i>{{ __('admin.scheduled_streams') }}
            </h5>
            <a href="{{ route('admin.livestreams.create') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-calendar-plus me-1"></i>{{ __('admin.schedule_new') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>{{ __('admin.channel') }}</th>
                        <th>{{ __('admin.event_program') }}</th>
                        <th>{{ __('admin.scheduled_time') }}</th>
                        <th>{{ __('admin.duration') }}</th>
                        <th>{{ __('admin.type') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th class="text-center">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $scheduled = [
                            ['channel' => 'Sports HD', 'event' => 'NBA Finals - Game 7', 'time' => '20:00', 'duration' => '3 hours', 'type' => 'Sports', 'status' => 'Confirmed'],
                            ['channel' => 'Movie Premium', 'event' => 'Premiere: Avatar 3', 'time' => '21:30', 'duration' => '2.5 hours', 'type' => 'Movie', 'status' => 'Confirmed'],
                            ['channel' => 'News 24/7', 'event' => 'Evening News Bulletin', 'time' => '18:00', 'duration' => '1 hour', 'type' => 'News', 'status' => 'Recurring'],
                            ['channel' => 'Kids Zone', 'event' => 'Cartoon Marathon', 'time' => '09:00', 'duration' => '4 hours', 'type' => 'Kids', 'status' => 'Tomorrow'],
                            ['channel' => 'Documentary Plus', 'event' => 'Planet Earth III - Episode 5', 'time' => '19:00', 'duration' => '1 hour', 'type' => 'Documentary', 'status' => 'Confirmed'],
                            ['channel' => 'Music TV', 'event' => 'Top 100 Countdown', 'time' => '16:00', 'duration' => '2 hours', 'type' => 'Music', 'status' => 'Weekly'],
                        ];

                        $typeColors = [
                            'Sports' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                            'Movie' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)',
                            'News' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                            'Kids' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                            'Documentary' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
                            'Music' => 'linear-gradient(135deg, #ec4899 0%, #d946ef 100%)',
                        ];
                    @endphp

                    @foreach($scheduled as $schedule)
                    <tr class="align-middle">
                        <td>
                            <strong style="color: var(--text-primary);">{{ $schedule['channel'] }}</strong>
                        </td>
                        <td>
                            <div>
                                <span style="color: var(--text-primary);">{{ $schedule['event'] }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-clock text-muted me-1"></i>
                                <span>Today, {{ $schedule['time'] }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $schedule['duration'] }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill text-white" style="background: {{ $typeColors[$schedule['type']] }}">
                                {{ $schedule['type'] }}
                            </span>
                        </td>
                        <td>
                            @if($schedule['status'] == 'Confirmed')
                                <span class="badge bg-success">{{ __('admin.confirmed') }}</span>
                            @elseif($schedule['status'] == 'Recurring')
                                <span class="badge bg-info">{{ __('admin.recurring') }}</span>
                            @elseif($schedule['status'] == 'Weekly')
                                <span class="badge bg-primary">{{ __('admin.weekly') }}</span>
                            @else
                                <span class="badge bg-warning">{{ $schedule['status'] }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-success" onclick="goLive('{{ $schedule['event'] }}')" title="{{ __('admin.go_live') }}">
                                    <i class="fas fa-play"></i>
                                </button>
                                <a href="{{ route('admin.livestreams.create') }}" class="btn btn-sm btn-outline-primary" title="{{ __('admin.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="cancelStream('{{ $schedule['event'] }}')" title="{{ __('admin.cancel') }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
        100% {
            opacity: 1;
        }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }
</style>
@endsection

@section('scripts')
<script>
    function startBroadcast() {
        window.location.href = '{{ route('admin.livestreams.create') }}';
    }

    function viewAnalytics(channel) {
        alert('Viewing analytics for: ' + channel + '\n\nThis feature will show detailed viewer statistics, engagement metrics, and performance data.');
    }

    function openSettings(channel) {
        alert('Opening settings for: ' + channel + '\n\nThis feature will allow you to configure stream quality, bitrate, and other technical settings.');
    }

    function stopStream(channel) {
        if (confirm('Are you sure you want to stop the stream for: ' + channel + '?')) {
            alert('Stream stopped successfully!');
            // In production: send AJAX request to stop the stream
        }
    }

    function goLive(event) {
        if (confirm('Start streaming: ' + event + '?')) {
            alert('Going live! Stream started successfully.');
            // In production: send AJAX request to start the stream
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    }

    function cancelStream(event) {
        if (confirm('Cancel scheduled stream: ' + event + '?')) {
            alert('Stream cancelled successfully!');
            // In production: send AJAX request to cancel the stream
        }
    }

    // Auto-refresh for live viewer counts
    setInterval(function() {
        // This would fetch updated viewer counts in production
        console.log('Refreshing viewer counts...');
    }, 30000); // Every 30 seconds
</script>
@endsection