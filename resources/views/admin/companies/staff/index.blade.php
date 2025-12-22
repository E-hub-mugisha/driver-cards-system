@extends('layouts.app')

@section('title', $company->name . ' Staff')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h3>{{ $company->name }} — Staff</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            Add Staff
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th width="280">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($staff as $row)
            <tr class="{{ $row->trashed() ? 'table-warning' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->user->email }}</td>
                <td>{{ ucfirst($row->role) }}</td>
                <td>{{ ucfirst($row->status) }}</td>
                <td>

                    @if(!$row->trashed())
                    <!-- Edit -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#editStaffModal{{ $row->id }}">Edit</button>

                    <!-- Reset Password -->
                    <form action="{{ route('admin.company.staff.reset-password', $row->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-info btn-sm">Reset Password</button>
                    </form>

                    <!-- Delete (Soft Delete) -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#deleteStaffModal{{ $row->id }}">Remove</button>
                    @else
                    <!-- Restore -->
                    <form action="{{ route('admin.company.staff.restore', $row->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>
                    @endif

                </td>
            </tr>

            <!-- Edit Staff Modal -->
            <div class="modal fade" id="editStaffModal{{ $row->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.company.staff.update', $row->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $row->user->name }}">
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $row->user->email }}">
                                </div>

                                <div class="mb-3">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="manager" {{ $row->role=='manager'?'selected':'' }}>Manager</option>
                                        <option value="supervisor" {{ $row->role=='supervisor'?'selected':'' }}>Supervisor</option>
                                        <option value="staff" {{ $row->role=='staff'?'selected':'' }}>Staff</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{ $row->status=='active'?'selected':'' }}>Active</option>
                                        <option value="suspended" {{ $row->status=='suspended'?'selected':'' }}>Suspended</option>
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
            </div>

            <!-- Delete Staff Modal -->
            <div class="modal fade" id="deleteStaffModal{{ $row->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.company.staff.destroy',$row->id) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">Confirm Remove</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to remove <b>{{ $row->user->name }}</b>?
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger">Remove</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>

    {{ $staff->links() }}
</div>

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.company.staff.store',$company->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Add Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection