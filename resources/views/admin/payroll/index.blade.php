@extends('layouts.app')
@section('title','Payroll Processing')

@section('content')
<div class="container">

    {{-- ================== Payroll History Filter ================== --}}
    <h4>Filter Payroll History</h4>
    <form method="GET" action="{{ route('admin.payroll.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <label>Company</label>
            <select name="company_id" class="form-select">
                <option value="">-- All Companies --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ request('company_id')==$company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Payroll Month</label>
            <input type="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- ================== Payroll History Table ================== --}}
    <h4>Payroll History</h4>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Month</th>
                        <th>Status</th>
                        <th>Processed By</th>
                        <th>Approved By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payroll->company->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($payroll->month)->format('M Y') }}</td>
                        <td>
                            <span class="badge
                                @if($payroll->status=='pending') bg-warning
                                @elseif($payroll->status=='completed') bg-info
                                @elseif($payroll->status=='approved') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </td>
                        <td>{{ $payroll->processedBy?->name ?? '-' }}</td>
                        <td>{{ $payroll->approvedBy?->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.payroll.review', [
                                'company_id'=>$payroll->company_id,
                                'month'=>\Carbon\Carbon::parse($payroll->month)->format('Y-m')
                            ]) }}" class="btn btn-sm btn-primary">
                                Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No payroll records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
