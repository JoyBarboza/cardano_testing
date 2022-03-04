<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class HomeController extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->language( 'english' );
		$this->form_validation->set_error_delimiters('', '');
	}


    public function langauge_list_get()
    {
        $condition = array(
            "status"        =>  '1',
        );

        $country = $this->CommonModel->selectResultDataByCondition($condition,'language');


        if ($country) 
        {
            $msg = 'All language List';

            foreach ($country as $key => $value) 
            {

                $dataText[] = array(
                    'id'             =>  $this->check_value($value->id),
                    'language_name'   =>  $this->check_value($value->name),
                    'is_active'      =>  $this->check_value($value->status),
                );
            }
        }
        else
        {
            $dataText = array();
            $msg = 'No language Found';
            // $msg = 'Comming Soon';

        }

        $arr['language'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'    => 'data found.',
            'message'   => $msg,
            'object'    => $arr
        ));
    }
	
    public function country_list_get()
    {
        $condition = array(
            "is_active"        =>  '1',
        );

        $country = $this->CommonModel->selectResultDataByCondition($condition,'country');


        if ($country) 
        {
            $msg = 'All Country List';

            foreach ($country as $key => $value) 
            {

                $dataText[] = array(
                    'id'             =>  $this->check_value($value->id),
                    'country_name'   =>  $this->check_value($value->country_name),
                    'is_active'      =>  $this->check_value($value->is_active),
                );
            }
        }
        else
        {
            $dataText = array();
            $msg = 'No Country Found';
            // $msg = 'Comming Soon';

        }

        $arr['country'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'    => 'data found.',
            'message'   => $msg,
            'object'    => $arr
        ));
    }

    public function state_list_post()
    {
        
        $this->form_validation->set_rules('country_id', 'Country id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));
            
        }
        
        $country_id = $this->input->post('country_id');

        $condition = array(
            "is_active"        =>  '1',
            "country_id" => $country_id

        );

        // $state_list = $this->CommonModel->selectResultDataByCondition($condition,'states');

        $state_list = $this->CommonModel->getStateList($country_id);


        if ($state_list) 
        {
            $msg = 'All State List';

            foreach ($state_list as $key => $value) 
            {
               
                $dataText[] = array(
                    'id'             =>  $this->check_value($value['id']),
                    'state_name'     =>  $this->check_value($value['state_name']),
                    'country_id'     =>  $this->check_value($value['country_id']),
                    'is_active'      =>  $this->check_value($value['is_active']),
                );
            }
        }
        else
        {
            $dataText = array();
            $msg = 'No State Found';
            // $msg = 'Comming Soon';

        }

        $arr['state'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message'   => $msg,
            'object'    => $arr
        ));
    }
    
    public function city_list_post()
    {
        
        $this->form_validation->set_rules('state_id', 'State id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));
            
        }
        
        $state_id = $this->input->post('state_id');

        // $condition = array(
        //     "is_active"        =>  '1',
        //     "state_id" => $state_id

        // );

        // $city_list = $this->CommonModel->selectResultDataByCondition($condition,'cities');

        $city_list = $this->CommonModel->getCityList($state_id);

        if ($city_list) 
        {
            $msg = 'All City List';

            foreach ($city_list as $key => $value) 
            {
               
                $dataText[] = array(
                    'id'            =>  $this->check_value($value['id']),
                    'city_name'     =>  $this->check_value($value['city_name']),
                    'state_id'      =>  $this->check_value($value['state_id']),
                    'is_active'     =>  $this->check_value($value['is_active']),
                );
            }
        }
        else
        {
            $dataText = array();
            $msg = 'No City Found';
            // $msg = 'Comming Soon';

        }

        $arr['city'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message'   => $msg,
            'object'    => $arr
        ));
    }
	
	public function category_get()
	{

        $condition = array(
                "is_active"        =>  '1',
                "deleted_at" => NULL

            );

        $category = $this->CommonModel->selectResultDataByCondition($condition,'categories');


        if ($category) 
        {
            $msg = 'All Category List';

            foreach ($category as $key => $value) 
            {
                // print_r($value->id);die;
                $image    =   base_url().'uploads/category/'.$value->image;

                $dataText[] = array(
                    'id'             =>  $this->check_value($value->id),
                    'image'   =>  $this->check_value($image),
                    'name'           =>  $this->check_value($value->name),
                    'other_language_name'          =>  $this->check_value($value->other_language_name),
                    'is_active'            =>  $this->check_value($value->is_active),
                    'created_at'       =>  $this->check_value($value->created_at),
                    'updated_at'       =>  $this->check_value($value->updated_at),
                    'deleted_at'      =>  $this->check_value($value->deleted_at),
                );
            }
        }
        else
        {
            $dataText = array();
            // $msg = 'No Category Found';
            $msg = 'Coming Soon';

        }

        $arr['category'] = $dataText;


	    return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			// 'message' 	=> 'data found.',
			'message' 	=> $msg,
		   	'object'	=> $arr
		));
	}
	
    public function nationality_get()
	{
	    
        $condition = array(
                "is_active"        =>  '1',
                // "deleted_at" => NULL
        );

        $nationality = $this->CommonModel->selectResultDataByCondition($condition,'nationality');

        if ($nationality) 
        {
            // $dataText[0] = array("Choose City");


            $dataText[0] = array(
                    'id'                    =>   0,
                    'name'                  =>  'Select Nationality eg :Indian (Select Nationality)',
                    'other_language_name'   =>  'Select Nationality eg :Indian (Select Nationality)',
                    // 'is_active'            =>  $this->check_value($value->is_active),
                    "created_at"    =>  date('Y-m-d H:i:s a'),
                    "updated_at"    =>  date('Y-m-d H:i:s a'),
                    // 'deleted_at'      =>  $this->check_value($value->deleted_at),
                );

            $msg = 'All nationality List';

            foreach ($nationality as $key => $value) 
            {
                
                $dataText[] = array(
                    'id'             =>  $this->check_value($value->id),
                    'name'           =>  $this->check_value($value->name),
                    'other_language_name'          =>  $this->check_value($value->other_language_name),
                    // 'is_active'            =>  $this->check_value($value->is_active),
                    'created_at'       =>  $this->check_value($value->created_at),
                    'updated_at'       =>  $this->check_value($value->updated_at),
                    // 'deleted_at'      =>  $this->check_value($value->deleted_at),
                );
            }
        }
        else
        {
            $dataText = array();
            // $msg = 'No Nationality Found';
            $msg = 'Coming Soon';

        }

        $arr['nationality'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message' 	=> $msg,
            'object'    => $arr
        ));
	}
	
    public function sub_category_post()
	{
	    
	    $this->form_validation->set_rules('category_id', 'category id', 'required');
	    
        if ($this->form_validation->run() == FALSE)
        {
        	return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> validation_errors(),
				'object'	=> new stdClass()
			));
            
        }
        
        $category_id = $this->input->post('category_id');

        $condition = array(
            "is_active"        =>  '1',
            "deleted_at" => NULL,
            "category_id" => $category_id

        );

        $category = $this->CommonModel->selectResultDataByCondition($condition,'subcategories');


        if ($category) 
        {
            $msg = 'All subcategories List';

            foreach ($category as $key => $value) 
            {
                $image    =   base_url().'uploads/category/'.$value->image;

                
                $dataText[] = array(
                    'id'             =>  $this->check_value($value->id),
                    'category_id'           =>  $this->check_value($value->category_id),
                    'name'           =>  $this->check_value($value->name),
                    'description'           =>  $this->check_value($value->description),
                    'other_language_name'          =>  $this->check_value($value->other_language_name),
                    'other_language_description'          =>  $this->check_value($value->other_language_description),
                    'image'            =>  $this->check_value($image),
                    'is_active'            =>  $this->check_value($value->is_active),
                    'created_at'       =>  $this->check_value($value->created_at),
                    'updated_at'       =>  $this->check_value($value->updated_at),
                    'deleted_at'      =>  $this->check_value($value->deleted_at),
                );
            }
        }
        else
        {
            $dataText = array();
            // $msg = 'No subcategories Found';
            $msg = 'Coming Soon';

        }

        $arr['sub_category'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message' 	=> $msg,
            'object'    => $arr
        ));
	}
	
	public function sub_sub_category_post()
	{
	  
        $details = $this->input->post();
        
	   $this->form_validation->set_rules('user_id', 'User id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));            
        }
        $user = $this->CommonModel->selectRowDataByCondition(array('id' => $details['user_id']),'users');
        
        if (empty($user)) {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_UNAUTHORIZED,
                'message'   => 'Wrong Token',
                'object'    => new stdClass()
            ));
        }



        if($user->status == 0)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => $this->lang->line('you_deactived_by_admin'),
                'object'    => new stdClass()
            )); 
        }
        
        if(!empty($user->deleted_at))
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => $this->lang->line('you_deleted_by_admin'),
                'object'    => new stdClass()
            )); 
        }


        $this->form_validation->set_rules('subcategory_id', 'subcategory id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));
            
        }
        
        $subcategory_id = $this->input->post('subcategory_id');
        $user_id = $this->input->post('user_id');

        //  $condition = array(
        //     "is_active"        =>  '1',
        //     // "deleted_at" => NULL,
        //     "subcategory_id" => $subcategory_id

        // );

        // $category = $this->CommonModel->selectResultDataByCondition($condition,'sub_subcategory');
        $subsubcategory = $this->CommonModel->getSubSubCategoryList($subcategory_id);

