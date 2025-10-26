<!-- Comprehensive Responsive Styles for Admin Panel -->
<style>
/* ============================= */
/* RESPONSIVE BREAKPOINTS */
/* ============================= */
/*
  - Mobile: 320px - 767px
  - Tablet: 768px - 1023px
  - Desktop: 1024px - 1439px
  - Large Desktop: 1440px+
*/

/* ============================= */
/* MOBILE FIRST BASE STYLES */
/* ============================= */

/* Container Responsive */
@media (max-width: 1536px) {
    .container, .dashboard-container, .activity-logs-container,
    .translations-container, .user-management-container {
        max-width: 1280px;
    }
}

@media (max-width: 1280px) {
    .container, .dashboard-container, .activity-logs-container,
    .translations-container, .user-management-container {
        max-width: 1024px;
    }
}

@media (max-width: 1024px) {
    .container, .dashboard-container, .activity-logs-container,
    .translations-container, .user-management-container {
        max-width: 768px;
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .container, .dashboard-container, .activity-logs-container,
    .translations-container, .user-management-container {
        max-width: 100%;
        padding: 1rem;
    }
}

/* ============================= */
/* SIDEBAR RESPONSIVE */
/* ============================= */

/* Mobile Overlay Sidebar */
@media (max-width: 1024px) {
    .enhanced-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        width: 280px;
    }

    .enhanced-sidebar.mobile-open {
        transform: translateX(0);
    }

    /* Overlay backdrop */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
    }

    .sidebar-overlay.show {
        display: block;
    }

    /* Main content adjustment */
    .main-content {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .enhanced-sidebar {
        width: 100%;
        max-width: 300px;
    }
}

/* ============================= */
/* NAVBAR RESPONSIVE */
/* ============================= */

