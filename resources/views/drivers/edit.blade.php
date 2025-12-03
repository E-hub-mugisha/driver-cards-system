@extends('layouts.members')
@section('title', 'Edit Driver')
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
                                    <i class="notika-icon notika-house"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>@yield('title')</h2>
                                    <p>Welcome to A.T.P.R <span class="bread-ntd">System</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                            <div class="breadcomb-report">
                                <form id="delete-form" action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger notika-btn-danger waves-effect" onclick="return confirm('Are you sure you want to delete this driver?')">
                                        Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-3">
                            <div class="breadcomb-report">
                                <button data-toggle="tooltip" data-placement="left" title="Back To list" class="btn"><i class="notika-icon notika-left-arrow"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcomb area End-->
<!-- Start Contact Info area-->
<div class="contact-info-area mg-t-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
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
                <form action="{{ route('drivers.update',$driver->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-element-list">
                        <div class="cmp-tb-hd">
                            <h2>Edit {{ $driver->names}}'s Information</h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <label class="nk-label">Full Name</label>
                                        <input type="text" name="names" id="names" class="form-control" value="{{ $driver->names}}">

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
                                        <input type="text" name="ID_number" id="ID_number" class="form-control" value="{{ $driver->ID_number}}">

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
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $driver->phone}}">

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
                                        <input type="text" name="driver_license" id="driver_license" class="form-control" value="{{ $driver->driver_license}}">

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
                                        <input type="text" name="rssb" id="rssb" class="form-control" value="{{ $driver->rssb}}">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group ic-cmp-int form-elet-mg">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-edit"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <label class="nk-label">Company Name</label>
                                        <input type="text" name="company" id="company" readonly class="form-control" value="{{ $driver->company}}">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group ic-cmp-int form-elet-mg">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-edit"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <label class="nk-label">Contract Type</label>
                                        <select name="contract_type" id="contract_type" class="form-control">
                                            <option value="{{ $driver->contract_type}}" disabled selected>{{ $driver->contract_type}}</option>
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
                                            <option value="{{ $driver->Insurance}}" disabled selected>{{ $driver->Insurance}}</option>
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
                        <div class="form-example-int mg-t-15">
                            <div class="row">

                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <button type="submit" class="btn btn-success notika-btn-success waves-effect">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Contact Info area-->

    @endsection