// print_r($subsubcategory);die;
        if ($subsubcategory) 
        {
            $msg = 'All subsubcategories List';

            foreach ($subsubcategory as $key => $value) 
            {
                $image    =   base_url().'uploads/category/'.$value['image'];

                $where = array(
                        // "category_id"           => $value['category_id'],
                        // "subcategory_id"        => $value['subcategory_id'],
                        // "sub_subcategory_id"    => $value['id'],
                        "user_id"               => $user_id,
                    );

                $checkUserResume = $this->CommonModel->selectRowDataByCondition($where,'user_resume');

                if(!empty($checkUserResume)){
                    $resume_status = 1;
                }else{
                    $resume_status = 0;
                }
                
                $dataText[] = array(
                    'id'             =>  $this->check_value($value['id']),
                    'category_id'           =>  $this->check_value($value['category_id']),
                    'subcategory_id'           =>  $this->check_value($value['subcategory_id']),
                    'name'           =>  $this->check_value($value['name']),
                    'other_language_name'           =>  $this->check_value($value['other_language_name']),
                    'image'            =>  $this->check_value($image),
                    'is_active'            =>  $this->check_value($value['is_active']),
                    'created_at'       =>  $this->check_value($value['created_at']),
                    'updated_at'       =>  $this->check_value($value['updated_at']),
                    'resume_status'       =>  $resume_status,
                    // 'deleted_at'      =>  $this->check_value($value->deleted_at),
                );
            }
        }
        else
        {
            $dataText = array();
            // $msg = 'No subsubcategories Found';
            $msg = 'Coming Soon';

        }

        $arr['sub_sub_category'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message' 	=> $msg,
            'object'    => $arr
        ));
	    
	}	
	
	public function sub_sub_sub_category_post()
	{
	    //echo 1;die;
	    
	    $details = $this->input->post();
        
	   $this->form_validation->set_rules('user_id', 'User id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));            
        }
        $user = $this->CommonModel->selectRowDataByCondition(array('id' => $details['user_id']),'users');
        
        if (empty($user)) {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_UNAUTHORIZED,
                'message'   => 'Wrong Token',
                'object'    => new stdClass()
            ));
        }



        if($user->status == 0)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => $this->lang->line('you_deactived_by_admin'),
                'object'    => new stdClass()
            )); 
        }
        
        if(!empty($user->deleted_at))
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => $this->lang->line('you_deleted_by_admin'),
                'object'    => new stdClass()
            )); 
        }


        $this->form_validation->set_rules('subsubcategory_id', 'subsubcategory id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'    => REST_Controller::HTTP_BAD_REQUEST,
                'message'   => validation_errors(),
                'object'    => new stdClass()
            ));
            
        }
        
        $subsubcategory_id = $this->input->post('subsubcategory_id');
        $user_id = $this->input->post('user_id');
        
         $subsubsubcategory = $this->CommonModel->getSubSubSubCategoryList($subsubcategory_id);

