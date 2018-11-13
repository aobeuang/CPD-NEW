<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 $config['levels_and_roles'] = [
 '1' => 'central_normal',
 '2' => 'central_manager',
 '5' => 'notcentral_normal',
 '6' => 'notcentral_manager',
 '8' => 'admin_normal',
 '9' => 'admin'
 ];*/
if ( ! function_exists('canAdd'))
{
	function canAdd($citizen_id="")
	{
		$ci =& get_instance();
		$ci->load->helper('user');
		$ci->load->library('session');
		$user_id = $ci->session->userdata('auth_user_id');
		if (empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}
		
		$ci =& get_instance();
		$role = $ci->session->userdata('auth_role');
		if ($role=="admin" 
				|| $role=="notcentral_normal" 
				|| $role=="central_normal" 
				|| $role=="central_manager"
				|| $role=="admin_normal"
				|| $role=="notcentral_manager") 
		{	
			return true;
		}
		
		return false;
	}
}

if ( ! function_exists('canUpdate'))
{
	function canUpdate($citizen_id,$year)
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$ci->load->helper('user');
		$user_id = $ci->session->userdata('auth_user_id');
		if (empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}
		
		$ci =& get_instance();
		$role = $ci->session->userdata('auth_role');
		if ($role=="admin"				
				|| $role=="central_normal"
				|| $role=="central_manager"
				|| $role=="admin_normal"
				|| $role=="notcentral_manager"
		) 
		{
			return true;
		}
		
		//$year = getSelectedSurveyYear();

		return false;
	}
}

if ( ! function_exists('canView'))
{
	function canView($citizen_id,$year)
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$ci->load->helper('user');
		$user_id = $ci->session->userdata('auth_user_id');
		
		if (empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}

		$role = $ci->session->userdata('auth_role');
		if ($role=="admin"
				//|| $role=="notcentral_normal"
				|| $role=="central_normal"
				|| $role=="central_manager"
				|| $role=="admin_normal"
				//|| $role=="notcentral_manager"
		) 
		{
			return true;
		}
		
		
		
		
		//return true;
	
		///TODO
		// 		if("กรุงเทพมหานคร พื้นที่ 1" == x['province']){
		//if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
		//	$org_id = '4553';
		//}else if("กรุงเทพมหานคร พื้นที่ 2" == $province_name_user_search['province'])
		//{
		//if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
		//	$org_id = '4559';
		//}
		if ( $role=="notcentral_manager" && !empty($citizen_id))
		{
			$user = getUser($user_id);
			$province = $user['province'];
			
			$all_kets = getAllKhetRecord();
			$khet_id = "";
			foreach ($all_kets as $v){
				
				if (trim($province)==trim($v['province_name']))
				{
					$khet_id = $v['khet_id'];
				}
				
				// bkk
				if ($v['province_name_sort']=='สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 1' && trim($province)=='กรุงเทพมหานคร พื้นที่ 1')
				{
					$khet_id = 1;
				}
				
				if ($v['province_name_sort']=='สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 2' && trim($province)=='กรุงเทพมหานคร พื้นที่ 2')
				{
					$khet_id = 1;
				}
			}
			
			
			$org_org_ids = array();
			foreach ($all_kets as $v){
				if ($khet_id==$v['khet_id'])
				{
					$org_org_ids[] = $v['org_org_id'];
				}
			}

			

			//$user_org_id = getOrgIdByProvinceName($province);
			//if ($province=='กรุงเทพมหานคร พื้นที่ 1' || $province=='กรุงเทพมหานคร พื้นที่ 2')
			//{
				$coop_members = getMahadthaiByCitizenID($citizen_id);
				
				// ถ้าเจอในมหาดไทย
				if (!empty($coop_members))
				{
					foreach ($coop_members as $member)
					{
						// ถ้าดูจากสหกรณ์ที่เป็นสมาชิก ไม่ใช่จังหวัดที่สมาชิกอาศัยอยู่
						$coop_id = $member['D_COOP'];
						$coop = getCoopByID($coop_id);
						if (!empty($coop))
						{
							$coop['ORG_ID'] = trim($coop['ORG_ID']);
							
							// ถ้ารหัสเขตพื้นที่ ของผู้ใช้เท่ากับ รหัสเขตพื้นที่ของสหกรณ์
							if (in_array($coop['ORG_ID'] , $org_org_ids))
							{
								return true;
							}
						}
					}
				}
				else {
					// สามารถกรอกแบบสำรวจใหม่เลย เพราะไม่เจอในมหาดไทย
					return true;
				}
				return false;
			//}
		}

		
		if ( $role=="notcentral_normal" &&  !empty($citizen_id)){
			
			$year = getSelectedSurveyYear();
			
			$user = getUser($user_id);
			$province = $user['province'];
			$user_org_id = getOrgIdByProvinceName($province);
			

			$coop_members = getMahadthaiByCitizenID($citizen_id);
		
			// ถ้าเจอในมหาดไทย
			if (!empty($coop_members))
			{					
				foreach ($coop_members as $member)
				{
					// ถ้าดูจากสหกรณ์ที่เป็นสมาชิก ไม่ใช่จังหวัดที่สมาชิกอาศัยอยู่
					$coop_id = $member['D_COOP'];
					$coop = getCoopByID($coop_id);						
					if (!empty($coop))
					{
						// ถ้ารหัสเขตพื้นที่ ของผู้ใช้เท่ากับ รหัสเขตพื้นที่ของสหกรณ์
						if (trim($coop['ORG_ID'])==$user_org_id)
						{
							return true;
						}
					}
				}
			}	
			else {
				// สามารถกรอกแบบสำรวจใหม่เลย เพราะไม่เจอในมหาดไทย
				return true;					
			}
			return false;
			
						
		}
		return false;
	}
}



/*
 * 
 
select a.OU_D_ID,a.IN_D_COOP from "MOIUSER"."MASTER_DATA"  a
left join COOP_INFO c on a.IN_D_COOP=c.REGISTRY_NO_2
where c.org_id='4553'


MOI เขต 1
3860100609608	1010000825377
3339900021012	1010000825377
3300101335000	1010000825377
3360700206312	1010000825377
3101702348079	1010000825377
3100203551315	1010000825377
3100300476373	1010000825377
3100904241061	1010000825377
3160300214441	1010000825377
3141100352744	1010000825377
3950600160790	1010000825377
3100502323039	1010000825377
3130100263171	1010000825377


select a.* from "MOIUSER"."MASTER_DATA"  a
left join COOP_INFO c on a.IN_D_COOP=c.REGISTRY_NO_2
where c.org_id='4559'

MOI เขต 2
1103701763191	1020001325488
1101400288221	1020001325488
3100503552864	1020001325488
3100601974160	1020001325488
3100502379051	1020001325488
3100601936586	1020001325488
1103701643765	1020001325488
3100502341444	1020001325488
3660500136954	1020001325488
3100601902711	1020001325488
3251000146319	1020001325488
3110401037073	1020001325488
3140600078969	1020001325488
1103700966463	1020001325488
 
 
 * 
 */


if ( ! function_exists('canViewSurveyByCoop'))
{
	function canViewSurveyByCoop($coop_id)
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$ci->load->helper('user');
		$user_id = $ci->session->userdata('auth_user_id');
		$user = getUser($user_id);		
		$role = $ci->session->userdata('auth_role');
		if ($role=="admin"
				//|| $role=="notcentral_normal"
				|| $role=="central_normal"
				|| $role=="central_manager"
				|| $role=="admin_normal"
				//|| $role=="notcentral_manager"
				)
		{
			return true;
		}
		
		$province = $user['province'];
		$coop_id = trim($coop_id);
		$coop = getCoopByID($coop_id);
		
		
		//echo "<pre>can view by coop";
		//print_r($coop);
		//echo "</pre>";
		
		if ( $role=="notcentral_normal" && !empty($coop))
		{
			$user_org_id = getOrgIdByProvinceName($province);
			$coop_name[] = $coop['ORG_NAME'];
			if (trim($coop['ORG_ID'])==$user_org_id)
			{
				return true;
			}
			return false;
		}

		
		if ( $role=="notcentral_manager" && !empty($coop))
		{
			$all_kets = getAllKhetRecord();
			$khet_id = "";
			foreach ($all_kets as $v){
				
				if (trim($province)==trim($v['province_name']))
				{
					$khet_id = $v['khet_id'];
				}
								
				// bkk 
				if ($v['province_name_sort']=='สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 1' && trim($province)=='กรุงเทพมหานคร พื้นที่ 1')
				{
					$khet_id = 1;
				}

				if ($v['province_name_sort']=='สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 2' && trim($province)=='กรุงเทพมหานคร พื้นที่ 2')
				{
					$khet_id = 1;
				}
				
				
			}
			
			$org_org_ids = array();
			foreach ($all_kets as $v){
				
				if ($khet_id==$v['khet_id'])
				{
					$org_org_ids[] = $v['org_org_id'];
				}
			}
			
			foreach ($org_org_ids as $v)
			{
				if (trim($coop['ORG_ID'])==$v)
				{
					return true;
				}
				
			}
		}
				
		return false;
	}
}


if ( ! function_exists('canViewReport'))
{
	function canViewReport()
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$user_id = $ci->session->userdata('auth_user_id');
		
		if (empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}
		
		$role = $ci->session->userdata('auth_role');
		if ($role=="admin"
				|| $role=="central_normal"
				|| $role=="central_manager"
				|| $role=="notcentral_manager"
				) 
		{
			return true;
		}

		return false;
	}
}

