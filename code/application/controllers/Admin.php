<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	public $group_id = null;
	public  $workflow_id = NULL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('file');		
		$this->load->helper('form');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));

		$this->load->library('session');
		$this->load->library('grocery_CRUD');

		$this->load->helper('properties');
		$this->load->helper('survey');
		$this->load->helper('user');
		$this->load->helper('log');

		$this->load->model('csv_import_model');
		$this->load->library('csvimport');
		

// 		$this->output->enable_profiler($this->config->item('profiling_enabled'));
		$this->output->enable_profiler(FALSE);



		
	}

	function _admin_output($output = null)
	{
		echo $this->load->view('auth/page_header', '', TRUE);

		$this->load->view('table_body.php',$output);

		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	function _admin_output_ajax($output = null)
	{
		echo $this->load->view('auth/page_header_ajax', '', TRUE);
		
		$this->load->view('table_body.php',$output);
		
		echo $this->load->view('auth/page_footer_ajax', '', TRUE);
	}
	
	public function index()
	{
		if( $this->require_role('admin') )
		{
			$this->_admin_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		}
	}
	
	
	
	
	
	function import($output = null)
	{
		echo $this->load->view('auth/page_header', '', TRUE);
	
		$this->load->view('admin/import',$output);

	
		echo $this->load->view('auth/page_footer', '', TRUE);
	}
	function import_user($output = null)
	{
		ob_start();
		echo $this->load->view('auth/page_header', '', TRUE);
	
		$this->load->view('admin/import',array('error' => ' ' ));
	
		echo $this->load->view('auth/page_footer', '', TRUE);
	}

	function importFile()
	{
		
	}
	
	
	public function clear_all_caches()
	{
		$this->cache->clean();
		print_r("All application caches have been deleted!!");
		redirect('/');
		// die();
	}

	public function addUsers($output = null)
	{

		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
			$provinces = array();
			$province_all = getAllProvinces();
			foreach ($province_all as $key => $value) {
				// echo $value->PROVINCE_ID.'<br>';
				$provinces[$value->PROVINCE_ID] = $value->PROVINCE_NAME;
			}

			$agency = $this->callAgency();


			$output = array(
				'province'	=> $provinces,
				'agency'	=> $agency,
			);

		echo $this->load->view('auth/page_header', '', TRUE);
		$this->load->view('new_users',$output);
		echo $this->load->view('auth/page_footer', '', TRUE);
		}else{
			redirect('/');
		}
	}

	public function addUsersCall($citizen = null)
	{

		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
		if (empty($_POST)) {
			redirect('/admin/users_management');
		}
		$citizen = !empty($this->input->post('citizen'))? trim($this->input->post('citizen')): null;
		$passwd = !empty($this->input->post('passwd'))? trim($this->input->post('passwd')): null;
		$name = !empty($this->input->post('name'))? trim($this->input->post('name')): null;
		$email = !empty($this->input->post('email'))? trim($this->input->post('email')): null;
		$auth = !empty($this->input->post('auth_level'))? trim($this->input->post('auth_level')): null;
		$agency = !empty($this->input->post('agency'))? trim($this->input->post('agency')): null;
		$province_id = !empty($this->input->post('province'))? trim($this->input->post('province')): null;
		$province_name = !empty($this->input->post('province_name'))? trim($this->input->post('province_name')): null;
		$org_id = !empty($this->input->post('org_id'))? trim($this->input->post('org_id')): null;
		$org_name = !empty($this->input->post('org_name'))? trim($this->input->post('org_name')): null;
		$banned = !empty($this->input->post('banned'))? trim($this->input->post('banned')): null;

		if(empty($citizen) || empty($passwd) || empty($name) || empty($email) || empty($auth) || empty($agency) || empty($province_id) || empty($province_name) || empty($org_id) || empty($org_name) || empty($banned))
		{
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่อีกครั้ง'));
            die();
		}

		if (!valid_citizen_id($citizen)) {
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'หมายเลขบัตรประชาชนไม่ถูกต้อง'));
            die();
		}

		if (!$this->checkDuplicateCitizen($citizen)) {
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'มีหมายเลขบัตรประชาชนนี้ในระบบแล้ว'));
            die();
		}

		if (!$this->checkDuplicateEmail($email)) {
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'มีอีเมล์นี้ในระบบแล้ว'));
            die();
		}
		

		




		$sequence_tablename = "USERS_SEQUENCE";
		$query = $this->db->query(" SELECT $sequence_tablename.nextval as nextvalue FROM dual ");
		$result = $query->result_array();;
		$nextvalue = !empty($result) && isset($result[0]['NEXTVALUE']) ? $result[0]['NEXTVALUE']: 1;
		if (empty($nextvalue))
		{
		header('Content-Type: application/json');
        echo json_encode(array('success'=>false, 'message'=> 'Create sequence named  $sequence_tablename'));
        die();
		}

		$c_email = null;
		if ($email != '-') {
			$c_email = $email;
		}

		$data[] = array(
		'user_id' => $nextvalue,
		'username' => $citizen,
		'name'  => $name,
		'auth_level'  => $auth,
		'AGENCY'  => $agency,
		'passwd'   => $this->hash_passwd($passwd),
		'banned'   => $banned,
		'province'   => $province_id,
		'province_name'   => $province_name,
		'ORG_ID'   => $org_id,
		'org_name'   => $org_name,
		'email'   => $c_email
		);

		if($this->db->insert_batch('users', $data)){
			addLogUsers("เพิ่มผู้ใช้งาน","เพิ่มผู้ใช้งาน ".$citizen."เข้าสู่ระบบ");
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>true, 'message'=>'สำเร็จ'));
	        die();
		}else{
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>false, 'message'=>'เกิดปัญหาการเพิ่มข้อมูล'));
	        die();
		}




		}else{
			redirect('/');
		}
	}

	public function updateUsersCall($citizen = null)
	{

		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
		if (empty($_POST)) {
			redirect('/admin/users_management');
		}
		$citizen = !empty($this->input->post('citizen'))? trim($this->input->post('citizen')): null;
		$passwd = !empty($this->input->post('passwd'))? trim($this->input->post('passwd')): null;
		$name = !empty($this->input->post('name'))? trim($this->input->post('name')): null;
		$email = !empty($this->input->post('email'))? trim($this->input->post('email')): null;
		$auth = !empty($this->input->post('auth_level'))? trim($this->input->post('auth_level')): null;
		$agency = !empty($this->input->post('agency'))? trim($this->input->post('agency')): null;
		$province_id = !empty($this->input->post('province'))? trim($this->input->post('province')): null;
		$province_name = !empty($this->input->post('province_name'))? trim($this->input->post('province_name')): null;
		$org_id = !empty($this->input->post('org_id'))? trim($this->input->post('org_id')): null;
		$org_name = !empty($this->input->post('org_name'))? trim($this->input->post('org_name')): null;
		$banned = !empty($this->input->post('banned'))? trim($this->input->post('banned')): null;

		if(empty($citizen) || empty($passwd) || empty($name) || empty($email) || empty($auth) || empty($agency) || empty($province_id) || empty($province_name) || empty($org_id) || empty($org_name) || empty($banned))
		{
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่อีกครั้ง'));
            die();
		}



		$c_email = null;
		if ($email != '-') {
			$c_email = $email;
		}

		$c_passwd = null;
		if ($passwd != 'nochange') {
			$c_passwd = $passwd;
		}

		$data = null;
		if (empty($c_passwd)) {

			$data = array(
			'username' => $citizen,
			'name'  => $name,
			'auth_level'  => $auth,
			'AGENCY'  => $agency,
			'banned'   => $banned,
			'province'   => $province_id,
			'province_name'   => $province_name,
			'ORG_ID'   => $org_id,
			'org_name'   => $org_name,
			'email'   => $c_email
			);

		}else{

			$data = array(
			'username' => $citizen,
			'name'  => $name,
			'auth_level'  => $auth,
			'AGENCY'  => $agency,
			'passwd'   => $this->hash_passwd($c_passwd),
			'banned'   => $banned,
			'province'   => $province_id,
			'province_name'   => $province_name,
			'ORG_ID'   => $org_id,
			'org_name'   => $org_name,
			'email'   => $c_email
			);

		}
		

		if($this->db->update('users', $data,array('username' => $citizen))){
			addLogUsers("อัพเดทผู้ใช้งาน".$citizen,"อัพเดทผู้ใช้งาน ".$citizen);
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>true, 'message'=>'สำเร็จ'));
	        die();
		}else{
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>false, 'message'=>'เกิดปัญหาการอัพเดทข้อมูล'));
	        die();
		}




		}else{
			redirect('/');
		}
	}

