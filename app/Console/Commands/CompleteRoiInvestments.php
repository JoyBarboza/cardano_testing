<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\RoiInvestment;
use App\Transaction;

class CompleteRoiInvestments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:investment';

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
        $this->completeJpcInvestmentPlan();
    }
	
	protected function completeJpcInvestmentPlan(){
		$roiInvestment = RoiInvestment::whereRaw('`created_at` < DATE_SUB(NOW(), INTERVAL `duration` DAY)')
					->where('status',1)->get();
					
				
		foreach($roiInvestment as $investment){
			
			$payeecoin = \App\Currency::where('name',$investment->payout_coin)->first(); 
			
			
			Transaction::create([
                'user_id' => $investment->user_id,
                'currency_id' => $payeecoin->id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Credit',
                'amount' => $investment->amount_return,
                'description' => 'Cloud mining completed',
                'status' => 1,
			]);
			
			$investment->status = 3;
			$investment->save();
		}
	}
}
