<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BehaviorCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Safety Violations',
                'slug' => 'safety',
                'behaviors' => [
                    ['name' => 'Speeding', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Harsh Braking', 'category' => 'negative', 'severity' => 'low', 'score' => -5],
                    ['name' => 'Rapid Acceleration', 'category' => 'negative', 'severity' => 'low', 'score' => -5],
                    ['name' => 'Dangerous Cornering', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Tailgating', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Running Red Light / Stop Sign', 'category' => 'negative', 'severity' => 'high', 'score' => -25],
                    ['name' => 'Distracted Driving (Phone Use)', 'category' => 'negative', 'severity' => 'high', 'score' => -20],
                    ['name' => 'Driving Under Fatigue', 'category' => 'negative', 'severity' => 'high', 'score' => -20],
                    ['name' => 'Driving Under Influence', 'category' => 'negative', 'severity' => 'high', 'score' => -50],
                    ['name' => 'Not Wearing Seatbelt', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                ],
            ],
            [
                'name' => 'Time & Attendance Issues',
                'slug' => 'time-attendance',
                'behaviors' => [
                    ['name' => 'Late Arrival', 'category' => 'negative', 'severity' => 'low', 'score' => -5],
                    ['name' => 'Late Delivery', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Missed Scheduled Trip', 'category' => 'negative', 'severity' => 'high', 'score' => -20],
                    ['name' => 'Unapproved Route Deviation', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Excessive Idle Time', 'category' => 'negative', 'severity' => 'low', 'score' => -5],
                ],
            ],
            [
                'name' => 'Vehicle & Asset Misuse',
                'slug' => 'vehicle-misuse',
                'behaviors' => [
                    ['name' => 'Unauthorized Vehicle Use', 'category' => 'negative', 'severity' => 'high', 'score' => -20],
                    ['name' => 'Personal Use of Company Vehicle', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Excessive Fuel Consumption', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Failure to Secure Cargo', 'category' => 'negative', 'severity' => 'high', 'score' => -25],
                    ['name' => 'Improper Loading / Unloading', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                ],
            ],
            [
                'name' => 'Policy & Compliance Violations',
                'slug' => 'policy-compliance',
                'behaviors' => [
                    ['name' => 'Ignoring Company SOPs', 'category' => 'negative', 'severity' => 'medium', 'score' => -15],
                    ['name' => 'Unauthorized Passengers', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Failure to Report Incident', 'category' => 'negative', 'severity' => 'high', 'score' => -20],
                    ['name' => 'Providing False Information', 'category' => 'negative', 'severity' => 'high', 'score' => -25],
                ],
            ],
            [
                'name' => 'Customer & Public Interaction',
                'slug' => 'customer-interaction',
                'behaviors' => [
                    ['name' => 'Rude Behavior', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Poor Customer Feedback', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Unprofessional Conduct', 'category' => 'negative', 'severity' => 'medium', 'score' => -10],
                    ['name' => 'Excellent Customer Feedback', 'category' => 'positive', 'severity' => 'low', 'score' => 10],
                ],
            ],
            [
                'name' => 'Positive Performance',
                'slug' => 'positive-performance',
                'behaviors' => [
                    ['name' => 'Safe Driving Record', 'category' => 'positive', 'severity' => 'low', 'score' => 15],
                    ['name' => 'On-Time Delivery', 'category' => 'positive', 'severity' => 'low', 'score' => 10],
                    ['name' => 'Fuel Efficient Driving', 'category' => 'positive', 'severity' => 'low', 'score' => 10],
                    ['name' => 'Proactive Issue Reporting', 'category' => 'positive', 'severity' => 'low', 'score' => 5],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $categoryId = DB::table('behavior_categories')->insertGetId([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($category['behaviors'] as $behavior) {
                DB::table('behavior_types')->insert([
                    'behavior_category_id' => $categoryId,
                    'name' => $behavior['name'],
                    'category' => $behavior['category'],
                    'default_score' => $behavior['score'],
                    'severity' => $behavior['severity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
