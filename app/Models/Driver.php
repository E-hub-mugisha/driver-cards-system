<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'names', 'ID_number', 'driver_license', 'phone',
        'rssb', 'contract_type', 'insurance', 'photo',
        'contract', 'status', 'company_id'
    ];

    // Company relation
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function behaviors()
    {
        return $this->hasMany(DriverBehavior::class);
    }
}
