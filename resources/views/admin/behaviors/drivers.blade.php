@extends('layouts.app')
@section('title', 'Drivers with behavior')
@section('content')

<div class="container">
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- TITLE -->
            <h2 class="az-content-title mb-0">Drivers with behavior:
                <span class="badge bg-primary">{{ $behavior->name }}</span>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.behaviors.index') }}" class="btn btn-secondary">
                    ← Back to Behaviors
                </a>
            </div>
        </div>

        <div class="card mt-4 shadow-sm py-3 px-4">
            <div class="card-header mb-3">
                Total Drivers: {{ $drivers->total() }}
            </div>

            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Reported On</th>
                        <th>Severity</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->driver->names }}</td>
                        <td>{{ $row->created_at?->format('d M Y') }}</td>
                        <td>
                            <span class="badge
                        @if($row->severity === 'low') bg-info
                        @elseif($row->severity === 'medium') bg-warning
                        @else bg-danger @endif">
                                {{ ucfirst($row->severity) }}
                            </span>
                        </td>
                        <td>{{ $row->score }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No drivers found for this behavior
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-2">
                {{ $drivers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection