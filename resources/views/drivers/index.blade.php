@extends('layouts.members')
@section('title','Drivers list')
@section('content')

<!-- Breadcomb area Start-->
<div class="breadcomb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
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
                                <button class="btn" data-toggle="modal" data-target="#myModalAddDriver">Add Driver</button>
                            </div>
                            <div class="modal fade" id="myModalAddDriver" role="dialog">
                                <div class="modal-dialog modal-large">
                                    <div class="modal-content">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-element-list">
                                                    <div class="cmp-tb-hd">
                                                        <h2>Add Driver</h2>
                                                        <p>Fll in the form to add driver details </p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-support"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Full Name</label>
                                                                    <input type="text" name="names" id="names" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-mail"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">ID Number</label>
                                                                    <input type="text" name="ID_number" id="ID_number" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-phone"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Phone Number</label>
                                                                    <input type="text" name="phone" id="phone" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-wifi"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Driver License</label>
                                                                    <input type="text" name="driver_license" id="driver_license" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-house"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">RSSB Number</label>
                                                                    <input type="text" name="rssb" id="rssb" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-edit"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Company Name</label>
                                                                    <input type="text" name="company" id="company" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-edit"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Contract Type</label>
                                                                    <select name="contract_type" id="contract_type" class="form-control">
                                                                        <option value="" disabled selected></option>
<option value="No Contract">No Contract</option>
                                                                        <option value="3 Month">3 Month</option>
                                                                        <option value="6 Month">6 Month</option>
                                                                        <option value="12 Month">12 Month</option>
                                                                        <option value="Open Ended">Open Ended</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-edit"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Insurance</label>
                                                                    <select name="insurance" id="insurance" class="form-control">
                                                                        <option value="" disabled selected></option>
                                                                        <option value="YES">YES</option>
                                                                        <option value="NO">NO</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-edit"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Upload Photo Passport</label>
                                                                    <input type="file" name="photo" id="photo" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                                <div class="form-ic-cmp">
                                                                    <i class="notika-icon notika-up-arrow"></i>
                                                                </div>
                                                                <div class="nk-int-st">
                                                                    <label class="nk-label">Upload Contract</label>
                                                                    <input type="file" name="contract" id="contract" class="form-control">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default">Save changes</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="breadcomb-report">
                                <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
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
                                        <a class="btn btn-primary btn-xs" href="{{ route('drivers.show', $driver->id) }}">
                                            View
                                        </a>
                                        <a class="btn btn-info btn-xs" href="{{ route('drivers.edit', $driver->id) }}">
                                            Edit
                                        </a>
                                        <form id="delete-form" action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
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