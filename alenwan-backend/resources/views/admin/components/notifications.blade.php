<!-- Real-time Notifications Component -->
<div class="notifications-wrapper">
    <!-- Notification Bell -->
    <div class="notification-trigger" onclick="toggleNotifications()">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge">5</span>
    </div>

    <!-- Notifications Dropdown -->
    <div class="notifications-dropdown" id="notificationsDropdown">
        <div class="notifications-header">
            <h3>Notifications</h3>
            <div class="notification-actions">
                <button class="mark-all-read" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
                <button class="settings-btn" onclick="openNotificationSettings()">
                    <i class="fas fa-cog"></i>
                </button>
            </div>
        </div>

        <div class="notification-tabs">
            <button class="tab-btn active" data-tab="all">All</button>
            <button class="tab-btn" data-tab="unread">Unread</button>
            <button class="tab-btn" data-tab="system">System</button>
            <button class="tab-btn" data-tab="users">Users</button>
        </div>

        <div class="notifications-list" id="notificationsList">
            <!-- New User Registration -->
            <div class="notification-item unread" data-id="1">
                <div class="notification-icon new-user">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New User Registration</div>
                    <div class="notification-message">John Doe has registered and started a free trial</div>
                    <div class="notification-time">2 minutes ago</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewNotification(1)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(1)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Subscription Upgrade -->
            <div class="notification-item unread" data-id="2">
                <div class="notification-icon subscription">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Subscription Upgrade</div>
                    <div class="notification-message">Sarah Smith upgraded to Premium Plan - $29.99/month</div>
                    <div class="notification-time">15 minutes ago</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewNotification(2)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(2)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Content Upload -->
            <div class="notification-item unread" data-id="3">
                <div class="notification-icon content">
                    <i class="fas fa-film"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New Content Available</div>
                    <div class="notification-message">10 new movies have been successfully uploaded</div>
                    <div class="notification-time">1 hour ago</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewNotification(3)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(3)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- System Alert -->
            <div class="notification-item" data-id="4">
                <div class="notification-icon alert">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">High Server Load</div>
                    <div class="notification-message">Server load is at 85%. Consider scaling up resources.</div>
                    <div class="notification-time">2 hours ago</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewNotification(4)">
                        <i class="fas fa-chart-line"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(4)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Payment Failed -->
            <div class="notification-item" data-id="5">
                <div class="notification-icon error">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Payment Failed</div>
                    <div class="notification-message">Payment failed for user Mike Wilson. Subscription paused.</div>
                    <div class="notification-time">3 hours ago</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewNotification(5)">
                        <i class="fas fa-user"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(5)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Live Stream Started -->
            <div class="notification-item live" data-id="6">
                <div class="notification-icon live-stream">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Live Stream Started</div>
                    <div class="notification-message">Sports Channel is now live with 2.5K viewers</div>
                    <div class="notification-time">
                        <span class="live-badge">LIVE NOW</span>
                    </div>
                </div>
                <div class="notification-actions">
                    <button class="btn-icon" onclick="viewLiveStream(6)">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="btn-icon" onclick="dismissNotification(6)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="notifications-footer">
            <a href="/admin/notifications" class="view-all-link">View All Notifications</a>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div class="toast-container" id="toastContainer"></div>

<!-- Notification Settings Modal -->
<div class="notification-settings-modal" id="notificationSettingsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Notification Settings</h3>
            <button class="close-btn" onclick="closeNotificationSettings()">×</button>
        </div>
        <div class="modal-body">
            <div class="settings-group">
                <h4>Email Notifications</h4>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                    <span class="label">New user registrations</span>
                </label>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                    <span class="label">Subscription changes</span>
                </label>
                <label class="toggle-switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                    <span class="label">Content uploads</span>
                </label>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                    <span class="label">System alerts</span>
                </label>
            </div>

            <div class="settings-group">
                <h4>Push Notifications</h4>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                    <span class="label">Desktop notifications</span>
                </label>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                    <span class="label">Sound alerts</span>
                </label>
            </div>

            <div class="settings-group">
                <h4>Notification Frequency</h4>
                <select class="frequency-select">
                    <option>Instant</option>
                    <option>Every 5 minutes</option>
                    <option>Every 15 minutes</option>
                    <option>Hourly digest</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeNotificationSettings()">Cancel</button>
            <button class="btn btn-primary" onclick="saveNotificationSettings()">Save Settings</button>
        </div>
    </div>
