@extends('layouts.app')
@section('title', 'Company Reports')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <div class="nk-block-head nk-block-head-sm mb-4">
                <h3 class="nk-block-title page-title">Reporting & Analytics - {{ $company->name }}</h3>
            </div>

            {{-- KPI Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5>Total Drivers</h5>
                            <p class="fs-4">{{ $totalDrivers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5>Avg Performance Score</h5>
                            <p class="fs-4">{{ $avgScore ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5>High Risk Drivers</h5>
                            <p class="fs-4">{{ $highRiskDrivers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5>Total Incidents</h5>
                            <p class="fs-4">{{ $totalIncidents }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================== CHARTS ================== --}}
            <div class="row g-4 mb-4">
                <div class="col-md-12 mt-3">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="nk-block">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <h5>Monthly Incidents</h5>
                                                <canvas id="monthlyIncidentsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <h5>Behavior Severity Distribution</h5>

                                                <canvas id="behaviorSeverityChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="nk-block">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <h6>Monthly Payroll (Net Salary)</h6>
                                                <canvas id="payrollChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <h6>Monthly Penalties</h6>
                                                <canvas id="penaltyChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6>Driver vs Behavior Trends (Last 6 Months)</h6>
                            <canvas id="driversBehaviorChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const payrollChart = new Chart(document.getElementById('payrollChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Net Salary (USD)',
                data: @json($netSalaries),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    });

    const penaltyChart = new Chart(document.getElementById('penaltyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlyPenalties -> keys()),
            datasets: [{
                label: 'Penalties',
                data: @json($monthlyPenalties -> values()),
                backgroundColor: '#e74a3b'
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<script>
    const ctx = document.getElementById('driversBehaviorChart').getContext('2d');
    const driversBehaviorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                    label: 'Drivers Added',
                    data: @json($driversData),
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: '#4e73df',
                    borderWidth: 1
                },
                {
                    label: 'Behaviors Reported',
                    data: @json($behaviorsData),
                    backgroundColor: 'rgba(231, 74, 59, 0.7)',
                    borderColor: '#e74a3b',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
</script>

<script>
    // ================== Monthly Incidents Chart ==================
    const monthlyCtx = document.getElementById('monthlyIncidentsChart').getContext('2d');
    const monthlyIncidentsChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyIncidents -> pluck('month')),
            datasets: [{
                label: 'Incidents',
                data: @json($monthlyIncidents -> pluck('total')),
                backgroundColor: 'rgba(220,53,69,0.7)',
                borderColor: 'rgba(220,53,69,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // ================== Behavior Severity Chart ==================
    const behaviorCtx = document.getElementById('behaviorSeverityChart').getContext('2d');
    const behaviorSeverityChart = new Chart(behaviorCtx, {
        type: 'doughnut',
        data: {
            labels: @json($behaviorStats -> pluck('severity') -> map(fn($s) => ucfirst($s))),
            datasets: [{
                label: 'Behaviors',
                data: @json($behaviorStats -> pluck('total')),
                backgroundColor: [
                    '#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection