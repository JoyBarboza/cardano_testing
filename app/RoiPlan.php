<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoiPlan extends Model
{

    protected $fillable = [
        'name', 'duration', 'percentage', 'status','token_price','payin_coin','payout_coin','min_coin','max_coin'
    ];


}
