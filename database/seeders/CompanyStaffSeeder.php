<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyStaff;
use Illuminate\Support\Facades\Hash;

class CompanyStaffSeeder extends Seeder
{
    public function run(): void
    {
        // Get all companies (or choose specific ones)
        $companies = Company::all();

        foreach ($companies as $company) {
            // Example staff for each company
            $staffMembers = [
                [
                    'name' => 'Alice Uwimana',
                    'email' => 'alice.' . $company->id . '@example.rw',
                    'role' => 'Manager',
                ],
                [
                    'name' => 'Jean Mukamana',
                    'email' => 'jean.' . $company->id . '@example.rw',
                    'role' => 'Dispatcher',
                ],
                [
                    'name' => 'Claire Niyonzima',
                    'email' => 'claire.' . $company->id . '@example.rw',
                    'role' => 'Admin',
                ],
            ];

            foreach ($staffMembers as $staff) {
                // Create User
                $user = User::updateOrCreate(
                    ['email' => $staff['email']],
                    [
                        'name' => $staff['name'],
                        'password' => Hash::make('password123'), // default password
                        'type' => 2, // Manager/Staff
                        'status' => 'active'
                    ]
                );

                // Create Company Staff record
                CompanyStaff::updateOrCreate(
                    ['user_id' => $user->id, 'company_id' => $company->id],
                    [
                        'role' => $staff['role'],
                        'name' => $staff['name'],
                        'email' => $staff['email'],
                    ]
                );
            }
        }
    }
}
