<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable =  [
        'names',
        'ID_number',
        'driver_license',
        'phone',
        'rssb',
        'company',
        'contract_type',
        'insurance',
        'company_id',
        'photo',
    ];
}
