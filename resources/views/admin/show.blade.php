@extends('layouts.app')
@section('title', 'Driver Details')
@section('content')

<div class="container py-4">

    <div class="row g-4">

        <!-- LEFT CARD: Driver Info -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- Photo + Status -->
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('photo/'.$driver->photo) }}" 
                             class="rounded me-3 border" 
                             width="90" height="90" 
                             style="object-fit: cover;">

                        <div>
                            @if($driver->status == "approved")
                                <span class="badge bg-success px-3 py-2">{{ $driver->status }}</span>
                            @elseif($driver->status == "pending")
                                <span class="badge bg-warning px-3 py-2">{{ $driver->status }}</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">{{ $driver->status }}</span>
                            @endif

                            <h4 class="mt-2 mb-0 fw-bold">{{ $driver->names }}</h4>

                            <a href="{{asset('photo/'.$driver->photo)}}" 
                               class="btn btn-sm btn-outline-success mt-2"
                               target="_blank">
                                Download Photo
                            </a>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Driver Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="fw-semibold mb-1">Company Name</p>
                            <p class="text-muted">{{ $driver->company }}</p>

                            <p class="fw-semibold mb-1">Phone Number</p>
                            <p class="text-muted">{{ $driver->phone }}</p>

                            <p class="fw-semibold mb-1">ID Number</p>
                            <p class="text-muted">{{ $driver->ID_number }}</p>
                        </div>

                        <div class="col-md-6">
                            <p class="fw-semibold mb-1">RSSB Number</p>
                            <p class="text-muted">{{ $driver->rssb }}</p>

                            <p class="fw-semibold mb-1">Contract Type</p>
                            <p class="text-muted">{{ $driver->contract_type }}</p>

                            <p class="fw-semibold mb-1">Insurance</p>
                            <p class="text-muted">{{ $driver->Insurance }}</p>
                        </div>
                    </div>

                    <p class="fw-semibold mb-1">Driver License</p>
                    <p class="text-muted">{{ $driver->driver_license }}</p>

                    <p class="fw-semibold mb-1">Created At</p>
                    <p class="text-muted">{{ $driver->created_at }}</p>

                    <hr class="my-4">

                    <!-- Status Action Buttons -->
                    <div class="row g-2">
                        <div class="col-md-4">
                            <form action="{{ route('admin.approval', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-success w-100 btn-sm"
                                        onclick="return confirm('Approve this driver?')">
                                    Approve
                                </button>
                            </form>
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('admin.pending', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-warning w-100 btn-sm"
                                        onclick="return confirm('Set driver as pending?')">
                                    Pending
                                </button>
                            </form>
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('admin.decline', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-danger w-100 btn-sm"
                                        onclick="return confirm('Decline this driver?')">
                                    Decline
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT CARD: Contract -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <h4 class="fw-bold mb-3">Driver Contract</h4>

                    <div class="border rounded overflow-hidden mb-3" style="height: 280px;">
                        <object data="{{ asset('contract/'.$driver->contract) }}" 
                                type="application/pdf"
                                width="100%" height="100%">
                        </object>
                    </div>

                    <a href="{{ asset('contract/'.$driver->contract) }}" 
                       target="_blank" 
                       class="btn btn-outline-success btn-sm"
                       onclick="return confirm('Download contract?')">
                        Download Contract
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