</div>

<style>
/* Notifications Wrapper */
.notifications-wrapper {
    position: relative;
}

/* Notification Trigger */
.notification-trigger {
    position: relative;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background 0.3s ease;
}

.notification-trigger:hover {
    background: rgba(255, 255, 255, 0.1);
}

.notification-trigger i {
    font-size: 1.2rem;
    color: white;
}

.notification-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #ef4444;
    color: white;
    font-size: 0.7rem;
    font-weight: bold;
    padding: 0.1rem 0.3rem;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
    animation: pulse-badge 2s infinite;
}

@keyframes pulse-badge {
    0% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    70% {
        box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
    }
}

/* Notifications Dropdown */
.notifications-dropdown {
    position: absolute;
    top: calc(100% + 1rem);
    right: 0;
    width: 400px;
    background: var(--surface-color, #141414);
    border: 1px solid #333;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 1000;
    max-height: 600px;
    overflow: hidden;
    animation: slideDown 0.3s ease;
}

.notifications-dropdown.show {
    display: block;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Notifications Header */
.notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #333;
}

.notifications-header h3 {
    margin: 0;
    color: white;
    font-size: 1.1rem;
}

.notification-actions {
    display: flex;
    gap: 0.5rem;
}

.mark-all-read,
.settings-btn {
    padding: 0.25rem 0.5rem;
    background: transparent;
    border: none;
    color: #888;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.mark-all-read:hover,
.settings-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

/* Notification Tabs */
.notification-tabs {
    display: flex;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #333;
    gap: 0.5rem;
}

.tab-btn {
    padding: 0.5rem 1rem;
    background: transparent;
    border: none;
    color: #888;
    cursor: pointer;
    border-radius: 20px;
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.tab-btn:hover {
    background: rgba(255, 255, 255, 0.05);
    color: white;
}

.tab-btn.active {
    background: var(--primary-color, #A20136);
    color: white;
}

/* Notifications List */
.notifications-list {
    max-height: 400px;
    overflow-y: auto;
    padding: 0.5rem;
}

.notifications-list::-webkit-scrollbar {
    width: 6px;
}

.notifications-list::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
}

.notifications-list::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 3px;
}

/* Notification Item */
.notification-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 0.5rem;
    transition: background 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.05);
}

