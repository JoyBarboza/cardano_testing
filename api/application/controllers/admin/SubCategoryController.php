<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategoryController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
	
	public function subcategory_list()
    {

        $data['title'] = 'Sub Cateogry List';
        
         $condition = array(
            "is_active" => 1
        );

        $data['allCateogry'] = $this->CommonModel->selectResultDataByCondition($condition,'categories'); 


        if(!empty(base64_decode($this->uri->segment(3)))){

            $category_id = base64_decode($this->uri->segment(3));

             $data['getCateogryData'] = $this->CommonModel->getsingle('categories',array('id' => base64_decode($this->uri->segment(3))));

            $where = array(
                "category_id" => base64_decode($this->uri->segment(3))
            );


            $data['getAllSubCategory'] = $this->CommonModel->getSubCategory($category_id);

        }else
        {
            $category_id = "";
            
             $data['getAllSubCategory'] = $this->CommonModel->getSubCategory($category_id);
        }


         $this->loadAdminView('admin/category/sub_category_list',$data); 
    }
    //show about us
    public function subcategory_listOld()
    {
        // echo "string";
        // print_r(base64_decode($this->uri->segment(3)));die;

        $data['title'] = 'Sub Cateogry List';
        

        $condition = array(
            "is_active" => 1
        );

        $data['allCateogry'] = $this->CommonModel->selectResultDataByCondition($condition,'categories'); 

// print_r($data['allCateogry']);die;

        $data['getAllSubCategory'] = $this->CommonModel->selectResultData('subcategories','subcategories.id');

         $this->loadAdminView('admin/category/sub_category_list',$data); 
    }

     public function insert_subcategory()
    {
        // print_r($_POST);die;

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
            "category_id"                   => $this->input->post('category_id'),
            "name"                          => $this->input->post('name'),
            "description"                   => $this->input->post('description'),
            "other_language_name"           => $this->input->post('other_language_name'),
            "other_language_description"    => $this->input->post('other_language_description'),
            "image"                         => $img,
            "is_active"                     => 1,
            "created_at"                    => date('Y-m-d H:i:s a'),
            "updated_at"                    => date('Y-m-d H:i:s a'),
        );


        $insertData = $this->CommonModel->insertData($data,'subcategories');  

        if($insertData){
            $this->session->set_flashdata('success','SubCategory add successfully');
           redirect('admin/subcategory');
        }else{
           $this->session->set_flashdata('error','SubCategory not added, Please try again.');
            redirect('admin/subcategory');
        }
    }


    public function update_subcategory()
    {
        // print_r($_POST);die;
        $condition = array(
            "id" => $this->input->post('subcategory_id')
        );
        
         // print_r($condition);die;

        $getSubCateogryData = $this->CommonModel->getsingle('subcategories',$condition);

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
               $img = $getSubCateogryData->image; 
            }
        }
        else
        {
            $img = $getSubCateogryData->image; 
        }

        $data = array(
            "category_id"                   => $this->input->post('category_id'),
            "name"                          => $this->input->post('name'),
            "description"                   => $this->input->post('description'),
            "other_language_name"           => $this->input->post('other_language_name'),
            "other_language_description"    => $this->input->post('other_language_description'),
            "image"                         => $img,
            "is_active"                     => 1,
            "created_at"                    => date('Y-m-d H:i:s a'),
            "updated_at"                    => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'subcategories',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Sub Category updated successfully');
            redirect('admin/subcategory');
        }else{
            $this->session->set_flashdata('error', 'Sub Category not updated');
            redirect('admin/subcategory');
        }
    }

    public function delete_subcategory()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'subcategories');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Sub Category deleted successfully');
            redirect('admin/subcategory');
        }else{
            $this->session->set_flashdata('error', 'Sub Category not deleted');
            redirect('admin/subcategory');
        }
    }
    
    public function status_subcategory()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('subcategory_id')),'subcategories');

        $condition = array(
            "id" => $this->input->post('subcategory_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'subcategories',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }
}
