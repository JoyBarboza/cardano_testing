<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Charge;
use App\Currency;
use App\Libs\AdminSettings;
use App\Setting;
use App\Ticker;
use App\Presale;
use App\PresaleSlab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Session;
use App\User;
use App\NftItem;
use App\ActiveUser;
use App\Reward;
use App\BnbCsmCoveter;

class SettingController extends Controller
{
    protected $charge, $setting;

    public function __construct(Charge $charge, Setting $setting)
    {
        $this->charge = $charge;
        $this->setting = $setting;
    }

    public function getLimit()
    {
        $settings = $this->setting->all();
    	return view('setting.limit',compact('settings'));
    }

    public function postLimit(Request $request)
    {
        $this->validate($request, [
            '*' => 'required'
        ]);

        try {
            $data = $request->except('_token');
            
            foreach($data as $key => $value) {
                $settings = $this->setting->where('key',$key)->where('value',$value)->first();
                if(!$settings){
                    $this->setting->create([
                        'key' => $key, 'value' => $value
                    ]);

                
                }else{

                   $this->setting
                       ->where('id', $settings->id)
                       ->update([
                           'key' => $key,
                           'value' => $value
                       ]);
                }
            }
        flash()->success('Limit settings updated!')->important();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            flash()->error(trans('auth/controller_msg.error_saving_settings'));
        }
    	return redirect()->back();
    }

    public function getCharges()
    {
        $settings = $this->setting->all();
        $cur = new Currency();
        $currencies = $cur->activeCurrency()->get();

        return view('setting.charges',compact('settings', 'currencies'));
    }

    public function charges(Request $request)
    {
        $this->validate($request, [
            '*' => 'required'
        ]);

        try {
            $data = $request->except('_token');
            
            foreach($data as $key => $value)
            {
                $names = explode('_', $key);
                $charges = $this->charge->where('name',$names[0])->where('currency_id',$names[1])->first();
                if(!$charges){
                    $this->charge->create([
                        'currency_id' => $names[1],
                        'name' => $names[0],
                        'type' => 'PERCENT',
                        'amount' => $value,
                    ]);
                    
                }else{

                   $this->charge
                   ->where('id', $charges->id)
                   ->update([
                        'currency_id' => $names[1],
                        'name' => $names[0],
                        'type' => 'PERCENT',
                        'amount' => $value,
                    ]);
                }

            }
        flash()->success('Charges setting updated!')->important();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            flash()->error(trans('auth/controller_msg.error_saving_settings'));
        }

        return redirect()->back();
    }

    public function getBtcPrice(Currency $currency)
    {
        $currentPrice = $currency->where('name', 'BTC')->firstOrFail();
        $currentPrice = $currentPrice->ticker()->orderBy('synced_at','DESC')->first();
        $settings = $this->setting->all();
        return view('setting.btc-price',compact('currentPrice','settings'));
    }

    public function setBtcPrice(Request $request)
    {
        try {
            $data = $request->except('_token');
            
            foreach($data as $key => $value) {
                $settings = $this->setting->where('key',$key)->first();

                if(!$settings){

                    $this->setting->create([
                        'key' => $key, 'value' => $value
                    ]);

                }else{

                   $this->setting
                       ->where('id', $settings->id)
                       ->update([
                           'key' => $key,
                           'value' => $value
                       ]);
                }
            }
            flash()->success('Settings updated!')->important();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            flash()->error(trans('auth/controller_msg.error_saving_settings'));
        }
        return redirect()->back();
    }

    public function getWtcPrice(Currency $currency)
    {
        $currentPrice = $currency->where('name', 'WTC')->firstOrFail();
        $currentPrice = $currentPrice->ticker()->orderBy('synced_at','DESC')->first();

        return view('setting.wtc-price',compact('currentPrice'));
    }

    public function setWtcPrice(Request $request, Currency $currency)
    {
        $this->validate($request, [
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
        ]);

        $currency = $currency->where('name', 'WTC')->firstOrFail();
        $inr = Currency::where('name', 'INR')->first();
        $inr = $inr->price()->orderBy('synced_at', 'desc')->first();

        Ticker::create([
            'currency_id' => $currency->id,
            'buy_price' => $request->input('buy_price'),
            'sale_price' => $request->input('sell_price'),
            'last_price' => $request->input('buy_price'),
            'buy_inr_price' => round(($request->input('buy_price') * $inr->buy_price)),
            'sell_inr_price' => round(($request->input('sell_price') * $inr->buy_price)),
            'last_inr_price' => round(($request->input('buy_price') * $inr->buy_price))

        ]);

        flash()->success(trans('auth/controller_msg.Success_Ticker_for_WTC_price_has_been_updated'))->important();

        return redirect()->back();
    }

    public function wtcDeposit()
    {
        $user = auth()->user();
        $coinaddress = $user->coinaddress()
            ->where('coin_id',2)
            ->get();

        $payments = $user->payment()
            ->whereIn('remarks',['WTCDeposit','WTCWithdrawal'])
            ->whereHas('transaction',function($q){
                $q->where('status',1);
            })->paginate(15);

        return view('setting.wtc-deposit',compact('coinaddress', 'payments'));
    }

    public function getBanner()
    {
        $banner = $this->setting
            ->where('key', 'home_banner_image')
            ->pluck('value')->first();
        return view('setting.banner', compact('banner'));
    }

    public function postBanner(Request $request)
    {
        $this->validate($request, [
            'banner' => 'required|image|dimensions:min_width=2003,min_height=1336'
        ]);

        try {
            $file = $request->banner->store('public');

            $this->setting->setMeta('home_banner_image', explode('/',$file)[1]);
            flash()->success('Success! Banner has been set');
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! There is an error saving file');
        }
        return redirect()->back();
    }
    
    public function getWireTransferDetails()
    {
		$min_amount_cloud_mining = $this->setting
            ->where('key', 'min_amount_cloud_mining')
            ->pluck('value')->first();
        $max_amount_cloud_mining = $this->setting
            ->where('key', 'max_amount_cloud_mining')
            ->pluck('value')->first();
		
        return view('setting.wireTransferDetails', compact('min_amount_cloud_mining','max_amount_cloud_mining'));
    }
    
     public function postWireTransferDetails(Request $request)
    {
		
		$this->validate($request, [
            'min_amount_cloud_mining' => 'required|numeric',
            'max_amount_cloud_mining' => 'required|numeric'
        ]);
        
      
			try {
			 $min_amount_cloud_mining = $this->setting->where('key','min_amount_cloud_mining')->first();
			 
			if(!$min_amount_cloud_mining){
				$this->setting->create([
					'key' => 'min_amount_cloud_mining', 'value' => $request->min_amount_cloud_mining
				]);

			
			}else{

			   $this->setting
				   ->where('id', $min_amount_cloud_mining->id)
				   ->update([
					   'value' => $request->min_amount_cloud_mining
				   ]);
			}
			$max_amount_cloud_mining = $this->setting->where('key','max_amount_cloud_mining')->first();
			if(!$max_amount_cloud_mining){
                    $this->setting->create([
                        'key' => 'max_amount_cloud_mining', 'value' => $request->max_amount_cloud_mining
                    ]);

                
                }else{

                   $this->setting
                       ->where('id', $max_amount_cloud_mining->id)
                       ->update([
                           'value' => $request->max_amount_cloud_mining
                       ]);
                }
            
            flash()->success('Success! Core mining Details has been set');
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! There is an error saving file');
        }
        return redirect()->back();
    }
    
    public function postWireTransferDetails1(Request $request)
    {
		
		$this->validate($request, [
            'account_details' => 'required',
            'one_time_password' => 'required'
        ]);
        
        $otp = Session::get('withdraw_email_otp');
        if(!$otp){
			flash()->error( __('One Time Password verify is required') );
			return redirect()->back();
		}
        
		$user_otp = $request->input('one_time_password');

		if($otp!=$user_otp){
			flash()->error( __('Error! Invalid Email One Time Password') );
			return redirect()->back();
		}
		
		
			try {
			 $settings = $this->setting->where('key','wire_transfer')->first();
                if(!$settings){
                    $this->setting->create([
                        'key' => 'wire_transfer', 'value' => $request->account_details
                    ]);

                
                }else{

                   $this->setting
                       ->where('id', $settings->id)
                       ->update([
                           'value' => $request->account_details
                       ]);
                }
            
            flash()->success('Success! Wire Transfer Details has been set');
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! There is an error saving file');
        }
        return redirect()->back();
    }

    public function reward(Request $request)
    {
        
        $reward = Reward::where('id','1')->first();


       return view('setting.reward',compact('reward'));
    }

    public function update_reward (Request $request){

        $data               = Reward::findOrFail($request->id);
        $data->time         =   $request->time;
        $data->reward       =   $request->reward;
        $data->total_user   =   $request->total_user;
        // $data->save();

        if($data->save()){
            flash()->success('Reward update successfully')->important();
        }
        return redirect()->back();
    }


    public function active_user(Request $request)
    {
        
        $active_user = ActiveUser::
                leftJoin('users', function($join) {
                  $join->on('users.id', '=', 'active_users.user_id');
                })
                ->orderBy('active_users.id', 'DESC')
                ->select([
                    'active_users.id','active_users.user_id','active_users.status','users.first_name','users.cjm_wallet','users.eth_wallet','steps','bullets_shot','total_time'
                ])
                ->paginate('10');
       return view('setting.active_user',compact('active_user'));
    }

    public function active(Request $request){
        $active_user = ActiveUser::
            leftJoin('users', function($join) {
              $join->on('users.id', '=', 'active_users.user_id');
            })
            ->orderBy('active_users.id', 'DESC')
            ->select([
                'active_users.id','active_users.user_id','active_users.status','users.first_name','users.cjm_wallet','users.eth_wallet','steps','bullets_shot','total_time'
            ])
            ->get();

        $active_user_total = ActiveUser::count();
        
        if(!empty($active_user)){
            foreach ($active_user as $key => $value) 
            {

                $reward_detail = Reward::where('id',1)->first();

                $distribute_reward = $reward_detail->reward/$active_user_total;

                $data               = ActiveUser::findOrFail($value['id']);
                $data->total_time   =   600;
                $data->status       =   1;
                $data->save();

                $user_detail = User::where('id',$value['user_id'])->first();

                $reward_amount = $reward_detail->reward;
                $wallet = $user_detail->cjm_wallet;

                $total_amount = $wallet + $distribute_reward;

                $dataUser           = User::findOrFail($value['user_id']);
                $dataUser->cjm_wallet   =   $total_amount;
                $dataUser->save();
            }

            flash()->success('Reward update successfully')->important();
            return redirect()->back();
        }
    }

    public function deactive(Request $request)
    {
        $active_user = ActiveUser::
            leftJoin('users', function($join) {
              $join->on('users.id', '=', 'active_users.user_id');
            })
            ->orderBy('active_users.id', 'DESC')
            ->select([
                'active_users.id','active_users.user_id','active_users.status','users.first_name','users.cjm_wallet','users.eth_wallet','steps','bullets_shot','total_time'
            ])->get();
        if(!empty($active_user))
        {
            foreach ($active_user as $key => $value) 
            {

                $reward_detail = Reward::where('id',1)->first();

                $data               = ActiveUser::findOrFail($value['id']);
                $data->total_time   =   0;
                $data->status       =   0;
                $data->save();
            }

            flash()->success('Reward update successfully')->important();
            return redirect()->back();
        }
    }

    public function bnb_csm_coveter(Request $request)
    {
        
        $bnb_csm = BnbCsmCoveter::where('id','1')->first();


       return view('setting.bnb_csm_coveters',compact('bnb_csm'));
    }

    public function update_bnb_csm (Request $request){

        $data               =   BnbCsmCoveter::findOrFail($request->id);
        $data->csm          =   $request->csm;
        $data->bnb          =   $request->bnb;
        // $data->save();

        if($data->save()){
            flash()->success('BNB value update successfully')->important();
        }
        return redirect()->back();
    }
    
}
