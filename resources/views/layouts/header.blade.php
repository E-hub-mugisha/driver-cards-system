<style>
    :root {
        --primary: #00ADEE;
        --accent: #E3B228;
        --dark: #1a1f36;
        --light: #f8f9fb;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --white: #ffffff;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 32px rgba(0, 0, 0, 0.15);
    }

    /* ============= HEADER MODERN ============= */
    .header-modern {
        position: fixed;
        top: 0;
        left: 280px;
        right: 0;
        height: 70px;
        background: var(--white);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        padding: 0 32px;
        z-index: 999;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .header-modern.has-sidebar-collapsed {
        left: 80px;
    }

    .header-content-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        gap: 24px;
    }

    /* Left Section */
    .header-left-modern {
        display: flex;
        align-items: center;
        gap: 24px;
        flex: 1;
    }

    .header-brand-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-brand-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--primary) 0%, #0094d4 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(0, 173, 238, 0.3);
    }

    .header-brand-text h1 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .header-brand-text p {
        font-size: 12px;
        color: var(--gray-600);
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    .header-divider {
        width: 1px;
        height: 30px;
        background: var(--gray-200);
    }

    .header-breadcrumb {
        font-size: 13px;
        color: var(--gray-600);
        display: none;
    }

    .header-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .header-breadcrumb a:hover {
        color: var(--dark);
    }

    @media (min-width: 1400px) {
        .header-breadcrumb {
            display: block;
        }
    }

    /* Right Section */
    .header-right-modern {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* Search Bar */
    .header-search-modern {
        position: relative;
        width: 280px;
        display: none;
    }

    .header-search-modern.show {
        display: block;
    }

    .search-input-modern {
        width: 100%;
        padding: 10px 16px 10px 36px;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        font-size: 13px;
        background: var(--gray-100);
        color: var(--dark);
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .search-input-modern:focus {
        outline: none;
        background: var(--white);
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 173, 238, 0.1);
    }

    .search-icon-modern {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 16px;
    }

    /* Header Actions */
    .header-actions-modern {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .action-btn-modern {
        width: 40px;
        height: 40px;
        border: 1px solid var(--gray-200);
        background: var(--gray-100);
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        font-size: 18px;
        transition: all 0.2s ease;
        position: relative;
    }

    .action-btn-modern:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .action-btn-modern.has-notification::after {
        content: '';
        position: absolute;
        top: 6px;
        right: 6px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        box-shadow: 0 0 0 2px var(--white);
    }

    /* Notifications Panel */
    .notifications-panel {
        position: absolute;
        top: 100%;
        right: 0;
        width: 360px;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        box-shadow: var(--shadow-lg);
        margin-top: 12px;
        z-index: 1001;
        display: none;
    }

    .notifications-panel.active {
        display: block;
        animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    .notifications-header {
        padding: 16px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .notifications-header h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .notifications-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 12px 16px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        gap: 12px;
        align-items: flex-start;
        transition: background 0.2s ease;
    }

    .notification-item:hover {
        background: var(--gray-50);
    }

    .notification-icon {
        width: 32px;
        height: 32px;
        background: rgba(0, 173, 238, 0.1);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 16px;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
        margin: 0;
    }

    .notification-time {
        font-size: 12px;
        color: var(--gray-500);
        margin-top: 4px;
    }

    /* User Menu */
    .user-menu-modern {
        position: relative;
    }

    .user-toggle-modern {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
        text-decoration: none;
        color: var(--dark);
    }

    .user-toggle-modern:hover {
        background: var(--gray-100);
    }

    .user-avatar-modern {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 173, 238, 0.25);
    }

    .user-info-modern {
        text-align: right;
        display: none;
    }

    .user-info-modern.show {
        display: block;
    }

    .user-name-modern {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .user-role-modern {
        font-size: 11px;
        color: var(--gray-600);
        margin: 2px 0 0 0;
    }

    .user-menu-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 280px;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        box-shadow: var(--shadow-lg);
        margin-top: 12px;
        z-index: 1001;
        display: none;
    }

    .user-menu-dropdown.active {
        display: block;
        animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-card-dropdown {
        padding: 16px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .user-card-dropdown .user-avatar-modern {
        width: 44px;
        height: 44px;
        font-size: 16px;
    }

    .user-card-info {
        flex: 1;
    }

    .user-card-info p {
        margin: 0;
    }

    .user-card-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .user-card-email {
        font-size: 12px;
        color: var(--gray-600);
        margin-top: 4px;
    }

    .dropdown-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .dropdown-menu-item {
        border-bottom: 1px solid var(--gray-100);
    }

    .dropdown-menu-item:last-child {
        border-bottom: none;
    }

    .dropdown-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--gray-700);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .dropdown-menu-link:hover {
        background: var(--gray-50);
        color: var(--primary);
    }

    .dropdown-menu-link em {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    .dropdown-divider {
        height: 1px;
        background: var(--gray-200);
        margin: 8px 0;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #ef4444;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        transition: all 0.2s ease;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.05);
        color: #dc2626;
    }

    .logout-btn em {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 1199px) {
        .header-modern {
            left: 0;
        }

        .header-modern.has-sidebar-collapsed {
            left: 0;
        }

        .header-brand-info {
            gap: 12px;
        }

        .header-divider {
            display: none;
        }

        .header-breadcrumb {
            display: none !important;
        }

        .header-search-modern {
            width: 220px;
        }

        .header-right-modern {
            gap: 16px;
        }

        .user-info-modern {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .header-modern {
            padding: 0 16px;
            gap: 12px;
        }

        .header-brand-text h1 {
            font-size: 16px;
        }

        .header-brand-text p {
            display: none;
        }

        .header-left-modern {
            gap: 12px;
        }

        .header-search-modern {
            display: none !important;
        }

        .header-actions-modern {
            gap: 8px;
        }

        .action-btn-modern {
            width: 36px;
            height: 36px;
        }

        .notifications-panel {
            width: 320px;
            right: -50%;
        }

        .user-menu-dropdown {
            width: 260px;
        }
    }
</style>

<header class="header-modern" id="headerModern">
    <div class="header-content-modern">
        <!-- Left Section -->
        <div class="header-left-modern">
            <button class="action-btn-modern d-xl-none" id="mobileSidebarToggle">
                <em class="icon ni ni-menu"></em>
            </button>
            
            <div class="header-brand-info">
                <div class="header-brand-icon">
                    <em class="icon ni ni-briefcase"></em>
                </div>
                <div class="header-brand-text">
                    <h1>{{ config('app.name') }}</h1>
                    <p>Fleet Management System</p>
                </div>
            </div>

            <div class="header-divider"></div>

            <div class="header-breadcrumb" id="headerBreadcrumb">
                <a href="#">Dashboard</a> / <span id="pageTitle">Home</span>
            </div>
        </div>

        <!-- Right Section -->
        <div class="header-right-modern">
            <!-- Search -->
            <div class="header-search-modern" id="headerSearch">
                <em class="icon ni ni-search search-icon-modern"></em>
                <input type="text" class="search-input-modern" placeholder="Search drivers, reports...">
            </div>

            <!-- Actions -->
            <div class="header-actions-modern">
                <!-- Search Toggle -->
                <button class="action-btn-modern d-lg-none" id="searchToggleBtn" title="Search">
                    <em class="icon ni ni-search"></em>
                </button>

                <!-- Notifications -->
                <button class="action-btn-modern has-notification" id="notificationsBtn" title="Notifications">
                    <em class="icon ni ni-bell"></em>
                </button>

                <div class="notifications-panel" id="notificationsPanel">
                    <div class="notifications-header">
                        <h3>Notifications</h3>
                        <button class="action-btn-modern" style="width: 28px; height: 28px; font-size: 14px;" id="closeNotifications">
                            <em class="icon ni ni-cross"></em>
                        </button>
                    </div>
                    <div class="notifications-body">
                        <div class="notification-item">
                            <div class="notification-icon">
                                <em class="icon ni ni-alert"></em>
                            </div>
                            <div class="notification-content">
                                <p class="notification-title">Driver Behavior Alert</p>
                                <p class="notification-time">John Doe - 5 minutes ago</p>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-icon">
                                <em class="icon ni ni-check-circle"></em>
                            </div>
                            <div class="notification-content">
                                <p class="notification-title">Payroll Processed</p>
                                <p class="notification-time">System - 2 hours ago</p>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-icon">
                                <em class="icon ni ni-info"></em>
                            </div>
                            <div class="notification-content">
                                <p class="notification-title">System Maintenance</p>
                                <p class="notification-time">Admin - 1 day ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="user-menu-modern">
                    <a href="#" class="user-toggle-modern" id="userMenuToggle">
                        <div class="user-avatar-modern">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                        </div>
                        <div class="user-info-modern show">
                            <p class="user-name-modern">{{ Auth::user()->name }}</p>
                            <p class="user-role-modern">{{ ucfirst(Auth::user()->type) }}</p>
                        </div>
                    </a>

                    <div class="user-menu-dropdown" id="userMenuDropdown">
                        <div class="user-card-dropdown">
                            <div class="user-avatar-modern">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                            </div>
                            <div class="user-card-info">
                                <p class="user-card-name">{{ Auth::user()->name }}</p>
                                <p class="user-card-email">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-item">
                                <a href="#" class="dropdown-menu-link">
                                    <em class="icon ni ni-user-alt"></em>
                                    <span>View Profile</span>
                                </a>
                            </li>
                            <li class="dropdown-menu-item">
                                <a href="#" class="dropdown-menu-link">
                                    <em class="icon ni ni-setting-alt"></em>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                        </ul>

                        <div class="dropdown-divider"></div>

                        <button type="button" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <em class="icon ni ni-signout"></em>
                            <span>Sign Out</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Menu Toggle
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userMenuDropdown = document.getElementById('userMenuDropdown');

    userMenuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        userMenuDropdown.classList.toggle('active');
        notificationsPanel.classList.remove('active');
    });

    // Notifications Toggle
    const notificationsBtn = document.getElementById('notificationsBtn');
    const notificationsPanel = document.getElementById('notificationsPanel');
    const closeNotifications = document.getElementById('closeNotifications');

    notificationsBtn.addEventListener('click', function() {
        notificationsPanel.classList.toggle('active');
        userMenuDropdown.classList.remove('active');
    });

    closeNotifications.addEventListener('click', function() {
        notificationsPanel.classList.remove('active');
    });

    // Search Toggle
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const headerSearch = document.getElementById('headerSearch');

    if (searchToggleBtn) {
        searchToggleBtn.addEventListener('click', function() {
            headerSearch.classList.toggle('show');
            if (headerSearch.classList.contains('show')) {
                headerSearch.querySelector('input').focus();
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!userMenuToggle.contains(e.target) && !userMenuDropdown.contains(e.target)) {
            userMenuDropdown.classList.remove('active');
        }
        if (!notificationsBtn.contains(e.target) && !notificationsPanel.contains(e.target)) {
            notificationsPanel.classList.remove('active');
        }
    });

    // Mobile sidebar toggle
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebarMenu');
            if (sidebar) {
                sidebar.classList.toggle('is-open');
            }
        });
    }
});
</script>