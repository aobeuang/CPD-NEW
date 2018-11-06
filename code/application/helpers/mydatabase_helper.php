<?php 
if(!function_exists('standard_php_query')){
	function standard_php_query($sql){
		$ci =& get_instance();
		$ci->load->database();
		$user_info = $ci->session->userdata();
		$link = mssql_connect($ci->db->hostname, $ci->db->username, $ci->db->password);
		if (!$link) {
			die('Something went wrong while connecting to MSSQL');
		}
		
		$db_selected = mssql_select_db($ci->db->database, $link);
		if (!$db_selected) {
			die ('Can\'t use db : ' . mssql_get_last_message());
		}
		$result = mssql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mssql_get_last_message());
		}
		$result_list = array();
		if (!mssql_num_rows($result)) {
			//echo 'No records found';
		} else {
			while ($row = mssql_fetch_array($result,MSSQL_ASSOC)) {
				$result_list[] = $row;
			}
		}
		mssql_free_result($result);
		return $result_list;
	}
}

if(!function_exists('standard_php_query')){
	function standard_php_query($sql){
		$ci =& get_instance();
		$ci->load->database();
		$user_info = $ci->session->userdata();
		$link = mssql_connect($ci->db->hostname, $ci->db->username, $ci->db->password);
		if (!$link) {
			die('Something went wrong while connecting to MSSQL');
		}

		$db_selected = mssql_select_db($ci->db->database, $link);
		if (!$db_selected) {
			die ('Can\'t use db : ' . mssql_get_last_message());
		}
		$result = mssql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mssql_get_last_message());
		}
		$result_list = array();
		if (!mssql_num_rows($result)) {
			//echo 'No records found';
		} else {
			while ($row = mssql_fetch_array($result,MSSQL_ASSOC)) {
				$result_list[] = $row;
			}
		}
		mssql_free_result($result);
		return $result_list;
	}
}