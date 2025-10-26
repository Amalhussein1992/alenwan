@extends('admin.layouts.app')

@section('title', 'Theme Settings')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">Theme Customization</h1>
                <p class="text-muted">Personalize your admin panel appearance</p>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-primary-modern" onclick="saveThemeSettings()">
                    <i class="fas fa-save me-2"></i>Save Theme Settings
                </button>
            </div>
        </div>
    </div>

    <!-- Theme Preview and Selection -->
    <div class="row">
        <!-- Theme Presets -->
        <div class="col-xl-8">
            <div class="card-modern mb-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-palette me-2 text-primary"></i>Theme Presets
                </h5>

                <div class="row">
                    @php
                        $themes = [
                            [
                                'id' => 'default',
                                'name' => 'Default Blue',
                                'primary' => '#6366f1',
                                'secondary' => '#8b5cf6',
                                'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'dark_bg' => '#0f172a',
                                'light_bg' => '#ffffff'
                            ],
                            [
                                'id' => 'emerald',
                                'name' => 'Emerald Green',
                                'primary' => '#10b981',
                                'secondary' => '#14b8a6',
                                'gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                                'dark_bg' => '#022c22',
                                'light_bg' => '#ffffff'
                            ],
                            [
                                'id' => 'sunset',
                                'name' => 'Sunset Orange',
                                'primary' => '#f97316',
                                'secondary' => '#fb923c',
                                'gradient' => 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)',
                                'dark_bg' => '#431407',
                                'light_bg' => '#fff7ed'
                            ],
                            [
                                'id' => 'ocean',
                                'name' => 'Ocean Blue',
                                'primary' => '#0ea5e9',
                                'secondary' => '#38bdf8',
                                'gradient' => 'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)',
                                'dark_bg' => '#082f49',
                                'light_bg' => '#f0f9ff'
                            ],
                            [
                                'id' => 'purple',
                                'name' => 'Royal Purple',
                                'primary' => '#a855f7',
                                'secondary' => '#c084fc',
                                'gradient' => 'linear-gradient(135deg, #a855f7 0%, #9333ea 100%)',
                                'dark_bg' => '#2e1065',
                                'light_bg' => '#faf5ff'
                            ],
                            [
                                'id' => 'rose',
                                'name' => 'Rose Pink',
                                'primary' => '#f43f5e',
                                'secondary' => '#fb7185',
                                'gradient' => 'linear-gradient(135deg, #f43f5e 0%, #e11d48 100%)',
                                'dark_bg' => '#4c0519',
                                'light_bg' => '#fff1f2'
                            ],
                            [
                                'id' => 'dark',
                                'name' => 'Dark Mode Pro',
                                'primary' => '#475569',
                                'secondary' => '#64748b',
                                'gradient' => 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
                                'dark_bg' => '#020617',
                                'light_bg' => '#f8fafc'
                            ],
                            [
                                'id' => 'netflix',
                                'name' => 'Netflix Red',
                                'primary' => '#dc2626',
                                'secondary' => '#ef4444',
                                'gradient' => 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)',
                                'dark_bg' => '#450a0a',
                                'light_bg' => '#fef2f2'
                            ]
                        ];
                    @endphp

                    @foreach($themes as $theme)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="theme-card position-relative" onclick="selectTheme('{{ $theme['id'] }}')"
                             style="cursor: pointer; border-radius: 16px; overflow: hidden; border: 2px solid transparent; transition: all 0.3s;"
                             id="theme-{{ $theme['id'] }}">
                            <!-- Theme Preview -->
                            <div style="height: 120px; background: {{ $theme['gradient'] }}; position: relative;">
                                <div class="position-absolute top-0 start-0 p-3">
                                    <div class="d-flex gap-2">
                                        <div style="width: 12px; height: 12px; background: #ef4444; border-radius: 50%;"></div>
                                        <div style="width: 12px; height: 12px; background: #f59e0b; border-radius: 50%;"></div>
                                        <div style="width: 12px; height: 12px; background: #10b981; border-radius: 50%;"></div>
                                    </div>
                                </div>
                                <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                    <h6 class="mb-0">{{ $theme['name'] }}</h6>
                                </div>
                            </div>

                            <!-- Color Swatches -->
                            <div class="p-3 bg-white">
                                <div class="d-flex gap-2 mb-2">
                                    <div class="color-swatch" style="width: 30px; height: 30px; background: {{ $theme['primary'] }}; border-radius: 8px;"
                                         title="Primary Color"></div>
                                    <div class="color-swatch" style="width: 30px; height: 30px; background: {{ $theme['secondary'] }}; border-radius: 8px;"
                                         title="Secondary Color"></div>
                                    <div class="color-swatch" style="width: 30px; height: 30px; background: {{ $theme['dark_bg'] }}; border-radius: 8px;"
                                         title="Dark Background"></div>
                                    <div class="color-swatch" style="width: 30px; height: 30px; background: {{ $theme['light_bg'] }}; border: 1px solid #e5e7eb; border-radius: 8px;"
                                         title="Light Background"></div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary w-100" onclick="applyTheme('{{ $theme['id'] }}')">
                                    Apply Theme
                                </button>
                            </div>

                            <!-- Selected Badge -->
                            <div class="position-absolute top-0 end-0 p-2 selected-badge d-none">
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Active
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Custom Colors -->
            <div class="card-modern">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-paint-brush me-2 text-success"></i>Custom Colors
                </h5>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Primary Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="primaryColor" value="#6366f1" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#6366f1" id="primaryColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Secondary Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="secondaryColor" value="#8b5cf6" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#8b5cf6" id="secondaryColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Success Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="successColor" value="#10b981" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#10b981" id="successColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Danger Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="dangerColor" value="#ef4444" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#ef4444" id="dangerColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Warning Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="warningColor" value="#f59e0b" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#f59e0b" id="warningColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Info Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="infoColor" value="#3b82f6" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#3b82f6" id="infoColorText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Dark Background</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="darkBg" value="#0f172a" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#0f172a" id="darkBgText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Light Background</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="lightBg" value="#ffffff" style="border-radius: 10px 0 0 10px;">
                            <input type="text" class="form-control" value="#ffffff" id="lightBgText" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" onclick="applyCustomColors()">
                    <i class="fas fa-palette me-2"></i>Apply Custom Colors
                </button>
                <button class="btn btn-outline-secondary ms-2" onclick="resetToDefault()">
                    <i class="fas fa-undo me-2"></i>Reset to Default
                </button>
            </div>
        </div>

        <!-- Right Column - Settings -->
        <div class="col-xl-4">
            <!-- Appearance Settings -->
            <div class="card-modern mb-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-sliders-h me-2 text-warning"></i>Appearance Settings
                </h5>

                <div class="mb-3">
                    <label class="form-label">Default Theme Mode</label>
                    <select class="form-select" id="defaultThemeMode" style="border-radius: 10px;">
                        <option value="light">Light Mode</option>
                        <option value="dark">Dark Mode</option>
                        <option value="auto">Auto (System)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sidebar Style</label>
                    <select class="form-select" id="sidebarStyle" style="border-radius: 10px;">
                        <option value="gradient">Gradient</option>
                        <option value="solid">Solid Color</option>
                        <option value="transparent">Transparent</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Header Style</label>
                    <select class="form-select" id="headerStyle" style="border-radius: 10px;">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="colored">Colored</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Card Style</label>
                    <select class="form-select" id="cardStyle" style="border-radius: 10px;">
                        <option value="shadow">With Shadow</option>
                        <option value="bordered">Bordered</option>
                        <option value="flat">Flat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Border Radius</label>
                    <input type="range" class="form-range" id="borderRadius" min="0" max="30" value="16">
                    <small class="text-muted"><span id="borderRadiusValue">16</span>px</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Font Family</label>
                    <select class="form-select" id="fontFamily" style="border-radius: 10px;">
                        <option value="Inter">Inter</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Open Sans">Open Sans</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="system-ui">System Default</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Font Size</label>
                    <select class="form-select" id="fontSize" style="border-radius: 10px;">
                        <option value="small">Small</option>
                        <option value="medium" selected>Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>
            </div>

            <!-- Animation Settings -->
            <div class="card-modern mb-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-magic me-2 text-info"></i>Animation Settings
                </h5>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="enableAnimations" checked>
                    <label class="form-check-label" for="enableAnimations">
                        Enable Animations
                    </label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="enableTransitions" checked>
                    <label class="form-check-label" for="enableTransitions">
                        Smooth Transitions
                    </label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="enableHoverEffects" checked>
                    <label class="form-check-label" for="enableHoverEffects">
                        Hover Effects
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Animation Speed</label>
                    <select class="form-select" id="animationSpeed" style="border-radius: 10px;">
                        <option value="slow">Slow</option>
                        <option value="normal" selected>Normal</option>
                        <option value="fast">Fast</option>
                    </select>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="card-modern">
                <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-eye me-2 text-primary"></i>Live Preview
                </h5>

                <div class="preview-container" style="border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; height: 200px;">
                    <div class="preview-header" style="background: var(--primary-color); padding: 8px; display: flex; align-items: center;">
                        <div class="d-flex gap-1">
                            <div style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%;"></div>
                            <div style="width: 8px; height: 8px; background: #f59e0b; border-radius: 50%;"></div>
                            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                        </div>
                    </div>
                    <div class="preview-body" style="padding: 12px; background: var(--bg-primary);">
                        <div class="mb-2" style="background: var(--card-bg); padding: 8px; border-radius: 8px;">
                            <div style="background: var(--primary-color); height: 20px; border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="background: var(--text-secondary); height: 12px; border-radius: 4px; opacity: 0.3;"></div>
                        </div>
                        <div class="d-flex gap-2">
                            <div style="background: var(--success-color); height: 30px; flex: 1; border-radius: 6px;"></div>
                            <div style="background: var(--warning-color); height: 30px; flex: 1; border-radius: 6px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export/Import Settings -->
    <div class="card-modern mt-4">
        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
            <i class="fas fa-exchange-alt me-2 text-secondary"></i>Export/Import Theme Settings
        </h5>

        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-outline-primary w-100" onclick="exportThemeSettings()">
                    <i class="fas fa-download me-2"></i>Export Current Theme
                </button>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="file" class="form-control" id="importThemeFile" accept=".json" style="border-radius: 10px 0 0 10px;">
                    <button class="btn btn-outline-success" onclick="importThemeSettings()" style="border-radius: 0 10px 10px 0;">
                        <i class="fas fa-upload me-2"></i>Import
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Theme management
    let currentTheme = localStorage.getItem('selectedTheme') || 'default';

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        selectTheme(currentTheme);

        // Sync color inputs
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('change', function() {
                const textInput = document.getElementById(this.id + 'Text');
                if (textInput) textInput.value = this.value;
            });
        });

        document.querySelectorAll('input[type="text"][id$="Text"]').forEach(input => {
            input.addEventListener('change', function() {
                const colorInput = document.getElementById(this.id.replace('Text', ''));
                if (colorInput) colorInput.value = this.value;
            });
        });

        // Border radius slider
        document.getElementById('borderRadius').addEventListener('input', function() {
            document.getElementById('borderRadiusValue').textContent = this.value;
            document.documentElement.style.setProperty('--border-radius', this.value + 'px');
        });
    });

    function selectTheme(themeId) {
        // Remove active class from all themes
        document.querySelectorAll('.theme-card').forEach(card => {
            card.style.borderColor = 'transparent';
            card.querySelector('.selected-badge')?.classList.add('d-none');
        });

        // Add active class to selected theme
        const selectedCard = document.getElementById('theme-' + themeId);
        if (selectedCard) {
            selectedCard.style.borderColor = '#6366f1';
            selectedCard.querySelector('.selected-badge')?.classList.remove('d-none');
        }

        currentTheme = themeId;
    }

    function applyTheme(themeId) {
        const themes = {
            'default': {
                primary: '#6366f1',
                secondary: '#8b5cf6',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6',
                dark: '#0f172a',
                light: '#ffffff'
            },
            'emerald': {
                primary: '#10b981',
                secondary: '#14b8a6',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#06b6d4',
                dark: '#022c22',
                light: '#ffffff'
            },
            'sunset': {
                primary: '#f97316',
                secondary: '#fb923c',
                success: '#10b981',
                danger: '#dc2626',
                warning: '#f59e0b',
                info: '#0ea5e9',
                dark: '#431407',
                light: '#fff7ed'
            },
            'ocean': {
                primary: '#0ea5e9',
                secondary: '#38bdf8',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#0284c7',
                dark: '#082f49',
                light: '#f0f9ff'
            },
            'purple': {
                primary: '#a855f7',
                secondary: '#c084fc',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#8b5cf6',
                dark: '#2e1065',
                light: '#faf5ff'
            },
            'rose': {
                primary: '#f43f5e',
                secondary: '#fb7185',
                success: '#10b981',
                danger: '#e11d48',
                warning: '#f59e0b',
                info: '#ec4899',
                dark: '#4c0519',
                light: '#fff1f2'
            },
            'dark': {
                primary: '#475569',
                secondary: '#64748b',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6',
                dark: '#020617',
                light: '#f8fafc'
            },
            'netflix': {
                primary: '#dc2626',
                secondary: '#ef4444',
                success: '#10b981',
                danger: '#991b1b',
                warning: '#f59e0b',
                info: '#dc2626',
                dark: '#450a0a',
                light: '#fef2f2'
            }
        };

        const theme = themes[themeId];
        if (theme) {
            // Apply colors to CSS variables
            document.documentElement.style.setProperty('--primary-color', theme.primary);
            document.documentElement.style.setProperty('--secondary-color', theme.secondary);
            document.documentElement.style.setProperty('--success-color', theme.success);
            document.documentElement.style.setProperty('--danger-color', theme.danger);
            document.documentElement.style.setProperty('--warning-color', theme.warning);
            document.documentElement.style.setProperty('--info-color', theme.info);

            // Save to localStorage
            localStorage.setItem('selectedTheme', themeId);
            localStorage.setItem('themeColors', JSON.stringify(theme));

            // Show success message
            alert('Theme applied successfully!');

            // Reload page to apply theme
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
    }

    function applyCustomColors() {
        const customTheme = {
            primary: document.getElementById('primaryColor').value,
            secondary: document.getElementById('secondaryColor').value,
            success: document.getElementById('successColor').value,
            danger: document.getElementById('dangerColor').value,
            warning: document.getElementById('warningColor').value,
            info: document.getElementById('infoColor').value,
            dark: document.getElementById('darkBg').value,
            light: document.getElementById('lightBg').value
        };

        // Apply colors
        Object.keys(customTheme).forEach(key => {
            document.documentElement.style.setProperty(`--${key}-color`, customTheme[key]);
        });

        // Save custom theme
        localStorage.setItem('customTheme', JSON.stringify(customTheme));
        localStorage.setItem('selectedTheme', 'custom');

        alert('Custom colors applied successfully!');
    }

    function resetToDefault() {
        if (confirm('Are you sure you want to reset to default theme?')) {
            localStorage.removeItem('selectedTheme');
            localStorage.removeItem('themeColors');
            localStorage.removeItem('customTheme');
            window.location.reload();
        }
    }

    function saveThemeSettings() {
        const settings = {
            theme: currentTheme,
            mode: document.getElementById('defaultThemeMode').value,
            sidebarStyle: document.getElementById('sidebarStyle').value,
            headerStyle: document.getElementById('headerStyle').value,
            cardStyle: document.getElementById('cardStyle').value,
            borderRadius: document.getElementById('borderRadius').value,
            fontFamily: document.getElementById('fontFamily').value,
            fontSize: document.getElementById('fontSize').value,
            animations: {
                enabled: document.getElementById('enableAnimations').checked,
                transitions: document.getElementById('enableTransitions').checked,
                hoverEffects: document.getElementById('enableHoverEffects').checked,
                speed: document.getElementById('animationSpeed').value
            }
        };

        localStorage.setItem('themeSettings', JSON.stringify(settings));
        alert('Theme settings saved successfully!');
    }

    function exportThemeSettings() {
        const settings = {
            theme: currentTheme,
            colors: JSON.parse(localStorage.getItem('themeColors') || '{}'),
            customTheme: JSON.parse(localStorage.getItem('customTheme') || '{}'),
            settings: JSON.parse(localStorage.getItem('themeSettings') || '{}')
        };

        const blob = new Blob([JSON.stringify(settings, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'alenwan-theme-' + new Date().toISOString().split('T')[0] + '.json';
        a.click();
    }

    function importThemeSettings() {
        const file = document.getElementById('importThemeFile').files[0];
        if (!file) {
            alert('Please select a theme file to import');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const settings = JSON.parse(e.target.result);

                // Apply imported settings
                if (settings.theme) localStorage.setItem('selectedTheme', settings.theme);
                if (settings.colors) localStorage.setItem('themeColors', JSON.stringify(settings.colors));
                if (settings.customTheme) localStorage.setItem('customTheme', JSON.stringify(settings.customTheme));
                if (settings.settings) localStorage.setItem('themeSettings', JSON.stringify(settings.settings));

                alert('Theme imported successfully! Reloading...');
                window.location.reload();
            } catch (error) {
                alert('Error importing theme file: ' + error.message);
            }
        };
        reader.readAsText(file);
    }
</script>

<style>
    .theme-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .color-swatch {
        transition: transform 0.2s;
    }

    .color-swatch:hover {
        transform: scale(1.2);
    }
</style>
@endsection