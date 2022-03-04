<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class LoginCotroller extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		$this->form_validation->set_error_delimiters('', '');
	}
	
	
	public function login_post()
	{
        $_POST = json_decode(file_get_contents("php://input"), true);
        
        $this->form_validation->set_rules('email', 'Email Id', 'required');
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
        
        $email = $_POST['email'];
	    $password = $_POST['password'];
	   // $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
	    
	   // print_r($password);die;
	    
		$where = array(
			"email"  	 => $email,
// 			"password"  	 => md5($password),
		);	
		$userDetail = $this->CommonModel->selectRowDataByCondition($where,'users');
		
		
	   // print_r($userDetail);die;

		
		if(empty($userDetail))
		{ 
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('incorrect_email_password'),
				'object'	=> new stdClass()
			));			
			
		}
		
		if(!password_verify($_POST['password'],$userDetail->password)){
            // 	echo 'not verify';
        
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('incorrect_email_password'),
				'object'	=> new stdClass()
			));	
        }
		
		if($userDetail->status == 0)
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> $this->lang->line('you_deactived_by_admin'),
				'object'	=> new stdClass()
			));	
		}
		
		if(!empty($userDetail->deleted_at))
		{
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'You are deleted by admin',
				'object'	=> new stdClass()
			));	
		}
        
        
//         $device_id  = ($this->input->post('device_id') == "") ? $userDetail->device_id:$this->input->post('device_id');
// 		$device_type = ($this->input->post('device_type') == "") ? $userDetail->devicetype:$this->input->post('device_type');
		
		$device_id  = ($_POST['device_id'] == "") ? '':$_POST['device_id'] ;
		$device_type = ($_POST['device_type'] == "") ? '':$_POST['device_type'] ;
		
		
		$condition1 = array(
			"id"  	=> $userDetail->id,
// 			"id"  	=> 7
		);

		$updateData = array(
	            "device_type"	=> $device_type,
				"device_id" 	=> $device_id,
				"updated_at" 	=> date('Y-m-d H:i:s')
			);

		$res  = $this->CommonModel->updateRowByCondition($condition1,'users',$updateData);
		
		
		if ($res) 
		{
		    $where = array('id'=>$userDetail->id);
		  //  $where = array('id'=>7);
            $userDetail = $this->CommonModel->getsingle('users',$where);
            // print_r($userDetail);die;
            
		    $data['id'] 	 	= 	$this->check_value($userDetail->id);
		    $data['wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['cjm_wallet'] 	 	= 	$this->check_value($userDetail->cjm_wallet);
		    $data['eth_wallet'] 	 	= 	$this->check_value($userDetail->eth_wallet);
			$data['name'] 	= 	$this->check_value($userDetail->first_name);
			$data['email']      = 	$this->check_value($userDetail->email);
			$data['phone_no']      = 	$this->check_value($userDetail->phone_no);
			$data['device_id'] 	    = 	$this->check_value($userDetail->device_id);
			$data['device_type']    = 	$this->check_value($userDetail->device_type);		
			
            return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> $this->lang->line('login_successfully'),
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
	
}