@media (max-width: 1024px) {
    .enhanced-navbar {
        padding: 0.75rem 1rem;
    }

    .mobile-sidebar-toggle {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mobile-sidebar-toggle:hover {
        transform: scale(1.05);
    }
}

@media (max-width: 768px) {
    .nav-container {
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .header-actions {
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        gap: 0.5rem;
    }

    .header-actions .btn {
        flex: 1;
        min-width: 100px;
        font-size: 0.85rem;
    }

    /* Hide desktop elements */
    .d-none.d-md-flex {
        display: none !important;
    }

    /* Language switcher */
    .language-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    /* Theme toggle */
    .theme-toggle {
        width: 36px;
        height: 36px;
    }

    /* Profile dropdown */
    .profile-btn {
        padding: 0.5rem;
    }

    .profile-menu {
        width: 280px;
        right: -1rem;
        left: auto;
        border-radius: 0;
    }
}

@media (max-width: 480px) {
    .profile-menu {
        width: 100vw;
        right: 0;
        border-radius: 0;
        top: 100%;
    }

    .language-dropdown {
        width: 200px;
    }
}

/* ============================= */
/* DASHBOARD CARDS RESPONSIVE */
/* ============================= */

/* Stats Cards Grid */
@media (max-width: 1280px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-card h3 {
        font-size: 0.85rem;
    }

    .stat-value {
        font-size: 1.5rem !important;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
}

/* ============================= */
/* TABLES RESPONSIVE */
/* ============================= */

/* Make all tables responsive with horizontal scroll */
@media (max-width: 1024px) {
    .table-responsive,
    .users-table-container,
    .translation-table-container,
    .content-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .users-table,
    .translation-table,
    table {
        min-width: 700px;
    }

    /* Sticky first column for better mobile experience */
    .users-table td:first-child,
    .users-table th:first-child {
        position: sticky;
        left: 0;
        background: var(--surface-color);
        z-index: 1;
    }
}

@media (max-width: 768px) {
    /* Convert table to cards on mobile */
    .mobile-card-view .users-table tbody {
        display: block;
    }

    .mobile-card-view .users-table tr {
        display: block;
        margin-bottom: 1rem;
        background: var(--surface-color);
        border-radius: 12px;
        padding: 1rem;
    }

    .mobile-card-view .users-table td {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border: none;
    }

    .mobile-card-view .users-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--text-secondary);
    }

    .mobile-card-view .users-table thead {
        display: none;
    }
}

/* ============================= */
/* FORMS AND MODALS RESPONSIVE */
/* ============================= */

@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 1rem;
        max-height: calc(100vh - 2rem);
    }

    .modal-content.large {
        width: 100%;
        margin: 0;
        border-radius: 0;
        height: 100vh;
        max-height: 100vh;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }

    /* Form grid adjustments */
    .form-grid {
        grid-template-columns: 1fr;
    }

    .filter-controls {
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-select {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .modal-header h2 {
        font-size: 1.25rem;
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }

    .modal-footer .btn {
        width: 100%;
    }
}

/* ============================= */
/* CHARTS RESPONSIVE */
/* ============================= */

@media (max-width: 1024px) {
    .charts-container {
        grid-template-columns: 1fr;
    }

    .chart-card {
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .chart-card {
        min-height: 250px;
    }

    canvas {
        max-height: 250px !important;
    }
}

/* ============================= */
/* ACTIVITY LOGS RESPONSIVE */
/* ============================= */

@media (max-width: 768px) {
    .timeline-item {
        flex-direction: column;
        padding-left: 2rem;
    }

    .timeline-time {
        width: auto;
        text-align: left;
        margin-bottom: 0.5rem;
    }

    .timeline-connector {
        position: absolute;
        left: 0;
    }

    .activity-card {
        width: 100%;
    }

    .activity-feed-widget {
        display: none;
    }

    /* Filter section */
    .filter-section {
        flex-direction: column;
    }

    .date-filter {
        flex-direction: column;
        width: 100%;
    }

    .date-filter input {
        width: 100%;
    }
}

/* ============================= */
/* CONTENT MANAGEMENT RESPONSIVE */
/* ============================= */

@media (max-width: 1280px) {
    .content-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .view-toggle {
        display: none;
    }
}

@media (max-width: 640px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .content-card {
        flex-direction: row;
        align-items: center;
    }

    .content-card .content-poster {
        width: 80px;
        height: 120px;
    }

    .drop-zone {
        padding: 2rem 1rem;
    }

    .drop-zone-content h3 {
        font-size: 1.25rem;
    }
}

/* ============================= */
/* USER MANAGEMENT RESPONSIVE */
/* ============================= */

@media (max-width: 768px) {
    .filter-chips {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 0.5rem;
    }

    .chip {
        flex-shrink: 0;
    }

    .user-info {
        flex-direction: column;
        align-items: flex-start;
    }

    .user-badges {
        margin-left: 0;
        margin-top: 0.5rem;
    }

    .device-icons {
        flex-wrap: wrap;
    }

    .action-buttons {
        flex-wrap: wrap;
    }
}

/* ============================= */
/* TRANSLATIONS RESPONSIVE */
/* ============================= */

@media (max-width: 1024px) {
    .language-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .language-stats {
        grid-template-columns: 1fr;
    }

    .translation-table {
        font-size: 0.85rem;
    }

    .translation-value {
        min-height: 50px;
        font-size: 0.85rem;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }
}

/* ============================= */
/* PAGINATION RESPONSIVE */
/* ============================= */

@media (max-width: 640px) {
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }

    .pagination-info {
        text-align: center;
    }

    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
}

/* ============================= */
/* NOTIFICATIONS RESPONSIVE */
/* ============================= */

@media (max-width: 768px) {
    .notifications-dropdown {
        width: 100vw;
        right: -1rem;
        left: auto;
        border-radius: 0;
        max-height: 100vh;
        top: calc(100% + 0.5rem);
    }

    .notification-item {
        padding: 0.75rem;
    }

    .notification-icon {
        width: 36px;
        height: 36px;
    }

    .toast-container {
        right: 1rem;
        left: 1rem;
    }

    .toast {
        width: 100%;
        min-width: auto;
    }
}

/* ============================= */
/* BUTTONS AND CONTROLS RESPONSIVE */
/* ============================= */

@media (max-width: 640px) {
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-group {
        flex-direction: column;
        width: 100%;
    }

    .btn-group .btn {
        width: 100%;
        border-radius: 8px !important;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
    }
}

/* ============================= */
/* UTILITY CLASSES */
/* ============================= */

/* Hide on mobile */
@media (max-width: 768px) {
    .hide-mobile {
        display: none !important;
    }
}

/* Hide on tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .hide-tablet {
        display: none !important;
    }
}

/* Hide on desktop */
@media (min-width: 1025px) {
    .hide-desktop {
        display: none !important;
    }
}

/* Show only on mobile */
@media (min-width: 769px) {
    .show-mobile {
        display: none !important;
    }
}

/* Text responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem !important;
    }

    .section-title {
        font-size: 1.25rem !important;
    }

    .page-description {
        font-size: 0.875rem;
    }

    h1 { font-size: 1.75rem; }
    h2 { font-size: 1.5rem; }
    h3 { font-size: 1.25rem; }
    h4 { font-size: 1.1rem; }
    h5 { font-size: 1rem; }
    h6 { font-size: 0.9rem; }
}

/* ============================= */
/* LANDSCAPE MOBILE SPECIFIC */
/* ============================= */

@media (max-height: 500px) and (orientation: landscape) {
    .enhanced-navbar {
        padding: 0.5rem 1rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .modal-content {
        max-height: 90vh;
        overflow-y: auto;
    }
}

/* ============================= */
/* HIGH DPI DISPLAYS */
/* ============================= */

@media (-webkit-min-device-pixel-ratio: 2),
       (min-resolution: 192dpi) {
    /* Ensure sharp borders and text */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Thinner borders for retina */
    .stat-card,
    .content-card,
    .activity-card {
        border-width: 0.5px;
    }
}

/* ============================= */
/* PRINT STYLES */
/* ============================= */

@media print {
    .enhanced-sidebar,
    .enhanced-navbar,
    .header-actions,
    .pagination,
    .btn,
    .mobile-sidebar-toggle,
    .theme-toggle,
    .language-switcher {
        display: none !important;
    }

    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    * {
        box-shadow: none !important;
        text-shadow: none !important;
    }
}

/* ============================= */
/* TOUCH DEVICE ENHANCEMENTS */
/* ============================= */

@media (hover: none) and (pointer: coarse) {
    /* Larger touch targets */
    .btn,
    .menu-item,
    .chip,
    button,
    a {
        min-height: 44px;
        min-width: 44px;
    }

    /* Remove hover effects on touch devices */
    .stat-card:hover,
    .content-card:hover {
        transform: none;
    }

    /* Increase spacing for touch */
    .menu-item {
        padding: 1rem 1.5rem;
    }

    /* Disable text selection on interactive elements */
    .btn,
    .menu-item,
    .chip {
        -webkit-user-select: none;
        user-select: none;
    }
}

/* ============================= */
/* ACCESSIBILITY IMPROVEMENTS */
/* ============================= */

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}

/* Focus visible for keyboard navigation */
@media (prefers-reduced-motion: no-preference) {
    :focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }
}

