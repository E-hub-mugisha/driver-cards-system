@extends('layouts.app')
@section('title','Drivers')
@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>Drivers</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDriverModal">Add Driver</button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Please fix the following issues:
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Active Drivers --}}
    <h5>Active & Inactive Drivers</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>ID</th>
                <th>License</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Status</th>
                <th width="300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $driver)
            @if(!$driver->trashed())
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($driver->photo)
                    <img src="{{ asset('storage/'.$driver->photo) }}" width="50">
                    @endif
                </td>
                <td>{{ $driver->names }}</td>
                <td>{{ $driver->ID_number }}</td>
                <td>{{ $driver->driver_license }}</td>
                <td>{{ $driver->phone }}</td>
                <td>{{ $driver->company?->name ?? '-' }}</td>
                <td>{{ ucfirst($driver->status) }}</td>
                <td>
                    <a href="{{ route('admin.drivers.show', $driver->id )}}" class="btn btn-info">View Details</a>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDriverModal{{ $driver->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDriverModal{{ $driver->id }}">Remove</button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    {{-- Deleted Drivers --}}
    <h5 class="mt-5">Deleted Drivers</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>ID</th>
                <th>Company</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers->whereNotNull('deleted_at') as $driver)
            <tr class="table-warning">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $driver->names }}</td>
                <td>{{ $driver->ID_number }}</td>
                <td>{{ $driver->company?->name ?? '-' }}</td>
                <td>{{ ucfirst($driver->status) }}</td>
                <td>
                    <a href="{{ route('admin.drivers.show', $driver->id ) }}" class="btn btn-info">View Details</a>
                    <form action="{{ route('admin.drivers.restore',$driver->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- Add Driver Modal --}}
<div class="modal fade" id="addDriverModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="names" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>ID Number</label>
                            <input type="text" name="ID_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Driver License</label>
                            <input type="text" name="driver_license" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>RSSB Number</label>
                            <input type="text" name="rssb" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Insurance</label>
                            <select name="insurance" class="form-select">
                                <option selected disabled>-- select insurance --</option>
                                <option>YES</option>
                                <option>NO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Company</label>
                            <select name="company_id" class="form-control">
                                <option value="">--Select Company--</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Contract Type</label>
                            <select name="contract_type" class="form-select">
                                <option selected disabled>-- select contract type --</option>
                                <option value="3 month">3 Month</option>
                                <option value="6 month">6 Month</option>
                                <option value="12 month">12 Month</option>
                                <option value="open ended">Open Ended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Contract</label>
                            <input type="file" name="contract" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Add Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit and Delete Modals for each driver --}}
@foreach($drivers as $driver)
@if(!$driver->trashed())
<!-- Edit Driver Modal -->
<div class="modal fade" id="editDriverModal{{ $driver->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.update',$driver->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="names" class="form-control" value="{{ $driver->names }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>ID Number</label>
                            <input type="text" name="ID_number" class="form-control" value="{{ $driver->ID_number }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Driver License</label>
                            <input type="text" name="driver_license" class="form-control" value="{{ $driver->driver_license }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>RSSB Number</label>
                            <input type="text" name="rssb" class="form-control" value="{{ $driver->rssb }}">
                        </div>
                        <div class="col-md-6">
                            <label>Insurance</label>
                            <select name="insurance" class="form-select">
                                <option>YES</option>
                                <option>NO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Company</label>
                            <select name="company_id" class="form-control">
                                <option value="">--Select Company--</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $driver->company_id==$company->id?'selected':'' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Contract Type</label>
                            <select name="contract_type" class="form-select">
                                <option value="3 month" {{ $driver->contract_type=='3 month'?'selected':'' }}>3 Month</option>
                                <option value="6 month" {{ $driver->contract_type=='6 month'?'selected':'' }}>6 Month</option>
                                <option value="12 month" {{ $driver->contract_type=='12 month'?'selected':'' }}>12 Month</option>
                                <option value="open ended" {{ $driver->contract_type=='open ended'?'selected':'' }}>Open Ended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $driver->status=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ $driver->status=='inactive'?'selected':'' }}>Inactive</option>
                                <option value="suspended" {{ $driver->status=='suspended'?'selected':'' }}>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control">
                            @if($driver->photo)
                            <small>Current: <a href="{{ asset('storage/'.$driver->photo) }}" target="_blank">View</a></small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label>Contract</label>
                            <input type="file" name="contract" class="form-control">
                            @if($driver->contract)
                            <small>Current: <a href="{{ asset('storage/'.$driver->contract) }}" target="_blank">View</a></small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Driver Modal -->
<div class="modal fade" id="deleteDriverModal{{ $driver->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.destroy',$driver->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirm Remove</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove <b>{{ $driver->names }}</b>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection
