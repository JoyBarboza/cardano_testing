<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class ProfileController extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		$this->form_validation->set_error_delimiters('', '');
	}
	
	public function checkUserPackage_post()
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
        
        $where = array(
			"status"  	 => 1,
		);	
		$getPack = $this->CommonModel->selectResultDataByCondition($where,'pack');
		
        if (!empty($getPack)) 
		{
		    
		    foreach($getPack as $p)
		    {
		        $check_status = $user = $this->CommonModel->selectRowDataByCondition(array('user_id' => $_POST['user_id'],'pack_id' => $p->id,'type' => 0),'user_buy_pack');
		        
		        if(empty($check_status)){
		           $user_check_pack = 0; 
		        }else{
		            $user_check_pack = 1;
		        }
		        
		        $dataText[] = array(
					'id' 			    =>  $this->check_value($p->id),
					'name' 			    =>  $this->check_value($p->name),
					'img_name' 			=>  $this->check_value($p->img_name),
					'price' 			=>  $this->check_value($p->price),
					'user_check_package' 	=>  $user_check_pack,
				);
		    }
		    
           $msg = 'All Pack List';
		}
		else{
		    $dataText = array();
			$msg = 'No Pack avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
	
	public function buyPack_post()
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
        
        $this->form_validation->set_rules('pack_id', 'Pack id', 'required');
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
		$pack_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['pack_id']),'pack');
		
		
		if (empty($pack_detail)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Pack not found',
				'object'	=> new stdClass()
			));
		}
		
		
		$checkUserBuy = $this->CommonModel->selectRowDataByCondition(array('user_id' => $user->id,'pack_id' => $pack_detail->id,'type' => 0),'user_buy_pack');
		
		if(!empty($checkUserBuy)){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You already buy this pack',
				'object'	=> new stdClass()
			));
		}
        
        
        
	    $pack_price = $pack_detail->price;
	   // $wallet = $user->wallet;
	    $wallet = $user->cjm_wallet;
	    
	   // print_r($wallet);die;
	    
	    if(empty($wallet) || $wallet == 0){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}
	
		if($wallet < $pack_price){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}

	    $remaining_amount = $wallet - $pack_price;
	    
	    $insert_user_buy_pack 	= array(
        	"user_id" 		=> $user->id,
        	"pack_id" 		=> $pack_detail->id,
    	    "created_at"        =>  date('Y-m-d H:i:s a'),
        );
        
        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_user_buy_pack,' user_buy_packs');
        
        if($insertUserBuyPackData)
        {
            
            $user_buy_pack_id = $this->db->insert_id();
             
            $updateUserWalletData = array( 
                "cjm_wallet"     =>  $remaining_amount,
            );
        
            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $user->id),'users',$updateUserWalletData); 
            
            if(!empty($update_user_wallet))
            {
            	 $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				$transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

            	$insert_nft_history 	= array(
		    	    'type' => 'pack',
		            'coversion' => 'buy pack',
		            'user_id' => $user->id,
		            'to_id' => $pack_detail->user_id,
		            'transaction_id' => $pack_detail->transaction_id,
		            'usd_amt' => 0,
		            'eth_amount' => 0,
		            'csm_amount' => $pack_price,
		        );
		        
		        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_nft_history,' convert_currencies');

                
               $getUserPack = $this->CommonModel->getUserPack($user_buy_pack_id);
               
            //   print_r($getUserPack);die;
               
               $data['user_buy_pack_id'] 	 	= 	$this->check_value($getUserPack->user_buy_pack_id);
               $data['wallet'] 	 	= 	$this->check_value($getUserPack->cjm_wallet);
               $data['cjm_wallet'] 	 	= 	$this->check_value($getUserPack->cjm_wallet);
               $data['eth_wallet'] 	 	= 	$this->check_value($getUserPack->eth_wallet);
               $data['user_id'] 	 	= 	$this->check_value($getUserPack->user_id);
               $data['pack_id'] 	 	= 	$this->check_value($getUserPack->pack_id);
               $data['name'] 	 	= 	$this->check_value($getUserPack->name);
               $data['price'] 	 	= 	$this->check_value($getUserPack->price);
                
                return $this->response(array(
    				'status'	=> REST_Controller::HTTP_OK,
    				'message' 	=> 'You buy pack successfully.',
    				// 'object'	=> new stdClass()
    					'object'	=> $data
    			)); 
            }
        }else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        } 
	}
	
	public function getprofile_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		$userDetail = $this->CommonModel->selectRowDataByCondition(array("id"  	=> $user->id),'users');

		$activeuserDetail = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user->id),'active_users');
		
		if ($userDetail) 
		{
		    $data['id'] 	 		= 	$this->check_value($userDetail->id);
		    $data['wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['cjm_wallet'] 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['eth_wallet'] 	= 	$this->check_value($userDetail->eth_wallet);
			$data['name'] 			= 	$this->check_value($userDetail->first_name);
			$data['name'] 			= 	$this->check_value($userDetail->first_name);
			$data['name'] 			= 	$this->check_value($userDetail->first_name);
			$data['email']      	= 	$this->check_value($userDetail->email);
			$data['phone_no']      	= 	$this->check_value($userDetail->phone_no);
			$data['username']      	= 	$this->check_value($userDetail->username);
			$data['device_id'] 	    = 	$this->check_value($userDetail->device_id);
			$data['device_type']    = 	$this->check_value($userDetail->device_type);
			$data['level']    		= 	!empty($activeuserDetail)?$activeuserDetail->level:'';
			$data['xp_points']    		= 	!empty($activeuserDetail)?$activeuserDetail->xp_points:'';
			$data['total_matches']    		= 	!empty($activeuserDetail)?$activeuserDetail->total_matches:'';
			$data['total_time_played']    		= 	!empty($activeuserDetail)?$activeuserDetail->total_time_played:'';
			$data['kills']    		= 	!empty($activeuserDetail)?$activeuserDetail->kills:'';
			$data['deaths']    		= 	!empty($activeuserDetail)?$activeuserDetail->deaths:'';
			$data['wins']    		= 	!empty($activeuserDetail)?$activeuserDetail->wins:'';
			$data['points_captured']    		= 	!empty($activeuserDetail)?$activeuserDetail->points_captured:'';
			
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'User Profile',
				'object'	=> $data
			)); 
		}
		else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('something_went_wrong'),
				'object'	=> new stdClass()
			));
        } 
	}

	public function update_status_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;

        $activeuserDetail = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user->id),'active_users');

        $level    			= 	empty($_POST['level'])?$activeuserDetail->level:$_POST['level'];
		$xp_points    		= 	empty($_POST['xp_points'])?$activeuserDetail->xp_points:$_POST['xp_points'];
		$total_matches    	= 	empty($_POST['total_matches'])?$activeuserDetail->total_matches:$_POST['total_matches'];
		$total_time_played  = 	empty($_POST['total_time_played'])?$activeuserDetail->total_time_played:$_POST['total_time_played'];
		$kills    			= 	empty($_POST['kills'])?$activeuserDetail->kills:$_POST['kills'];
		$deaths    			= 	empty($_POST['deaths'])?$activeuserDetail->deaths:$_POST['deaths'];
		$wins    			= 	empty($_POST['wins'])?$activeuserDetail->wins:$_POST['wins'];
		$points_captured    = 	empty($_POST['points_captured'])?$activeuserDetail->points_captured:$_POST['points_captured'];


        $user_data 	= array(
            'user_id' => $user->id,
            'level' => $level,
            'xp_points' => $xp_points,
            'total_matches' => $total_matches,
            'total_time_played' => $total_time_played,
            'kills' => $kills,
            'deaths' => $deaths,
            'wins' => $wins,
            'points_captured' => $points_captured,
        );
		        

        if(empty($activeuserDetail)){
		    $activity_user_data  = $this->CommonModel->insertData($user_data,' active_users');
        }else{
        	$activity_user_data = $this->CommonModel->updateRowByCondition(array('id' => $activeuserDetail->id),'active_users',$user_data);
        }


        if($activity_user_data){
        	$userDetail = $this->CommonModel->selectRowDataByCondition(array("id"  	=> $user->id),'users');

			$activeuserDetail = $this->CommonModel->selectRowDataByCondition(array("user_id" => $user->id),'active_users');
			
			if ($userDetail) 
			{
			    $data['id'] 	 		= 	$this->check_value($userDetail->id);
			    $data['wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
			    $data['cjm_wallet'] 	= 	$this->check_value($userDetail->cjm_wallet);
			    $data['eth_wallet'] 	= 	$this->check_value($userDetail->eth_wallet);
				$data['name'] 			= 	$this->check_value($userDetail->first_name);
				$data['name'] 			= 	$this->check_value($userDetail->first_name);
				$data['name'] 			= 	$this->check_value($userDetail->first_name);
				$data['email']      	= 	$this->check_value($userDetail->email);
				$data['phone_no']      	= 	$this->check_value($userDetail->phone_no);
				$data['username']      	= 	$this->check_value($userDetail->username);
				$data['device_id'] 	    = 	$this->check_value($userDetail->device_id);
				$data['device_type']    = 	$this->check_value($userDetail->device_type);
				$data['level']    		= 	!empty($activeuserDetail)?$activeuserDetail->level:'';
				$data['xp_points']    		= 	!empty($activeuserDetail)?$activeuserDetail->xp_points:'';
				$data['total_matches']    		= 	!empty($activeuserDetail)?$activeuserDetail->total_matches:'';
				$data['total_time_played']    		= 	!empty($activeuserDetail)?$activeuserDetail->total_time_played:'';
				$data['kills']    		= 	!empty($activeuserDetail)?$activeuserDetail->kills:'';
				$data['deaths']    		= 	!empty($activeuserDetail)?$activeuserDetail->deaths:'';
				$data['wins']    		= 	!empty($activeuserDetail)?$activeuserDetail->wins:'';
				$data['points_captured']    		= 	!empty($activeuserDetail)?$activeuserDetail->points_captured:'';
				
	            return $this->response(array(
					'status'	=> REST_Controller::HTTP_OK,
					'message' 	=> 'User status update successfully',
					'object'	=> $data
				)); 
			}
			else{
				return $this->response(array(
					'status'	=> REST_Controller::HTTP_BAD_REQUEST,
					'message' 	=> $this->lang->line('something_went_wrong'),
					'object'	=> new stdClass()
				));
	        } 

        }else{
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('something_went_wrong'),
				'object'	=> new stdClass()
			));
        } 
	}
	
	
	public function userBuyPackList_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;
		
		$getAllUserBuyPack = $this->CommonModel->getUserPackList($user_id);
