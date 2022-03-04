<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Role;
use App\User;
use App\Presale;
use App\Document;
use App\Country;
use App\Currency;
use App\UserMeta;
use App\Transaction;
use App\Http\Requests;
use App\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Repository\User\UserRepository;
use App\Http\Requests\RegistrationFormRequest;
use Session;

class UserController extends Controller
{
  protected $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function index()
  {
    $request = request();

    $query = $this->repository->exceptMe()->latest();

    if(strcasecmp($request->get('search'), 'true')==0)
    {
      if($request->has('first_name') && ($request->first_name!="")) {
        $query->where('first_name', 'like', "%".$request->first_name."%");
      }
      if($request->has('last_name') && ($request->last_name!="")) {
        $query->where('first_name', 'like', "%".$request->last_name."%");
      }
      if($request->has('email') && ($request->email!="")) {
        $query->where('email', 'like', "%".$request->email."%");
      }
      
       if($request->input('kyc_verified') && ($request->kyc_verified!="")) {
			$search_ide_verify=$request->input('kyc_verified'); 
			if($search_ide_verify==1){
				$query->whereHas('profile', function($q) use ($request) {
					$q->where('profiles.kyc_verified', '1');
				});
				
			}else if($search_ide_verify==2){	
				$query->whereHas('profile', function($q) use ($request) {				
					  $q->where('profiles.kyc_verified', '0')
					  ->where('profiles.ide_no', '!=',NULL);
				});
					
			}else if($search_ide_verify==3){	
				$query->whereHas('profile', function($q) use ($request) {					
					  $q->where('profiles.kyc_verified', '0')
					  ->where('profiles.ide_no',NULL);
				});						
			}
		}
      if($request->has('role') && ($request->role!="")) {
        //~ $role = $request->role;
        //~ $query->whereHas('roles', function($query) use ($role) {
          //~ $query->where('name', $role);
        //~ });
      }
      if($request->has('status') && ($request->status!="") ) {
        $query->where('status', '=', $request->status);
      }            
    }

    $users = $query->paginate(10)->appends($request->query());
	
    $roles = Role::all();
    return view('user.index',compact('users', 'roles'));
  }

  public function create()
  {
    return view('user.create');
  }

  public function store(RegistrationFormRequest $request)
  {
    try {
      event(new Registered($user = $this->repository->createOrUpdate($request->all())));
      return json_encode(['status' => true, 'message' => trans('auth/controller_msg.Success_User_created')]);
    } catch (\Exception $exception) {
      Log::error($exception->getMessage());
      return json_encode(['status' => false, 'message' => trans('auth/controller_msg.Error_User_creation_failed')]);
    }

  }

  public function edit($user)
  {
	$countries= Country::latest()->get();
    $user = $this->repository->find($user);
    return view('user.edit',compact('user','countries'));
  }

  public function update(RegistrationFormRequest $request,  $user)
  {
    try {
      $this->repository->createOrUpdate($request->all(), $user);
      return json_encode(['status' => true, 'message' => trans('auth/controller_msg.Success_User_updated')]);
    } catch (\Exception $exception) {
      return json_encode(['status' => false, 'message' => trans('auth/controller_msg.Error_User_creation_failed')]);
    }
  }

  public function show($user)
  {
    $user = $this->repository->find($user);
    return view('user.show', compact('user'));
  }

  public function destroy($user)
  {
    try {
      $user = $this->repository->find($user);
      $user->delete();
      $output = ['status' => true, 'message' => trans('auth/controller_msg.Success_User_deleted')];
    } catch (\Exception $exception) {
      $output = ['status' => false, 'message' => trans('auth/controller_msg.Error_deleting_user')];
    }
    return json_encode($output);
  }

  public function getProfile()
  {
    session()->put('basic', 'active');
    return view('user.profile');
  }

  public function getReferral(Request $request)
  {
    //$users = $this->repository->whereHas('referredBy')->paginate(10);
     $query = $this->repository->whereHas('referredBy');
    
    if($request->has('user_email') && ($request->user_email!="")) {
		 $query->Where('users.email', 'like', "%".$request->user_email."%");
	   
	}
	if($request->has('sponser_email') && ($request->sponser_email!="")) {
		 $all_user= User::Where('users.email', 'like', "%".$request->sponser_email."%")->pluck('id')->toArray();
	   $query->WhereIn('referred_by', $all_user);
	}
    $users =$query->latest()->paginate(10); 
    return view('user.referral', compact('users'));
  }

  public function profileUpdate(Request $request)
  {
    $this->validate($request, [
      'firstname' => 'required|max:191',
      'email' => 'unique:users,email,'.auth()->id().'id',
      'mobile_no' => 'required'
    ]);

    $user = auth()->user();

    $userData = [
        'first_name' => $request->firstname,
        'middle_name' => $request->middlename,
        'last_name' => $request->lastname,
        'email' => $request->email,
        'phone_no' => $request->mobile_no
    ];

    $profileData = [
      'address' => $request->address,
      'city' => $request->city,
      'state' => $request->state,
      'pin_code' => $request->pincode
    ];

    try {

      $user->update($userData);

      $user->profile->update($profileData);

      flash()->success(trans('auth/controller_msg.message_has_been_done'))->important();

    } catch (\Exception $exception) {
      Log::error($exception->getMessage());
      flash()->error(trans('auth/controller_msg.error_updating_profile'))->important();
    }


    return redirect()->back();
  }

