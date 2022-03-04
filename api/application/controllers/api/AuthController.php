<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class AuthController extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		$this->form_validation->set_error_delimiters('', '');
	}
	
	public function pack_get()
	{ 
	    $details = $this->input->post();
        
        $where = array(
			"status"  	 => 1,
		);	
		$getPack = $this->CommonModel->selectResultDataByCondition($where,'pack');
		
        if (!empty($getPack)) 
		{
		    
		    foreach($getPack as $p)
		    {
		        $dataText[] = array(
					'id' 			=>  $this->check_value($p->id),
					'name' 			=>  $this->check_value($p->name),
					'img_name' 			=>  $this->check_value($p->img_name),
					'price' 			=>  $this->check_value($p->price),
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
	
	// public function registrationOld_post()
	// { 
	    	  
	//     $_POST = json_decode(file_get_contents("php://input"), true);
	    
 //        $this->form_validation->set_rules('name', 'Name', 'required');
 //        if ($this->form_validation->run() == FALSE)
 //        {
 //        	return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 			'message' 	=> validation_errors(),
	// 			'object'	=> new stdClass()
	// 		));
            
 //        }
        
        
 //        $this->form_validation->set_rules('email', 'Email-Id', 'required');
 //        if ($this->form_validation->run() == FALSE)
 //        {
 //        	return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 			'message' 	=> validation_errors(),
	// 			'object'	=> new stdClass()
	// 		));
            
 //        }
        
 //        $this->form_validation->set_rules('password', 'Password', 'required');
 //        if ($this->form_validation->run() == FALSE)
 //        {
 //        	return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 			'message' 	=> validation_errors(),
	// 			'object'	=> new stdClass()
	// 		));
            
 //        }

 //        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
 //        if ($this->form_validation->run() == FALSE)
 //        {
 //        	return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 			'message' 	=> validation_errors(),
	// 			'object'	=> new stdClass()
	// 		));
            
 //        }
 //        $where = array(
	// 		"email"  	 => $_POST['email'],
	// 	);	
	// 	$checkUserAvaialable = $this->CommonModel->selectRowDataByCondition($where,'users');
		
	// 	if(!empty($checkUserAvaialable))
	// 	{
	// 		return $this->response(array(
	// 				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 				'message' 	=> 'Email-Id already exit',
	// 				'object'	=> new stdClass()
	// 			));
	// 	}
		
        
 //        $device_id  = ($_POST['device_id'] == "") ? '':$_POST['device_id'] ;
	// 	$device_type = ($_POST['device_type'] == "") ? '':$_POST['device_type'] ;
		
		
	// 	$password = password_hash($_POST['password'],PASSWORD_BCRYPT);
		
	// 	//$today_date   = date('Y-m-d H:i:s');
 //        // $tokenNumber  = $details['first_name'].time();
 //        // $token        = md5(substr(md5($tokenNumber), 0, 10));

 //        $user_data 	= array(
	// 	  //  "wallet" 		=> 0,
 //        	"first_name" 		=> $_POST['name'],
 //        	"email" 		=> $_POST['email'],
 //        // 	"verification_token" 		=> '1',
 //        // 	"referral" 		=> '',
 //        	"password" 			=> $password,
 //        	"device_id" 		=> $device_id,
 //        	"device_type" 		=> $device_type,
        	
 //    	    "created_at"        =>  date('Y-m-d H:i:s a'),
 //            "updated_at"         =>  date('Y-m-d H:i:s a'),
 //        );
        
 //        $insertData  = $this->CommonModel->insertData($user_data,'users');
        
 //        if ($insertData) 
	// 	{
	// 		$last_id 		= $this->db->insert_id();
            
 //            // $usr_id = $last_id;
           
	//         // $userDetail = $this->CommonModel->getUserDetail($usr_id);
	//         $userDetail = $this->CommonModel->selectRowDataByCondition(array('id' => $last_id),'users');

		    
	// 	    $data['id'] 	 	= 	$this->check_value($userDetail->id);
	// 	    $data['wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
	// 	    $data['cjm_wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
	// 	    $data['eth_wallet'] 	 	= 	$this->check_value($userDetail->eth_wallet);
	// 		$data['name'] 	= 	$this->check_value($userDetail->first_name);
	// 		$data['email']      = 	$this->check_value($userDetail->email);
	// 		$data['device_id'] 	    = 	$this->check_value($userDetail->device_id);
	// 		$data['device_type']    = 	$this->check_value($userDetail->device_type);
				

 //           return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_OK,
	// 			'message' 	=> 'Your Registered successfully.',
	// 			'object'	=> $data
	// 		)); 
	// 	}
	// 	else{
	// 		return $this->response(array(
	// 			'status'	=> REST_Controller::HTTP_BAD_REQUEST,
	// 			'message' 	=> 'Somethings went wrong',
	// 			'object'	=> new stdClass()
	// 		));
 //        } 
	// }


	public function registration_post()
	{ 
	    	  
	    $_POST = json_decode(file_get_contents("php://input"), true);
	    
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));
            
        }
        
        
        $this->form_validation->set_rules('email', 'Email-Id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));
            
        }
        
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));
            
        }

        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));
            
        }
        $where = array(
			"email"  	 => $_POST['email'],
		);	
		$checkUserAvaialable = $this->CommonModel->selectRowDataByCondition($where,'users');
		
		if(!empty($checkUserAvaialable))
		{
			return $this->response(array(
					'status'	=> REST_Controller::HTTP_BAD_REQUEST,
					'message' 	=> 'Email-Id already exit',
					'object'	=> new stdClass()
				));
		}
		
        
        $device_id  = ($_POST['device_id'] == "") ? '':$_POST['device_id'] ;
		$device_type = ($_POST['device_type'] == "") ? '':$_POST['device_type'] ;
		
		
		$password = password_hash($_POST['password'],PASSWORD_BCRYPT);
		
