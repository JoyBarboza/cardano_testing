<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {

	public function __construct() 
	{
	    parent::__construct();

	    
	}

	public function loadAdminView($view,$data=array())
	{
        // $where = array('id'=>$this->session->userdata('ses_admin_id'));
        $where = array('id'=>$this->session->userdata('ses_admin_id'));
        $data['getAdminData'] = $this->CommonModel->getsingle('admin',$where);
        // print_r($data['getAdminData']);die;

		$this->load->view('admin/common/header',$data);
		$this->load->view($view);
		$this->load->view('admin/common/footer');
	}
}
