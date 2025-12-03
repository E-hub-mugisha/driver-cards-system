@extends('layouts.members')
@section('title', 'Show Driver')
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
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                            <div class="breadcomb-report">
                                <button data-toggle="tooltip" data-placement="left" title="Download Contract" class="btn"><i class="notika-icon notika-sent"></i></button>
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="contact-list">
                    <div class="contact-win">
                        <div class="contact-img">
                            <img src="{{ asset('photo')}}/{{ $driver->photo }}" class="img" alt="" width="100px">
                        </div>
                        <div class="conct-sc-ic">
                            @if($driver->status == "approved")
                            <button class="btn btn-xs btn-success notika-btn-success waves-effect">{{ $driver->status }}</button>

                            @elseif($driver->status == "pending")
                            <button class="btn btn-xs btn-warning notika-btn-warning waves-effect">{{ $driver->status }}</button>
                            @else
                            <button class="btn btn-xs btn-danger notika-btn-danger waves-effect">{{ $driver->status }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="contact-ctn">
                        <div class="contact-ad-hd">
                            <h2>{{ $driver->names}}</h2>
                        </div>
                    </div>
                    <div class="contact-dt row">
                        <ul class="col-md-6 contact-list widget-contact-list">
                            <li><i class="notika-icon notika-star"></i>Company Name: {{ $driver->company}}</li>
                            <li><i class="notika-icon notika-star"></i>Phone Number: {{ $driver->phone}}</li>
                            <li><i class="notika-icon notika-star"></i>ID Number: {{ $driver->ID_number}}</li>
                            <li><i class="notika-icon notika-star"></i>Driver's: License {{ $driver->driver_license}}</li>

                        </ul>
                        <ul class="col-md-6 contact-list widget-contact-list">
                            <li><i class="notika-icon notika-star"></i>RSSB Number: {{ $driver->rssb}}</li>
                            <li><i class="notika-icon notika-star"></i>Contract Type: {{ $driver->contract_type}}</li>
                            <li><i class="notika-icon notika-star"></i>Insurance: {{ $driver->Insurance}}</li>
                            <li><i class="notika-icon notika-star"></i>Created At: {{ $driver->created_at}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="contact-list">
                    <div class="contact-ctn">
                        <div class="contact-ad-hd">
                            <h2>Driver's Contract</h2>
                        </div>
                    </div>
                    <div class="contact-dt row">
                        <object class="pdf" data="{{asset('contract')}}/{{ $driver->contract }}" width="100%" height="250">
                        </object>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Contact Info area-->

@endsection