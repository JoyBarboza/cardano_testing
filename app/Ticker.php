<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'currency_id', 'buy_price', 'sale_price','last_price', 'buy_inr_price', 'sell_inr_price', 'last_inr_price'
    ];

    protected $dates= [
        'synced_at'
    ];


    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
