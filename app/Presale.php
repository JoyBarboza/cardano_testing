<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Presale extends Model
{
    use SoftDeletes;

    const BASE_PRICE = 0.15;

    protected $fillable = [
        'start_date', 'end_date','total_coin_unit',
        'unit_price', 'discount_percent', 'status','sold_coin'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function currentSale()
    {
        $current_date = date('Y-m-d');

        return $this->whereDate('start_date', '<=', $current_date)
            ->whereDate('end_date', '>=', $current_date)
            ->first();
    }

    public function totalSale()
    {
        //~ return Transaction::whereHas('currency', function($query){
            //~ $query->where('name', 'CSM');
        //~ })->whereDate('created_at', '>=', $this->start_date)       
            //~ ->whereDate('created_at', '<=', $this->end_date)
            //~ ->where('type', 'Credit')->get()
            //~ ->sum('amount'); 
            return ($this->csmCredit())-($this->csmDebit());
    }
    
    public function csmCredit()
    {
        return Transaction::whereHas('currency', function($query){
            $query->where('name', 'CSM');
        })->whereDate('created_at', '>=', $this->start_date)       
            ->whereDate('created_at', '<=', $this->end_date)
            ->where('type', 'Credit')->get()
            ->sum('amount');
    }
    
     public function csmDebit()
    {
        return Transaction::whereHas('currency', function($query){
            $query->where('name', 'CSM');
        })->whereDate('created_at', '>=', $this->start_date)       
            ->whereDate('created_at', '<=', $this->end_date)
            ->where('type', 'Debit')->get()
            ->sum('amount');
    }

    public function getRemainingVolumeAttribute()
    {
        return $this->total_coin_unit - $this->sold_coin;
    }

    public function getRemainingPercentAttribute()
    {
        return (100 - round(($this->remaining_volume * 100) / $this->total_coin_unit));
    }


    public function getIsSoldOutAttribute()
    {
        return ($this->end_date < date('Y-m-d'));
    }

    public function getIsCurrentAttribute()
    {
        $today = date('Y-m-d');
        return ($this->start_date <= $today)&& ($this->end_date >= $today);
    }

    public function existingSale($start_date='',$end_date='')
    {
        return $this->where(function($query) use ($start_date,$end_date){
                 $query->whereDate('start_date', '<=', $start_date);
                 $query->whereDate('end_date', '>=', $start_date);
             })->orWhere(function($query) use ($start_date, $end_date){
                 $query->whereDate('start_date', '<=', $end_date);
                 $query->whereDate('end_date', '>=', $end_date);
             });
    }

    public function scopeActiveStatus($query)
    {
		return $query->where('status',1)->whereRaw('presales.total_coin_unit > presales.sold_coin')->whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date','ASC');
        
    }


    public function scopeActive($query)
    {
		return $query->where('status',1)->whereRaw('presales.total_coin_unit > presales.sold_coin')->whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date','ASC');
        
        //~ $current_date = date('Y-m-d');
        //~ $active= $query->where('status', 1)
            //~ ->whereDate('start_date', '<=', $current_date)
            //~ ->whereDate('end_date', '>=', $current_date); 
        //~ if($active->count()==0){
			//~ $active= $this->where('status', 1)->latest(); 
		//~ } 
		//~ return $active;
    }
    
    public function totalPresaleCoin(){
		return $this->sum('total_coin_unit');
	}
	
	public function currentSaleTotal($start_date,$end_date)
    {
		return Transaction::whereHas('currency', function($query){
            $query->where('name', 'CSM');
        })->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->sum('amount');
	}
	
	public function totalSoldCoin(){
		//~ return Transaction::whereHas('currency', function($query){
            //~ $query->where('name', 'CSM');
        //~ })->where('type','Credit')
        //~ ->sum('amount');
        
       $this->sum('sold_coin');
	}
}
