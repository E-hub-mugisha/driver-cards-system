@extends('layouts.app')

@section('title', 'Reporting & Analytics')

@section('content')
<div class="container-fluid py-3">

    <h3 class="mb-3">📊 Reporting & Analytics Dashboard</h3>

    <!-- ================= KPI CARDS ================= -->
    <div class="row">

        <div class="col-md-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <h6>Total Drivers</h6>
                    <h3 class="fw-bold">{{ $totalDrivers ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h6>Average Performance Score</h6>
                    <h3 class="fw-bold">{{ round($avgScore ?? 0,1) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-danger">
                <div class="card-body">
                    <h6>Total Incidents</h6>
                    <h3 class="fw-bold">{{ $totalIncidents ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <h6>High Risk Drivers</h6>
                    <h3 class="fw-bold">{{ $highRiskDrivers ?? 0 }}</h3>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <!-- ================= CHART ROW 1 ================= -->
    <div class="row mt-3">

        <!-- Monthly Incidents -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Monthly Incident Trend</div>
                <div class="card-body">
                    <canvas id="monthlyIncidentsChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Behavior Severity -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Behavior Severity Distribution</div>
                <div class="card-body">
                    <canvas id="behaviorSeverityChart" height="120"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= CHART ROW 2 ================= -->
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Incident Status Breakdown</div>
                <div class="card-body">
                    <canvas id="incidentStatusChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Responsibility Allocation</div>
                <div class="card-body">
                    <canvas id="responsibilityChart" height="120"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ================= DATA FROM CONTROLLER =================
    const monthlyLabels = @json($monthlyIncidents->pluck('month') ?? []);
    const monthlyCounts = @json($monthlyIncidents->pluck('total') ?? []);

    const severityLabels = @json($behaviorStats->pluck('severity') ?? []);
    const severityCounts = @json($behaviorStats->pluck('total') ?? []);

    const incidentStatus = @json($incidentStatus ?? ['open'=>0,'closed'=>0,'pending'=>0]);
    const responsibilityData = @json($responsibilityStats ?? [
        'driver' => 0,
        'company' => 0,
        'third_party' => 0
    ]);

    // ================= MONTHLY INCIDENTS =================
    new Chart(document.getElementById('monthlyIncidentsChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Incidents',
                data: monthlyCounts,
                borderWidth: 3,
                fill: false,
                tension: .3
            }]
        }
    });

    // ================= BEHAVIOR SEVERITY =================
    new Chart(document.getElementById('behaviorSeverityChart'), {
        type: 'bar',
        data: {
            labels: severityLabels,
            datasets: [{
                label: 'Count',
                data: severityCounts,
                borderWidth: 1
            }]
        }
    });

    // ================= INCIDENT STATUS =================
    new Chart(document.getElementById('incidentStatusChart'), {
        type: 'pie',
        data: {
            labels: ['Open','Closed','Pending'],
            datasets: [{
                data: [
                    incidentStatus.open ?? 0,
                    incidentStatus.closed ?? 0,
                    incidentStatus.pending ?? 0
                ]
            }]
        }
    });

    // ================= RESPONSIBILITY =================
    new Chart(document.getElementById('responsibilityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Driver','Company','Third Party'],
            datasets: [{
                data: [
                    responsibilityData.driver ?? 0,
                    responsibilityData.company ?? 0,
                    responsibilityData.third_party ?? 0
                ]
            }]
        }
    });

</script>
@endsection
