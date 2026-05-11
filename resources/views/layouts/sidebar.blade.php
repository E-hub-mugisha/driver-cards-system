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
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 32px rgba(0, 0, 0, 0.15);
    }

    /* ============= SIDEBAR MODERN ============= */
    .nk-sidebar-modern {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fb 100%);
        border-right: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .nk-sidebar-modern.is-collapsed {
        width: 80px;
    }

    .nk-sidebar-modern.is-collapsed .sidebar-brand-text,
    .nk-sidebar-modern.is-collapsed .nk-menu-text,
    .nk-sidebar-modern.is-collapsed .overline-title {
        display: none;
    }

    /* Sidebar Header */
    .sidebar-header-modern {
        padding: 24px 20px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .sidebar-brand-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        flex: 1;
    }

    .sidebar-brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary) 0%, #0094d4 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 173, 238, 0.25);
    }

    .sidebar-brand-text {
        font-weight: 700;
        color: var(--dark);
        font-size: 16px;
        letter-spacing: -0.5px;
        margin: 0;
    }

    .sidebar-brand-text span {
        display: block;
        font-size: 12px;
        color: var(--gray-600);
        font-weight: 500;
        margin-top: 2px;
    }

    .sidebar-toggle-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: var(--gray-100);
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        transition: all 0.2s ease;
    }

    .sidebar-toggle-btn:hover {
        background: var(--primary);
        color: white;
    }

    /* Sidebar Content */
    .sidebar-content-modern {
        flex: 1;
        overflow-y: auto;
        padding: 20px 0;
    }

    .sidebar-content-modern::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-content-modern::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-content-modern::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 3px;
    }

    .sidebar-content-modern::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }

    /* Menu Styles */
    .sidebar-menu-modern {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-heading-modern {
        padding: 16px 20px 12px;
        margin-top: 8px;
    }

    .menu-heading-modern:first-child {
        margin-top: 0;
    }

    .menu-heading-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        color: var(--gray-500);
        text-transform: uppercase;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .menu-heading-title::before {
        content: '';
        width: 3px;
        height: 3px;
        background: var(--primary);
        border-radius: 50%;
    }

    .menu-item-modern {
        padding: 0 12px;
        margin-bottom: 4px;
    }

    .menu-link-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        text-decoration: none;
        color: var(--gray-700);
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .menu-link-modern::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background: var(--primary);
        transform: scaleY(0);
        transform-origin: top;
        transition: transform 0.3s ease;
    }

    .menu-link-modern:hover {
        background: var(--gray-100);
        color: var(--primary);
    }

    .menu-link-modern:hover::before {
        transform: scaleY(1);
    }

    .menu-link-modern.active {
        background: linear-gradient(135deg, rgba(0, 173, 238, 0.1) 0%, rgba(227, 178, 40, 0.05) 100%);
        color: var(--primary);
        font-weight: 600;
    }

    .menu-link-modern.active::before {
        transform: scaleY(1);
    }

    .menu-icon-modern {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .menu-text-modern {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Sidebar Footer */
    .sidebar-footer-modern {
        padding: 16px 20px;
        border-top: 1px solid var(--gray-200);
        background: var(--gray-50);
    }

    .user-card-mini {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: white;
        border-radius: 8px;
        text-decoration: none;
        color: var(--dark);
        transition: all 0.2s ease;
    }

    .user-card-mini:hover {
        background: var(--gray-100);
        transform: translateY(-2px);
    }

    .user-avatar-mini {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .user-info-mini {
        flex: 1;
        min-width: 0;
    }

    .user-name-mini {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-role-mini {
        font-size: 11px;
        color: var(--gray-600);
        margin-top: 2px;
    }

    /* Responsive */
    @media (max-width: 1199px) {
        .nk-sidebar-modern {
            width: 280px;
            position: fixed;
            left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nk-sidebar-modern.is-open {
            transform: translateX(0);
        }
    }
</style>

<div class="nk-sidebar-modern" id="sidebarMenu">
    <!-- Header -->
    <div class="sidebar-header-modern">
        <a href="{{ auth()->user()->companyStaff ? route('company.dashboard') : route('admin.home') }}"
           class="sidebar-brand-modern">
            <div class="sidebar-brand-icon">
                <em class="icon ni ni-briefcase"></em>
            </div>
            <div>
                <p class="sidebar-brand-text">
                    {{ config('app.name') }}
                    <span>Fleet Management</span>
                </p>
            </div>
        </a>
        <button class="sidebar-toggle-btn d-xl-none" id="sidebarToggleBtn">
            <em class="icon ni ni-arrow-left"></em>
        </button>
    </div>

    <!-- Content -->
    <div class="sidebar-content-modern">
        <ul class="sidebar-menu-modern">

            {{-- ================= ADMIN SIDEBAR ================= --}}
            @if(auth()->user()->type === 'admin')

                {{-- MAIN --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Admin Panel</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.home') }}" class="menu-link-modern {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-dashboard"></em></span>
                        <span class="menu-text-modern">Dashboard</span>
                    </a>
                </li>

                {{-- MANAGEMENT --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Management</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.users.index') }}" class="menu-link-modern {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-users"></em></span>
                        <span class="menu-text-modern">Staff Users</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.companies.index') }}" class="menu-link-modern {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-building"></em></span>
                        <span class="menu-text-modern">Companies</span>
                    </a>
                </li>

                {{-- DRIVERS --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Drivers</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.drivers.index') }}" class="menu-link-modern {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-truck"></em></span>
                        <span class="menu-text-modern">Drivers</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.behaviors.index') }}" class="menu-link-modern {{ request()->routeIs('admin.behaviors.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-alert"></em></span>
                        <span class="menu-text-modern">Driver Behavior</span>
                    </a>
                </li>

                {{-- PAYROLL --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Payroll</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.payroll.index') }}" class="menu-link-modern {{ request()->routeIs('admin.payroll.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-wallet"></em></span>
                        <span class="menu-text-modern">Payroll Processing</span>
                    </a>
                </li>

                {{-- REPORTS --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Reports & Analytics</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('reports.index') }}" class="menu-link-modern {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-report"></em></span>
                        <span class="menu-text-modern">Reports</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.company.behavior.page') }}" class="menu-link-modern {{ request()->routeIs('admin.company.behavior.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-report"></em></span>
                        <span class="menu-text-modern">Behavior Reports</span>
                    </a>
                </li>

                {{-- SYSTEM --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">System</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('admin.settings.index') }}" class="menu-link-modern {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-setting"></em></span>
                        <span class="menu-text-modern">System Settings</span>
                    </a>
                </li>

            @endif


            {{-- ================= COMPANY SIDEBAR ================= --}}
            @if(auth()->user()->staff)

                {{-- COMPANY --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Company Panel</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.dashboard') }}" class="menu-link-modern {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-dashboard"></em></span>
                        <span class="menu-text-modern">Dashboard</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.profile.index') }}" class="menu-link-modern {{ request()->routeIs('company.profile.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-building"></em></span>
                        <span class="menu-text-modern">Company Profile</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.staff.index') }}" class="menu-link-modern {{ request()->routeIs('company.staff.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-users"></em></span>
                        <span class="menu-text-modern">Company Staff</span>
                    </a>
                </li>

                {{-- DRIVERS --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Drivers</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.drivers.index') }}" class="menu-link-modern {{ request()->routeIs('company.drivers.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-truck"></em></span>
                        <span class="menu-text-modern">Drivers list</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.reports.behaviors') }}" class="menu-link-modern {{ request()->routeIs('company.reports.behaviors') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-alert"></em></span>
                        <span class="menu-text-modern">Drivers Behavior</span>
                    </a>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.reports.incidents') }}" class="menu-link-modern {{ request()->routeIs('company.reports.incidents') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-alert"></em></span>
                        <span class="menu-text-modern">Drivers Incident</span>
                    </a>
                </li>

                {{-- PAYROLL --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Payroll</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.payroll.index') }}" class="menu-link-modern {{ request()->routeIs('company.payroll.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-wallet"></em></span>
                        <span class="menu-text-modern">Payroll</span>
                    </a>
                </li>

                {{-- REPORTS --}}
                <li class="menu-heading-modern">
                    <h6 class="menu-heading-title">Reports</h6>
                </li>

                <li class="menu-item-modern">
                    <a href="{{ route('company.reports.index') }}" class="menu-link-modern {{ request()->routeIs('company.reports.*') ? 'active' : '' }}">
                        <span class="menu-icon-modern"><em class="icon ni ni-report"></em></span>
                        <span class="menu-text-modern">Driver Reports</span>
                    </a>
                </li>

            @endif

        </ul>
    </div>

    <!-- Footer -->
    <div class="sidebar-footer-modern">
        <a href="#" class="user-card-mini">
            <div class="user-avatar-mini">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
            </div>
            <div class="user-info-mini">
                <div class="user-name-mini">{{ Auth::user()->name }}</div>
                <div class="user-role-mini">{{ ucfirst(Auth::user()->type) }}</div>
            </div>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('sidebarMenu');

    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('is-open');
        });
    }

    // Close sidebar when clicking on a menu link (mobile)
    const menuLinks = sidebar.querySelectorAll('.menu-link-modern');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1200) {
                sidebar.classList.remove('is-open');
            }
        });
    });
});
</script>