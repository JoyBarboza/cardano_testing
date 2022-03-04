<?php

namespace App\Http\Controllers;

use App\DepositCoinDetail;
use App\Setting;
use App\Payment;
use App\Presale;
use App\Currency;
use App\Transaction;
use App\CoinAddress;
use App\BankDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\Currency\JPCoin;
use Illuminate\Support\Facades\Log;
use App\ConvertCurrency;


class DepositController extends Controller
{
    public function index()
    {
        return view('deposit.index'/*,compact('presale')*/);
    }
	

    public function depositMoney($currency)
    {
		$wire_transfer = Setting::where('key', 'wire_transfer')
            ->pluck('value')->first();
            
        switch($currency)
        {
            case 'usd':
                return view('deposit.usd', compact('wire_transfer'));
            // case 'jpc':
            //     return $this->depositJpc();
            case 'btc':
                return $this->depositCoins('BTC');
            case 'ltc':
                return $this->depositCoins('LTC');
            case 'ltct':
                return $this->depositCoins('LTCT');
            case 'msc':
                return $this->depositMSC();
            default:
                return redirect()->back();
        }
    }

    public function paypalDeposit(Request $request){

        
       // print_r($request->all());die();
       $user = auth()->user();
        try {
            
            if($user->id==$request->input('user_id')){
                $currency_id = Currency::where('name', 'USD')->pluck('id')->first();

                $transaction = [
                    'user_id' => $request->input('user_id'),
                    'currency_id' => $currency_id,
                    'reference_no' => $request->input('txn'),
                    'type' => 'Credit',
                    'amount' => $request->input('amount'),
                    'status'=>1,
                    'source' => 'Paypal',
                    'description'=> 'Deposit From Paypal'
                ];


                DB::transaction(function() use ($transaction) {

                    $transaction = Transaction::create($transaction);

                });

                return redirect()->back()->with('sueecss-paypal', trans('auth/controller_msg.Your_Payment_has_made_succesfully').' Txn-id:'.$request->input('txn'));
            }else{
                flash()->error('Something went wrong!');
                return redirect()->back();
            }

        } catch (\Exception $exception) {

            Log::error('Error in creating coin transaction '.$exception->getMessage());

            flash()->error($exception->getMessage());
        }
        return redirect()->back();
    }

    private function depositCoins($currency)
    {
        $user = auth()->user();
        $query = $user->coinaddress()
            ->whereHas('currency', function($q) use ($currency) {
                $q->where('name', strtoupper($currency));
            });

        if($query->exists()) {
            $coinAddress = $query->first();

        } else {
            $address = \Coinpayments::getCallbackAddress($currency);

            $coinAddress = CoinAddress::create([
                'user_id'=>$user->id,
                'coin_id'=>$currency->id,
                'address'=>trim($address['address'])
            ]);
        }

        return view('deposit.currency', compact('coinAddress'));
    }

    private function depositJpc()
    {
        $user = auth()->user();
        $query = $user->coinaddress()
            ->whereHas('currency', function($q) {
                $q->where('name', strtoupper('jpc'));
            });

        $coin = Currency::where('name', 'JPC')->first();

        if($query->exists()) {
            $coinAddress = $query->first();

        } else {
            $newAddress = bitcoind()->client('jpcoin')->getNewAddress()->get();

            $coinAddress = CoinAddress::create([
                'user_id'=>$user->id,
                'coin_id'=>$coin->id,
                'address'=>trim($newAddress)
            ]);
        }

        $address = $coinAddress->address;

        return view('deposit.jpc', compact('address'));
    }

    private function depositMSC(){
        
    }

    public function makeDeposit(Request $request, $currency)
    {
        switch($currency) {
            case 'usd' :
                return $this->usdDeposit($request);
            default :
                return redirect()->back();
        }
    }

