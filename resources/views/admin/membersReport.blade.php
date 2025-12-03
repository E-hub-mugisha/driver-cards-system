@extends('layouts.app')
@section('title','Member By Status')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">@yield('title')</h2>
        <p>Welcome to A.T.P.R <span class="bread-ntd">System</span></p>

        <div class="breadcomb-report">
            <a href="{{ route('drivers.export') }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></a>
        </div>
        <div>
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'approved'] ) }}">
                                Approved
                            </a>
                            <a class="btn btn-info btn-xs" href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'pending'] ) }}">
                                Pending
                            </a>
                            <a class="btn btn-info btn-xs" href="{{ route('approved.driver', ['name' => $member->name, 'status' => 'declined'] ) }}">
                                Declined
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>


@endsection