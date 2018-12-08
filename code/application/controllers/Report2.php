<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report2 extends MY_Controller {
	
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		
		$this->load->helper('form');
		$this->load->helper('survey');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->library('session');
		$this->load->library('grocery_CRUD');
		$this->load->helper('properties');
		$this->load->helper('user');
		$this->load->helper('log');
		if (!canAdd())
		{
			redirect('/');
		}
		
// 		$this->output->enable_profiler($this->config->item('profiling_enabled'));
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
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')) 
				&& (canViewReport() || canAdd()))
		{
			
// 			include(APPPATH."third_party/mpdf/mpdf.php");
 			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
 			// $start = isset($_GET['start'])? trim($_GET['start']): 0;
 			// $length = isset($_GET['length'])? trim($_GET['length']): 50;
			
			// check access
			// checkSuspiciousActivityMahadthai($citizen_id, "ViewReport2-1", getSelectedSurveyYear());

			//addLogSuspiciousMessage($citizen_id, "ViewReport2-1");			
			
			$export = isset($_GET['exportdata'])?trim($_GET['exportdata']):"";
			
			if(!empty($export))
			{
// 				$year = getSelectedSurveyYear();
				
// 				$coops = getMemberByCitizenID($citizen_id);
				
// 				$existing_surveys = getAllSurveyRecordByCitizenIDYear($citizen_id);
				
// 				$output = array(
// 						'citizen_id' => $citizen_id,
// 						'year' => $year,
// 						'coop_members' => $coops,
// 						'surveys' => $existing_surveys,
// 						'downloadpdf'=>true
// 				);
				
// 				$content = $this->load->view('reports2/report1', $output, TRUE);
// 				$filename = 'testing.pdf';
				
// 				$mpdf=new mPDF('th', 'A4-L', '0', '');
// 				$mpdf->WriteHTML($content);
				
// 				$mpdf->Output(FCPATH."assets\\".$filename,"F"); //F
// 				echo base_url("assets\\".$filename);
				
				die();
			}
			echo $this->load->view('auth/page_header', '', TRUE);
			
			if (strlen($citizen_id)>0 && strlen($citizen_id) != 13 && !is_numeric($citizen_id))
			{
				echo $this->load->view('survey_error', array('message'=>'หมายเลขบัตรประชาชนไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				die();
			}

			// if (empty($citizen_id))
			// {

			// 	echo $this->load->view('auth/page_footer', '', TRUE);
				
			// 	die();
			// }
			

			$year = getSelectedSurveyYear();
			
			// $coops = getMemberByCitizenID($citizen_id,$start,$length);
			$coops = getMemberByCitizenID($citizen_id);

			$data = array();
			$pcheck = 0;

			$user_id = $this->session->userdata('auth_user_id');
			$user = getUser($user_id);

			$role_user = $this->session->userdata('auth_role');
			// echo "<pre>".print_r($user)."</pre>";
			// die();

			$detail_user = getOrgByID($user['org_id']);
					
			if (!empty($citizen_id)){
				foreach ($coops as $key => $value) {
					$coop = getCoopByID($value['COOP_ID']);
					// array_push($data, $coop);
					// echo $role_user;
					
					if ($role_user == 'notcentral_normal') {

						if ($coop['ORG_ID'] == $user['org_id']) {
							$data[$key] = getDataCitizen($coop,$value);
						}else if ($coop['PROVINCE_ID'] == $detail_user['province_id']){
							$data[$key] = getDataCitizen($coop,$value);
						}else{
							$pcheck = 1;
						}
					
					}else if ($role_user == 'notcentral_manager') {

							$khet = getOrgByID($coop['ORG_ID']);
							// echo "<pre>".print_r($khet)."</pre>";
							// echo "<pre>".print_r($detail_user)."</pre>";
						$real_khet = null;
						$user_khet = null;
						if ($khet['khet_id'] == 99) {
							$real_khet = 1;
						}else{
							$real_khet = $khet['khet_id'];
						}
						if ($detail_user['khet_id'] == 99) {
							$user_khet = 1;
						}else{
							$user_khet = $detail_user['khet_id'];
						}

						if ($real_khet == $user_khet) {
							$data[$key] = getDataCitizen($coop,$value);
						}else{
							$pcheck = 1;
						}

					}else{
						$data[$key] = getDataCitizen($coop,$value);
					}
					
						
				}
			}



			
			$existing_surveys = getAllSurveyRecordByCitizenIDYear($citizen_id);
			
			$output = array(
				'citizen_id' => $citizen_id,
				'year' => $year,
				'coop_members' => $data,
				'permission' => $pcheck,
				'surveys' => $existing_surveys,
				'role'	=> $role_user,
			);

			if (!empty($citizen_id)) {
				addLogSuspiciousMessage($citizen_id,'รายงานข้อมูลสมาชิกในสหกรณ์',"มีการเข้าถึงบัตรประชาชน");
			}
			
			
			echo $this->load->view('reports2/report1', $output, TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
			
			die();
		}
		else
		{
			redirect('/');
		}
			
	}
	
	public function index2()
	{	
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')) 
				&& (canViewReport() || canAdd()))
		{
			ini_set("memory_limit", '-1');
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "กรุงเทพมหานคร";
			$filter_coop = isset($_GET['filter_coop'])? trim($_GET['filter_coop']): "";
			$frompost = isset($_GET['frompost'])? trim($_GET['frompost']): "";
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 100;
			$export = isset($_GET['exportdata'])? trim($_GET['exportdata']): "";
			
			// echo $filter_coop;die();

// 			$all_coops = $this->cache->get('All_coops');
// 			$all_coops = getAllCoops();
// 			$dataMaster = getAllMaster();
// 			$dataMaster = $this->cache->get('All_master');
// 			$dataMaster_size = sizeof($dataMaster);
			
			//$table = getMahadthaiDbTable();
			//$sql = "Select count(OU_D_ID) as num from MOIUSER.MASTER_DATA where OU_D_FLAG in('1','2')   and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data.IN_D_COOP) = 13";
			//$query = $this->db->query($sql);
			//$dataMaster = $query->result_array();
			//$dataMaster_size = $dataMaster[0]['NUM'];
			//unset($dataMaster);			
			$dataMaster_size = countAllMembers();
			
			if (!is_numeric($filter_coop)) $filter_coop = "";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			if (  !empty($frompost) && (empty($filter_province) || empty($filter_coop) ||  empty($filter_year) || !is_numeric($filter_coop)))
			{
				$output = array(
						'filter_province' => $filter_province,
						'filter_coop' => $filter_coop,
						'filter_year' => $filter_year,
						'total_number' => 0,
						'current_page' => 0,
						'range' => 0,
						'count' =>($dataMaster_size>0)?$dataMaster_size:0
				);
				
				$error = 'กรุณาเลือก ปี จังหวัด และสหกรณ์';
				
				echo $this->load->view('auth/page_header', array('error_msg'=>$error), TRUE);
				echo $this->load->view('reports2/report2', $output, TRUE);
				echo $this->load->view('auth/page_footer', '', TRUE);
				die();
			}
			
			
			if (!empty($export))
			{
// 				$data = array();
// 				$surveys = getMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop, $page=0, $range=1000000);
				
// 				// file name for download
// 				$fileName = "export_report_2_1_" . date('Ymd') . ".xls";
				
// 				// headers for download
// 				header("Content-Disposition: attachment; filename=\"$fileName\"");
// 				header("Content-Type: application/vnd.ms-excel");
				
// 				$flag = false;
// 				foreach($surveys as $row) {
// 					$keys = array_keys($row);
// 					$new_row = array();
// 					foreach ($keys as $k)
// 					{
// 						$str = $row[$k];
// 						$str = preg_replace("/\t/", "\\t", $str);
// 						$str = preg_replace("/\r?\n/", "\\n", $str);
// 						if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
// 						$str = mb_convert_encoding($str, 'UCS-2LE', 'UTF-8');
// 						$new_row[$k] = $str;
// 					}
					
					
					
// 					echo implode("\t", array_values($new_row)) . "\r\n";
// 				}				
// 				exit;
				$namefile = "Report2";
				$surveys = getMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop, $page=0, $range=1000000);
				print_r($this->getExportReportFile($surveys,$namefile));
			}
			
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			
			$table  =getMahadthaiDbTable();
			
			
			//TODO bug
			
// 			$test = getAllCoops();
			
			
			
			$keyword =  $filter_province;
			$keyword2 = $filter_province;
// 			$return_results = array();
			
// 			foreach ($all_coops as $item)
// 			{
// 				$name = trim($item['COOP_NAME_TH']);
// 				$temp = array();
// 				$temp['user_id'] = $item['REGISTRY_NO_2'];
// 				$temp['name'] = $name;
// 				$temp['username'] = trim($item['COOP_NAME_TH']);
// 				$temp['coop_reg'] = trim($item['REGISTRY_NO_2']);
// 				$temp['id'] = trim($item['REGISTRY_NO_2']);
// 				$temp['text'] = trim($name);
// 				if (!empty($keyword2))
// 				{
					
// 					if ((strpos($item['COOP_NAME_TH'],$keyword)!==FALSE || strpos($item['REGISTRY_NO_2'],$keyword)!==FALSE) || strpos($item['PROVINCE_NAME'],$keyword2)!==FALSE)
// 					{
						
// 						$return_results[] = $temp;
// 					}
// 				}
// 				else
// 				{
// 					if (strpos($item['COOP_NAME_TH'],$keyword)!==FALSE || strpos($item['REGISTRY_NO_2'],$keyword)!==FALSE)
// 					{
// 						$return_results[] = $temp;
// 					}
					
// 				}
// 				unset($temp);
				
// 			}
			
			
			
// 			$coop_array = array();
// 			foreach ($return_results as $coop)
// 			{
// 				$coop_array[] = $coop['coop_reg'];
// 			}
			
// 			$this->db->where_in('IN_D_COOP',$coop_array);
// 			$testData = $this->db->get($table)->result_array();
			
// 			$where_in_str = implode("','",$coop_array);
			
// 			$sql = "select IN_D_COOP,IN_D_PREFIX,IN_D_PNAME,IN_D_SNAME,IN_D_PIN,OU_D_FLAG,IN_PROVICE_NAME,OU_D_FLAG from  moiuser.master_data where IN_D_COOP in('$where_in_str')";
			
			
// 			if(!empty($life_status)){
// 				$sql .=" and OU_D_FLAG = $life_status";
// 			}
// 			$testData = $this->db->query($sql)->result_array();
// 			echo "<pre>";
// 			print_r($testData);
// 			die();
// 			$data_respone = array();
// 			foreach ($testData as $data_user)
// 			{
// 				$data_field = array();
// 				if($data_user['OU_D_FLAG']=='1' )
// 				foreach ($data_user as $fields)
// 				{
// 					if(!empty($fields))
// 					{
// 						$data_field[]=$fields;
// 					}
// 					else
// 					{
// 						$data_field[]="";
// 					}
// 				}
// 				$data_respone[] = $data_field;
				
// 			}
			
			
		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
			$surveys = getMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop, $page, $range);
			
			$total_number = countMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop);
			$output = array(
				'filter_province' => $filter_province,
				'filter_coop' => $filter_coop,
				'filter_year' => $filter_year,	
				'total_number' => $total_number,
				'surveys' => $surveys,
				'current_page' => $page,
				'range' => $range,
					'count' =>($dataMaster_size>0)?$dataMaster_size:0
			);
			echo $this->load->view('reports2/report2', $output, TRUE);			
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/');
		}
	}


	
	
	
	public function index3()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$filter_creator = isset($_GET['filter_creator'])? trim($_GET['filter_creator']): "";
			$frompost = isset($_GET['frompost'])? trim($_GET['frompost']): "";
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			$export = isset($_GET['exportdata'])? trim($_GET['exportdata']): "";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			
			if (  !empty($frompost) && (empty($filter_creator) || empty($filter_year)))
			{
				$output = array(
						'filter_creator' => $filter_creator,
						'filter_year' => $filter_year,
						'total_number' => 0,
						'current_page' => 0,
						'range' => 0,
				);
				
				$error = 'กรุณาเลือก ปีและผูู้บันทึก';
				
				echo $this->load->view('auth/page_header', array('error_msg'=>$error), TRUE);
				echo $this->load->view('reports2/report2', $output, TRUE);
				echo $this->load->view('auth/page_footer', '', TRUE);
				die();
			}
			
			
			if (!empty($export))
			{
				
				$surveys = getSurveysByYearCreator($filter_year, $filter_creator, $page, $range);				
				$namefile = "Report3";
// 				_export_to_excel($surveys);
				$this->exportdatacsvreport3($surveys,$namefile);
				
			}
			
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			$surveys = getSurveysByYearCreator($filter_year, $filter_creator, $page, $range);
			
			$total_number = countSurveysByYearCreator($filter_year, $filter_creator);
			$output = array(
					'filter_creator' => $filter_creator,
					'filter_year' => $filter_year,
					'total_number' => $total_number,
					'surveys' => $surveys,
					'current_page' => $page,
					'range' => $range,
			);
			echo $this->load->view('reports2/report3', $output, TRUE);
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			
			redirect('/');
		}
	}
	
	public function index4()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& (canViewReport() || canAdd()))
		{
			ini_set("memory_limit", '-1');
			$filter_province = isset($_GET['filter_province'])? trim($_GET['filter_province']): "กรุงเทพมหานคร";
			$filter_coop = isset($_GET['filter_coop'])? trim($_GET['filter_coop']): "";
			$frompost = isset($_GET['frompost'])? trim($_GET['frompost']): "";
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			$export = isset($_GET['exportdata'])? trim($_GET['exportdata']): "";
		
			
			//$table = getMahadthaiDbTable();
			//$sql = "Select count(OU_D_ID) as num from MOIUSER.MASTER_DATA where OU_D_FLAG in('1','2')   and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data.IN_D_COOP) = 13";
			//$query = $this->db->query($sql);
			//$dataMaster = $query->result_array();
			//$dataMaster_size = $dataMaster[0]['NUM'];
			//unset($dataMaster);
			$dataMaster_size = countAllMembers();			
			
			if (!is_numeric($filter_coop)) $filter_coop = "";
			$filter_year = isset($_GET['filter_year'])? trim($_GET['filter_year']): getSelectedSurveyYear();
			if (  !empty($frompost) && (empty($filter_province) || empty($filter_coop) ||  empty($filter_year) || !is_numeric($filter_coop)))
			{
				$output = array(
						'filter_province' => $filter_province,
						'filter_coop' => $filter_coop,
						'filter_year' => $filter_year,
						'total_number' => 0,
						'current_page' => 0,
						'range' => 0,
						'count' =>($dataMaster_size>0)?$dataMaster_size:0
				);
				
				$error = 'กรุณาเลือก ปี จังหวัด และสหกรณ์';
				
				echo $this->load->view('auth/page_header', array('error_msg'=>$error), TRUE);
				echo $this->load->view('reports2/report2', $output, TRUE);
				echo $this->load->view('auth/page_footer', '', TRUE);
				die();
			}
			
			
			if (!empty($export))
			{
				
				$namefile = "Report2";
				$surveys = getMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop, $page=0, $range=1000000);
				print_r($this->getExportReportFile($surveys,$namefile));
			}
			
			echo $this->load->view('auth/page_header', '', TRUE);
			
			$page = isset($_GET['page'])? trim($_GET['page']): 0;
			$range = isset($_GET['range'])? trim($_GET['range']): 25;
			
			$table  =getMahadthaiDbTable();
			
			
			$keyword =  $filter_province;
			$keyword2 = $filter_province;
			
			$surveys = getMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop, $page, $range);
			
			$total_number = countMembersByYearProvinceCoopID($filter_year, $filter_province, $filter_coop);
			$output = array(
					'filter_province' => $filter_province,
					'filter_coop' => $filter_coop,
					'filter_year' => $filter_year,
					'total_number' => $total_number,
					'surveys' => $surveys,
					'current_page' => $page,
					'range' => $range,
					'count' =>($dataMaster_size>0)?$dataMaster_size:0
			);
			echo $this->load->view('reports2/report4', $output, TRUE);
			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/');
		}
	}
	public function exportTotalResultNomalOrDieOfCoop()
	{
		set_time_limit(0);
		$filter_khet = !empty($this->input->get('khet'))?$this->input->get('khet'):"";
		$filter_tambon = !empty($this->input->get('filter_tambon'))?$this->input->get('filter_tambon'):"";
		$filter_district = !empty($this->input->get('filter_district'))?$this->input->get('filter_district'):"";
		$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):"";
		$filter_coop = !empty($this->input->get('filter_coop'))?$this->input->get('filter_coop'):"";
		$life_status = isset($_GET['filter_life_status'])? trim($_GET['filter_life_status']): "";
		
		
		
		if(empty($filter_khet))
			exit();
		
		
		$filename = 'export-data';
		$data = $this->getTotalResultNomalOrDieOfCoop(true,$filter_khet,$filter_provinces,$filter_district,$filter_coop,$life_status);
		
		
		$countRow = sizeof($data);
		$strFilds = 'D1:D'.$countRow;
		// 		->getNumberFormat()->setFormatCode('0')
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet()->fromArray($data);
		// $sheet = $spreadsheet->getActiveSheet()->fromArray($data)->getStyle($strFilds)->getNumberFormat()->setFormatCode('0000000000000');
		// 		$writer = new Xlsx($spreadsheet);
		// 		$writer->save('php://output');
		
		
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="รายงานสรุปยอดสถานะสมาชิกสหกรณ์.xlsx"');
		$writer->save("php://output");
	}
	public function getTotalResultNomalOrDieOfCoop($export = false,$filter_khet=null,$filter_provinces=null,$filter_district=null,$filter_coop=null,$life_status=null,$start=0,$length=10)
	{
		ini_set("memory_limit", "8124M");
		$life_status = isset($_GET['filter_life_status'])? trim($_GET['filter_life_status']): "";
		$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
		
		$start = !empty($this->input->get('start'))? trim($this->input->get('start')): $start;
		$length = !empty($this->input->get('length'))? trim($this->input->get('length')): $length;
		
		$filter_count_coop = !empty($this->input->get('filter_count_coop'))?$this->input->get('filter_khet'):null;
		$filter_khet = !empty($this->input->get('filter_khet'))?$this->input->get('filter_khet'):$filter_khet;
		$filter_tambon = !empty($this->input->get('filter_tambon'))?$this->input->get('filter_tambon'):$this->session->userdata('filter_tambon');
		$filter_district = !empty($this->input->get('filter_district'))?$this->input->get('filter_district'):$filter_district;
		$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):$filter_provinces;
		$filter_coop = !empty($this->input->get('filter_coop'))?$this->input->get('filter_coop'):$filter_coop;
		// $more_coop = !empty($this->input->get('filter_more_coop'))?$this->input->get('filter_more_coop'):null;
		$show_query = !empty($this->input->get('query'))?TRUE:FALSE;
		
		$search = !empty($this->input->get('search[value]'))?$this->input->get('search[value]'):null;
		
		$orderBy = " ORDER BY COOP_INFO.COOP_NAME_TH ASC";
		
		
		
		$sql_coop="";
		$sql_provinces="";
		$sql_KHET="";
		$life_status_query ="";
		$sql_more_coop ="";
		if(!empty($filter_coop))
		{
			$sql_coop = " and COOP_INFO.REGISTRY_NO_2 = '$filter_coop' ";
		}else if(!empty($filter_provinces))
		{
			$sql_coop = " and  COOP_INFO.ORG_ORG_ID in (select KHET.COL011 from KHET where KHET.COL011 = $filter_provinces) ";
		}
		else{
			if(!empty($filter_khet) && is_numeric($filter_khet)){
			$sql_KHET = " and  COOP_INFO.ORG_ORG_ID in (select KHET.COL011 from KHET where KHET.COL004 = $filter_khet)";
			}
		}
		
		if(!empty($life_status)){
			if($life_status =='2'){
				$life_status_query =" and moiuser.master_data.OU_D_STATUS_TYPE in (1,11,13) ";
			}else if($life_status =='1'){
				$life_status_query =" and moiuser.master_data.OU_D_STATUS_TYPE not in (1,11,13) ";
			}
		}

		
		// if(!empty($more_coop) && $more_coop !='3')
		// {
		// 	if(empty($search) && $search =="")
		// 		$sql_more_coop =" and moiuser.master_data.NUMBER_OF_COOP =".$more_coop;
		// 	else if($export)
		// 		$sql_more_coop =" and moiuser.master_data.OU_D_ID in (select OU_D_ID from MOIUSER.MASTER_DATA where number_of_coop =$more_coop)";
		// 	else
		// 		$sql_more_coop =" and moiuser.master_data.OU_D_ID in (select OU_D_ID from MOIUSER.MASTER_DATA where number_of_coop =$more_coop)";
						
		// }
		// if(!empty($more_coop) && $more_coop>='3')
		// {
		// 	if(empty($search) && $search =="")
		// 		$sql_more_coop =" and moiuser.master_data.number_of_coop >2";
		// 	else if($export)
		// 			$sql_more_coop =" and moiuser.master_data.OU_D_ID in (select OU_D_ID from MOIUSER.MASTER_DATA where number_of_coop >2)";
		// 	else
		// 		$sql_more_coop =" and moiuser.master_data.OU_D_ID in (select OU_D_ID from MOIUSER.MASTER_DATA where number_of_coop >2)";
		// }
		
		

		
		// $sql = "select a.TOTAL_COOP,COOP_INFO.REGISTRY_NO_2,COOP_INFO.COOP_NAME_TH,COOP_INFO.PROVINCE_NAME,COOP_INFO.AMPHUR_NAME
		//   from COOP_INFO
		//   left join (
		//        select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
		//        from moiuser.master_data
		//        where OU_D_FLAG in (1,2) $life_status_query $sql_more_coop
		//        group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		//   ) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where a.TOTAL_COOP is not null $sql_coop $sql_provinces $sql_KHET 
		// 	$orderBy ";

		
		// $sql_count ="select sum( a.TOTAL_COOP) as TOTAL
		//   from COOP_INFO
		//   left join (
		//        select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
		//        from moiuser.master_data
		//        where OU_D_FLAG in (1,2) $life_status_query $sql_more_coop
		//        group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		//   ) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where a.TOTAL_COOP is not null $sql_coop $sql_provinces $sql_KHET
		// 	";

		// $sql =	"SELECT a.TOTAL_COOP, COOP_INFO.REGISTRY_NO_2, COOP_INFO.COOP_NAME_TH, COOP_INFO.PROVINCE_NAME, COOP_INFO.AMPHUR_NAME 
		// 		FROM COOP_INFO 
		// 		LEFT JOIN ( 
		//     		SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
		// 			FROM ( 
		// 				SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
		// 				FROM moiuser.master_data 
		// 				WHERE OU_D_FLAG IN (1, 2) $life_status_query $sql_more_coop 
		// 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
		// 				AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
		// 			) tb 
		// 			GROUP BY tb.IN_D_COOP 
		// 		) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP 
		// 		WHERE a.TOTAL_COOP IS NOT NULL $sql_coop $sql_provinces $sql_KHET 
		// 		$orderBy";

		// $sql = "SELECT a.TOTAL_COOP,b.TOTAL_DIE , COOP_INFO.REGISTRY_NO_2, COOP_INFO.COOP_NAME_TH, COOP_INFO.PROVINCE_NAME, COOP_INFO.AMPHUR_NAME 
		// 		FROM COOP_INFO 
		// 		LEFT JOIN ( 
		//     		SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
		// 			FROM ( 
		// 				SELECT DISTINCT IN_D_COOP, OU_D_ID
		// 				FROM moiuser.master_data 
		// 				WHERE OU_D_FLAG IN (1, 2) and moiuser.master_data.OU_D_STATUS_TYPE not in (1,11,13)
		// 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
		// 				AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
		// 			) tb 
		// 			GROUP BY tb.IN_D_COOP 
		// 		) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP 
  //               LEFT JOIN ( 
		//     		SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_DIE 
		// 			FROM ( 
		// 				SELECT DISTINCT IN_D_COOP, OU_D_ID 
		// 				FROM moiuser.master_data 
		// 				WHERE OU_D_FLAG IN (1, 2) and moiuser.master_data.OU_D_STATUS_TYPE in (1,11,13)
		// 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
		// 				AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
		// 			) tb 
		// 			GROUP BY tb.IN_D_COOP 
		// 		) b ON COOP_INFO.REGISTRY_NO_2 = b.IN_D_COOP 
  //               WHERE a.TOTAL_COOP IS NOT NULL $sql_coop $sql_provinces $sql_KHET $orderBy";

		$sql = "SELECT a.TOTAL_COOP, COOP_INFO.REGISTRY_NO_2, COOP_INFO.COOP_NAME_TH, COOP_INFO.PROVINCE_NAME, COOP_INFO.AMPHUR_NAME 
				FROM COOP_INFO 
				LEFT JOIN ( SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP FROM ( SELECT DISTINCT IN_D_COOP, OU_D_ID FROM moiuser.master_data 
				WHERE OU_D_FLAG IN (1, 2)
				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
				AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 )
				tb GROUP BY tb.IN_D_COOP ) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP WHERE a.TOTAL_COOP IS NOT NULL $sql_coop $sql_provinces $sql_KHET $orderBy";
		
		// $sql_count =	"SELECT SUM(a.TOTAL_COOP) AS TOTAL 
		// 				FROM COOP_INFO 
		// 				LEFT JOIN ( 
		//     				SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
		// 					FROM ( 
		// 						SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
		// 						FROM moiuser.master_data 
		// 						WHERE OU_D_FLAG IN (1, 2) 
		// 						AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
		// 						AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
		// 					) tb 
		// 					GROUP BY tb.IN_D_COOP 
		// 				) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
		// 				WHERE a.TOTAL_COOP IS NOT NULL $sql_coop $sql_provinces $sql_KHET";

				$sql_count = "SELECT count(a.IN_D_COOP) AS TOTAL 
						FROM COOP_INFO 
						LEFT JOIN ( 
		    				SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
							FROM ( 
								SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
								FROM moiuser.master_data 
								WHERE OU_D_FLAG IN (1, 2) 
								AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
								AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
							) tb 
							GROUP BY tb.IN_D_COOP 
						) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP WHERE a.TOTAL_COOP IS NOT NULL $sql_coop $sql_provinces $sql_KHET";




			if(!$export){
				$sql .=" OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
			}


		
		
			$more_coop_array = array('1'=>"เป็นสมาชิก 1 สหกรณ์",'2'=>"เป็นสมาชิก 2  สหกรณ์",'3'=>"ตั้งแต่ 3 สหกรณ์ขึ้นไป");
			$status_array = array('1'=>"ปกติ",'2'=>"ตาย");
			$coop_data = getCoopByID($filter_coop);
			
			// echo print_r($filter_khet);die();


			$list_province = $this->getlistProvince($filter_khet,true);
			if(!empty($filter_khet))
			{
				$this->db->distinct('COL004');
				$this->db->where('COL004',$filter_khet);
				$query = $this->db->get('KHET')->result_array();
				$filter_khet = $query[0]['COL003'];
				
			}
		
			if(!empty($filter_provinces))
			{
				foreach ($list_province as $province)
				{
					if($province['id'] == $filter_provinces)
					{
						$filter_provinces = $province['name'];
					}
				}
			}
			$coop_names = getAllCoops();
			
			$data_coop = array();
			
			foreach ($coop_names as $coop_name)
			{
				$data_coop[$coop_name['REGISTRY_NO_2']] = $coop_name['COOP_NAME_TH'];
				
			}
			if(!empty($filter_coop))
			{
				$filter_coop = $data_coop[$filter_coop];
			}
			// if(!empty($more_coop))
			// {
			// 	$more_coop_array = array("1"=>"เป็นสมาชิก 1 สหกรณ์","2"=>"เป็นสมาชิก 2  สหกรณ์","3"=>"ตั้งแต่ 3 สหกรณ์ขึ้นไป");
			// 	$more_coop = $more_coop_array[$more_coop];
				
			// }
			
			// echo print_r($sql_count);die();
			$query_count = $this->db->query($sql_count)->result_array();
			// $qty = "select TOTAL_COOP, REGISTRY_NO_2 from alive_die where REGISTRY_NO_2 = '1200000124844'";

			// $qty = "SELECT alive.TOTAL_COOP, alive.REGISTRY_NO_2, alive_die.TOTAL_COOP as TOTAL_DIE FROM alive INNER JOIN alive_die ON alive.REGISTRY_NO_2=alive_die.REGISTRY_NO_2 where alive.REGISTRY_NO_2 = '1200000124844'";
			// 	// $query_count_die = $this->db->query($qty)->result_array();

		 //    $query_count_die = $this->db->query($qty)->result_array();
		 //    echo $query_count_die[0]['TOTAL_COOP'];
			// echo print_r($query_count_die);die();

			// $query_count_die = getDie('1200000124844');
			// echo $query_count_die['TOTAL_COOP'];die();


			$text ="";
			
			if (!empty($filter_khet) && !empty($filter_provinces)) {
				$text .=!empty($filter_khet)?$filter_khet." /":"เขตทั้งหมด";
			}elseif (empty($filter_khet) && !empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet."":"";
				$text .=!empty($filter_provinces)?" ".$filter_provinces."":"";
			}elseif (!empty($filter_khet) && empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet."":"";
				$text .=!empty($filter_provinces)?" ".$filter_provinces."":"";
			}elseif (empty($filter_khet) && empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet." /":"ทั้งหมด /";
			}
			$text .=!empty($filter_district)?" ".$filter_district." /":"";
			$text .=!empty($filter_coop)?" ".$filter_coop." /":"";
			// $text .=!empty($life_status)?" ".$status_array[$life_status]." /":"";
			// $text .=!empty($life_status)?" ".$status_array[1]." /":"";
			// $text .=!empty($life_status)?" ".$status_array[2]." /":"";
			// $text .=!empty($more_coop)?" ".$more_coop." /":"";
			$text .=" จำนวน   : ".number_format($query_count[0]['TOTAL']);
			$text .=" สหกรณ์";
			
			$textlog ="";
			$textlog.=!empty($filter_khet)?$filter_khet." ":"";
			$textlog.=!empty($filter_provinces)?" / ".$filter_provinces." ":"";
			$textlog.=!empty($filter_district)?"/ ".$filter_district." ":"";
			$textlog.=!empty($filter_coop)?" / ".$filter_coop." ":"";
			// $textlog.=!empty($life_status)?" / ".$status_array[$life_status]." ":"";
			// $textlog.=!empty($more_coop)?" / ".$more_coop." ":"";
			
			
			if($show_query)
			{
				$data = array();
				$temp = array();
				$data['numrow'] = $text ;
				$data['query'][] = $sql;
				print_r(json_encode($data));
				exit();
			}
			// echo print_r($sql);die();
			$query_nomal = $this->db->query($sql)->result_array();

			// $query_nomal_die = $this->db->query($sql_die)->result_array();


		
		$data_key_coop_id = array();
		
		// echo print_r($query_nomal);die();
		if($export)
		{
			$date_time = $this->changemonth();
			$data_key_coop_id[] =array('','','',$date_time);
			$data_key_coop_id[] =array('รายงานสรุปยอดสถานะสมาชิกสหกรณ์','','','','');
			$data_key_coop_id[] =array($text,'','','');
			$data_key_coop_id[] =array('ชื่อสหกรณ์','จังหวัด','เขต|อำเภอ','จำนวนสมาชิกปกติ','จำนวนสมาชิกตาย','จำนวนสมาชิกทั้งหมด');
// 			$data = array();
			foreach ($query_nomal as $data_temp)
			{
				// echo print_r($data_temp);die();
				$query_count_die = getDie($data_temp['REGISTRY_NO_2']);
				$die = null;
				
				// echo $die['TOTAL_DIE'];
				// echo print_r($die);die();
				if (!empty($query_count_die['TOTAL_DIE'])) {
					$die = $query_count_die['TOTAL_DIE'];
				}

				$temp = array();
				$temp[] = $data_temp['COOP_NAME_TH'];
				$temp[] = $data_temp['PROVINCE_NAME'];
				$temp[] = $data_temp['AMPHUR_NAME'];
				$temp[] = number_format($data_temp['TOTAL_COOP'] - $die);
				$temp[] = number_format($die);
				$temp[] = number_format($data_temp['TOTAL_COOP']);	
				$data_key_coop_id[] =$temp;
			}
			// addLogSuspiciousMessageReport('พิมพ์รายงานข้อมูลสมาชิกในสหกรณ์', $textlog,$filter_provinces);
			// echo print_r($data_key_coop_id);die();
			return $data_key_coop_id;
		}else{
			addLogSuspiciousMessageReport('เข้าดูรายงานสรุปยอดสถานะสมาชิกสหกรณ์', $textlog,$filter_provinces);
			$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
			
			$data = array();
			foreach ($query_nomal as $data_temp)
			{
				$query_count_die = getDie($data_temp['REGISTRY_NO_2']);
				$die = null;
				
				// echo $die['TOTAL_DIE'];
				// echo print_r($die);die();
				if (!empty($query_count_die['TOTAL_DIE'])) {
					$die = $query_count_die['TOTAL_DIE'];
				}
				// echo print_r($query_count_die);die();
				$temp = array();
				$temp[] = $data_temp['COOP_NAME_TH'];
				$temp[] = $data_temp['PROVINCE_NAME'];
				$temp[] = $data_temp['AMPHUR_NAME'];
				$temp[] = number_format($data_temp['TOTAL_COOP'] - $die);
				$temp[] = number_format($die);
				$temp[] = number_format($data_temp['TOTAL_COOP']);	
				$data[] =$temp;
			}


			$recordsTotal = $query_count[0]['TOTAL'];
			$recordsFiltered = $query_count[0]['TOTAL'];
			
			if(!empty($search)){
				$recordsTotal = sizeof($data_temp);
				$recordsFiltered = sizeof($data_temp);
			}
			
// 			unset($query_nomal);
			$output = array(
					"draw"    => intval($draw),
					"recordsTotal"  => intval($recordsTotal),
					"recordsFiltered" => intval($recordsFiltered),
					"data"   => $data,
					"textlog" => $text
			);
			// echo print_r($output['data']);die();
			print_r(json_encode($output));
		}

