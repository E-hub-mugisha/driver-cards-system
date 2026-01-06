@extends('layouts.app')

@section('title', 'Reporting & Analytics')

@section('content')
<div class="container-fluid py-3">

    <h3 class="mb-3">📊 Reporting & Analytics Dashboard</h3>

    <!-- ================= FILTERS ================= -->
    <form method="GET" action="{{ route('reports.index') }}" class="card shadow-sm rounded-5 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <!-- Company -->
                <div class="col-md-3">
                    <label class="fw-bold">Company</label>
                    <select name="company_id" class="form-select rounded-5">
                        <option value="">All Companies</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div class="col-md-2">
                    <label class="fw-bold">From</label>
                    <input type="date" name="from" class="form-control rounded-5"
                           value="{{ request('from') }}">
                </div>

                <!-- End Date -->
                <div class="col-md-2">
                    <label class="fw-bold">To</label>
                    <input type="date" name="to" class="form-control rounded-5"
                           value="{{ request('to') }}">
                </div>

                <!-- Buttons -->
                <div class="col-md-5 text-end">
                    <button class="btn btn-primary rounded-5">
                        <i class="ti ti-filter"></i> Apply Filter
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary rounded-5">
                        <i class="ti ti-arrows-cross"></i> Reset
                    </a>
                </div>

            </div>
        </div>
    </form>

    <!-- ================= KPI CARDS ================= -->
    <div class="row">

        @php
            $cards = [
                ['title'=>'Total Drivers','value'=>$totalDrivers,'color'=>'primary'],
                ['title'=>'Avg Performance','value'=>round($avgScore,1),'color'=>'success'],
                ['title'=>'Total Incidents','value'=>$totalIncidents,'color'=>'danger'],
                ['title'=>'High Risk Drivers','value'=>$highRiskDrivers,'color'=>'warning'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm bg-{{ $card['color'] }} text-white rounded-5">
                <div class="card-body">
                    <h6 class="text-white">{{ $card['title'] }}</h6>
                    <h3 class="fw-bold">{{ $card['value'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <hr>

    <!-- ================= CHARTS ================= -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm rounded-5">
                <div class="card-header bg-white fw-bold">Monthly Incident Trend</div>
                <div class="card-body">
                    <canvas id="monthlyIncidentsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm rounded-5">
                <div class="card-header bg-white fw-bold">Behavior Severity</div>
                <div class="card-body">
                    <canvas id="behaviorSeverityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm rounded-5">
                <div class="card-header bg-white fw-bold">Incident Status</div>
                <div class="card-body">
                    <canvas id="incidentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm rounded-5">
                <div class="card-header bg-white fw-bold">Responsibility</div>
                <div class="card-body">
                    <canvas id="responsibilityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const monthlyLabels = @json($monthlyIncidents->pluck('month'));
const monthlyCounts = @json($monthlyIncidents->pluck('total'));
const severityLabels = @json($behaviorStats->pluck('severity'));
const severityCounts = @json($behaviorStats->pluck('total'));
const incidentStatus = @json($incidentStatus);
const responsibility = @json($responsibilityStats);

new Chart(monthlyIncidentsChart, {
    type: 'line',
    data: { labels: monthlyLabels, datasets: [{ data: monthlyCounts, label: 'Incidents', borderWidth: 3 }] }
});

new Chart(behaviorSeverityChart, {
    type: 'bar',
    data: { labels: severityLabels, datasets: [{ data: severityCounts, label: 'Count' }] }
});

new Chart(incidentStatusChart, {
    type: 'pie',
    data: { labels: ['Open','Closed','Pending'], datasets: [{ data: Object.values(incidentStatus) }] }
});

new Chart(responsibilityChart, {
    type: 'doughnut',
    data: { labels: ['Driver','Company','Third Party'], datasets: [{ data: Object.values(responsibility) }] }
});
</script>
@endsection
