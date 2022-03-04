<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'currency_id', 'reference_no',
        'type', 'source', 'description',
        'amount', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'transaction_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeInComplete($query)
    {
        return $query->where('status', 0)->where('source','BankDeposit');
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 1);
    }

    public function getStatusAttribute($value)
    {
        return ['Pending', 'Success', 'Failed'][$value];
    }

    /*public static function revenueChart()
    {
        return collect(DB::select('call sp_getFeeCollection()'));
    }*/

    public static function amountChart($currency)
    {
        return collect(DB::select('call sp_getTransactionAmount(?)', [$currency]));
    }

    public function saleTimeTransaction($start, $end, $currency, $type){
        $total_amount = Transaction::where('created_at', '>=', $start)
                                ->where('created_at', '<=', $end)
                                ->where('currency_id',$currency)
                                ->where('type',$type)
                                ->sum('amount');

        return $total_amount;
    }


    public function scopeDeposit($query)
    {
        return $query->whereType('Credit');
    }

    public function getAddressAttribute($value)
    {
        return $value?:'Not Available';
    }

    public function creditTotal($currency)
    {
        return $this->whereHas('currency', function($q) use ($currency) {
            $q->where('name', $currency);
        })->where('status', 1)->where('type', 'Credit')->sum('amount');
    }

    public function debitTotal($currency)
    {
        return $this->whereHas('currency', function($q) use ($currency) {
            $q->where('name', $currency);
        })->where('status', 1)->where('type', 'Debit')->sum('amount');
    }
}