// 		$draw = 1;
		
		
	}
	
	public function getlistProvince($khet_id=null ,$retrun_data = false)
	{
		if(!$retrun_data)
		$khet_id = $this->input->get('khet');
		
		if($khet_id == 0 ){
			$province = getAllOrgNew();
			// echo print_r($province);die();

		}else{
			$province = getProvinceOfKhetById($khet_id);
		}
	
		
		$province_name_user_search = getUser($this->session->userdata('auth_user_id'));
		// echo print_r($province_name_user_search);die();
		$province_id = $province_name_user_search['province'];
		
		$org_id = null;
		// if("กรุงเทพมหานคร พื้นที่ 1" == $province_name_user_search['org_id']){
		// 	if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
		// 		$org_id = '4553';
		// }else if("กรุงเทพมหานคร พื้นที่ 2" == $province_name_user_search['province'])
		// {
		// 	if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
		// 		$org_id = '4559';
		// }
		
		// echo print_r($province);die();
		$temp_data = array();
		if ($khet_id == 0 ) {
			foreach ($province as $v) {
				$temp_data[] = array('id'=>$v['COL011'],'name'=>$v['COL007']);
			}
		}else{

			foreach ($province as $v)
			{
				if($this->session->userdata('auth_role') == "notcentral_normal")
				{
					if(!empty($org_id) && !is_null($org_id) && intval($v['COL011']) == intval($org_id))
					{
						$temp_data[] = array('id'=>$v['COL011'],'name'=>$v['COL007']);
					}
					if(empty($org_id) && intval($province_id) == intval($v['COL006']))
					{
						$temp_data[] = array('id'=>$v['COL011'],'name'=>$v['COL007']);
					}else{
						continue;
					}
				}else{
					$temp_data[] = array('id'=>$v['COL011'],'name'=>$v['COL007']);
				}
	// 				$temp_data[]['name'] = $v['COL008'];
				
			}
			# code...	
		}
		$data_responce = array();
		
		$data_responce['items'] =  $temp_data;
		// $test = array();

		// foreach ($province as $v){
		// 	array_push($test,$v['COL011']);
		// }
		
		// echo print_r($test);
		// echo implode(',',$test);
		// die();
		
		
		$data_responce['query'] ="select COL008 from KHET_DATA where COL004='".$khet_id."'";
		if($retrun_data)
		{
			return $temp_data;
		}else{
			print_r(json_encode($data_responce));
		}
	}
	
	public function getlistKhet()
	{
		$listKhet = getAllKhet();
		$temp_data_list_khet = array();
		$province_name_user_search = getUser($this->session->userdata('auth_user_id'));
		
		// echo print_r($province_name_user_search); die();
		if("4553" == $province_name_user_search['org_id']){
			if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
				$this->db->where('COL011','4553');			

		}else if("4559" == $province_name_user_search['org_id'])
		{
			if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager")
				$this->db->where('COL011','4559');
		}else{
			$province_name = getOrgByID($province_name_user_search['org_id']);
		// echo print_r($province_name); die();
			
			if($this->session->userdata('auth_role') == "notcentral_normal")
			{

				$this->db->where('COL011',$province_name['org_org_id']);
				// echo print_r($province_name);
			}else if ($this->session->userdata('auth_role') == "notcentral_manager"){
				// echo print_r($province_name);
				$this->db->where('COL004',$province_name['khet_id']);
			}
				
		}
		
		
		
		
		
		$query = $this->db->get($this->db->dbprefix('KHET'));
		$datas = $query->result_array();
			
			

// 		$table = getMahadthaiDbTable();
		
		
		$temp_data = array();
		$checkpermission = true;
		if($this->session->userdata('auth_role') == "notcentral_normal" || $this->session->userdata('auth_role') == "notcentral_manager") {
			$checkpermission = false;
		}

		foreach ($datas as $data)
		{
			$temp_data[intval($data['COL004'])] = $data;
		}
		
		ksort($temp_data);
		
		$temp_data_alert_sort = array();
		
		

		foreach ($temp_data as $data_sort)
		{
			$temp_data_list_khet[] = $data_sort;
		}
		
		
		$data_respone = array();
		$data_respone['items'] = $temp_data_list_khet;
		$data_respone['check'] = $checkpermission;
		$data_respone['query'] = "select * from KHET_DATA";
		print_r(json_encode($data_respone));
		
	}
	
	public function exportdatacsv($filename = "export-data")
	{
		ini_set('max_execution_time', -1);
		ini_set("memory_limit", '8124M');
		$life_status = isset($_GET['filter_life_status'])? trim($_GET['filter_life_status']):"";
		$filter_khet = !empty($this->input->get('khet'))?$this->input->get('khet'):null;
		$filter_tambon = !empty($this->input->get('filter_tambon'))?$this->input->get('filter_tambon'):null;
		$filter_district = !empty($this->input->get('filter_district'))?$this->input->get('filter_district'):null;
		$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):null;
		$filter_coop = !empty($this->input->get('filter_coop'))?$this->input->get('filter_coop'):null;

		if(empty($filter_khet))
			exit();
		// $sunm_keycache_export = $filename.'-'.$filter_khet.'-'.$life_status.'-'.$filter_district.'-'.$filter_provinces.'-'.$filter_coop.'-'.$filter_tambon;
		// $cache_key = md5($sunm_keycache_export);
		// 	$ci =& get_instance();
		// 	$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		// 	$data_cache_export = "";
		// $data = null;
		// $value = null;
		// 	if ( ! $data_cache_export = $ci->cache->get($cache_key)) {
	
			
				$data = $this->ajax_filter_report2(true,$filter_khet,$filter_provinces,$filter_district,$filter_coop,$life_status);
		
		// 		$ci->cache->save($cache_key, $data, 30000);
		// 		$value = $data;
		// 	}
		// $value = $data_cache_export;

		// echo print_r($data);die();
		$countRow = sizeof($data);
		$strFilds = 'E1:E'.$countRow;
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet()->fromArray($data)->getStyle($strFilds)->getNumberFormat()->setFormatCode('0000000000000');
		
		
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="รายงานข้อมูลสมาชิกในสหกรณ์.xlsx"');
		$writer->save("php://output");
		
		
	}
	
	
	public function ajax_filter_report2($export = false,$filter_khet=null,$filter_provinces=null,$filter_district=null,$filter_coop=null,$life_status="",$start=0,$length=-1)
	{


		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& (canViewReport() || canAdd()))
		{
			ini_set('max_execution_time', -1);
			ini_set("memory_limit", "8124M");
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			$life_status = isset($_GET['filter_life_status'])? trim($_GET['filter_life_status']):$life_status;
			$citizen_id = isset($_GET['citizen_id'])? trim($_GET['citizen_id']): "";
			
			$start = !empty($this->input->get('start'))? trim($this->input->get('start')): $start;
			$length = !empty($this->input->get('length'))? trim($this->input->get('length')): $length;
			
			$filter_count_coop = !empty($this->input->get('filter_count_coop'))?$this->input->get('filter_khet'):null;
			$filter_khet = !empty($this->input->get('filter_khet'))?$this->input->get('filter_khet'):$filter_khet;
			$filter_district = !empty($this->input->get('filter_district'))?$this->input->get('filter_district'):null;
			$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):null;
			$filter_coop = !empty($this->input->get('filter_coop'))?$this->input->get('filter_coop'):null;
			$more_coop = !empty($this->input->get('filter_more_coop'))?$this->input->get('filter_more_coop'):null;
			$show_query = !empty($this->input->get('query'))?TRUE:FALSE;
			
			$search = !empty($this->input->get('search[value]'))?$this->input->get('search[value]'):null;
			
			// $sunm_keycache = $export.'-'.$filter_count_coop.'-'.$filter_khet.'-'.$filter_district.'-'.$filter_provinces.'-'.$filter_coop.'-'.$more_coop.'-'.$life_status.'-'.$show_query.'-'.$search.'-'.$start.'-'.$length.'-'.$citizen_id;
			// $sunm_keycache_ex = 'export'.$export.'-'.$filter_count_coop.'-'.$filter_khet.'-'.$filter_district.'-'.$filter_provinces.'-'.$filter_coop.'-'.$more_coop.'-'.$life_status.'-'.$show_query.'-'.$search.'-'.$start.'-'.$length.'-'.$citizen_id;

			if(strlen($filter_provinces) == 2){
				$ss = getOrgIdByProvinceId($filter_provinces);
				$filter_provinces = $ss[0]['org_org_id'];
			}
			


			$numm =0;
			$sql="";
			$sql_count = "";
			$life_status_query = "";
			$more_coop_query ="";

			//Check Alive and Die
			if(!empty($life_status)){
				if($life_status =='2'){
					$life_status_query =" AND OU_D_STATUS_TYPE IN (1,11,13) ";
				}else if($life_status =='1'){
					$life_status_query =" AND OU_D_STATUS_TYPE NOT IN (1,11,13) ";
				}
			}


			//Check More COOP value NUll, 1, 2, >2
			if (!empty($more_coop)) {
				if ($more_coop == 1) {
					$more_coop_query = " HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) = 1 ";
				}else if ($more_coop == 2) {
					$more_coop_query = " HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) = 2 ";
				}else{
					$more_coop_query = " HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) > 2 ";
				}		
			}else{
				$more_coop_query = "";
			}

			//Seach Datatable
			$search_datatable = "";
			$search = safeSQLValue($search);
			if(!empty($search))
			{
				$search_datatable = " and (IN_D_COOP like '$search' or IN_D_COOP like '$search%' or IN_D_COOP like '%$search' or IN_D_COOP like '%$search%'";
				$search_datatable .="or COOP_NAME_TH like '$search' or COOP_NAME_TH like '$search%' or COOP_NAME_TH like '%$search' or COOP_NAME_TH like '%$search%'";
				$search_datatable .="or OU_D_PNAME like '$search' or OU_D_PNAME like '$search%' or OU_D_PNAME like '%$search' or OU_D_PNAME like '%$search%'";
				$search_datatable .="or OU_D_SNAME like '$search' or OU_D_SNAME like '$search%' or OU_D_SNAME like '%$search' or OU_D_SNAME like '%$search%'";
				$search_datatable .="or OU_D_ID like '$search' or OU_D_ID like '$search%' or OU_D_ID like '%$search' or OU_D_ID like '%$search%'";
				$search_datatable .="or IN_PROVICE_NAME like '$search' or IN_PROVICE_NAME like '$search%' or IN_PROVICE_NAME like '%$search' or IN_PROVICE_NAME like '%$search%')";
			}

			//Check Filter Before Query
			$query_coop = null;
			$query_org_id = null;
			$query_org_id_2 = null;
			if (!empty($filter_coop) && !empty($filter_provinces)) {
				//IF isset $filter_coop and $filter_provinces
				$query_coop = " AND IN_D_COOP = $filter_coop ";
				$query_org_id = " AND B.ORG_ID IN ($filter_provinces) ";
				$query_org_id_2 = " AND B.ORG_ID IN ($filter_provinces) ";

			}else if (!empty($filter_coop)) {
				$query_coop = " AND IN_D_COOP = $filter_coop ";
			}else if (!empty($filter_provinces)) {
				$query_org_id = " AND B.ORG_ID IN ($filter_provinces) ";
				$query_org_id_2 = " AND B.ORG_ID IN ($filter_provinces) ";
			}else{

			}

			//Check Select Org_id
			$isset_org_id = array();
			if (empty($filter_provinces)) {
				if($filter_khet != 0 ){
					$province = getProvinceOfKhetById($filter_khet);
					foreach ($province as $v){
						array_push($isset_org_id,$v['COL011']);
					}
					// $province = getProvinceOfKhetById($filter_khet);
				
					$list = implode(',',$isset_org_id);
					$query_org_id = " AND ORG_ID IN ($list) ";
				}else{
					$query_org_id = "";
				}
				
			}



			//New Query
			$sql = "SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
					FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
					WHERE A.OU_D_FLAG IN(1,2)
					AND LENGTH (A.IN_D_COOP) = 13 
					AND LENGTH (A.OU_D_ID) = 13
					AND A.IN_D_COOP IS NOT NULL
					$life_status_query
			 		$query_org_id
			 		$query_coop
					GROUP BY OU_D_ID $more_coop_query ORDER BY OU_D_ID";

			// //New Query
			// $sql = "SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
			// 		FROM MOIUSER.MASTER_DATA A,ANALYTICPRD.COOP_INFO B
			// 		WHERE A.IN_D_COOP=B.REGISTRY_NO_2
			// 		AND A.OU_D_FLAG IN(1,2)
			// 		AND A.IN_D_COOP IS NOT NULL
			// 		$life_status_query
			// 		$query_org_id
			// 		$query_coop
			// 		GROUP BY OU_D_ID
			// 		HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) $more_coop_query";



			$sql_count = "SELECT SUM(AMT) AS TOTAL FROM($sql)";
			$sql_count_row = "SELECT COUNT(AMT) AS TOTAL FROM($sql)";


			// Query
			// $sql = "SELECT DISTINCT OU_D_ID,IN_D_COOP, B.COOP_NAME_TH,OU_D_PREFIX,OU_D_PNAME,OU_D_SNAME,OU_D_STATUS_TYPE,IN_PROVICE_NAME
			// 		FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
			// 		WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
			// 		                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
			// 		                          FROM MOIUSER.MASTER_DATA 
			// 		                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER' 
			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13 
			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.OU_D_ID) = 13 
			// 		                          AND IN_D_COOP IS NOT NULL
			// 		                          AND OU_D_ID IS NOT NULL
			// 		                          AND OU_D_FLAG IN(1,2)
			// 		                          $life_status_query
			// 		                          $query_org_id
			// 		                          AND B.COOP_TYPE IS NOT NULL
			// 		                          GROUP BY OU_D_ID
			// 		                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) $more_coop_query ) S) $search_datatable
			// 		$query_coop
			// 		ORDER BY OU_D_ID";

			// Count Query		
			// $dis_count = "DISTINCT OU_D_ID";
			// $sql_count_row = "SELECT count(*) as TOTAL FROM (
			// 					SELECT DISTINCT OU_D_ID,IN_D_COOP
			// 					FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
			// 					WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
			// 					                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
			// 					                          FROM MOIUSER.MASTER_DATA 
			// 					                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER' 
			// 					                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13 
			// 					                          AND LENGTH (MOIUSER.MASTER_DATA.OU_D_ID) = 13 
			// 					                          AND IN_D_COOP IS NOT NULL
			// 					                          AND OU_D_ID IS NOT NULL
			// 					                          AND OU_D_FLAG IN(1,2)
			// 					                          $life_status_query
			// 					                          $query_org_id
			// 					                          AND B.COOP_TYPE IS NOT NULL
			// 					                          GROUP BY OU_D_ID
			// 					                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) $more_coop_query ) S) $search_datatable)";
			// $sql_count = "SELECT count($dis_count) as TOTAL FROM (
			// 				SELECT DISTINCT OU_D_ID,IN_D_COOP
			// 				FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
			// 				WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
			// 				                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
			// 				                          FROM MOIUSER.MASTER_DATA 
			// 				                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER' 
			// 				                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13 
			// 				                          AND LENGTH (MOIUSER.MASTER_DATA.OU_D_ID) = 13 
			// 				                          AND IN_D_COOP IS NOT NULL
			// 				                          AND OU_D_ID IS NOT NULL
			// 				                          AND OU_D_FLAG IN(1,2)
			// 				                          $life_status_query
			// 				                          $query_org_id
			// 				                          AND B.COOP_TYPE IS NOT NULL
			// 				                          GROUP BY OU_D_ID
			// 				                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) $more_coop_query ) S) $search_datatable)";
			



			if(!$export){
				$sql .=" OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
			}


			// echo print_r($sql);die();
			
			$status_array = array("0"=>"ปกติ",
					"1"=>"ตาย","11"=>"ตาย","13"=>"ตาย",
					"2"=>"จำหน่าย","3"=>"จำหน่าย","5"=>"จำหน่าย","7"=>"จำหน่าย","10"=>"จำหน่าย","12"=>"จำหน่าย",
					"4"=>"ย้ายไปต่างประเทศ",
					"6"=>"อยู่ระหว่างการหาข้อมูลเพิ่มเติม","8"=>"บุคคลในบ้านกลาง","9"=>"บุคคลอยู่ระหว่างการย้าย","14"=>"อยู่ระหว่างการปรับปรุงข้อมูล","15"=>"อยู่ระหว่างการตรวจสอบ");
			$status_array_text =array("1"=>"ปกติ","2"=>"ตาย");
			// echo $sql_count;

			// $cache_key = md5($sunm_keycache);
			// $cache_key_export = md5($sunm_keycache_ex);
			// $ci =& get_instance();
			// $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			// $data_cache = "";
			// $data_cache_export = "";
			
			// if ( ! $data_cache = $ci->cache->get($cache_key)) {
			
			// cache count
			// $cache_key_count = md5($sql_count);
			// $ci =& get_instance();
			// $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			// $data_cache_count = "";
			// $query_count = null;
			// if ( ! $data_cache_count = $ci->cache->get($cache_key_count)) {
			// 	$query_count = $this->db->query($sql_count)->result_array();

			// 	$ci->cache->save($cache_key_count, $query_count, 30000);
			// 	// return $query_count;
			// }else{
			// 	$query_count = $data_cache_count;
			// }

			$query_count = $this->db->query($sql_count)->result_array();
			$query_count_row = $this->db->query($sql_count_row)->result_array();

			
			
			// echo print_r($query_count );die();

			$coop_names = getAllCoops();
			
			$data_coop = array();
			
			foreach ($coop_names as $coop_name)
			{
				$data_coop[$coop_name['REGISTRY_NO_2']] = $coop_name['COOP_NAME_TH'];
				
			}
			
			$list_province = $this->getlistProvince($filter_khet,true);
			if(!empty($filter_khet))
			{
				$this->db->distinct('COL004');
				$this->db->where('COL004',$filter_khet);
				$query = $this->db->get('KHET')->result_array();
				$filter_khet = $query[0]['COL003'];
				
			}
			if(!empty($filter_district))
			{
				
				$AMPHUR = getAmphurNameByAmphurId($filter_district);
				$filter_district = $AMPHUR['AMPHUR_NAME'];
			}
			if(!empty($filter_provinces))
			{
				foreach ($list_province as $province)
				{
					if($province['id'] == $filter_provinces)
					{
						$filter_provinces = $province['name'];
					}
				}
			}
			// 			echo "<pre>";
			// 			print_r($filter_coop);
			// 			echo "</pre>";

			if(!empty($filter_coop))
			{
				$filter_coop = $data_coop[$filter_coop];
			}

			if(!empty($more_coop))
			{
				$more_coop_array = array("1"=>"เป็นสมาชิก 1 สหกรณ์","2"=>"เป็นสมาชิก 2  สหกรณ์","3"=>"ตั้งแต่ 3 สหกรณ์ขึ้นไป");
				$more_coop = $more_coop_array[$more_coop];
				
			}
			
			$text ="";
			// $text .= !empty($filter_khet)?$filter_khet." /":"";
			// $text .=!empty($filter_provinces)?" ".$filter_provinces." /":"";
			if (!empty($filter_khet) && !empty($filter_provinces)) {
				$text .=!empty($filter_khet)?$filter_khet." /":"เขตทั้งหมด";
			}elseif (empty($filter_khet) && !empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet."":"";
				$text .=!empty($filter_provinces)?" ".$filter_provinces."":"";
			}elseif (!empty($filter_khet) && empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet."":"";
				$text .=!empty($filter_provinces)?" ".$filter_provinces."":"";
			}elseif (empty($filter_khet) && empty($filter_provinces)){
				$text .=!empty($filter_khet)?$filter_khet." /":"ทั้งหมด /";
			}
			$text .=!empty($filter_district)?" ".$filter_district." /":"";
			$text .=!empty($filter_coop)?" ".$filter_coop." /":"";
			$text .=!empty($life_status)?" ".$status_array_text[$life_status]." /":"";
			$text .=!empty($more_coop)?" ".$more_coop." /":"";
			$text .=" จำนวนสมาชิก ".number_format($query_count[0]['TOTAL']);
			$text .=" คน";
			
			$textlog ="";
			$textlog.=!empty($filter_khet)?$filter_khet." ":"";
			$textlog.=!empty($filter_provinces)?" / ".$filter_provinces." ":"";
			$textlog.=!empty($filter_district)?"/ ".$filter_district." ":"";
			$textlog.=!empty($filter_coop)?" / ".$filter_coop." ":"";
			$textlog.=!empty($life_status)?" / ".$status_array_text[$life_status]." ":"";
			$textlog.=!empty($more_coop)?" / ".$more_coop." ":"";
	
			
			// if($show_query){
				
			
			// 	$data = array();
			// 	$temp = array();
			// 	$data['query'] = $sql;
			// 	$data['numrow'] = $text ;
			// 	$temp['items'] = $data;
			// 	print_r(json_encode($temp));
			// 	exit();
			// }
			
			// echo print_r($sql);die();
			$cache_key = md5($sql);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache = "";
			$query_nomal = null;
			if ( ! $data_cache = $ci->cache->get($cache_key)) {
				$query_nomal = $this->db->query($sql)
								->result_array();
				$ci->cache->save($cache_key, $query_nomal, 30000);

				// return $query_nomal;
			}else{
				$query_nomal = $data_cache;
			}
			

			
			// echo json_encode($query_nomal);
			// exit();
			
			$data_temp = array();
			if($export){
				$date_time = $this->changemonth();
				$data_temp[] =array('','','','','','',$date_time);
				$data_temp[] =array('รายงานข้อมูลสมาชิกในสหกรณ์','','','','');
				$data_temp[] = array($text,'','','','');
				$data_temp[] = array('เลขบัตรประชาชน','คำนำหน้า','ชื่อ','นามสกุล','สถานะสมาชิก','จังหวัด', 'ชื่อ สหกรณ์');
			}
			unset($coop_names);
			$count = 1;
			$count_row =1;
			// foreach ($query_nomal as $data) {
			// 	$citizen_data = getMemberByCitizenID($data['OU_D_ID']);
			// 			echo print_r($citizen_data);
			// 			die();
			// 		}
					
				foreach ($query_nomal as $data)
				{

					$citizen_data = getMemberByCitizenID($data['OU_D_ID']);
					// echo $citizen_data[0]['COOP_NAME_TH'];die();
					$temp_data = array();
					
					if(!$export){			
						$temp_data[]=!empty($citizen_data[0]['OU_D_ID'])?$citizen_data[0]['OU_D_ID']:"-";
					}else{
						$temp_data[]=!empty($citizen_data[0]['OU_D_ID'])?"'".$citizen_data[0]['OU_D_ID']:"-";
					}
					$temp_data[]=!empty($citizen_data[0]['OU_D_PREFIX'])?$citizen_data[0]['OU_D_PREFIX']:"-";
					$temp_data[]=!empty($citizen_data[0]['OU_D_PNAME'])?$citizen_data[0]['OU_D_PNAME']:"-";
					$temp_data[]=!empty($citizen_data[0]['OU_D_SNAME'])?$citizen_data[0]['OU_D_SNAME']:"-";
					$temp_data[]=!empty($status_array[trim($citizen_data[0]['OU_D_STATUS_TYPE'])])?$status_array[trim($citizen_data[0]['OU_D_STATUS_TYPE'])]:"-";					
					$temp_data[]=!empty($citizen_data[0]['IN_PROVICE_NAME'])?$citizen_data[0]['IN_PROVICE_NAME']:"-";					
					$temp_data[]=!empty($citizen_data[0]['COOP_NAME_TH'])?$citizen_data[0]['COOP_NAME_TH']:"-";		
					if(!$export){			
					$temp_data[]="<a href='javascript:void(0)' onclick='getUserDetailReport2(".$citizen_data[0]['OU_D_ID'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					}
					$data_temp[]=$temp_data;


					// New List
					
					// $citizen_data = getMemberByCitizenID($data['OU_D_ID']);
					// echo print_r($citizen_data);
					// 	die();

					// foreach ($citizen_data as $value) {
					// 	$coop = getCoopByID($value['IN_D_COOP']);
					// 	$datacoop= getDataCitizen($coop,$value);
					// 	// echo print_r($datacoop);
					// 	$temp_data = array();
					// 	// foreach ($datacoop as $value) {
					// 	// 	echo print_r($value);
					// 	// die();
					// 	// }
					// 	if(!$export){			
					// 		$temp_data[]=!empty($datacoop['citizen_id'])?$datacoop['citizen_id']:"-";
					// 	}else{
					// 		$temp_data[]=!empty($datacoop['citizen_id'])?"'".$datacoop['citizen_id']:"-";
					// 	}
					// 	$temp_data[]=!empty($datacoop['prefix'])?$datacoop['prefix']:"-";
					// 	$temp_data[]=!empty($datacoop['name'])?$datacoop['name']:"-";
					// 	$temp_data[]=!empty($datacoop['surname'])?$datacoop['surname']:"-";
					// 	$temp_data[]=!empty($status_array[trim($datacoop['ou_d_status'])])?$status_array[trim($datacoop['ou_d_status'])]:"-";					
					// 	$temp_data[]=!empty($datacoop['province_name'])?$datacoop['province_name']:"-";					
					// 	$temp_data[]=!empty($datacoop['coop_name'])?$datacoop['coop_name']:"-";	
						
					// 	$data_temp[]=$temp_data;
						
					// }
					// $data_temp[]=$temp_data;
					// echo print_r($data_temp);
					// die();
					$count++;
					







					
	
				}

			
				// $citicen = null;
				// echo print_r($data_temp);
				// die();
		
			
			$recordsTotal = $query_count_row[0]['TOTAL'];
			$recordsFiltered = $query_count_row[0]['TOTAL'];
		
			if(!empty($search)){
				$recordsTotal = $query_count[0]['TOTAL'];
				$recordsFiltered = $query_count[0]['TOTAL'];
			}
			//unset($master_data);
			// echo "<pre>";
			// print_r($filter_provinces);
			// echo "</pre>";
			// die();
	// 		echo "test11";
	// 		exit();

			if($export){
				// addLogSuspiciousMessageReport('พิมพ์รายงานข้อมูลสมาชิกในสหกรณ์', $textlog,$filter_provinces);
				// $ci->cache->save($cache_key_export, $data_temp, 30000);
				return $data_temp;

			}else{
				
				$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
				$output = array(
						"draw"    => intval($draw),
						"recordsTotal"  => intval($recordsTotal),
						"recordsFiltered" => intval($recordsFiltered),
						"data"   => $data_temp,
						"numtotal"   => $text
				);
				// $ci->cache->save($cache_key, $output, 30000);
				if (!empty($_GET["draw"]) && $_GET["draw"] == 1) {
					addLogSuspiciousMessageReport('รายงานข้อมูลสมาชิกในสหกรณ์', $textlog,$filter_provinces);
				}
				print_r(json_encode($output));
				// $this->load->view($textlog);
				die();
			}
		// 	print_r(json_encode($data_cache));
		// }else if ( ! $data_cache_export = $ci->cache->get($cache_key_export)) {
		// 	print_r(json_encode($data_cache_export));

		// }




		}else {
			redirect('/');
		}
	}
	
	/*
	 * ntk software
	 * 
	 * by Nattikorn
	 */
	public function ajax_org_list()
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
			
