<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ConvertCurrency extends Model
{
    use SoftDeletes;

    const BASE_PRICE = 0.15;

    protected $fillable = [
        'type','coversion' ,'user_id','usd_amt','to_id',
        'eth_amount', 'csm_amount', 'transaction_id','created_at','updated_at'
    ];

    protected $dates = [
        'deleted_at'
    ];

}
