<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('getData'))
{
	function getData($key, $default="")
	{
		$cache_key = "systemproperties";
		$key = trim($key);
		$ci =& get_instance();
		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$name = null;
		$value= null;
		$propertise_id = null;
		
		$data_cache = "";
		if ( ! $data_cache = $ci->cache->get($cache_key))
		{
			$ci->load->database('default', true);			
			$query = $ci->db->SELECT('*')
			->from($ci->db->dbprefix('properties'))
			->get();
				
			$temp = array();
			$result_properties = $query->result();

			if(empty($result_properties)){
				return $default;
			}
			$return_result = $default;
			
			foreach ($result_properties as $data){
// 				$propertise_id = $data->properties_id;
 				$name = trim($data->name);
 				$value = trim($data->propvalue);
				if ($name==$key)
				{
					$return_result = $value;
				}
 				$temp[$name] = trim($value);
			}
			
			$ci->cache->save($cache_key, $temp, 30000);
			return $return_result;
		}

		$result = !empty($data_cache) && isset($data_cache[$key])?$data_cache[$key]: $default;
		return $result;
	}
}

if (! function_exists('getIntegerSystemProperties'))
{
	function getIntegerSystemProperties($parameters,$default)
	{
		$ci =& get_instance();
		$result = getData($parameters, $default);
		$valueInt = $result;
		$valueInt = (float)$result;
		if($valueInt == 0){
			return  $default;
		}
		else
			return $valueInt;
	}
}


if (! function_exists('getBooleanSystemProperties'))
{
	function getBooleanSystemProperties($parameters, $default="")
	{
		$ci =& get_instance();
		$result = getData($parameters, $default);
		if($result == true || $result == false){
			if(filter_var($result,FILTER_VALIDATE_BOOLEAN) == true)
				return  true;
				elseif(filter_var($result,FILTER_VALIDATE_BOOLEAN) == false)
				return  false;
		}else{
			return $default;
		}
			
	}
}

if (! function_exists('getStringSystemProperties'))
{
	function getStringSystemProperties($parameters, $default="")
	{
		$ci =& get_instance();
		$g = false;
		$result = getData($parameters, $default);

		return $result;
	}
}