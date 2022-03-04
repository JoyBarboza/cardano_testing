<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm()
    {
		$string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 40);
		
        session()->put('phrase', $string);    

        return view('auth.passwords.email', compact('builder'));
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

    protected function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'captcha' => 'required|passed'
        ],[
            'captcha.passed' => 'Captcha is invalid'
        ]);
    }
}
