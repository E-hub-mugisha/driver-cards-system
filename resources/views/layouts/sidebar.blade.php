<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a><a href="#"
                class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
        <div class="nk-sidebar-brand"><a href="../../index.html" class="logo-link nk-sidebar-logo"><img
                    class="logo-light logo-img" src="../../images/logo.png"
                    srcset="/demo1/images/logo2x.png 2x" alt="logo"><img class="logo-dark logo-img"
                    src="../../images/logo-dark.png" srcset="/demo1/images/logo-dark2x.png 2x"
                    alt="logo-dark"></a></div>
    </div>
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    @if(auth()->user()->type == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.home') }}" class="nav-link">Dashboard</a>
                    </li>
                    @elseif(auth()->user()->type == 'manager')
                    <li class="nav-item">
                        <a href="{{ route('manager.home') }}" class="nav-link">Dashboard</a>
                    </li>
                    @else
                    <li class="nk-menu-item">
                        <a href="{{ route('driver.index') }}" class="nk-menu-link">Dashboard</a>
                    </li>
                    @endif
                    <li class="nk-menu-item">
                        <a href="{{ route('member.index')}}" class="nk-menu-link"><span>Members List</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.users.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Staff users</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.companies.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Companies</span>
                        </a>
                    </li>
                    
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.drivers.index')}}" class="nk-menu-link"><span>Driver</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.behaviors.index') }}" class="nk-menu-link"><span>Behavior</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.payroll.index') }}" class="nk-menu-link"><span>Payroll</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('reports.index')}}" class="nk-menu-link"><span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>