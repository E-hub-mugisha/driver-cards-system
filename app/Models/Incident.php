<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'type',
        'severity',
        'incident_date',
        'location',
        'description',
        'evidence',
        'reported_by',
        'impact_score',
        'root_cause_category',
        'root_cause_details',
        'responsibility',
        'approval_status',
        'rejection_reason',
        'approved_by',
        'approved_at'
    ];
    // App\Models\Incident.php
    protected $casts = [
        'incident_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Optional: reporter
    public function reporter()
    {
        return $this->belongsTo(\App\Models\User::class, 'reported_by');
    }
}
