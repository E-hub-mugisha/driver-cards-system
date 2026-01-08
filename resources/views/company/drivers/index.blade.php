@extends('layouts.app')

@section('title','My Drivers')

@section('content')
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            {{-- Header --}}
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">
                            Drivers — {{ $company->name }}
                        </h3>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addDriverModal"
                            class="btn btn-primary">
                            <em class="icon ni ni-plus"></em>
                            <span>Add Driver</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Active Drivers --}}
            <div class="nk-block nk-block-lg p-4 bg-white rounded-5 mt-4">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="nk-block-des">
                            <h5 class="mb-3">Active Drivers</h5>
                            <p>
                                Below is the list of drivers registered under
                                <strong>{{ $company->name }}</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col">#</th>
                            <th class="nk-tb-col">Photo</th>
                            <th class="nk-tb-col">Name</th>
                            <th class="nk-tb-col">ID</th>
                            <th class="nk-tb-col">License</th>
                            <th class="nk-tb-col">Phone</th>
                            <th class="nk-tb-col">Status</th>
                            <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers->whereNull('deleted_at') as $driver)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">{{ $loop->iteration }}</td>
                            <td class="nk-tb-col">
                                @if($driver->photo)
                                <img src="{{ asset('storage/'.$driver->photo) }}" width="50">
                                @endif
                            </td>
                            <td class="nk-tb-col">{{ $driver->names }}</td>
                            <td class="nk-tb-col">{{ $driver->ID_number }}</td>
                            <td class="nk-tb-col">{{ $driver->driver_license }}</td>
                            <td class="nk-tb-col">{{ $driver->phone }}</td>
                            <td class="nk-tb-col">{{ ucfirst($driver->status) }}</td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown"><a href="#"
                                                class="dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('company.drivers.show', $driver->id )}}" class="text-info">View Details</a>
                                                    </li>
                                                    <li>
                                                        <a role="button" class="text-warning" data-bs-toggle="modal" data-bs-target="#editDriverModal{{ $driver->id }}">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a role="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteDriverModal{{ $driver->id }}">Remove</a>
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

            {{-- Deleted Drivers --}}
            <div class="nk-block nk-block-lg p-4 bg-white rounded-5 mt-5">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="nk-block-des">
                            <h5>Deleted Drivers</h5>
                            <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head">
                                        <th class="nk-tb-col">#</th>
                                        <th class="nk-tb-col">Photo</th>
                                        <th class="nk-tb-col">Name</th>
                                        <th class="nk-tb-col">ID</th>
                                        <th class="nk-tb-col">License</th>
                                        <th class="nk-tb-col">Phone</th>
                                        <th class="nk-tb-col">Company</th>
                                        <th class="nk-tb-col">Status</th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($drivers->whereNotNull('deleted_at') as $driver)
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">{{ $loop->iteration }}</td>
                                        <td class="nk-tb-col">
                                            @if($driver->photo)
                                            <img src="{{ asset('storage/'.$driver->photo) }}" width="50">
                                            @endif
                                        </td>
                                        <td class="nk-tb-col">{{ $driver->names }}</td>
                                        <td class="nk-tb-col">{{ $driver->ID_number }}</td>
                                        <td class="nk-tb-col">{{ $driver->driver_license }}</td>
                                        <td class="nk-tb-col">{{ $driver->phone }}</td>
                                        <td class="nk-tb-col">{{ $driver->company?->name ?? '-' }}</td>
                                        <td class="nk-tb-col">{{ ucfirst($driver->status) }}</td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown"><a href="#"
                                                            class="dropdown-toggle btn btn-icon btn-trigger"
                                                            data-bs-toggle="dropdown"><em
                                                                class="icon ni ni-more-h"></em></a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li>
                                                                    <a href="{{ route('admin.drivers.show', $driver->id )}}" class="text-info">View Details</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('admin.drivers.restore',$driver->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button class="btn btn-success btn-sm">Restore</button>
                                                                    </form>
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
    </div>
</div>

{{-- ================= ADD DRIVER MODAL ================= --}}
<div class="modal fade" id="addDriverModal">
    <div class="modal-dialog modal-lg">
        <form method="POST"
            action="{{ route('company.drivers.store') }}"
            enctype="multipart/form-data"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Add Driver</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input name="names" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>ID Number</label>
                        <input name="ID_number" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Driver License</label>
                        <input name="driver_license" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Phone</label>
                        <input name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>RSSB</label>
                        <input name="rssb" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Insurance</label>
                        <select name="Insurance" class="form-select" required>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Contract Type</label>
                        <select name="contract_type" class="form-select" required>
                            <option value="3 month">3 Month</option>
                            <option value="6 month">6 Month</option>
                            <option value="12 month">12 Month</option>
                            <option value="open ended">Open Ended</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
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
                <button type="submit" class="btn btn-primary">Save Driver</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= EDIT & DELETE MODALS ================= --}}
@foreach($drivers as $driver)

{{-- Edit --}}
<div class="modal fade" id="editDriverModal{{ $driver->id }}">
    <div class="modal-dialog modal-lg">
        <form method="POST"
            action="{{ route('company.drivers.update',$driver) }}"
            enctype="multipart/form-data"
            class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5>Edit Driver</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input name="names" class="form-control" value="{{ $driver->names }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>ID Number</label>
                        <input name="ID_number" class="form-control" value="{{ $driver->ID_number }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Driver License</label>
                        <input name="driver_license" class="form-control" value="{{ $driver->driver_license }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Phone</label>
                        <input name="phone" class="form-control" value="{{ $driver->phone }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>RSSB</label>
                        <input name="rssb" class="form-control" value="{{ $driver->rssb }}">
                    </div>

                    <div class="col-md-6">
                        <label>Insurance</label>
                        <select name="Insurance" class="form-select">
                            <option value="YES" {{ $driver->Insurance=='YES'?'selected':'' }}>YES</option>
                            <option value="NO" {{ $driver->Insurance=='NO'?'selected':'' }}>NO</option>
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
                        <select name="status" class="form-select">
                            <option value="active" {{ $driver->status=='active'?'selected':'' }}>Active</option>
                            <option value="inactive" {{ $driver->status=='inactive'?'selected':'' }}>Inactive</option>
                            <option value="suspended" {{ $driver->status=='suspended'?'selected':'' }}>Suspended</option>
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
                <button type="submit" class="btn btn-success">Update Driver</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete --}}
<div class="modal fade" id="deleteDriverModal{{ $driver->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('company.drivers.destroy',$driver) }}"
            class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="text-danger">Confirm Remove</h5>
            </div>

            <div class="modal-body">
                Remove <b>{{ $driver->names }}</b>?
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Remove</button>
            </div>
        </form>
    </div>
</div>

@endforeach
@endsection