public function changeUsersCall($citizen = null)
	{

		// if(true)
		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
		if (empty($_POST)) {
			redirect('/admin/users_management');
		}
		$citizen = !empty($this->input->post('citizen'))? trim($this->input->post('citizen')): null;
		$passwd = !empty($this->input->post('passwd'))? trim($this->input->post('passwd')): null;
		

		if(empty($citizen) || empty($passwd))
		{
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'ไม่สามารถเปลี่ยนรหัสผ่านได้ กรุณาลองใหม่อีกครั้ง'));
            die();
		}

		$c_passwd = null;
		if ($passwd != 'nochange') {
			$c_passwd = $passwd;
		}

		$data = null;
		if (empty($c_passwd)) {
			header('Content-Type: application/json');
            echo json_encode(array('success'=>false, 'message'=> 'โปรดระบุรหัสผ่านใหม่ เพื่อเปลี่ยนรหัสผ่าน'));
            die();

		}else{

			$data = array(
			'username' => $citizen,
			'passwd'   => $this->hash_passwd($c_passwd)
			);

		}
		

		if($this->db->update('users', $data,array('username' => $citizen))){
			addLogUsers("เปลี่ยนรหัสผ่านผู้ใช้งาน".$citizen,"เปลี่ยนรหัสผ่านผู้ใช้งาน ".$citizen);
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>true, 'message'=>'เปลี่ยนรหัสผ่านเรียบร้อย'));
	        die();
		}else{
			header('Content-Type: application/json');
	        echo json_encode(array('success'=>false, 'message'=>'เกิดปัญหาการเปลี่ยนรหัสผ่าน'));
	        die();
		}




		}else{
			redirect('/');
		}
	}

	public function editUsers($output = null)
	{

		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
			$provinces = array();
			$province_all = getAllProvinces();
			foreach ($province_all as $key => $value) {
				// echo $value->PROVINCE_ID.'<br>';
				$provinces[$value->PROVINCE_ID] = $value->PROVINCE_NAME;
			}

			$agency = $this->callAgency();


			$output = array(
				'province'	=> $provinces,
				'agency'	=> $agency,
			);

		echo $this->load->view('auth/page_header', '', TRUE);
		$this->load->view('edit_users',$output);
		echo $this->load->view('auth/page_footer', '', TRUE);
		}else{
			redirect('/');
		}
	}

	public function changeUsers($output = null)
	{

		// if(true)
		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
			$provinces = array();
			$province_all = getAllProvinces();
			foreach ($province_all as $key => $value) {
				// echo $value->PROVINCE_ID.'<br>';
				$provinces[$value->PROVINCE_ID] = $value->PROVINCE_NAME;
			}

			$agency = $this->callAgency();


			$output = array(
				'province'	=> $provinces,
				'agency'	=> $agency,
			);

		echo $this->load->view('auth/page_header', '', TRUE);
		$this->load->view('change_user',$output);
		echo $this->load->view('auth/page_footer', '', TRUE);
		}else{
			redirect('/');
		}
	}

	public function getUsersID($id=null)
	{

		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{	
			if (empty($_GET)) {
				redirect('/');
			}
			$id = !empty($this->input->get('id'))? trim($this->input->get('id')): null;

			$user = getUsersIdAll($id);
			// echo print_r($user);die();

            // [user_id] => 186
            // [username] => 3710500707942
            // [name] => ศิรินาฏ  พันธุ์ภักดี
            // [auth_level] => 5
            // [banned] => 2
            // [passwd] => $2y$11$iEXnoaMg0TujeKShR8rHcek8JjRgegrT4GNPNzZ7NmhVB6EW1VPVG
            // [passwd_recovery_code] => 
            // [passwd_recovery_date] => 
            // [passwd_modified_at] => 
            // [last_login] => 23-NOV-18 02.06.54.000000 PM
            // [created_at] => 01-OCT-18 04.13.36.000000 PM
            // [modified_at] => 01-OCT-18 04.13.36.000000 PM
            // [created_by] => 152
            // [modified_by] => 152
            // [email] => abcd@xyz.com
            // [province] => 62
            // [AGENCY] => ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 7 จังหวัดขอนแก่น
            // [AUTH_LEVEL_NAME] => ผู้ใช้งานส่วนภูมิภาคระดับจัดการ
            // [ORG_ID] => 5153
            // [province_name] => นราธิวาส
            // [org_name] => สำนักงานสหกรณ์จังหวัดนราธิวาส


			$output = null;
			foreach ($user as $value) {
				$output = array(
					'user_id'	=>	$value->user_id,
					'username'	=>	$value->username,
					'name'	=>	$value->name,
					'auth_level'	=>	$value->auth_level,
					'banned'	=>	$value->banned,
					'passwd'	=>	'nochange',
					'email'	=>	$value->email,
					'province'	=>	$value->province,
					'AGENCY'	=>	$value->AGENCY,
					'ORG_ID'	=>	$value->ORG_ID,
					'province_name'	=>	$value->province_name,
					'org_name'	=>	$value->org_name
				);
			}
			// echo print_r($user['username']);die();


			header('Content-Type: application/json');
	        echo json_encode(array('success'=>true, 'message'=>'Success','data'=>$output));

			// echo print_r($user);die();


		}else{
			redirect('/');
		}
	}


	public function logUsers()
	{
		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{		
			$this->is_logged_in();
			
			$crud = new grocery_CRUD();

			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('logusers');
			$crud->set_table($table);
			
			$crud->set_primary_key('logusersid');
			$crud->columns('created_at','name','citizen_id','actor_name','actor_auth','actor_agency','actor_province');
			$crud->display_as('created_at','วันและเวลา')
				->display_as('name','การใช้งาน')
				->display_as('citizen_id','ผู้ใช้งาน')
				->display_as('actor_name','ชื่อผู้ใช้งาน')
				->display_as('actor_auth','สิทธิ์การใช้งาน')
				->display_as('actor_province','จังหวัดผู้ใช้งาน')
				->display_as('actor_agency','สังกัดหน่วยงาน');
			if ( $crud->getState()=='export' ) {
				$crud->callback_column('citizen_id', array($this, 'callback_text'));
			}

			$crud->callback_column('created_at', array($this, 'callback_date'));
			$crud->callback_field('created_at', array($this, 'callback_date'));
			


			$crud->set_subject('ผู้ใช้งานระบบ','	ประวัติการใช้งานระบบ');
			$crud->unset_delete();
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_read();

			// $crud->callback_column('ORG_ID', array($this, 'callback_org_name'));
			// $crud->callback_column('province', array($this, 'callback_province'));

			// if ($crud->getState()=='ajax_list') {
			// 	$crud->callback_column('ORG_ID', array($_POST[''], 'callback_org_id'));
			// 	$crud->callback_column('province', array($this, 'callback_province'));
			// }
			$crud->field_type('actor_auth','dropdown',
					array(	'1' => 'ผู้ใช้งานส่วนกลางระดับจัดการ',
							'2' => 'ผู้ใช้งานส่วนกลางระดับบริหาร',
							'5' => 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ',
							'6' => 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร' ,
							'8' => 'ผู้ดูแลระบบระดับจัดการ' ,
							'9' => 'ผู้ดูแลระบบระดับบริหาร'));


			$output = $crud->render();
		
			$this->_admin_output($output);
		}
		else{
			redirect('/');
		}
	}
	
	
	
	public function users_management()
	{
		if( $this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{		
			$this->is_logged_in();
			
			$crud = new grocery_CRUD();

			if ($crud->getState()=='add') {
				redirect('/admin/addUsers');
			}
			if ($crud->getState()=='edit') {
				redirect('/admin/editUsers/'.end($this->uri->segments));
			}

			// 	$sql = 'select * from "users"';

			// 	$query_nomal = $this->db->query($sql)->result_array();	
			// 	$data_temp = array();
			// 	foreach ($query_nomal as $data){
			// 		$temp_data = array();

			// 	}

			// 	echo $this->load->view('auth/page_header', '', TRUE);
	
			// 	$this->load->view('admin/list_table',$output, TRUE);
	
			// 	echo $this->load->view('auth/page_footer', '', TRUE);
			// die();
			// }
				
			// $crud->set_theme('datatables');
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			
			$table = $this->db->dbprefix('users');
			$crud->set_table($table);
			
			$crud->set_primary_key('user_id');
			$crud->columns('username','email','name','auth_level','AGENCY','province_name','org_name');
			$crud->edit_fields('username','email','name','passwd','auth_level','AGENCY','province','ORG_ID','banned', 'modified_at', 'modified_by','province_name','org_name');
			$crud->fields('username','email','name','passwd','auth_level','AGENCY','province','ORG_ID','banned','province_name','org_name');
			$crud->add_fields('username','email','name','passwd','auth_level','AGENCY','province','ORG_ID','banned', 'created_at', 'modified_at','created_by','modified_by','province_name','org_name');
			$crud->set_read_fields('username','email','name','auth_level','AGENCY','province');
			$crud->display_as('username','ชื่อบัญชีผู้ใช้')
				->display_as('name','ชื่อ')
				->display_as('last_login','ล็อกอินครั้งล่าสุด')
				->display_as('created_at','สร้างเมื่อ')
				->display_as('modified_at','แก้ไขเมื่อ')
				->display_as('banned','อนุญาตให้ใช้')
				->display_as('email','อีเมล')
				->display_as('passwd','รหัสผ่าน')
				->display_as('auth_level','บทบาท')
				->display_as('province','จังหวัด')
				->display_as('province_name','จังหวัด')
				->display_as('ORG_ID','เขตพื้นที่')
				->display_as('org_name','เขตพื้นที่')
				->display_as('AGENCY','สังกัดหน่วยงาน')

			;
			$crud->set_subject('ผู้ใช้งานระบบ','	การจัดการผู้ใช้งานระบบ');
			$crud->unset_delete();
			// $crud->callback_column('ORG_ID', array($this, 'callback_org_name'));
			// $crud->callback_column('province', array($this, 'callback_province'));

			// if ($crud->getState()=='ajax_list') {
			// 	$crud->callback_column('ORG_ID', array($_POST[''], 'callback_org_id'));
			// 	$crud->callback_column('province', array($this, 'callback_province'));
			// }
			$crud->field_type('auth_level','dropdown',
					array(	'1' => 'ผู้ใช้งานส่วนกลางระดับจัดการ',
							'2' => 'ผู้ใช้งานส่วนกลางระดับบริหาร',
							'5' => 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ',
							'6' => 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร' ,
							'8' => 'ผู้ดูแลระบบระดับจัดการ' ,
							'9' => 'ผู้ดูแลระบบระดับบริหาร'));

			// if ($crud->getState()=='add') {
			$crud->field_type('auth_level','dropdown',
					array(	'1' => 'ผู้ใช้งานส่วนกลางระดับจัดการ',
							'2' => 'ผู้ใช้งานส่วนกลางระดับบริหาร',
							'5' => 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ',
							'6' => 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร' ,
							'8' => 'ผู้ดูแลระบบระดับจัดการ' ,
							'9' => 'ผู้ดูแลระบบระดับบริหาร'));
			
			
			$crud->field_type('banned','dropdown',
					array('2' => 'ใช้งานได้','1' => 'ไม่ให้ใช้'));

			// $crud->field_type('username','numeric');
			
			$provinces = array();
			$province_all = getAllProvinces();
			foreach ($province_all as $key => $value) {
				// echo $value->PROVINCE_ID.'<br>';
				$provinces[$value->PROVINCE_ID] = $value->PROVINCE_NAME;
			}
			// echo '<pre>'.print_r($provinces).'</pre>';die();

			$org_name = array();
			$allkhet = getAllOrg();
			foreach ($allkhet as $key => $value) {
				// echo $value['org_name'].'<br>';
				$org_name[$value['org_org_id']] = $value['org_name'];
			}
			// echo '<pre>'.print_r($org_name).'</pre>';die();
			
			
			$agency= array(	
					"กองการเจ้าหน้าที่(กกจ)"=>"กองการเจ้าหน้าที่(กกจ)",
					"กองแผนงาน(กผง)"=>"กองแผนงาน(กผง)",
					"ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร(ศสท)"=>"ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร(ศสท)",
					"กองคลัง(กค)"=>"กองคลัง(กค)",
					"กลุ่มตรวจสอบภายใน(กตน)"=>"กลุ่มตรวจสอบภายใน(กตน)",
					"กลุ่มพัฒนาระบบบริหาร(กพร)"=>"กลุ่มพัฒนาระบบบริหาร(กพร)",
					"สำนักงานเลขานุการกรม(สลก)"=>"สำนักงานเลขานุการกรม(สลก)",
					"กองพัฒนาสหกรณ์ภาคการเกษตรและกลุ่มเกษตรกร(กพก)"=>"กองพัฒนาสหกรณ์ภาคการเกษตรและกลุ่มเกษตรกร(กพก)",
					"กองพัฒนาสหกรณ์ด้านการเงินและร้านค้า(กพง)"=>"กองพัฒนาสหกรณ์ด้านการเงินและร้านค้า(กพง)",
					"กองพัฒนาระบบสนับสนุนการสหกรณ์(กพน)"=>"กองพัฒนาระบบสนับสนุนการสหกรณ์(กพน)",
					"สำนักพัฒนาและถ่ายทอดเทคโนโลยีการสหกรณ์(สทส)"=>"สำนักพัฒนาและถ่ายทอดเทคโนโลยีการสหกรณ์(สทส)",
					"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่1(สสพ1)"=>"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่1(สสพ1)",
					"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่2(สสพ2)"=>"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่2(สสพ2)",
					"สำนักนายทะเบียนและกฎหมาย(สนม)"=>"สำนักนายทะเบียนและกฎหมาย(สนม)",
					"สถาบันพัฒนาเครื่องจักรกลและพื้นที่สหกรณ์(สคส)"=>"สถาบันพัฒนาเครื่องจักรกลและพื้นที่สหกรณ์(สคส)",
					"สถาบันพัฒนากรรมการและฝ่ายจัดการสหกรณ์(สกส)"=>"สถาบันพัฒนากรรมการและฝ่ายจัดการสหกรณ์(สกส)",
					"กองประสานงานโครงการพระราชดำริ(กคร)"=>"กองประสานงานโครงการพระราชดำริ(กคร)",
					"ผู้ตรวจราชการกรมส่งเสริมสหกรณ์(ผตร)"=>"ผู้ตรวจราชการกรมส่งเสริมสหกรณ์(ผตร)",
					"สำนักงานติดตามงานตามนโยบายของรมว.กษ.(กรมส่งเสริมสหกรณ์)(สตน)"=>"สำนักงานติดตามงานตามนโยบายของรมว.กษ.(กรมส่งเสริมสหกรณ์)(สตน)",
					"สำนักงานสหกรณ์จังหวัดนนทบุรี"=>"สำนักงานสหกรณ์จังหวัดนนทบุรี",
					"สำนักงานสหกรณ์จังหวัดปทุมธานี"=>"สำนักงานสหกรณ์จังหวัดปทุมธานี",
					"สำนักงานสหกรณ์จังหวัดพระนครศรีอยุธยา"=>"สำนักงานสหกรณ์จังหวัดพระนครศรีอยุธยา",
					"สำนักงานสหกรณ์จังหวัดสระบุรี"=>"สำนักงานสหกรณ์จังหวัดสระบุรี",
					"สำนักงานสหกรณ์จังหวัดชัยนาท"=>"สำนักงานสหกรณ์จังหวัดชัยนาท",
					"สำนักงานสหกรณ์จังหวัดลพบุรี"=>"สำนักงานสหกรณ์จังหวัดลพบุรี",
					"สำนักงานสหกรณ์จังหวัดสิงห์บุรี"=>"สำนักงานสหกรณ์จังหวัดสิงห์บุรี",
					"สำนักงานสหกรณ์จังหวัดอ่างทอง"=>"สำนักงานสหกรณ์จังหวัดอ่างทอง",
					"สำนักงานสหกรณ์จังหวัดฉะเชิงเทรา"=>"สำนักงานสหกรณ์จังหวัดฉะเชิงเทรา",
					"สำนักงานสหกรณ์จังหวัดปราจีนบุรี"=>"สำนักงานสหกรณ์จังหวัดปราจีนบุรี",
					"สำนักงานสหกรณ์จังหวัดสระแก้ว"=>"สำนักงานสหกรณ์จังหวัดสระแก้ว",
					"สำนักงานสหกรณ์จังหวัดนครนายก"=>"สำนักงานสหกรณ์จังหวัดนครนายก",
					"สำนักงานสหกรณ์จังหวัดสมุทรปราการ"=>"สำนักงานสหกรณ์จังหวัดสมุทรปราการ",
					"สำนักงานสหกรณ์จังหวัดกาญจนบุรี"=>"สำนักงานสหกรณ์จังหวัดกาญจนบุรี",
					"สำนักงานสหกรณ์จังหวัดนครปฐม"=>"สำนักงานสหกรณ์จังหวัดนครปฐม",
					"สำนักงานสหกรณ์จังหวัดราชบุรี"=>"สำนักงานสหกรณ์จังหวัดราชบุรี",
					"สำนักงานสหกรณ์จังหวัดสุพรรณบุรี"=>"สำนักงานสหกรณ์จังหวัดสุพรรณบุรี",
					"สำนักงานสหกรณ์จังหวัดประจวบคีรีขันธ์"=>"สำนักงานสหกรณ์จังหวัดประจวบคีรีขันธ์",
					"สำนักงานสหกรณ์จังหวัดเพชรบุรี"=>"สำนักงานสหกรณ์จังหวัดเพชรบุรี",
					"สำนักงานสหกรณ์จังหวัดสมุทรสาคร"=>"สำนักงานสหกรณ์จังหวัดสมุทรสาคร",
					"สำนักงานสหกรณ์จังหวัดสมุทรสงคราม"=>"สำนักงานสหกรณ์จังหวัดสมุทรสงคราม",
					"สำนักงานสหกรณ์จังหวัดชุมพร"=>"สำนักงานสหกรณ์จังหวัดชุมพร",
					"สำนักงานสหกรณ์จังหวัดสุราษฎร์ธานี"=>"สำนักงานสหกรณ์จังหวัดสุราษฎร์ธานี",
					"สำนักงานสหกรณ์จังหวัดนครศรีธรรมราช"=>"สำนักงานสหกรณ์จังหวัดนครศรีธรรมราช",
					"สำนักงานสหกรณ์จังหวัดพัทลุง"=>"สำนักงานสหกรณ์จังหวัดพัทลุง",
					"สำนักงานสหกรณ์จังหวัดระนอง"=>"สำนักงานสหกรณ์จังหวัดระนอง",
					"สำนักงานสหกรณ์จังหวัดพังงา"=>"สำนักงานสหกรณ์จังหวัดพังงา",
					"สำนักงานสหกรณ์จังหวัดภูเก็ต"=>"สำนักงานสหกรณ์จังหวัดภูเก็ต",
					"สำนักงานสหกรณ์จังหวัดกระบี่"=>"สำนักงานสหกรณ์จังหวัดกระบี่",
					"สำนักงานสหกรณ์จังหวัดตรัง"=>"สำนักงานสหกรณ์จังหวัดตรัง",
					"สำนักงานสหกรณ์จังหวัดสงขลา"=>"สำนักงานสหกรณ์จังหวัดสงขลา",
					"สำนักงานสหกรณ์จังหวัดสตูล"=>"สำนักงานสหกรณ์จังหวัดสตูล",
					"สำนักงานสหกรณ์จังหวัดปัตตานี"=>"สำนักงานสหกรณ์จังหวัดปัตตานี",
					"สำนักงานสหกรณ์จังหวัดยะลา"=>"สำนักงานสหกรณ์จังหวัดยะลา",
					"สำนักงานสหกรณ์จังหวัดนราธิวาส"=>"สำนักงานสหกรณ์จังหวัดนราธิวาส",
					"สำนักงานสหกรณ์จังหวัดจันทบุรี"=>"สำนักงานสหกรณ์จังหวัดจันทบุรี",
					"สำนักงานสหกรณ์จังหวัดชลบุรี"=>"สำนักงานสหกรณ์จังหวัดชลบุรี",
					"สำนักงานสหกรณ์จังหวัดระยอง"=>"สำนักงานสหกรณ์จังหวัดระยอง",
					"สำนักงานสหกรณ์จังหวัดตราด"=>"สำนักงานสหกรณ์จังหวัดตราด",
					"สำนักงานสหกรณ์จังหวัดหนองคาย"=>"สำนักงานสหกรณ์จังหวัดหนองคาย",
					"สำนักงานสหกรณ์จังหวัดเลย"=>"สำนักงานสหกรณ์จังหวัดเลย",
					"สำนักงานสหกรณ์จังหวัดอุดรธานี"=>"สำนักงานสหกรณ์จังหวัดอุดรธานี",
					"สำนักงานสหกรณ์จังหวัดหนองบัวลำภู"=>"สำนักงานสหกรณ์จังหวัดหนองบัวลำภู",
					"สำนักงานสหกรณ์จังหวัดบึงกาฬ"=>"สำนักงานสหกรณ์จังหวัดบึงกาฬ",
					"สำนักงานสหกรณ์จังหวัดนครพนม"=>"สำนักงานสหกรณ์จังหวัดนครพนม",
					"สำนักงานสหกรณ์จังหวัดมุกดาหาร"=>"สำนักงานสหกรณ์จังหวัดมุกดาหาร",
					"สำนักงานสหกรณ์จังหวัดสกลนคร"=>"สำนักงานสหกรณ์จังหวัดสกลนคร",
					"สำนักงานสหกรณ์จังหวัดร้อยเอ็ด"=>"สำนักงานสหกรณ์จังหวัดร้อยเอ็ด",
					"สำนักงานสหกรณ์จังหวัดขอนแก่น"=>"สำนักงานสหกรณ์จังหวัดขอนแก่น",
					"สำนักงานสหกรณ์จังหวัดมหาสารคาม"=>"สำนักงานสหกรณ์จังหวัดมหาสารคาม",
					"สำนักงานสหกรณ์จังหวัดกาฬสินธุ์"=>"สำนักงานสหกรณ์จังหวัดกาฬสินธุ์",
					"สำนักงานสหกรณ์จังหวัดอำนาจเจริญ"=>"สำนักงานสหกรณ์จังหวัดอำนาจเจริญ",
					"สำนักงานสหกรณ์จังหวัดศรีสะเกษ"=>"สำนักงานสหกรณ์จังหวัดศรีสะเกษ",
					"สำนักงานสหกรณ์จังหวัดยโสธร"=>"สำนักงานสหกรณ์จังหวัดยโสธร",
					"สำนักงานสหกรณ์จังหวัดอุบลราชธานี"=>"สำนักงานสหกรณ์จังหวัดอุบลราชธานี",
					"สำนักงานสหกรณ์จังหวัดสุรินทร์"=>"สำนักงานสหกรณ์จังหวัดสุรินทร์",
					"สำนักงานสหกรณ์จังหวัดนครราชสีมา"=>"สำนักงานสหกรณ์จังหวัดนครราชสีมา",
					"สำนักงานสหกรณ์จังหวัดบุรีรัมย์"=>"สำนักงานสหกรณ์จังหวัดบุรีรัมย์",
					"สำนักงานสหกรณ์จังหวัดชัยภูมิ"=>"สำนักงานสหกรณ์จังหวัดชัยภูมิ",
					"สำนักงานสหกรณ์จังหวัดเชียงใหม่"=>"สำนักงานสหกรณ์จังหวัดเชียงใหม่",
					"สำนักงานสหกรณ์จังหวัดแม่ฮ่องสอน"=>"สำนักงานสหกรณ์จังหวัดแม่ฮ่องสอน",
					"สำนักงานสหกรณ์จังหวัดลำปาง"=>"สำนักงานสหกรณ์จังหวัดลำปาง",
					"สำนักงานสหกรณ์จังหวัดลำพูน"=>"สำนักงานสหกรณ์จังหวัดลำพูน",
					"สำนักงานสหกรณ์จังหวัดน่าน"=>"สำนักงานสหกรณ์จังหวัดน่าน",
					"สำนักงานสหกรณ์จังหวัดพะเยา"=>"สำนักงานสหกรณ์จังหวัดพะเยา",
					"สำนักงานสหกรณ์จังหวัดเชียงราย"=>"สำนักงานสหกรณ์จังหวัดเชียงราย",
					"สำนักงานสหกรณ์จังหวัดแพร่"=>"สำนักงานสหกรณ์จังหวัดแพร่",
					"สำนักงานสหกรณ์จังหวัดตาก"=>"สำนักงานสหกรณ์จังหวัดตาก",
					"สำนักงานสหกรณ์จังหวัดพิษณุโลก"=>"สำนักงานสหกรณ์จังหวัดพิษณุโลก",
					"สำนักงานสหกรณ์จังหวัดสุโขทัย"=>"สำนักงานสหกรณ์จังหวัดสุโขทัย",
					"สำนักงานสหกรณ์จังหวัดเพชรบูรณ์"=>"สำนักงานสหกรณ์จังหวัดเพชรบูรณ์",
					"สำนักงานสหกรณ์จังหวัดอุตรดิตถ์"=>"สำนักงานสหกรณ์จังหวัดอุตรดิตถ์",
					"สำนักงานสหกรณ์จังหวัดกำแพงเพชร"=>"สำนักงานสหกรณ์จังหวัดกำแพงเพชร",
					"สำนักงานสหกรณ์จังหวัดพิจิตร"=>"สำนักงานสหกรณ์จังหวัดพิจิตร",
					"สำนักงานสหกรณ์จังหวัดนครสวรรค์"=>"สำนักงานสหกรณ์จังหวัดนครสวรรค์",
					"สำนักงานสหกรณ์จังหวัดอุทัยธานี"=>"สำนักงานสหกรณ์จังหวัดอุทัยธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 1 จังหวัดปทุมธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 1 จังหวัดปทุมธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 2 จังหวัดปทุมธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 2 จังหวัดปทุมธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 3 จังหวัดชลบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 3 จังหวัดชลบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 4 จังหวัดนครนายก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 4 จังหวัดนครนายก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 5 จังหวัดนครราชสีมา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 5 จังหวัดนครราชสีมา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 6 จังหวัดนครราชสีมา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 6 จังหวัดนครราชสีมา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 7 จังหวัดขอนแก่น"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 7 จังหวัดขอนแก่น",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 8 จังหวัดขอนแก่น"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 8 จังหวัดขอนแก่น",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 9 จังหวัดเชียงใหม่"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 9 จังหวัดเชียงใหม่",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 10 จังหวัดลำปาง"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 10 จังหวัดลำปาง",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 11 จังหวัดพิษณุโลก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 11 จังหวัดพิษณุโลก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 12 จังหวัดพิษณุโลก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่12 จังหวัดพิษณุโลก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 13 จังหวัดชัยนาท"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 13 จังหวัดชัยนาท",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 14 จังหวัดชัยนาท"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 14 จังหวัดชัยนาท",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 15 จังหวัดเพชรบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 15 จังหวัดเพชรบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 16 จังหวัดเพชรบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 16 จังหวัดเพชรบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 17 จังหวัดสงขลา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 17 จังหวัดสงขลา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 18 จังหวัดสงขลา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 18 จังหวัดสงขลา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 19 จังหวัดสุราษฎร์ธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที 19 จังหวัดสุราษฎร์ธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 20 จังหวัดสุราษฎร์ธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 20 จังหวัดสุราษฎร์ธานี",
					"ศูนย์สาธิตสหกรณ์โครงการหุบกะพง"=>"ศูนย์สาธิตสหกรณ์โครงการหุบกะพง"
			
			
			
			);

			$crud->field_type('ORG_ID','dropdown',
					$org_name);
			$crud->field_type('province','dropdown',
					$provinces);
			$crud->field_type('AGENCY','dropdown',
					$agency);
			$crud->field_type('last_login','date');
			$crud->field_type('created_at','hidden');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_by','hidden');
			$crud->field_type('org_name','hidden');
				$crud->field_type('province_name','hidden');
				
			$crud->field_type('passwd','password');
			//$crud->field_type('banned','hidden');
			$crud->field_type('passwd_recovery_code','hidden');
			$crud->field_type('passwd_recovery_date','hidden');
			$crud->field_type('passwd_modified_at','hidden');
			
			//$crud->callback_before_insert(array($this,'validate_charater_password'));
			//$crud->callback_before_insert(array($this,'encrypt_password_callback'));
			//$crud->callback_before_insert(array($this,'log_activity_before_insert'));
				
			//$crud->callback_before_update(array($this,'validate_charater_password'));
			//$crud->callback_before_update(array($this,'encrypt_password_callback'));
			//$crud->callback_before_update(array($this,'log_activity_before_update'));
			
			
			$crud->callback_before_insert(array($this,'validate_charater_password'));
			$crud->callback_before_insert(array($this,'encrypt_password_callback'));
			$crud->callback_before_update(array($this,'encrypt_password_callback'));
			$crud->callback_edit_field('passwd',array($this,'decrypt_password_callback'));
			// }
			// $crud->set_rules('passwd','รหัสผ่าน','required|callback_validate_charater_password_callback');
			
			if( $crud->getState()=='edit'  || $crud->getState()=='update' || $crud->getState()=='update_validation')
			{
				// $crud->callback_column('ORG_ID', array($this, 'callback_org_name'));
				// $crud->callback_column('province', array($this, 'callback_province'));
				$crud->set_rules('name', 'Name', 'required');
				$crud->field_type('username','readonly');
				$crud->field_type('org_name','hidden');
				$crud->field_type('province_name','hidden');
				// $crud->field_type('org_name','readonly');
				$crud->field_type('email','readonly');
				// $crud->callback_before_insert(array($this,'encrypt_password_callback'));
				// $crud->callback_before_update(array($this,'encrypt_password_callback'));
				// $crud->callback_edit_field('passwd',array($this,'decrypt_password_callback'));
			}
			else if ( $crud->getState()=='export' )
			{
				$crud->callback_column('username', array($this,'change_value_number'));
			}
			else
			{
				$crud->set_rules('username','ชื่อบัญชีผู้ใช้','required|alpha_numeric_spaces|is_unique[users.username]');
				$crud->set_rules('email', 'Email', 'valid_email|is_unique[users.email]');
				$crud->set_rules('name', 'Name', 'required');
			}
			
			//$crud->set_rules('username','ชื่อบัญชีผู้ใช้','required');
			//$crud->set_rules('passwd','รหัสผ่าน','required');
			
			$output = $crud->render();
		
			$this->_admin_output($output);
		}
		else{
			redirect('/');
		}
	}

	function validate_username_uppercase_callback($username){
	    if (strtoupper($username)===$username)
	    {
	        return true;
	    }
	    else
	    {
	        $this->form_validation->set_message('validate_username_uppercase_callback','username ต้องเป็น A-Z');
	        return false;
	    }
	}
	public function validate_charater_password($post_array, $primary_key = null)
	{
// 		$regex = '(?=(?:.*[A-Z].*){' . config_item('min_uppercase_chars_for_password') . ',})';
// 		if( preg_match( '/^' . $regex . '.*$/', $post_array['passwd'] ) ){
// 			return $post_array;
// 		}else{
// // 			$this->from_validation->set_message('Pass fail');
// 			return false;
// 		}
		return $post_array;
	}
	

	
	function clear_announcement_cache()
	{
		$this->cache->delete('announcement');
		$this->cache->delete('current_announcement_id');
	}
	
	public function get_user_id($user_id)
	{
		$this->load->model('user_model');
		$user_id = $this->user_model->getId();
	
		return '<input type="text" name="user_id" value="'.$user_id.'" readonly/>';
	}

	function callback_org_name($value)
	{
		$p = getOrgById($value);
		// echo print_r($p);die();
		return $p['org_name'];
	}

	function callback_province($value)
	{
		$p = getProvinceByID($value);
		// echo print_r($p);die();
		return $p->PROVINCE_NAME;
	}

	function change_value_number($value)
	{
		
		return "'".$value;
	}
	

	function encrypt_password_callback($post_array, $primary_key = null)
	{
		if (isset($post_array['passwd']) && !empty($post_array['passwd']) && $post_array['passwd']!="nochange")
		{
			//die($post_array['passwd']);
			$post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
		}
		else
			unset($post_array['passwd']);
		
		if(empty($post_array['banned'])){
			$post_array['banned'] = 0;
		}
		
		if (!isset($post_array['user_id']))
			$post_array = $this->log_activity_before_insert($post_array, $primary_key);
		else 
			$post_array = $this->log_activity_before_update($post_array, $primary_key);
		
		return $post_array;
	}
	
	function decrypt_password_callback($value)
	{
		return "<input type='password' id='field-passwd' class='form-control' name='passwd' value='nochange' class='form-control' />";
	}
	
	function validate_charater_password_callback($password)
	{
	    $this->load->helper('user');
	    $count_date_modify = get_count_last_date_modify_password();
	    $count_date_last_modify = get_last_change_password($this->session->userdata('auth_user_id'));
	    if("nochange" == $password && $count_date_last_modify > $count_date_modify){
	        $this->form_validation->set_message('validate_charater_password_callback','กรุณาเปลี่ยนรหัสผ่าน');
	        return false;
	    }
	    else if("nochange" == $password ){
	        return true;
	    }
	    // else if (preg_match('/[A-Z]/',$password))
	    // {
	    //     return true;
	    // }
	    // else
	    // {
	    //     $this->form_validation->set_message('validate_charater_password_callback','รหัสผ่านจำเป็นต้องมี A-Z อย่างน้อย 1 ตัวอักษร');
	    //     return false;
	    // }
	}
	
	public function announcements_management()
	{
		if($this->session->userdata('auth_role')=="admin")
		{
			$this->is_logged_in();
	
			$crud = new grocery_CRUD();
	
			$crud->set_theme('bootstrap');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
	
			$crud->set_table('announcements');
			$crud->columns('message', 'created_at', 'modified_at', 'created_by', 'modified_by');
			$crud->edit_fields('message', 'modified_at', 'modified_by');
			$crud->add_fields('message', 'created_at', 'modified_at', 'created_by', 'modified_by');
			$crud->fields('message', 'created_at', 'modified_at', 'created_by', 'modified_by');
				
			$crud->set_primary_key('announcement_id');
	
			$crud->display_as('message','ข้อความประกาศ')
			->display_as('announcement_id','ประกาศเลขที่')
			;
			$crud->set_subject('ประกาศ');
	
			$crud->field_type('created_at','hidden');
			$crud->field_type('message','string');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_by','hidden');
					
			$crud->set_rules('message','รายละเอียดประกาศ','trim|required|htmlspecialchars');
			
			$crud->callback_before_insert(array($this, 'log_activity_before_insert'));
			$crud->callback_before_update(array($this, 'log_activity_before_update'));
			$crud->callback_after_insert(array($this,'clear_announcement_cache'));
			$crud->callback_after_update(array($this,'clear_announcement_cache'));
			$crud->callback_after_delete(array($this,'clear_announcement_cache'));
	
			$crud->required_fields('message');
				
			$output = $crud->render();
	
			$this->_admin_output($output);
		}
		else 
		{
			redirect('/');
		}
	}
	
	
	

	public function group_management(){

		if ($this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal")
		{
			//$this->db->where('group_id', $this->group_id);
			//$this->db->delete($this->db->dbprefix('user_group'));
			
			
			
			$this->is_logged_in();
			$crud = new Grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->unset_jquery();
			$crud->display_as('name','name')
			->display_as('created_at','created at');
// 			->display_as('create_date','create date')
// 			->display_as('modify_date','modification date')
// 			->display_as('group_status','status');
// 			$crud->set_subject('Group list');

			// clean up related table
			if ($crud->getState()=='delete')
			{
				$this->db->where('group_id', $crud->getStateInfo()->primary_key);
				$this->db->delete($this->db->dbprefix('user_group'));				
			}				
			
			$table = $this->db->dbprefix('groups');
			$crud->where('deleted',0);
			$crud->set_table($this->db->dbprefix('groups'));
			$crud->set_primary_key('group_id');
			
			
			$crud->columns('name','created_at','modified_at','created_by', 'modified_by');
			$crud->edit_fields('name', 'users','modified_at','modified_by');
			$crud->add_fields('name','users','created_at','modified_at','created_by', 'modified_by');
			
			$crud->field_type('created_at','hidden');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_by','hidden');
			$crud->field_type('deleted','hidden');
				
			// to have group id created
 			$crud->unset_add_fields('group_id');
 			$crud->unset_edit_fields('group_id');

 			// to have group id created
 			//$crud->add_action('สมาชิก', '', '','fa fa-group',array($this,'_manage_members'));
			
 			$crud->set_subject('กลุ่มผู้ใช้');
 			
 			$crud->callback_after_delete(array($this,'clean_user_group_callback'));
 			$crud->callback_before_insert(array($this,'log_activity_before_insert'));
 			$crud->callback_before_update(array($this,'log_activity_before_update'));
 			
 			$crud->set_relation_n_n('users', 'user_group', 'users', 'group_id', 'user_id', 'username','priority');			
 			
 			// iframe url
 			$crud->iframe_url= null;
 			
			$output = $crud->render();
			$this->_admin_output($output);
		}
		else
		{
			redirect('/');
		}
	}
	

	public function log_activity_before_update($post_array,$primary_key)
	{
		$currenttime = date('Y-m-d H:i:s',time());
		$post_array['modified_at'] = "TO_DATE('$currenttime','yyyy-mm-dd hh24:mi:ss')";
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		
		return $post_array;
	}
	
	public function log_activity_before_insert($post_array,$primary_key)
	{
		if (isset($post_array['deleted']))
			$post_array['deleted'] = 0;
		
		$time = time();
		$currenttimestr = date('Y-m-d H:i:s',$time);
		$post_array['modified_at'] = "TO_DATE('$currenttimestr','yyyy-mm-dd hh24:mi:ss')";
	
		//$time = strtotime($post_array['created_at']);
		//$currenttimestr = date('Y-m-d H:i:s',$time);
		$post_array['created_at'] = "TO_DATE('$currenttimestr','yyyy-mm-dd hh24:mi:ss')";
	
		$post_array['modified_by'] = $this->session->userdata('auth_user_id');
		$post_array['created_by'] = $this->session->userdata('auth_user_id');
		
		return $post_array;
	}


	function getListOrg($data="")
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$province_id = $this->input->get('province');

		$allorg = getOrgIdByProvinceId($province_id);
		// echo print_r($allorg);die();

		$temp = array();
		$temp['items'] = $allorg;
		echo json_encode($temp);
	}		
	
	
	

	
	function _manage_members($primary_key , $row)
	{
		return site_url("admin/group_management/read/".$row->group_id);
	}	
	
	public function user_group_management($group_id){
		
		if ($this->require_role('admin'))
		{
			$this->is_logged_in();
			$crud = new Grocery_CRUD();
			$crud->set_theme('bootstrap_ajax');
			$crud->unset_jquery();
			$crud->display_as('user_id','Username');
			
// 			$group_id_in_url = $_SERVER['PHP_SELF'];
// 			$group_id_in_url_array = explode('/', $group_id_in_url);
// 			$size_array_url = sizeof($group_id_in_url_array);
// 			$group_id = $group_id_in_url_array[4];
			
			$crud->where('group_id',$group_id);
			$crud->where('deleted',0);
			$crud->set_table($this->db->dbprefix('user_group'));
			$crud->set_primary_key('user_group_id');
			if ($crud->getState()!='ajax_list')
			{
				$crud->set_relation('user_id',  $this->db->dbprefix('users') ,'{username}');
			}
				
			$crud->columns('user_id','created_at','modified_at','created_by', 'modified_by');
			$crud->edit_fields('user_group_id','group_id','user_id','deleted', 'modified_at','modified_by');
			$crud->add_fields('group_id','user_id','deleted', 'modified_at','modified_by');
			$crud->fields('group_id','user_id','deleted');
			
			$crud->field_type('deleted','hidden');
			$crud->field_type('group_id','hidden');
			$crud->field_type('user_group_id','hidden');
			$crud->field_type('created_at','hidden');
			$crud->field_type('created_by','hidden');
			$crud->field_type('modified_at','hidden');
			$crud->field_type('modified_by','hidden');
						
			// set group id
			$this->group_id = $group_id;
			$crud->callback_before_insert(array($this,'set_group_id_callback'));
			$crud->callback_before_update(array($this,'set_group_id_callback'));
			$crud->callback_after_insert(array($this,'log_activity_after_insert'));
			$crud->callback_after_update(array($this,'log_activity_after_update'));
			
			// to have group id created
			$crud->unset_add_fields('user_group_id');
			$crud->unset_edit_fields('user_group_id');
			
			//unset action
			$crud->unset_edit();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_export();
			
			$crud->set_rules('user_id','User','trim|required|callback_check_user_id');

			$crud->set_subject('สมาชิก');
			
			$output = $crud->render();
				
			$this->_admin_output_ajax($output);
		}
		else
		{
			redirect('/');
		}
	}


	public function search_coop_name(){
		if(isset($_GET['term'])){
			$term = $_GET['term'];
			$array = array();
			$this->db->select('COOP_ID,COOP_NAME_TH');
			$this->db->from('COOP_INFO'); //		 $this->db->from($this->db->dbprefix('coop_info'));
			//$this->db->where('user_id', $str);
			//$this->db->where('COOP_NAME_TH', $this->group_id);
			$this->db->like('COOP_NAME_TH', $term);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$array[] = array(
						'id' => $row->COOP_ID,
						'label' => $row->COOP_NAME_TH,
						'value' =>$row->COOP_NAME_TH
					);
				}
			}

			echo json_encode ($array);
		}
	}
	
	function check_user_id($str)
	{
		if (empty($str) || $str==0)
		{
			$this->form_validation->set_message('check_user_id',"กรุณาเลือกผู้ใช้");
				
			return false;			
		}
		
		$this->db->select('group_id');
		$this->db->from($this->db->dbprefix('user_group'));
		$this->db->where('user_id', $str);
		$this->db->where('group_id', $this->group_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$this->form_validation->set_message('check_user_id',"ผู้ใช้เป็นสมาชิกของกลุ่มอยู่แล้ว");
			
			return false;
		}
		return true;		
	}

	
	function set_group_id_callback($post_array, $primary_key = null)
	{
		$post_array['group_id'] = $this->group_id;
		$post_array['deleted'] = 0;
		return $post_array;
	}	

	

	public function _valid_images($files_to_upload, $field_info)
	{
		if ($files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/png'
				&& $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpeg'
				&& $files_to_upload[$field_info->encrypted_field_name]['type'] != 'image/jpg'
				)
		{
			return 'รองรับแค่ PNG และ JPG ขนาด 640x480 เท่านั้น';
		}
		
		$path = $files_to_upload[$field_info->encrypted_field_name]['tmp_name'];
		list($width, $height) = getimagesize($path);
		//$xx = print_r($files_to_upload[$field_info->encrypted_field_name]['tmp_name'],true);
		//return " xx $width $height xx";
				
		//if ($width!=640 && $height!=480)
		//{
		//	return 'รองรับแค่ขนาด 640x480 เท่านั้น';
		//}
		return true;
	}
	
	function _callback_customer_url($value, $row)
	{
		return "<a href='".site_url('admin/user_managements/read/'.$row->id)."'>$value</a>";
	}
	public function test_act()
	{
		echo "test";

	}

	public function view_survey(){
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);

			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']): "";

			if (!empty($coop_member_id))
			{
				$member = getSurveyRecordByMemberIDSelectedYear($coop_member_id);
				$citizen_id = $member['citizen_id'];
			}

			if (strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			$year = getSelectedSurveyYear();
			if (!canView($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);

				echo "ไม่มีสิทธิเข้าถึง";
			}


			$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
			if (!empty($existing_member))
			{
				$output = array(
					'citizen_id' => $citizen_id,
					'year' => $year,
					'survey' => $existing_member
				);

				echo $this->load->view('survey_view', $output, TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			$output = array(
				'message'=>'ไม่พบแบบสอบถามตามหมายเลขบัตรประชาชน');

			echo $this->load->view('survey_error', $output, TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);

			die();
		}
		else
		{
			redirect('/', 'refresh');
		}
	}

	public function add_survey()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{

			$output = array();

			if (!canAdd())
			{
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเพิ่มแบบสำรวจ'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			$step = isset($_GET['step'])? $_GET['step']: "";
			if ($step=="" || $step=="0"){

				$citizen_id = isset($_GET['citizen_id'])?trim($_GET['citizen_id']): null;
				$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']):null;
				if ($step=="0" && strlen($citizen_id)!=13)
				{
					$this->session->set_userdata('error_msg',"กรุณากรอกหมายเลขบัตรประชาชนให้ถูกต้อง รูปแบบที่รองรับคือตัวเลขทั้งหมด โดยไม่มีตัวอักษรหรือช่องว่าง");
				}
				else if ($step=="0" && strlen($citizen_id)==13)
				{
					$url = site_url("admin/add_survey_1")."/$citizen_id/?coop_member_id=$coop_member_id&step=1";
					header( "location: ".$url);
					exit(0);
				}

				$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
				if (!empty($existing_member))
				{
					$url = site_url("admin/edit_survey_1")."/$citizen_id/?coop_member_id=$coop_member_id&step=1";
					header( "location: ".$url);
					exit(0);
				}

				echo $this->load->view('auth/page_header', '', TRUE);

				echo $this->load->view('survey_add_searchbox', $output, true);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			echo $this->load->view('auth/page_header', '', TRUE);


			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	public function do_survey_1($citizen_id=0)
	{  //if(!isset($citizen_id)){ if(isset($_GET['citizen_id'])){ $citizen_id=$_GET['citizen_id']; }}
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$year = getSelectedSurveyYear();
			if (!canView($citizen_id, $year))
			{
				echo $this->load->view('auth/page_header', '', TRUE);
				
				echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิดูแบบสำรวจ หรือข้อมูลสมาชิกสหกรณ์นอกพื้นที่'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			if (!canAdd())
			{
				echo $this->load->view('auth/page_header', '', TRUE);

				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเพิ่มแบบสำรวจ'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}


			if(strlen($citizen_id)!=13)
			{   //echo 2; exit;
				redirect('admin/add_survey', 'refresh');
			}
			
			// check access
			//checkSuspiciousActivityMahadthai($citizen_id, "Do Edit Survey", getSelectedSurveyYear());
				
			
			$output = array();

			$step = isset($_GET['step'])? $_GET['step']: "";
			$coop_id = isset($_GET['coop'])? $_GET['coop']: "";
			$coop = null;

			if (!empty($coop_id))
			{
				if (!canViewSurveyByCoop($coop_id))
				{
					echo $this->load->view('auth/page_header', '', TRUE);
					
					echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิดูข้อมูลของสมาชิกสหกรณ์ต่างพื้นที่'), TRUE);
					
					echo $this->load->view('auth/page_footer', '', TRUE);	
					
					die();
				}
			}			
			
			if (!empty($coop_id) && !is_numeric($coop_id))
			{
				echo $this->load->view('auth/page_header', '', TRUE);

				echo $this->load->view('survey_error', array('message'=>'รหัสสหกรณ์ไม่มีอยู่'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			if (!empty($coop_id))
			{
				$coop = getCoopByID($coop_id);
				if (empty($coop_id))
				{
					echo $this->load->view('auth/page_header', '', TRUE);

					echo $this->load->view('survey_error', array('message'=>'รหัสสหกรณ์ไม่มีอยู่'), TRUE);

					echo $this->load->view('auth/page_footer', '', TRUE);

					die();
				}
			}



			if ($step=="1")
			{   //echo 3; exit;
				//	echo $this->load->view('auth/page_header', '', TRUE);
				$province_name_user_add_servey = getUser($this->session->userdata('auth_user_id'));
				
				$province_name = getProvinceByName($province_name_user_add_servey['province']);
				
				$this->load->model('grocery_crud_model');
				$crud = new grocery_CRUD();
				$getdata = $this->grocery_crud_model->gettheSurvey($citizen_id, $coop_id);

				//print_r($getdata[0]['citizen_id']);exit;
				$list_data_citizen = array();
				if(isset($getdata[0])) {
					$list_data_citizen = $getdata[0];
				}
				//$list_data_citizen['PROVINCE_CODE'] = $province_name->PROVINCE_ID;
				
				$data_mahadthai = array();
				$data_farmer_one = array();
				// load data from MAHADTHAI and check if information is there
				$data_mahadthai = getMahadthaiByCitizenID($citizen_id);
				
				if(!empty($coop_id) && is_array($data_mahadthai) && sizeof($data_mahadthai)>0)
					$data_mahadthai = getMahadthaiByCitizenIDAndCoopID($citizen_id, $coop_id);

				// Load data from FarmerOne and check if information is there
				/////$data_farmer_one = getFarmerOneByCitizenID($citizen_id);
				$data_getAllprovinces = getAllProvinces();
				// if there is info from $mahadthai_table or $farmer_one_table, autofill the form
				$default_data = array(

				);

				// save to survey db
				// citizen_already_in_f1 - ถ้ามีข้อมูลใน FarmerOne ใส่ค่า Column เป็น TRUE
				// User ไม่ต้องกรอกข้อมูล

				$already_have_data_in_farmer1 = !empty($data_farmer_one)? true: false;
				
// 				echo "<pre>";print_r($data_mahadthai);exit();
				
				if(!empty($data_mahadthai[0]['PROVICE_NAME']) && !empty($list_data_citizen['PROVINCE_ID']))
					$data_mahadthai[0]['PROVICE_NAME'] = !empty(getProvinceByID($list_data_citizen['PROVINCE_ID']))?getProvinceByID($list_data_citizen['PROVINCE_ID'])->PROVINCE_NAME:$data_mahadthai[0]['PROVICE_NAME'];
				
				if(empty($data_mahadthai[0]['PROVICE_NAME']) && !empty($list_data_citizen['PROVINCE_ID']))
					$data_mahadthai[0]['PROVICE_NAME'] = !empty(getProvinceByID($list_data_citizen['PROVINCE_ID']))?getProvinceByID($list_data_citizen['PROVINCE_ID'])->PROVINCE_NAME:$data_mahadthai[0]['PROVICE_NAME'];

				if(!empty($mahadthai[0]['OU_D_DISTRICT']) &&  !empty($list_data_citizen['DISTRICT_ID']))
				{
					$amphur = getAmphurByID($list_data_citizen['DISTRICT_ID']);		
					$mahadthai[0]['OU_D_DISTRICT'] =$amphur[0]['amphor_name'];
				}
				if(!empty($data_mahadthai[0]['OU_D_SUBD']) && !empty($list_data_citizen['SUB_DISTRICT_ID']))
				{
					$tambol = getTambolByID($list_data_citizen['SUB_DISTRICT_ID']);
					
					$data_mahadthai[0]['OU_D_SUBD'] =  !empty($tambol->TAMBON_NAME)?$tambol->TAMBON_NAME:$data_mahadthai[0]['OU_D_SUBD'];
				}
				
				
						
// 				echo "<pre>";print_r($data_mahadthai);exit();

				echo $this->load->view('auth/page_header', '', TRUE);

				$output = array(
					'default_data' => $default_data,
					'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
					'citizen_id' => $citizen_id,
					'mahadthai' => $data_mahadthai,
					'coop' => $coop,
					'data_farmer_one' => $data_farmer_one,
					'data_getAllprovinces'=>$data_getAllprovinces,
					'user_survey_data'=>$list_data_citizen
				);

				$mode = !empty($this->input->get('mode'))?$this->input->get('mode'):null;

				if(!empty($mode) && $mode=='view')
				{
					echo $this->load->view('survey_add', $output, true);
					
				}else{
					echo $this->load->view('survey_add', $output, true);
				}
				


				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			echo $this->load->view('auth/page_header', '', TRUE);


			echo $this->load->view('auth/page_footer', '', TRUE);

		}
		else
		{
			redirect('/', 'refresh');
		}
	}

	public function add_survey_1($citizen_id=0)
	{  //if(!isset($citizen_id)){ if(isset($_GET['citizen_id'])){ $citizen_id=$_GET['citizen_id']; }}
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			if (!canAdd())
			{
				echo $this->load->view('auth/page_header', '', TRUE);
				
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเพิ่มแบบสำรวจ'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}
			
			

			if(strlen($citizen_id)!=13)
			{   //echo 2; exit;
				redirect('admin/add_survey', 'refresh');
			}

			// check access
// 			checkSuspiciousActivityMahadthai($citizen_id, "Add Survey 1", getSelectedSurveyYear());
							
			$output = array();

			$step = isset($_GET['step'])? $_GET['step']: "";
			$coop_id = isset($_GET['coop'])? $_GET['coop']: "";
			$coop = null;
			
			if (!empty($coop_id) && !is_numeric($coop_id))
			{
				echo $this->load->view('auth/page_header', '', TRUE);
				
				echo $this->load->view('survey_error', array('message'=>'รหัสสหกรณ์ไม่มีอยู่'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();				
			}
	
			if (!empty($coop_id))
			{
				$coop = getCoopByID($coop_id);
				if (empty($coop_id))
				{
					echo $this->load->view('auth/page_header', '', TRUE);
					
					echo $this->load->view('survey_error', array('message'=>'รหัสสหกรณ์ไม่มีอยู่'), TRUE);
					
					echo $this->load->view('auth/page_footer', '', TRUE);
					
					die();					
				}
				
				if (!canViewSurveyByCoop($coop_id))
				{
					echo $this->load->view('auth/page_header', '', TRUE);
					
					echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเข้าถึงข้อมูลสหกรณ์  '.$coop['COOP_NAME_TH'].', '.$coop['PROVINCE_NAME']), TRUE);
					
					echo $this->load->view('auth/page_footer', '', TRUE);
					
					die();
				}
				
				
			}
			
			

			if ($step=="1")
			{   //echo 3; exit;
			//	echo $this->load->view('auth/page_header', '', TRUE);
				$data_mahadthai = array();
				$data_farmer_one = array();
				// load data from MAHADTHAI and check if information is there
				$data_mahadthai = getMahadthaiByCitizenID($citizen_id);

				// Load data from FarmerOne and check if information is there
				/////$data_farmer_one = getFarmerOneByCitizenID($citizen_id);
                $data_getAllprovinces = getAllProvinces();
				// if there is info from $mahadthai_table or $farmer_one_table, autofill the form
				$default_data = array(

				);
				
				
				// save to survey db
				// citizen_already_in_f1 - ถ้ามีข้อมูลใน FarmerOne ใส่ค่า Column เป็น TRUE
				// User ไม่ต้องกรอกข้อมูล

				$already_have_data_in_farmer1 = !empty($data_farmer_one)? true: false;

				echo $this->load->view('auth/page_header', '', TRUE);
				
				$output = array(
					'default_data' => $default_data,
					'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
					'citizen_id' => $citizen_id,
					'mahadthai' => $data_mahadthai,
					'coop' => $coop,
					'data_farmer_one' => $data_farmer_one,
					'data_getAllprovinces'=>$data_getAllprovinces
				);

				echo $this->load->view('survey_add', $output, true);


				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			echo $this->load->view('auth/page_header', '', TRUE);


			echo $this->load->view('auth/page_footer', '', TRUE);

		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	
	public function add_survey_1_old($citizen_id)
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			if (!canAdd())
			{
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเพิ่มแบบสำรวจ'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			if(strlen($citizen_id)!=13)
			{ //echo 2; exit;
				//redirect('admin/add_survey', 'refresh');
			}

			$output = array();

			$step = isset($_GET['step'])? $_GET['step']: "";

			if ($step=="1")
			{   //echo 3; exit;
				//	echo $this->load->view('auth/page_header', '', TRUE);

				// load data from MAHADTHAI and check if information is there
				////$data_mahadthai = getMahadthaiByCitizenID($citizen_id);
				$data_mahadthai = array();
				// Load data from FarmerOne and check if information is there
				$data_farmer_one = getFarmerOneByCitizenID($citizen_id);
				$data_getAllprovinces = getAllProvinces();
				// if there is info from $mahadthai_table or $farmer_one_table, autofill the form
				$default_data = array(

				);

				// save to survey db
				// citizen_already_in_f1 - ถ้ามีข้อมูลใน FarmerOne ใส่ค่า Column เป็น TRUE
				// User ไม่ต้องกรอกข้อมูล

				$already_have_data_in_farmer1 = !empty($data_farmer_one)? true: false;

				$output = array(
					'default_data' => $default_data,
					'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
					'citizen_id' => $citizen_id,
					'mahadthai' => $data_mahadthai,
					'data_farmer_one' => $data_farmer_one,
					'data_getAllprovinces'=>$data_getAllprovinces
				);

				echo $this->load->view('survey_add', $output, true);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			echo $this->load->view('auth/page_header', '', TRUE);


			echo $this->load->view('auth/page_footer', '', TRUE);

		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	public function listjson_local($id=0){

			$response = "";
			$response .= '{"response": ';
			$id = (int)$id;
			// $data[0]->provice_id
			$data = getAmphurByProvince2($id);
			//$data = unserialize(LOCAL_1DATA);
			//print_r($data[0]);
			//print_r($data[0]->{$id}[0]); exit;

			$all_pro = count($data);


			$response .= '"';
		    if($id=="21"){
			  $xname ="เขต";
			}else {
			  $xname ="อำเภอ";
			}
			$response .= '<option  value=\"\">==โปรดเลือก'.$xname.'==</option>';
			for ($i = 0; $i < $all_pro; $i++) {
				///echo "<pre>";print_r($data[$i]); echo "</pre>";


					$html = "";
					if (isset($data[$i]['amphor_name'])) {
						if(trim($data[$i]['amphor_name']!="")) {
							$html = '<option  value=\"' . $data[$i]['amphor_id'] . '\">' . $data[$i]['amphor_name'] . '</option>';
							$response .= $html;
						}
					}//if2


			}//for

			$response .= '"}';
			$response = str_replace('"  "', ' ', $response);
			$response = str_replace('""', '"', $response);


			echo $response;

	}
	public function listjson_local2($id=0){

		$response = "";
		$response .= '{"response": ';
		$id = (int)$id;
		// $data[0]->provice_id
		$data = getTambolByAmphur($id);
		//$data = unserialize(LOCAL_1DATA);
		//print_r($data[0]);
		//print_r($data[0]->{$id}[0]); exit;

		$all_pro = count($data);


		$response .= '"';
		//if($id=="21"){
		//	$xname ="เขต";
		//}else {
			$xname ="ตำบล";
		//}
		$response .= '<option  value=\"\">==โปรดเลือก'.$xname.'==</option>';
		for ($i = 0; $i < $all_pro; $i++) {



			$html = "";
			if (isset($data[$i]['tambol_name'])) {
				if(trim($data[$i]['tambol_name']!="")) {
					$html = '<option  value=\"' . $data[$i]['tambol_id'] . '\">' . $data[$i]['tambol_name'] . '</option>';
					$response .= $html;
				}
			}//if2


		}//for

		$response .= '"}';
		$response = str_replace('"  "', ' ', $response);
		$response = str_replace('""', '"', $response);


		echo $response;

	}


	public function do_survey_add(){
// 		echo "<pre>";
// 		echo "data send";
// 		echo "</pre>";
// 		echo "<pre>";
// 		print_r($this->input->post());
// 		echo "</pre>";
// 		exit();
		$data_test = $this->input->post();
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{ //echo "<pre>"; print_r($_POST); echo "</pre>"; exit; //11-FEB-85
			//print_r($this->input->post('joining_date'));  echo date("d-M-y",strtotime($this->input->post('joining_date')));     exit;
			// echo "<pre>";
			// print_r($this->input->post('water'));
			// echo "</pre>";
			// echo "<pre>"; print_r($this->input->post('water_Irrigation_canal_public'));
			// echo "</pre>";
			
			// echo  '<pre>';
			// print_r($_POST);
			// echo '</pre>';
			// exit();


			$mode = "add";
			if(isset($_POST['mode'])){
				if($_POST['mode']=="edit") {
					$mode = "edit";
				}
			}
			$data = array();

			if(isset($_POST['idcard'])){
				//if($mode=='add') {
					$data['citizen_id'] = $this->input->post('idcard');
					$data[strtoupper('name_title')] = $this->input->post('name_title');
					$data['citizen_firstname'] = $this->input->post('first_name');
					$data['citizen_lastname'] = $this->input->post('last_name');
					$data['citizen_address1'] = $this->input->post('adr');
				//}
				//$data[strtoupper('citizen_address2')] = "";
				
					
				$birthdate = $this->input->post('thebirthdate');
				if (!empty($birthdate))
				{
					$temp = $this->input->post('thebirthdate');
					$tempArray = explode("-", $temp);
					if (isset($tempArray[2]) && is_numeric($tempArray[2]) && $tempArray[2]>2400)
					{
						$tempArray[2] = $tempArray[2]-543;
						$birthdate = implode("-", $tempArray);					
					}
				}

					
				$data['citizen_birthdate'] = date("d-M-y",strtotime($birthdate));
				//$data[strtoupper('citizen_city')] = "";
				$data['citizen_zipcode'] =  $this->input->post('postal_code');

				$data['CITIZEN_PREFIX'] = $this->input->post('name_title');

				$data[strtoupper('household_code')] = $this->input->post('household_code');
				$data[strtoupper('family_status')] =(int)$this->input->post('family_status');
				$data[strtoupper('family_status_others')] = $this->input->post('family_status_others');
				
				// add new input by nattikorn
				
				$data[strtoupper('family_name')] = $this->input->post('family_name');
				$data[strtoupper('family_citizen_id')] =(int)$this->input->post('family_citizen_id');
				$data[strtoupper('email')] = $this->input->post('email');
				$data[strtoupper('agriculture_income')] =(int)$this->input->post('agriculture_income');
				$data[strtoupper('out_agriculture_income')] =(int)$this->input->post('out_agriculture_income');
				$data[strtoupper('do_buz_text')] = $this->input->post('do_buz_text');
				
				
				
				
				//end add new input by nattikorn
				
				$data[strtoupper('house_no')] = $this->input->post('house_no');
				$data[strtoupper('village_no')] = $this->input->post('village_no');
				$data[strtoupper('province_id')] = (int)$this->input->post('province_id');
				$data[strtoupper('district_id')] = (int)$this->input->post('district_id');
				$data[strtoupper('sub_district_id')] = (int)$this->input->post('sub_district_id');
				$data[strtoupper('province_name')] = $this->input->post('province_name');
				$data[strtoupper('district_name')] = $this->input->post('district_name');
				$data[strtoupper('sub_district_name')] = $this->input->post('sub_district_name');
				$data[strtoupper('home_phone_no')] =  $this->input->post('home_phone_no');
				$data[strtoupper('cell_phone')] =  $this->input->post('cell_phone');
				$data[strtoupper('org_type')] = (int)$this->input->post('org_type');
				if($this->input->post('org_type')==1){
					$data[strtoupper('farmer_group_name')] =  $this->input->post('coop_name');
				}
				if($this->input->post('org_type')==2){
					$data[strtoupper('farmer_group_name')] =  $this->input->post('farmer_group_name');
				}


				//$date_from = DateTime::createFromFormat('d/m/Y', $this->input->post('joining_date'));
				//$date_from = $date_from->format('Y-m-d'); 11-FEB-85
				//$j_date = $this->input->post('joining_date');
				//$date_from = '11-FEB-85';
				
				
				$joining_date = $this->input->post('joining_date');
				if (!empty($joining_date))
				{
					$temp = $this->input->post('joining_date');
					$tempArray = explode("-", $temp);
					if (isset($tempArray[2]) && is_numeric($tempArray[2]) && $tempArray[2]>2400)
					{
						$tempArray[2] = $tempArray[2]-543;
						$joining_date = implode("-", $tempArray);
					}
				}
				
				$data[strtoupper('joining_date')] = date("d-M-y",strtotime($joining_date));
				// $data[strtoupper('joining_date')] =  "TO_DATE($this->input->post('joining_date'),'yyyy-mm-dd')"; // $this->input->post('joining_date');
				$data[strtoupper('province_code')] =  $this->input->post('province_code');
				$data[strtoupper('cooperative_code')] =   $this->input->post('cooperative_code');
				$data[strtoupper('budget_year')] =  $this->input->post('budget_year');
				$data[strtoupper('survey_code')] =  $this->input->post('survey_code');

				$data['REGISTRATION_NUMBER'] = $this->input->post('registration_number');

				$data[strtoupper('education_code')] =  $this->input->post('education_code');
				$data[strtoupper('stock_register')] =  $this->input->post('stock_register');
				$data[strtoupper('shares_num')] =  intval($this->input->post('shares_num'));
				
				$data[strtoupper('land_holding_rai')] =  intval($this->input->post('land_holding_rai'));
				$data[strtoupper('land_holding_ngan')] =  intval($this->input->post('land_holding_ngan'));
				$data[strtoupper('land_holding_squarewa')] =  $this->input->post('land_holding_squarewa');
				
				
				$data[strtoupper('own_land_type')] =  serialize($this->input->post('own_land_type'));			
				$data[strtoupper('own_land_type_type')] =  serialize($this->input->post('own_land_type_type'));
				$data[strtoupper('own_land_number')] =  serialize($this->input->post('own_land_number'));
				$data[strtoupper('own_land_ravang')] =  serialize($this->input->post('own_land_ravang'));
				$data[strtoupper('own_land_rai')] =  serialize($this->input->post('own_land_rai'));
				$data[strtoupper('own_land_ngan')] =  serialize($this->input->post('own_land_ngan'));
				$data[strtoupper('own_land_squarewa')] =  serialize($this->input->post('own_land_squarewa'));
				$data[strtoupper('own_land_pin')] =  serialize($this->input->post('own_land_pin'));
				$data[strtoupper('own_land_pname')] =  serialize($this->input->post('own_land_pname'));
				$data[strtoupper('own_land_sname')] =  serialize($this->input->post('own_land_sname'));
				
// 				$data[strtoupper('tab2_area_type')] =  serialize($this->input->post('hire_land_type'));
// 				$data[strtoupper('tab2_area_number')] =  serialize($this->input->post('hire_land_number'));
// 				$data[strtoupper('tab2_area_ravang')] =  serialize($this->input->post('hire_land_ravang'));
// 				$data[strtoupper('tab2_area_rai')] =  serialize($this->input->post('hire_land_rai'));
// 				$data[strtoupper('tab2_area_ngan')] =  serialize($this->input->post('hire_land_ngan'));
// 				$data[strtoupper('tab2_area_squarewa')] =  serialize($this->input->post('hire_land_squarewa'));
// 				$data[strtoupper('tab2_area_pin')] =  serialize($this->input->post('hire_land_pin'));
// 				$data[strtoupper('tab2_area_pname')] =  serialize($this->input->post('hire_land_pname'));
// 				$data[strtoupper('tab2_area_sname')] =  serialize($this->input->post('hire_land_sname'));
				
				
				
// 				$data[strtoupper('obligation_land')] =  serialize($this->input->post('obligation_land'));
// 				$data[strtoupper('land_other_reason')] =  $this->input->post('land_other_reason');
				
				$data[strtoupper('water')] =  serialize($this->input->post('water'));
				$data[strtoupper('water_shallow_well_own')] =  serialize($this->input->post('water_shallow_well_own'));
				$data[strtoupper('water_groundwater_wells_own')] =  serialize($this->input->post('water_groundwater_wells_own'));
				$data[strtoupper('water_ponds_own')] =  serialize($this->input->post('water_ponds_own'));
				$data[strtoupper('water_groundwater_wells_public')] =  serialize($this->input->post('water_groundwater_wells_public'));
				$data[strtoupper('water_swamp_public')] =  serialize($this->input->post('water_swamp_public'));
				$data[strtoupper('water_Irrigation_canal_public')] =  serialize($this->input->post('water_Irrigation_canal_public'));
				$data[strtoupper('water_river_public')] =  serialize($this->input->post('water_river_public'));
				
				
// 				$data[strtoupper('water_type')] =  $this->input->post('water_type');
// 				$data[strtoupper('water_holding_rai')] =  $this->input->post('water_holding_rai');
// 				$data[strtoupper('water_holding_ngan')] =  $this->input->post('water_holding_ngan');
// 				$data[strtoupper('water_holding_squarewa')] =  $this->input->post('water_holding_squarewa');
// 				$data[strtoupper('water_type_others')] =  $this->input->post('water_type_others');

				
				$data[strtoupper('farm_equ')] =  $this->input->post('farm_equ');
				$data[strtoupper('plant_type')] =  serialize($this->input->post('plant_type'));
				$data[strtoupper('plant_specie')] =  serialize($this->input->post('plant_specie'));
				$data[strtoupper('planting_num_per_year')] =  serialize($this->input->post('plant_planting_num_per_year'));
				$data[strtoupper('growing_area')] =  serialize($this->input->post('growing_area'));
				$data[strtoupper('growing_area_will')] =  serialize($this->input->post('growing_area_will'));
				$data[strtoupper('product_num_per_year')] =  serialize($this->input->post('plant_product_num_per_year'));
				$data[strtoupper('PLANT_SELL_MECHANT')] =  serialize($this->input->post('plant_sell_merchant'));
				$data[strtoupper('plant_sell_coop')] =  serialize($this->input->post('plant_sell_coop'));
				$data[strtoupper('plant_sell_other')] =  serialize($this->input->post('plant_sell_other'));
				$data[strtoupper('estsales_revenueyear')] =  serialize($this->input->post('estimated_sales_revenue_per_year'));
				$data[strtoupper('estagri_incomeyear')] =  serialize($this->input->post('estimate_agri_income_per_year'));

				$data[strtoupper('how2sell')] =  serialize($this->input->post('how2sell'));
				$data[strtoupper('sale_problems')] =  $this->input->post('sale_problems');

				$data[strtoupper('how2sell_others_reason')] =  $this->input->post('how2sell3_others_reason');
				$data[strtoupper('product_sale_comment')] =  serialize($this->input->post('product_sale_comment'));
				$data[strtoupper('product_sale_other')] = $this->input->post('product_sale_comment_other');
				$data[strtoupper('product_sale_comment2')] =  serialize($this->input->post('product_sale_comment2'));
				$data[strtoupper('product_sale_other2')] = $this->input->post('product_sale_comment_other2');
				$data[strtoupper('chm1_46_0_0')] =  serialize($this->input->post('chm1_46_0_0'));
				$data[strtoupper('chm2_15_15_15')] =  serialize($this->input->post('chm2_15_15_15'));
				$data[strtoupper('chm3_16_20_0')] =  serialize($this->input->post('chm3_16_20_0'));
				$data[strtoupper('chm4_other')] =  serialize($this->input->post('chm4_other'));
				$data[strtoupper('chm2_intr')] =  serialize($this->input->post('chm2_intr_intr_intr'));
				$data[strtoupper('chm1_water')] =  serialize($this->input->post('chm1_water_water_water'));
				$data[strtoupper('chm2_c_c_c')] =  serialize($this->input->post('chm2_c_c_c'));
				$data[strtoupper('chm1_seed')] =  serialize($this->input->post('chm1_seed'));
				$data[strtoupper('chm1_seed_text')] =  serialize($this->input->post('chm1_seed_text'));
				$data[strtoupper('chm2_seed')] =  serialize($this->input->post('chm2_seed'));
				$data[strtoupper('chm2_seed_text')] =  serialize($this->input->post('chm2_seed_text'));
				$data[strtoupper('ani_type')] =  serialize($this->input->post('ani_type'));
				$data[strtoupper('ani_specie')] =  serialize($this->input->post('ani_specie'));
				$data[strtoupper('ani_num_per_year')] =  serialize($this->input->post('ani_num_per_year'));
				$data[strtoupper('ani_num_will')] =  serialize($this->input->post('ani_num_will'));
				$data[strtoupper('ani_num_sale')] =  serialize($this->input->post('ani_num_sale'));
				$data[strtoupper('ani_income')] =  serialize($this->input->post('ani_income'));
				$data[strtoupper('ani_expense_per_year')] =  serialize($this->input->post('ani_expense_per_year'));
				$data[strtoupper('ani_food')] =  serialize($this->input->post('ani_food'));
				$data[strtoupper('ani_wetchapan')] =  serialize($this->input->post('ani_wetchapan'));
				
				$data[strtoupper('ani2_type')] =  serialize($this->input->post('ani2_type'));
				$data[strtoupper('ani2_specie')] =  serialize($this->input->post('ani2_specie'));
				$data[strtoupper('ani2_numyear')] =  serialize($this->input->post('ani2_numyear'));	
				$data[strtoupper('ani2_will')] =  serialize($this->input->post('ani2_will'));	
				$data[strtoupper('ani2_sale')] =  serialize($this->input->post('ani2_sale'));	
				$data[strtoupper('ani2_expense_per_year')] =  serialize($this->input->post('ani2_expense_per_year'));
				$data[strtoupper('ani2_income')] =  serialize($this->input->post('ani2_income'));
				$data[strtoupper('ani2_food')] =  serialize($this->input->post('ani2_food'));
				$data[strtoupper('ani2_wetchapan')] =  serialize($this->input->post('ani2_wetchapan'));
				$data[strtoupper('tab5_a1')] =  serialize($this->input->post('tab5_a1'));

				$data[strtoupper('tab5_a1_problem')] =  $this->input->post('tab5_a1_problem');
				$data[strtoupper('tab5_a2')] =  serialize($this->input->post('tab5_a2'));
				$data[strtoupper('tab5_a2_problem')] =  $this->input->post('tab5_a2_problem');
				$data[strtoupper('tab5_a3')] =  serialize($this->input->post('tab5_a3'));
				$data[strtoupper('tab5_a4')] =  serialize($this->input->post('tab5_a4'));
				$data[strtoupper('tab5_a5')] =  serialize($this->input->post('tab5_a5'));
				$data[strtoupper('tab5_a6')] =  serialize($this->input->post('tab5_a6'));
				$data[strtoupper('tab5_a6_other')] =  $this->input->post('tab5_a6_other');

				$data[strtoupper('tab4_b6')] =  serialize($this->input->post('tab4_b6'));
				$data[strtoupper('tab4_b6_other')] =  $this->input->post('tab4_b6_other');
				$data[strtoupper('tab5_debt_num')] =  serialize($this->input->post('tab5_debt_num'));

				$temp_name = 'tab5_debt_num';
				$data[strtoupper($temp_name.'_coop')] =  $this->input->post($temp_name."['coop']");
				$data[strtoupper($temp_name.'_baac')] =  $this->input->post($temp_name."['baac']");
				$data[strtoupper($temp_name.'_b_others')] =  $this->input->post($temp_name."['b_others']");
				$data[strtoupper($temp_name.'_housing')] =  $this->input->post($temp_name."['housing']");
				$data[strtoupper($temp_name.'_middle_man')] =  $this->input->post($temp_name."['middle_man']");
				$data[strtoupper($temp_name.'_the_neig')] =  $this->input->post($temp_name."['the_neig']");
				$data[strtoupper($temp_name.'_others')] =  $this->input->post($temp_name."['others']");

// 				$temp_name = 'tab5_debt_normal';
// 				if(isset($this->input->post($temp_name."")['coop'])) {
// 					$data[strtoupper($temp_name . '_coop')] = (int)$this->input->post($temp_name . "")['coop'];
// 				}
// 				if(isset($this->input->post($temp_name."")['baac'])) {
// 					$data[strtoupper($temp_name . '_baac')] = (int)$this->input->post($temp_name . "")['baac'];
// 				}
// 				if(isset($this->input->post($temp_name."")['b_others'])) {
// 					$data[strtoupper($temp_name . '_others')] = (int)$this->input->post($temp_name . "")['b_others'];
// 				}
// 				//$data[strtoupper($temp_name.'_housing_fund')] =  $this->input->post($temp_name."['housing_fund']");
// 				if(isset($this->input->post($temp_name."")['middle_man'])) {
// 					$data[strtoupper($temp_name . '_middle_man')] = (int)$this->input->post($temp_name . "")['middle_man'];
// 				}
// 				if(isset($this->input->post($temp_name."")['the_neighbor'])) {
// 					$data[strtoupper($temp_name . '_the_neig')] = (int)$this->input->post($temp_name . "")['the_neighbor'];
// 				}
// 				if(isset($this->input->post($temp_name."")['the_others'])) {
// 					$data[strtoupper($temp_name . '_the_others')] = (int)$this->input->post($temp_name . "")['the_others'];
// 				}

				$temp_name = 'tab5_debt_abnormal';
				$data[strtoupper($temp_name.'_coop')] =  !empty((int)$this->input->post($temp_name."")['coop'])?(int)$this->input->post($temp_name."")['coop']:"N";
				$data[strtoupper($temp_name.'_baac')] =   !empty((int)$this->input->post($temp_name."")['baac'])?(int)$this->input->post($temp_name."")['baac']:"N";
				$data[strtoupper($temp_name.'_b_others')] =   !empty((int)$this->input->post($temp_name."")['b_others'])?(int)$this->input->post($temp_name."")['b_others']:"N";
				$data[strtoupper($temp_name.'_housing')] =   !empty((int)$this->input->post($temp_name."")['housing'])?(int)$this->input->post($temp_name."")['housing']:"N";
				$data[strtoupper($temp_name.'_middle_man')] =   !empty((int)$this->input->post($temp_name."")['middle_man'])?(int)$this->input->post($temp_name."")['middle_man']:"N";
				$data[strtoupper($temp_name.'_the_neig')] =   !empty((int)$this->input->post($temp_name."")['the_neig'])?(int)$this->input->post($temp_name."")['the_neig']:"N";
				$data[strtoupper($temp_name.'_others')] =   !empty((int)$this->input->post($temp_name."")['others'])?(int)$this->input->post($temp_name."")['others']:"N";
				
				$temp_name = 'tab5_debt_normal';
				$data[strtoupper($temp_name.'_coop')] =  !empty((int)$this->input->post($temp_name."")['coop'])?(int)$this->input->post($temp_name."")['coop']:"N";
				$data[strtoupper($temp_name.'_baac')] =   !empty((int)$this->input->post($temp_name."")['baac'])?(int)$this->input->post($temp_name."")['baac']:"N";
				$data[strtoupper($temp_name.'_b_others')] =   !empty((int)$this->input->post($temp_name."")['b_others'])?(int)$this->input->post($temp_name."")['b_others']:"N";
				$data[strtoupper($temp_name.'_housing')] =   !empty((int)$this->input->post($temp_name."")['housing'])?(int)$this->input->post($temp_name."")['housing']:"N";
				$data[strtoupper($temp_name.'_middle_man')] =   !empty((int)$this->input->post($temp_name."")['middle_man'])?(int)$this->input->post($temp_name."")['middle_man']:"N";
				$data[strtoupper($temp_name.'_the_neig')] =   !empty((int)$this->input->post($temp_name."")['the_neig'])?(int)$this->input->post($temp_name."")['the_neig']:"N";
				$data[strtoupper($temp_name.'_others')] =   !empty((int)$this->input->post($temp_name."")['others'])?(int)$this->input->post($temp_name."")['others']:"N";
				
				$data[strtoupper('tab5_debt_the_others')] =  $this->input->post('tab5_debt_the_others');
				$data[strtoupper('tab6_a1_type')] =  serialize($this->input->post('tab6_a1_type'));
				$data[strtoupper('tab6_a1_species')] =  serialize($this->input->post('tab6_a1_species'));
				$data[strtoupper('tab6_a1_doing')] =  serialize($this->input->post('tab6_a1_doing'));
				$data[strtoupper('tab6_a1_willdo')] =  serialize($this->input->post('tab6_a1_willdo'));
				$data[strtoupper('tab6_a1_expected_output')] =  serialize($this->input->post('tab6_a1_expected_output'));
				$data[strtoupper('tab6_a2_type')] =  serialize($this->input->post('tab6_a2_type'));
				$data[strtoupper('tab6_a2_species')] =  serialize($this->input->post('tab6_a2_species'));

				$data[strtoupper('tab6_a2_doing')] =  serialize($this->input->post('tab6_a2_doing'));
				$data[strtoupper('tab6_a2_willdo')] =  serialize($this->input->post('tab6_a2_willdo'));
				$data[strtoupper('tab6_a2_expected_output')] =  serialize($this->input->post('tab6_a2_expected_output'));
				$data[strtoupper('tab7_a1_bucket_no')] =  serialize($this->input->post('tab7_a1_bucket_no'));
				$data[strtoupper('tab7_a1_cows1')] =  serialize($this->input->post('tab7_a1_cows1'));
				$data[strtoupper('tab7_a1_cows2')] =  serialize($this->input->post('tab7_a1_cows2'));
				$data[strtoupper('tab7_a1_cows3')] =  serialize($this->input->post('tab7_a1_cows3'));
				$data[strtoupper('tab7_a1_cows4')] =  serialize($this->input->post('tab7_a1_cows4'));
				$data[strtoupper('tab7_a1_cows5')] =  serialize($this->input->post('tab7_a1_cows5'));
				$data[strtoupper('tab7_a1_cowsmilk_pregnant')] =  serialize($this->input->post('tab7_a1_cowsmilk_pregnant'));
				$data[strtoupper('tab7_a1_cowsmilk_notpregnant')] =  serialize($this->input->post('tab7_a1_cowsmilk_notpregnant'));
				$data[strtoupper('tab7_a1_cowsmilk_all')] =  serialize($this->input->post('tab7_a1_cowsmilk_all'));
				$data[strtoupper('tab7_a1_cowslay_pregnant')] =  serialize($this->input->post('tab7_a1_cowslay_pregnant'));
				$data[strtoupper('tab7_a1_cowslay_notpregnant')] =  serialize($this->input->post('tab7_a1_cowslay_notpregnant'));
				$data[strtoupper('tab7_a1_cowslay_all')] =  serialize($this->input->post('tab7_a1_cowslay_all'));
				$data[strtoupper('tab7_a1_cows_total')] =  serialize($this->input->post('tab7_a1_cows_total'));

				$data[strtoupper('need_help_agri')] =  $this->input->post('need_help_agri');
				$data[strtoupper('need_help_market')] =  $this->input->post('need_help_market');
                $data['FARM_EQU_THERS'] = $this->input->post('farm_equ_thers');
				$data['CITIZEN_LANE'] = $this->input->post('lane');
				$data['CITIZEN_ROAD'] = $this->input->post('road');
				
				
				$data['SECONDARY_CAREER'] = $this->input->post('secondary_career');
				$data[strtoupper('secondary_career_orther')] = $this->input->post('secondary_career_orther');
				$data['MAIN_CAREER'] = $this->input->post('main_career');
				$data[strtoupper('main_career_orther')] = $this->input->post('main_career_orther');
				$data['DO_BUZ'] = serialize($this->input->post('do_buz'));
				$data['DO_BUZ2'] = serialize($this->input->post('do_buz2'));
				$data[strtoupper('do_buz_text')] = $this->input->post('do_buz_text');
				
				
				$data['DO_BUZ_OTHER'] = $this->input->post('do_buz_other');

// 				$data[strtoupper('people_all')] =   $this->input->post('people_all');
// 				$data[strtoupper('people_men')] =   $this->input->post('people_men');
// 				$data[strtoupper('people_women')] =   $this->input->post('people_women');
// 				$data[strtoupper('people_in_agri')] =   $this->input->post('people_in_agri');
// 				$data[strtoupper('people_out_agri')] =   $this->input->post('people_out_agri');
// 				$data[strtoupper('people_out_agri')] =   $this->input->post('people_out_agri');
// 				$data[strtoupper('people_men2')] =   $this->input->post('people_men2');
// 				$data[strtoupper('people_women2')] =   $this->input->post('people_women2');
// 				$data[strtoupper('people_student2')] =   $this->input->post('people_student2');
				$data[strtoupper('year_income')] =   $this->input->post('year_income');
				$data[strtoupper('agriculture_income')] =   $this->input->post('agriculture_income');
				$data[strtoupper('out_agriculture_income')] =   $this->input->post('out_agriculture_income');
// 				$data[strtoupper('people_out_agri2')] =   $this->input->post('people_out_agri2');
// 				$data[strtoupper('people_out_agri2')] =   $this->input->post('people_out_agri2');

				$data['modified_by'] = $this->session->userdata('auth_user_id');
				$data['created_by'] = $this->session->userdata('auth_user_id');	
				$data[strtoupper('COOP_ID')] = $this->input->post('coop_id');
				$data[strtoupper('COOPERATIVE_CODE')] = $this->input->post('coop_id');
				
				
				//$data[strtoupper('COOP_ID')] = '7600000125597';
				// echo "<pre>";
				// print_r($this->input->post('water'));
				// echo "</pre>";
				// echo "<pre>"; print_r($this->input->post('water_Irrigation_canal_public'));
				// echo "</pre>";
				
				// echo  '<pre>';
				// print_r($_POST);
				// echo '</pre>';
				// exit();

// 				$test_check = array(
						
// 						'name_title',
// 						'first_name',
// 						'last_name',
// 						'idcard',
// 						'thebirthdate',
// 						'family_status_others',
// 						'house_no',
// 						'village_no',
// 						'lane',
// 						'road',
// 						'province_name',
// 						'district_id',
// 						'district_name',
// 						'sub_district_id',
// 						'sub_district_name',
// 						'postal_code',
// 						'home_phone_no',
// 						'cell_phone',
// 						'year_income',
// 						'typeCoop',
// 						'farmer_group_name',
// 						'budget_year',
// 						'registration_number',
// 						'stock_register',
// 						'shares_num',
// 						'do_buz_other',
// 						'land_holding_ngan',
// 						'land_holding_squarewa',
// 						'own_land_type',
// 						'own_land_number',
// 						'own_land_ravang',
// 						'own_land_pin',
// 						'own_land_pname',
// 						'own_land_sname',
// 						'how2sell3_others_reason',
// 						'product_sale_comment_other',
// 						'product_sale_comment_other2',
// 						'ani2_planting_num_per_year',
// 						'chm2_intr_intr_intr',
// 						'chm1_water_water_water',
// 						'tab4_b6_other',
// 						'tab5_debt_normal',
// 						'tab5_debt_abnormal',
// 						'tab5_debt_the_others',
// 						'own_land_rai',
// 						'coop_name',
// 						'own_land_squarewa',
// 						'own_land_ngan',
// 						'',
// 						'',
// 						''
						
// 				);
// 				$data_not_math = array();
// 				foreach ($data_test as $k=>$v)
// 				{
// 					if(!empty($data[strtoupper($k)]) || in_array($k, $test_check))
// 					{
						
// 					}else{
// 						$data_not_math[$k] = $v;
// 					}
// 				}
				
// 				$data_get = $_POST;
// // 				echo "data_get<pre>";
// // 				print_r($data_get);
// // 				echo "</pre>";
// 				echo "data_get<pre>";
// 				print_r(sizeof($data_get));
// 				echo "</pre>";
// 				echo "data<pre>";
// 				print_r(sizeof($data));
// 				echo "</pre>";
// 				echo "<pre>";
// 				print_r(sizeof($data_not_math));
// 				echo "</pre>";
				
// 				echo "<pre>";
// 				print_r($data_not_math);
// 				echo "</pre>";
				
				
// 				exit();
				
				// strip tags
				foreach ($data as $k=>$v)
				{
					$data[$k] = strip_tags($v);
				}
				
				$this->load->model('grocery_crud_model');
				$crud = new grocery_CRUD();

				if($mode=="edit"){
					if ($this->grocery_crud_model->EditSurvey($data['citizen_id'],$data)) {
						//work
						checkSuspiciousActivityMahadthai($data['citizen_id'], "แก้ไขแบบสำรวจ", getSelectedSurveyYear());
					} else {
						//not work
					}
				}else {
					
					if ($this->grocery_crud_model->addSurvey($data)) {
						//work
						checkSuspiciousActivityMahadthai($data['citizen_id'], "กรอกแบบสำรวจ", getSelectedSurveyYear());

					} else {
						//not work
					}
				}
			    redirect('/', 'refresh');
			}
		}

	}
	public function edit_survey_1($citizen_id)
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			if(strlen($citizen_id)!=13 && !is_numeric($citizen_id))
			{
				redirect('admin/add_survey', 'refresh');
			}

			$year = getSelectedSurveyYear();
			if (!canView($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิแก้ไขแบบสำรวจ'), TRUE);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}
			
			// check access
// 			checkSuspiciousActivityMahadthai($citizen_id, "Add Survey 1", getSelectedSurveyYear());

			$output = array();

			$step = isset($_GET['step'])? $_GET['step']: "";

			if ($step=="1")
			{
				echo $this->load->view('auth/page_header', '', TRUE);

				// load data from MAHADTHAI and check if information is there
				$data_mahadthai = getMahadthaiByCitizenID($citizen_id);

				// Load data from FarmerOne and check if information is there
				$data_farmer_one = getFarmerOneByCitizenID($citizen_id);

				// if there is info from $mahadthai_table or $farmer_one_table, autofill the form
				$default_data = array(

				);

				// if there is info from $mahadthai_table or $farmer_one_table, autofill the form
				$output = array(
					'default_data' => $default_data,
					'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
					'citizen_id' => $citizen_id,
					'mahadthai' => $data_mahadthai,
					'data_farmer_one' => $data_farmer_one,
				);

				echo $this->load->view('survey_edit', $output, true);

				echo $this->load->view('auth/page_footer', '', TRUE);

				die();
			}

			echo $this->load->view('auth/page_header', '', TRUE);


			echo $this->load->view('auth/page_footer', '', TRUE);

		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	
	public function search_surver($citizen_id)
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$this->db->where('citizen_id',$citizen_id);
			$query = $this->db->get('SURVEY_2018')->result_array();
			$data_return = array();
			if(!empty($query) && sizeof($query)>0)
			{
				$data_return[] = 'SURVEY_2018';
			}
			
			
			echo json_encode($data_return);
			
		}
	}
	
	public function callAgency($value='')
		{
			$agency= array(	
					"กองการเจ้าหน้าที่(กกจ)"=>"กองการเจ้าหน้าที่(กกจ)",
					"กองแผนงาน(กผง)"=>"กองแผนงาน(กผง)",
					"ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร(ศสท)"=>"ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร(ศสท)",
					"กองคลัง(กค)"=>"กองคลัง(กค)",
					"กลุ่มตรวจสอบภายใน(กตน)"=>"กลุ่มตรวจสอบภายใน(กตน)",
					"กลุ่มพัฒนาระบบบริหาร(กพร)"=>"กลุ่มพัฒนาระบบบริหาร(กพร)",
					"สำนักงานเลขานุการกรม(สลก)"=>"สำนักงานเลขานุการกรม(สลก)",
					"กองพัฒนาสหกรณ์ภาคการเกษตรและกลุ่มเกษตรกร(กพก)"=>"กองพัฒนาสหกรณ์ภาคการเกษตรและกลุ่มเกษตรกร(กพก)",
					"กองพัฒนาสหกรณ์ด้านการเงินและร้านค้า(กพง)"=>"กองพัฒนาสหกรณ์ด้านการเงินและร้านค้า(กพง)",
					"กองพัฒนาระบบสนับสนุนการสหกรณ์(กพน)"=>"กองพัฒนาระบบสนับสนุนการสหกรณ์(กพน)",
					"สำนักพัฒนาและถ่ายทอดเทคโนโลยีการสหกรณ์(สทส)"=>"สำนักพัฒนาและถ่ายทอดเทคโนโลยีการสหกรณ์(สทส)",
					"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่1(สสพ1)"=>"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่1(สสพ1)",
					"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่2(สสพ2)"=>"สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานครพื้นที่2(สสพ2)",
					"สำนักนายทะเบียนและกฎหมาย(สนม)"=>"สำนักนายทะเบียนและกฎหมาย(สนม)",
					"สถาบันพัฒนาเครื่องจักรกลและพื้นที่สหกรณ์(สคส)"=>"สถาบันพัฒนาเครื่องจักรกลและพื้นที่สหกรณ์(สคส)",
					"สถาบันพัฒนากรรมการและฝ่ายจัดการสหกรณ์(สกส)"=>"สถาบันพัฒนากรรมการและฝ่ายจัดการสหกรณ์(สกส)",
					"กองประสานงานโครงการพระราชดำริ(กคร)"=>"กองประสานงานโครงการพระราชดำริ(กคร)",
					"ผู้ตรวจราชการกรมส่งเสริมสหกรณ์(ผตร)"=>"ผู้ตรวจราชการกรมส่งเสริมสหกรณ์(ผตร)",
					"สำนักงานติดตามงานตามนโยบายของรมว.กษ.(กรมส่งเสริมสหกรณ์)(สตน)"=>"สำนักงานติดตามงานตามนโยบายของรมว.กษ.(กรมส่งเสริมสหกรณ์)(สตน)",
					"สำนักงานสหกรณ์จังหวัดนนทบุรี"=>"สำนักงานสหกรณ์จังหวัดนนทบุรี",
					"สำนักงานสหกรณ์จังหวัดปทุมธานี"=>"สำนักงานสหกรณ์จังหวัดปทุมธานี",
					"สำนักงานสหกรณ์จังหวัดพระนครศรีอยุธยา"=>"สำนักงานสหกรณ์จังหวัดพระนครศรีอยุธยา",
					"สำนักงานสหกรณ์จังหวัดสระบุรี"=>"สำนักงานสหกรณ์จังหวัดสระบุรี",
					"สำนักงานสหกรณ์จังหวัดชัยนาท"=>"สำนักงานสหกรณ์จังหวัดชัยนาท",
					"สำนักงานสหกรณ์จังหวัดลพบุรี"=>"สำนักงานสหกรณ์จังหวัดลพบุรี",
					"สำนักงานสหกรณ์จังหวัดสิงห์บุรี"=>"สำนักงานสหกรณ์จังหวัดสิงห์บุรี",
					"สำนักงานสหกรณ์จังหวัดอ่างทอง"=>"สำนักงานสหกรณ์จังหวัดอ่างทอง",
					"สำนักงานสหกรณ์จังหวัดฉะเชิงเทรา"=>"สำนักงานสหกรณ์จังหวัดฉะเชิงเทรา",
					"สำนักงานสหกรณ์จังหวัดปราจีนบุรี"=>"สำนักงานสหกรณ์จังหวัดปราจีนบุรี",
					"สำนักงานสหกรณ์จังหวัดสระแก้ว"=>"สำนักงานสหกรณ์จังหวัดสระแก้ว",
					"สำนักงานสหกรณ์จังหวัดนครนายก"=>"สำนักงานสหกรณ์จังหวัดนครนายก",
					"สำนักงานสหกรณ์จังหวัดสมุทรปราการ"=>"สำนักงานสหกรณ์จังหวัดสมุทรปราการ",
					"สำนักงานสหกรณ์จังหวัดกาญจนบุรี"=>"สำนักงานสหกรณ์จังหวัดกาญจนบุรี",
					"สำนักงานสหกรณ์จังหวัดนครปฐม"=>"สำนักงานสหกรณ์จังหวัดนครปฐม",
					"สำนักงานสหกรณ์จังหวัดราชบุรี"=>"สำนักงานสหกรณ์จังหวัดราชบุรี",
					"สำนักงานสหกรณ์จังหวัดสุพรรณบุรี"=>"สำนักงานสหกรณ์จังหวัดสุพรรณบุรี",
					"สำนักงานสหกรณ์จังหวัดประจวบคีรีขันธ์"=>"สำนักงานสหกรณ์จังหวัดประจวบคีรีขันธ์",
					"สำนักงานสหกรณ์จังหวัดเพชรบุรี"=>"สำนักงานสหกรณ์จังหวัดเพชรบุรี",
					"สำนักงานสหกรณ์จังหวัดสมุทรสาคร"=>"สำนักงานสหกรณ์จังหวัดสมุทรสาคร",
					"สำนักงานสหกรณ์จังหวัดสมุทรสงคราม"=>"สำนักงานสหกรณ์จังหวัดสมุทรสงคราม",
					"สำนักงานสหกรณ์จังหวัดชุมพร"=>"สำนักงานสหกรณ์จังหวัดชุมพร",
					"สำนักงานสหกรณ์จังหวัดสุราษฎร์ธานี"=>"สำนักงานสหกรณ์จังหวัดสุราษฎร์ธานี",
					"สำนักงานสหกรณ์จังหวัดนครศรีธรรมราช"=>"สำนักงานสหกรณ์จังหวัดนครศรีธรรมราช",
					"สำนักงานสหกรณ์จังหวัดพัทลุง"=>"สำนักงานสหกรณ์จังหวัดพัทลุง",
					"สำนักงานสหกรณ์จังหวัดระนอง"=>"สำนักงานสหกรณ์จังหวัดระนอง",
					"สำนักงานสหกรณ์จังหวัดพังงา"=>"สำนักงานสหกรณ์จังหวัดพังงา",
					"สำนักงานสหกรณ์จังหวัดภูเก็ต"=>"สำนักงานสหกรณ์จังหวัดภูเก็ต",
					"สำนักงานสหกรณ์จังหวัดกระบี่"=>"สำนักงานสหกรณ์จังหวัดกระบี่",
					"สำนักงานสหกรณ์จังหวัดตรัง"=>"สำนักงานสหกรณ์จังหวัดตรัง",
					"สำนักงานสหกรณ์จังหวัดสงขลา"=>"สำนักงานสหกรณ์จังหวัดสงขลา",
					"สำนักงานสหกรณ์จังหวัดสตูล"=>"สำนักงานสหกรณ์จังหวัดสตูล",
					"สำนักงานสหกรณ์จังหวัดปัตตานี"=>"สำนักงานสหกรณ์จังหวัดปัตตานี",
					"สำนักงานสหกรณ์จังหวัดยะลา"=>"สำนักงานสหกรณ์จังหวัดยะลา",
					"สำนักงานสหกรณ์จังหวัดนราธิวาส"=>"สำนักงานสหกรณ์จังหวัดนราธิวาส",
					"สำนักงานสหกรณ์จังหวัดจันทบุรี"=>"สำนักงานสหกรณ์จังหวัดจันทบุรี",
					"สำนักงานสหกรณ์จังหวัดชลบุรี"=>"สำนักงานสหกรณ์จังหวัดชลบุรี",
					"สำนักงานสหกรณ์จังหวัดระยอง"=>"สำนักงานสหกรณ์จังหวัดระยอง",
					"สำนักงานสหกรณ์จังหวัดตราด"=>"สำนักงานสหกรณ์จังหวัดตราด",
					"สำนักงานสหกรณ์จังหวัดหนองคาย"=>"สำนักงานสหกรณ์จังหวัดหนองคาย",
					"สำนักงานสหกรณ์จังหวัดเลย"=>"สำนักงานสหกรณ์จังหวัดเลย",
					"สำนักงานสหกรณ์จังหวัดอุดรธานี"=>"สำนักงานสหกรณ์จังหวัดอุดรธานี",
					"สำนักงานสหกรณ์จังหวัดหนองบัวลำภู"=>"สำนักงานสหกรณ์จังหวัดหนองบัวลำภู",
					"สำนักงานสหกรณ์จังหวัดบึงกาฬ"=>"สำนักงานสหกรณ์จังหวัดบึงกาฬ",
					"สำนักงานสหกรณ์จังหวัดนครพนม"=>"สำนักงานสหกรณ์จังหวัดนครพนม",
					"สำนักงานสหกรณ์จังหวัดมุกดาหาร"=>"สำนักงานสหกรณ์จังหวัดมุกดาหาร",
					"สำนักงานสหกรณ์จังหวัดสกลนคร"=>"สำนักงานสหกรณ์จังหวัดสกลนคร",
					"สำนักงานสหกรณ์จังหวัดร้อยเอ็ด"=>"สำนักงานสหกรณ์จังหวัดร้อยเอ็ด",
					"สำนักงานสหกรณ์จังหวัดขอนแก่น"=>"สำนักงานสหกรณ์จังหวัดขอนแก่น",
					"สำนักงานสหกรณ์จังหวัดมหาสารคาม"=>"สำนักงานสหกรณ์จังหวัดมหาสารคาม",
					"สำนักงานสหกรณ์จังหวัดกาฬสินธุ์"=>"สำนักงานสหกรณ์จังหวัดกาฬสินธุ์",
					"สำนักงานสหกรณ์จังหวัดอำนาจเจริญ"=>"สำนักงานสหกรณ์จังหวัดอำนาจเจริญ",
					"สำนักงานสหกรณ์จังหวัดศรีสะเกษ"=>"สำนักงานสหกรณ์จังหวัดศรีสะเกษ",
					"สำนักงานสหกรณ์จังหวัดยโสธร"=>"สำนักงานสหกรณ์จังหวัดยโสธร",
					"สำนักงานสหกรณ์จังหวัดอุบลราชธานี"=>"สำนักงานสหกรณ์จังหวัดอุบลราชธานี",
					"สำนักงานสหกรณ์จังหวัดสุรินทร์"=>"สำนักงานสหกรณ์จังหวัดสุรินทร์",
					"สำนักงานสหกรณ์จังหวัดนครราชสีมา"=>"สำนักงานสหกรณ์จังหวัดนครราชสีมา",
					"สำนักงานสหกรณ์จังหวัดบุรีรัมย์"=>"สำนักงานสหกรณ์จังหวัดบุรีรัมย์",
					"สำนักงานสหกรณ์จังหวัดชัยภูมิ"=>"สำนักงานสหกรณ์จังหวัดชัยภูมิ",
					"สำนักงานสหกรณ์จังหวัดเชียงใหม่"=>"สำนักงานสหกรณ์จังหวัดเชียงใหม่",
					"สำนักงานสหกรณ์จังหวัดแม่ฮ่องสอน"=>"สำนักงานสหกรณ์จังหวัดแม่ฮ่องสอน",
					"สำนักงานสหกรณ์จังหวัดลำปาง"=>"สำนักงานสหกรณ์จังหวัดลำปาง",
					"สำนักงานสหกรณ์จังหวัดลำพูน"=>"สำนักงานสหกรณ์จังหวัดลำพูน",
					"สำนักงานสหกรณ์จังหวัดน่าน"=>"สำนักงานสหกรณ์จังหวัดน่าน",
					"สำนักงานสหกรณ์จังหวัดพะเยา"=>"สำนักงานสหกรณ์จังหวัดพะเยา",
					"สำนักงานสหกรณ์จังหวัดเชียงราย"=>"สำนักงานสหกรณ์จังหวัดเชียงราย",
					"สำนักงานสหกรณ์จังหวัดแพร่"=>"สำนักงานสหกรณ์จังหวัดแพร่",
					"สำนักงานสหกรณ์จังหวัดตาก"=>"สำนักงานสหกรณ์จังหวัดตาก",
					"สำนักงานสหกรณ์จังหวัดพิษณุโลก"=>"สำนักงานสหกรณ์จังหวัดพิษณุโลก",
					"สำนักงานสหกรณ์จังหวัดสุโขทัย"=>"สำนักงานสหกรณ์จังหวัดสุโขทัย",
					"สำนักงานสหกรณ์จังหวัดเพชรบูรณ์"=>"สำนักงานสหกรณ์จังหวัดเพชรบูรณ์",
					"สำนักงานสหกรณ์จังหวัดอุตรดิตถ์"=>"สำนักงานสหกรณ์จังหวัดอุตรดิตถ์",
					"สำนักงานสหกรณ์จังหวัดกำแพงเพชร"=>"สำนักงานสหกรณ์จังหวัดกำแพงเพชร",
					"สำนักงานสหกรณ์จังหวัดพิจิตร"=>"สำนักงานสหกรณ์จังหวัดพิจิตร",
					"สำนักงานสหกรณ์จังหวัดนครสวรรค์"=>"สำนักงานสหกรณ์จังหวัดนครสวรรค์",
					"สำนักงานสหกรณ์จังหวัดอุทัยธานี"=>"สำนักงานสหกรณ์จังหวัดอุทัยธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 1 จังหวัดปทุมธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 1 จังหวัดปทุมธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 2 จังหวัดปทุมธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 2 จังหวัดปทุมธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 3 จังหวัดชลบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 3 จังหวัดชลบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 4 จังหวัดนครนายก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 4 จังหวัดนครนายก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 5 จังหวัดนครราชสีมา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 5 จังหวัดนครราชสีมา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 6 จังหวัดนครราชสีมา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 6 จังหวัดนครราชสีมา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 7 จังหวัดขอนแก่น"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 7 จังหวัดขอนแก่น",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 8 จังหวัดขอนแก่น"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 8 จังหวัดขอนแก่น",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 9 จังหวัดเชียงใหม่"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 9 จังหวัดเชียงใหม่",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 10 จังหวัดลำปาง"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 10 จังหวัดลำปาง",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 11 จังหวัดพิษณุโลก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 11 จังหวัดพิษณุโลก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 12 จังหวัดพิษณุโลก"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่12 จังหวัดพิษณุโลก",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 13 จังหวัดชัยนาท"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 13 จังหวัดชัยนาท",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 14 จังหวัดชัยนาท"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 14 จังหวัดชัยนาท",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 15 จังหวัดเพชรบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 15 จังหวัดเพชรบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 16 จังหวัดเพชรบุรี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 16 จังหวัดเพชรบุรี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 17 จังหวัดสงขลา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 17 จังหวัดสงขลา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 18 จังหวัดสงขลา"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 18 จังหวัดสงขลา",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 19 จังหวัดสุราษฎร์ธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที 19 จังหวัดสุราษฎร์ธานี",
					"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 20 จังหวัดสุราษฎร์ธานี"=>"ศูนย์ถ่ายทอดเทคโนโลยีการสหกรณ์ที่ 20 จังหวัดสุราษฎร์ธานี",
					"ศูนย์สาธิตสหกรณ์โครงการหุบกะพง"=>"ศูนย์สาธิตสหกรณ์โครงการหุบกะพง"
			
			
			
			);
			return $agency;
		}

		public function hash_passwd( $password, $random_salt = '' )
		{
		// If no salt provided for older PHP versions, make one
		if( ! is_php('5.5') && empty( $random_salt ) )
		  $random_salt = $this->random_salt();

		// PHP 5.5+ uses new password hashing function
		if( is_php('5.5') ){
		  return password_hash( $password, PASSWORD_BCRYPT, ['cost' => 11] );
		}

		// PHP < 5.5 uses crypt
		else
		{
		  return crypt( $password, '$2y$10$' . $random_salt );
		}
		}

		public function random_salt()
		{
		$this->CI->load->library('encryption');

		$salt = substr( bin2hex( $this->CI->encryption->create_key(64) ), 0, 22 );

		return strlen( $salt ) != 22 
		  ? substr( md5( mt_rand() ), 0, 22 )
		  : $salt;
		}	

		public function checkDuplicateCitizen($citizen) {

		    $this->db->where('username', $citizen);

		    $query = $this->db->get('users');

		    $count_row = $query->num_rows();

		    if ($count_row > 0) {
		      //if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
		        return FALSE; // here I change TRUE to false.
		     } else {
		      // doesn't return any row means database doesn't have this email
		        return TRUE; // And here false to TRUE
		     }
		}

		public function checkDuplicateEmail($email) {

		    $this->db->where('email', $email);

		    $query = $this->db->get('users');

		    $count_row = $query->num_rows();

		    if ($count_row > 0) {
		      //if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
		        return FALSE; // here I change TRUE to false.
		     } else {
		      // doesn't return any row means database doesn't have this email
		        return TRUE; // And here false to TRUE
		     }
		}

		public function callback_text($val, $row)
		{

			
			return "'".$val;

		        // return date('Y-m-d', strtotime($val));
		}

		public function callback_date($val, $row)
		{

			// echo print_r($val);die();
			// $test = date('Y-m-d H:i:s',time());
			$strYear = date("Y",strtotime($val))+543;
			
			// echo print_r($test);die();

			$strMonth= date("m",strtotime($val));
			$strDay= date("d",strtotime($val));
			$strHour= date("H",strtotime($val));
			$strMinute= date("i",strtotime($val));
			$strSeconds= date("s",strtotime($val));
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			// $strMonthThai=$strMonthCut[$strMonth];
			return "$strDay-$strMonth-$strYear $strHour:$strMinute:$strSeconds";

		        // return date('Y-m-d', strtotime($val));
		}
	





}