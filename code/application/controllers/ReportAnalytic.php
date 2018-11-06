<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// namespace code\application\controllers;

class ReportAnalytic extends MY_Controller {
	
	private $listfilter = array("","100000-300000","300000-500000","500000");
	public function __construct()
	{
		parent::__construct();
		//include(APPPATH."third_party/mpdf/mpdf.php");
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->helper('form');
		$this->load->helper('survey');
		$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->library('session');
		$this->load->library('grocery_CRUD');
		
		$this->load->helper('analytic');
		$this->load->helper('survey');
		
		if (!canViewReport())
		{
			redirect('/');
		}
		
	}
	
	public function family_status_report ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			$family_status_array = array();
			$family_status_array['โสด'] = 0;
			$family_status_array['สมรส'] = 0;
			$family_status_array['หม้าย/หย่าร่าง'] = 0;
			$family_status_array['อื่นๆ'] = 0;
			$total = 0;
			$check_data = false;
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_family_status[] = array('name'=>'โสด '.number_format($family_status_array['โสด']).' คน','value'=> $family_status_array['โสด']);
				$list_family_status[] = array('name'=>'สมรส '.number_format($family_status_array['สมรส']).' คน','value'=> $family_status_array['สมรส']);
				$list_family_status[] = array('name'=>'หม้าย/หย่าร่าง '.number_format($family_status_array['หม้าย/หย่าร่าง']).' คน','value'=> $family_status_array['หม้าย/หย่าร่าง']);
				$list_family_status[] = array('name'=>'อื่นๆ '.number_format($family_status_array['อื่นๆ']).' คน','value'=> $family_status_array['อื่นๆ']);
				
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_family_status;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			foreach ($data_report as $data)
			{
// 				echo "<pre>";
// 				print_r($data[strtoupper('family_status')]);
// 				echo "</pre>";
				$family_status = $data[strtoupper('family_status')];
				$family_status = !empty($family_status)?$family_status:0;
				

				
				switch ($family_status)
				{
					case '1':
						$family_status_array['โสด']= intval($family_status_array['โสด'])+1;
						$total++;
						break;
					case '2':
						$family_status_array['สมรส']= intval($family_status_array['สมรส'])+1;
						$total++;
						break;
					case '3':
						$family_status_array['หม้าย/หย่าร่าง']= intval($family_status_array['หม้าย/หย่าร่าง'])+1;
						$total++;
						break;
					case '4':
						$family_status_array['อื่นๆ']= intval($family_status_array['อื่นๆ'])+1;
						$total++;
						break;
				}
				
			}
			$list_family_status[] = array('name'=>'โสด '.number_format($family_status_array['โสด']).' คน','value'=> $family_status_array['โสด']);
			$list_family_status[] = array('name'=>'สมรส '.number_format($family_status_array['สมรส']).' คน','value'=> $family_status_array['สมรส']);
			$list_family_status[] = array('name'=>'หม้าย/หย่าร่าง '.number_format($family_status_array['หม้าย/หย่าร่าง']).' คน','value'=> $family_status_array['หม้าย/หย่าร่าง']);
			$list_family_status[] = array('name'=>'อื่นๆ '.number_format($family_status_array['อื่นๆ']).' คน','value'=> $family_status_array['อื่นๆ']);
	
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_family_status;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	
	public function education_level()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			$education = array();
			
			$education['สูงกว่าปริญญาตรี'] = 0;
			$education['ปริญญาตรี'] = 0;
			$education['อนุปริญญา/ปวส'] = 0;
			$education['ปวช'] = 0;
			$education['มัธยมศึกษาตอนปลาย'] = 0;
			$education['มัธยมศึกษาตอนต้น'] = 0;
			$education['ประถมศึกษา'] = 0;
			$education['ไม่ได้ศึกษา'] = 0;
			$total = 0;
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_education_result[] = array('name'=>'สูงกว่าปริญญาตรี '.number_format($education['สูงกว่าปริญญาตรี']).' คน','value'=> $education['สูงกว่าปริญญาตรี']);
				$list_education_result[] = array('name'=>'ปริญญาตรี '.number_format($education['ปริญญาตรี']).' คน','value'=> $education['ปริญญาตรี']);
				$list_education_result[] = array('name'=>'อนุปริญญา/ปวส '.number_format($education['อนุปริญญา/ปวส']).' คน','value'=> $education['อนุปริญญา/ปวส']);
				$list_education_result[] = array('name'=>'ปวช '.number_format($education['ปวช']).' คน','value'=> $education['ปวช']);
				$list_education_result[] = array('name'=>'มัธยมศึกษาตอนปลาย '.number_format($education['มัธยมศึกษาตอนปลาย']).' คน','value'=> $education['มัธยมศึกษาตอนปลาย']);
				$list_education_result[] = array('name'=>'มัธยมศึกษาตอนต้น '.number_format($education['มัธยมศึกษาตอนต้น']).' คน','value'=> $education['มัธยมศึกษาตอนต้น']);
				$list_education_result[] = array('name'=>'ประถมศึกษา '.number_format($education['ประถมศึกษา']).' คน','value'=> $education['ประถมศึกษา']);
				$list_education_result[] = array('name'=>'ไม่ได้ศึกษา '.number_format($education['ไม่ได้ศึกษา']).' คน','value'=> $education['ไม่ได้ศึกษา']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_education_result;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
		
			foreach ($data_report as $data)
			{
							
							
				$list_education = $data[strtoupper('EDUCATION_CODE')];
				
				$education = !empty($education)?$education:0;
				
				switch ($list_education)
				{
					case '1':
						$education['สูงกว่าปริญญาตรี'] = intval($education['สูงกว่าปริญญาตรี'])+1;
						$total++;
						break;
					case '2':
						$education['ปริญญาตรี'] = intval($education['ปริญญาตรี'])+1;
						$total++;
						break;
					case '3':
						$education['อนุปริญญา/ปวส'] = intval($education['อนุปริญญา/ปวส'])+1;
						$total++;
						break;
					case '4':
						$education['ปวช'] = intval($education['ปวช'])+1;
						$total++;
						break;
					case '5':
						$education['มัธยมศึกษาตอนปลาย'] = intval($education['มัธยมศึกษาตอนปลาย'])+1;
						$total++;
						break;
					case '6':
						$education['มัธยมศึกษาตอนต้น'] = intval($education['มัธยมศึกษาตอนต้น'])+1;
						$total++;
						break;
					case '7':
						$education['ประถมศึกษา'] = intval($education['ประถมศึกษา'])+1;
						$total++;
						break;
					case '8':
						$education['ไม่ได้ศึกษา'] = intval($education['ไม่ได้ศึกษา'])+1;
						$total++;
						break;
				}
				
			}
			$list_education_result[] = array('name'=>'สูงกว่าปริญญาตรี '.number_format($education['สูงกว่าปริญญาตรี']).' คน','value'=> $education['สูงกว่าปริญญาตรี']);
			$list_education_result[] = array('name'=>'ปริญญาตรี '.number_format($education['ปริญญาตรี']).' คน','value'=> $education['ปริญญาตรี']);
			$list_education_result[] = array('name'=>'อนุปริญญา/ปวส '.number_format($education['อนุปริญญา/ปวส']).' คน','value'=> $education['อนุปริญญา/ปวส']);
			$list_education_result[] = array('name'=>'ปวช '.number_format($education['ปวช']).' คน','value'=> $education['ปวช']);
			$list_education_result[] = array('name'=>'มัธยมศึกษาตอนปลาย '.number_format($education['มัธยมศึกษาตอนปลาย']).' คน','value'=> $education['มัธยมศึกษาตอนปลาย']);
			$list_education_result[] = array('name'=>'มัธยมศึกษาตอนต้น '.number_format($education['มัธยมศึกษาตอนต้น']).' คน','value'=> $education['มัธยมศึกษาตอนต้น']);
			$list_education_result[] = array('name'=>'ประถมศึกษา '.number_format($education['ประถมศึกษา']).' คน','value'=> $education['ประถมศึกษา']);
			$list_education_result[] = array('name'=>'ไม่ได้ศึกษา '.number_format($education['ไม่ได้ศึกษา']).' คน','value'=> $education['ไม่ได้ศึกษา']);
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_education_result;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	
	public function type_business()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
		
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			$type_business= array();
			$list_type_business = array();
			$type_business['กู้เงิน'] = 0;
			$type_business['ฝากเงิน'] = 0;
			$type_business['ซื้อสินค้า'] = 0;
			$type_business['ขายผลผลิต'] = 0;
			$type_business['แปรรูป'] = 0;
			$type_business['บริการ'] = 0;
			$type_business['ซื้อน้ำ'] = 0;
			$type_business['น้ำมันเชื่อเพลิง/แก๊ส'] = 0;
			$type_business['อื่นๆ'] = 0;
			$total = 0;
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_type_business[] = array('name'=>'กู้เงิน '.number_format($type_business['กู้เงิน']).' คน','value'=> $type_business['กู้เงิน']);
				$list_type_business[] = array('name'=>'ฝากเงิน '.number_format($type_business['ฝากเงิน']).' คน','value'=> $type_business['ฝากเงิน']);
				$list_type_business[] = array('name'=>'ซื้อสินค้า '.number_format($type_business['ซื้อสินค้า']).' คน','value'=> $type_business['ซื้อสินค้า']);
				$list_type_business[] = array('name'=>'ขายผลผลิต '.number_format($type_business['ขายผลผลิต']).' คน','value'=> $type_business['ขายผลผลิต']);
				$list_type_business[] = array('name'=>'แปรรูป '.number_format($type_business['แปรรูป']).' คน','value'=> $type_business['แปรรูป']);
				$list_type_business[] = array('name'=>'บริการ '.number_format($type_business['บริการ']).' คน','value'=> $type_business['บริการ']);
				$list_type_business[] = array('name'=>'ซื้อน้ำ '.number_format($type_business['ซื้อน้ำ']).' คน','value'=> $type_business['ซื้อน้ำ']);
				$list_type_business[] = array('name'=>'น้ำมันเชื่อเพลิง/แก๊ส '.number_format($type_business['น้ำมันเชื่อเพลิง/แก๊ส']).' คน','value'=> $type_business['น้ำมันเชื่อเพลิง/แก๊ส']);
				$list_type_business[] = array('name'=>'อื่นๆ '.number_format($type_business['อื่นๆ']).' คน','value'=> $type_business['อื่นๆ']);
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_type_business;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			foreach ($data_report as $data)
			{
			
				$business = $data[strtoupper('DO_BUZ')];
				if (!isset($business) || empty($business) || sizeof($business)<=0) {					
					continue;
				}
				$total = $total+1;
				foreach ($business as $list_business)
				{
	// 				$type_business = !empty($list_business)?$list_business:0;
					
					switch ($list_business)
					{
						case '0':
							$type_business['กู้เงิน'] = intval($type_business['กู้เงิน'])+1;
							
							break;
						case '1':
							$type_business['ฝากเงิน']= intval($type_business['ฝากเงิน'])+1;
						
							break;
						case '2':
							$type_business['ซื้อสินค้า']= intval($type_business['ซื้อสินค้า'])+1;
							
							break;
						case '3':
							$type_business['ขายผลผลิต']= intval($type_business['ขายผลผลิต'])+1;
							
							break;
						case '4':
							$type_business['แปรรูป']= intval($type_business['แปรรูป'])+1;
							
							break;
						case '5':
							$type_business['บริการ']= intval($type_business['บริการ'])+1;
							
							break;
						case '6':
							$type_business['ซื้อน้ำ']= intval($type_business['ซื้อน้ำ'])+1;
						
							break;
						case '7':
							$type_business['น้ำมันเชื่อเพลิง/แก๊ส']= intval($type_business['น้ำมันเชื่อเพลิง/แก๊ส'])+1;
							
							break;
						case '8':
							$type_business['อื่นๆ']= intval($type_business['อื่นๆ'])+1;
							
							break;
					}
				}
			}
					
			
			$list_type_business[] = array('name'=>'กู้เงิน '.number_format($type_business['กู้เงิน']).' คน','value'=> $type_business['กู้เงิน']);
			$list_type_business[] = array('name'=>'ฝากเงิน '.number_format($type_business['ฝากเงิน']).' คน','value'=> $type_business['ฝากเงิน']);
			$list_type_business[] = array('name'=>'ซื้อสินค้า '.number_format($type_business['ซื้อสินค้า']).' คน','value'=> $type_business['ซื้อสินค้า']);
			$list_type_business[] = array('name'=>'ขายผลผลิต '.number_format($type_business['ขายผลผลิต']).' คน','value'=> $type_business['ขายผลผลิต']);
			$list_type_business[] = array('name'=>'แปรรูป '.number_format($type_business['แปรรูป']).' คน','value'=> $type_business['แปรรูป']);
			$list_type_business[] = array('name'=>'บริการ '.number_format($type_business['บริการ']).' คน','value'=> $type_business['บริการ']);
			$list_type_business[] = array('name'=>'ซื้อน้ำ '.number_format($type_business['ซื้อน้ำ']).' คน','value'=> $type_business['ซื้อน้ำ']);
			$list_type_business[] = array('name'=>'น้ำมันเชื่อเพลิง/แก๊ส '.number_format($type_business['น้ำมันเชื่อเพลิง/แก๊ส']).' คน','value'=> $type_business['น้ำมันเชื่อเพลิง/แก๊ส']);
			$list_type_business[] = array('name'=>'อื่นๆ '.number_format($type_business['อื่นๆ']).' คน','value'=> $type_business['อื่นๆ']);
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_type_business;	
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	
	
	public function get_result_product_animal()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			// 			$this->print_data($province);
			
			
			$this->db->select(strtoupper('PLANT_TYPE,GROWING_AREA,PRODUCT_NUM_PER_YEAR,GROWING_AREA_WILL,ani_num_per_year,ani_income,ani_expense_per_year'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				
				$this->rang_income();
				
				
			$data_report = getListDataSurvey($year);
			
			
			
			
			$peolple = 0;
			$ani = 0;
			$ani2 =0;
			$count_row =0;
			if(!empty($data_report) && is_array($data_report) && sizeof($data_report)>0)
			foreach ($data_report as $data)
			{
			
				$validate_data= false;
				
				if(!empty($data['PLANT_TYPE']) && sizeof($data['PLANT_TYPE'])>0
						&& !empty($data['GROWING_AREA']) && sizeof($data['GROWING_AREA'])>0
						&& !empty($data['GROWING_AREA'][0]) && $data['GROWING_AREA'][0]>0
						)
				{
					$peolple++;
					$validate_data= true;
				}
				
				if(!empty($data[strtoupper('ani_type')]) && sizeof($data[strtoupper('ani_type')])>0
						&& !empty(strtoupper('ani_num_per_year')) && sizeof(strtoupper('ani_num_per_year'))>0
						&& !empty($data[strtoupper('ani_num_per_year')][0]) && $data[strtoupper('ani_num_per_year')][0]>0
					)
				{
					$ani++;
					$validate_data= true;
				}
				if(!empty($data[strtoupper('ani2_type')]) && sizeof($data[strtoupper('ani2_type')])>0
						&& !empty(strtoupper('ani2_numyear')) && sizeof(strtoupper('ani2_numyear'))>0
						&& !empty($data[strtoupper('ani2_numyear')][0]) && $data[strtoupper('ani2_numyear')][0]>0
						)
				{
					$ani2++;
					$validate_data= true;
				}
				
				if($validate_data)
				{
					$count_row++;
				}
			}
			
			
			
			$data = array();
			$data['ปลูกพืช'] = $peolple;
			$data['เลี้ยงสัตว์บก'] = $ani;
			$data['เลี้ยงสัตว์น้ำ'] = $ani2;
			
			$result = array();
			$result['count'] = $count_row;
			$result['data'] = $data;
			
			$result['countall'] =  getCountRowSurvey($year);
// 			$this->print_data($result);
			
			$this->response_data($result);
		}
	}
	
	
	
	public function result_product ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
// 			$this->print_data($province);
			
			
			$this->db->select('PLANT_TYPE,GROWING_AREA,PRODUCT_NUM_PER_YEAR,GROWING_AREA_WILL');
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
				$this->rang_income();
			
			
				$data_report = getListDataSurvey($year);
				
				
				
				
				
				
				
			$count_rai = array();
			$count_rai['พื้นที่ปลูก'] = 0;
			$count_rai['พื้นที่จะปลูก'] = 0;
			$count_rai['ผลิตที่คาดว่าจะได้'] = 0;
			
			$count_row = 0;
			
			
			if(!empty($data_report) && is_array($data_report) && sizeof($data_report)>0)
			foreach ($data_report as $data)
			{
				$validate_data = false;
				if(!empty($data['GROWING_AREA']) && is_array($data['GROWING_AREA']) && sizeof($data['GROWING_AREA'])>0)
					foreach ($data['GROWING_AREA'] as $GROWING_AREA)
					{
						
						$count_rai['พื้นที่ปลูก'] = floatval($count_rai['พื้นที่ปลูก']) + floatval($GROWING_AREA);
						if(floatval($count_rai['พื้นที่ปลูก'])>0)
						$validate_data = true;
					}
				if(!empty($data['GROWING_AREA_WILL']) && is_array($data['GROWING_AREA_WILL']) && sizeof($data['GROWING_AREA_WILL'])>0)
					foreach ($data['GROWING_AREA_WILL'] as $GROWING_AREA)
					{
						
						$count_rai['พื้นที่จะปลูก'] = floatval($count_rai['พื้นที่จะปลูก']) + floatval($GROWING_AREA);
						if(floatval($count_rai['พื้นที่จะปลูก'])>0)
						$validate_data = true;
					}
				if(!empty($data['PRODUCT_NUM_PER_YEAR']) && is_array($data['PRODUCT_NUM_PER_YEAR']) && sizeof($data['PRODUCT_NUM_PER_YEAR'])>0)
					foreach ($data['PRODUCT_NUM_PER_YEAR'] as $GROWING_AREA)
					{
						
						$count_rai['ผลิตที่คาดว่าจะได้'] = floatval($count_rai['ผลิตที่คาดว่าจะได้']) + floatval($GROWING_AREA);
						
						if(floatval($count_rai['ผลิตที่คาดว่าจะได้'])>0)
						$validate_data = true;
					}
				if($validate_data)
				{
					$count_row++;
				}
			}
			$data_response =array();
			$data_response['data'] = $count_rai;
			$data_response['count'] = $count_row;
			
			$data_response['countall'] =  getCountRowSurvey($year);
			
			return  $data_response;
		}
	}
	
	public function result_animal()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				
			$this->db->select(strtoupper('ani_num_per_year,ani_income,ani_expense_per_year'));
			
			$this->rang_income();
			
				$data_report = getListDataSurvey($year);
			$count_rai = array();
			$count_rai['จำนวนรวมสัตว์'] = 0;
			$count_rai['จำนวนสัตว์ที่จะเลี้ยง'] = 0;
			$count_rai['มูลค่าสัตว์ที่จะขาย'] = 0;
			$count_row = 0;
			
			if(!empty($data_report) && is_array($data_report) && sizeof($data_report)>0)
			foreach ($data_report as $data)
			{
				$calidate_data = false;
				if(!empty($data[strtoupper('ani_num_per_year')]) && is_array($data[strtoupper('ani_num_per_year')]) && sizeof($data[strtoupper('ani_num_per_year')])>0)
					foreach ($data[strtoupper('ani_num_per_year')] as $GROWING_AREA)
					{
						
						$count_rai['จำนวนรวมสัตว์'] = floatval($count_rai['จำนวนรวมสัตว์']) + floatval($GROWING_AREA);
						
						if(floatval($count_rai['จำนวนรวมสัตว์'])>0)
						$calidate_data = true;
					}
				if(!empty($data[strtoupper('ani_num_will')]) && is_array($data[(strtoupper('ani_num_will'))]) && sizeof($data[strtoupper('ani_num_will')])>0)
					foreach ($data[strtoupper('ani_num_will')] as $GROWING_AREA)
					{
						
						$count_rai[strtoupper('จำนวนสัตว์ที่จะเลี้ยง')] = floatval($count_rai['จำนวนสัตว์ที่จะเลี้ยง']) + floatval($GROWING_AREA);
						
						if(floatval($count_rai[strtoupper('จำนวนสัตว์ที่จะเลี้ยง')])>0)
						$calidate_data = true;
					}
				if(!empty($data[strtoupper('ani_num_sale')]) && is_array($data[strtoupper('ani_num_sale')]) && sizeof($data[strtoupper('ani_num_sale')])>0)
					foreach ($data[strtoupper('ani_num_sale')] as $GROWING_AREA)
					{
						$count_rai['มูลค่าสัตว์ที่จะขาย'] = floatval($count_rai['มูลค่าสัตว์ที่จะขาย']) + floatval($GROWING_AREA);
						
						if(floatval($count_rai['มูลค่าสัตว์ที่จะขาย'])>0)
						$calidate_data = true;
					}
				if(!empty($data[strtoupper('ani2_numyear')]) && is_array($data[strtoupper('ani2_numyear')]) && sizeof($data[strtoupper('ani2_numyear')])>0)
					foreach ($data[strtoupper('ani2_numyear')] as $GROWING_AREA)
					{
						
						$count_rai['จำนวนรวมสัตว์'] = floatval($count_rai['จำนวนรวมสัตว์']) + floatval($GROWING_AREA);
						
						if(floatval($count_rai['จำนวนรวมสัตว์'])>0)
							$calidate_data = true;
					}
				if(!empty($data[strtoupper('ani2_will')]) && is_array($data[(strtoupper('ani2_will'))]) && sizeof($data[strtoupper('ani2_will')])>0)
					foreach ($data[strtoupper('ani2_will')] as $GROWING_AREA)
					{
						
						$count_rai['จำนวนสัตว์ที่จะเลี้ยง'] = floatval($count_rai['จำนวนสัตว์ที่จะเลี้ยง']) + floatval($GROWING_AREA);
						if(floatval($count_rai['จำนวนสัตว์ที่จะเลี้ยง'] )>0)
							$calidate_data = true;
						
					}
				if(!empty($data[strtoupper('ani2_sale')]) && is_array($data[strtoupper('ani2_sale')]) && sizeof($data[strtoupper('ani2_sale')])>0){
					$calidate_data = true;
					foreach ($data[strtoupper('ani2_sale')] as $GROWING_AREA)
					{
						$count_rai['มูลค่าสัตว์ที่จะขาย'] = floatval($count_rai['มูลค่าสัตว์ที่จะขาย']) + floatval($GROWING_AREA);
						if(floatval($count_rai['มูลค่าสัตว์ที่จะขาย'])>0)
							$calidate_data = true;
					}
				}
				if($calidate_data){
					$count_row++;
				}
					
			}
			// 			$this->print_data($count_rai);
