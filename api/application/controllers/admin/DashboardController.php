<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();
        
	}
	public function index()
	{
        $data['title'] = 'Dashboard';

        $data['employee'] = $this->CommonModel->select_single_row("Select count(*) as total from users where user_type = 1 and deleted_at IS NULL");
        
        $data['recuriter'] = $this->CommonModel->select_single_row("Select count(*) as total from users where user_type = 2 and deleted_at IS NULL");
        $data['jobpost'] = $this->CommonModel->select_single_row("Select count(*) as total from jobpost");
        
        // $data['resume'] = $this->CommonModel->select_single_row("Select count(*) as total from resume");
        $data['resume'] = $this->CommonModel->select_single_row("Select count(*) as total from user_job_list");

        
        // print_r($data['employee']);die;

        $this->loadAdminView('admin/dashboard',$data); 
	}

    
}
