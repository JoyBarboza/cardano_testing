<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use SoftDeletes;

	protected $fillable = [
		 'user_id','currency_id','transaction_id','address','amount','fees','remarks','description','status','t_hash','decline_reason','net_amount','withdraw'
    ];
   

    protected $dates = [
        'deleted_at'
    ];

   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getStatusAttribute($value)
    {
        return ['Pending','Approved','Declined'][$value];
    }

    public function scopePending($query)
    {
        return $query->whereStatus(0);
    }

    public function scopeApproved($query)
    {
        return $query->whereStatus(1);
    }

    public function scopeDeclined($query)
    {
        return $query->whereStatus(2);
    }
    
    public function searchWithdraw(array $searchField)
    {
        return DB::select('call SP_GetAllWithdraw(?,?,?,?,?,?,?)', $searchField);
    }

}
