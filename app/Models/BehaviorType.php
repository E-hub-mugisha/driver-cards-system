<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorType extends Model
{
    protected $fillable = [
        'behavior_category_id',
        'name',
        'category',
        'severity',
        'default_score',
        'is_active',
    ];

    public function behaviorCategory()
    {
        return $this->belongsTo(BehaviorCategory::class, 'behavior_category_id');
    }


    public function driverBehaviors()
    {
        return $this->hasMany(DriverBehavior::class);
    }
}