    private function usdDeposit(Request $request)
    {
		
        $this->validate($request, [
            'payable_currency' => 'required|in:BTC,BCH,XMR,DASH,LTC,ETH,BNB,USDT.ERC20,USDT.BEP20,USDT.BEP2,BUSD,BUSD.BEP2,BUSD.BEP20,USDC.BEP20,USDC,TUSD,ADA',
            'amount' => 'required|numeric'
            
        ]);

        $amount = $request->input('amount');
        $currencyToPay = $request->input('payable_currency');
        $user = auth()->user();

        try {
            $cpTansaction = \Coinpayments::createTransactionSimple($amount, 'USD', $currencyToPay, ['buyer_email' => $user->email]); 

            $currency_id = Currency::where('name', 'USD')->pluck('id')->first();

            $transaction = [
                'user_id' => auth()->id(),
                'currency_id' => $currency_id,
                'reference_no' => $cpTansaction->txn_id,
                'type' => 'Credit',
                'amount' => $amount,
		        'source' => 'Coinpayments',
            ];

            $payment = [
                'user_id' => auth()->id(),
                'address' => $cpTansaction->address,
                'reference_no' => $cpTansaction->txn_id,
                'remarks' => 'USDDeposit'
            ];

            DB::transaction(function() use ($transaction, $payment) {

                $transaction = Transaction::create($transaction);

                $payment['transaction_id'] = $transaction->id;

                Payment::create($payment);

            });

            return redirect()->back()->with('transaction', $cpTansaction);

        } catch (\Exception $exception) {
            
            Log::error(trans('auth/controller_msg.Error_in_creating_coin_transaction').$exception->getMessage());

            flash()->error($exception->getMessage());
        }
        return redirect()->back();
    }

    public function ConfirmDeposit(Request $request){
		$getcoins=DepositCoinDetail::where('status',1)->pluck('coin')->toArray();
        
        $this->validate($request, [
            'ref_no' => 'required',
            'amount' => 'required|numeric',
            'deposit_coin' => 'required|in:'.implode(',',$getcoins)
        ]);
        
        $coinDetails=DepositCoinDetail::where('status',1)->where('coin',$request->deposit_coin)->first();
        

        try {
            BankDeposit::create([

                'uid'=> auth()->id(),
                'reference_no' => $request->input('ref_no'),
                'currency_id' =>1,
                'deposit_coin' =>$request->deposit_coin,
                'deposit_address' =>$coinDetails->address,
                'amount' => $request->input('amount'),
                'approved_amount' => $request->input('amount'),
                'remarks' => $request->input('user_remarks')
            ]);
            return redirect()->back()->with('sueecss-wire', trans('auth/controller_msg.Successfully_submitted'));
        } catch (\Exception $exception) {

            //Log::error('Error in creating coin transaction '.$exception->getMessage());

            flash()->error(trans('auth/controller_msg.Error_Something_went_wrong'));
        }
        return redirect()->back();
    }



     //--------------Apeksha-------------------------------------
    public function deposit_eth(Request $request)
    {

        // return 1;die;

        $symbol = 'ADA';

        $user = auth()->user();

        // $this->validate($request, [
        //     // 'usd_amount' => 'required|numeric|check_fund:usd',
        //     'eth_amount' => 'required|numeric',
        // ]);
// return $request->all();

        $user_eth_wallet = $user->eth_wallet;

        $eth_amount = $request->input('amount');


        $convertCurrency = ConvertCurrency::create([
                'type'          => 'buy',
                'coversion'     => 'ada to wallet',
                'user_id'       => $user->id,
                'usd_amt'       => 0,
                'eth_amount'    => $eth_amount,
                'csm_amount'    => 0,
            ]);

         $add_eth =   $user_eth_wallet + $eth_amount;

         $user->eth_wallet = $add_eth;
        
         if($user->save()){
            $user->save();
            // flash()->success(trans('auth/controller_msg.Success_Your_Profile_has_been_Updated'))->important();
            flash()->success($symbol.' has been deposite Successfully');
        }else{
            flash()->error(trans('auth/controller_msg.SeverError'));
        }

        return redirect()->back();
    }
}
