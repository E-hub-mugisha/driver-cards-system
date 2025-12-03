@extends('layouts.app')
@section('title', 'Edit Driver')

@section('content')
<div class="container py-4">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">@yield('title')</h2>

    <div class="breadcomb-report mb-3">
        <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Back to List">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the following errors:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit {{ $driver->names }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('drivers.update',$driver->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- Full Name -->
                    <div class="col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="names" value="{{ $driver->names }}">
                    </div>

                    <!-- ID Number -->
                    <div class="col-md-4">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-control" name="ID_number" value="{{ $driver->ID_number }}">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="{{ $driver->phone }}">
                    </div>

                    <!-- Driver License -->
                    <div class="col-md-4">
                        <label class="form-label">Driver License</label>
                        <input type="text" class="form-control" name="driver_license" value="{{ $driver->driver_license }}">
                    </div>

                    <!-- RSSB -->
                    <div class="col-md-4">
                        <label class="form-label">RSSB Number</label>
                        <input type="text" class="form-control" name="rssb" value="{{ $driver->rssb }}">
                    </div>

                    <!-- Company -->
                    <div class="col-md-4">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="company" value="{{ $driver->company }}">
                    </div>

                    <!-- Contract Type -->
                    <div class="col-md-4">
                        <label class="form-label">Contract Type</label>
                        <select class="form-select" name="contract_type">
                            <option selected disabled>{{ $driver->contract_type }}</option>
                            <option value="No Contract">No Contract</option>
                            <option value="3 Month">3 Month</option>
                            <option value="6 Month">6 Month</option>
                            <option value="12 Month">12 Month</option>
                            <option value="Open Ended">Open Ended</option>
                        </select>
                    </div>

                    <!-- Insurance -->
                    <div class="col-md-4">
                        <label class="form-label">Insurance</label>
                        <select class="form-select" name="insurance">
                            <option selected disabled>{{ $driver->Insurance }}</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>

                    <!-- Photo -->
                    <div class="col-md-4">
                        <label class="form-label">Passport Photo</label>
                        <input type="file" class="form-control" name="photo">
                    </div>

                    <!-- Contract File -->
                    <div class="col-md-4">
                        <label class="form-label">Contract Document</label>
                        <input type="file" class="form-control" name="contract">
                    </div>

                </div>

                <!-- Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
