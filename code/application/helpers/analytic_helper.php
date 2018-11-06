<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_usable("getListDataSurvey")){
	function getListDataSurvey($table_name = '2018')
	{
		$ci =& get_instance();
		$ci->load->library('session');
		
		
// 		$ci->db->select();
// 		$ci->db->where();

		$table = 'SURVEY_'.$table_name;
		
		$result_data = $ci->db->get($table)->result_array();
		
		$data_return = changeDataFormart($result_data);
		
		return $data_return;
	}
	
	function changeDataFormart($datas)
	{
		$temp_data_process = array();
		foreach ($datas as $data_inarray)
		{
			$temp_data = array();
			foreach ($data_inarray as $k=>$v)
			{
				
				if(isSerialized($v))
				{
					$temp_data[$k] = unserialize($v);
				}
				else
				{
					$temp_data[$k] =$v;
				}
			}
			$temp_data_process[] = $temp_data;
		}
		return $temp_data_process;
	}
	function isSerialized($str) {
		return ($str == serialize(false) || @unserialize($str) !== false);
	}
	
}

if(!function_exists("getCountRowSurvey"))
{
	function getCountRowSurvey($table_name = '2018')
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$sql = "select count(*) as total from SURVEY_$table_name";
		$query_count = $ci->db->query($sql)->result_array();
// 		echo "<pre>";
// 		print_r($query_count);
// 		echo "</pre>";
		return intval($query_count[0]['TOTAL']);
	}
	
}