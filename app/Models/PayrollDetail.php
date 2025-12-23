<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payroll_id',
        'driver_id',

        'base_amount',
        'trips_earning',
        'overtime_amount',
        'bonus_amount',

        'penalty_amount',
        'incident_deduction',
        'tax_deduction',
        'rssb_deduction',

        'gross_salary',
        'net_salary',

        'payment_status',
        'payment_method',
        'payment_reference',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