// 			$range = getStringSystemProperties('coop.ajax.range', 20);
// 			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
// 			$page = isset($_GET['page'])? $_GET['page'] :30;
			
			$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):$this->session->userdata('filter_district');
// 			echo "<pre>";
// 			print_r($filter_provinces);
// 			echo "</pre>";
			
			
			$filter_district = !empty($filter_district) ? $filter_district : $this->session->userdata('filter_district');
			
			
			
			
// 			$filter_district = $this->session->userdata('filter_district');
// 			$filter_provinces = ($this->session->userdata('filter_province'));
// 			print_r($filter_provinces);die();
			$All_coops = $this->cache->get('All_coops');
			if(empty($test))
			{
				$All_coops = getAllCoops();
			}
			
			$district_search = array();
			$temp_data = array();
			foreach ($All_coops as $coop)
			{
				
				$temp  = array();
				$temp['id'] = $coop['ORG_ORG_ID'];
				$temp['name'] = $coop['ORG_NAME'];
				if($coop['PROVINCE_NAME'] == $filter_provinces && empty($temp_data[$coop['ORG_ORG_ID']]) && $coop['AMPHUR_ID'] == $filter_district)
				{
					$district_search[] = $temp;
					$temp_data[$coop['ORG_ORG_ID']]=$coop['ORG_NAME'];
				}
				else if($coop['PROVINCE_NAME'] == $filter_provinces && empty($temp_data[$coop['ORG_ORG_ID']]) && empty($filter_district))
				{
					
					$district_search[] = $temp;
					$temp_data[$coop['ORG_ORG_ID']]=$coop['ORG_NAME'];
				}
			}
			$temp  = array();
			$temp['items'] = $district_search;
			echo json_encode($temp);
			
			
		}
		else
			echo "no permission";
	}
	
	public function ajax_tambom()
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
			
			$range = getStringSystemProperties('coop.ajax.range', 20);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
			$page = isset($_GET['page'])? $_GET['page'] :30;
			$filter_district = !empty($filter_district) ? $filter_district : $this->session->userdata('filter_district');
			
			$filter_district = $this->session->userdata('filter_district');
			$filter_provinces = ($this->session->userdata('filter_province'));
			
			$page = $page-1;
			$cache_key = isset($_GET['cache_key'])? $_GET['cache_key'] :"coopquery-"."$filter_district-".$keyword;
			
			$tombons = getAllTombon();
			