// print_r($subsubsubcategory);die;
        if ($subsubsubcategory) 
        {
            $msg = 'All subsubcategories List';

            foreach ($subsubsubcategory as $key => $value) 
            {
                $image    =   base_url().'uploads/category/'.$value['image'];

                 $where = array(
                        "category_id"           => $value['category_id'],
                        "subcategory_id"        => $value['sub_category_id'],
                        "sub_subcategory_id"    => $value['sub_subcategory_id'],
                        "user_id"               => $user_id,
                    );
                 
                $checkUserResume = $this->CommonModel->selectRowDataByCondition($where,'user_resume');

                if(!empty($checkUserResume)){
                    $resume_status = 1;
                }else{
                    $resume_status = 0;
                }
                
                $dataText[] = array(
                    'id'             =>  $this->check_value($value['id']),
                    // 'category_id'           =>  $this->check_value($value['category_id']),
                    'sub_subcategory_id'           =>  $this->check_value($value['sub_subcategory_id']),
                    'name'           =>  $this->check_value($value['name']),
                    'other_language_name'           =>  $this->check_value($value['other_language_name']),
                    'image'            =>  $this->check_value($image),
                    'is_active'            =>  $this->check_value($value['is_active']),
                    'created_at'       =>  $this->check_value($value['created_at']),
                    'updated_at'       =>  $this->check_value($value['updated_at']),
                    'resume_status'       =>  $resume_status,
                    // 'deleted_at'      =>  $this->check_value($value->deleted_at),
                );
            }
        }
        else
        {
            $dataText = array();
            // $msg = 'No subsubcategories Found';
            $msg = 'Comming Soon';

        }

        $arr['sub_sub_category'] = $dataText;


        return $this->response(array(
            'status'    => REST_Controller::HTTP_OK,
            // 'message'   => 'data found.',
            'message' 	=> $msg,
            'object'    => $arr
        ));
	}
	public function empjob_post()
	{
        $this->form_validation->set_rules('subcategory_id', 'subcategory id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        $this->form_validation->set_rules('sub_subcategory_id', 'sub_subcategory id', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $subcategory_id = $this->input->post('subcategory_id');
	    
	    $condition = array(
            "subcategory_id" => $subcategory_id,
            "post_status" => 0
        );

        $datatext['sub_sub_category'] = $this->CommonModel->select_joppost_data($subcategory_id);
       /* print_r($datatext['sub_sub_category']);
        die();*/
        if($datatext['sub_sub_category'])
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_OK,
                'message' 	=> 'data found.',
                'object'	=> $datatext
            ));
            
        }
        else
        {
             return $this->response(array(
                'status'	=> REST_Controller::HTTP_OK,
                // 'message' 	=> 'data not found.',
                'message' => 'Comming Soon',
                'object'	=> $datatext
            ));
        }
         
	    
	}
	
