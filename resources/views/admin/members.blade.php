@extends('layouts.app')
@section('title','Member list')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">Members list</h2>
        <div class="breadcomb-report">
            <a href="{{ route('drivers.export') }}" class="btn btn-primary btn-rounded btn-block">Download Report</a>
        </div>
        <div>
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->status }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $member->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $member->id }}">
                                    <li>
                                        <a href="{{ route('member.active', $member->id) }}" class="dropdown-item text-success">Activate</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('member.inactive', $member->id) }}" class="dropdown-item text-warning">Inactivate</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('member.delete', $member->id) }}" class="dropdown-item text-danger">Delete</a>
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
