@extends('layouts.app')
@section('title', $company->name . " — Drivers")
@section('content')
<div class="container">

    <h4>{{ $company->name }} — Drivers Management</h4>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDriverModal">
        Add Driver
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Names</th>
                <th>Phone</th>
                <th>License</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($drivers as $driver)
            <tr class="{{ $driver->trashed() ? 'table-danger' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $driver->names }}</td>
                <td>{{ $driver->phone }}</td>
                <td>{{ $driver->driver_license }}</td>
                <td>{{ $driver->status }}</td>

                <td>
                    <a href="{{ route('admin.drivers.show', $driver->id )}}" class="btn btn-info">View Details</a>
                    @if(!$driver->trashed())
                    <button class="btn btn-sm btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#editDriverModal{{ $driver->id }}">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('admin.company.drivers.delete', [$company->id,$driver->id]) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.company.drivers.restore', [$company->id,$driver->id]) }}">
                        @csrf
                        <button class="btn btn-sm btn-success">Restore</button>
                    </form>
                    @endif
                </td>
            </tr>

            <div class="modal fade" id="editDriverModal{{ $driver->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form method="POST" action="{{ route('admin.company.drivers.update', [$company->id,$driver->id]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h5>Edit Driver</h5>
                            </div>

                            <div class="modal-body">

                                <input class="form-control mb-2" name="names" value="{{ $driver->names }}">
                                <input class="form-control mb-2" name="ID_number" value="{{ $driver->ID_number }}">
                                <input class="form-control mb-2" name="driver_license" value="{{ $driver->driver_license }}">
                                <input class="form-control mb-2" name="phone" value="{{ $driver->phone }}">
                                <input class="form-control mb-2" name="rssb" value="{{ $driver->rssb }}">
                                <input class="form-control mb-2" name="Insurance" value="{{ $driver->Insurance }}">
                                <input class="form-control mb-2" name="contract_type" value="{{ $driver->contract_type }}">

                                <input type="file" class="form-control mb-2" name="photo">
                                <input type="file" class="form-control mb-2" name="contract">

                                <select class="form-control mb-2" name="status">
                                    <option {{ $driver->status=='Active'?'selected':'' }}>Active</option>
                                    <option {{ $driver->status=='Suspended'?'selected':'' }}>Suspended</option>
                                </select>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


            @endforeach
        </tbody>
    </table>

</div>

<div class="modal fade" id="addDriverModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('admin.company.drivers.store',$company->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5>Add Driver</h5>
                </div>

                <div class="modal-body">

                    <input class="form-control mb-2" name="names" placeholder="Names">
                    <input class="form-control mb-2" name="ID_number" placeholder="National ID">
                    <input class="form-control mb-2" name="driver_license" placeholder="License">
                    <input class="form-control mb-2" name="phone" placeholder="Phone">
                    <input class="form-control mb-2" name="rssb" placeholder="RSSB">
                    <input class="form-control mb-2" name="Insurance" placeholder="Insurance">
                    <input class="form-control mb-2" name="contract_type" placeholder="Contract Type">

                    <input type="file" class="form-control mb-2" name="photo">
                    <input type="file" class="form-control mb-2" name="contract">

                    <select class="form-control mb-2" name="status">
                        <option value="Active">Active</option>
                        <option value="Suspended">Suspended</option>
                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection