<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'salary_type',
        'base_salary',
        'trip_rate',
        'overtime_rate',
        'rssb_rate',
        'tax_rate',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
