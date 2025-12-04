@extends('layouts.app')
@section('title','Member Report')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="az-content-title">@yield('title')</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('drivers.export') }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn btn-primary btn-rounded btn-block">Download Report</a>
            </div>
        </div>
        <div class="card shadow-sm p-4">
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Drivers</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <th> {{ $member->drivers_count }} (Drivers) </th>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $member->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $member->id }}">
                                    <li>
                                        <a class="dropdown-item " href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'approved'] ) }}">
                                            Approved
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item " href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'pending'] ) }}">
                                            Pending
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item " href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'declined'] ) }}">
                                            Declined
                                        </a>
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