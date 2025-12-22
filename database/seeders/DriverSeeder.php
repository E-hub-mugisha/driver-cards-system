<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Company;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->info('No companies found. Please seed companies first.');
            return;
        }

        foreach ($companies as $company) {
            // Generate 5 drivers per company
            for ($i = 1; $i <= 5; $i++) {
                $names = fake()->name();
                $idNumber = fake()->unique()->numerify('12345#####');
                $driverLicense = fake()->unique()->bothify('DL#######');
                $phone = fake()->phoneNumber();
                $rssb = fake()->numerify('RSSB######');
                $contractType = fake()->randomElement(['3 month','6 month','12 month','open ended']);
                $insurance = fake()->randomElement(['YES','NO']);
                $status = fake()->randomElement(['active','inactive','suspended']);
                $performanceScore = fake()->numberBetween(0, 100);
                $riskLevel = fake()->randomElement(['low','medium','high']);

                Driver::create([
                    'names' => $names,
                    'ID_number' => $idNumber,
                    'driver_license' => $driverLicense,
                    'phone' => $phone,
                    'rssb' => $rssb,
                    'contract_type' => $contractType,
                    'insurance' => $insurance,
                    'photo' => null,
                    'contract' => null,
                    'status' => $status,
                    'company_id' => $company->id,
                    'performance_score' => $performanceScore,
                    'risk_level' => $riskLevel,
                ]);
            }
        }
    }
}
