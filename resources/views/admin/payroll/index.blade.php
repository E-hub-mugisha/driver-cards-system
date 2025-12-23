@extends('layouts.app')

@section('title','Payroll Processing')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Payroll Processing</h4>
        {{-- Generate Payroll Modal Trigger --}}
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generatePayrollModal">
            Generate Payroll
        </button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Payroll Table --}}
    <div class="card">
        <div class="card-header">
            <strong>Payroll Records</strong>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Company</th>
                        <th>Month</th>
                        <th>Gross Salary</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                        @foreach($payroll->details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->driver->names }}</td>
                                <td>{{ $payroll->company->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($payroll->month)->format('M Y') }}</td>
                                <td>${{ number_format($detail->gross_salary, 2) }}</td>
                                <td>${{ number_format($detail->net_salary, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($payroll->status=='pending') bg-warning
                                        @elseif($payroll->status=='approved') bg-success
                                        @else bg-danger @endif">
                                        {{ ucfirst($payroll->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($payroll->status=='pending')
                                        <form method="POST" action="{{ route('admin.payroll.approve', $payroll) }}" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectPayroll{{ $payroll->id }}">
                                            Reject
                                        </button>
                                    @endif

                                    {{-- View Payslip --}}
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewPayslip{{ $payroll->id }}">
                                        Payslip
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No payroll records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Generate Payroll Modal --}}
<div class="modal fade" id="generatePayrollModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.payroll.process') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Generate Payroll</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Select Company</label>
                    <select name="company_id" class="form-select" required>
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Month</label>
                    <input type="month" name="month" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Process Payroll</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Payroll Modals --}}
@foreach($payrolls as $payroll)
<div class="modal fade" id="rejectPayroll{{ $payroll->id }}">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" action="{{ route('admin.payroll.reject', $payroll) }}">
            @csrf
            <div class="modal-header">
                <h5>Reject Payroll</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea name="reason" class="form-control" placeholder="Reason for rejection" required></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger">Reject</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- Payslip Modals --}}
@foreach($payrolls as $payroll)
<div class="modal fade" id="viewPayslip{{ $payroll->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Payslip - {{ $payroll->company->name }} ({{ \Carbon\Carbon::parse($payroll->month)->format('M Y') }})</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Driver</th>
                            <th>Base Pay</th>
                            <th>Bonus</th>
                            <th>Deductions</th>
                            <th>Gross Salary</th>
                            <th>Net Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payroll->details as $detail)
                        <tr>
                            <td>{{ $detail->driver->names }}</td>
                            <td>${{ number_format($detail->base_amount, 2) }}</td>
                            <td>${{ number_format($detail->bonus_amount, 2) }}</td>
                            <td>${{ number_format($detail->penalty_amount + $detail->tax_deduction + $detail->rssb_deduction, 2) }}</td>
                            <td>${{ number_format($detail->gross_salary, 2) }}</td>
                            <td>${{ number_format($detail->net_salary, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
