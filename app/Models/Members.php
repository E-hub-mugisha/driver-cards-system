<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'company_id'); // adjust foreign key if different
    }
}
