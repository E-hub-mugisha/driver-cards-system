<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriversExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Driver::all();
    }
    public function headings(): array
    {
        return [
            "names",
            "ID_number",
            "driver_license",
            "phone",
            "rssb",
            "company",
            "contract_type",
            "insurance",
            "company_id",
            "photo",
            "contract",
            "status",
            "created_at"
        ];
    }
}
