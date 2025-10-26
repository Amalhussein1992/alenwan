@extends('admin.layouts.app')

@section('title', 'Translation Management')

@section('content')
<div class="translations-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-language"></i>
                Translation Management
            </h1>
            <p class="page-description">Manage all application translations and localizations</p>
        </div>

        <div class="header-actions">
            <button class="btn btn-outline" onclick="exportTranslations()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-outline" onclick="importTranslations()">
                <i class="fas fa-upload"></i> Import
            </button>
            <button class="btn btn-primary" onclick="showAddLanguageModal()">
                <i class="fas fa-plus"></i> Add Language
            </button>
        </div>
    </div>

    <!-- Language Stats -->
    <div class="language-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Crect width='512' height='170.67' fill='%23c8312a'/%3E%3Crect y='170.67' width='512' height='170.67' fill='%23fff'/%3E%3Crect y='341.33' width='512' height='170.67' fill='%23c8312a'/%3E%3C/svg%3E" alt="English">
            </div>
            <div class="stat-content">
                <h3>English</h3>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 100%"></div>
                </div>
                <span class="stat-text">1,245 / 1,245 translated (100%)</span>
            </div>
            <div class="stat-actions">
                <button class="btn-icon" onclick="editLanguage('en')">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Crect width='512' height='512' fill='%23006233'/%3E%3Crect x='170.67' width='170.67' height='512' fill='%23fff'/%3E%3C/svg%3E" alt="Arabic">
            </div>
            <div class="stat-content">
                <h3>العربية</h3>
                <div class="progress-bar">
                    <div class="progress-fill warning" style="width: 85%"></div>
                </div>
                <span class="stat-text">1,058 / 1,245 translated (85%)</span>
            </div>
            <div class="stat-actions">
                <button class="btn-icon" onclick="editLanguage('ar')">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Crect width='170.67' height='512' fill='%23002654'/%3E%3Crect x='170.67' width='170.67' height='512' fill='%23fff'/%3E%3Crect x='341.33' width='170.67' height='512' fill='%23ed2939'/%3E%3C/svg%3E" alt="French">
            </div>
            <div class="stat-content">
                <h3>Français</h3>
                <div class="progress-bar">
                    <div class="progress-fill warning" style="width: 78%"></div>
                </div>
                <span class="stat-text">971 / 1,245 translated (78%)</span>
            </div>
            <div class="stat-actions">
                <button class="btn-icon" onclick="editLanguage('fr')">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Crect width='512' height='512' fill='%23c60b1e'/%3E%3Crect y='128' width='512' height='256' fill='%23ffc400'/%3E%3C/svg%3E" alt="Spanish">
            </div>
            <div class="stat-content">
                <h3>Español</h3>
                <div class="progress-bar">
                    <div class="progress-fill danger" style="width: 65%"></div>
                </div>
                <span class="stat-text">809 / 1,245 translated (65%)</span>
            </div>
            <div class="stat-actions">
                <button class="btn-icon" onclick="editLanguage('es')">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Translation Editor -->
    <div class="translation-editor">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search translations..." id="translationSearch">
            </div>

            <div class="filter-controls">
                <select class="filter-select" id="languageFilter">
                    <option value="">All Languages</option>
                    <option value="en">English</option>
                    <option value="ar">Arabic</option>
                    <option value="fr">French</option>
                    <option value="es">Spanish</option>
                </select>

                <select class="filter-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="translated">Translated</option>
                    <option value="untranslated">Untranslated</option>
                    <option value="needs_update">Needs Update</option>
                </select>

                <select class="filter-select" id="groupFilter">
                    <option value="">All Groups</option>
                    <option value="auth">Authentication</option>
                    <option value="validation">Validation</option>
                    <option value="pagination">Pagination</option>
                    <option value="passwords">Passwords</option>
                    <option value="app">Application</option>
                </select>
            </div>
        </div>

        <!-- Translation Table -->
        <div class="translation-table-container">
            <table class="translation-table">
                <thead>
                    <tr>
                        <th width="200">Key</th>
                        <th>English (Base)</th>
                        <th>Arabic</th>
                        <th>French</th>
                        <th>Spanish</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="key-cell">
                            <span class="translation-key">auth.login</span>
                            <span class="key-group">Authentication</span>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true" data-lang="en" data-key="auth.login">
                                Login
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable rtl" contenteditable="true" data-lang="ar" data-key="auth.login">
                                تسجيل الدخول
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true" data-lang="fr" data-key="auth.login">
                                Connexion
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true" data-lang="es" data-key="auth.login">
                                Iniciar sesión
                            </div>
                        </td>
                        <td class="action-cell">
                            <button class="btn-icon" onclick="saveTranslation('auth.login')">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="btn-icon" onclick="resetTranslation('auth.login')">
                                <i class="fas fa-undo"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="key-cell">
                            <span class="translation-key">auth.register</span>
                            <span class="key-group">Authentication</span>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                Register
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable rtl" contenteditable="true">
                                تسجيل
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                S'inscrire
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                Registrarse
                            </div>
                        </td>
                        <td class="action-cell">
                            <button class="btn-icon" onclick="saveTranslation('auth.register')">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="btn-icon" onclick="resetTranslation('auth.register')">
                                <i class="fas fa-undo"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="key-cell">
                            <span class="translation-key">auth.forgot_password</span>
                            <span class="key-group">Authentication</span>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                Forgot Password?
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable rtl" contenteditable="true">
                                هل نسيت كلمة المرور؟
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                Mot de passe oublié?
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable untranslated" contenteditable="true" placeholder="Enter translation...">

                            </div>
                            <span class="status-badge">Needs Translation</span>
                        </td>
                        <td class="action-cell">
                            <button class="btn-icon" onclick="saveTranslation('auth.forgot_password')">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="btn-icon" onclick="autoTranslate('auth.forgot_password', 'es')">
                                <i class="fas fa-magic"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="key-cell">
                            <span class="translation-key">validation.required</span>
                            <span class="key-group">Validation</span>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                The :attribute field is required.
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable rtl" contenteditable="true">
                                حقل :attribute مطلوب.
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                Le champ :attribute est requis.
                            </div>
                        </td>
                        <td class="translation-cell">
                            <div class="translation-value editable" contenteditable="true">
                                El campo :attribute es requerido.
                            </div>
                        </td>
                        <td class="action-cell">
                            <button class="btn-icon" onclick="saveTranslation('validation.required')">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="btn-icon" onclick="resetTranslation('validation.required')">
                                <i class="fas fa-undo"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing <strong>1-10</strong> of <strong>1,245</strong> translations
            </div>
            <div class="pagination">
                <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <span class="page-dots">...</span>
                <button class="page-btn">125</button>
                <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <button class="action-btn" onclick="scanForMissing()">
                <i class="fas fa-search-plus"></i>
                <span>Scan for Missing</span>
            </button>
            <button class="action-btn" onclick="autoTranslateAll()">
                <i class="fas fa-magic"></i>
                <span>Auto-Translate All</span>
            </button>
            <button class="action-btn" onclick="publishTranslations()">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Publish Changes</span>
            </button>
            <button class="action-btn" onclick="clearCache()">
                <i class="fas fa-broom"></i>
                <span>Clear Cache</span>
            </button>
        </div>
    </div>
