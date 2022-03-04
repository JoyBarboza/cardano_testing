<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	

	function getSingleDetailsWhere($table,$where)
	{
		$CI =& get_instance();
		return $result = $CI->user_model->getSingle($table,$where);
	}
	function getMultipleDetailsWhere($table,$where)
	{
		$CI =& get_instance();
		return $result = $CI->user_model->getWhere($table,$where);
	}
	function getsingleDataBySql($sql)
	{
		$CI =& get_instance();
		return $result = $CI->user_model->select_single_row($sql);
	}
		