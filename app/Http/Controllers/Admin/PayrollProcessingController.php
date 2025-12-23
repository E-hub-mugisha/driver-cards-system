<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollSetting;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollProcessingController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        $payrolls = Payroll::with('company', 'details.driver')->latest()->get();
        // fetch payroll records
        $companies = Company::all();
        return view('admin.payroll.index', compact('drivers', 'payrolls', 'companies'));
    }


    /**
     * PROCESS PAYROLL
     */
    public function process(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'month'      => 'required|date'
        ]);

        $month = Carbon::parse($request->month)->startOfMonth();

        $company = Company::findOrFail($request->company_id);
        $settings = PayrollSetting::where('company_id', $company->id)->first();

        if (!$settings) {
            return back()->with('error', 'Payroll settings not configured for this company.');
        }

        DB::transaction(function () use ($company, $month, $settings) {

            // Prevent double payroll
            $payroll = Payroll::firstOrCreate([
                'company_id' => $company->id,
                'month'      => $month,
            ], [
                'status'      => 'processing',
                'processed_by' => auth()->id(),
            ]);

            $drivers = Driver::where('company_id', $company->id)
                ->where('status', 'active')
                ->get();

            foreach ($drivers as $driver) {

                // ===============================
                // BASE SALARY / TRIP PAYMENT
                // ===============================
                $baseAmount = 0;
                $tripEarning = 0;
                $overtime = 0;
                $bonus = 0;

                if ($settings->salary_type == 'fixed') {
                    $baseAmount = $settings->base_salary;
                } elseif ($settings->salary_type == 'per_trip') {

                    // If you have trips table replace this logic
                    $tripCount = $driver->incidents() // temp logic replace
                        ->whereMonth('incident_date', $month->month)
                        ->count();

                    $tripEarning = $tripCount * $settings->trip_rate;
                }

                // ===============================
                // PENALTIES & INCIDENT DEDUCTIONS
                // ===============================
                $incidentPenalty = Incident::where('driver_id', $driver->id)
                    ->whereMonth('incident_date', $month->month)
                    ->sum('impact_score'); // convert to money if needed

                $penalties = $incidentPenalty; // adjust + formula later

                // ===============================
                // TAX & RSSB
                // ===============================
                $gross = $baseAmount + $tripEarning + $overtime + $bonus;

                $tax = ($settings->tax_rate / 100) * $gross;
                $rssb = ($settings->rssb_rate / 100) * $gross;

                $netSalary = $gross - ($tax + $rssb + $penalties);

                if ($netSalary < 0) $netSalary = 0;

                // ===============================
                // SAVE PAYROLL DETAIL
                // ===============================
                PayrollDetail::updateOrCreate([
                    'payroll_id' => $payroll->id,
                    'driver_id'  => $driver->id,
                ], [
                    'base_amount'       => $baseAmount,
                    'trips_earning'     => $tripEarning,
                    'overtime_amount'   => $overtime,
                    'bonus_amount'      => $bonus,

                    'penalty_amount'    => $penalties,
                    'incident_deduction' => $incidentPenalty,
                    'tax_deduction'     => $tax,
                    'rssb_deduction'    => $rssb,

                    'gross_salary'      => $gross,
                    'net_salary'        => $netSalary,
                    'payment_status'    => 'pending',
                ]);
            }

            $payroll->status = 'completed';
            $payroll->save();
        });

        return back()->with('success', 'Payroll processed successfully.');
    }


    /**
     * Approve Payroll
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
}
