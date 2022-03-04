<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();
        
	}

    public function profile()
    {
        $data['title'] = 'Profile';

        $where = array('id'=>$this->session->userdata('ses_admin_id'));
        $data['getAdminData'] = $this->CommonModel->getsingle('admin',$where);
        $this->loadAdminView('admin/profile',$data); 
    }
    
    public function update_profile()
    {
        $data['title'] = 'Profile';

        $where = array('id'=>$this->session->userdata('ses_admin_id'));
        $getAdminData = $this->CommonModel->getsingle('admin',$where);

        if (isset($_FILES['image'])) 
        {  
            if($_FILES['image']['size'] != 0)
            {
                $config['upload_path']          =  'uploads/admin/';
                $config['allowed_types']        =  'jpeg|jpg|png|JPEG|JPG|PNG';
                $config['max_size']             =  (1024)*(1024);
                $config['max_width']            =  0;
                $config['max_height']           =  0;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('image'))
                {
                    $this->form_validation->set_message('do_upload', $this->upload->display_errors());
                    $this->session->set_flashdata('error','You select invalid image format');
                    redirect('admin/profile');
                }
                else
                {
                    $this->upload_data['file'] = $this->upload->data();
                    $profile_img = $this->upload->data('file_name');      
                }
            }
            else
            {
               $profile_img = $getAdminData->profile_image; 
            }
        }
        else
        {
            $profile_img = $getAdminData->profile_image; 
        }

        $data = array(
            'profile_image'     => $profile_img,
            'name'              => $this->input->post('name'),
            'mobile_number'     => $this->input->post('mobile_number'),
            'email'             => $this->input->post('email'),
            'updated_at'        => date('Y-m-d H:i:s')
        );
        $where = array('id' => $this->session->userdata('ses_admin_id'));
        $this->CommonModel->update_entry('admin',$data,$where);
        $this->session->set_flashdata('success','Your profile update successfully');
        redirect('admin/profile');
    }
    
    public function change_password()
    {
        // print_r($_POST);die;
        $where = array('id'=>$this->session->userdata('ses_admin_id'));
        $getAdminData = $this->CommonModel->getsingle('admin',$where);

        $oldPassword        = $this->input->post('old_password');
        $newPassword        = $this->input->post('new_password');
        $confirmPassword    = $this->input->post('confirm_password');

        if($getAdminData->orginal_password != $oldPassword)
        {
            $this->session->set_flashdata('error','Old Password not match');
            redirect('admin/profile');
        }
        else{
            // echo "string";
            $data = array(
                'password'              => md5($newPassword),
                'orginal_password'      => $newPassword,
            );
            $this->CommonModel->update_entry('admin',$data,$where);
            $this->session->set_flashdata('success','Your Password update successfully');
            redirect('admin/profile');
        }

    }
    public function logout()
    {
        $sessionData = array(
            'admin_id'    => '',
            'admin_name'  =>'',
            'admin_email' => '',
            'logged_in'   => FALSE,
           );
        $this->session->unset_userdata($sessionData);
        $this->session->sess_destroy();
        redirect('admin/login','refresh');
    }
}
