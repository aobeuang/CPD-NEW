<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Examples Model
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2016, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class User_model extends MY_Model {

	public function getId()
	{
		$q = $this->db->query("select MAX(user_id) as maxUserID from users");
		$tmp = 1;
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->maxUserID)+1;
				
			}
		}
		return $tmp;
	}
	
	public function getUsersByGroupnameArray($list_of_group_no_empty)
	{
		$groupnames = implode("','", $list_of_group_no_empty);
		$groupnames = "'".$groupnames."'";
		
		$sub2 = " select group_id from ".$this->db->dbprefix('groups')." where deleted=0 and name in ($groupnames)" ; 
		$sub1 = " select user_id from ".$this->db->dbprefix('user_group'). " where group_id in ($sub2) "; 
		$query = " * from ".$this->db->dbprefix('users')." where user_id in ($sub1)"; 	
		$this->db->select($query);
		$query = $this->db->get();
		$temp = $query->result_array();

		return $temp;
	}
	


}

