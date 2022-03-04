<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostJobController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function post_job_list()
    {
        $data['title'] = 'Post Job List';
                

        if(!empty(base64_decode($this->uri->segment(3))))
        {
        	
             $data['getUserData'] = $this->CommonModel->getsingle('users',array('id' => base64_decode($this->uri->segment(3))));


            $recuriter_id = base64_decode($this->uri->segment(3));

             $data['getAllPostedJob'] = $this->CommonModel->allPostList($recuriter_id);

        }else
        {
            $recuriter_id = "";

			$data['getAllPostedJob'] = $this->CommonModel->allPostList($recuriter_id);
        }


        // print_r($data['getAllPostedJob']);die;
         $this->loadAdminView('admin/post_job/post_job_list',$data);
    }

    public function view_post_job()
    {
    	$data['title'] = 'View Post Job Detail';

    	$post_job_id = base64_decode($this->uri->segment(3));

    	$data['getPostedJobDetail'] = $this->CommonModel->viewPostJob($post_job_id);

    // 	print_r($data['getPostedJobDetail']);die;

    	 $this->loadAdminView('admin/post_job/view_post_job',$data);

    }

}