@extends('admin.layouts.app')

@section('title', __('admin.settings_title'))
@section('page-title', __('admin.settings_title'))

@push('styles')
<style>
    .settings-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }

    .settings-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .settings-nav {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 0;
    }

    .settings-nav .nav-link {
        padding: 1rem 1.5rem;
        color: #495057;
        border: none;
        background: transparent;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }

    .settings-nav .nav-link:hover {
        background: #e9ecef;
        color: var(--primary-color);
    }

    .settings-nav .nav-link.active {
        background: white;
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
    }

    .settings-content {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-section h5 {
        color: var(--dark-color);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-enhanced {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-test {
        background: var(--success-color);
        color: white;
    }

    .btn-generate {
        background: var(--warning-color);
        color: white;
    }

    .subscription-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--box-shadow);
        border-left: 4px solid var(--primary-color);
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .metric-label {
        color: #6b7280;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert {
        border-radius: 0.5rem;
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border-left: 4px solid var(--success-color);
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid var(--danger-color);
    }

    .progress {
        height: 0.5rem;
        border-radius: 0.25rem;
        background: #f3f4f6;
    }

    .progress-bar {
        background: var(--primary-gradient);
    }

    .subscription-products {
        background: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .product-info h6 {
        margin: 0;
        color: var(--dark-color);
    }

    .product-info small {
        color: #6b7280;
    }

    .product-price {
        font-weight: 700;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .settings-nav .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .subscription-metrics {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h1>{{ __('admin.settings_title') }}</h1>
        <p class="mb-0">{{ __('admin.settings_subtitle') }}</p>
    </div>

    <div class="settings-nav">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                    <i class="fas fa-cog me-2"></i>{{ __('admin.general_settings') }}
                </button>
                <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab">
                    <i class="fas fa-building me-2"></i>{{ __('admin.company_info') }}
                </button>
                <button class="nav-link" id="app-tab" data-bs-toggle="tab" data-bs-target="#app" type="button" role="tab">
                    <i class="fas fa-mobile-alt me-2"></i>{{ __('admin.app_settings') }}
                </button>
                <button class="nav-link" id="database-tab" data-bs-toggle="tab" data-bs-target="#database" type="button" role="tab">
                    <i class="fas fa-database me-2"></i>{{ __('admin.database') }}
                </button>
                <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api" type="button" role="tab">
                    <i class="fas fa-key me-2"></i>{{ __('admin.api_keys') }}
                </button>
                <button class="nav-link" id="mobile-subscriptions-tab" data-bs-toggle="tab" data-bs-target="#mobile-subscriptions" type="button" role="tab">
                    <i class="fas fa-credit-card me-2"></i>{{ __('admin.mobile_subscriptions') }}
                </button>
            </div>
        </nav>
    </div>

    <div class="settings-content">
        <form id="settingsForm">
            @csrf
            <div class="tab-content" id="nav-tabContent">
                <!-- General Settings Tab -->
                <div class="tab-pane active" id="general" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.general_settings') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_name" class="form-label">{{ __('admin.app_name') }}</label>
                                    <input type="text" class="form-control" id="app_name" name="app_name" value="Alenwan Streaming">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_version" class="form-label">{{ __('admin.app_version') }}</label>
                                    <input type="text" class="form-control" id="app_version" name="app_version" value="1.0.0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_url" class="form-label">{{ __('admin.app_url') }}</label>
                                    <input type="url" class="form-control" id="app_url" name="app_url" value="https://alenwan.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="environment" class="form-label">{{ __('admin.environment') }}</label>
                                    <select class="form-select" id="environment" name="environment">
                                        <option value="production">Production</option>
                                        <option value="staging">Staging</option>
                                        <option value="development">Development</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_language" class="form-label">{{ __('admin.default_language') }}</label>
                                    <select class="form-select" id="default_language" name="default_language">
                                        <option value="en">English</option>
                                        <option value="ar">العربية</option>
                                        <option value="fr">Français</option>
                                        <option value="es">Español</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="timezone" class="form-label">{{ __('admin.timezone') }}</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="UTC">UTC</option>
                                        <option value="America/New_York">Eastern Time</option>
                                        <option value="Europe/London">London</option>
                                        <option value="Asia/Dubai">Dubai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Info Tab -->
                <div class="tab-pane" id="company" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.company_info') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name" class="form-label">{{ __('admin.company_name') }}</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="Alenwan Entertainment">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_email" class="form-label">{{ __('admin.company_email') }}</label>
                                    <input type="email" class="form-control" id="company_email" name="company_email" value="info@alenwan.com">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="support_email" class="form-label">{{ __('admin.support_email') }}</label>
                                    <input type="email" class="form-control" id="support_email" name="support_email" value="support@alenwan.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_phone" class="form-label">{{ __('admin.company_phone') }}</label>
                                    <input type="tel" class="form-control" id="company_phone" name="company_phone" value="+1-555-0123">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_address" class="form-label">{{ __('admin.company_address') }}</label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="3">123 Entertainment Blvd, Los Angeles, CA 90210</textarea>
                        </div>
                    </div>
                </div>

                <!-- App Settings Tab -->
                <div class="tab-pane" id="app" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.app_settings') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode">
                                        <label class="form-check-label" for="maintenance_mode">
                                            {{ __('admin.maintenance_mode') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="debug_mode" name="debug_mode">
                                        <label class="form-check-label" for="debug_mode">
                                            {{ __('admin.debug_mode') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Tab -->
                <div class="tab-pane" id="database" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.database') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="db_host" class="form-label">Database Host</label>
                                    <input type="text" class="form-control" id="db_host" name="db_host" value="localhost">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="db_port" class="form-label">Database Port</label>
                                    <input type="number" class="form-control" id="db_port" name="db_port" value="3306">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="db_database" class="form-label">Database Name</label>
                                    <input type="text" class="form-control" id="db_database" name="db_database" value="alenwan_db">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="db_username" class="form-label">Database Username</label>
                                    <input type="text" class="form-control" id="db_username" name="db_username" value="alenwan_user">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-enhanced btn-test" onclick="testDatabaseConnection()">
                                <i class="fas fa-plug me-2"></i>{{ __('admin.test_connection') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- API Keys Tab -->
                <div class="tab-pane" id="api" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.api_keys') }}</h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="api_key" class="form-label">API Key</label>
                                    <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Generated API key will appear here" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-enhanced btn-generate d-block" onclick="generateApiKey()">
                                        <i class="fas fa-sync-alt me-2"></i>{{ __('admin.generate') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Subscriptions Tab -->
                <div class="tab-pane" id="mobile-subscriptions" role="tabpanel">
                    <div class="form-section">
                        <h5>{{ __('admin.mobile_subscriptions') }}</h5>

                        <!-- Revenue Analytics -->
                        <div class="subscription-metrics">
                            <div class="metric-card">
                                <div class="metric-value">$12,450</div>
                                <div class="metric-label">Monthly Revenue</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">1,234</div>
                                <div class="metric-label">Active Subscribers</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">89%</div>
                                <div class="metric-label">Retention Rate</div>
                            </div>
                            <div class="metric-card">
                                <div class="metric-value">156</div>
                                <div class="metric-label">New This Month</div>
                            </div>
                        </div>

                        <!-- Google Play Console -->
                        <div class="mb-4">
                            <h6><i class="fab fa-google-play me-2"></i>{{ __('admin.google_play_console') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="google_package_name" class="form-label">Package Name</label>
                                        <input type="text" class="form-control" id="google_package_name" name="google_package_name" placeholder="com.alenwan.streaming">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="google_service_account" class="form-label">Service Account Key</label>
                                        <input type="file" class="form-control" id="google_service_account" name="google_service_account" accept=".json">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Apple App Store Connect -->
                        <div class="mb-4">
                            <h6><i class="fab fa-apple me-2"></i>{{ __('admin.app_store_connect') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apple_app_id" class="form-label">App ID</label>
                                        <input type="text" class="form-control" id="apple_app_id" name="apple_app_id" placeholder="123456789">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apple_shared_secret" class="form-label">Shared Secret</label>
                                        <input type="password" class="form-control" id="apple_shared_secret" name="apple_shared_secret">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apple_key_id" class="form-label">Key ID</label>
                                        <input type="text" class="form-control" id="apple_key_id" name="apple_key_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apple_private_key" class="form-label">Private Key</label>
                                        <input type="file" class="form-control" id="apple_private_key" name="apple_private_key" accept=".p8">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Products -->
                        <div class="subscription-products">
                            <h6>{{ __('admin.subscription_products') }}</h6>
                            <div class="product-item">
                                <div class="product-info">
                                    <h6>Premium Monthly</h6>
                                    <small>Access to all premium content</small>
                                </div>
                                <div class="product-price">$9.99/month</div>
                            </div>
                            <div class="product-item">
                                <div class="product-info">
                                    <h6>Premium Yearly</h6>
                                    <small>Annual subscription with 20% discount</small>
                                </div>
                                <div class="product-price">$95.99/year</div>
                            </div>
                            <div class="product-item">
                                <div class="product-info">
                                    <h6>Premium Plus</h6>
                                    <small>Premium + 4K streaming + offline downloads</small>
                                </div>
                                <div class="product-price">$14.99/month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-enhanced btn-lg">
                    <i class="fas fa-save me-2"></i>{{ __('admin.save_all_changes') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="alertContainer"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveSettings();
    });

    // Auto-save functionality
    let saveTimeout;
    const formElements = document.querySelectorAll('#settingsForm input, #settingsForm select, #settingsForm textarea');
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveSettings(true); // Silent save
            }, 2000);
        });
    });
});

function saveSettings(silent = false) {
    const formData = new FormData(document.getElementById('settingsForm'));

    fetch('{{ route("admin.settings.save") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && !silent) {
            showAlert('success', data.message || '{{ __("admin.settings_saved") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (!silent) {
            showAlert('danger', 'An error occurred while saving settings.');
        }
    });
}

function testDatabaseConnection() {
    const formData = new FormData();
    formData.append('db_host', document.getElementById('db_host').value);
    formData.append('db_port', document.getElementById('db_port').value);
    formData.append('db_database', document.getElementById('db_database').value);
    formData.append('db_username', document.getElementById('db_username').value);

    fetch('{{ route("admin.settings.test-connection") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || '{{ __("admin.connection_successful") }}');
        } else {
            showAlert('danger', data.message || 'Connection failed.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Connection test failed.');
    });
}

function generateApiKey() {
    fetch('{{ route("admin.settings.generate-api-key") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('api_key').value = data.api_key;
            showAlert('success', 'API key generated successfully!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Failed to generate API key.');
    });
}

function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alert);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}
</script>
@endpush