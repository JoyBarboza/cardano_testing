<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoiInvestment extends Model
{
   

    protected $fillable = [
        'plan_id', 'user_id', 'amount_investment', 'amount_return','duration', 'percentage', 'status', 'price','payin_coin','payout_coin'
    ];

   
    public function roiPlan()
    {
        return $this->belongsTo(RoiPlan::class, 'plan_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    protected function getStatusAttribute($value)
    {
        return ['','Ongoing','Canceled', 'Completed'][$value];
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDayDateTimeString();
    }
}
