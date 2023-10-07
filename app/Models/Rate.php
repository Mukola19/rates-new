<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;


    protected  $fillable = ['sale', 'purchase'];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }


    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
