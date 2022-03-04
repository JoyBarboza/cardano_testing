<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BannerController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function banner_list()
    {
        $data['title'] = 'Banner List';
        

        $data['getAllBanner'] = $this->CommonModel->selectResultData('banner','banner.id');

         $this->loadAdminView('admin/banner_list',$data);
    }

     public function insert_banner()
    {
            $config['upload_path']          =  'uploads/banner/';
            $config['allowed_types']        =  'jpeg|jpg|png|JPEG|JPG|PNG';
            $config['max_size'] = 2000;
            $config['max_width'] = 1500;
            $config['max_height'] = 1500;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('doc_img')) 
            {
                $this->form_validation->set_message('do_upload', $this->upload->display_errors());
                 $this->session->set_flashdata('error','You select invalid image format');
                         redirect('admin/banner'); 
            } 
            else 
            {
                $doc_img = $this->upload->data('file_name');  
            }


            $data = array (
                    'user_type'     =>  $this->input->post('user_type'),
                    'image'         =>  $doc_img,
                    "created_at"    =>  date('Y-m-d H:i:s a'),
                    "updated_at "   =>  date('Y-m-d H:i:s a'),
                );

                $insertData = $this->CommonModel->insertData($data,'banner');  

            if($insertData){
                $this->session->set_flashdata('success','Banner add successfully');
               redirect('admin/banner');
            }else{
               $this->session->set_flashdata('error','Banner not added, Please try again.');
                redirect('admin/banner');
            }
 
    }


    public function update_banner()
    {
        // print_r($_FILES);die;
    
        $condition = array("id" => $this->input->post('banner_id'));
             
        $bannerDetail = $this->CommonModel->getsingle('banner',$condition);

        // $config['upload_path']          =  'uploads/banner/';
        // $config['allowed_types']        =  'jpeg|jpg|png|JPEG|JPG|PNG';
        // $config['max_size'] = 2000;
        // $config['max_width'] = 1500;
        // $config['max_height'] = 1500;

        // $this->load->library('upload', $config);

        // if (!$this->upload->do_upload('doc_img')) 
        // {
        //     $this->form_validation->set_message('do_upload', $this->upload->display_errors());
        //      $this->session->set_flashdata('error','You select invalid image format');
        //              redirect('admin/banner'); 
        // } 
        // else 
        // {
        //     $doc_img =  $bannerDetail->image;  
        // }

        if (isset($_FILES['doc_img'])) 
        {  
            if($_FILES['doc_img']['size'] != 0)
            {
                $config['upload_path']          =  'uploads/banner/';
                $config['allowed_types']        =  'jpeg|jpg|png|JPEG|JPG|PNG';
                $config['max_size']             =  (1024)*(1024);
                $config['max_width']            =  0;
                $config['max_height']           =  0;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('doc_img'))
                {
                    $this->form_validation->set_message('do_upload', $this->upload->display_errors());
                    $this->session->set_flashdata('error','You select invalid image format');
                    redirect('service_provider/profile');
                }
                else
                {
                    $this->upload_data['file'] = $this->upload->data();
                    $doc_img = $this->upload->data('file_name');      
                }
            }
            else
            {
               $doc_img =  $bannerDetail->image;  
            }
        }
        else
        {
            $doc_img =  $bannerDetail->image;  
        }

// print_r($doc_img);die;

 
        $data = array (
                    'user_type'     =>  $this->input->post('user_type'),
                    'image'         =>  $doc_img,
                    "created_at"    =>  date('Y-m-d H:i:s a'),
                    "updated_at "   =>  date('Y-m-d H:i:s a'),
                );
                
        // print_r($condition);exit;
        $bannerData = $this->CommonModel->updateRowByCondition($condition,'banner',$data);  
        
        if ($bannerData) {
            $this->session->set_flashdata('success','Banner updated successfully');
            redirect('admin/banner');
        }else{
            $this->session->set_flashdata('error', 'Banner not updated');
             redirect('admin/banner');
        }
    }

    public function delete_banner()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        $categoryData = $this->CommonModel->delete($condition,'banner');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Banner deleted successfully');
            redirect('admin/banner');
        }else{
            $this->session->set_flashdata('error', 'Banner not deleted');
            redirect('admin/banner');
        }
    }
    
    public function status_banner()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('banner_id')),'banner');

        $condition = array(
            "id" => $this->input->post('banner_id')
        );
        if($data->status == 1){
            $data = array("status" => '0');
        }else{
            $data = array("status" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'banner',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
    }

    
}