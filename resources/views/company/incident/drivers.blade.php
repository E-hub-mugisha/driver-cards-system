@extends('layouts.app')
@section('title','Driver Incident Reports')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <h5 class="mb-3">Company: {{ $company->name ?? 'N/A' }}</h5>
            <p>Total Drivers with Incidents: <strong>{{ $totalDrivers ?? 0 }}</strong></p>

            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Incidents Reported</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $index => $driver)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $driver->names ?? 'Unknown' }}</td>

                            <td>
                                <span class="badge bg-danger">
                                    {{ $driver->incidents_count ?? 0 }} Incident{{ $driver->incidents_count != 1 ? 's' : '' }}
                                </span>
                            </td>

                            <td>
                                @if(($driver->incidents_count ?? 0) > 0)
                                    <button class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#incidentModal{{ $driver->id }}">
                                        Quick Details
                                    </button>
                                    <a href="{{ route('company.drivers.incidents.index', $driver->id) }}" class="btn btn-sm btn-primary">
                                        Full Details
                                    </a>
                                @else
                                    <span class="text-muted">No Records</span>
                                @endif
                            </td>
                        </tr>

                        <!-- ================= INCIDENT MODAL ================= -->
                        <div class="modal fade" id="incidentModal{{ $driver->id }}" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Incident Records - {{ $driver->names ?? 'Unknown Driver' }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        @forelse($driver->incidents ?? [] as $incident)
                                            <div class="border rounded p-3 mb-3">
                                                <strong>Type:</strong> {{ $incident->type ?? 'N/A' }} <br>
                                                <strong>Severity:</strong> {{ ucfirst($incident->severity ?? 'N/A') }} <br>
                                                <strong>Date:</strong> {{ $incident->incident_date?->format('d M Y') ?? 'N/A' }} <br>
                                                <strong>Location:</strong> {{ $incident->location ?? 'N/A' }} <br>
                                                <strong>Description:</strong> {{ $incident->description ?? 'N/A' }} <br>
                                                <strong>Evidence:</strong>
                                                @if($incident->evidence)
                                                    <a href="{{ asset('storage/'.$incident->evidence) }}" target="_blank">View</a>
                                                @else
                                                    N/A
                                                @endif
                                                <br>
                                                <strong>Impact Score:</strong> {{ $incident->impact_score ?? 'N/A' }} <br>
                                                <strong>Root Cause Category:</strong> {{ $incident->root_cause_category ?? 'N/A' }} <br>
                                                <strong>Root Cause Details:</strong> {{ $incident->root_cause_details ?? 'N/A' }} <br>
                                                <strong>Responsibility:</strong> {{ $incident->responsibility ?? 'N/A' }} <br>
                                                <strong>Approval Status:</strong> {{ ucfirst($incident->approval_status ?? 'Pending') }} <br>
                                                @if($incident->approval_status === 'rejected')
                                                    <strong>Rejection Reason:</strong> {{ $incident->rejection_reason ?? 'N/A' }} <br>
                                                @endif
                                                <strong>Reported by:</strong> {{ optional($incident->reporter)->name ?? 'System' }} <br>
                                                @if($incident->approved_at)
                                                    <strong>Approved At:</strong> {{ $incident->approved_at?->format('d M Y - h:i A') }}
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-muted">No incident records found.</p>
                                        @endforelse
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- ================================================== -->

                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No drivers found with incidents.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
