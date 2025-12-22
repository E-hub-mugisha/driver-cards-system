<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\BehaviorType;
use App\Models\DriverBehavior;
use App\Models\User;
use Carbon\Carbon;

class DriverBehaviorSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();
        $behaviorTypes = BehaviorType::all();
        $users = User::all(); // staff who reports behaviors

        if ($drivers->isEmpty() || $behaviorTypes->isEmpty()) {
            $this->command->info('No drivers or behavior types found. Please seed them first.');
            return;
        }

        foreach ($drivers as $driver) {

            // Generate 3-8 random behavior records per driver
            $recordsCount = rand(3, 8);

            for ($i = 0; $i < $recordsCount; $i++) {

                $behaviorType = $behaviorTypes->random();

                $severity = ['low','medium','high'][array_rand(['low','medium','high'])];

                // Severity weights
                $weights = [
                    'low' => 5,
                    'medium' => 10,
                    'high' => 20,
                ];

                $baseScore = $behaviorType->default_score ?? 0;
                $severityScore = $weights[$severity];

                $finalScore = $baseScore + $severityScore;

                // Apply negative effect if behavior type is negative
                if ($behaviorType->category === 'negative') {
                    $finalScore = -abs($finalScore);
                }

                // Random behavior date within last 3 months
                $behaviorDate = Carbon::now()->subDays(rand(0, 90));

                DriverBehavior::create([
                    'driver_id' => $driver->id,
                    'behavior_type_id' => $behaviorType->id,
                    'type' => $behaviorType->category,
                    'severity' => $severity,
                    'score' => $finalScore,
                    'behavior_date' => $behaviorDate->format('Y-m-d'),
                    'recorded_month' => $behaviorDate->copy()->startOfMonth()->format('Y-m-d'),
                    'description' => 'Sample behavior for testing',
                    'reported_by' => $users->isNotEmpty() ? $users->random()->id : null,
                ]);

                // Update driver performance score
                $driver->performance_score += $finalScore;
            }

            // Ensure performance_score is not negative
            if ($driver->performance_score < 0) {
                $driver->performance_score = 0;
            }

            $driver->save();
        }
    }
}