// 			print_r($filter_district);die();
			foreach ($tombons as $tombon){
				//strpos($district->TAMBON_NAME,$keyword)!==FALSE && 
				if($tombon->AMPHUR_AMPHUR_ID == $filter_district){
					$temp['id'] = $tombon->TAMBON_ID;
					$temp['name'] = $tombon->TAMBON_NAME;
					$temp['text'] = $tombon->TAMBON_NAME;
					$temp['username'] = $tombon->TAMBON_NAME;
					$temp['user_id'] = $tombon->TAMBON_ID;
					$temp['username'] = $tombon->TAMBON_NAME;
					$temp['coop_reg'] = $tombon->TAMBON_NAME;
					$district_search[] = $temp;
				}
			}
			$temp = array();
			$temp['items'] = $district_search;
			echo json_encode($temp);
			
		}else 
			echo "no permission";
	}
	
	public function ajax_District()
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
			
			$range = getStringSystemProperties('coop.ajax.range', 20);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
			$page = isset($_GET['page'])? $_GET['page'] :30;
			//$filter_province = !empty($filter_province) ? $filter_province : $this->session->userdata('filter_province');
			
			$filter_province = !empty($this->input->get('province'))?$this->input->get('province'):$this->session->userdata('filter_district');
			$page = $page-1;
			$cache_key = isset($_GET['cache_key'])? $_GET['cache_key'] :"coopquery-"."$filter_province-".$keyword;
			
			//if ( ! $users_with_keyword = $this->cache->get($cache_key))
			
			$sql = "select * from DISTRICT where AMPHUR_ID in (select AMPHUR_ID from COOP_INFO where ORG_ID =$filter_province group BY AMPHUR_ID)";
			
