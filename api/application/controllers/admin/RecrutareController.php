<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecrutareController extends MY_Controller {


	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();
        
	}
    
     public function recuratare_list()
    {

        $data['title'] = 'Recruiter List';

        $where = array( 
            'deleted_at' => NULL,
            'user_type' => 2,
        );

        $data['getAllEmployee'] = $this->CommonModel->selectResultDataByConditionAndFieldName($where,'users','users.id');

        $this->loadAdminView('admin/recuratare/list',$data); 
    }

    public function changeStatus()
    {
       $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('employee_id')),'users');

        $condition = array(
            "id" => $this->input->post('employee_id')
        );
        if($data->status == 1){
            $data = array("status" => '0');
        }else{
            $data = array("status" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'users',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
    }

    public function delete()
    {
        $id    = base64_decode($this->uri->segment(3));


        $data = array(
                "deleted_at"     => date('Y-m-d H:i:s a'),
            );
        $updateData = $this->CommonModel->updateRowByCondition(array('id' => $id),'users',$data);  
    
        if($updateData){
            $this->session->set_flashdata('success','Recrutare delete successfully');
            redirect('admin/recuratare');            
        }else{
            $this->session->set_flashdata('error','Recrutare not delete successfully');
            redirect('admin/recuratare');               
        }
    }

}
