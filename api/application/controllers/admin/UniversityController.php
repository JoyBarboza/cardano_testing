<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UniversityController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function university_list()
    {
        $data['title'] = 'University List';
        

        $data['getAllUniversity'] = $this->CommonModel->selectResultData('university','university.id');

         $this->loadAdminView('admin/university/list',$data);
    }

     public function add_university()
    {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	// print_r($_POST);die;
            $name                = $this->input->post('name');
            $other_language_name = $this->input->post('other_language_name');


            foreach ($name as $key => $value) 
            {
                $where = array(
                        'name'     => $name[$key],
                );
                $checkUniversity = $this->CommonModel->getsingle('university',$where);
                // print_r($checkParents);
                if(empty($checkUniversity))
                {
                   	$data = array (
	                    "name"                  =>  $name[$key],
	                    "other_language_name"   =>  $other_language_name[$key],
	                    "created_at"            =>  date('Y-m-d H:i:s a'),
	                    "updated_at "            =>  date('Y-m-d H:i:s a'),
	                );

	                $insertData = $this->CommonModel->insertData($data,'university');  
                }else{
                    $condition = array('id'=>$checkUniversity->id);
    
                   	$data = array (
	                    "name"                  =>  $name[$key],
	                    "other_language_name"   =>  $other_language_name[$key],
	                    "created_at"            =>  date('Y-m-d H:i:s a'),
	                    "updated_at "            =>  date('Y-m-d H:i:s a'),
	                );
    
                    $insertData = $this->CommonModel->updateRowByCondition($condition,'university',$data);
                }
            }

            if($insertData){
                $this->session->set_flashdata('success','University add successfully');
               redirect('admin/university');
            }else{
               $this->session->set_flashdata('error','University not added, Please try again.');
                redirect('admin/add_university');
            }
        }else{
             $data['title'] = 'Add University';

            $this->loadAdminView('admin/university/add',$data); 
        }
    }


    public function update_nationality()
    {
        $condition = array(
            "id" => $this->input->post('university_id')
        );
        
 
        $data = array(
            "name"  => $this->input->post('university_name'),
            "other_language_name"  => $this->input->post('other_university_name'),
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'university',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','University updated successfully');
            redirect('admin/university');
        }else{
            $this->session->set_flashdata('error', 'University not updated');
            redirect('admin/university');
        }
    }

    public function delete_university()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'university');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','University deleted successfully');
            redirect('admin/university');
        }else{
            $this->session->set_flashdata('error', 'University not deleted');
            redirect('admin/university');
        }
    }
    
    public function status_university()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('university_id')),'university');

        $condition = array(
            "id" => $this->input->post('university_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'university',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
    }

    public function checkUniversity()
    {
    	if(!empty($this->input->post('university_name')))
        {
            $condition1 = array(
                "name"     => $this->input->post('university_name'),
            );
            $subCatData = $this->CommonModel->selectResultDataByCondition($condition1,'university');

            if (!empty($subCatData)) {
                echo "1";
            }else{
                echo "0";
            }

        }
    }
}