// 			$districts = getAllDistrict();
			$districts = $this->db->query($sql)->result();
			$district_search = array();
			foreach ($districts as $district)
			{
// 				if($district->PROV_PROVINCE_ID == $filter_province){
					$temp = array();
					$temp['id'] = $district->AMPHUR_ID;
					$temp['name'] = $district->AMPHUR_NAME;
					
					
					$district_search[] = $temp;
					unset($temp);
// 				}
			}
			
// 			echo "<pre>";
// 			print_r($district_search);
// 			die();
			
			$temp = array();
			$temp['items'] = $district_search;
			$temp['query'] ="select * from DISTRICT";
			echo json_encode($temp);
			
		}
		else
			echo "no permission";
	}
	
	public function ajax_coop_group()
	{
		// ini_set("memory_limit", "3024M");
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$province = !empty($this->input->get('province'))?$this->input->get('province'):null;
			$page = !empty($this->input->get('page'))?$this->input->get('page'):1;
			$end = !empty($this->input->get('end'))?$this->input->get('start'):10;
			$start = 0;
			
// 			echo "<pre>";
// 			print_r($_POST);
// 			echo "</pre>";
// 			echo "<pre>";
// 			print_r($_GET);
// 			echo "</pre>";
// 			die();
// 			exit();
			
			if($page !=0 )
			{
				if($page != 1 ){
					
					$start = $page * 10;
					$end = $start + 10;
				}
				else {
					$start = $page;
					$end = 10;
				}
				
			}
			
			$all_coops = getAllCoops();
			
			$array_coop = array();
// 			echo "<pre>";
// 			print_r($all_coops);
// 			echo "</pre>";
			$numrow = 1;
			foreach ($all_coops as $coop)
			{
// 				echo "<pre>";
// 				print_r($coop['COOP_TYPE']);
// 				echo "</pre>";
				if(intval($coop['COOP_TYPE'])>8){
					if($numrow>=$start && $numrow<=$end){
						if(!is_null($province) && $province == $coop['PROVINCE_ID']){
							$array_coop[] = array(
									'id'=>$coop['REGISTRY_NO_2'],
									'name'=>$coop['COOP_NAME_TH']
							);
							$numrow++;
						}else if(is_null($province)){
							$array_coop[] = array(
									'id'=>$coop['REGISTRY_NO_2'],
									'name'=>$coop['COOP_NAME_TH']
							);
							$numrow++;
						}
					}else if($numrow>$end)
					{
						break;
					}
					
					
				}
				
			}
			
// 			echo "<pre>";
// 			print_r($array_coop);
// 			echo "</pre>";
			$temp['total_count'] = sizeof($all_coops);
			$temp['page'] = $page;
			$temp['items'] = $array_coop;
			echo json_encode($temp);
			
			
		}
		
		
	}
	
	
	public function ajax_coop_all()
	{
		// ini_set("memory_limit", "3024M");
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$province = !empty($this->input->get('province'))?$this->input->get('province'):null;
			$page = !empty($this->input->get('page'))?$this->input->get('page'):1;
			$end = !empty($this->input->get('end'))?$this->input->get('start'):10;
			$start = 0;
			
			
			if(empty($province))
			{
				$temp['total_count'] = sizeof($all_coops);
			$temp['page'] = $page;
			$temp['items'] = $array();
			echo json_encode($temp);
			exit();
			}


			if($page !=0 )
			{
				if($page != 1 ){
					
					$start = intval($page) * 10;
					$end = $start + 10;
				}
				else {
					$start = intval($page);
					$end = 10;
				}
				
			}
			
			$all_coops = getAllCoops();
			
			$array_coop = array();
// 			echo "<pre>";
// 			print_r($all_coops);
// 			echo "</pre>";
			$numrow = 1;
			foreach ($all_coops as $coop)
			{
// 				echo "<pre>";
// 				print_r($coop['COOP_TYPE']);
// 				echo "</pre>";
				if(intval($coop['COOP_TYPE'])<=8){
					// if($numrow>=$start && $numrow<=$end){
						if(!is_null($province) && $province == $coop['PROVINCE_ID']){
							$array_coop[] = array(
									'id'=>$coop['REGISTRY_NO_2'],
									'name'=>$coop['COOP_NAME_TH']
							);
							$numrow++;
						}else if(is_null($province)){
							$array_coop[] = array(
									'id'=>$coop['REGISTRY_NO_2'],
									'name'=>$coop['COOP_NAME_TH']
							);
							$numrow++;
						}
					// }else if($numrow>$end)
					// {
						// break;
					// }
					
					
				}
				
			}
			
// 			echo "<pre>";
// 			print_r($array_coop);
// 			echo "</pre>";
			$temp['total_count'] = sizeof($all_coops);
			$temp['page'] = $page;
			$temp['items'] = $array_coop;
			echo json_encode($temp);
			
			
		}
		
	}
	
	public function ajax_coop($filter_province="")
	{
		
		// no cache
		ini_set("memory_limit", "3024M");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
			
			$range = getStringSystemProperties('coop.ajax.range', 20);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
			$page = isset($_GET['page'])? $_GET['page'] :1;
			
			
			// echo $this->input->get('filter_khet');die();
			
			if ($this->input->get('filter_khet') == 0) {
				$filter_khet = $this->input->get('filter_khet');
			}else if ($this->input->get('filter_khet') == ''){
				$filter_khet = 0;
			}else{
				$filter_khet = $this->input->get('filter_khet');
			}
			
			$filter_khet = !empty($this->input->get('filter_khet'))?$this->input->get('filter_khet'):$filter_khet;
			$filter_tambon = !empty($this->input->get('filter_tambon'))?$this->input->get('filter_tambon'):"";
			$filter_district = !empty($this->input->get('filter_district'))?$this->input->get('filter_district'):"";
			$filter_provinces = !empty($this->input->get('province'))?$this->input->get('province'):"";
			
			
			// echo $filter_khet;die();
			
			$province_of_khet = getProvinceOfKhetById(intval($filter_khet));
	
			$province_of_khet_array = array();

			foreach ($province_of_khet as $data_khet)
			{
				// array_push($province_of_khet_array,trim($data_khet['COL011']));
				array_push($province_of_khet_array,trim($data_khet['COL011']));
				
			}
// 			echo "<pre>";
// 			print_r($province_of_khet);
// 			echo "</pre>";
// 			echo "<pre>";
// 			print_r($province_of_khet_array);
// 			die();
			
			$page = $page-1;
			$cache_key = isset($_GET['cache_key'])? $_GET['cache_key'] :"coopquery-"."$filter_province-".$keyword;
			
// 			$all_coops = $this->cache->get('All_coops');
// 			if(!isset($all_coops)){
			ini_set("memory_limit", "6024M");
			$all_coops = getAllCoops();
// 			}
			$return_results = array();
// 			if(!empty($filter_provinces)){
// 				$sql = "select PROVINCE_ID from COOP_INFO where ORG_ID ='$filter_provinces' group BY PROVINCE_ID";
				
// 				// 			$districts = getAllDistrict();
// 				$provinc = $this->db->query($sql)->result_array();
				
				
// 				$filter_provinces=$provinc[0]['PROVINCE_ID'];
// 			}
			
			
// 			if(!empty($keyword) && $keyword != 0)
// 			foreach ($all_coops as $all_coop)
// 			{
				
				
				
// 				$name = trim($all_coop['COOP_NAME_TH']);
// 				$temp = array();
// 				$temp['user_id'] = $all_coop['REGISTRY_NO_2'];
// 				$temp['name'] = $name;
// 				$temp['username'] = trim($all_coop['COOP_NAME_TH']);
// 				$temp['coop_reg'] = trim($all_coop['REGISTRY_NO_2']);
// 				$temp['id'] = trim($all_coop['REGISTRY_NO_2']);
// 				$temp['text'] = trim($name);
// 				if((strpos($all_coop['COOP_NAME_TH'],$keyword)!==FALSE || strpos($all_coop['REGISTRY_NO_2'],$keyword)!==FALSE) && $all_coop['TAMBON_ID']==$filter_tambon)
// 				{
					
// 					$return_results[] = $temp;
// 				}else if((strpos($all_coop['COOP_NAME_TH'],$keyword)!==FALSE || strpos($all_coop['REGISTRY_NO_2'],$keyword)!==FALSE) && $all_coop['AMPHUR_ID']==$filter_district && empty($filter_provinces))
// 				{
// 					$return_results[] = $temp;
// 				}else if((strpos($all_coop['COOP_NAME_TH'],$keyword)!==FALSE || strpos($all_coop['REGISTRY_NO_2'],$keyword)!==FALSE) && $all_coop['ORG_ID']==$filter_provinces)
// 				{
// 					$return_results[] = $temp;
// 				}
// 				unset($temp);
// 			}

// 			if(empty($keyword))
				foreach ($all_coops as $all_coop)
				{
					
					$name = trim($all_coop['COOP_NAME_TH']);
					$temp = array();
					$temp['name'] = $name;
					$temp['id'] = trim($all_coop['REGISTRY_NO_2']);
					if(!empty($filter_tambon) && $all_coop['TAMBON_ID']==$filter_tambon && $all_coop['REGISTRY_NO_2'] !="0" && $all_coop['REGISTRY_NO_2'] !=0)
					{
						
						$return_results[] = $temp;
					}else if(!empty($filter_district)  && $all_coop['AMPHUR_ID']==$filter_district && !empty($filter_provinces) && $all_coop['REGISTRY_NO_2'] !="0" && $all_coop['REGISTRY_NO_2'] !=0)
					{
						$return_results[] = $temp;
					}else if(!empty($filter_provinces) && trim($all_coop['ORG_ID'])==trim($filter_provinces) && empty($filter_district) && $all_coop['REGISTRY_NO_2'] !="0" && $all_coop['REGISTRY_NO_2'] !=0)
					{
						$return_results[] = $temp;
					}
					else if(in_array(trim($all_coop['ORG_ID']), $province_of_khet_array,TRUE) && empty($filter_provinces) && $all_coop['REGISTRY_NO_2'] !="0" && $all_coop['REGISTRY_NO_2'] !=0){
						$return_results[] = $temp;
					}
// 					else if( empty($filter_district) && empty($filter_provinces) && sizeof($var)$province_of_khet_array){
// 						$return_results[] = $temp;
// 					}
					unset($temp);
				}
			
			$temp = array();
			$temp['items'] = $return_results;
			echo json_encode($temp);
// 			echo "<pre>";
// 			print_r($temp);
// 			echo "</pre>";
			
			
			
			
		}
	}
	
	public function ajax_coops($filter_province="")
	{
		
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
			
			$range = getStringSystemProperties('coop.ajax.range', 20);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
			$page = isset($_GET['page'])? $_GET['page'] :1;
			$filter_province = !empty($filter_province) ? $filter_province : $this->session->userdata('filter_province');

			$page = $page-1;
			$cache_key = isset($_GET['cache_key'])? $_GET['cache_key'] :"coopquery-"."$filter_province-".$keyword;
			
			//if ( ! $users_with_keyword = $this->cache->get($cache_key))
			$users_with_keyword =null;
			if (true)
			{
				$users_with_keyword = getCoopsByKeyword($keyword,$filter_province);
				$this->cache->save($cache_key,$users_with_keyword, 300); //5 minute
			}
			
			$temp['items'] = array();
			if (!empty($users_with_keyword))
			{
				$count = 0;
				$from = $page*$range;
				$to = $from+$range;
				
				foreach ($users_with_keyword as $user)
				{
					if ($count>=$from && $count<$to)
					{
						$temp['items'][] = $user;
					}
					$count++;
				}
			}
			echo json_encode($temp);
		}
		else
			echo "no permission";
	}	
		
	public function ajax_coops2($filter_province="")
	{
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$userID = $this->session->userdata('auth_user_id');
				
			$range = getStringSystemProperties('coop.ajax.range', 20);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword']:0;
			$page = isset($_GET['page'])? $_GET['page'] :1;
			
			$page = $page-1;
			$cache_key = isset($_GET['cache_key'])? $_GET['cache_key'] :"coopquery2-".$keyword;
				
			//if ( ! $users_with_keyword = $this->cache->get($cache_key))
			if (true)
			{
				$users_with_keyword = getCoopsByKeyword2($keyword);
				$this->cache->save($cache_key,$users_with_keyword, 300); //5 minute
			}
				
			$temp['items'] = array();
			if (!empty($users_with_keyword))
			{
				$count = 0;
				$from = $page*$range;
				$to = $from+$range;
	
				foreach ($users_with_keyword as $user)
				{
					if ($count>=$from && $count<$to)
					{
						$temp['items'][] = $user;
					}
					$count++;
				}
			}
			echo json_encode($temp);
		}
	}
	public function ajax_set_filter_coop($filter_coop="")
	{
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$filter_district = urldecode($filter_coop);
			
			$this->session->set_userdata('filter_coop',$filter_coop);
			
			echo json_encode(array($filter_coop));
			
			die($filter_coop);
		}
		else
			echo "no permission";
	}
	
   		public function ajax_set_filter_tambon($filter_tambon="")
        {
            // no cache
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            
            if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
            {
                $filter_district = urldecode($filter_tambon);
                
                $this->session->set_userdata('filter_tambon',$filter_tambon);
                
                echo json_encode(array($filter_tambon));
                
                die($filter_tambon);
            }
            else
                echo "no permission";
        }
        
        
	public function ajax_set_filter_district($filter_district="")
	{
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$filter_district = urldecode($filter_district);
			
			$this->session->set_userdata('filter_district',$filter_district);
			$this->session->set_userdata('filter_tambon','');
			
			echo json_encode(array($filter_district));
			
			die($filter_district);
		}
		else
			echo "no permission";
	}

	public function ajax_set_filter_province($filter_province="")
	{
		
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$filter_province = urldecode($filter_province);
			
			$this->session->set_userdata('filter_province',$filter_province);
			$this->session->set_userdata('filter_district','');
			$this->session->set_userdata('filter_tambon','');
			$this->session->set_userdata('filter_coop','');
			echo json_encode(array($filter_province));
			
			die($filter_province);
		}
		else
			echo "no permission";
	}
	
	function getExportReportFile($data,$namefile){
		
		$ci =& get_instance();
		$user_info = $ci->session->userdata();
		
		$file_path = "export-".$namefile."-".$user_info['auth_user_id'].".xls";
		
		require_once(dirname(__FILE__).'/../third_party/php-excel-master/third_party/PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		
		// Add new sheet
		//$sheet = $objPHPExcel->createSheet(1); //Setting index when creating
		$sheet = $objPHPExcel->getActiveSheet();
		$results = $data;
		$sheet->fromArray($results);
		$sheet->setTitle("Data");
		$countRow = sizeof($data);
		$column = 'E';
		$strFilds = $column.'1:'.$column.''.$countRow;
		$sheet->fromArray($results)->getStyle($strFilds)->getNumberFormat()->setFormatCode('0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($file_path);		
		return $file_path;
	}
	
	protected function _export_to_excel($data)
	{
		/**
		 * No need to use an external library here. The only bad thing without using external library is that Microsoft Excel is complaining
		 * that the file is in a different format than specified by the file extension. If you press "Yes" everything will be just fine.
		 * */
		
		$string_to_export = "";
		foreach($data as $column){
			$string_to_export .= $column->display_as."\t";
		}
		$string_to_export .= "\n";
		
		foreach($data->list as $num_row => $row){
			foreach($data->columns as $column){
				$string_to_export .= $this->_trim_export_string($row->{$column->field_name})."\t";
			}
			$string_to_export .= "\n";
		}
		
		// Convert to UTF-16LE and Prepend BOM
		$string_to_export = "\xFF\xFE" .mb_convert_encoding($string_to_export, 'UTF-16LE', 'UTF-8');
		
		$filename = "export-".date("Y-m-d_H:i:s").".xls";
		
		header('Content-type: application/vnd.ms-excel;charset=UTF-16LE');
		header('Content-Disposition: attachment; filename='.$filename);
		header("Cache-Control: no-cache");
		echo $string_to_export;
		die();
	}

	public function exportdatacsvreport3($surveys,$filename)
	{
		ob_start();		
// 		print_graph($data);
		$data= array();
		$header_excel = array('รหัสบัตรประชาชน','ชื่อ','นามสกุล','หมายเลขสหกรณ์');
		$data[] = $header_excel;
		foreach ($surveys as $rows) {
			$temp= array();
			$temp[]	=  $rows['citizen_id'];
			$temp[]	=  $rows['citizen_firstname'];
			$temp[]	=  $rows['citizen_lastname'];			
			$temp[]	=  $rows['COOP_ID'];
			$data[] = $temp;
		}
		$df = fopen('php://output', 'a');
		foreach ($data as $rows) {
			$temp = array();	
			foreach ($rows as $row)	
				$temp[] = iconv('UTF-8','tis-620', $row);		
			
				fputcsv($df, $temp);
				unset($temp);
			
		}
		
		fclose($df);
		
		$string = ob_get_clean();
		
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
		header('Content-Transfer-Encoding: binary');
		
		exit($string);
	}
	
	function getExportReportFileData($all_case_docs,$filename,$column='E'){
		
		ini_set("memory_limit", "512M");
// 		$ci =& get_instance();
// 		$user_info = $this->session->userdata();
		$date = date_create();
		
		$file_path = "assets/uploads/export-report-".date_timestamp_get($date)."-".$filename.".xlsx";
		require_once(dirname(__FILE__).'/../third_party/php-excel-master/third_party/PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		
// 		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
// 		$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
// 		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
// 		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
// 		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
// 		$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
// 		$objPHPExcel->getProperties()->setCategory("Test result file");
		
		$countRow = sizeof($all_case_docs);
		$strFilds = $column.'1:'.$column.''.$countRow;
		
		$sheet = $objPHPExcel->getActiveSheet();
		//      $results = $all_case_docs;
		$sheet->fromArray($all_case_docs)->getStyle($strFilds)->getNumberFormat()->setFormatCode('0');
		//$sheet->fromArray($all_case_docs);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($file_path);
// 		$objPHPExcel->disconnectWorksheets();
		
		
		return $file_path;
	}
	public function changemonth()
	{
		// 		echo date(" m ");
		// 		echo date("Y")+543;
		
		$str_month = date("m");
		$str_year = intval(date("Y")+543);
		$thaimonth=array('01'=>"มกราคม",'02'=>"กุมภาพันธ์",'03'=>"มีนาคม",'04'=>"เมษายน",'05'=>"พฤษภาคม",'06'=>"มิถุนายน",'07'=>"กรกฎาคม",'08'=>"สิงหาคม",'09'=>"กันยายน",'10'=>"ตุลาคม",'11'=>"พฤศจิกายน",'12'=>"ธันวาคม");
		$date_time = 'ข้อมูล ณ '. date(" j ").  $thaimonth[$str_month]  . " พ.ศ. ".$str_year;
		return $date_time;
	}

	public function getMemberByCitizenID($citizen_id="")
	{
		
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$citizen_id = !empty($this->input->get('citizen_id'))?$this->input->get('citizen_id'):null;
			$check_permission = !empty($this->input->get('check'))?$this->input->get('check'):false;
			// $start = !empty($this->input->get('start'))?$this->input->get('start'):0;
			// $length = !empty($this->input->get('length'))?$this->input->get('length'):10;
			$temp = array();
			// $coops = getMemberByCitizenID($citizen_id,$start,$length);
			$coops = getMemberByCitizenID($citizen_id);
			$pcheck = null;

			$role_user = $this->session->userdata('auth_role');
			$user_id = $this->session->userdata('auth_user_id');
			$user = getUser($user_id);
			$detail_user = getOrgByID($user['org_id']);

			$count = 1;
			$check_same_log = null;
			if (!empty($citizen_id)){
				if ($check_permission) {
					foreach ($coops as $key => $value) {

						$coop = getCoopByID($value['IN_D_COOP']);
						$logtype = 1;
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$name = $value['OU_D_PNAME'].' '.$value['OU_D_SNAME'];
						if ($role_user == 'notcentral_normal') {

							if ($coop['ORG_ID'] == $user['org_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else if ($coop['PROVINCE_ID'] == $detail_user['province_id']){
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$pcheck = 1;
								$logtype = 2;
							}
						
						}else if ($role_user == 'notcentral_manager') {

								$khet = getOrgByID($coop['ORG_ID']);
								// echo "<pre>".print_r($khet)."</pre>";
								// echo "<pre>".print_r($detail_user)."</pre>";
							$real_khet = null;
							$user_khet = null;
							if ($khet['khet_id'] == 99) {
								$real_khet = 1;
							}else{
								$real_khet = $khet['khet_id'];
							}
							if ($detail_user['khet_id'] == 99) {
								$user_khet = 1;
							}else{
								$user_khet = $detail_user['khet_id'];
							}

							if ($real_khet == $user_khet) {
								if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 1;		
								}else{
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 3;
								}
							}else{
								$pcheck = 1;
								$logtype = 4;
							}

						}else{
							if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 5;
							}
						}

						if (empty($check_same_log)){
							addLogSuspiciousMessage($citizen_id,$name,$logtype,"มีการเข้าถึงบัตรประชาชน");
							$check_same_log = 1 ;
						}

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}

				}else{
					foreach ($coops as $key => $value) {
						$coop = getCoopByID($value['IN_D_COOP']);
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$data[$key] = getDataCitizen($coop,$value);

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";						
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}
				}
			}

			$show_query = !empty($this->input->get('query'))?TRUE:FALSE;
			if (!empty($data)){
				if($show_query)
				{
					$temp['items'] = $data;
					echo json_encode($temp);
					exit();
				}
				$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
				$output = array(
						"draw"    => intval($draw),
						"data"   => $data_temp
				);
				print_r(json_encode($output));
			}else if ($pcheck == 1){
				$temp['permission'] = "nopermission";
				echo json_encode($temp);
				exit();
			}else{
				echo "ไม่พบข้อมูลที่ค้นหา";
			}
		}
		else
			echo "nopermission";
	}

	public function getMemberReport2ByCitizenID($citizen_id="")
	{
		
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$citizen_id = !empty($this->input->get('citizen_id'))?$this->input->get('citizen_id'):null;
			$check_permission = !empty($this->input->get('check'))?$this->input->get('check'):false;
			// $start = !empty($this->input->get('start'))?$this->input->get('start'):0;
			// $length = !empty($this->input->get('length'))?$this->input->get('length'):10;
			$temp = array();
			// $coops = getMemberByCitizenID($citizen_id,$start,$length);
			$coops = getMemberByCitizenID($citizen_id);
			$pcheck = null;

			$role_user = $this->session->userdata('auth_role');
			$user_id = $this->session->userdata('auth_user_id');
			$user = getUser($user_id);
			$detail_user = getOrgByID($user['org_id']);

			$count = 1;
			$check_same_log = null;
			if (!empty($citizen_id)){

				if ($check_permission) {
					foreach ($coops as $key => $value) {

						$coop = getCoopByID($value['IN_D_COOP']);
						$logtype = 1;
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$name = $value['OU_D_PNAME'].' '.$value['OU_D_SNAME'];
						if ($role_user == 'notcentral_normal') {

							if ($coop['ORG_ID'] == $user['org_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else if ($coop['PROVINCE_ID'] == $detail_user['province_id']){
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$data[$key] = getDataCitizen($coop,$value);
								$pcheck = 1;
								$logtype = 2;
							}
						
						}else if ($role_user == 'notcentral_manager') {

								$khet = getOrgByID($coop['ORG_ID']);
								// echo "<pre>".print_r($khet)."</pre>";
								// echo "<pre>".print_r($detail_user)."</pre>";
							$real_khet = null;
							$user_khet = null;
							if ($khet['khet_id'] == 99) {
								$real_khet = 1;
							}else{
								$real_khet = $khet['khet_id'];
							}
							if ($detail_user['khet_id'] == 99) {
								$user_khet = 1;
							}else{
								$user_khet = $detail_user['khet_id'];
							}

							if ($real_khet == $user_khet) {
								if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 1;		
								}else{
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 3;
								}
							}else{
								$data[$key] = getDataCitizen($coop,$value);
								$pcheck = 1;
								$logtype = 4;
							}

						}else{
							if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 5;
							}
						}

						if (empty($check_same_log)){
							addLogSuspiciousMessage($citizen_id,$name,$logtype,"มีการเข้าถึงบัตรประชาชน");
							$check_same_log = 1 ;
						}

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}

				}else{
					foreach ($coops as $key => $value) {
						$coop = getCoopByID($value['IN_D_COOP']);
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$data[$key] = getDataCitizen($coop,$value);

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";						
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}
				}
				
			}

			$show_query = !empty($this->input->get('query'))?TRUE:FALSE;
			if (!empty($data)){
				if($show_query)
				{
					$temp['items'] = $data;
					echo json_encode($temp);
					exit();
				}
				$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
				$output = array(
						"draw"    => intval($draw),
						"data"   => $data_temp
				);
				print_r(json_encode($output));
			}else if ($pcheck == 1){
				$temp['items'] = "nopermission";
				echo json_encode($temp);
				exit();
			}else{
				echo "ไม่พบข้อมูลที่ค้นหา";
			}
		}
		else
			echo "nopermission";
	}

	public function getMemberByCitizenIDOrgID($citizen_id="",$org_id="")
	{
		
		// no cache
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
		{
			$citizen_id = !empty($this->input->get('citizen_id'))?$this->input->get('citizen_id'):null;
			$org_id = !empty($this->input->get('org_id'))?$this->input->get('org_id'):null;
			$check_permission = !empty($this->input->get('check'))?$this->input->get('check'):false;
			// $start = !empty($this->input->get('start'))?$this->input->get('start'):0;
			// $length = !empty($this->input->get('length'))?$this->input->get('length'):10;
			$temp = array();
			// $coops = getMemberByCitizenID($citizen_id,$start,$length);
			$coops = getMemberByCitizenIDAndOrgID($citizen_id,$org_id);
			$pcheck = null;
			// echo print_r($coops);die();
			$role_user = $this->session->userdata('auth_role');
			$user_id = $this->session->userdata('auth_user_id');
			$user = getUser($user_id);
			$detail_user = getOrgByID($user['org_id']);

			$count = 1;
			$check_same_log = null;
			if (!empty($citizen_id)){
				if ($check_permission) {
					foreach ($coops as $key => $value) {

						$coop = getCoopByID($value['IN_D_COOP']);
						$logtype = 1;
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$name = $value['OU_D_PNAME'].' '.$value['OU_D_SNAME'];
						if ($role_user == 'notcentral_normal') {

							if ($coop['ORG_ID'] == $user['org_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else if ($coop['PROVINCE_ID'] == $detail_user['province_id']){
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$pcheck = 1;
								$logtype = 2;
							}
						
						}else if ($role_user == 'notcentral_manager') {

								$khet = getOrgByID($coop['ORG_ID']);
								// echo "<pre>".print_r($khet)."</pre>";
								// echo "<pre>".print_r($detail_user)."</pre>";
							$real_khet = null;
							$user_khet = null;
							if ($khet['khet_id'] == 99) {
								$real_khet = 1;
							}else{
								$real_khet = $khet['khet_id'];
							}
							if ($detail_user['khet_id'] == 99) {
								$user_khet = 1;
							}else{
								$user_khet = $detail_user['khet_id'];
							}

							if ($real_khet == $user_khet) {
								if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 1;		
								}else{
									$data[$key] = getDataCitizen($coop,$value);
									$logtype = 3;
								}
							}else{
								$pcheck = 1;
								$logtype = 4;
							}

						}else{
							if ($coop['PROVINCE_ID'] == $detail_user['province_id']) {
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 1;
							}else{
								$data[$key] = getDataCitizen($coop,$value);
								$logtype = 5;
							}
						}

						if (empty($check_same_log)){
							addLogSuspiciousMessage($citizen_id,$name,$logtype,"มีการเข้าถึงบัตรประชาชน");
							$check_same_log = 1 ;
						}

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}

				}else{
					foreach ($coops as $key => $value) {
						$coop = getCoopByID($value['IN_D_COOP']);
						// array_push($data, $coop);
						// echo $role_user;
						// echo print_r($value);die();
						$data[$key] = getDataCitizen($coop,$value);

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($value['OU_D_ID'])?$value['OU_D_ID']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";						
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;
							
					}
				}
			}

			$show_query = !empty($this->input->get('query'))?TRUE:FALSE;
			if (!empty($data)){
				if($show_query)
				{
					$temp['items'] = $data;
					echo json_encode($temp);
					exit();
				}
				$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
				$output = array(
						"draw"    => intval($draw),
						"data"   => $data_temp
				);
				print_r(json_encode($output));
			}else if ($pcheck == 1){
				$temp['items'] = "nopermission";
				echo json_encode($temp);
				exit();
			}else{
				echo "ไม่พบข้อมูลที่ค้นหา";
			}
		}
		else
			echo "nopermission";
	}

	public function getUserListByName()
	{	

		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		ini_set('max_execution_time', -1);
			ini_set("memory_limit", "8124M");
		
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')) 
				&& (canViewReport() || canAdd()))
		{
			
// 			include(APPPATH."third_party/mpdf/mpdf.php");
 			$pname = isset($_GET['coop_membername'])? trim($_GET['coop_membername']): "";
 			$start = isset($_GET['start'])? trim($_GET['start']): 0;
 			$length = isset($_GET['length'])? trim($_GET['length']): 10;
			
			// check access
			// checkSuspiciousActivityMahadthai($citizen_id, "ViewReport2-1", getSelectedSurveyYear());

			//addLogSuspiciousMessage($citizen_id, "ViewReport2-1");			
			
			// $export = isset($_GET['exportdata'])?trim($_GET['exportdata']):"";
			
			if(!empty($export))
			{
				
			}
			//echo $this->load->view('auth/page_header', '', TRUE);
			
			if (strlen($pname) == '' || is_numeric($pname))
			{
				echo $this->load->view('survey_error', array('message'=>'กรอกชื่อค้นหาไม่ถูกต้อง'), TRUE);
				
				echo $this->load->view('auth/page_footer', '', TRUE);
				
				//die();
			}

			$year = getSelectedSurveyYear();
			
			$coops = getMemberByName($pname,$start,$length);
			$query_count = getCountMemberByName($pname);
			// echo print_r($query_count);die();

			// $recordsTotal = $query_count[0]['TOTAL'];
			// $recordsFiltered = $query_count[0]['TOTAL'];

			$data = array();
			$pcheck = 0;

			$user_id = $this->session->userdata('auth_user_id');
			$user = getUser($user_id);

			$role_user = $this->session->userdata('auth_role');
			/*echo "<pre>".print_r($coops)."</pre>";
			die();*/
			$count = $start+1;

				if (!empty($pname)){

					foreach ($coops as $key => $value) {
						$coop = getCoopByID($value['IN_D_COOP']);
						// array_push($data, $coop);
						 // echo "<pre>".print_r(strtotime($value['OU_D_BDATE']))."</pre>";die();
							$data[$key] = getDataCitizen($coop,$value);

						$temp_data = array();
						$temp_data[]=$count;
						$temp_data[]=!empty($value['OU_D_PNAME'])?$value['OU_D_PNAME']:"-";
						$temp_data[]=!empty($value['OU_D_SNAME'])?$value['OU_D_SNAME']:"-";
						$temp_data[]=!empty($coop['COOP_NAME_TH'])?$coop['COOP_NAME_TH']:"-";
						$temp_data[]=!empty($coop['PROVINCE_NAME'])?$coop['PROVINCE_NAME']:"-";
						$temp_data[] ="<a href='javascript:void(0)' onclick='getUserDetail(".$value['OU_D_ID'].",".$value['IN_D_COOP'].");'><i class='fa fa-eye'></i> <strong>ดูรายละเอียด</strong></a>";
					
						$data_temp[]=$temp_data;
						$count++;	
					}

				}
			
			
			//$existing_surveys = getAllSurveyRecordByCitizenIDYear($citizen_id);

			$recordsTotal = $query_count[0]['TOTAL'];
			$recordsFiltered = $query_count[0]['TOTAL'];
			
			
			if(!empty($data_temp)){
				$draw = !empty($_GET["draw"])?$_GET["draw"]:0;
				$output = array(
						"draw"    => intval($draw),
						"recordsTotal"  => intval($recordsTotal),
						"recordsFiltered" => intval($recordsFiltered),
						"data"   => $data_temp
				);
				print_r(json_encode($output));
				
				die();
			}else{
				echo "ไม่พบข้อมูลที่ค้นหา";
			}
			
		}
		else
		{
			redirect('/');
		}
	}

}