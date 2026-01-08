<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollGenerator
{
    public static function generate(Company $company, Carbon $month, int $userId): Payroll
    {
        $month = $month->startOfMonth();
        $settings = $company->payrollSettings;

        if (!$settings || !$settings->status) {
            throw new \Exception('Payroll settings not configured.');
        }

        return DB::transaction(function () use ($company, $month, $settings, $userId) {

            // 🔒 Prevent duplicate payroll
            $payroll = Payroll::firstOrCreate(
                [
                    'company_id' => $company->id,
                    'month' => $month,
                ],
                [
                    'status' => 'draft',
                    'processed_by' => $userId,
                ]
            );

            // ❌ Do not regenerate approved payroll
            if ($payroll->status === 'approved') {
                throw new \Exception('Approved payroll cannot be regenerated.');
            }

            // ♻ Clear old details (safe regeneration)
            $payroll->details()->delete();

            // 👥 Generate per driver
            $drivers = $company->drivers()->where('status', 'active')->get();

            foreach ($drivers as $driver) {
                $data = self::calculatePayroll($driver, $settings, $month);

                PayrollDetail::create(array_merge($data, [
                    'payroll_id' => $payroll->id,
                    'driver_id'  => $driver->id,
                ]));
            }

            $payroll->update([
                'status' => 'processed',
                'processed_by' => $userId,
            ]);

            return $payroll;
        });
    }

    /**
     * Simple local payroll calculator used when App\Services\PayrollCalculator is missing.
     *
     * @param  mixed $driver
     * @param  mixed $settings
     * @param  \Carbon\Carbon $month
     * @return array
     */
    private static function calculatePayroll($driver, $settings, Carbon $month): array
    {
        // Minimal safe defaults to avoid runtime errors; adapt to your real calculation.
        $gross = $driver->salary ?? 0;
        $deductions = 0;
        $net = $gross - $deductions;

        return [
            'gross' => $gross,
            'deductions' => $deductions,
            'net' => $net,
        ];
    }
}
