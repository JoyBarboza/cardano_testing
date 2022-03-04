<?php

namespace App\Http\Controllers\Admin;

use App\DepositCoinDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Session;

class DepositAddressController extends Controller
{
    public function index(){
        $depositaddress = DepositCoinDetail::latest()->paginate(20);

        return view('depositaddress.index', compact('depositaddress'));
    }

    public function create(){
        return view('depositaddress.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'coin'      => 'required|max:255',
            'address'=> 'required',
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

            DepositCoinDetail::create([
                'coin' => $request->input('coin'),
                'address' => $request->input('address'),
                'status' => $request->input('status'),
            ]);

            flash()->success('Coin details successfully added');

        } catch (\Exception $exception) {
            Log::error('Error!!'.$exception->getMessage());

            flash()->error('Error!!'.$exception->getMessage());
        }

        return redirect()->route('admin.depositaddress.index');
    }

    public function edit($id)
    {
        $depositaddress = DepositCoinDetail::findOrFail($id);

        return view('depositaddress.edit', compact('depositaddress'));

    }

    public function update(Request $request, $id)
    {
		$this->validate($request, [
            'coin'      => 'required|max:255',
            'address'=> 'required',
            'one_time_password' => 'required'
           
        ]);
        
        
        $otp = Session::get('withdraw_email_otp'); 
        if(!$otp){
			flash()->error('One Time Password verify is required');
			return redirect()->back();
		}
        
		$user_otp = $request->input('one_time_password'); 

		if($otp!=$user_otp){ 
			flash()->error('Error! Invalid Email One Time Password');
			return redirect()->back();
		}
		
		
        $depositCoinDetail = DepositCoinDetail::findOrFail($id);

        $depositCoinDetail->coin = $request->input('coin');
        $depositCoinDetail->address = $request->input('address');
        $depositCoinDetail->status = $request->input('status');
        

        try {
            $depositCoinDetail->save();

            flash()->success(trans('Coin details successfully updated'));
        } catch (QueryException $exception) {

            Log::error('Error!!'.$exception->getMessage());
            flash()->error('Error!!'.$exception->getMessage());

        } catch (\Exception $exception) {

            Log::error('Error!!'.$exception->getMessage());
            flash()->error('Error!!'.$exception->getMessage());
        }

        return redirect()->route('admin.depositaddress.index');
    }

  
    public function delete($id)
    {
      
    }
}
