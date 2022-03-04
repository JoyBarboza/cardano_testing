<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Currency;
use App\Ticker;
use Carbon\Carbon;

class SynCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:syncurrency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url = "https://api.coinmarketcap.com/v1/ticker/?convert=INR";
        $data = json_decode(file_get_contents($url),true);
        foreach($data as $symbol){

            if($symbol['symbol'] != 'BTC' and $symbol['symbol'] != 'JPC') {

                $currency = new Currency;
                $currency->name = $symbol['symbol'];
                $currency->description = $symbol['name'];
                $currency->save();

            }

        }

    }
}
