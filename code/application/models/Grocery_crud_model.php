<?php
/**
 * PHP grocery CRUD
 *
 * LICENSE
 *
 * Grocery CRUD is released with dual licensing, using the GPL v3 (license-gpl3.txt) and the MIT license (license-mit.txt).
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	grocery CRUD
 * @copyright  	Copyright (c) 2010 through 2012, John Skoumbourdis
 * @license    	https://github.com/scoumbourdis/grocery-crud/blob/master/license-grocery-crud.txt
 * @version    	1.4.2
 * @author     	John Skoumbourdis <scoumbourdisj@gmail.com>
 */

// ------------------------------------------------------------------------

/**
 * Grocery CRUD Model
 *
 *
 * @package    	grocery CRUD
 * @author     	John Skoumbourdis <scoumbourdisj@gmail.com>
 * @version    	1.5.4
 * @link		http://www.grocerycrud.com/documentation
 */
class Grocery_crud_model  extends CI_Model  {

	protected $primary_key = null;
	protected $table_name = null;
	protected $relation = array();
	protected $relation_reverse = array();
	protected $relation_reverse_sum = array();
	protected $relation_n_n = array();
	protected $primary_keys = array();

	function __construct()
    {
        parent::__construct();
    }

    function db_table_exists($table_name = null)
    {
    	//$this->db->cache_on();
    	$result = $this->db->table_exists($table_name);
    	//$this->db->cache_off();

    	return $result;
    }

    function get_list()
    {
    	if($this->table_name === null)
    		return false;

    	$select = "*";

    	//set_relation special queries
       	if(!empty($this->relation))
    	{
    		$select = "{$this->table_name}.*";
    		
    		foreach($this->relation as $relation)
    		{
    			list($field_name , $related_table , $related_field_title) = $relation;
    			$unique_join_name = $this->_unique_join_name($field_name);
    			$unique_field_name = $this->_unique_field_name($field_name);

				if(strstr($related_field_title,'{'))
				{
					$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
    				$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
				}
    			else
    			{
    				$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
    			}

    			if($this->field_exists($related_field_title))
    				$select .= ", `{$this->table_name}`.$related_field_title AS '{$this->table_name}.$related_field_title'";
    		}
    	}

    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
			$select = $this->relation_n_n_queries($select);
    	}


    	$this->db->select($select, false);