// 		print_r($getAllUserBuyPack);die;
        if (!empty($getAllUserBuyPack)) 
		{
		    
		    foreach($getAllUserBuyPack as $v)
		    {
		      //  print_r($v['user_buy_pack']);die;
		        $dataText[] = array(
					'user_buy_pack_id' 	=>  $this->check_value($v['user_buy_pack_id']),
					'user_id' 			=>  $this->check_value($v['user_id']),
					'pack_id' 			=>  $this->check_value($v['pack_id']),
					'pack_name' 		=>  $this->check_value($v['name']),
					'pack_price' 		=>  $this->check_value($v['price']),
				);
		    }
		    
           $msg = 'All Pack List';
		}
		else{
		    $dataText = array();
			$msg = 'No Pack avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
    
	public function logout_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		$userDetail = $this->CommonModel->selectRowDataByCondition(array("id"  	=> $user->id),'users');
		
		$updateData = array(
	        	"device_type"  => '',
	        	"device_id" 	=> ''
	        );

        $update = $this->CommonModel->updateRowByCondition(array('id' => $user->id),'users',$updateData);  
        if ($update) {
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> $this->lang->line('logout_successfully'),
				'object'	=> new stdClass()
			));
        }else{
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('something_went_wrong'),
				'object'	=> new stdClass()
			));
        }
	}
	
	public function deletePackageUser_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    $this->form_validation->set_rules('type', 'Type', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }
        
        $this->form_validation->set_rules('user_package_id', 'User Id or User Buy Package Id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }
        
	    $type = $_POST['type'];
	    $user_package_id = $_POST['user_package_id'];
	    
	    
	    if($type == 1)
	    {
	       $user_package_id = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_package_id']),'user_buy_pack');
	        
	        if (empty($user_package_id)) {
    			return $this->response(array(
    				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
    				'message' 	=> 'No user buy package found',
    				'object'	=> new stdClass()
    			));
    		}
    		
    		$delete_data =  $this->CommonModel->delete(array('id' => $user_package_id->id),'user_buy_pack');
	    }else if($type == 2){
	         $get_user = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_package_id']),'users');
	         
	        
	        if (empty($get_user)) {
    			return $this->response(array(
    				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
    				'message' 	=> 'No user found',
    				'object'	=> new stdClass()
    			));
    		}
    		
    		$get_id = $get_user->id;
    		
    		$delete_data =  $this->CommonModel->delete(array('id' => $get_user->id),'users');
	    }else if($type == 3){
	         $user_package_id = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_package_id']),'user_buy_packs');
	        
	        if (empty($user_package_id)) {
    			return $this->response(array(
    				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
    				'message' 	=> 'No NFT found',
    				'object'	=> new stdClass()
    			));
    		}
    		
    		$delete_data =  $this->CommonModel->delete(array('id' => $user_package_id->id),'user_buy_packs');
	    }else{
	         $user_package_id = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['user_package_id']),'user_buy_packs');
	        
	        if (empty($user_package_id)) {
    			return $this->response(array(
    				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
    				'message' 	=> 'No FT found',
    				'object'	=> new stdClass()
    			));
    		}
    		
    		$delete_data =  $this->CommonModel->delete(array('id' => $user_package_id->id),'user_buy_pack');
	    }
	    
	    
	    if($delete_data)
        {
            if($type == 1)
	        {
	            $msg = 'Buy Package delete successfully';
	        }elseif($type == 2){
	             $msg = 'User delete successfully';
	        }elseif($type == 3){
	             $msg = 'NFT delete successfully';
	        }else{
	             $msg = 'FT delete successfully';
	        }
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> $msg,
				'object'	=> new stdClass()
			));
            
    	}else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        } 
	}


	public function nftList_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;
		
		$getAllNft = $this->CommonModel->selectResultDataByConditionAndFieldName(array('type' => 1),'nft_items','nft_items.id');
		// print_r($getAllNft);die;

        if (!empty($getAllNft)) 
		{
		    
		    foreach($getAllNft as $v)
		    {
		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'nft_id' 	=>  $this->check_value($v['id']),
					'type' 	=>  $this->check_value($v['type']),
					'name' 		=>  $this->check_value($v['name']),
					'descripition' 			=>  $this->check_value($v['descripition']),
					'price' 			=>  $this->check_value($v['price']),
					'unique_asset_identifier' 			=>  $this->check_value($v['unique_asset_identifier']),
					'img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
				);

		    }
		    
           $msg = 'All Nft List';
		}
		else{
		    $dataText = array();
			$msg = 'No Nft avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
	
	public function buyNft_post()
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
        
        $this->form_validation->set_rules('nft_id', 'NFT id', 'required');
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
		$nft_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['nft_id']),'nft_items');
		
		// print_r($nft_detail);die;
		
		if (empty($nft_detail)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'NFT not found',
				'object'	=> new stdClass()
			));
		}
		
		
		$checkUserNft = $this->CommonModel->selectRowDataByCondition(array('user_id' => $user->id,'pack_id' => $_POST['nft_id'],'type' => 1),'user_buy_packs');
		
		if(!empty($checkUserNft)){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You already mint this nft',
				'object'	=> new stdClass()
			));
		}
        

	    $nft_price = $nft_detail->price;
	    // print_r($nft_price);die;
	   // $wallet = $user->wallet;
	    $wallet = $user->cjm_wallet;
	    
	   // print_r($wallet);die;
	    
	    if(empty($wallet) || $wallet == 0){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}
	
		if($wallet < $nft_price){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}

	    $remaining_amount = $wallet - $nft_price;
	    
	    $insert_user_buy_pack 	= array(
        	"user_id" 		=> $user->id,
        	"pack_id" 		=> $_POST['nft_id'],
        	"type" 			=> 1,
    	    "created_at"   =>  date('Y-m-d H:i:s a'),
        );
        
        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_user_buy_pack,' user_buy_packs');
        
        if($insertUserBuyPackData)
        {
            
            $user_buy_nft_id = $this->db->insert_id();
             
            $updateUserWalletData = array( 
                "cjm_wallet"     =>  $remaining_amount,
            );
        
            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $user->id),'users',$updateUserWalletData); 
            
            if(!empty($update_user_wallet)){
                 $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				$transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

                $insert_nft_history 	= array(
		    	    'type' => 'nft',
		            'coversion' => 'mint nft',
		            'user_id' => $user->id,
		            'to_id' => $nft_detail->user_id,
		            'transaction_id' => $transaction_id,
		            'usd_amt' => 0,
		            'eth_amount' => 0,
		            'csm_amount' => $nft_price,
		        );
		        
		        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_nft_history,' convert_currencies');


               $getNftPack = $this->CommonModel->getNftDetail($user_buy_nft_id);
               
              // print_r($getNftPack);die;

               $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$getNftPack->nft_img);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }
               
               $data['user_buy_nft_id'] 	 	= 	$this->check_value($getNftPack->user_buy_nft_id);
               $data['wallet'] 	 	= 	$this->check_value($getNftPack->cjm_wallet);
               $data['cjm_wallet'] 	 	= 	$this->check_value($getNftPack->cjm_wallet);
               $data['eth_wallet'] 	 	= 	$this->check_value($getNftPack->eth_wallet);
               $data['user_id'] 	 	= 	$this->check_value($getNftPack->user_id);
               $data['nft_id'] 	 	= 	$this->check_value($getNftPack->pack_id);
               $data['nft_name'] 	 	= 	$this->check_value($getNftPack->name);
               $data['nft_price'] 	 	= 	$this->check_value($getNftPack->price);
               $data['nft_price'] 	 	= 	$this->check_value($getNftPack->descripition);
               $data['unique_asset_identifier'] 	 	= 	$this->check_value($getNftPack->unique_asset_identifier);
               $data['nft_img'] 	 	= 	'https://anandisha.com/alpha_game_code/public/nft_item/'.$img;
                
                return $this->response(array(
    				'status'	=> REST_Controller::HTTP_OK,
    				'message' 	=> 'You mint nft successfully.',
    				// 'object'	=> new stdClass()
    					'object'	=> $data
    			)); 
            }
        }else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        } 
	}
	

	public function userNftList_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;
		
		$getAllUserBuyNft = $this->CommonModel->getNftList($user_id);
		
		// print_r($getAllUserBuyNft);die;
        if (!empty($getAllUserBuyNft)) 
		{
		    
		    foreach($getAllUserBuyNft as $v)
		    {

		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'user_buy_nft_id' 	=>  $this->check_value($v['user_buy_nft_id']),
					'user_id' 			=>  $this->check_value($v['user_id']),
					'nft_id' 			=>  $this->check_value($v['pack_id']),
					'nft_name' 		=>  $this->check_value($v['name']),
					'nft_price' 		=>  $this->check_value($v['price']),
					'nft_descripition' 		=>  $this->check_value($v['descripition']),
					'nft_img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
					'unique_asset_identifier' 		=>  $this->check_value($v['unique_asset_identifier'])
				);
		    }
		    
           $msg = 'All Nft List';
		}
		else{
		    $dataText = array();
			$msg = 'No Nft avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
	
	public function ftList_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;
		
		$getAllNft = $this->CommonModel->selectResultDataByConditionAndFieldName(array('type' => 2),'nft_items','nft_items.id');
		// print_r($getAllNft);die;

        if (!empty($getAllNft)) 
		{
		    
		    foreach($getAllNft as $v)
		    {
		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'nft_id' 	=>  $this->check_value($v['id']),
					'type' 	=>  $this->check_value($v['type']),
					'name' 		=>  $this->check_value($v['name']),
					'descripition' 			=>  $this->check_value($v['descripition']),
					'price' 			=>  $this->check_value($v['price']),
					'price' 			=>  $this->check_value($v['price']),
					'img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
					'unique_asset_identifier' 		=>  $this->check_value($v['unique_asset_identifier'])
				);

		    }
		    
           $msg = 'All Nft List';
		}
		else{
		    $dataText = array();
			$msg = 'No Nft avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
	public function buyft_post()
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
        
        $this->form_validation->set_rules('ft_id', 'FT id', 'required');
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
		$nft_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['ft_id'],'type' => 2),'nft_items');
		
		// print_r($nft_detail);die;
		
		if (empty($nft_detail)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'FT not found',
				'object'	=> new stdClass()
			));
		}
		
		
		$checkUserNft = $this->CommonModel->selectRowDataByCondition(array('user_id' => $user->id,'pack_id' => $_POST['ft_id'],'type' => 2),'user_buy_packs');
		
		if(!empty($checkUserNft)){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You already mint this FT',
				'object'	=> new stdClass()
			));
		}
        

	    $nft_price = $nft_detail->price;
	    // print_r($nft_price);die;
	   // $wallet = $user->wallet;
	    $wallet = $user->cjm_wallet;
	    
	   // print_r($wallet);die;
	    
	    if(empty($wallet) || $wallet == 0){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}
	
		if($wallet < $nft_price){
		    return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'You not have sufficient amount',
				'object'	=> new stdClass()
			));
		}

	    $remaining_amount = $wallet - $nft_price;
	    
	    $insert_user_buy_pack 	= array(
        	"user_id" 		=> $user->id,
        	"pack_id" 		=> $_POST['ft_id'],
        	"type" 			=> 2,
    	    "created_at"   =>  date('Y-m-d H:i:s a'),
        );
        
        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_user_buy_pack,' user_buy_packs');
        
        if($insertUserBuyPackData)
        {
            
            $user_buy_ft_id = $this->db->insert_id();
             
            $updateUserWalletData = array( 
                "cjm_wallet"     =>  $remaining_amount,
            );
        
            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $user->id),'users',$updateUserWalletData); 
            
            if(!empty($update_user_wallet)){
                
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				$transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

                $insert_nft_history 	= array(
		    	    'type' => 'ft',
		            'coversion' => 'mint ft',
		            'user_id' => $user->id,
		            'to_id' => $nft_detail->user_id,
		            'usd_amt' => 0,
		            'eth_amount' => 0,
		            'csm_amount' => $nft_price,
		            'transaction_id' => $transaction_id,
		        );
		        
		        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_nft_history,' convert_currencies');


               $getFtPack = $this->CommonModel->getftDetail($user_buy_ft_id);
               
            //   print_r($getFtPack);die;

               $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$getFtPack->nft_img);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }
               
               $data['user_buy_ft_id'] 	 	= 	$this->check_value($getFtPack->user_buy_nft_id);
               $data['wallet'] 	 	= 	$this->check_value($getFtPack->cjm_wallet);
               $data['cjm_wallet'] 	 	= 	$this->check_value($getFtPack->cjm_wallet);
               $data['eth_wallet'] 	 	= 	$this->check_value($getFtPack->eth_wallet);
               $data['user_id'] 	 	= 	$this->check_value($getFtPack->user_id);
               $data['ft_id'] 	 	= 	$this->check_value($getFtPack->pack_id);
               $data['ft_name'] 	 	= 	$this->check_value($getFtPack->name);
               $data['ft_price'] 	 	= 	$this->check_value($getFtPack->price);
               $data['ft_price'] 	 	= 	$this->check_value($getFtPack->descripition);
               $data['unique_asset_identifier'] 	 	= 	$this->check_value($getFtPack->unique_asset_identifier);
               $data['ft_img'] 	 	= 	'https://anandisha.com/alpha_game_code/public/nft_item/'.$img;

                
                return $this->response(array(
    				'status'	=> REST_Controller::HTTP_OK,
    				'message' 	=> 'You mint ft successfully.',
    				// 'object'	=> new stdClass()
    					'object'	=> $data
    			)); 
            }
        }else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        } 
	}
	
	public function userFtList_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
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
		
		$user_id = $user->id;
		
		$getAllUserBuyFt = $this->CommonModel->getFtList($user_id);
		
		// print_r($getAllUserBuyNft);die;
        if (!empty($getAllUserBuyFt)) 
		{
		    
		    foreach($getAllUserBuyFt as $v)
		    {

		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'user_buy_ft_id' 	=>  $this->check_value($v['user_buy_nft_id']),
					'user_id' 			=>  $this->check_value($v['user_id']),
					'ft_id' 			=>  $this->check_value($v['pack_id']),
					'ft_name' 		=>  $this->check_value($v['name']),
					'ft_price' 		=>  $this->check_value($v['price']),
					'ft_descripition' 		=>  $this->check_value($v['descripition']),
					'unique_asset_identifier' 		=>  $this->check_value($v['unique_asset_identifier']),
					'ft_img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
				);
		    }
		    
           $msg = 'All FT List';
		}
		else{
		    $dataText = array();
			$msg = 'No FT avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
	}
	
	
	public function addTrading_post()
	{
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
	    $this->form_validation->set_rules('user_id', 'User id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }
        
        $this->form_validation->set_rules('nft_id', 'NFT id', 'required');
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
		
		// $checkBuyNft = $this->CommonModel->selectRowDataByCondition(array('pack_id' => $_POST['nft_id'],'user_id' => $_POST['user_id']),'user_buy_packs');
		
  //       // print_r($checkBuyNft);die;
  //       if(empty($checkBuyNft))
		// {
		// 	return $this->response(array(
		// 		'status'	=> REST_Controller::HTTP_BAD_REQUEST,
		// 		'message' 	=> 'You  cannot buy this nft',
		// 		'object'	=> new stdClass()
		// 	));	
		// }
        
         $insert_trading 	= array(
        	"user_id" 		=> $user->id,
        	"pack_id" 		=> $_POST['nft_id'],
        	"price" 		=> $_POST['price'],
        	"expire_date" 	=> $_POST['expire_date'],
        	"buy_id" 		=> 0,
    	    "created_at"   =>  date('Y-m-d H:i:s a'),
        );
        
        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_trading,' user_tradings');
        
        if($insertUserBuyPackData){
            $trade_id = $this->db->insert_id();
            
            $getTradeDetail = $this->CommonModel->getTradeDetail($trade_id);
            
            $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$getTradeDetail->nft_img);
            if(!empty($img[1])){
                $img = $img[1];
            }else{
                $img = $img[0];
            }
            
            $data['user_buy_ft_id'] 	 	= 	$this->check_value($getTradeDetail->trading_id);
           $data['user_id'] 	 	= 	$this->check_value($getTradeDetail->user_id);
           $data['nft_id'] 	 	= 	$this->check_value($getTradeDetail->pack_id);
           $data['trading_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           $data['expire_date'] 	 	= 	$this->check_value($getTradeDetail->expire_date);
           $data['buy_id'] 	 	= 	$this->check_value($getTradeDetail->buy_id);
           $data['nft_name'] 	 	= 	$this->check_value($getTradeDetail->name);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->descripition);
           $data['unique_asset_identifier'] 	 	= 	$this->check_value($getTradeDetail->unique_asset_identifier);
           $data['nft_img'] 	 	= 	'https://anandisha.com/alpha_game_code/public/nft_item/'.$img;
                
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'You add trade successfully',
				// 'object'	=> new stdClass()
					'object'	=> $data
			)); 
        }

	}
	
	
	public function tradingList_post()
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
		
		$getTradeList = $this->CommonModel->getTradeList($user_id);
		
		if (!empty($getTradeList)) 
		{
		    foreach($getTradeList as $v)
		    {
		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'trading_id' 	=>  $this->check_value($v['trading_id']),
					'user_id' 	=>  $this->check_value($v['user_id']),
					'pack_id' 		=>  $this->check_value($v['pack_id']),
					'price' 			=>  $this->check_value($v['price']),
					'expire_date' 			=>  $this->check_value($v['expire_date']),
					'buy_id' 			=>  $this->check_value($v['buy_id']),
					'buy_name' 			=>  $this->check_value($v['buy_name']),
					'unique_asset_identifier' 			=>  $this->check_value($v['unique_asset_identifier']),
					'img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
				);
		    }
		    
           $msg = 'All trade List';
		}
		else{
		    $dataText = array();
			$msg = 'No trade avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		));
		
	}
	
	
	public function buyTrading_post()
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
        
        $this->form_validation->set_rules('trading_id', 'Trading id', 'required');
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
		
		$checkTrading = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['trading_id']),'user_tradings');
		

		$today_date = date('Y-m-d');
		// print_r($checkTrading);
		// echo "<br>";
		
		if (empty($checkTrading)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Trade not found',
				'object'	=> new stdClass()
			));
		}

		if(strtotime($today_date) > strtotime($checkTrading->expire_date)){
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Date Expire',
				'object'	=> new stdClass()
			));
		}

		if(!empty($checkTrading->buy_id)){
		     $insert_trading 	= array(
	    	    'user_id'			=>  $checkTrading->user_id,
	    	    'pack_id'			=>  $checkTrading->pack_id,
	    	    'price'				=>  $checkTrading->price,
	    	    'expire_date'		=>  $checkTrading->expire_date,
	    	    'buy_id'			=>  $user->id,
	    	    'status'			=>  0, 
	    	    "created_at"   		=>  date('Y-m-d H:i:s a'),
	        );

			$update_trade  = $this->CommonModel->insertData($insert_trading,'user_tradings');
		}else{        
        
	        $updateTradeData = array( 
	               "buy_id" 		=> $user->id
	        );
	        
	        $update_trade = $this->CommonModel->updateRowByCondition(array("id" => $_POST['trading_id']),'user_tradings',$updateTradeData);  
	    }

	    if($update_trade)
        {
            $trade_id = $_POST['trading_id'];
            
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
			$transaction_id = substr(str_shuffle($permitted_chars), 0, 50);
            
            $insert_nft_history 	= array(
		    	    'type' => 'buy_trade',
		            'coversion' => 'buy trade',
		            'user_id' => $user->id,
		            'to_id' => 0,
		            'usd_amt' => 0,
		            'eth_amount' => 0,
		            'csm_amount' => $checkTrading->price,
		            'transaction_id' => $transaction_id,
		        );
		        
		      $insertUserBuyPackData  = $this->CommonModel->insertData($insert_nft_history,' convert_currencies');
		        
            $getTradeDetail = $this->CommonModel->getTradeDetail($trade_id);
            
            $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$getTradeDetail->nft_img);
            if(!empty($img[1])){
                $img = $img[1];
            }else{
                $img = $img[0];
            }
            
            $data['user_buy_ft_id'] 	 	= 	$this->check_value($getTradeDetail->trading_id);
           $data['user_id'] 	 	= 	$this->check_value($getTradeDetail->user_id);
           $data['nft_id'] 	 	= 	$this->check_value($getTradeDetail->pack_id);
           $data['trading_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           $data['expire_date'] 	 	= 	$this->check_value($getTradeDetail->expire_date);
           $data['buy_id'] 	 	= 	$this->check_value($getTradeDetail->buy_id);
           $data['nft_name'] 	 	= 	$this->check_value($getTradeDetail->name);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->descripition);
           $data['unique_asset_identifier'] 	 	= 	$this->check_value($getTradeDetail->unique_asset_identifier);
           $data['nft_img'] 	 	= 	'https://anandisha.com/alpha_game_code/public/nft_item/'.$img;
                
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'You trade successfully',
				// 'object'	=> new stdClass()
					'object'	=> $data
			)); 
        }else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        }
	}

	public function sendTradeAmount_get()
	{
		$today_date = date('Y-m-d');

		$current_date = date('Y-m-d', strtotime('- 10 seconds'));
		// print_r($current_date);die;
		$getUserTrading = $this->CommonModel->selectResultDataByCondition(array("expire_date >=" => $current_date,"status" =>0),'user_tradings');


		$maxUser = $this->CommonModel->select_single_row("Select MIN(Price) AS LargestPrice from user_tradings where status = 0 AND expire_date >='".$current_date."' order by price DESC");

		$LargestPrice = $maxUser->LargestPrice;

		// print_r($maxUser->LargestPrice);die;

		if(!empty($getUserTrading)){
			foreach ($getUserTrading as $key => $value) 
			{
				$price = $value->price;
				$buy_id = $value->buy_id;	

				if($LargestPrice <= $price)
				{
					$user_detail = $this->CommonModel->selectRowDataByCondition(array('id' => $buy_id),'users');
					$wallet = $user_detail->cjm_wallet;
					$total_amount = $wallet + $price;

					$updateUserRewardData = array( 
	                	"status"     	=>  1,
	                	"created_at"    =>  date('Y-m-d H:i:s'),
		            );
		        
		            $update_status = $this->CommonModel->updateRowByCondition(array("id" => $value->id),'user_tradings',$updateUserRewardData); 


				    $updateUserWalletData = array( 
		                "cjm_wallet"     =>  $total_amount,
		            );
		        	
		            $update_user_wallet = $this->CommonModel->updateRowByCondition(array("id" => $buy_id),'users',$updateUserWalletData); 


					$insert_currencies 	= array(
			    	    'type'			=>  'trading',
			            'coversion' 	=>  'user trading',
			            'user_id' 		=>  $buy_id,
			            'to_id' 		=>  0,
			            'usd_amt' 		=>  0,
			            'eth_amount' 	=>  0,
			            'csm_amount' 	=>  $price,
			        );

					$setReward  = $this->CommonModel->insertData($insert_currencies,' convert_currencies');
				}else{
					$updateUserRewardData = array( 
	                	"status"     	=>  0,
	                	"created_at"    =>  date('Y-m-d H:i:s'),
		            );
		        
		            $update_status = $this->CommonModel->updateRowByCondition(array("id" => $value->id),'user_tradings',$updateUserRewardData); 
				}
			}

			$msg = 'Trade amount send successfully';
		}else{
			$msg = 'Somethings went wrong';
		}
		

		if(!empty($setReward)){
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> $msg,
				// 'object'	=> $dataText
			));
		}

	}


	public function userInventory_post()
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
		
		$user_id = $user->id;
		
		$getNftFt = $this->CommonModel->getNftFt($user_id);
		// print_r($getNftFt);dieuser inventory;

        if (!empty($getNftFt)) 
		{
		    
		    foreach($getNftFt as $v)
		    {
		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'nft_id' 	=>  $this->check_value($v['user_buy_nft_id']),
					'type' 	=>  $this->check_value($v['type']),
					'name' 		=>  $this->check_value($v['name']),
					'descripition' 			=>  $this->check_value($v['descripition']),
					'price' 			=>  $this->check_value($v['price']),
					'unique_asset_identifier' 			=>  $this->check_value($v['unique_asset_identifier']),
					'img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
				);

		    }
		    
           $msg = 'All user inventory List';
		}
		else{
		    $dataText = array();
			$msg = 'No user inventory avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		)); 
	}


	public function marketplace_post()
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
		
		$user_id = $user->id;
		
		$getAllNftFt = $this->CommonModel->selectResultDataByConditionAndFieldName(array('type !=' => 0),'nft_items','nft_items.id');
		// print_r($getAllNft);die;

        if (!empty($getAllNftFt)) 
		{
		    
		    foreach($getAllNftFt as $v)
		    {
		    	$img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);
                if(!empty($img[1])){
                    $img = $img[1];
                }else{
                    $img = $img[0];
                }

		        $dataText[] = array(
					'nft_id' 	=>  $this->check_value($v['id']),
					'type' 	=>  $this->check_value($v['type']),
					'user_id' 	=>  $this->check_value($v['user_id']),
					'name' 		=>  $this->check_value($v['name']),
					'descripition' 			=>  $this->check_value($v['descripition']),
					'price' 			=>  $this->check_value($v['price']),
					'price' 			=>  $this->check_value($v['price']),
					'img' 		=>  'https://anandisha.com/alpha_game_code/public/nft_item/'.$img,
					'unique_asset_identifier' 		=>  $this->check_value($v['unique_asset_identifier'])
				);

		    }
		    
           $msg = 'All marketplace data';
		}
		else{
		    $dataText = array();
			$msg = 'No marketplace avaiable';
        } 
        
		return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> $msg,
			'object'	=> $dataText
		)); 
	}

	public function bid_item_post(){

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
		
		$user_id = $user->id;

		$this->form_validation->set_rules('nft_ft_id', 'NFT/FT Id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }

        $this->form_validation->set_rules('bid_amount', 'Bid Amount', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));            
        }

        $user_package_id = $this->CommonModel->selectRowDataByCondition(array('id' => $_POST['nft_ft_id']),'nft_items');

        if (empty($user_package_id)) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'No NFT/FT found',
				'object'	=> new stdClass()
			));
		}

        if($_POST['bid_amount'] <= $user_package_id->price){
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_UNAUTHORIZED,
				'message' 	=> 'Amount less than highest bid',
				'object'	=> new stdClass()
			));
        }
        
        $insert_trading 	= array(
        	"user_id" 		=> $user->id,
        	"pack_id" 		=> $_POST['nft_ft_id'],
        	"price" 		=> $_POST['bid_amount'],
        	"buy_id" 		=> 0,
    	    "created_at"   =>  date('Y-m-d H:i:s a'),
        );
        
        $insertUserBuyPackData  = $this->CommonModel->insertData($insert_trading,' user_tradings');
        
        if($insertUserBuyPackData)
        {
            $trade_id = $this->db->insert_id();
            
            $getTradeDetail = $this->CommonModel->getTradeDetail($trade_id);
            
            $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$getTradeDetail->nft_img);
            if(!empty($img[1])){
                $img = $img[1];
            }else{
                $img = $img[0];
            }
            
            $data['user_buy_ft_id'] 	 	= 	$this->check_value($getTradeDetail->trading_id);
           $data['user_id'] 	 	= 	$this->check_value($getTradeDetail->user_id);
           $data['nft_id'] 	 	= 	$this->check_value($getTradeDetail->pack_id);
           $data['trading_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           // $data['expire_date'] 	 	= 	$this->check_value($getTradeDetail->expire_date);
           $data['buy_id'] 	 	= 	$this->check_value($getTradeDetail->buy_id);
           $data['nft_name'] 	 	= 	$this->check_value($getTradeDetail->name);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->price);
           $data['nft_price'] 	 	= 	$this->check_value($getTradeDetail->descripition);
           $data['unique_asset_identifier'] 	 	= 	$this->check_value($getTradeDetail->unique_asset_identifier);
           $data['nft_img'] 	 	= 	'https://anandisha.com/alpha_game_code/public/nft_item/'.$img;
                
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'You add trade successfully',
				// 'object'	=> new stdClass()
					'object'	=> $data
			)); 
        }



	}
}