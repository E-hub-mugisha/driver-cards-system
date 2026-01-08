@extends('layouts.app')
@section('title', 'Companies')
@section('content')

<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ $company->name }} Details</h3>
                        <div class="nk-block-des text-soft">
                            <p>An overview page for company details</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-md-12 mt-3">

                        <div class="card card-bordered">
                            <div class="card-inner-group">
                                <div class="row">
                                    <div class="card-inner col-md-6">
                                        <div class="user-card user-card-s2">
                                            <div class="user-avatar lg bg-primary"><img src="images/avatar/b-sm.jpg" alt=""></div>
                                            <div class="user-info">
                                                <div class="badge bg-light rounded-pill ucap">{{ ucfirst($company->status) }}</div>
                                                <h5>{{ $company->name }}</h5><span class="sub-text">{{ $company->email }}</span>
                                            </div>
                                        </div>

                                        <div class="card-inner">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">{{ $company->drivers()->count() ?? 0 }}</span><span class="sub-text">Total Drivers</span></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">{{ $company->staff()->count() ?? 0 }}</span><span class="sub-text">Total Staff</span></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="profile-stats"><span class="amount">3</span><span class="sub-text">Progress</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner col-md-6">
                                        <h6 class="overline-title mb-2">Short Details</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">User ID:</span><span>{{ ucfirst($company->id) }}</span></div>
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">Email:</span><span>{{ $company->email }}</span></div>
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">Address:</span><span>{{ $company->address }}</span></div>
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">Phone:</span><span>{{ $company->phone }}</span></div>
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">Status:</span><span class=" 
                        @if($company->status=='active') text-success
                        @elseif($company->status=='suspended') text-danger
                        @else text-secondary @endif">
                                                    {{ ucfirst($company->status) }}
                                                </span></div>
                                            <div class="col-sm-6 col-md-4 col-lg-12"><span class="sub-text">Register At:</span><span>{{ $company->created_at }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <div class="overline-title-alt mb-2 mt-2">In Account</div>
                                    <div class="profile-balance">
                                        <div class="profile-balance-group gx-4">

                                            <li>
                                                <a href="{{ route('company.drivers.index') }}">
                                                    <em class="icon ni ni-users"></em><span>View Drivers</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('company.staff.index') }}">
                                                    <em class="icon ni ni-users"></em><span>View Staff</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#payrollSettingsModal{{ $company->id }}">
                                                    <em class="icon ni ni-coins"></em><span>Payroll Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCompanyModal{{ $company->id }}">
                                                    <em class="icon ni ni-edit"></em><span>Edit Company</span>
                                                </a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Company overview Summary</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <h6>Monthly Payroll (Net Salary)</h6>
                                                    <canvas id="payrollChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <h6>Monthly Penalties</h6>
                                                    <canvas id="penaltyChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6>Driver vs Behavior Trends (Last 6 Months)</h6>
                                <canvas id="driversBehaviorChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editCompanyModal{{ $company->id }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.companies.update',$company->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input name="name" class="form-control"
                        value="{{ $company->name ?? old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control"
                        value="{{ $company->email ?? old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input name="phone" class="form-control"
                        value="{{ $company->phone ?? old('phone') }}">
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control">{{ $company->address ?? old('address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ (isset($company) && $company->status=='active')?'selected':'' }}>Active</option>
                        <option value="suspended" {{ (isset($company) && $company->status=='suspended')?'selected':'' }}>Suspended</option>
                        <option value="inactive" {{ (isset($company) && $company->status=='inactive')?'selected':'' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCompanyModal{{ $company->id }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.companies.destroy',$company->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Delete</h5>
            </div>

            <div class="modal-body">
                Are you sure you want to delete <b>{{ $company->name }}</b>?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- Payroll Settings Modal -->
<div class="modal fade" id="payrollSettingsModal{{ $company->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            @if($company->payrollSettings)
            action="{{ route('company.payroll.settings.update', $company->payrollSettings->id) }}"
            @else
            action="{{ route('company.payroll.settings.store') }}"
            @endif>

            @csrf
            @if($company->payrollSettings) @method('PUT') @endif

            <div class="modal-header">
                <h5>Payroll Settings — {{ $company->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Salary Type</label>
                    <select name="salary_type" class="form-select">
                        <option value="fixed" {{ optional($company->payrollSettings)->salary_type=='fixed'?'selected':'' }}>Fixed</option>
                        <option value="per_trip" {{ optional($company->payrollSettings)->salary_type=='per_trip'?'selected':'' }}>Per Trip</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Base Salary</label>
                    <input type="number" step="0.01" name="base_salary" class="form-control"
                        value="{{ optional($company->payrollSettings)->base_salary }}">
                </div>

                <div class="mb-3">
                    <label>Trip Rate</label>
                    <input type="number" step="0.01" name="trip_rate" class="form-control"
                        value="{{ optional($company->payrollSettings)->trip_rate }}">
                </div>

                <div class="mb-3">
                    <label>Tax Rate (%)</label>
                    <input type="number" step="0.01" name="tax_rate" class="form-control"
                        value="{{ optional($company->payrollSettings)->tax_rate }}">
                </div>

                <div class="mb-3">
                    <label>RSSB Rate (%)</label>
                    <input type="number" step="0.01" name="rssb_rate" class="form-control"
                        value="{{ optional($company->payrollSettings)->rssb_rate }}">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save Settings</button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const payrollChart = new Chart(document.getElementById('payrollChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Net Salary (USD)',
                data: @json($netSalaries),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    });

    const penaltyChart = new Chart(document.getElementById('penaltyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlyPenalties -> keys()),
            datasets: [{
                label: 'Penalties',
                data: @json($monthlyPenalties -> values()),
                backgroundColor: '#e74a3b'
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<script>
    const ctx = document.getElementById('driversBehaviorChart').getContext('2d');
    const driversBehaviorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                    label: 'Drivers Added',
                    data: @json($driversData),
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: '#4e73df',
                    borderWidth: 1
                },
                {
                    label: 'Behaviors Reported',
                    data: @json($behaviorsData),
                    backgroundColor: 'rgba(231, 74, 59, 0.7)',
                    borderColor: '#e74a3b',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
</script>
@endsection