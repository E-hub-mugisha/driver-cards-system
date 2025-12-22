@extends('layouts.app')
@section('title','System Users')
@section('content')

<!-- Breadcomb area Start-->
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">@yield('title')</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle"><a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right"><em
                                                    class="icon ni ni-search"></em></div><input
                                                type="text" class="form-control" id="default-04"
                                                placeholder="Quick search by id">
                                        </div>
                                    </li>
                                    <li class="nk-block-tools-opt"><a href="#"
                                            data-target="addProduct"
                                            class="toggle btn btn-icon btn-primary d-md-none"><em
                                                class="icon ni ni-plus"></em></a><a href="#"
                                            data-target="addProduct"
                                            class="toggle btn btn-primary d-none d-md-inline-flex"><em
                                                class="icon ni ni-plus"></em><span>Add
                                                User</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Something went wrong!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <div class="nk-block-des">
                                <p>Lists of users that uses the system</p>
                            </div>
                        </div>
                    </div>
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col">ID</th>
                                <th class="nk-tb-col"><span class="sub-text">User</span></th>
                                <th class="nk-tb-col tb-col-lg">
                                    <span class="sub-text">Last Login</span>
                                </th>
                                <th class="nk-tb-col tb-col-lg">
                                    <span class="sub-text">Verified</span>
                                </th>
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">User Role</span></th>
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">{{ $user->id }}</td>
                                <td>
                                    <div class="user-card">
                                        <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                            <span>AB</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="tb-lead">
                                                {{ $user->name }}
                                            </span>
                                            <span class="dot dot-success d-md-none ms-1"></span>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg"><span>{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Never Logged In' }}</span>
                                <td class="nk-tb-col tb-col-lg" data-order="Email Verified - Kyc Unverified">
                                    <ul class="list-status">
                                        <li>
                                            <em class="icon text-success ni ni-check-circle"></em>
                                            <span>Email</span>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    @php
                                    $roles = [
                                    0 => 'User',
                                    1 => 'Admin',
                                    2 => 'Manager',
                                    3 => 'Supervisor'
                                    ];
                                    @endphp

                                    <span class="badge bg-primary">
                                        {{ $roles[$user->type] ?? 'User' }}
                                    </span>
                                </td>

                                <td>
                                    @if($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    @elseif($user->status === 'suspended')
                                    <span class="badge bg-danger">Suspended</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li class="nk-tb-action-hidden"><a href="#"
                                                class="btn btn-trigger btn-icon"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Send Email"><em
                                                    class="icon ni ni-mail-fill"></em></a>
                                        </li>
                                        <li class="nk-tb-action-hidden"><a href="#"
                                                class="btn btn-trigger btn-icon"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Suspend"><em
                                                    class="icon ni ni-user-cross-fill"></em></a>
                                        </li>
                                        <li>
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em
                                                                    class="icon ni ni-focus"></em><span>Quick
                                                                    View</span></a></li>

                                                        <li>
                                                            <a href="#editUserModal{{ $user->id }}" data-bs-toggle="modal">
                                                                <em class="icon ni ni-edit"></em>
                                                                <span>Edit User</span>
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#resetPasswordModal-{{ $user->id }}"><em
                                                                    class="icon ni ni-shield-star"></em><span>Reset
                                                                    Pass</span></a></li>
                                                        <li>
                                                            <a href="#userStatusModal{{ $user->id }}" data-bs-toggle="modal">
                                                                <em class="icon ni ni-na"></em>
                                                                <span>Suspend / Activate</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a type="button"
                                                                class="dropdown-item text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteUserModal{{ $user->id }}">
                                                                <em class="icon ni ni-trash"></em> Delete
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

@foreach($users as $user)
<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Are you sure you want to delete
                    <strong>{{ $user->name }}</strong>?
                </p>
                <p class="text-muted small">
                    This action will <strong>soft delete</strong> the user.
                    You can restore later.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <form action="{{ route('admin.users.destroy', $user->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Reset Password - {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admin.users.reset-password',$user->id) }}">
                @csrf
                <div class="modal-body">

                    <div class="alert alert-info">
                        The user will be required to login using the new password.
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-warning">
                        Reset Password
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.users.update',$user->id) }}" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5>Edit User - {{ $user->name }}</h5>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label>Name</label>
                    <input class="form-control" name="name" value="{{ $user->name }}">
                </div>

                <div class="mb-2">
                    <label>Email</label>
                    <input class="form-control" name="email" value="{{ $user->email }}">
                </div>

                <div class="mb-2">
                    <label>Role</label>
                    <select name="type" class="form-select">
                        <option value="1" {{ $user->type==1?'selected':'' }}>Admin</option>
                        <option value="2" {{ $user->type==2?'selected':'' }}>Manager</option>
                        <option value="3" {{ $user->type==3?'selected':'' }}>Supervisor</option>
                        <option value="0" {{ $user->type==0?'selected':'' }}>User</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach($users as $user)
<div class="modal fade" id="userStatusModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.users.updateStatus',$user->id) }}" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Update Status - {{ $user->name }}</h5>
            </div>

            <div class="modal-body">
                <select name="status" class="form-select" required>
                    <option value="active" {{ $user->status=='active'?'selected':'' }}>Activate</option>
                    <option value="suspended" {{ $user->status=='suspended'?'selected':'' }}>Suspend</option>
                    <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="nk-add-product toggle-slide toggle-slide-right" data-content="addProduct"
    data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true"
    data-simplebar>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">New User</h5>
            <div class="nk-block-des">
                <p>Add information and add new user.</p>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-3">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="col-12">
                    <div class="form-group"><label class="form-label"
                            for="name">User names</label>
                        <div class="form-control-wrap"><input type="text"
                                class="form-control" id="name" name="name"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group"><label class="form-label"
                            for="email">Email</label>
                        <div class="form-control-wrap"><input type="email"
                                class="form-control" id="email" name="email"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group"><label class="form-label" for="password">Password</label>
                        <div class="form-control-wrap"><input type="password"
                                class="form-control" id="password" name="password"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group"><label class="form-label" for="confirm_password">Confirm Password</label>
                        <div class="form-control-wrap"><input type="password"
                                class="form-control" id="password" name="password_confirmation"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group"><label class="form-label" for="SKU">User Role</label>
                        <div class="form-control-wrap">
                            <select class="form-select" name="type" id="type">
                                <option value="">-- select user role --</option>
                                <option value="1">Admin</option>
                                <option value="2">Manager</option>
                                <option value="3">Supervisor</option>
                                <option value="0">User</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="upload-zone small bg-lighter my-2">
                        <div class="dz-message"><span class="dz-message-text">Drag and drop
                                photo</span></div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <em class="icon ni ni-plus"></em><span>Add New</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection