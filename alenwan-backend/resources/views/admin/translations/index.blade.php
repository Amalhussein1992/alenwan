@extends('admin.layouts.app')

@section('title', 'Translation Management')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">Translation Management</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Translations</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button class="btn-modern btn-success-modern" onclick="saveAllTranslations()">
                    <i class="fas fa-save me-2"></i>Save All Changes
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Language Tabs -->
    <div class="card-modern mb-4">
        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button">
                    <i class="fas fa-flag me-2"></i>English
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="arabic-tab" data-bs-toggle="tab" data-bs-target="#arabic" type="button">
                    <i class="fas fa-flag me-2"></i>العربية (Arabic)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="french-tab" data-bs-toggle="tab" data-bs-target="#french" type="button">
                    <i class="fas fa-flag me-2"></i>Français (French)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="spanish-tab" data-bs-toggle="tab" data-bs-target="#spanish" type="button">
                    <i class="fas fa-flag me-2"></i>Español (Spanish)
                </button>
            </li>
        </ul>
    </div>

    <!-- Translation Sections -->
    <div class="row">
        <div class="col-lg-3">
            <div class="card-modern sticky-top" style="top: 100px;">
                <h5 class="mb-3">Translation Sections</h5>
                <div class="list-group list-group-flush">
                    <a href="#section-landing" class="list-group-item list-group-item-action active" data-section="landing">
                        <i class="fas fa-home me-2"></i>Landing Page
                    </a>
                    <a href="#section-admin" class="list-group-item list-group-item-action" data-section="admin">
                        <i class="fas fa-cog me-2"></i>Admin Panel
                    </a>
                    <a href="#section-auth" class="list-group-item list-group-item-action" data-section="auth">
                        <i class="fas fa-sign-in-alt me-2"></i>Authentication
                    </a>
                    <a href="#section-messages" class="list-group-item list-group-item-action" data-section="messages">
                        <i class="fas fa-envelope me-2"></i>Messages
                    </a>
                    <a href="#section-validation" class="list-group-item list-group-item-action" data-section="validation">
                        <i class="fas fa-check-circle me-2"></i>Validation
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content" id="languageTabsContent">
                <!-- English Tab -->
                <div class="tab-pane fade show active" id="english" role="tabpanel">
                    @include('admin.translations.partials.translation-form', ['language' => 'en', 'languageName' => 'English'])
                </div>

                <!-- Arabic Tab -->
                <div class="tab-pane fade" id="arabic" role="tabpanel">
                    @include('admin.translations.partials.translation-form', ['language' => 'ar', 'languageName' => 'Arabic'])
                </div>

                <!-- French Tab -->
                <div class="tab-pane fade" id="french" role="tabpanel">
                    @include('admin.translations.partials.translation-form', ['language' => 'fr', 'languageName' => 'French'])
                </div>

                <!-- Spanish Tab -->
                <div class="tab-pane fade" id="spanish" role="tabpanel">
                    @include('admin.translations.partials.translation-form', ['language' => 'es', 'languageName' => 'Spanish'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Smooth scroll to sections
    document.querySelectorAll('.list-group-item-action').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.list-group-item-action').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            const section = this.getAttribute('data-section');
            const target = document.getElementById('section-' + section);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Save all translations
    function saveAllTranslations() {
        // Collect all translation data
        const translations = {};

        document.querySelectorAll('.translation-input').forEach(input => {
            const lang = input.dataset.lang;
            const section = input.dataset.section;
            const key = input.dataset.key;
            const value = input.value;

            if (!translations[lang]) translations[lang] = {};
            if (!translations[lang][section]) translations[lang][section] = {};
            translations[lang][section][key] = value;
        });

        // Send to server
        fetch('/admin/translations/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(translations)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Translations saved successfully!');
                location.reload();
            } else {
                alert('Error saving translations: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving translations.');
        });
    }

    // Auto-save indicator
    let saveTimeout;
    document.querySelectorAll('.translation-input').forEach(input => {
        input.addEventListener('input', function() {
            this.style.borderColor = 'var(--warning-color)';
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                this.style.borderColor = '';
            }, 1000);
        });
    });
</script>
@endsection

@section('styles')
<style>
    .nav-tabs .nav-link {
        color: var(--text-secondary);
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background: var(--bg-secondary);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: var(--bg-secondary);
        border-bottom: 3px solid var(--primary-color);
    }

    .list-group-item-action {
        border: none;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }

    .list-group-item-action:hover {
        background: var(--bg-secondary);
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .list-group-item-action.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border-radius: 10px;
    }

    .translation-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .translation-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(162, 1, 54, 0.1);
    }

    .sticky-top {
        position: sticky;
    }
</style>
@endsection