  public function changePicture(Request $request)
  {

    $this->validate($request, [
      'profile_pic' => 'required|image|max:1000'
    ]);

    try {

      $user = auth()->user();

      $path = 'public'.DIRECTORY_SEPARATOR
          .$user->username.DIRECTORY_SEPARATOR
          .$user->getDocumentPath('PHOTO');

      $user->document()->delete();
      Storage::delete($path);

      $path = $request->file('profile_pic')
          ->store('public'.DIRECTORY_SEPARATOR.$user->username);

      $user->document()->save(new Document([
        'name' => 'PHOTO',
        'location' => explode('/', $path)[2],
      ]));

      flash()->success(trans('auth/controller_msg.Profile_picture_has_been_changed'))->important();

    } catch (QueryException $exception) {

      Log::error('Error! From Change Picture: ' . $exception->getMessage());
      flash()->error(trans('auth/controller_msg.Changing_profile_picture'));

    } catch (\Exception $exception) {
      Log::error('Error! From Change Picture: ' . $exception->getMessage());
      flash()->error()->important();

    }

    return redirect()->back();
  }

  public function changePassword(Request $request)
  {
    $user = auth()->user();

    $this->validate($request, [
        'password' => 'required|confirmed|min:6',
        'old_password' => 'required|match_old:'.$user->password
    ],[
      'old_password.match_old' => 'Old password doesn\'t match'
    ]);

    try {

      $user->update([
          'password' => bcrypt($request->input('password'))
      ]);

      flash()->success(trans('auth/controller_msg.Success_Profile_password_has_been_changed'))->important();

    } catch (QueryException $exception) {

      Log::error(trans('auth/controller_msg.Error_Changing_profile_password') . $exception->getMessage());

      flash()->error(trans('auth/controller_msg.Error_Changing_profile_password'))->important();

    } catch (\Exception $exception) {

      Log::error(trans('auth/controller_msg.Error_Changing_profile_password'). $exception->getMessage());

      flash()->error(trans('auth/controller_msg.Critical_Error_Changing_profile_password_failed'))->important();

    }

    $this->activeTab = 'password';
    return redirect()->back();
  }

  public function getLimit()
  {
    return view('user.limit');
  }

  public function setLimit(Request $request, $user)
  {
    try
    {
      $user = $this->repository->find($user);
      foreach ($request->except('_token') as $key => $value)
      {
        $meta = $user->userMeta()->where('meta_key', $key)->first();

        if($meta) {
          $meta->update(['meta_value' => $value]);
        } else {
          $user->userMeta()->save(new UserMeta([
              'meta_key' => $key,
              'meta_value' => $value
          ]));
        }
      }

      $output = ['status' => true, 'message' => trans('auth/controller_msg.Success_Limit_has_been_set')];
    } catch (\Exception $exception) {
      $output = ['status' => false, 'message' => trans('auth/controller_msg.Error_Limit_has_been_not_been_set')];
    }
    return json_encode($output);
  }

  public function loginAs($id)
  {
    $user = $this->repository->findOrFail($id); 

    if( ! $user->hasRole('admin') )
    {
		Session::put('adminLogin', true);
		Auth::login($user);
    }
    else
    {
      flash()->error(trans('auth/controller_msg.Impersonate_disabled_for_this_user'));
    }

    return redirect()->route('home');
  }
  
  public function user_account(Transaction $transaction){
	  
		$request = request();
    $symbol = env('TOKEN_SYMBOL');

		$query = User::where('status',1)->where('verified_at','!=',null)->latest();

		if($request->has('query') && ($request->input('query')!='')) {
			$query = $query
				->where('email', $request->input('query'))
				->orWhere('first_name', 'like', '%'.$request->input('query').'%')
				->orWhere('last_name', 'like', '%'.$request->input('query').'%');
		}

		$users = $query->paginate(15)->appends($request->query());
	  
	  return view('user.account',compact('users','symbol'));
  }
  
  public function balanceCredit($userid){
	  $user = User::where('id',$userid)->first();
	  return view('user.balanceCredit',compact('userid','user'));
  }
  
