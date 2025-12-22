<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Kigali Bus Services',
                'email' => 'info@kbs.rw',
                'phone' => '+250788800001',
                'address' => 'Nyabugogo, Kigali',
                'status' => 'active',
            ],
            [
                'name' => 'Volcano Express',
                'email' => 'support@volcano.rw',
                'phone' => '+250788800002',
                'address' => 'Nyabugogo Bus Park, Kigali',
                'status' => 'active',
            ],
            [
                'name' => 'Horizon Express',
                'email' => 'contact@horizon.rw',
                'phone' => '+250788800003',
                'address' => 'Kigali, Rwanda',
                'status' => 'active',
            ],
            [
                'name' => 'RFTC Cooperative',
                'email' => 'office@rftc.rw',
                'phone' => '+250788800004',
                'address' => 'Remera, Kigali',
                'status' => 'active',
            ],
            [
                'name' => 'Ritco Transport',
                'email' => 'info@ritco.rw',
                'phone' => '+250788800005',
                'address' => 'Kigali, Rwanda',
                'status' => 'active',
            ],
            [
                'name' => 'Akagera Transport',
                'email' => 'support@akagera.rw',
                'phone' => '+250788800006',
                'address' => 'Kicukiro, Kigali',
                'status' => 'active',
            ],
            [
                'name' => 'Royal Express Rwanda',
                'email' => 'help@royalexpress.rw',
                'phone' => '+250788800007',
                'address' => 'Kigali, Rwanda',
                'status' => 'active',
            ],
            [
                'name' => 'Yahoo Car Express',
                'email' => 'office@yahooexpress.rw',
                'phone' => '+250788800008',
                'address' => 'Nyabugogo, Kigali',
                'status' => 'suspended',
            ],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['name' => $company['name']],
                $company
            );
        }
    }
}
