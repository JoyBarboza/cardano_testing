<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();
	}
	
	public function notification_list()
    {
        $data['title'] = 'Notification List';
        
        $to_id = $this->session->userdata('ses_admin_id');
        
        $msg_update = array(
            "is_read" => 1
        );
        
        $type = 3;
        // $to_id = 0;
        $data['notification_list']  = $this->CommonModel->notification($type,$to_id); 
        
        $update = $this->CommonModel->updateRowByCondition(array("to_id" => $to_id),'notification',$msg_update);

         $this->loadAdminView('admin/notification_list',$data); 
    }
    
    public function count_notification()
    {
        
        $to_id = $this->session->userdata('ses_admin_id');
        
        
        // $condition      = array(
        //     "is_read"   => 0,
        //     "to_id" => $to_id
        // );
        $data   = $this->AdminModel->countNotification($to_id); 
        
        if ($data == 0) {
            echo '0';
        }else{
            echo $data['total'];
        }
    }
}