</div>

<!-- Add Language Modal -->
<div class="modal" id="addLanguageModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Language</h2>
            <button class="close-btn" onclick="closeModal('addLanguageModal')">×</button>
        </div>
        <div class="modal-body">
            <form id="addLanguageForm">
                <div class="form-group">
                    <label>Language Code</label>
                    <input type="text" class="form-control" placeholder="e.g., de, it, pt" required>
                </div>
                <div class="form-group">
                    <label>Language Name</label>
                    <input type="text" class="form-control" placeholder="e.g., German, Italian, Portuguese" required>
                </div>
                <div class="form-group">
                    <label>Native Name</label>
                    <input type="text" class="form-control" placeholder="e.g., Deutsch, Italiano, Português" required>
                </div>
                <div class="form-group">
                    <label>Direction</label>
                    <select class="form-control">
                        <option value="ltr">LTR (Left to Right)</option>
                        <option value="rtl">RTL (Right to Left)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Flag Icon</label>
                    <input type="text" class="form-control" placeholder="Upload or paste URL">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('addLanguageModal')">Cancel</button>
            <button class="btn btn-primary" onclick="addLanguage()">Add Language</button>
        </div>
    </div>
</div>

<style>
.translations-container {
    padding: 2rem;
    max-width: 1600px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 2rem;
    font-weight: bold;
    color: white;
    margin: 0;
}

.page-description {
    color: #888;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Language Stats */
.language-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(162, 1, 54, 0.2);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.stat-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    margin: 0 0 0.5rem 0;
    color: white;
    font-size: 1.1rem;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: #4ade80;
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-fill.warning {
    background: #fb923c;
}

.progress-fill.danger {
    background: #ef4444;
}

.stat-text {
    color: #888;
    font-size: 0.85rem;
}

.stat-actions {
    display: flex;
    gap: 0.5rem;
}

/* Translation Editor */
.translation-editor {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.filter-section {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 300px;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 10px;
    color: white;
}

.filter-controls {
    display: flex;
    gap: 1rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 10px;
    color: white;
    min-width: 150px;
}

/* Translation Table */
.translation-table-container {
    overflow-x: auto;
    margin-bottom: 1.5rem;
}

.translation-table {
    width: 100%;
    border-collapse: collapse;
}

.translation-table thead {
    background: rgba(0, 0, 0, 0.3);
}

.translation-table th {
    padding: 1rem;
    text-align: left;
    color: #888;
    font-weight: 500;
    font-size: 0.85rem;
    text-transform: uppercase;
    border-bottom: 1px solid #333;
}

.translation-table tbody tr {
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: background 0.3s ease;
}

.translation-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.02);
}