/* ============================= */
/* CUSTOM SCROLLBAR FOR MOBILE */
/* ============================= */

@media (max-width: 768px) {
    /* Hide scrollbar for mobile but keep functionality */
    .filter-chips::-webkit-scrollbar,
    .table-responsive::-webkit-scrollbar {
        height: 4px;
    }

    .filter-chips::-webkit-scrollbar-thumb,
    .table-responsive::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }
}

/* ============================= */
/* RTL RESPONSIVE ADJUSTMENTS */
/* ============================= */

[dir="rtl"] {
    @media (max-width: 1024px) {
        .enhanced-sidebar {
            left: auto;
            right: 0;
            transform: translateX(100%);
        }

        .enhanced-sidebar.mobile-open {
            transform: translateX(0);
        }
    }

    @media (max-width: 768px) {
        .timeline-item {
            padding-left: 0;
            padding-right: 2rem;
        }

        .timeline-connector {
            left: auto;
            right: 0;
        }

        .profile-menu {
            right: auto;
            left: -1rem;
        }
    }
}
</style>

<!-- Mobile Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

<!-- Mobile-Specific JavaScript -->
<script>
// Mobile Sidebar Toggle
function toggleMobileSidebar() {
    const sidebar = document.querySelector('.enhanced-sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.toggle('mobile-open');
    overlay.classList.toggle('show');

    // Prevent body scroll when sidebar is open
    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
}

function closeMobileSidebar() {
    const sidebar = document.querySelector('.enhanced-sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.remove('mobile-open');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
}

// Handle responsive table view
function toggleTableView() {
    const table = document.querySelector('.users-table-container');
    if (table) {
        table.classList.toggle('mobile-card-view');
    }
}

// Detect touch device
function isTouchDevice() {
    return ('ontouchstart' in window) ||
           (navigator.maxTouchPoints > 0) ||
           (navigator.msMaxTouchPoints > 0);
}

// Handle viewport changes
function handleViewportChange() {
    const width = window.innerWidth;

    // Close mobile sidebar on desktop
    if (width > 1024) {
        closeMobileSidebar();
    }

    // Adjust chart sizes
    if (typeof Chart !== 'undefined') {
        Chart.helpers.each(Chart.instances, function(instance) {
            instance.resize();
        });
    }
}

// Smooth scroll for mobile
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Initialize responsive features
document.addEventListener('DOMContentLoaded', function() {
    // Add mobile-specific classes
    if (isTouchDevice()) {
        document.body.classList.add('touch-device');
    }

    // Handle viewport changes
    window.addEventListener('resize', handleViewportChange);

    // Add swipe gestures for mobile sidebar
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipeGesture();
    });

    function handleSwipeGesture() {
        const swipeThreshold = 50;
        const sidebar = document.querySelector('.enhanced-sidebar');

        if (touchEndX - touchStartX > swipeThreshold && touchStartX < 50) {
            // Swipe right from left edge - open sidebar
            sidebar.classList.add('mobile-open');
            document.getElementById('sidebarOverlay').classList.add('show');
        }

        if (touchStartX - touchEndX > swipeThreshold && sidebar.classList.contains('mobile-open')) {
            // Swipe left - close sidebar
            closeMobileSidebar();
        }
    }

    // Add data labels for responsive tables
    const tables = document.querySelectorAll('.users-table, .translation-table');
    tables.forEach(table => {
        const headers = table.querySelectorAll('thead th');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent);
                }
            });
        });
    });

    // Handle mobile menu items
    const mobileMenuBtn = document.querySelector('.mobile-sidebar-toggle');
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleMobileSidebar);
    }

    // Prevent zoom on form focus (iOS)
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (window.innerWidth < 768) {
                document.querySelector('meta[name="viewport"]').setAttribute('content',
                    'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0');
            }
        });

        input.addEventListener('blur', function() {
            document.querySelector('meta[name="viewport"]').setAttribute('content',
                'width=device-width, initial-scale=1.0');
        });
    });
});

// Handle orientation change
window.addEventListener('orientationchange', function() {
    setTimeout(handleViewportChange, 300);
});

// Lazy loading for images on mobile
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img.lazy').forEach(img => {
        imageObserver.observe(img);
    });
}
</script>