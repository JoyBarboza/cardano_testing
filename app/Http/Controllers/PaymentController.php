<?php

namespace App\Http\Controllers;

use App\CoinAddress;
use App\Events\DepositDone;
use App\Payment;
use App\Currency;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repository\Payment\CoinpaymentRepository;
use Kevupton\LaravelCoinpayments\Exceptions\IpnIncompleteException;

class PaymentController extends Controller
{
	
	public function depositJpcNotification(Request $request){
		
		if($request->input('txid')){
			
			$txid = trim($request->input('txid'));
			
			$tx_info = bitcoind()->client('jpcoin')->getTransaction($txid)->get();		   
			
		
					
			if(isset($tx_info["details"])){
				$details = $tx_info["details"];
				
				foreach($details as $tx_detail){
					if(isset($tx_detail["category"]) and isset($tx_detail["address"]) and isset($tx_detail["amount"]) ){
						if($tx_detail["category"] == "receive"){
							if($tx_detail["amount"]>0){
								
								$coin_id = Currency::where('name', 'JPC')->latest()->pluck('id')->first();
								
								$query = CoinAddress::where('coin_id', $coin_id)->where('address', $tx_detail["address"]);

								if($query->exists()) {
					
									$coinAddress = $query->first();

									$transaction = Transaction::where('reference_no',$txid)->first();
									
									if($transaction){
										
										Payment::where('reference_no',$txid)->update(['confirm'=>$tx_info["confirmations"]]);
										
										if($tx_info["confirmations"]>0 and $transaction->status==0){
											$transaction->status = 1;
											$transaction->amount = $tx_detail["amount"];
											$transaction->save();										
										}
									}else{
										$transaction = new Transaction();
										
										$transaction->user_id = $coinAddress->user->id;
										$transaction->currency_id = $coinAddress->currency->id;
										$transaction->reference_no = $txid;
										$transaction->type = 'Credit';
										$transaction->amount = $tx_detail["amount"];
										$transaction->source = 'Deposit';
										$transaction->status = 0;
										
										if($tx_info["confirmations"]>0){
											$transaction->status = 1;
										}
										
										$transaction->save();
										
										Payment::create([
											'user_id' => $coinAddress->user->id,
											'transaction_id' => $transaction->id,
											'address' => $coinAddress->address,
											'reference_no' =>  $txid,
											'remarks' => 'JPCDeposit',
											'confirm' => 0
										]);
									}
									
								}
							}
						}
						
					}
				}			
				
			}
				
		}
	}
	
    public function notification(Request $request)
    {
		//Log::info('Payment controller request data is '.$request->getContent());

        try {

            // do something with the completed transaction

	        $ipn = \Coinpayments::validateIPNRequest($request);

            Log::info($ipn);

            if($ipn->isWithdrawal()) {

                $address = $request->input('address');
                $transaction_id = $request->input('txn_id');

                $withdrawID = $request->input('id');

                $query = Payment::where('reference_no', $withdrawID)
                    ->where('address', $address);

                if($query->exists()) {
                    $query->update([
                        'reference_no' => $transaction_id,
                    ]);

                    event(new DepositDone($query->first()));
                }
            }

            if ($ipn->isApi()) {
		
				$getCurrency = Currency::where('name',$ipn->currency1)->latest()->pluck('id')->first();
			
                //~ $query = Transaction::where('reference_no', $ipn->txn_id)
                    //~ ->whereHas('currency', function($q) use ($ipn){
                        //~ $q->where('name', $ipn->currency1);
                    //~ })->pending();
                    
                $query = Transaction::where('reference_no', $ipn->txn_id);
				if($getCurrency){
				   $query->where('currency_id',$getCurrency);
				} 
				$query->pending(); 

                if($query->exists() && $ipn->isComplete()) {
                    $query->update([
                        'amount' => $ipn->amount1,
                        'status' => 1
                    ]);

                    $qry = Payment::where('reference_no', $ipn->txn_id);

                    if($qry->exists()) {
                        $qry->update([ 'confirm' => 1]);
                        event(new DepositDone($qry->first()));
                    }
                }
            }
        } catch (\Exception $e) {

            if($e instanceof IpnIncompleteException) {
                $ipn = $e->getIpn();

                if($ipn->isApi()) {
					$getCurrency = Currency::where('name',$ipn->currency1)->latest()->pluck('id')->first();
                    //~ $query = Transaction::where('reference_no', $ipn->txn_id)
                        //~ ->whereHas('currency', function($q) use ($ipn){
                            //~ $q->where('name', $ipn->currency1);
                        //~ })->pending();
                    $query = Transaction::where('reference_no', $ipn->txn_id);
					if($getCurrency){
					   $query->where('currency_id',$getCurrency);
					}
					$query->pending(); 

                    if($query->exists() && ($ipn->status == -1)) {
                        $query->update([
                            'amount' => $ipn->amount1,
                            'status' => 2
                        ]);
                        $qry = Payment::where('reference_no', $ipn->txn_id);
                        if($qry->exists()) {
                            $qry->update([ 'confirm' => 2]);
                        }
                    }
                }
            } else {
                Log::error($e);
            }
        }
    }
}

