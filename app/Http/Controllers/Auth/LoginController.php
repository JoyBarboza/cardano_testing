<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Events\Registered;
use App\Setting;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */

    public function showLoginForm()
    {
		$string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 40);
		
        session()->put('phrase', $string);    

        return view('auth.login', compact('builder'));
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
     
    protected function authenticated(Request $request, $user)
    {
		$dev_server_on = Setting::where('key','dev_server_on')->pluck('value')->first();
		if($dev_server_on==1){
			if(!($user->isAdmin())){
				auth()->logout();
				flash()->error( __('site is Maintainence mode') );
				return redirect()->back()->withInput($request->all());
			}
			
		}
		// return $user;
        
        if(!$user->verified_at) {
			

			event(new Registered($user, $locale = app()->getLocale()));

            flash()->error(trans('auth/controller_msg.mail_has_not_been_verified'))->important();
            auth()->logout();
            return redirect()->back();
        }

        if(!$user->status) {
            flash()->error(trans('auth/controller_msg.account_blocked'))->important();
            auth()->logout();
            return redirect()->back();
        }

        if($user->hasRole('admin')) {
            return redirect()->intended(route('admin.index'));
        }

        if($user->hasRole('nft')) {
            return redirect()->intended(route('nft.nft_collection'));
        }


        if($user->language) {
            session()->put('locale', $user->language);
            app()->setLocale('en');
        }
		
		return redirect()->intended(route('home'));
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha' => 'required|passed'
        ],[
            'captcha.passed' => 'Captcha is invalid'
        ]);

        session()->forget('phrase');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/'.app()->getLocale());
    }
    
    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }
}
