@extends('layouts.app')
@section('title', $driver->names . " - Details")
@section('content')
<div class="container">

    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">

                <div>
                    <h4 class="mb-1">
                        {{ $driver->names }}
                        <span class="badge 
                            @if($driver->performance_score >= 80) bg-success
                            @elseif($driver->performance_score >= 60) bg-primary
                            @elseif($driver->performance_score >= 40) bg-warning
                            @else bg-danger @endif">
                            {{ $driver->performance_rating }}
                        </span>
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
                        @if($driver->status != 'approved')
                        <li>
                            <button class="dropdown-item text-success"
                                data-bs-toggle="modal"
                                data-bs-target="#approveDriverModal">
                                Approve Driver
                            </button>
                        </li>
                        @endif
                        <li>
                            @if($driver->photo)
                            <a class="dropdown-item"
                                href="{{ asset('storage/'.$driver->photo) }}" download>
                                Download Photo
                            </a>
                            @else
                            <span class="dropdown-item text-muted">No Photo</span>
                            @endif
                        </li>
                        <li>
                            @if($driver->contract)
                            <a class="dropdown-item"
                                href="{{ asset('storage/'.$driver->contract) }}" download>
                                Download Contract
                            </a>
                            @else
                            <span class="dropdown-item text-muted">No Contract</span>
                            @endif
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editDriverModal{{ $driver->id }}">
                                Edit Driver
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteDriverModal{{ $driver->id }}">
                                Delete Driver
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Tabs --}}
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
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#incidents">Incidents</a>
                </li>
            </ul>

            <div class="tab-content mt-3">

                {{-- PROFILE TAB --}}
                <div class="tab-pane fade show active" id="profile">
                    <div class="row">
                        <div class="col-md-4">
                            @if($driver->photo)
                            <img src="{{ asset('storage/'.$driver->photo) }}" class="img-fluid rounded shadow">
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
                                    <td>{{ ucfirst($driver->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Performance Score</th>
                                    <td>{{ $driver->performance_score }}</td>
                                </tr>
                                <tr>
                                    <th>Performance Rating</th>
                                    <td>{{ $driver->performance_rating }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTS TAB --}}
                <div class="tab-pane fade" id="documents">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Photo:</strong>
                            @if($driver->photo)
                            <a href="{{ asset('storage/'.$driver->photo) }}" target="_blank">View Photo</a>
                            @else <span class="text-danger">Not Uploaded</span> @endif
                        </li>
                        <li class="list-group-item">
                            <strong>Contract:</strong>
                            @if($driver->contract)
                            <a href="{{ asset('storage/'.$driver->contract) }}" target="_blank">View Contract</a>
                            @else <span class="text-danger">Not Uploaded</span> @endif
                        </li>
                    </ul>
                </div>

                {{-- BEHAVIOR HISTORY TAB --}}
                <div class="tab-pane fade" id="behavior">
                    <div class="d-flex justify-content-between">
                        <h5>Driver Behavior History</h5>
                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#addBehaviorModal-{{ $driver->id }}">
                            Add Behavior
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
                                <td>{{ $behavior->behavior_date?->format('d M Y') }}</td>
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
                                <td colspan="6" class="text-center text-muted">No behavior history found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="incidents">
                    <div class="d-flex justify-content-between">
                        <h5>Incident History</h5>

                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#addIncidentModal-{{ $driver->id }}">
                            Record Incident
                        </button>
                    </div>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Severity</th>
                                <th>Impact</th>
                                <th>Evidence</th>
                                <th>Reported By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($driver->incidents as $i)
                            <tr>
                                <td>{{ $i->incident_date }}</td>
                                <td>{{ ucfirst($i->type) }}</td>

                                <td>
                                    <span class="badge
                        @if($i->severity=='low') bg-info
                        @elseif($i->severity=='medium') bg-warning
                        @elseif($i->severity=='high') bg-danger
                        @else bg-dark @endif">
                                        {{ ucfirst($i->severity) }}
                                    </span>
                                </td>

                                <td>{{ $i->impact_score }}</td>

                                <td>
                                    @if($i->evidence)
                                    <a href="{{ asset('storage/'.$i->evidence) }}" target="_blank">
                                        View
                                    </a>
                                    @else
                                    <span class="text-muted">No Evidence</span>
                                    @endif
                                </td>

                                <td>{{ $i->reported_by }}</td>
                                <td>
                                    <span class="badge
 @if($i->approval_status=='pending') bg-warning
 @elseif($i->approval_status=='approved') bg-success
 @else bg-danger @endif">
                                        {{ ucfirst($i->approval_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($i->approval_status=='pending')
                                    <form method="POST"
                                        action="{{ route('admin.drivers.incidents.approve',$i) }}"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>

                                    <button class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectIncident{{ $i->id }}">
                                        Reject
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No incidents recorded</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDriverModal{{ $driver->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.update',$driver->id) }}" enctype="multipart/form-data"> @csrf @method('PUT') <div class="modal-header">
                    <h5 class="modal-title">Edit Driver</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"> <label>Name</label> <input type="text" name="names" class="form-control" value="{{ $driver->names }}" required> </div>
                        <div class="col-md-6"> <label>ID Number</label> <input type="text" name="ID_number" class="form-control" value="{{ $driver->ID_number }}" required> </div>
                        <div class="col-md-6"> <label>Driver License</label> <input type="text" name="driver_license" class="form-control" value="{{ $driver->driver_license }}" required> </div>
                        <div class="col-md-6"> <label>Phone</label> <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}" required> </div>
                        <div class="col-md-6"> <label>RSSB Number</label> <input type="text" name="rssb" class="form-control" value="{{ $driver->rssb }}"> </div>
                        <div class="col-md-6"> <label>Insurance</label> <select name="insurance" class="form-select">
                                <option>YES</option>
                                <option>NO</option>
                            </select> </div>
                        <div class="col-md-6"> <label>Company</label> <select name="company_id" class="form-control">
                                <option value="">--Select Company--</option> @foreach($companies as $company) <option value="{{ $company->id }}" {{ $driver->company_id==$company->id?'selected':'' }}>{{ $company->name }}</option> @endforeach
                            </select> </div>
                        <div class="col-md-6"> <label>Contract Type</label> <select name="contract_type" class="form-select">
                                <option value="3 month" {{ $driver->contract_type=='3 month'?'selected':'' }}>3 Month</option>
                                <option value="6 month" {{ $driver->contract_type=='6 month'?'selected':'' }}>6 Month</option>
                                <option value="12 month" {{ $driver->contract_type=='12 month'?'selected':'' }}>12 Month</option>
                                <option value="open ended" {{ $driver->contract_type=='open ended'?'selected':'' }}>Open Ended</option>
                            </select> </div>
                        <div class="col-md-6"> <label>Status</label> <select name="status" class="form-control">
                                <option value="active" {{ $driver->status=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ $driver->status=='inactive'?'selected':'' }}>Inactive</option>
                                <option value="suspended" {{ $driver->status=='suspended'?'selected':'' }}>Suspended</option>
                            </select> </div>
                        <div class="col-md-6"> <label>Photo</label> <input type="file" name="photo" class="form-control"> @if($driver->photo) <small>Current: <a href="{{ asset('storage/'.$driver->photo) }}" target="_blank">View</a></small> @endif </div>
                        <div class="col-md-6"> <label>Contract</label> <input type="file" name="contract" class="form-control"> @if($driver->contract) <small>Current: <a href="{{ asset('storage/'.$driver->contract) }}" target="_blank">View</a></small> @endif </div>
                    </div>
                </div>
                <div class="modal-footer"> <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button> <button class="btn btn-success">Update</button> </div>
            </form>
        </div>
    </div>
</div> <!-- Delete Driver Modal -->
<div class="modal fade" id="deleteDriverModal{{ $driver->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.destroy',$driver->id) }}"> @csrf @method('DELETE') <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirm Remove</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"> Are you sure you want to remove <b>{{ $driver->names }}</b>? </div>
                <div class="modal-footer"> <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-danger">Remove</button> </div>
            </form>
        </div>
    </div>
</div> @if($driver->status != 'approved') <div class="modal fade" id="approveDriverModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.drivers.approve', $driver->id) }}" method="POST"> @csrf <div class="modal-header">
                    <h5 class="modal-title">Confirm Approval</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p> Are you sure you want to <strong>approve</strong> this driver? </p>
                    <div class="alert alert-info"> ✔ Driver will become approved<br> ✔ Status will update immediately </div>
                </div>
                <div class="modal-footer"> <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-success">Yes, Approve</button> </div>
            </form>
        </div>
    </div>
</div> @endif
<!-- REPORT BEHAVIOR MODAL -->
<div class="modal fade" id="addBehaviorModal-{{ $driver->id }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.drivers.behaviors.store', $driver) }}" class="modal-content"> @csrf <input type="hidden" name="driver_id" value="{{ $driver->id }}">
            <div class="modal-header">
                <h5>Report Behavior – {{ $driver->names }}</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"> <!-- Behavior Category --> <select class="form-control mb-2" id="categorySelect-{{ $driver->id }}" required>
                    <option value="">Select Category</option> @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                </select> <!-- Behavior --> <select name="behavior_type_id" class="form-control mb-2" id="behaviorSelect-{{ $driver->id }}" required>
                    <option value="">Select Behavior</option> @foreach($categories as $cat) @foreach($cat->behaviorTypes as $b) <option value="{{ $b->id }}" data-cat="{{ $cat->id }}" data-category="{{ $b->category }}" data-score="{{ $b->default_score }}" style="display:none;"> {{ $b->name }} </option> @endforeach @endforeach
                </select> <!-- Severity --> <select name="severity" class="form-control mb-2" id="severitySelect-{{ $driver->id }}" required>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select> <!-- Behavior Date --> <input type="date" name="behavior_date" class="form-control mb-2" value="{{ date('Y-m-d') }}" required> <!-- Final Score (auto-filled) --> <input type="number" name="score" class="form-control mb-2" placeholder="Final Score (auto-calculated)" readonly> <!-- Description --> <textarea name="description" class="form-control" placeholder="Description (optional)"></textarea> </div>
            <div class="modal-footer"> <button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('categorySelect-{{ $driver->id }}');
        const behaviorSelect = document.getElementById('behaviorSelect-{{ $driver->id }}');
        const severitySelect = document.getElementById('severitySelect-{{ $driver->id }}');
        const scoreInput = behaviorSelect.form.score;
        const weights = {
            'low': 5,
            'medium': 10,
            'high': 20
        };

        function updateScore() {
            const defaultScore = parseFloat(behaviorSelect.selectedOptions[0]?.dataset.score || 0);
            const severityScore = weights[severitySelect.value] || 0;
            let finalScore = defaultScore + severityScore;
            const category = behaviorSelect.selectedOptions[0]?.dataset.category || 'positive';
            if (category === 'negative') {
                finalScore = -Math.abs(finalScore);
            }
            scoreInput.value = finalScore;
        }
        categorySelect.addEventListener('change', function() {
            const selectedCat = this.value;
            behaviorSelect.value = '';
            scoreInput.value = '';
            behaviorSelect.querySelectorAll('option').forEach(opt => {
                if (!opt.value) return;
                opt.style.display = (opt.dataset.cat === selectedCat) ? 'block' : 'none';
            });
        });
        behaviorSelect.addEventListener('change', updateScore);
        severitySelect.addEventListener('change', updateScore);
    });
</script>

<div class="modal fade" id="rejectIncident{{ $i->id }}">
    <div class="modal-dialog">
        <form class="modal-content"
            method="POST"
            action="{{ route('admin.drivers.incidents.reject',$i) }}">
            @csrf

            <div class="modal-header">
                <h5>Reject Incident</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <textarea name="rejection_reason"
                    class="form-control"
                    placeholder="Reason for rejection"
                    required></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger">Reject</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="addIncidentModal-{{ $driver->id }}">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('admin.drivers.incidents.store',$driver) }}"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Record Incident – {{ $driver->names }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <select name="type" class="form-control mb-2" required>
                    <option value="">Select Incident Type</option>
                    <option value="accident">Accident</option>
                    <option value="traffic_violation">Traffic Violation</option>
                    <option value="vehicle_damage">Vehicle Damage</option>
                    <option value="complaint">Complaint</option>
                    <option value="other">Other</option>
                </select>

                <select name="severity" class="form-control mb-2">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>

                <input type="date" name="incident_date"
                    value="{{ date('Y-m-d') }}"
                    class="form-control mb-2" required>

                <input type="text" name="location"
                    class="form-control mb-2"
                    placeholder="Location (optional)">
                <hr>
                <h6>Root Cause & Responsibility</h6>

                <select name="root_cause_category" class="form-control mb-2">
                    <option value="">Select Root Cause</option>
                    <option value="human_error">Human Error</option>
                    <option value="mechanical_failure">Mechanical Failure</option>
                    <option value="environment">Environment</option>
                    <option value="policy_violation">Policy Violation</option>
                    <option value="training_gap">Training Gap</option>
                    <option value="fatigue">Fatigue</option>
                    <option value="other">Other</option>
                </select>

                <textarea name="root_cause_details"
                    class="form-control mb-2"
                    placeholder="Explain what caused this incident..."></textarea>

                <select name="responsibility" class="form-control mb-2">
                    <option value="driver">Driver</option>
                    <option value="company">Company</option>
                    <option value="third_party">Third Party</option>
                    <option value="shared">Shared</option>
                    <option value="unknown">Unknown</option>
                </select>

                <textarea name="description"
                    class="form-control mb-2"
                    placeholder="Incident details..."></textarea>

                <input type="file" name="evidence" class="form-control">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>

@endsection