if ( ! function_exists('checkSuspiciousActivityMahadthai'))
{
	function checkSuspiciousActivityMahadthai($citizen_id, $action, $year="")
	{
		if (empty($citizen_id) || !is_numeric($citizen_id))
			return;
		
		$ci =& get_instance();
		$ci->load->library('session');
		$user_id = $ci->session->userdata('auth_user_id');
		$ci->load->helper('log');
		$ci->load->helper('user');
		
		$current_user = getUser($user_id);
		$user_province = isset($current_user['province']) ? $current_user['province']:"";
		$mahadthai = getMahadthaiByCitizenID($citizen_id);
		
		$mahadthai_province0 =  isset($mahadthai[0]) && isset($mahadthai[0]['PROVINCE_NAME']) ? $mahadthai[0]['PROVINCE_NAME'] :"";
		$mahadthai_province1 =  isset($mahadthai[1]) && isset($mahadthai[1]['PROVINCE_NAME']) ? $mahadthai[1]['PROVINCE_NAME'] :"";
		$mahadthai_province2 =  isset($mahadthai[2]) && isset($mahadthai[2]['PROVINCE_NAME']) ? $mahadthai[2]['PROVINCE_NAME'] :"";
		$mahadthai_province3 =  isset($mahadthai[3]) && isset($mahadthai[3]['PROVINCE_NAME']) ? $mahadthai[3]['PROVINCE_NAME'] :"";
		if ($mahadthai_province0!=$user_province && $mahadthai_province1!=$user_province 
				&& $mahadthai_province2!=$user_province && $mahadthai_province3!=$user_province)
		{
			addLogSuspiciousMessage($citizen_id, $action);				
		}
		
		/*
		if (!empty($year))
		{
			$coop0 = isset($mahadthai[0]['IN_D_COOP']) ? getCoopByID($mahadthai[0]['IN_D_COOP']):"";
			$coop1 = isset($mahadthai[1]['IN_D_COOP']) ? getCoopByID($mahadthai[1]['IN_D_COOP']):"";
			$coop2 = isset($mahadthai[2]['IN_D_COOP']) ? getCoopByID($mahadthai[2]['IN_D_COOP']):"";
			$coop3 = isset($mahadthai[3]['IN_D_COOP']) ? getCoopByID($mahadthai[3]['IN_D_COOP']):"";
			
			if (!empty($coop0) && $coop0['PROVINCE_NAME']!=$user_province)
			{
				addLogSuspiciousMessage($citizen_id, $action);
			}
			if (!empty($coop1) && $coop1['PROVINCE_NAME']!=$user_province)
			{
				addLogSuspiciousMessage($citizen_id, $action);
			}
			if (!empty($coop2) && $coop2['PROVINCE_NAME']!=$user_province)
			{
				addLogSuspiciousMessage($citizen_id, $action);
			}
			if (!empty($coop3) && $coop3['PROVINCE_NAME']!=$user_province)
			{
				addLogSuspiciousMessage($citizen_id, $action);
			}	
			
		}*/
	}
}



if ( ! function_exists('canDelete'))
{
	function canDelete($citizen_id,$year)
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$user_id = $ci->session->userdata('auth_user_id');
		if (empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}		
		

		if ($ci->session->userdata('auth_role')=="admin") return true;

		if (canUpdate($citizen_id,$year))
			return true;

		return false;
	}
}

if ( ! function_exists('monitorUserViewActivity'))
{
	function monitorUserViewActivity($citizen_id,$year)
	{
		$ci =& get_instance();
		$ci->load->helper('user_group');
		
		$user_id = $ci->session->userdata('auth_user_id');
		$current_user_group = getAllCurrentUserGroupName();
		
		// query MAHADTHAI or survey

		// get province name
		//if found the citizen in mahadthai or survey
		// compare if user is in the authorize user groups 
		// if not, log the activity
		
		// if not found
		// ignore!!!
		

		return false;
	}
}


if ( ! function_exists('setSelectedSurveyYear'))
{
	function setSelectedSurveyYear($year)
	{
		$ci =& get_instance();
		$ci->session->set_userdata('selected_survey',$year);
	}
}

if ( ! function_exists('getSurveyYearDbTable'))
{
	function getSurveyYearDbTable($year)
	{
		return "SURVEY_".strtoupper($year);		
	}
}

if ( ! function_exists('getMahadthaiDbTable'))
{
	function getMahadthaiDbTable()
	{		
		$ci =& get_instance();
		$ci->load->library('session');
		$ci->load->helper('properties');
		$table = getStringSystemProperties("coop.mahadthai.db.table", "MASTER_DATA");
		
		return $table;
	}
}

if ( ! function_exists('getFarmerOneDbTable'))
{
	function getFarmerOneDbTable()
	{
		return "FARMERONE";
	}
}


if ( ! function_exists('getSurveyRecordByCitizenIDSelectedYear'))
{
	function getSurveyRecordByCitizenIDSelectedYear($citizen_id)
	{
		$year = getSelectedSurveyYear();
		$results = getSurveyRecordByCitizenIDYear($citizen_id, $year);
		
		return $results;
	}
}


if ( ! function_exists('countSurveyRecordByCitizenNameYear'))
{
	function countSurveyRecordByCitizenNameYear($keyword, $year)
	{
		$keyword = trim($keyword);
		$keyword = safeSQLValue($keyword);
		$keyword = str_replace("    ", " ",$keyword);
		$keyword = str_replace("   ", " ",$keyword);
		$keyword = str_replace("  ", " ",$keyword);
		
		$ci =& get_instance();
		$cache_key = "countSurveyRecordByCitizenNameYear_ $keyword _ $year";
		$ci =& get_instance();
		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));		
		//$data_cache = "";
		//if ($data_cache = $ci->cache->get($cache_key))
		//{
		//	return $data_cache;
		//}
					
		$ci->load->helper('user');
		$user_id = $ci->session->userdata('auth_user_id');
		$user = getUser($user_id);
		$user_province = $user['province'];
		$user_province = safeSQLValue($user_province);
		
		/*
		 $canViewAll = false;
		 $role = $ci->session->userdata('auth_role');
		 if ($role=="admin"
		 || $role=="central_manager"
		 || $role=="notcentral_manager"
		 )
		 {
		 $canViewAll = true;
		 }*/
		
		$canViewAll = true;
		 
		 
		if ($canViewAll)
		$user_province_obj = null;
		if (!empty($user_province))
		{
			$user_province_obj = getProvinceByName($user_province);
		}

		$ci->load->database();
		$ci->db->reset_query();
		$ci->db->select('count(*) as "totalnumber"');
		$table = getSurveyYearDbTable($year);
		$ci->db->from($table);
		
		if (!$canViewAll  && canAdd())
		{

			if (!empty($user_province))
			{
				if (strpos($keyword, ' ')!==false)
				{
					$temp = explode(" ", $keyword);
					if (!empty($temp) && isset($temp[0]) && isset($temp[1]))
					{
						$ci->db->where('PROVINCE_ID = '.$user_province_obj->PROVINCE_ID.'  AND ( "citizen_firstname" like \''.$temp[0].'\' OR "citizen_lastname" like \''.$temp[1].'\')');
					}
				}
				else
				{
					$ci->db->where('PROVINCE_ID = '.$user_province_obj->PROVINCE_ID.'  AND ( "citizen_firstname" like \'%'.$keyword.'%\' OR "citizen_lastname" like \'%'.$keyword.'%\')');
				}
			}
			else
			{
				die('User profile must specify province');
			}
		}
		else
		{

			
			if (strpos($keyword,' ')!==false)
			{
				$keyword = str_replace("  ", " ",$keyword);
				$keyword = strtolower($keyword);

				$temp = explode(" ", $keyword);
				if (!empty($temp) && isset($temp[0]) && isset($temp[1]))
				{
					$ci->db->where('LOWER("citizen_firstname") like \'%'.$temp[0].'%\' OR LOWER("citizen_lastname") like \'%'.$temp[1].'%\'');
				}
			}
			else
			{	$keyword = str_replace("  ", " ",$keyword);
				$keyword = strtolower($keyword);
				
				
				$ci->db->where(' "citizen_firstname" like \'%'.$keyword.'%\' OR "citizen_lastname" like \'%'.$keyword.'%\'');
				$lower_case = strtolower($keyword);
				$ci->db->or_where(' LOWER("citizen_firstname") like \'%'.$lower_case.'%\' OR LOWER("citizen_lastname") like \'%'.$lower_case.'%\'');
			}
		}
		
		$query = $ci->db->get();
		$result = $query->result_array();
		$sql = $ci->db->last_query();
		//echo "<pre>";
		//print_r($sql);
		//echo "</pre>";
		
		//if (empty($result))
		//{
		//	$ci->cache->save($cache_key,0, 300);
		//	return 0;
		//}
		//$ci->cache->save($cache_key,$result[0]['totalnumber'], 300);
		
		return $result[0]['totalnumber'];
	}
}

if ( ! function_exists('getSurveyRecordByCitizenNameYear'))
{
	function getSurveyRecordByCitizenNameYear($keyword, $year, $page=0, $range=25)
	{
		$keyword = trim($keyword);
		$keyword = safeSQLValue($keyword);
		$keyword = str_replace("   ", " ",$keyword);
		$keyword = str_replace("  ", " ",$keyword);
		$keyword = strtolower($keyword);
		
		$ci =& get_instance();
		$ci->load->helper('user');
		$user_id = $ci->session->userdata('auth_user_id');
		$user = getUser($user_id);
		$user_province = $user['province'];			
		$user_province = safeSQLValue($user_province);
		
		/*$cache_key = "surveyRecordByCitizenNameYear_k $keyword _ y $year _p $page _ r $range";
		$ci =& get_instance();
		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$data_cache = "";
		if ($data_cache = $ci->cache->get($cache_key))
		{
			return $data_cache;
		}*/
		
		
		/*
		 $canViewAll = false;
		 $role = $ci->session->userdata('auth_role');
		 if ($role=="admin"
		 || $role=="central_manager"
		 || $role=="notcentral_manager"
		 )
		 {
		 $canViewAll = true;
		 }
		if ($canViewAll)
		$user_province_obj = null;
		if (!empty($user_province))
		{
			$user_province_obj = getProvinceByName($user_province);
		}

		*/
		$canViewAll = true;
		
		$ci->load->database();
		$ci->db->select('*');
		$table = getSurveyYearDbTable($year);
		$ci->db->from($table);
		$start = $page * $range;
		$ci->db->limit($range, $start);
		
		if (!$canViewAll && canAdd())
		{
			if (!empty($user_province))
			{
				if (strpos($keyword, ' ')!==false)
				{
					$temp = explode(" ", $keyword);
					if (!empty($temp) && isset($temp[0]) && isset($temp[1]))
					{
						$ci->db->where('PROVINCE_ID = '.$user_province_obj->PROVINCE_ID.'   AND ( "citizen_firstname" like \''.$temp[0].'\' OR "citizen_lastname" like \''.$temp[1].'\')');
					}
				}
				else
				{
					$ci->db->where('PROVINCE_ID = '.$user_province_obj->PROVINCE_ID.'   AND ( "citizen_firstname" like \'%'.$keyword.'%\' OR "citizen_lastname" like \'%'.$keyword.'%\')');
				}
			}
			else
			{
				die('User profile must specify province');
			}
		}
		else 
		{		
			if (strpos($keyword,' ')!==false)
			{
				$keyword = str_replace("  ", " ",$keyword);
				$temp = explode(" ", $keyword);
				if (!empty($temp) && isset($temp[0]) && isset($temp[1]))
				{
					$ci->db->where('LOWER("citizen_firstname") like \'%'.$temp[0].'%\' OR LOWER("citizen_lastname") like \'%'.$temp[1].'%\'');
				}
			}
			else 
			{
				$ci->db->where(' "citizen_firstname" like \'%'.$keyword.'%\' OR "citizen_lastname" like \'%'.$keyword.'%\'');
				$lower_case = strtolower($keyword);
				$ci->db->or_where(' LOWER("citizen_firstname") like \'%'.$lower_case.'%\' OR LOWER("citizen_lastname") like \'%'.$lower_case.'%\'');
// 				$ci->db->like('"citizen_firstname"', $keyword);
// 				$ci->db->like('"citizen_lastname"', $keyword);				
			}			
		}
		
		$query = $ci->db->get();
		
		if (empty($query))
			return array();
			
			$results = $query->result_array();
			
			return $results;
		
		return $results;
	}
}

