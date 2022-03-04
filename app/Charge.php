<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    /*
     * THIS will be used to provide referral bonus to user
     *
     */
    const REFERRAL_BONUS = 0.05;

    protected $fillable = [
        'currency_id', 'name',
        'display_name', 'description',
        'type', 'amount',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
