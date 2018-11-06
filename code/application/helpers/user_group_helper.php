<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getCurrentUserGroup'))
{
    function getCurrentUserGroup()
    {
    	$ci =& get_instance();
    	$ci->load->database();
    	$ci->load->library('session');
    	
    	if (!$ci->session->has_userdata('user_group'))
    	{
    		$current_user_id = $ci->session->userdata('auth_user_id');
    		
    		$ci->db->select('group_id');
    		$ci->db->from($ci->db->dbprefix('user_group'));
    		$ci->db->where('user_id', $current_user_id);
    		$query = $ci->db->get();
    		
    		$temp = array();
    		foreach ($query->result() as $row)
    		{
    			$temp[] = $row->group_id;
    		}
    		
    		$user_group_str = implode(",", $temp);
    		$ci->session->set_userdata('user_group', $user_group_str);
    	}
    	return $ci->session->userdata('user_group');
    }
}

// including dw groups
// by prem
if ( ! function_exists('getAllCurrentUserGroupName'))
{
	function getAllCurrentUserGroupName()
	{
		$ci =& get_instance();
		if (!$ci->session->has_userdata('user_group_names'))
		{
			$ci->load->database();
			$ci->load->library('session');
				
			$local_groups = getCurrentUserGroup();
			$all_group_names = array();
			if (!empty($local_groups))
			{
				$ci->db->select('name');
				$ci->db->from($ci->db->dbprefix('groups'));
				$ci->db->where("group_id in ($local_groups)");
				$query = $ci->db->get();
				foreach ($query->result() as $row)
				{
					$all_group_names[] = trim($row->name);
				}
			}
		
			$ci->session->set_userdata('user_group_names', $all_group_names);
		}	
		return $ci->session->userdata('user_group_names');
	}
}


if ( ! function_exists('getCurrentDwUserGroup'))
{
	function getCurrentDwUserGroup($user_id)
	{
		$ci =& get_instance();
		$cacheName = "CurrentDwUserGroup".$user_id;
		$ci->cache->delete($cacheName);
		if ( ! $users = $ci->cache->get($cacheName))
		{
			$ci->db->select($ci->db->dbprefix('groups').'.group_id'.','.$ci->db->dbprefix('groups').'.name');
			$ci->db->from($ci->db->dbprefix('groups'));
			$ci->db->join($ci->db->dbprefix('user_group'),$ci->db->dbprefix('groups').'.group_id='.$ci->db->dbprefix('user_group').'.group_id');
			$ci->db->where($ci->db->dbprefix('user_group').'.user_id',$user_id);
			$query = $ci->db->get();
// 			print_r($query->result());
			if(!$query->row() == null ){
				$ci->cache->save($cacheName,$query->result(), 30000);
				return $ci->cache->get($cacheName);
			}
			else return "ERROR";
		}
		return $users;
	}
}

if ( ! function_exists('getCurrentAllUserGroup'))
{
	function getCurrentAllUserGroup($group_id)
	{
		$ci =& get_instance();
				
		if ( ! $users = $ci->cache->get($group_id))
		{
			$ci->db->select('users.user_id,username,name');
			$ci->db->from($ci->db->dbprefix('users'));
			$ci->db->join($ci->db->dbprefix('user_group'),$ci->db->dbprefix('users').'.user_id='.$ci->db->dbprefix('user_group').'.user_id');
			$ci->db->where($ci->db->dbprefix('user_group').'.group_id',$group_id);			
			$query = $ci->db->get();
			if(!$query->row() == null ){			
				$ci->cache->save($group_id,$query->result(), 30000);			
				return $ci->cache->get($group_id);	
			}
			else return "ERROR";
		}
		return $users;
	}
}


