@extends('layouts.app')

@section('title', $company->name . ' Staff')

@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between mb-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ $company->name }} — Staff</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#addStaffModal"
                            class="toggle btn rounded-5 d-none d-md-inline-flex"
                            style="background-color:#00ADEE; color:#fff">
                            <em class="icon ni ni-plus"></em>
                            <span>Add Staff</span>
                        </a>

                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="nk-block nk-block-lg bg-white rounded-5 shadow-sm p-4">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="nk-block-des">
                            <p>Lists of staff for the {{ $company->name }}</p>
                        </div>
                    </div>
                </div>
                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col">#</th>
                            <th class="nk-tb-col">User</th>
                            <th class="nk-tb-col">Email</th>
                            <th class="nk-tb-col">Role</th>
                            <th class="nk-tb-col">Status</th>
                            <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($staff as $row)
                        <tr class="nk-tb-item {{ $row->trashed() ? 'table-warning' : '' }}">
                            <td class="nk-tb-col">{{ $loop->iteration }}</td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                        <span>{{ substr($row->name, 0, 2) }}</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $row->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">{{ $row->user->email }}</td>
                            <td class="nk-tb-col">{{ ucfirst($row->role ?? 'No Role') }}</td>
                            <td class="nk-tb-col">
                                <span class=" 
                        @if($row->status=='active') text-success
                        @elseif($row->status=='suspended') text-danger
                        @else text-secondary @endif">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools text-end">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown"><a href="#"
                                                class="dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @if(!$row->trashed())
                                                    <!-- Edit -->
                                                    <li>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#editStaffModal{{ $row->id }}">
                                                            <em class="icon ni ni-edit"></em>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                    <!-- Reset Password Trigger -->
                                                    <li>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#resetPasswordModal{{ $row->id }}">
                                                            <em class="icon ni ni-shield-star"></em><span>Reset Password</span>
                                                        </a>
                                                    </li>

                                                    <!-- Delete (Soft Delete) -->
                                                    <li><a type="button"
                                                            class="dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteStaffModal{{ $row->id }}">
                                                            <em class="icon ni ni-trash"></em><span>Remove</span></a>
                                                    </li>
                                                    @else
                                                    <!-- Restore Trigger -->
                                                    <li>
                                                        <a
                                                            type="button"
                                                            class="text-success btn btn-link p-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#restoreStaffModal{{ $row->id }}">
                                                            Restore
                                                        </a>
                                                        <!-- Restore Staff Confirmation Modal -->
                                                        <div class="modal fade" id="restoreStaffModal{{ $row->id }}" tabindex="-1"
                                                            aria-labelledby="restoreStaffModalLabel{{ $row->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">

                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="restoreStaffModalLabel{{ $row->id }}">
                                                                            Confirm Restore
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p class="mb-2">
                                                                            Are you sure you want to restore
                                                                            <strong>{{ $row->name }}</strong>?
                                                                        </p>
                                                                        <p class="text-muted mb-0">
                                                                            This user will regain access to the system.
                                                                        </p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                                            Cancel
                                                                        </button>

                                                                        <form action="{{ route('company.staff.restore', $row->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-success">
                                                                                Yes, Restore User
                                                                            </button>
                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
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


@foreach($staff as $row)


<!-- Reset Password Confirmation Modal -->
<div class="modal fade" id="resetPasswordModal{{ $row->id }}" tabindex="-1"
    aria-labelledby="resetPasswordModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel{{ $row->id }}">
                    Confirm Password Reset
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">
                    Are you sure you want to reset the password for
                    <strong>{{ $row->name }}</strong>?
                </p>
                <p class="text-muted mb-0">
                    A new password will be generated and sent to the user.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <form action="{{ route('company.staff.reset-password', $row->id) }}"
                    method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Yes, Reset Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal{{ $row->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('company.staff.update', $row->id) }}">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Staff Modal -->
<div class="modal fade" id="deleteStaffModal{{ $row->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('company.staff.destroy',$row->id) }}">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('company.staff.store', $company->id) }}">
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
                        <select name="role" class="form-select" required>
                            <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Staff</button>
                </div>

            </form>

        </div>
    </div>
</div>


@endsection