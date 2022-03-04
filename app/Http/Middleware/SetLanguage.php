<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguage
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

        $locale = strtolower($request->segment(1));

        if ( ! array_key_exists($locale, config('app.locales'))) {

            $segments = $request->segments();
            $segments[0] = isset($request->user()->language) ?
                $request->user()->language : config('app.default_lang');

            return redirect()->to(implode('/', $segments));
        } else if(isset($request->user()->language) && ($request->user()->language != $locale)){
	   $segments[0] = $request->user()->language;
	   return redirect()->to(implode('/', $segments));
	}

        app()->setLocale($locale);

        return $next($request);
    }
}
