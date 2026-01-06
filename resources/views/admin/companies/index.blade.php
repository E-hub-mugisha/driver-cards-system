@extends('layouts.app')
@section('title', 'Companies')
@section('content')

<!-- Breadcomb area Start-->
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between mb-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Company Management</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu">
                                <em class="icon ni ni-more-v"></em>
                            </a>

                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">

                                        <!-- Mobile -->
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#createCompanyModal"
                                            class="btn btn-icon rounded-5 d-md-none"
                                            style="background-color:#00ADEE;color:#fff">
                                            <em class="icon ni ni-plus"></em>
                                        </a>

                                        <!-- Desktop -->
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#createCompanyModal"
                                            class="btn rounded-5 d-none d-md-inline-flex"
                                            style="background-color:#00ADEE;color:#fff">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add Company</span>
                                        </a>

                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </div>
                @endif

                <div class="nk-block nk-block-lg bg-white rounded-5 shadow-sm p-4">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <div class="nk-block-des">
                                <p>Below is the list of all companies registered in the system.</p>
                            </div>
                        </div>
                    </div>
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col">#</th>
                                <th class="nk-tb-col">Name</th>
                                <th class="nk-tb-col">Email</th>
                                <th class="nk-tb-col tb-col-lg">Address </th>
                                <th class="nk-tb-col tb-col-lg">Phone </th>
                                <th class="nk-tb-col">Status</th>
                                <th class="nk-tb-col">Drivers</th>
                                <th class="nk-tb-col">Staff</th>
                                <th class="nk-tb-col nk-tb-col-tools text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($companies as $key=>$company)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">{{ $companies->firstItem() + $key }}</td>
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                            <span>{{ substr($company->name, 0, 2) }}</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="tb-lead">{{ $company->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">{{ $company->email }}</td>
                                <td class="nk-tb-col tb-col-lg">{{ $company->address }}</td>
                                <td class="nk-tb-col tb-col-lg">{{ $company->phone }}</td>
                                <td class="nk-tb-col tb-col-lg">
                                    <span class=" 
                        @if($company->status=='active') text-success
                        @elseif($company->status=='suspended') text-danger
                        @else text-secondary @endif">
                                        {{ ucfirst($company->status) }}
                                    </span>
                                </td>

                                <td class="nk-tb-col tb-col-lg">{{ $company->drivers()->count() ?? 0 }}</td>
                                <td class="nk-tb-col tb-col-lg">{{ $company->staff()->count() ?? 0 }}</td>

                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="{{ route('admin.company.staff.index',$company->id) }}">
                                                                <em class="icon ni ni-users"></em><span>View Staff</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('admin.company.drivers.index',$company->id) }}">
                                                                <em class="icon ni ni-users"></em><span>View Drivers</span>
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
                                                        <li>
                                                            <a href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteCompanyModal{{ $company->id }}">
                                                                <em class="icon ni ni-trash"></em><span>Delete Company</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach( $companies as $company)

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
                    <input name="name" class="form-control"required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control"required>
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" >Active</option>
                        <option value="suspended" >Suspended</option>
                        <option value="inactive" >Inactive</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection