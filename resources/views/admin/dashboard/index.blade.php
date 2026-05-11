@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Dashboard</h3>
                    <div class="nk-block-des text-soft">
                        <p>Welcome to {{ config('app.name') }} Overview</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                            <em class="icon ni ni-more-v"></em>
                        </a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown">
                                            <em class="d-none d-sm-inline icon ni ni-calender-date"></em>
                                            <span><span class="d-none d-md-inline">Last</span> 30 Days</span>
                                            <em class="dd-indc icon ni ni-chevron-right"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#"><span>Last 7 Days</span></a></li>
                                                <li><a href="#"><span>Last 30 Days</span></a></li>
                                                <li><a href="#"><span>Last 6 Months</span></a></li>
                                                <li><a href="#"><span>Last 1 Year</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="nk-block-tools-opt">
                                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-primary rounded-5">
                                        <em class="icon ni ni-reports"></em>
                                        <span>Reports</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards Section -->
        <div class="nk-block">
            <div class="row g-gs">
                <!-- Total Drivers Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-modern rounded-3 card-gradient-primary">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title text-dark">Total Drivers</h6>
                                    <p class="sub-text mb-0">Driver statistics overview</p>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" title="Drivers registered in the system"></em>
                                </div>
                            </div>

                            <div class="nk-sale-data-group flex-wrap g-4">
                                <div class="nk-sale-data">
                                    <span class="amount">
                                        {{ $DriversMonth }}
                                        <span class="change {{ $MonthChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                            <em class="icon ni ni-arrow-long-{{ $MonthChange >= 0 ? 'up' : 'down' }}"></em>
                                            {{ number_format($MonthChange, 2) }}%
                                        </span>
                                    </span>
                                    <span class="sub-title">Last 30 Days</span>
                                </div>

                                <div class="nk-sale-data">
                                    <span class="amount">
                                        {{ $DriversWeek }}
                                        <span class="change {{ $WeekChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                            <em class="icon ni ni-arrow-long-{{ $WeekChange >= 0 ? 'up' : 'down' }}"></em>
                                            {{ number_format($WeekChange, 2) }}%
                                        </span>
                                    </span>
                                    <span class="sub-title">This Week</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Driver Status Overview Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-modern rounded-3 card-gradient-accent">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title text-dark">Driver Status</h6>
                                    <p class="sub-text mb-0">Active, Suspended and Pending</p>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" title="Current driver status distribution"></em>
                                </div>
                            </div>

                            <div class="nk-sale-data-group flex-column g-3">
                                <div class="nk-sale-data">
                                    <span class="amount text-success">{{ $activeDrivers }}</span>
                                    <span class="sub-title">Active Drivers</span>
                                </div>

                                <div class="nk-sale-data">
                                    <span class="amount text-warning">{{ $pendingDrivers }}</span>
                                    <span class="sub-title">Pending Approval</span>
                                </div>

                                <div class="nk-sale-data">
                                    <span class="amount text-danger">{{ $suspendedDrivers }}</span>
                                    <span class="sub-title">Suspended Drivers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Companies Registration Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-modern rounded-3 card-gradient-secondary">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title text-dark">Avg Registered Companies</h6>
                                    <p class="sub-text mb-0">Companies registration overview</p>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" title="Daily average number of companies registered"></em>
                                </div>
                            </div>

                            <div class="nk-sale-data-group flex-wrap g-4">
                                <div class="nk-sale-data">
                                    <span class="amount">
                                        {{ number_format($avgCompaniesPerDay, 1) }}
                                        <span class="change {{ $companyChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                            <em class="icon ni ni-arrow-long-{{ $companyChange >= 0 ? 'up' : 'down' }}"></em>
                                            {{ number_format($companyChange, 2) }}%
                                        </span>
                                    </span>
                                    <span class="sub-title">Per Day</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="nk-block">
            <div class="row g-gs">
                <!-- Recent Drivers Table -->
                <div class="col-xxl-8">
                    <div class="card card-modern rounded-3 card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">
                                        <span class="me-2">Recent Drivers Added</span>
                                        <a href="{{ route('admin.drivers.index') }}" class="link d-none d-sm-inline">See All</a>
                                    </h6>
                                </div>
                                <div class="card-tools">
                                    <ul class="card-tools-nav">
                                        <li><a href="#"><span>All</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-inner p-0 border-top">
                            <div class="nk-tb-list nk-tb-orders">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span>Driver No.</span></div>
                                    <div class="nk-tb-col tb-col-sm"><span>Names</span></div>
                                    <div class="nk-tb-col tb-col-md"><span>Company</span></div>
                                    <div class="nk-tb-col tb-col-lg"><span>License</span></div>
                                    <div class="nk-tb-col"><span>Phone</span></div>
                                    <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                    <div class="nk-tb-col"><span>&nbsp;</span></div>
                                </div>

                                @forelse($drivers as $driver)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead text-primary fw-bold">{{ $driver->ID_number }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <div class="user-card">
                                            <div class="user-avatar user-avatar-sm rounded-2" style="background: linear-gradient(135deg, #00ADEE, #E3B228);">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($driver->names, 0, 1)) }}</span>
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $driver->names }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-sub text-soft">{{ $driver->company?->name ?? '-' }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-lg">
                                        <span class="tb-sub text-primary">{{ $driver->driver_license }}</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="tb-sub tb-amount">{{ $driver->phone }}</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="badge badge-dot {{ $driver->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($driver->status) }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-action">
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li>
                                                        <a href="{{ route('admin.drivers.show', $driver->id) }}">
                                                            <em class="icon ni ni-eye"></em>
                                                            <span>View Details</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <em class="icon ni ni-edit"></em>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col" colspan="7">
                                        <span class="text-center text-soft">No drivers found</span>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reported Drivers -->
                <div class="col-md-6 col-xxl-4">
                    <div class="card card-modern rounded-3 card-full">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Recent Reported Drivers</h6>
                                </div>
                                <div class="card-tools">
                                    <ul class="card-tools-nav">
                                        <li class="active"><a href="#"><span>All</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <ul class="nk-activity">
                            @forelse($reportedDrivers as $report)
                            <li class="nk-activity-item">
                                <div class="nk-activity-media user-avatar rounded-2 bg-danger-dim">
                                    <span class="text-danger fw-bold">
                                        {{ strtoupper(substr($report->driver->names ?? 'N', 0, 1)) }}
                                    </span>
                                </div>

                                <div class="nk-activity-data">
                                    <div class="label">
                                        <strong>{{ $report->driver->names ?? 'Unknown Driver' }}</strong>
                                        was reported for
                                        <span class="text-danger fw-bold">
                                            {{ $report->behaviorType->behaviorCategory->name ?? 'Uncategorized Behavior' }}
                                        </span>
                                    </div>

                                    <span class="time">
                                        <em class="icon ni ni-clock me-1"></em>
                                        {{ $report->behavior_date?->diffForHumans() ?? $report->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                            @empty
                            <li class="nk-activity-item">
                                <div class="nk-activity-data">
                                    <div class="label text-soft text-center py-4 w-100">
                                        <em class="icon ni ni-check-circle"></em>
                                        <p class="mt-2">No recent behavior reports</p>
                                    </div>
                                </div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- New Users -->
                <div class="col-md-6 col-xxl-4">
                    <div class="card card-modern rounded-3 card-full">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">New Users</h6>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('admin.users.index') }}" class="link">View All</a>
                                </div>
                            </div>
                        </div>

                        @forelse($users as $user)
                        <div class="card-inner card-inner-md border-bottom">
                            <div class="user-card">
                                <div class="user-avatar rounded-2 bg-primary-dim">
                                    <span class="text-primary fw-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(last(explode(' ', $user->name)), 0, 1)) }}
                                    </span>
                                </div>

                                <div class="user-info">
                                    <span class="lead-text">{{ $user->name }}</span>
                                    <span class="sub-text">{{ $user->email }}</span>
                                </div>

                                <div class="user-action">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li>
                                                    <a href="#">
                                                        <em class="icon ni ni-user-list"></em>
                                                        <span>View Profile</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <em class="icon ni ni-notify"></em>
                                                        <span>Send Notification</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="card-inner">
                            <p class="text-center text-soft py-4">No new users found.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Companies -->
                <div class="col-lg-6 col-xxl-4">
                    <div class="card card-modern rounded-3 h-100">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Recent Companies</h6>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('admin.companies.index') }}" class="link">All Companies</a>
                                </div>
                            </div>
                        </div>

                        <ul class="nk-support">
                            @forelse($companies as $company)
                            <li class="nk-support-item">
                                <div class="user-avatar rounded-2" style="background: linear-gradient(135deg, #E3B228, #d4a420);">
                                    <span class="text-white fw-bold">
                                        {{ strtoupper(substr($company->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="nk-support-content">
                                    <div class="title">
                                        <span>{{ $company->name }}</span>
                                        <span class="badge badge-dot badge-dot-xs ms-1 {{ $company->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($company->status) }}
                                        </span>
                                    </div>
                                    <p>{{ $company->email }}</p>
                                    <span class="time">{{ $company->address }}</span>
                                </div>
                            </li>
                            @empty
                            <li class="nk-support-item">
                                <div class="nk-support-content">
                                    <p class="text-center text-soft py-4">No companies found</p>
                                </div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Notifications Timeline -->
                <div class="col-lg-6 col-xxl-4">
                    <div class="card card-modern rounded-3 h-100">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Notifications</h6>
                                </div>
                                <div class="card-tools">
                                    <a href="#" class="link">View All</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-inner">
                            <div class="timeline">
                                <h6 class="timeline-head">November, 2024</h6>
                                <ul class="timeline-list">
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-primary is-outline"></div>
                                        <div class="timeline-date">13 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">KYC Application Submitted</h6>
                                            <div class="timeline-des">
                                                <p>Re-submitted KYC Application form.</p>
                                                <span class="time">09:30am</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-primary"></div>
                                        <div class="timeline-date">12 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">Document Verification</h6>
                                            <div class="timeline-des">
                                                <p>Your documents are under review.</p>
                                                <span class="time">02:15pm</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-success"></div>
                                        <div class="timeline-date">11 Nov <em class="icon ni ni-alarm-alt"></em></div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">Account Created</h6>
                                            <div class="timeline-des">
                                                <p>Welcome to our platform.</p>
                                                <span class="time">11:45am</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ============================================================================
       DASHBOARD MODERN ENHANCEMENTS - DashLite Compatible
       ============================================================================ */

    :root {
        --primary: #00ADEE;
        --primary-dark: #0094d4;
        --accent: #E3B228;
        --accent-dark: #d4a420;
        --dark: #1a1f36;
        --light: #f8f9fb;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-600: #4b5563;
        --white: #ffffff;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 32px rgba(0, 0, 0, 0.15);
    }

    /* Card Modern Enhancements */
    .card-modern {
        background: var(--white);
        border: 1px solid #e5e7eb;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-modern:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .card-modern.rounded-3 {
        border-radius: 12px;
    }

    /* Card Gradient Backgrounds */
    .card-gradient-primary {
        background: linear-gradient(135deg, rgba(0, 173, 238, 0.05), rgba(0, 173, 238, 0.02));
        border-left: 4px solid var(--primary);
    }

    .card-gradient-primary .card-title,
    .card-gradient-primary .nk-sale-data span.amount {
        color: var(--dark);
    }

    .card-gradient-accent {
        background: linear-gradient(135deg, rgba(227, 178, 40, 0.05), rgba(227, 178, 40, 0.02));
        border-left: 4px solid var(--accent);
    }

    .card-gradient-secondary {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.02));
        border-left: 4px solid #10b981;
    }

    /* Button Enhancements */
    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: 0 10px 32px rgba(0, 173, 238, 0.2);
        transform: translateY(-2px);
    }

    .btn-primary.rounded-5 {
        border-radius: 24px;
    }

    /* Avatar Enhancements */
    .user-avatar.rounded-2 {
        border-radius: 8px;
    }

    .user-avatar.bg-primary-dim {
        background: rgba(0, 173, 238, 0.1);
    }

    .user-avatar.bg-danger-dim {
        background: rgba(239, 68, 68, 0.1);
    }

    /* Badge Enhancements */
    .badge-dot.bg-success {
        background: rgba(16, 185, 129, 0.15) !important;
        color: #10b981;
    }

    .badge-dot.bg-warning {
        background: rgba(245, 158, 11, 0.15) !important;
        color: #f59e0b;
    }

    .badge-dot.bg-danger {
        background: rgba(239, 68, 68, 0.15) !important;
        color: #ef4444;
    }

    /* Table Enhancements */
    .nk-tb-item {
        transition: background 0.2s ease;
    }

    .nk-tb-item:not(.nk-tb-head):hover {
        background: var(--gray-50);
    }

    .nk-tb-col .text-primary {
        color: var(--primary);
        font-weight: 600;
    }

    /* Card Title Enhancements */
    .card-title-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .card-title h6.title {
        color: var(--dark);
        font-weight: 700;
        letter-spacing: -0.3px;
        margin: 0;
    }

    .link {
        color: var(--primary);
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .link:hover {
        color: var(--primary-dark);
    }

    /* Dropdown Menu Enhancements */
    .dropdown-menu {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        padding: 4px;
    }

    .dropdown-menu .dropdown-item {
        border-radius: 6px;
        transition: all 0.2s ease;
        padding: 10px 14px;
        font-size: 13px;
    }

    .dropdown-menu .dropdown-item:hover {
        background: rgba(0, 173, 238, 0.1);
        color: var(--primary);
    }

    .dropdown-menu .dropdown-item em {
        margin-right: 6px;
    }

    /* Activity List */
    .nk-activity {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nk-activity-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s ease;
    }

    .nk-activity-item:last-child {
        border-bottom: none;
    }

    .nk-activity-item:hover {
        background: var(--gray-50);
    }

    .nk-activity-media {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
    }

    .nk-activity-data .label {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
        margin: 0;
    }

    .nk-activity-data .time {
        font-size: 11px;
        color: var(--gray-600);
        margin-top: 4px;
        display: flex;
        align-items: center;
    }

    /* Support List */
    .nk-support {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nk-support-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s ease;
    }

    .nk-support-item:last-child {
        border-bottom: none;
    }

    .nk-support-item:hover {
        background: var(--gray-50);
    }

    /* Timeline Enhancements */
    .timeline-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .timeline-item {
        display: flex;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-status {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .timeline-status.bg-primary {
        background: var(--primary);
    }

    .timeline-status.bg-success {
        background: #10b981;
    }

    .timeline-date {
        font-size: 11px;
        color: var(--gray-600);
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .timeline-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin: 4px 0;
    }

    .timeline-des p {
        font-size: 12px;
        color: var(--gray-600);
        margin: 0;
    }

    .timeline-des .time {
        font-size: 11px;
        color: var(--gray-600);
    }

    /* Text Classes */
    .text-soft {
        color: var(--gray-600);
    }

    .text-primary {
        color: var(--primary);
    }

    .text-success {
        color: #10b981;
    }

    .text-warning {
        color: #f59e0b;
    }

    .text-danger {
        color: #ef4444;
    }

    /* Sale Data Enhancements */
    .nk-sale-data {
        padding: 8px 0;
    }

    .nk-sale-data span.amount {
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nk-sale-data .change {
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }

    .nk-sale-data .change.up {
        color: #10b981;
    }

    .nk-sale-data .change.down {
        color: #ef4444;
    }

    .nk-sale-data-group.flex-column {
        display: flex;
        flex-direction: column;
    }

    .nk-sale-data-group.flex-wrap {
        display: flex;
        flex-wrap: wrap;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-gradient-primary,
        .card-gradient-accent,
        .card-gradient-secondary {
            border-left-width: 3px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }

        .nk-tb-col .text-primary {
            font-size: 12px;
        }

        .timeline-title {
            font-size: 12px;
        }
    }

    /* Utility Classes */
    .fw-bold {
        font-weight: 700;
    }

    .text-white {
        color: var(--white);
    }

    .border-bottom {
        border-bottom: 1px solid #e5e7eb;
    }

    .h-100 {
        height: 100%;
    }
</style>
@endsection