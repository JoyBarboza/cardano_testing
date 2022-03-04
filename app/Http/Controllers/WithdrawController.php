<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Withdraw;
use App\Payment;
use App\Currency;
use App\Repository\Currency\JPCoin;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\Payment\CoinpaymentRepository;
use Symfony\Component\Debug\Exception\UndefinedFunctionException;
use Kevupton\LaravelCoinpayments\Exceptions\CoinPaymentsResponseError;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('withdraw.index');
    }

    public function withdraw($currency)
    {
        switch($currency)
        {
            case 'usd' :
                return view ('withdraw.usd');
            case 'msc' :
				$withdraws = auth()->user()->withdraw()
				->latest()->paginate(15);
				$is_withdraw= Currency::where('name', 'MSC')->first();
                return view ('withdraw.msc',compact('withdraws','is_withdraw'));
            case 'token' :
                $symbol = env('TOKEN_SYMBOL');
                $withdraws = auth()->user()->withdraw()
                ->latest()->paginate(15);
                $is_withdraw= Currency::where('name', $symbol)->first();
                return view ('withdraw.token',compact('withdraws','is_withdraw','symbol'));
            default :
                flash()->info('Service for this currency doesn\'t available from our end')->important();
                return redirect()->back();
        }
    }
    

    public function makeWithdraw(Request $request, $currency)
    {
		$user = auth()->user();
		if((! $user->profile->kyc_verified) && ($user->profile->ide_no==null)){
			flash()->error('Please complete your KYC under <a href="{{route("account.profile")}}">Profile</a>  section to Withdraw');
			return redirect()->back();		
		}
        else if(! $user->profile->kyc_verified){
			flash()->error('Your KYC is processing');
			return redirect()->back();		
		}
        switch($currency)
        {
            case 'token':
                return $this->withdrawMSC($request);
            default :
                return $this->withdrawMoney($request);
        }
    }

    private function withdrawMoney(Request $request)
    {
        $this->validate($request, [
            'payable_currency' => 'required|in:BTC,BCH,XMR,DASH,LTC,ETH,LTCT,USD,CSM',
            'address' => 'required',
            'amount' => 'required|numeric|min:1|check_fund:usd'
        ],['amount.check_fund'=>'Insufficient Balance']);

        $amount = $request->input('amount');
        $address = $request->input('address');
        $currencyToPay = $request->input('payable_currency');

        try {

            $curAmount = (1 / CoinpaymentRepository::toUSD($currencyToPay,1)) * $amount;

            $cpWithdraw = \Coinpayments::createWithdrawal($curAmount, $currencyToPay, $address);

            $currency_id = Currency::where('name', 'USD')->pluck('id')->first();

            $transaction = [
                'user_id' => auth()->id(),
                'currency_id' => $currency_id,
                'reference_no' => $cpWithdraw->ref_id,
                'type' => 'Debit',
                'amount' => $amount,
                'status' => 1
            ];

            $payment = [
                'user_id' => auth()->id(),
                'address' => $address,
                'reference_no' => $cpWithdraw->ref_id,
                'remarks' => 'USD Withdraw'
            ];

            DB::transaction(function() use ($transaction, $payment) {

                $transaction = Transaction::create($transaction);

                $payment['transaction_id'] = $transaction->id;

                Payment::create($payment);

            });

            return redirect()->back()->with('withdraw', $cpWithdraw);

        } catch(CoinPaymentsResponseError $exception) {

            Log::error('Error Address is not valid '.$exception->getMessage());

            flash()->error('Error! Given address is not valid')->important();

        } catch (\Exception $exception) {

            Log::error('Error in creating coin transaction '.$exception->getMessage());

            flash()->error(trans('auth/controller_msg.Error_USD_Payment_currently_Under_Maintenance'))->important();
        }
        return redirect()->back();
    }
	
	private function withdrawMSC(Request $request)
    {
		$user = auth()->user();
		$symbol = env('TOKEN_SYMBOL');
			$this->validate($request, [
				'currency' => 'required',
				'caddress' => 'required',
				'camount' => 'required|numeric|min:1|check_fund:csm'
			],[
				'camount.required' => 'Amount is a required field',
				'camount.min' => 'Minimum amount should be '.$symbol.' 1',
				'caddress.required' => $symbol.' Address is a required field',
				'camount.check_fund' => 'Your wallet doesn\'t have sufficient fund'
			]);
			
			$is_withdraw= Currency::where('name', $symbol)->first();
			if(! $is_withdraw->withdraw){
				flash()->error('Error! Currently Pre Sale of coins is active so withdraw of coins has been disabled.');
				return redirect()->back();
			}

			$msc = $request->camount;
			$currency = $request->currency;
			$address = $request->caddress;
			
			
			if($user->withdraw()->pending()->count()) {
				flash()->error('Error! Your earlier withdrawal request is already pending.');
				return redirect()->back();
			}
			
			$fee_percentage= Setting::where('key','msc_withdraw_fee_percentage')->pluck('value')->first();
			
			if($fee_percentage > 0){
				$fees=($msc * $fee_percentage / 100);			
			}else{
				$fees=0;
			}
			
			$amountToSend = $msc - $fees;
			
			try {
	
				DB::transaction(function () use ($user, $currency, $msc ,$address,$amountToSend,$fees,$symbol) {
					
					$random_num=uniqid('WTH').str_random(20);
			
				   $transaction =  Transaction::create([
									'user_id' => $user->id,
									'currency_id' => Currency::whereName($symbol)->pluck('id')->first(),
									'reference_no' => $random_num,
									'amount' => $msc,
									'source' => 'withdraw',
									'type' => 'Debit',
									'description' => 'Withdraw of '.$symbol.' '.$msc.' from wallet',
									'status' => 1,
						]);
						
				
					
					$withdraw = Withdraw::create([
						'user_id' => $user->id,
						'currency_id' => Currency::whereName($symbol)->pluck('id')->first(),
						'transaction_id' => $transaction->id,
						'address' => $address,
						'net_amount' => $amountToSend,
						'amount' => $msc,
						'fees' => $fees,
						'remarks' => $random_num,
						'description' => 'Withdraw of '.$symbol.' '.$msc.' from wallet',
						'status' => 0,
					]);
					

				});
			
				flash()->success('Success! Your Request for withdraw has been successfully initiated.');

			} catch(QueryException $exception) {
				Log::error('Error from withdrawCoinAmount '.$exception->getMessage());
				flash()->error('Error! Request for withdraw can\'t be initiated. Please try later');
			} catch (\Exception $exception) {
				Log::error('Error from withdrawCoinAmount'.$exception->getMessage());
				flash()->error('Error! Request for withdraw can\'t be initiated');
			}
        
		
		return redirect()->back();
	}
    
    private function withdrawJPC(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'amount' => 'required|numeric|check_fund:jpc|min:1'
        ], [
            'amount.check_fund' => 'Your wallet doesn\'t have sufficient fund'
        ]);

        try {
            $wallet = new JPCoin();
            $address = $request->input('address');
			
			$fees = 0.1;
            $amount = (float)$request->input('amount');
			$netAmount = $amount + $fees;
			
			if($netAmount > auth()->user()->getBalance('JPC')){
				flash()->error('Error! Unable to pay the transaction fees : JPC '.$fees)->important();
				return redirect()->back();
			}
			
			$result = bitcoind()->client('jpcoin')->sendToAddress($address, $amount)->get();

            if($result){

                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'currency_id' => Currency::whereName('JPC')->pluck('id')->first(),
                    'reference_no' => trim($result),
                    'type' => 'Debit',
                    'status' => 1,
                    'amount' => $netAmount,
                ]);

                $payment = Payment::create([
                    'user_id' => auth()->user()->id,
                    'transaction_id' => $transaction->id,
                    'address' => $address,
                    'reference_no' =>  trim($result),
                    'remarks' => 'JPCWithdrawal',
                    'confirm' => 1
                ]);

                flash()->success(trans('auth/controller_msg.Success_Withdraw_has_been_successfully_processed'))->important();

                return redirect()->back()->with('payment', $payment);

            } else {
                flash()->error(trans('auth/controller_msg.facing_temporary_failure'))->important();
            }

        } catch (\Exception $exception) {
            Log::error('Error from jpc withdraw '.$exception->getMessage());
            flash()->error(trans('auth/controller_msg.currently_Under_Maintenance'))->important();
        }
        return redirect()->back();

    }
}