if ( ! function_exists('getSurveyRecordByCitizenIDYear'))
{
	function getSurveyRecordByCitizenIDYear($citizen_id,$year)
	{
		$ci =& get_instance();
		$ci->load->database();
		$table = getSurveyYearDbTable($year);
		$ci->db->select( "$table.*".',to_char("created_at", \'DD/MM/YYYY\') as "DATETH" ');
		$ci->db->from($table);
		$ci->db->where('citizen_id', $citizen_id);
		$query = $ci->db->get();
		
		if (empty($query))
			return array();
		
		$results = $query->result_array();
		
		return $results;
	}
}


if ( ! function_exists('getAllSurveyRecordByCitizenIDYear'))
{
	function getAllSurveyRecordByCitizenIDYear($citizen_id)
	{
		
		$ci =& get_instance();
		$ci->load->database();
		
		$allYears = getAllSurveyYears();
		$results = array();
		foreach ($allYears as $year=>$v)
		{
			$table = getSurveyYearDbTable($year);

			$ci->db->select( "$table.*".',to_char("created_at", \'DD/MM/YYYY\') as "DATETH" ');
			$ci->db->from($table);
			$ci->db->where('citizen_id', $citizen_id);
			$query = $ci->db->get();
			$result = $query->result_array();
			
			if (!empty($result))
				$results[$year] = $result;			
		}
		
		return $results;
	}
}

if ( ! function_exists('safeSQLValue'))
{
	function safeSQLValue($keyword)
	{
		$keyword = str_replace("%", "", $keyword);
		$keyword = str_replace("?", "", $keyword);
// 		TODO replace name table survery
// 		$keyword = str_replace("_", "", $keyword);
		$keyword = str_replace(";", "", $keyword);
		$keyword = str_replace("TRUNCATE", "", strtoupper($keyword));
		$keyword = str_replace("INSERT", "", strtoupper($keyword));
		$keyword = str_replace("DELETE", "", strtoupper($keyword));
		$keyword = str_replace("UPDATE", "", strtoupper($keyword));
		$keyword = str_replace("SELECT", "", strtoupper($keyword));
		$keyword = str_replace("FROM", "", strtoupper($keyword));
		$keyword = str_replace("WHERE", "", strtoupper($keyword));
		$keyword = str_replace("ALTER", "", strtoupper($keyword));
		$keyword = str_replace("DROP", "", strtoupper($keyword));
		$keyword = str_replace("ADD", "", strtoupper($keyword));
		
		return $keyword;
	}
}
	

if ( ! function_exists('getSurveyRecordByMemberIDSelectedYear'))
{
	function getSurveyRecordByMemberIDSelectedYear($coop_member_id)
	{
		$year = getSelectedSurveyYear();
		$results = getSurveyRecordByMemberIDYear($coop_member_id, $year);

		return $results;
	}
}

if ( ! function_exists('getSurveyRecordByMemberIDYear'))
{
	function getSurveyRecordByMemberIDYear($coop_member_id,$year)
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$table = getSurveyYearDbTable($year);
		$ci->db->from($table);
		$ci->db->where('coop_member_id', $coop_member_id);
		$query = $ci->db->get();

		if (empty($query))
			return array();

		$results = $query->result_array();

		return $results;
	}
}


if ( ! function_exists('getFarmerOneByCitizenID'))
{
	function getFarmerOneByCitizenID($citizen_id)
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$table = getFarmerOneDbTable();
		$ci->db->from($table);
		$ci->db->where('citizen_id', $citizen_id);
		$query = $ci->db->get();

		if (empty($query))
			return array();

		$results = $query->result_array();

		return $results;
	}
}


if ( ! function_exists('getMahadthaiByCitizenID'))
{
	function getMahadthaiByCitizenID($citizen_id)
	{
		$ci =& get_instance();
		$ci->load->database();
		
		$select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP,IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME ,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
		$table = getMahadthaiDbTable();
		$sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"citizen_id\" = '$citizen_id'";
		$query = $ci->db->query($sql);

		if (empty($query))
			return array();

		$results = $query->result_array();
		
		//print_r($results);

		return $results;
	}
}
if ( ! function_exists('getMahadthaiByCitizenIDAndCoopID'))
{
	function getMahadthaiByCitizenIDAndCoopID($citizen_id,$coop_id)
	{
		$ci =& get_instance();
		$ci->load->database();
		
		$select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP,IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME ,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
		$table = getMahadthaiDbTable();
		$sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"citizen_id\" = '$citizen_id' and \"D_COOP\" = '$coop_id' ";
		$query = $ci->db->query($sql);
		
		if (empty($query))
			return array();
			
			$results = $query->result_array();
			
			return $results;
	}
}

if ( ! function_exists('getSelectedSurveyYear'))
{
	function getSelectedSurveyYear()
	{
		$ci =& get_instance();
		$ci->load->library('session');
		$ci->load->helper('properties');
		$default = getStringSystemProperties("coop.default.selected.survey", "2018");
		$temp = $ci->session->all_userdata();
		if (isset($temp['selected_survey']))
			return $temp['selected_survey'];
		else
		{
			setSelectedSurveyYear($default);
			return $default;
		}		
	}
}


if ( ! function_exists('getDefaultBudgetYear'))
{
	function getDefaultBudgetYear()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->helper('properties');
		$selected_year_str = getStringSystemProperties("coop.all.selected.budget.years", "2018");
		return $selected_year_str;
	}
}


if ( ! function_exists('getAllBudgetYears'))
{
	function getAllBudgetYears()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->helper('properties');
		$all_year_str = getStringSystemProperties("coop.all.budget.years", "2017,2018");
		$result = explode(",",$all_year_str);
		return $result;
	}
}



