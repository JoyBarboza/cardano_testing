<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model {
    

/* ************* add  data *************** */
	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }

	public function insert_data($table,$data)
	{ 
	
     	$data = $this->db->insert($table,$data);

     	return $final_data = $this->db->select('*')->from($table)->where('id',$this->db->insert_id())->get()->row();
	
	}

	public function user_info_from_token($token)
	{
		return $userinfo = $this->db->select('*')
								->from('users')
								->where('token',$token)
								->where('is_delete','0')
								->get()->row();
	}
	public function get_single_data($table,$where)
	{
		$this->db->where($where);
		$data = $this->db->get($table);
		$get = $data->row();

		$num = $data->num_rows();

		if($num){
		return $get;
		}
		else
		{
		return false;
		}
	}
	

}
?>
