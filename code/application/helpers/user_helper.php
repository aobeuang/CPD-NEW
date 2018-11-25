<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * get user
 * para user id 
 * return name and email
 */
if ( ! function_exists('getUser'))
{
	function getUser($userID = NULL)
	{
		$cache_key = 'getUser-'.$userID;
		$ci =& get_instance();
		$user_cache =null;
		if (!is_numeric($userID))
		{
			return array();
		}
		if($ci->session->userdata('auth_user_id')!=null && is_numeric($ci->session->userdata('auth_user_id')))
		{
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));		
			//if ( ! $user_cache = $ci->cache->get($cache_key))
			if (true)
			{
				$ci->load->database();
				$ci->db->SELECT('*');
				$ci->db->from($ci->db->dbprefix('users'));			
				if(!is_null($userID)){
					$ci->db->where('user_id',$userID);
				}

				$query = $ci->db->get();				
				$value = array();
				if(empty($query->result())){
					return array();
				}
				foreach ($query->result() as $data){
					$value = array(
							'user_id'=>$data->user_id,
							'name'=>$data->name,
							'username'=>$data->username,
							'email'=>$data->email,
							'agency'=>$data->AGENCY,
							'last_login'=>strtotime($data->last_login),
							'province'=>$data->province,
							'org_id'=>$data->ORG_ID
							);
					$ci->cache->save($cache_key,$value, 30000);
				}	
	
				return $value;
			}
			return $user_cache;
		}
	}
}
/*
 * get all users 
 * return list users format array
 */
if(! function_exists('getUsers')){
	function getUsers(){
		$ci->db->select('name,email');
		$ci->db->from($ci->db->dbprefix('users'));		
		$query = $ci->db->get();
		return $query->result();
	}
}

if(! function_exists('getUsersIdAll')){
	function getUsersIdAll($userID = NULL){
		$ci =& get_instance();
		$ci->db->select('*');
		$ci->db->from($ci->db->dbprefix('users'));
		$ci->db->where('user_id',$userID);		
		$query = $ci->db->get();
		$value = array();
		foreach ($query->result() as $data){
			$value[] = $data;
		}
		return $value;
	}
}

if(! function_exists('getUsersRole')){
	function getUsersRole($userID = NULL){
		$ci =& get_instance();
		$ci->db->select('auth_level');
		$ci->db->from($ci->db->dbprefix('users'));
		$ci->db->where('user_id',$userID);
		$query = $ci->db->get();
		$value = array();
		foreach ($query->result() as $data){
			$value = array(
				'auth_level'=>$data->auth_level,
			);
		}
		return $value;
	}
}


if(! function_exists('getCacheUsers')){
	function getCacheUsers(){
		$ci =& get_instance();
		$cache_key = "getCacheUsers";
		if ( ! $user_cache = $ci->cache->get($cache_key))
		{
			$ci->db->select('user_id,name,email');
			$ci->db->from($ci->db->dbprefix('users'));
			$query = $ci->db->get();
			
			$results = $query->result();
			
			$ci->cache->save($cache_key,$results, 300);
			
			return $results;
		}
		return $user_cache;
	}
}


if(!function_exists('get_last_change_password')){
	function get_last_change_password($user_id){
		$ci =& get_instance();
		$ci->load->helper('time');
		$ci->db->from($ci->db->dbprefix('users'));
		$ci->db->where('user_id',$user_id);
		$query = $ci->db->get();
		$passwd_modified_at = null;
		$passwd_created_at_at = null;
		$result_array =  $query->result_array();
		$cache_key = "check_last_modify_password_";
		if(!empty($result_array)){
			$cache_key .= $user_id;
		}
		if ( ! $user_cache = $ci->cache->get($cache_key))
		{
			$passwd_modified_at = $result_array[0]['passwd_modified_at'];
			$passwd_created_at_at = strtotime($result_array[0]['created_at']);
			
			$leng_date = null;
			if(!empty($passwd_modified_at)){
					
				$now_date = strtotime(getDateTime());
				$time_diff = abs($now_date - $passwd_modified_at);
				$leng_date = idate('d',$time_diff);
			}else if(!empty($passwd_created_at_at)){
				$now_date = strtotime(getDateTime());
				$time_diff = abs($now_date - $passwd_created_at_at);
				$leng_date = idate('d',$time_diff);
			}
			$ci->cache->save($cache_key,$leng_date, 300);
			return $leng_date;
		}
		
		return $user_cache;
	}
}
if(!function_exists('get_count_last_date_modify_password')){
	function get_count_last_date_modify_password(){
		$ci =& get_instance();
		$ci->load->helper('properties');
		$count_date = getStringSystemProperties("length.date.change.password","60");
		return $count_date;
	}
}

if ( ! function_exists('getUserByUsername'))
{
	function getUserByUsername($username)
	{
		$cache_key = "getUserByUsername-$username";
		$ci =& get_instance();
		if($ci->session->userdata('auth_user_id')!=null && is_numeric($ci->session->userdata('auth_user_id')))
		{
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			if ( ! $user_cache = $ci->cache->get($cache_key))
			{
				$ci->load->database();
				$ci->db->SELECT('*');
				$ci->db->from($ci->db->dbprefix('users'));
				if(!empty($username)){
					$ci->db->where('username',$username);
				}
				$query = $ci->db->get();
				
				$data = $query->result();
				
				
				$value = array(
					'name'=>$data[0]->name,
					'email'=>$data[0]->email,
					'user_id'=>$data[0]->user_id,
					'dcw_username'=>$data[0]->dcw_username,
					'dcw_password'=>$data[0]->dcw_password						
				);
				
				$ci->cache->save($cache_key,$value, 300);

				return $value;
			}
			return $user_cache;
		}
	}
}

/*
 * get all users
 * return list users format array
 */
if(! function_exists('getUsersByKeyword')){
	function getUsersByKeyword($keyword){
		$ci =& get_instance();
		$ci->db->select('name,email,username,user_id');
		$ci->db->from($ci->db->dbprefix('users'));
		$ci->db->like('name', $keyword, 'both');
		$ci->db->or_like('username', $keyword, 'both');
		$ci->db->or_like('email', $keyword, 'both');
		
		$query = $ci->db->get();
		
		$results = $query->result();
		$return_results = array();
		if (!empty($results))
		{
			foreach ($results as $item)
			{
				$name = trim($item->name);
				$temp = array();
				$temp['user_id'] = $item->user_id;
				$temp['name'] = $name;
				$temp['username'] = trim($item->username);
				$temp['email'] = trim($item->email);
				$temp['id'] = trim($item->username);
				$temp['text'] = trim($item->username);
				$return_results[] = $temp;				
			}
		}
		
		return $return_results;
	}
}



if(! function_exists('getUsersJoin')){
	function getUsersJoin($parameter){
		$ci =& get_instance();
		$value = array();		
		if ( ! $users = $ci->cache->get($parameter))
		{
			$ci->db->select('users.user_id,username,name');
			$ci->db->from($ci->db->dbprefix('users'));
			$ci->db->join($ci->db->dbprefix('user_group'),$ci->db->dbprefix('users').'.user_id='.$ci->db->dbprefix('user_group').'.user_id');
			$ci->db->where($ci->db->dbprefix('user_group').'.group_id',$parameter);			
			$query = $ci->db->get();
			if(!$query->row() == null ){			
				$ci->cache->save($parameter,$query->result(), 30000);			
				return $ci->cache->get($parameter);	
			}
			else return "ERROR";
		}
		return $users;
	}
}

