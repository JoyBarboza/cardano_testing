<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\EmailOtp;
use App\User;
use App\Setting;
use App\Events\Registered;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Repository\User\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\RegistrationFormRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Log;
use Snowfire\Beautymail\Beautymail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('guest');
        $this->repository = $repository;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegistrationFormRequest $request)
    {
		$dev_server_on = Setting::where('key','dev_server_on')->pluck('value')->first();
		if($dev_server_on==1){
			
			flash()->error( __('site is Maintainence mode') );
			return redirect()->back()->withInput($request->all());
		}
		
		$otp = EmailOtp::where('email',$request->email)->where('email_otp',$request->one_time_password)->first();
		if(!$otp){
			flash()->error( __('One Time Password verify is required') );
			return redirect()->back()->withInput($request->all());
		}
		
        //~ event(new Registered($user = $this->repository->createOrUpdate($request->all()), $locale = app()->getLocale()));
        $user = $this->repository->createOrUpdate($request->all()); 
        
        $user->verified_at = Carbon::now();
        $user->save();
        
        $beautymail = app()->make(BeautyMail::class);
              
		$beautymail->send('emails.after_verify_email', ['locale' => app()->getLocale()],
			
		function($message) use ($user)
		{
			$message
				->to($user->email, $user->first_name)
				->subject('Welcome!! to '.env('TOKEN_NAME'));
		});

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    public function registered($request, $user)
    {
		return redirect()->route('thankyou', [$user->id]);
        //return view('auth.thank-you', compact('user'));
    }

    public function showRegisterForm()
    {
		
		$string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 40);
		
        session()->put('phrase', $string); 
        
        $referal = request()->query('referral-code');
        if ($referal) {
            try{
                $userDet = User::where('referral', $referal)->first();               
                //~ session()->put('username', $userDet->username);    
                session(['username' => $userDet->referral]);             

            } catch (\Exception $exception) {
                Log::error($exception);
                flash()->error('Error! '.$exception->getMessage());
            }
        }
   

        return view('auth.register', compact('builder'));
    }

    protected function randomString($length = 4) {
		$str = "";
		$characters = array_merge(range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
    }

}
