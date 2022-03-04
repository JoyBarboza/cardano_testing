<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DegreeController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function degree_list()
    {
        $data['title'] = 'Degree List';

         $condition = array(
            "deleted_at"       =>  NULL
        );

        $data['getAllUniversity'] = $this->CommonModel->selectResultDataByConditionAndFieldName($condition,'degree','degree.id');

         $this->loadAdminView('admin/degress/list',$data);
    }

     public function add_degree()
    {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	// print_r($_POST);die;
            $name                   =   $this->input->post('name');
            $other_language_name    =   $this->input->post('other_language_name');
            $type                   =   $this->input->post('type');


            foreach ($name as $key => $value) 
            {
                $where = array(
                        'name'     => $name[$key],
                        "type"     =>  $type[$key],
                );
                $checkUniversity = $this->CommonModel->getsingle('degree',$where);
                // print_r($checkParents);
                if(empty($checkUniversity))
                {
                   	$data = array (
	                    "name"                  =>  $name[$key],
	                    "other_language_name"   =>  $other_language_name[$key],
                        "type"                  =>  $type[$key],
	                    "created_at"            =>  date('Y-m-d H:i:s a'),
	                    "updated_at "           =>  date('Y-m-d H:i:s a'),
	                );

	                $insertData = $this->CommonModel->insertData($data,'degree');  
                }else{
                    $condition = array('id'=>$checkUniversity->id);
    
                   	$data = array (
	                    "name"                  =>  $name[$key],
	                    "other_language_name"   =>  $other_language_name[$key],
                        "type"                  =>  $type[$key],
	                    "created_at"            =>  date('Y-m-d H:i:s a'),
	                    "updated_at "            =>  date('Y-m-d H:i:s a'),
	                );
    
                    $insertData = $this->CommonModel->updateRowByCondition($condition,'degree',$data);
                }
            }

            if($insertData){
                $this->session->set_flashdata('success','Degree add successfully');
               redirect('admin/degree');
            }else{
               $this->session->set_flashdata('error','Degree not added, Please try again.');
                redirect('admin/add_degree');
            }
        }else{
             $data['title'] = 'Add Degree';

            $this->loadAdminView('admin/degress/add',$data); 
        }
    }


    public function update_degree()
    {
         // print_r($_POST);exit;
         
        $condition = array(
            "id" => $this->input->post('degree_id')
        );
        
 
        $data = array(
            "name"  => $this->input->post('degree_name'),
            "other_language_name"  => $this->input->post('other_degree_name'),
            "type"  => $this->input->post('type'),
            "updated_at"     => date('Y-m-d H:i:s a'),
        );
                
        // print_r($condition);exit;
        $categoryData = $this->CommonModel->updateRowByCondition($condition,'degree',$data);  
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Degree updated successfully');
            redirect('admin/degree');
        }else{
            $this->session->set_flashdata('error', 'Degree not updated');
            redirect('admin/degree');
        }
    }

    public function delete_degree()
    {
        $condition = array(
            "id" => base64_decode($this->uri->segment(3))
        );
        // print_r($condition);die;
        $categoryData = $this->CommonModel->delete($condition,'degree');
        
        if ($categoryData) {
            $this->session->set_flashdata('success','Degree deleted successfully');
            redirect('admin/degree');
        }else{
            $this->session->set_flashdata('error', 'Degree not deleted');
            redirect('admin/degree');
        }
    }
    
    public function status_degree()
    {
        $data = $this->CommonModel->selectRowDataByCondition(array('id' =>  $this->input->post('degree_id')),'degree');

        $condition = array(
            "id" => $this->input->post('degree_id')
        );
        if($data->is_active == 1){
            $data = array("is_active" => '0');
        }else{
            $data = array("is_active" => '1');
        }

        $updateData = $this->CommonModel->updateRowByCondition($condition,'degree',$data);  

        if($updateData)
        {
            echo "1";
        }else{
            echo "0";
        }
    }

    public function checkDegree()
    {
    	if(!empty($this->input->post('degree_name')))
        {
            $condition1 = array(
                "name"     => $this->input->post('degree_name'),
                "type"     => $this->input->post('type'),
            );
            $subCatData = $this->CommonModel->selectResultDataByCondition($condition1,'degree');

            if (!empty($subCatData)) {
                echo "1";
            }else{
                echo "0";
            }

        }
    }

     public function filterdegree()
    {

        $types = $this->input->post('types');

        $condition = array(
            "type"             =>  $types,
            "deleted_at"       =>  NULL
        );

        $key = $this->CommonModel->selectResultDataByConditionAndFieldName($condition,'degree','degree.id');
        // print_r($data['getAllUniversity']);die;

        if ($key) {
            $k = 0;
            for ($i=0; $i < count($key); $i++) { 

                 if($key[$i]['is_active'] == 1)
                {
                    $active_status = "change_status('".$key[$i]['id']."','Deactive')";
                    $status = '<button title="Change Status" class="btn-success btn btn-sm" value="'.$key[$i]['id'].'" onclick="'.$active_status.'">Active</button>';

                }else{
                    $deactive_status = "change_status('".$key[$i]['id']."','Active')";
                    $status = '<button title="Change Status" class="btn-info btn btn-sm " value="'.$key[$i]['id'].'" onclick="'.$deactive_status.'">Deactive</button>';
                }


                $edit = '<a class="btn btn-primary edit_category" title="edit" href="javascript:void(0);" data-university_name="'. $key[$i]['name'].'" ddata-other_university_name="'. $key[$i]['other_language_name'].'" data-type="'. $key[$i]['type'].'" data-university_id="'. $key[$i]['id'].'"><i class="fa fa-pencil"></i></a>';


                $encode_id = base64_encode($key[$i]['id']);

                $deleteUrl = base_url('admin/delete_degree/'.$encode_id);
                $delete = '<a title="Delete"  onclick="return delteUniversity()" class="btn btn-danger" href="'. $deleteUrl.'"><i class="fa fa-trash" ></i></a>';

                $action = $edit.'<br>'.$delete;


                $acton = 1;
                
                if($key[$i]['type'] == 0){
                  $type = 'Degree';
                }elseif($key[$i]['type'] == 1){
                  $type = 'Master';
                } elseif($key[$i]['type'] == 2){
                  $type = 'ITI';
                } elseif($key[$i]['type'] == 3){
                  $type = 'Diploma';
                }  
                
                $k = $k+1;
                $arr[] = array(
                    $k,
                    $type,
                    $key[$i]['name'],
                    $key[$i]['other_language_name'],
                    $status,
                    $action
                );
                    
            } 
        }
        
        if (!empty($arr)) {
            $arr2 = array("data" => $arr);
        }else{
            $arr2 = array("data" => []);
        }
        echo json_encode($arr2);
        
    }
}