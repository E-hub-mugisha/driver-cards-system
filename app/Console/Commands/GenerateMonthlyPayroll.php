<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Services\PayrollGenerator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateMonthlyPayroll extends Command
{
    protected $signature = 'payroll:generate {--company= : Company ID to generate payroll for}';
    protected $description = 'Generate payroll for companies automatically';

    public function handle()
    {
        $companies = Company::query();

        if ($companyId = $this->option('company')) {
            $companies->where('id', $companyId);
        }

        $companies = $companies->get();

        foreach ($companies as $company) {
            $this->info("Generating payroll for {$company->name}...");

            DB::transaction(function () use ($company) {
                $month = Carbon::now()->startOfMonth();

                // Get or create payroll record
                $payroll = Payroll::firstOrCreate(
                    [
                        'company_id' => $company->id,
                        'month' => $month,
                    ],
                    [
                        'status' => 'processing',
                        'processed_by' => auth()->id() ?? 1, // default to admin ID 1 if CLI
                    ]
                );

                $settings = $company->payrollSettings;

                if (!$settings) {
                    $this->warn("Skipping {$company->name}, no payroll settings configured.");
                    return;
                }

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

                    // ✅ Properly create or update PayrollDetail
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

            $this->info("Payroll generated for {$company->name}");
        }
    }
}