// 	public function contact_us_post()
// 	{
	    
//         $this->form_validation->set_rules('user_id', 'user id', 'required');
        
//         if ($this->form_validation->run() == FALSE)
//         {
//             return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_BAD_REQUEST,
//                 'message' 	=> validation_errors(),
//                 'object'	=> new stdClass()
//             ));
        
//         }
//          $this->form_validation->set_rules('full_name', 'full name', 'required');
        
//         if ($this->form_validation->run() == FALSE)
//         {
//             return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_BAD_REQUEST,
//                 'message' 	=> validation_errors(),
//                 'object'	=> new stdClass()
//             ));
        
//         }
        
//         $this->form_validation->set_rules('email', 'email', 'required');
        
//         if ($this->form_validation->run() == FALSE)
//         {
//             return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_BAD_REQUEST,
//                 'message' 	=> validation_errors(),
//                 'object'	=> new stdClass()
//             ));
        
//         }
        
//         $this->form_validation->set_rules('message', 'message', 'required');
        
//         if ($this->form_validation->run() == FALSE)
//         {
//             return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_BAD_REQUEST,
//                 'message' 	=> validation_errors(),
//                 'object'	=> new stdClass()
//             ));
        
//         }
        
//         $user_id = $this->input->post('user_id');
//         $full_name = $this->input->post('full_name');
//         $email = $this->input->post('email');
//         $message = $this->input->post('message');
       

