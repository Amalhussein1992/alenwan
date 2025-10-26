@extends('admin.layouts.app')

@section('title', __('admin.profile'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">{{ __('admin.profile') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-lg-4">
            <div class="card-modern">
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&size=150&background=a20136&color=fff"
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; border: 4px solid var(--primary-color);">
                        <button class="btn btn-sm position-absolute bottom-0 end-0"
                                style="background: var(--primary-color); color: white; border-radius: 50%; width: 40px; height: 40px;">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h4 style="color: var(--text-primary); font-weight: 600;">Admin User</h4>
                    <p class="text-muted mb-3">admin@example.com</p>
                    <span class="badge bg-success">{{ __('admin.active') }}</span>
                </div>

                <hr style="border-color: var(--border-color);">

                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: var(--text-secondary);">{{ __('admin.role') }}</span>
                        <strong style="color: var(--text-primary);">Administrator</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: var(--text-secondary);">{{ __('admin.joined') }}</span>
                        <strong style="color: var(--text-primary);">{{ date('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="color: var(--text-secondary);">{{ __('admin.last_login') }}</span>
                        <strong style="color: var(--text-primary);">{{ date('M d, Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-lg-8">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.edit_profile') }}</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h6 style="color: var(--text-primary); font-weight: 500; margin-bottom: 1rem;">{{ __('admin.personal_information') }}</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    {{ __('admin.first_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="first_name" value="Admin" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    {{ __('admin.last_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="last_name" value="User" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                {{ __('admin.email') }} <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" name="email" value="admin@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                {{ __('admin.phone') }}
                            </label>
                            <input type="tel" class="form-control" name="phone" value="+1234567890">
                        </div>
                    </div>

                    <hr style="border-color: var(--border-color);">

                    <!-- Change Password Section -->
                    <div class="mb-4">
                        <h6 style="color: var(--text-primary); font-weight: 500; margin-bottom: 1rem;">{{ __('admin.change_password') }}</h6>

                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                {{ __('admin.current_password') }}
                            </label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    {{ __('admin.new_password') }}
                                </label>
                                <input type="password" class="form-control" name="new_password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    {{ __('admin.confirm_password') }}
                                </label>
                                <input type="password" class="form-control" name="confirm_password">
                            </div>
                        </div>

                        <div class="alert alert-info" style="border-radius: 10px;">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>{{ __('admin.password_requirements') }}</small>
                        </div>
                    </div>

                    <hr style="border-color: var(--border-color);">

                    <!-- Preferences Section -->
                    <div class="mb-4">
                        <h6 style="color: var(--text-primary); font-weight: 500; margin-bottom: 1rem;">{{ __('admin.preferences') }}</h6>

                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                {{ __('admin.language') }}
                            </label>
                            <select class="form-select" name="language">
                                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                                <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>العربية</option>
                                <option value="fr" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>Español</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                {{ __('admin.timezone') }}
                            </label>
                            <select class="form-select" name="timezone">
                                <option value="UTC">UTC</option>
                                <option value="America/New_York">America/New York (EST)</option>
                                <option value="Europe/London">Europe/London (GMT)</option>
                                <option value="Asia/Dubai">Asia/Dubai (GST)</option>
                                <option value="Asia/Tokyo">Asia/Tokyo (JST)</option>
                            </select>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" checked>
                            <label class="form-check-label" for="emailNotifications" style="color: var(--text-primary);">
                                {{ __('admin.email_notifications') }}
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>{{ __('admin.cancel') }}
                        </button>
                        <button type="submit" class="btn-modern btn-primary-modern">
                            <i class="fas fa-save me-2"></i>{{ __('admin.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings Card -->
            <div class="card-modern mt-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">{{ __('admin.security_settings') }}</h5>

                <div class="d-flex justify-content-between align-items-center mb-3 p-3" style="background: var(--card-bg); border-radius: 10px; border: 1px solid var(--border-color);">
                    <div>
                        <h6 style="color: var(--text-primary); margin-bottom: 0.25rem;">{{ __('admin.two_factor_authentication') }}</h6>
                        <small class="text-muted">{{ __('admin.two_factor_desc') }}</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="twoFactor" style="width: 3rem; height: 1.5rem;">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--card-bg); border-radius: 10px; border: 1px solid var(--border-color);">
                    <div>
                        <h6 style="color: var(--text-primary); margin-bottom: 0.25rem;">{{ __('admin.login_alerts') }}</h6>
                        <small class="text-muted">{{ __('admin.login_alerts_desc') }}</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="loginAlerts" checked style="width: 3rem; height: 1.5rem;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
