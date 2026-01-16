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

    <a href="{{ route('admin.driver.behaviors.download', $driver->id) }}" class="btn btn-primary">
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

                <form action="{{ route('admin.driver.behaviors.sendEmail', $driver->id) }}"
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

<div class="card p-4">
    <div class="card-title">
        Total Records: {{ $driver->behaviors->count() }}
    </div>

    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
        <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col">#</th>
                <th class="nk-tb-col">Behavior Type</th>
                <th class="nk-tb-col">Category</th>
                <th class="nk-tb-col">Description</th>
                <th class="nk-tb-col">Reported By</th>
                <th class="nk-tb-col">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($driver->behaviors as $index => $behavior)
            <tr class="nk-tb-item">
                <td class="nk-tb-col">{{ $index + 1 }}</td>
                <td class="nk-tb-col">{{ $behavior->behaviorType->name ?? 'N/A' }}</td>
                <td class="nk-tb-col">{{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }}</td>
                <td class="nk-tb-col">{{ $behavior->description ?? 'N/A' }}</td>
                <td class="nk-tb-col">{{ optional($behavior->reporter)->name ?? 'System' }}</td>
                <td class="nk-tb-col">{{ $behavior->created_at?->format('d M Y - h:i A') }}</td>
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