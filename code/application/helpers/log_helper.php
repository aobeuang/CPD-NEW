<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('addMessage'))
{
	// ex addMessage("Update content ... ", "success", "desc ......")
    function addMessage($message, $status, $description)
    {
    	$ci =& get_instance();
    	$ci->load->database();
    	
    	$sequence_tablename = "LOGS_SEQUENCE";
    	$query = $ci->db->query(" SELECT $sequence_tablename.NEXTVAL as nextvalue FROM dual ");
    	$result = $query->result_array();;
    	$nextvalue = !empty($result) && isset($result[0]['NEXTVALUE']) ? $result[0]['NEXTVALUE']: "";
    	if (empty($nextvalue))
    	{
    		die("Create sequence named $sequence_tablename");
    	}
    	$ci->db->reset_query();
    	     	
    	$ci->db->set('log_id', $nextvalue);
    	$ci->db->set('name', $message);
    	$ci->db->set('status', $status);
    	date_default_timezone_set("Asia/Bangkok");
    	$currenttime = date('Y-m-d H:i:s',time());
    	$ci->db->set('"created_at"', "to_char('$currenttime','yy-mm-dd hh24:mi:ss')", false);
    	$ci->db->set('description', $description);
    	$ci->db->insert($ci->db->dbprefix('logs'));
    	
    	$ci->db->reset_query();
    }  
}


if ( ! function_exists('addLogSuspiciousMessage'))
{
	function addLogSuspiciousMessage($citizen_id,$citizen_name,$action_name,$description)
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->library('session');
		$ci->load->helper('properties');
		$ci->load->helper('user');
		$ci->load->helper('survey');
		$ci->load->helper('time');
		// $on = getStringSystemProperties('coop.log.suspicious.enabled', "false");		
		// if ($on=="false")
		// {
		// 	return;			
		// }

		// $sequence_tablename = "LOGACTIVITY_SEQUENCE";
    	// $query = $ci->db->query(' SELECT LOGACTIVITY_SEQUENCE.nextval as nextvalue FROM "logactivity" ');
    	// $result = $query->result_array();;
    	// $nextvalue = !empty($result) && isset($result[0]['NEXTVALUE']) ? $result[0]['NEXTVALUE']: 1;
    	// if (empty($nextvalue))
    	// {
    	// 	die("Create sequence named");
    	// }
    	// $ci->db->reset_query();

		$log_type_name = getLogNameBylogType($action_name);
		// echo $log_type_name['log_type_text'];
		// echo print_r($log_type_name);die();

		
		if($ci->session->userdata('auth_user_id')!=null && is_numeric($ci->session->userdata('auth_user_id')))
		{

			$actor = getUser($ci->session->userdata('auth_user_id'));
			$citizen = getMahadthaiByCitizenID($citizen_id);
			// $logdb = $ci->load->database();
			// $logdb = $ci->db->dbprefix('logactivityreport');
			// $logdb = $ci->load->database(); // the TRUE paramater tells CI that you'd like to return the database object.
			// $ci->db->set('logactivityid', $nextvalue);
			$ci->db->set('name', $log_type_name['log_type_text']);
			$ci->db->set('citizen_name', $citizen_name);
			$currenttime = date('Y-m-d H:i:s',time());

			$province_user = getProvinceByID($actor['province']);
			// echo print_r($province_user);die();
			
			$ci->db->set('"created_at"', $currenttime);
			// $description = "มีการเข้าถึงแบบสำรวจ";
			$ci->db->set('detail', $description);
			$ci->db->set('citizen_id', $citizen_id);			
			if (!empty($citizen) && isset($citizen[0]) && isset($citizen[0]['PROVICE_NAME']))
			{
				$ci->db->set('citizen_province', $citizen[0]['PROVICE_NAME']);
			}
			$ci->db->set('actor_province', $province_user->PROVINCE_NAME);
			$ci->db->set('actor_name', $actor['name']);
			
			$ci->db->insert($ci->db->dbprefix('logactivity'));
			// $logdb->close();
			$ci->db->reset_query();
		
		}
	}
}



if ( ! function_exists('addLogSuspiciousMessageReport'))
{
	function addLogSuspiciousMessageReport($action_name,$description,$search_province="")
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->library('session');
		$ci->load->helper('properties');
		$ci->load->helper('user');
		$ci->load->helper('survey');
		$ci->load->helper('time');
		// $on = getStringSystemProperties('coop.log.suspicious.enabled', "false");
		// if ($on=="false")
		// {
		// 	return;
		// }
		
		if($ci->session->userdata('auth_user_id')!=null && is_numeric($ci->session->userdata('auth_user_id')))
		{		
			$actor = getUser($ci->session->userdata('auth_user_id'));			
			// $logdb = $ci->load->database('cooplog', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
			$ci->db->set('name', $action_name);
			$currenttime = date('Y-m-d H:i:s',time());

			$province_user = getProvinceByID($actor['province']);
			// echo print_r($province_user);die();
			$ci->db->set('created_at',$currenttime);
// 			$description = "มีการค้นหารายงานสมาชิก โดยผู้ใช้ชื่อ ".$actor['name'];
			$ci->db->set('detail', $description);			
			$ci->db->set('actor_province', $province_user->PROVINCE_NAME);
			$ci->db->set('actor_name', $actor['name']);
			$ci->db->set('search_province', $search_province);
			$ci->db->insert("logactivityreport");
			// $ci->db->close();
			$ci->db->reset_query();
		}
	}
}
// file error log codeignitor
// https://www.codeigniter.com/user_guide/general/errors.html
//Parameters:
//$level (string) – Log level: ‘error’, ‘debug’ or ‘info’
//$message (string) – Message to log
// log_message($level, $message)


//In order for the log file to actually be written, the logs/ directory must be writable. 
//In addition, you must set the “threshold” for logging in application/config/config.php. You might, for example, only want error messages to be logged, and not the other two types. If you set it to zero logging will be disabled.
