@extends('layouts.app')

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

    <form action="{{ route('company.driver.behaviors.sendEmail', $driver->id) }}" method="POST" class="d-flex gap-2">
        @csrf
        <input type="email" name="email" placeholder="Enter email" class="form-control" required>
        <button class="btn btn-success">Send Report</button>
    </form>

</div>

<div class="card">
    <div class="card-header">
        Total Records: {{ $driver->behaviors->count() }}
    </div>

    <table class="table table-sm mb-0">
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