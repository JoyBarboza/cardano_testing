<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdvertismentController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function advertisment_list()
    {
        $data['title'] = 'Advertisment List';
        
        $data['getAllAdvertisment'] = $this->CommonModel->selectResultData('advertisement','advertisement.id');

         $this->loadAdminView('admin/advertisment/list',$data); 
    }
    
    public function update_advertisment()
    {
        $condition = array(
            "id" => $this->input->post('ads_id')
        );
        
        $data = array(
            "name"  => $this->input->post('ads_name'),
            "price"  => $this->input->post('price'),
            "description"  => $this->input->post('description'),
            "data_access"  => $this->input->post('data_access'),
            "validity"  => $this->input->post('validity').' days',
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        $adsData = $this->CommonModel->updateRowByCondition($condition,'advertisement',$data);  
        
        if ($adsData) {
            $this->session->set_flashdata('success','Advertisment updated successfully');
            redirect('admin/advertisment');
        }else{
            $this->session->set_flashdata('error', 'Advertisment not updated');
            redirect('admin/advertisment');
        }
    }
    
    public function status_advertisment()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('ads_id')),'advertisement');

        $condition = array(
            "id" => $this->input->post('ads_id')
        );
        if($data->ads_status == 1){
            $data = array("ads_status" => '0');
        }else{
            $data = array("ads_status" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'advertisement',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
        
    }
    
}