    	//$this->db->cache_on();
    	$results = $this->db->get($this->table_name)->result();
    	//$this->db->cache_off();
    	return $results;
    }
    
    function get_list_reverse()
    {
    	if($this->table_name === null)
    		return false;
    
    		$select = "{$this->table_name}.*";
    
    		//set_relation special queries
    		if(!empty($this->relation_reverse))
    		{
    			foreach($this->relation_reverse as $relation)
    			{
    				list($field_name , $related_table , $related_field_title) = $relation;
    				$unique_join_name = $this->_unique_join_name($field_name);
    				$unique_field_name = $this->_unique_field_name($field_name);
    				if(strstr($related_field_title,'{'))
    				{
    					$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
    					$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
    				}
    				else
    				{
    					$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
    				}
    
    				if($this->field_exists($related_field_title))
    					$select .= ", {$this->table_name}.$related_field_title AS '{$this->table_name}.$related_field_title'";
    				

    			}
    		}
    
    		//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    		if(!empty($this->relation_n_n))
    		{
    			$select = $this->relation_n_n_queries($select);
    		}
    

    		foreach($this->relation_reverse as $relation)
    		{
    			if(!empty($relation[3])){
    				list($field_name , $related_table , $related_field_title, $where_cause) = $relation;
    				$this->db->where($where_cause);
    			}
    		}
    		$results = $this->db->select($select, false);
    		//$this->db->cache_on();
    		$results = $this->db->get($this->table_name)->result();
    		//$this->db->cache_off();
    		 
    		return $results;
    }
    
    function get_list_reverse_sum()
    {
    	if($this->table_name === null)
    		return false;
    
    	$select = "`{$this->table_name}`.*";
    	 
    	//set_relation special queries
    	if(!empty($this->relation_reverse_sum))
    	{
    		foreach($this->relation_reverse_sum as $relation)
    		{
    				
    			list($field_name , $related_table , $related_field_title, $where_clause) = $relation;
    			$unique_join_name = $this->_unique_join_name($field_name);
    			$unique_field_name = $this->_unique_field_name($field_name);
    			if(strstr($related_field_title,'{'))
    			{
    				$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
    				$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name ";
    				if($where_clause !="" && isset($where_clause))
    					$select .= ", ".$where_clause;
    
    					
    			}
    			else
    			{
    					
    				$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
    
    			}
    
    
    			if($this->field_exists($related_field_title))
    				$select .= ", `{$this->table_name}`.$related_field_title AS '{$this->table_name}.$related_field_title'";
    
    		}
    	}
    
    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
    		$select = $this->relation_n_n_queries($select);
    	}
    
    
    	//     		if($where_clause!=null)
    		//     			$select .= ", (jcb24373b.rai*400)+(jcb24373b.ngan*100)+jcb24373b.meters as totail";
    	$this->db->select($select, false);
    
    	//     		$this->db->cache_on();
    	$results = $this->db->get($this->table_name)->result();
    	//$this->db->cache_off();
    
    	for ($i=0;$i< sizeof($results);$i++){
    		if(($results[$i]->totail) < 17907){
    
    			unset($results[$i]);
    		}
    		else{
    			$results[$i]->rai = $results[$i]->totail/400;
    		}
    	}
    	 
    	return $results;
    }
    
    
    

    public function get_row($table_name = null)
    {
    	$table_name = $table_name === null ? $this->table_name : $table_name;

    	//$this->db->cache_on();
    	$result = $this->db->get($table_name)->row();
    	//$this->db->cache_off();
    	
    	return $result;
    }

    public function set_primary_key($field_name, $table_name = null)
    {
    	$table_name = $table_name === null ? $this->table_name : $table_name;

    	$this->primary_keys[$table_name] = $field_name;
    }

    protected function relation_n_n_queries($select)
    {
    	$this_table_primary_key = $this->get_primary_key();
    	foreach($this->relation_n_n as $relation_n_n)
    	{
    		list($field_name, $relation_table, $selection_table, $primary_key_alias_to_this_table,
    					$primary_key_alias_to_selection_table, $title_field_selection_table, $priority_field_relation_table) = array_values((array)$relation_n_n);

    		$primary_key_selection_table = $this->get_primary_key($selection_table);

	    	$field = "";
	    	$use_template = strpos($title_field_selection_table,'{') !== false;
	    	$field_name_hash = $this->_unique_field_name($title_field_selection_table);
	    	if($use_template)
	    	{
	    		$title_field_selection_table = str_replace(" ", "&nbsp;", $title_field_selection_table);
	    		$field .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$title_field_selection_table))."')";
	    	}
	    	else
	    	{
	    		$field .= "$selection_table.$title_field_selection_table";
	    	}

    		//Sorry Codeigniter but you cannot help me with the subquery!
    		//$select .= ", (SELECT GROUP_CONCAT(DISTINCT $field) FROM $selection_table "
    		//	."LEFT JOIN $relation_table ON $relation_table.$primary_key_alias_to_selection_table = $selection_table.$primary_key_selection_table "
			//	."WHERE $relation_table.$primary_key_alias_to_this_table = `{$this->table_name}`.$this_table_primary_key GROUP BY $relation_table.$primary_key_alias_to_this_table) AS $field_name";
    	}

    	return $select;
    }

    function order_by($order_by , $direction)
    {
    	$this->db->order_by( $order_by , $direction );
    }

    function where($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->where( $key, $value, $escape);
    }

    function or_where($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->or_where( $key, $value, $escape);
    }

    function having($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->having( $key, $value, $escape);
    }

    function or_having($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->or_having( $key, $value, $escape);
    }

    function like($field, $match = '', $side = 'both')
    {
    	$this->db->like($field, $match, $side);
    }

    function or_like($field, $match = '', $side = 'both')
    {
    	$this->db->or_like($field, $match, $side);
    }

    function limit($value, $offset = '')
    {
    	$this->db->limit( $value , $offset );
    }


    function group_by($key, $value = NULL, $escape = TRUE)
    {
    	$this->db->group_by($key);
    }
    
    
    function get_total_results()
    {
    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
    		$select = "{$this->table_name}.*";
    		$select = $this->relation_n_n_queries($select);

    		$this->db->select($select,false);
    	}

    	//$this->db->cache_on();
    	//$result = $this->db->get($this->table_name)->num_rows();
    	//$this->db->cache_off();
    	//$this->db->cache_on();  
    	$result = $this->db->count_all_results($this->table_name);
    	//$this->db->cache_off();
    	
    	return $result;
    }
    

    function set_basic_table($table_name = null)
    {
    	if( !($this->db->table_exists($table_name)) )
    		return false;

    	$this->table_name = $table_name;

    	return true;
    }

    function get_edit_values($primary_key_value)
    {
    	$this->db->reset_query();
    	
    	$primary_key_field = $this->get_primary_key();
    	$this->db->where($primary_key_field,$primary_key_value);
    	
    	$result = $this->db->get($this->table_name)->row();
    	return $result;
    }

    function join_relation($field_name , $related_table , $related_field_title)
    {
		$related_primary_key = $this->get_primary_key($related_table);

		if($related_primary_key !== false)
		{
			$unique_name = $this->_unique_join_name($field_name);
			$this->db->join( $related_table.' as '.$unique_name , "$unique_name.$related_primary_key = {$this->table_name}.$field_name",'left');

			$this->relation[$field_name] = array($field_name , $related_table , $related_field_title);

			return true;
		}

    	return false;
    }
    //Ntk cutomize
    function join_relation_reverse($field_name , $related_table , $related_field_title, $where_cause)
    {
    	$related_primary_key = $this->get_primary_key($related_table);
    
    	if($related_primary_key !== false)
    	{
    		$unique_name = $this->_unique_join_name($field_name);
    		$this->db->join( $related_table.' as '.$unique_name , "{$this->table_name}.$field_name = $unique_name.$field_name",'left');
    		
    		if($where_cause !=null){
    			$this->relation_reverse[$field_name] = array($field_name , $related_table , $related_field_title,$where_cause);
    		}else
    		{
    			$this->relation_reverse[$field_name] = array($field_name , $related_table , $related_field_title);
    		}
    		return true;
    	}
    
    	return false;
    }
    
    function join_relation_sum($field_name , $related_table , $related_field_title, $where_cause)
    {
    	$related_primary_key = $this->get_primary_key($related_table);
    
    	if($related_primary_key !== false)
    	{
    		$unique_name = $this->_unique_join_name($field_name);
    		$this->db->join( $related_table.' as '.$unique_name , "{$this->table_name}.$field_name = $unique_name.$field_name",'left');
    
    		if($where_cause !=null)
    			$this->relation_reverse_sum[$field_name] = array($field_name , $related_table , $related_field_title , $where_cause);
    		 
    		return true;
    	}
    
    	return false;
    }
    
    //End customize

    function set_relation_n_n_field($field_info)
    {
		$this->relation_n_n[$field_info->field_name] = $field_info;
    }

    protected function _unique_join_name($field_name)
    {
    	return 'j'.substr(md5($field_name),0,8); //This j is because is better for a string to begin with a letter and not with a number
    }

    protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

    function get_relation_array($field_name , $related_table , $related_field_title, $where_clause, $order_by, $limit = null, $search_like = null)
    {
    	$relation_array = array();
    	$field_name_hash = $this->_unique_field_name($field_name);

    	$related_primary_key = $this->get_primary_key($related_table);

    	$select = "$related_table.$related_primary_key, ";

    	$column_name = "";
    	if(strstr($related_field_title,'{'))
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", '' COLLATE Thai_CI_AI),'"),str_replace("'","\\'",$related_field_title))."'COLLATE Thai_CI_AI) as $field_name_hash";
    		
    		$column_name = str_replace('{', '', $related_field_title);
    		$column_name = str_replace('}', '', $column_name);
    	}
    	else
    	{
	    	$select .= "$related_table.$related_field_title as $field_name_hash";

	    	$column_name = $related_table.$related_field_title;	    	
    	}

    	$this->db->select($select,false);
    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	if($limit !== null)
    		$this->db->limit($limit);

    	if($search_like !== null)
    		$this->db->where("$column_name LIKE '%".$this->db->escape_like_str($search_like)."%'");

    	$order_by !== null
    		? $this->db->order_by($order_by)
    		: $this->db->order_by($column_name);

    	//$this->db->cache_on();
    	$results = $this->db->get($related_table)->result();
    	//$this->db->cache_off();
    	
    	foreach($results as $row)
    	{
    		$relation_array[$row->$related_primary_key] = $row->$field_name_hash;
    	}

    	return $relation_array;
    }

    function get_ajax_relation_array($search, $field_name , $related_table , $related_field_title, $where_clause, $order_by)
    {
    	return $this->get_relation_array($field_name , $related_table , $related_field_title, $where_clause, $order_by, 10 , $search);
    }

    function get_relation_total_rows($field_name , $related_table , $related_field_title, $where_clause)
    {
    	if($where_clause !== null)
    		$this->db->where($where_clause);

    	return $this->db->count_all_results($related_table);
    }

    function get_relation_n_n_selection_array($primary_key_value, $field_info)
    {
    	$select = "";
    	$related_field_title = $field_info->title_field_selection_table;
    	$use_template = strpos($related_field_title,'{') !== false;;
    	$field_name_hash = $this->_unique_field_name($related_field_title);
    	if($use_template)
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    		$this->db->select('*, '.$select,false);
    	}
    	else
    	{
			if ($this->table_name=="groups")
			{
				
				$select .= "\"$related_field_title\" as  \"$field_name_hash\" ";
				$this->db->select('"users".*, "users".'.$select,false);
			}    		
			else 
			{    		
    			$select .= "$related_field_title as $field_name_hash";
    			$this->db->select('*, '.$select,false);
			}
    	}
    	   	
    	

    	$selection_primary_key = $this->get_primary_key($field_info->selection_table);

    	if(empty($field_info->priority_field_relation_table))
    	{
    		if(!$use_template){
    			$this->db->order_by("{$field_info->selection_table}.{$field_info->title_field_selection_table}");
    		}
    	}
    	else
    	{
    		$this->db->order_by("{$field_info->relation_table}.{$field_info->priority_field_relation_table}");
    	}
    	$this->db->where($field_info->primary_key_alias_to_this_table, $primary_key_value);
    	$this->db->join(
    			$field_info->selection_table,
    			"{$field_info->relation_table}.{$field_info->primary_key_alias_to_selection_table} = {$field_info->selection_table}.{$selection_primary_key}"
    		);
    	$results = $this->db->get($field_info->relation_table)->result();

    	$results_array = array();
    	foreach($results as $row)
    	{
    		$results_array[$row->{$field_info->primary_key_alias_to_selection_table}] = $row->{$field_name_hash};
    	}

    	return $results_array;
    }

    function get_relation_n_n_unselected_array($field_info, $selected_values)
    {
    	$use_where_clause = !empty($field_info->where_clause);

    	$select = "";
    	$related_field_title = $field_info->title_field_selection_table;
    	$use_template = strpos($related_field_title,'{') !== false;
    	$field_name_hash = $this->_unique_field_name($related_field_title);

    	if($use_template)
    	{
    		$related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
    		$select .= "CONCAT('".str_replace(array('{','}'),array("',COALESCE(",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $field_name_hash";
    		$this->db->select('*, '.$select,false);
    	}
    	else
    	{
    		if ($this->table_name=="groups")
    		{  		
    			$select .= "\"$related_field_title\" as \"$field_name_hash\"";
    			$this->db->select('"users".*, "users".'.$select,false);
    		}
    		else
    		{
	    		$select .= "$related_field_title as $field_name_hash";
	    		$this->db->select('*, '.$select,false);
    		}
    	}
    	

    	if($use_where_clause){
    		$this->db->where($field_info->where_clause);
    	}

    	$selection_primary_key = $this->get_primary_key($field_info->selection_table);
        if(!$use_template)
        	$this->db->order_by("{$field_info->selection_table}.{$field_info->title_field_selection_table}");
        $results = $this->db->get($field_info->selection_table)->result();

        $results_array = array();
        foreach($results as $row)
        {
            if(!isset($selected_values[$row->$selection_primary_key]))
                $results_array[$row->$selection_primary_key] = $row->{$field_name_hash};
        }

        return $results_array;
    }

    function db_relation_n_n_update($field_info, $post_data ,$main_primary_key)
    {
    	$this->db->where($field_info->primary_key_alias_to_this_table, $main_primary_key);
    	if(!empty($post_data))
    		$this->db->where_not_in($field_info->primary_key_alias_to_selection_table , $post_data);
    	$this->db->delete($field_info->relation_table);

    	$counter = 0;
    	if(!empty($post_data))
    	{
    		foreach($post_data as $primary_key_value)
	    	{
				$where_array = array(
	    			$field_info->primary_key_alias_to_this_table => $main_primary_key,
	    			$field_info->primary_key_alias_to_selection_table => $primary_key_value,
	    		);

	    		$this->db->where($where_array);
				$count = $this->db->from($field_info->relation_table)->count_all_results();

				if($count == 0)
				{
					if(!empty($field_info->priority_field_relation_table))
						$where_array[$field_info->priority_field_relation_table] = $counter;

					$this->db->insert($field_info->relation_table, $where_array);

				}elseif($count >= 1 && !empty($field_info->priority_field_relation_table))
				{
					$this->db->update( $field_info->relation_table, array($field_info->priority_field_relation_table => $counter) , $where_array);
				}

				$counter++;
	    	}
    	}
    }

    function db_relation_n_n_delete($field_info, $main_primary_key)
    {
    	$this->db->where($field_info->primary_key_alias_to_this_table, $main_primary_key);
    	$this->db->delete($field_info->relation_table);
    }


    function get_field_types_basic_table()
    {

    	if ($this->db->dbdriver=='mysqli')
    	{
    		
    		foreach($this->db->query("SHOW COLUMNS FROM `{$this->table_name}`")->result() as $db_field_type)
    		{
    			$type = explode("(",$db_field_type->Type);
    			$db_type = $type[0];
    			
    			if(isset($type[1]))
    			{
    				if(substr($type[1],-1) == ')')
    				{
    					$length = substr($type[1],0,-1);
    				}
    				else
    				{
    					list($length) = explode(" ",$type[1]);
    					$length = substr($length,0,-1);
    				}
    			}
    			else
    			{
    				$length = '';
    			}
    			$db_field_types[$db_field_type->Field]['db_max_length'] = $length;
    			$db_field_types[$db_field_type->Field]['db_type'] = $db_type;
    			$db_field_types[$db_field_type->Field]['db_null'] = $db_field_type->Null == 'YES' ? true : false;
    			$db_field_types[$db_field_type->Field]['db_extra'] = $db_field_type->Extra;
    		}
    		
    	}
    	else 
    	{
    		
    		$data1= $this->db->query("SELECT cols.column_name \"primarykeycolumn\"
    			FROM all_constraints cons, all_cons_columns cols
    			WHERE cols.table_name = 'users'
    			AND cons.constraint_type = 'P'
    			AND cons.constraint_name = cols.constraint_name
    			AND cons.owner = cols.owner
    			ORDER BY cols.table_name, cols.position");
    		
    		$primary_column = "";
    		foreach ($data1->result() as $row)
    		{
    			$primary_column = $row->primarykeycolumn;
    		}
    		
    		$db_field_types = array();
    		foreach($this->db->field_data($this->table_name) as $db_field_type)
    		{
    			
    			$type = explode("(",$db_field_type->type);
    			$db_type = $type[0];
    			
    			if(isset($type[1]))
    			{
    				if(substr($type[1],-1) == ')')
    				{
    					$length = substr($type[1],0,-1);
    				}
    				else
    				{
    					list($length) = explode(" ",$type[1]);
    					$length = substr($length,0,-1);
    				}
    			}
    			else
    			{
    				$length = '';
    			}
    			$db_field_types[$db_field_type->name]['db_max_length'] = $length;
    			$db_field_types[$db_field_type->name]['db_type'] = $db_type;
    			$db_field_types[$db_field_type->name]['db_null'] = $db_field_type->default == 'null' ? true : false;
    		}
    		
    		
    	}

    	
    	if ($this->db->dbdriver=='mysqli')
    	{
	    	
	    	$results = $this->db->field_data($this->table_name);
	    	foreach($results as $num => $row)
	    	{
	    		$row = (array)$row;
	    		$results[$num] = (object)( array_merge($row, $db_field_types[$row['name']])  );
	    	}
    	}
    	else 
	    {
	    	$results = $this->db->field_data($this->table_name);
	    	foreach($results as $num => $row)
	    	{
	    		$row = (array)$row;
	    		
	    		
	    		if ($row['name']==$primary_column)
	    			$row['primary_key'] = 1;
	    		else
	    			$row['primary_key'] = 0;
	    			 
	    		$results[$num] = (object)( array_merge($row, $db_field_types[$row['name']])  );
	    	}
	    }
    	return $results;
    }

    function get_field_types($table_name)
    {
    	$results = $this->db->field_data($table_name);

    	return $results;
    }

    function db_update($post_array, $primary_key_value)
    {
    	$primary_key_field = $this->get_primary_key();
    	
    	// handle date
    	foreach ($post_array as $k=>$v)
    	{
    		if (strpos(strtoupper($v), "TO_DATE")!==FALSE)
    		{
    			$this->db->set("\"".$k."\"", $v,false);
    		}
    		else
    		{
    			$this->db->set("\"".$k."\"",$v);
    		}    			
    	} 
    	$this->db->where($primary_key_field, $primary_key_value);
    	
    	//$result = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
    	$result = $this->db->update($this->table_name);
    	 
    	$this->db->cache_delete_all();
    	
    	return $result;
    }

    function db_insert($post_array)
    {
    	
    	$primary_key = $this->get_primary_key();
    	$sequence_tablename = strtoupper($this->table_name)."_SEQUENCE";
    	$query = $this->db->query(" SELECT $sequence_tablename.NEXTVAL as nextvalue FROM dual ");
    	$result = $query->result_array();;
    	 
    	$nextvalue = !empty($result) && isset($result[0]['NEXTVALUE']) ? $result[0]['NEXTVALUE']: "";
    	if (empty($nextvalue))
    	{
    		die("Create sequence named $sequence_tablename");
    		
    	}
    	
    	$this->db->reset_query();
    	
    	// handle date
    	foreach ($post_array as $k=>$v)
    	{
    		if (strpos(strtoupper($v), "TO_DATE")!==FALSE)
    		{
    			$this->db->set("\"".$k."\"", $v,false);
    		}
    		else
    		{
    			$this->db->set("\"".$k."\"",$v);
    		}
    	} 	
    	
    	// set primary key
    	$this->db->set($primary_key,$nextvalue);    	
    	
    	$insert = $this->db->insert($this->table_name);
    	if($insert)
    	{
    		$this->db->cache_delete_all();
    		
    		return $nextvalue;
    	}
    	return false;
    }

    function db_delete($primary_key_value)
    {
    	$primary_key_field = $this->get_primary_key();

    	if($primary_key_field === false)
    		return false;

    	$this->db->limit(1);
    	$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
    	if( $this->db->affected_rows() != 1)
    		return false;
    	else
    	{
    		$this->db->cache_delete_all();
    		
    		return true;
    	}
    }

    function db_file_delete($field_name, $filename)
    {
    	if( $this->db->update($this->table_name,array($field_name => ''),array($field_name => $filename)) )
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    function field_exists($field,$table_name = null)
    {
    	if(empty($table_name))
    	{
    		$table_name = $this->table_name;
    	}
    	return $this->db->field_exists($field,$table_name);
    }

    function get_primary_key($table_name = null)
    {
    	if ($this->db->dbprefix('users')==$table_name)
    		return "user_id";

    	if ($this->db->dbprefix('groups')==$table_name)
    		return "group_id";    	

    	if ($this->db->dbprefix('workflow_status')==$table_name)
    		return "workflow_status_id";    	

    	if ($this->db->dbprefix('workflows')==$table_name)
    		return "workflow_id";  

    	if ($this->db->dbprefix('notifications')==$table_name)
    		return "notification_id";

    	if ($this->db->dbprefix('comment')==$table_name)
    		return "comment_id";    	
    	
    	if($table_name == null)
    	{
    		if(isset($this->primary_keys[$this->table_name]))
    		{
    			return $this->primary_keys[$this->table_name];
    		}

	    	if(empty($this->primary_key))
	    	{
		    	$fields = $this->get_field_types_basic_table();

		    	foreach($fields as $field)
		    	{
		    		if($field->primary_key == 1)
		    		{
		    			return $field->name;
		    		}
		    	}

		    	return false;
	    	}
	    	else
	    	{
	    		return $this->primary_key;
	    	}
    	}
    	else
    	{
    		if(isset($this->primary_keys[$table_name]))
    		{
    			return $this->primary_keys[$table_name];
    		}

	    	$fields = $this->get_field_types($table_name);

	    	foreach($fields as $field)
	    	{
	    		if($field->primary_key == 1)
	    		{
	    			return $field->name;
	    		}
	    	}

	    	return false;
    	}

    }

    function escape_str($value)
    {
    	return $this->db->escape_str($value);
    }




	public function EditSurvey($citizen_id='',$data='',$table="SURVEY_2018")
	{		//$table = "SURVEY_2018";//getMahadthaiDbTable();
		
		if (!isset($data[strtoupper('COOP_ID')]) && !is_numeric($data[strtoupper('COOP_ID')]))
		{
			return false;			
		}			
		
		if($citizen_id!='') {
			$this->db->trans_start();
			$this->db->where('citizen_id', $citizen_id);
			$this->db->where('COOP_ID', $data[strtoupper('COOP_ID')]);
			
			
			$time = time();
			$currenttimestr = date('Y-m-d H:i:s',$time);
			$this->db->set('"modified_at"', "TO_DATE('$currenttimestr','yyyy-mm-dd hh24:mi:ss')", false);
			$data['modified_by'] = $this->session->userdata('auth_user_id');
			
			if ($this->db->update($table, $data)) {

				//$this->utils->insert_function($data);
				//	$this->utils->update_function2($test);
				$this->db->trans_complete();
				$this->db->trans_commit();
				return true;
			}
		}
		return false;
	}


	public function addSurvey($data,$table="SURVEY_2018")
	{		//$table = "SURVEY_2018";//getMahadthaiDbTable();
		$this->db->trans_start();
		
		$time = time();
		$currenttimestr = date('Y-m-d H:i:s',$time);
		$this->db->set('"modified_at"', "TO_DATE('$currenttimestr','yyyy-mm-dd hh24:mi:ss')", false);
		$this->db->set('"created_at"', "TO_DATE('$currenttimestr','yyyy-mm-dd hh24:mi:ss')", false);
		$data['modified_by'] = $this->session->userdata('auth_user_id');
		$data['created_by'] = $this->session->userdata('auth_user_id');		
		
		if ($this->db->insert($table, $data)) {

			//$this->utils->insert_function($data);
			//	$this->utils->update_function2($test);
			$this->db->trans_complete();
			$this->db->trans_commit();
			
			return true;
		}

		return false;
	}

	public function gettheSurvey($idcard=0,$coop_id,$table="SURVEY_2018"){

		$select = '"citizen_id", 
"coop_member_id", 
"citizen_firstname", 
"citizen_lastname", 
"citizen_birthdate", 
"citizen_address1", 
"citizen_address2", 
"citizen_city", 
"citizen_zipcode", 
"citizen_already_in_f1", 
"created_at", 
"modified_at", 
"created_by", 
"modified_by", 
"HOUSEHOLD_CODE", 
"FAMILY_STATUS", 
"FAMILY_STATUS_OTHERS", 
"HOUSE_NO", 
"VILLAGE_NO", 
"PROVINCE_ID", 
"DISTRICT_ID", 
"SUB_DISTRICT_ID", 
"PROVINCE_NAME", 
"DISTRICT_NAME", 
"SUB_DISTRICT_NAME", 
"HOME_PHONE_NO", 
"CELL_PHONE", 
"ORG_TYPE", 
"FARMER_GROUP_NAME", 
"JOINING_DATE", 
"PROVINCE_CODE", 
"COOPERATIVE_CODE", 
"BUDGET_YEAR", 
"SURVEY_CODE", 
"EDUCATION_CODE", 
"STOCK_REGISTER", 
"SHARES_NUM", 
"LAND_HOLDING_RAI", 
"LAND_HOLDING_NGAN", 
"LAND_HOLDING_SQUAREWA", 
"WATER_TYPE", 
"WATER_HOLDING_RAI", 
"WATER_HOLDING_NGAN", 
"WATER_HOLDING_SQUAREWA", 
"WATER_TYPE_OTHERS", 
"TAB2_AREA_RAI", 
"TAB2_AREA_NGAN", 
"TAB2_AREA_SQUAREWA", 
"OBLIGATION_LAND", 
"LAND_OTHER_REASON", 
"FARM_EQU", 
"PLANT_TYPE", 
"PLANT_SPECIE", 
"PLANTING_NUM_PER_YEAR", 
"GROWING_AREA", 
"PRODUCT_NUM_PER_YEAR", 
"PLANT_SELL_MECHANT", 
"PLANT_SELL_COOP", 
"PLANT_SELL_OTHER", 
"ESTSALES_REVENUEYEAR", 
"ESTAGRI_INCOMEYEAR", 
"HOW2SELL", 
"HOW2SELL_OTHERS_REASON", 
"PRODUCT_SALE_COMMENT", 
"PRODUCT_SALE_OTHER", 
"PRODUCT_SALE_COMMENT2", 
"PRODUCT_SALE_OTHER2", 
"CHM1_46_0_0", 
"CHM2_15_15_15", 
"CHM3_16_20_0", 
"CHM4_OTHER", 
"CHM2_INTR", 
"CHM1_WATER", 
"CHM2_C_C_C", 
"ANI_TYPE", 
"ANI_SPECIE", 
"ANI_NUM_PER_YEAR", 
"ANI_INCOME", 
"ANI_EXPENSE_PER_YEAR", 
"ANI_AREA_RAI", 
"ANI2_TYPE", 
"ANI2_SPECIE", 
"ANI2_EXPENSE_PER_YEAR", 
"ANI2_FOOD", 
"ANI2_INCOME", 
"ANI2_WETCHAPAN", 
"TAB5_A1", 
"TAB5_A1_PROBLEM", 
"TAB5_A2", 
"TAB5_A2_PROBLEM", 
"TAB5_A3", 
"TAB5_A4", 
"TAB5_A5", 
"TAB5_A6", 
"TAB5_A6_OTHER", 
"TAB4_B6", 
"TAB4_B6_OTHER", 
"TAB5_DEBT_NUM", 
"TAB5_DEBT_NUM_COOP", 
"TAB5_DEBT_NUM_BAAC", 
"TAB5_DEBT_NUM_B_OTHERS", 
"TAB5_DEBT_NUM_HOUSING", 
"TAB5_DEBT_NUM_MIDDLE_MAN", 
"TAB5_DEBT_NUM_THE_NEIG", 
"TAB5_DEBT_NUM_OTHERS", 
"TAB5_DEBT_NORMAL_COOP", 
"TAB5_DEBT_NORMAL_BAAC", 
"TAB5_DEBT_NORMAL_B_OTHERS", 
"TAB5_DEBT_NORMAL_HOUSING", 
"TAB5_DEBT_NORMAL_MIDDLE_MAN", 
"TAB5_DEBT_NORMAL_THE_NEIG", 
"TAB5_DEBT_NORMAL_OTHERS", 
"TAB5_DEBT_ABNORMAL_COOP", 
"TAB5_DEBT_ABNORMAL_BAAC", 
"TAB5_DEBT_ABNORMAL_B_OTHERS", 
"TAB5_DEBT_ABNORMAL_HOUSING", 
"TAB5_DEBT_ABNORMAL_MIDDLE_MAN", 
"TAB5_DEBT_ABNORMAL_THE_NEIG", 
"TAB5_DEBT_ABNORMAL_OTHERS", 
"TAB5_DEBT_THE_OTHERS", 
"TAB6_A1_TYPE", 
"TAB6_A1_SPECIES", 
"TAB6_A1_DOING", 
"TAB6_A1_WILLDO", 
"TAB6_A1_EXPECTED_OUTPUT", 
"TAB6_A2_TYPE", 
"TAB6_A2_SPECIES", 
"TAB6_A2_DOING", 
"TAB6_A2_WILLDO", 
"TAB6_A2_EXPECTED_OUTPUT", 
"TAB7_A1_BUCKET_NO", 
"TAB7_A1_COWS1", 
"TAB7_A1_COWS2", 
"TAB7_A1_COWS3", 
"TAB7_A1_COWS4", 
"TAB7_A1_COWS5", 
"TAB7_A1_COWSMILK_PREGNANT", 
"TAB7_A1_COWSMILK_NOTPREGNANT", 
"TAB7_A1_COWSMILK_ALL", 
"TAB7_A1_COWSLAY_PREGNANT", 
"TAB7_A1_COWSLAY_NOTPREGNANT", 
"TAB7_A1_COWSLAY_ALL", 
"TAB7_A1_COWS_TOTAL", 
"COOP_ID", 
"REGISTRATION_NUMBER", 
"SALE_PROBLEMS", 
"NAME_TITLE", 
"FARM_EQU_THERS", 
"NEED_HELP_AGRI", 
"NEED_HELP_MARKET", 
"CITIZEN_PREFIX", 
"CITIZEN_LANE", 
"CITIZEN_ROAD", 
"OWN_LAND_TYPE", 
"OWN_LAND_NUMBER", 
"OWN_LAND_RAVANG", 
"OWN_LAND_PIN", 
"OWN_LAND_PNAME", 
"OWN_LAND_SNAME", 
"TAB2_AREA_TYPE", 
"TAB2_AREA_NUMBER", 
"TAB2_AREA_RAVANG", 
"TAB2_AREA_PIN", 
"TAB2_AREA_PNAME", 
"TAB2_AREA_SNAME", 
"WATER", 
"WATER_SHALLOW_WELL_OWN", 
"WATER_GROUNDWATER_WELLS_OWN", 
"WATER_GROUNDWATER_WELLS_PUBLIC", 
"WATER_SWAMP_PUBLIC", 
"WATER_IRRIGATION_CANAL_PUBLIC", 
"WATER_RIVER_PUBLIC", 
"OWN_LAND_HOLDING_RAI", 
"OWN_LAND_HOLDING_NGAN", 
"OWN_LAND_HOLDING_SQUAREWA", 
"DO_BUZ", 
"YEAR_INCOME", 
"FAMILY_NAME", 
"FAMILY_CITIZEN_ID", 
"EMAIL", 
"AGRICULTURE_INCOME", 
"OUT_AGRICULTURE_INCOME", 
"DO_BUZ_TEXT", 
"DO_BUZ_OTHER", 
"DO_BUZ2", 
"WATER_PONDS_OWN", 
"ANI_FOOD", 
"ANI_WETCHAPAN", 
"ANI2_NUMYEAR", 
"SECONDARY_CAREER", 
"MAIN_CAREER", 
"CHM1_SEED", 
"CHM2_SEED", 
"CHM1_SEED_TEXT", 
"CHM2_SEED_TEXT", 
"OWN_LAND_TYPE_TYPE", 
"OWN_LAND_SQUAREWA", 
"OWN_LAND_NGAN", 
"OWN_LAND_RAI", 
"GROWING_AREA_WILL", 
"MAIN_CAREER_ORTHER", 
"SECONDARY_CAREER_ORTHER", 
"ANI_NUM_WILL", 
"ANI_NUM_SALE", 
"ANI2_WILL", 
"ANI2_SALE"';		
		
		$result = array();
		if($idcard>0) {
			$sql = "    SELECT $select FROM " . $table . "  WHERE    'citizen_id'    IS NOT NULL and COOP_ID  IS NOT NULL  and 'citizen_firstname' IS NOT NULL   ";
			$sql .= '  and  "citizen_id" = ';
			$sql .= "'{$idcard}'   ";
			$sql .= '  and  COOP_ID = ';
			$sql .= "'{$coop_id}'   ";			
			$sql .= ' order by "created_at" DESC ';
			$query = $this->db->query($sql);
			$result = $query->result_array();
		}
		return $result;
	}


	public function updateSurvey($id, $data = array())
	{   $table = getMahadthaiDbTable();
		$this->db->where('citizen_id', $citizen_id);
		if ($this->db->update($table, $data)) {
			return true;
		}
		return false;
	}
}
