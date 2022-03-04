<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeController extends MY_Controller {


	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();
        
	}
    public function employee_list()
    {
        // echo 1;die;
        $data['title'] = 'Employee List';

        $where = array( 
            'deleted_at' => NULL,
            'user_type' => 1,

        );

        $data['getAllEmployee'] = $this->CommonModel->selectResultDataByConditionAndFieldName($where,'users','users.id');

        // print_r($data['getAllEmployee']);die;

        $this->loadAdminView('admin/employee/list',$data); 
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
            $this->session->set_flashdata('success','Employee delete successfully');
            redirect('admin/employee');            
        }else{
            $this->session->set_flashdata('error','Employee not delete successfully');
            redirect('admin/employee');               
        }
    }

    // public function user_view()
    // {
    //     $data['title'] = 'View User';

    //     $where = array( 'id' => base64_decode($this->uri->segment(3)));
    //     $data['getUserDetail'] = $this->CommonModel->getsingle('user',$where);
        
    //     $whereAddress = array( 'user_id' => base64_decode($this->uri->segment(3)));
        
    //     $data['getUserAddress'] = $this->CommonModel->selectResultDataByConditionAndFieldName($whereAddress,'user_address','user_address.id');
        
    //     $data['getUserPayment'] = $this->CommonModel->selectResultDataByConditionAndFieldName($whereAddress,'user_payment','user_payment.id');
        
    //     // print_r($data['getUserAddress']);die;
    //     $this->loadAdminView('admin/user/view',$data); 
    // }  
}
