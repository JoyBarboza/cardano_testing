<?php

namespace App\Providers;

use App\Operation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\BtcController;
use App\Http\Controllers\WtcController;
use App\Http\Controllers\InrController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Repository\Exchange\ExchangeRepository;
use App\Libs\Wtcwallet;
use App\Libs\Dashwallet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('verify_btc_address', function ($attribute, $value, $parameters) {
            if($parameters[0]=='btc'){
                return ExchangeRepository::verifyWallet($value);
            }else if($parameters[0]=='wtc'){
                $wallet = new Wtcwallet;
                return $wallet->validaddress($value);
            }else if($parameters[0]=='dash'){
                $wallet = new Dashwallet;
                return $wallet->validaddress($value);
            }
        });


        Validator::extend('check_club_id', function ($attribute, $value, $parameters) {
            
            $return = false;
            //$check_club_id = json_decode(file_get_contents('https://enticer.club/webservice/userdetails_ws.php?id='.$value));
            //if(($check_club_id->data->id != null) && ($check_club_id->data->id==$value))
            //$return = true;

            return true;

            
        });

        

        validator::extend('checkDepositTxn',function ($attribute, $value, $parameters) {

            $user = auth()->user();
            $check = \App\Payment::where('reference_no', '')->where('user_id',$user->id)->where('remarks','bankdeposit')->first();

            return ($check)?true:false;
        });

        // Check the balance of user of specified coin
        Validator::extend('check_fund', function ($attribute, $value, $parameters) {
            $user = auth()->user();

            return $value <= $user->{$parameters[0]};
        });


        Validator::extend('match_old', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });

        Validator::replacer('check_fund', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':wallet'], $parameters, $message);
        });

        Validator::extend('check_limit', function ($attribute, $value, $parameters, $validator) {
            $user = auth()->user();
            return $value <= ($user->totalLimit($parameters[0], $parameters[1]) - $user->bought($parameters[0], $parameters[1]));
        });

        Validator::extend('passed', function ($attribute, $value, $parameters) {
            $phrase = session()->get('phrase');
            return $phrase == $value;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repository\Message\IMessageRepository', 'App\Repository\Message\MessageRepository');
    }
}
