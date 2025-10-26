@php
    $landingTranslations = [
        'Navigation' => [
            'home' => 'Home',
            'features' => 'Features',
            'content' => 'Content',
            'pricing' => 'Pricing',
            'sign_in' => 'Sign In',
            'get_started' => 'Get Started',
        ],
        'Hero Section' => [
            'hero_title' => 'Stream Movies & Series Like Never Before',
            'hero_subtitle' => 'Experience premium entertainment with 4K quality',
            'start_watching' => 'Start Watching',
            'learn_more' => 'Learn More',
        ],
        'Statistics' => [
            'stat_movies' => 'Movies & Series',
            'stat_users' => 'Happy Users',
            'stat_quality' => 'Ultra HD Quality',
            'stat_support' => 'Support',
        ],
    ];

    $adminTranslations = [
        'Navigation' => [
            'dashboard' => 'Dashboard',
            'movies' => 'Movies',
            'series' => 'Series',
            'users' => 'Users',
            'settings' => 'Settings',
        ],
        'Common' => [
            'save' => 'Save',
            'cancel' => 'Cancel',
            'delete' => 'Delete',
            'edit' => 'Edit',
            'add' => 'Add',
            'search' => 'Search',
        ],
    ];

    // Load actual translations from files if they exist
    if (file_exists(resource_path("lang/{$language}/landing.php"))) {
        $landingFile = include resource_path("lang/{$language}/landing.php");
        if (is_array($landingFile)) {
            foreach ($landingTranslations as $section => &$items) {
                foreach ($items as $key => &$value) {
                    if (isset($landingFile[$key])) {
                        $value = $landingFile[$key];
                    }
                }
            }
        }
    }

    if (file_exists(resource_path("lang/{$language}/admin.php"))) {
        $adminFile = include resource_path("lang/{$language}/admin.php");
        if (is_array($adminFile)) {
            foreach ($adminTranslations as $section => &$items) {
                foreach ($items as $key => &$value) {
                    if (isset($adminFile[$key])) {
                        $value = $adminFile[$key];
                    }
                }
            }
        }
    }
@endphp

<form id="translation-form-{{ $language }}">
    <!-- Landing Page Section -->
    <div class="card-modern mb-4" id="section-landing">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <i class="fas fa-home text-white"></i>
            </div>
            <div>
                <h4 class="mb-0">Landing Page Translations</h4>
                <small class="text-muted">Translations for the public landing page</small>
            </div>
        </div>

        @foreach($landingTranslations as $sectionName => $items)
        <div class="mb-4">
            <h6 class="text-muted mb-3">{{ $sectionName }}</h6>
            <div class="row g-3">
                @foreach($items as $key => $value)
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                    <input type="text"
                           class="translation-input"
                           data-lang="{{ $language }}"
                           data-section="landing"
                           data-key="{{ $key }}"
                           value="{{ $value }}"
                           placeholder="Enter translation...">
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Admin Panel Section -->
    <div class="card-modern mb-4" id="section-admin">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, var(--info-color) 0%, #2563eb 100%);">
                <i class="fas fa-cog text-white"></i>
            </div>
            <div>
                <h4 class="mb-0">Admin Panel Translations</h4>
                <small class="text-muted">Translations for the admin dashboard</small>
            </div>
        </div>

        @foreach($adminTranslations as $sectionName => $items)
        <div class="mb-4">
            <h6 class="text-muted mb-3">{{ $sectionName }}</h6>
            <div class="row g-3">
                @foreach($items as $key => $value)
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                    <input type="text"
                           class="translation-input"
                           data-lang="{{ $language }}"
                           data-section="admin"
                           data-key="{{ $key }}"
                           value="{{ $value }}"
                           placeholder="Enter translation...">
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Authentication Section -->
    <div class="card-modern mb-4" id="section-auth">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);">
                <i class="fas fa-sign-in-alt text-white"></i>
            </div>
            <div>
                <h4 class="mb-0">Authentication Translations</h4>
                <small class="text-muted">Login, registration, and password reset</small>
            </div>
        </div>

        <div class="row g-3">
            @php
                $authTranslations = [
                    'login' => 'Login',
                    'register' => 'Register',
                    'email' => 'Email',
                    'password' => 'Password',
                    'forgot_password' => 'Forgot Password?',
                    'remember_me' => 'Remember Me',
                ];
            @endphp

            @foreach($authTranslations as $key => $value)
            <div class="col-md-6">
                <label class="form-label fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                <input type="text"
                       class="translation-input"
                       data-lang="{{ $language }}"
                       data-section="auth"
                       data-key="{{ $key }}"
                       value="{{ $value }}"
                       placeholder="Enter translation...">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Messages Section -->
    <div class="card-modern mb-4" id="section-messages">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);">
                <i class="fas fa-envelope text-white"></i>
            </div>
            <div>
                <h4 class="mb-0">System Messages</h4>
                <small class="text-muted">Success, error, and notification messages</small>
            </div>
        </div>

        <div class="row g-3">
            @php
                $messageTranslations = [
                    'success_message' => 'Operation completed successfully!',
                    'error_message' => 'An error occurred. Please try again.',
                    'warning_message' => 'Please review your input.',
                    'info_message' => 'Information has been updated.',
                ];
            @endphp

            @foreach($messageTranslations as $key => $value)
            <div class="col-md-6">
                <label class="form-label fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                <input type="text"
                       class="translation-input"
                       data-lang="{{ $language }}"
                       data-section="messages"
                       data-key="{{ $key }}"
                       value="{{ $value }}"
                       placeholder="Enter translation...">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Validation Section -->
    <div class="card-modern mb-4" id="section-validation">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon me-3" style="background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <div>
                <h4 class="mb-0">Validation Messages</h4>
                <small class="text-muted">Form validation error messages</small>
            </div>
        </div>

        <div class="row g-3">
            @php
                $validationTranslations = [
                    'required' => 'This field is required.',
                    'email_invalid' => 'Please enter a valid email address.',
                    'password_min' => 'Password must be at least 8 characters.',
                    'password_confirm' => 'Passwords do not match.',
                ];
            @endphp

            @foreach($validationTranslations as $key => $value)
            <div class="col-md-6">
                <label class="form-label fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                <input type="text"
                       class="translation-input"
                       data-lang="{{ $language }}"
                       data-section="validation"
                       data-key="{{ $key }}"
                       value="{{ $value }}"
                       placeholder="Enter translation...">
            </div>
            @endforeach
        </div>
    </div>
</form>
