<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinAddress extends Model
{
    protected $fillable = [
        'user_id', 'coin_id','address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'coin_id');
    }
}
