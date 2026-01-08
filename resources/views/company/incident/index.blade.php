@extends('layouts.app')
@section('title','Driver Incident Reports')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <h5 class="mb-3">Company: {{ $company->name ?? 'N/A' }}</h5>
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
                    @forelse($driver->incidents as $incident)
                    <tr>
                        <td>{{ $incident->incident_date }}</td>
                        <td>{{ ucfirst($incident->type) }}</td>

                        <td>
                            <span class="badge
@if($incident->severity=='low') bg-info
@elseif($incident->severity=='medium') bg-warning
@elseif($incident->severity=='high') bg-danger
@else bg-dark @endif">
                                {{ ucfirst($incident->severity) }}
                            </span>
                        </td>

                        <td>{{ $incident->impact_score }}</td>

                        <td>
                            @if($incident->evidence)
                            <a href="{{ asset('storage/'.$incident->evidence) }}" target="_blank">View</a>
                            @else
                            <span class="text-muted">No Evidence</span>
                            @endif
                        </td>

                        <td>{{ $incident->reported_by }}</td>

                        <td>
                            <span class="badge
@if($incident->approval_status=='pending') bg-warning
@elseif($incident->approval_status=='approved') bg-success
@else bg-danger @endif">
                                {{ ucfirst($incident->approval_status) }}
                            </span>
                        </td>

                        <td>
                            @if($incident->approval_status=='pending')
                            <form method="POST"
                                action="{{ route('company.incidents.approve',$incident) }}"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>

                            <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectIncident{{ $incident->id }}">
                                Reject
                            </button>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal MUST be inside the loop --}}
                    <div class="modal fade" id="rejectIncident{{ $incident->id }}">
                        <div class="modal-dialog">
                            <form class="modal-content"
                                method="POST"
                                action="{{ route('company.incidents.reject',$incident) }}">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No incidents recorded
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addIncidentModal-{{ $driver->id }}">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('company.incidents.store',$driver) }}"
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
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>

@endsection