<?php

namespace App\Http\Controllers\Company;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Mail\PayrollOtpMail;
use App\Models\Driver;
use App\Models\DriverBehavior;
use App\Models\Incident;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollSetting;
use App\Services\PayrollGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CompanyDashboardController extends Controller
{
    protected function company()
    {
        return auth()->user()->staff->company;
    }

    public function index()
    {
        $company = auth()->user()->staff->company;

        $drivers = Driver::with('company')
            ->where('company_id', $company->id)
            ->latest()
            ->take(5)
            ->get();

        $TotalDrivers = Driver::where('company_id', $company->id)->count();

        $DriversMonth = Driver::where('company_id', $company->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $DriversWeek = Driver::where('company_id', $company->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Optional growth %
        $PrevMonth = Driver::where('company_id', $company->id)
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $MonthChange = $PrevMonth ? (($DriversMonth - $PrevMonth) / $PrevMonth) * 100 : 0;

        $PrevWeek = Driver::where('company_id', $company->id)
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $WeekChange = $PrevWeek ? (($DriversWeek - $PrevWeek) / $PrevWeek) * 100 : 0;

        $activeDrivers = Driver::where('company_id', $company->id)
            ->where('status', 'active')
            ->count();

        $suspendedDrivers = Driver::where('company_id', $company->id)
            ->where('status', 'suspended')
            ->count();

        $pendingDrivers = Driver::where('company_id', $company->id)
            ->where('status', 'pending')
            ->count();

        $reportedDrivers = DriverBehavior::with([
            'driver',
            'behaviorType.behaviorCategory'
        ])
            ->whereHas('driver', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })
            ->latest('behavior_date')
            ->limit(5)
            ->get();

        // KPI Data
        $totalDrivers = $company->drivers()->count();
        $totalStaff   = $company->staff()->count();
        $totalIncidents = $company->drivers()->withCount('incidents')->get()->sum('incidents_count');

        $monthlyPayrolls = $company->payrolls() // Note the parentheses
            ->where('month', '>=', now()->subMonths(6))
            ->join('payroll_details', 'payroll_details.payroll_id', '=', 'payrolls.id')
            ->selectRaw('MONTH(month) as month_number, MONTHNAME(month) as month_name, SUM(net_salary) as total_net')
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $months = $monthlyPayrolls->pluck('month_name');
        $netSalaries = $monthlyPayrolls->pluck('total_net');

        // Monthly Penalties
        $monthlyPenalties = $company->drivers()
            ->with(['incidents' => function ($q) {
                $q->where('incident_date', '>=', now()->subMonths(6));
            }])
            ->get()
            ->flatMap->incidents
            ->groupBy(function ($incident) {
                return \Carbon\Carbon::parse($incident->incident_date)->format('M Y');
            })
            ->map(fn($group) => $group->sum('impact_score'));

        // Monthly driver & behavior trends (last 6 months)
        $monthlyDrivers = $company->drivers()
            ->withCount(['behaviors as behaviors_count' => function ($q) {
                $q->where('created_at', '>=', now()->subMonths(6));
            }])
            ->get();

        $monthlyStats = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');

            // Drivers added in that month
            $driversCount = $company->drivers()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Behaviors reported in that month
            $behaviorsCount = DriverBehavior::whereHas('driver', fn($q) => $q->where('company_id', $company->id))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $monthlyStats->push([
                'month' => $monthName,
                'drivers' => $driversCount,
                'behaviors' => $behaviorsCount
            ]);
        }

        $months = $monthlyStats->pluck('month');
        $driversData = $monthlyStats->pluck('drivers');
        $behaviorsData = $monthlyStats->pluck('behaviors');

        return view('company.dashboard.index', compact(
            'company',
            'drivers',
            'TotalDrivers',
            'DriversMonth',
            'DriversWeek',
            'activeDrivers',
            'suspendedDrivers',
            'pendingDrivers',
            'reportedDrivers',
            'MonthChange',
            'WeekChange',

        ));
    }

    /**
     * Display KPI reports scoped to the authenticated staff's company.
     */
    public function reportCompany(Request $request)
    {
        $company = $this->company();
        $from    = $request->from;
        $to      = $request->to;

        // ================= BASE QUERIES =================
        $driversQuery   = Driver::where('company_id', $company->id);
        $incidentsQuery = Incident::whereHas('driver', fn($q) => $q->where('company_id', $company->id));
        $behaviorsQuery = DriverBehavior::whereHas('driver', fn($q) => $q->where('company_id', $company->id));

        // ================= DATE FILTER =================
        if ($from && $to) {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate   = Carbon::parse($to)->endOfDay();

            $driversQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $incidentsQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $behaviorsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        // ================= KPI DATA =================
        $totalDrivers     = (clone $driversQuery)->count();
        $avgScore         = (clone $driversQuery)->avg('performance_score');
        $highRiskDrivers  = (clone $driversQuery)->where('risk_level', 'high')->count();
        $totalIncidents   = (clone $incidentsQuery)->count();

        // ================= MONTHLY INCIDENTS =================
        $monthlyIncidents = (clone $incidentsQuery)
            ->select(
                DB::raw('COUNT(id) as total'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('MONTH(created_at) as month_number')
            )
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // ================= BEHAVIOR STATS =================
        $behaviorStats = (clone $behaviorsQuery)
            ->select(DB::raw('COUNT(id) as total'), 'severity')
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

        // KPI Data
        $totalDrivers = $company->drivers()->count();
        $totalStaff   = $company->staff()->count();
        $totalIncidents = $company->drivers()->withCount('incidents')->get()->sum('incidents_count');

        $monthlyPayrolls = $company->payrolls() // Note the parentheses
            ->where('month', '>=', now()->subMonths(6))
            ->join('payroll_details', 'payroll_details.payroll_id', '=', 'payrolls.id')
            ->selectRaw('MONTH(month) as month_number, MONTHNAME(month) as month_name, SUM(net_salary) as total_net')
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $months = $monthlyPayrolls->pluck('month_name');
        $netSalaries = $monthlyPayrolls->pluck('total_net');

        // Monthly Penalties
        $monthlyPenalties = $company->drivers()
            ->with(['incidents' => function ($q) {
                $q->where('incident_date', '>=', now()->subMonths(6));
            }])
            ->get()
            ->flatMap->incidents
            ->groupBy(function ($incident) {
                return \Carbon\Carbon::parse($incident->incident_date)->format('M Y');
            })
            ->map(fn($group) => $group->sum('impact_score'));

        // Monthly driver & behavior trends (last 6 months)
        $monthlyDrivers = $company->drivers()
            ->withCount(['behaviors as behaviors_count' => function ($q) {
                $q->where('created_at', '>=', now()->subMonths(6));
            }])
            ->get();

        $monthlyStats = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');

            // Drivers added in that month
            $driversCount = $company->drivers()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Behaviors reported in that month
            $behaviorsCount = DriverBehavior::whereHas('driver', fn($q) => $q->where('company_id', $company->id))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $monthlyStats->push([
                'month' => $monthName,
                'drivers' => $driversCount,
                'behaviors' => $behaviorsCount
            ]);
        }

        $months = $monthlyStats->pluck('month');
        $driversData = $monthlyStats->pluck('drivers');
        $behaviorsData = $monthlyStats->pluck('behaviors');

        return view('company.reports.index', [
            'company'           => $company,
            'totalDrivers'      => $totalDrivers,
            'avgScore'          => $avgScore,
            'highRiskDrivers'   => $highRiskDrivers,
            'totalIncidents'    => $totalIncidents,
            'monthlyIncidents'  => $monthlyIncidents,
            'behaviorStats'     => $behaviorStats,
            'incidentStatus'    => $incidentStatus,
            'responsibilityStats' => $responsibilityStats,
            'incidentsQuery'    => $incidentsQuery->get(),
            'totalDrivers'      => $totalDrivers,
            'totalStaff'        => $totalStaff,
            'totalIncidents'    => $totalIncidents,
            'months'            => $months,
            'netSalaries'       => $netSalaries,
            'monthlyPenalties'  => $monthlyPenalties,
            'driversData'       => $driversData,
            'behaviorsData'     => $behaviorsData
        ]);
    }

    /**
     * Export PDF report scoped to the company.
     */
    public function exportPdf(Request $request)
    {
        $company = $this->company();
        $data = $this->getReportData($request, $company);

        $pdf = Pdf::loadView('company.reports.pdf', $data);
        return $pdf->download('report.pdf');
    }

    /**
     * Export Excel report scoped to the company.
     */
    public function exportExcel(Request $request)
    {
        $company = $this->company();
        $data = $this->getReportData($request, $company);

        return Excel::download(new ReportExport($data), 'report.xlsx');
    }

    /**
     * Centralized data retrieval for exports.
     */
    protected function getReportData(Request $request, $company)
    {
        $from = $request->from;
        $to   = $request->to;

        $driversQuery   = Driver::where('company_id', $company->id);
        $incidentsQuery = Incident::whereHas('driver', fn($q) => $q->where('company_id', $company->id));
        $behaviorsQuery = DriverBehavior::whereHas('driver', fn($q) => $q->where('company_id', $company->id));

        if ($from && $to) {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate   = Carbon::parse($to)->endOfDay();

            $driversQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $incidentsQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $behaviorsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return [
            'company'           => $company,
            'drivers'           => $driversQuery->get(),
            'incidents'         => $incidentsQuery->get(),
            'behaviors'         => $behaviorsQuery->get(),
        ];
    }

    /**
     * Company Payroll Dashboard
     */
    public function generate(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $company = auth()->user()->staff->company;

        // Optional: allow selecting month
        $month = $request->month
            ? Carbon::createFromFormat('Y-m', $request->month)->startOfMonth()
            : Carbon::now()->startOfMonth();

        $settings = $company->payrollSettings;

        if (!$settings) {
            return back()->with('error', 'Payroll settings not configured for your company.');
        }

        DB::transaction(function () use ($company, $month, $settings) {

            // Get or create payroll record
            $payroll = Payroll::firstOrCreate(
                [
                    'company_id' => $company->id,
                    'month' => $month,
                ],
                [
                    'status' => 'processing',
                    'processed_by' => auth()->id(),
                ]
            );

            $drivers = $company->drivers()->where('status', 'active')->get();

            foreach ($drivers as $driver) {
                $baseSalary = $settings->salary_type === 'fixed' ? $settings->base_salary : 0;

                // Calculate penalties
                $incidentPenalty = $driver->incidents()
                    ->whereMonth('incident_date', $month->month)
                    ->whereYear('incident_date', $month->year)
                    ->sum('impact_score');

                $gross = $baseSalary;
                $tax = ($settings->tax_rate / 100) * $gross;
                $rssb = ($settings->rssb_rate / 100) * $gross;
                $net = max(0, $gross - ($tax + $rssb + $incidentPenalty));

                // Create or update payroll detail
                PayrollDetail::updateOrCreate(
                    [
                        'payroll_id' => $payroll->id,
                        'driver_id' => $driver->id,
                    ],
                    [
                        'base_amount' => $baseSalary,
                        'trips_earning' => 0,
                        'overtime_amount' => 0,
                        'bonus_amount' => 0,
                        'penalty_amount' => $incidentPenalty,
                        'tax_deduction' => $tax,
                        'rssb_deduction' => $rssb,
                        'gross_salary' => $gross,
                        'net_salary' => $net,
                        'payment_status' => 'pending',
                    ]
                );
            }

            $payroll->status = 'completed';
            $payroll->save();
        });

        return back()->with('success', "Payroll generated successfully for {$month->format('M Y')}.");
    }
    public function payrollCompany(Request $request)
    {
        $company = auth()->user()->staff->company;

        $payrolls = Payroll::query()
            ->where('company_id', $company->id)
            ->with(['processedBy', 'approvedBy'])
            ->withSum('details as gross_total', 'gross_salary')
            ->withSum('details as net_total', 'net_salary')
            ->withSum('details as penalty_total', 'penalty_amount')
            ->orderBy('month', 'asc');

        if ($request->month) {
            $date = Carbon::createFromFormat('Y-m', $request->month);
            $payrolls->whereYear('month', $date->year)
                ->whereMonth('month', $date->month);
        }

        $payrolls = $payrolls->get();

        return view('company.payroll.index', compact('company', 'payrolls'));
    }

    public function storePayroll(Request $request)
    {
        $company = auth()->user()->staff->company;

        $request->validate([
            'salary_type' => 'required|in:fixed,per_trip',
            'base_salary' => 'required|numeric',
            'trip_rate'   => 'nullable|numeric',
            'tax_rate'    => 'required|numeric',
            'rssb_rate'   => 'required|numeric',
        ]);

        PayrollSetting::create([
            'company_id'  => $company->id,
            'salary_type' => $request->salary_type,
            'base_salary' => $request->base_salary,
            'trip_rate'   => $request->trip_rate,
            'tax_rate'    => $request->tax_rate,
            'rssb_rate'   => $request->rssb_rate,
        ]);

        return back()->with('success', 'Payroll settings saved successfully.');
    }

    public function updatePayroll(Request $request, PayrollSetting $payrollSetting)
    {
        $request->validate([
            'salary_type' => 'required|in:fixed,per_trip',
            'base_salary' => 'required|numeric',
            'trip_rate'   => 'nullable|numeric',
            'tax_rate'    => 'required|numeric',
            'rssb_rate'   => 'required|numeric',
        ]);

        $payrollSetting->update($request->all());

        return back()->with('success', 'Payroll settings updated successfully.');
    }

    /**
     * Step 2: Preview drivers for payroll
     */
    public function previewPayroll(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $company = auth()->user()->staff->company;
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $drivers = $company->drivers()->where('status', 'active')->get();
        $settings = $company->payrollSettings;

        return view('company.payroll.preview', compact('company', 'month', 'drivers', 'settings'));
    }

    /**
     * Step 3: Process payroll for the company
     */
    public function processPayroll(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $company = auth()->user()->staff->company;
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $settings = $company->payrollSettings;

        if (!$settings) {
            return back()->with('error', 'Payroll settings not configured for your company.');
        }

        DB::transaction(function () use ($company, $month, $settings) {

            // Prevent duplicate payroll
            $payroll = Payroll::firstOrCreate(
                ['company_id' => $company->id, 'month' => $month],
                ['status' => 'processing', 'processed_by' => auth()->id()]
            );

            $drivers = $company->drivers()->where('status', 'active')->get();

            foreach ($drivers as $driver) {

                $baseSalary = $settings->salary_type == 'fixed' ? $settings->base_salary : 0;

                // Sum penalties for this driver this month
                $incidentPenalty = $driver->incidents()
                    ->whereMonth('incident_date', $month->month)
                    ->whereYear('incident_date', $month->year)
                    ->sum('impact_score');

                $gross = $baseSalary;
                $tax   = ($settings->tax_rate / 100) * $gross;
                $rssb  = ($settings->rssb_rate / 100) * $gross;
                $net   = max(0, $gross - ($tax + $rssb + $incidentPenalty));

                PayrollDetail::updateOrCreate(
                    ['payroll_id' => $payroll->id, 'driver_id' => $driver->id],
                    [
                        'base_amount' => $baseSalary,
                        'trips_earning' => 0,
                        'overtime_amount' => 0,
                        'bonus_amount' => 0,
                        'penalty_amount' => $incidentPenalty,
                        'tax_deduction' => $tax,
                        'rssb_deduction' => $rssb,
                        'gross_salary' => $gross,
                        'net_salary' => $net,
                        'payment_status' => 'pending',
                    ]
                );
            }

            $payroll->status = 'completed';
            $payroll->save();
        });

        return redirect()->route('company.payroll.review', [
            'month' => $month->format('Y-m')
        ])->with('success', 'Payroll processed successfully.');
    }

    /**
     * Step 4: Review payroll
     */
    public function reviewPayroll(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $company = auth()->user()->staff->company;
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();

        $payroll = Payroll::with('details.driver')
            ->where('company_id', $company->id)
            ->where('month', $month)
            ->firstOrFail();

        return view('company.payroll.review', compact('company', 'month', 'payroll'));
    }

    /**
     * Approve payroll
     */
    public function approvePayroll(Payroll $payroll)
    {
        if ($payroll->company_id != auth()->user()->staff->company_id) {
            abort(403);
        }

        $payroll->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Payroll approved successfully.');
    }

    /**
     * Download individual driver payslip PDF
     */
    public function downloadDriverPayslip(PayrollDetail $detail)
    {
        if ($detail->payroll->company_id != auth()->user()->staff->company_id) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('company.payroll.payslip_driver_pdf', compact('detail'));
        return $pdf->download("Payslip-{$detail->driver->names}-" . $detail->payroll->month->format('M-Y') . ".pdf");
    }

    /**
     * Send OTP to the authenticated user's email
     */
    public function sendOtp(Payroll $payroll)
    {
        $user = auth()->user();
        $otp = rand(100000, 999999);

        // Save OTP with expiry (5 minutes)
        $expiresAt = now()->addMinutes(5);
        session([
            "payroll_delete_otp_{$payroll->id}" => [
                'otp' => $otp,
                'expires_at' => $expiresAt
            ]
        ]);

        // Send OTP via email
        Mail::to($user->email)->send(new \App\Mail\PayrollOtpMail($otp));

        return response()->json([
            'success' => true,
            'otp' => $otp // Optional: remove in production
        ]);
    }

    /**
     * Delete payroll after OTP confirmation
     */
    public function deletePayroll(Request $request, Payroll $payroll)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $sessionKey = "payroll_delete_otp_{$payroll->id}";
        $otpData = session($sessionKey);

        if (!$otpData) {
            return response()->json(['success' => false, 'message' => 'OTP not found or expired.'], 422);
        }

        if (now()->gt($otpData['expires_at'])) {
            session()->forget($sessionKey);
            return response()->json(['success' => false, 'message' => 'OTP expired.'], 422);
        }

        if ($request->otp != $otpData['otp']) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 422);
        }

        // Delete payroll and its details
        $payroll->details()->delete();
        $payroll->delete();

        // Forget OTP after successful deletion
        session()->forget($sessionKey);

        return response()->json(['success' => true]);
    }
}
