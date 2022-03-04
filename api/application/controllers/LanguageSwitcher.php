<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LanguageSwitcher extends CI_Controller
{
    public function __construct() {
        parent::__construct();     
    }
 
  //   function switchLang($language = "") 
  //   {
		
  //       $language = ($language != "") ? $language : "english";
		// // print_r($language);die;        
  //       $this->session->set_userdata('site_lang', $language);
        
  //       redirect($_SERVER['HTTP_REFERER']);
        
  //   }


    function switchLang($language = "") 
    {
        $lang = $this->input->post('lang');
        $language = ($lang != "") ? $lang : "english";
        
        if($language) {

            $this->session->set_userdata('site_lang', $language);
             echo "1";
        }else{
            echo "0";
        }
        
    }
}