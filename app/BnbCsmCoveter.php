<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BnbCsmCoveter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'csm','bnb'
    ];
}
