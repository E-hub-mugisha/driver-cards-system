<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Incident;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollSetting;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PayrollProcessingController extends Controller
{
    /**
     * Step 1: Show form to select company & month
     */
    public function index(Request $request)
    {
        $companies = Company::where('status', 'active')->orderBy('name')->get();

        $payrolls = Payroll::with('company', 'processedBy', 'approvedBy')->orderBy('month', 'desc');

        if ($request->company_id) {
            $payrolls->where('company_id', $request->company_id);
        }
        if ($request->month) {
            $month = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
            $payrolls->where('month', $month);
        }

        $payrolls = $payrolls->get();

        return view('admin.payroll.index', compact('companies', 'payrolls'));
    }


    /**
     * Step 2: Preview drivers for payroll
     */
    public function preview(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'month'      => 'required|date_format:Y-m',
        ]);

        $company = Company::findOrFail($request->company_id);
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $drivers = $company->drivers()->where('status', 'active')->get();
        $settings = PayrollSetting::where('company_id', $company->id)->first();

        return view('admin.payroll.preview', compact('company', 'month', 'drivers', 'settings'));
    }

    /**
     * Step 3: Process payroll for selected company & month
     */
    public function process(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'month'      => 'required|date_format:Y-m',
        ]);

        $company = Company::findOrFail($request->company_id);
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $settings = $company->payrollSettings;

        if (!$settings) {
            return back()->with('error', 'Payroll settings not configured for this company.');
        }

        DB::transaction(function () use ($company, $month, $settings) {

            // Prevent duplicate payroll
            $payroll = Payroll::firstOrCreate(
                ['company_id' => $company->id, 'month' => $month],
                ['status' => 'processing', 'processed_by' => auth()->id()]
            );

            $drivers = $company->drivers()->where('status', 'active')->get();

            foreach ($drivers as $driver) {

                // ===== Fixed Salary =====
                $baseSalary = $settings->salary_type == 'fixed' ? $settings->base_salary : 0;

                // ===== Penalties from incidents in this month =====
                $incidentPenalty = $driver->incidents()
                    ->whereMonth('incident_date', $month->month)
                    ->whereYear('incident_date', $month->year)
                    ->sum('impact_score'); // adjust if impact_score → money

                // ===== Gross / Net =====
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

        return redirect()->route('admin.payroll.review', [
            'company_id' => $company->id,
            'month' => $month->format('Y-m')
        ])->with('success', 'Payroll processed successfully.');
    }

    /**
     * Step 4: Review payroll
     */
    public function review(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $company = Company::findOrFail($request->company_id);
        $month   = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();

        $payroll = Payroll::with('details.driver')
            ->where('company_id', $company->id)
            ->where('month', $month)
            ->firstOrFail();

        return view('admin.payroll.review', compact('company', 'month', 'payroll'));
    }

    /**
     * Approve payroll
     */
    public function approve(Payroll $payroll)
    {
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
        $pdf = FacadePdf::loadView('admin.payroll.payslip_driver_pdf', compact('detail'));
        return $pdf->download("Payslip-{$detail->driver->names}-" . $detail->payroll->month->format('M-Y') . ".pdf");
    }
}
