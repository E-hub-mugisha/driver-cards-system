@extends('layouts.app')
@section('title','Driver Behavior Reports')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="card p-4">
                <h5 class="mb-3">Company: {{ $company->name ?? 'N/A' }}</h5>

                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col">#</th>
                            <th class="nk-tb-col">Driver</th>
                            <th class="nk-tb-col">Behaviors Reported</th>
                            <th class="nk-tb-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($drivers as $index => $driver)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col">{{ $index + 1 }}</td>
                            <td class="nk-tb-col">{{ $driver->names }}</td>
                            <td class="nk-tb-col"><span class="badge bg-danger">Reported {{ $driver->behaviors_count }}</span></td>
                            <td class="nk-tb-col">
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
</div>

@endsection