  public function balanceDebit($userid){
	   $user = User::where('id',$userid)->first();
	  return view('user.balanceDebit',compact('userid','user'));
  }
  public function balanceCreditSubmit(Request $request){
	  $this->validate($request, [
			'usd_balance' => 'nullable|numeric',
			'msc_balance' => 'nullable|numeric',
			'description' => 'required|min:8',
	
        ]); 
      $symbol = env('TOKEN_SYMBOL');
		  $message ='';
		
		
      $usd = $request->usd_balance;
      $msc = $request->msc_balance;
      $user= $request->user_id;
      $description = $request->description;
      
      if(($usd==''||$usd <=0) && ($msc==''||$msc <=0)){
        $message .="Enter valid Credit Amount";
        flash()->error($message);
            return redirect()->route('admin.user.account');
      }
	  
      $currency = new Currency;
        
        $usd_details 	= $currency->getCoinByName('USD')->first(); 
      $msc_details 	= $currency->getCoinByName($symbol)->first(); 
    
      
      if(($usd!='') && ($usd >=0) && ($usd !='0.00')){
      $transaction_usd = Transaction::create([
                'user_id' => $user,
                'currency_id' => $usd_details->id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Credit',
                'amount' => $usd,
                'source' => 'Admindeposit',
                'description' => $description,
                'status'=>1
              ]);
        $message .= trans('auth/controller_msg.USD_Balance_Credited_Successfully').'. <br>';
      }
      if(($msc!='') && ($msc >= 0) && ($msc != '0.00')){
		$transaction_msc = Transaction::create([
                'user_id' => $user,
                'currency_id' => $msc_details->id,
                'reference_no' => uniqid('TXN'.time()),
                'type' => 'Credit',
                'amount' => $msc,
                'source' => 'Admindeposit',
                'description' => $description,
                'status'=>1
              ]);
        $message .= $symbol.' balance Credited successfully.';
        
        $presale = Presale::where('status',1)->where('presales.total_coin_unit','>','presales.sold_coin')->orderBy('start_date','ASC')->first();
		$presale->sold_coin += $msc;
		$presale->save();
      }
      
      
      flash()->success($message);
      return redirect()->route('admin.user.account');
		
  }
  
  public function balanceDebitSubmit(Request $request){
	  $this->validate($request, [
			'usd_balance' => 'nullable|numeric',
			'msc_balance' => 'nullable|numeric',
			'description' => 'required|min:8',
	
        ]); 
		$message ='';
		$symbol = env('TOKEN_SYMBOL');
		
	  $usd = $request->usd_balance;
	  $msc = $request->msc_balance;
	  $user= $request->user_id;
	  $description = $request->description;
	  
	  if(($usd==''||$usd <=0) && ($msc==''||$msc <=0)){
			$message .="Enter valid Debit Amount";
			flash()->error($message);
          return redirect()->route('admin.user.account');
	  }
	  
	  $currency = new Currency;
      
    $usd_details 	= $currency->getCoinByName('USD')->first(); 
	  $msc_details 	= $currency->getCoinByName($symbol)->first(); 
	  
	  
	  
	  $usd_balance = User::find($user)->getBalance('USD');//auth()->user($user);
	  $msc_balance = User::find($user)->getBalance($symbol);
	  
	 
	  if(($usd!='') && ($usd >= 0) && ($usd !='0.00')){
		  if(($usd_balance>0) && ($usd <= $usd_balance) ){
			$transaction_usd = Transaction::create([
								'user_id' => $user,
								'currency_id' => $usd_details->id,
								'reference_no' => uniqid('TXN'.time()),
								'type' => 'Debit',
								'amount' => $usd,
								'source' => 'Admindebit',
								'description' => $description,
								'status'=>1
							]);
				$message .= trans('auth/controller_msg.USD_Balance_debited_successfully').' <br>';
			}else{
				$message .= trans('auth/controller_msg.Insufficient_USD_Balance').'. <br>';
			}
		}
		if(($msc!='') && ($msc >= 0) && ($msc != '0.00')){
			if(($msc_balance>0) && ($msc<=$msc_balance)){
				$transaction_msc = Transaction::create([
									'user_id' => $user,
									'currency_id' => $msc_details->id,
									'reference_no' => uniqid('TXN'.time()),
									'type' => 'Debit',
									'amount' => $msc,
									'source' => 'Admindebit',
									'description' => $description,
									'status'=>1
								]);
				$message .= $symbol.' balance has been debited successfully. <br>';
				
				$presale = Presale::where('status',1)->where('presales.total_coin_unit','>=','presales.sold_coin')->orderBy('start_date','ASC')->first();
				$presale->sold_coin -= $msc;
				$presale->save();
			}else{
				$message .= 'User do not have sufficiant CSM balance .';
				}
		}
		
	
	  flash()->success($message);
    return redirect()->route('admin.user.account');
  }
  
  public function userdoc($user)
  {
    $user = $this->repository->find($user);
    return view('user.showdoc', compact('user'));
  }
  
  public function verifyEmail(Request $request,$id){
	  $user=User::where('id',$id)->first();
		if(!$user){
			flash()->error('User not exist');
			return redirect()->back();
		}
		if($user->verified_at){
			flash()->error('user email is already verified');
			return redirect()->back();
		}
		  $user->verified_at = Carbon::now();
		  $user->save();
      
		flash()->success('User has been successfully verified');
			return redirect()->back();
	}
  
}
