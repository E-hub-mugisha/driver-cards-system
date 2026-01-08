@extends('layouts.app')
@section('title', 'Payroll Dashboard - ' . $company->name)
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            {{-- Header --}}
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title">Payroll Dashboard - {{ $company->name }}</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <!-- ================== Generate Payroll Button ================== -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generatePayrollModal">
                            <em class="icon ni ni-calender-date"></em> Generate Payroll
                        </button>
                        <!-- ================== Generate Payroll Modal ================== -->
                        <div class="modal fade" id="generatePayrollModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('company.payroll.generate') }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Generate Payroll</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="month" class="form-label">Select Month</label>
                                            <input type="month" name="month" class="form-control" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                <em class="icon ni ni-calender-date"></em> Generate Payroll
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================== Date Filter ================== --}}
            <div class="card mb-4 p-3">

                <!-- ================== Filter Form ================== -->
                <form method="GET" action="{{ route('company.payroll.index') }}" class="mb-3">
                    <div class="row mb-3 align-items-end g-3">
                        <input type="hidden" name="company_id" value="{{ $company->id }}">

                    <div class="col-md-4">
                        <label for="month" class="form-label">Select Month</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('company.payroll.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div></form>

            </div>

            {{-- ================== Monthly Payroll Charts ================== --}}
            @if($payrolls->isNotEmpty())
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card p-3">
                        <h5 class="mb-3">Monthly Payroll Summary</h5>
                        <canvas id="payrollChart"></canvas>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3">
                        <h5 class="mb-3">Monthly Penalties</h5>
                        <canvas id="penaltyChart"></canvas>
                    </div>
                </div>
            </div>
            @endif

            {{-- ================== Payroll Table ================== --}}
            <div class="card mb-4 p-3">
                <div class="card-header">
                    <h5>Payroll Records for {{ $company->name }}</h5>
                </div>
                <div class="card-body">
                    @if($payrolls->isEmpty())
                    <p class="text-center text-muted">No payroll records found.</p>
                    @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Month</th>
                                <th>Status</th>
                                <th>Processed By</th>
                                <th>Approved By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrolls as $index => $payroll)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payroll->month?->format('M Y') ?? 'N/A' }}</td>
                                <td>
                                    @if($payroll->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                    @elseif($payroll->status == 'approved')
                                    <span class="badge bg-primary">Approved</span>
                                    @else
                                    <span class="badge bg-warning">{{ ucfirst($payroll->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $payroll->processedBy?->name ?? 'N/A' }}</td>
                                <td>{{ $payroll->approvedBy?->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('company.payroll.review', ['month' => $payroll->month->format('Y-m')]) }}" class="btn btn-sm btn-info">Review</a>
                                    @if($payroll->status != 'approved')
                                    <form action="{{ route('company.payroll.approve', $payroll->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    @endif
                                    <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deletePayrollModal{{ $payroll->id }}">
                                        Delete
                                    </button>
                                    <!-- Delete Payroll Modal -->
                                    <!-- Delete Payroll Modal -->
                                    <div class="modal fade" id="deletePayrollModal{{ $payroll->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Payroll - {{ $payroll->month?->format('M Y') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>To confirm deletion, an OTP has been sent to your email. Enter it below:</p>
                                                    <input type="text" class="form-control mb-2" id="otpInput{{ $payroll->id }}" placeholder="Enter OTP">
                                                    <small class="text-muted">OTP expires in 5 minutes.</small>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" onclick="confirmDeletePayroll({{ $payroll->id }})">Delete Payroll</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="otpStatus{{ $payroll->id }}" class="text-success ms-2"></span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


{{-- ================== Charts Scripts ================== --}}


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($payrolls->isNotEmpty())
    // Prepare payroll chart data
    const months = @json($payrolls->pluck('month')->map(fn($m) => $m?->format('M Y')));
    const grossData = @json($payrolls->map(fn($p) => $p->details->sum('gross_salary')));
    const netData = @json($payrolls->map(fn($p) => $p->details->sum('net_salary')));
    const penaltyData = @json($payrolls->map(fn($p) => $p->details->sum('penalty_amount')));

    // Payroll Summary Chart
    const ctxPayroll = document.getElementById('payrollChart').getContext('2d');
    new Chart(ctxPayroll, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Gross Salary',
                    data: grossData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                },
                {
                    label: 'Net Salary',
                    data: netData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Monthly Payroll Summary' }
            }
        }
    });

    // Penalty Chart
    const ctxPenalty = document.getElementById('penaltyChart').getContext('2d');
    new Chart(ctxPenalty, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Penalties',
                    data: penaltyData,
                    borderColor: 'rgba(255, 99, 132, 0.8)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Monthly Penalties' }
            }
        }
    });
    @endif
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Detect modal show
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            const payrollId = this.id.replace('deletePayrollModal', '');
            generateOtp(payrollId);
        });
    });
});

function generateOtp(payrollId) {
    fetch(`/company/payroll/send-otp/${payrollId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            console.log('OTP sent:', data.otp); // For testing
            alert('OTP has been sent to your email.');
        }
    });
}

function confirmDeletePayroll(payrollId) {
    const otp = document.getElementById(`otpInput${payrollId}`).value;

    fetch(`/company/payroll/delete/${payrollId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ otp })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Payroll deleted successfully.');
            location.reload();
        } else {
            alert(data.message);
        }
    });
}
</script>
@endsection