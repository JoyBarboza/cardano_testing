<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ConvertCurrency;
use App\User;

class TransactionController extends Controller
{
    public function index($currency=null)
    {
        $user = auth()->user();

        // echo "string";die;
        if($currency=='token'){
            $currency = env('TOKEN_SYMBOL');
        }
        
		$transactions = auth()->user()
            ->transaction()->latest();
            
		$request = request();

        if(strcasecmp($request->get('search'), 'true')==0)
        {
            if($request->has('from_date') && ($request->from_date!="")) {
		        $transactions->whereDate('created_at', '>=', Carbon::parse($request->from_date)->toDateString());           
            }
	
            if($request->has('to_date') && ($request->to_date!="")){
                $transactions->whereDate('created_at', '<=', Carbon::parse($request->to_date)->toDateString());
            }

            if($request->has('txnid') && ($request->txnid!="")) {
                $transactions->where('reference_no', $request->txnid);
            }

            if($request->has('currency') && ($request->currency!="")) {
                $transactions->where('transactions.currency_id', '=', $request->currency);
            }

            if($request->has('type') && ($request->type!="")) {
                $transactions->where('transactions.type', '=', $request->type);
            }


        }else{
        
			 if($currency!=null){   
				$transactions->whereHas('currency', function($query) use ($currency){
								$query->where('name', $currency);
							});
			 }   
			
		 }
         $transactions =   $transactions->paginate(10)->appends($request->query());
         $coin = new Currency();
         $currencies = $coin->pluck('name', 'id');


        $bnb_transaction = ConvertCurrency::where('to_id',$user->id)->orWhere('user_id',$user->id)
            ->where(function($q) {
                 $q->where('type', 'buy')
                   ->orWhere('type', 'buy_nft')
                   ->orWhere('type', 'resell_nft')
                   ->orWhere('type', 'unstake_amount')
                   ->orWhere('type', 'stake_amount');
             })
            ->orderBy('id', 'DESC')->paginate(10);

        return view('transaction.user-list', compact('transactions',  'currency','currencies','bnb_transaction'));
    }
}
