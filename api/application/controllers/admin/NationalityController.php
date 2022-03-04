<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NationalityController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function nationality_list()
    {
        $data['title'] = 'Nationality List';
        

        // $data['getAllNationality'] = $this->CommonModel->selectResultData('nationality','nationality.id');
        $data['getAllNationality'] = $this->CommonModel->selectAllResultData('nationality');

         $this->loadAdminView('admin/nationality/list_nationality',$data);
    }

     public function add_nationality()
    {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $name                = $this->input->post('name');
            $other_language_name = $this->input->post('other_language_name');


            foreach ($name as $key => $value) 
            {
                $data = array (
                    "name"                  =>  $name[$key],
                    "other_language_name"   =>  $other_language_name[$key],
                    "created_at"            =>  date('Y-m-d H:i:s a'),
                    "updated_at "            =>  date('Y-m-d H:i:s a'),
                );

                $insertData = $this->CommonModel->insertData($data,'nationality');  
            }

            if($insertData){
                $this->session->set_flashdata('success','nationality add successfully');
               redirect('admin/nationality');
            }else{
               $this->session->set_flashdata('error','Nationality not added, Please try again.');
                redirect('admin/add_nationality');
            }
        }else{
             $data['title'] = 'Add Nationality';

            $this->loadAdminView('admin/nationality/add_nationality',$data); 
        }
    }


    public function update_nationality()
    {
        // echo "string";
        // print_r($_POST);die;
        $condition = array(
            "id" => $this->input->post('nationality_id')
        );
        
 
        $data = array(
            "name"  => $this->input->post('name'),
            "other_language_name"  => $this->input->post('other_name'),
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'nationality',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Nationality updated successfully');
            redirect('admin/nationality');
        }else{
            $this->session->set_flashdata('error', 'Nationality not updated');
            redirect('admin/nationality');
        }
    }

    public function delete_nationality()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'nationality');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Nationality deleted successfully');
            redirect('admin/nationality');
        }else{
            $this->session->set_flashdata('error', 'Nationality not deleted');
            redirect('admin/nationality');
        }
    }
    
    public function status_nationality()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('nationality_id')),'nationality');

        $condition = array(
            "id" => $this->input->post('nationality_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'nationality',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }
}
