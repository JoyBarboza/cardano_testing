<?php namespace App\Http\Controllers;

use App\User;
use App\Presale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    public function thankYou(Request $request,$user_id=null){
		$user=User::where('id',$user_id)->first();
		return view('auth.thank-you', compact('user'));
	}
	
    public function welcome(Presale $presale)
    {//session_start();
    //echo  request()->session()->getId();
//echo dd($_COOKIE['PHPSESSID']);die;
        $presales = $presale->activeStatus()->orderBy('start_date', 'asc')->get();
        $current = $presale->active()->first();

        if(!$current) {
            $current = $presale->where('end_date', '>=', Carbon::now())->first();
        }

        return view('page.welcome', compact('presales', 'current'));
    }
    
    public function setLocale($locale)
    {
        $locale = strtolower($locale);

        if (! array_key_exists($locale, config('app.locales'))) {
            return json_encode(['status' => false, 'locale' => null]);
        }

        $request = request();

        if($request->user()){
            $request->user()->language = $locale;
        }

        App::setLocale($locale);

        $url = explode('/', parse_url(url()->previous())['path']);
        $url[1] = $locale;
        $url = implode('/', $url);

        return json_encode(['status' => true, 'locale' => $url]);
	}
}
