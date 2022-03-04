<?php
/**
 * Created by PhpStorm.
 * User: amit
 * Date: 22/5/17
 * Time: 2:15 PM
 */

namespace App\Repository\Exchange;


use App\Currency;
use App\Ticker;
use Illuminate\Support\Facades\Log;

class ExchangeRepository
{
   
    const EXCHANGE_VARIANCE = 0.00;

    public static function verifyWallet($address, $coin='BTC')
    {
        $btc = (env('ENABLE_TESTNET')) ? 'tBTC' : 'BTC';
        $url = 'https://api.blocktrail.com/v1/'.$btc.'/address/';
        $ch = curl_init($url.$address.'?api_key='.env('BLOCKTRAIL_KEY'));

        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);

        $output = curl_exec($ch);

        if ($err = curl_errno($ch)) {
            Log::error('CURL Connection error!'. $err);
            return false;
        }

        curl_close($ch);
        $result = json_decode($output);
        return !isset($result->code);
    }

    public static function getINRTOBTC($amount)
    {
        $url ='https://blockchain.info/tobtc?currency=INR&value';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url=$amount");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $output = curl_exec($ch);

        if ($error = curl_errno($ch)) {
            Log::error('Error Retrieving bitcoin price'.$error);
            return 0;
        }

        curl_close($ch);
        return $output;
    }

    public static function buyPrice($currency = 'BTC', $convert_currency='INR')
    {
        $btc = Currency::where('name', $currency)->first();
        $inr = Currency::where('name', 'INR')->first();

        $priceBtc = $btc->price()
            ->orderBy('synced_at', 'desc')
            ->pluck('buy_price')->first();
        if($currency=='BTC'){
            if(\App\Setting::where('key','buy_price_variance_btc')->first()==null){
                $varience = 0.00;
            }else{
            $varience = \App\Setting::where('key','buy_price_variance_btc')->first()->value;
            }
            $priceBtc = ($priceBtc + $varience);
        }
        
        $priceInr = $inr->price()
            ->orderBy('synced_at', 'desc')
            ->pluck('buy_price')->first();
        if($convert_currency=='INR'){
        $price = $priceBtc * $priceInr;
        }else{
        $price = $priceBtc;
        }
        return  $price;
    }

    public static function sellPrice($currency = 'BTC',$convert_currency='INR')
    {
        $btc = Currency::where('name', $currency)->first();
        $inr = Currency::where('name', 'INR')->first();
        $priceBtc = $btc->price()
            ->orderBy('synced_at', 'desc')
            ->pluck('sale_price')->first();
        if($currency=='BTC'){
            if(\App\Setting::where('key','sell_price_variance_btc')->first()==null){
                $varience = 0.00;
            }else{
            $varience = \App\Setting::where('key','sell_price_variance_btc')->first()->value;
            }
            $priceBtc = ($priceBtc - $varience);
        }
        
        $priceInr = $inr->price()
            ->orderBy('synced_at', 'desc')
            ->pluck('buy_price')->first();
        if($convert_currency=='INR'){
            $price = $priceBtc * $priceInr;
        }else{
            $price = $priceBtc;
        }
        
        return  $price;
    }
}