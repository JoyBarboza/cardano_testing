<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserVerified
{
    protected $except = [
        '*/account/two-factor-authentication'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if(($user->getMeta('google2fa_on') == 'started') && (!session()->get('twoFAVerified'))) {
            if($request->session()->get('adminLogin')!=true){
                return redirect()->route('account.twofacode');
            }
        }
        return $next($request);
    }
}
