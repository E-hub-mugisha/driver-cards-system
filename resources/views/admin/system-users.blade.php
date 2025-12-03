@extends('layouts.app')
@section('title','System Users')
@section('content')

<!-- Breadcomb area Start-->
<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">@yield('title')</h2>
        <div>
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if( $user->type == 'admin')
                            <span class="badge badge-success notika-btn-success waves-effect">Admin</span>
                            @else
                            <span class="badge badge-primary notika-btn-primary waves-effect">Member User</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $user->id }}">
                                    <li>
                                        <form class="col-md-4" id="approve-form" action="{{ route('users.admin', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="dropdown-item btn btn-sm btn-success notika-btn-success waves-effect" onclick="return confirm('Are you sure you want to set this user admin?')">Make Admin</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form class="col-md-4" id="approve-form" action="{{ route('users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item btn btn-sm btn-danger notika-btn-danger waves-effect" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection