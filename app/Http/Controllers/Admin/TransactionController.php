<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Currency;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\ConvertCurrency;

class TransactionController extends Controller
{
    public function index(Transaction $transaction, Currency $currency)
    {
        //~ $query = $transaction->orderBy('transactions.created_at', 'desc')->complete();
        $query = $transaction->orderBy('transactions.created_at', 'desc');

        $request = request();

        if(strcasecmp($request->get('search'), 'true')==0)
        {
            if($request->has('from_date') && ($request->from_date!="") && $request->has('to_date') && ($request->to_date!="")) {

                $dates = [
                    Carbon::parse($request->from_date)->toDateString(),
                    Carbon::parse($request->to_date)->toDateString()
                ];

                $query->whereBetween('transactions.created_at', $dates);

            }

            if($request->has('transaction_id') && ($request->transaction_id!="")) {
                $query->where('reference_no', $request->transaction_id);
            }

            if($request->has('user_info') && ($request->user_info!="")) {
				$all_users= User::orwhere('users.first_name', 'like', "%".$request->user_info."%")
                    ->orwhere('users.username', 'like', "%".$request->user_info."%")
                    ->orWhere('users.email', '=', $request->user_info)->pluck('id')->toArray();
               
                 $query->whereIn('user_id',$all_users);
               
            }

            if($request->has('currency') && ($request->currency!="")) {
                $query->where('transactions.currency_id', '=', $request->currency);
            }

            if($request->has('type') && ($request->type!="")) {
                $query->where('transactions.type', '=', $request->type);
            }


        }
		$deposit_amount_query=$buy_time_amount_query=$query;
		
		$result   = $query->get()->toArray();
		####################### Export ######################
        if($request->has('export')) { 
                $array = json_decode(json_encode($result), true); 
                $resultSet = array_map(function($record){ 
					$udetails=User::where('id',$record['user_id'])->first();
					$coinDetails=Currency::where('id',$record['currency_id'])->first();
                    return [          
                        'Email' => $udetails->email,
                        'Transaction ID' => $record['reference_no'],
                        'Source' => $record['source'],
                        'Type' => $record['type'],
                        'Coin' => $coinDetails->name,
                        'Amount' => $record['amount'],                       
                        'Description' => $record['description'],                       
                        'Status' => $record['status'],                                          
                        'Date' => $record['created_at'],                           
                    ];
                }, $array); 

			Excel::create('Member Transaction', function($excel) use($resultSet) {

				$excel->sheet('Date - '.date('Y-m-d'), function($sheet) use ($resultSet) {

					$sheet->setAutoSize(true);

					$sheet->fromArray($resultSet);

					$sheet->freezeFirstRow();
					$sheet->cells('A1:I1', function($cells) {
						$cells->setBackground('#000000');
						$cells->setFontColor('#ffffff');
						$cells->setFontFamily('Calibri');
						$cells->setFontSize(14);
						$cells->setFontWeight('bold');
						$cells->setAlignment('center');
						$cells->setValignment('center');
					});


				});

			})->download('xlsx');

		}
	
		
        $transactions = $query->paginate(20)->appends($request->query()); 
        $currencies = $currency->pluck('name', 'id');
       
        //~ $total_deposit_amount= $this->getSourceSum(clone $deposit_amount_query,'Coinpayments');
        //~ $approve_deposit_amount= $this->getSourceSum(clone $deposit_amount_query,'Coinpayments',1);
        $total_deposit_amount= Transaction::whereHas('currency', function($query){
            $query->where('name', 'USD');
        })->where('type', 'Credit')->get()
            ->sum('amount');
        $approve_deposit_amount= Transaction::whereHas('currency', function($query){
            $query->where('name', 'USD');
        })->where('type', 'Credit')->where('status', 1)->get()
            ->sum('amount');
  
  
		$debit_for_buy_time_amount= $this->getSourceSum(clone $deposit_amount_query,'Purchase CSM',null,'Debit'); 
		//~ $buy_time_amount= $this->getSourceSum(clone $deposit_amount_query,'Purchase CSM',null,'Credit'); 
		$buy_time_amount= Transaction::whereHas('currency', function($query){
            $query->where('name', 'CSM');
        })->where('type', 'Credit')->where('status', 1)->get()
            ->sum('amount');
		$total_withdraw_amount= $this->getSourceSum(clone $deposit_amount_query,'withdraw'); 
		$approved_withdraw_amount= $this->getSourceSum(clone $deposit_amount_query,'withdraw',1); 


        $bnb_transaction = ConvertCurrency::
        // where(function($q) {
        //          $q->where('type', 'buy')
        //            ->orWhere('type', 'buy_nft')
        //            ->orWhere('type', 'resell_nft')
        //            ->orWhere('type', 'unstake_amount')
        //            ->orWhere('type', 'stake_amount');
        //      })->
        orderBy('id', 'DESC')->paginate(10);

		
        return view('transaction.index',compact('transactions', 'currencies','total_deposit_amount','buy_time_amount',
        'total_withdraw_amount','approved_withdraw_amount','approve_deposit_amount','debit_for_buy_time_amount','bnb_transaction'));
    }
    
    public function getSourceSum($tquery,$source,$status=null,$type=null){
		 $tquery->where('source',$source);
		 if($status){
			 $tquery->where('status',$status);
		 }
		 if($type){
			 $tquery->where('type',$type);
		 }
		 return $tquery->sum('amount');
	}

    public function getDetails($id){

        $transaction = Transaction::find($id);
        if($transaction->operation_id != null){
            $details['operation'] = $transaction->operation()->first();
        }else{
            $details['payment'] = $transaction->payment()->first();
        }
        
        return view('transaction.transaction',compact('details','transaction'));
    }
}
