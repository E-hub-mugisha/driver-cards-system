<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use App\Models\DriverBehavior;
use App\Models\Incident;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->company_id;
        $from = $request->from;
        $to = $request->to;

        // ================= BASE QUERIES =================
        $driversQuery   = Driver::query();
        $incidentsQuery = Incident::query();
        $behaviorsQuery = DriverBehavior::query();

        // ================= COMPANY FILTER =================
        if ($companyId) {

            // Drivers have company_id
            $driversQuery->where('company_id', $companyId);

            // Incidents → Driver → Company
            $incidentsQuery->whereHas('driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

            // Behaviors → Driver → Company
            $behaviorsQuery->whereHas('driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        // ================= DATE FILTER =================
        if ($from && $to) {

            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate   = Carbon::parse($to)->endOfDay();

            $driversQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $incidentsQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $behaviorsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        // ================= KPI DATA =================
        $totalDrivers = (clone $driversQuery)->count();
        $avgScore = (clone $driversQuery)->avg('performance_score');
        $highRiskDrivers = (clone $driversQuery)->where('risk_level', 'high')->count();

        $totalIncidents = (clone $incidentsQuery)->count();

        // ================= MONTHLY INCIDENTS =================
        $monthlyIncidents = (clone $incidentsQuery)
            ->select(
                DB::raw('COUNT(id) as total'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('MONTH(created_at) as month_number')
            )
            ->groupBy(
                DB::raw('MONTH(created_at)'),
                DB::raw('MONTHNAME(created_at)')
            )
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // ================= BEHAVIOR STATS =================
        $behaviorStats = (clone $behaviorsQuery)
            ->select(
                DB::raw('COUNT(id) as total'),
                'severity'
            )
            ->groupBy('severity')
            ->get();

        // ================= INCIDENT STATUS =================
        $incidentStatus = [
            'open'    => (clone $incidentsQuery)->where('status', 'open')->count(),
            'closed'  => (clone $incidentsQuery)->where('status', 'closed')->count(),
            'pending' => (clone $incidentsQuery)->where('status', 'pending')->count(),
        ];

        // ================= RESPONSIBILITY =================
        $responsibilityStats = [
            'driver'      => (clone $incidentsQuery)->where('responsibility', 'driver')->count(),
            'company'     => (clone $incidentsQuery)->where('responsibility', 'company')->count(),
            'third_party' => (clone $incidentsQuery)->where('responsibility', 'third_party')->count(),
        ];

        return view('admin.reports.index', [
            'companies' => Company::orderBy('name')->get(),

            'totalDrivers' => $totalDrivers,
            'avgScore' => $avgScore,
            'highRiskDrivers' => $highRiskDrivers,
            'totalIncidents' => $totalIncidents,

            'monthlyIncidents' => $monthlyIncidents,
            'behaviorStats' => $behaviorStats,
            'incidentStatus' => $incidentStatus,
            'responsibilityStats' => $responsibilityStats,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request); // reuse logic

        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        return $pdf->download('report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getReportData($request);
        return Excel::download(new ReportExport($data), 'report.xlsx');
    }
}
