<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends MY_Controller {



	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->helper('form');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));

		$this->load->library('session');
		$this->load->library('grocery_CRUD');
		$this->load->helper('user_helper');

		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
 		$this->output->enable_profiler(FALSE);
	}
	public function _properties_output($output = null)
	{	
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
		echo $this->load->view('auth/page_header', '', TRUE);
	
		echo $this->load->view('table_body.php',$output);		
	
		echo $this->load->view('auth/page_footer', '', TRUE);
		}
	}
	
	public function index()
	{
		if( $this->require_role('admin') )
		{
			$this->_properties_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		}
	}
	
	public function properties(){	
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->display_as('name','name')
			->display_as('propvalue','value');
			$crud->set_table('properties');
			$crud->set_primary_key('properties_id');
			$crud->set_subject('System Properties');

			$crud->columns('name','propvalue', "created_at", "modified_at", "created_by", "modified_by");
			$crud->edit_fields('name','propvalue', "modified_at", "modified_by");
			$crud->add_fields('name','propvalue',"created_at", "created_by", "modified_at", "modified_by");
			
			$crud->field_type('created_at','hidden');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_by','hidden');
						
			//$crud->fields('name','propvalue');
			//$crud->unset_add_fields('properties_id');
			//$crud->unset_edit_fields('properties_id');
			$crud->callback_after_delete(array($this,'clean_cache_callback'));
			
			$crud->callback_before_update(array($this,'log_activity_before_update'));
			$crud->callback_before_insert(array($this,'log_activity_before_insert'));			
			
			$crud->set_rules('name','ชื่อ','required');
			$crud->set_rules('propvalue','ค่าของคุณสมบัติระบบ','required');
			
			$output = $crud->render();			
			$this->_properties_output($output);	
		}else{
			redirect('/');
		}
	}
	
	public function log_activity_before_update($post_array,$primary_key)
	{
		if (isset($post_array['name']))
			$post_array['name'] = trim($post_array['name']);
		if (isset($post_array['propvalue']))
			$post_array['propvalue'] = trim($post_array['propvalue']);
		
		$cache_key = "systemproperties";
		$this->cache->delete($cache_key);		
		
		$currenttime = date('Y-m-d H:i:s',time());
		$post_array['modified_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		
		return $post_array;
	}
	
	public function log_activity_before_insert($post_array,$primary_key=null)
	{
		if (isset($post_array['name']))
			$post_array['name'] = trim($post_array['name']);
		if (isset($post_array['propvalue']))
			$post_array['propvalue'] = trim($post_array['propvalue']);
		
		$cache_key = "systemproperties";
		$this->cache->delete($cache_key);		
		
		$currenttime = date('Y-m-d H:i:s',time());
		$post_array['modified_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
		$post_array['created_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
	
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		$post_array['created_by'] = $this->session->userdata('auth_user_id');
	
		return $post_array;
	}	
	
	

	
	//TODO
	public function getToken(){
		if( $this->session->userdata('auth_role')=="admin" )
		{
		$this->load->helper('document');
		$this->load->helper('task');
		echo "<pre>";
// 		print_r(getDocumentUrl('admin','V'));
	print_r(getUrlTaskBranched(2));
	echo "</pre>";
		}
	}
	

}