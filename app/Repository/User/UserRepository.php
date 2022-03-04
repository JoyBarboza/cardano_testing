<?php
/**
 * Created by PhpStorm.
 * User: amit
 * Date: 11/7/17
 * Time: 6:28 PM
 */

namespace App\Repository\User;

use App\Profile;
use App\Role;
use App\User;
use DB;

class UserRepository
{

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->user, $method], $args);
    }

    public function createOrUpdate(array $data, $id = null)
    {
        if($id) {

            $user = $this->user->find($id);

            return DB::transaction(function() use ($user, $data) {

                $updatedData = [
                    'first_name' => $data['name'],
                    
                    //'username' => $data['username'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                    'phone_no' => $data['phone'],
                ];

                if(isset($data['password'])) {
                    $updatedData['password'] = bcrypt($data['password']);
                }

                //~ if(isset($data['role'])) {
                    //~ $role = Role::where('name', $data['role'])->first();
                //~ } else {
                    //~ $role = Role::where('name', 'subscriber')->first();
                //~ }
                //~ $user->attachRole($role);

                $user->update($updatedData);
                
                $profileData = [
                    'locale' => app()->getLocale(),
                     'address' => $data['address'], 
                     'pin_code' => $data['pin_code'],
                     'city' => $data['city'],
                     'country_id' => $data['country_id'],
                     'state' => $data['state'],
                     'ide_no' => $data['ide_no'],
                     'kyc_verified' => ($data['kyc_verified']==1)?1:0,
                     'account_type' => $data['account_type'], 
                ];
          
                
                if($data['account_type']=='company'){
					$profileData['company']=$data['name'];
				}
                
				
				$user->profile->update($profileData);

                return $user;
            });
        } else {
            // Start a transaction
            return DB::transaction(function() use ($data) {
				if(isset($data['status'])){
					$status = $data['status'];
				}else{
					$status = 'active';
				}
				
				if($data['first_name']!=''){
					$firstname = $string = strtolower(str_replace(' ', '', $data['first_name']));
					$referralAuto = $firstname;
				}else{					
					$referralAuto = mt_rand(1000000, 9999999);
				}
				$referral_Check=false;				
				
				while($referral_Check==false) {
					$getUser= User::where('referral',$referralAuto)->first();
					if(!$getUser){
						$referral_Check=true;
					}else{
						$referralAuto=$referralAuto.'_'.mt_rand(1,9);
					}
				}

                // Create a user

                $userData = [
                    'first_name' => $data['first_name'],
                    //'middle_name' => $data['middle_name'],
                    //'last_name' => $data['last_name'],
                    //'username' => strtolower($data['username']),
                    'email' => strtolower($data['email']),
                    'password' => bcrypt($data['password']),
                    'phone_no' => $data['phone'],
                    'status' => $status,
                    'verification_token' => str_random(4),
                    'referral' => $referralAuto,
                ];
                
                 $profileData = [
                    'locale' => app()->getLocale(),
                    'account_type' => $data['account_type'], 
                    
                ];
                
                if($data['account_type']=='company'){
					$profileData['company']=$data['first_name'];
				}

                if(isset($data['referral_code'])) {
                    $referredBy = $this->user
                        ->where('referral', $data['referral_code'])
                        ->pluck('id')->first();

                    $userData['referred_by'] = $referredBy;
                }

                $user = $this->user->create($userData);

                $user->profile()->save(new Profile($profileData));

                //~ if(isset($data['role'])) {
                    //~ $role = Role::where('name', $data['role'])->first();
                //~ } else {
                    //~ $role = Role::where('name', 'subscriber')->first();
                //~ }

                //~ $user->attachRole($role);

                return $user;
            });
        }
    }
}
