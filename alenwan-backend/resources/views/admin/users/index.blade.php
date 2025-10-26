@extends('admin.layouts.app')

@section('title', __('admin.users_management'))

@section('content')
<div class="container-fluid p-0">
    <!-- Alert Container -->
    <div class="alert-container mb-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.users_management') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.users') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-secondary-modern me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter me-2"></i>{{ __('admin.filter') }}
                </button>
                <button class="btn-modern btn-info-modern me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i>{{ __('admin.export') }}
                </button>
                <button class="btn-modern btn-success-modern" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-2"></i>{{ __('admin.add_new_user') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card animate-slide-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                        <div class="stat-label">{{ __('admin.total_users') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.1s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['premium_users']) }}</div>
                        <div class="stat-label">{{ __('admin.premium_users') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['active_users']) }}</div>
                        <div class="stat-label">{{ __('admin.active_users') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-user-check text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card animate-slide-in" style="animation-delay: 0.3s;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['banned_users']) }}</div>
                        <div class="stat-label">{{ __('admin.banned_users') }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-user-slash text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card-modern">
        <!-- Search and Actions Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2 align-items-center">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                    <input type="text" class="form-control ps-5" placeholder="{{ __('admin.search_users') }}" style="width: 350px; border-radius: 10px;">
                </div>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>{{ __('admin.all_status') }}</option>
                    <option>{{ __('admin.active') }}</option>
                    <option>{{ __('admin.inactive') }}</option>
                    <option>{{ __('admin.suspended') }}</option>
                    <option>{{ __('admin.banned') }}</option>
                </select>
                <select class="form-select" style="width: 150px; border-radius: 10px;">
                    <option>{{ __('admin.all_plans') }}</option>
                    <option>{{ __('admin.free') }}</option>
                    <option>{{ __('admin.basic') }}</option>
                    <option>{{ __('admin.premium') }}</option>
                    <option>{{ __('admin.premium_plus') }}</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-th me-1"></i>{{ __('admin.card_view') }}
                </button>
                <button class="btn btn-outline-secondary btn-sm active">
                    <i class="fas fa-list me-1"></i>{{ __('admin.list_view') }}
                </button>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="mb-3 d-flex gap-2">
            <select class="form-select" style="width: 200px; border-radius: 10px;">
                <option value="">-- {{ __('admin.bulk_actions') }} --</option>
                <option value="activate">{{ __('admin.activate_selected') }}</option>
                <option value="deactivate">{{ __('admin.deactivate_selected') }}</option>
                <option value="suspend">{{ __('admin.suspend_selected') }}</option>
                <option value="delete">{{ __('admin.delete_selected') }}</option>
                <option value="email">{{ __('admin.send_email') }}</option>
            </select>
            <button class="btn-modern btn-primary-modern btn-sm">{{ __('admin.apply') }}</button>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>{{ __('admin.user') }}</th>
                        <th>{{ __('admin.email') }}</th>
                        <th>{{ __('admin.subscription') }}</th>
                        <th>{{ __('admin.joined') }}</th>
                        <th>{{ __('admin.last_active') }}</th>
                        <th>{{ __('admin.status') }}</th>
                        <th class="text-center">{{ __('admin.verified') }}</th>
                        <th class="text-center">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="align-middle">
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                     alt="Avatar" class="rounded-circle me-3"
                                     style="width: 40px; height: 40px;">
                                <div>
                                    <strong style="color: var(--text-primary);">{{ $user->name }}</strong>
                                    <br><small style="color: var(--text-secondary);">{{ __('admin.id') }}: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="color: var(--text-primary);">{{ $user->email }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-secondary">{{ __('admin.free_plan') }}</span>
                        </td>
                        <td>
                            <span style="color: var(--text-primary);">{{ $user->created_at->format('M d, Y') }}</span>
                            <br><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if($user->updated_at->diffInHours() < 1)
                                <span class="badge bg-success">{{ __('admin.online_now') }}</span>
                            @else
                                <span style="color: var(--text-primary);">{{ $user->updated_at->diffForHumans() }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-success">
                                <i class="fas fa-check-circle me-1"></i>{{ __('admin.active') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($user->email_verified_at)
                                <i class="fas fa-check-circle text-success" title="{{ __('admin.email_verified') }}"></i>
                            @else
                                <i class="fas fa-times-circle text-danger" title="{{ __('admin.not_verified') }}"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="dropdown-item">
                                            <i class="fas fa-eye me-2 text-info"></i>{{ __('admin.view_details') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item">
                                            <i class="fas fa-edit me-2 text-primary"></i>{{ __('admin.edit_user') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i>{{ __('admin.delete_user') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('admin.no_users_found') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('admin.user_details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=6366f1&color=fff&size=150"
                             alt="User Avatar" class="rounded-circle mb-3">
                        <h5>John Doe</h5>
                        <p class="text-muted">{{ __('admin.premium_user') }}</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success">{{ __('admin.active') }}</span>
                            <span class="badge bg-primary">{{ __('admin.verified') }}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="mb-3">{{ __('admin.account_information') }}</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="text-muted">{{ __('admin.user_id') }}:</td>
                                <td>#USR001234</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.email') }}:</td>
                                <td>john.doe@example.com</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.phone') }}:</td>
                                <td>+1 234 567 8901</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.joined') }}:</td>
                                <td>January 15, 2024</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.last_login') }}:</td>
                                <td>{{ __('admin.hours_ago', ['hours' => '2']) }}</td>
                            </tr>
                        </table>

                        <h6 class="mb-3 mt-4">{{ __('admin.subscription_details') }}</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="text-muted">{{ __('admin.plan') }}:</td>
                                <td><span class="badge bg-primary">{{ __('admin.premium') }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.started') }}:</td>
                                <td>March 1, 2024</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.expires') }}:</td>
                                <td>April 1, 2024</td>
                            </tr>
                            <tr>
                                <td class="text-muted">{{ __('admin.payment_method') }}:</td>
                                <td><i class="fab fa-cc-visa me-1"></i> **** 1234</td>
                            </tr>
                        </table>

                        <h6 class="mb-3 mt-4">{{ __('admin.activity_summary') }}</h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="text-primary">156</h4>
                                <small class="text-muted">{{ __('admin.movies_watched') }}</small>
                            </div>
                            <div class="col-4">
                                <h4 class="text-success">42</h4>
                                <small class="text-muted">{{ __('admin.series_watched') }}</small>
                            </div>
                            <div class="col-4">
                                <h4 class="text-warning">89</h4>
                                <small class="text-muted">{{ __('admin.hours_streamed') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                <button type="button" class="btn btn-primary">{{ __('admin.edit_user') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('admin.add_new_user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.full_name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.email_address') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.phone_number') }}</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+1 234 567 8901" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.subscription_plan') }}</label>
                        <select name="subscription_plan" class="form-select" style="border-radius: 10px;">
                            <option value="free">{{ __('admin.free') }}</option>
                            <option value="basic">{{ __('admin.basic') }}</option>
                            <option value="premium">{{ __('admin.premium') }}</option>
                            <option value="premium_plus">{{ __('admin.premium_plus') }}</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="send_welcome" id="sendWelcome" checked>
                        <label class="form-check-label" for="sendWelcome">
                            {{ __('admin.send_welcome_email') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
                    <button type="submit" class="btn btn-success">{{ __('admin.add_user') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add user form submission
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("admin.saving") }}';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || '{{ __("admin.user_added_successfully") }}');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('danger', data.message || '{{ __("admin.save_failed") }}');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', '{{ __("admin.error_occurred") }}');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.alert-container').innerHTML = alertHtml;
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Close modal if success
        if (type === 'success') {
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            if (modal) modal.hide();
        }
    }

    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
@endsection