<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function package_list()
    {
        $data['title'] = 'Package List';
        
        // $data['getAllPackage'] = $this->CommonModel->selectResultData('packages','packages.id');

        $where = array( 
            'deleted_at' => NULL,
            'user_type' => 2,
        );

        $data['getAllPackage'] = $this->CommonModel->selectResultDataByConditionAndFieldName($where,'packages','packages.id');


         $this->loadAdminView('admin/package/list',$data); 
    }
    
    public function update_package()
    {
        $condition = array(
            "id" => $this->input->post('package_id')
        );
        
        $data = array(
            "name"  => $this->input->post('package_name'),
            "price"  => $this->input->post('price'),
            "data_access"  => $this->input->post('data_access'),
            "validity"  => $this->input->post('validity').' days',
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        $packageData = $this->CommonModel->updateRowByCondition($condition,'packages',$data);  
        
        if ($packageData) {
            $this->session->set_flashdata('success','Package updated successfully');
            redirect('admin/package');
        }else{
            $this->session->set_flashdata('error', 'Package not updated');
            redirect('admin/package');
        }
    }
    
    public function status_package()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('package_id')),'packages');

        $condition = array(
            "id" => $this->input->post('package_id')
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
    
}