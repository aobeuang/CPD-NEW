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

class Land_model extends MY_Model {

	public function getLandByIdentificationID($identification_id)
	{
		$this->db->cache_on();
		
		$query = $this->db->select( '*' )
			->from( "lands" )
			->where( 'LOWER( identification_id ) =', strtolower( $identification_id ) )
			->limit(1)
			->get();
		
		$this->db->cache_off();

		if( $query->num_rows() == 1 )
			return $query->row();

		return FALSE;
	}
	
	public function getLandByIdentificationID($land_id)
	{
		$this->db->cache_on();
		
		$query = $this->db->select( '*' )
		->from( "lands" )
		->where( ' land_id =', $land_id )
		->limit(1)
		->get();
	
		$this->db->cache_off();
		
		if( $query->num_rows() == 1 )
			return $query->row();
	
		return FALSE;
	}

}

