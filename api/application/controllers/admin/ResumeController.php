<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResumeController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->common->check_adminlogin();

	}
    //show about us
    public function resume_list()
    {
        // echo 1;die;
        $data['title'] = 'Applied Resume List';
        
        $data['getAllCategory'] = $this->CommonModel->selectResultData('categories','categories.id');
        $data['getAllDegree'] = $this->CommonModel->selectResultData('degree','degree.id');
        // $data['getAllSubCategory'] = $this->CommonModel->selectResultData('subcategories','subcategories.id');
        // $data['getAllSubSubCategory'] = $this->CommonModel->selectResultData('sub_subcategory','sub_subcategory.id');

        if(!empty(base64_decode($this->uri->segment(3))))
        {
            $data['getUserData'] = $this->CommonModel->getsingle('users',array('id' => base64_decode($this->uri->segment(3))));


            $user_id = base64_decode($this->uri->segment(3));

             $data['getAllResumeList'] = $this->CommonModel->getAllResume($user_id);

        }else
        {
            $user_id = "";

			$data['getAllResumeList'] = $this->CommonModel->getAllResume($user_id);
        }


        // print_r($data['getAllResumeList']);die;
        $this->loadAdminView('admin/resume/resume_list',$data);
    }
    
     public function resume_detail()
    {
       
        $data['title'] = 'Resume Detail';
        
         $resume_id = base64_decode($this->uri->segment(3));
        //  print_r($resume_id);die;
        $data['getResumeDetail'] = $this->CommonModel->resume_detail($resume_id);
        
        $user_id = $data['getResumeDetail']->user_id; 
        $data['getuserExperience'] = $this->CommonModel->selectResultDataByCondition(array('user_id' => $user_id),'experience');
        $data['getuserQualification'] = $this->CommonModel->userResumeQualification( $user_id);
        //  print_r($data['getuserQualification']);die;

        $this->loadAdminView('admin/resume/resume_detail',$data);
    }
    
    public function getSubCategory()
	{
        $condition  = array(
           "category_id" => $this->input->post('category_id'),
            "is_active" => 1,
        );
        $catData = $this->CommonModel->selectResultDataByCondition($condition,'subcategories');
        
        if (!empty($catData)) {
            echo json_encode($catData);
        }else{
            echo "0";
        }
    }
    
    public function getSubSubCategory()
	{
        $condition  = array(
           "subcategory_id" => $this->input->post('sub_category_id'),
            "is_active" => 1,
        );
        $catData = $this->CommonModel->selectResultDataByCondition($condition,'sub_subcategory');
        
        if (!empty($catData)) {
            echo json_encode($catData);
        }else{
            echo "0";
        }
    }
    
    public function filterResume()
    {
        // print_r($_POST);die;
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $sub_sub_category_id = $this->input->post('sub_sub_category_id');
        $user_id = $this->input->post('user_id');
        $search = $this->input->post('search');
        $experience = $this->input->post('experience');
        $qulalifcation = $this->input->post('qulalifcation');
        
        $key = $this->CommonModel->getAllResumeFilter($user_id,$category_id, $sub_category_id,$sub_sub_category_id,$search,$qulalifcation,$experience);
        
        // print_r($key);die;
        
        if ($key) {
            $k = 0;
            for ($i=0; $i < count($key); $i++) { 
                
                if ($key[$i]['job_status'] == '1') {
                    $status = "<span class = 'btn btn-success remove_effect' >Accepted by recuriter</span>";
                }else if ($key[$i]['job_status'] == '2') {
                    $status = "<span class = 'btn btn-danger remove_effect' >Rejected by recuriter</span>";
                }else {
                    $status = "<span class = 'btn btn-primary remove_effect' >Pending</span>";
                }
                    
                if (!empty($key[$i]['resume_pdf'])) {
                    $pdfUrl = base_url('uploads/resume_pdf/'.$key[$i]['resume_pdf']);
                    $img = '<a  title="View PDF" target="_blank" href="'. $pdfUrl.'">Download PDF</a>';
                }else{
                    $img ='No Pdf';
                }
                
                $view_url = base_url().'admin/resume_detail/'.base64_encode($key[$i]['id']);
                
                $view = '<a href="'.$view_url.'">View</a>';
                
                
                $k = $k+1;
                $arr[] = array(
                    $k,
                    $key[$i]['categories_name'],
                    $key[$i]['subcategories_name'],
                    $key[$i]['subsubcategories_name'],
                    $key[$i]['full_name'],
                    $key[$i]['r_name'],
                    $key[$i]['subsubcategories_name'],
                    $key[$i]['organization_name'],
                    $key[$i]['total_experience'],
                    $key[$i]['degreename'],
                    $img,
                    $status,
                    $view
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
    
    
     public function user_resume_list()
    {
        $data['title'] = 'All User Resume List';
                

         $user_id = "";
         
         $data['getAllCategory'] = $this->CommonModel->selectResultData('categories','categories.id');
        $data['getAllDegree'] = $this->CommonModel->selectResultData('degree','degree.id');

        $data['getAllResumeList'] = $this->CommonModel->getAllUserResume($user_id);
         $this->loadAdminView('admin/resume/user_resume_list',$data);
    }
    
    public function user_resume_detail()
    {
        $data['title'] = 'Resume Detail';
        
         $user_id = base64_decode($this->uri->segment(3));
        //  print_r($user_id);die;
        $data['getResumeDetail'] = $this->CommonModel->user_resume_detail($user_id);
        
        // $user_id = $data['getResumeDetail']->user_id; 
        $data['getuserExperience'] = $this->CommonModel->selectResultDataByCondition(array('user_id' => $user_id),'experience');
        
        //  print_r($data['getResumeDetail']);die;
        
         $data['getuserQualification'] = $this->CommonModel->userResumeQualification( $user_id);
// print_r($data['getuserQualification']);die;
        $this->loadAdminView('admin/resume/resume_detail',$data);
    }
    
    public function filterUserResume()
    {
        // print_r($_POST);die;
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $sub_sub_category_id = $this->input->post('sub_sub_category_id');
        $user_id = $this->input->post('user_id');
        $search = $this->input->post('search');
        $experience = $this->input->post('experience');
        $qulalifcation = $this->input->post('qulalifcation');
        
        $key = $this->CommonModel->getAllUserResumeFilter($user_id,$category_id, $sub_category_id,$sub_sub_category_id,$search,$qulalifcation,$experience);
        
        // print_r($key);die;
        
        if ($key) {
            $k = 0;
            for ($i=0; $i < count($key); $i++) { 
                
                // if ($key[$i]['job_status'] == '1') {
                //     $status = "<span class = 'btn btn-success remove_effect' >Accepted by recuriter</span>";
                // }else if ($key[$i]['job_status'] == '2') {
                //     $status = "<span class = 'btn btn-danger remove_effect' >Rejected by recuriter</span>";
                // }else {
                //     $status = "<span class = 'btn btn-primary remove_effect' >Pending</span>";
                // }
                    
                if (!empty($key[$i]['resume_pdf'])) {
                    $pdfUrl = base_url('uploads/resume_pdf/'.$key[$i]['resume_pdf']);
                    $img = '<a  title="View PDF" target="_blank" href="'. $pdfUrl.'">Download PDF</a>';
                }else{
                    $img ='No Pdf';
                }
                
                $view_url = base_url().'admin/user_resume_detail/'.base64_encode($key[$i]['user_id']);
                
                $view = '<a href="'.$view_url.'">View</a>';
                
                
                $k = $k+1;
                $arr[] = array(
                    $k,
                    $key[$i]['categories_name'],
                    $key[$i]['subcategories_name'],
                    $key[$i]['subsubcategories_name'],
                    $key[$i]['full_name'],
                    $key[$i]['subsubcategories_name'],
                    $key[$i]['total_experience'],
                    $key[$i]['degreename'],
                    $img,
                    $view
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
    
    public function generate_pdf(){
    //       $this->load->library('Pdf');
    // //   	$this->pdf->load_view('mypdf');
    //   	$this->pdf->load_view('admin/resume/view_resume_pdf');
    //   	$this->pdf->render();
    //   	$this->pdf->stream("User_resume.pdf", array("Attachment"=>0));
        
         error_reporting(1);
          $resume_id = base64_decode($this->uri->segment(4));
        //  print_r($resume_id);die;
        $data['getResumeDetail'] = $this->CommonModel->resume_detail($resume_id);
        
        $user_id = $data['getResumeDetail']->user_id; 
        $data['getuserExperience'] = $this->CommonModel->selectResultDataByCondition(array('user_id' => $user_id),'experience');
        $data['getuserQualification'] = $this->CommonModel->userResumeQualification( $user_id);
        
        //  $this->load->view('admin/resume/view_resume_pdf');
         $this->load->view('admin/resume/view_resume_pdf', $data);
        // die;

        // Get output html
        $html = $this->output->get_output();
        
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        ob_end_clean();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
  	
    }
    
    public function user_generate_pdf(){
         error_reporting(1);
          $resume_id = base64_decode($this->uri->segment(4));
        //  print_r($resume_id);die;
        $data['getResumeDetail'] = $this->CommonModel->resume_detail($resume_id);
        
        $user_id = $data['getResumeDetail']->user_id; 
        $data['getuserExperience'] = $this->CommonModel->selectResultDataByCondition(array('user_id' => $user_id),'experience');
        $data['getuserQualification'] = $this->CommonModel->userResumeQualification( $user_id);
        
        //  $this->load->view('admin/resume/view_resume_pdf');
         $this->load->view('admin/resume/view_user_resume_pdf', $data);
        
        // Get output html
        $html = $this->output->get_output();
        
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        ob_end_clean();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
  	
    }
    

}