// 		$today_date   = date('Y-m-d H:i:s');
        // $tokenNumber  = $details['first_name'].time();
        // $token        = md5(substr(md5($tokenNumber), 0, 10));

        $user_data 	= array(
		  //  "wallet" 		=> 0,
		    "eth_wallet" 		=> 10000,
        	"first_name" 		=> $_POST['name'],
        	"email" 		=> $_POST['email'],
        // 	"verification_token" 		=> '1',
        // 	"referral" 		=> '',
        	"password" 			=> $password,
        	"device_id" 		=> $device_id,
        	"device_type" 		=> $device_type,
        	
    	    "verified_at"        =>  date('Y-m-d H:i:s a'),
    	    "created_at"        =>  date('Y-m-d H:i:s a'),
            "updated_at"         =>  date('Y-m-d H:i:s a'),
        );
        
        $insertData  = $this->CommonModel->insertData($user_data,'users');
        
        if ($insertData) 
		{
			$last_id 		= $this->db->insert_id();
            
            
            $profiles_data 	= array(
    		  //  "wallet" 		=> 0,
            	"user_id" 		=> $last_id,
            	"kyc_verified" 		=> 1,
        	    "created_at"        =>  date('Y-m-d H:i:s a'),
                "updated_at"         =>  date('Y-m-d H:i:s a'),
            );
            
            $insertProfilesData  = $this->CommonModel->insertData($profiles_data,'profiles');
            // $usr_id = $last_id;
           
	        // $userDetail = $this->CommonModel->getUserDetail($usr_id);
	        $userDetail = $this->CommonModel->selectRowDataByCondition(array('id' => $last_id),'users');

		    
		    $data['id'] 	 	= 	$this->check_value($userDetail->id);
		    $data['wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['cjm_wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['eth_wallet'] 	 	= 	$this->check_value($userDetail->eth_wallet);
			$data['name'] 	= 	$this->check_value($userDetail->first_name);
			$data['email']      = 	$this->check_value($userDetail->email);
			$data['device_id'] 	    = 	$this->check_value($userDetail->device_id);
			$data['device_type']    = 	$this->check_value($userDetail->device_type);
				

           return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'Your Registered successfully.',
				'object'	=> $data
			)); 
		}
		else{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'Somethings went wrong',
				'object'	=> new stdClass()
			));
        } 
	}
}
