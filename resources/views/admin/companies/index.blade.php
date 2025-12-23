@extends('layouts.app')
@section('title', 'Companies')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Company Management</h4>

        <!-- Create Button -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
            Add Company
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Drivers</th>
                <th>Staff</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($companies as $key=>$company)
            <tr>
                <td>{{ $companies->firstItem() + $key }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>
                    <span class="badge 
                        @if($company->status=='active') bg-success
                        @elseif($company->status=='suspended') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($company->status) }}
                    </span>
                </td>

                <td>{{ $company->drivers()->count() ?? 0 }}</td>
                <td>{{ $company->staff()->count() ?? 0 }}</td>

                <td>
                    <a href="{{ route('admin.company.staff.index',$company->id) }}"
                        class="btn btn-sm btn-outline-primary">
                        View Staff
                    </a>
                    <a href="{{ route('admin.company.drivers.index',$company->id) }}"
                        class="btn btn-sm btn-outline-primary">
                        View drivers
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payrollSettingsModal{{ $company->id }}">
                        Payroll Settings
                    </button>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editCompanyModal{{ $company->id }}">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteCompanyModal{{ $company->id }}">
                        Delete
                    </button>
                </td>
            </tr>



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
            @endforeach
        </tbody>
    </table>

    {{ $companies->links() }}
</div>

@foreach( $companies as $company)
<!-- Payroll Settings Modal -->
<div class="modal fade" id="payrollSettingsModal{{ $company->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            @if($company->payrollSettings)
            action="{{ route('admin.payroll.settings.update', $company->payrollSettings->id) }}"
            @else
            action="{{ route('admin.payroll.settings.store') }}"
            @endif>

            @csrf
            @if($company->payrollSettings) @method('PUT') @endif

            <input type="hidden" name="company_id" value="{{ $company->id }}">

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
                <button class="btn btn-success">Save Settings</button>
            </div>

        </form>
    </div>
</div>
@endforeach

<!-- Create Modal -->
<div class="modal fade" id="createCompanyModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.companies.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create Company</h5>
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
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection