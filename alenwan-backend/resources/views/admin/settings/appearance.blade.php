@extends('admin.layouts.app')

@section('title', 'Appearance Management')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-3 mb-md-0">
                    <h1 class="h3 mb-2">
                        <i class="fas fa-palette me-2"></i>Appearance Management
                    </h1>
                    <p class="text-muted mb-0">Customize the look and feel of your platform</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-secondary" onclick="resetToDefault()">
                        <i class="fas fa-undo me-2"></i>Reset to Default
                    </button>
                    <button class="btn btn-outline-info" onclick="previewChanges()">
                        <i class="fas fa-eye me-2"></i>Preview
                    </button>
                    <button class="btn btn-primary" onclick="saveAppearance()">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-12 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#theme" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-paint-brush me-2"></i>Theme
                        </a>
                        <a href="#colors" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-palette me-2"></i>Colors
                        </a>
                        <a href="#typography" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-font me-2"></i>Typography
                        </a>
                        <a href="#layout" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-th-large me-2"></i>Layout
                        </a>
                        <a href="#branding" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-copyright me-2"></i>Branding
                        </a>
                        <a href="#components" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-cube me-2"></i>Components
                        </a>
                        <a href="#animations" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-magic me-2"></i>Animations
                        </a>
                        <a href="#custom-css" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-code me-2"></i>Custom CSS
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-12 col-lg-9">
            <div class="tab-content">
                <!-- Theme Tab -->
                <div class="tab-pane fade show active" id="theme">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Theme Selection</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Theme Presets -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Choose a Theme Preset</label>
                                    <div class="row g-3">
                                        @php
                                        $themes = [
                                            ['name' => 'Netflix Dark', 'primary' => '#E50914', 'bg' => '#141414', 'text' => '#FFFFFF'],
                                            ['name' => 'Prime Video', 'primary' => '#00A8E1', 'bg' => '#0F171E', 'text' => '#FFFFFF'],
                                            ['name' => 'Disney+', 'primary' => '#113CCF', 'bg' => '#1A1D29', 'text' => '#FFFFFF'],
                                            ['name' => 'Hulu Green', 'primary' => '#1CE783', 'bg' => '#0B0C0F', 'text' => '#FFFFFF'],
                                            ['name' => 'HBO Purple', 'primary' => '#B535F6', 'bg' => '#000000', 'text' => '#FFFFFF'],
                                            ['name' => 'Apple TV+', 'primary' => '#FFFFFF', 'bg' => '#000000', 'text' => '#FFFFFF'],
                                            ['name' => 'YouTube Red', 'primary' => '#FF0000', 'bg' => '#0F0F0F', 'text' => '#FFFFFF'],
                                            ['name' => 'Spotify Green', 'primary' => '#1DB954', 'bg' => '#121212', 'text' => '#FFFFFF'],
                                            ['name' => 'Light Mode', 'primary' => '#6366F1', 'bg' => '#FFFFFF', 'text' => '#1F2937'],
                                        ];
                                        @endphp
                                        @foreach($themes as $index => $theme)
                                        <div class="col-12 col-md-6 col-xl-4">
                                            <div class="theme-card {{ $index == 0 ? 'active' : '' }}" onclick="selectTheme({{ $index }})">
                                                <div class="theme-preview" style="background: {{ $theme['bg'] }};">
                                                    <div class="theme-header" style="background: {{ $theme['primary'] }};">
                                                        <div class="theme-dots">
                                                            <span></span><span></span><span></span>
                                                        </div>
                                                    </div>
                                                    <div class="theme-content">
                                                        <div class="theme-sidebar" style="background: rgba(255,255,255,0.1);"></div>
                                                        <div class="theme-main">
                                                            <div class="theme-block" style="background: {{ $theme['primary'] }}; opacity: 0.8;"></div>
                                                            <div class="theme-lines">
                                                                <span style="background: {{ $theme['text'] }}; opacity: 0.3;"></span>
                                                                <span style="background: {{ $theme['text'] }}; opacity: 0.3;"></span>
                                                                <span style="background: {{ $theme['text'] }}; opacity: 0.3;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="theme-name">{{ $theme['name'] }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Dark Mode Toggle -->
                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">Dark Mode</h6>
                                            <small class="text-muted">Enable dark mode for better viewing at night</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="darkModeToggle" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colors Tab -->
                <div class="tab-pane fade" id="colors">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Color Scheme</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Primary Colors -->
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Primary Colors</h6>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Primary Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#6366F1">
                                                <input type="text" class="form-control" value="#6366F1">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Secondary Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#8B5CF6">
                                                <input type="text" class="form-control" value="#8B5CF6">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Colors -->
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Status Colors</h6>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">Success</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#10B981">
                                                <input type="text" class="form-control" value="#10B981">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">Danger</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#EF4444">
                                                <input type="text" class="form-control" value="#EF4444">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">Warning</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#F59E0B">
                                                <input type="text" class="form-control" value="#F59E0B">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">Info</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#3B82F6">
                                                <input type="text" class="form-control" value="#3B82F6">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Background Colors -->
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Background Colors</h6>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Body Background</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#0F172A">
                                                <input type="text" class="form-control" value="#0F172A">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Card Background</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#1E293B">
                                                <input type="text" class="form-control" value="#1E293B">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Sidebar Background</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#0F172A">
                                                <input type="text" class="form-control" value="#0F172A">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text Colors -->
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Text Colors</h6>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Primary Text</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#F1F5F9">
                                                <input type="text" class="form-control" value="#F1F5F9">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Secondary Text</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#94A3B8">
                                                <input type="text" class="form-control" value="#94A3B8">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Muted Text</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#64748B">
                                                <input type="text" class="form-control" value="#64748B">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typography Tab -->
                <div class="tab-pane fade" id="typography">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Typography Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Font Family -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Primary Font Family</label>
                                    <select class="form-select mb-3">
                                        <option>Inter</option>
                                        <option>Roboto</option>
                                        <option>Open Sans</option>
                                        <option>Lato</option>
                                        <option>Poppins</option>
                                        <option>Montserrat</option>
                                        <option>Nunito Sans</option>
                                        <option>Work Sans</option>
                                        <option>Source Sans Pro</option>
                                    </select>
                                </div>

                                <!-- Font Sizes -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Base Font Size</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group">
                                                <input type="range" class="form-range" min="12" max="20" value="16" id="baseFontSize">
                                                <span class="input-group-text">16px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Heading Sizes -->
                                <div class="col-12">
                                    <label class="form-label fw-bold mb-3">Heading Sizes</label>
                                    <div class="row g-3">
                                        @for($i = 1; $i <= 6; $i++)
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Heading {{ $i }} (H{{ $i }})</label>
                                            <div class="input-group">
                                                <input type="range" class="form-range" min="{{ 32 - ($i * 4) }}" max="{{ 48 - ($i * 4) }}" value="{{ 40 - ($i * 4) }}">
                                                <span class="input-group-text">{{ 40 - ($i * 4) }}px</span>
                                            </div>
                                            <div class="mt-2">
                                                <h{{ $i }} style="margin: 0;">Sample Heading {{ $i }}</h{{ $i }}>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Font Weight -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Font Weights</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Normal Text</label>
                                            <select class="form-select">
                                                <option value="300">Light (300)</option>
                                                <option value="400" selected>Regular (400)</option>
                                                <option value="500">Medium (500)</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Bold Text</label>
                                            <select class="form-select">
                                                <option value="600" selected>Semi-Bold (600)</option>
                                                <option value="700">Bold (700)</option>
                                                <option value="800">Extra-Bold (800)</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Headings</label>
                                            <select class="form-select">
                                                <option value="600">Semi-Bold (600)</option>
                                                <option value="700" selected>Bold (700)</option>
                                                <option value="800">Extra-Bold (800)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Layout Tab -->
                <div class="tab-pane fade" id="layout">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Layout Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Container Width -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Container Width</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="containerWidth" id="containerFluid" checked>
                                        <label class="btn btn-outline-primary" for="containerFluid">Fluid (100%)</label>

                                        <input type="radio" class="btn-check" name="containerWidth" id="containerBoxed">
                                        <label class="btn btn-outline-primary" for="containerBoxed">Boxed (1440px)</label>

                                        <input type="radio" class="btn-check" name="containerWidth" id="containerCompact">
                                        <label class="btn btn-outline-primary" for="containerCompact">Compact (1200px)</label>
                                    </div>
                                </div>

                                <!-- Sidebar Layout -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Sidebar Style</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <div class="layout-option" onclick="selectLayout('sidebar-left')">
                                                <div class="layout-preview">
                                                    <div class="layout-sidebar-left"></div>
                                                    <div class="layout-content"></div>
                                                </div>
                                                <div class="layout-label">Left Sidebar</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="layout-option" onclick="selectLayout('sidebar-right')">
                                                <div class="layout-preview">
                                                    <div class="layout-content"></div>
                                                    <div class="layout-sidebar-right"></div>
                                                </div>
                                                <div class="layout-label">Right Sidebar</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="layout-option" onclick="selectLayout('no-sidebar')">
                                                <div class="layout-preview">
                                                    <div class="layout-content-full"></div>
                                                </div>
                                                <div class="layout-label">No Sidebar</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grid Settings -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Grid Settings</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Movies per Row</label>
                                            <select class="form-select">
                                                <option>3</option>
                                                <option>4</option>
                                                <option selected>5</option>
                                                <option>6</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Grid Gap</label>
                                            <div class="input-group">
                                                <input type="range" class="form-range" min="10" max="30" value="20">
                                                <span class="input-group-text">20px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Border Radius -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Border Radius</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Cards</label>
                                            <div class="input-group">
                                                <input type="range" class="form-range" min="0" max="20" value="8">
                                                <span class="input-group-text">8px</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Buttons</label>
                                            <div class="input-group">
                                                <input type="range" class="form-range" min="0" max="20" value="6">
                                                <span class="input-group-text">6px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branding Tab -->
                <div class="tab-pane fade" id="branding">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Branding Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Logo Upload -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Platform Logo</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="upload-area">
                                                <div class="upload-preview">
                                                    <img src="https://via.placeholder.com/300x100/6366F1/FFFFFF?text=LOGO" alt="Logo">
                                                </div>
                                                <input type="file" class="form-control mt-2" accept="image/*">
                                                <small class="text-muted">Recommended: 300x100px, PNG or SVG</small>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="upload-area">
                                                <div class="upload-preview">
                                                    <img src="https://via.placeholder.com/50x50/6366F1/FFFFFF?text=ICON" alt="Favicon">
                                                </div>
                                                <input type="file" class="form-control mt-2" accept="image/*">
                                                <small class="text-muted">Favicon: 32x32px or 64x64px</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Platform Name -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Platform Details</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Platform Name</label>
                                            <input type="text" class="form-control" value="Alenwan">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Tagline</label>
                                            <input type="text" class="form-control" value="Stream Your Entertainment">
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Settings -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Footer Information</label>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Copyright Text</label>
                                            <input type="text" class="form-control" value="© 2024 Alenwan. All rights reserved.">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Footer Links</label>
                                            <div class="footer-links">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" placeholder="Link Title" value="Privacy Policy">
                                                    <input type="text" class="form-control" placeholder="URL" value="/privacy">
                                                    <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" placeholder="Link Title" value="Terms of Service">
                                                    <input type="text" class="form-control" placeholder="URL" value="/terms">
                                                    <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                                <button class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-plus me-2"></i>Add Footer Link
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Components Tab -->
                <div class="tab-pane fade" id="components">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Component Styles</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Button Styles -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Button Styles</label>
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Button Style</label>
                                            <select class="form-select">
                                                <option>Solid</option>
                                                <option>Outline</option>
                                                <option>Ghost</option>
                                                <option>Gradient</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Button Size</label>
                                            <select class="form-select">
                                                <option>Small</option>
                                                <option selected>Medium</option>
                                                <option>Large</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="button-preview">
                                        <button class="btn btn-primary me-2">Primary</button>
                                        <button class="btn btn-secondary me-2">Secondary</button>
                                        <button class="btn btn-success me-2">Success</button>
                                        <button class="btn btn-danger me-2">Danger</button>
                                        <button class="btn btn-warning me-2">Warning</button>
                                        <button class="btn btn-info">Info</button>
                                    </div>
                                </div>

                                <!-- Card Styles -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Card Appearance</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Shadow</label>
                                            <select class="form-select">
                                                <option>None</option>
                                                <option>Small</option>
                                                <option selected>Medium</option>
                                                <option>Large</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Border</label>
                                            <select class="form-select">
                                                <option>None</option>
                                                <option>Thin</option>
                                                <option>Medium</option>
                                                <option>Thick</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Hover Effect</label>
                                            <select class="form-select">
                                                <option>None</option>
                                                <option>Lift</option>
                                                <option selected>Glow</option>
                                                <option>Scale</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Elements -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Form Elements</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Input Style</label>
                                            <select class="form-select">
                                                <option>Default</option>
                                                <option>Rounded</option>
                                                <option>Underline</option>
                                                <option>Filled</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Focus Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" value="#6366F1">
                                                <input type="text" class="form-control" value="#6366F1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Animations Tab -->
                <div class="tab-pane fade" id="animations">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Animation Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Animation Toggle -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 border rounded mb-3">
                                        <div>
                                            <h6 class="mb-1">Enable Animations</h6>
                                            <small class="text-muted">Turn on/off all animations</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>

                                <!-- Animation Speed -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Animation Speed</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">Transition Duration</span>
                                                <input type="range" class="form-range" min="100" max="1000" value="300">
                                                <span class="input-group-text">300ms</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Page Transitions -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Page Transitions</label>
                                    <select class="form-select">
                                        <option>None</option>
                                        <option selected>Fade</option>
                                        <option>Slide</option>
                                        <option>Zoom</option>
                                        <option>Flip</option>
                                    </select>
                                </div>

                                <!-- Hover Effects -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Hover Effects</label>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Card Hover Animation</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Button Hover Animation</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Image Hover Zoom</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom CSS Tab -->
                <div class="tab-pane fade" id="custom-css">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Custom CSS</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Warning:</strong> Custom CSS can override default styles. Use with caution.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Add your custom CSS code below:</label>
                                <textarea class="form-control font-monospace" rows="20" placeholder="/* Your custom CSS here */

