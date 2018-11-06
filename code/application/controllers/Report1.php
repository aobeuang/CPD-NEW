<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report1 extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		
		$this->load->helper('form');
		$this->load->helper('survey');
		$this->load->helper('log');
		$this->load->helper('analytic');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->library('session');
		$this->load->library('grocery_CRUD');
		
		if (!canViewReport())
		{
			redirect('/');
		}
		
		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
// 		$this->output->enable_profiler(false);

	}

	function _report_output($output = null)
	{
		echo $this->load->view('auth/page_header', '', TRUE);
		
		$this->load->view('table_body.php',$output);
		
		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	public function index()
	{
		if( $this->require_role('admin') )
		{				
			echo $this->load->view('auth/page_header', '', TRUE);
			
			echo "all reports";
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}		
	}
	public function report_cout(){
		if( $this->require_role('admin') )
		{
			$this->is_logged_in();
	
			$crud = new grocery_CRUD();
	
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
	
			$crud->display_as('identification_id','เลขโฉนด')
			->display_as('address1','ที่อยู่ 1')
			->display_as('address2','ที่อยู่ 2')
			->display_as('city','เมือง')
			->display_as('state','จังหวัด')
			->display_as('postal_code','รหัสไปรษณีย์')
			->display_as('customer_id','สมาชิก')
			->display_as('image_path','รูปโฉนด')
			->display_as('maters','ตารางวา')
			->display_as('ngan','งาน')
			->display_as('rai','ไร่')
			;

			$crud->where('((lands.rai*400)+(lands.ngan*100)+lands.meters)>100',null,false);
			$crud->set_table('lands');
			$crud->set_relation('customer_id','customers','{customer_name})');
			$crud->set_subject('ที่ดิน');
	
			$crud->columns('identification_id','customer_id','image_path','address1','address2','city','state','postal_code','maters','ngan','rai');
			$crud->unset_edit_fields('identification_id','customer_id','image_path','address1','address2','city','state','postal_code','maters','ngan','rai');
			$crud->fields('identification_id','customer_id','image_path','address1','address2','city','state','postal_code','maters','ngan','rai');
				
			$crud->field_type('created_at','date');
			$crud->field_type('updated_at','date');
			$crud->set_field_upload('image_path','assets/uploads/files');
				
			$crud->callback_after_insert(array($this, 'log_user_after_insert'));
			$crud->callback_after_update(array($this, 'log_user_after_update'));
			$crud->callback_before_upload(array($this, '_valid_images'));
				
			$crud->required_fields('identification_id','address1');
			$crud->set_rules('identification_id','เลขโฉนด','required');
				
			$crud->add_action('พิมพ์โฉนด', '', '','fa fa-print',array($this,'_print_land'));
			$crud->unset_delete();
				
			$crud->callback_column('customer_id',array($this,'_callback_customer_url'));
	
			$output = $crud->render();
	
			$this->_report_output($output);
		}
	}
	
	public function index1()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "0";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_status' => $filter_status,
					'filter_year' => $filter_year,					
					'filter_province' => $filter_province,
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report1', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	public function index2()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "0";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_status' => $filter_status,
					'filter_year' => $filter_year,
					'filter_province' => $filter_province,
					'filter_range_income' => $filter_range_income,
			);
			
			echo $this->load->view('reports/report2', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	
	public function index3()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "0";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
// 			$query = $this->db->get('SURVEY_2018')->result_array();
			$output = array(
					'filter_status' => $filter_status,
					'filter_year' => $filter_year,
					'filter_province' => $filter_province,
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report3', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}

	
	
	public function index4()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_loan = isset($_GET['filter_loan'])? trim($_GET['filter_loan']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "0";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_year' => $filter_year,
					'filter_loan' => $filter_loan,
					'filter_province' => $filter_province,
					'filter_status' => $filter_status,
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report4', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	
	public function index5()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
						
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_loan = isset($_GET['filter_loan'])? trim($_GET['filter_loan']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "0";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_year' => $filter_year,
					'filter_loan' => $filter_loan,
					'filter_province' => $filter_province,
					'filter_status' => $filter_status,
					'filter_range_income' => $filter_range_income,
			);
			
			echo $this->load->view('reports/report5', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	
	public function index6()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_loan = isset($_GET['filter_loan'])? trim($_GET['filter_loan']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "1";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_year' => $filter_year,
					'filter_loan' => $filter_loan,
					'filter_province' => $filter_province,
					'filter_status' => $filter_status,
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report6', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	
	
	public function index7()
	{
		if(canViewReport())
		{
			
			echo $this->load->view('auth/page_header', '', TRUE);
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report7', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			die('rrr');
			redirect('/');
		}
	}
	
	
	
	
	public function index8()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report8', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	
	
	
	public function index9()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_plant = isset($_GET['filter_plant'])? trim($_GET['filter_plant']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_status= isset($_GET['filter_status'])? trim($_GET['filter_status']): "1";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_year' => $filter_year,
					'filter_plant' => $filter_plant,
					'filter_province' => $filter_province,
					'filter_status' => $filter_status,
					'filter_range_income' => $filter_range_income,
			);
			
			echo $this->load->view('reports/report9', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	public function index10()
	{
		if(canViewReport())
		{	
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_infra = isset($_GET['filter_infra'])? trim($_GET['filter_infra']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			
			echo $this->load->view('auth/page_header', '', TRUE);
			
			
			$output = array(
					'filter_year' => $filter_year,
					'filter_infra' => $filter_infra,
					'filter_province' => $filter_province,
					'filter_range_income' => $filter_range_income,
			);
			
			echo $this->load->view('reports/report10', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	
	public function index11()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			$filter_plant = isset($_GET['filter_plant'])? trim($_GET['filter_plant']): "";
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "";
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_year' => $filter_year,
					'filter_plant' => $filter_plant,
					'filter_province' => $filter_province,
					'filter_range_income' => $filter_range_income,
			);
			
			echo $this->load->view('reports/report11', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/');
		}
	}
	public function index12()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			$filter_range_income= isset($_GET['filter_range_income'])? trim($_GET['filter_range_income']): "0";
			$output = array(
					'filter_range_income' => $filter_range_income,
			);
			echo $this->load->view('reports/report12', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
}