<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public function rate()
    {
        return $this->belongsTo(Bank::class, 'id', 'rate_id');
    }

}
