<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Alenwan Admin') - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #a20136;
            --primary-dark: #7a0129;
            --secondary-color: #d4154e;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 70px;
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --border-color: #334155;
            --card-bg: #1e293b;
        }

        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            margin-right: 12px;
            border-radius: 10px;
        }

        [dir="rtl"] .sidebar-logo img {
            margin-right: 0;
            margin-left: 12px;
        }

        .sidebar.collapsed .sidebar-logo span {
            display: none;
        }

        .sidebar-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            padding: 0 1rem;
            margin-bottom: 1rem;
        }

        .menu-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            padding: 0 0.5rem;
        }

        .sidebar.collapsed .menu-section-title {
            display: none;
        }

        .menu-item {
            display: block;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        [dir="rtl"] .menu-item:hover {
            transform: translateX(-5px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: white;
            border-radius: 0 3px 3px 0;
        }

        [dir="rtl"] .menu-item.active::before {
            left: auto;
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        [dir="rtl"] .menu-item i {
            margin-right: 0;
            margin-left: 12px;
        }

        .sidebar.collapsed .menu-item {
            padding: 0.75rem;
            display: flex;
            justify-content: center;
        }

        .sidebar.collapsed .menu-item i {
            margin: 0;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .menu-badge {
            background: var(--danger-color);
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: auto;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            transition: all 0.3s ease;
            z-index: 999;
        }

        [dir="rtl"] .header {
            left: 0;
            right: var(--sidebar-width);
        }

        .sidebar.collapsed ~ .main-wrapper .header {
            left: var(--sidebar-collapsed);
        }

        [dir="rtl"] .sidebar.collapsed ~ .main-wrapper .header {
            left: 0;
            right: var(--sidebar-collapsed);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .search-box {
            position: relative;
            width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-btn {
            position: relative;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-btn:hover {
            background: var(--bg-tertiary);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            background: var(--bg-secondary);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        [dir="rtl"] .main-wrapper {
            margin-left: 0;
            margin-right: var(--sidebar-width);
        }

        .sidebar.collapsed ~ .main-wrapper {
            margin-left: var(--sidebar-collapsed);
        }

        [dir="rtl"] .sidebar.collapsed ~ .main-wrapper {
            margin-left: 0;
            margin-right: var(--sidebar-collapsed);
        }

        .main-content {
            padding: 2rem;
        }

        /* Card Styles */
        .card-modern {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stat-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .stat-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        /* Table Styles */
        .table-modern {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-modern thead {
            background: var(--bg-secondary);
        }

        .table-modern th {
            padding: 1rem;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table-modern td {
            padding: 1rem;
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background: var(--bg-secondary);
        }

        /* Button Styles */
        .btn-modern {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Mobile Menu Toggle Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1002;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.1);
        }

        .mobile-menu-btn.active {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .search-box {
                width: 300px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed);
            }

            .sidebar .menu-section-title,
            .sidebar .menu-item span,
            .sidebar .menu-badge {
                display: none;
            }

            .sidebar .menu-item {
                justify-content: center;
                padding: 0.75rem;
            }

            .sidebar .menu-item i {
                margin: 0;
                font-size: 1.2rem;
            }

            .sidebar-logo span {
                display: none;
            }

            .sidebar-toggle {
                display: none;
            }

            .header {
                left: var(--sidebar-collapsed);
            }

            .main-wrapper {
                margin-left: var(--sidebar-collapsed);
            }

            .sidebar:hover {
                width: var(--sidebar-width);
                box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            }

            .sidebar:hover .menu-section-title,
            .sidebar:hover .menu-item span,
            .sidebar:hover .menu-badge,
            .sidebar:hover .sidebar-logo span {
                display: block;
            }

            .sidebar:hover .menu-item {
                justify-content: flex-start;
                padding: 0.75rem 1rem;
            }

            .sidebar:hover .menu-item i {
                margin-right: 12px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                z-index: 1001;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar .menu-section-title,
            .sidebar .menu-item span,
            .sidebar .menu-badge,
            .sidebar .sidebar-logo span {
                display: block !important;
            }

            .sidebar .menu-item {
                justify-content: flex-start !important;
                padding: 0.75rem 1rem !important;
            }

            .sidebar .menu-item i {
                margin-right: 12px !important;
            }

            .header {
                left: 0;
                padding: 0 1rem;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .search-box {
                width: 150px;
            }

            .search-box input::placeholder {
                font-size: 0.85rem;
            }

            .user-info {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .theme-toggle {
                bottom: 90px;
            }

            /* Hide some header buttons on mobile */
            .header-btn:nth-child(1) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding: 0 0.5rem;
                height: 60px;
            }

            .header-left {
                flex: 1;
            }

            .search-box {
                display: none;
            }

            .header-btn {
                padding: 0.4rem 0.6rem;
                font-size: 1rem;
            }

            .mobile-menu-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .theme-toggle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            /* Card and table responsive */
            .card-modern {
                padding: 1rem;
                border-radius: 12px;
            }

            .stat-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            /* Make tables scroll horizontally */
            .table-modern {
                min-width: 600px;
            }
        }

        /* Tablet specific adjustments */
        @media (min-width: 769px) and (max-width: 991px) {
            .stat-value {
                font-size: 1.5rem;
            }

            .card-modern {
                padding: 1.25rem;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease;
        }
    </style>

    @include('admin.partials.responsive-styles')
    @yield('styles')
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
        <i class="fas fa-bars" id="mobileMenuIcon"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileMenu()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/admin/dashboard" class="sidebar-logo">
                <i class="fas fa-film"></i>
                <span>Alenwan</span>
            </a>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">{{ __('admin.main') }}</div>
                <a href="/admin/dashboard" class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>{{ __('admin.dashboard') }}</span>
                </a>
                <a href="/admin/analytics" class="menu-item {{ Request::is('admin/analytics') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>{{ __('admin.analytics') }}</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">{{ __('admin.content') }}</div>
                <a href="/admin/movies" class="menu-item {{ Request::is('admin/movies*') ? 'active' : '' }}">
                    <i class="fas fa-film"></i>
                    <span>{{ __('admin.movies') }}</span>
                    <span class="menu-badge">12</span>
                </a>
                <a href="/admin/series" class="menu-item {{ Request::is('admin/series*') ? 'active' : '' }}">
                    <i class="fas fa-tv"></i>
                    <span>{{ __('admin.series') }}</span>
                </a>
                <a href="/admin/documentaries" class="menu-item {{ Request::is('admin/documentaries*') ? 'active' : '' }}">
                    <i class="fas fa-video"></i>
                    <span>{{ __('admin.documentaries') }}</span>
                </a>
                <a href="/admin/sports" class="menu-item {{ Request::is('admin/sports*') ? 'active' : '' }}">
                    <i class="fas fa-football-ball"></i>
                    <span>{{ __('admin.sports') }}</span>
                </a>
                <a href="/admin/cartoons" class="menu-item {{ Request::is('admin/cartoons*') ? 'active' : '' }}">
                    <i class="fas fa-child"></i>
                    <span>{{ __('admin.cartoons') }}</span>
                </a>
                <a href="/admin/livestreams" class="menu-item {{ Request::is('admin/livestreams*') ? 'active' : '' }}">
                    <i class="fas fa-broadcast-tower"></i>
                    <span>{{ __('admin.livestreams') }}</span>
                </a>
                <a href="/admin/channels" class="menu-item {{ Request::is('admin/channels*') ? 'active' : '' }}">
                    <i class="fas fa-satellite-dish"></i>
                    <span>{{ __('admin.channels') }}</span>
                </a>
                <a href="/admin/categories" class="menu-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    <span>{{ __('admin.categories') }}</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">{{ __('admin.users_section') }}</div>
                <a href="/admin/users" class="menu-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>{{ __('admin.all_users') }}</span>
                </a>
                <a href="/admin/subscriptions" class="menu-item {{ Request::is('admin/subscriptions*') ? 'active' : '' }}">
                    <i class="fas fa-crown"></i>
                    <span>{{ __('admin.subscriptions') }}</span>
                </a>
                <a href="/admin/subscription-plans" class="menu-item {{ Request::is('admin/subscription-plans*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>{{ __('admin.plans') }}</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">{{ __('admin.settings_section') }}</div>
                <a href="/admin/settings/general" class="menu-item {{ Request::is('admin/settings/general*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>{{ __('admin.general') }}</span>
                </a>
                <a href="/admin/settings/appearance" class="menu-item {{ Request::is('admin/settings/appearance*') ? 'active' : '' }}">
                    <i class="fas fa-palette"></i>
                    <span>{{ __('admin.appearance') }}</span>
                </a>
                <a href="/admin/translations" class="menu-item {{ Request::is('admin/translations*') ? 'active' : '' }}">
                    <i class="fas fa-language"></i>
                    <span>{{ __('admin.translations') }}</span>
                </a>
                <a href="/admin/settings/security" class="menu-item {{ Request::is('admin/settings/security*') ? 'active' : '' }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>{{ __('admin.security') }}</span>
                </a>
                <a href="/admin/settings/api" class="menu-item {{ Request::is('admin/settings/api*') ? 'active' : '' }}">
                    <i class="fas fa-plug"></i>
                    <span>{{ __('admin.api_keys') }}</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="{{ __('admin.search') }}...">
                </div>
            </div>

            <div class="header-right">
                <div class="dropdown">
                    <button class="header-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="?lang=en">
                                <i class="fas fa-check me-2" style="opacity: {{ app()->getLocale() === 'en' ? '1' : '0' }};"></i>
                                English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'ar' ? 'active' : '' }}" href="?lang=ar">
                                <i class="fas fa-check me-2" style="opacity: {{ app()->getLocale() === 'ar' ? '1' : '0' }};"></i>
                                العربية
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}" href="?lang=fr">
                                <i class="fas fa-check me-2" style="opacity: {{ app()->getLocale() === 'fr' ? '1' : '0' }};"></i>
                                Français
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'es' ? 'active' : '' }}" href="?lang=es">
                                <i class="fas fa-check me-2" style="opacity: {{ app()->getLocale() === 'es' ? '1' : '0' }};"></i>
                                Español
                            </a>
                        </li>
                    </ul>
                </div>

                <button class="header-btn" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i>
                </button>

                <button class="header-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <button class="header-btn">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </button>

                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=a20136&color=fff" alt="Admin" class="user-avatar">
                        <div class="user-info">
                            <span class="user-name">{{ __('admin.admin_user') }}</span>
                            <span class="user-role">{{ __('admin.super_admin') }}</span>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/admin/profile"><i class="fas fa-user me-2"></i> {{ __('admin.profile') }}</a></li>
                        <li><a class="dropdown-item" href="/admin/settings"><i class="fas fa-cog me-2"></i> {{ __('admin.settings') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="/admin/logout">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('admin.logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Theme Toggle -->
    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon" id="theme-icon"></i>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuBtn = document.getElementById('mobileMenuBtn');
            const menuIcon = document.getElementById('mobileMenuIcon');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            menuBtn.classList.toggle('active');

            if (sidebar.classList.contains('mobile-open')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuBtn = document.getElementById('mobileMenuBtn');
            const menuIcon = document.getElementById('mobileMenuIcon');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }

        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth <= 768) {
                // On mobile, use mobile menu
                toggleMobileMenu();
            } else {
                // On desktop, use collapse
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        // Toggle Theme
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            const icon = document.getElementById('theme-icon');

            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            if (newTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // Toggle Fullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    closeMobileMenu();
                }
            }, 250);
        });

        // Close mobile menu on navigation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.menu-item').forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(closeMobileMenu, 100);
                    }
                });
            });
        });

        // Load saved preferences
        document.addEventListener('DOMContentLoaded', function() {
            // Load sidebar state (only on desktop)
            if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }

            // Load theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);

            const icon = document.getElementById('theme-icon');
            if (savedTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>