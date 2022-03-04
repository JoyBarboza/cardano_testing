<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('CommonModel');
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		//$token = $this->input->get_request_header('token', TRUE);	
		//$this->user = $this->_userLoginCheck( $token );
	}

	public function reset_verify()
    {
        $id = base64_decode($this->input->get('id'));
        $condition  = array(
            "id" => $id
        );
        
		$userDetail = $this->CommonModel->selectRowDataByCondition($condition,'users');

        if($userDetail === FALSE)
        {	          
            redirect('admin/login');
        }
        if($userDetail)
        {
            $email_id = $userDetail->email;
        	$user_id  = $userDetail->id;
        	// print_r($id);die;
            $this->load->view('email_templates/reset_password',
            	array(
                    'email_id'  =>  $email_id,
            		'id'	=>	$user_id,
	            	'name'		=>	$userDetail->name
	            ));
		}
	} 

	public function verify_resetpassword()
	{
        $condition  = array("id" => base64_decode($this->input->get('id')));

        if ($this->input->post('npwd') == $this->input->post('cpwd')) 
        {
            $data       = array(
				"password" => md5($this->input->post('npwd')),
				"actual_password" => $this->input->post('npwd'),
			);

            $updateData = $this->CommonModel->updateRowByCondition($condition,'users',$data);

            if($updateData) 
            { 
            	$userDetail = $this->CommonModel->selectRowDataByCondition($condition,'users');
            	// print_r($userDetail);die;
            	// $fullname = $userDetail->first_name.''.$userDetail->last_name;

                $this->session->set_flashdata('success','Password reset Successfully');
                redirect('auth/reset_verify?id='.$this->input->get('id'));
                
            //     $this->load->view('email_templates/thankyou',array(
            //         // 'name'  =>  $fullname
	           // 	'name'  =>  $userDetail->first_name.' '.$userDetail->last_name
	           // ));
            }
            else
            {
                $this->session->set_flashdata('error', 'Password not reset');
                // $this->load->view('email_templates/forget_password');
                // $this->load->view('auth/reset_verify?id='.$this->input->get('id'));
                redirect('auth/reset_verify?id='.$this->input->get('id'));
            }
        }
        else 
        { 
            $this->session->set_flashdata('error', 'Your new Password and confirm Password not match!');
            redirect('Auth/forget?id='.base64_encode($this->input->post('email')));
        } 
		
	} 
    
    
    public function about_us()
    {
        $aboutData['title'] = 'About Us';
        
        $condition = array(
            "id" => 1
        );

        $aboutData['cms'] = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
        $this->load->view('cms/commonPage',$aboutData);
    }
    
    public function privacy_policy()
    {
        $privacyData['title'] = 'Privacy Policy';

        $condition = array(
            "id" => 2
        );

        $privacyData['cms'] = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
        $this->load->view('cms/commonPage',$privacyData); 
    }

    public function term_and_condition()
    {
       $termData['title'] = 'Terms and Condition';
        $condition = array(
            "id" => 3
        );

        $termData['cms'] = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
        $this->load->view('cms/commonPage',$termData); 
    }
      
}   
           
