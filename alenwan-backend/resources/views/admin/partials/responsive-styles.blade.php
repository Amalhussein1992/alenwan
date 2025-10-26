<style>
/* Responsive Helper Classes */
@media (max-width: 576px) {
    /* Mobile Styles */
    .table-responsive {
        border: none;
    }

    .card, .card-modern {
        border-radius: 12px !important;
        margin-bottom: 1rem !important;
    }

    .btn-group {
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Hide less important columns on mobile */
    .table th:nth-child(n+4),
    .table td:nth-child(n+4) {
        display: none;
    }

    .table th:nth-child(1),
    .table td:nth-child(1),
    .table th:nth-child(2),
    .table td:nth-child(2),
    .table th:last-child,
    .table td:last-child {
        display: table-cell;
    }

    /* Stack form elements on mobile */
    .row.g-3 > [class*="col-"] {
        margin-bottom: 1rem;
    }

    /* Adjust modal sizes */
    .modal-xl {
        max-width: 100%;
        margin: 0.5rem;
    }

    .modal-content {
        border-radius: 12px;
    }

    /* Responsive badges and pills */
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    /* Responsive stats cards */
    .stat-card {
        padding: 1rem !important;
    }

    .stat-value {
        font-size: 1.5rem !important;
    }

    .stat-icon {
        width: 40px !important;
        height: 40px !important;
        font-size: 1.25rem !important;
    }
}

@media (min-width: 576px) and (max-width: 768px) {
    /* Small Tablet Styles */
    .table th:nth-child(n+5),
    .table td:nth-child(n+5) {
        display: none;
    }

    .modal-xl {
        max-width: 90%;
    }
}

@media (min-width: 768px) and (max-width: 992px) {
    /* Tablet Styles */
    .container-fluid {
        padding: 0 1rem;
    }

    .modal-xl {
        max-width: 80%;
    }
}

/* Responsive Utilities */
.text-truncate-mobile {
    @media (max-width: 576px) {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}

.hide-mobile {
    @media (max-width: 576px) {
        display: none !important;
    }
}

.show-mobile {
    @media (min-width: 577px) {
        display: none !important;
    }
}

/* Responsive Grid Cards */
.grid-responsive {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
}

@media (max-width: 576px) {
    .grid-responsive {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 576px) and (max-width: 768px) {
    .grid-responsive {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Responsive Navigation Tabs */
@media (max-width: 576px) {
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        white-space: nowrap;
        padding-bottom: 0.5rem;
    }

    .nav-tabs .nav-link {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .nav-tabs .badge {
        display: none;
    }
}

/* Responsive Charts */
@media (max-width: 576px) {
    canvas {
        max-height: 200px !important;
    }
}

/* Responsive Forms */
@media (max-width: 768px) {
    .form-label {
        font-size: 0.875rem;
    }

    .form-control,
    .form-select {
        font-size: 0.875rem;
    }

    .input-group > * {
        font-size: 0.875rem;
    }
}

/* Responsive Animations */
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

/* Touch-friendly Interactions */
@media (hover: none) and (pointer: coarse) {
    .btn,
    .menu-item,
    .dropdown-item,
    .nav-link {
        min-height: 44px;
        display: flex;
        align-items: center;
    }
}

/* Responsive Scrollbars */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: var(--bg-secondary);
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: var(--text-secondary);
}

/* Responsive Spacing */
@media (max-width: 576px) {
    .p-0 { padding: 0.5rem !important; }
    .p-1 { padding: 0.5rem !important; }
    .p-2 { padding: 0.75rem !important; }
    .p-3 { padding: 1rem !important; }
    .p-4 { padding: 1.25rem !important; }
    .p-5 { padding: 1.5rem !important; }

    .m-0 { margin: 0 !important; }
    .m-1 { margin: 0.25rem !important; }
    .m-2 { margin: 0.5rem !important; }
    .m-3 { margin: 0.75rem !important; }
    .m-4 { margin: 1rem !important; }
    .m-5 { margin: 1.25rem !important; }
}

/* Responsive Typography */
@media (max-width: 576px) {
    h1, .h1 { font-size: 1.75rem !important; }
    h2, .h2 { font-size: 1.5rem !important; }
    h3, .h3 { font-size: 1.25rem !important; }
    h4, .h4 { font-size: 1.125rem !important; }
    h5, .h5 { font-size: 1rem !important; }
    h6, .h6 { font-size: 0.875rem !important; }
}

/* Responsive Floating Action Button */
@media (max-width: 768px) {
    .mobile-menu-btn,
    .theme-toggle {
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
}

/* Responsive Images */
img {
    max-width: 100%;
    height: auto;
}

/* Responsive Video Players */
.video-responsive {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
}

.video-responsive iframe,
.video-responsive video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Print Styles */
@media print {
    .sidebar,
    .header,
    .mobile-menu-btn,
    .theme-toggle,
    .btn-group,
    .dropdown {
        display: none !important;
    }

    .main-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }

    .main-content {
        padding: 20px !important;
    }

    .card-modern,
    .stat-card {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}
</style>