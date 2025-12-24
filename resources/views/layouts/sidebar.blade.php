<div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">
                <em class="icon ni ni-arrow-left"></em>
            </a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu">
                <em class="icon ni ni-menu"></em>
            </a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="{{ route('admin.home') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('assets/images/logo.png') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo.png') }}" alt="logo-dark">
            </a>
        </div>
    </div>

    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">

                    {{-- Dashboard --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Main</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.home') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>

                    {{-- Users & Companies --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Management</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.users.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Staff Users</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.companies.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-building"></em></span>
                            <span class="nk-menu-text">Companies</span>
                        </a>
                    </li>

                    {{-- Drivers --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Drivers</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.drivers.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-truck"></em></span>
                            <span class="nk-menu-text">Drivers</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.behaviors.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-alert"></em></span>
                            <span class="nk-menu-text">Driver Behavior</span>
                        </a>
                    </li>

                    {{-- Payroll --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Payroll</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.payroll.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-wallet"></em></span>
                            <span class="nk-menu-text">Payroll Processing</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.payroll.settings.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                            <span class="nk-menu-text">Payroll Settings</span>
                        </a>
                    </li>

                    {{-- Reports --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Reports & Analytics</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('reports.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-report"></em></span>
                            <span class="nk-menu-text">Reports</span>
                        </a>
                    </li>

                    {{-- System --}}
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">System</h6>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('admin.settings.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                            <span class="nk-menu-text">System Settings</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