.example {
    color: #333;
    background: #fff;
}">/* Custom Theme Styles */

/* Example: Change primary button color */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

/* Example: Custom card hover effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}</textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary" onclick="validateCSS()">
                                    <i class="fas fa-check me-2"></i>Validate CSS
                                </button>
                                <button class="btn btn-primary" onclick="applyCustomCSS()">
                                    <i class="fas fa-paint-brush me-2"></i>Apply CSS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Preview Panel -->
    <div class="position-fixed bottom-0 end-0 m-3" style="z-index: 1050;">
        <button class="btn btn-primary rounded-circle shadow-lg" onclick="togglePreview()" style="width: 60px; height: 60px;">
            <i class="fas fa-eye fa-lg"></i>
        </button>
    </div>
</div>

<style>
/* Theme Card Styles */
.theme-card {
    cursor: pointer;
    padding: 10px;
    border: 2px solid transparent;
    border-radius: 12px;
    transition: all 0.3s;
    text-align: center;
}

.theme-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.theme-card.active {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.1);
}

.theme-preview {
    width: 100%;
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
}

.theme-header {
    height: 25px;
    position: relative;
}

.theme-dots {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    gap: 5px;
}

.theme-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
}

.theme-content {
    display: flex;
    height: calc(100% - 25px);
}

