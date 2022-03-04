<?php

namespace App\Console\Commands;

use App\Currency;
use App\Ticker;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SynchronizePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will synchronize all the currency price by fetching from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $allPrice = $this->fetchPrice();
        //$prices = $this->fetchBtcPrice();
        if(!empty($allPrice)){

            foreach($allPrice as $price){

                if($price->symbol != 'JPC'){
                    $currency = Currency::where('name', $price->symbol)->first();
                    if(isset($currency->name)){
                        $currency->price()->save(new Ticker([
                            'buy_price' => $price->price_usd,
                            'sale_price' => $price->price_usd,
                            'last_price' => $price->price_usd,
                            'buy_inr_price' => $price->price_inr,
                            'sell_inr_price' => $price->price_inr,
                            'last_inr_price' => $price->price_inr,
                            'synced_at' => Carbon::now()
                        ]));
                    }
                }

            }
        }


        /*$pricesBTC = $this->fetchBtcPrice();
        $pricesINR = $this->fetchInrPrice();
        if($pricesBTC) {
            $currency = Currency::where('name', 'BTC')->first();

            $currency->price()->save(new Ticker([
                'buy_price' => $pricesBTC->USD->buy,
                'sale_price' => $pricesBTC->USD->sell,
                'last_price' => $pricesBTC->USD->last,
                'buy_inr_price' => round(($pricesBTC->USD->buy * $pricesINR->rates->INR)),
                'sell_inr_price' => round(($pricesBTC->USD->sell * $pricesINR->rates->INR)),
                'last_inr_price' => round(($pricesBTC->USD->last * $pricesINR->rates->INR)),
                'synced_at' => Carbon::now()
            ]));
        }*/

        
        $pricesINR = $this->fetchInrPrice();
        if($pricesINR) {
            $currency = Currency::where('name', 'INR')->first();

            $currency->price()->save(new Ticker([
                'buy_price' => round($pricesINR->rates->INR),
                'sale_price' => round($pricesINR->rates->INR),
                'synced_at' => Carbon::now()
            ]));
        }

        Ticker::where('synced_at', '<', Carbon::now()->subMonth(3))->delete();

    }

    protected function fetchBtcPrice()
    {
        $url ='https://blockchain.info/ticker';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $output = curl_exec($ch);

        if ($error = curl_errno($ch))
        {
            Log::error('Error Retrieving bitcoin price'.$error);
            return null;
        }
        curl_close($ch);
        return json_decode($output);
    }

    protected function fetchPrice(){

        $url = 'https://api.coinmarketcap.com/v1/ticker/?convert=INR';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $output = curl_exec($ch);

        if ($error = curl_errno($ch))
        {
            Log::error('Error Retrieving bitcoin price'.$error);
            return null;
        }
        curl_close($ch);
        return json_decode($output);
    }

    protected function fetchInrPrice()
    {
        $url ='http://api.fixer.io/latest?base=USD&symbols=INR';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $output = curl_exec($ch);

        if ($error = curl_errno($ch))
        {
            Log::error('Error Retrieving bitcoin price'.$error);
            return null;
        }
        curl_close($ch);
        return json_decode($output);
    }
}
