@extends('layouts.app')
@section('title','Driver Behavior Reports')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <h5 class="mb-3">Company: {{ $company->name ?? 'N/A' }}</h5>

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
                        <td><span class="badge bg-danger">{{ $driver->behaviors_count }}</span></td>
                        <td>
                            @if($driver->behaviors_count > 0)
                            <a href="{{ route('company.driver.behaviors', $driver->id) }}" class="btn btn-sm btn-info">
                                View Details
                            </a>
                            @else
                            <span class="text-muted">No Records</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No drivers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection