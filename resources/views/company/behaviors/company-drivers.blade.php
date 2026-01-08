@extends('layouts.app')
@section('title', 'Driver Behaviors')
@section('content')
<div class="container mt-4">

    <h4>Select Company to View Driver Behaviors</h4>

    <div class="card mt-3">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.company.behavior.page') }}">
                <div class="row align-items-end">

                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <select name="company_id" class="form-control" required>
                            <option value="">-- Select Company --</option>

                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">View Drivers</button>
                    </div>

                </div>
            </form>

            <hr>

            @if($selectedCompany)

                <h5 class="mb-3">Company: {{ $selectedCompany->name }}</h5>

                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Driver</th>
                            <th>Behaviors Reported</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($drivers as $index => $driver)

                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $driver->names }}</td>

                                <td>
                                    <span class="badge bg-danger">
                                        {{ $driver->behaviors_count }} Reports
                                    </span>
                                </td>

                                <td>
                                    @if($driver->behaviors_count > 0)
                                        <button class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#behaviorModal{{ $driver->id }}">
                                            View Details
                                        </button>
                                    @else
                                        <span class="text-muted">No Records</span>
                                    @endif
                                </td>
                            </tr>


                            <!-- ================= BEHAVIOR MODAL ================= -->
                            <div class="modal fade" id="behaviorModal{{ $driver->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Behavior Records - {{ $driver->names }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            @foreach($driver->behaviors as $behavior)
                                                <div class="border rounded p-2 mb-2">
                                                    <strong>Title:</strong> {{ $behavior->behaviorType->behaviorCategory->name ?? 'N/A' }} <br>
                                                    <strong>Type:</strong> {{ $behavior->behaviorType->name ?? 'N/A' }} <br>
                                                    <strong>Description:</strong>
                                                    {{ $behavior->description ?? 'No description' }} <br>
                                                    <strong>Reported by:</strong>{{ optional($behavior->reporter)->name ?? 'System' }}<br>
                                                    <small class="text-muted">
                                                        {{ $behavior->created_at?->format('d M Y - h:i A') }}
                                                    </small>
                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ================================================== -->

                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No drivers found for this company.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            @else
                <div class="text-muted">
                    Select a company to view drivers.
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
