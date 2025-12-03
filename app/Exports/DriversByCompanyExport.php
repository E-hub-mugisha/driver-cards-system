<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DriversByCompanyExport implements FromCollection, WithHeadings, WithTitle
{
    protected $name;
    protected $status;

    public function __construct($name, $status)
    {
        $this->name = $name;
        $this->status = $status;
    }

    public function collection()
    {
        return Driver::where('company', $this->name)
            ->where('status', $this->status)
            ->get();
    }

    public function headings(): array
    {
        return [
            "ID",
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

    public function title(): string
    {
        return $this->name;
    }
}
