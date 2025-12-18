<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverBehavior extends Model
{
    protected $fillable = [
        'driver_id',
        'behavior_type_id',
        'severity',
        'score',
        'notes',
        'reported_by',
    ];

    // ✅ Define the behaviorType relationship
    public function behaviorType()
    {
        return $this->belongsTo(\App\Models\BehaviorType::class, 'behavior_type_id');
    }

    // Optional: driver
    public function driver()
    {
        return $this->belongsTo(\App\Models\Driver::class);
    }

    // Optional: reporter
    public function reporter()
    {
        return $this->belongsTo(\App\Models\User::class, 'reported_by');
    }
}
