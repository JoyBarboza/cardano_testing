<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Transaction;
use App\Profile;
use App\Currency;

class KycVerifiedBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:kycBonus';

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
		$currencies=Currency::where('kyc_verified_amount','>',0)->where('status',1)->get();
		
		if(count($currencies) > 0){
		   $getProfile=Profile::where('is_kyc_verified_amount',0)->where('kyc_verified',1)->get();
		   if($getProfile){
				foreach($getProfile as $profile){
					foreach($currencies as $currency){
						$transaction = [
							'user_id' => $profile->user_id,
							'source' => 'KYC Bonus',
							'description' => 'KYC Bonus',
							'currency_id' => $currency->id,
							'reference_no' => time().$profile->user_id,
							'type' => 'Credit',
							'amount' => $currency->kyc_verified_amount,
							'status' => 1
						];
						Transaction::create($transaction); 
					}
					$profile->is_kyc_verified_amount=1;
					$profile->save();
				}
			}
		}
    }
	
}
