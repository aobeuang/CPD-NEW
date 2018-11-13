<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginlog extends MY_Controller {

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
		$this->load->helper('survey');
	}
	public function _formlog_output($output = null)
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
	

	
	public function index(){	
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();			
			
			$table = $this->db->dbprefix('denied_access');
			$crud->set_table($table);
			$crud->set_primary_key('ai');
			$crud->set_subject('Denied Access');
			$crud->columns('ip_address','time');			
			$crud->fields('ip_address','time');		
			$crud->unset_add();
			$crud->unset_edit();
			//$crud->unset_export();
			//$crud->unset_print();
			$output = $crud->render();			
			$this->_formlog_output($output);	
		}
	}

	public function formauth(){
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('auth_sessions');
			$crud->set_table($table);
			$crud->set_primary_key('id');
			$crud->set_subject('Auth');
			$crud->columns('id','login_time','ip_address','user_agent');
			$crud->fields('id','login_time','ip_address','user_agent');
			//$crud->field_type('login_time','date');
			
			$crud->callback_column('login_time',array($this,'_callback_changetimestamp'));
			
			$crud->unset_add();
			$crud->unset_edit();
			//$crud->unset_export();
			//$crud->unset_print();
			$output = $crud->render();
			$this->_formlog_output($output);
		}
	}
	
	public function formloginerror(){
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('login_errors');
			$crud->set_table($table);
			$crud->set_primary_key('ai');
			$crud->set_subject('Login Errors');
			$crud->columns('username_or_email','ip_address','time');
			$crud->fields('username_or_email','ip_address','time');
			$crud->unset_add();
			$crud->unset_edit();
			//$crud->unset_export();
			//$crud->unset_print();
			$output = $crud->render();
			$this->_formlog_output($output);
		}
	}
	
	public function formips(){
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('ips_on_hold');
			$crud->set_table($table);
			$crud->set_primary_key('ai');
			$crud->set_subject('IPs On Hold');
			$crud->columns('ip_address','time');
			$crud->fields('ip_address','time');
			$crud->unset_add();
			$crud->unset_edit();
			//$crud->unset_export();
			//$crud->unset_print();
			$output = $crud->render();
			$this->_formlog_output($output);
		}
	}
	
	public function formci(){
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$table = $this->db->dbprefix('ci_sessions');
			$crud->set_table($table);
			
			$crud->callback_column('timestamp',array($this,'_callback_webpage_url'));
			
			$crud->set_primary_key('id');
			$crud->set_subject('User Sessions');
			$crud->columns('id','ip_address','timestamp');
			$crud->fields('id','ip_address','timestamp');
			
			$crud->callback_column('timestamp',array($this,'_callback_changetimestamp'));
			
			$crud->unset_add();
			$crud->unset_edit();
			//$crud->unset_export();
			//$crud->unset_print();
			$output = $crud->render();
			$this->_formlog_output($output);
		}
	}
	
	public function _callback_changetimestamp($value, $row)
	{
		if (!is_numeric($value))
		{
			return $value;
			
			//$time = strtotime($value);	
			//return date('d/m/Y h:i:s', $time);
		}
		
		return date('d/m/Y h:i:s', $value);
	}
	public function suspiciouslog_management()
	{
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$this->is_logged_in();
			
			
			// close the default connection
			$this->db->close();
			// connect to the other db
			$this->db = $this->load->database('cooplog', true);
			
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('logactivity');
			$crud->set_table($table);
			
			/*
			 *
			 *   `logactivityid` INT(11) NOT NULL AUTO_INCREMENT,
			 `name` VARCHAR(128) NULL,
			 `detail` TEXT NULL,
			 `citizen_id` VARCHAR(128) NULL,
			 `citizen_province` VARCHAR(128) NULL,
			 `actor_name` VARCHAR(128) NULL,
			 `actor_province` VARCHAR(128) NULL,
			 `created_at` DATETIME NULL,
			 *
			 */
			
			
			$crud->set_primary_key('logactivityid');
			$crud->columns('created_at','name','citizen_name','citizen_province','actor_province','actor_name');
			$crud->fields('created_at','name','citizen_id','citizen_name','citizen_province','actor_province','actor_name');
			
			$crud->display_as('created_at', 'วันและเวลาที่เข้าดู')
			->display_as('name', 'ประเภทของประวัติ')
			->display_as('detail', 'ชื่อกิจกรรม')
			->display_as('citizen_province', 'จังหวัดของสมาชิก')
			->display_as('actor_name', 'ชื่อผู้ใช้งาน')
			->display_as('actor_province','จังหวัดของผู้ใช้งาน')
			->display_as('citizen_name','ชื่อ-สกุลของสมาชิก')
			->display_as('citizen_id','เลขบัตรประชาชน');
			
			$crud->set_subject('ประวัติการเรียกดูข้อมูลสมาชิก');
			// $crud->field_type('citizen_id', 'hidden');
			$crud->field_type('created_at', 'text');

			$crud->callback_column('created_at', array($this, 'callback_date'));
			// $crud->callback_edit_field('created_at',array($this,'callback_date'));
			// $crud->callback_column('citizen_id', array($this, 'callback_name_bycitizen'));


			
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			
			$crud->iframe_url = null;
			$crud->order_by('logactivityid', 'desc');
			
			$output = $crud->render();
			
			// close the default connection
			$this->db->close();
			// connect to the other db
			$this->db = $this->load->database('default', true);
			
			$this->_admin_output($output);
		}
		else
		{
			$redirect_protocol = "http";
			redirect(site_url( LOGIN_PAGE . '?redirect=' . "loginlog/suspiciouslog_management", $redirect_protocol ));
		}
		
		
	}
	public function suspiciouslogreport_management()
	{
		if( $this->session->userdata('auth_role')=="admin" )
		{
			$this->is_logged_in();
			
			
			// close the default connection
			$this->db->close();
			// connect to the other db
			$this->db = $this->load->database('cooplog', true);
			
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('logactivityreport');
			$crud->set_table($table);
			
			/*
			 *
			 *   `logactivityid` INT(11) NOT NULL AUTO_INCREMENT,
			 `name` VARCHAR(128) NULL,
			 `detail` TEXT NULL,
			 `citizen_id` VARCHAR(128) NULL,
			 `citizen_province` VARCHAR(128) NULL,
			 `actor_name` VARCHAR(128) NULL,
			 `actor_province` VARCHAR(128) NULL,
			 `created_at` DATETIME NULL,
			 *
			 */
			
// 			IP address
			$crud->set_primary_key('logactivityid');
			$crud->columns('created_at','detail','search_province','actor_name','actor_province');
			$crud->fields('created_at','detail','search_province','actor_name','actor_province');
			 $crud->unset_fields('citizen_id', 'citizen_province');
			
			$crud->display_as('created_at', 'วันและเวลาที่เข้าดู')
			->display_as('name', 'ชื่อกิจกรรม')
			->display_as('detail', 'ประเภทของประวัติ')
			->display_as('search_province', 'จังหวัดที่เรียกดู')
			->display_as('actor_name', 'ชื่อผู้ใช้งาน')
			->display_as('actor_province','จังหวัดของผู้ใช้งาน')
			
			;

			// $crud->field_type('detail', 'text');
			

			$crud->set_subject('ประวัติการเข้าใช้งานระบบ');
			$crud->field_type('created_at', 'text');

			$crud->callback_column('created_at', array($this, 'callback_date'));
			$crud->callback_edit_field('created_at',array($this,'callback_date'));
			$crud->callback_column('detail', array($this, 'callback_text'));
			

			
			
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			
			$crud->iframe_url = null;
			$crud->order_by('logactivityid', 'desc');
			
			$output = $crud->render();
			
			
			// close the default connection
			$this->db->close();
			// connect to the other db
			$this->db = $this->load->database('default', true);
			
			$this->_admin_output($output);
			
		}
		else
		{
			$redirect_protocol = "http";
			redirect(site_url( LOGIN_PAGE . '?redirect=' . "loginlog/suspiciouslog_management", $redirect_protocol ));
		}
		
		
	}
	function _admin_output($output = null)
	{
		echo $this->load->view('auth/page_header', '', TRUE);
		
		$this->load->view('table_body.php',$output);
		
		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	public function callback_text($val, $row)
	{

		
		return trim($val," ");

	        // return date('Y-m-d', strtotime($val));
	}

	public function callback_date($val, $row)
	{

		$strYear = date("Y",strtotime($val))+543;
		$strMonth= date("m",strtotime($val));
		$strDay= date("d",strtotime($val));
		$strHour= date("H",strtotime($val));
		$strMinute= date("i",strtotime($val));
		$strSeconds= date("s",strtotime($val));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay-$strMonth-$strYear $strHour:$strMinute:$strSeconds";

	        // return date('Y-m-d', strtotime($val));
	}

	public function callback_name_bycitizen($val, $row)
	{

		$name = getMemberByCitizenID($val);



		return $name['COOP_NAME_TH'];

	        // return date('Y-m-d', strtotime($val));
	}
	
}

