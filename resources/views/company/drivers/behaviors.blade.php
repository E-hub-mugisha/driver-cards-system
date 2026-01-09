@extends('layouts.app')
@section('title', 'Driver Behavior History')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>
        Behavior History —
        <span class="fw-bold">{{ $driver->names }}</span>
    </h5>

    <a href="#" class="btn btn-secondary">
        ← Back to Drivers
    </a>

    <a href="{{ route('company.driver.behaviors.download', $driver->id) }}" class="btn btn-primary">
        <em class="icon ni ni-download"></em> Download PDF
    </a>

    <button class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#sendBehaviorReportModal{{ $driver->id }}">
        Send Report
    </button>

    <div class="modal fade"
        id="sendBehaviorReportModal{{ $driver->id }}"
        tabindex="-1"
        aria-labelledby="sendBehaviorReportLabel{{ $driver->id }}"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('company.driver.behaviors.sendEmail', $driver->id) }}"
                    method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="sendBehaviorReportLabel{{ $driver->id }}">
                            Send Behavior Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Recipient Email</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter email address"
                                required>
                        </div>

                        <p class="text-muted small mb-0">
                            The behavior report for this driver will be generated and sent as a PDF.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            Send Report
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


</div>

<div class="card">
    <div class="card-header">
        Total Records: {{ $driver->behaviors->count() }}
    </div>

    <table class="table  mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Behavior Type</th>
                <th>Category</th>
                <th>Description</th>
                <th>Reported By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($driver->behaviors as $index => $behavior)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $behavior->behaviorType->name ?? 'N/A' }}</td>
                <td>{{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }}</td>
                <td>{{ $behavior->description ?? 'N/A' }}</td>
                <td>{{ optional($behavior->reporter)->name ?? 'System' }}</td>
                <td>{{ $behavior->created_at?->format('d M Y - h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No behavior records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection