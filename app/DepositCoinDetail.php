<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositCoinDetail extends Model
{
    //
    protected $fillable = [
        'coin', 'address', 'status'
    ];
    
}