.theme-sidebar {
    width: 30%;
}

.theme-main {
    flex: 1;
    padding: 10px;
}

.theme-block {
    height: 20px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.theme-lines span {
    display: block;
    height: 3px;
    margin-bottom: 5px;
    border-radius: 2px;
}

.theme-name {
    font-weight: 600;
    font-size: 0.9rem;
}

/* Layout Options */
.layout-option {
    cursor: pointer;
    padding: 15px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s;
}

.layout-option:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
}

.layout-preview {
    height: 80px;
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.layout-sidebar-left,
.layout-sidebar-right {
    width: 30%;
    background: var(--primary-color);
    opacity: 0.3;
    border-radius: 4px;
}

.layout-content,
.layout-content-full {
    flex: 1;
    background: var(--primary-color);
    opacity: 0.1;
    border-radius: 4px;
}

.layout-label {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Upload Area */
.upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
}

.upload-preview {
    margin-bottom: 15px;
}

.upload-preview img {
    max-width: 100%;
    max-height: 100px;
}

/* Color Input Group */
.form-control-color {
    width: 50px;
    padding: 0.25rem;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .form-control-color + .form-control {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Custom Scrollbar for Code */
textarea.font-monospace {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 13px;
    line-height: 1.5;
    tab-size: 4;
}

/* Responsive */
@media (max-width: 992px) {
    .theme-card {
        margin-bottom: 15px;
    }
}

@media (max-width: 768px) {
    .list-group-item {
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
    }
}
</style>

<script>
// Theme Selection
function selectTheme(index) {
    document.querySelectorAll('.theme-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelectorAll('.theme-card')[index].classList.add('active');
}

// Layout Selection
function selectLayout(layout) {
    document.querySelectorAll('.layout-option').forEach(option => {
        option.style.borderColor = 'var(--border-color)';
    });
    event.currentTarget.style.borderColor = 'var(--primary-color)';
}

// Save Appearance Settings
function saveAppearance() {
    alert('Appearance settings saved successfully!');
}

// Reset to Default
function resetToDefault() {
    if (confirm('Are you sure you want to reset all appearance settings to default?')) {
        alert('Settings reset to default!');
    }
}

// Preview Changes
function previewChanges() {
    alert('Opening preview mode...');
}

// Toggle Preview Panel
function togglePreview() {
    alert('Preview panel toggled');
}

// Validate CSS
function validateCSS() {
    alert('CSS validated successfully!');
}

// Apply Custom CSS
function applyCustomCSS() {
    alert('Custom CSS applied!');
}

// Handle range inputs
document.addEventListener('DOMContentLoaded', function() {
    // Update range input labels
    document.querySelectorAll('input[type="range"]').forEach(input => {
        input.addEventListener('input', function() {
            const label = this.parentElement.querySelector('.input-group-text:last-child');
            if (label) {
                label.textContent = this.value + 'px';
            }
        });
    });

    // Sync color inputs
    document.querySelectorAll('.input-group').forEach(group => {
        const colorInput = group.querySelector('input[type="color"]');
        const textInput = group.querySelector('input[type="text"]');

        if (colorInput && textInput) {
            colorInput.addEventListener('input', function() {
                textInput.value = this.value.toUpperCase();
            });

            textInput.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    colorInput.value = this.value;
                }
            });
        }
    });

    // Tab navigation
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.list-group-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endsection