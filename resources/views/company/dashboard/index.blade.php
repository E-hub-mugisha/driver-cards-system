@extends('layouts.app')

@section('title', 'Company Dashboard')

@section('content')
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            {{-- PAGE HEADER --}}
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            {{ $company->name }} Overview
                        </h3>
                        <div class="nk-block-des text-soft">
                            <p>Welcome to your company dashboard.</p>
                        </div>
                    </div>

                    <div class="nk-block-head-content">
                        <a href="{{ route('company.reports.drivers') }}"
                           class="btn rounded-5"
                           style="background:#00ADEE; color:#fff">
                            <em class="icon ni ni-reports"></em>
                            <span>Reports</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- KPI CARDS --}}
            <div class="nk-block">
                <div class="row g-gs">

                    {{-- TOTAL DRIVERS --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="card rounded-5 card-gradient"
                             style="background: linear-gradient(135deg, #00ADEE, #E3B228); color:#fff;">
                            <div class="card-inner">
                                <h6 class="title text-white">Drivers Overview</h6>
                                <p class="text-white mb-3">Your company driver statistics</p>

                                <div class="nk-sale-data-group g-4">
                                    <div class="nk-sale-data">
                                        <span class="amount">
                                            {{ $DriversMonth }}
                                            <span class="change {{ $MonthChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                                <em class="icon ni ni-arrow-long-{{ $MonthChange >= 0 ? 'up' : 'down' }}"></em>
                                                {{ number_format($MonthChange, 2) }}%
                                            </span>
                                        </span>
                                        <span class="sub-title text-white">Last 30 Days</span>
                                    </div>

                                    <div class="nk-sale-data">
                                        <span class="amount">
                                            {{ $DriversWeek }}
                                            <span class="change {{ $WeekChange >= 0 ? 'up text-success' : 'down text-danger' }}">
                                                <em class="icon ni ni-arrow-long-{{ $WeekChange >= 0 ? 'up' : 'down' }}"></em>
                                                {{ number_format($WeekChange, 2) }}%
                                            </span>
                                        </span>
                                        <span class="sub-title text-white">This Week</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DRIVER STATUS --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="card rounded-5">
                            <div class="card-inner">
                                <h6 class="title">Driver Status</h6>
                                <p class="mb-3">Current status distribution</p>

                                <div class="nk-sale-data-group g-4">
                                    <div class="nk-sale-data">
                                        <span class="amount text-success">{{ $activeDrivers }}</span>
                                        <span class="sub-title">Active</span>
                                    </div>

                                    <div class="nk-sale-data">
                                        <span class="amount text-warning">{{ $pendingDrivers }}</span>
                                        <span class="sub-title">Pending</span>
                                    </div>

                                    <div class="nk-sale-data">
                                        <span class="amount text-danger">{{ $suspendedDrivers }}</span>
                                        <span class="sub-title">Suspended</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- RECENT DRIVERS --}}
            <div class="nk-block">
                <div class="row g-gs">

                    <div class="col-lg-8">
                        <div class="card rounded-5 card-full">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <h6 class="title">Recently Added Drivers</h6>
                                    <a href="{{ route('company.drivers.index') }}" class="link">
                                        View All
                                    </a>
                                </div>
                            </div>

                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-orders">

                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>ID</span></div>
                                        <div class="nk-tb-col"><span>Name</span></div>
                                        <div class="nk-tb-col"><span>License</span></div>
                                        <div class="nk-tb-col"><span>Phone</span></div>
                                        <div class="nk-tb-col"><span>Status</span></div>
                                        <div class="nk-tb-col"></div>
                                    </div>

                                    @forelse($drivers as $driver)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">{{ $driver->ID_number }}</div>
                                            <div class="nk-tb-col">{{ $driver->names }}</div>
                                            <div class="nk-tb-col text-primary">{{ $driver->driver_license }}</div>
                                            <div class="nk-tb-col">{{ $driver->phone }}</div>
                                            <div class="nk-tb-col">
                                                <span class="badge badge-dot bg-success">
                                                    {{ ucfirst($driver->status) }}
                                                </span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col-action">
                                                <a href="{{ route('company.drivers.show', $driver->id) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col text-muted text-center">
                                                No drivers found.
                                            </div>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RECENT REPORTED DRIVERS --}}
                    <div class="col-lg-4">
                        <div class="card rounded-5 card-full">
                            <div class="card-inner border-bottom">
                                <h6 class="title">Recent Driver Reports</h6>
                            </div>

                            <ul class="nk-activity">
                                @forelse($reportedDrivers as $report)
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar bg-danger">
                                            <span>{{ strtoupper(substr($report->driver->names ?? 'N', 0, 1)) }}</span>
                                        </div>
                                        <div class="nk-activity-data">
                                            <div class="label">
                                                <strong>{{ $report->driver->names ?? 'Unknown Driver' }}</strong>
                                                reported for
                                                <span class="text-danger">
                                                    {{ $report->behaviorType->behaviorCategory->name ?? 'Uncategorized' }}
                                                </span>
                                            </div>
                                            <span class="time">
                                                {{ $report->behavior_date?->diffForHumans() }}
                                            </span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-data text-muted">
                                            No recent reports
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