.notification-item.unread {
    background: rgba(162, 1, 54, 0.1);
    border-left: 3px solid var(--primary-color, #A20136);
}

.notification-item.live {
    background: rgba(74, 222, 128, 0.05);
    border-left: 3px solid #4ade80;
}

/* Notification Icon */
.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.notification-icon.new-user {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.notification-icon.subscription {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.notification-icon.content {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
}

.notification-icon.alert {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.notification-icon.error {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff4757 100%);
}

.notification-icon.live-stream {
    background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
    animation: pulse-live 2s infinite;
}

@keyframes pulse-live {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.notification-icon i {
    color: white;
    font-size: 1rem;
}

/* Notification Content */
.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-weight: 600;
    color: white;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.notification-message {
    color: #888;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.notification-time {
    color: #666;
    font-size: 0.75rem;
}

.live-badge {
    display: inline-block;
    padding: 0.2rem 0.5rem;
    background: #ef4444;
    color: white;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: bold;
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Notification Item Actions */
.notification-item .notification-actions {
    display: none;
    gap: 0.25rem;
}

.notification-item:hover .notification-actions {
    display: flex;
}

.notification-item .btn-icon {
    width: 28px;
    height: 28px;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: #888;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.notification-item .btn-icon:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Notifications Footer */
.notifications-footer {
    padding: 1rem;
    text-align: center;
    border-top: 1px solid #333;
}

.view-all-link {
    color: var(--primary-color, #A20136);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

/* Toast Container */
.toast-container {
    position: fixed;
    top: 2rem;
    right: 2rem;
    z-index: 10000;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Toast Notification */
.toast {
    background: var(--surface-color, #141414);
    border: 1px solid #333;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    min-width: 300px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast.success {
    border-left: 4px solid #4ade80;
}

.toast.error {
    border-left: 4px solid #ef4444;
}

.toast.warning {
    border-left: 4px solid #fb923c;
}

.toast.info {
    border-left: 4px solid #3b82f6;
}

.toast-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.toast.success .toast-icon {
    background: rgba(74, 222, 128, 0.2);
    color: #4ade80;
}

.toast.error .toast-icon {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.toast.warning .toast-icon {
    background: rgba(251, 146, 60, 0.2);
    color: #fb923c;
}

.toast.info .toast-icon {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-weight: 600;
    color: white;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.toast-message {
    color: #888;
    font-size: 0.85rem;
}

.toast-close {
    width: 24px;
    height: 24px;
    border: none;
    background: transparent;
    color: #888;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.toast-close:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

/* Notification Settings Modal */
.notification-settings-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 2000;
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
}

.notification-settings-modal.show {
    display: flex;
}

.notification-settings-modal .modal-content {
    background: var(--surface-color, #141414);
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.notification-settings-modal .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #333;
}

.notification-settings-modal .modal-header h3 {
    margin: 0;
    color: white;
}

.notification-settings-modal .close-btn {
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

.notification-settings-modal .modal-body {
    padding: 1.5rem;
}

.settings-group {
    margin-bottom: 2rem;
}

.settings-group h4 {
    color: white;
    margin-bottom: 1rem;
    font-size: 0.95rem;
}

/* Toggle Switch */
.toggle-switch {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    cursor: pointer;
}

.toggle-switch input {
    display: none;
}

.toggle-switch .slider {
    position: relative;
    width: 44px;
    height: 24px;
    background: #333;
    border-radius: 12px;
    margin-right: 1rem;
    transition: background 0.3s ease;
}

.toggle-switch .slider::before {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    background: white;
    border-radius: 50%;
    top: 3px;
    left: 3px;
    transition: transform 0.3s ease;
}

.toggle-switch input:checked + .slider {
    background: var(--primary-color, #A20136);
}

.toggle-switch input:checked + .slider::before {
    transform: translateX(20px);
}

.toggle-switch .label {
    color: #888;
    font-size: 0.9rem;
}

.frequency-select {
    width: 100%;
    padding: 0.75rem;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid #333;
    border-radius: 8px;
    color: white;
    font-size: 0.9rem;
}

.notification-settings-modal .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #333;
}

/* Responsive */
@media (max-width: 480px) {
    .notifications-dropdown {
        width: 100vw;
        right: -1rem;
        border-radius: 0;
        max-height: 100vh;
    }

    .toast-container {
        right: 1rem;
        left: 1rem;
    }

    .toast {
        min-width: auto;
        width: 100%;
    }
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    font-size: 0.9rem;
}

.btn-primary {
    background: var(--primary-gradient, linear-gradient(135deg, #A20136 0%, #8b0000 100%));
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
</style>

<script>
// Toggle notifications dropdown
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    dropdown.classList.toggle('show');

    // Mark notifications as read when opened
    if (dropdown.classList.contains('show')) {
        setTimeout(() => {
            updateNotificationBadge();
        }, 2000);
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.querySelector('.notifications-wrapper');
    if (!wrapper.contains(e.target)) {
        document.getElementById('notificationsDropdown').classList.remove('show');
    }
});

// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        filterNotifications(this.dataset.tab);
    });
});

// Filter notifications
function filterNotifications(tab) {
    console.log('Filtering notifications by:', tab);
    // Implement filtering logic here
}

// Mark all as read
function markAllAsRead() {
    document.querySelectorAll('.notification-item.unread').forEach(item => {
        item.classList.remove('unread');
    });
    updateNotificationBadge();
    showToast('success', 'Success', 'All notifications marked as read');
}

// Update notification badge
function updateNotificationBadge() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const badge = document.getElementById('notificationBadge');

    if (unreadCount > 0) {
        badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
        badge.style.display = 'block';
    } else {
        badge.style.display = 'none';
    }
}

// View notification
function viewNotification(id) {
    console.log('Viewing notification:', id);
    const item = document.querySelector(`.notification-item[data-id="${id}"]`);
    if (item) {
        item.classList.remove('unread');
        updateNotificationBadge();
    }
}

// Dismiss notification
function dismissNotification(id) {
    const item = document.querySelector(`.notification-item[data-id="${id}"]`);
    if (item) {
        item.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            item.remove();
            updateNotificationBadge();
        }, 300);
    }
}

// View live stream
function viewLiveStream(id) {
    console.log('Viewing live stream:', id);
    window.open('/admin/live-streams/' + id, '_blank');
}

// Open notification settings
function openNotificationSettings() {
    document.getElementById('notificationSettingsModal').classList.add('show');
}

// Close notification settings
function closeNotificationSettings() {
    document.getElementById('notificationSettingsModal').classList.remove('show');
}

// Save notification settings
function saveNotificationSettings() {
    showToast('success', 'Settings Saved', 'Your notification preferences have been updated');
    closeNotificationSettings();
}

// Show toast notification
function showToast(type, title, message) {
    const toastContainer = document.getElementById('toastContainer');

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fas fa-${getToastIcon(type)}"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close" onclick="closeToast(this)">
            <i class="fas fa-times"></i>
        </button>
    `;

    toastContainer.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Get toast icon based on type
function getToastIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'times-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Close toast
function closeToast(button) {
    const toast = button.parentElement;
    toast.style.animation = 'slideOut 0.3s ease';
    setTimeout(() => toast.remove(), 300);
}

// Slide out animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// WebSocket for real-time notifications (simulated)
function initializeWebSocket() {
    // Simulate receiving notifications
    setInterval(() => {
        if (Math.random() > 0.8) {
            simulateNewNotification();
        }
    }, 30000); // Every 30 seconds
}

// Simulate new notification
function simulateNewNotification() {
    const notifications = [
        {
            type: 'success',
            title: 'New Subscription',
            message: 'A new user just subscribed to Premium plan'
        },
        {
            type: 'info',
            title: 'Content Update',
            message: 'New episode available for popular series'
        },
        {
            type: 'warning',
            title: 'Storage Warning',
            message: 'Storage usage is at 75% capacity'
        }
    ];

    const notification = notifications[Math.floor(Math.random() * notifications.length)];
    showToast(notification.type, notification.title, notification.message);

    // Update badge
    const badge = document.getElementById('notificationBadge');
    const currentCount = parseInt(badge.textContent) || 0;
    badge.textContent = currentCount + 1;
    badge.style.display = 'block';

    // Play notification sound
    playNotificationSound();
}

// Play notification sound
function playNotificationSound() {
    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBiuBzvLZiTUIG2m98OScTgwOUann7blmFgU7k9n1unEiBC13yO/eizEIHWq+8+OWT' +
        'AsOUqzn77RiGQUvg8/12IcwCBxpve3onVIMC1Gq5O+3YRsGMIXR8tiIOQkZaLvt559NEAxPqOPwtmMcBjiP1/PMeS0GI3fH8N+RQAoUXrTp66hVFApGnt/yvmwhBiuBzvLYiTQIHGm+8eSaTgsLUqvm77ViGAU9k9n1unEiBCx5x+/eizEIHWq+8+OWT' +
        'AkKTqXm7blmFgU7k9n1unEiBC13yO/eizEIHWq+8+OWTAkKUqzl7rVlGAU3k9n1unEiBCx5x+/eizEIHWq+8+OWTAkKUqvm7rdmGAU7k9n1unEiBCx5x+/eizEIHWq+8+OWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWq+8+OWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWq+8+OWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWq+8+OWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77dlGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGAU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqvm77RjGQU7k9n1unEiBCx5x+/eizEIHWm98uOWTAkKUqzm7rRjGQU7k9n1uHEhBS15yu7bi');
    audio.volume = 0.3;
    audio.play().catch(e => console.log('Notification sound blocked:', e));
}

// Request notification permission
function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                showToast('success', 'Notifications Enabled', 'You will receive desktop notifications');
            }
        });
    }
}

// Show desktop notification
function showDesktopNotification(title, message, icon) {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(title, {
            body: message,
            icon: icon || '/admin/assets/icon.png',
            badge: '/admin/assets/badge.png',
            vibrate: [200, 100, 200]
        });
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updateNotificationBadge();
    initializeWebSocket();
    requestNotificationPermission();
});
</script>