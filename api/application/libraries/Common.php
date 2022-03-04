<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

class Common{

	public $CI;
	public function __construct()
    {
        $this->CI =& get_instance();
    }

	public function check_adminlogin()
	{
		$login = $this->CI->session->userdata('ses_admin_id');

		// print_r($login);
		if($login)
		{
			return true;

		} 
		else 
		{
			redirect('admin/login');
		}
	}

	public function check_subadminlogin()
	{
		$login = $this->CI->session->userdata('ses_subadmin_id');
		if($login)
		{
			return true;

		} 
		else 
		{
			redirect('subadmin/login');
		}
	}
	
	public function check_userlogin()
	{
		$login = $this->CI->session->userdata('ses_user_id');
		if($login)
		{
			return true;

		} 
		else 
		{
			redirect('login');
		}
	}
}