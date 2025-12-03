@extends('layouts.app')
@section('title', 'Create Driver')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <h2 class="az-content-title">@yield('title')</h2>
        <div class="breadcomb-report">
            <a href="{{ route('admin.index') }}" class="btn btn-primary btn-rounded btn-block" data-bs-toggle="tooltip" title="Back to List">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        {{-- Validation Errors --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Add Driver Information</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        {{-- Full Name --}}
                        <div class="col-md-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="names" class="form-control" placeholder="Enter full name">
                        </div>

                        {{-- ID Number --}}
                        <div class="col-md-4">
                            <label class="form-label">ID Number</label>
                            <input type="text" name="ID_number" class="form-control" placeholder="Enter ID number">
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                        </div>

                        {{-- License --}}
                        <div class="col-md-4">
                            <label class="form-label">Driver License</label>
                            <input type="text" name="driver_license" class="form-control">
                        </div>

                        {{-- RSSB --}}
                        <div class="col-md-4">
                            <label class="form-label">RSSB Number</label>
                            <input type="text" name="rssb" class="form-control">
                        </div>

                        {{-- Company --}}
                        <div class="col-md-4">
                            <label class="form-label">Company Name</label>
                            <select name="company" class="form-select">
                                <option selected disabled>-- select company name --</option>
                                @foreach($companies as $c)
                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Contract --}}
                        <div class="col-md-4">
                            <label class="form-label">Contract Type</label>
                            <select name="contract_type" class="form-select">
                                <option selected disabled>-- select contract type --</option>
                                <option>No Contract</option>
                                <option>3 Month</option>
                                <option>6 Month</option>
                                <option>12 Month</option>
                                <option>Open Ended</option>
                            </select>
                        </div>

                        {{-- Insurance --}}
                        <div class="col-md-4">
                            <label class="form-label">Insurance</label>
                            <select name="insurance" class="form-select">
                                <option selected disabled>-- select insurance --</option>
                                <option>YES</option>
                                <option>NO</option>
                            </select>
                        </div>

                        {{-- Photo --}}
                        <div class="col-md-4">
                            <label class="form-label">Upload Passport Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        {{-- Contract Upload --}}
                        <div class="col-md-4">
                            <label class="form-label">Upload Contract</label>
                            <input type="file" name="contract" class="form-control">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection