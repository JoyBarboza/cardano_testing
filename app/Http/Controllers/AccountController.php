<?php

namespace App\Http\Controllers;

use App\Country;
use App\Document;
use App\UserMeta;
use Carbon\Carbon;
use App\Announcement;
use App\Events\Registered;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;
use App\User;
use Illuminate\Support\Facades\Mail;
use Snowfire\Beautymail\Beautymail;
use Storage;


class AccountController extends Controller
{
    protected $repository;

    const AC_VERIFICATION_HOURS = 72;

    protected $docs = [
        'Identity Proof', 'Photo'
    ];

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth')->except(['verification']);
    }

    public function verification($token = null)
    {
        try {
            $countries = Country::pluck('name', 'id');

            if(auth()->check()) {
                $user = auth()->user();

                // If document of user is already verified
                if( $user->isVerified() ) {
                    return redirect()->route('home');
                }

                if(!$token){
                    // If user is already logged in but not verified their account
                    
					/*
					if( $user->verificationPending() ) {
                        return view('account.kycreview');
                    }
					*/

                    return view('account.verification', compact('countries'));
                }

            }

            // Decrypt the token
            $token = decrypt($token);

            // Fetch the user token belongs from
            $user = $this->repository->whereVerificationToken($token);

            if( !$user->exists() ) {
                return view('errors.verification.token-invalid');
            }

            $user = $user->first();

            // If document of user is already verified
            if( $user->isVerified() ) {
                return redirect()->route('home');
            }

            // extract the time of sending token
            $time = explode('-', $token)[0];

            // Validate verification with account verification time frame
            $validToken = ((strtotime("now") - $time)/3600) <= self::AC_VERIFICATION_HOURS;

            if ( $validToken ) {
                $user->verified_at = Carbon::now();
                $user->save();
                
                flash()->success('Your Email has been successfully verified. '); 
                
                $beautymail = app()->make(BeautyMail::class);
              
                $beautymail->send('emails.after_verify_email', ['locale' => app()->getLocale()],
                    
                    function($message) use ($user)
                    {
                        $message
                            ->to($user->email, $user->first_name)
                            ->subject('Welcome!! to '.env('TOKEN_NAME'));
                    });
		
				return redirect()->route('login');
            }

            // If token has been expire
            // Regenerate verification token
            $user->verification_token = str_random(4); $user->save();
            event(new Registered($user, app()->getLocale())); // Send a verification email once again;

            return view('errors.verification.token-expire');

        } catch (DecryptException $exception) {
            return view('errors.verification.token-invalid');
        } catch (QueryException $exception) {
            return view('errors.verification.token-invalid');
        } catch (\Exception $exception) {
            return view('errors.verification.token-invalid');
        }
    }

    public function kycReview()
    {
        if(auth()->user()->verificationPending()) {
            return view('account.kycreview', compact('countries'));
        } else {
            return redirect()->to('home');
        }
    }

    public function getProfile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    

    public function getChangeBankDetail()
    {
        $user = auth()->user();
        return view('account.bank-account', compact('user'));
    }

    public function getChangeSetting()
    {
        $user = auth()->user();
        return view('account.setting', compact('user'));
    }

    public function showEditProfile(){
		$countries= Country::latest()->get();
        return view('account.EditMyProfile',compact('countries'));
    }

    public function updateMyProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.auth()->user()->id,
            'address' => 'required',
            'pin_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country_id' => 'required',
            'ide_no' => 'required',
            // 'doc_image' => 'required',
            // 'profile_image' => 'required',
            'doc_image' => 'required|mimes:jpg,jpeg,png|max:1500',
            'profile_image' => 'required|mimes:jpg,jpeg,png|max:1500',
        ]);

        $user = auth()->user();

        if($request->has('name')) {
            $user->first_name = $request->input('name');
            if($user->profile->account_type=='company'){
				$user->profile->company = $request->input('name');
			}
        }
		

        if($request->has('phone_no')) {
            $user->phone_no = $request->input('phone_no');
        }

        if($request->has('email')) {
            //$user->email = $request->input('email');
        }
        
        if($request->has('address')) {
            $user->profile->address = $request->input('address');
        }
        if($request->has('pin_code')) {
            $user->profile->pin_code = $request->input('pin_code');
        }
        if($request->has('city')) {
            $user->profile->city = $request->input('city');
        }
        if($request->has('state')) {
            $user->profile->state = $request->input('state');
        }
        if($request->has('country_id')) {
            $user->profile->country_id = $request->input('country_id');
        }
        
        if($request->has('ide_no')) {
            $user->profile->ide_no = $request->input('ide_no');
        }

        //~ $basepath = 'public'.DIRECTORY_SEPARATOR.$user->username;
        $basepath = 'public';

        if($request->hasFile('profile_image')) {
            $user->document()->where('name','PHOTO')->delete();
            $path = explode('/', $request->profile_image->store($basepath))[2];
            $document = new Document();

            $document->create([
                'user_id' => $user->id,
                'name' => 'PHOTO',
                'location' => $path,
                'status' => 1
            ]);
        }
        
        if($request->hasFile('doc_image')) {
           $user->document()->where('name','DOC_PHOTO')->delete();
            $docpath = explode('/', $request->doc_image->store($basepath))[2];
            $document = new Document();

            $document->create([
                'user_id' => $user->id,
                'name' => 'DOC_PHOTO',
                'location' => $docpath,
                'status' => 1
            ]);
        }

        if($user->save()){
			$user->profile->save();
            flash()->success(trans('auth/controller_msg.Success_Your_Profile_has_been_Updated'))->important();
        }

        return redirect()->back();
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
                'phone_no' => 'required|numeric|unique:users,phone_no,'.auth()->user()->id,
                'ide_no'=> 'required|unique:profiles,ide_no,'.auth()->user()->id,
                'identity' => 'required|image|max:1500',
                'photo' => 'required|image|max:1500',
                'country' => 'required|exists:countries,id',
            ]);
        
        $profile = []; $document = []; $user = auth()->user();

        if($request->has('phone_no')) {
            $user->phone_no = $request->input('phone_no');
        }

        if($request->has('address')) {
            $profile['address'] = $request->input('address');
        }

        if($request->has('zip')) {
            $profile['pin_code'] = $request->input('zip');
        }

        if($request->has('ide_no')) {
            $profile['ide_no'] = $request->input('ide_no');
        }

        if($request->has('state')) {
            $profile['state'] = $request->input('state');
        }
        if($request->has('city')) {
            $profile['city'] = $request->input('city');
        }
        if($request->has('country')) {
            $profile['country_id'] = $request->input('country');
        }

        //~ $basepath = 'public'.DIRECTORY_SEPARATOR.$user->username;
        $basepath = 'public';
        if($request->hasFile('identity')) {
            $user->document()->where('name','IDENTITY')->delete();
            $path = explode('/', $request->identity->store($basepath))[2];
            $document[] = new Document([
                'name' => 'IDENTITY',
                'location' => $path,
                'status' => 1
            ]);
        }

        if($request->hasFile('photo')) {
            $user->document()->where('name','PHOTO')->delete();
            $path = explode('/', $request->photo->store($basepath))[2];
            $document[] = new Document([
                'name' => 'PHOTO',
                'location' => $path,
                'status' => 1
            ]);
        }

        if(count($document) > 0) {
            $user->document()->saveMany($document);
        }

        $user->save();

        $user->profile()->update($profile);

        return redirect()->to('home');
    }

    public function updateSetting(Request $request, UserMeta $userMeta)
    {
        $this->validate($request, [
            'key' => 'required|in:news-letter,buy-btc,send-btc,recieve-btc,sell-btc,send-otp',
            'value' => 'required|in:true,false'
        ]);

        try {

            $user = $request->user();

            $meta = $user->userMeta()->where('meta_key', $request->key)->first();

            if($meta) {
                $meta->update([
                    'meta_value' => $request->value
                ]);
            } else {
                $userMeta->create([
                    'user_id' => $user->id,
                    'meta_key' => $request->key,
                    'meta_value' => $request->value
                ]);
            }

            $output = ['status' => true, 'message' => trans('auth/controller_msg.Success_Setting_updated')];
        } catch (\Exception $exception) {
            $output = ['status' => false, 'message' => trans('auth/controller_msg.Error_Setting_update_failed')];
        }

        return json_encode($output);
    }

    public function getUserDetails(Request $request)
    {

        if ($request->isMethod('post')){  
            $check_club_id = json_decode(file_get_contents('https://enticer.club/webservice/userdetails_ws.php?id='.$request->input('club_id_number')));
            if(($check_club_id->data->id != null) && ($check_club_id->data->id==$request->input('club_id_number'))){

                $response = response()->json(['response' => trans('auth/controller_msg.Success_Data_populate_successfully'), 'data'=>$check_club_id->data]);
            }else{

                $response = response()->json(['response' => trans('auth/controller_msg.Error_No_data_found'), 'data'=>'']);
            }

            return $response;
        }
    }

    public function security_2fa()
    {

        $user = auth()->user();
        $google2fa = new Google2FA();
        if(!$user->getMeta('google2fa')){
            $twofakey = $google2fa->generateSecretKey();
            $user->setMeta('google2fa',$twofakey);
            $user->setMeta('google2fa_on', 'off');
        }

        return view('account.security',compact('google2fa'));
    }

    public function security_2fa_post(Request $request)
    {
        $this->validate($request, [
            'twofa_secret' => 'required',
            '2fa_confirm' => 'required',
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();
        $secret = $request->input('twofa_secret');
        $valid = $google2fa->verifyKey($user->getMeta('google2fa'), $secret);

        if($valid) {

            if($user->getMeta('google2fa_on') != 'started')
                $user->updateMeta('google2fa_on','started');
            else
                $user->updateMeta('google2fa_on','off');

            flash()->success(trans('auth/controller_msg.Success_Successfully_update'))->important();
        }else{

            flash()->error('Invalid secret!')->important();
        }

        return redirect()->back();

    }

    public function checkTwoFa()
    {
        return view('auth.2fa');
    }

    public function verifyTwoFA(Request $request)
    {

        $this->validate($request, [
            'twofa_secret' => 'required',
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();
        $secret = $request->input('twofa_secret');
        $valid = $google2fa->verifyKey($user->getMeta('google2fa'), $secret);

        if($valid) {
            session()->put('twoFAVerified', true);
        }else{
            flash()->error(trans('auth/controller_msg.Error_Invalid_secret'))->important();
            return redirect()->back();
        }
        return redirect()->intended(route('home'));
    }
    
    public function change_password()
    {
		return view('account.changePassword');
	}
	
	public function updateMyPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'old_password' => 'required|match_old:'.auth()->user()->password
        ],['old_password.match_old'=> 'Wrong Password!']);

        $user = auth()->user();
        $user->password = bcrypt($request->input('password'));

        if($user->save()){
            flash()->success(trans('auth/controller_msg.Success_Your_Password_has_been_Updated'))->important();
        }
        return redirect()->back();
    }

    public function announcements(){
        $announcements = Announcement::where('status',1)->latest()->paginate(20);
        return view('account.announcement',compact('announcements'));
    }
    
    
}
