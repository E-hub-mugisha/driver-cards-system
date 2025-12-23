<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('incidents')->insert([

            // ---------- Incident 1 ----------
            [
                'driver_id'           => 1,
                'type'                => 'accident',
                'severity'            => 'high',
                'incident_date'       => Carbon::now()->subDays(7),
                'location'            => 'Nyabugogo - Kigali',
                'description'         => 'Minor collision with another vehicle, no casualties reported.',
                'evidence'            => 'uploads/incidents/evidence1.jpg',
                'reported_by'         => 2, // user id
                'impact_score'        => 8,
                'root_cause_category' => 'Human Error',
                'root_cause_details'  => 'Driver distraction due to mobile phone usage.',
                'responsibility'      => 'driver',
                'approval_status'     => 'approved',
                'rejection_reason'    => null,
                'approved_by'         => 1,
                'approved_at'         => Carbon::now()->subDays(5),
                'created_at'          => now(),
                'updated_at'          => now(),
            ],

            // ---------- Incident 2 ----------
            [
                'driver_id'           => 2,
                'type'                => 'mechanical_failure',
                'severity'            => 'medium',
                'incident_date'       => Carbon::now()->subDays(3),
                'location'            => 'Kigali - Musanze Highway',
                'description'         => 'Engine overheating resulting in roadside breakdown.',
                'evidence'            => null,
                'reported_by'         => 3,
                'impact_score'        => 5,
                'root_cause_category' => 'Mechanical',
                'root_cause_details'  => 'Cooling system malfunction.',
                'responsibility'      => 'company',
                'approval_status'     => 'pending',
                'rejection_reason'    => null,
                'approved_by'         => null,
                'approved_at'         => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],

            // ---------- Incident 3 ----------
            [
                'driver_id'           => 3,
                'type'                => 'misconduct',
                'severity'            => 'low',
                'incident_date'       => Carbon::now()->subDay(),
                'location'            => 'Remera',
                'description'         => 'Passenger complaint about rude communication.',
                'evidence'            => null,
                'reported_by'         => 4,
                'impact_score'        => 3,
                'root_cause_category' => 'Behavioral',
                'root_cause_details'  => 'Unprofessional communication with passengers.',
                'responsibility'      => 'driver',
                'approval_status'     => 'rejected',
                'rejection_reason'    => 'Insufficient evidence',
                'approved_by'         => 1,
                'approved_at'         => Carbon::now()->subHours(12),
                'created_at'          => now(),
                'updated_at'          => now(),
            ],

        ]);
    }
}
