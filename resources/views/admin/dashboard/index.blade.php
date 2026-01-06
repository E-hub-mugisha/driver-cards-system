@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ config('app.name')}} Overview</h3>
                        <div class="nk-block-des text-soft">
                            <p>Welcome to {{ config('app.name')}} Dashboard.</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle"><a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="dropdown"><a href="#"
                                                class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                                data-bs-toggle="dropdown"><em
                                                    class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span
                                                        class="d-none d-md-inline">Last</span> 30
                                                    Days</span><em
                                                    class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Last 30 Days</span></a>
                                                    </li>
                                                    <li><a href="#"><span>Last 6 Months</span></a>
                                                    </li>
                                                    <li><a href="#"><span>Last 1 Years</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nk-block-tools-opt"><a href="#"
                                            class="btn rounded-5" style="background:#00ADEE; color:#fff"><em
                                                class="icon ni ni-reports"></em><span>Reports</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-xxl-12">
                        <div class="row g-gs">
                            <div class="col-md-4">
                                <div class="card rounded-5 card-gradient" style="background: linear-gradient(135deg, #00ADEE, #E3B228); color: #fff;">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title text-white">Total Drivers</h6>
                                                <p class="mb-0 text-white">Driver statistics overview</p>
                                            </div>

                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="Drivers registered in the system"></em>
                                            </div>
                                        </div>

                                        <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">

                                            {{-- KPI DATA --}}
                                            <div class="nk-sale-data-group flex-md-nowrap g-4">

                                                <div class="nk-sale-data">
                                                    <span class="amount">
                                                        {{ $DriversMonth }}
                                                        <span class="change {{ $MonthChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                                            <em class="icon ni ni-arrow-long-{{ $MonthChange >= 0 ? 'up' : 'down' }}"></em>
                                                            {{ number_format($MonthChange,2) }}%
                                                        </span>
                                                    </span>
                                                    <span class="sub-title text-white">Last 30 Days</span>
                                                </div>

                                                <div class="nk-sale-data">
                                                    <span class="amount">
                                                        {{ $DriversWeek }}
                                                        <span class="change {{ $WeekChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                                            <em class="icon ni ni-arrow-long-{{ $WeekChange >= 0 ? 'up' : 'down' }}"></em>
                                                            {{ number_format($WeekChange,2) }}%
                                                        </span>
                                                    </span>
                                                    <span class="sub-title text-white">This Week</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="card rounded-5" style="background: linear-gradient(135deg, #ffffffff, #E3B228);">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Drivers Status Overview</h6>
                                                <p>Active, Suspended and Pending Drivers</p>
                                            </div>

                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="Current driver status distribution"></em>
                                            </div>
                                        </div>

                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">

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
                            <div class="col-md-4">
                                <div class="card rounded-5" style="background: linear-gradient(135deg, #00ADEE, #ffffffff);">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <h6 class="text-white">Avg Registered Companies</h6>
                                                <p class="text-white">Companies registration overview</p>
                                            </div>

                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help-fill"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="Daily average number of companies registered"></em>
                                            </div>
                                        </div>

                                        <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                            <div class="nk-sale-data">
                                                <span class="amount">
                                                    {{ number_format($avgCompaniesPerDay, 1) }}
                                                </span>

                                                <span class="sub-title">
                                                    <span class="change {{ $companyChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                                        <em class="icon ni ni-arrow-long-{{ $companyChange >= 0 ? 'up' : 'down' }}"></em>
                                                        {{ number_format($companyChange,2) }}%
                                                    </span>
                                                    since last week
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8">
                        <div class="card rounded-5 card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title"><span class="me-2">Recent Drivers added</span> <a
                                                href="{{ route('admin.drivers.index')}}" class="link d-none d-sm-inline">See
                                                All</a></h6>
                                    </div>
                                    <div class="card-tools">
                                        <ul class="card-tools-nav">
                                            <li><a href="#"><span>Paid</span></a></li>
                                            <li><a href="#"><span>Pending</span></a></li>
                                            <li class="active"><a href="{{ route('admin.drivers.index')}}"><span>All</span></a></li>
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
                                        <div class="nk-tb-col"><span
                                                class="d-none d-sm-inline">Status</span></div>
                                        <div class="nk-tb-col"><span>&nbsp;</span></div>
                                    </div>
                                    @foreach( $drivers as $driver)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col"><span class="tb-lead"><a
                                                    href="#">{{ $driver->ID_number }}</a></span></div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="user-card">
                                                <div class="user-avatar user-avatar-sm bg-purple">
                                                    <span>AB</span>
                                                </div>
                                                <div class="user-name"><span class="tb-lead">{{ $driver->names }}</span></div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md"><span
                                                class="tb-sub">{{ $driver->company?->name ?? '-' }}</span></div>
                                        <div class="nk-tb-col tb-col-lg"><span
                                                class="tb-sub text-primary">{{ $driver->driver_license }}</span></div>
                                        <div class="nk-tb-col"><span
                                                class="tb-sub tb-amount">{{ $driver->phone }}
                                            </span></div>
                                        <div class="nk-tb-col"><span
                                                class="badge badge-dot badge-dot-xs bg-success">{{ ucfirst($driver->status) }}</span>
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-action">
                                            <div class="dropdown"><a
                                                    class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                    <ul class="link-list-plain">
                                                        <li><a href="{{ route('admin.drivers.show', $driver->id )}}">View</a></li>
                                                        <!-- <li><a href="#">Invoice</a></li>
                                                        <li><a href="#">Print</a></li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-inner-sm border-top text-center d-sm-none"><a href="#"
                                    class="btn btn-link btn-block">See History</a></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-4">
                        <div class="card rounded-5 card-full">
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
                                    <div class="nk-activity-media user-avatar bg-danger">
                                        <span>
                                            {{ strtoupper(substr($report->driver->names ?? 'N', 0, 1)) }}
                                        </span>
                                    </div>

                                    <div class="nk-activity-data">
                                        <div class="label">
                                            <strong>{{ $report->driver->names ?? 'Unknown Driver' }}</strong>
                                            was reported for
                                            <span class="text-danger">
                                                {{
                        $report->behaviorType->behaviorCategory->name 
                        ?? 'Uncategorized Behavior' 
                    }}
                                            </span>
                                        </div>

                                        <span class="time">
                                            {{ $report->behavior_date?->diffForHumans() ?? $report->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </li>
                                @empty
                                <li class="nk-activity-item">
                                    <div class="nk-activity-data">
                                        <div class="label text-muted">No recent behavior reports</div>
                                    </div>
                                </li>
                                @endforelse
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-4">
                        <div class="card rounded-5 card-full">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">New Users</h6>
                                        </div>

                                        <div class="card-tools">
                                            <a href="{{ route('admin.users.index')}}" class="link">
                                                View All
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @forelse($users as $user)
                                <div class="card-inner card-inner-md">
                                    <div class="user-card">

                                        <!-- Avatar -->
                                        <div class="user-avatar bg-primary-dim">
                                            <span>
                                                {{ strtoupper(substr($user->name,0,1)) }}
                                                {{ strtoupper(substr(last(explode(' ', $user->name)),0,1)) }}
                                            </span>
                                        </div>

                                        <!-- User Info -->
                                        <div class="user-info">
                                            <span class="lead-text">{{ $user->name }}</span>
                                            <span class="sub-text">{{ $user->email }}</span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="user-action">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                    data-bs-toggle="dropdown">
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
                                    <p class="text-center text-muted">No new users found.</p>
                                </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <div class="card rounded-5 h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Recent Companies</h6>
                                    </div>
                                    <div class="card-tools"><a href="{{ route('admin.companies.index')}}" class="link">All Companies</a>
                                    </div>
                                </div>
                            </div>
                            <ul class="nk-support">
                                @foreach( $companies as $company)
                                <li class="nk-support-item">
                                    <div class="user-avatar">
                                        <span>
                                            {{ strtoupper(substr($company->name,0,1)) }}
                                            {{ strtoupper(substr(last(explode(' ', $company->name)),0,1)) }}
                                        </span>
                                    </div>
                                    <div class="nk-support-content">
                                        <div class="title"><span>{{ $company->name }}</span><span
                                                class="badge badge-dot badge-dot-xs ms-1 @if($company->status=='active') bg-success
                        @elseif($company->status=='suspended') bg-danger
                        @else bg-secondary @endif">{{ ucfirst($company->status) }}</span>
                                        </div>
                                        <p>{{ $company->email }}</p><span
                                            class="time">{{ $company->address }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <div class="card rounded-5 h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Notifications</h6>
                                    </div>
                                    <div class="card-tools"><a href="#" class="link">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="timeline">
                                    <h6 class="timeline-head">November, 2019</h6>
                                    <ul class="timeline-list">
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-primary is-outline">
                                            </div>
                                            <div class="timeline-date">13 Nov <em
                                                    class="icon ni ni-alarm-alt"></em></div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Submited KYC Application
                                                </h6>
                                                <div class="timeline-des">
                                                    <p>Re-submitted KYC Application form.</p><span
                                                        class="time">09:30am</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-primary"></div>
                                            <div class="timeline-date">13 Nov <em
                                                    class="icon ni ni-alarm-alt"></em></div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Submited KYC Application
                                                </h6>
                                                <div class="timeline-des">
                                                    <p>Re-submitted KYC Application form.</p><span
                                                        class="time">09:30am</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-pink"></div>
                                            <div class="timeline-date">13 Nov <em
                                                    class="icon ni ni-alarm-alt"></em></div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Submited KYC Application
                                                </h6>
                                                <div class="timeline-des">
                                                    <p>Re-submitted KYC Application form.</p><span
                                                        class="time">09:30am</span>
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
</div>
@endsection