<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mylogger extends MY_Controller {

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
	public function _log_output($output = null)
	{	
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
		echo $this->load->view('auth/page_header', '', TRUE);
	
		echo $this->load->view('table_body.php',$output);		
	
		echo $this->load->view('auth/page_footer', '', TRUE);
		}
	}
	

	
	public function index(){	
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->display_as('name','Name')
			->display_as('status','Status')
			->display_as('description','Description');

			$table = $this->db->dbprefix('logs');
			$crud->set_table($table);
			$crud->order_by('created_at','desc');
			$crud->set_primary_key('log_id');
			$crud->set_subject('Logs');
			$crud->columns('name','status','description','created_at');			
			$crud->fields('name','status','description','created_at');
			$crud->unset_add_fields('log_id');
			$crud->unset_edit_fields('log_id');
			
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_add();
			
			$output = $crud->render();			
			$this->_log_output($output);	
		}
		else{
			redirect('/');
		}
	}
	


}