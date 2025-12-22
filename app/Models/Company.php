<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','email','phone','address','status'
    ];

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function staff()
    {
        return $this->hasMany(CompanyStaff::class);
    }
}
