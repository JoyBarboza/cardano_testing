<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function category_list()
    {
        $data['title'] = 'Cateogry List';
        

        $data['getAllCategory'] = $this->CommonModel->selectResultData('categories','categories.id');

         $this->loadAdminView('admin/category/category_list',$data); 
    }

     public function insert_category()
    {
        // print_r($_FILES);die;
        $config['upload_path']          =  'uploads/category/';
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
            redirect('admin/category');
        }
        else
        {
            $this->upload_data['file'] = $this->upload->data();
            $img = $this->upload->data('file_name');      
        }

        $data = array(
            "name"  => $this->input->post('category_name'),
            "other_language_name"  => $this->input->post('other_category_name'),
            "image"  => $img,
            "updated_at"     => date('Y-m-d H:i:s a'),
        );


        $insertData = $this->CommonModel->insertData($data,'categories');  

        if($insertData){
            $this->session->set_flashdata('success','Category add successfully');
           redirect('admin/category');
        }else{
           $this->session->set_flashdata('error','Category not added, Please try again.');
            redirect('admin/category');
        }
    }


    public function update_category()
    {
        $condition = array(
            "id" => $this->input->post('category_id')
        );
        

        $getCateogryData = $this->CommonModel->getsingle('categories',$condition);

        if (isset($_FILES['image'])) 
        {  
            if($_FILES['image']['size'] != 0)
            {
                $config['upload_path']          =  'uploads/category/';
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
                    redirect('admin/category');
                }
                else
                {
                    $this->upload_data['file'] = $this->upload->data();
                    $img = $this->upload->data('file_name');      
                }
            }
            else
            {
               $img = $getCateogryData->image; 
            }
        }
        else
        {
            $img = $getCateogryData->image; 
        }

        $data = array(
            "name"  => $this->input->post('category_name'),
            "other_language_name"  => $this->input->post('other_category_name'),
            "image"  => $img,
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'categories',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Category updated successfully');
            redirect('admin/category');
        }else{
            $this->session->set_flashdata('error', 'Category not updated');
            redirect('admin/category');
        }
    }

    public function delete_category()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'categories');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Category deleted successfully');
            redirect('admin/category');
        }else{
            $this->session->set_flashdata('error', 'Category not deleted');
            redirect('admin/category');
        }
    }
    
    public function status_category()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('category_id')),'categories');

        $condition = array(
            "id" => $this->input->post('category_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'categories',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }
}
