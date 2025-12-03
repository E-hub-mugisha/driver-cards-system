@extends('layouts.app')
@section('title','Member By Status')
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
                                <a href="{{ route('drivers.export') }}" data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></a>
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
                        <p>It's just that simple. Turn your simple table into a sophisticated data table and offer your users a nice experience and great features without any effort.</p>
                    </div>
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
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
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
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