@extends('admin.layouts.app')

@section('title', __('admin.settings'))

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">
                    <i class="fas fa-cog me-2" style="color: #667eea;"></i>{{ __('admin.system_settings') }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">{{ __('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.settings') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Settings Navigation Tabs -->
    <div class="card-modern mb-4">
        <ul class="nav nav-pills" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                    <i class="fas fa-cog me-2"></i>{{ __('admin.general') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment" type="button">
                    <i class="fas fa-credit-card me-2"></i>{{ __('admin.payment') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vimeo" type="button">
                    <i class="fab fa-vimeo me-2"></i>{{ __('admin.vimeo') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#languages" type="button">
                    <i class="fas fa-language me-2"></i>{{ __('admin.languages') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#audio" type="button">
                    <i class="fas fa-microphone me-2"></i>{{ __('admin.audio_translation') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#api" type="button">
                    <i class="fas fa-plug me-2"></i>{{ __('admin.api_flutter') }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security" type="button">
                    <i class="fas fa-shield-alt me-2"></i>{{ __('admin.security') }}
                </button>
            </li>
        </ul>
    </div>

    <!-- Settings Content -->
    <div class="tab-content" id="settingsContent">
        <!-- General Settings -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-globe me-2 text-primary"></i>{{ __('admin.general_settings') }}
                </h5>

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    <input type="hidden" name="_group" value="general">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.application_name') }}</label>
                            <input type="text" name="app_name" class="form-control" value="{{ $settings['general']['app_name'] ?? 'Alenwan' }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.application_url') }}</label>
                            <input type="url" name="app_url" class="form-control" value="{{ $settings['general']['app_url'] ?? 'https://alenwan.com' }}" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.support_email') }}</label>
                            <input type="email" name="support_email" class="form-control" value="{{ $settings['general']['support_email'] ?? 'support@alenwan.com' }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.default_timezone') }}</label>
                            <select name="timezone" class="form-select" style="border-radius: 10px;">
                                <option value="UTC" {{ ($settings['general']['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ ($settings['general']['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                <option value="Europe/London" {{ ($settings['general']['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="Asia/Dubai" {{ ($settings['general']['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                <option value="Asia/Riyadh" {{ ($settings['general']['timezone'] ?? '') == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.default_language') }}</label>
                            <select name="default_language" class="form-select" style="border-radius: 10px;">
                                <option value="en" {{ ($settings['general']['default_language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="ar" {{ ($settings['general']['default_language'] ?? '') == 'ar' ? 'selected' : '' }}>Arabic (العربية)</option>
                                <option value="fr" {{ ($settings['general']['default_language'] ?? '') == 'fr' ? 'selected' : '' }}>French (Français)</option>
                                <option value="es" {{ ($settings['general']['default_language'] ?? '') == 'es' ? 'selected' : '' }}>Spanish (Español)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.currency') }}</label>
                            <select name="currency" class="form-select" style="border-radius: 10px;">
                                <option value="USD" {{ ($settings['general']['currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ ($settings['general']['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ ($settings['general']['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="SAR" {{ ($settings['general']['currency'] ?? '') == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                                <option value="AED" {{ ($settings['general']['currency'] ?? '') == 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="fas fa-save me-2"></i>{{ __('admin.save_general_settings') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="tab-pane fade" id="payment" role="tabpanel">
            <div class="card-modern mb-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fab fa-google-pay me-2 text-success"></i>{{ __('admin.google_pay_integration') }}
                </h5>

                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.google_pay_merchant_id') }}</label>
                            <input type="text" class="form-control" placeholder="BCR2DN4T..." style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.environment') }}</label>
                            <select class="form-select" style="border-radius: 10px;">
                                <option>TEST</option>
                                <option>PRODUCTION</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.google_pay_gateway') }}</label>
                        <input type="text" class="form-control" placeholder="example" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.gateway_merchant_id') }}</label>
                        <input type="text" class="form-control" placeholder="exampleGatewayMerchantId" style="border-radius: 10px;">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="googlePayEnabled" checked>
                        <label class="form-check-label" for="googlePayEnabled">
                            {{ __('admin.enable_google_pay') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>{{ __('admin.save_google_pay_settings') }}
                    </button>
                </form>
            </div>

            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fab fa-apple-pay me-2"></i>{{ __('admin.apple_pay_integration') }}
                </h5>

                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.apple_pay_merchant_id') }}</label>
                            <input type="text" class="form-control" placeholder="merchant.com.alenwan" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.payment_processing_certificate') }}</label>
                            <input type="file" class="form-control" accept=".pem" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('admin.merchant_identity_certificate') }}</label>
                        <input type="file" class="form-control" accept=".pem" style="border-radius: 10px;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.display_name') }}</label>
                            <input type="text" class="form-control" value="Alenwan Streaming" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('admin.country_code') }}</label>
                            <input type="text" class="form-control" value="US" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="applePayEnabled" checked>
                        <label class="form-check-label" for="applePayEnabled">
                            {{ __('admin.enable_apple_pay') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save me-2"></i>{{ __('admin.save_apple_pay_settings') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Vimeo Settings -->
        <div class="tab-pane fade" id="vimeo" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fab fa-vimeo me-2 text-info"></i>Vimeo API Configuration
                </h5>

                <form>
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        All video content is streamed from Vimeo. Configure your API credentials to enable video playback.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vimeo Access Token *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="vimeoToken"
                                   placeholder="Enter your Vimeo access token" style="border-radius: 10px 0 0 10px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleTokenVisibility()"
                                    style="border-radius: 0 10px 10px 0;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Get your token from vimeo.com/settings/apps</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client ID</label>
                            <input type="text" class="form-control" placeholder="Your Vimeo Client ID" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Secret</label>
                            <input type="password" class="form-control" placeholder="Your Vimeo Client Secret" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Default Video Quality</label>
                            <select class="form-select" style="border-radius: 10px;">
                                <option>Auto</option>
                                <option>360p</option>
                                <option>540p</option>
                                <option>720p</option>
                                <option>1080p</option>
                                <option>4K</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Folder ID (Optional)</label>
                            <input type="text" class="form-control" placeholder="Vimeo folder/project ID" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Webhook URL for Upload Status</label>
                        <input type="url" class="form-control" value="https://alenwan.com/api/vimeo/webhook" style="border-radius: 10px;" readonly>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="testVimeoConnection()">
                            <i class="fas fa-plug me-2"></i>Test Connection
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Vimeo Settings
                        </button>
                    </div>
                </form>

                <!-- Vimeo Stats -->
                <div class="mt-4">
                    <h6>Vimeo Account Stats</h6>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fab fa-vimeo fa-2x text-info mb-2"></i>
                                <h4>1,245</h4>
                                <small class="text-muted">Total Videos</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-cloud fa-2x text-primary mb-2"></i>
                                <h4>2.5 TB</h4>
                                <small class="text-muted">Storage Used</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-play-circle fa-2x text-success mb-2"></i>
                                <h4>45.2M</h4>
                                <small class="text-muted">Total Plays</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                                <h4>89%</h4>
                                <small class="text-muted">Completion Rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Languages Settings -->
        <div class="tab-pane fade" id="languages" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-language me-2 text-primary"></i>Language Management
                </h5>

                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    RTL languages (Arabic, Hebrew, Persian) will automatically apply right-to-left layout direction.
                </div>

                <!-- Active Languages -->
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Language</th>
                                <th>Native Name</th>
                                <th>Code</th>
                                <th>Direction</th>
                                <th>Translations</th>
                                <th>Default</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="https://flagcdn.com/24x18/gb.png" alt="English" class="me-2">
                                    English
                                </td>
                                <td>English</td>
                                <td><code>en</code></td>
                                <td><span class="badge bg-info">LTR</span></td>
                                <td>
                                    <div class="progress" style="width: 100px; height: 10px;">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                    <small>100%</small>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defaultLang" checked>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr style="background-color: rgba(255, 193, 7, 0.1);">
                                <td>
                                    <img src="https://flagcdn.com/24x18/sa.png" alt="Arabic" class="me-2">
                                    Arabic
                                </td>
                                <td>العربية</td>
                                <td><code>ar</code></td>
                                <td><span class="badge bg-warning">RTL</span></td>
                                <td>
                                    <div class="progress" style="width: 100px; height: 10px;">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                    <small>85%</small>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defaultLang">
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://flagcdn.com/24x18/fr.png" alt="French" class="me-2">
                                    French
                                </td>
                                <td>Français</td>
                                <td><code>fr</code></td>
                                <td><span class="badge bg-info">LTR</span></td>
                                <td>
                                    <div class="progress" style="width: 100px; height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                                    </div>
                                    <small>60%</small>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defaultLang">
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://flagcdn.com/24x18/es.png" alt="Spanish" class="me-2">
                                    Spanish
                                </td>
                                <td>Español</td>
                                <td><code>es</code></td>
                                <td><span class="badge bg-info">LTR</span></td>
                                <td>
                                    <div class="progress" style="width: 100px; height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 45%"></div>
                                    </div>
                                    <small>45%</small>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defaultLang">
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">Inactive</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addLanguageModal">
                    <i class="fas fa-plus me-2"></i>Add New Language
                </button>
            </div>
        </div>

        <!-- Audio Translation Settings -->
        <div class="tab-pane fade" id="audio" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-microphone me-2 text-danger"></i>Audio Translation Settings
                </h5>

                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Configure automatic audio translation for all content using AI-powered services.
                </div>

                <form>
                    <div class="mb-4">
                        <label class="form-label">Translation Service Provider</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="audioProvider" id="googleTTS" checked>
                                    <label class="form-check-label" for="googleTTS">
                                        Google Cloud TTS
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="audioProvider" id="awsPolly">
                                    <label class="form-check-label" for="awsPolly">
                                        Amazon Polly
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="audioProvider" id="azureTTS">
                                    <label class="form-check-label" for="azureTTS">
                                        Azure Speech
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="audioProvider" id="elevenLabs">
                                    <label class="form-check-label" for="elevenLabs">
                                        ElevenLabs
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Key</label>
                            <input type="password" class="form-control" placeholder="Enter your API key" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Secret (if required)</label>
                            <input type="password" class="form-control" placeholder="Enter your API secret" style="border-radius: 10px;">
                        </div>
                    </div>

                    <h6 class="mb-3">Supported Languages for Audio Translation</h6>
                    <div class="row mb-4">
                        @php
                            $audioLangs = [
                                ['lang' => 'English', 'code' => 'en-US', 'voice' => 'Neural'],
                                ['lang' => 'Arabic', 'code' => 'ar-SA', 'voice' => 'Neural'],
                                ['lang' => 'French', 'code' => 'fr-FR', 'voice' => 'Standard'],
                                ['lang' => 'Spanish', 'code' => 'es-ES', 'voice' => 'Neural'],
                                ['lang' => 'German', 'code' => 'de-DE', 'voice' => 'Standard'],
                                ['lang' => 'Italian', 'code' => 'it-IT', 'voice' => 'Standard'],
                            ];
                        @endphp

                        @foreach($audioLangs as $lang)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="audio_{{ $lang['code'] }}" checked>
                                <label class="form-check-label" for="audio_{{ $lang['code'] }}">
                                    {{ $lang['lang'] }} ({{ $lang['code'] }})
                                    <span class="badge bg-info ms-1">{{ $lang['voice'] }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h6 class="mb-3">Voice Settings</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Voice Type</label>
                            <select class="form-select" style="border-radius: 10px;">
                                <option>Neural (Best Quality)</option>
                                <option>Standard</option>
                                <option>WaveNet</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Speaking Rate</label>
                            <input type="range" class="form-range" min="0.5" max="2" step="0.1" value="1">
                            <small class="text-muted">1.0x</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pitch</label>
                            <input type="range" class="form-range" min="-20" max="20" step="1" value="0">
                            <small class="text-muted">0 Hz</small>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="autoTranslate" checked>
                        <label class="form-check-label" for="autoTranslate">
                            Automatically translate audio for new content
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Audio Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- API & Flutter Settings -->
        <div class="tab-pane fade" id="api" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-mobile-alt me-2 text-success"></i>Flutter App API Configuration
                </h5>

                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    Your Flutter app is connected and ready to use these endpoints.
                </div>

                <div class="mb-4">
                    <h6>API Base URL</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" value="https://alenwan.com/api/v1" readonly style="border-radius: 10px 0 0 10px;">
                        <button class="btn btn-outline-secondary" onclick="copyToClipboard('https://alenwan.com/api/v1')" style="border-radius: 0 10px 10px 0;">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <h6>API Key for Flutter App</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" value="sk_live_alenwan_2024_xYz123ABc456" readonly style="border-radius: 10px 0 0 10px;">
                        <button class="btn btn-outline-secondary" onclick="regenerateApiKey()" style="border-radius: 0;">
                            <i class="fas fa-sync"></i>
                        </button>
                        <button class="btn btn-outline-secondary" onclick="copyToClipboard('sk_live_alenwan_2024_xYz123ABc456')" style="border-radius: 0 10px 10px 0;">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <h6 class="mb-3">Available API Endpoints</h6>
                <div class="accordion" id="apiEndpoints">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#authEndpoints">
                                Authentication Endpoints
                            </button>
                        </h2>
                        <div id="authEndpoints" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <code>POST /api/v1/auth/login</code> - User login with Google/Apple<br>
                                <code>POST /api/v1/auth/register</code> - User registration<br>
                                <code>POST /api/v1/auth/logout</code> - User logout<br>
                                <code>GET /api/v1/auth/profile</code> - Get user profile<br>
                                <code>POST /api/v1/auth/google</code> - Google Sign-In<br>
                                <code>POST /api/v1/auth/apple</code> - Apple Sign-In
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contentEndpoints">
                                Content Endpoints
                            </button>
                        </h2>
                        <div id="contentEndpoints" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <code>GET /api/v1/movies</code> - Get all movies<br>
                                <code>GET /api/v1/series</code> - Get all series<br>
                                <code>GET /api/v1/livestreams</code> - Get live streams<br>
                                <code>GET /api/v1/vimeo/video/{id}</code> - Get Vimeo video URL<br>
                                <code>GET /api/v1/content/audio/{id}/{lang}</code> - Get audio translation
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paymentEndpoints">
                                Payment Endpoints
                            </button>
                        </h2>
                        <div id="paymentEndpoints" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <code>POST /api/v1/payment/google-pay</code> - Process Google Pay<br>
                                <code>POST /api/v1/payment/apple-pay</code> - Process Apple Pay<br>
                                <code>POST /api/v1/subscription/create</code> - Create subscription<br>
                                <code>POST /api/v1/coupon/validate</code> - Validate coupon code
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Flutter App Configuration</h6>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="forceUpdate" checked>
                        <label class="form-check-label" for="forceUpdate">
                            Enable force update for app versions below 2.0.0
                        </label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="maintenanceMode">
                        <label class="form-check-label" for="maintenanceMode">
                            Maintenance mode (show message in app)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="tab-pane fade" id="security" role="tabpanel">
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-shield-alt me-2 text-danger"></i>Security Settings
                </h5>

                <form>
                    <div class="mb-4">
                        <h6>Two-Factor Authentication</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="require2FA">
                            <label class="form-check-label" for="require2FA">
                                Require 2FA for admin accounts
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6>API Rate Limiting</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Requests per minute</label>
                                <input type="number" class="form-control" value="60" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Requests per day</label>
                                <input type="number" class="form-control" value="10000" style="border-radius: 10px;">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save me-2"></i>Save Security Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleTokenVisibility() {
        const input = document.getElementById('vimeoToken');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function testVimeoConnection() {
        alert('Testing Vimeo connection...');
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        alert('Copied to clipboard!');
    }

    function regenerateApiKey() {
        if(confirm('Are you sure you want to regenerate the API key?')) {
            alert('New API key generated!');
        }
    }
</script>
@endsection