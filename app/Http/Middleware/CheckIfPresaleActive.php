<?php

namespace App\Http\Middleware;

use Closure;
use App\Presale;

class CheckIfPresaleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $preSaleStatus = Presale::active()->exists();

        if($preSaleStatus) {
            return $next($request);
        }

        abort(404);

        /*$presale = new Presale();
        $is_active = $presale->active()->exists();//$presale->currentSale()
        if($is_active){
            // $pay_currency       = $request->input('PaycurrencyId');
            // $receive_currency   = $request->input('ReceivecurrencyId');dd($request->all());
            // $payeecoin = \App\Currency::find($request->input('PaycurrencyId'));
            // $receivecoin = \App\Currency::find($request->input('ReceivecurrencyId'));
            // $paycoin_name = $payeecoin->name;
            // $receivecoin_name = $payeecoin->name;

            // if($paycoin_name!='JPC'){
            //     return $next($request);
            // }
            $sale_details = $presale->currentSale();
            if($sale_details->status==1){

			}else{
				flash()->error('Error! No Sale is running currently!');
				return redirect('exchange');
			}
            
        }else{
            //return $next($request);

        }*/


    }
}
