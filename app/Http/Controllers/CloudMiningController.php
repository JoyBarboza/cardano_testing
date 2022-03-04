<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\RoiInvestment;
use App\RoiPlan;
use App\Presale;
use App\Transaction;
use App\Setting;
use DB;

class CloudMiningController extends Controller
{
    public function index()
    {
		$roiPlan = RoiPlan::where('status',1)->get();
		$roiInvestments = RoiInvestment::where('user_id',auth()->id())->latest()->paginate(10);
        return view('cloud-mining.index',compact('roiPlan','roiInvestments'));
    }
	
	

    public function oparetion(Request $request){
		
		
        
		
        $this->validate($request,[
            'plan' => 'required',
            'investment' => 'required|numeric'
                       
        ],[
           
                 
            'investment.required' => 'The Core Mining amount required'
        ]);
		
		$investment = $request->input('investment');
		$userID = auth()->id();
		$roiPlan = RoiPlan::findOrFail($request->input('plan'));
		
		$payin_coin= $roiPlan->payin_coin;
		$payeecoin = \App\Currency::where('name',$payin_coin)->first();
		
		$payout_coin= $roiPlan->payout_coin;
		$user_balance= auth()->user()->{$payin_coin};
		
		$min_coin= $roiPlan->min_coin;
		$max_coin= $roiPlan->max_coin;
		
		if($investment < $min_coin){
			flash()->error('The Core Mining amount amount must be at least '.$min_coin);
			return redirect()->back()->withInput($request->input());
		}
		if($investment > $max_coin){
			flash()->error('The Core Mining amount may not be greater than '.$max_coin);
			return redirect()->back()->withInput($request->input());
		}

        if($user_balance < $investment){
			flash()->error('Your '.$payin_coin.' Wallet doesn\'t have sufficient fund');
			return redirect()->back()->withInput($request->input());
		}
		
		
		$returnAmountPer100 = $roiPlan->token_price;
		$return =($returnAmountPer100*$investment)/100;
		
		
		//~ flash()->error('Core Mining is in maintainence mode');
		//~ return redirect()->back();
		
        $investment_data = [
            'user_id' => $userID,
            'plan_id' => $roiPlan->id,
            'amount_investment' => $investment,
            'amount_return' => $return,
            'duration' => $roiPlan->duration,
            'percentage' => $roiPlan->percentage,
            'payin_coin' => $roiPlan->payin_coin,
            'payout_coin' => $roiPlan->payout_coin,
            
            'price' => $returnAmountPer100
        ];
		
		$transaction_data = [
                'user_id' => $userID,
                'currency_id' => $payeecoin->id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Debit',
                'amount' => $investment,
                'description' => 'Core mining started',
				'status' =>1
        ];
		
        DB::transaction(function() use ($investment_data,$transaction_data) {
			Transaction::create($transaction_data);
			RoiInvestment::create($investment_data);
        });
		
		
		flash()->success('Core Mining Plan has been successfully activated');
		return redirect()->back();        
        

    }
    
}
