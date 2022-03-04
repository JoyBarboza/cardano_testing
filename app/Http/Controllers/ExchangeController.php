<?php namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Snowfire\Beautymail\Beautymail;
use App\User;
use App\Payment;
use App\CoinAddress;
use App\Transaction;
use App\Currency;

class ExchangeController extends Controller
{

    public function __construct(
        Transaction $transaction, Payment $payment,
        Currency $currency
    ) {
        $this->transaction = $transaction;
        $this->payment = $payment;
        $this->currency = $currency;
        
    }


    public function index(){

        return view('coin.exchange');
    }




    public function oparetion(Request $request){
        
        //print_r($request->all());die();
        $payeecoin = \App\Currency::find($request->input('PaycurrencyId')); 
        $receivecoin = \App\Currency::find($request->input('ReceivecurrencyId'));
        $this->validate($request,[
            'paycurrency' => 'required|check_fund:'.strtolower($payeecoin->name),
        ],[
            'paycurrency.check_fund' => 'Your '.$payeecoin->name.' Wallet doesn\'t have sufficient fund'
        ]);

        

        if($payeecoin->name != $receivecoin->name){

        $currency = \App\Currency::find(1); // for global;
        $site_fee = $currency->charge()->where('name','SITEFEE')->first();
        $tax = $currency->charge()->where('name','TAX')->first();
        $getwayfee = $currency->charge()->where('name','OTHERS')->first();


        if($request->input('PaycurrencyId')==3 && $request->input('ReceivecurrencyId') != 3 ){
            $payeecoinprice = 1;
            $receivecoinprice = $receivecoin->actualBuyPrice('INR');
        }else if($request->input('ReceivecurrencyId')==3 && $request->input('PaycurrencyId') != 3){
            $payeecoinprice = $payeecoin->actualBuyPrice('INR');
            $receivecoinprice = 1;
        }else{
            $payeecoinprice = $payeecoin->actualBuyPrice();
            $receivecoinprice = $receivecoin->actualBuyPrice();
            $tax->amount = 0;
        }


        

        $feefactor =($site_fee->amount/100);
        $taxfactor = ($tax->amount/100);
        $totalpaycurrency = ($payeecoinprice*$request->input('paycurrency'));
        $totalreceivecurrency = ($totalpaycurrency/$receivecoinprice);
        $finalfee = ($totalreceivecurrency*$feefactor);
        $finalTax = ($totalreceivecurrency*$taxfactor);
        $finalreceivecurrency = ($totalreceivecurrency-($finalfee+$finalTax));
        $other = 0.00;

        $userID = auth()->id();
        $operation = [
            //'txnid' => uniqid('TXN'.time()),
            'user_id' => $userID,
            'name' => $payeecoin->name.'_'.$receivecoin->name,
            'source_currency_id' => $payeecoin->id,
            'source_amount' => $request->input('paycurrency'),
            'fees' => round($finalfee,8),
            'tax' => round($finalTax,0),
            'other' => round($other),
            'destination_currency_id' => $receivecoin->id,
            'destination_amount' => $finalreceivecurrency,
            'remarks' => 'Exchange Oparetion',
        ];

        $opId = DB::transaction(function() use ($operation,$payeecoin,$receivecoin) {

            $operation = $this->operation->create($operation);
            $transaction_payee = Transaction::create([
                'operation_id' => $operation->id,
                'user_id' => $operation->user_id,
                'currency_id' => $operation->source_currency_id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Debit',
                'amount' => $operation->source_amount,
            ]);

            $transaction_recive = Transaction::create([
                'operation_id' => $operation->id,
                'user_id' => $operation->user_id,
                'currency_id' => $operation->destination_currency_id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Credit',
                'amount' => $operation->destination_amount,
            ]);

            $operation->update(['status' => 2]);
            $transaction_recive->update(['status'=>1]);
            $transaction_payee->update(['status'=>1]);

            ///  Email should be triggered here ///////////////

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('emails.exchange', ['paycoin'=>$payeecoin->name, 'receivecoin'=>$receivecoin->name,'oparetion'=>$operation], function($message)
            {
                $message
                    ->to(auth()->user()->email, auth()->user()->fullName)
                    ->subject('Currency Exchange Details - ');
            });
            
            flash()->success(trans('auth/controller_msg.Currency_has_been_successfully_exchanged'));
            return $operation->id;

        });
            
            if($opId){
                return redirect()->route('exchange.success',['operation_id'=>$opId]);
            }else{
                flash()->error(trans('auth/controller_msg.Sorry_Something_went_wrong'));
                return redirect()->back(); 
            }
        
        }else{

        flash()->error(trans('auth/controller_msg.Sorry_Pay_Receive_Currency_should_be_different'));
        return redirect()->back();
        }

        
        

    }

    public function Successoparetion($op){

        $userID = auth()->id();
        $oparetion = Operation::where('id',$op)->where('user_id',$userID);
        if($oparetion->exists()){
            $oparetion = $oparetion->first();
            $payeecoin = \App\Currency::find($oparetion->source_currency_id);
            $receivecoin = \App\Currency::find($oparetion->destination_currency_id);
            return view('coin.success',['paycoin'=>$payeecoin->name, 'receivecoin'=>$receivecoin->name,'oparetion'=>$oparetion]);

        }else{

            return redirect()->to('exchange');

        }

        


    }
}
