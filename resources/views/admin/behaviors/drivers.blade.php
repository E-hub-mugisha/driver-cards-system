@extends('layouts.app')
@section('title', 'Drivers with behavior')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Drivers with behavior:
                            <span class="badge bg-primary">{{ $behavior->name }}</span>
                        </h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="{{ route('admin.behaviors.index') }}" class="btn btn-secondary rounded-5">
                                <em class="icon ni ni-arrow-left"></em> Back to Behaviors
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block nk-block-lg p-4 bg-white rounded-5 mt-5">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <div class="nk-block-des">
                                <h5>Total Drivers: {{ $drivers->total() }}</h5>
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col">#</th>
                                            <th class="nk-tb-col">Driver</th>
                                            <th class="nk-tb-col">License</th>
                                            <th class="nk-tb-col">Company</th>
                                            <th class="nk-tb-col">Reported On</th>
                                            <th class="nk-tb-col">Severity</th>
                                            <th class="nk-tb-col">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($drivers as $row)
                                        <tr class="nk-tb-item">
                                            <td class="nk-tb-col">{{ $loop->iteration }}</td>
                                            <td class="nk-tb-col">{{ $row->driver->names }}</td>
                                            <td class="nk-tb-col">{{ $row->driver->driver_license }}</td>
                                            <td class="nk-tb-col">{{ $row->driver->company->name }}</td>
                                            <td class="nk-tb-col">{{ $row->created_at?->format('d M Y') }}</td>
                                            <td class="nk-tb-col">
                                                <span class="@if($row->severity === 'low') text-info @elseif($row->severity === 'medium') text-warning                        @else text-danger @endif">
                                                    <em class="icon ni ni-alert"></em> {{ ucfirst($row->severity) }}
                                                </span>
                                            </td>
                                            <td class="nk-tb-col">{{ $row->score }}</td>
                                        </tr>
                                        @empty
                                        <tr class="nk-tb-item">
                                            <td colspan="5" class="text-center text-muted">
                                                No drivers found for this behavior
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection