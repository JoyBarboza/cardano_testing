<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use App\Charge;
use App\Events\CoinPurchased;
use App\Presale;
use App\Transaction;
use App\Repository\Currency\JPCoin;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\ConvertCurrency;
use App\User;
use App\BnbCsmCoveter;

class PreSaleController extends Controller
{
    protected $presale;

    public function __construct(Presale $presale) {
        $this->presale = $presale;
    }

    public function index()
    {
        $sales = $this->presale->latest()->paginate(10);  //dd($sales); 

        return view('presale.index', compact('sales'));
    }

    public function create()
    {
        return view('presale.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_date'      => 'required|date|date_format:Y-m-d|after:yesterday',
            'end_date'        => 'required|date|date_format:Y-m-d|after:start_date',
            'total_unit' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'bonus_discount' => 'required|numeric',
        ]);

        try {

            Presale::create([
                'start_date' => Carbon::parse($request->input('start_date')),
                'end_date' => Carbon::parse($request->input('end_date')),
                'total_coin_unit' => $request->input('total_unit'),
                'unit_price' => $request->input('unit_price'),
                'discount_percent' => $request->input('bonus_discount'),
                'status' =>1
            ]);

            flash()->success(trans('auth/controller_msg.Coin_PreSale_added_successfully'));

        } catch (\Exception $exception) {
            Log::error(trans('auth/controller_msg.Error_presale_store').$exception->getMessage());

            flash()->error(trans('auth/controller_msg.Coin_PreSale_added_successfully'));
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $preSale = $this->presale->findOrFail($id);

        return view('presale.edit', compact('preSale'));

    }

    public function update(Request $request, $id)
    {
		$this->validate($request, [
            'start_date'      => 'required|date|date_format:Y-m-d|after:yesterday',
            'end_date'        => 'required|date|date_format:Y-m-d|after:start_date',
            'total_unit' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'bonus_discount' => 'required|numeric',
        ]);
        $preSale = $this->presale->findOrFail($id);

        $preSale->start_date = $request->input('start_date');
        $preSale->end_date = $request->input('end_date');
        $preSale->total_coin_unit = $request->input('total_unit');
        $preSale->unit_price = $request->input('unit_price');
        $preSale->discount_percent = $request->input('bonus_discount');

        try {
            $preSale->save();

            flash()->success('PreSale has been updated successfully');
        } catch (QueryException $exception) {

            Log::error(trans('auth/controller_msg.presale_update_query_exception').$exception->getMessage());
            flash()->error(trans('auth/controller_msg.Error_PreSale_updated_successfully'));

        } catch (\Exception $exception) {

            Log::error(trans('auth/controller_msg.Error_Presale_update').' '.$exception->getMessage());
            flash()->error('Error! Presale has not been updated');
        }

        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $presale = $this->presale->find($id);

        try {
            if($presale->status) {
                $presale->status = 0;
            } else {
                $presale->status = 1;
            }

            $presale->save();

            flash()->success(trans('auth/controller_msg.PreSale_status_modified'))->important();
        } catch (\Exception $exception) {
            Log::error(trans('auth/controller_msg.PreSale_status_has_been_changed'));

            flash()->error(trans('auth/controller_msg.PreSale_status_modification_failed'))->important();
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        try {
                if($this->presale->destroy($id)) {
                    return json_encode([
                        'status' => true,
                        'message' => trans('auth/controller_msg.PreSale_deleted_successfully')
                    ]);
                }

                return json_encode([
                    'status' => false,
                    'message' => trans('auth/controller_msg.PreSale_not_found_with_this_code')
                ]);

        } catch (\Exception $exception) {
            Log::error('Error! Deleting Pre Sale '. $exception->getMessage());

            return json_encode([
                'status' => false,
                'message' => trans('auth/controller_msg.failed_delete_presale')
            ]);
        }
        //return redirect()->back();
    }


    public function getPreSaleData()
    {
        $presale = $this->presale->active();

        if($presale->exists()) {

            $presale = $presale->first(); 

            return json_encode([
                'status' => true,
                'data' => [
                    'remainingCoins' => $presale->remaining_volume,
                    'discountPercent' => $presale->discount_percent,
                    'coinPrice' => $presale->unit_price,
                    'basePrice' => Presale::BASE_PRICE
                ]
            ]);
        }

        return json_encode([
            'status' => false,
            'message' => trans('auth/controller_msg.no_any_active_Sale')
        ]);
    }

    public function buy()
    {
        $symbol = env('TOKEN_SYMBOL');
        //~ $presales = $this->presale->orderBy('start_date')->get();
        $presales = $this->presale->where('status',1)->whereRaw('presales.total_coin_unit > presales.sold_coin')->limit(1)->get();

        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        return view('presale.buy', compact('presales','symbol','bnb_csm'));
    }

    public function buyJPC(Request $request)
    {
		$user = auth()->user();
		
		//~ flash()->error('Site is in Maintainence mode.');
			//~ return redirect()->back();	
			
        $symbol = env('TOKEN_SYMBOL');
        $this->validate($request, [
            'jpc_coin' => 'required|numeric',
            'usd_amount' => 'required|numeric|check_fund:usd',
        ], [
            'usd_amount.check_fund' => 'You don\'t have sufficient fund in you wallet'
        ]);

		
        $userID = $user->id;	
        
        
        
        //~ if((! $user->profile->kyc_verified) && ($user->profile->ide_no==null)){
			//~ flash()->error('Please complete your KYC under <a href="{{route("account.profile")}}">Profile</a>  section to buy CSM');
			//~ return redirect()->back();		
		//~ }
        //~ else if(! $user->profile->kyc_verified){
			//~ flash()->error('Your KYC is processing');
			//~ return redirect()->back();		
		//~ }

        $jpc_coin 	= (float)$request->jpc_coin;
        $usd_amount = $request->usd_amount;    
        $presale = $this->presale->active();
		
        
        
        $currency = new Currency; 
        $payeecoin 	= $currency->getCoinByName('USD')->first(); 
        $rcvcoin 	= $currency->getCoinByName('CSM')->first(); 

        if($presale->exists()) {
			$presale = $presale->first(); 
			$remainingCoin=$presale->remaining_volume;  
			if($remainingCoin >= $jpc_coin) {//dd(round($usd_amount,2) , round(($presale->unit_price*$jpc_coin),2));
				$unitPrice=$presale->unit_price;
				if($presale->discount_percent > 0){
					$unitPrice=$presale->discount_percent;
				}
				
                if(round($usd_amount,2) == round(($unitPrice*$jpc_coin),2)) {
					if($jpc_coin>0) {
						$jpc_address_for_user = $user->profile->account_address_jpc;
						
						if(!$jpc_address_for_user){
							// $jpc_address_for_user = bitcoind()->client('msc')->getNewAddress()->get();
							// $user->profile->account_address_jpc = $jpc_address_for_user;
							// $user->profile->save();
						}	

						$hash = [];
						
						//$hash['hash'] = bitcoind()->client('msc')->sendToAddress($jpc_address_for_user, $jpc_coin)->get();
						$hash['hash'] = uniqid('HASH'.time());
						
						if($hash['hash']){
							$mailData['totalPrice'] = $jpc_coin * Presale::BASE_PRICE;

							$transaction[0] = [
								'user_id' => $userID,
								'currency_id' => $payeecoin->id,
								'reference_no' => uniqid('TXN'.time()),
								'type' => 'Debit',
								'amount' => $usd_amount,
								'source' => 'Purchase '.$symbol,
								'status'=>1,
								'description' => 'USD deducted for purchasing '.$symbol.' coin'
							];

							$mailData['netAmount'] = $usd_amount;

							$transaction[1] = [
								'user_id' => $userID,
								'currency_id' => $rcvcoin->id,
								'reference_no' => $hash['hash'],
								'type' => 'Credit',
								'amount' => $jpc_coin,
								'source' => 'Purchase '.$symbol,
								'status'=>1,
								'description' => $symbol.' has been purchased'
							];

							$mailData['buyVolume'] = $jpc_coin;
							
							

							/*$bonusAmount = ($jpc_coin * $presale->discount_percent)/100;

							if($bonusAmount > 0) {
								$transaction[2] = [
									'user_id' => $userID,
									'currency_id' => $rcvcoin->id,
									'reference_no' => uniqid('TXN'.time()),
									'type' => 'Credit',
									'amount' => $bonusAmount,
									'status'=>1,
									'source' => 'Purchase Bonus',
									'description' => 'Bonus coins added for JPC'
								];

								$mailData['bonusVolume'] = $transaction[2]['amount'];
							}*/

							$user = $request->user();
							$referralBonusAmount = Setting::where('key','REFERRAL_BONUS')->pluck('value')->first();
							$level2bonus = Setting::where('key','LEVEL_2_REFERRAL_BONUS')->pluck('value')->first();
							$level3bonus = Setting::where('key','LEVEL_3_REFERRAL_BONUS')->pluck('value')->first();
							
							if($referralBonusAmount){
								//~ $referralBonus = $jpc_coin * Charge::REFERRAL_BONUS;
								$referralBonus = $jpc_coin * $referralBonusAmount;
								$level_2_bonus = $jpc_coin * $level2bonus;
								$level_3_bonus = $jpc_coin * $level3bonus;
								
								if($referralBonus > 0){
									if($sponsor = $user->referredBy) {
										$transaction[3] = [
											'user_id' => $sponsor->id,
											'currency_id' => $rcvcoin->id,
											'reference_no' => uniqid('REF'.time()),
											'type' => 'Credit',
											'amount' => $referralBonus,
											'status' => 1,
											'description' => 'Referral Bonus From '.$user->username,
											'source' => 'Referral Bonus'
										];
										
										if(($level2bonus > 0) && ($level2sponsor = $sponsor->referredBy)){
											$transaction[4] = [
												'user_id' => $level2sponsor->id,
												'currency_id' => $rcvcoin->id,
												'reference_no' => uniqid('REF'.time()),
												'type' => 'Credit',
												'amount' => $level_2_bonus,
												'status' => 1,
												'description' => 'Referral Bonus From '.$user->username,
												'source' => 'Referral Bonus'
											];
											
											if(($level3bonus > 0) && ($level3sponsor = $level2sponsor->referredBy)){
												$transaction[5] = [
													'user_id' => $level3sponsor->id,
													'currency_id' => $rcvcoin->id,
													'reference_no' => uniqid('REF'.time()),
													'type' => 'Credit',
													'amount' => $level_3_bonus,
													'status' => 1,
													'description' => 'Referral Bonus From '.$user->username,
													'source' => 'Referral Bonus'
												];
											}
										}
									}
								}
							}

							DB::transaction(function() use ($transaction,$presale,$remainingCoin,$level2bonus,$level3bonus,$referralBonus){
								$sold_coin=$transaction[1]['amount'];
								$checkPercentage=$remainingCoin;
								if(isset($transaction[3])) {
									
									$sold_coin = $sold_coin + $transaction[3]['amount'];
									$checkPercentage =$checkPercentage - ($remainingCoin * $referralBonus);
								}
								
								if(isset($transaction[4])) {
									
									$sold_coin = $sold_coin + $transaction[4]['amount'];
									$checkPercentage =$checkPercentage - ($remainingCoin * $level2bonus);
								}
								
								if(isset($transaction[5])) {
									
									$sold_coin = $sold_coin + $transaction[5]['amount'];
									$checkPercentage =$checkPercentage - ($remainingCoin * $level2bonus);
								}
								
								if($sold_coin > $remainingCoin){
									flash()->error('You can Purchase only '.$checkPercentage.' CSM amount for this presale');
									return redirect()->back();
								}
								
								$presale->sold_coin += $sold_coin;
								$presale->save();	

								$transactions[1] = Transaction::create($transaction[1]);
								$transactions[0] = Transaction::create($transaction[0]);
								
								
								/*if(isset($transaction[2])) {
									$transactions[2] = Transaction::create($transaction[2]);
								}*/

								if(isset($transaction[3])) {
									$transactions[3] = Transaction::create($transaction[3]);
									
								}
								
								if(isset($transaction[4])) {
									$transactions[4] = Transaction::create($transaction[4]);
									
								}
								
								if(isset($transaction[5])) {
									$transactions[5] = Transaction::create($transaction[5]);
									
								}

							});

							$mailData['discount'] = $mailData['totalPrice'] - $mailData['netAmount'];

							event(new CoinPurchased($mailData, $user));

							flash()->success($symbol.' has been Purchased Successfully');
						}else{
							flash()->error(trans('auth/controller_msg.SeverError'));
						}

					} else {
						flash()->error(trans('auth/controller_msg.Transaction_amount_must_be_greater_than'));
					}
				} else {
					flash()->error(trans('auth/controller_msg.USD_Amount_Not_Valid'));
				}
			} else {	
				flash()->error(trans('auth/controller_msg.Error_Only').$remainingCoin.trans('auth/controller_msg.coin_is_remaining_for_sale'));
			}
		} else {
			flash()->error(trans('auth/controller_msg.No_Presale_is_running'));
        }
		return redirect()->back();
    }

    //--------------Apeksha-------------------------------------
    public function buyCSMOld(Request $request)
    {
    	$symbol = 'CSM';

		 $user = auth()->user();


		$this->validate($request, [
            // 'usd_amount' => 'required|numeric|check_fund:usd',
            'eth_amount' => 'required|numeric',
        ]);
		// return $request->all();

		$user_eth_wallet = $user->eth_wallet;
		$user_cjm_wallet = $user->cjm_wallet;

		$eth_amount = $request->input('eth_amount');
		$czm_amount = $request->input('czm_amount');

		if(empty($user_eth_wallet) || $user_eth_wallet == 0){
		    // if($wallet < $pack_price){
				// 	return 0;
        	flash()->error('You not have sufficient value');
        	 return redirect()->back();
		}
	
		if($user_eth_wallet < $eth_amount){
		    // if($wallet < $pack_price){
			// return 0;
        	flash()->error('You not have sufficient value');
        	 return redirect()->back();
		}


		 $sub_eth =  $user_eth_wallet - $eth_amount;
		 $add_cjm =   $user_cjm_wallet + $czm_amount;

		 $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		$transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

		$convertCurrency = ConvertCurrency::create([
	            'type' => 'buy',
	            'coversion' => 'ada to csm',
	            'user_id' => 1,
	            'to_id'   => $user->id,
	            'usd_amt' => 0,
	            'transaction_id' => $transaction_id,
	            'eth_amount' => $eth_amount,
	            'csm_amount' => $czm_amount,
	    ]);

		
		 
		 $user->eth_wallet = $sub_eth;
		 $user->cjm_wallet = $add_cjm;

		
		 if($user->save()){
			$user->save();
            // flash()->success(trans('auth/controller_msg.Success_Your_Profile_has_been_Updated'))->important();
        	flash()->success($symbol.' has been Purchased Successfully');
        }else{
        	flash()->error(trans('auth/controller_msg.SeverError'));
        }

        return redirect()->back();
	}
	
	public function buyCSM(Request $request){
		// return $request->all();

		$symbol = 'CSM';

		$user = auth()->user();


		$csm_wallet 		= 	$request->input('csm_wallet');
		$send_bnb 			= 	$request->input('bnb_amount');
		$transaction_id 	= 	$request->input('transaction_id');
		$csm_amount 		= 	$request->input('csm_amount');


		$user_bnb_wallet = $user->eth_wallet;
		$user_csm_wallet = $user->cjm_wallet;


		$total_bnb 	=   $user_bnb_wallet + $send_bnb;
		// $total_csm 	=   $user_csm_wallet + $get_csm;


		$convertCurrency = ConvertCurrency::create([
	            'type' => 'buy',
	            'coversion' => 'bnb to csm',
	            'user_id' => '0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223',
	            'to_id'   => $user->id,
	            'usd_amt' => 0,
	            'transaction_id' => $transaction_id,
	            'eth_amount' => $send_bnb,
	            'csm_amount' => $csm_amount,
	    ]);


	     $user->eth_wallet = $total_bnb;
		 $user->cjm_wallet = $csm_wallet;

		
		if($user->save()){

			$status = '200';
			echo json_encode($status);
			// $user->save();
        	// flash()->success($symbol.' has been Purchased Successfully');
        }else{
        	$status = '400';
			echo json_encode($status);
        	// flash()->error(trans('auth/controller_msg.SeverError'));
        }

        // return redirect()->back();


	}
	
	  public function cardano_explore()
    {
    	// return 1;die;
    	
    	// $convert_currency = ConvertCurrency::orderBy('id', 'DESC')->paginate(10);

    	$convert_currency = ConvertCurrency::where('type','reward')->orWhere('type','buy')->orWhere('type','csm_wallet_received')->orderBy('id', 'DESC')->paginate(10);

        return view('cardano_explore',compact('convert_currency'));
    }

      public function cardano_explore_detail($id,$block,$transaction)
    {
    	$id = decrypt($id);
    	$block = $block;
    	$transaction = $transaction;
    	
    	$explore_detail = ConvertCurrency::where('id',$id)->first();

        return view('cardano_explode_detail',compact('explore_detail','block','transaction'));
    }

    public function account(Request $request)
    {
        $user = auth()->user();
        $user->daedalus_wallet = $request->input('daedalus_wallet');

        if($user->save()){
            flash()->success('Wallet update successfully')->important();
        }
        return redirect()->back();
    }


    public function csm_wallet(Request $request)
    {
    	$user = auth()->user();

    	$transaction_count = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->count();

    	$received = ConvertCurrency::where('type','csm_wallet_received')->where('to_id',$user->id)->orderBy('id', 'DESC')->paginate(10);

    	$transaction = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->orderBy('id', 'DESC')->paginate(10);
    	
    	$summy_transaction = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->orderBy('id', 'DESC')->limit(5)->get();


        return view('csm_wallet',compact('received','transaction','summy_transaction','transaction_count'));
    }

     public function csm_wallet_transaction(Request $request)
    {
    	$user = auth()->user();

    	$transaction_count = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->count();

    	$received = ConvertCurrency::where('type','csm_wallet_received')->where('to_id',$user->id)->orderBy('id', 'DESC')->paginate(10);

    	$transaction = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->orderBy('id', 'DESC')->paginate(10);
    	
    	$summy_transaction = ConvertCurrency::where('user_id',$user->id)->orwhere('to_id',$user->id)->orderBy('id', 'DESC')->limit(5)->get();


        return view('csm_wallet_transaction',compact('received','transaction','summy_transaction','transaction_count'));
        
    }

    public function send_amount(Request $request)
    {
    	$from_id = auth()->user()->id;
    	$form_csm_amt = auth()->user()->cjm_wallet;

    	$daedalus_wallet  =  $request->input('daedalus_wallet');
    	$csm_amount  	  =  $request->input('csm_amount');


		if(empty($form_csm_amt) || $form_csm_amt == 0){
        	flash()->error('You not have sufficient value')->important();
        	 return redirect()->back();
		}
	
		if($form_csm_amt < $csm_amount){
        	flash()->error('You not have sufficient value')->important();
        	 return redirect()->back();
		}

		$send_amt = $form_csm_amt - $csm_amount;  //send amount
		 

    	$to_user_detail = User::where('daedalus_wallet',$daedalus_wallet)->first();
    	

    	if(empty($to_user_detail)){
    		flash()->error('No wallet address found')->important();
    		return redirect()->back();
    	}

    	 $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);


    	$to_id = $to_user_detail->id;
    	$to_csm_amt = $to_user_detail->cjm_wallet;

    	$received_amt = $to_csm_amt + $csm_amount; //received amount

    	$send_amount 				=  new ConvertCurrency; 
    	$send_amount->type 			=  'csm_wallet_received';
    	$send_amount->coversion 	=  'csm_wallet_received';
    	$send_amount->csm_amount 	=  $csm_amount;
    	$send_amount->user_id 		=  $from_id;
    	$send_amount->to_id 		=  $to_id;
    	$send_amount->transaction_id 		=  $transaction_id;

        if($send_amount->save())
        {
        	//----------update send amount------
        	$update_from_id = User::where('id',$from_id)->first();
        	$update_from_id->cjm_wallet = $send_amt;
        	$update_from_id->save(); 

        	//----------update received amount--------
        	$update_to_id = User::where('id',$to_id)->first();
        	$update_to_id->cjm_wallet = $received_amt;
        	$update_to_id->save();
            flash()->success('Amount send successfully')->important();
        }
        return redirect()->back();
    }

    public function add_wallet_detail(Request $request)
    {
    	// return $request->all();

    	$seed_pharse  		=  $request->input('seed_pharse');
    	$daedalus_wallet  	=  $request->input('daedalus_wallet');
    	$user_id  	  		=  $request->input('user_id');


    	$to_csm_amt = auth()->user()->cjm_wallet;
    	$received_amt = $to_csm_amt + 500; //received amount


    	$update_wallet = User::where('id',$user_id)->first();
    	$update_wallet->daedalus_wallet = $daedalus_wallet;
    	$update_wallet->seed_pharse = $seed_pharse;
    	$update_wallet->cjm_wallet = $received_amt;
    	$update_wallet->save();


    	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

    	$send_amount 				=  new ConvertCurrency; 
    	$send_amount->type 			=  'csm_wallet_received';
    	$send_amount->coversion 	=  'csm_wallet_received';
    	$send_amount->csm_amount 	=  500;
    	$send_amount->user_id 		=  0;
    	$send_amount->transaction_id 		=  $transaction_id;
    	$send_amount->to_id 		=  $user_id;
    	$send_amount->save();

        flash()->success('Wallet created successfully')->important();

        return redirect()->back();
    }

    public function wallet_password(Request $request)
    {
    	// bcrypt($data['password'])
    	// return $request->all();

    	$type_password  	=  $request->input('type_password');
    	$user_id  	  		=  $request->input('user_id');

    	if($type_password == 1)
    	{
    		// echo "dsf";die;

    		$update_wallet_password = User::where('id',$user_id)->first();
	    	$update_wallet_password->wallet_password = bcrypt($request->input('newPassword'));
	    	$update_wallet_password->wallet_update = Carbon::now();


	    	if($update_wallet_password->save()){
	            flash()->success('Wallet password created successfully')->important();
	        }
	        return redirect()->back();

    	}else{

	        // echo "string";die;
    		$this->validate($request, [
	            'newPassword' => 'required',
	            // 'confirm_password' => 'required|confirmed|min:6',
	            'oldPassword' => 'required|match_old:'.auth()->user()->wallet_password
	        ],['oldPassword.match_old'=> 'Wrong Password!']);

	        $wallet_password = auth()->user();
	        $wallet_password->wallet_password = bcrypt($request->input('newPassword'));
	        $wallet_password->wallet_update = Carbon::now();

	        if($wallet_password->save()){
	            flash()->success('Password change successfully')->important();
	        }
	        return redirect()->back();
    	}
    }

    public function staking(){
    	// return auth()->user();
    	return view('staking');
    }


    public function stake_amt(Request $request)
    {

    	// return $request->all();

    	$from_id = auth()->user()->id;

    	$form_csm_amt = auth()->user()->cjm_wallet;

		// $remaining_token = $form_csm_amt - $request->input('numberOfTokens');  //send token
		$stake_amt = auth()->user()->stake_amt + $request->input('numberOfTokens');  //send amount
				 

    	$send_amount 					=  new ConvertCurrency; 
    	$send_amount->type 				=  'stake_amount';
    	$send_amount->coversion 		=  'stake_amount';
    	$send_amount->csm_amount 		=  $request->input('numberOfTokens');
    	$send_amount->user_id 			=  $from_id;
    	$send_amount->to_id 			=  '0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223';
    	$send_amount->usd_amt 			=  $request->input('startDateTime');
    	$send_amount->eth_amount 		=  $request->input('finishDateTime');
    	$send_amount->transaction_id 	=  $request->input('staketransaction_id');

        if($send_amount->save())
        {
        	//----------update send amount------
        	$update_from_id = User::where('id',$from_id)->first();
        	// $update_from_id->cjm_wallet 		= 	$remaining_token;
        	$update_from_id->daedalus_wallet 	= 	$request->input('loginAddress');
        	$update_from_id->start_time 		= 	$request->input('startDateTime');
        	$update_from_id->finish_time 		= 	$request->input('finishDateTime');
        	$update_from_id->reward		 		= 	$request->input('stakeReward');
        	$update_from_id->stake_amt 			= 	$stake_amt;

           	if($update_from_id->save()){
				$status = 200;
				echo json_encode($status);
	        }else{
	        	$status = 400;
				echo json_encode($status);
	        }
        }else{
        	$status = 400;
			echo json_encode($status);
        }
    }

    public function unstake_amt(Request $request)
    {
    	// return $request->all();die;

    	$from_id = auth()->user()->id;

    	$form_csm_amt = auth()->user()->cjm_wallet;

		  //   	// $daedalus_wallet  =  $request->input('daedalus_wallet');
		  //   	$csm_amount  	  =  $request->input('number');


				// if(empty($form_csm_amt) || $form_csm_amt == 0){
		  //       	flash()->error('You not have sufficient value')->important();
		  //       	 return redirect()->back();
				// }
			
				// if($form_csm_amt < $csm_amount){
		  //       	flash()->error('You not have sufficient value')->important();
		  //       	 return redirect()->back();
				// }

		// $remaining_token = $form_csm_amt + $request->input('numberOfunstake');  //send token
		$unstake_amt = auth()->user()->unstake_amt + $request->input('numberOfunstake');  //send amount
		$stake_amt = auth()->user()->stake_amt - $request->input('numberOfunstake');  //send amount
				 

		  //   	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		  //       $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);


    	$send_amount 					=  new ConvertCurrency; 
    	$send_amount->type 				=  'unstake_amount';
    	$send_amount->coversion 		=  'unstake_amount';
    	$send_amount->csm_amount 		=  $request->input('numberOfunstake');
    	$send_amount->user_id 			=  $from_id;
    	$send_amount->to_id 			=  '0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223';
    	$send_amount->usd_amt 			=  $request->input('startDateTime');
    	$send_amount->eth_amount 		=  $request->input('finishDateTime');
    	$send_amount->transaction_id 	=  $request->input('unstaketransaction_id');
    	

        if($send_amount->save())
        {
        	//----------update send amount------
        	$update_from_id = User::where('id',$from_id)->first();
        	// $update_from_id->cjm_wallet 		= 	$remaining_token;
        	$update_from_id->daedalus_wallet 	= 	$request->input('loginAddress');
        	$update_from_id->start_time 		= 	$request->input('startDateTime');
        	$update_from_id->finish_time 		= 	$request->input('finishDateTime');
        	$update_from_id->reward		 		= 	$request->input('stakeReward');
        	$update_from_id->stake_amt 			= 	$stake_amt;
        	$update_from_id->unstake_amt 		= 	$unstake_amt;

           	if($update_from_id->save()){
				$status = 200;
				echo json_encode($status);
	        }else{
	        	$status = 400;
				echo json_encode($status);
	        }
        }else{
        	$status = 400;
			echo json_encode($status);
        }
    }
}
