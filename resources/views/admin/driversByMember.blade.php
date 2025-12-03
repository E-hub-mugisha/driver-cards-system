@extends('layouts.app')
@section('title','Drivers list')
@section('content')

<!-- Breadcomb area Start-->
<div class="breadcomb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-windows"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>@yield('title')</h2>
                                    <p>Welcome to A.T.P.R <span class="bread-ntd">System</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="breadcomb-report">
                                <a href="{{ route('drivers.exportByCompany', ['name' => $memberOf , 'status' => $statusOf ]) }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcomb area End-->
<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="basic-tb-hd">
                        <h2>@yield('title')</h2>
                        <p>Driver {{ $status}} List for {{ $name }} Company.</p>
                    </div>
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
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
                            <tfoot>
                                <tr>
                                    <th>Names</th>
                                    <th>company</th>
                                    <th>phone</th>
                                    <th>contract_type</th>
                                    <th>status</th>
                                    <th>created date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->

@endsection