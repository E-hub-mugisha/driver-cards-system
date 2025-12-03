<?php

namespace App\Exports;

use App\Models\driver;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class DriverByMemberExport implements FromCollection
{
    protected $name;
    protected $status;

    public function __construct($name, $status)
    {
        $this->name = $name;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Driver::where('company', $this->name)->where('status', $this->status)->get();
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
