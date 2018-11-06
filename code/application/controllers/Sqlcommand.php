<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sqlcommand extends MY_Controller {



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

		$this->output->enable_profiler($this->config->item('profiling_enabled'));
// 		$this->output->enable_profiler(FALSE);
	}
	public function _sql_output($output = null)
	{	
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);
		
			echo $this->load->view('table_body.php',$output);		
		
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	

	/*
	
	CREATE TABLE "sql_commands"(
			"command_id" INTEGER NOT NULL,
			"group_name" VARCHAR2(64) DEFAULT NULL,
			"name" VARCHAR2(200) DEFAULT NULL,
			"description" VARCHAR2(512) DEFAULT NULL,
			"command_type" VARCHAR2(16) DEFAULT NULL,
			"command_order" INTEGER DEFAULT NULL,
			"last_fail" TIMESTAMP DEFAULT NULL,
			"sql" VARCHAR2(64) NOT NULL;
			"last_success" TIMESTAMP DEFAULT NULL,
			"last_execution" TIMESTAMP DEFAULT NULL,
			"created_at" TIMESTAMP DEFAULT SYSDATE,
			"modified_at" TIMESTAMP DEFAULT SYSDATE,
			"created_by" INTEGER NOT NULL,
			"modified_by" INTEGER NOT NULL,
			"disabled" INTEGER DEFAULT 0
			PRIMARY KEY ("command_id")	
			*/
	
	
	public function index(){	
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->display_as('name','Name')
			->display_as('group_name','Group')
			->display_as('command_type','Type')
			->display_as('command_order','Order')
			->display_as('disabled','Active')
			->display_as('description','Description');
			
			$crud->set_table('sql_commands');
			$crud->order_by('created_at','desc');
			$crud->set_primary_key('command_id');
			$crud->set_subject('SQL Command');
			
			$crud->columns('name','group_name','command_type','command_order','last_execution','last_success', 'disabled', 'created_at', 'modified_at');			
			//$crud->fields('name','group_name','command_type','command_order','last_execution','last_success', 'last_fail', 'disabled', 'created_at', 'modified_at', 'created_by', 'modified_by');
			
			$crud->edit_fields('name','group_name','command_type','sql','command_order','description', 'disabled', 'modified_at', 'created_by', 'modified_by');
			$crud->add_fields('name','group_name','command_type','sql','command_order','description', 'disabled', 'created_at', 'modified_at', 'created_by', 'modified_by');
			
			$crud->unset_add_fields('command_id', 'last_execution', 'last_success', 'last_fail');
			$crud->unset_edit_fields('command_id', 'last_execution', 'last_success', 'last_fail');
			$crud->callback_before_insert(array($this,'insert_callback'));
			$crud->callback_before_update(array($this,'update_callback'));
			
			$crud->field_type('command_type','dropdown',
					array('stage'=>'Stage', 'clean'=>"Clean", 'switch'=>"Switch", 'build'=>"Build", 'sql'=>"SQL"));

			$crud->field_type('group_name','dropdown',
					array('1'=>"1",'2'=>"2",'3'=>"3",'4'=>"4",'5'=>"5"));

			$crud->field_type('disabled','dropdown',
					array('1'=>"Active", '2'=>"Not Active"));			
			
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_by','hidden');
			$crud->field_type('created_at','hidden');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('description','text');
			$crud->field_type('sql','text');
			$crud->field_type('command_order','integer');
			$crud->unset_texteditor("description");
			$crud->unset_texteditor("sql");
				
			$crud->set_rules('name','name','required');
			$crud->set_rules('command_type','Command Type','required');			
			$crud->set_rules('command_order','Order','required');
			$crud->set_rules('group_name','Group','required');
			$crud->set_rules('sql','SQL Statement','required');
				
			$output = $crud->render();			
			$this->_sql_output($output);	
		}
		else{
			redirect('/');
		}
		
	}
	
	function update_callback($post_array, $primary_key = null)
	{
		$currenttime = date('Y-m-d H:i:s',time());
		$post_array['modified_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		
		return $post_array;
	}
	
	function insert_callback($post_array, $primary_key = null)
	{
		$currenttime = date('Y-m-d H:i:s',time());
		$post_array['modified_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
		$post_array['created_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
			
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		$post_array['created_by'] = $this->session->userdata('auth_user_id');
		
		return $post_array;
	}	

}