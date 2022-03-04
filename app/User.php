<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait { restore as private restoreA;}
    use SoftDeletes { restore as private restoreB;}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'verification_token','referral','referred_by',
        'username', 'email', 'phone_no', 'password', 'status',
        'csm_wallet','eth_wallet','daedalus_wallet','seed_pharse','wallet_password','wallet_update'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referred()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function document()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function bankdeposit()
    {
        return $this->hasMany(BankDeposit::class, 'uid');
    }

    public function payment(){

        return $this->hasMany(Payment::class, 'user_id');
    }

    public function coinAddress(){

        return $this->hasMany(CoinAddress::class, 'user_id');
    }

    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function activeUser()
    {
        return $this->hasMany(ActiveUser::class, 'user_id');
    }

    public function getMeta($key)
    {
        $query = $this->userMeta()->where('meta_key', $key);

        if($query->exists()) {
            $output = $query->first();
            return $output->meta_value;
        }

        return null;
    }

    public function setMeta($key, $value)
    {
        $meta = new UserMeta([
            'user_id' => $this->id,
            'meta_key' => $key,
            'meta_value' => $value,
        ]);

        return $this->userMeta()->save($meta);
    }

    public function updateMeta($key,$value){

        UserMeta::where('meta_key', $key)
          ->where('user_id', $this->id)
          ->update(['meta_value' => $value]);
    }

    // public function getBtcAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'BTC']))->first()->balance;
    // }

    // public function getJpcAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'JPC']))->first()->balance;
    // }

    // public function getMscAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'MSC']))->first()->balance;
    // }

    // public function getCSMAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'CSM']))->first()->balance;
    // }

    // public function getUsdAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'USD']))->first()->balance;
    // }

    // public function getDashAttribute()
    // {
    //     return collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'DASH']))->first()->balance;
    // }

    public function getAvailableBalanceAttribute()
    {
        $preWithdraw = $this->operation()->withdrawInr()
            ->initiated()->sum('destination_amount');
        return ($preWithdraw > 0 )?
            collect(DB::select('call sp_getMyBalance(?, ?)', [$this->id, 'USD']))
                ->first()->balance - $preWithdraw:0;
    }

    // Operation on User model

    public function isVerified()
    {
        $verified = $this->verified_at;

        $docVerified = $this->document()
            ->whereIn('name', ['IDENTITY', 'PHOTO'])
            ->sum('status');

        // 4 is the sum of at least two document status
        // where each document is supposed to be approved
        // by admin
        return ($verified && ($docVerified >=4));
    }

    // Operations on User model
    public function verificationPending()
    {
        $mailVerified = $this->verified_at;
        
        $query = $this->document()
            ->whereIn('name', ['IDENTITY', 'PHOTO']);
        $docSubmited = $query->exists();
        $docVerified = $query->sum('status');
        
        // 2 is the sum of at least two document pending status
        // where each document is supposed to be uploaded
        // by user
        return ($mailVerified && $docSubmited && ($docVerified == 2));
    }

    public function isNotVerified()
    {
        return ! $this->isVerified();
    }

    // Mutators

    public function setVerificationTokenAttribute($value)
    {
        $string = strtotime("now").'-'.uniqid(str_random(70).'-').'-'.$value;
        $this->attributes['verification_token'] = $string;
    }
    
    public function setStatusAttribute($value)
    {
        $status = ['active'=>1,'deactive'=>0];
        $this->attributes['status'] = $status[$value];
    }

    /**
     *
     * Get full name of a user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return implode(
            ' ',
            array_filter(
                [
                    $this->first_name,
                    $this->middle_name,
                    $this->last_name
                ],
                function($item) {

                    return ! empty($item);

                }
            )
        );
    }

    /**
     * Some trait based method overload
     */

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * Users except self
     */

    public function scopeExceptMe($query)
    {
        return $query->where('id', '!=', auth()->id());
    }

    public function assign()
    {
        $array = func_get_args();
        foreach ($array as $value) {
            $role = Role::where('name', $value)->first();
            if($role) {
                $this->attachRole($role);
            }
        }
        return true;
    }

    public function retract()
    {
        $array = func_get_args();
        foreach ($array as $value) {
            $role = Role::where('name', $value)->first();
            if($role) {
                $this->detachRole($role);
            }
        }
        return true;
    }

    public function getDocumentPath($document)
    {
        return $this->document()
            ->where('name',$document)
            ->pluck('location')
            ->first();
    }

    public function totalLimit($coin, $type)
    {
        $result = $this->getMeta($coin.'_'.$type.'_LIMIT');

        if(!$result) {
            $setting = new Setting();
            return (int) $setting->getMeta($coin.'_'.$type.'_LIMIT');
        }
        return (int) $result;
    }

    public function bought($coin, $type)
    {
        $sumAmount = ($type=='BUY') ? 'destination_amount' : 'source_amount';
        return $this->operation()
            ->where('name', $type.'_'.$coin)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->sum($sumAmount);
    }

    public function recipient()
    {
        return $this->hasMany(Recipient::class, 'user_id');
    }

    public function getUsersToMail()
    {
        return $this->exceptMe()->pluck('first_name', 'id')->toArray();
    }


    public function getLanguageAttribute()
    {
        return $this->profile->locale;
    }

    public function setLanguageAttribute($value)
    {
        return $this->profile()->update(['locale' => strtolower($value)]);
    }
    
    public function getBalance($coin)
    {
        //$coin = Currency::where('name', $coin)->pluck('id')->first();
        $result = 0;
        if($coin) {
            $result = DB::select('CALL 	sp_getMyBalance(?, ?)', [$this->id, $coin]);

            return ($result[0]->balance)?$result[0]->balance:0;
        }
        return $result;

    }

    public function getPhotoAttribute()
    {
        $photo = $this->document()->where('name','PHOTO')->pluck('location')->first();

        return $photo?:'no-image.jpg';
    }

    public function getReferralBonus($username='')
    {
        return $this->transaction()
            ->whereHas('currency', function($q){
                $q->where('name', 'TIME');
            })->where('source', 'Referral Bonus')->where('description','Referral Bonus From '.$username)
            ->sum('amount');
    }
    public function withdraw()
    {
        return $this->hasMany(Withdraw::class, 'user_id');
    }
    
    public function isAdmin()
    {
		if($this->id==1){
			return 1;
		}
		return false;
    }
}
