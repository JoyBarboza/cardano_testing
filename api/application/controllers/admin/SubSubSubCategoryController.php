<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubSubSubCategoryController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function subsubsubcategory_list()
    {
        // print_r(base64_decode($this->uri->segment(3)));die;
        $data['title'] = 'Sub Sub Sub Cateogry List';
        
         $condition = array(
            "is_active" => 1
        );

        $data['getAllCategory'] = $this->CommonModel->selectResultData('categories','categories.id');

        $data['allSubCateogry'] = $this->CommonModel->selectResultDataByCondition($condition,'subcategories'); 

        $data['allSubSubCateogry'] = $this->CommonModel->selectResultDataByCondition($condition,'sub_subcategory'); 


        if(!empty(base64_decode($this->uri->segment(3)))){

            $subcategory_id = base64_decode($this->uri->segment(3));

            // $data['getSubCateogryData'] = $this->CommonModel->getSubCatgoryDetail($subcategory_id);
            $data['getSubCateogryData'] = $this->CommonModel->getSubSubCatgoryDetail($subcategory_id);

          
             // $data['getAllSubCategory'] = $this->CommonModel->selectResultDataByConditionAndFieldName($where,'subcategories','subcategories.id');
             $data['getAllSubSubSubCategory'] = $this->CommonModel->getSubSubSubCategory($subcategory_id);

        }else
        {
            $subsubcategory_id = "";

            // $data['getAllSubCategory'] = $this->CommonModel->selectResultData('subcategories','subcategories.id');

             // $data['getAllSubSubCategory'] = $this->CommonModel->getSubSubCategory($subcategory_id);
             $data['getAllSubSubSubCategory'] = $this->CommonModel->getSubSubSubCategory($subsubcategory_id);
        }

// print_r($data['getAllSubSubCategory'] );die;
        $this->loadAdminView('admin/category/sub_sub_sub_category_list',$data); 
    }

    public function getSubCategory()
    {
        $condition  = array("category_id" => $this->input->post('category_id'));

        $subCatData = $this->CommonModel->selectResultDataByCondition($condition,'subcategories');

        if (!empty($subCatData)) {
            echo json_encode($subCatData);
        }else{
            echo "0";
        }
    }

     public function getSubSubCategory()
    {
        $condition  = array("subcategory_id" => $this->input->post('subcategory_id'));

        $subCatData = $this->CommonModel->selectResultDataByCondition($condition,'sub_subcategory');

        if (!empty($subCatData)) {
            echo json_encode($subCatData);
        }else{
            echo "0";
        }
    }
    

     public function insert_subsubsubcategory()
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
            redirect('admin/subsubsubcategory');
        }
        else
        {
            $this->upload_data['file'] = $this->upload->data();
            $img = $this->upload->data('file_name');      
        }

        $data = array(
            "sub_subcategory_id"            => $this->input->post('sub_sub_cateogry_id'),
            "name"                          => $this->input->post('name'),
            "other_language_name"           => $this->input->post('other_language_name'),
            "image"                         => $img,
            "is_active"                     => 1,
            "created_at"                    => date('Y-m-d H:i:s a'),
            "updated_at"                    => date('Y-m-d H:i:s a'),
        );


        $insertData = $this->CommonModel->insertData($data,'sub_sub_subcategory');  

        if($insertData){
            $this->session->set_flashdata('success','Sub Sub Sub Category add successfully');
           redirect('admin/subsubsubcategory');
        }else{
           $this->session->set_flashdata('error','Sub Sub Sub Category not added, Please try again.');
            redirect('admin/subsubsubcategory');
        }
    }


    public function update_subsubsubcategory()
    {
        // print_r($_POST);die;
        // echo "string";die;
        $condition = array(
            "id" => $this->input->post('subsubsubcategory_id')
        );
        
        $getSubSubCateogryData = $this->CommonModel->getsingle('sub_sub_subcategory',$condition);

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
                    redirect('admin/subsubcategory');
                }
                else
                {
                    $this->upload_data['file'] = $this->upload->data();
                    $img = $this->upload->data('file_name');      
                }
            }
            else
            {
               $img = $getSubSubCateogryData->image; 
            }
        }
        else
        {
            $img = $getSubSubCateogryData->image; 
        }

        $data = array(
            // "sub_subcategory_id"            => $this->input->post('sub_sub_cateogry_id'),
            "name"                          => $this->input->post('name'),
            "other_language_name"           => $this->input->post('other_language_name'),
            "image"                         => $img,
            "is_active"                     => 1,
            "created_at"                    => date('Y-m-d H:i:s a'),
            "updated_at"                    => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'sub_sub_subcategory',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Sub Sub Sub Category updated successfully');
            redirect('admin/subsubsubcategory');
        }else{
            $this->session->set_flashdata('error', 'Sub Sub Sub Category not updated');
            redirect('admin/subsubsubcategory');
        }
    }

    public function delete_subsubsubcategory()
    {
        // echo "string";
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'sub_sub_subcategory');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Sub Sub Sub Category deleted successfully');
            redirect('admin/subsubsubcategory');
        }else{
            $this->session->set_flashdata('error', 'Sub Sub Sub Category not deleted');
            redirect('admin/subsubsubcategory');
        }
    }
    
    public function status_subsubsubcategory()
    {
        // echo "string";die;
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('subsubsubcategory_id')),'sub_sub_subcategory');

        $condition = array(
            "id" => $this->input->post('subsubsubcategory_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'sub_sub_subcategory',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }
}
