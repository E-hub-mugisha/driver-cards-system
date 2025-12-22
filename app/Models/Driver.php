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
        'names',
        'ID_number',
        'driver_license',
        'phone',
        'rssb',
        'contract_type',
        'insurance',
        'photo',
        'contract',
        'status',
        'company_id',
        'performance_score',
        'risk_level',
    ];

    // Company relation
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function behaviors()
    {
        return $this->hasMany(DriverBehavior::class);
    }

    // Performance badge based on score
    public function getPerformanceBadgeAttribute()
    {
        if ($this->performance_score >= 80) {
            return 'Excellent';
        } elseif ($this->performance_score >= 50) {
            return 'Good';
        } elseif ($this->performance_score >= 20) {
            return 'Risky';
        } else {
            return 'Critical';
        }
    }

    // Average behavior score for a month
    public function monthlyPerformance($month = null)
    {
        $month = $month ?: now()->startOfMonth();
        return $this->behaviors()
            ->whereMonth('behavior_date', $month->month)
            ->whereYear('behavior_date', $month->year)
            ->sum('score');
    }

    // Accessor for full display name
    public function getDisplayNameAttribute()
    {
        return "{$this->names} ({$this->ID_number})";
    }

    public function incidents()
{
    return $this->hasMany(Incident::class);
}

}
