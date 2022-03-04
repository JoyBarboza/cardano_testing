<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    //
    protected $fillable = [
        'uid', 'currency_id', 'reference_no',
        'status','description','amount','approved_amount','remarks','deposit_coin','deposit_address'
    ];
    protected $table = 'BankDeposits';
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