// 			echo json_encode($count_rai);
			$data_response =array();
			$data_response['data'] = $count_rai;
			$data_response['count'] = $count_row;
			
			$data_response['countall'] = getCountRowSurvey($year);
			
			return $data_response;
		}
	}
	
	
	
	public function count_plant()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			$this->db->select('PLANT_TYPE,GROWING_AREA,PRODUCT_NUM_PER_YEAR,GROWING_AREA_WILL');
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
			$this->rang_income();
			$data_report = getListDataSurvey($year);
			
			$count_rai = array();
			$count_rai['พื้นที่ปลูก'] = 0;
			$count_rai['พื้นที่จะปลูก'] = 0;
			$count_rai['ผลิตที่คาดว่าจะได้'] = 0;
			$count_row = 0;
			
			
			
			if(!empty($data_report) && is_array($data_report) && sizeof($data_report)>0)
			foreach ($data_report as $data)
			{
				$validate_data = false;
				if(!empty($data['GROWING_AREA']) && is_array($data['GROWING_AREA']) && sizeof($data['GROWING_AREA'])>0)
					foreach ($data['GROWING_AREA'] as $GROWING_AREA)
					{
						
						$count_rai['พื้นที่ปลูก'] = floatval($count_rai['พื้นที่ปลูก']) + floatval($GROWING_AREA);
						if(floatval($count_rai['พื้นที่ปลูก']) >0)
						$validate_data = true;
					}
				if(!empty($data['GROWING_AREA_WILL']) && is_array($data['GROWING_AREA_WILL']) && sizeof($data['GROWING_AREA_WILL'])>0)
					foreach ($data['GROWING_AREA_WILL'] as $GROWING_AREA)
					{
						
						$count_rai['พื้นที่จะปลูก'] = floatval($count_rai['พื้นที่จะปลูก']) + floatval($GROWING_AREA);
						if( floatval($count_rai['พื้นที่จะปลูก'])>0)
						$validate_data = true;
					}
				if(!empty($data['PRODUCT_NUM_PER_YEAR']) && is_array($data['PRODUCT_NUM_PER_YEAR']) && sizeof($data['PRODUCT_NUM_PER_YEAR'])>0)
					foreach ($data['PRODUCT_NUM_PER_YEAR'] as $GROWING_AREA)
					{
						
						$count_rai['ผลิตที่คาดว่าจะได้'] = floatval($count_rai['ผลิตที่คาดว่าจะได้']) + floatval($GROWING_AREA);
						if(floatval($count_rai['ผลิตที่คาดว่าจะได้']))
						$validate_data = true;
					}
				if($validate_data)
				{
					$count_row++;
				}
			}
			
			$data_response =array();
			$data_response['data'] = $count_rai;
			$data_response['count'] = $count_row;
			
			$data_response['countall'] =  getCountRowSurvey($year);
			
			echo json_encode($data_response);
		}
	}
	
	public function count_plant_type()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			
			
			$this->db->select(strtoupper('plant_type,growing_area,growing_area_will'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
				$this->rang_income();
			
			
			
			$data_survey = getListDataSurvey($year);
			
		
			$plan_name = array();
			
			$i = 1;
			$plan_name[$i] = "ข้าวหอมมะลิ";  $i++;
			$plan_name[$i] = "ข้าวเหนียว"; $i++;
			$plan_name[$i] = "ข้าวจ้าว";  $i++;
			$plan_name[$i] = "มันสำปะหลัง"; $i++;
			$plan_name[$i] = "ปาล์มน้ำมัน"; $i++;
			$plan_name[$i] = "ยางพารา";  $i++;
			$plan_name[$i] = "ลำไย"; $i++;
			$plan_name[$i] = "ทุเรียน";  $i++;
			$plan_name[$i] = "มังคุด";  $i++;
			$plan_name[$i] = "สับปะรด";  $i++;
			$plan_name[$i] = "ถั่วเหลือง";  $i++;
			$plan_name[$i] = "ข้าวโพดเลี้ยงสัตว์"; $i++;
			$plan_name[$i] = "อ้อย";  $i++;
			
			$data_response = array();
			$count_row = 0;
			
			$data_result= array();
			if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
			for ($j=0;$j<sizeof($data_survey);$j++)
			{
				$validate_data = false;
				if(!empty($data_survey[$j]['PLANT_TYPE']))
				{
					
					if(!empty($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
					{
						for($i=0;$i<sizeof($data_survey[$j]['PLANT_TYPE']);$i++)
						{
							if(!empty($data_survey[$j]['PLANT_TYPE'][$i]))
							{
								
								if(!empty($data_survey[$j]['GROWING_AREA'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
									{
										$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] = 0;
									}
									$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA'][$i]);
									if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
										$validate_data = true;
								}
								if(!empty($data_survey[$j]['GROWING_AREA_WILL'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL']))
									{
										$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] = 0;
									}
									
									$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA_WILL'][$i]);
									
									if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL']))
										$validate_data = true;
								}
								
							}
						}
						
					}
					
				}
				if($validate_data){
					$count_row++;
				}
				
			}
			$data = array();
			
			foreach ($plan_name as $k=>$v)
				$data[$plan_name[$k]] =array(0,'ปลูกแล้ว'=>0,'จะปลูก'=>0);
			
			foreach ($data_result as $k=>$v)
			{
				$data[$plan_name[$k]] = array($plan_name[$k],'ปลูกแล้ว'=>!empty($v['GROWING_AREA'])?$v['GROWING_AREA']:0,'จะปลูก'=>!empty($v['GROWING_AREA_WILL'])?$v['GROWING_AREA_WILL']:0);
			}
			
			
			$data_response =array();
			$data_response['data'] = $data;
			$data_response['count'] = $count_row;
			
			
			$data_response['countall'] =  getCountRowSurvey($year);
			
			$this->response_data($data_response);
		}
	}
	
	public function result_animal_type ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('ani_type,ani_num_per_year,ani_num_will,ani_num_sale,ani2_type,ani2_numyear,ani2_will,ani2_sale'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
				$this->rang_income();
				$data_survey = getListDataSurvey($year);
			
			// 			$this->print_data($data_survey);
			
			$data_response = array();
			
			$ani_name = array();
			
			$ani_name[11] = "ผึ้งเลี้ยง";
			$ani_name[21] = "กระบือ";
			$ani_name[22] = "สุกร";
			$ani_name[12] = "ไก่";
			$ani_name[13] = "เป็ด";
			$ani_name[23] = "โคนม";
			$ani_name[24] = "โคเนื้อ";
			$ani_name[25] = "แพะเนื้อ";
			$ani_name[26] = "แพะนม";
			$ani_name[27] = "กวาง";
			$ani_name[28] = "สัตว์บกอื่น ๆ";
			
			
			
			$data_result= array();
			if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
			for ($j=0;$j<sizeof($data_survey);$j++)
			{
				if(!empty($data_survey[$j]['ANI_TYPE']))
				{
					
					if(!empty($data_survey[$j]['ANI_TYPE']) && sizeof($data_survey[$j]['ANI_TYPE'])>0)
					{
						if(!empty($data_survey[$j]['ANI_TYPE']) && is_array($data_survey[$j]['ANI_TYPE']) && sizeof($data_survey[$j]['ANI_TYPE'])>0)
						for($i=0;$i<sizeof($data_survey[$j]['ANI_TYPE']);$i++)
						{
							if(!empty($data_survey[$j]['ANI_TYPE'][$i]))
							{
								if(!empty($data_survey[$j]['ANI_NUM_PER_YEAR'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_PER_YEAR']))
									{
										$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_PER_YEAR'] = 0;
									}
									$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_PER_YEAR'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI_NUM_PER_YEAR'][$i]);
									
								}
								if(!empty($data_survey[$j]['ANI_TYPE'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_WILL']))
									{
										$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_WILL'] = 0;
									}
									$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_WILL'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI_NUM_WILL'][$i]);
									
								}
								if(!empty($data_survey[$j]['ANI_TYPE'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_SALE']))
									{
										$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_SALE'] = 0;
									}
									$data_result[$data_survey[$j]['ANI_TYPE'][$i]]['ANI_NUM_SALE'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI_NUM_SALE'][$i]);
									
								}
							}
						
						}
					
					}
				}
			}
			
			
			
			if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
			for ($j=0;$j<sizeof($data_survey);$j++)
			{
				if(!empty($data_survey[$j]['ANI2_TYPE']))
				{
					
					if(!empty($data_survey[$j]['ANI2_TYPE']) && sizeof($data_survey[$j]['ANI2_TYPE'])>0)
					{
						if(!empty($data_survey[$j]['ANI2_TYPE']) && is_array($data_survey[$j]['ANI2_TYPE']) && sizeof($data_survey[$j]['ANI2_TYPE'])>0)
						for($i=0;$i<sizeof($data_survey[$j]['ANI2_TYPE']);$i++)
						{
							if(!empty($data_survey[$j]['ANI2_TYPE'][$i]))
							{
								if(!empty($data_survey[$j]['ANI2_NUMYEAR'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_NUMYEAR']))
									{
										$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_NUMYEAR'] = 0;
									}
									
									$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_NUMYEAR'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI2_NUMYEAR'][$i]);
								}
								if(!empty($data_survey[$j]['ANI2_TYPE'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_WILL']))
									{
										$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_WILL'] = 0;
									}
									$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_WILL'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI2_WILL'][$i]);
								}
								if(!empty($data_survey[$j]['ANI2_TYPE'][$i]))
								{
									if(empty($data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_SALE']))
									{
										$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_SALE'] = 0;
									}
									$data_result[$data_survey[$j]['ANI2_TYPE'][$i]]['ANI2_SALE'] +=$this->validate_nummeric_and_emty($data_survey[$j]['ANI2_SALE'][$i]);
								}
							}
						}
						
					}
					
				}
			}
// 			$this->print_data($data_result);
			
			$ani_name2 = array(); $ani_code2 = array();
			$ani_name2['01'] = "กุ้ง"; 
			$ani_name2['02'] = "ปลา"; 
			$ani_name2['03'] = "หอย";  
			$ani_name2['04'] = "สัตว์น้ำอื่น ๆ";
			
			$count_row = 0;
			
			$data_ani = array();
			$data_ani2 = array();
			
			foreach ($ani_name2 as $k=>$v)
				$data_ani2[$ani_name2[$k]] =array(0,0,0);
			
			foreach ($ani_name as $k=>$v)
				$data_ani[$ani_name[$k]] =array(0,0,0);

			if(!empty($data_result) && is_array($data_result) && sizeof($data_result)>0)
			foreach ($data_result as $k=>$v)
			{
				$validate = false;
				if(!empty($ani_name[$k]))
					$data_ani[$ani_name[$k]] =array(!empty($v['ANI_NUM_PER_YEAR'])?intval($v['ANI_NUM_PER_YEAR']):0,!empty($v['ANI_NUM_WILL'])?intval($v['ANI_NUM_WILL']):0,!empty($v['ANI_NUM_SALE'])?intval($v['ANI_NUM_SALE']):0);
				if(!empty($ani_name2[$k]))
					$data_ani2[$ani_name2[$k]] =array(!empty($v['ANI2_NUMYEAR'])?intval($v['ANI2_NUMYEAR']):0,!empty($v['ANI2_WILL'])?intval($v['ANI2_WILL']):0,!empty($v['ANI2_SALE'])?intval($v['ANI2_SALE']):0);
				if( !empty($ani_name2[$k]) && (!empty($data_ani2[$ani_name2[$k]]) && max($data_ani2[$ani_name2[$k]])>0))
					$validate = true;
				if(!empty($ani_name[$k]) && (!empty($data_ani[$ani_name[$k]]) && max($data_ani[$ani_name[$k]])>0))
					$validate = true;
				if($validate)
					$count_row++;
						
			}
			
// 						$this->print_data($data_ani2);
// 			in_array($needle, $haystack)
			
			$data_response =array();
			$data_response['data_ani'] = $data_ani;
			$data_response['data_ani2'] = $data_ani2;
			$data_response['count'] = $count_row;
			
			
			$data_response['countall'] =  getCountRowSurvey($year);
			
			$this->response_data($data_response);
		}
		
	}
	
	
	
	public function count_fruit()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = !empty($this->input->get('filter_year'))?$this->input->get('filter_year'):"2018";
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('plant_type,growing_area,growing_area_will'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				
				$this->rang_income();
				$data_survey = getListDataSurvey($year);
				
				// 			$this->print_data($data_survey);
				
				$data_response = array();
				$plan_name = array();
				
				$plan_name['7'] = "ลำไย";
				$plan_name['8'] = "ทุเรียน";
				$plan_name['9'] = "มังคุด";
				$plan_name['10'] = "สับปะรด";
				
				$count_row = 0;
				
				$data_response = array();
				
				$data_result= array();
				if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
				for ($j=0;$j<sizeof($data_survey);$j++)
				{
					$validate = false;
					if(!empty($data_survey[$j]['PLANT_TYPE']))
					{
						
						if(!empty($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
						{
							if(!empty($data_survey[$j]['PLANT_TYPE']) && is_array($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
							for($i=0;$i<sizeof($data_survey[$j]['PLANT_TYPE']);$i++)
							{
								if(!empty($data_survey[$j]['PLANT_TYPE'][$i]))
								{
									if(!empty($data_survey[$j]['GROWING_AREA'][$i]))
									{
										if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
										{
											$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] = 0;
										}
										
										$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA'][$i]);
										
										if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
											$validate = true;
											
											
									}
									if(!empty($data_survey[$j]['GROWING_AREA_WILL'][$i]))
									{
										if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL']))
										{
											$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] = 0;
										}

										$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA_WILL'][$i]);
										
										if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL']))
											$validate = true;
									}
									
									
										
								}
							}
							
						}
						
					}
					if($validate)
					{
						$count_row++;
					}
					
				}
				$data = array();
				
				
				foreach ($plan_name as $k=>$v)
				{
					$data[$v] = Array('ปลูกแล้ว'=>0,'จะปลูก'=>0);
				}
				
				
				foreach ($data_result as $k=>$v)
				{
					if(!empty($plan_name[$k]))
						$data[$plan_name[$k]] = array('ปลูกแล้ว'=>!empty($v['GROWING_AREA'])?$v['GROWING_AREA']:0,'จะปลูก'=>!empty($v['GROWING_AREA_WILL'])?$v['GROWING_AREA_WILL']:0);
					
				}
				
// 				$this->print_data($data_survey);
				
				$data_response =array();
				$data_response['data'] = $data;
				$data_response['count'] = $count_row;
				
				$data_response['countall'] =  getCountRowSurvey($year);
			
// 				$this->print_data($data_response);
				
				$this->response_data($data_response);
			
			
			
			
		}
	}
	
	public function count_fertilizer ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = !empty($this->input->get('filter_year'))?$this->input->get('filter_year'):"2018";
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('chm1_46_0_0,chm2_15_15_15,chm3_16_20_0,chm4_other,chm2_intr,chm1_water,chm2_c_c_c,chm1_seed,chm2_seed'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				
				$this->rang_income();
				$data_survey = getListDataSurvey($year);
				
				
				
				$data_result = array();
				$data_result[strtoupper('chm1_46_0_0')][1] = 0;
				$data_result[strtoupper('chm2_15_15_15')][1] = 0;
				$data_result[strtoupper('chm3_16_20_0')][1] = 0;
				$data_result[strtoupper('chm4_other')][1] = 0;
				$data_result[strtoupper('chm2_intr')][1] = 0;
				$data_result[strtoupper('chm1_water')][1] = 0;
				$data_result[strtoupper('chm2_c_c_c')][1] = 0;
				$data_result[strtoupper('chm1_seed')][1] = 0;
				$data_result[strtoupper('chm2_seed')][1]= 0;
				
				$data_result[strtoupper('chm1_46_0_0')][2] = 0;
				$data_result[strtoupper('chm2_15_15_15')][2] = 0;
				$data_result[strtoupper('chm3_16_20_0')][2] = 0;
				$data_result[strtoupper('chm4_other')][2] = 0;
				$data_result[strtoupper('chm2_intr')][2] = 0;
				$data_result[strtoupper('chm1_water')][2] = 0;
				$data_result[strtoupper('chm2_c_c_c')][2] = 0;
				$data_result[strtoupper('chm1_seed')][2] = 0;
				$data_result[strtoupper('chm2_seed')][2]= 0;
				
				$count_row = 0;
				
				if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
				foreach ($data_survey as $data)
					
				{
					$validate = false;
					foreach ($data as $k=>$v)
					{
						if(isset($data_result[$k])&&!empty($v))
						{
							foreach ($v as $key=>$data_on_array)
							{
								$data_result[$k][$key] += $this->validate_nummeric_and_emty($data_on_array);
								
								if(intval($data_result[$k][$key]) != 0){
									$validate = true;
								}
								
								
							}
						}
					}
					
					if($validate)
					{
						$count_row++;
					}
				}
				
				
				$data_responce = array();
				$data_responce['46-0-0'] = $data_result[strtoupper('chm1_46_0_0')]; 
				$data_responce['15-15-15'] = $data_result[strtoupper('chm2_15_15_15')]; 
				$data_responce['16-20-0'] = $data_result[strtoupper('chm3_16_20_0')]; 
				$data_responce['ปุ๋ยอื่นๆ'] = $data_result[strtoupper('chm4_other')]; 
				$data_responce['ปุ้ยอินทรีย์'] = $data_result[strtoupper('chm2_intr')]; 
				$data_responce['ยาปราบศํตรูพืชชนิดน้ำ'] = $data_result[strtoupper('chm1_water')]; 
				$data_responce['ยาปราบศํตรูพืชชนิดเม็ด/ผง'] = $data_result[strtoupper('chm2_c_c_c')]; 
				$data_responce['เมล็ดพันธุ์'] = $data_result[strtoupper('chm2_seed')] + $data_result[strtoupper('chm1_seed')]; 
				
				
				
				
				$data =array();
				$data['data'] = $data_responce;
				
				$data['count'] = $count_row;
				
				$data['countall'] =  getCountRowSurvey($year);
				
				
				
				$this->response_data($data);
		}
	}
	
	public function count_plant_all()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			$plant_type = !empty($this->input->get('filter_plant'))?$this->input->get('filter_plant'):1;
			
			$this->db->select(strtoupper('plant_type,growing_area,PROVINCE_ID'));
			
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
				$this->rang_income();
				
				$data_survey = getListDataSurvey($year);
				$province_all = getAllProvinces();
				
				$province_all_array = array();
				$data_response = array();
				$data_result= array();
				
				
				
				
// 				$this->print_data($province_all_array);
// 				exit();
				
				
				$plan_name = array();
				$plan_temp = array();
				
				$i = 1;
				$plan_name[$i] = "ข้าวหอมมะลิ"; $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ข้าวเหนียว"; $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ข้าวจ้าว";  $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "มันสำปะหลัง"; $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ปาล์มน้ำมัน"; $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ยางพารา";  $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ลำไย"; $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "ทุเรียน";  $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "มังคุด";  $plan_temp[$i]['GROWING_AREA']=0; $i++;
				$plan_name[$i] = "สับปะรด"; $plan_temp[$i]['GROWING_AREA']=0;  $i++;
				$plan_name[$i] = "ถั่วเหลือง"; $plan_temp[$i]['GROWING_AREA']=0;  $i++;
				$plan_name[$i] = "ข้าวโพดเลี้ยงสัตว์"; $plan_temp[$i]['GROWING_AREA']=0;  $i++;
				$plan_name[$i] = "อ้อย";  $plan_temp[$i]['GROWING_AREA']=0;  $i++;
				if(!empty($province_all) && is_array($province_all) && sizeof($province_all)>0)
				foreach ($province_all as $data_province)
				{
					$province_all_array[$data_province->PROVINCE_ID] = $data_province->PROVINCE_NAME;
					$data_result[$data_province->PROVINCE_ID] = $plan_temp[1];
				}
				
				if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
				for ($j=0;$j<sizeof($data_survey);$j++)
				{
					if(!empty($data_survey[$j]['PLANT_TYPE']) && intval($data_survey[$j]['PLANT_TYPE']) == intval($data_survey[$j]['PLANT_TYPE']))
					{
						
						if(!empty($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
						{
							for($i=0;$i<sizeof($data_survey[$j]['PLANT_TYPE']);$i++)
							{
								if(!empty($data_survey[$j]['PLANT_TYPE'][$i]) && $data_survey[$j]['PLANT_TYPE'][$i] == $plant_type)
								{
									
									if(!empty($data_survey[$j]['GROWING_AREA'][$i]))
									{
										if(empty($data_result[$data_survey[$j]['PROVINCE_ID']][$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
										{
											$data_result[$data_survey[$j]['PROVINCE_ID']][$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] = 0;
										}
										$data_result[$data_survey[$j]['PROVINCE_ID']][$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA'][$i]);
										
									}
								}
							}
							
						}
						
					}
					
				}
// 				$this->print_data($data_result);
				$validate_data = true;
				$count_row=0;
				if(!empty($data_result) && is_array($data_result) && sizeof($data_result)>0)
				foreach ($data_result as $province_key=>$plan_type)
				{
// 					$this->print_data($plan_type);
// 					if
					foreach ($plan_type as $k=>$v)
					{
						//validate if data is empty or valude is not 0
						if($k ==$plant_type && !empty($v['GROWING_AREA']) && $v['GROWING_AREA'] !='0')
						{
							$validate_data = false;
							$data_response[$province_all_array[$province_key]] = $v['GROWING_AREA'];
							$count_row++;
						}else {
							$data_response[$province_all_array[$province_key]] = 0;
						}
						
					}
				}
				
				$key_array = array();
				$key_array[] = 'จังหวัด';
				foreach ($plan_name as $k=>$plant)
				{
					if($k ==$plant_type)
						$key_array[] = $plant;
				}
				
// 				$this->print_data($data_response);
				
				$data =array();
				$data['data'] = $data_response;
				$data['validate'] = $validate_data;
				$data['key'] = $key_array;
				$data['count'] = $count_row;
				
				$data['countall'] =  getCountRowSurvey($year);
				
				
				
				$this->response_data($data);
		}
	}
	
	public function count_water()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$fields_array = ['WATER_SHALLOW_WELL_OWN','WATER_GROUNDWATER_WELLS_OWN','WATER_GROUNDWATER_WELLS_PUBLIC'
					,'WATER_SWAMP_PUBLIC','WATER_IRRIGATION_CANAL_PUBLIC','WATER_RIVER_PUBLIC','WATER_PONDS_OWN'];
			
			$data_result = array();
			$total = 0;
			$data_result['WATER_SHALLOW_WELL_OWN'] = 0;
			$data_result['WATER_GROUNDWATER_WELLS_OWN'] = 0;
			$data_result['WATER_GROUNDWATER_WELLS_PUBLIC'] = 0;
			$data_result['WATER_SWAMP_PUBLIC'] = 0;
			$data_result['WATER_IRRIGATION_CANAL_PUBLIC'] = 0;
			$data_result['WATER_RIVER_PUBLIC'] = 0;
			$data_result['WATER_PONDS_OWN'] = 0;
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			$this->db->select('WATER_SHALLOW_WELL_OWN,WATER_GROUNDWATER_WELLS_OWN,WATER_GROUNDWATER_WELLS_PUBLIC,WATER_SWAMP_PUBLIC,WATER_IRRIGATION_CANAL_PUBLIC,WATER_RIVER_PUBLIC,WATER_PONDS_OWN');
			$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_water[] = array('name'=>'บ่อน้ำตื้น '.number_format($data_result['WATER_SHALLOW_WELL_OWN']).' คน','value'=> $data_result['WATER_SHALLOW_WELL_OWN']);
				$list_water[] = array('name'=>'บ่อบาดาลตนเอง '.number_format($data_result['WATER_GROUNDWATER_WELLS_OWN']).' คน','value'=> $data_result['WATER_GROUNDWATER_WELLS_OWN']);
				$list_water[] = array('name'=>'สระน้ำตนเอง '.number_format($data_result['WATER_PONDS_OWN']).' คน','value'=> $data_result['WATER_PONDS_OWN']);
				$list_water[] = array('name'=>'บ่อบาดาลสาธารณะ '.number_format($data_result['WATER_GROUNDWATER_WELLS_PUBLIC']).' คน','value'=> $data_result['WATER_GROUNDWATER_WELLS_PUBLIC']);
				$list_water[] = array('name'=>'หนอง/สระ '.number_format($data_result['WATER_SWAMP_PUBLIC']).' คน','value'=> $data_result['WATER_SWAMP_PUBLIC']);
				$list_water[] = array('name'=>'คลองชลประทาน '.number_format($data_result['WATER_IRRIGATION_CANAL_PUBLIC']).' คน','value'=> $data_result['WATER_IRRIGATION_CANAL_PUBLIC']);
				$list_water[] = array('name'=>'แม่น้ำ '.number_format($data_result['WATER_RIVER_PUBLIC']).' คน','value'=> $data_result['WATER_RIVER_PUBLIC']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_water;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $datas)
			{
				$total = $total+1;
				foreach ($datas as $k=>$v)
				{
					
					if(isset($data_result[$k])&&!empty($v))
					{
						foreach ($v as $data_on_array)
						{
							$data_result[$k] += 1;
							
						}
					}
				}
				
				
			}
			
			
			$list_water[] = array('name'=>'บ่อน้ำตื้น '.number_format($data_result['WATER_SHALLOW_WELL_OWN']).' คน','value'=> $data_result['WATER_SHALLOW_WELL_OWN']);
			$list_water[] = array('name'=>'บ่อบาดาลตนเอง '.number_format($data_result['WATER_GROUNDWATER_WELLS_OWN']).' คน','value'=> $data_result['WATER_GROUNDWATER_WELLS_OWN']);
			$list_water[] = array('name'=>'สระน้ำตนเอง '.number_format($data_result['WATER_PONDS_OWN']).' คน','value'=> $data_result['WATER_PONDS_OWN']);
			$list_water[] = array('name'=>'บ่อบาดาลสาธารณะ '.number_format($data_result['WATER_GROUNDWATER_WELLS_PUBLIC']).' คน','value'=> $data_result['WATER_GROUNDWATER_WELLS_PUBLIC']);
			$list_water[] = array('name'=>'หนอง/สระ '.number_format($data_result['WATER_SWAMP_PUBLIC']).' คน','value'=> $data_result['WATER_SWAMP_PUBLIC']);
			$list_water[] = array('name'=>'คลองชลประทาน '.number_format($data_result['WATER_IRRIGATION_CANAL_PUBLIC']).' คน','value'=> $data_result['WATER_IRRIGATION_CANAL_PUBLIC']);
			$list_water[] = array('name'=>'แม่น้ำ '.number_format($data_result['WATER_RIVER_PUBLIC']).' คน','value'=> $data_result['WATER_RIVER_PUBLIC']);
			
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_water;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	
	
	public function count_member_cow()
	{
		$data_response = array();
		
		$year = $this->input->get('filter_year');
		$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
		$range_income = !empty($this->input->get('filter_range_income_hidden'))?$this->input->get('filter_range_income_hidden'):"";
		
		
		
		
		
		
		if(empty($year))
		{
			$data_response['status'] = false;
			$data_response['message'] = 'year empty';
			
			echo json_encode($data_response);
			exit();
		}
		
		
		$this->db->select(strtoupper('tab7_a1_cows1,tab7_a1_cows2,tab7_a1_cows3,tab7_a1_cows4,tab7_a1_cows5,tab7_a1_cowsmilk_pregnant,tab7_a1_cowsmilk_notpregnant,tab7_a1_cowsmilk_all,tab7_a1_cowslay_pregnant,tab7_a1_cowslay_notpregnant,tab7_a1_cowslay_all'));
		
		if(!empty($province) && $province !="")
			$this->db->where('PROVINCE_ID',$province);
			
			
			$data_result['TAB7_A1_COWS1'] = 0;
			$data_result['TAB7_A1_COWS2'] = 0;
			$data_result['TAB7_A1_COWS3'] = 0;
			$data_result['TAB7_A1_COWS4'] = 0;
			$data_result['TAB7_A1_COWS5'] = 0;
			$data_result['TAB7_A1_COWSMILK_PREGNANT'] = 0;
			$data_result['TAB7_A1_COWSMILK_NOTPREGNANT'] = 0;
			$data_result['TAB7_A1_COWSMILK_ALL'] = 0;
			$data_result['TAB7_A1_COWSLAY_PREGNANT'] = 0;
			$data_result['TAB7_A1_COWSLAY_NOTPREGNANT'] = 0;
			$data_result['TAB7_A1_COWSLAY_ALL'] = 0;
			$data_survey = getListDataSurvey($year);
			$TAB7_A1_COWS1 = 0;
			
			if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
			foreach ($data_survey as $data)
			{
				if(!empty($data) && is_array($data) && sizeof($data)>0)
				foreach ($data as $k=>$v)
				{
					
					if(isset($data_result[$k]) && !empty($v))
					{
						if(sizeof($v)>0 && $this->check_data_count_member_cow($v))
							$data_result[$k] +=1;
					}
				}
				
			}
			
			$this->response_data($data_result);
	}
	
	private function check_data_count_member_cow($data)
	{
		if(!empty($data) && is_array($data) && sizeof($data)>0)
		{
			foreach ($data as $k=>$v)
			{
				if(!empty($v))
				{
					return true;
				}
			}
			return false;
		}
	}
	
	
	public function count_cow ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$data_response = array();
			
			$year = !empty($this->input->get('filter_year'))?$this->input->get('filter_year'):"2018";
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
// 			$range_income = !empty($this->input->get('filter_range_income_hidden'))?$this->input->get('filter_range_income_hidden'):"";
			
			
			
			
			
			
			if(empty($year))
			{
				$data_response['status'] = false;
				$data_response['message'] = 'year empty';
				
				echo json_encode($data_response);
				exit();
			}
			
			
			$this->db->select(strtoupper('tab7_a1_cows1,tab7_a1_cows2,tab7_a1_cows3,tab7_a1_cows4,tab7_a1_cows5,tab7_a1_cowsmilk_pregnant,tab7_a1_cowsmilk_notpregnant,tab7_a1_cowsmilk_all,tab7_a1_cowslay_pregnant,tab7_a1_cowslay_notpregnant,tab7_a1_cowslay_all'));
			
			if(!empty($province) && $province !="")
			$this->db->where('PROVINCE_ID',$province);
			
			$this->rang_income();
			
			$data_survey = getListDataSurvey($year);
// 			echo "<pre>";print_r($data_survey);echo "</pre>";
			
			
			$data_result = array();
			$data_result['TAB7_A1_COWS1'] = 0;
			$data_result['TAB7_A1_COWS2'] = 0;
			$data_result['TAB7_A1_COWS3'] = 0;
			$data_result['TAB7_A1_COWS4'] = 0;
			$data_result['TAB7_A1_COWS5'] = 0;
			$data_result['TAB7_A1_COWSMILK_PREGNANT'] = 0;
			$data_result['TAB7_A1_COWSMILK_NOTPREGNANT'] = 0;
			$data_result['TAB7_A1_COWSMILK_ALL'] = 0;
			$data_result['TAB7_A1_COWSLAY_PREGNANT'] = 0;
			$data_result['TAB7_A1_COWSLAY_NOTPREGNANT'] = 0;
			$data_result['TAB7_A1_COWSLAY_ALL'] = 0;
			
			$count_row = 0;
			
			if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
			foreach ($data_survey as $data)
			{
				$validate = false;
				if(!empty($data) && is_array($data) && sizeof($data)>0)
				foreach ($data as $k=>$v)
				{
					
					if(isset($data_result[$k]) && !empty($v))
					{
						foreach ($v as $data_on_array)
						{
							
							$data_result[$k] += $this->validate_nummeric_and_emty($data_on_array);
							
							if(intval($data_result[$k])>0)
							{
								$validate = true;
							}
						}
					}
				}
				if($validate)
				{
					$count_row++;
				}
			}
			
			$data_response['ลูกโค 0-1 เดือน(ตัว)'] = $data_result['TAB7_A1_COWS1'];
			$data_response['ลูกโค 1เดือน-1ปี(ตัว)'] = $data_result['TAB7_A1_COWS2'];
			$data_response['โคสาว 1ปี-2ปี (ตัว)'] = $data_result['TAB7_A1_COWS3'];
			$data_response['โคสาว 2ปี-ไม่ท้อง'] = $data_result['TAB7_A1_COWS4'];
			$data_response['โคสาว ท้อง (ตัว)'] = $data_result['TAB7_A1_COWS5'];
			$data_response['แม่โคเตรียมรีดนม ท้อง (ตัว)'] = $data_result['TAB7_A1_COWSMILK_PREGNANT'];
			$data_response['แม่โคเตรียมรีดนมไม่ท้อง (ตัว)'] = $data_result['TAB7_A1_COWSMILK_NOTPREGNANT'];
			$data_response['แม่โครายท้อง (ตัว)'] = $data_result['TAB7_A1_COWSLAY_PREGNANT'];
			$data_response['แม่โครายไม่ท้อง (ตัว)'] = $data_result['TAB7_A1_COWSLAY_NOTPREGNANT'];
			
			$data =array();
			$data['data'] = $data_response;
			$data['count'] = $count_row;
			$data['countall'] =  getCountRowSurvey($year);
			
			$this->response_data($data);
			
			
			
		}else {
			$data_response['status'] = false;
			$data_response['message'] = 'permission denied';
			
			$this->response_data($data_response);
		}
	}
	
	public function count_calrose_rice()
	{
		$year = !empty($this->input->get('filter_year'))?$this->input->get('filter_year'):"2018";
		$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
		
		$this->db->select(strtoupper('plant_type,growing_area,growing_area_will'));
		if(!empty($province) && $province !="")
			$this->db->where('PROVINCE_ID',$province);
		
			$this->rang_income();
		$data_survey = getListDataSurvey($year);
		
		
	
		
		$data_response = array();
		
		$data_result= array();
		$data_result[1]['GROWING_AREA'] = 0;
		$data_result[1]['GROWING_AREA_WILL'] = 0;
		$data_result[2]['GROWING_AREA'] = 0;
		$data_result[2]['GROWING_AREA_WILL'] = 0;
		$data_result[3]['GROWING_AREA'] = 0;
		$data_result[3]['GROWING_AREA_WILL'] = 0;
		
		$count_row = 0;
		
		if(!empty($data_survey) && is_array($data_survey) && sizeof($data_survey)>0)
		for ($j=0;$j<sizeof($data_survey);$j++)
		{
			$validate = false;
			if(!empty($data_survey[$j]['PLANT_TYPE']))
			{
				
				if(!empty($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
				{
					if(!empty($data_survey[$j]['PLANT_TYPE']) && is_array($data_survey[$j]['PLANT_TYPE']) && sizeof($data_survey[$j]['PLANT_TYPE'])>0)
					for($i=0;$i<sizeof($data_survey[$j]['PLANT_TYPE']);$i++)
					{
						if(!empty($data_survey[$j]['PLANT_TYPE'][$i]) && ($data_survey[$j]['PLANT_TYPE'][$i] == 1 || $data_survey[$j]['PLANT_TYPE'][$i] == 2 || $data_survey[$j]['PLANT_TYPE'][$i] == 3 ))
						{
							
							if(!empty($data_survey[$j]['GROWING_AREA'][$i]))
							{
								if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA']))
								{
									$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] = 0;
								}
								$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA'][$i]);
								
								if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA'])>0)
								{
									$validate = true;
								}
								
							}
							if(!empty($data_survey[$j]['GROWING_AREA_WILL'][$i]))
							{
								if(empty($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL']))
								{
									$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] = 0;
								}
								if(!is_numeric($data_survey[$j]['GROWING_AREA_WILL'][$i])){
									$data_survey[$j]['GROWING_AREA_WILL'][$i] = 0;
								}
								$data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'] +=$this->validate_nummeric_and_emty($data_survey[$j]['GROWING_AREA_WILL'][$i]);
								if(intval($data_result[$data_survey[$j]['PLANT_TYPE'][$i]]['GROWING_AREA_WILL'])>0)
								{
									$validate = true;
								}
							}
						}
					}
					
				}
				if($validate)
				{
					$count_row++;
				}
				
			}

		}
		
		$data_response['ข้าวหอมมะลิ']['ปลูกแล้ว'] = $data_result[1]['GROWING_AREA'];
		$data_response['ข้าวหอมมะลิ']['จะปลูก'] = $data_result[1]['GROWING_AREA_WILL'];
		$data_response['ข้าวเหนียว']['ปลูกแล้ว'] = $data_result[2]['GROWING_AREA'];
		$data_response['ข้าวเหนียว']['จะปลูก'] = $data_result[2]['GROWING_AREA_WILL'];
		$data_response['ข้าวจ้าว']['ปลูกแล้ว'] = $data_result[3]['GROWING_AREA'];
		$data_response['ข้าวจ้าว']['จะปลูก'] = $data_result[3]['GROWING_AREA_WILL'];
		
		
		$data =array();
		$data['data'] = $data_response;
		$data['count'] = $count_row;
		$data['countall'] =  getCountRowSurvey($year);
		$this->response_data($data);
		
		
// 		$this->response_data($data_response);
	}
	public function own_land_type()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('OWN_LAND_TYPE');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			$own_land_type_array = array();
			$own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3'] = 0;
			$own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.'] = 0;
			$own_land_type_array['น.ส.2/น.ส.1/ภบท.5/'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_own_land[] = array('name'=>'โฉนด/น.ส.3 ก./น.ส.3 '.number_format($own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3']).' คน','value'=> $own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3']);
				$list_own_land[] = array('name'=>'สปก.4-01/น.คส.ท.ก./ก.ส.น. '.number_format($own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.']).' คน','value'=> $own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.']);
				$list_own_land[] = array('name'=>'น.ส.2/น.ส.1/ภบท.5/ '.number_format($own_land_type_array['น.ส.2/น.ส.1/ภบท.5/']).' คน','value'=> $own_land_type_array['น.ส.2/น.ส.1/ภบท.5/']);
				
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_own_land;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
		
			foreach ($data_report as $data)
			{
				if (!isset($data['OWN_LAND_TYPE']) || empty($data['OWN_LAND_TYPE']) || sizeof($data['OWN_LAND_TYPE'])<=0) {
					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['OWN_LAND_TYPE'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '1':
							$own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3']= intval($own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3'])+1;							
							break;
						case '2':
							$own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.']= intval($own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.'])+1;
							break;
						case '3':
							$own_land_type_array['น.ส.2/น.ส.1/ภบท.5/']= intval($own_land_type_array['น.ส.2/น.ส.1/ภบท.5/'])+1;
							break;
					}
				}
				
			}	
			$list_own_land[] = array('name'=>'โฉนด/น.ส.3 ก./น.ส.3 '.number_format($own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3']).' คน','value'=> $own_land_type_array['โฉนด/น.ส.3 ก./น.ส.3']);
			$list_own_land[] = array('name'=>'สปก.4-01/น.คส.ท.ก./ก.ส.น. '.number_format($own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.']).' คน','value'=> $own_land_type_array['สปก.4-01/น.คส.ท.ก./ก.ส.น.']);
			$list_own_land[] = array('name'=>'น.ส.2/น.ส.1/ภบท.5/ '.number_format($own_land_type_array['น.ส.2/น.ส.1/ภบท.5/']).' คน','value'=> $own_land_type_array['น.ส.2/น.ส.1/ภบท.5/']);
	
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_own_land;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function count_type_plant()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('PLANT_TYPE');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report = getListDataSurvey();
			
		
			
			$plant_type_array = array();
			$plant_type_array['ข้าวหอมมะลิ'] = 0;
			$plant_type_array['ข้าวเหนียว'] = 0;
			$plant_type_array['ข้าวจ้าว'] = 0;
			$plant_type_array['มันสำปะหลัง'] = 0;
			$plant_type_array['ปาล์มน้ำมัน'] = 0;
			$plant_type_array['ยางพารา'] = 0;
			$plant_type_array['ลำไย'] = 0;
			$plant_type_array['ทุเรียน'] = 0;
			$plant_type_array['มังคุด'] = 0;
			$plant_type_array['สับปะรด'] = 0;
			$plant_type_array['ถั่วเหลือง'] = 0;
			$plant_type_array['ข้าวโพดเลี้ยงสัตว์'] = 0;
			$plant_type_array['อ้อย'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_plant_type[] = array('name'=>'ข้าวหอมมะลิ '.number_format($plant_type_array['ข้าวหอมมะลิ']).' คน','value'=> $plant_type_array['ข้าวหอมมะลิ']);
				$list_plant_type[] = array('name'=>'ข้าวเหนียว '.number_format($plant_type_array['ข้าวเหนียว']).' คน','value'=> $plant_type_array['ข้าวเหนียว']);
				$list_plant_type[] = array('name'=>'ข้าวจ้าว '.number_format($plant_type_array['ข้าวจ้าว']).' คน','value'=> $plant_type_array['ข้าวจ้าว']);
				$list_plant_type[] = array('name'=>'มันสำปะหลัง '.number_format($plant_type_array['มันสำปะหลัง']).' คน','value'=> $plant_type_array['มันสำปะหลัง']);
				$list_plant_type[] = array('name'=>'ปาล์มน้ำมัน '.number_format($plant_type_array['ปาล์มน้ำมัน']).' คน','value'=> $plant_type_array['ปาล์มน้ำมัน']);
				$list_plant_type[] = array('name'=>'ยางพารา '.number_format($plant_type_array['ยางพารา']).' คน','value'=> $plant_type_array['ยางพารา']);
				$list_plant_type[] = array('name'=>'ลำไย '.number_format($plant_type_array['ลำไย']).' คน','value'=> $plant_type_array['ลำไย']);
				$list_plant_type[] = array('name'=>'ทุเรียน '.number_format($plant_type_array['ทุเรียน']).' คน','value'=> $plant_type_array['ทุเรียน']);
				$list_plant_type[] = array('name'=>'มังคุด '.number_format($plant_type_array['มังคุด']).' คน','value'=> $plant_type_array['มังคุด']);
				$list_plant_type[] = array('name'=>'สับปะรด '.number_format($plant_type_array['สับปะรด']).' คน','value'=> $plant_type_array['สับปะรด']);
				$list_plant_type[] = array('name'=>'ถั่วเหลือง '.number_format($plant_type_array['ถั่วเหลือง']).' คน','value'=> $plant_type_array['ถั่วเหลือง']);
				$list_plant_type[] = array('name'=>'ข้าวโพดเลี้ยงสัตว์ '.number_format($plant_type_array['ข้าวโพดเลี้ยงสัตว์']).' คน','value'=> $plant_type_array['ข้าวโพดเลี้ยงสัตว์']);
				$list_plant_type[] = array('name'=>'อ้อย '.number_format($plant_type_array['อ้อย']).' คน','value'=> $plant_type_array['อ้อย']);
				
				
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_plant_type;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['PLANT_TYPE']) || empty($data['PLANT_TYPE']) || sizeof($data['PLANT_TYPE'])<=0) {
// 					$total = $total+1;
					continue;
				}
				
				
				foreach($data['PLANT_TYPE'] as $key=>$value)
				{
					$check_data = false;
					if(!empty($value) && $value != '' && $value !='0')
					{
						$check_data = true;
					}
					
					switch ($value)
					{
						case '1':
							$plant_type_array['ข้าวหอมมะลิ']= intval($plant_type_array['ข้าวหอมมะลิ'])+1;
							break;
						case '2':
							$plant_type_array['ข้าวเหนียว'] = intval($plant_type_array['ข้าวเหนียว'])+1;
							break;
						case '3':
							$plant_type_array['ข้าวจ้าว'] = intval($plant_type_array['ข้าวจ้าว'])+1;
							break;
						case '4':
							$plant_type_array['มันสำปะหลัง'] = intval($plant_type_array['มันสำปะหลัง'])+1;
							break;
						case '5':
							$plant_type_array['ปาล์มน้ำมัน'] = intval($plant_type_array['ปาล์มน้ำมัน'])+1;
							break;
						case '6':
							$plant_type_array['ยางพารา'] = intval($plant_type_array['ยางพารา'])+1;
							break;
						case '7':
							$plant_type_array['ลำไย'] = intval($plant_type_array['ลำไย'])+1;
							break;
						case '8':
							$plant_type_array['ทุเรียน'] = intval($plant_type_array['ทุเรียน'])+1;
							break;
						case '9':
							$plant_type_array['มังคุด'] = intval($plant_type_array['มังคุด'])+1;
							break;
						case '10':
							$plant_type_array['สับปะรด'] = intval($plant_type_array['สับปะรด'])+1;
							break;
						case '11':
							$plant_type_array['ถั่วเหลือง'] = intval($plant_type_array['ถั่วเหลือง'])+1;
							break;
						case '12':
							$plant_type_array['ข้าวโพดเลี้ยงสัตว์'] = intval($plant_type_array['ข้าวโพดเลี้ยงสัตว์'])+1;
							break;
						case '13':
							$plant_type_array['อ้อย'] = intval($plant_type_array['อ้อย'])+1;
							break;
							
					}
				}
				if($check_data)
				{
					$total = $total+1;
				}
			}	
			
			$list_plant_type[] = array('name'=>'ข้าวหอมมะลิ '.number_format($plant_type_array['ข้าวหอมมะลิ']).' คน','value'=> $plant_type_array['ข้าวหอมมะลิ']);
			$list_plant_type[] = array('name'=>'ข้าวเหนียว '.number_format($plant_type_array['ข้าวเหนียว']).' คน','value'=> $plant_type_array['ข้าวเหนียว']);
			$list_plant_type[] = array('name'=>'ข้าวจ้าว '.number_format($plant_type_array['ข้าวจ้าว']).' คน','value'=> $plant_type_array['ข้าวจ้าว']);
			$list_plant_type[] = array('name'=>'มันสำปะหลัง '.number_format($plant_type_array['มันสำปะหลัง']).' คน','value'=> $plant_type_array['มันสำปะหลัง']);
			$list_plant_type[] = array('name'=>'ปาล์มน้ำมัน '.number_format($plant_type_array['ปาล์มน้ำมัน']).' คน','value'=> $plant_type_array['ปาล์มน้ำมัน']);
			$list_plant_type[] = array('name'=>'ยางพารา '.number_format($plant_type_array['ยางพารา']).' คน','value'=> $plant_type_array['ยางพารา']);
			$list_plant_type[] = array('name'=>'ลำไย '.number_format($plant_type_array['ลำไย']).' คน','value'=> $plant_type_array['ลำไย']);
			$list_plant_type[] = array('name'=>'ทุเรียน '.number_format($plant_type_array['ทุเรียน']).' คน','value'=> $plant_type_array['ทุเรียน']);
			$list_plant_type[] = array('name'=>'มังคุด '.number_format($plant_type_array['มังคุด']).' คน','value'=> $plant_type_array['มังคุด']);
			$list_plant_type[] = array('name'=>'สับปะรด '.number_format($plant_type_array['สับปะรด']).' คน','value'=> $plant_type_array['สับปะรด']);
			$list_plant_type[] = array('name'=>'ถั่วเหลือง '.number_format($plant_type_array['ถั่วเหลือง']).' คน','value'=> $plant_type_array['ถั่วเหลือง']);
			$list_plant_type[] = array('name'=>'ข้าวโพดเลี้ยงสัตว์ '.number_format($plant_type_array['ข้าวโพดเลี้ยงสัตว์']).' คน','value'=> $plant_type_array['ข้าวโพดเลี้ยงสัตว์']);
			$list_plant_type[] = array('name'=>'อ้อย '.number_format($plant_type_array['อ้อย']).' คน','value'=> $plant_type_array['อ้อย']);

			
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_plant_type;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
		
		
	}
	
	private function response_data($data)
	{
		echo json_encode($data);
	}
	
	private function print_data($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	public function how2sell()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('HOW2SELL');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
			
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
		
			
			$how2sell_type_array = array();
			$how2sell_type_array['นำไปขายที่ตลาดกลาง'] = 0;
			$how2sell_type_array['พ่อค้ามาซื้อที่ผลิต'] = 0;
			$how2sell_type_array['ขายผลผลิตล่วงหน้า'] = 0;
			$how2sell_type_array['อื่นๆ'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_how2sell_type[] = array('name'=>'นำไปขายที่ตลาดกลาง '.number_format($how2sell_type_array['นำไปขายที่ตลาดกลาง']).' คน','value'=> $how2sell_type_array['นำไปขายที่ตลาดกลาง']);
				$list_how2sell_type[] = array('name'=>'พ่อค้ามาซื้อที่ผลิต '.number_format($how2sell_type_array['พ่อค้ามาซื้อที่ผลิต']).' คน','value'=> $how2sell_type_array['พ่อค้ามาซื้อที่ผลิต']);
				$list_how2sell_type[] = array('name'=>'ขายผลผลิตล่วงหน้า '.number_format($how2sell_type_array['ขายผลผลิตล่วงหน้า']).' คน','value'=> $how2sell_type_array['ขายผลผลิตล่วงหน้า']);
				$list_how2sell_type[] = array('name'=>'อื่นๆ '.number_format($how2sell_type_array['อื่นๆ']).' คน','value'=> $how2sell_type_array['อื่นๆ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_how2sell_type;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['HOW2SELL']) || empty($data['HOW2SELL'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['HOW2SELL'] as $key=>$value)
				{
					
					switch ($key)
					{
						case '0':
							$how2sell_type_array['นำไปขายที่ตลาดกลาง']= intval($how2sell_type_array['นำไปขายที่ตลาดกลาง'])+1;
							break;
						case '1':
							$how2sell_type_array['พ่อค้ามาซื้อที่ผลิต'] = intval($how2sell_type_array['พ่อค้ามาซื้อที่ผลิต'])+1;
							break;
						case '2':
							$how2sell_type_array['ขายผลผลิตล่วงหน้า'] = intval($how2sell_type_array['ขายผลผลิตล่วงหน้า'])+1;
							break;
						case '3':
							$how2sell_type_array['อื่นๆ'] = intval($how2sell_type_array['อื่นๆ'])+1;
							break;
					}
				}
				
			}
			
			$list_how2sell_type[] = array('name'=>'นำไปขายที่ตลาดกลาง '.number_format($how2sell_type_array['นำไปขายที่ตลาดกลาง']).' คน','value'=> $how2sell_type_array['นำไปขายที่ตลาดกลาง']);
			$list_how2sell_type[] = array('name'=>'พ่อค้ามาซื้อที่ผลิต '.number_format($how2sell_type_array['พ่อค้ามาซื้อที่ผลิต']).' คน','value'=> $how2sell_type_array['พ่อค้ามาซื้อที่ผลิต']);
			$list_how2sell_type[] = array('name'=>'ขายผลผลิตล่วงหน้า '.number_format($how2sell_type_array['ขายผลผลิตล่วงหน้า']).' คน','value'=> $how2sell_type_array['ขายผลผลิตล่วงหน้า']);
			$list_how2sell_type[] = array('name'=>'อื่นๆ '.number_format($how2sell_type_array['อื่นๆ']).' คน','value'=> $how2sell_type_array['อื่นๆ']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_how2sell_type;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function product_sale_comment()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('PRODUCT_SALE_COMMENT,PRODUCT_SALE_COMMENT2');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
		
			
			$sale_comment_type1_array = array();
			$sale_comment_type1_array['เป็นทางเลือกที่ดี'] = 0;
			$sale_comment_type1_array['การชั่วตวง เชื่อถือได้'] = 0;
			$sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง'] = 0;
			$sale_comment_type1_array['ราคาซื้อขายเป็นธรรม'] = 0;
			$sale_comment_type1_array['ความสะดวก'] = 0;
			$sale_comment_type1_array['พอใจในการบริการ'] = 0;
			$sale_comment_type1_array['อื่นๆ'] = 0;
			
			$sale_comment_type2_array = array();
			$sale_comment_type2_array['เป็นทางเลือกที่ดี'] = 0;
			$sale_comment_type2_array['การชั่วตวง เชื่อถือได้'] = 0;
			$sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง'] = 0;
			$sale_comment_type2_array['ราคาซื้อขายเป็นธรรม'] = 0;
			$sale_comment_type2_array['ความสะดวก'] = 0;
			$sale_comment_type2_array['พอใจในการบริการ'] = 0;
			$sale_comment_type2_array['อื่นๆ'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_sale_comment_type1[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($sale_comment_type1_array['เป็นทางเลือกที่ดี']).' คน','value'=> $sale_comment_type1_array['เป็นทางเลือกที่ดี']);
				$list_sale_comment_type1[] = array('name'=>'การชั่วตวง เชื่อถือได้ '.number_format($sale_comment_type1_array['การชั่วตวง เชื่อถือได้']).' คน','value'=> $sale_comment_type1_array['การชั่วตวง เชื่อถือได้']);
				$list_sale_comment_type1[] = array('name'=>'รับเงินค่าผลผลิตตามข้อตกลง '.number_format($sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง']).' คน','value'=> $sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง']);
				$list_sale_comment_type1[] = array('name'=>'ราคาซื้อขายเป็นธรรม '.number_format($sale_comment_type1_array['ราคาซื้อขายเป็นธรรม']).' คน','value'=> $sale_comment_type1_array['ราคาซื้อขายเป็นธรรม']);
				$list_sale_comment_type1[] = array('name'=>'ความสะดวก '.number_format($sale_comment_type1_array['ความสะดวก']).' คน','value'=> $sale_comment_type1_array['ความสะดวก']);
				$list_sale_comment_type1[] = array('name'=>'พอใจในการบริการ '.number_format($sale_comment_type1_array['พอใจในการบริการ']).' คน','value'=> $sale_comment_type1_array['พอใจในการบริการ']);
				$list_sale_comment_type1[] = array('name'=>'อื่นๆ '.number_format($sale_comment_type1_array['อื่นๆ']).' คน','value'=> $sale_comment_type1_array['อื่นๆ']);
				
				$list_sale_comment_type2[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($sale_comment_type2_array['เป็นทางเลือกที่ดี']).' คน','value'=> $sale_comment_type2_array['เป็นทางเลือกที่ดี']);
				$list_sale_comment_type2[] = array('name'=>'การชั่วตวง เชื่อถือได้ '.number_format($sale_comment_type2_array['การชั่วตวง เชื่อถือได้']).' คน','value'=> $sale_comment_type2_array['การชั่วตวง เชื่อถือได้']);
				$list_sale_comment_type2[] = array('name'=>'รับเงินค่าผลผลิตตามข้อตกลง '.number_format($sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง']).' คน','value'=> $sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง']);
				$list_sale_comment_type2[] = array('name'=>'ราคาซื้อขายเป็นธรรม '.number_format($sale_comment_type2_array['ราคาซื้อขายเป็นธรรม']).' คน','value'=> $sale_comment_type2_array['ราคาซื้อขายเป็นธรรม']);
				$list_sale_comment_type2[] = array('name'=>'ความสะดวก '.number_format($sale_comment_type2_array['ความสะดวก']).' คน','value'=> $sale_comment_type2_array['ความสะดวก']);
				$list_sale_comment_type2[] = array('name'=>'พอใจในการบริการ '.number_format($sale_comment_type2_array['พอใจในการบริการ']).' คน','value'=> $sale_comment_type2_array['พอใจในการบริการ']);
				$list_sale_comment_type2[] = array('name'=>'อื่นๆ '.number_format($sale_comment_type2_array['อื่นๆ']).' คน','value'=> $sale_comment_type2_array['อื่นๆ']);
				
				$list_sale_comment['ขายผลผลิตให้กับสหกรณ์'] = $list_sale_comment_type1;
				$list_sale_comment['ขายผลผลิตให้กับพ่อค้า'] = $list_sale_comment_type2;
				
				$list_comment[] = 'เป็นทางเลือกที่ดี';
				$list_comment[] = 'การชั่วตวง เชื่อถือได้';
				$list_comment[] ='รับเงินค่าผลผลิตตามข้อตกลง';
				$list_comment[] = 'ราคาซื้อขายเป็นธรรม';
				$list_comment[] ='ความสะดวก';
				$list_comment[] ='พอใจในการบริการ';
				$list_comment[] = 'อื่นๆ';
				
				$output = array();
				$output['total'] = $total;
				$output['list_comment'] = $list_comment;
				$output['list_data'] = $list_sale_comment;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['PRODUCT_SALE_COMMENT']) || empty($data['PRODUCT_SALE_COMMENT']) ||
						!isset($data['PRODUCT_SALE_COMMENT2']) || empty($data['PRODUCT_SALE_COMMENT2'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['PRODUCT_SALE_COMMENT'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '4':
							$sale_comment_type1_array['เป็นทางเลือกที่ดี']= intval($sale_comment_type1_array['เป็นทางเลือกที่ดี'])+1;
							break;
						case '5':
							$sale_comment_type1_array['การชั่วตวง เชื่อถือได้'] = intval($sale_comment_type1_array['การชั่วตวง เชื่อถือได้'])+1;
							break;
						case '6':
							$sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง'] = intval($sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง'])+1;
							break;
						case '7':
							$sale_comment_type1_array['ราคาซื้อขายเป็นธรรม'] = intval($sale_comment_type1_array['ราคาซื้อขายเป็นธรรม'])+1;
							break;
						case '8':
							$sale_comment_type1_array['ความสะดวก'] = intval($sale_comment_type1_array['ความสะดวก'])+1;
							break;
						case '9':
							$sale_comment_type1_array['พอใจในการบริการ'] = intval($sale_comment_type1_array['พอใจในการบริการ'])+1;
							break;
						case '10':
							$sale_comment_type1_array['อื่นๆ'] = intval($sale_comment_type1_array['อื่นๆ'])+1;
							break;
					}
				}
				foreach($data['PRODUCT_SALE_COMMENT2'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '4':
							$sale_comment_type2_array['เป็นทางเลือกที่ดี']= intval($sale_comment_type2_array['เป็นทางเลือกที่ดี'])+1;
							break;
						case '5':
							$sale_comment_type2_array['การชั่วตวง เชื่อถือได้'] = intval($sale_comment_type2_array['การชั่วตวง เชื่อถือได้'])+1;
							break;
						case '6':
							$sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง'] = intval($sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง'])+1;
							break;
						case '7':
							$sale_comment_type2_array['ราคาซื้อขายเป็นธรรม'] = intval($sale_comment_type2_array['ราคาซื้อขายเป็นธรรม'])+1;
							break;
						case '8':
							$sale_comment_type2_array['ความสะดวก'] = intval($sale_comment_type2_array['ความสะดวก'])+1;
							break;
						case '9':
							$sale_comment_type2_array['พอใจในการบริการ'] = intval($sale_comment_type2_array['พอใจในการบริการ'])+1;
							break;
						case '10':
							$sale_comment_type2_array['อื่นๆ'] = intval($sale_comment_type2_array['อื่นๆ'])+1;
							break;
					}
				}
				
				
			}
			
			$list_sale_comment_type1[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($sale_comment_type1_array['เป็นทางเลือกที่ดี']).' คน','value'=> $sale_comment_type1_array['เป็นทางเลือกที่ดี']);
			$list_sale_comment_type1[] = array('name'=>'การชั่วตวง เชื่อถือได้ '.number_format($sale_comment_type1_array['การชั่วตวง เชื่อถือได้']).' คน','value'=> $sale_comment_type1_array['การชั่วตวง เชื่อถือได้']);
			$list_sale_comment_type1[] = array('name'=>'รับเงินค่าผลผลิตตามข้อตกลง '.number_format($sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง']).' คน','value'=> $sale_comment_type1_array['รับเงินค่าผลผลิตตามข้อตกลง']);
			$list_sale_comment_type1[] = array('name'=>'ราคาซื้อขายเป็นธรรม '.number_format($sale_comment_type1_array['ราคาซื้อขายเป็นธรรม']).' คน','value'=> $sale_comment_type1_array['ราคาซื้อขายเป็นธรรม']);
			$list_sale_comment_type1[] = array('name'=>'ความสะดวก '.number_format($sale_comment_type1_array['ความสะดวก']).' คน','value'=> $sale_comment_type1_array['ความสะดวก']);
			$list_sale_comment_type1[] = array('name'=>'พอใจในการบริการ '.number_format($sale_comment_type1_array['พอใจในการบริการ']).' คน','value'=> $sale_comment_type1_array['พอใจในการบริการ']);
			$list_sale_comment_type1[] = array('name'=>'อื่นๆ '.number_format($sale_comment_type1_array['อื่นๆ']).' คน','value'=> $sale_comment_type1_array['อื่นๆ']);
			
			$list_sale_comment_type2[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($sale_comment_type2_array['เป็นทางเลือกที่ดี']).' คน','value'=> $sale_comment_type2_array['เป็นทางเลือกที่ดี']);
			$list_sale_comment_type2[] = array('name'=>'การชั่วตวง เชื่อถือได้ '.number_format($sale_comment_type2_array['การชั่วตวง เชื่อถือได้']).' คน','value'=> $sale_comment_type2_array['การชั่วตวง เชื่อถือได้']);
			$list_sale_comment_type2[] = array('name'=>'รับเงินค่าผลผลิตตามข้อตกลง '.number_format($sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง']).' คน','value'=> $sale_comment_type2_array['รับเงินค่าผลผลิตตามข้อตกลง']);
			$list_sale_comment_type2[] = array('name'=>'ราคาซื้อขายเป็นธรรม '.number_format($sale_comment_type2_array['ราคาซื้อขายเป็นธรรม']).' คน','value'=> $sale_comment_type2_array['ราคาซื้อขายเป็นธรรม']);
			$list_sale_comment_type2[] = array('name'=>'ความสะดวก '.number_format($sale_comment_type2_array['ความสะดวก']).' คน','value'=> $sale_comment_type2_array['ความสะดวก']);
			$list_sale_comment_type2[] = array('name'=>'พอใจในการบริการ '.number_format($sale_comment_type2_array['พอใจในการบริการ']).' คน','value'=> $sale_comment_type2_array['พอใจในการบริการ']);
			$list_sale_comment_type2[] = array('name'=>'อื่นๆ '.number_format($sale_comment_type2_array['อื่นๆ']).' คน','value'=> $sale_comment_type2_array['อื่นๆ']);
			
			$list_sale_comment['ขายผลผลิตให้กับสหกรณ์'] = $list_sale_comment_type1;
			$list_sale_comment['ขายผลผลิตให้กับพ่อค้า'] = $list_sale_comment_type2;
			
			$list_comment[] = 'เป็นทางเลือกที่ดี';
			$list_comment[] = 'การชั่วตวง เชื่อถือได้';
			$list_comment[] ='รับเงินค่าผลผลิตตามข้อตกลง';
			$list_comment[] = 'ราคาซื้อขายเป็นธรรม';
			$list_comment[] ='ความสะดวก';
			$list_comment[] ='พอใจในการบริการ';
			$list_comment[] = 'อื่นๆ';
			
			$output = array();
			$output['total'] = $total;
			$output['list_comment'] = $list_comment;
			$output['list_data'] = $list_sale_comment;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	
	public function land_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A1');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			
			$land_problem_array = array();
			$land_problem_array['ไม่มีปัญหา'] = 0;
			$land_problem_array['มีปัญหา'] = 0;
	
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_land_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($land_problem_array['ไม่มีปัญหา']).' คน','value'=> $land_problem_array['ไม่มีปัญหา']);
				$list_land_problem[] = array('name'=>'มีปัญหา '.number_format($land_problem_array['มีปัญหา']).' คน','value'=> $land_problem_array['มีปัญหา']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_land_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A1']) || empty($data['TAB5_A1'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['TAB5_A1'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '0':
							$land_problem_array['ไม่มีปัญหา']= intval($land_problem_array['ไม่มีปัญหา'])+1;
							break;
						case '2':
							$land_problem_array['มีปัญหา'] = intval($land_problem_array['มีปัญหา'])+1;
							break;
						
					}
				}
				
			}
			
			$list_land_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($land_problem_array['ไม่มีปัญหา']).' คน','value'=> $land_problem_array['ไม่มีปัญหา']);
			$list_land_problem[] = array('name'=>'มีปัญหา '.number_format($land_problem_array['มีปัญหา']).' คน','value'=> $land_problem_array['มีปัญหา']);
	
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_land_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function water_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A2');
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			
			$water_problem_array = array();
			$water_problem_array['ไม่มีปัญหา'] = 0;
			$water_problem_array['มีปัญหา'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_water_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($water_problem_array['ไม่มีปัญหา']).' คน','value'=> $water_problem_array['ไม่มีปัญหา']);
				$list_water_problem[] = array('name'=>'มีปัญหา '.number_format($water_problem_array['มีปัญหา']).' คน','value'=> $water_problem_array['มีปัญหา']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_water_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A2']) || empty($data['TAB5_A2'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['TAB5_A2'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '0':
							$water_problem_array['ไม่มีปัญหา']= intval($water_problem_array['ไม่มีปัญหา'])+1;
							break;
						case '2':
							$water_problem_array['มีปัญหา'] = intval($water_problem_array['มีปัญหา'])+1;
							break;
							
					}
				}
				
			}
			
			$list_water_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($water_problem_array['ไม่มีปัญหา']).' คน','value'=> $water_problem_array['ไม่มีปัญหา']);
			$list_water_problem[] = array('name'=>'มีปัญหา '.number_format($water_problem_array['มีปัญหา']).' คน','value'=> $water_problem_array['มีปัญหา']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_water_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function seed_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A3');
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
					
			
			$seed_problem_array = array();
			$seed_problem_array['ไม่มีปัญหา'] = 0;
			$seed_problem_array['ไม่มีเมล็ดพันธุ์'] = 0;
			$seed_problem_array['ไม่เพียงพอ'] = 0;
			$seed_problem_array['มีราคาแพง'] = 0;
			$seed_problem_array['คุณภาพไม่ได้มาตรฐาน'] = 0;
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_seed_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($seed_problem_array['ไม่มีปัญหา']).' คน','value'=> $seed_problem_array['ไม่มีปัญหา']);
				$list_seed_problem[] = array('name'=>'ไม่มีเมล็ดพันธุ์ '.number_format($seed_problem_array['ไม่มีเมล็ดพันธุ์']).' คน','value'=> $seed_problem_array['ไม่มีเมล็ดพันธุ์']);
				$list_seed_problem[] = array('name'=>'ไม่เพียงพอ '.number_format($seed_problem_array['ไม่เพียงพอ']).' คน','value'=> $seed_problem_array['ไม่เพียงพอ']);
				$list_seed_problem[] = array('name'=>'มีราคาแพง '.number_format($seed_problem_array['มีราคาแพง']).' คน','value'=> $seed_problem_array['มีราคาแพง']);
				$list_seed_problem[] = array('name'=>'คุณภาพไม่ได้มาตรฐาน '.number_format($seed_problem_array['คุณภาพไม่ได้มาตรฐาน']).' คน','value'=> $seed_problem_array['คุณภาพไม่ได้มาตรฐาน']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_seed_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A3']) || empty($data['TAB5_A3'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['TAB5_A3'] as $key=>$value)
				{
					
					switch ($value)
					{
						case '0':
							$seed_problem_array['ไม่มีปัญหา']= intval($seed_problem_array['ไม่มีปัญหา'])+1;
							break;
						case '2':
							$seed_problem_array['ไม่มีเมล็ดพันธุ์']= intval($seed_problem_array['ไม่มีเมล็ดพันธุ์'])+1;
							break;
						case '3':
							$seed_problem_array['ไม่เพียงพอ']= intval($seed_problem_array['ไม่เพียงพอ'])+1;
							break;
						case '4':
							$seed_problem_array['มีราคาแพง']= intval($seed_problem_array['มีราคาแพง'])+1;
							break;
						case '5':
							$seed_problem_array['คุณภาพไม่ได้มาตรฐาน']= intval($seed_problem_array['คุณภาพไม่ได้มาตรฐาน'])+1;
							break;
					}
				}
				
			}
			
			$list_seed_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($seed_problem_array['ไม่มีปัญหา']).' คน','value'=> $seed_problem_array['ไม่มีปัญหา']);
			$list_seed_problem[] = array('name'=>'ไม่มีเมล็ดพันธุ์ '.number_format($seed_problem_array['ไม่มีเมล็ดพันธุ์']).' คน','value'=> $seed_problem_array['ไม่มีเมล็ดพันธุ์']);
			$list_seed_problem[] = array('name'=>'ไม่เพียงพอ '.number_format($seed_problem_array['ไม่เพียงพอ']).' คน','value'=> $seed_problem_array['ไม่เพียงพอ']);
			$list_seed_problem[] = array('name'=>'มีราคาแพง '.number_format($seed_problem_array['มีราคาแพง']).' คน','value'=> $seed_problem_array['มีราคาแพง']);
			$list_seed_problem[] = array('name'=>'คุณภาพไม่ได้มาตรฐาน '.number_format($seed_problem_array['คุณภาพไม่ได้มาตรฐาน']).' คน','value'=> $seed_problem_array['คุณภาพไม่ได้มาตรฐาน']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_seed_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function fertilizer_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			
			
			$fertilizer_problem_array = array();
			$fertilizer_problem_array['ไม่มีปัญหา'] = 0;
			$fertilizer_problem_array['ราคาแพง'] = 0;
			$fertilizer_problem_array['ปลอมปน'] = 0;
			$fertilizer_problem_array['อื่นๆ'] = 0;
			
			$total = 0;
		
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_fertilizer_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($fertilizer_problem_array['ไม่มีปัญหา']).' คน','value'=> $fertilizer_problem_array['ไม่มีปัญหา']);
				$list_fertilizer_problem[] = array('name'=>'ราคาแพง '.number_format($fertilizer_problem_array['ราคาแพง']).' คน','value'=> $fertilizer_problem_array['ราคาแพง']);
				$list_fertilizer_problem[] = array('name'=>'ปลอมปน '.number_format($fertilizer_problem_array['ปลอมปน']).' คน','value'=> $fertilizer_problem_array['ปลอมปน']);
				$list_fertilizer_problem[] = array('name'=>'อื่นๆ '.number_format($fertilizer_problem_array['อื่นๆ']).' คน','value'=> $fertilizer_problem_array['อื่นๆ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_fertilizer_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4']) ) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '0':
							if($value == 0){
								$fertilizer_problem_array['ไม่มีปัญหา']= intval($fertilizer_problem_array['ไม่มีปัญหา'])+1;
								break;
							}							
						case '1':
							$fertilizer_problem_array['ราคาแพง']= intval($fertilizer_problem_array['ราคาแพง'])+1;
							break;
						case '2':
							$fertilizer_problem_array['ปลอมปน']= intval($fertilizer_problem_array['ปลอมปน'])+1;
							break;
						case '3':
							$fertilizer_problem_array['อื่นๆ']= intval($fertilizer_problem_array['อื่นๆ'])+1;
							break;
					}
				}
				
			}
			
			$list_fertilizer_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($fertilizer_problem_array['ไม่มีปัญหา']).' คน','value'=> $fertilizer_problem_array['ไม่มีปัญหา']);
			$list_fertilizer_problem[] = array('name'=>'ราคาแพง '.number_format($fertilizer_problem_array['ราคาแพง']).' คน','value'=> $fertilizer_problem_array['ราคาแพง']);
			$list_fertilizer_problem[] = array('name'=>'ปลอมปน '.number_format($fertilizer_problem_array['ปลอมปน']).' คน','value'=> $fertilizer_problem_array['ปลอมปน']);
			$list_fertilizer_problem[] = array('name'=>'อื่นๆ '.number_format($fertilizer_problem_array['อื่นๆ']).' คน','value'=> $fertilizer_problem_array['อื่นๆ']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_fertilizer_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function technology_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A5');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			
			
			
			$technology_problem_array = array();
			$technology_problem_array['ไม่มีปัญหา'] = 0;
			$technology_problem_array['มีน้อย'] = 0;
			$technology_problem_array['ขาดแหล่งความรู้'] = 0;
			
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_technology_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($technology_problem_array['ไม่มีปัญหา']).' คน','value'=> $technology_problem_array['ไม่มีปัญหา']);
				$list_technology_problem[] = array('name'=>'มีน้อย '.number_format($technology_problem_array['มีน้อย']).' คน','value'=> $technology_problem_array['มีน้อย']);
				$list_technology_problem[] = array('name'=>'ขาดแหล่งความรู้ '.number_format($technology_problem_array['ขาดแหล่งความรู้']).' คน','value'=> $technology_problem_array['ขาดแหล่งความรู้']);
				
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_technology_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A5']) || empty($data['TAB5_A5'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A5']) && is_array($data['TAB5_A5']) && sizeof($data['TAB5_A5'] ) > 0)
				foreach($data['TAB5_A5'] as $key=>$value)
				{
					switch ($key)
					{
						case '0':
							if($value == 0){
								$technology_problem_array['ไม่มีปัญหา']= intval($technology_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '1':
							$technology_problem_array['มีน้อย']= intval($technology_problem_array['มีน้อย'])+1;
							break;
						case '2':
							$technology_problem_array['ขาดแหล่งความรู้']= intval($technology_problem_array['ขาดแหล่งความรู้'])+1;
							break;
					}
				}
				
			}
			
			$list_technology_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($technology_problem_array['ไม่มีปัญหา']).' คน','value'=> $technology_problem_array['ไม่มีปัญหา']);
			$list_technology_problem[] = array('name'=>'มีน้อย '.number_format($technology_problem_array['มีน้อย']).' คน','value'=> $technology_problem_array['มีน้อย']);
			$list_technology_problem[] = array('name'=>'ขาดแหล่งความรู้ '.number_format($technology_problem_array['ขาดแหล่งความรู้']).' คน','value'=> $technology_problem_array['ขาดแหล่งความรู้']);
		
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_technology_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function trends_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A6');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$trends_problem_array = array();
			$trends_problem_array['ไม่มีปัญหา'] = 0;
			$trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ'] = 0;
			$trends_problem_array['เข้าใจปานกลาง'] = 0;
			$trends_problem_array['ไม่สนใจติดตาม'] = 0;
			$trends_problem_array['อื่นๆ'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_trends_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($trends_problem_array['ไม่มีปัญหา']).' คน','value'=> $trends_problem_array['ไม่มีปัญหา']);
				$list_trends_problem[] = array('name'=>'ทราบเล็กน้อย-ไม่เข้าใจ '.number_format($trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ']).' คน','value'=> $trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ']);
				$list_trends_problem[] = array('name'=>'เข้าใจปานกลาง '.number_format($trends_problem_array['เข้าใจปานกลาง']).' คน','value'=> $trends_problem_array['เข้าใจปานกลาง']);
				$list_trends_problem[] = array('name'=>'ไม่สนใจติดตาม '.number_format($trends_problem_array['ไม่สนใจติดตาม']).' คน','value'=> $trends_problem_array['ไม่สนใจติดตาม']);
				$list_trends_problem[] = array('name'=>'อื่นๆ '.number_format($trends_problem_array['อื่นๆ']).' คน','value'=> $trends_problem_array['อื่นๆ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_trends_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A6']) || empty($data['TAB5_A6'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['TAB5_A6'] as $key=>$value)
				{
					switch ($key)
					{
						case '0':
							if($value == 0){
								$trends_problem_array['ไม่มีปัญหา']= intval($trends_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '1':
							$trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ']= intval($trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ'])+1;
							break;
						case '2':
							$trends_problem_array['เข้าใจปานกลาง']= intval($trends_problem_array['เข้าใจปานกลาง'])+1;
							break;
						case '3':
							$trends_problem_array['ไม่สนใจติดตาม']= intval($trends_problem_array['ไม่สนใจติดตาม'])+1;
							break;
						case '4':
							$trends_problem_array['อื่นๆ']= intval($trends_problem_array['อื่นๆ'])+1;
							break;
					}
				}
				
			}
			
			$list_trends_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($trends_problem_array['ไม่มีปัญหา']).' คน','value'=> $trends_problem_array['ไม่มีปัญหา']);
			$list_trends_problem[] = array('name'=>'ทราบเล็กน้อย-ไม่เข้าใจ '.number_format($trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ']).' คน','value'=> $trends_problem_array['ทราบเล็กน้อย-ไม่เข้าใจ']);
			$list_trends_problem[] = array('name'=>'เข้าใจปานกลาง '.number_format($trends_problem_array['เข้าใจปานกลาง']).' คน','value'=> $trends_problem_array['เข้าใจปานกลาง']);
			$list_trends_problem[] = array('name'=>'ไม่สนใจติดตาม '.number_format($trends_problem_array['ไม่สนใจติดตาม']).' คน','value'=> $trends_problem_array['ไม่สนใจติดตาม']);
			$list_trends_problem[] = array('name'=>'อื่นๆ '.number_format($trends_problem_array['อื่นๆ']).' คน','value'=> $trends_problem_array['อื่นๆ']);
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_trends_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function maket_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$maket_problem_array = array();
			$maket_problem_array['ไม่มีปัญหา'] = 0;
			$maket_problem_array['ไม่มีตลาดแน่นอน'] = 0;
			$maket_problem_array['ไม่พอใจราคาขาย'] = 0;
			$maket_problem_array['อื่นๆ'] = 0;
			
			$total = 0;
			
					
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_maket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($maket_problem_array['ไม่มีปัญหา']).' คน','value'=> $maket_problem_array['ไม่มีปัญหา']);
				$list_maket_problem[] = array('name'=>'ไม่มีตลาดแน่นอน '.number_format($maket_problem_array['ไม่มีตลาดแน่นอน']).' คน','value'=> $maket_problem_array['ไม่มีตลาดแน่นอน']);
				$list_maket_problem[] = array('name'=>'ไม่พอใจราคาขาย '.number_format($maket_problem_array['ไม่พอใจราคาขาย']).' คน','value'=> $maket_problem_array['ไม่พอใจราคาขาย']);
				$list_maket_problem[] = array('name'=>'อื่นๆ '.number_format($maket_problem_array['อื่นๆ']).' คน','value'=> $maket_problem_array['อื่นๆ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_maket_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '4':
							if($value == 0){
								$maket_problem_array['ไม่มีปัญหา']= intval($maket_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '5':
							$maket_problem_array['ไม่มีตลาดแน่นอน']= intval($maket_problem_array['ไม่มีตลาดแน่นอน'])+1;
							break;
						case '6':
							$maket_problem_array['ไม่พอใจราคาขาย']= intval($maket_problem_array['ไม่พอใจราคาขาย'])+1;
							break;
						case '7':
							$maket_problem_array['อื่นๆ']= intval($maket_problem_array['อื่นๆ'])+1;
							break;
					}
				}
				
			}
			$list_maket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($maket_problem_array['ไม่มีปัญหา']).' คน','value'=> $maket_problem_array['ไม่มีปัญหา']);
			$list_maket_problem[] = array('name'=>'ไม่มีตลาดแน่นอน '.number_format($maket_problem_array['ไม่มีตลาดแน่นอน']).' คน','value'=> $maket_problem_array['ไม่มีตลาดแน่นอน']);
			$list_maket_problem[] = array('name'=>'ไม่พอใจราคาขาย '.number_format($maket_problem_array['ไม่พอใจราคาขาย']).' คน','value'=> $maket_problem_array['ไม่พอใจราคาขาย']);
			$list_maket_problem[] = array('name'=>'อื่นๆ '.number_format($maket_problem_array['อื่นๆ']).' คน','value'=> $maket_problem_array['อื่นๆ']);

			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_maket_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function storehouse_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$storehouse_problem_array = array();
			$storehouse_problem_array['ไม่มีปัญหา'] = 0;
			$storehouse_problem_array['มี'] = 0;
			$storehouse_problem_array['มีไม่พอ'] = 0;
			$storehouse_problem_array['ไม่มี'] = 0;
			$storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ'] = 0;
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_storehouse_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($storehouse_problem_array['ไม่มีปัญหา']).' คน','value'=> $storehouse_problem_array['ไม่มีปัญหา']);
				$list_storehouse_problem[] = array('name'=>'มี '.number_format($storehouse_problem_array['มี']).' คน','value'=> $storehouse_problem_array['มี']);
				$list_storehouse_problem[] = array('name'=>'มีไม่พอ '.number_format($storehouse_problem_array['มีไม่พอ']).' คน','value'=> $storehouse_problem_array['มีไม่พอ']);
				$list_storehouse_problem[] = array('name'=>'ไม่มี '.number_format($storehouse_problem_array['ไม่มี']).' คน','value'=> $storehouse_problem_array['ไม่มี']);
				$list_storehouse_problem[] = array('name'=>'ไม่จำเป็นต้องมีที่เก็บ '.number_format($storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ']).' คน','value'=> $storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_storehouse_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '8':
							if($value == 0){
								$storehouse_problem_array['ไม่มีปัญหา']= intval($storehouse_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '9':
							$storehouse_problem_array['มี']= intval($storehouse_problem_array['มี'])+1;
							break;
						case '10':
							$storehouse_problem_array['มีไม่พอ']= intval($storehouse_problem_array['มีไม่พอ'])+1;
							break;
						case '11':
							$storehouse_problem_array['ไม่มี']= intval($storehouse_problem_array['ไม่มี'])+1;
							break;
						case '12':
							$storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ']= intval($storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ'])+1;
							break;
					}
				}
				
			}
			$list_storehouse_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($storehouse_problem_array['ไม่มีปัญหา']).' คน','value'=> $storehouse_problem_array['ไม่มีปัญหา']);
			$list_storehouse_problem[] = array('name'=>'มี '.number_format($storehouse_problem_array['มี']).' คน','value'=> $storehouse_problem_array['มี']);
			$list_storehouse_problem[] = array('name'=>'มีไม่พอ '.number_format($storehouse_problem_array['มีไม่พอ']).' คน','value'=> $storehouse_problem_array['มีไม่พอ']);
			$list_storehouse_problem[] = array('name'=>'ไม่มี '.number_format($storehouse_problem_array['ไม่มี']).' คน','value'=> $storehouse_problem_array['ไม่มี']);
			$list_storehouse_problem[] = array('name'=>'ไม่จำเป็นต้องมีที่เก็บ '.number_format($storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ']).' คน','value'=> $storehouse_problem_array['ไม่จำเป็นต้องมีที่เก็บ']);
			
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_storehouse_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function datamaket_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
		
			$datamaket_problem_array = array();
			$datamaket_problem_array['ไม่มีปัญหา'] = 0;
			$datamaket_problem_array['ไม่ทราบ'] = 0;			
			$datamaket_problem_array['ทราบจากแหล่งอื่น'] = 0;
			
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_datamaket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($datamaket_problem_array['ไม่มีปัญหา']).' คน','value'=> $datamaket_problem_array['ไม่มีปัญหา']);
				$list_datamaket_problem[] = array('name'=>'ไม่ทราบ '.number_format($datamaket_problem_array['ไม่ทราบ']).' คน','value'=> $datamaket_problem_array['ไม่ทราบ']);
				$list_datamaket_problem[] = array('name'=>'ทราบจากแหล่งอื่น '.number_format($datamaket_problem_array['ทราบจากแหล่งอื่น']).' คน','value'=> $datamaket_problem_array['ทราบจากแหล่งอื่น']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_datamaket_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']))
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '13':
							if($value == 0){
								$datamaket_problem_array['ไม่มีปัญหา']= intval($datamaket_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '14':
							$datamaket_problem_array['ไม่ทราบ']= intval($datamaket_problem_array['ไม่ทราบ'])+1;
							break;
						case '15':
							$datamaket_problem_array['ทราบจากแหล่งอื่น']= intval($datamaket_problem_array['ทราบจากแหล่งอื่น'])+1;
							break;
					}
				}
				
			}
			$list_datamaket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($datamaket_problem_array['ไม่มีปัญหา']).' คน','value'=> $datamaket_problem_array['ไม่มีปัญหา']);
			$list_datamaket_problem[] = array('name'=>'ไม่ทราบ '.number_format($datamaket_problem_array['ไม่ทราบ']).' คน','value'=> $datamaket_problem_array['ไม่ทราบ']);
			$list_datamaket_problem[] = array('name'=>'ทราบจากแหล่งอื่น '.number_format($datamaket_problem_array['ทราบจากแหล่งอื่น']).' คน','value'=> $datamaket_problem_array['ทราบจากแหล่งอื่น']);

			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_datamaket_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function wantmaket_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$wantmaket_problem_array = array();
			$wantmaket_problem_array['ไม่มีปัญหา'] = 0;
			$wantmaket_problem_array['ต้องการมี'] = 0;
			$wantmaket_problem_array['ไม่ต้องการมี'] = 0;
			
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_wantmaket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($wantmaket_problem_array['ไม่มีปัญหา']).' คน','value'=> $wantmaket_problem_array['ไม่มีปัญหา']);
				$list_wantmaket_problem[] = array('name'=>'ต้องการมี '.number_format($wantmaket_problem_array['ต้องการมี']).' คน','value'=> $wantmaket_problem_array['ต้องการมี']);
				$list_wantmaket_problem[] = array('name'=>'ไม่ต้องการมี '.number_format($wantmaket_problem_array['ไม่ต้องการมี']).' คน','value'=> $wantmaket_problem_array['ไม่ต้องการมี']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_wantmaket_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '16':
							if($value == 0){
								$wantmaket_problem_array['ไม่มีปัญหา']= intval($wantmaket_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '17':
							$wantmaket_problem_array['ต้องการมี']= intval($wantmaket_problem_array['ต้องการมี'])+1;
							break;
						case '18':
							$wantmaket_problem_array['ไม่ต้องการมี']= intval($wantmaket_problem_array['ไม่ต้องการมี'])+1;
							break;
					}
				}
				
			}
			$list_wantmaket_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($wantmaket_problem_array['ไม่มีปัญหา']).' คน','value'=> $wantmaket_problem_array['ไม่มีปัญหา']);
			$list_wantmaket_problem[] = array('name'=>'ต้องการมี '.number_format($wantmaket_problem_array['ต้องการมี']).' คน','value'=> $wantmaket_problem_array['ต้องการมี']);
			$list_wantmaket_problem[] = array('name'=>'ไม่ต้องการมี '.number_format($wantmaket_problem_array['ไม่ต้องการมี']).' คน','value'=> $wantmaket_problem_array['ไม่ต้องการมี']);

			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_wantmaket_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function price_problem()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$price_problem_array = array();
			$price_problem_array['ไม่มีปัญหา'] = 0;
			$price_problem_array['ราคาต่ำ'] = 0;
			$price_problem_array['เหมาะสม'] = 0;
			
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_price_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($price_problem_array['ไม่มีปัญหา']).' คน','value'=> $price_problem_array['ไม่มีปัญหา']);
				$list_price_problem[] = array('name'=>'ราคาต่ำ '.number_format($price_problem_array['ราคาต่ำ']).' คน','value'=> $price_problem_array['ราคาต่ำ']);
				$list_price_problem[] = array('name'=>'เหมาะสม '.number_format($price_problem_array['เหมาะสม']).' คน','value'=> $price_problem_array['เหมาะสม']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_price_problem;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '19':
							if($value == 0){
								$price_problem_array['ไม่มีปัญหา']= intval($price_problem_array['ไม่มีปัญหา'])+1;
								break;
							}
						case '20':
							$price_problem_array['ราคาต่ำ']= intval($price_problem_array['ราคาต่ำ'])+1;
							break;
						case '21':
							$price_problem_array['เหมาะสม']= intval($price_problem_array['เหมาะสม'])+1;
							break;
					}
				}
				
			}
			$list_price_problem[] = array('name'=>'ไม่มีปัญหา '.number_format($price_problem_array['ไม่มีปัญหา']).' คน','value'=> $price_problem_array['ไม่มีปัญหา']);
			$list_price_problem[] = array('name'=>'ราคาต่ำ '.number_format($price_problem_array['ราคาต่ำ']).' คน','value'=> $price_problem_array['ราคาต่ำ']);
			$list_price_problem[] = array('name'=>'เหมาะสม '.number_format($price_problem_array['เหมาะสม']).' คน','value'=> $price_problem_array['เหมาะสม']);

			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_price_problem;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function data_receive()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_A4');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
			$data_receive_array = array();
			$data_receive_array['เกษตรตำบล'] = 0;
			$data_receive_array['กำนันผู้ใหญ่บ้าน'] = 0;
			$data_receive_array['วิทยุชุมชน'] = 0;
			$data_receive_array['องค์กรบริหารส่วนตำบล'] = 0;
			$data_receive_array['สถานีวิทยุ'] = 0;
			$data_receive_array['โทรทัศน์'] = 0;
			$data_receive_array['สหกรณ์'] = 0;
			$data_receive_array['อื่นๆ'] = 0;
			
			
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_data_receive[] = array('name'=>'เกษตรตำบล '.number_format($data_receive_array['เกษตรตำบล']).' คน','value'=> $data_receive_array['เกษตรตำบล']);
				$list_data_receive[] = array('name'=>'กำนันผู้ใหญ่บ้าน '.number_format($data_receive_array['กำนันผู้ใหญ่บ้าน']).' คน','value'=> $data_receive_array['กำนันผู้ใหญ่บ้าน']);
				$list_data_receive[] = array('name'=>'วิทยุชุมชน '.number_format($data_receive_array['วิทยุชุมชน']).' คน','value'=> $data_receive_array['วิทยุชุมชน']);
				$list_data_receive[] = array('name'=>'องค์กรบริหารส่วนตำบล '.number_format($data_receive_array['องค์กรบริหารส่วนตำบล']).' คน','value'=> $data_receive_array['องค์กรบริหารส่วนตำบล']);
				$list_data_receive[] = array('name'=>'สถานีวิทยุ '.number_format($data_receive_array['สถานีวิทยุ']).' คน','value'=> $data_receive_array['สถานีวิทยุ']);
				$list_data_receive[] = array('name'=>'โทรทัศน์ '.number_format($data_receive_array['โทรทัศน์']).' คน','value'=> $data_receive_array['โทรทัศน์']);
				$list_data_receive[] = array('name'=>'สหกรณ์ '.number_format($data_receive_array['สหกรณ์']).' คน','value'=> $data_receive_array['สหกรณ์']);
				$list_data_receive[] = array('name'=>'อื่นๆ '.number_format($data_receive_array['อื่นๆ']).' คน','value'=> $data_receive_array['อื่นๆ']);
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_data_receive;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			
			foreach ($data_report as $data)
			{
				if (!isset($data['TAB5_A4']) || empty($data['TAB5_A4'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				if(!empty($data['TAB5_A4']) && is_array($data['TAB5_A4']) && sizeof($data['TAB5_A4'] ) > 0)
				foreach($data['TAB5_A4'] as $key=>$value)
				{
					switch ($key)
					{
						case '0':						
							$data_receive_array['เกษตรตำบล']= intval($data_receive_array['เกษตรตำบล'])+1;
							break;						
						case '1':
							$data_receive_array['กำนันผู้ใหญ่บ้าน']= intval($data_receive_array['กำนันผู้ใหญ่บ้าน'])+1;
							break;
						case '2':
							$data_receive_array['วิทยุชุมชน']= intval($data_receive_array['วิทยุชุมชน'])+1;
							break;
						case '3':
							$data_receive_array['องค์กรบริหารส่วนตำบล']= intval($data_receive_array['องค์กรบริหารส่วนตำบล'])+1;
							break;
						case '4':
							$data_receive_array['สถานีวิทยุ']= intval($data_receive_array['สถานีวิทยุ'])+1;
							break;
						case '5':
							$data_receive_array['โทรทัศน์']= intval($data_receive_array['โทรทัศน์'])+1;
							break;
						case '6':
							$data_receive_array['สหกรณ์']= intval($data_receive_array['สหกรณ์'])+1;
							break;
						case '7':
							$data_receive_array['อื่นๆ']= intval($data_receive_array['อื่นๆ'])+1;
							break;
					}
				}
				
			}
			
			$list_data_receive[] = array('name'=>'เกษตรตำบล '.number_format($data_receive_array['เกษตรตำบล']).' คน','value'=> $data_receive_array['เกษตรตำบล']);
			$list_data_receive[] = array('name'=>'กำนันผู้ใหญ่บ้าน '.number_format($data_receive_array['กำนันผู้ใหญ่บ้าน']).' คน','value'=> $data_receive_array['กำนันผู้ใหญ่บ้าน']);
			$list_data_receive[] = array('name'=>'วิทยุชุมชน '.number_format($data_receive_array['วิทยุชุมชน']).' คน','value'=> $data_receive_array['วิทยุชุมชน']);
			$list_data_receive[] = array('name'=>'องค์กรบริหารส่วนตำบล '.number_format($data_receive_array['องค์กรบริหารส่วนตำบล']).' คน','value'=> $data_receive_array['องค์กรบริหารส่วนตำบล']);
			$list_data_receive[] = array('name'=>'สถานีวิทยุ '.number_format($data_receive_array['สถานีวิทยุ']).' คน','value'=> $data_receive_array['สถานีวิทยุ']);
			$list_data_receive[] = array('name'=>'โทรทัศน์ '.number_format($data_receive_array['โทรทัศน์']).' คน','value'=> $data_receive_array['โทรทัศน์']);
			$list_data_receive[] = array('name'=>'สหกรณ์ '.number_format($data_receive_array['สหกรณ์']).' คน','value'=> $data_receive_array['สหกรณ์']);
			$list_data_receive[] = array('name'=>'อื่นๆ '.number_format($data_receive_array['อื่นๆ']).' คน','value'=> $data_receive_array['อื่นๆ']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_data_receive;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function count_debt()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$this->db->select('TAB5_DEBT_NORMAL_COOP,TAB5_DEBT_NORMAL_BAAC,TAB5_DEBT_NORMAL_B_OTHERS,TAB5_DEBT_NORMAL_HOUSING,TAB5_DEBT_NORMAL_MIDDLE_MAN,TAB5_DEBT_NORMAL_THE_NEIG,
TAB5_DEBT_NORMAL_OTHERS,TAB5_DEBT_ABNORMAL_COOP,TAB5_DEBT_ABNORMAL_BAAC,TAB5_DEBT_ABNORMAL_B_OTHERS,TAB5_DEBT_ABNORMAL_HOUSING
,TAB5_DEBT_ABNORMAL_MIDDLE_MAN,TAB5_DEBT_ABNORMAL_THE_NEIG,TAB5_DEBT_ABNORMAL_OTHERS');
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$data_report = getListDataSurvey();
			
		
			$data_result['TAB5_DEBT_NORMAL_COOP'] = 0;
			$data_result['TAB5_DEBT_NORMAL_BAAC'] = 0;
			$data_result['TAB5_DEBT_NORMAL_B_OTHERS'] = 0;
			$data_result['TAB5_DEBT_NORMAL_HOUSING'] = 0;
			$data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN'] = 0;
			$data_result['TAB5_DEBT_NORMAL_THE_NEIG'] = 0;
			$data_result['TAB5_DEBT_NORMAL_OTHERS'] = 0;
			
			$data_result['TAB5_DEBT_ABNORMAL_COOP'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_BAAC'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_B_OTHERS'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_HOUSING'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_THE_NEIG'] = 0;
			$data_result['TAB5_DEBT_ABNORMAL_OTHERS'] = 0;
			$total = 0;
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_debt_normal[] = array('name'=>'สหกรณ์/กลุ่มเกษตรกร '.number_format($data_result['TAB5_DEBT_NORMAL_COOP']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_COOP']);
				$list_debt_normal[] = array('name'=>'ธกส. '.number_format($data_result['TAB5_DEBT_NORMAL_BAAC']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_BAAC']);
				$list_debt_normal[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($data_result['TAB5_DEBT_NORMAL_B_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_B_OTHERS']);
				$list_debt_normal[] = array('name'=>'ธนาคารอื่น '.number_format($data_result['TAB5_DEBT_NORMAL_HOUSING']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_HOUSING']);
				$list_debt_normal[] = array('name'=>'กองทุนหมู่บ้าน '.number_format($data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']);
				$list_debt_normal[] = array('name'=>'ญาติ/เพื่อนบ้าน '.number_format($data_result['TAB5_DEBT_NORMAL_THE_NEIG']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_THE_NEIG']);
				$list_debt_normal[] = array('name'=>'อื่นๆ '.number_format($data_result['TAB5_DEBT_NORMAL_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_OTHERS']);
				
				$list_debt_abnormal[] = array('name'=>'สหกรณ์/กลุ่มเกษตรกร '.number_format($data_result['TAB5_DEBT_ABNORMAL_COOP']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_COOP']);
				$list_debt_abnormal[] = array('name'=>'ธกส. '.number_format($data_result['TAB5_DEBT_ABNORMAL_BAAC']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_BAAC']);
				$list_debt_abnormal[] = array('name'=>'ธนาคารอื่น '.number_format($data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']);
				$list_debt_abnormal[] = array('name'=>'กองทุนหมู่บ้าน '.number_format($data_result['TAB5_DEBT_ABNORMAL_HOUSING']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_HOUSING']);
				$list_debt_abnormal[] = array('name'=>'พ่อค้าคนกลาง/นายทุน '.number_format($data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']);
				$list_debt_abnormal[] = array('name'=>'ญาติ/เพื่อนบ้าน '.number_format($data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']);
				$list_debt_abnormal[] = array('name'=>'อื่นๆ '.number_format($data_result['TAB5_DEBT_ABNORMAL_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_OTHERS']);
				
				
				$list_debt_data['หนี้ปกติ'] = $list_debt_normal;
				$list_debt_data['หนี้ค้าง/ฟ้องดำเนินคดี'] = $list_debt_abnormal;
				
				$total_debtnormal = $data_result['TAB5_DEBT_NORMAL_COOP']+$data_result['TAB5_DEBT_NORMAL_BAAC']+$data_result['TAB5_DEBT_NORMAL_B_OTHERS']+$data_result['TAB5_DEBT_NORMAL_HOUSING']+$data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']+$data_result['TAB5_DEBT_NORMAL_THE_NEIG']+$data_result['TAB5_DEBT_NORMAL_OTHERS'];
				$total_debtabnormal = $data_result['TAB5_DEBT_ABNORMAL_COOP']+$data_result['TAB5_DEBT_ABNORMAL_BAAC']+$data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']+$data_result['TAB5_DEBT_ABNORMAL_HOUSING']+$data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']+$data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']+$data_result['TAB5_DEBT_ABNORMAL_OTHERS'];
				
				$list_total[] =  array('name'=>'หนี้ปกติ '.number_format($total_debtnormal).' คน','value'=> $total_debtnormal);
				$list_total[] =  array('name'=>'หนี้ค้าง/ฟ้องดำเนินคดี '.number_format($total_debtabnormal).' คน','value'=> $total_debtabnormal);
				
				$list_debt[] = 'สหกรณ์/กลุ่มเกษตรกร';
				$list_debt[] = 'ธกส.';
				$list_debt[] ='ธนาคารอื่น';
				$list_debt[] = 'กองทุนหมู่บ้าน';
				$list_debt[] ='พ่อค้าคนกลาง/นายทุน';
				$list_debt[] ='ญาติ/เพื่อนบ้าน';
				$list_debt[] = 'อื่นๆ';
				
				$output = array();
				$output['total'] = $total;
				$output['total_debt'] = $list_total;
				$output['list_comment'] = $list_debt;
				$output['list_data'] = $list_debt_data;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
				
			}
			foreach ($data_report as $datas)
			{
				$check_data = false;
				foreach ($datas as $k=>$v)
				{
					
					if(isset($data_result[$k])&&!empty($v)&& strtoupper($v) != "N")
					{
						$data_result[$k] += 1;	
						if(!empty($v) && $v!= '' && $v!='0')
						{
							$check_data = true;
						}
					}
				}
				if($check_data)
				{
					$total = $total+1;
				}
				
				
			}
			
			$list_debt_normal[] = array('name'=>'สหกรณ์/กลุ่มเกษตรกร '.number_format($data_result['TAB5_DEBT_NORMAL_COOP']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_COOP']);
			$list_debt_normal[] = array('name'=>'ธกส. '.number_format($data_result['TAB5_DEBT_NORMAL_BAAC']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_BAAC']);
			$list_debt_normal[] = array('name'=>'เป็นทางเลือกที่ดี '.number_format($data_result['TAB5_DEBT_NORMAL_B_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_B_OTHERS']);
			$list_debt_normal[] = array('name'=>'ธนาคารอื่น '.number_format($data_result['TAB5_DEBT_NORMAL_HOUSING']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_HOUSING']);
			$list_debt_normal[] = array('name'=>'กองทุนหมู่บ้าน '.number_format($data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']);
			$list_debt_normal[] = array('name'=>'ญาติ/เพื่อนบ้าน '.number_format($data_result['TAB5_DEBT_NORMAL_THE_NEIG']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_THE_NEIG']);
			$list_debt_normal[] = array('name'=>'อื่นๆ '.number_format($data_result['TAB5_DEBT_NORMAL_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_NORMAL_OTHERS']);
			
			$list_debt_abnormal[] = array('name'=>'สหกรณ์/กลุ่มเกษตรกร '.number_format($data_result['TAB5_DEBT_ABNORMAL_COOP']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_COOP']);
			$list_debt_abnormal[] = array('name'=>'ธกส. '.number_format($data_result['TAB5_DEBT_ABNORMAL_BAAC']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_BAAC']);
			$list_debt_abnormal[] = array('name'=>'ธนาคารอื่น '.number_format($data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']);
			$list_debt_abnormal[] = array('name'=>'กองทุนหมู่บ้าน '.number_format($data_result['TAB5_DEBT_ABNORMAL_HOUSING']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_HOUSING']);
			$list_debt_abnormal[] = array('name'=>'พ่อค้าคนกลาง/นายทุน '.number_format($data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']);
			$list_debt_abnormal[] = array('name'=>'ญาติ/เพื่อนบ้าน '.number_format($data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']);
			$list_debt_abnormal[] = array('name'=>'อื่นๆ '.number_format($data_result['TAB5_DEBT_ABNORMAL_OTHERS']).' คน','value'=> $data_result['TAB5_DEBT_ABNORMAL_OTHERS']);

			
			$list_debt_data['หนี้ปกติ'] = $list_debt_normal;
			$list_debt_data['หนี้ค้าง/ฟ้องดำเนินคดี'] = $list_debt_abnormal;
			
			$total_debtnormal = $data_result['TAB5_DEBT_NORMAL_COOP']+$data_result['TAB5_DEBT_NORMAL_BAAC']+$data_result['TAB5_DEBT_NORMAL_B_OTHERS']+$data_result['TAB5_DEBT_NORMAL_HOUSING']+$data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN']+$data_result['TAB5_DEBT_NORMAL_THE_NEIG']+$data_result['TAB5_DEBT_NORMAL_OTHERS'];
			$total_debtabnormal = $data_result['TAB5_DEBT_ABNORMAL_COOP']+$data_result['TAB5_DEBT_ABNORMAL_BAAC']+$data_result['TAB5_DEBT_ABNORMAL_B_OTHERS']+$data_result['TAB5_DEBT_ABNORMAL_HOUSING']+$data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN']+$data_result['TAB5_DEBT_ABNORMAL_THE_NEIG']+$data_result['TAB5_DEBT_ABNORMAL_OTHERS'];
			
			$list_total[] =  array('name'=>'หนี้ปกติ '.number_format($total_debtnormal).' คน','value'=> $total_debtnormal);
			$list_total[] =  array('name'=>'หนี้ค้าง/ฟ้องดำเนินคดี '.number_format($total_debtabnormal).' คน','value'=> $total_debtabnormal);
			
			$list_debt[] = 'สหกรณ์/กลุ่มเกษตรกร';
			$list_debt[] = 'ธกส.';
			$list_debt[] ='ธนาคารอื่น';
			$list_debt[] = 'กองทุนหมู่บ้าน';
			$list_debt[] ='พ่อค้าคนกลาง/นายทุน';
			$list_debt[] ='ญาติ/เพื่อนบ้าน';
			$list_debt[] = 'อื่นๆ';
			
			$output = array();
			$output['total'] = $total;
			$output['total_debt'] = $list_total;			
			$output['list_comment'] = $list_debt;
			$output['list_data'] = $list_debt_data;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function count_fertilizer_report3()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
			$this->db->select('CHM1_46_0_0,CHM2_15_15_15,CHM3_16_20_0,CHM4_OTHER,CHM2_INTR,CHM1_WATER,CHM2_C_C_C,CHM1_SEED,CHM2_SEED');
			$data_report = getListDataSurvey();
// 						echo "<pre>";
// 						print_r($data_report);
// 						echo "</pre>";
			$data_result = array();
			$total = 0;
			$data_result['CHM1_46_0_0']['1'] = 0;
			$data_result['CHM2_15_15_15']['1'] = 0;
			$data_result['CHM3_16_20_0']['1'] = 0;
			$data_result['CHM4_OTHER']['1'] = 0;
			$data_result['CHM2_INTR']['1'] = 0;
			$data_result['CHM1_WATER']['1'] = 0;
			$data_result['CHM2_C_C_C']['1'] = 0;
			$data_result['CHM1_SEED']['1'] = 0;
			$data_result['CHM2_SEED']['1'] = 0;
			
			$data_result['CHM1_46_0_0']['2'] = 0;
			$data_result['CHM2_15_15_15']['2'] = 0;
			$data_result['CHM3_16_20_0']['2'] = 0;
			$data_result['CHM4_OTHER']['2'] = 0;
			$data_result['CHM2_INTR']['2'] = 0;
			$data_result['CHM1_WATER']['2'] = 0;
			$data_result['CHM2_C_C_C']['2'] = 0;
			$data_result['CHM1_SEED']['2'] = 0;
			$data_result['CHM2_SEED']['2'] = 0;
			
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 46 - 0 - 0 '.number_format($data_result['CHM1_46_0_0']['1']).' กิโลกรัม','value'=> $data_result['CHM1_46_0_0']['1']);
				$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 15 - 15 - 15 '.number_format($data_result['CHM2_15_15_15']['1']).' กิโลกรัม','value'=> $data_result['CHM2_15_15_15']['1']);
				$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 16 - 20 - 0 '.number_format($data_result['CHM3_16_20_0']['1']).' กิโลกรัม','value'=> $data_result['CHM3_16_20_0']['1']);
				$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีอื่นๆ '.number_format($data_result['CHM4_OTHER']['1']).' กิโลกรัม','value'=> $data_result['CHM4_OTHER']['1']);
				$list_fertilizer_type1[] = array('name'=>'ปุ๋ยอินทรีย์ '.number_format($data_result['CHM2_INTR']['1']).' กิโลกรัม','value'=> $data_result['CHM2_INTR']['1']);
				$list_fertilizer_type1[] = array('name'=>'ยาปราบศัตรูพืชชนิดน้ำ '.number_format($data_result['CHM1_WATER']['1']).' กิโลกรัม','value'=> $data_result['CHM1_WATER']['1']);
				$list_fertilizer_type1[] = array('name'=>'ยาปราบศัตรูพืชชนิดเม็ด/ผง '.number_format($data_result['CHM2_C_C_C']['1']).' กิโลกรัม','value'=> $data_result['CHM2_C_C_C']['1']);
				$list_fertilizer_type1[] = array('name'=>'เมล็ดพันธุ์ '.number_format($data_result['CHM1_SEED']['1']).' กิโลกรัม','value'=> $data_result['CHM1_SEED']['1']);
				
				
				
				$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 46 - 0 - 0 '.number_format($data_result['CHM1_46_0_0']['2']).' กิโลกรัม','value'=> $data_result['CHM1_46_0_0']['2']);
				$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 15 - 15 - 15 '.number_format($data_result['CHM2_15_15_15']['2']).' กิโลกรัม','value'=> $data_result['CHM2_15_15_15']['2']);
				$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 16 - 20 - 0 '.number_format($data_result['CHM3_16_20_0']['2']).' กิโลกรัม','value'=> $data_result['CHM3_16_20_0']['2']);
				$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีอื่นๆ '.number_format($data_result['CHM4_OTHER']['2']).' กิโลกรัม','value'=> $data_result['CHM4_OTHER']['2']);
				$list_fertilizer_type2[] = array('name'=>'ปุ๋ยอินทรีย์ '.number_format($data_result['CHM2_INTR']['2']).' กิโลกรัม','value'=> $data_result['CHM2_INTR']['2']);
				$list_fertilizer_type2[] = array('name'=>'ยาปราบศัตรูพืชชนิดน้ำ '.number_format($data_result['CHM1_WATER']['2']).' กิโลกรัม','value'=> $data_result['CHM1_WATER']['2']);
				$list_fertilizer_type2[] = array('name'=>'ยาปราบศัตรูพืชชนิดเม็ด/ผง '.number_format($data_result['CHM2_C_C_C']['2']).' กิโลกรัม','value'=> $data_result['CHM2_C_C_C']['2']);
				$list_fertilizer_type2[] = array('name'=>'เมล็ดพันธุ์ '.number_format($data_result['CHM1_SEED']['2']).' กิโลกรัม','value'=> $data_result['CHM1_SEED']['2']);
				
				$list_fertilizer_type['ซื้อจากสหกรณ์'] = $list_fertilizer_type1;
				$list_fertilizer_type['ซื้อจากพ่อค้า'] = $list_fertilizer_type2;
				
				$list_fertilizer[] = 'ปุ๋ยเคมีสูตร 46 - 0 - 0';
				$list_fertilizer[] = 'ปุ๋ยเคมีสูตร 15 - 15 - 15';
				$list_fertilizer[] ='ปุ๋ยเคมีสูตร 16 - 20 - 0';
				$list_fertilizer[] = 'ปุ๋ยเคมีอื่นๆ';
				$list_fertilizer[] ='ปุ๋ยอินทรีย์';
				$list_fertilizer[] ='ยาปราบศัตรูพืชชนิดน้ำ';
				$list_fertilizer[] = 'ยาปราบศัตรูพืชชนิดเม็ด/ผง';
				$list_fertilizer[] = 'เมล็ดพันธุ์';
				
				$output = array();
				$output['total'] = $total;
				$output['list_comment'] = $list_fertilizer;
				$output['list_data'] = $list_fertilizer_type;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}
			foreach ($data_report as $datas)
			{
// 				$total = $total+1;
				$check_data = false;
				foreach ($datas as $k=>$v)
				{
					
					
					if(isset($data_result[$k])&&!empty($v))
					{
						foreach ($v as $key=>$value)
						{
							$data_result[$k][$key] = intval($data_result[$k][$key])+intval($value);
							if(!empty($value) && $value != '' && $value !='0')
							{
								$check_data = true;
							}
							
						}
						
					}
				}
				if($check_data)
				{
					$total = $total+1;
				}
				
				
			}
			$data_result['CHM1_SEED']['1'] = $data_result['CHM1_SEED']['1'] + $data_result['CHM2_SEED']['1'];
			$data_result['CHM1_SEED']['2'] = $data_result['CHM1_SEED']['2'] + $data_result['CHM2_SEED']['2'];
			
			$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 46 - 0 - 0 '.number_format($data_result['CHM1_46_0_0']['1']).' กิโลกรัม','value'=> $data_result['CHM1_46_0_0']['1']);
			$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 15 - 15 - 15 '.number_format($data_result['CHM2_15_15_15']['1']).' กิโลกรัม','value'=> $data_result['CHM2_15_15_15']['1']);
			$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีสูตร 16 - 20 - 0 '.number_format($data_result['CHM3_16_20_0']['1']).' กิโลกรัม','value'=> $data_result['CHM3_16_20_0']['1']);
			$list_fertilizer_type1[] = array('name'=>'ปุ๋ยเคมีอื่นๆ '.number_format($data_result['CHM4_OTHER']['1']).' กิโลกรัม','value'=> $data_result['CHM4_OTHER']['1']);
			$list_fertilizer_type1[] = array('name'=>'ปุ๋ยอินทรีย์ '.number_format($data_result['CHM2_INTR']['1']).' กิโลกรัม','value'=> $data_result['CHM2_INTR']['1']);
			$list_fertilizer_type1[] = array('name'=>'ยาปราบศัตรูพืชชนิดน้ำ '.number_format($data_result['CHM1_WATER']['1']).' กิโลกรัม','value'=> $data_result['CHM1_WATER']['1']);
			$list_fertilizer_type1[] = array('name'=>'ยาปราบศัตรูพืชชนิดเม็ด/ผง '.number_format($data_result['CHM2_C_C_C']['1']).' กิโลกรัม','value'=> $data_result['CHM2_C_C_C']['1']);
			$list_fertilizer_type1[] = array('name'=>'เมล็ดพันธุ์ '.number_format($data_result['CHM1_SEED']['1']).' กิโลกรัม','value'=> $data_result['CHM1_SEED']['1']);
			
			
			
			$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 46 - 0 - 0 '.number_format($data_result['CHM1_46_0_0']['2']).' กิโลกรัม','value'=> $data_result['CHM1_46_0_0']['2']);
			$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 15 - 15 - 15 '.number_format($data_result['CHM2_15_15_15']['2']).' กิโลกรัม','value'=> $data_result['CHM2_15_15_15']['2']);
			$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีสูตร 16 - 20 - 0 '.number_format($data_result['CHM3_16_20_0']['2']).' กิโลกรัม','value'=> $data_result['CHM3_16_20_0']['2']);
			$list_fertilizer_type2[] = array('name'=>'ปุ๋ยเคมีอื่นๆ '.number_format($data_result['CHM4_OTHER']['2']).' กิโลกรัม','value'=> $data_result['CHM4_OTHER']['2']);
			$list_fertilizer_type2[] = array('name'=>'ปุ๋ยอินทรีย์ '.number_format($data_result['CHM2_INTR']['2']).' กิโลกรัม','value'=> $data_result['CHM2_INTR']['2']);
			$list_fertilizer_type2[] = array('name'=>'ยาปราบศัตรูพืชชนิดน้ำ '.number_format($data_result['CHM1_WATER']['2']).' กิโลกรัม','value'=> $data_result['CHM1_WATER']['2']);
			$list_fertilizer_type2[] = array('name'=>'ยาปราบศัตรูพืชชนิดเม็ด/ผง '.number_format($data_result['CHM2_C_C_C']['2']).' กิโลกรัม','value'=> $data_result['CHM2_C_C_C']['2']);
			$list_fertilizer_type2[] = array('name'=>'เมล็ดพันธุ์ '.number_format($data_result['CHM1_SEED']['2']).' กิโลกรัม','value'=> $data_result['CHM1_SEED']['2']);
			
			$list_fertilizer_type['ซื้อจากสหกรณ์'] = $list_fertilizer_type1;
			$list_fertilizer_type['ซื้อจากพ่อค้า'] = $list_fertilizer_type2;
			
			$list_fertilizer[] = 'ปุ๋ยเคมีสูตร 46 - 0 - 0';
			$list_fertilizer[] = 'ปุ๋ยเคมีสูตร 15 - 15 - 15';
			$list_fertilizer[] ='ปุ๋ยเคมีสูตร 16 - 20 - 0';
			$list_fertilizer[] = 'ปุ๋ยเคมีอื่นๆ';
			$list_fertilizer[] ='ปุ๋ยอินทรีย์';
			$list_fertilizer[] ='ยาปราบศัตรูพืชชนิดน้ำ';
			$list_fertilizer[] = 'ยาปราบศัตรูพืชชนิดเม็ด/ผง';
			$list_fertilizer[] = 'เมล็ดพันธุ์';
			
			$output = array();
			$output['total'] = $total;
			$output['list_comment'] = $list_fertilizer;
			$output['list_data'] = $list_fertilizer_type;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function count_animal_land()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('ani_type'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report= getListDataSurvey();
				$animal_type_array = array();
				$animal_type_array['ผึ้งเลี้ยง'] = 0;
				$animal_type_array['กระบือ'] = 0;
				$animal_type_array['สุกร'] = 0;
				$animal_type_array['ไก่'] = 0;
				$animal_type_array['เป็ด'] = 0;
				$animal_type_array['โคนม'] = 0;
				$animal_type_array['โคเนื้อ'] = 0;
				$animal_type_array['แพะเนื้อ'] = 0;
				$animal_type_array['แพะนม'] = 0;
				$animal_type_array['กวาง'] = 0;
				$animal_type_array['สัตว์บกอื่นๆ'] = 0;		
			
			$total = 0;
			
			
			if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
				
				$list_animal[] = array('name'=>'ผึ้งเลี้ยง '.number_format($animal_type_array['ผึ้งเลี้ยง']).' คน','value'=> $animal_type_array['ผึ้งเลี้ยง']);
				$list_animal[] = array('name'=>'กระบือ '.number_format($animal_type_array['กระบือ']).' คน','value'=> $animal_type_array['กระบือ']);
				$list_animal[] = array('name'=>'สุกร '.number_format($animal_type_array['สุกร']).' คน','value'=> $animal_type_array['สุกร']);
				$list_animal[] = array('name'=>'ไก่ '.number_format($animal_type_array['ไก่']).' คน','value'=> $animal_type_array['ไก่']);
				$list_animal[] = array('name'=>'เป็ด '.number_format($animal_type_array['เป็ด']).' คน','value'=> $animal_type_array['เป็ด']);
				$list_animal[] = array('name'=>'โคนม '.number_format($animal_type_array['โคนม']).' คน','value'=> $animal_type_array['โคนม']);
				$list_animal[] = array('name'=>'โคเนื้อ '.number_format($animal_type_array['โคเนื้อ']).' คน','value'=> $animal_type_array['โคเนื้อ']);
				$list_animal[] = array('name'=>'แพะเนื้อ '.number_format($animal_type_array['แพะเนื้อ']).' คน','value'=> $animal_type_array['แพะเนื้อ']);
				$list_animal[] = array('name'=>'แพะนม '.number_format($animal_type_array['แพะนม']).' คน','value'=> $animal_type_array['แพะนม']);
				$list_animal[] = array('name'=>'กวาง '.number_format($animal_type_array['กวาง']).' คน','value'=> $animal_type_array['กวาง']);
				$list_animal[] = array('name'=>'สัตว์บกอื่นๆ '.number_format($animal_type_array['สัตว์บกอื่นๆ']).' คน','value'=> $animal_type_array['สัตว์บกอื่นๆ']);
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_animal;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
				exit();
			}

			foreach ($data_report as $data)
			{
				if (!isset($data['ANI_TYPE']) || empty($data['ANI_TYPE'])) {
// 					$total = $total+1;
					continue;
				}
				$total = $total+1;
				foreach($data['ANI_TYPE'] as $key=>$value)
				{
					switch ($value)
					{
						case '11':
							$animal_type_array['ผึ้งเลี้ยง']= intval($animal_type_array['ผึ้งเลี้ยง'])+1;
							break;
						case '12':
							$animal_type_array['ไก่']= intval($animal_type_array['ไก่'])+1;
							break;
						case '13':
							$animal_type_array['เป็ด']= intval($animal_type_array['เป็ด'])+1;
							break;
						case '23':
							$animal_type_array['โคนม']= intval($animal_type_array['โคนม'])+1;
							break;
						case '24':
							$animal_type_array['โคเนื้อ']= intval($animal_type_array['โคเนื้อ'])+1;
							break;
						case '25':
							$animal_type_array['แพะเนื้อ']= intval($animal_type_array['แพะเนื้อ'])+1;
							break;
						case '26':
							$animal_type_array['แพะนม']= intval($animal_type_array['แพะนม'])+1;
							break;
						case '27':
							$animal_type_array['กวาง']= intval($animal_type_array['กวาง'])+1;
							break;
						case '28':
							$animal_type_array['สัตว์บกอื่นๆ']= intval($animal_type_array['สัตว์บกอื่นๆ'])+1;
							break;
					}
				}
				
			}
			
			$list_animal[] = array('name'=>'ผึ้งเลี้ยง '.number_format($animal_type_array['ผึ้งเลี้ยง']).' คน','value'=> $animal_type_array['ผึ้งเลี้ยง']);
			$list_animal[] = array('name'=>'กระบือ '.number_format($animal_type_array['กระบือ']).' คน','value'=> $animal_type_array['กระบือ']);
			$list_animal[] = array('name'=>'สุกร '.number_format($animal_type_array['สุกร']).' คน','value'=> $animal_type_array['สุกร']);
			$list_animal[] = array('name'=>'ไก่ '.number_format($animal_type_array['ไก่']).' คน','value'=> $animal_type_array['ไก่']);
			$list_animal[] = array('name'=>'เป็ด '.number_format($animal_type_array['เป็ด']).' คน','value'=> $animal_type_array['เป็ด']);
			$list_animal[] = array('name'=>'โคนม '.number_format($animal_type_array['โคนม']).' คน','value'=> $animal_type_array['โคนม']);
			$list_animal[] = array('name'=>'โคเนื้อ '.number_format($animal_type_array['โคเนื้อ']).' คน','value'=> $animal_type_array['โคเนื้อ']);
			$list_animal[] = array('name'=>'แพะเนื้อ '.number_format($animal_type_array['แพะเนื้อ']).' คน','value'=> $animal_type_array['แพะเนื้อ']);
			$list_animal[] = array('name'=>'แพะนม '.number_format($animal_type_array['แพะนม']).' คน','value'=> $animal_type_array['แพะนม']);
			$list_animal[] = array('name'=>'กวาง '.number_format($animal_type_array['กวาง']).' คน','value'=> $animal_type_array['กวาง']);
			$list_animal[] = array('name'=>'สัตว์บกอื่นๆ '.number_format($animal_type_array['สัตว์บกอื่นๆ']).' คน','value'=> $animal_type_array['สัตว์บกอื่นๆ']);
		
			$output = array();
			$output['total'] = $total;
			$output['list_data'] = $list_animal;
			$output['countall'] =  getCountRowSurvey($year);
			echo json_encode($output);
		}
	}
	public function count_animal_water ()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('ani2_type'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report= getListDataSurvey();
				
				
				
				
				$animal_type_array = array();
				$animal_type_array['กุ้ง'] = 0;
				$animal_type_array['ปลา'] = 0;
				$animal_type_array['หอย'] = 0;
				$animal_type_array['สัตว์น้ำอื่นๆ'] = 0;
				
				$total = 0;
				
				
				if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
					
					$list_animal[] = array('name'=>'กุ้ง '.number_format($animal_type_array['กุ้ง']).' คน','value'=> $animal_type_array['กุ้ง']);
					$list_animal[] = array('name'=>'ปลา '.number_format($animal_type_array['ปลา']).' คน','value'=> $animal_type_array['ปลา']);
					$list_animal[] = array('name'=>'หอย '.number_format($animal_type_array['หอย']).' คน','value'=> $animal_type_array['หอย']);
					$list_animal[] = array('name'=>'สัตว์น้ำอื่นๆ '.number_format($animal_type_array['สัตว์น้ำอื่นๆ']).' คน','value'=> $animal_type_array['สัตว์น้ำอื่นๆ']);
				
					$output = array();
					$output['total'] = $total;
					$output['list_data'] = $list_animal;
					$output['countall'] =  getCountRowSurvey($year);
					echo json_encode($output);
					exit();
				}
				
				foreach ($data_report as $data)
				{
					if (!isset($data['ANI2_TYPE']) || empty($data['ANI2_TYPE']) || sizeof($data['ANI2_TYPE'])<=0) {
// 						$total = $total+1;
						continue;
					}
					$total = $total+1;
					foreach($data['ANI2_TYPE'] as $key=>$value)
					{
						switch ($value)
						{
							case '01':
								$animal_type_array['กุ้ง']= intval($animal_type_array['กุ้ง'])+1;
								break;
							case '02':
								$animal_type_array['ปลา']= intval($animal_type_array['ปลา'])+1;
								break;
							case '03':
								$animal_type_array['หอย']= intval($animal_type_array['หอย'])+1;
								break;
							case '04':
								$animal_type_array['สัตว์น้ำอื่นๆ']= intval($animal_type_array['สัตว์น้ำอื่นๆ'])+1;
								break;
							
						}
					}
					
				}
				
				$list_animal[] = array('name'=>'กุ้ง '.number_format($animal_type_array['กุ้ง']).' คน','value'=> $animal_type_array['กุ้ง']);
				$list_animal[] = array('name'=>'ปลา '.number_format($animal_type_array['ปลา']).' คน','value'=> $animal_type_array['ปลา']);
				$list_animal[] = array('name'=>'หอย '.number_format($animal_type_array['หอย']).' คน','value'=> $animal_type_array['หอย']);
				$list_animal[] = array('name'=>'สัตว์น้ำอื่นๆ '.number_format($animal_type_array['สัตว์น้ำอื่นๆ']).' คน','value'=> $animal_type_array['สัตว์น้ำอื่นๆ']);
				
				
				$output = array();
				$output['total'] = $total;
				$output['list_data'] = $list_animal;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
		}
	}
	public function count_income_expense_animal()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select('ANI_INCOME,ANI2_INCOME,ANI_EXPENSE_PER_YEAR,ANI2_EXPENSE_PER_YEAR');
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report= getListDataSurvey();
				
				$i = 0;
				$list_count_income['1'] = 0;
				$list_count_income['2'] = 0;
				$list_count_income['3'] = 0;
				$list_count_expense['1'] = 0;
				$list_count_expense['2'] = 0;
				$list_count_expense['3'] = 0;
				
				if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
					
					$list_income[] = array('name'=>'รายรับน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
					$list_income[] = array('name'=>'รายรับ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
					$list_income[] = array('name'=>'รายรับมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
					
					$list_expense[] = array('name'=>'รายจ่ายน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
					$list_expense[] = array('name'=>'รายจ่าย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
					$list_expense[] = array('name'=>'รายจ่ายมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
					
					$list_count['รายรับ'] = $list_income;
					$list_count['รายจ่าย'] = $list_expense;
					
					$list_comment[] = 'รายรับ/จ่ายน้อยกว่า 50,000';
					$list_comment[] = 'รายรับ/จ่าย 50,000-300,000';
					$list_comment[] = 'รายรับ/จ่ายมากกว่า 300,000';
					$output = array();
					$output['total'] = $i;
					$output['list_comment'] = $list_comment;
					$output['list_data'] = $list_count;
					$output['countall'] =  getCountRowSurvey($year);
					echo json_encode($output);
					exit();
				}
				$temp = array();
				
				
				foreach ($data_report as $data)
				{
					$temp[$i]['INCOME'] = 0;
					$temp[$i]['EXPENSE'] = 0;
					if((!empty($data['ANI_INCOME']) && sizeof($data['ANI_INCOME'])>0) || (!empty($data['ANI2_INCOME']) && sizeof($data['ANI2_INCOME'])>0)){
						if(!empty($data['ANI_INCOME']) && sizeof($data['ANI_INCOME'])>0)
							foreach ($data['ANI_INCOME'] as $ANI_INCOME)
							{
								if(!empty($ANI_INCOME) && is_numeric($ANI_INCOME))
									$temp[$i]['INCOME'] = intval($temp[$i]['INCOME'])+intval($ANI_INCOME);
								
							}
						if(!empty($data['ANI2_INCOME']) && sizeof($data['ANI2_INCOME'])>0)
							foreach ($data['ANI2_INCOME'] as $ANI2_INCOME)
							{
								if(!empty($ANI2_INCOME) && is_numeric($ANI2_INCOME))
									$temp[$i]['INCOME']= intval($temp[$i]['INCOME'])+intval($ANI2_INCOME);
							}
					}
					if((!empty($data['ANI_EXPENSE_PER_YEAR']) && sizeof($data['ANI_EXPENSE_PER_YEAR'])>0) || (!empty($data['ANI2_EXPENSE_PER_YEAR']) && sizeof($data['ANI2_EXPENSE_PER_YEAR'])>0)){
						if(!empty($data['ANI_EXPENSE_PER_YEAR']) && sizeof($data['ANI_EXPENSE_PER_YEAR'])>0)
							foreach ($data['ANI_EXPENSE_PER_YEAR'] as $ANI_EXPENSE_PER_YEAR)
							{
								if(!empty($ANI_EXPENSE_PER_YEAR) && is_numeric($ANI_EXPENSE_PER_YEAR))
									$temp[$i]['EXPENSE'] = intval($temp[$i]['EXPENSE'])+intval($ANI_EXPENSE_PER_YEAR);
							}
						if(!empty($data['ANI2_EXPENSE_PER_YEAR']) && sizeof($data['ANI2_EXPENSE_PER_YEAR'])>0)
							foreach ($data['ANI2_EXPENSE_PER_YEAR'] as $ANI2_EXPENSE_PER_YEAR)
							{
								if(!empty($ANI2_EXPENSE_PER_YEAR) && is_numeric($ANI2_EXPENSE_PER_YEAR))
									$temp[$i]['EXPENSE'] = intval($temp[$i]['EXPENSE'])+intval($ANI2_EXPENSE_PER_YEAR);
							}
					}
					$i++;
					
				}	

				
				foreach ($temp as $value)
				{
					if($value['INCOME'] < 50000)
						$list_count_income['1'] = intval($list_count_income['1'])+1;
					elseif ($value['INCOME'] > 300000)
							$list_count_income['3'] = intval($list_count_income['3'])+1;
					else 
							$list_count_income['2'] = intval($list_count_income['2'])+1;
						
					if($value['EXPENSE'] < 50000)
						$list_count_expense['1'] = intval($list_count_expense['1'])+1;
					elseif ($value['EXPENSE'] > 300000)
						$list_count_expense['3'] = intval($list_count_expense['3'])+1;
					else
						$list_count_expense['2'] = intval($list_count_expense['2'])+1;
				}
				
				$list_income[] = array('name'=>'รายรับน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
				$list_income[] = array('name'=>'รายรับ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
				$list_income[] = array('name'=>'รายรับมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
				
				$list_expense[] = array('name'=>'รายจ่ายน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
				$list_expense[] = array('name'=>'รายจ่าย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
				$list_expense[] = array('name'=>'รายจ่ายมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
				
				$list_count['รายรับ'] = $list_income;
				$list_count['รายจ่าย'] = $list_expense;
				
				$list_comment[] = 'รายรับ/จ่ายน้อยกว่า 50,000';
				$list_comment[] = 'รายรับ/จ่าย 50,000-300,000';
				$list_comment[] = 'รายรับ/จ่ายมากกว่า 300,000';
				
				$output = array();
				$output['total'] = $i;
				$output['list_comment'] = $list_comment;
				$output['list_data'] = $list_count;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
		}
	}
	public function count_income_expense_plant()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select('ESTSALES_REVENUEYEAR,ESTAGRI_INCOMEYEAR');
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report= getListDataSurvey();
							
				$i = 0;
				$list_count_income['1'] = 0;
				$list_count_income['2'] = 0;
				$list_count_income['3'] = 0;
				$list_count_expense['1'] = 0;
				$list_count_expense['2'] = 0;
				$list_count_expense['3'] = 0;
				
				if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
					
					$list_income[] = array('name'=>'รายรับน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
					$list_income[] = array('name'=>'รายรับ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
					$list_income[] = array('name'=>'รายรับมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
					
					$list_expense[] = array('name'=>'รายจ่ายน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
					$list_expense[] = array('name'=>'รายจ่าย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
					$list_expense[] = array('name'=>'รายจ่ายมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
					
					$list_count['รายรับ'] = $list_income;
					$list_count['รายจ่าย'] = $list_expense;
					
					$list_comment[] = 'รายรับ/จ่ายน้อยกว่า 50,000';
					$list_comment[] = 'รายรับ/จ่าย 50,000-300,000';
					$list_comment[] = 'รายรับ/จ่ายมากกว่า 300,000';
					$output = array();
					$output['total'] = $i;
					$output['list_comment'] = $list_comment;
					$output['list_data'] = $list_count;
					$output['countall'] =  getCountRowSurvey($year);
					echo json_encode($output);
					exit();
				}
				$temp = array();
				
				
				foreach ($data_report as $data)
				{
					$temp[$i]['INCOME'] = 0;
					$temp[$i]['EXPENSE'] = 0;
					if((!empty($data['ESTAGRI_INCOMEYEAR']) && sizeof($data['ESTAGRI_INCOMEYEAR'])>0)){
						if(!empty($data['ESTAGRI_INCOMEYEAR']) && sizeof($data['ESTAGRI_INCOMEYEAR'])>0)
							foreach ($data['ESTAGRI_INCOMEYEAR'] as $ANI_INCOME)
							{
								if(!empty($ANI_INCOME) && is_numeric($ANI_INCOME))
								$temp[$i]['INCOME'] = intval($temp[$i]['INCOME'])+intval($ANI_INCOME);
							}
						
					}
					if((!empty($data['ESTSALES_REVENUEYEAR']) && sizeof($data['ESTSALES_REVENUEYEAR'])>0)){
						if(!empty($data['ESTSALES_REVENUEYEAR']) && sizeof($data['ESTSALES_REVENUEYEAR'])>0)
							foreach ($data['ESTSALES_REVENUEYEAR'] as $ANI_EXPENSE_PER_YEAR)
							{
								if(!empty($ANI_EXPENSE_PER_YEAR) && is_numeric($ANI_EXPENSE_PER_YEAR))
									$temp[$i]['EXPENSE'] = intval($temp[$i]['EXPENSE'])+intval($ANI_EXPENSE_PER_YEAR);
							}
						
					}
					$i++;
					
				}
				
				
				foreach ($temp as $value)
				{
					if($value['INCOME'] < 50000)
						$list_count_income['1'] = intval($list_count_income['1'])+1;
						elseif ($value['INCOME'] > 300000)
						$list_count_income['3'] = intval($list_count_income['3'])+1;
						else
							$list_count_income['2'] = intval($list_count_income['2'])+1;
							
							if($value['EXPENSE'] < 50000)
								$list_count_expense['1'] = intval($list_count_expense['1'])+1;
								elseif ($value['EXPENSE'] > 300000)
								$list_count_expense['3'] = intval($list_count_expense['3'])+1;
								else
									$list_count_expense['2'] = intval($list_count_expense['2'])+1;
				}
				
				$list_income[] = array('name'=>'รายรับน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
				$list_income[] = array('name'=>'รายรับ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
				$list_income[] = array('name'=>'รายรับมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
				
				$list_expense[] = array('name'=>'รายจ่ายน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
				$list_expense[] = array('name'=>'รายจ่าย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
				$list_expense[] = array('name'=>'รายจ่ายมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
				
				$list_count['รายรับ'] = $list_income;
				$list_count['รายจ่าย'] = $list_expense;
				
				$list_comment[] = 'รายรับ/จ่ายน้อยกว่า 50,000';
				$list_comment[] = 'รายรับ/จ่าย 50,000-300,000';
				$list_comment[] = 'รายรับ/จ่ายมากกว่า 300,000';
				
				$output = array();
				$output['total'] = $i;
				$output['list_comment'] = $list_comment;
				$output['list_data'] = $list_count;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
		}
	}
	
	public function range_area()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select(strtoupper('own_land_type,own_land_rai,own_land_ngan,own_land_squarewa'));
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
			
				
				//TODO enable for use
// 				$this->db->where(strtoupper('own_land_type'),'1');
				
				$this->rang_income();
				
				$data_report= getListDataSurvey();
				
				$count_array = array();
				if(!empty($data_report) && is_array($data_report) && sizeof($data_report)>0)
				foreach ($data_report as $data)
				{
					if(!empty($data['OWN_LAND_TYPE']) && is_array($data['OWN_LAND_TYPE']) && sizeof($data['OWN_LAND_TYPE'])>0)
					for ($i=0;$i<sizeof($data['OWN_LAND_TYPE']);$i++)
					{
						if(!empty($data['OWN_LAND_TYPE'][$i]) && $data['OWN_LAND_TYPE'][$i] == '1')
						{
							$temp_area =0;
							if(!empty($data['OWN_LAND_RAI'][$i]))
							{
								$temp_area += (($this->validate_nummeric_and_emty($data['OWN_LAND_RAI'][$i])*4)*100);
							}
							if(!empty($data['OWN_LAND_NGAN'][$i]))
							{
								$temp_area += ($this->validate_nummeric_and_emty($data['OWN_LAND_NGAN'][$i])*100);
							}
							if(!empty($data[strtoupper('own_land_squarewa')][$i]))
							{
								$temp_area += $this->validate_nummeric_and_emty($data[strtoupper('own_land_squarewa')][$i]);
							}
							$count_array[] = $temp_area;
							
							
						}
					}
					
				}
				
				$key = array('1-10','10-50','50-100','100-500','500-1000','1000');
				$result_arear = array();
				$data_response = array();
				if(!empty($count_array) && is_array($count_array) && sizeof($count_array)>0)
				foreach ($count_array as $area)
				{
					if($area !=0)
					{
						$result_arear[] = ($area/400);
					}
				}
				foreach ($key as $k=>$v)
				{
					$length_area = explode("-", $v);
					
					foreach ($result_arear as $area)
					{
						if(empty($data_response[$v] ))
							$data_response[$v] =0;
						
						if( !empty($length_area[1]) && intval($length_area[0]) < $area && intval($length_area[1]) >=$area)
						{
							if(empty($data_response[$v] ))
								$data_response[$v] =0;
							
							$data_response[$v] += 1;
							
						}if(empty($length_area[1]) && intval($length_area[0]) < $area){
							if(empty($data_response[$v] ))
								$data_response[$v] =0;
							
								$data_response[$v] += 1;
						}
					}
					
				}
				$data_array = array();
				foreach ($data_response as $k=>$v)
				{
					$data_array[] = array('name'=>'ตั้งแต่  '.$k.' ไร่  '.$v.' คน','value'=>$v);
				}
				
				$data = array();
				
				$data['list_data'] = $data_array;
				$data['total'] = sizeof($data_report);
				
				$data['countall'] =  getCountRowSurvey($year);
				
				
				
				$this->response_data($data);
		}
	}
	
	private function rang_income()
	{
		$range_income = !empty($this->input->get('filter_range_income_hidden'))?$this->input->get('filter_range_income_hidden'):"";
		if(!empty($range_income) &&  $range_income !="0")
		{
			
			if($range_income>3)
			{
				$range_income = 3;
			}
			
			$pieces = explode("-", $this->listfilter[$range_income]);
			
			$this->db->where('YEAR_INCOME >',$pieces[0]);
			
			if(!empty($pieces[1]))
				$this->db->where('YEAR_INCOME <',$pieces[1]);
				
		}
	}
	public function count_debt_normal_abnormal()
	{
		if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id'))
				&& canViewReport())
		{
			
			$year = $this->input->get('filter_year');
			$province = !empty($this->input->get('filter_province_hidden'))?$this->input->get('filter_province_hidden'):"";
			
			
			$this->db->select('TAB5_DEBT_NORMAL_COOP,TAB5_DEBT_NORMAL_BAAC,TAB5_DEBT_NORMAL_B_OTHERS,TAB5_DEBT_NORMAL_HOUSING,TAB5_DEBT_NORMAL_MIDDLE_MAN,TAB5_DEBT_NORMAL_THE_NEIG,
TAB5_DEBT_NORMAL_OTHERS,TAB5_DEBT_ABNORMAL_COOP,TAB5_DEBT_ABNORMAL_BAAC,TAB5_DEBT_ABNORMAL_B_OTHERS,TAB5_DEBT_ABNORMAL_HOUSING
,TAB5_DEBT_ABNORMAL_MIDDLE_MAN,TAB5_DEBT_ABNORMAL_THE_NEIG,TAB5_DEBT_ABNORMAL_OTHERS');
			
			if(!empty($province) && $province !="")
				$this->db->where('PROVINCE_ID',$province);
				$this->rang_income();
				$data_report= getListDataSurvey();
				
				$i = 0;
				$list_count_income['1'] = 0;
				$list_count_income['2'] = 0;
				$list_count_income['3'] = 0;
				$list_count_expense['1'] = 0;
				$list_count_expense['2'] = 0;
				$list_count_expense['3'] = 0;
				
				$data_result['TAB5_DEBT_NORMAL_COOP'] = 0;
				$data_result['TAB5_DEBT_NORMAL_BAAC'] = 0;
				$data_result['TAB5_DEBT_NORMAL_B_OTHERS'] = 0;
				$data_result['TAB5_DEBT_NORMAL_HOUSING'] = 0;
				$data_result['TAB5_DEBT_NORMAL_MIDDLE_MAN'] = 0;
				$data_result['TAB5_DEBT_NORMAL_THE_NEIG'] = 0;
				$data_result['TAB5_DEBT_NORMAL_OTHERS'] = 0;
				
				$data_result['TAB5_DEBT_ABNORMAL_COOP'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_BAAC'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_B_OTHERS'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_HOUSING'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_MIDDLE_MAN'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_THE_NEIG'] = 0;
				$data_result['TAB5_DEBT_ABNORMAL_OTHERS'] = 0;
				
				if (!isset($data_report) || empty($data_report) || sizeof($data_report)<=0) {
					
					$list_income[] = array('name'=>'หนี้ปกติน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
					$list_income[] = array('name'=>'หนี้ปกติ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
					$list_income[] = array('name'=>'หนี้ปกติมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
					
					$list_expense[] = array('name'=>'หนี้เสียน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
					$list_expense[] = array('name'=>'หนี้เสีย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
					$list_expense[] = array('name'=>'หนี้เสียมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
					
					$list_count['หนี้ปกติ'] = $list_income;
					$list_count['หนี้เสีย'] = $list_expense;
					
					$list_comment[] = 'หนี้สินน้อยกว่า 50,000';
					$list_comment[] = 'หนี้สิน 50,000-300,000';
					$list_comment[] = 'หนี้สินมากกว่า 300,000';
					
					$output = array();
					$output['total'] = $i;
					$output['list_comment'] = $list_comment;
					$output['list_data'] = $list_count;
					$output['countall'] =  getCountRowSurvey($year);
					echo json_encode($output);
					exit();
				}
				
				$temp = array();
				
				
				foreach ($data_report as $data)
				{
					$temp[$i]['NORMAL'] = 0;
					$temp[$i]['ABNORMAL'] = 0;	
					
					if(!empty($data['TAB5_DEBT_NORMAL_COOP']) &&  ($data['TAB5_DEBT_NORMAL_COOP'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_COOP'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_BAAC']) &&  ($data['TAB5_DEBT_NORMAL_BAAC'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_BAAC'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_B_OTHERS']) &&  ($data['TAB5_DEBT_NORMAL_B_OTHERS'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_B_OTHERS'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_HOUSING']) &&  ($data['TAB5_DEBT_NORMAL_HOUSING'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_HOUSING'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_MIDDLE_MAN'])  && ($data['TAB5_DEBT_NORMAL_MIDDLE_MAN'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_MIDDLE_MAN'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_THE_NEIG'])  && ($data['TAB5_DEBT_NORMAL_THE_NEIG'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_THE_NEIG'];
					
					if(!empty($data['TAB5_DEBT_NORMAL_OTHERS']) && ($data['TAB5_DEBT_NORMAL_OTHERS'] != "N"))
						$temp[$i]['NORMAL'] = $temp[$i]['NORMAL']+$data['TAB5_DEBT_NORMAL_OTHERS'];
// 				__________________________________________________________________________________________________________________________ 
					
					if(!empty($data['TAB5_DEBT_ABNORMAL_COOP'])  && ($data['TAB5_DEBT_ABNORMAL_COOP'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_COOP'];
						
					if(!empty($data['TAB5_DEBT_ABNORMAL_BAAC'])  && ($data['TAB5_DEBT_ABNORMAL_BAAC'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_BAAC'];
							
					if(!empty($data['TAB5_DEBT_ABNORMAL_B_OTHERS'])  && ($data['TAB5_DEBT_ABNORMAL_B_OTHERS'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_B_OTHERS'];
								
					if(!empty($data['TAB5_DEBT_ABNORMAL_HOUSING'])  && ($data['TAB5_DEBT_ABNORMAL_HOUSING'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_HOUSING'];
					
					if(!empty($data['TAB5_DEBT_ABNORMAL_MIDDLE_MAN'])  && ($data['TAB5_DEBT_ABNORMAL_MIDDLE_MAN'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_MIDDLE_MAN'];
						
					if(!empty($data['TAB5_DEBT_ABNORMAL_THE_NEIG'])  && ($data['TAB5_DEBT_ABNORMAL_THE_NEIG'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_THE_NEIG'];
						
					if(!empty($data['TAB5_DEBT_ABNORMAL_OTHERS'])  && ($data['TAB5_DEBT_ABNORMAL_OTHERS'] != "N"))
						$temp[$i]['ABNORMAL'] = $temp[$i]['ABNORMAL']+$data['TAB5_DEBT_ABNORMAL_OTHERS'];
	
				
						
					$i++;
					
				}
						
				
				foreach ($temp as $value)
				{
					if($value['NORMAL'] < 50000)
						$list_count_income['1'] = intval($list_count_income['1'])+1;
						elseif ($value['NORMAL'] > 300000)
						$list_count_income['3'] = intval($list_count_income['3'])+1;
						else
							$list_count_income['2'] = intval($list_count_income['2'])+1;
							
					if($value['ABNORMAL'] < 50000)
						$list_count_expense['1'] = intval($list_count_expense['1'])+1;
						elseif ($value['ABNORMAL'] > 300000)
						$list_count_expense['3'] = intval($list_count_expense['3'])+1;
						else
							$list_count_expense['2'] = intval($list_count_expense['2'])+1;
				}
				
			
				$list_income[] = array('name'=>'หนี้ปกติน้อยกว่า 50,000 '.number_format($list_count_income['1']).' คน','value'=> $list_count_income['1']);
				$list_income[] = array('name'=>'หนี้ปกติ 50,000-300,000 '.number_format($list_count_income['2']).' คน','value'=> $list_count_income['2']);
				$list_income[] = array('name'=>'หนี้ปกติมากกว่า 300,000 '.number_format($list_count_income['3']).' คน','value'=> $list_count_income['3']);
				
				$list_expense[] = array('name'=>'หนี้เสียน้อยกว่า 50,000 '.number_format($list_count_expense['1']).' คน','value'=> $list_count_expense['1']);
				$list_expense[] = array('name'=>'หนี้เสีย 50,000-300,000 '.number_format($list_count_expense['2']).' คน','value'=> $list_count_expense['2']);
				$list_expense[] = array('name'=>'หนี้เสียมากกว่า 300,000 '.number_format($list_count_expense['3']).' คน','value'=> $list_count_expense['3']);
				
				$list_count['หนี้ปกติ'] = $list_income;
				$list_count['หนี้เสีย'] = $list_expense;
				
				$list_comment[] = 'หนี้สินน้อยกว่า 50,000';
				$list_comment[] = 'หนี้สิน 50,000-300,000';
				$list_comment[] = 'หนี้สินมากกว่า 300,000';
				
				$output = array();
				$output['total'] = $i;
				$output['list_comment'] = $list_comment;
				$output['list_data'] = $list_count;
				$output['countall'] =  getCountRowSurvey($year);
				echo json_encode($output);
		}
	}
	
	private function validate_nummeric_and_emty($data)
	{
		if(empty($data))
		{
			$data = 0;
		}else if(!is_numeric($data))
		{
			$data = 0;
		}else{
			$data = intval($data);
		}
		
		return $data;
	}
	
}

