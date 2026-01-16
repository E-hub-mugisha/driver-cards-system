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
                                <a href="{{ route('admin.driver.behaviors', $driver->id) }}" class="btn btn-sm btn-info">
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

            @else
                <div class="text-muted">
                    Select a company to view drivers.
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
