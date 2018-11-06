<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		
		$this->load->helper('form');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->library('session');
		$this->load->library('grocery_CRUD');
		$this->load->helper('properties');
		$this->load->helper('survey');
		$this->load->helper('analytic');
		$this->load->helper('log');
		
		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
		//$this->output->enable_profiler(false);
	}

	function _output($output = null)
	{
		echo $this->load->view('auth/page_header', '', TRUE);
		
		$this->load->view('table_body.php',$output);
		
		echo $this->load->view('auth/page_footer', '', TRUE);
	}
	

	public function selectSurveyYear($year)
	{
		$this->load->helper('url');
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$this->load->helper('properties');
			$years = getAllSurveyYears();
			$keys = array_keys($years);
			if (in_array($year, $keys))
			{
				setSelectedSurveyYear($year);
			}
			redirect('/', 'refresh');
		}
		else
		{
			redirect('/', 'refresh');
		}
	}	
	

	public function index()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{				
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$output = array();

			echo $this->load->view('survey_add_searchbox', $output);
			
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
			
			$citizen_id = isset($_GET['citizen_id'])?trim($_GET['citizen_id']): null;
			
			if (!canAdd())
			{
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิเพิ่มแบบสำรวจ'), TRUE);
			
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			$step = isset($_GET['step'])? $_GET['step']: "";
			if ($step=="" || $step=="0"){
				
				$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']):null;
				
				if ($step=="0" && strlen($citizen_id)!=13)
				{
					$this->session->set_userdata('error_msg',"กรุณากรอกหมายเลขบัตรประชาชนให้ถูกต้อง รูปแบบที่รองรับคือตัวเลขทั้งหมด โดยไม่มีตัวอักษรหรือช่องว่าง");
				}
				else if ($step=="0" && strlen($citizen_id)==13)
				{
					//$url = site_url("survey/add_survey")."/$citizen_id/?coop_member_id=$coop_member_id&step=1";
					//header( "location: ".$url);
					//exit(0);
				}
				
				$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
				$existing_coop_surveys = array();
				foreach($existing_member as $item)
				{
					$existing_coop_surveys[] = $item['COOPERATIVE_CODE'];
				}

				
				//if (!empty($existing_member))
				//{
				//	$url = site_url("survey/edit_survey_1")."/$citizen_id/?coop_member_id=$coop_member_id&step=1";
				//	header( "location: ".$url);
				//	exit(0);						
				//}
				
				$coop_members = getAliveMemberByCitizenID($citizen_id);
				$coops = array();
				if (!empty($coop_members))
				{
					foreach ($coop_members as $item)
					{
						$coop = getCoopByID($item['D_COOP']);

						if(!empty($coop))
							$coops[] = $coop;						
					}
				}
				
				$surveys = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
				
				echo $this->load->view('auth/page_header', '', TRUE);
				
				if (!empty($citizen_id)) {
					addLogSuspiciousMessage($citizen_id,1,"มีการเข้าถึงแบบสำรวจ");
				}
				
				$output = array(
						'citizen_id' => $citizen_id,
						'coops' => $coops,
						'existing_survey_member' => $existing_member,
						'existing_coop_surveys'	=> $existing_coop_surveys,
						'step' => $step,
						'surveys' => $surveys
				);

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

	public function add_survey_1($citizen_id)
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
			{
				redirect('survey/add_survey', 'refresh');
			}
			
			// check access
			checkSuspiciousActivityMahadthai($citizen_id, "Add Survey Step 1", getSelectedSurveyYear());
			
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
	
	public function edit_survey_1($citizen_id)
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			if(strlen($citizen_id)!=13 && !is_numeric($citizen_id))
			{
				redirect('survey/add_survey', 'refresh');
			}
			
			$year = getSelectedSurveyYear();
			if (!canView($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'ไม่มีสิทธิแก้ไขแบบสำรวจ'), TRUE);
					
				echo $this->load->view('auth/page_footer', '', TRUE);
					
				die();
			}
				
			
			// check access
			checkSuspiciousActivityMahadthai($citizen_id, "แก้ไขแบบสำรวจ", getSelectedSurveyYear());
			
			
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
	

	public function search_survey_by_id()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			
			if (strlen($citizen_id)>0 && strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			$year = getSelectedSurveyYear();
			
			/*if (!empty($citizen_id) && !canView($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิเห็นข้อมูลของสมาชิกสหกรณ์'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}*/
			
			// check access
// 			checkSuspiciousActivityMahadthai($citizen_id, "Edit Survey", getSelectedSurveyYear());
			
			$existing_surveys = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
			
			if (!empty($existing_surveys))
			{
				$output = array(
						'citizen_id' => $citizen_id,
						'year' => $year,
						'surveys' => $existing_surveys
				);

				echo $this->load->view('survey_search', $output, TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			//$output = array(
			//		'message'=>'ไม่พบแบบสอบถามตามหมายเลขบัตรประชาชน');
			
			//echo $this->load->view('survey_error', $output, TRUE);
			
			$output = array(
					'citizen_id' => $citizen_id,
					'year' => $year,
					'surveys' => null
			);
			
			echo $this->load->view('survey_search', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
			
			die();
		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	
	public function search_survey_by_name()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$coop_membername = isset($_GET['coop_membername'])? trim($_GET['coop_membername']): "";
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			if ($range > 1000) $range = 1000;
			
			if (strlen($coop_membername)>0 && strlen($coop_membername) < 3)
			{
				echo $this->load->view('survey_error', array('message'=>'กรุณากรอกคำค้นหามากกว่า 2 ตัวอักษร'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			$year = getSelectedSurveyYear();
			
			if (empty($coop_membername))
			{
				$output = array(
						'keyword' => '',
						'year' => $year,
						'current_page' => $page,
						'range' => $range,
						'total_number' => 0,
						'surveys' => null,
						'coop_membername' => ''
				);
				
				echo $this->load->view('survey_search_by_name', $output, TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
				
			}
			
			
			$total_number = countSurveyRecordByCitizenNameYear($coop_membername, $year);
			$sql = $this->db->last_query();
			
			
			$existing_surveys = getSurveyRecordByCitizenNameYear($coop_membername ,$year, $page, $range);
			
			$sql = $this->db->last_query();
		
			
			
			if (!empty($existing_surveys))
			{
				$output = array(
						'keyword' => htmlspecialchars($coop_membername),
						'year' => $year,
						'current_page' => $page,
						'range' => $range,
						'total_number' => $total_number,
						'surveys' => $existing_surveys,
						'coop_membername' => $coop_membername
				);
				
				echo $this->load->view('survey_search_by_name', $output, TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			$output = array(
					'message'=>'ไม่พบแบบสอบถาม',
					'total_number'=>0,
					'coop_membername' => $coop_membername
			);
			
			echo $this->load->view('survey_search_by_name', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
			
			die();
		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	
	
	public function view_survey()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);
	
			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']): "";
			$coop_id = isset($_GET['coop'])? trim($_GET['coop']): "";
			if (!empty($coop_member_id))
			{
				$member = getSurveyRecordByMemberIDSelectedYear($coop_member_id);
				if(sizeof($member)>0)
				$citizen_id = $member['citizen_id'];
			}
			
			if (strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{				
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();				
			}
			
			// check access
			checkSuspiciousActivityMahadthai($citizen_id, "ดูแบบสำรวจ", getSelectedSurveyYear());
			
			$year = getSelectedSurveyYear();
			if (!canView($citizen_id,$year) && !canViewReport())
			{
				echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิเห็นข้อมูลของสมาชิกสหกรณ์'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			$default_data = array(
					
			);
			
			
			$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
			$existing_coop_surveys = array();
			foreach($existing_member as $item)
			{
				$existing_coop_surveys[] = $item['COOPERATIVE_CODE'];
			}
			
			$getdata =null;
			$coop_id_array = array();
			$this->load->model('grocery_crud_model');
			foreach ($existing_coop_surveys as $coop_id_data)
			{
				$crud = new grocery_CRUD();
				$getdata_query = $this->grocery_crud_model->gettheSurvey($citizen_id, $coop_id_data);
				
				if(is_null($getdata))
				{
					$getdata = $getdata_query;
					$coop_id_array[] = $coop_id_data;
				}else if(!empty($getdata_query)){
					$coop_id_array[] = $coop_id_data;
				}
			}
			
			$list_data_citizen = array();
			if(isset($getdata[0])) {
				$list_data_citizen = $getdata[0];
			}
			
			if (!empty($existing_member))
			{
				$default_data = array();
				$data_getAllprovinces = getAllProvinces();
				$data_farmer_one = array();
				$already_have_data_in_farmer1 = !empty($data_farmer_one)? true: false;
				$coop = null;
				$data_mahadthai = array();
				// load data from MAHADTHAI and check if information is there
				$data_mahadthai = getMahadthaiByCitizenID($citizen_id);
				$output = array(
						'default_data' => $default_data,
						'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
						'citizen_id' => $citizen_id,
						'mahadthai' => $data_mahadthai,
						'coop' => $coop,
						'data_farmer_one' => $data_farmer_one,
						'data_getAllprovinces'=>$data_getAllprovinces,
						'user_survey_data'=>$list_data_citizen,
						'list_array'=>$coop_id_array
				);
				
				
// 				$data = $this->dbtojson($existing_member);
// 				$output = array(
// 					'citizen_id' => $citizen_id, 
// 					'year' => $year,
// 						'coop'=>$coop_id,
// 						'survey' => $data,
// 						'survey_array' => $existing_member
// 				);
				
				echo $this->load->view('view_survey', $output, TRUE);
// 				echo $this->load->view('survey_view', $output, TRUE);
				
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
	
	
	public function delete_survey()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']): "";
			$coop_id = isset($_GET['coop'])? trim($_GET['coop']): "";
			if (!empty($coop_member_id))
			{
				$member = getSurveyRecordByMemberIDSelectedYear($coop_member_id);
				if(sizeof($member)>0)
					$citizen_id = $member['citizen_id'];
			}

			if (!is_numeric($coop_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขสหกรณ์ไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			if (strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);
	
				echo $this->load->view('auth/page_footer', '', TRUE);
	
				die();
			}
				
			// check access
			checkSuspiciousActivityMahadthai($citizen_id, "Delete Survey", getSelectedSurveyYear());
				
			$year = getSelectedSurveyYear();
			if (!canDelete($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิลบข้อมูลแบบสอบถามของสมาชิกสหกรณ์'), TRUE);
	
				echo $this->load->view('auth/page_footer', '', TRUE);
	
				die();
			}
	
			$this->db->where('citizen_id', $citizen_id);
			$this->db->where('COOPERATIVE_CODE', $coop_id);			
			$this->db->delete(getSurveyYearDbTable(getSelectedSurveyYear()));
			
			redirect('/', 'refresh');
		}
		else
		{
			redirect('/', 'refresh');
		}
	}
	
	public function view_list_survey ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$this->load->view('auth/page_header', '');
// 			echo "test";
			$this->load->view('auth/page_footer', '');
		}
	}
	
	public function view_survey_by_name()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			echo $this->load->view('auth/page_header', '', TRUE);
	
			$citizen_id = isset($_GET['coop_membername'])? trim($_GET['coop_membername']): "";
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
	
				echo $this->load->view('list_survey_by_name', $output, TRUE);
	
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
	
	function dbtojson($output)
	{
		//$data_obj = json_decode('{"citizen_id":"\u0e40\u0e25\u0e02\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","coop_member_id":"\u0e23\u0e2b\u0e31\u0e2a\u0e2a\u0e21\u0e32\u0e0a\u0e34\u0e01\u0e2a\u0e2b\u0e01\u0e23\u0e13\u0e4c\r\n","citizen_firstname":"\u0e0a\u0e37\u0e48\u0e2d\u0e15\u0e32\u0e21\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","citizen_lastname":"\u0e19\u0e32\u0e21\u0e2a\u0e01\u0e38\u0e25\u0e15\u0e32\u0e21\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","citizen_birthdate":"\u0e27\u0e31\u0e19\u0e40\u0e14\u0e37\u0e2d\u0e19\u0e1b\u0e35\u0e40\u0e01\u0e34\u0e14\r\n","citizen_address1":"\u0e17\u0e35\u0e48\u0e2d\u0e22\u0e39\u0e48 1\r\n","citizen_address2":"\u0e17\u0e35\u0e48\u0e2d\u0e22\u0e39\u0e48 2\r\n","citizen_city":"\u0e40\u0e21\u0e37\u0e2d\u0e07\r\n","citizen_zipcode":"\u0e23\u0e2b\u0e31\u0e2a\u0e44\u0e1b\u0e23\u0e29\u0e13\u0e35\u0e22\u0e4c\r\n","citizen_already_in_f1":"\u0e21\u0e35\u0e02\u0e49\u0e2d\u0e21\u0e39\u0e25\u0e43\u0e19 F1 \u0e2b\u0e23\u0e37\u0e2d\u0e44\u0e21\u0e48\r\n","created_at":"\u0e27\u0e31\u0e19\u0e17\u0e35\u0e48\u0e2a\u0e23\u0e49\u0e32\u0e07\r\n","modified_at":"\u0e41\u0e01\u0e49\u0e44\u0e02\u0e40\u0e21\u0e37\u0e48\u0e2d\r\n","created_by":"\u0e2a\u0e23\u0e49\u0e32\u0e07\u0e42\u0e14\u0e22\r\n","modified_by":"\u0e41\u0e01\u0e49\u0e44\u0e02\u0e42\u0e14\u0e22\r\n","household_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e04\u0e23\u0e31\u0e27\u0e40\u0e23\u0e37\u0e2d\u0e19\r\n","family_status":"\u0e2a\u0e16\u0e32\u0e19\u0e30\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e31\u0e27\r\n","family_status_others":"\u0e23\u0e30\u0e1a\u0e38\u0e40\u0e2b\u0e15\u0e38\u0e1c\u0e25\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","house_no":"\u0e1a\u0e49\u0e32\u0e19\u0e40\u0e25\u0e02\u0e17\u0e35\u0e48\r\n","village_no":"\u0e2b\u0e21\u0e39\u0e48\u0e17\u0e35\u0e48\r\n","province_id":"Id \u0e08\u0e31\u0e07\u0e2b\u0e27\u0e31\u0e14\r\n","district_id":"Id \u0e2d\u0e33\u0e40\u0e20\u0e2d\r\n","sub_district_id":"Id \u0e15\u0e33\u0e1a\u0e25\r\n","province_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e08\u0e31\u0e07\u0e2b\u0e27\u0e31\u0e14\r\n","district_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e2d\u0e33\u0e40\u0e20\u0e2d\r\n","sub_district_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e15\u0e33\u0e1a\u0e25\r\n","home_phone_no":"\u0e40\u0e1a\u0e2d\u0e23\u0e4c\u0e1a\u0e49\u0e32\u0e19\r\n","cell_phone":"\u0e40\u0e1a\u0e2d\u0e23\u0e4c\u0e21\u0e37\u0e2d\u0e16\u0e37\u0e2d\r\n","org_type":"\u0e1b\u0e23\u0e30\u0e40\u0e20\u0e17\u0e2d\u0e07\u0e04\u0e4c\u0e01\u0e23\u0e13\u0e4c\r\n","farmer_group_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e01\u0e25\u0e38\u0e48\u0e21\u0e40\u0e01\u0e29\u0e15\u0e23\u0e01\u0e23\r\n","joining_date":"\u0e27\u0e31\u0e19\u0e17\u0e35\u0e48\u0e40\u0e02\u0e49\u0e32\u0e23\u0e48\u0e27\u0e21\r\n","province_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e08\u0e31\u0e07\u0e2b\u0e27\u0e31\u0e14\r\n","cooperative_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e2a\u0e2b\u0e01\u0e23\u0e13\u0e4c\r\n","budget_year":"\u0e1b\u0e35\u0e07\u0e1a\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\r\n","survey_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e41\u0e1a\u0e1a\u0e2a\u0e2d\u0e1a\u0e16\u0e32\u0e21\r\n","education_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e01\u0e32\u0e23\u0e28\u0e36\u0e01\u0e29\u0e32\r\n","stock_register":"\u0e17\u0e30\u0e40\u0e1a\u0e35\u0e22\u0e19\u0e2b\u0e38\u0e49\u0e19\r\n","shares_num":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2b\u0e38\u0e49\u0e19\r\n","land_holding_rai":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e44\u0e23\u0e48)\r\n","land_holding_ngan":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e07\u0e32\u0e19)\r\n","land_holding_squarewa":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","water_type":"\u0e1b\u0e23\u0e30\u0e40\u0e20\u0e17\u0e19\u0e49\u0e33\r\n","water_holding_rai":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e44\u0e23\u0e48)\r\n","water_holding_ngan":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e07\u0e32\u0e19)\r\n","water_holding_squarewa":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","water_type_others":"\u0e40\u0e2b\u0e15\u0e38\u0e1c\u0e25\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab2_area_rai":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e44\u0e23\u0e48)\r\n","tab2_area_ngan":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e07\u0e32\u0e19)\r\n","tab2_area_squarewa":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","obligation_land":"\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e20\u0e32\u0e23\u0e30\u0e1c\u0e39\u0e01\u0e1e\u0e31\u0e19\r\n","land_other_reason":"\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","farm_equ":"\u0e40\u0e04\u0e23\u0e37\u0e48\u0e2d\u0e07\u0e21\u0e37\u0e2d\/\u0e2d\u0e38\u0e1b\u0e01\u0e23\u0e13\u0e4c\u0e17\u0e33\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\r\n","plant_type":"\u0e0a\u0e19\u0e34\u0e14\u0e1e\u0e37\u0e0a \r\n","plant_specie":"\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01\r\n","planting_num_per_year":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e04\u0e23\u0e31\u0e49\u0e07\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01\u0e15\u0e48\u0e2d\u0e1b\u0e35\r\n","growing_area":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01 (\u0e44\u0e23\u0e48)\r\n","product_num_per_year":"\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35 (\u0e15\u0e31\u0e19)\r\n","area_rai":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e44\u0e23\u0e48)\r\n","area_ngan":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e07\u0e32\u0e19)\r\n","area_squarewa":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","estsales_revenueyear":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49 \u0e02\u0e32\u0e22 \u0e1c\u0e25\u0e34\u0e15\u0e15\u0e48\u0e2d\u0e1b\u0e35(\u0e1a\u0e32\u0e17)\r\n","estagri_incomeyear":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23(\u0e1a\u0e32\u0e17)\r\n","how2sell":"\u0e27\u0e34\u0e18\u0e35\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\r\n","how2sell_others_reason":"\u0e27\u0e34\u0e18\u0e35\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","product_sale_comment":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e17\u0e35\u0e48\u0e1e\u0e1a\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\r\n","product_sale_other":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\r\n","product_sale_comment2":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","product_sale_other2":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e152\r\n","chm1_46_0_0":"\u0e1b\u0e38\u0e4b\u0e22\u0e2a\u0e39\u0e15\u0e23 46 - 0 - 0  \r\n","chm2_15_15_15":"\u0e2a\u0e39\u0e15\u0e23 15 - 15 - 15 \r\n","chm3_16_20_0":"\u0e2a\u0e39\u0e15\u0e23 16 - 20 - 0","chm4_other":"\u0e1b\u0e48\u0e38\u0e48\u0e22\u0e2d\u0e37\u0e48\u0e19\u0e46\u0e08\u0e33\u0e19\u0e27\u0e19\r\n","chm2_intr":"\u0e1b\u0e38\u0e49\u0e22\u0e2d\u0e34\u0e19\u0e17\u0e23\u0e35\u0e22\u0e4c\r\n","chm1_water":"\u0e22\u0e32\u0e1b\u0e23\u0e32\u0e1a\u0e28\u0e4d\u0e15\u0e23\u0e39\u0e1e\u0e37\u0e0a\u0e0a\u0e19\u0e34\u0e14\u0e19\u0e49\u0e33\r\n","chm2_c_c_c":"\u0e22\u0e32\u0e1b\u0e23\u0e32\u0e1a\u0e28\u0e31\u0e15\u0e23\u0e39\u0e1e\u0e37\u0e0a\u0e0a\u0e19\u0e34\u0e14\u0e40\u0e21\u0e47\u0e14\/\u0e1c\u0e07\r\n","ani_type":"\u0e0a\u0e19\u0e34\u0e14\u0e2a\u0e31\u0e15\u0e27\u0e4c\r\n","ani_specie":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2a\u0e31\u0e15\u0e27\u0e4c(\u0e15\u0e31\u0e27)\r\n","ani_num_per_year":"\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35|\u0e01\u0e48\u0e2d\u0e19\u0e2b\u0e31\u0e01\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22|(\u0e1a\u0e32\u0e17)\r\n","ani_growing_area":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13|\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23|(\u0e1a\u0e32\u0e17)\r\n","ani_product_numyear":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e2a\u0e31\u0e15\u0e27\u0e4c (\u0e01\u0e01.)\r\n","ani_area_rai":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e40\u0e2a\u0e23\u0e34\u0e21|(\u0e25\u0e34\u0e15\u0e23\/\u0e01\u0e01.)\r\n","ani2_type":"\u0e0a\u0e19\u0e34\u0e14\u0e2a\u0e31\u0e15\u0e27\u0e4c\u0e19\u0e49\u0e33\r\n","ani2_specie":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2a\u0e31\u0e15\u0e27\u0e4c\r\n","ani2_plant_numyear":"\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35|\u0e01\u0e48\u0e2d\u0e19\u0e2b\u0e31\u0e01\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22|(\u0e1a\u0e32\u0e17)\r\n","ani2_growing_area":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13|\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23|(\u0e1a\u0e32\u0e17)\r\n","ani2_productyear":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e2a\u0e31\u0e15\u0e27\u0e4c (\u0e01\u0e01.)\r\n","ani2_area_rai":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e40\u0e2a\u0e23\u0e34\u0e21|(\u0e25\u0e34\u0e15\u0e23\/\u0e01\u0e01.)\r\n","tab5_a1":".\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e14\u0e49\u0e32\u0e19\u0e01\u0e32\u0e23\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e40\u0e1e\u0e37\u0e48\u0e2d\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\r\n","tab5_a1_problem":".\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e14\u0e49\u0e32\u0e19\u0e01\u0e32\u0e23\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e40\u0e1e\u0e37\u0e48\u0e2d\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_a2":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33\r\n","tab5_a2_problem":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_a3":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e40\u0e21\u0e25\u0e47\u0e14\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c|\u0e15\u0e49\u0e19\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c\r\n","tab5_a4":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32 \u0e1b\u0e38\u0e49\u0e22|\u0e22\u0e32|\u0e2a\u0e32\u0e23\u0e40\u0e04\u0e21\u0e35\r\n","tab5_a5":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49\u0e40\u0e17\u0e04\u0e42\u0e19\u0e42\u0e25\u0e22\u0e35\r\n","tab5_a6":"\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 \u0e41\u0e19\u0e27\u0e42\u0e19\u0e49\u0e21\u0e04\u0e27\u0e32\u0e21\u0e15\u0e49\u0e2d\u0e07\u0e01\u0e32\u0e23\u0e02\u0e2d\u0e07\u0e15\u0e25\u0e32\u0e14 \u0e19\u0e42\u0e22\u0e1a\u0e32\u0e22\u0e01\u0e32\u0e23\u0e2a\u0e48\u0e07\u0e40\u0e2a\u0e23\u0e34\u0e21\u0e02\u0e2d\u0e07\u0e20\u0e32\u0e04\u0e23\u0e31\u0e10\r\n","tab5_a6_other":"\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 \u0e41\u0e19\u0e27\u0e42\u0e19\u0e49\u0e21\u0e04\u0e27\u0e32\u0e21\u0e15\u0e49\u0e2d\u0e07\u0e01\u0e32\u0e23\u0e02\u0e2d\u0e07\u0e15\u0e25\u0e32\u0e14 \u0e19\u0e42\u0e22\u0e1a\u0e32\u0e22\u0e01\u0e32\u0e23\u0e2a\u0e48\u0e07\u0e40\u0e2a\u0e23\u0e34\u0e21\u0e02\u0e2d\u0e07\u0e20\u0e32\u0e04\u0e23\u0e31\u0e10\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab4_b6":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e15\u0e25\u0e32\u0e14\u0e23\u0e31\u0e1a\u0e0b\u0e37\u0e49\u0e2d\r\n","tab4_b6_other":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e15\u0e25\u0e32\u0e14\u0e23\u0e31\u0e1a\u0e0b\u0e37\u0e49\u0e2d\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_debt_num":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\r\n","tab5_debt_num_coop":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e2a\u0e2b\u0e01\u0e23\u0e13\u0e4c\/\u0e01\u0e25\u0e38\u0e48\u0e21\u0e40\u0e01\u0e29\u0e15\u0e23\u0e01\u0e23\r\n","tab5_debt_num_baac":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e18\u0e01\u0e2a.\r\n","tab5_debt_num_b_others":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e18\u0e19\u0e32\u0e04\u0e32\u0e23\u0e2d\u0e37\u0e48\u0e19\r\n","tab5_debt_num_housing_fund":"\u0e01\u0e2d\u0e07\u0e17\u0e38\u0e19\u0e2b\u0e21\u0e39\u0e48\u0e1a\u0e49\u0e32\u0e19\r\n","":null}');
		$data_obj = json_decode('{"citizen_id":"\u0e40\u0e25\u0e02\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","citizen_firstname":"\u0e0a\u0e37\u0e48\u0e2d\u0e15\u0e32\u0e21\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","citizen_lastname":"\u0e19\u0e32\u0e21\u0e2a\u0e01\u0e38\u0e25\u0e15\u0e32\u0e21\u0e1a\u0e31\u0e15\u0e23\u0e1b\u0e23\u0e30\u0e0a\u0e32\u0e0a\u0e19\r\n","citizen_birthdate":"\u0e27\u0e31\u0e19\u0e40\u0e14\u0e37\u0e2d\u0e19\u0e1b\u0e35\u0e40\u0e01\u0e34\u0e14\r\n","citizen_address1":"\u0e17\u0e35\u0e48\u0e2d\u0e22\u0e39\u0e48 1\r\n","citizen_address2":"\u0e17\u0e35\u0e48\u0e2d\u0e22\u0e39\u0e48 2\r\n","citizen_city":"\u0e40\u0e21\u0e37\u0e2d\u0e07\r\n","citizen_zipcode":"\u0e23\u0e2b\u0e31\u0e2a\u0e44\u0e1b\u0e23\u0e29\u0e13\u0e35\u0e22\u0e4c\r\n","citizen_already_in_f1":"\u0e21\u0e35\u0e02\u0e49\u0e2d\u0e21\u0e39\u0e25\u0e43\u0e19 F1 \u0e2b\u0e23\u0e37\u0e2d\u0e44\u0e21\u0e48\r\n","created_at":"\u0e27\u0e31\u0e19\u0e17\u0e35\u0e48\u0e2a\u0e23\u0e49\u0e32\u0e07\r\n","modified_at":"\u0e41\u0e01\u0e49\u0e44\u0e02\u0e40\u0e21\u0e37\u0e48\u0e2d\r\n","created_by":"\u0e2a\u0e23\u0e49\u0e32\u0e07\u0e42\u0e14\u0e22\r\n","modified_by":"\u0e41\u0e01\u0e49\u0e44\u0e02\u0e42\u0e14\u0e22\r\n","household_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e04\u0e23\u0e31\u0e27\u0e40\u0e23\u0e37\u0e2d\u0e19\r\n","family_status":"\u0e2a\u0e16\u0e32\u0e19\u0e30\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e31\u0e27\r\n","family_status_others":"\u0e23\u0e30\u0e1a\u0e38\u0e40\u0e2b\u0e15\u0e38\u0e1c\u0e25\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","house_no":"\u0e1a\u0e49\u0e32\u0e19\u0e40\u0e25\u0e02\u0e17\u0e35\u0e48\r\n","village_no":"\u0e2b\u0e21\u0e39\u0e48\u0e17\u0e35\u0e48\r\n","province_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e08\u0e31\u0e07\u0e2b\u0e27\u0e31\u0e14\r\n","district_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e2d\u0e33\u0e40\u0e20\u0e2d\r\n","sub_district_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e15\u0e33\u0e1a\u0e25\r\n","home_phone_no":"\u0e40\u0e1a\u0e2d\u0e23\u0e4c\u0e1a\u0e49\u0e32\u0e19\r\n","cell_phone":"\u0e40\u0e1a\u0e2d\u0e23\u0e4c\u0e21\u0e37\u0e2d\u0e16\u0e37\u0e2d\r\n","org_type":"\u0e1b\u0e23\u0e30\u0e40\u0e20\u0e17\u0e2d\u0e07\u0e04\u0e4c\u0e01\u0e23\u0e13\u0e4c\r\n","farmer_group_name":"\u0e0a\u0e37\u0e48\u0e2d\u0e01\u0e25\u0e38\u0e48\u0e21\u0e40\u0e01\u0e29\u0e15\u0e23\u0e01\u0e23\r\n","joining_date":"\u0e27\u0e31\u0e19\u0e17\u0e35\u0e48\u0e40\u0e02\u0e49\u0e32\u0e23\u0e48\u0e27\u0e21\r\n","province_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e08\u0e31\u0e07\u0e2b\u0e27\u0e31\u0e14\r\n","cooperative_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e2a\u0e2b\u0e01\u0e23\u0e13\u0e4c\r\n","budget_year":"\u0e1b\u0e35\u0e07\u0e1a\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\r\n","survey_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e41\u0e1a\u0e1a\u0e2a\u0e2d\u0e1a\u0e16\u0e32\u0e21\r\n","education_code":"\u0e23\u0e2b\u0e31\u0e2a\u0e01\u0e32\u0e23\u0e28\u0e36\u0e01\u0e29\u0e32\r\n","stock_register":"\u0e17\u0e30\u0e40\u0e1a\u0e35\u0e22\u0e19\u0e2b\u0e38\u0e49\u0e19\r\n","shares_num":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2b\u0e38\u0e49\u0e19\r\n","land_holding_rai":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e44\u0e23\u0e48)\r\n","land_holding_ngan":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e07\u0e32\u0e19)\r\n","land_holding_squarewa":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","water_type":"\u0e1b\u0e23\u0e30\u0e40\u0e20\u0e17\u0e19\u0e49\u0e33\r\n","water_holding_rai":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e44\u0e23\u0e48)\r\n","water_holding_ngan":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e07\u0e32\u0e19)\r\n","water_holding_squarewa":"\u0e04\u0e23\u0e2d\u0e1a\u0e04\u0e23\u0e2d\u0e07\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","water_type_others":"\u0e40\u0e2b\u0e15\u0e38\u0e1c\u0e25\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab2_area_rai":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e44\u0e23\u0e48)\r\n","tab2_area_ngan":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e07\u0e32\u0e19)\r\n","tab2_area_squarewa":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48(\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","obligation_land":"\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e20\u0e32\u0e23\u0e30\u0e1c\u0e39\u0e01\u0e1e\u0e31\u0e19\r\n","land_other_reason":"\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","farm_equ":"\u0e40\u0e04\u0e23\u0e37\u0e48\u0e2d\u0e07\u0e21\u0e37\u0e2d\/\u0e2d\u0e38\u0e1b\u0e01\u0e23\u0e13\u0e4c\u0e17\u0e33\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\r\n","plant_type":"\u0e0a\u0e19\u0e34\u0e14\u0e1e\u0e37\u0e0a \r\n","plant_specie":"\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01\r\n","planting_num_per_year":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e04\u0e23\u0e31\u0e49\u0e07\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01\u0e15\u0e48\u0e2d\u0e1b\u0e35\r\n","growing_area":"\u0e1e\u0e37\u0e49\u0e19\u0e17\u0e35\u0e48\u0e1b\u0e25\u0e39\u0e01 (\u0e44\u0e23\u0e48)\r\n","product_num_per_year":"\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35 (\u0e15\u0e31\u0e19)\r\n","area_rai":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e44\u0e23\u0e48)\r\n","area_ngan":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e07\u0e32\u0e19)\r\n","area_squarewa":"\u0e23\u0e27\u0e21\u0e1e\u0e37\u0e0a (\u0e01\u0e35\u0e48\u0e15\u0e32\u0e23\u0e32\u0e07\u0e27\u0e32)\r\n","estsales_revenueyear":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49 \u0e02\u0e32\u0e22 \u0e1c\u0e25\u0e34\u0e15\u0e15\u0e48\u0e2d\u0e1b\u0e35(\u0e1a\u0e32\u0e17)\r\n","estagri_incomeyear":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23(\u0e1a\u0e32\u0e17)\r\n","how2sell":"\u0e27\u0e34\u0e18\u0e35\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\r\n","how2sell_others_reason":"\u0e27\u0e34\u0e18\u0e35\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","product_sale_comment":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e17\u0e35\u0e48\u0e1e\u0e1a\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\r\n","product_sale_other":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\r\n","product_sale_comment2":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e15\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","product_sale_other2":"\u0e04\u0e27\u0e32\u0e21\u0e04\u0e34\u0e14\u0e40\u0e2b\u0e47\u0e19\u0e43\u0e19\u0e01\u0e32\u0e23\u0e02\u0e32\u0e22\u0e1c\u0e25\u0e1c\u0e25\u0e34\u0e152\r\n","chm1_46_0_0":"\u0e1b\u0e38\u0e4b\u0e22\u0e2a\u0e39\u0e15\u0e23 46 - 0 - 0  \r\n","chm2_15_15_15":"\u0e2a\u0e39\u0e15\u0e23 15 - 15 - 15 \r\n","chm3_16_20_0":"\u0e2a\u0e39\u0e15\u0e23 16 - 20 - 0","chm4_other":"\u0e1b\u0e48\u0e38\u0e48\u0e22\u0e2d\u0e37\u0e48\u0e19\u0e46\u0e08\u0e33\u0e19\u0e27\u0e19\r\n","chm2_intr":"\u0e1b\u0e38\u0e49\u0e22\u0e2d\u0e34\u0e19\u0e17\u0e23\u0e35\u0e22\u0e4c\r\n","chm1_water":"\u0e22\u0e32\u0e1b\u0e23\u0e32\u0e1a\u0e28\u0e4d\u0e15\u0e23\u0e39\u0e1e\u0e37\u0e0a\u0e0a\u0e19\u0e34\u0e14\u0e19\u0e49\u0e33\r\n","chm2_c_c_c":"\u0e22\u0e32\u0e1b\u0e23\u0e32\u0e1a\u0e28\u0e31\u0e15\u0e23\u0e39\u0e1e\u0e37\u0e0a\u0e0a\u0e19\u0e34\u0e14\u0e40\u0e21\u0e47\u0e14\/\u0e1c\u0e07\r\n","ani_type":"\u0e0a\u0e19\u0e34\u0e14\u0e2a\u0e31\u0e15\u0e27\u0e4c\r\n","ani_specie":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2a\u0e31\u0e15\u0e27\u0e4c(\u0e15\u0e31\u0e27)\r\n","ani_num_per_year":"\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35|\u0e01\u0e48\u0e2d\u0e19\u0e2b\u0e31\u0e01\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22|(\u0e1a\u0e32\u0e17)\r\n","ani_growing_area":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13|\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23|(\u0e1a\u0e32\u0e17)\r\n","ani_product_numyear":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e2a\u0e31\u0e15\u0e27\u0e4c (\u0e01\u0e01.)\r\n","ani_area_rai":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e40\u0e2a\u0e23\u0e34\u0e21|(\u0e25\u0e34\u0e15\u0e23\/\u0e01\u0e01.)\r\n","ani2_type":"\u0e0a\u0e19\u0e34\u0e14\u0e2a\u0e31\u0e15\u0e27\u0e4c\u0e19\u0e49\u0e33\r\n","ani2_specie":"\u0e08\u0e33\u0e19\u0e27\u0e19\u0e2a\u0e31\u0e15\u0e27\u0e4c\r\n","ani2_plant_numyear":"\u0e23\u0e32\u0e22\u0e44\u0e14\u0e49\u0e15\u0e48\u0e2d\u0e1b\u0e35|\u0e01\u0e48\u0e2d\u0e19\u0e2b\u0e31\u0e01\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22|(\u0e1a\u0e32\u0e17)\r\n","ani2_growing_area":"\u0e1b\u0e23\u0e30\u0e21\u0e32\u0e13|\u0e04\u0e48\u0e32\u0e43\u0e0a\u0e49\u0e08\u0e48\u0e32\u0e22\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23|(\u0e1a\u0e32\u0e17)\r\n","ani2_productyear":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e2a\u0e31\u0e15\u0e27\u0e4c (\u0e01\u0e01.)\r\n","ani2_area_rai":"\u0e2d\u0e32\u0e2b\u0e32\u0e23\u0e40\u0e2a\u0e23\u0e34\u0e21|(\u0e25\u0e34\u0e15\u0e23\/\u0e01\u0e01.)\r\n","tab5_a1":".\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e14\u0e49\u0e32\u0e19\u0e01\u0e32\u0e23\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e40\u0e1e\u0e37\u0e48\u0e2d\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\r\n","tab5_a1_problem":".\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e14\u0e49\u0e32\u0e19\u0e01\u0e32\u0e23\u0e1c\u0e25\u0e34\u0e15\u0e17\u0e35\u0e48\u0e14\u0e34\u0e19\u0e40\u0e1e\u0e37\u0e48\u0e2d\u0e01\u0e32\u0e23\u0e40\u0e01\u0e29\u0e15\u0e23\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_a2":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33\r\n","tab5_a2_problem":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e41\u0e2b\u0e25\u0e48\u0e07\u0e19\u0e49\u0e33\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_a3":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e40\u0e21\u0e25\u0e47\u0e14\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c|\u0e15\u0e49\u0e19\u0e1e\u0e31\u0e19\u0e18\u0e38\u0e4c\r\n","tab5_a4":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32 \u0e1b\u0e38\u0e49\u0e22|\u0e22\u0e32|\u0e2a\u0e32\u0e23\u0e40\u0e04\u0e21\u0e35\r\n","tab5_a5":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49\u0e40\u0e17\u0e04\u0e42\u0e19\u0e42\u0e25\u0e22\u0e35\r\n","tab5_a6":"\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 \u0e41\u0e19\u0e27\u0e42\u0e19\u0e49\u0e21\u0e04\u0e27\u0e32\u0e21\u0e15\u0e49\u0e2d\u0e07\u0e01\u0e32\u0e23\u0e02\u0e2d\u0e07\u0e15\u0e25\u0e32\u0e14 \u0e19\u0e42\u0e22\u0e1a\u0e32\u0e22\u0e01\u0e32\u0e23\u0e2a\u0e48\u0e07\u0e40\u0e2a\u0e23\u0e34\u0e21\u0e02\u0e2d\u0e07\u0e20\u0e32\u0e04\u0e23\u0e31\u0e10\r\n","tab5_a6_other":"\u0e04\u0e27\u0e32\u0e21\u0e23\u0e39\u0e49 \u0e41\u0e19\u0e27\u0e42\u0e19\u0e49\u0e21\u0e04\u0e27\u0e32\u0e21\u0e15\u0e49\u0e2d\u0e07\u0e01\u0e32\u0e23\u0e02\u0e2d\u0e07\u0e15\u0e25\u0e32\u0e14 \u0e19\u0e42\u0e22\u0e1a\u0e32\u0e22\u0e01\u0e32\u0e23\u0e2a\u0e48\u0e07\u0e40\u0e2a\u0e23\u0e34\u0e21\u0e02\u0e2d\u0e07\u0e20\u0e32\u0e04\u0e23\u0e31\u0e10\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab4_b6":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e15\u0e25\u0e32\u0e14\u0e23\u0e31\u0e1a\u0e0b\u0e37\u0e49\u0e2d\r\n","tab4_b6_other":"\u0e1b\u0e31\u0e0d\u0e2b\u0e32\u0e15\u0e25\u0e32\u0e14\u0e23\u0e31\u0e1a\u0e0b\u0e37\u0e49\u0e2d\u0e2d\u0e37\u0e48\u0e19\u0e46\r\n","tab5_debt_num":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\r\n","tab5_debt_num_coop":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e2a\u0e2b\u0e01\u0e23\u0e13\u0e4c\/\u0e01\u0e25\u0e38\u0e48\u0e21\u0e40\u0e01\u0e29\u0e15\u0e23\u0e01\u0e23\r\n","tab5_debt_num_baac":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e18\u0e01\u0e2a.\r\n","tab5_debt_num_b_others":"\u0e40\u0e08\u0e49\u0e32\u0e2b\u0e19\u0e35\u0e49\u0e18\u0e19\u0e32\u0e04\u0e32\u0e23\u0e2d\u0e37\u0e48\u0e19\r\n","tab5_debt_num_housing_fund":"\u0e01\u0e2d\u0e07\u0e17\u0e38\u0e19\u0e2b\u0e21\u0e39\u0e48\u0e1a\u0e49\u0e32\u0e19\r\n","":null}');
		$list_data_get_from_database = array();
		
		$data_field = array("citizen_city");
		
		foreach ($output as $data){
			foreach ($data as $k=>$value)
			{
				if(!empty($data_obj->{strtolower($k)}))
				{
					
					$data_field[] = array(
							'key'=>$k,
							'label'=>$data_obj->{strtolower($k)},
							'value'=>$this->addlabel($value)
					);
				}
			}
		}
		return $data_field;
		
	}
	
	function addlabel($value)
	{
		$data = is_serialized($value);
		if($data)
		{
			return unserialize($value);
			
		}else{
			return $value;
		}
	}
	
	public function exportSurveyToPDF()
	{
		$citizen_id = $this->input->get("citizen_id");
		$coop		= $this->input->get("coop");
		$year 		= $this->input->get("year");
		
		if (!canView($citizen_id,$year))
		{
			echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิเห็นข้อมูลของสมาชิกสหกรณ์'), TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
			
			die();
		}
		$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
		if (!empty($existing_member))
		{
			$data = $this->dbtojson($existing_member);
			$output = array(
					'citizen_id' => $citizen_id,
					'year' => $year,
					'survey' => $data
			);
			
			$html =  $this->load->view('survey_detail', $output, TRUE);
			
			
// 			$this->exportPDF($html);
		}
		
	}
	//TODO for progress bar
	public function ajax_search_view_survery ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
			
			
			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			$coop_member_id = isset($_GET['coop_member_id'])? trim($_GET['coop_member_id']): "";
			$coop_id = isset($_GET['coop'])? trim($_GET['coop']): "";
			
			
			if (!empty($coop_member_id))
			{
				$member = getSurveyRecordByMemberIDSelectedYear($coop_member_id);
				if(sizeof($member)>0)
					$citizen_id = $member['citizen_id'];
			}
			
			if (strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			
			// check access
			checkSuspiciousActivityMahadthai($citizen_id, "ดูแบบสำรวจ", getSelectedSurveyYear());
			
			$year = getSelectedSurveyYear();
			if (!canView($citizen_id,$year))
			{
				echo $this->load->view('survey_error', array('message'=>'คุณไม่มีสิทธิเห็นข้อมูลของสมาชิกสหกรณ์'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}
			$default_data = array(
					
			);
			
			
			$existing_member = getSurveyRecordByCitizenIDSelectedYear($citizen_id);
			$existing_coop_surveys = array();
			foreach($existing_member as $item)
			{
				$existing_coop_surveys[] = $item['COOPERATIVE_CODE'];
			}
			
			$getdata =null;
			$coop_id_array = array();
			$this->load->model('grocery_crud_model');
			foreach ($existing_coop_surveys as $coop_id_data)
			{
				$crud = new grocery_CRUD();
				$getdata_query = $this->grocery_crud_model->gettheSurvey($citizen_id, $coop_id_data);
				
				if(is_null($getdata))
				{
					$getdata = $getdata_query;
					$coop_id_array[] = $coop_id_data;
				}else if(!empty($getdata_query)){
					$coop_id_array[] = $coop_id_data;
				}
			}
			
			$list_data_citizen = array();
			if(isset($getdata[0])) {
				$list_data_citizen = $getdata[0];
			}
			
			if (!empty($existing_member))
			{
				$default_data = array();
				$data_getAllprovinces = getAllProvinces();
				$data_farmer_one = array();
				$already_have_data_in_farmer1 = !empty($data_farmer_one)? true: false;
				$coop = null;
				$data_mahadthai = array();
				// load data from MAHADTHAI and check if information is there
				$data_mahadthai = getMahadthaiByCitizenID($citizen_id);
				
				foreach ($data_mahadthai as $mahadthai)
				{
// 					echo "<pre>";
// 					print_r($mahadthai['IN_D_COOP']);
// 					echo "</pre>";
					
				}
				
// 				echo "<pre>";
// 				print_r($list_data_citizen);
// 				echo "</pre>";
// 				exit();
				$output = array(
						'default_data' => $default_data,
						'already_have_data_in_farmer1' => $already_have_data_in_farmer1,
						'citizen_id' => $citizen_id,
						'mahadthai' => $data_mahadthai,
						'coop' => $coop,
						'data_farmer_one' => $data_farmer_one,
						'data_getAllprovinces'=>$data_getAllprovinces,
						'user_survey_data'=>$list_data_citizen,
						'list_array'=>$coop_id_array
				);
				echo "<pre>";
				print_r($output);
				echo "</pre>";
				
		}else{
			
		}
	}
// 	public function exportPDF($html)
// 	{
// // 		$html = $this->input->get('html');
// // 		print_r($html);
// 		include(APPPATH."third_party/mpdf/mpdf.php");
// 		$filename = 'testing.pdf';
// // 		$stylesheet = file_get_contents('http://govdw.ntksoftware.com/assets/default/css/bootstrap.min.css');
// // 		$stylesheet1 = file_get_contents('http://govdw.ntksoftware.com/assets/grocery_crud/themes/bootstrap/css/font-awesome/css/font-awesome.min.css');
		
// // 		$css = '<style>'.$stylesheet.$stylesheet1.'</style>';
		
// 		$mpdf=new mPDF('th', 'A4-P', '0', '');
		
		
// 		$mpdf->WriteHTML($html);
// // 		$mpdf->Wri
// 		$mpdf->WriteHTML($css, 1);
// 		$mpdf->Output(FCPATH."assets\\".$filename,"F"); //F
// 		echo base_url("assets\\".$filename);
// 	}
	
	
	public function test_act()
	{
			echo "test";

	}
}