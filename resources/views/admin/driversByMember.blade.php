@extends('layouts.app')
@section('title','Drivers list')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">@yield('title')</h2>
        <p>Welcome to A.T.P.R <span class="bread-ntd">System</span></p>

        <div class="breadcomb-report">
            <a href="{{ route('drivers.exportByCompany', ['name' => $memberOf , 'status' => $statusOf ]) }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></a>
        </div>

        <p>Driver {{ $status}} List for {{ $name }} Company.</p>
        <div>
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>Names</th>
                        <th>company</th>
                        <th>phone</th>
                        <th>contract type</th>
                        <th>status</th>
                        <th>created date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $drivers as $driver)
                    <tr>
                        <td>{{ $driver->names }}</td>
                        <td>{{ $driver->company }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->contract_type }}</td>
                        <td>
                            @if($driver->status == "approved")
                            <button class="btn btn-xs btn-success notika-btn-success waves-effect">{{ $driver->status }}</button>

                            @elseif($driver->status == "pending")
                            <button class="btn btn-xs btn-warning notika-btn-warning waves-effect">{{ $driver->status }}</button>
                            @else
                            <button class="btn btn-xs btn-danger notika-btn-danger waves-effect">{{ $driver->status }}</button>
                            @endif
                        </td>
                        <td>{{ $driver->created_at }}</td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="{{ route('admin.show', $driver->id) }}">
                                View
                            </a>
                            <a class="btn btn-info btn-xs" href="{{ route('admin.edit', $driver->id) }}">
                                Edit
                            </a>
                            <form id="delete-form" action="{{ route('admin.destroy', $driver->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this driver?')">
                                    Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

@endsection