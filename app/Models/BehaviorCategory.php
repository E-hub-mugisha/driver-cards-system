<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function behaviorTypes()
    {
        return $this->hasMany(BehaviorType::class);
    }
}