if ( ! function_exists('getAllSurveyYears'))
{
	function getAllSurveyYears()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->helper('properties');
		
		$all_survey_str = getStringSystemProperties("coop.all.survey.years", "2018:2561,2017_1:2560-1");	
		$temp = explode(",",$all_survey_str);
		$result = array();
		if (!empty($temp))
		{
			foreach ($temp as $one){
				
				$pair = explode(":",$one);
				if (!empty($pair))
				{
					$result[$pair[0]] = $pair[1];
				}
			}
		}			
		return $result;
	}
	
	if (! function_exists('getAllMaster'))
	{
		function getAllMaster()
		{
			
			$cache_key = "All_master";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			$table  =getMahadthaiDbTable();
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();

				$table = getMahadthaiDbTable();
				
				$sql = "select IN_D_COOP,IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_PIN,OU_D_FLAG,IN_PROVICE_NAME from  $table where NUMBER_OF_COOP is not null and (OU_D_FLAG ='1' or OU_D_FLAG ='2')";
				$query = $ci->db->query($sql);
				
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				unset($results);
				$results = $ci->cache->get('All_master');
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllCoops'))
	{
		function getAllCoops()
		{
			$cache_key = "getAllCoops";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('COOP_INFO'))
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllProvinces'))
	{
		function getAllProvinces()
		{
			$cache_key = "PROVINCES";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";

			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('PROVINCE'))->order_by('PROVINCE_NAME', 'ASC')			
				->get();
				
	
				$temp = array();
				$results = $query->result();					
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
	
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllDistrict'))
	{
		function getAllDistrict()
		{
			$cache_key = "DISTRICT";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('DISTRICT'))
				->order_by("AMPHUR_CODE", "ASC")
				->get();
				
				$temp = array();
				$results = $query->result();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllTombon'))
	{
		function getAllTombon()
		{
			$cache_key = "TAMBON";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TAMBON'))
				->get();
				
				$temp = array();
				$results = $query->result();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllPlants'))
	{
		function getAllPlants()
		{
			$cache_key = "ALL_plants";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TYPE_PLANT'))
				->get();

				$temp = array();
				$results = $query->result();				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllRices'))
	{
		function getAllRices()
		{
			$cache_key = "getAllRices";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
			$data_cache = "";
				
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TYPE_PLANT'))
				->where('PLANT_TYPE', 'ข้าว')
				->get();
	
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
				
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllPlantTypes'))
	{
		function getAllPlantTypes()
		{
			$cache_key = "getAllPlantTypes";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
			$data_cache = "";
				
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('PLANT_TYPE')
				->from($ci->db->dbprefix('TYPE_PLANT'))
				->group_by('PLANT_TYPE')
				->get();
				
	
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
				
			return $data_cache;
		}
	}
	
	
	if (! function_exists('getAllInfras'))
	{
		function getAllInfras()
		{
			$cache_key = "getAllInfras";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TYPE_INFRA_USE'))
				->get();
				
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getAllInfraTypes'))
	{
		function getAllInfraTypes()
		{
			$cache_key = "getAllInfraTypes";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
			$data_cache = "";
				
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('INFRA_TYPE')
				->from($ci->db->dbprefix('TYPE_INFRA_USE'))
				->group_by('INFRA_TYPE')
				->get();
	
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
				
			return $data_cache;
		}
	}
	
	
	if (! function_exists('getAllLoans'))
	{
		function getAllLoans()
		{
			$cache_key = "getAllLoans";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TYPE_LOAN'))
				->get();
				
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	
	if (! function_exists('getProvinceByName'))
	{
		function getProvinceByName($name)
		{
			$all = getAllProvinces();
			foreach($all as $province)
			{
				if (trim($province->PROVINCE_NAME)==trim($name))
				{
					return $province;
				}
			}
			
			return null;
		}
	}
	
	if (! function_exists('getProvinceByID'))
	{
		function getProvinceByID($id)
		{
			$all = getAllProvinces();
			foreach($all as $province)
			{
				if (trim($province->PROVINCE_ID)==trim($id))
				{
					return $province;
				}
			}
			
			return array();
		}
	}
	
	
	if (! function_exists('getProvinceByCode'))
	{
		function getProvinceByCode($code)
		{
			$all = getAllProvinces();
			foreach($all as $province)
			{
				if (trim($province->PROVINCE_CODE)==trim($code))
				{
					return $province;
				}
			}
			
			return array();
		}
	}
	

	if (! function_exists('getAmphurByProvince'))
	{
		function getAmphurByProvince($province_id)
		{
			$cache_key = "AMPHUR_PROVID_$province_id";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))					
			{
				$to_return = array();
				
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('DISTRICT'))
				->where("PROV_PROVINCE_ID", $province_id)
				->get();
	
				$temp = array();
				$results = $query->result();
				
				$amphur = array();
				
				if (!empty($results))
				{
					foreach ($results as $item)
					{
						$to_return[$item->AMPHUR_ID]['amphor_code'] = $item->AMPHUR_CODE;
						$to_return[$item->AMPHUR_ID]['amphor_name'] = $item->AMPHUR_NAME;						
						$amphur[] = $item->AMPHUR_ID;
					}
					
					$ci->load->database();
					$query2 = $ci->db->SELECT('*')
					->from($ci->db->dbprefix('TAMBON'))
					->where_in('AMPHUR_AMPHUR_ID', $amphur)
					->get();
					$result2 = $query2->result();
					
					foreach ($result2 as $item)
					{
						
						if (!isset($to_return[$item->AMPHUR_AMPHUR_ID]['tambon']))
							$to_return[$item->AMPHUR_AMPHUR_ID]['tambon'] = array();
						
						$to_return[$item->AMPHUR_AMPHUR_ID]['tambon'][] = $item;					
					}					
				}
				
				$ci->cache->save($cache_key, $to_return, 30000);
				return $to_return;
			}
	
			return $data_cache;
		}
	}

	if (! function_exists('getAmphurByProvince2'))
	{
		function getAmphurByProvince2($province_id)
		{
			$cache_key = "AMPHUR_option1_$province_id";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$to_return = array();

				$ci->load->database();
				$query = $ci->db->SELECT('*')
					->from($ci->db->dbprefix('DISTRICT'))
					->where("PROV_PROVINCE_ID", $province_id)
					->get();

				$temp = array();
				$results = $query->result();

				$amphur = array();

				if (!empty($results))
				{  $i=0;
					foreach ($results as $item)
					{
						//print_r($item);

						$to_return[$i]['amphor_code'] = $item->AMPHUR_CODE;
						$to_return[$i]['amphor_name'] = $item->AMPHUR_NAME;
						$to_return[$i]['amphor_id'] = $item->AMPHUR_ID;
						//$amphur[] = $item->AMPHUR_ID;
						$i++;
					}



				}

				$ci->cache->save($cache_key, $to_return, 30000);
				return $to_return;
			}

			return $data_cache;
		}
	}
	
	if(!function_exists("getAmphurByID"))
	{
		function getAmphurByID($amphurByID)
		{
			$cache_key = "AmphurByID_option1_$amphurByID";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$to_return = array();
				
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('DISTRICT'))
				->where("AMPHUR_ID", $amphurByID)
				->get();
				
				$temp = array();
				$results = $query->result();
				
				$amphur = array();
				
				if (!empty($results))
				{  $i=0;
				foreach ($results as $item)
				{
					//print_r($item);
					
					$to_return[$i]['amphor_code'] = $item->AMPHUR_CODE;
					$to_return[$i]['amphor_name'] = $item->AMPHUR_NAME;
					$to_return[$i]['amphor_id'] = $item->AMPHUR_ID;
					//$amphur[] = $item->AMPHUR_ID;
					$i++;
				}
				
				
				
				}
				
				$ci->cache->save($cache_key, $to_return, 30000);
				return $to_return;
			}
			
			return $data_cache;
		}
	}
	
	
	if (! function_exists('getAmphurByProvinceIDAmphurName'))
	{
		function getAmphurByProvinceIDAmphurName($province_id, $amphur_name)
		{
			$amphurs = getAmphurByProvince2($province_id);

			if (!empty($amphurs))
			{
				foreach($amphurs as $amp)
				{
					if ($province_id==21)
					{
						$amp['amphor_name'] = str_replace("เขต", "", $amp['amphor_name']);
					}
					else
					{
						$amp['amphor_name'] = str_replace("อ.", "", $amp['amphor_name']);
					}
					
					if (trim($amphur_name)==trim($amp['amphor_name']))
						return $amp;				
				}
			}
		}
	}	
	
	if (! function_exists('getTambolByAmphur'))
	{
		function getTambolByAmphur($amphur)
		{
			$cache_key = "Tambol1_option3_$amphur";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			//{
				$to_return = array();

				$ci->load->database();
				$query = $ci->db->SELECT('*')
					->from($ci->db->dbprefix('TAMBON'))
					->where_in('AMPHUR_AMPHUR_ID', $amphur)
					->get();

				$temp = array();
				$results = $query->result();  //echo "x".$results[0]->TAMBON_NAME;
				// print_r($results);
			    for($i=0;$i<=count($results);$i++){ // echo $results[0]->TAMBON_NAME;
					if(isset($results[$i]->TAMBON_CODE)) {
						$to_return[$i]['tambol_code'] = $results[$i]->TAMBON_CODE;
						$to_return[$i]['tambol_name'] = $results[$i]->TAMBON_NAME;
						$to_return[$i]['tambol_id'] = $results[$i]->TAMBON_ID;
					}
				}
				/*

				if (!empty($results))
				{  $i=0;
					foreach ($results as $item)
					{
						 // print_r($item);

						$to_return[$i]['tambol_code'] = $item->TAMBON_CODE;
						$to_return[$i]['tambol_name'] = $item->TAMBON_NAME;
						$to_return[$i]['tambol_id'] = $item->TAMBON_ID;
						//$amphur[] = $item->AMPHUR_ID;
						$i++;
					}



				}*/

				//$ci->cache->save($cache_key, $to_return, 30000);
				return $to_return;
			//}

			return $data_cache;
		}
	}
	
	
	
	if (! function_exists('getTambolByAmphurIDTambolName'))
	{
		function getTambolByAmphurIDTambolName($amphur, $tambol_name)
		{
			$all = getTambolByAmphur($amphur);
			if (!empty($all))
			{
				foreach ($all as $tambol)
				{
					if (trim($tambol_name)==trim($tambol['tambol_name']))
						return $tambol;
				}
			}
			return array();
		}
	}
	
	if(!function_exists('getTambolByID'))
	{
		function getTambolByID($tombolId)
		{
			if(!empty($tombolId) && !is_null($tombolId)){
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('TAMBON'))
				->where('TAMBON_ID',$tombolId)
				->get();
				
				$temp = array();
				$results = $query->result();
				
				if(!empty($results))
				
				
					return $results;
			}
			else
			{
				return null;	
			}
		}
	}
	
	if(!function_exists('getCoopsByIDs'))
	{
		function getCoopsByIDs($list_org_Id,$provinces=null,$district=null,$filter_coop=null) {
			if(is_array($list_org_Id) && sizeof($list_org_Id)>0)
			{
				$ci =& get_instance();
				$ci->load->database();
				$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
				
				
				
				
				if(!is_null($provinces) && !empty($provinces) && $provinces !='')
				{
// 					$province_id = getProvinceByName($provinces);
					$ci->db->where('PROVINCE_ID',$provinces);
				}
				if(!is_null($district) && !empty($district) && $district !='')
				{
					$ci->db->where('AMPHUR_ID',$district);
				}
				if(!is_null($filter_coop) && !empty($filter_coop) && $filter_coop !='')
				{
					$ci->db->where('REGISTRY_NO_2',$filter_coop);
				}
// 				$ci->db->distinct('REGISTRY_NO_2');
				$ci->db->where_in('ORG_ID',$list_org_Id);
				$ci->db->where('REGISTRY_NO_2 !=',"0");
				$result_array = $ci->db->get('COOP_INFO')->result_array();
				
				$result = array();
				foreach ($result_array as $data)
				{
					
// 					 if(is_null($provinces) && empty($provinces) && is_null($district) && empty($district) && is_null($filter_coop) && empty($filter_coop)){
						$result[] = $data;
					
				}
				
				
				
				return $result;
			}
		}
	}
	
	
	if (! function_exists('getCoopByID'))
	{
		
		function getCoopByID($coop_id)
		{
			$coop_id = trim($coop_id);
			
			if (!is_numeric($coop_id))
				return null;
				
				/*$test = array(
				 'COOP_ID' => 1593,
				 'COOP_NAME_TH' => 'สหกรณ์การเกษตรในเขตปฏิรูปที่ดินบ่อทอง จำกัด',
				 'LOC_ADDR' => '101 ถนนพหลโยธิน หมู่ที่ 4',
				 'TAMBON_ID' => '7106',
				 'TAMBON_NAME' => 'บ่อทอง',
				 'AMPHUR_ID' => '125',
				 'AMPHUR_NAME' => 'หนองม่วง',
				 'PROVINCE_ID' => '28',
				 'PROVINCE_NAME' => 'ลพบุรี',
				 'TEL_NO' => '0 3642 3289',
				 'ZIP_CODE' => '15170',
				 'FAX_NO' => '',
				 'REGISTRY_DATE' => '02/06/2535',
				 'REGISTRY_NO' => 'ก.008535',
				 'COOP_TYPE' => '1',
				 'COOP_TYPE_NAME' => 'สหกรณ์การเกษตร',
				 'INIT_MEMBER' => '159',
				 'ACCT_MONTH_END' => '7',
				 'INIT_VALUE' => '23850',
				 'COOP_STATUS' => '2',
				 'COOP_STATUS_DATE' => '02/06/2535',
				 'STATUS_NAME' => 'ดำเนินการ',
				 'CHARTER_DATE' => '27/09/2545',
				 'CHARTER_NO' => 'ก.090345',
				 'COOP_STRUC_GROUP_ID' => '29',
				 'COOP_SCOPE' => 'ในเขตปฏิรูปที่ดิน ตำบลบ่อทอง อำเภอหนองม่วง',
				 'GROUP_NAME_TH' => 'สหกรณ์การเกษตรปฎิรูปที่ดิน',
				 'ORG_NAME' => 'สำนักงานสหกรณ์จังหวัดลพบุรี',
				 'ORG_ORG_ID' => '4704',
				 'CAD_ID' => '9914',
				 'ORG_ID' => '4704',
				 'REGISTRY_NO_2' => '1600000125357'
				 );
				 return $test;
				 */
				
				$cache_key = "All_coops_$coop_id";
				$ci =& get_instance();
				$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				$ci->load->helper('properties');				
				$data_cache = "";

				if ( ! $data_cache = $ci->cache->get($cache_key))
				{
					$ci->load->database();
					$query = $ci->db->SELECT(' * ')
					->from($ci->db->dbprefix('COOP_INFO'))
					->order_by("COOP_NAME_TH", "asc")
					->where("REGISTRY_NO_2", $coop_id)
					->get();
					
					$to_return = array();
					$results = $query->result_array();
					if (!empty($results))
					{
						foreach ($results as $row ) {
							$to_return[trim($row['REGISTRY_NO_2'])] = $row;
						}
					}
					
					$ci->cache->save($cache_key, $to_return, 300000);
				
					if (isset($to_return[$coop_id])) return $to_return[$coop_id]; else return null;
				}
				if (isset($data_cache[$coop_id])) return$data_cache[$coop_id]; else return null;
		}
	}
	
	
	if (! function_exists('getCoopByIDxxx'))
	{
	
		function getCoopByIDxxx($coop_id)
		{
			$coop_id = trim($coop_id);
				
			if (!is_numeric($coop_id))
				return null;
				
			/*$test = array(
					'COOP_ID' => 1593,
					'COOP_NAME_TH' => 'สหกรณ์การเกษตรในเขตปฏิรูปที่ดินบ่อทอง จำกัด',
					'LOC_ADDR' => '101 ถนนพหลโยธิน หมู่ที่ 4',
					'TAMBON_ID' => '7106',
					'TAMBON_NAME' => 'บ่อทอง',
					'AMPHUR_ID' => '125',
					'AMPHUR_NAME' => 'หนองม่วง',
					'PROVINCE_ID' => '28',
					'PROVINCE_NAME' => 'ลพบุรี',
					'TEL_NO' => '0 3642 3289',
					'ZIP_CODE' => '15170',
					'FAX_NO' => '',
					'REGISTRY_DATE' => '02/06/2535',
					'REGISTRY_NO' => 'ก.008535',
					'COOP_TYPE' => '1',
					'COOP_TYPE_NAME' => 'สหกรณ์การเกษตร',
					'INIT_MEMBER' => '159',
					'ACCT_MONTH_END' => '7',
					'INIT_VALUE' => '23850',
					'COOP_STATUS' => '2',
					'COOP_STATUS_DATE' => '02/06/2535',
					'STATUS_NAME' => 'ดำเนินการ',
					'CHARTER_DATE' => '27/09/2545',
					'CHARTER_NO' => 'ก.090345',
					'COOP_STRUC_GROUP_ID' => '29',
					'COOP_SCOPE' => 'ในเขตปฏิรูปที่ดิน ตำบลบ่อทอง อำเภอหนองม่วง',
					'GROUP_NAME_TH' => 'สหกรณ์การเกษตรปฎิรูปที่ดิน',
					'ORG_NAME' => 'สำนักงานสหกรณ์จังหวัดลพบุรี',
					'ORG_ORG_ID' => '4704',
					'CAD_ID' => '9914',
					'ORG_ID' => '4704',
					'REGISTRY_NO_2' => '1600000125357'
			);
			return $test;
			*/	
				
			$cache_key = "All_coops";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$ci->load->helper('properties');
	
			$data_cache = "";
// 			if ( ! $data_cache = $ci->cache->get($cache_key))
// 			{				
				$ci->load->database();
				$query = $ci->db->SELECT(' * ')
				->from($ci->db->dbprefix('COOP_INFO'))					
				->get();
				
				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{
					foreach ($results as $row ) {
						$to_return[trim($row['REGISTRY_NO_2'])] = $row;
					}
				}
				
// 				$ci->cache->save($cache_key, $to_return, 300000);
	
				if (isset($to_return[$coop_id])) return $to_return[$coop_id]; else return null;
// 			}
			if (isset($data_cache[$coop_id])) return$data_cache[$coop_id]; else return null;
		}
	}
	
	if(!function_exists("getProvinceOfKhetById"))
	{
		function getProvinceOfKhetById($khetId,$filter_provinces=null,$filter_district=null,$filter_coop=null)
		{
			//ini_set("memory_limit", "3024M");
			if(isset($khetId) && !empty($khetId)){
				$cache_key = "ProvinceOfKhet";
				$ci =& get_instance();
				$ci->load->database();
				if(!$data = $ci->cache->get($cache_key)){
					
					$ci->db->SELECT('*');
					$ci->db->from($ci->db->dbprefix('KHET'));
					$ci->db->order_by("COL008", "ASC");
					$ci->db->order_by("COL007", "ASC");
					$query = $ci->db->get();
					$ci->cache->save($cache_key, $query->result_array(), 300000);
				}
				$data = $ci->cache->get($cache_key);

				$temp_data = array();
				$list_data = array();
// 				if(!empty($filter_provinces))
// 				$list_data =getProvinceByName($filter_provinces);
				
// 				echo "<pre>";print_r($data);echo "</pre>";
				foreach ($data as $v)
				{

					if(!empty($filter_provinces) &&  ($filter_provinces == $v['COL011'] || $filter_provinces == $v['COL008'] || $filter_provinces ==$v['COL006'] ) && $v['COL004'] == $khetId)
					{
						$temp_data[] = $v;
					}
					else if(empty($filter_provinces) && $v['COL004'] == intval($khetId)){

						$temp_data[] = $v;
					}
				}
				
				return $temp_data;
				
				
				
// 				$ci->cache->save($cache_key, $to_return, 300000);
				
			}
		}
	}
	
	if (! function_exists('getOrgByID'))
	{
	
		function getOrgByID($org_id)
		{
			
			if (!is_numeric($org_id))
				return null;
				
			$org_id = trim($org_id);
				
			/*
			$test = array(
					'seq'=> '54',
					'khet_id'=> '14',
					'khet_desc'=> 'เขตตรวจราชการที่ 14',
					'khet_id_sort'=> '14',
					'khet_group'=> '6',
					'province_id'=> '80',
					'province_name'=> 'ชัยภูมิ',
					'province_name_sort'=> 'ชัยภูมิ',
					'phak_id'=> '4',
					'phak'=> 'ตอ.เฉียงเหนือ',
					'org_org_id'=> '4704',
					'org_name'=> 'สำนักงานสหกรณ์จังหวัดชัยภูมิ',
					'in_cityhall'=> 'No',
					'member_all'=> '',
					'member_key'=> '',
					'input_date'=> ''
			);
			return $test;
			*/
	
			$cache_key = "allOrgs";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
	
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('khet_inspect'))
				->get();
				
				$to_return = array();
				$results = $query->result_array();
	
				if (!empty($results))
				{
					foreach ($results as $row ) {
						$to_return[trim($row['org_org_id'])] = $row;
					}
				}
	
				$ci->cache->save($cache_key, $to_return, 300000);
	
				if (isset($to_return[$org_id])) return $to_return[$org_id]; else return null;
			}
			if (isset($data_cache[$org_id])) return $data_cache[$org_id]; else return null;
		}
	}
	
	
	if (! function_exists('getAllKhetByID'))
	{	
		function getAllKhetByID()
		{
			$cache_key = "getAllKhetByID";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
	
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('khet_inspect'))
				->get();
	
				$to_return = array();
				$results = $query->result_array();
	
				foreach ($results as $row ) {
					$to_return[trim($row['khet_id'])] = is_array($to_return[trim($row['khet_id'])]) ? $to_return[trim($row['khet_id'])] : array();
					$to_return[trim($row['khet_id'])][] = $row;
				}
	
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}

	
	
	if (! function_exists('getAllKhetRecord'))
	{
		function getAllKhetRecord()
		{
			$cache_key = "getAllKhetRecord";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('KHET'))
				->get();
				
				$to_return = array();
				$results = $query->result_array();
				
				foreach ($results as $row ) {
					
					$row['province_name_sort'] = trim($row['COL007']);
					$row['province_name'] = trim($row['COL008']);
					$row['org_org_id'] = trim($row['COL011']);
					$row['khet_id'] = trim($row['COL004']);
					$to_return[] = $row;
				}
				
				
				
				$ci->cache->save($cache_key, $to_return, 300000);
				
				return $to_return;
			}
			return $data_cache;
		}
	}
	
	
	
	
	
	if (! function_exists('getOrgIdByProvinceName'))
	{
		function getOrgIdByProvinceName($province_name)
		{

			$all_orgs = getAllKhetRecord();
			foreach ($all_orgs as $org)
			{
				//echo '<pre>org[province_name_sort] ';
				//print_r($org['province_name_sort']);
				//print_r($org['org_org_id']);
				//echo '</pre>';
				if (trim($org['province_name'])==trim($province_name))
				{
					return $org['org_org_id'];
					
				}
				if (strpos($org['province_name_sort'],'1')>0 && strpos($province_name,'1')>0 )
				{
					return $org['org_org_id'];
					
				}
				if (strpos($org['province_name_sort'],'2')>0 && strpos($province_name,'2')>0 )
				{
					return $org['org_org_id'];
				}
				
			}
		}
	}
	
	
	
	
	
	
	if (! function_exists('getAllKhet'))
	{
		function getAllKhet()
		{
			$cache_key = "getAllKhet";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('khet_inspect'))
				->get();
				
				$to_return = array();
				$results = $query->result_array();
				
				foreach ($results as $row ) {
					$to_return[trim($row['khet_id'])] = $row;
				}
				
				$ci->cache->save($cache_key, $to_return, 300000);
				
				return $to_return;
			}
			return $data_cache;
		}
	}

	if (! function_exists('getAllOrg'))
	{
		function getAllOrg()
		{
			$cache_key = "getAllOrg";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{
				$ci->load->database();
				$query = $ci->db->SELECT('org_org_id,org_name')
				->from($ci->db->dbprefix('khet_inspect'))
				->get();
				
				$to_return = array();
				$results = $query->result_array();
				
				foreach ($results as $key => $row ) {
					$to_return[$key] = $row;
				}
				
				$ci->cache->save($cache_key, $to_return, 300000);
				
				return $to_return;
			}
			return $data_cache;
		}
	}

	if (! function_exists('getOrgIdByProvinceId'))
	{
		function getOrgIdByProvinceId($province_id)
		{
			$cache_key = "getOrgIdByProvinceId";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{
				$ci->load->database();
				$query = $ci->db->SELECT('org_org_id,org_name')
				->from($ci->db->dbprefix('khet_inspect'))
				->where("province_id", $province_id)
				->get();
				
				$to_return = array();
				$results = $query->result_array();
				
				foreach ($results as $key => $row ) {
					$to_return[$key] = $row;
				}
				
				$ci->cache->save($cache_key, $to_return, 300000);
				
				return $to_return;
			}
			return $data_cache;
		}
	}
	
	if (! function_exists('getAliveMemberByCitizenID'))
	{
		
		function getAliveMemberByCitizenID($citizen_id)
		{
			$citizen_id = trim($citizen_id);
			
			if (!is_numeric($citizen_id))
				return null;
				
				/*
				 $test = array();
				 $test[] = array(
				 'D_ID' => 509,
				 'D_YEAR' =>null,
				 'D_PIN' => '3160300354651',
				 'D_MDATE' => '09/09/3100',
				 'D_NSTOCK' => '305',
				 'D_VSTOCK' => '3050',
				 'D_TYPE' => 1,
				 'D_COOP' => '1600000125357',
				 'D_GROUP' => '01',
				 'D_PNAME' => 'จินดา',
				 'D_SNAME' => 'เชื่อมหอม',
				 'D_PREFIX' => 'นาง',
				 'D_NATION' => 'ไทย'
				 );
				 return $test;
				 */
				
				$cache_key = "getMemberByCitizenID_$citizen_id";
				$ci =& get_instance();
				$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
				$data_cache = "";
				//if ( ! $data_cache = $ci->cache->get($cache_key))
				if (true)
				{
					
					$select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP, IN_D_COOP as "COOP_ID",IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
					
					$table = getMahadthaiDbTable();
					
					$sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"citizen_id\" = '$citizen_id' and OU_D_STATUS_TYPE not in (1,11,13)";
					$query = $ci->db->query($sql);
					
					$to_return = array();
					$results = $query->result_array();
					if (!empty($results))
					{
						foreach ($results as $row ) {
							$to_return[] = $row;
						}
					}
					$ci->cache->save($cache_key, $to_return, 300000);
					
					return $to_return;
				}
				return $data_cache;
		}
	}
	
	
	if (! function_exists('getMemberByCitizenID'))
	{
	
		function getMemberByCitizenID($citizen_id)
		{
			$citizen_id = trim($citizen_id);
				
			if (!is_numeric($citizen_id))
				return null;
				
			/*
			$test = array();
			$test[] = array(
					'D_ID' => 509,
					'D_YEAR' =>null,
					'D_PIN' => '3160300354651',
					'D_MDATE' => '09/09/3100',
					'D_NSTOCK' => '305',
					'D_VSTOCK' => '3050',
					'D_TYPE' => 1,
					'D_COOP' => '1600000125357',
					'D_GROUP' => '01',
					'D_PNAME' => 'จินดา',
					'D_SNAME' => 'เชื่อมหอม',
					'D_PREFIX' => 'นาง',
					'D_NATION' => 'ไทย'
			);
			return $test;
			*/
				
			$cache_key = "getMemberByCitizenID_$citizen_id";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{

				// $select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP, IN_D_COOP as "COOP_ID",IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
				$select = 'IN_D_COOP,"citizen_id",COOP_ID,IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,OU_D_PNAME,OU_D_SNAME,OU_D_HNO,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_BDATE,OU_D_ID,OU_D_STATUS_TYPE,IN_PROVICE_NAME';
				
				$table = getMahadthaiDbTable();
				
				// $sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"citizen_id\" = '$citizen_id'"; 
				// $sql = "select * from view_citizen WHERE \"citizen_id\" = '$citizen_id'"; 
				// $sql = "select DISTINCT $select from view_citizen WHERE \"citizen_id\" = '$citizen_id'";//old
				$sql = "SELECT * FROM view_master_data_use WHERE OU_D_ID = '$citizen_id'";//new
				// echo print_r($sql);die();
				$query = $ci->db->query($sql);

				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return[] = $row;
					}
				}
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}

	if (! function_exists('countCoopCiticen'))
	{
	
		function countCoopCiticen($citizen_id)
		{
			$citizen_id = trim($citizen_id);
				
			if (!is_numeric($citizen_id))
				return null;
				

			$cache_key = "countCoopCiticen$citizen_id";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{

				// $select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP, IN_D_COOP as "COOP_ID",IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
				$select = '"citizen_id",COOP_ID';
				
				$table = getMahadthaiDbTable();
				
				// $sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"citizen_id\" = '$citizen_id'"; 
				// $sql = "select * from view_citizen WHERE \"citizen_id\" = '$citizen_id'"; 
				$sql = "select count(COOP_ID) as sss from (select DISTINCT $select from view_citizen WHERE \"citizen_id\" = '$citizen_id')";
				// echo print_r($sql);die();
				$query = $ci->db->query($sql);

				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return[] = $row;
					}
				}
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}
	
	
	
	
	
	/*
	
	if (! function_exists('getCoopByID'))
	{
		
		function getCoopByID($coop_id)
		{
			$coop_id = trim($coop_id);
			
			if (!is_numeric($coop_id))
				return null;
					
			$test = array(
					'COOP_ID' => 1593,
					'COOP_NAME_TH' => 'สหกรณ์การเกษตรในเขตปฏิรูปที่ดินบ่อทอง จำกัด',
					'LOC_ADDR' => '101 ถนนพหลโยธิน หมู่ที่ 4',
					'TAMBON_ID' => '7106',
					'TAMBON_NAME' => 'บ่อทอง',
					'AMPHUR_ID' => '125',
					'AMPHUR_NAME' => 'หนองม่วง',
					'PROVINCE_ID' => '28',
					'PROVINCE_NAME' => 'ลพบุรี',
					'TEL_NO' => '0 3642 3289',
					'ZIP_CODE' => '15170',
					'FAX_NO' => '',
					'REGISTRY_DATE' => '02/06/2535',
					'REGISTRY_NO' => 'ก.008535',
					'COOP_TYPE' => '1',
					'COOP_TYPE_NAME' => 'สหกรณ์การเกษตร',
					'INIT_MEMBER' => '159',
					'ACCT_MONTH_END' => '7',
					'INIT_VALUE' => '23850',
					'COOP_STATUS' => '2',
					'COOP_STATUS_DATE' => '02/06/2535',
					'STATUS_NAME' => 'ดำเนินการ',
					'CHARTER_DATE' => '27/09/2545',
					'CHARTER_NO' => 'ก.090345',
					'COOP_STRUC_GROUP_ID' => '29',
					'COOP_SCOPE' => 'ในเขตปฏิรูปที่ดิน ตำบลบ่อทอง อำเภอหนองม่วง',
					'GROUP_NAME_TH' => 'สหกรณ์การเกษตรปฎิรูปที่ดิน',
					'ORG_NAME' => 'สำนักงานสหกรณ์จังหวัดลพบุรี',
					'ORG_ORG_ID' => '4704',
					'CAD_ID' => '9914',
					'ORG_ID' => '4704',
					'REGISTRY_NO_2' => '1600000125357'			
			);
			return $test;
			
			
			$cache_key = "All_coops";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

			$ci->load->helper('properties');

			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				try {
					
					$hostname = getStringSystemProperties("coop.member.hostname", "54.251.97.78");
					$port = getStringSystemProperties("coop.member.port", "1433");;
					$dbname = getStringSystemProperties("coop.member.dbname", "member2561");
					$username = getStringSystemProperties("coop.member.dbusername", "analytic");
					$pw = getStringSystemProperties("coop.member.dbpw", "analytic");
					$CHAR_SET = getStringSystemProperties("coop.member.charset", "charset=utf8");
					$args = array(
							PDO::ATTR_TIMEOUT => 160,
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					);
					$dbh = new PDO ("dblib:version=7.0;host=$hostname:$port;dbname=$dbname;$CHAR_SET","$username","$pw",$args);
				} catch (PDOException $e) {
					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
					exit;
				}
				
				$to_return = array();
				$stmt = $dbh->prepare("select * from COOP_INFO");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$to_return[trim($row['REGISTRY_NO_2'])] = $row;
				}
				unset($dbh); unset($stmt);
		
				$ci->cache->save($cache_key, $to_return, 300000);
				
				if (isset($to_return[$coop_id])) return $to_return[$coop_id]; else return null;
			}		
			if (isset($data_cache[$coop_id])) return$data_cache[$coop_id]; else return null;
		}		
	}
	
	
	if (! function_exists('getOrgByID'))
	{
	
		function getOrgByID($org_id)
		{
			if (!is_numeric($org_id))
				return null;
			
			$org_id = trim($org_id);
			
			$test = array(					
					'seq'=> '54',
					'khet_id'=> '14',
					'khet_desc'=> 'เขตตรวจราชการที่ 14',
					'khet_id_sort'=> '14',
					'khet_group'=> '6',
					'province_id'=> '80',
					'province_name'=> 'ชัยภูมิ',
					'province_name_sort'=> 'ชัยภูมิ',
					'phak_id'=> '4',
					'phak'=> 'ตอ.เฉียงเหนือ',
					'org_org_id'=> '4704',
					'org_name'=> 'สำนักงานสหกรณ์จังหวัดชัยภูมิ',
					'in_cityhall'=> 'No',
					'member_all'=> '',
					'member_key'=> '',
					'input_date'=> ''
			);
			return $test;
				
			$cache_key = "allOrgs";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$ci->load->helper('properties');				
				
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				try {
						
					$hostname = getStringSystemProperties("coop.member.hostname", "54.251.97.78");
					$port = getStringSystemProperties("coop.member.port", "1433");;
					$dbname = getStringSystemProperties("coop.member.dbname", "member2561");
					$username = getStringSystemProperties("coop.member.dbusername", "analytic");
					$pw = getStringSystemProperties("coop.member.dbpw", "analytic");
					$CHAR_SET = getStringSystemProperties("coop.member.charset", "charset=utf8");
					$args = array(
							PDO::ATTR_TIMEOUT => 160,
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					);
					$dbh = new PDO ("dblib:version=7.0;host=$hostname:$port;dbname=$dbname;$CHAR_SET","$username","$pw",$args);
				} catch (PDOException $e) {
					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
					exit;
				}
	
				$to_return = array();
				$stmt = $dbh->prepare("select * from khet_inspect");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$to_return[trim($row['org_org_id'])] = $row;
				}
				unset($dbh); unset($stmt);
	
				$ci->cache->save($cache_key, $to_return, 300000);
	
				if (isset($to_return[$org_id])) return $to_return[$org_id]; else return null;
			}
			if (isset($data_cache[$org_id])) return $data_cache[$org_id]; else return null;
		}
	}
	
	
	if (! function_exists('getMemberByCitizenID'))
	{
	
		function getMemberByCitizenID($citizen_id)
		{
			$citizen_id = trim($citizen_id);
			
			if (!is_numeric($citizen_id))
				return null;
			
			
			$test = array();			
			$test[] = array(
					'D_ID' => 509,
					'D_YEAR' =>null,
					'D_PIN' => '3160300354651',
					'D_MDATE' => '09/09/3100',
					'D_NSTOCK' => '305',
					'D_VSTOCK' => '3050',
					'D_TYPE' => 1,
					'D_COOP' => '1600000125357',
					'D_GROUP' => '01',
					'D_PNAME' => 'จินดา',
					'D_SNAME' => 'เชื่อมหอม',
					'D_PREFIX' => 'นาง',
					'D_NATION' => 'ไทย'
			);
			return $test;
			
			
			$cache_key = "getMemberByCitizenID_$citizen_id";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			//if (true)
			{
				try {
					$hostname = getStringSystemProperties("coop.member.hostname", "54.251.97.78");
					$port = getStringSystemProperties("coop.member.port", "1433");;
					$dbname = getStringSystemProperties("coop.member.dbname", "member2561");
					$username = getStringSystemProperties("coop.member.dbusername", "analytic");
					$pw = getStringSystemProperties("coop.member.dbpw", "analytic");
					$CHAR_SET = getStringSystemProperties("coop.member.charset", "charset=utf8");
					$args = array(
							PDO::ATTR_TIMEOUT => 160,
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					);
					$dbh = new PDO ("dblib:version=7.0;host=$hostname:$port;dbname=$dbname;$CHAR_SET","$username","$pw",$args);
				} catch (PDOException $e) {
					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
					exit;
				}
	
				$to_return = array();
				$stmt = $dbh->prepare("select * from ta_member where D_PIN='$citizen_id'");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$to_return[] = $row;
				}
				unset($dbh); unset($stmt);
	
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}
	*/
	

			
	/*
	 * get all coops
	 * return list coops format array
	 */
	if(! function_exists('getCoopsByKeyword')){
		function getCoopsByKeyword($keyword, $keyword2=""){
			
			$cache_key = "All_coops";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{			
				$ci->load->database();
				$query = $ci->db->SELECT('COOP_NAME_TH,REGISTRY_NO_2,PROVINCE_NAME')
				->from($ci->db->dbprefix('COOP_INFO'))
				->get();
				
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 3000000);
				
				$data_cache = $results;				
			}
			
			$return_results = array();
			if (!empty($data_cache))
			{
				foreach ($data_cache as $item)
				{
					if (!empty($keyword2))
					{
						if ((strpos($item['COOP_NAME_TH'],$keyword)!==FALSE || strpos($item['REGISTRY_NO_2'],$keyword)!==FALSE) && strpos($item['PROVINCE_NAME'],$keyword2)!==FALSE)
						{
							$name = trim($item['COOP_NAME_TH']);
							$temp = array();
							$temp['user_id'] = $item['REGISTRY_NO_2'];
							$temp['name'] = $name;
							$temp['username'] = trim($item['COOP_NAME_TH']);
							$temp['coop_reg'] = trim($item['REGISTRY_NO_2']);
							$temp['id'] = trim($item['REGISTRY_NO_2']);
							$temp['text'] = trim($name);
							$return_results[] = $temp;
						}
					}
					else 
					{
						if (strpos($item['COOP_NAME_TH'],$keyword)!==FALSE || strpos($item['REGISTRY_NO_2'],$keyword)!==FALSE)
						{
							$name = trim($item['COOP_NAME_TH']);
							$temp = array();
							$temp['user_id'] = $item['REGISTRY_NO_2'];
							$temp['name'] = $name;
							$temp['username'] = trim($item['COOP_NAME_TH']);
							$temp['coop_reg'] = trim($item['REGISTRY_NO_2']);
							$temp['id'] = trim($item['REGISTRY_NO_2']);
							$temp['text'] = trim($name);
							$return_results[] = $temp;
						}
						
					}
					
				}
			}
			
			return $return_results;
		}
	}
	
	
	/*
	 * get all coops
	 * return list coops format array
	 */
	if(! function_exists('getCoopsByKeyword2')){
		function getCoopsByKeyword2($keyword){
				
			$cache_key = "All_coops";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
				
			$data_cache = "";
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('COOP_NAME_TH,REGISTRY_NO_2,PROVINCE_NAME')
				->from($ci->db->dbprefix('COOP_INFO'))
				->get();
	
				$results = $query->result_array();
	
				$ci->cache->save($cache_key, $results, 3000000);
	
				$data_cache = $results;
			}
				
			$return_results = array();
			if (!empty($data_cache))
			{
				foreach ($data_cache as $item)
				{
						if (strpos($item['COOP_NAME_TH'],$keyword)!==FALSE || strpos($item['REGISTRY_NO_2'],$keyword)!==FALSE)
						{
							$name = trim($item['COOP_NAME_TH']);
							$temp = array();
							$temp['user_id'] = $item['REGISTRY_NO_2'];
							$temp['name'] = $name;
							$temp['username'] = trim($item['COOP_NAME_TH']);
							$temp['coop_reg'] = trim($item['REGISTRY_NO_2']);
							$temp['id'] = trim($item['REGISTRY_NO_2']);
							$temp['text'] = trim($name);
							$return_results[] = $temp;
						}					
				}
			}
				
			return $return_results;
		}
	}
	
	
	if(! function_exists('countMembersByYearProvinceCoopID')){
		function countMembersByYearProvinceCoopID($year, $province, $coop_id){
			
			$cache_key = "countMembersByYearProvinceCoopID";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$year = safeSQLValue($year);
			$province = safeSQLValue($province);
			$coop_id = safeSQLValue($coop_id);
			
			$ci->load->database();
			$ci->db->reset_query();
			$ci->db->select('count(*) as "totalnumber"');
			$table = getSurveyYearDbTable($year);
			$ci->db->from($table);
			$ci->db->where("COOP_ID", $coop_id);
			
			$query = $ci->db->get();
			$result = $query->result_array();
			$ci->db->reset_query();
			
			if (empty($result))
			{
				return 0;
			}
			
			return $result[0]['totalnumber'];
		}
	}
	if(! function_exists('getMembersByYearProvinceCoopID')){
		function getMembersByYearProvinceCoopID($year, $province, $coop_id, $page=0, $range=25){
			
			$cache_key = "getMembersByYearProvinceCoopID";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			
			$year = safeSQLValue($year);
			$province = safeSQLValue($province);
			$coop_id = safeSQLValue($coop_id);
			
			if (!is_numeric($coop_id))
				return array();

			$ci->load->database();
			$ci->db->reset_query();
			$ci->db->select('*');
			$table = getSurveyYearDbTable($year);
			$ci->db->from($table);
			$ci->db->where("COOP_ID", $coop_id);
			$start = $page * $range;
			$ci->db->limit($range, $start);
			$query = $ci->db->get();
			
			if (empty($query))
				return array();
				
			$results = $query->result_array();
			
			$ci->db->reset_query();
			
			return $results;
			
		}
	}
	
	
	
	if(! function_exists('countSurveysByYearCreator')){
		function countSurveysByYearCreator($year, $creator){
			
			$cache_key = "countSurveysByYearCreator";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			$year = safeSQLValue($year);
			$creator = safeSQLValue($creator);
			
			$ci->load->database();
			$ci->db->reset_query();
			$ci->db->select('count(*) as "totalnumber"');
			$table = getSurveyYearDbTable($year);
			$ci->db->from($table);
			$ci->db->where("created_by", $creator);
			
			$query = $ci->db->get();
			$result = $query->result_array();
			$ci->db->reset_query();
			
			if (empty($result))
			{
				return 0;
			}
			
			return $result[0]['totalnumber'];
		}
	}
	if(! function_exists('getSurveysByYearCreator')){
		function getSurveysByYearCreator($year, $creator, $page=0, $range=25){
			
			$cache_key = "SurveysByYearCreator";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$ci->load->helper('properties');
			
			
			$year = safeSQLValue($year);
			$creator = safeSQLValue($creator);
			
			if (!is_numeric($creator))
				return array();
				
				$ci->load->database();
				$ci->db->reset_query();
				$ci->db->select('*');
				$table = getSurveyYearDbTable($year);
				$ci->db->from($table);
				$ci->db->where("created_by", $creator);
				$start = $page * $range;
				$ci->db->limit($range, $start);
				$query = $ci->db->get();
				
				if (empty($query))
					return array();
					
					$results = $query->result_array();
					
					$ci->db->reset_query();
					
				return $results;
					
		}
	}
	if (! function_exists('getAllTypePlants'))
	{
		function getAllTypePlants()
		{
			$cache_key = "ALLType_plants";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
 			if ( ! $data_cache = $ci->cache->get($cache_key))
 			{
				$ci->load->database();
				$query = $ci->db->SELECT('PLANT_TYPE')
				->from($ci->db->dbprefix('TYPE_PLANT'))
				->distinct('PLANT_TYPE')
				->get();
				
				$temp = array();
				$results = $query->result();
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	if (! function_exists('getDataReport3'))
	{
		function getDataReport3()
		{
			$cache_key = "DataReport3";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->SELECT('*')
				->from($ci->db->dbprefix('REPORT3'))				
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	if (! function_exists('getTotalCoopReport'))
	{
		function getTotalCoopReport()
		{
			$cache_key = "TotalCoopReport";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
			$ci->load->database();
			$query = $ci->db->select('SUM(TOTAL_COOP) as TOTAL_COOP ,COOP_TYPE,ORG_NAME')
			->from($ci->db->dbprefix('REPORTMIS'))
			->group_by('ORG_NAME,ORG_ORG_ID,COOP_TYPE')
			->order_by('ORG_ORG_ID')
			->get();
			
			$temp = array();
			$results = $query->result_array();
			
			$ci->cache->save($cache_key, $results, 30000);
			return $results;
		}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getTotalTypeAnimal'))
	{
		function getTotalTypeAnimal()
		{
			$cache_key = "TotalTypeAnimal";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->select('SUM(TOT_ANN) as TOT_ANN ,TYPE_NAME')
				->from($ci->db->dbprefix('TA_MEMBER_AN'))
				->where('TYPE_ANN','เลี้ยงสัตว์')
				->group_by('TYPE_NAME')
				->order_by('TYPE_NAME')
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
		
				return $data_cache;
			}
	}
	if (! function_exists('getCountTypeAnimal'))
	{
		function getCountTypeAnimal()
		{
			$cache_key = "CountTypeAnimal";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->select('count(TOT_ANN) as ROW_ANN')
				->from($ci->db->dbprefix('TA_MEMBER_AN'))
				->where('TYPE_ANN','เลี้ยงสัตว์')
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getTotalTypeFish'))
	{
		function getTotalTypeFish()
		{
			$cache_key = "TotalTypeFish";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->select('SUM(TOT_ANN) as TOT_ANN ,TYPE_NAME')
				->from($ci->db->dbprefix('TA_MEMBER_AN'))
				->where('TYPE_ANN','ประมง')
				->group_by('TYPE_NAME')
				->order_by('TYPE_NAME')
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	if (! function_exists('getCountTypeFish'))
	{
		function getCountTypeFish()
		{
			$cache_key = "CountTypeFish";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$query = $ci->db->select('count(TOT_ANN) as ROW_ANN')
				->from($ci->db->dbprefix('TA_MEMBER_AN'))
				->where('TYPE_ANN','ประมง')
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	
	if (! function_exists('getTotalCoopReport_Test'))
	{
		function getTotalCoopReport_Test()
		{
			$cache_key = "TotalCoopReport_Test";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{
				$ci =& get_instance();
				$query = $ci->db->select('SUM(TOTAL_COOP_DEAD) as TOTAL_COOP_DEAD,SUM(TOTAL_COOP_NOT_DEAD) as TOTAL_COOP_NOT_DEAD ,COOP_TYPE,ORG_NAME')
				->from($ci->db->dbprefix('REPORT_TEST'))
				->group_by('ORG_NAME,ORG_ID,COOP_TYPE')
				->order_by('ORG_ID')
				->get();
				
				$temp = array();
				$results = $query->result_array();
				
				$ci->cache->save($cache_key, $results, 30000);
				return $results;
			}
			
			return $data_cache;
		}
	}
	if(!function_exists("getAmphurNameByAmphurId"))
	{
		function getAmphurNameByAmphurId($amphurId)
		{
			$ci =& get_instance();
			$ci =& get_instance();
			$cache_key = "getAmphurNameByAmphurId";
			$data_cache = "";
			$results = null;
// 			if ( ! $data_cache = $ci->cache->get($cache_key))
// 			{
				if(isset($amphurId) and !is_null($amphurId) && $amphurId !="")
				{
// 					$ci->db->where('AMPHUR_ID',$amphurId);
					$results = $ci->db->get('DISTRICT')->result_array();
// 					$results = $ci->cache->save($cache_key, $query, 30000);
					
				}
// 			}
// 			$data_result = null;
// 			if(!empty($data_cache))
// 			{
// 				$data_result=$data_cache;
// 			}else{
// 				$data_result = $results;
// 			}
			
			foreach ($results as $amphur)
			{
				if($amphur['AMPHUR_ID'] == $amphurId){
					return $amphur;
				}
			}
			
			
		}
	}
	
	if(!function_exists("validateDataMahadthaiByCitizenID")){
		function validateDataMahadthaiByCitizenID($citizen_id)
		{
			$ci =& get_instance();
			$ci =& get_instance();
			
			$data_validate = getMahadthaiByCitizenID($citizen_id);
			if(isset($data_validate) && !empty($data_validate) && sizeof($data_validate)>0){
				echo json_encode(array('status'=>true));
			}else{
				echo json_encode(array('status'=>false));
			}
			
		}
	}
	
	if (! function_exists('countAllMembers'))
	{
		function countAllMembers()
		{
			$cache_key = "countAllMembers";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			$data_cache = "";
			
			if ( ! $data_cache = $ci->cache->get($cache_key))
			{				
				$table = getMahadthaiDbTable();
				$sql = "Select count(OU_D_ID) as num from MOIUSER.MASTER_DATA where OU_D_FLAG in('1','2')   and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data.IN_D_COOP) = 13";
				$query = $ci->db->query($sql);
				$dataMaster = $query->result_array();
				$dataMaster_size = $dataMaster[0]['NUM'];
				unset($dataMaster);				
				$ci->cache->save($cache_key, $dataMaster_size, 30000);
				return $dataMaster_size;
			}
			
			return $data_cache;
		}
	}

	if (! function_exists('getDataCitizen'))
	{
		function getDataCitizen($coop,$value)
		{
			$c = $value['OU_D_BDATE']; 

			$date = substr($c,6,2).'/'.substr($c,4,2).'/'.substr($c,0,4);
			
			$data = array(
				'coop_name'			=> $coop['COOP_NAME_TH'],
				'coop_id'			=> $value['IN_D_COOP'],
				'province_name'		=> $coop['PROVINCE_NAME'],
				'citizen_id'		=> $value['OU_D_ID'],
				'prefix'			=> $value['OU_D_PREFIX'],
				'name'				=> $value['OU_D_PNAME'],
				'surname'			=> $value['OU_D_SNAME'],
				'bdate'				=> date($date),
				'hno'				=> $value['OU_D_HNO'],
				'lane'				=> $value['OU_D_LANE'],
				'road'				=> $value['OU_D_ROAD'],
				'subd'				=> $value['OU_D_SUBD'],
				'district'			=> $value['OU_D_DISTRICT'],
				'province_name'		=> $value['OU_D_PROVICE_NAME'],
			);
			return $data;
		}
	}

	if (! function_exists('getMemberByName'))
	{
		function getMemberByName($pname,$start,$length)
		{
			$pname = trim($pname);
				
			if (is_numeric($pname))
				return null;
				
			/*
			$test = array();
			$test[] = array(
					'D_ID' => 509,
					'D_YEAR' =>null,
					'D_PIN' => '3160300354651',
					'D_MDATE' => '09/09/3100',
					'D_NSTOCK' => '305',
					'D_VSTOCK' => '3050',
					'D_TYPE' => 1,
					'D_COOP' => '1600000125357',
					'D_GROUP' => '01',
					'D_PNAME' => 'จินดา',
					'D_SNAME' => 'เชื่อมหอม',
					'D_PREFIX' => 'นาง',
					'D_NATION' => 'ไทย'
			);
			return $test;
			*/
				
			$cache_key = "getMemberByName$pname";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{

				$select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP, IN_D_COOP as "COOP_ID",IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
				
				$table = getMahadthaiDbTable();
				$search_datatable = "";
				$search = safeSQLValue($pname);
				if(!empty($search))
				{
					$search_datatable = " OU_D_PNAME like '$search' or OU_D_PNAME like '$search%' or OU_D_PNAME like '%$search' or OU_D_PNAME like '%$search%'";
					$search_datatable .="or OU_D_SNAME like '$search' or OU_D_SNAME like '$search%' or OU_D_SNAME like '%$search' or OU_D_SNAME like '%$search%'";
				}

				$sql = "SELECT * from view_master_data_use where $search_datatable OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";

				// $sql = "select a.* from (SELECT $select FROM $table) a  WHERE \"IN_D_PNAME\" LIKE '%$pname%' or \"IN_D_SNAME\" LIKE '%$pname%' OFFSET $start ROWS FETCH NEXT $length ROWS ONLY"; 
				// $sql = "select * from vu_f_name WHERE \"IN_D_PNAME\" LIKE '$pname%'"; 
				 // OFFSET 20 ROWS FETCH NEXT 10 ROWS ONLY
				$query = $ci->db->query($sql);

				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return[] = $row;
					}
				}
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}


	if (! function_exists('getCountMemberByName'))
	{
		function getCountMemberByName($pname)
		{
			$pname = trim($pname);
				
			if (is_numeric($pname))
				return null;
				
			/*
			$test = array();
			$test[] = array(
					'D_ID' => 509,
					'D_YEAR' =>null,
					'D_PIN' => '3160300354651',
					'D_MDATE' => '09/09/3100',
					'D_NSTOCK' => '305',
					'D_VSTOCK' => '3050',
					'D_TYPE' => 1,
					'D_COOP' => '1600000125357',
					'D_GROUP' => '01',
					'D_PNAME' => 'จินดา',
					'D_SNAME' => 'เชื่อมหอม',
					'D_PREFIX' => 'นาง',
					'D_NATION' => 'ไทย'
			);
			return $test;
			*/
				
			$cache_key = "getCountMemberByName$pname";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
			$data_cache = "";
			//if ( ! $data_cache = $ci->cache->get($cache_key))
			if (true)
			{

				$select = 'IN_D_ID,IN_D_YEAR,IN_D_PIN,IN_D_PIN as D_PIN, OU_D_ID as "citizen_id",IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_NATION,IN_D_MDATE,IN_D_TYPE,IN_D_COOP,IN_D_COOP as D_COOP, IN_D_COOP as "COOP_ID",IN_D_GROUP,IN_PROVICE_ID,IN_PROVICE_NAME, IN_PROVICE_NAME as PROVICE_NAME,OU_D_ID,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_BDATE,OU_D_HNO,OU_D_VNO,OU_D_ALLEY,OU_D_LANE,OU_D_ROAD,OU_D_SUBD,OU_D_DISTRICT,OU_D_PROVICE_NAME,OU_D_STATUS_TYPE,OU_D_FLAG';
				
				$table = getMahadthaiDbTable();
				
				$search_datatable = "";
				$search = safeSQLValue($pname);
				if(!empty($search))
				{
					$search_datatable = " OU_D_PNAME like '$search' or OU_D_PNAME like '$search%' or OU_D_PNAME like '%$search' or OU_D_PNAME like '%$search%'";
					$search_datatable .="or OU_D_SNAME like '$search' or OU_D_SNAME like '$search%' or OU_D_SNAME like '%$search' or OU_D_SNAME like '%$search%'";
				}

				$sql = "SELECT * from view_master_data_use where $search_datatable";

				$sql_count = "SELECT count(*) as TOTAL FROM ($sql)";

				
				$query = $ci->db->query($sql_count);
				// $count = $ci->db->count_all_results();

				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return[] = $row;
					}
				}
				$ci->cache->save($cache_key, $to_return, 300000);
	
				return $to_return;
			}
			return $data_cache;
		}
	}
 

	if (! function_exists('getDie'))
	{
		function getDie($id)
		{
			$cache_key = "getDie";
			$ci =& get_instance();
			// $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			// $data_cache = "";
			
			// if ( ! $data_cache = $ci->cache->get($cache_key))
			// {				
				
				$sql = "SELECT * FROM alive_die WHERE IN_D_COOP = '$id'";

				$query = $ci->db->query($sql);
				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return = $row;
					}
				}
			// 	$ci->cache->save($cache_key, $to_return, 30000);
			// 	return $to_return;
			// }
			
			return $to_return;
		}
	}

	if (! function_exists('getLogNameBylogType'))
	{
		function getLogNameBylogType($id)
		{
			$cache_key = "getLogNameBylogType";
			$ci =& get_instance();
			// $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			
			// $data_cache = "";
			
			// if ( ! $data_cache = $ci->cache->get($cache_key))
			// {				
				$ci->load->database();
				$query = $ci->db->SELECT('log_type_text')				
					->from($ci->db->dbprefix('log_type'))
					->where('id',$id)
					->get();

				$to_return = array();
				$results = $query->result_array();
				if (!empty($results))
				{		
					foreach ($results as $row ) {
						$to_return = $row;
					}
				}
			// 	$ci->cache->save($cache_key, $to_return, 30000);
			// 	return $to_return;
			// }
			
			return $to_return;
		}
	}

	// if (! function_exists('inputCache'))
	// {
	// 	function inputCache($key,$this)
	// 	{
	// 		$cache_key = md5($key);
	// 		$ci =& get_instance();
	// 		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	// 		$data_cache = "";
	// 		$to_return = null;
	// 		if ( ! $data_cache = $ci->cache->get($cache_key)) {
	// 			// $ci->load->database();
	// 			$data =  $this->query($key)->result_array();
	// 			$ci->cache->save($cache_key, $data, 30000);
	// 			$data_cache = $data;
	// 		}
	// 		return $data_cache;
	// 	}
	// }


	
}