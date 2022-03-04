<?php
class CommonModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library( 'Utility' );
	}

	//fetch all data api
	public function selectResultData($table,$fieldName)
	{
		$this->db->select('*')
		->from($table);
		$this->db->order_by($fieldName, "desc");
		return $this->db->get()->result_array();
	}

	//select all data asc
	public function selectAllResultData($table)
	{
		$this->db->select('*')
		->from($table);
		return $this->db->get()->result_array();
	}

	public function countData($table)
	{
		return $this->db->count_all_results($table);
	}

	public function countDataWithCondition($table,$condition)
	{
		return $this->db->where($condition)->from($table)->count_all_results();
	}
	public function totalColumnSumWithCondition($table,$condition,$param)
	{
		$this->db->select('SUM('.$param.') as rate');
        $this->db->from($table);
        $result = $this->db->get()->row();
        // return $this->db->last_query();
        return $result;
	}

	//check condition api
	public function selectRowDataByCondition($condition,$table)
	{
		$this->db->select('*')
		->from($table);
		$this->db->where($condition);
		return $this->db->get()->row();
	}
	
	
	
	//check condition api
	public function selectRowDataByCondition_resume($condition,$table)
	{
		$this->db->select('*')
		->from($table);
		$this->db->where($condition);
		return $this->db->get()->result_array();
	}
	//check condition api
	public function selectRowDataByConditionAndFieldName($condition,$table,$fieldName)
	{
		$this->db->select('*')
		->from($table);
		$this->db->where($condition);
		$this->db->order_by($fieldName, "desc")->limit(1);
		return $this->db->get()->row();
	}
	
	//get all data with where condition api
	public function selectResultDataByCondition($condition,$table)
	{
		$this->db->select('*')
		->from($table);
		$this->db->where($condition);
		return $this->db->get()->result();
	}

	public function selectResultDataByCondition1($condition,$table)
	{
		// print_r($condition);
		$this->db->select('*')
		->from($table);
		$this->db->where($condition);
		$data = $this->db->get();
		// print_r($data);
		if (!empty($data->result_array())) {
			return $data->result_array();
		}
	}
	
	//get all data with where condition api
	public function selectResultDataByConditionAndFieldName($condition,$table,$fieldName)
	{
		$this->db->select('*')
		->from($table);
		$this->db->order_by($fieldName, "desc");
		$this->db->where($condition);
		return $this->db->get()->result_array();
	}

	//insert api
	public function insertData($data,$table)
	{
		$result = $this->db->insert($table, $data);
		
		if( $result != FALSE )
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		} 	
	}

	//update condition api
	public function updateRowByCondition($condition,$table,$data)
	{  
		//echo $this->email->print_debugger();
		return $this->db->update($table, $data , $condition);
	}
	//update condition api
	public function updateRow($table,$data)
	{  
		//echo $this->email->print_debugger();
		return $this->db->update($table, $data);
	}

	public function update_entry($table,$data,$where)
	{
	    $this->db->where($where);
	    $query = $this->db->update($table,$data);
	    return $this->db->affected_rows();
	}
	
   public function sendMail1($data)
   {
   	// print_r($data);exit;
   	    $this->email->initialize(array(
			'protocol' 	=> 'smtp',
			'smtp_host' => 'smtp.sendgrid.net',
			'smtp_user' => 'neeteshagrawal',
			'smtp_pass' => 'neetesh@12345',
			'smtp_port' => 587,
			'crlf' 		=> "\r\n",
			'mailtype' 	=> "html",
			'charset' 	=> "iso-8859-1",
			'newline' 	=> "\r\n"
		));

		$this->email->from('info@pueodj.com', 'Pueo Dj');
		$this->email->to($data['to']);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		$this->email->subject($data['subject']);
		$this->email->message($data['message']);
		if($this->email->send())
		{
			return 1;
		}else{
			return 0;
		}
   	}


   	public function sendMail($to,$subject,$message,$options = array())
    {
    	// print_r($to);die;
        $this->load->library('email');
        $config = array (
		        'mailtype' => 'html',
		        'charset'  => 'utf-8',
		        'priority' => '1'
	      	);

        $this->email->initialize($config);
		if (isset($options['fromEmail']) && isset($options['fromName'])) 
		{
			$this->email->from($options['fromEmail'], $options['fromName']);  
		}
		else
		{
			$this->email->from('info@sliceledger.com', 'DJ');         
        }

		$this->email->to($to);

		if(isset($options['replyToEmail']) && isset($options['replyToName']))
		{
			$this->email->reply_to($options['replyToEmail'],$options['replyToName']);
		}

	    $this->email->subject($subject);
	    $this->email->message($message);

     // echo $message;die();

        if($this->email->send())
        {
            return true;
        }else
        {
            return false;
        }
    } 
	//delete api
	public function delete($condition,$table)
	{
		$this->db->where($condition);
		return $this->db->delete($table);
	}

    public function getsingle($table,$where)
     {
        $this->db->where($where);
        $data = $this->db->get($table);
        $get = $data->row();
         
        $num = $data->num_rows();
        
        if($num)
        {
          return $get;
        }
        else
        {
          return false;
        }
    }
    public function select_single_row($sql)
    {
        $res= $this->db->query($sql);
        return $res->row();
    }
    
   //  public function adminData($data)
   //  {
   //  // 	print_r($data);die;
   
   //      $this->db->select("*")->from('admin')->where(array(
   //                          'password' 		 	=> md5($data['password']),
   //                          'orginal_password' 	=> $data['password'],
   //                          'email' 			=> $data['password'],
   //                      ));
                        
		 // // $where = '(email="'.$data['email_mobile'].'" or mobile_number = "'.$data['email_mobile'].'")';
		 
   //        return  $this->db->where($where)->get()->row();
   //  }
	
	public function select_joppost_data($subcategory_id)
	{
      $this->db->select('jobpost.*,degree.name as degree_name')
        ->from('jobpost')
        ->join('degree','degree.id = jobpost.degree_id','left')
        ->where(array("jobpost.subcategory_id" => $subcategory_id,"jobpost.post_status" => 0,"jobpost.recreuter_job_status" => 2));
        
       
        return $this->db->get()->result_array();

	}
	
	public function getAllJobPost($user_id,$job_type){
	   if($job_type == 1){
	       $job_type = 2;
	   }else{
	       $job_type = 1;
	   }
	    
	    $this->db->select('jobpost.*,degree.name as degree_name,subcategories.name as subcategories_name,subcategories.other_language_name as subcategories_other_name,jobpost.degree_name as jb_degree_name,degree.type as degree_type')
        ->from('jobpost')
        ->join('degree','degree.id = jobpost.degree_id','left')
        ->join('subcategories','subcategories.id = jobpost.subcategory_id','left')
        ->where(array(
            "jobpost.post_status" => 0,
            "jobpost.recreuter_job_status" => $job_type,
            "jobpost.user_type" => 2,
            "jobpost.user_id" => $user_id)
        )
        // ->group_by('jobpost.subcategory_id')
        ->order_by("jobpost.id", "desc");
        
       
        return $this->db->get()->result_array();
	    
	} 
	
	public function getSubCategory($category_id)
	{
		$this->db->select('subcategories.*,categories.name as categories_name')
        ->from('subcategories')
        ->join('categories','categories.id = subcategories.category_id','left');

        if(!empty($category_id)){
        	$this->db->where(array("subcategories.category_id" => $category_id));	
        }
        return $this->db->get()->result_array();  
	}
   
    public function getSubSubCategory($subcategory_id)
	{

		$this->db->select('sub_subcategory.*,categories.name as categories_name,subcategories.name as subcategories_name')
        ->from('sub_subcategory')
        ->join('subcategories','subcategories.id = sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left');

        if(!empty($subcategory_id)){
        	$this->db->where(array("sub_subcategory.subcategory_id" => $subcategory_id));	
        }

        return $this->db->get()->result_array();  
	}
   

	public function getSubCatgoryDetail($subcategory_id)
	{

		$this->db->select('subcategories.*,categories.name as categories_name,categories.other_language_name as categories_other_name')
        ->from('subcategories')
        // ->join('subcategories','subcategories.id = sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left');

        if(!empty($subcategory_id)){
        	$this->db->where(array("subcategories.id" => $subcategory_id));	
        }

        return $this->db->get()->row();  
	}

	public function getSubSubCatgoryDetail($subcategory_id)
	{

		$this->db->select('sub_subcategory.*,categories.name as categories_name,categories.other_language_name as categories_other_name ,subcategories.name as subcategories_name,subcategories.other_language_name as subcategories_other_name')
        ->from('sub_subcategory')
        ->join('subcategories','subcategories.id = sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left');

        if(!empty($subcategory_id)){
        	$this->db->where(array("sub_subcategory.id" => $subcategory_id));	
        }

        return $this->db->get()->row();  
	}
	
	
	// public function selectJobListNotApply($subcategory_id,$sub_subcategory_id,$user_id)
	public function selectJobListNotApply($user_id,$subcategory_id,$sub_subcategory_id)
	{
        // $query = 'SELECT jobpost.*,degree.name as degree_name FROM jobpost LEFT JOIN degree ON degree.id = jobpost.degree_id WHERE NOT EXISTS (SELECT user_job_list.job_id,user_job_list.user_id,user_job_list.job_status FROM user_job_list WHERE user_job_list.job_id = jobpost.id AND user_job_list.user_id = '.$user_id.') AND jobpost.subcategory_id='.$subcategory_id.' AND jobpost.sub_subcategory_id='.$sub_subcategory_id.' AND jobpost.recreuter_job_status = 2 ORDER BY jobpost.id DESC';
        
        if($subcategory_id == '' || $sub_subcategory_id == '')
        {
            $query = 'SELECT jobpost.*,degree.name as degree_name,subcategories.name as subcategory_name,sub_subcategory.name as sub_subcategory_name,jobpost.degree_name as jb_degree_name,degree.type as degree_type  FROM jobpost LEFT JOIN degree ON degree.id = jobpost.degree_id LEFT JOIN subcategories ON subcategories.id = jobpost.subcategory_id LEFT JOIN sub_subcategory ON sub_subcategory.id = jobpost.sub_subcategory_id WHERE NOT EXISTS (SELECT user_job_list.job_id,user_job_list.user_id,user_job_list.job_status FROM user_job_list WHERE user_job_list.job_id = jobpost.id AND user_job_list.user_id = '.$user_id.') AND jobpost.recreuter_job_status = 2 ORDER BY jobpost.id DESC';
            
        }else{
            $query = 'SELECT jobpost.*,degree.name as degree_name,subcategories.name as subcategory_name,sub_subcategory.name as sub_subcategory_name,jobpost.degree_name as jb_degree_name,degree.type as degree_type FROM jobpost LEFT JOIN degree ON degree.id = jobpost.degree_id LEFT JOIN subcategories ON subcategories.id = jobpost.subcategory_id LEFT JOIN sub_subcategory ON sub_subcategory.id = jobpost.sub_subcategory_id WHERE NOT EXISTS (SELECT user_job_list.job_id,user_job_list.user_id,user_job_list.job_status FROM user_job_list WHERE user_job_list.job_id = jobpost.id AND user_job_list.user_id = '.$user_id.')  AND jobpost.subcategory_id='.$subcategory_id.' AND jobpost.sub_subcategory_id='.$sub_subcategory_id.' AND jobpost.recreuter_job_status = 2 ORDER BY jobpost.id DESC';
        }
        
        
        // print_r($query);die;
        $query = $this->db->query($query);

		return $query->result_array();

	}



    public function getApplyJobList($user_id)
	{
	   // $this->db->select('resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,jobpost.organization_name,jobpost.job_title,jobpost.selection_job_id,jobpost.country_id,jobpost.state_id,jobpost.city_id')
    //     ->from('resum')
    //     ->join(' jobpost',' jobpost.id = resume.job_id','left')
    //     ->join('nationality','nationality.id = resume.nationality','left')
    //     ->join('degree','degree.id = resume.degree_id','left')
    //     ->join('university','university.id = resume.university_id','left')
    //     ->join('users','users.id = resume.recuriter_id','left')
    //     ->join('sub_subcategory','sub_subcategory.id = resume.sub_subcategory_id','left')
    //     ->where(array("resume.user_id" => $user_id));
        
        
        $this->db->select('user_job_list.*,jobpost.job_title,jobpost.selection_job_id,jobpost.country_id,jobpost.state_id,jobpost.city_id,users.name,users.profile_img,user_resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,nationality.name as nationality_name,jobpost.organization_name,jobpost.salary_from,jobpost.salary_to,jobpost.contact_person_name,jobpost.contact_number,jobpost.experience,degree.name as degree_name,jobpost.degree_name as jb_degree_name ')
        ->from('user_job_list')
        ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
        // ->join('user_resume',' user_resume.id = user_job_list.job_id','left')
        // ->join('user_resume',' user_resume.id = user_job_list.job_id','left')
        ->join('user_resume',' user_resume.user_id = user_job_list.user_id','left')
        ->join('nationality','nationality.id = user_resume.nationality','left')
        ->join('degree','degree.id = jobpost.degree_id','left')
        // ->join('degree','degree.id = jobpost.degree_id','left')
        // ->join('university','university.id = jobpost.university_id','left')
        ->join('users','users.id = user_job_list.recuriter_id','left')
        ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
        ->where(array("user_job_list.user_id" => $user_id));
        
        return $this->db->get()->result_array();  
	}

 //    public function getAllResumeList($user_id,$type)
	// {
	//     $this->db->select('resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,jobpost.organization_name,jobpost.job_title')
 //        ->from('resume')
 //        ->join(' jobpost',' jobpost.id = resume.job_id','left')
 //        ->join('nationality','nationality.id = resume.nationality','left')
 //        ->join('degree','degree.id = resume.degree_id','left')
 //        ->join('university','university.id = resume.university_id','left')
 //        ->join('users','users.id = resume.recuriter_id','left')
 //        ->join('sub_subcategory','sub_subcategory.id = resume.sub_subcategory_id','left')
 //        ->where(array("resume.recuriter_id" => $user_id))
 //        ->order_by("resume.id", "desc");
        
 //        if($type == 2)
 //        {
 //            $this->db->where(array("resume.resume_status" => 1));
 //        }else{
 //        	$where = '(resume.resume_status= 0 or resume.resume_status= 2)';
	//          $this->db->where($where);

 //        }
        
 //        return $this->db->get()->result_array();  
	// }

	public function getAllResumeList($user_id,$type,$word)
	// public function getAllResumeList($user_id,$type)
	{
		// print_r($user_id);die;

		// $query = 'SELECT * FROM parents_notification where (parents_id = 0 AND type = '.$type.') OR (parents_id = '.$parentId.' AND type != 2) ';

		// if($type == 2)
     //    {
     //        $this->db->where(array("resume.resume_status" => 1));
     //    }else{
     //    	$where = '(resume.resume_status= 0 or resume.resume_status= 2)';
	    //      $this->db->where($where);

     //    }

		    // $this->db->select('user_job_list.*,jobpost.job_title,jobpost.selection_job_id,jobpost.country_id,jobpost.state_id,jobpost.city_id,users.name,users.profile_img,user_resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,nationality.name as nationality_name,jobpost.organization_name')
      //   ->from('user_job_list')
      //   ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
      //   ->join('user_resume',' user_resume.id = user_job_list.job_id','left')
      //   ->join('nationality','nationality.id = user_resume.nationality','left')
      //   ->join('users','users.id = user_job_list.recuriter_id','left')
      //   ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
      //   ->where(array("user_job_list.user_id" => $user_id));

		if($type == 2){
			$sql = "SELECT `user_job_list`.*, `sub_subcategory`.`name` `sub_subcategory_name`, `users`.`name`, `users`.`profile_img`, `users`.`mobile_number`, `users`.`email` as `user_email`, `nationality`.`name` as `nationality_name`, `jobpost`.`organization_name`, `jobpost`.`job_title`, `categories`.`name` as `categories_name`, `subcategories`.`name` as `subcategories_name`, `user_resume`.`total_experience`,`user_resume`.`video_work`,`user_resume`.`resume_pdf`,`user_videos`.`video` as user_video,`user_resume_img`.`img` as user_pdf_img
				FROM `user_job_list`
				LEFT JOIN `jobpost` ON `jobpost`.`id` = `user_job_list`.`job_id`
				LEFT JOIN `user_resume` ON `user_resume`.`id` = `user_job_list`.`job_id`
				LEFT JOIN `nationality` ON `nationality`.`id` = `user_resume`.`nationality`
				LEFT JOIN `users` ON `users`.`id` = `user_job_list`.`user_id`
				LEFT JOIN `sub_subcategory` ON `sub_subcategory`.`id` = `jobpost`.`sub_subcategory_id`
				LEFT JOIN `subcategories` ON `subcategories`.`id` = `sub_subcategory`.`subcategory_id`
				LEFT JOIN `categories` ON `categories`.`id` = `subcategories`.`category_id`
				LEFT JOIN `user_videos` ON `user_videos`.`user_id` = `user_job_list`.`user_id`
				LEFT JOIN `user_resume_img` ON `user_resume_img`.`user_id` = `user_job_list`.`user_id`
				WHERE  `user_job_list`.`recuriter_id` = ".$user_id." AND (`categories`.`name` LIKE '".$word."%' or `subcategories`.`name` LIKE '".$word."%' or `sub_subcategory`.`name` LIKE '".$word."%') AND `user_job_list`.`job_status` = 1
				ORDER BY `user_job_list`.`id` DESC";
		}else{
			$sql = "SELECT `user_job_list`.*, `sub_subcategory`.`name` as `sub_subcategory_name`, `users`.`name` , `users`.`profile_img`, `users`.`mobile_number`, `users`.`email` as `user_email`, `nationality`.`name` as `nationality_name`, `jobpost`.`organization_name`, `jobpost`.`job_title`, `categories`.`name` as `categories_name`, `subcategories`.`name` as `subcategories_name`, `user_resume`.`total_experience`,`user_resume`.`video_work`,`user_resume`.`resume_pdf`,`user_videos`.`video` as user_video,`user_resume_img`.`img` as user_pdf_img
				FROM `user_job_list`
				LEFT JOIN `jobpost` ON `jobpost`.`id` = `user_job_list`.`job_id`
				LEFT JOIN `user_resume` ON `user_resume`.`id` = `user_job_list`.`job_id`
				LEFT JOIN `nationality` ON `nationality`.`id` = `user_resume`.`nationality`
				LEFT JOIN `users` ON `users`.`id` = `user_job_list`.`user_id`
				LEFT JOIN `sub_subcategory` ON `sub_subcategory`.`id` = `jobpost`.`sub_subcategory_id`
				LEFT JOIN `subcategories` ON `subcategories`.`id` = `sub_subcategory`.`subcategory_id`
				LEFT JOIN `categories` ON `categories`.`id` = `subcategories`.`category_id`
				LEFT JOIN `user_videos` ON `user_videos`.`user_id` = `user_job_list`.`user_id`
				LEFT JOIN `user_resume_img` ON `user_resume_img`.`user_id` = `user_job_list`.`user_id`
				WHERE `user_job_list`.`recuriter_id` = ".$user_id." AND (`categories`.`name` LIKE '".$word."%' or `subcategories`.`name` LIKE '".$word."%' or `sub_subcategory`.`name` LIKE '".$word."%') AND (`user_job_list`.`job_status` =0 or `user_job_list`.`job_status` = 2)
				ORDER BY `user_job_list`.`id` DESC";

		}

				  $query = $this->db->query($sql);
				 return $query->result_array();

		// $whe = "categories.name LIKE '%$word%' or subcategories.name LIKE '%$word%' or sub_subcategory.name LIKE '%$word%'";


		// // ->where("full_name LIKE '%$word%'")

	 //    $this->db->select('resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,jobpost.organization_name,jobpost.job_title,categories.name as categories_name,subcategories.name as subcategories_name')
  //       ->from('resum')
  //       ->join(' jobpost',' jobpost.id = resume.job_id','left')
  //       ->join('nationality','nationality.id = resume.nationality','left')
  //       ->join('degree','degree.id = resume.degree_id','left')
  //       ->join('university','university.id = resume.university_id','left')
  //       ->join('users','users.id = resume.recuriter_id','left')
  //       ->join('sub_subcategory','sub_subcategory.id = resume.sub_subcategory_id','left')
  //       ->join('subcategories','subcategories.id = sub_subcategory.subcategory_id','left')
  //       ->join('categories','categories.id = subcategories.category_id','left')
  //       ->where(array("resume.recuriter_id" => $user_id))
  //       ->where($whe);
        
        
  //       if($type == 2)
  //       {
  //           $this->db->where(array("resume.resume_status" => 1));
  //       }else{
  //       	$where = '(resume.resume_status= 0 or resume.resume_status= 2)';
	 //         $this->db->where($where);

  //       }
        
  //       $this->db->where(array("resume.recuriter_id" => $user_id))
  //       ->order_by("resume.id", "desc");
  //       return $this->db->get()->result_array();  
	}

	  
	  
	 public function getAllResumeDetail($resume_id)
	{
	
			$sql = "SELECT `resume`.*, `sub_subcategory`.`name` `sub_subcategory_name`, `users`.`name`, `users`.`profile_img`, `users`.`mobile_number`, `users`.`email` as `user_email`, `nationality`.`name` as `nationality_name`, `degree`.`name` as `degree_name`, `university`.`name` as `university_name`, `jobpost`.`organization_name`, `jobpost`.`job_title`, `categories`.`name` as `categories_name`, `subcategories`.`name` as `subcategories_name`
				FROM `resume`
				LEFT JOIN `jobpost` ON `jobpost`.`id` = `resume`.`job_id`
				LEFT JOIN `nationality` ON `nationality`.`id` = `resume`.`nationality`
				LEFT JOIN `degree` ON `degree`.`id` = `resume`.`degree_id`
				LEFT JOIN `university` ON `university`.`id` = `resume`.`university_id`
				LEFT JOIN `users` ON `users`.`id` = `resume`.`recuriter_id`
				LEFT JOIN `sub_subcategory` ON `sub_subcategory`.`id` = `resume`.`sub_subcategory_id`
				LEFT JOIN `subcategories` ON `subcategories`.`id` = `sub_subcategory`.`subcategory_id`
				LEFT JOIN `categories` ON `categories`.`id` = `subcategories`.`category_id`
				WHERE `resume`.`id` = ".$resume_id." 
				ORDER BY `resume`.`id` DESC";

			

			 $query = $this->db->query($sql);

			 return $query->row();
	}
	  
	  public function notification($type,$to_id)
	  {
	   //   1=employee,2=recuriter,3=admin
	      
	    $this->db->select("notification.id as notification_id,notification.from_id,notification.to_id,notification.title,notification.message,notification.msg_for,notification.is_read,notification.type,notification.job_id,notification.created_at,notification.updated_at,f.name as f_name,f.profile_img as f_img,t.name as t_name,t.profile_img as t_img")
	        ->from(' notification')
	        ->join('users f','f.id = notification.from_id','left')
	        ->join('users t','t.id = notification.to_id','left');
	    if($type == 1){
	       //  $where = '(sender_id="'.$userId.'" or receiver_id = "'.$userId.'")';
	         $where = '(msg_for= 1 or msg_for= 5)';
	         $this->db->where($where);
	    }else if($type == 2){
	        $where = '(msg_for= 3 or msg_for= 6)';
	         $this->db->where($where);
	    }else if($type == 3){
	        $where = '(msg_for= 2 or msg_for= 4)';
	         $this->db->where($where);
	    }
	    
		$this->db->where(array("notification.to_id" => $to_id))
		->order_by("notification.id", "desc");
		    
	    return $this->db->get()->result_array();
	}
	
	public function getResumeDetail($resume_id)
    {
        $this->db->select('resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,jobpost.organization_name,jobpost.job_title')
            ->from('resume')
            ->join(' jobpost',' jobpost.id = resume.job_id','left')
            ->join('nationality','nationality.id = resume.nationality','left')
            ->join('degree','degree.id = resume.degree_id','left')
            ->join('university','university.id = resume.university_id','left')
            ->join('users','users.id = resume.recuriter_id','left')
            ->join('sub_subcategory','sub_subcategory.id = resume.sub_subcategory_id','left')
            ->where(array("resume.id" => $resume_id));

            return $this->db->get()->row();  
    }

    public function allPostList($recuriter_id)
    {
        $this->db->select('jobpost.*,degree.name as degree_name,subcategories.name as subcategories_name,subcategories.other_language_name as subcategories_other_name,users.name as recuriter_name')
	        ->from('jobpost')
	        ->join('degree','degree.id = jobpost.degree_id','left')
	        ->join('subcategories','subcategories.id = jobpost.subcategory_id','left')
	        ->join('users','users.id = jobpost.user_id','left');


	    if($recuriter_id){
	    	$this->db->where(array('jobpost.user_id' => $recuriter_id));
	    	$this->db->where(array('jobpost.user_type' => 2));
	    }

	    $this->db->order_by("jobpost.id", "desc");

        return $this->db->get()->result_array(); 
    }


    public function viewPostJob($post_job_id)
    {
        $this->db->select('jobpost.*,degree.name as degree_name,categories.name as categories_name,sub_subcategory.name as sub_subcategory_name,subcategories.name as subcategories_name, users.name as recuriter_name')
	        ->from('jobpost')
	        ->join('degree','degree.id = jobpost.degree_id','left')
	       // ->join('subcategories','subcategories.id = jobpost.subcategory_id','left')
	        ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
        
	        
	        ->join('users','users.id = jobpost.user_id','left')
	    	->where(array('jobpost.id' => $post_job_id))
	    	->where(array('jobpost.user_type' => 2));
        return $this->db->get()->row(); 
    }


    public function getAllResume($user_id)
	{
	   // echo 1;die;
	    $this->db->select('user_resume.*,user_job_list.user_id as user_job_list_userId,user_job_list.recuriter_id as user_job_list_recuriterId,user_job_list.job_id as user_job_list_jobId,,user_job_list.job_status,jobpost.organization_name,jobpost.job_title,qualification.degree_name as qualification_degree_id,degree.name as degreename,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,u.name as u_name,r.name as r_name,user_resume_img.img as resume_pdf')
	    ->from('user_job_list')
	   // ->from('user_resume')
	   // ->join('user_job_list',' user_job_list.user_id = user_resume.user_id','left')
	    ->join('user_resume',' user_job_list.user_id = user_resume.user_id','left')
	     ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
	     ->join('qualification','qualification.resume_id = user_resume.id','left')
	     ->join('degree','degree.id = qualification.degree_name','left')
	     ->join('user_resume_img','user_resume_img.user_id = user_resume.user_id','left')
	     ->join('users u','u.id = user_resume.user_id','left')
	     ->join('users r','r.id = jobpost.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
        ->group_by('qualification.resume_id');
        if($user_id){
	   // 	$this->db->where(array('user_job_list.user_id' => $user_id));
	    	$this->db->where(array('user_job_list.user_id' => $user_id));
	    }

	    $this->db->order_by("user_job_list.id", "desc");

        return $this->db->get()->result_array();  
	}
    
     public function resume_detail($resume_id)
	{
	    $this->db->select('user_resume.*,user_job_list.user_id as user_job_list_userId,user_job_list.recuriter_id as user_job_list_recuriterId,user_job_list.job_id as user_job_list_jobId,,user_job_list.job_status,jobpost.organization_name,jobpost.job_title,qualification.degree_name as qualification_degree_id,degree.name as degreename,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,u.name as u_name,r.name as r_name,user_resume_img.img as resume_pdf,user_videos.video,nationality.name as nationality_name')
	    ->from('user_resume')
	    ->join('user_job_list',' user_job_list.user_id = user_resume.user_id','left')
	     ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
	     ->join('qualification','qualification.resume_id = user_resume.id','left')
	     ->join('degree','degree.id = qualification.degree_name','left')
	     ->join('user_resume_img','user_resume_img.user_id = user_resume.user_id','left')
	     ->join('user_videos','user_videos.user_id = user_resume.user_id','left')
	     ->join('nationality','nationality.id = user_resume.nationality','left')
	     ->join('users u','u.id = user_resume.user_id','left')
	     ->join('users r','r.id = jobpost.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
	    ->where(array('user_resume.id' => $resume_id));
	    

        return $this->db->get()->row();    
	}
    
    public function user_resume_detail($user_id)
	{
	    $this->db->select('user_resume.*,qualification.degree_name as qualification_degree_id,degree.name as degreename,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,u.name as u_name,user_resume_img.img as resume_pdf,user_videos.video,nationality.name as nationality_name')
	    ->from('user_resume')
	     ->join('qualification','qualification.resume_id = user_resume.id','left')
	     ->join('degree','degree.id = qualification.degree_name','left')
	     ->join('user_resume_img','user_resume_img.user_id = user_resume.user_id','left')
	     ->join('user_videos','user_videos.user_id = user_resume.user_id','left')
	     ->join('nationality','nationality.id = user_resume.nationality','left')
	     ->join('users u','u.id = user_resume.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = user_resume.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
	    ->where(array('user_resume.user_id' => $user_id));
	    

        return $this->db->get()->row();    
	}
    
	public function getUserResumeDetail($user_resume_id)
    {
        $this->db->select('user_resume.*,categories.name as categories_name,sub_subcategory.name sub_subcategory_name,subcategories.name as subcategories_name,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,user_resume.degree_name as u_degee_name')
            ->from('user_resume')
            ->join('nationality','nationality.id = user_resume.nationality','left')
            ->join('degree','degree.id = user_resume.degree_id','left')
            ->join('university','university.id = user_resume.university_id','left')
            // ->join('users','users.id = user_resume.recuriter_id','left')
            ->join('categories','categories.id = user_resume.category_id','left')
            ->join('subcategories','subcategories.id  =  user_resume.subcategory_id','left')
            ->join('sub_subcategory','sub_subcategory.id = user_resume.sub_subcategory_id','left')
        	
            ->where(array("user_resume.id" => $user_resume_id));

            return $this->db->get()->row();  
    }


    public function getSubSubCategoryList($subcategory_id)
    {
        $this->db->select('sub_subcategory.*,subcategories.category_id category_id,subcategories.id sub_category_id,subcategories.name sub_category_name')
            ->from('sub_subcategory')
            ->join('subcategories','subcategories.id = sub_subcategory.subcategory_id','left')
            ->where(array("sub_subcategory.subcategory_id" => $subcategory_id));

            return $this->db->get()->result_array();  
    }
    
     public function getSubSubSubCategoryList($subsubcategory_id)
    {
        $this->db->select('sub_sub_subcategory.*,subcategories.category_id category_id,subcategories.id sub_category_id,subcategories.name sub_category_name')
            ->from('sub_sub_subcategory')
            ->join('subcategories','subcategories.id = sub_sub_subcategory.sub_subcategory_id','left')
            ->where(array("sub_sub_subcategory.sub_subcategory_id" => $subsubcategory_id));

            return $this->db->get()->result_array();  
    }
    
    public function getAllHistory($user_id)
    {
        $this->db->select('payment_table.id,payment_table.user_id,payment_table.type,payment_table.packageads_id,payment_table.amount,payment_table.date')
            ->from('payment_table')
			->where(array("payment_table.user_id" => $user_id))
        	->order_by("payment_table.id", "desc");

            return $this->db->get()->result_array();  
    }

    public function getContry($country_id)
	{
	       $query = 'SELECT country.id,country.country_name FROM country  where country.id in('.$country_id.')';
	       	
	       	$query = $this->db->query($query);

		 return $query->result_array();

	}

	public function getCountryByName($countryName)
	{

		// $countryName = ;
	    // $query = 'SELECT country.id,country.country_name FROM country  where country.country_name in('.$countryName.')';
	    $query = "SELECT country.id,country.country_name FROM country  where country.country_name in('".$countryName."')";
	       	print_r( $query);die;
	    $query = $this->db->query($query);

		return $query->result_array();

	}



	public function getState($state_id)
	{
	    $query = 'SELECT states.id,states.state_name,states.country_id,states.is_active FROM states  where states.is_active = 1 AND states.id in('.$state_id.')';
	       	
	    $query = $this->db->query($query);

		return $query->result_array();

	}

	public function getCity($city_id)
	{
	    $query = 'SELECT cities.id,cities.city_name,cities.state_id,cities.is_active FROM cities  where cities.is_active = 1 AND cities.id in('.$city_id.')';
	       	
	    $query = $this->db->query($query);

		return $query->result_array();

	}

	public function getStateList($country_id)
	{
	    $query = 'SELECT states.id,states.state_name,states.country_id,states.is_active FROM states  where  states.is_active = 1 AND states.country_id in('.$country_id.')';
	       	
	    $query = $this->db->query($query);

		return $query->result_array();

	}

	public function getCityList($state_id)
	{
	    $query = 'SELECT cities.id,cities.city_name,cities.state_id,cities.is_active FROM cities  where cities.is_active = 1 AND cities.state_id in('.$state_id.')';
	       	
	    $query = $this->db->query($query);

		return $query->result_array();

	}


	public function getAllUserResume($user_id)
	{
	   // $this->db->select('user_resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,users.name as recuriter_name,u.name as u_name')
    //     ->from('user_resume')
    //     // ->join(' jobpost',' jobpost.id = user_resume.job_id','left')
    //     ->join('nationality','nationality.id = user_resume.nationality','left')
    //     ->join('degree','degree.id = user_resume.degree_id','left')
    //     ->join('university','university.id = user_resume.university_id','left')
    //     ->join('users','users.id = user_resume.user_id','left')
    //     ->join('users u','u.id = user_resume.user_id','left')
    //     ->join('sub_subcategory','sub_subcategory.id = user_resume.sub_subcategory_id','left');

    //     if($user_id){
	   // 	$this->db->where(array('user_resume.user_id' => $user_id));
	   // }

	   // $this->db->order_by("user_resume.id", "desc");

        
    //     return $this->db->get()->result_array();  
    
        // echo 1;die;
	    $this->db->select('user_resume.*,qualification.degree_name as qualification_degree_id,degree.name as degreename,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,u.name as u_name,user_resume_img.img as resume_pdf')
	    ->from('user_resume')
	   // ->join('user_job_list',' user_job_list.user_id = user_resume.user_id','left')
	   //  ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
	     ->join('qualification','qualification.resume_id = user_resume.id','left')
	     ->join('degree','degree.id = qualification.degree_name','left')
	     ->join('user_resume_img','user_resume_img.user_id = user_resume.user_id','left')
	     ->join('users u','u.id = user_resume.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = user_resume.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
        ->group_by('user_resume.user_id');

        if($user_id){
	   // 	$this->db->where(array('user_job_list.user_id' => $user_id));
	    	$this->db->where(array('user_resume.user_id' => $user_id));
	    }

	    $this->db->order_by("user_resume.id", "desc");

        return $this->db->get()->result_array();  
	}


	public function getSubSubSubCategory($subsubcategory_id)
	{

		$this->db->select('sub_sub_subcategory.*,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name')
        ->from('sub_sub_subcategory')
        ->join(' sub_subcategory','sub_subcategory.id = sub_sub_subcategory.sub_subcategory_id','left')
        ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left');

        if(!empty($subsubcategory_id)){
        	$this->db->where(array("sub_sub_subcategory.sub_subcategory_id" => $subsubcategory_id));	
        }

        return $this->db->get()->result_array();  
	}

	public function getAllUserResumeAPI($user_id)
	{
	    $this->db->select('user_resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,users.name as recuriter_name,u.name as u_name')
        ->from('user_resume')
        // ->join(' jobpost',' jobpost.id = user_resume.job_id','left')
        ->join('nationality','nationality.id = user_resume.nationality','left')
        ->join('degree','degree.id = user_resume.degree_id','left')
        ->join('university','university.id = user_resume.university_id','left')
        ->join('users','users.id = user_resume.user_id','left')
        ->join('users u','u.id = user_resume.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = user_resume.sub_subcategory_id','left');

        if($user_id){
	    	$this->db->where(array('user_resume.user_id' => $user_id));
	    	$this->db->where(array('user_resume.full_name !=' => ''));
	    }

	    $this->db->LIMIT(1)
	    ->order_by("user_resume.id", "desc");

        
        return $this->db->get()->row();  
	}

	public function getAllUserResumeRecuirterAPI($user_id)
	{
	    $this->db->select('resume.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,degree.name as degree_name,university.name as university_name,users.name as recuriter_name,u.name as u_name')
        ->from('resume')
        // ->join(' jobpost',' jobpost.id = user_resume.job_id','left')
        ->join('nationality','nationality.id = resume.nationality','left')
        ->join('degree','degree.id = resume.degree_id','left')
        ->join('university','university.id = resume.university_id','left')
        ->join('users','users.id = resume.user_id','left')
        ->join('users u','u.id = resume.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = resume.sub_subcategory_id','left');

        if($user_id){
	    	$this->db->where(array('resume.user_id' => $user_id));
	    	$this->db->where(array('resume.full_name !=' => ''));
	    }

	    $this->db->LIMIT(1)
	    ->order_by("resume.id", "desc");

        
        // return $this->db->get()->result_array();  
        return $this->db->get()->row();  
	}
	
// 	public function getAllResumeFilter($user_id,$category_id, $sub_category_id,$sub_sub_category_id,$search,$qulalifcation,$experience)
// 	{
// 	   // echo 1;die;

// // 		$condition = "user_resume.address LIKE '%$search' OR user_resume.city LIKE '%$search' OR user_resume.state LIKE '%$search' OR user_resume.country LIKE '%$search' OR user_resume.total_experience LIKE '%$search' OR qualification.degree_name LIKE '%$search%'";
// 		$condition = "user_resume.address LIKE '%$search' OR user_resume.city LIKE '%$search' OR user_resume.state LIKE '%$search' OR user_resume.country LIKE '%$search' OR user_resume.total_experience LIKE '%$search' OR qualification.degree_name LIKE '%$search%'";

// 		 $this->db->select('user_job_list.*,sub_subcategory.name sub_subcategory_name,users.name,users.profile_img,users.mobile_number,users.email as user_email ,nationality.name as nationality_name,jobpost.organization_name,jobpost.job_title,users.name as recuriter_name,u.name as u_name,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,user_resume.total_experience,qualification.degree_name as qualification_name')
//         ->from('user_job_list')
//         ->join(' jobpost',' jobpost.id = user_job_list.job_id','left')
//          ->join('user_resume',' user_resume.id = user_job_list.job_id','left')
//         ->join('nationality','nationality.id = user_resume.nationality','left')
//         ->join('qualification','qualification.resume_id = user_resume.id','left')
//         // ->join('degree','degree.id = resume.degree_id','left')
//         // ->join('university','university.id = resume.university_id','left')
//         ->join('users','users.id = user_job_list.recuriter_id','left')
//         ->join('users u','u.id = user_job_list.user_id','left')
//         ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
//           ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
//         ->join('categories','categories.id = subcategories.category_id','left');
        

//         if($user_id != 0){
// 	    	$this->db->where(array('user_job_list.user_id' => $user_id));
// 	    }
// 	    if(!empty($category_id)){
// 	    	$this->db->where(array('categories.id' => $category_id));
// 	    }
//         if(!empty($sub_category_id)){
// 	    	$this->db->where(array('subcategories.id' => $sub_category_id));
// 	    }
// 	   if(!empty($sub_sub_category_id)){
// 	    	$this->db->where(array('jobpost.sub_subcategory_id' => $sub_sub_category_id));
// 	    }

// 	     $this->db->where($condition);
// 	    $this->db->order_by("user_job_list.id", "desc");

        
//         return $this->db->get()->result_array();  
// 	}
    
    	public function getAllResumeFilter($user_id,$category_id, $sub_category_id,$sub_sub_category_id,$search,$qulalifcation,$experience)
	{
	    
        $condition='';
		$this->db->select('user_resume.*,user_job_list.user_id as user_job_list_userId,user_job_list.recuriter_id as user_job_list_recuriterId,user_job_list.job_id as user_job_list_jobId,,user_job_list.job_status,jobpost.organization_name,jobpost.job_title,qualification.degree_name,qualification.degree_name as qualification_degree_id,degree.name as degreename,categories.name as categories_name,subcategories.name as subcategories_name,sub_subcategory.name as subsubcategories_name,u.name as u_name,r.name as r_name,user_resume_img.img as resume_pdf,subcategories.category_id,sub_subcategory.subcategory_id,subcategories.id as subcategories_id,jobpost.sub_subcategory_id')
	   // ->from('user_resume')
	    ->from('user_job_list')
	   // ->join('user_job_list',' user_job_list.user_id = user_resume.user_id','left')
	    ->join('user_resume',' user_job_list.user_id = user_resume.user_id','left')
	     ->join('jobpost',' jobpost.id = user_job_list.job_id','left')
	     ->join('qualification','qualification.resume_id = user_resume.id','left')
	     ->join('degree','degree.id = qualification.degree_name','left')
	     
	     ->join('user_resume_img','user_resume_img.user_id = user_resume.user_id','left')
	     ->join('users u','u.id = user_resume.user_id','left')
	     ->join('users r','r.id = jobpost.user_id','left')
        ->join('sub_subcategory','sub_subcategory.id = jobpost.sub_subcategory_id','left')
         ->join('subcategories','subcategories.id  =  sub_subcategory.subcategory_id','left')
        ->join('categories','categories.id = subcategories.category_id','left')
        ->group_by('qualification.resume_id');
        

        if($user_id != 0){
	    	$this->db->where(array('user_resume.user_id' => $user_id));
	    }
	    if(!empty($category_id)){
	    	$this->db->where(array('categories.id' => $category_id));
	    	
	    	$condition.=" categories.id ='".$category_id."'";
	    }
        if(!empty($sub_category_id)){
	    	$this->db->where(array('subcategories.id' => $sub_category_id));
	   // 		$condition.=" subcategories.id ='".$sub_category_id."'";
	    }
	   if(!empty($sub_sub_category_id)){
	    	$this->db->where(array('jobpost.sub_subcategory_id' => $sub_sub_category_id));
	           // $condition.=" jobpost.sub_subcategory_id ='".$sub_sub_category_id."'";
	    }
	    
	    if(!empty($experience)){
	    	$this->db->where(array('user_resume.total_experience' => $experience));
	           // $condition.=" jobpost.sub_subcategory_id ='".$sub_sub_category_id."'";
	    }
	    
	    if(!empty($qulalifcation)){
	    	$this->db->where(array('qualification.degree_name' => $qulalifcation));
	       //$condition.=" AND qualification.degree_name ='".$qulalifcation."'";
	    }
	    
	    	$condition = "(user_resume.address LIKE '%$search' OR user_resume.city LIKE '%$search' OR user_resume.state LIKE '%$search' OR user_resume.country LIKE '%$search')";
	    	
        // if(!empty($search))
        // {
        //      $condition.=" user_resume.address LIKE '%".$search."%'";
        //     $condition.=" OR user_resume.city LIKE '%".$search."%'";
        //     $condition.=" OR user_resume.state LIKE '%".$search."%'";
        //     $condition.=" OR user_resume.country LIKE '%".$search."%'";
        // }
        
	    $this->db->where($condition);
	    $this->db->order_by("user_job_list.id", "desc");

        
        return $this->db->get()->result_array();  
	}
	
	
	
    
	 public function checkLoginDetail($email_mobile,$password,$user_type)
    {
		$where = '(deleted_at IS NULL AND  email="'.$email_mobile.'" or mobile_number = "'.$email_mobile.'")';

		$this->db->select("*")
				->from('users')
        		->where($where)
                ->where(array("password" => md5($password)))
                ->where(array("actual_password" => $password))
                ->where(array("user_type" => $user_type));
		
		return $this->db->get()->row();
    }

     public function checkOtp($email_mobile,$user_type,$otp)
    {
		// $where = '(deleted_at IS NULL AND  email="'.$email_mobile.'" or mobile_number = "'.$email_mobile.'")';
		$where = '(email="'.$email_mobile.'" or mobile_number = "'.$email_mobile.'")';

		$this->db->select("*")
				->from('users')
        		->where($where)
                // ->where(array("password" => md5($password)))
                // ->where(array("actual_password" => $password))
                ->where(array("user_type" => $user_type));
		
		return $this->db->get()->row();
    }


    
    function _softDeletebyCondition($table='', $where=array()){
        
        $dateTime = mdate('%Y-%m-%d %H:%i:%s', now());
        $Query    = $this->db->update($table, array('updated_at' => $dateTime,'deleted_at' => $dateTime), $where);
        if($this->db->affected_rows()>0){
            
            return true;  
        }else{

            return false;
        }
    }

    public function getUserPackList($user_id)
    {
        
        $this->db->select('user_buy_packs.id as user_buy_pack_id,user_buy_packs.user_id,user_buy_packs.pack_id,pack.name,pack.price')
	        ->from('user_buy_packs')
	        ->join('pack','pack.id = user_buy_packs.pack_id','left')
	        ->where(array('user_buy_packs.type' => 0))
	    	->where(array('user_buy_packs.user_id' => $user_id));
	    	
        return $this->db->get()->result_array(); 

    }
    
    
    public function getUserPack($user_buy_pack_id)
    {
        
        $this->db->select('user_buy_packs.id as user_buy_pack_id,user_buy_packs.user_id,user_buy_packs.pack_id,pack.name,pack.price,users.cjm_wallet,users.eth_wallet')
	        ->from('user_buy_packs')
	        ->join('pack','pack.id = user_buy_packs.pack_id','left')
	        ->join('users','users.id = user_buy_packs.user_id','left')
	        ->where(array('user_buy_packs.type' => 0))
	    	->where(array('user_buy_packs.id' => $user_buy_pack_id));
	    	
        return $this->db->get()->row(); 
    }



     public function getNftList($user_id)
    {
        
        $this->db->select('user_buy_packs.id as user_buy_nft_id,user_buy_packs.user_id,user_buy_packs.pack_id,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,nft_items.unique_asset_identifier')
	        ->from('user_buy_packs')
	        ->join('nft_items','nft_items.id = user_buy_packs.pack_id','left')
	    	->where(array('user_buy_packs.type' => 1))
	    	->where(array('user_buy_packs.user_id' => $user_id));
	    	
        return $this->db->get()->result_array(); 

    }


    public function getNftDetail($user_buy_nft_id)
    {
        
        $this->db->select('user_buy_packs.id as user_buy_nft_id,user_buy_packs.user_id,user_buy_packs.pack_id,users.cjm_wallet,users.eth_wallet,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,nft_items.unique_asset_identifier')
	        ->from('user_buy_packs')
	         ->join('nft_items','nft_items.id = user_buy_packs.pack_id','left')
	        ->join('users','users.id = user_buy_packs.user_id','left')
	        ->where(array('user_buy_packs.type' => 1))
	    	->where(array('user_buy_packs.id' => $user_buy_nft_id));
	    	
        return $this->db->get()->row(); 
    }
    
    public function getftDetail($user_buy_ft_id)
    {
        $this->db->select('user_buy_packs.id as user_buy_nft_id,user_buy_packs.user_id,user_buy_packs.pack_id,users.cjm_wallet,users.eth_wallet,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,nft_items.unique_asset_identifier')
	        ->from('user_buy_packs')
	         ->join('nft_items','nft_items.id = user_buy_packs.pack_id','left')
	        ->join('users','users.id = user_buy_packs.user_id','left')
	        ->where(array('user_buy_packs.type' => 2))
	    	->where(array('user_buy_packs.id' => $user_buy_ft_id));
	    	
        return $this->db->get()->row(); 
    }
    
     public function getFtList($user_id)
    {
        
        $this->db->select('user_buy_packs.id as user_buy_nft_id,user_buy_packs.user_id,user_buy_packs.pack_id,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,nft_items.unique_asset_identifier')
	        ->from('user_buy_packs')
	        ->join('nft_items','nft_items.id = user_buy_packs.pack_id','left')
	    	->where(array('user_buy_packs.type' => 2))
	    	->where(array('user_buy_packs.user_id' => $user_id));
	    	
        return $this->db->get()->result_array(); 

    }
    
     public function getTradeDetail($trade_id)
    {
        $this->db->select('user_tradings.id as trading_id,user_tradings.user_id,user_tradings.pack_id,user_tradings.price,user_tradings.expire_date,user_tradings.buy_id,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,users.first_name as buy_name,nft_items.unique_asset_identifier')
	        ->from('user_tradings')
	         ->join('nft_items','nft_items.id = user_tradings.pack_id','left')
	        ->join('users','users.id = user_tradings.user_id','left')
	    	->where(array('user_tradings.id' => $trade_id));
	    	
        return $this->db->get()->row(); 
    }
    
    public function getTradeList($user_id)
    {
        $this->db->select('user_tradings.id as trading_id,user_tradings.user_id,user_tradings.pack_id,user_tradings.price,user_tradings.expire_date,user_tradings.buy_id,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,users.first_name as buy_name,nft_items.unique_asset_identifier')
	        ->from('user_tradings')
	         ->join('nft_items','nft_items.id = user_tradings.pack_id','left')
	        ->join('users','users.id = user_tradings.user_id','left')
	    	->where(array('user_tradings.user_id !=' => $user_id));
	    	
        return $this->db->get()->result_array();  
    }


    public function getNftFt($user_id)
    {
        $this->db->select('user_buy_packs.id as user_buy_nft_id,user_buy_packs.user_id,user_buy_packs.pack_id,nft_items.name,nft_items.price,nft_items.nft_img,nft_items.descripition,nft_items.unique_asset_identifier,user_buy_packs.type')
	        ->from('user_buy_packs')
	        ->join('nft_items','nft_items.id = user_buy_packs.pack_id','left')
	    	->where(array('user_buy_packs.type !=' => 0))
	    	->where(array('user_buy_packs.user_id' => $user_id));
	    	
        return $this->db->get()->result_array(); 

    }
    
    
    
    
    
    
    
    
    
}



