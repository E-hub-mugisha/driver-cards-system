@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>
        Behavior History —
        <span class="fw-bold">{{ $driver->names }}</span>
    </h5>

    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
        ← Back to Drivers
    </a>
</div>

<div class="card">
    <div class="card-header">
        Total Records: {{ $behaviors->total() }}
    </div>

    <table class="table table-sm mb-0">
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
            @forelse($behaviors as $row)
            <tr>
                <td>{{ $row->created_at?->format('d M Y') }}</td>
                <td>{{ $row->behaviorType->behaviorCategory->name ?? 'N/A' }}</td>
                <td>{{ $row->behaviorType->name }}</td>
                <td>
                    <span class="badge
                        @if($row->severity === 'low') bg-info
                        @elseif($row->severity === 'medium') bg-warning
                        @else bg-danger @endif">
                        {{ ucfirst($row->severity) }}
                    </span>
                </td>
                <td>{{ $row->score }}</td>
                <td>{{ optional($row->reporter)->name ?? 'System' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No behaviors reported for this driver
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-2">
        {{ $behaviors->links() }}
    </div>
</div>

@endsection
