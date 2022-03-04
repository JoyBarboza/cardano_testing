<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
    	$this->load->library('session');
	}

    public function forgot_password()
    {

        $this->load->view('admin/forgot_password');
    }

    public function send_reset_mail()
    {
        $condition = array(
                'email' => $this->input->post('email')
        );
        $adminDetail = $this->CommonModel->selectRowDataByCondition($condition,'admin');

         // print_r($subAdminDetail);

         if(empty($adminDetail))
         {
            $this->session->set_flashdata('error','This email-id not registered with us.');
            redirect('admin/forgot_password');

         }else
         {
            $view = $this->load->view('admin/email_template/forgot_password',$adminDetail,TRUE );
            
            // print_r($view);die;

            $this->email->from('info@ebusinessmart.com', 'E-Business Mart')
                    ->to($adminDetail->email)    
                    ->subject('Forgot Password')    
                    ->message($view)
                    ->set_mailtype('html');
            // send email
            $sent = $this->email->send();
            
            // print_r($sent);die;

            if ($sent) {
                $this->session->set_flashdata('success','Reset Password link send to your regristered mail.Please check your mail.');
                redirect('admin/login'); 
            }else{
                $this->session->set_flashdata('error','Somethings went wrong');
                redirect('admin/forgot_password');
            }       
         }
    }
    
    public function admin_resetPassword()
    {
        $id = $this->input->get('token');
        
    	$condition = array(
			"id"  	=> $id,
		);	
		$adminDetail = $this->CommonModel->selectRowDataByCondition($condition,'admin');
		
        if(empty($adminDetail))
        {	          
             $this->session->set_flashdata('error','Something went wrong');
               redirect('admin/login'); 
        }
        else
        {
            $email_id       =   $adminDetail->email;
        	$subadmin_id    =   $adminDetail->id;
            $name           =   $adminDetail->name;
            
        	// print_r($id);die;
            $this->load->view('admin/email_template/reset_password',
            	array(
                    'email_id'        =>    $email_id,
            		'subadmin_id'	  =>	$subadmin_id,
	            	'name'		      =>	$name
	            ));
		}
    }
    
    public function verify_adminresetpassword()
	{
        $condition  = array("id" => $this->input->get('id'));

        // print_r($_POST);die;

        $newPassword        = $this->input->post('new_password');
        $confirmPassword    = $this->input->post('confirm_password');

        $data = array(
                'password'          => md5($newPassword),
                'orginal_password'  => $newPassword,
            );
         $updateData = $this->CommonModel->update_entry('admin',$data,$condition);

         if($updateData)
         {
            $this->session->set_flashdata('success','Password reset successfully');
            redirect('admin/login');
         }else{
             $this->session->set_flashdata('error', 'Password not reset');
            $this->load->view('admin/forgot_password');
         }
	    
	}

    
}
