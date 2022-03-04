<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'ide_no', 'pin_code', 'address', 'state','company','account_type',
        'city', 'country_id', 'locale','account_address_jpc','kyc_verified','is_kyc_verified_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
