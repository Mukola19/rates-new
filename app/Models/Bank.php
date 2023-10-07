<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public function rates()
    {
        return $this->hasMany(Rate::class, 'bank_id', 'id');
    }
}