.translation-table td {
    padding: 1rem;
}

.key-cell {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.translation-key {
    font-family: monospace;
    font-size: 0.9rem;
    color: var(--primary-color);
    font-weight: 500;
}

.key-group {
    font-size: 0.75rem;
    color: #666;
}

.translation-cell {
    position: relative;
}

.translation-value {
    padding: 0.5rem;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid transparent;
    border-radius: 6px;
    color: white;
    min-height: 36px;
    transition: all 0.3s ease;
}

.translation-value.editable {
    cursor: text;
}

.translation-value.editable:hover {
    background: rgba(0, 0, 0, 0.4);
    border-color: #333;
}

.translation-value.editable:focus {
    outline: none;
    background: rgba(0, 0, 0, 0.5);
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(162, 1, 54, 0.2);
}

.translation-value.rtl {
    direction: rtl;
    text-align: right;
}

.translation-value.untranslated {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    color: #888;
}

.translation-value.untranslated:empty::before {
    content: attr(placeholder);
    color: #666;
}

.status-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ef4444;
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    font-weight: 600;
}

.action-cell {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: rgba(255, 255, 255, 0.05);
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-icon:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

/* Quick Actions */
.quick-actions {
    background: var(--surface-color);
    border-radius: 16px;
    padding: 1.5rem;
}

.quick-actions h3 {
    color: white;
    margin: 0 0 1rem 0;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-btn {
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #333;
    border-radius: 12px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: rgba(162, 1, 54, 0.1);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 1.2rem;
    color: var(--primary-color);
}

.action-btn span {
    font-weight: 500;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
}

.pagination-info {
    color: #888;
    font-size: 0.9rem;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.page-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #333;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.page-btn:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.1);
}

.page-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-dots {
    display: flex;
    align-items: center;
    padding: 0 0.5rem;
    color: #888;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--surface-color);
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #333;
}

.modal-header h2 {
    margin: 0;
    color: white;
}

.close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #333;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #888;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 8px;
    color: white;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(162, 1, 54, 0.2);
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(162, 1, 54, 0.3);
}

.btn-outline {
    background: transparent;
    color: white;
    border: 1px solid #333;
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.05);
}

/* Responsive */
@media (max-width: 768px) {
    .language-stats {
        grid-template-columns: 1fr;
    }

    .filter-section {
        flex-direction: column;
    }

    .filter-controls {
        flex-direction: column;
    }

    .filter-select {
        width: 100%;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Save translation
function saveTranslation(key) {
    console.log('Saving translation:', key);
    // Show success toast
    showToast('Translation saved successfully');
}

// Reset translation
function resetTranslation(key) {
    if (confirm('Are you sure you want to reset this translation?')) {
        console.log('Resetting translation:', key);
    }
}

// Auto translate
function autoTranslate(key, lang) {
    console.log('Auto-translating:', key, 'to', lang);
    // Simulate auto translation
    const cell = document.querySelector(`[data-lang="${lang}"][data-key="${key}"]`);
    if (cell) {
        cell.textContent = 'Translating...';
        setTimeout(() => {
            cell.textContent = '¿Olvidaste tu contraseña?';
            cell.classList.remove('untranslated');
        }, 1000);
    }
}

// Edit language
function editLanguage(lang) {
    console.log('Editing language:', lang);
}

// Export translations
function exportTranslations() {
    console.log('Exporting translations...');
}

// Import translations
function importTranslations() {
    console.log('Importing translations...');
}

// Show add language modal
function showAddLanguageModal() {
    document.getElementById('addLanguageModal').classList.add('show');
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

// Add language
function addLanguage() {
    console.log('Adding new language...');
    closeModal('addLanguageModal');
}

// Scan for missing
function scanForMissing() {
    console.log('Scanning for missing translations...');
}

// Auto translate all
function autoTranslateAll() {
    if (confirm('This will auto-translate all missing translations. Continue?')) {
        console.log('Auto-translating all...');
    }
}

// Publish translations
function publishTranslations() {
    console.log('Publishing translations...');
}

// Clear cache
function clearCache() {
    console.log('Clearing translation cache...');
}

// Show toast notification
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--primary-color);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        z-index: 10000;
        animation: slideUp 0.3s ease;
    `;
    document.body.appendChild(toast);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideDown 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    @keyframes slideDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Search functionality
document.getElementById('translationSearch').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    console.log('Searching translations:', query);
});

// Make translation cells save on blur
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.translation-value.editable').forEach(cell => {
        let originalValue = cell.textContent;

        cell.addEventListener('focus', function() {
            originalValue = this.textContent;
        });

        cell.addEventListener('blur', function() {
            if (this.textContent !== originalValue) {
                const key = this.dataset.key;
                const lang = this.dataset.lang;
                console.log('Translation changed:', key, lang, this.textContent);
                showToast('Translation saved');
            }
        });
    });
});
</script>
@endsection