//         $datatext['sub_sub_category'] = $this->CommonModel->selectResultDataByCondition($condition,'jobpost');
//       /* print_r($datatext['sub_sub_category']);
//         die();*/
//         if($datatext['sub_sub_category'])
//         {
//             return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_OK,
//                 'message' 	=> 'data found.',
//                 'object'	=> $datatext
//             ));
            
//         }
//         else
//         {
//              return $this->response(array(
//                 'status'	=> REST_Controller::HTTP_OK,
//                 'message' 	=> 'data not found.',
//                 'object'	=> $datatext
//             ));
//         }
         
	    
// 	}
	
	public function job_accept_ignore_post()
	{
        $this->form_validation->set_rules('jobpost_id', 'jobpost id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('type', 'type', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
            ));
        
        }
        
        $type = $this->input->post('type');
        $jobpost_id = $this->input->post('jobpost_id');
        
        
        if($type == '1')
        {
        
            $condition = array(
            "id" => $jobpost_id
        
        );
        
        $data = array(
        "post_status" => $type
        );
        
        $table = 'jobpost';
        
        $this->CommonModel->updateRowByCondition($condition,$table, $data);
        
        
        $datatext['sub_sub_category'] = $this->CommonModel->selectResultDataByCondition($condition,'jobpost');
        return $this->response(array(
        'status'	=> REST_Controller::HTTP_OK,
        'message' 	=> 'Job accept'
        ));
        
        }
        if($type == '2')
        {
        
        $condition = array(
        "id" => $jobpost_id
        
        
        );
        
        $data = array(
        "post_status" => $type
        );
        
        $table = 'jobpost';
        
        $this->CommonModel->updateRowByCondition($condition,$table, $data);
        
        
        $datatext['sub_sub_category'] = $this->CommonModel->selectResultDataByCondition($condition,'jobpost');
        return $this->response(array(
        'status'	=> REST_Controller::HTTP_OK,
        'message' 	=> 'job ignore.'
        ));
        
        }
        
     }
     
     public function resume_post()
     {
         
        $this->form_validation->set_rules('sub_subcategory_id', 'subcategory id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
         $this->form_validation->set_rules('user_id', 'subcategory id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
            ));
        
        }
        
        
        $this->form_validation->set_rules('email', 'email', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
        
        
        $this->form_validation->set_rules('phone', 'pone', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
        
        
        $this->form_validation->set_rules('gender', 'gender', 'required');
        if ($this->form_validation->run() == FALSE)
        {
        return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
        $this->form_validation->set_rules('education', 'Education', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('experience_month', 'Experience', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('experience_year', 'Experience', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('degree_id', 'Degree id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('university_id', 'university id', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('age', 'age', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
         $this->form_validation->set_rules('language', 'language', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('nationality', 'nationality', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
        
        
        $this->form_validation->set_rules('address', 'address', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_BAD_REQUEST,
            'message' 	=> validation_errors(),
            'object'	=> new stdClass()
        ));
        
        }
        $this->form_validation->set_rules('city', 'city', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
        $this->form_validation->set_rules('country', 'country', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
        
         $this->form_validation->set_rules('state', 'state', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
         $this->form_validation->set_rules('pincode', 'pincode', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->response(array(
                'status'	=> REST_Controller::HTTP_BAD_REQUEST,
                'message' 	=> validation_errors(),
                'object'	=> new stdClass()
            ));
        
        }
       
        
        $sub_subcategory_id = $this->input->post('sub_subcategory_id');
        $user_id = $this->input->post('user_id');
        $full_name = $this->input->post('full_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $gender = $this->input->post('gender');
        
        
        $education = $this->input->post('education');
        $degree_id = $this->input->post('degree_id');
        $experience_month = $this->input->post('experience_month');
        $experience_year = $this->input->post('experience_year');
        $degree_id = $this->input->post('degree_id');
        $university_id = $this->input->post('university_id');
        $age = $this->input->post('age');
        $language = $this->input->post('language');
        $nationality = $this->input->post('nationality');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $country = $this->input->post('country');
        $address = $this->input->post('address');
        $pincode = $this->input->post('pincode');
        
        $table = "resume";
        $data = array(
                    "sub_subcategory_id" => $sub_subcategory_id,
                    "user_id" => $user_id,
                    "full_name" => $full_name,
                    "email" => $email,
                    "phone" => $phone,
                    "gender" => $gender,
                    "education" => $education,
                    "degree_id" => $degree_id,
                    "experience_month" => $experience_month,
                    "experience_year" => $experience_year,
                    "university_id" => $university_id,
                    "degree_id" => $degree_id,
                    "age" => $age,
                    "language" => $language,
                    "nationality" => $nationality,
                    "state" => $state,
                    "city" => $city,
                    "country" => $country,
                    "address" => $address,
                    "pincode" => $pincode,
         );
        
        
        $datatext['resume'] = $this->CommonModel->insertData($data,$table);
        
        if($datatext['resume'])
        {
            return $this->response(array(
            'status'	=> REST_Controller::HTTP_OK,
            'message' 	=> 'insert successfully.'
            ));
        }
        else
        {
                return $this->response(array(
                'status'	=> REST_Controller::HTTP_OK,
                'message' 	=> 'not insert successfully.'
                ));
            
            
        }
        
         
     }
     
    
     
     
	
	public function cms_url_get()
    {
    	$dataText['about_us'] = base_url().'about_us';
    	$dataText['term_and_condition'] = base_url().'term_and_condition';
    	$dataText['privacy_policy'] = base_url().'privacy_policy';
    	
    	return $this->response(array(
			'status'	=> REST_Controller::HTTP_OK,
			'message' 	=> 'CMS Data.',
		   	'object'	=> $dataText
		));
    }
    
    public function term_and_condition_get()
    {
    	 $condition = array(
            "id" => 3
        );

        $term_and_condition = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
		if ($term_and_condition == FALSE) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'No Term & Condition.'
			));
		}else{

// 			$dataText['title'] 		= $term_and_condition->title;
// 			$dataText['description'] 	= $term_and_condition->description;
            
            $dataText 		= $term_and_condition->title;
			$dataText 	= $term_and_condition->description;
			
	      	return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'Term & Condition.',
			   	'object'	=> $dataText
			));
		}
    }
    
    public function about_us_get()
    {
    	$condition = array(
            "id" => 1
        );

        $aboutData = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
		if ($aboutData == FALSE) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'No about us data.'
			));
		}else{
			// print_r($about[0]);exit;
// 			$dataText['title'] 		= $aboutData->title;
// 			$dataText['description'] 	= $aboutData->description;  

            $dataText 		= $aboutData->title;
			$dataText 	= $aboutData->description;
			
	      	return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'About us.',
			   	'object'	=> $dataText
			));
		}
    }
    
    public function privacy_policy_get()
    {
    	$condition = array(
            "id" => 2
        );

        $privacyData = $this->CommonModel->selectRowDataByCondition($condition,'cms'); 
        
		if ($privacyData == FALSE) {
			return $this->response(array(
				'status'	=> REST_Controller::HTTP_BAD_REQUEST,
				'message' 	=> 'No about us data.'
			));
		}else{
			// print_r($about[0]);exit;
// 			$dataText['title'] 		= $privacyData->title;
// 			$dataText['description'] 	= $privacyData->description;
            
            $dataText 		= $privacyData->title;
			$dataText 	= $privacyData->description;
			
	      	return $this->response(array(
				'status'	=> REST_Controller::HTTP_OK,
				'message' 	=> 'Privacy Policy.',
			   	'object'	=> $dataText
			));
		}
    }
    
}