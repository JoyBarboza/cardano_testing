<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class RewardController extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		$this->form_validation->set_error_delimiters('', '');
	}
	
	public function checkActiveUserOld_post()
	{ 
	    $_POST = json_decode(file_get_contents("php://input"), true);

	   // $details = $this->input->post();
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }

        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }
        
        $user = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_id']),'users');
		
		if (empty($user)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Wrong Token',
				'object'	=> new stdClass()
			));
		}
		
	    
	    if($user->status == 0)
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('you_deactived_by_admin'),
				'object'	=> new stdClass()
			));	
		}
		
		if(!empty($user->deleted_at))
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('you_deleted_by_admin'),
				'object'	=> new stdClass()
			));	
		}
		
        $user_id = $_POST['user_id'];
        $status  = $_POST['status'];
        

		$checkUser = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user_id),'active_users');

		$insert_active_user 	= array(
        	"user_id" 			=> $user->id,
        	"status" 			=> $status,
    	    "created_at"    	=>  date('Y-m-d H:i:s'),
        );

		if(!empty($checkUser)){
			$setActiveUser = $this->CommonModel->updateRowByCondition(array("id" => $checkUser->id),'active_users',$insert_active_user);
		}else{
			$setActiveUser  = $this->CommonModel->insertData($insert_active_user,' active_users');
		}


		$totalActiveUser = $this->CommonModel->select_single_row("Select count(*) as total from active_users where status = 1");
		$reward = $this->CommonModel->selectRowDataByCondition(array("id" => 1),'rewards');


		if($totalActiveUser->total >= $reward->total_user)
		{
			$current_date = date('Y-m-d H:i:s', strtotime('-'.$reward->time));

			$getActiveUser = $this->CommonModel->selectResultDataByCondition(array("status" => 1,"created_at >=" => $current_date),'active_users');


			if(!empty($getActiveUser))
			{
				// echo "1";die;
				$countActiveUser = $this->CommonModel->select_single_row("Select count(*) as total from active_users where status = 1 AND created_at >='".$current_date."' ");

				if(!empty($countActiveUser))
				{
					if($countActiveUser->total >= $reward->total_user)
					{
						// $msg="Time blockchain active";

						$distribute_reward = $reward->reward/$countActiveUser->total;

						// print_r($distribute_reward);
						foreach ($getActiveUser as $key => $value) 
						{
							// print_r($value->user_id);die;
							$user_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $value->user_id),'users');

							 $wallet = $user_detail->cjm_wallet;

							 $total_amount = $wallet + $distribute_reward;
	    
						    $updateUserWalletData = array( 
				                "cjm_wallet"     =>  $total_amount,
				            );
				        
				            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $user->id),'users',$updateUserWalletData); 

				            if($update_user_wallet){
				            	$msg="Time blockchain active.Reward send to your wallet";
				            }else{
				            	$msg="Somethings went Wrong";
				            }
						}
					}else{
						$msg="Time blockchain not active";
					}
				}else{
					$msg="Time blockchain not active";
				}
			}else{
				$msg="Time blockchain not active";
			}
		}else{
			$msg="Time blockchain not active";
		}

        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			// 'object'	=> $dataText
		));
	}

	public function checkActiveUser_post()
	{ 
	    $_POST = json_decode(file_get_contents("php://input"), true);

	   // $details = $this->input->post();
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }

        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }
        
        


        $steps = isset($_POST['steps'])?$_POST['steps']:0;
        $bullets_shot = isset($_POST['bullets_shot'])?$_POST['bullets_shot']:0;

        $user = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_id']),'users');
		
		if (empty($user)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Wrong Token',
				'object'	=> new stdClass()
			));
		}
		
	    
	    if($user->status == 0)
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('you_deactived_by_admin'),
				'object'	=> new stdClass()
			));	
		}
		
		if(!empty($user->deleted_at))
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('you_deleted_by_admin'),
				'object'	=> new stdClass()
			));	
		}
		
        $user_id = $_POST['user_id'];
        $status  = $_POST['status'];
        $time = date('Y-m-d H:i:s', strtotime('+ 10 seconds'));

        // print_r($time);die;

		$checkUser = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user_id),'active_users');

		$checkUserStep = $checkUser->steps + $steps;
		$checkUserBullet = $checkUser->bullets_shot + $bullets_shot;

		$checktotal_time = $checkUser->total_time + 10;

		// if(!empty($checkUser->total_time)){
		// 	$checktotal_time = $checkUser->total_time + $time;
		// }else{
		// 	$checktotal_time =  $time;
		// }
		
		// $checktotal_time_stamp = $checkUser->total_time_stamp + strtotime($time);

		// print_r($checkUserStep);die;

		$insert_active_user 	= array(
        	"user_id" 			=> $user->id,
        	"status" 			=> $status,
        	"steps" 			=> $checkUserStep,
        	"bullets_shot" 			=> $checkUserBullet,
        	"total_time" 			=> $checktotal_time,
        	"total_time_stamp" 			=> 0,
    	    "created_at"    	=>  date('Y-m-d H:i:s'),
        );

		if(!empty($checkUser)){
			$setActiveUser = $this->CommonModel->updateRowByCondition(array("id" => $checkUser->id),'active_users',$insert_active_user);
		}else{
			$setActiveUser  = $this->CommonModel->insertData($insert_active_user,' active_users');
		}


		if(!empty($checkUser)){
			$active_user_id = $checkUser->id;
		}else{
			 $active_user_id = $this->db->insert_id();
		}

		$active_users = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user_id),'active_users');


		$dataText['id'] = $active_users->id;
		$dataText['user_id'] = $active_users->user_id;
		$dataText['steps'] = $active_users->steps;
		$dataText['bullets_shot'] = $active_users->bullets_shot;
		$dataText['total_timeplayed'] = $active_users->total_time;
		// $dataText['total_time'] = date("Y-m-d H:i:s", $active_users->total_time_stamp);
		$dataText['status'] = $active_users->status;

		if($status == 1){
			$msg = 'User active';
		}else{
			$msg = 'User not active';
		}


        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}

	public function checkAndReward_get()
	{
		$reward = $this->CommonModel->selectRowDataByCondition(array("id" => 1),'rewards');

		$current_date = date('Y-m-d H:i:s', strtotime('-'.$reward->time));

		$totalActiveUser = $this->CommonModel->select_single_row("Select count(*) as total from active_users where status = 1");

		if($totalActiveUser->total >= $reward->total_user)
		{
			
			$getActiveUser = $this->CommonModel->selectResultDataByCondition(array("status" => 1,"created_at >=" => $current_date),'active_users');


			if(!empty($getActiveUser))
			{
				// echo "1";die;
				$countActiveUser = $this->CommonModel->select_single_row("Select count(*) as total from active_users where status = 1 AND created_at >='".$current_date."' ");

				if(!empty($countActiveUser))
				{
					if($countActiveUser->total >= $reward->total_user)
					{
						// $msg="Time blockchain active";

						$distribute_reward = $reward->reward/$countActiveUser->total;

						// print_r($distribute_reward);
						foreach ($getActiveUser as $key => $value) 
						{
							// print_r($value->user_id);die;
							$user_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $value->user_id),'users');

							 $wallet = $user_detail->cjm_wallet;

							 $total_amount = $wallet + $distribute_reward;
	    
						    $updateUserWalletData = array( 
				                "cjm_wallet"     =>  $total_amount,
				            );
				        	
				            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $value->user_id),'users',$updateUserWalletData); 


				            $insert_currencies 	= array(
					    	    'type'			=>  'reward',
					            'coversion' 	=>  'time blockchain reward',
					            'user_id' 		=>  $value->user_id,
					            'usd_amt' 		=>  0,
					            'eth_amount' 	=>  0,
					            'csm_amount' 	=>  $distribute_reward,
					        );

							$setReward  = $this->CommonModel->insertData($insert_currencies,' convert_currencies');

				            if($update_user_wallet){
				            	$msg="Time blockchain active.Reward send to your wallet";
				            }else{
				            	$msg="Somethings went Wrong";
				            }
						}
					}else{
						$msg="Time blockchain not active";
					}
				}else{
					$msg="Time blockchain not active";
				}
			}else{
				$msg="Time blockchain not active";
			}
		}else{
			$msg="Time blockchain not active";
		}

		$totalInactiveUser = $this->CommonModel->selectResultDataByCondition(array("created_at <=" => $current_date),'active_users');
		// print_r($totalInactiveUser);die;

		if(!empty($totalInactiveUser)){
			foreach ($totalInactiveUser as $key => $k) 
			{
				$updateUserRewardData = array( 
                	"steps"     	=>  0,
                	"bullets_shot"     	=>  0,
                	"total_time"     	=>  0,
                	"created_at"    =>  date('Y-m-d H:i:s'),
	            );
	        
	            $update_status = $this->CommonModel->updateRowByCondition(array("id" => $k->id),'active_users',$updateUserRewardData); 
			}
		}
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			// 'object'	=> $dataText
		));
	}
	
	
	
	
}