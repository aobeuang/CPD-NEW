<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Csv_import_model extends MY_Model
{
 public function select()
 {
  $this->db->order_by('id', 'DESC');
  $query = $this->db->get('tbl_user');
  return $query;
 }

 public function insert($data)
 {
 	// $table = $this->db->dbprefix('users');
  	$this->db->insert_batch('users', $data);

 }

}
