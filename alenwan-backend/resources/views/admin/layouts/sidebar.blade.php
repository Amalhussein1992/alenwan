<div class="enhanced-sidebar">
    <!-- Logo Section -->
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fas fa-film"></i>
            </div>
            <div class="logo-text">
                <h3>Alenwan</h3>
                <span>Admin Panel</span>
            </div>
        </div>
        <div class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="sidebar-menu">
        <!-- Main Navigation -->
        <div class="menu-section">
            <h6 class="menu-title">{{ __('Main Navigation') }}</h6>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <span class="menu-text">{{ __('admin.dashboard') }}</span>
                <div class="menu-indicator"></div>
            </a>
        </div>

        <!-- Content Management -->
        <div class="menu-section">
            <h6 class="menu-title">{{ __('Content Management') }}</h6>
            <a href="{{ route('admin.movies.index') }}" class="menu-item {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-film"></i>
                </div>
                <span class="menu-text">{{ __('admin.movies') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.series.index') }}" class="menu-item {{ request()->routeIs('admin.series.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-tv"></i>
                </div>
                <span class="menu-text">{{ __('admin.series') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.documentaries.index') }}" class="menu-item {{ request()->routeIs('admin.documentaries.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-book"></i>
                </div>
                <span class="menu-text">{{ __('admin.documentaries') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.sports.index') }}" class="menu-item {{ request()->routeIs('admin.sports.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-football-ball"></i>
                </div>
                <span class="menu-text">{{ __('admin.sports') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.cartoons.index') }}" class="menu-item {{ request()->routeIs('admin.cartoons.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-child"></i>
                </div>
                <span class="menu-text">{{ __('admin.cartoons') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.livestreams.index') }}" class="menu-item {{ request()->routeIs('admin.livestreams.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <span class="menu-text">{{ __('admin.livestreams') }}</span>
                <div class="menu-indicator"></div>
            </a>
        </div>

        <!-- User Management -->
        <div class="menu-section">
            <h6 class="menu-title">{{ __('User Management') }}</h6>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-users"></i>
                </div>
                <span class="menu-text">{{ __('admin.users') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.subscriptions.index') }}" class="menu-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <span class="menu-text">{{ __('admin.subscriptions') }}</span>
                <div class="menu-indicator"></div>
            </a>
        </div>

        <!-- Marketing -->
        <div class="menu-section">
            <h6 class="menu-title">{{ __('Marketing') }}</h6>
            <a href="{{ route('admin.coupons.index') }}" class="menu-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <span class="menu-text">{{ __('admin.coupons') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="{{ route('admin.banners.index') }}" class="menu-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-images"></i>
                </div>
                <span class="menu-text">{{ __('admin.banners') }}</span>
                <div class="menu-indicator"></div>
            </a>
        </div>

        <!-- System -->
        <div class="menu-section">
            <h6 class="menu-title">{{ __('System') }}</h6>
            <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="menu-text">{{ __('admin.settings') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="/admin/translations" class="menu-item {{ request()->is('admin/translations') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-language"></i>
                </div>
                <span class="menu-text">{{ __('Translations') }}</span>
                <div class="menu-indicator"></div>
            </a>
            <a href="/admin/activity-logs" class="menu-item {{ request()->is('admin/activity-logs') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fas fa-history"></i>
                </div>
                <span class="menu-text">{{ __('Activity Logs') }}</span>
                <div class="menu-indicator"></div>
            </a>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
            <div class="menu-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <span class="menu-text">{{ __('admin.logout') }}</span>
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <div class="sidebar-version">
            <small>Version 1.0.0</small>
        </div>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-sidebar-overlay"></div>

<!-- Mobile Menu Button (for navbar) -->
<button class="mobile-menu-btn" id="mobileSidebarToggle">
    <span></span>
    <span></span>
    <span></span>
</button>

<!-- Enhanced Sidebar Styles -->
<style>
:root {
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
    --primary-color: #A20136;
    --primary-gradient: linear-gradient(135deg, #A20136 0%, #8b0000 100%);
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 255, 255, 0.7);
    --bg-primary: #141414;
    --bg-secondary: #000000;
    --border-color: rgba(255, 255, 255, 0.1);
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --shadow-sm: 0 4px 15px rgba(162, 1, 54, 0.2);
    --shadow-lg: 0 10px 25px rgba(162, 1, 54, 0.3);
}

/* Mobile Menu Button */
.mobile-menu-btn {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1002;
    width: 44px;
    height: 44px;
    padding: 0;
    background: var(--primary-color);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.mobile-menu-btn span {
    display: block;
    width: 24px;
    height: 2px;
    background: white;
    margin: 5px auto;
    transition: all 0.3s ease;
}

.mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* Mobile Sidebar Overlay */
.mobile-sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mobile-sidebar-overlay.show {
    display: block;
    opacity: 1;
}

.enhanced-sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    background: linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    border-right: 1px solid var(--border-color);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1001;
    display: flex;
    flex-direction: column;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.enhanced-sidebar.collapsed {
    width: var(--sidebar-collapsed-width);
}

/* Header Section */
.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--primary-gradient);
    color: white;
    position: relative;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.logo-text h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.logo-text span {
    font-size: 0.875rem;
    opacity: 0.8;
    font-weight: 400;
}

.sidebar-toggle {
    position: absolute;
    top: 1.5rem;
    right: 1rem;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.sidebar-toggle:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

/* Removed admin profile section - moved to navbar */

/* Sidebar Menu */
.sidebar-menu {
    flex: 1;
    padding: 2rem 0 1rem;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--border-color) transparent;
}

.sidebar-menu::-webkit-scrollbar {
    width: 4px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 2px;
}

.menu-section {
    margin-bottom: 2rem;
}

.menu-title {
    padding: 0 1.5rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-secondary);
    margin: 0 0 0.5rem 0;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    text-decoration: none;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    margin: 0 0.75rem;
    border-radius: 12px;
}

.menu-item:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: var(--primary-color);
    transform: translateX(4px);
    text-decoration: none;
}

.menu-item.active {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    transform: translateX(4px);
}

.menu-item.active .menu-indicator {
    opacity: 1;
    transform: scale(1);
}

.menu-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.1rem;
}

.menu-text {
    flex: 1;
    white-space: nowrap;
}

.menu-indicator {
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
    background: var(--bg-secondary);
}

.logout-btn {
    display: flex;
    align-items: center;
    padding: 0.875rem 1rem;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 12px;
    text-decoration: none;
    color: var(--danger-color);
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.logout-btn:hover {
    background: var(--danger-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    text-decoration: none;
}

.sidebar-version {
    text-align: center;
    color: var(--text-secondary);
    font-size: 0.75rem;
}

/* Collapsed State */
.enhanced-sidebar.collapsed .logo-text,
.enhanced-sidebar.collapsed .profile-info,
.enhanced-sidebar.collapsed .menu-title,
.enhanced-sidebar.collapsed .menu-text,
.enhanced-sidebar.collapsed .sidebar-version {
    opacity: 0;
    visibility: hidden;
}

.enhanced-sidebar.collapsed .admin-profile {
    justify-content: center;
}

.enhanced-sidebar.collapsed .menu-item {
    justify-content: center;
    margin: 0 0.5rem;
    padding: 0.875rem;
}

.enhanced-sidebar.collapsed .menu-icon {
    margin: 0;
}

.enhanced-sidebar.collapsed .logout-btn {
    justify-content: center;
    padding: 0.875rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .mobile-menu-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .enhanced-sidebar {
        transform: translateX(-100%);
    }

    .enhanced-sidebar.show {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: none;
    }
}

@media (max-width: 768px) {
    .enhanced-sidebar {
        width: 85vw;
        max-width: 320px;
    }

    .mobile-menu-btn {
        top: 15px;
        left: 15px;
    }

    .menu-item {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
    }

    .menu-title {
        font-size: 0.7rem;
    }
}

/* RTL Support */
[dir="rtl"] .enhanced-sidebar {
    left: auto;
    right: 0;
    border-right: none;
    border-left: 1px solid var(--border-color);
}

[dir="rtl"] .logo-container {
    flex-direction: row-reverse;
}

[dir="rtl"] .menu-item {
    flex-direction: row-reverse;
}

[dir="rtl"] .menu-icon {
    margin-right: 0;
    margin-left: 1rem;
}

[dir="rtl"] .menu-item:hover,
[dir="rtl"] .menu-item.active {
    transform: translateX(-4px);
}

/* Animation Effects */
.menu-item {
    overflow: hidden;
}

.menu-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.menu-item:hover::before {
    left: 100%;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const sidebar = document.querySelector('.enhanced-sidebar');
    const overlay = document.querySelector('.mobile-sidebar-overlay');

    // Desktop sidebar toggle
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');

            // Store state in localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });

        // Restore state from localStorage (desktop only)
        if (window.innerWidth > 1024) {
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
            }
        }
    }

    // Mobile sidebar toggle
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            mobileSidebarToggle.classList.toggle('active');
        });
    }

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            if (mobileSidebarToggle) {
                mobileSidebarToggle.classList.remove('active');
            }
        });
    }

    // Close sidebar on mobile when clicking a menu item
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (mobileSidebarToggle) {
                    mobileSidebarToggle.classList.remove('active');
                }
            }
        });
    });

    // Handle swipe gestures for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    sidebar.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    sidebar.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeDistance = touchEndX - touchStartX;
        if (swipeDistance < -50) { // Swipe left
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            if (mobileSidebarToggle) {
                mobileSidebarToggle.classList.remove('active');
            }
        }
    }

    // Adjust for window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            if (mobileSidebarToggle) {
                mobileSidebarToggle.classList.remove('active');
            }
        }
    });
});
</script>