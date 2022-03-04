<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaidServiceController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

        $this->load->helper('date');
	}
    //show about us
    public function emp_paid_service_list()
    {
        $data['title'] = 'Employee Paid Service List';
        
        $where = 'deleted_at IS NULL AND user_type = 1';


        $data['getAllPackage'] = $this->CommonModel->selectResultDataByConditionAndFieldName($where,'packages','packages.id');

         $this->loadAdminView('admin/emp_paid_service/list',$data); 
    }
    
    public function add_paid_service()
    {
        $data = array(
            "package_color"  => 'pink',
            "user_type"  => 1,
            "name"  => $this->input->post('package_name'),
            "price"  => $this->input->post('price'),
            "gst" => 'GST',
            "data_access"  => $this->input->post('data_access'),
            "validity"  => $this->input->post('validity').' days',
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        $packageData = $this->CommonModel->insertData($data,'packages');  
        
        if ($packageData) {
            $this->session->set_flashdata('success','Service added successfully');
            redirect('admin/serive_list');
        }else{
            $this->session->set_flashdata('error', 'Service not added');
            redirect('admin/serive_list');
        }
    }


    public function update_paid_service()
    {
        $condition = array(
            "id" => $this->input->post('service_id')
        );
        
        $data = array(
            "package_color"  => 'pink',
            "user_type"  => 1,
            "name"  => $this->input->post('package_name'),
            "price"  => $this->input->post('price'),
             "gst" => 'GST',
            "data_access"  => $this->input->post('data_access'),
            "validity"  => $this->input->post('validity').' days',
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        $packageData = $this->CommonModel->updateRowByCondition($condition,'packages',$data);  
        
        if ($packageData) {
            $this->session->set_flashdata('success','Service updated successfully');
            redirect('admin/serive_list');
        }else{
            $this->session->set_flashdata('error', 'Service not updated');
            redirect('admin/serive_list');
        }
    }
    
    public function status_paid_service()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('service_id')),'packages');

        $condition = array(
            "id" => $this->input->post('service_id')
        );
        if($data->package_status == 1){
            $data = array("package_status" => '0');
        }else{
            $data = array("package_status" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'packages',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }

    public function delete_paid_service(){

        $service_id    = base64_decode($this->uri->segment(3));
        $where             = array('id' => $service_id);
// print_r($where);die;
        if($this->CommonModel->_softDeletebyCondition('packages',$where)==true){
            
            $this->session->set_flashdata('success','Service delete successfully');
            redirect('admin/serive_list');         
        }else{

            $this->session->set_flashdata('error','Service not delete, Please try again.');
            redirect('admin/serive_list');      
        }
    }
    
}