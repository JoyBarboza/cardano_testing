<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
    	$this->load->library('session');
    	
	}
	public function login_view()
	{
		$this->load->view('admin/login');
	}


	public function check_login()
    {
        
        $email      = 	$this->input->post('email');
        $password          = 	$this->input->post('password');

        $data = array(
            'email'      =>  $email,
            'password'   =>  $password
        );
 
        $adminData = $this->AdminModel->adminData($data);

        if(!empty($adminData))
        {
            // echo "string";die;
            // print_r($adminData->id);die;
            $this->session->set_flashdata('success','Login Successfully');
            $this->session->set_userdata('ses_admin_id',$adminData->id);
            redirect('admin/dashboard');
        }
        else
        {
             // echo "dfhfgh";die;
            $this->session->set_flashdata('error','Your not valid user');
            redirect('admin/login');
        }   

	}
}
