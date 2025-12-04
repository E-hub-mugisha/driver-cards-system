@extends('layouts.app')
@section('title', 'Driver Details')
@section('content')

<div class="container py-4">
    <div class="az-content-body pd-lg-l-40">

        <div class="row g-4">

            <!-- LEFT CARD -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <!-- Photo + Status -->
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('photo/'.$driver->photo) }}"
                                class="rounded-circle shadow-sm me-3"
                                width="90" height="90"
                                style="object-fit: cover;">

                            <div>
                                <h4 class="mt-2 fw-bold mb-0">{{ $driver->names }}</h4>
                                <p class="text-muted small mb-0">{{ $driver->company }} <!-- STATUS BADGE -->
                                    <span class="badge 
                                    @if($driver->status=='approved') bg-success 
                                    @elseif($driver->status=='pending') bg-warning 
                                    @else bg-danger @endif 
                                    px-3 py-2 text-uppercase">
                                        {{ $driver->status }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- INFO GRID -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="mb-2">
                                    <span class="fw-semibold">Phone</span>
                                    <p class="text-muted mb-0">{{ $driver->phone }}</p>
                                </div>

                                <div class="mb-2">
                                    <span class="fw-semibold">ID Number</span>
                                    <p class="text-muted mb-0">{{ $driver->ID_number }}</p>
                                </div>

                                <div class="mb-2">
                                    <span class="fw-semibold">RSSB</span>
                                    <p class="text-muted mb-0">{{ $driver->rssb }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="mb-2">
                                    <span class="fw-semibold">Contract Type</span>
                                    <p class="text-muted mb-0">{{ $driver->contract_type }}</p>
                                </div>

                                <div class="mb-2">
                                    <span class="fw-semibold">Insurance</span>
                                    <p class="text-muted mb-0">{{ $driver->Insurance }}</p>
                                </div>

                                <div class="mb-2">
                                    <span class="fw-semibold">Driver License</span>
                                    <p class="text-muted mb-0">{{ $driver->driver_license }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="fw-semibold">Created At</span>
                            <p class="text-muted mb-0">{{ $driver->created_at->format('M j, Y') }}</p>
                        </div>

                        <hr>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex gap-2 flex-wrap">

                            <form action="{{ route('admin.approval', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-success btn-sm px-3"
                                    onclick="return confirm('Approve this driver?')">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.pending', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-warning btn-sm px-3"
                                    onclick="return confirm('Set driver as pending?')">
                                    Pending
                                </button>
                            </form>

                            <form action="{{ route('admin.decline', $driver->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="btn btn-danger btn-sm px-3"
                                    onclick="return confirm('Decline this driver?')">
                                    Decline
                                </button>
                            </form>

                            <a href="{{ asset('photo/'.$driver->photo) }}"
                                target="_blank"
                                class="btn btn-outline-success btn-sm px-3">
                                Download Photo
                            </a>

                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT CARD -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-3">Driver Contract</h4>

                        <div class="border rounded shadow-sm overflow-hidden mb-3"
                            style="height: 330px; background:#f8f9fa;">
                            <object data="{{ asset('contract/'.$driver->contract) }}"
                                type="application/pdf"
                                width="100%" height="100%">
                            </object>
                        </div>

                        <a href="{{ asset('contract/'.$driver->contract) }}"
                            target="_blank"
                            class="btn btn-outline-primary btn-sm px-3">
                            Download Contract
                        </a>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection