<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description',
    ];

    const EXCHANGE_VARIANCE = 0.00;

    public function price()
    {
        return $this->hasMany(Ticker::class, 'currency_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'currency_id');
    }

    public function ticker()
    {
        return $this->hasMany(Ticker::class, 'currency_id');
    }

    public function charge(){

        return $this->hasMany(Charge::class, 'currency_id');
    }

    public function actualBuyPrice($currency='USD')
    {
        $price = $this->price()->orderBy('synced_at', 'desc')->first();
        /*if($this->name=='BTC'){
            if(\App\Setting::where('key','buy_price_variance_btc')->first()==null){
                $varience = 0.00;
            }else{
            $varience = \App\Setting::where('key','buy_price_variance_btc')->first()->value;
            }
            $price->buy_price = $price->buy_price + $varience;
        }*/
        return ($currency=='USD') ? $price->buy_price : $price->buy_inr_price;
    }

    public function actualSellPrice()
    {
        $price = $this->price()->orderBy('synced_at', 'desc')->first();
        if($this->name=='BTC'){
            if(\App\Setting::where('key','sell_price_variance_btc')->first()==null){
                $varience = 0.00;
            }else{
                $varience = \App\Setting::where('key','sell_price_variance_btc')->first()->value;
            }
            $price->sale_price = $price->sale_price - $varience;
        }
        return $price->sale_price;
    }
    
    public function getCoinByName($name)
    {
		return Currency::where('name',$name);
	}


    public function activeCurrency()
    {
        return $this->whereIn('name', ['BTC', 'USD', 'DASH', 'JPC', 'ETH', 'XMR','BCH', 'LTC']);
    }
}
