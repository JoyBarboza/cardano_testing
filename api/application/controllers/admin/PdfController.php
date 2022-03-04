<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class PdfController extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        // $this->common->check_adminlogin();
         $this->load->library('pdf');

	}
    //show about us
    function viewPdf()
    {

        // echo 1;die;
        $resume_id = '18';

        $dataa['resume_data'] = $this->CommonModel->getResumeDetail($resume_id);


         $imageWhere = array(
            "resume_id" => $resume_id
        );
        
        $dataa['imageData'] = $this->CommonModel->selectResultDataByCondition($imageWhere,'degree_image');


        // $this->pdf->load_view('mypdf',$dataa);
        // $this->pdf->render();
        // $this->pdf->stream("welcome.pdf",array("Attachment"=>0));
    
         
return $value = $this->load->view('mypdf',$dataa);
     
//         $apikey = 'a10be8ae-e3c3-411a-9ad9-b5d57b72901e';
//         $result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" . urlencode($value));
//         $myfile = 'Resume_'.date('Y-m-d').time().'.pdf';
//         $Pdfcontent = file_put_contents('./uploads/resume_pdf/'.$myfile, $result);
           
    }
}