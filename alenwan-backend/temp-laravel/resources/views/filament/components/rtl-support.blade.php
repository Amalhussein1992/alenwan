@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa', 'ur']);
@endphp

@if($isRtl)
    <script>
        document.documentElement.setAttribute('dir', 'rtl');
    </script>
    <style>
        /* RTL Support for Arabic Language */
        [dir="rtl"] {
            direction: rtl;
        }

        [dir="rtl"] .fi-sidebar {
            left: auto !important;
            right: 0 !important;
        }

        [dir="rtl"] .fi-sidebar-nav {
            text-align: right;
        }

        [dir="rtl"] .fi-topbar {
            direction: rtl;
        }

        [dir="rtl"] .fi-breadcrumbs {
            direction: rtl;
        }

        [dir="rtl"] .fi-ta-table {
            direction: rtl;
        }

        [dir="rtl"] .fi-fo-field-wrp {
            direction: rtl;
        }

        /* Fix for form fields */
        [dir="rtl"] input,
        [dir="rtl"] textarea,
        [dir="rtl"] select {
            text-align: right;
        }

        /* Fix for icons in sidebar */
        [dir="rtl"] .fi-sidebar-item-icon {
            margin-right: 0 !important;
            margin-left: 0.75rem !important;
        }

        /* Fix for dropdown menus */
        [dir="rtl"] .fi-dropdown-list {
            text-align: right;
        }

        /* Fix for notifications */
        [dir="rtl"] .fi-no {
            direction: rtl;
        }

        /* Fix for badges */
        [dir="rtl"] .fi-badge {
            direction: rtl;
        }

        /* Fix for action buttons */
        [dir="rtl"] .fi-ac-btn-group {
            flex-direction: row-reverse;
        }

        /* Fix spacing in RTL */
        [dir="rtl"] .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Fix for main content area */
        [dir="rtl"] .fi-main {
            direction: rtl;
        }

        /* Fix for page header */
        [dir="rtl"] .fi-header {
            direction: rtl;
        }

        /* Fix for stats widgets */
        [dir="rtl"] .fi-stats-card {
            direction: rtl;
        }

        /* Fix for table headers */
        [dir="rtl"] .fi-ta-header-cell {
            text-align: right;
        }

        /* Fix for table cells */
        [dir="rtl"] .fi-ta-cell {
            text-align: right;
        }
    </style>
@else
    <script>
        document.documentElement.setAttribute('dir', 'ltr');
    </script>
@endif
