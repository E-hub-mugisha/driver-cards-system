@extends('layouts.app')
@section('title', $driver->names . "- details")
@section('content')
<div class="container">

    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">

                <div>
                    <h4 class="mb-1">
                        {{ $driver->names }}
                        <span class="badge bg-primary">{{ ucfirst($driver->status) }}</span>
                    </h4>

                    <p class="text-muted mb-0">
                        Company: <strong>{{ $driver->company->name ?? 'Not Assigned' }}</strong>
                    </p>
                </div>

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        Actions
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        {{-- APPROVE --}}
                        @if($driver->status != 'approved')
                        <li>
                            <form method="POST" action="{{ route('admin.drivers.approve',$driver->id) }}">
                                @csrf
                                <button class="dropdown-item">Approve Driver</button>
                            </form>
                        </li>
                        @endif

                        {{-- DOWNLOAD PHOTO --}}
                        <li>
                            @if($driver->photo)
                            <a class="dropdown-item"
                                href="{{ asset('storage/'.$driver->photo) }}"
                                download>
                                Download Photo
                            </a>
                            @else
                            <span class="dropdown-item text-muted">No Photo</span>
                            @endif
                        </li>

                        {{-- DOWNLOAD CONTRACT --}}
                        <li>
                            @if($driver->contract)
                            <a class="dropdown-item"
                                href="{{ asset('storage/'.$driver->contract) }}"
                                download>
                                Download Contract
                            </a>
                            @else
                            <span class="dropdown-item text-muted">No Contract</span>
                            @endif
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        {{-- EDIT --}}
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editDriverModal{{ $driver->id }}">
                                Edit Driver
                            </a>
                        </li>

                        {{-- DELETE --}}
                        <li>
                            <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteDriverModal{{ $driver->id }}">
                                Delete Driver
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <ul class="nav nav-tabs" id="driverTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#profile">Profile</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#documents">Documents</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#behavior">Behavior History</a>
                </li>
            </ul>

            <div class="tab-content mt-3">

                {{-- PROFILE TAB --}}
                <div class="tab-pane fade show active" id="profile">
                    <div class="row">

                        <div class="col-md-4">
                            @if($driver->photo)
                            <img src="{{ asset('storage/'.$driver->photo) }}"
                                class="img-fluid rounded shadow">
                            @else
                            <div class="alert alert-info">No Photo Uploaded</div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Names</th>
                                    <td>{{ $driver->names }}</td>
                                </tr>
                                <tr>
                                    <th>National ID</th>
                                    <td>{{ $driver->ID_number }}</td>
                                </tr>
                                <tr>
                                    <th>Driver License</th>
                                    <td>{{ $driver->driver_license }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $driver->phone }}</td>
                                </tr>
                                <tr>
                                    <th>RSSB</th>
                                    <td>{{ $driver->rssb }}</td>
                                </tr>
                                <tr>
                                    <th>Insurance</th>
                                    <td>{{ $driver->insurance }}</td>
                                </tr>
                                <tr>
                                    <th>Contract Type</th>
                                    <td>{{ $driver->contract_type }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $driver->status }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>


                {{-- DOCUMENTS TAB --}}
                <div class="tab-pane fade" id="documents">
                    <h5>Driver Documents</h5>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Photo:</strong>
                            @if($driver->photo)
                            <a href="{{ asset('storage/'.$driver->photo) }}" target="_blank">View Photo</a>
                            @else
                            <span class="text-danger">Not Uploaded</span>
                            @endif
                        </li>

                        <li class="list-group-item">
                            <strong>Contract:</strong>
                            @if($driver->contract)
                            <a href="{{ asset('storage/'.$driver->contract) }}" target="_blank">View Contract</a>
                            @else
                            <span class="text-danger">Not Uploaded</span>
                            @endif
                        </li>
                    </ul>
                </div>


                {{-- BEHAVIOR HISTORY TAB --}}
                <div class="tab-pane fade" id="behavior">
                    <div class="d-flex justify-content-between">
                        <h5>Driver Behavior History</h5>

                        {{-- Optional: Add Record Button --}}
                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#addBehaviorModal-{{ $driver->id }}">
                            Add Behavior Record
                        </button>
                    </div>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Behavior</th>
                                <th>Severity</th>
                                <th>Score</th>
                                <th>Reported By</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($driver->behaviors as $behavior)
                            <tr>
                                <td>{{ $behavior->created_at?->format('d M Y') }}</td>
                                <td>{{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }}</td>
                                <td>{{ $behavior->behaviorType->name }}</td>
                                <td>
                                    <span class="badge
                        @if($behavior->severity === 'low') bg-info
                        @elseif($behavior->severity === 'medium') bg-warning
                        @else bg-danger @endif">
                                        {{ ucfirst($behavior->severity) }}
                                    </span>
                                </td>
                                <td>{{ $behavior->score }}</td>
                                <td>{{ optional($behavior->reporter)->name ?? 'System' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No behavior history found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>

</div>


<!-- REPORT MODAL -->
<div class="modal fade" id="addBehaviorModal-{{ $driver->id }}">
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

<div class="modal fade" id="editDriverModal{{ $driver->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.update',$driver->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="names" class="form-control" value="{{ $driver->names }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>ID Number</label>
                            <input type="text" name="ID_number" class="form-control" value="{{ $driver->ID_number }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Driver License</label>
                            <input type="text" name="driver_license" class="form-control" value="{{ $driver->driver_license }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>RSSB Number</label>
                            <input type="text" name="rssb" class="form-control" value="{{ $driver->rssb }}">
                        </div>
                        <div class="col-md-6">
                            <label>Insurance</label>
                            <select name="insurance" class="form-select">
                                <option>YES</option>
                                <option>NO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Company</label>
                            <select name="company_id" class="form-control">
                                <option value="">--Select Company--</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $driver->company_id==$company->id?'selected':'' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Contract Type</label>
                            <select name="contract_type" class="form-select">
                                <option value="3 month" {{ $driver->contract_type=='3 month'?'selected':'' }}>3 Month</option>
                                <option value="6 month" {{ $driver->contract_type=='6 month'?'selected':'' }}>6 Month</option>
                                <option value="12 month" {{ $driver->contract_type=='12 month'?'selected':'' }}>12 Month</option>
                                <option value="open ended" {{ $driver->contract_type=='open ended'?'selected':'' }}>Open Ended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $driver->status=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ $driver->status=='inactive'?'selected':'' }}>Inactive</option>
                                <option value="suspended" {{ $driver->status=='suspended'?'selected':'' }}>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control">
                            @if($driver->photo)
                            <small>Current: <a href="{{ asset('storage/'.$driver->photo) }}" target="_blank">View</a></small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label>Contract</label>
                            <input type="file" name="contract" class="form-control">
                            @if($driver->contract)
                            <small>Current: <a href="{{ asset('storage/'.$driver->contract) }}" target="_blank">View</a></small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Driver Modal -->
<div class="modal fade" id="deleteDriverModal{{ $driver->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.destroy',$driver->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirm Remove</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove <b>{{ $driver->names }}</b>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection