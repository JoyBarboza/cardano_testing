<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CoinTransaction;
use App\Coin;
use DB;

class UpdateJpcTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jpc:transaction';

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
		$coin = Coin::where('coin','JPC')->first();
		
		$query = CoinTransaction::where('coin_id', $coin->id)->where('status',0)->where('type','Credit')->get();
		
		DB::transaction(function() use ($query) {
			foreach($query as $info){
				$tx_info = bitcoind()->client('jpcoin')->getTransaction($info->reference_no)->get();
				
				if(isset($tx_info['confirmations'])){
				
					if($tx_info['confirmations'] > 0){
						$info->status = 1;
						$info->save();
						
						$info->transaction->status = 1;
						$info->transaction->save();
					}
				}
			}
		});
    }
}
