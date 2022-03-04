<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'transaction_id', 'address',
        'reference_no', 'remarks', 'confirm'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
