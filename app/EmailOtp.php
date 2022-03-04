<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $fillable = [
        'user_id', 'email_otp','type','email'
    ];
}
