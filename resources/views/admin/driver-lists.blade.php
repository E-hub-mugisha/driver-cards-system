@extends('layouts.app')
@section('title','Drivers list')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- TITLE -->
            <h2 class="az-content-title mb-0">Drivers lists</h2>

            <!-- BUTTONS -->
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-rounded"
                    data-bs-toggle="modal"
                    data-bs-target="#myModalAddDriver">
                    Add Driver
                </button>

                <a href="{{ route('drivers.export') }}"
                    class="btn btn-success btn-rounded">
                    Download Report
                </a>
            </div>

        </div>


        <!-- Bootstrap 5 Modal -->
        <div class="modal fade" id="myModalAddDriver" tabindex="-1" aria-labelledby="addDriverLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- BS5 uses modal-lg not modal-large -->
                <div class="modal-content">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDriverLabel">Add Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">

                            <p class="text-muted mb-3">Fill in the form to add driver details</p>

                            <div class="row g-3">

                                <!-- Full Name -->
                                <div class="col-md-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="names" class="form-control">
                                </div>

                                <!-- ID Number -->
                                <div class="col-md-4">
                                    <label class="form-label">ID Number</label>
                                    <input type="text" name="ID_number" class="form-control">
                                </div>

                                <!-- Phone -->
                                <div class="col-md-4">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>

                                <!-- License -->
                                <div class="col-md-4">
                                    <label class="form-label">Driver License</label>
                                    <input type="text" name="driver_license" class="form-control">
                                </div>

                                <!-- RSSB -->
                                <div class="col-md-4">
                                    <label class="form-label">RSSB Number</label>
                                    <input type="text" name="rssb" class="form-control">
                                </div>

                                <!-- Company -->
                                <div class="col-md-4">
                                    <label class="form-label">Company Name</label>
                                    <select name="company" class="form-select">
                                        <option disabled selected>-- select company name --</option>
                                        @foreach($companies as $c)
                                        <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Contract -->
                                <div class="col-md-4">
                                    <label class="form-label">Contract Type</label>
                                    <select name="contract_type" class="form-select">
                                        <option disabled selected>-- select contract type --</option>
                                        <option>No Contract</option>
                                        <option>3 Month</option>
                                        <option>6 Month</option>
                                        <option>12 Month</option>
                                        <option>Open Ended</option>
                                    </select>
                                </div>

                                <!-- Insurance -->
                                <div class="col-md-4">
                                    <label class="form-label">Insurance</label>
                                    <select name="insurance" class="form-select">
                                        <option disabled selected>-- select insurance --</option>
                                        <option>YES</option>
                                        <option>NO</option>
                                    </select>
                                </div>

                                <!-- Photo -->
                                <div class="col-md-4">
                                    <label class="form-label">Upload Passport Photo</label>
                                    <input type="file" name="photo" class="form-control">
                                </div>

                                <!-- Contract Upload -->
                                <div class="col-md-4">
                                    <label class="form-label">Upload Contract</label>
                                    <input type="file" name="contract" class="form-control">
                                </div>

                            </div>

                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm py-3 px-4">
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
                            <span class="badge badge-success">{{ $driver->status }}</span>

                            @elseif($driver->status == "pending")
                            <span class="badge badge-warning">{{ $driver->status }}</span>
                            @else
                            <span class="badge badge-info">{{ $driver->status }}</span>
                            @endif
                        </td>
                        <td>{{ $driver->created_at }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $driver->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $driver->id }}">
                                    <li>
                                        <a class="dropdown-item btn btn-primary btn-xs" href="{{ route('admin.show', $driver->id) }}">
                                            View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.drivers.behaviors.index', $driver) }}"
                                            class="dropdown-item btn btn-sm btn-secondary">
                                            View Behaviors
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reportBehaviorModal-{{ $driver->id }}">
                                            Report Behavior
                                        </button>

                                    </li>
                                    <li>
                                        <a class="dropdown-item btn btn-info btn-xs" href="{{ route('admin.edit', $driver->id) }}">
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form id="delete-form" action="{{ route('admin.destroy', $driver->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this driver?')">
                                                Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

@foreach( $drivers as $driver)
<!-- REPORT MODAL -->
<div class="modal fade" id="reportBehaviorModal-{{ $driver->id }}">
    <div class="modal-dialog">
        <form method="POST"
            action="{{ route('admin.drivers.behaviors.store', $driver) }}"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Report Behavior – {{ $driver->name }}</h5>
            </div>

            <div class="modal-body">
                <!-- CATEGORY -->
                <select class="form-control mb-2"
                    onchange="this.nextElementSibling.querySelectorAll('option').forEach(o=>o.style.display=o.dataset.cat==this.value?'block':'none')">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <!-- BEHAVIOR -->
                <select name="behavior_type_id"
                    class="form-control mb-2"
                    required
                    onchange="
            this.form.score.value =
            this.options[this.selectedIndex].dataset.score || ''
        ">
                    <option value="">Select Behavior</option>

                    @foreach($categories as $cat)
                    @foreach($cat->behaviorTypes as $b)
                    <option value="{{ $b->id }}"
                        data-cat="{{ $cat->id }}"
                        data-score="{{ $b->default_score }}"
                        style="display:none">
                        {{ $b->name }}
                    </option>
                    @endforeach
                    @endforeach
                </select>


                <!-- SEVERITY -->
                <select name="severity" class="form-control mb-2">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <!-- SCORE -->
                <input type="number"
                    name="score"
                    class="form-control mb-2"
                    placeholder="Score (auto-filled)">


                <!-- description -->
                <textarea name="description"
                    class="form-control"
                    placeholder="description (optional)"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection