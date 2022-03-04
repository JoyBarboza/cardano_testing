<?php

namespace App\Http\Controllers;

use App\User;
use App\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\EmailOtp;
use App\Mail\SendOtp;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	// return auth()->user()->hasRole('admin');
        $symbol = env('TOKEN_SYMBOL');
        if(auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.index');
        }
        
        $user=auth()->user();
        $getReferralUsers=User::where('referred_by',$user->id)->orderBy('id','DESC')->paginate(10);

        return view('home', compact('symbol','getReferralUsers'));
    }
    
    public function showTeam($member)
    {
		
        $member = User::where('email',$member)
            ->firstOrFail();

        $downlines = $member->referred()->get();
		
		$dataset = []; 
		foreach($downlines as $downline){ 
			$data = [];
			$downline_count = $downline->referred()->count();
			
			$disabled = ($downline_count>0)?false:true;
			
            
			$class = 'text-success';
			
			$data['id'] = $downline->email;
			$data['text'] = $downline->full_name;
			$data['icon'] = 'https://caesiumlab.com/images/user.jpg';
			$data['li_attr'] = [];
			$data['a_attr'] = ['class'=>$class];
			$data['children'] = !$disabled;
			
			$dataset[] = $data;
		}
		return json_encode($dataset);
    }
    
    public function showDetail($member)
    {
        $member = User::where('email',$member)
            ->firstOrFail();

        $downline = $member->referred()->get();
          
     

        return view('show',compact('member','downline'));
    }
    
    public function sendOTP(Request $request,$useremail=null){
        $otp = rand(100000, 999999);

        $details=[
            'otp'=>$otp
        ];
		$email ='';
		if($useremail){ 
			$email = urldecode($useremail);		
			EmailOtp::create(['email'=>$email,'email_otp'=>$otp,'type'=>'register']);
		}else{
			$otp=12345;
			$user = auth()->user();
			$email = $user->email;
			//$email = 'panditpiyali61@gmail.com';
			

			EmailOtp::create(['user_id'=>$user->id,'email_otp'=>$otp,'type'=>'withdraw']);
		}
		
        $s = Mail::to($email)->queue(new SendOtp($otp));
        session()->put('withdraw_email_otp', $otp);
        echo 'success';
    }
    
  
   
}
