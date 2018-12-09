<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Report3 extends MY_Controller {

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

		if (!canViewReport())
		{
			redirect('/');
		}



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
	public function index4()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			$type_coop= isset($_GET['type_coop'])? trim($_GET['type_coop']): "0";
			$output = array(
					'type_coop' => $type_coop,
			);
			echo $this->load->view('reports/report12', $output, TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function ajexreport1()
	{
		if(canViewReport())
		{

			ini_set('max_execution_time', -1);
			ini_set("memory_limit", "8124M");
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			// $data = getTotalCoopReport();
			$list_type1 = array();
			$list_total_type1 = 0;
			$list_total_type2 = 0;
			$list_total = array();
			$list_type_in_1 = 0;
			$list_type_in_2 = 0;
			$list_type_in_3 = 0;
			$list_type_out_4 = 0;
			$list_type_out_5 = 0;
			$list_type_out_6 = 0;
			$list_type_out_7 = 0;
			$list_type_in_out = array();

			$sql_count_farm = "SELECT COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
								FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
								WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
								                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
								                          FROM MOIUSER.MASTER_DATA A
								                          WHERE A.OU_D_FLAG IN(1,2)
								                          AND LENGTH (A.IN_D_COOP) = 13 
								                          AND LENGTH (A.OU_D_ID) = 13
								                          AND A.IN_D_COOP IS NOT NULL
								                          GROUP BY OU_D_ID) S)
								AND B.COOP_TYPE IN (1,2,3)                           
								ORDER BY 1";
			$sql_count_nonfarm = "SELECT COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
									FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
									WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
									                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
									                          FROM MOIUSER.MASTER_DATA A
									                          WHERE A.OU_D_FLAG IN(1,2)
									                          AND LENGTH (A.IN_D_COOP) = 13 
									                          AND LENGTH (A.OU_D_ID) = 13
									                          AND A.IN_D_COOP IS NOT NULL
									                          GROUP BY OU_D_ID) S)
									AND B.COOP_TYPE IN (4,5,6,7)                          
									ORDER BY 1";

							

			$sql = "SELECT B.COOP_TYPE,B.COOP_TYPE_NAME,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
					FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
					WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
					                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
					                          FROM MOIUSER.MASTER_DATA A
					                          WHERE A.OU_D_FLAG IN(1,2)
					                          AND LENGTH (A.IN_D_COOP) = 13 
					                          AND LENGTH (A.OU_D_ID) = 13
					                          AND A.IN_D_COOP IS NOT NULL
					                          GROUP BY OU_D_ID) S)
					AND B.COOP_TYPE IS NOT NULL
					GROUP BY B.COOP_TYPE,B.COOP_TYPE_NAME                           
					ORDER BY 1";



			$cache_key_sql = md5($sql);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql = "";
			$query_sql = null;
//			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
				$query_sql = $this->db->query($sql)->result_array();

//				$ci->cache->save($cache_key_sql, $query_sql, 30000);
				// return $query_sql;
//			}else{
//				$query_sql = $data_cache_sql;
//			}

			$cache_key_sql_c_farm = md5($sql_count_farm);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql_c_farm = "";
			$query_sql_c_farm = null;
//			if ( ! $data_cache_sql_c_farm = $ci->cache->get($cache_key_sql_c_farm)) {
				$query_sql_c_farm = $this->db->query($sql_count_farm)->result_array();

//				$ci->cache->save($cache_key_sql_c_farm, $query_sql_c_farm, 30000);
				// return $query_sql_c_farm;
//			}else{
//				$query_sql_c_farm = $data_cache_sql_c_farm;
//			}

			$cache_key_sql_c_nfarm = md5($sql_count_nonfarm);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql_c_nfarm = "";
			$query_sql_c_nfarm = null;
//			if ( ! $data_cache_sql_c_nfarm = $ci->cache->get($cache_key_sql_c_nfarm)) {
				$query_sql_c_nfarm = $this->db->query($sql_count_nonfarm)->result_array();

//				$ci->cache->save($cache_key_sql_c_nfarm, $query_sql_c_nfarm, 30000);
				// return $query_sql_c_nfarm;
//			}else{
//				$query_sql_c_nfarm = $data_cache_sql_c_nfarm;
//			}



			// $query_nomal = $this->db->query($sql)->result_array();
			// $query_count_farm = $this->db->query($sql_count_farm)->result_array();
			// $query_count_nonfarm = $this->db->query($sql_count_nonfarm)->result_array();
			

			// echo print_r($query_nomal);die();
			foreach ($query_sql_c_farm as $value) {
				$list_total[] = array('name'=>'ภาคเกษตร '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
				$list_total_type1 = $value['TOTAL'];
			}

			foreach ($query_sql_c_nfarm as $value) {
				$list_total[] = array('name'=>'นอกภาคเกษตร '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
				$list_total_type2 = $value['TOTAL'];
			}

			foreach ($query_sql as $value) {
				$list_type_in_out[] = array('name'=>$value['COOP_TYPE_NAME'].' '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
			}
			


			// foreach ($data as $item)
			// {
			// 	if(!isset($list_type[$item['ORG_NAME']]))
			// 	{
			// 		$list_type[$item['ORG_NAME']]['1'] =0;
			// 		$list_type[$item['ORG_NAME']]['2'] =0;
			// 		$list_type[$item['ORG_NAME']]['3'] =0;
			// 		$list_type[$item['ORG_NAME']]['4'] =0;
			// 		$list_type[$item['ORG_NAME']]['5'] =0;
			// 		$list_type[$item['ORG_NAME']]['6'] =0;
			// 		$list_type[$item['ORG_NAME']]['7'] =0;
			// 	}
			// 	if($item['COOP_TYPE'] == '1')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['1'];
			// 		$list_type_in_1 = $list_type_in_1+$list_type[$item['ORG_NAME']]['1'];
			// 	}
			// 	if($item['COOP_TYPE'] == '2')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['2']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['2'];
			// 		$list_type_in_2 = $list_type_in_2+$list_type[$item['ORG_NAME']]['2'];
			// 	}
			// 	if($item['COOP_TYPE'] == '3')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['3']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['3'];
			// 		$list_type_in_3 = $list_type_in_3+$list_type[$item['ORG_NAME']]['3'];
			// 	}
			// 	if($item['COOP_TYPE'] == '4')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['4']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['4'];
			// 		$list_type_out_4= $list_type_out_4+$list_type[$item['ORG_NAME']]['4'];
			// 	}
			// 	if($item['COOP_TYPE'] == '5')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['5']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['5'];
			// 		$list_type_out_5= $list_type_out_5+$list_type[$item['ORG_NAME']]['5'];
			// 	}
			// 	if($item['COOP_TYPE'] == '6')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['6']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['6'];
			// 		$list_type_out_6 = $list_type_out_6+$list_type[$item['ORG_NAME']]['6'];
			// 	}
			// 	if($item['COOP_TYPE'] == '7')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['7']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['7'];
			// 		$list_type_out_7 = $list_type_out_7+$list_type[$item['ORG_NAME']]['7'];
			// 	}
			// }




			// $list_total[] =  array('name'=>'ภาคเกษตร '.number_format($list_total_type1).' คน','value'=> $list_total_type1);
			// $list_total[] =  array('name'=>'นอกภาคเกษตร '.number_format($list_total_type2).' คน','value'=> $list_total_type2);


			// $list_type_in_out[] =  array('name'=>'สหกรณ์การเกษตร '.number_format($list_type_in_1).' คน','value'=> $list_type_in_1);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์ประมง '.number_format($list_type_in_2).' คน','value'=> $list_type_in_2);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์นิคม '.number_format($list_type_in_3).' คน','value'=> $list_type_in_3);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์ออมทรัพย์ '.number_format($list_type_out_4).' คน','value'=> $list_type_out_4);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์ร้านค้า '.number_format($list_type_out_5).' คน','value'=> $list_type_out_5);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์บริการ '.number_format($list_type_out_6).' คน','value'=> $list_type_out_6);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์เครดิตยูเนี่ยน '.number_format($list_type_out_7).' คน','value'=> $list_type_out_7);

			// echo print_r($list_total);die();
			$total = $list_total_type1+$list_total_type2;

			$output = array();

			$output['list'] = $list_total;
			$output['type'] = $list_type_in_out;
			$output['total'] = $total;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));
		}
		else {
		echo json_encode(array('1','2'));
		}
	}
	public function ajexreport2()
	{
		if(canViewReport())
		{
			ini_set('max_execution_time', -1);
			ini_set("memory_limit", "8124M");
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			// $data = getTotalCoopReport();
			$list_type1 = array();
			$list_total_type1 = 0;


			$list_type_in_1 = 0;
			$list_type_in_2 = 0;
			$list_type_in_3 = 0;

			$list_type_in_out = array();

			$sql_count_farm = "SELECT COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
								FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
								WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
								                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
								                          FROM MOIUSER.MASTER_DATA A
								                          WHERE A.OU_D_FLAG IN(1,2)
								                          AND LENGTH (A.IN_D_COOP) = 13 
								                          AND LENGTH (A.OU_D_ID) = 13
								                          AND A.IN_D_COOP IS NOT NULL
								                          GROUP BY OU_D_ID) S)
								AND B.COOP_TYPE IN (1,2,3)                           
								ORDER BY 1";
			$sql = "SELECT B.COOP_TYPE,B.COOP_TYPE_NAME,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
					FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
					WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
					                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
					                          FROM MOIUSER.MASTER_DATA A
					                          WHERE A.OU_D_FLAG IN(1,2)
					                          AND LENGTH (A.IN_D_COOP) = 13 
					                          AND LENGTH (A.OU_D_ID) = 13
					                          AND A.IN_D_COOP IS NOT NULL
					                          GROUP BY OU_D_ID) S)
					AND B.COOP_TYPE IN (1,2,3)  
					GROUP BY B.COOP_TYPE,B.COOP_TYPE_NAME                           
					ORDER BY 1";

			$cache_key_sql = md5($sql);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql = "";
			$query_sql = null;
//			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
				$query_sql = $this->db->query($sql)->result_array();

//				$ci->cache->save($cache_key_sql, $query_sql, 30000);
				// return $query_sql;
//			}else{
//				$query_sql = $data_cache_sql;
//			}


			$cache_key_sql_c_farm = md5($sql_count_farm);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql_c_farm = "";
			$query_sql_c_farm = null;
//			if ( ! $data_cache_sql_c_farm = $ci->cache->get($cache_key_sql_c_farm)) {
				$query_sql_c_farm = $this->db->query($sql_count_farm)->result_array();

//				$ci->cache->save($cache_key_sql_c_farm, $query_sql_c_farm, 30000);
				// return $query_sql_c_farm;
//			}else{
//				$query_sql_c_farm = $data_cache_sql_c_farm;
//			}


			foreach ($query_sql_c_farm as $value) {
				// $list_total[] = array('name'=>'ภาคเกษตร '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
				$list_total_type1 = $value['TOTAL'];
			}

			foreach ($query_sql as $value) {
				$list_type_in_out[] = array('name'=>$value['COOP_TYPE_NAME'].' '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
			}


			// foreach ($data as $item)
			// {
			// 	if(!isset($list_type[$item['ORG_NAME']]))
			// 	{
			// 		$list_type[$item['ORG_NAME']]['1'] =0;
			// 		$list_type[$item['ORG_NAME']]['2'] =0;
			// 		$list_type[$item['ORG_NAME']]['3'] =0;
			// 		$list_type[$item['ORG_NAME']]['4'] =0;
			// 		$list_type[$item['ORG_NAME']]['5'] =0;
			// 		$list_type[$item['ORG_NAME']]['6'] =0;
			// 		$list_type[$item['ORG_NAME']]['7'] =0;
			// 	}
			// 	if($item['COOP_TYPE'] == '1')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['1'];
			// 		$list_type_in_1 = $list_type_in_1+$list_type[$item['ORG_NAME']]['1'];
			// 	}
			// 	if($item['COOP_TYPE'] == '2')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['2']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['2'];
			// 		$list_type_in_2 = $list_type_in_2+$list_type[$item['ORG_NAME']]['2'];
			// 	}
			// 	if($item['COOP_TYPE'] == '3')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['3']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['3'];
			// 		$list_type_in_3 = $list_type_in_3+$list_type[$item['ORG_NAME']]['3'];
			// 	}

			// }










			// $list_type_in_out[] =  array('name'=>'สหกรณ์การเกษตร '.number_format($list_type_in_1).' คน','value'=> $list_type_in_1);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์ประมง '.number_format($list_type_in_2).' คน','value'=> $list_type_in_2);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์นิคม '.number_format($list_type_in_3).' คน','value'=> $list_type_in_3);



			$output = array();

			$output['list_total'] = number_format($list_total_type1);
			$output['list_in_out'] = $list_type_in_out;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));

		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function ajexreport3()
	{
		if(canViewReport())
		{

			ini_set('max_execution_time', -1);
			ini_set("memory_limit", "8124M");
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			// $data = getTotalCoopReport();
			$list_type1 = array();
			$list_total_type1 = 0;
			$list_total_type2 = 0;
			$list_total = array();
			$list_type_in_1 = 0;
			$list_type_in_2 = 0;
			$list_type_in_3 = 0;
			$list_type_out_4 = 0;
			$list_type_out_5 = 0;
			$list_type_out_6 = 0;
			$list_type_out_7 = 0;
			$list_type_in_out = array();

			$sql_count_nonfarm = "SELECT COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
									FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
									WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
									                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
									                          FROM MOIUSER.MASTER_DATA A
									                          WHERE A.OU_D_FLAG IN(1,2)
									                          AND LENGTH (A.IN_D_COOP) = 13 
									                          AND LENGTH (A.OU_D_ID) = 13
									                          AND A.IN_D_COOP IS NOT NULL
									                          GROUP BY OU_D_ID) S)
									AND B.COOP_TYPE IN (4,5,6,7)                          
									ORDER BY 1";
			$sql = "SELECT B.COOP_TYPE,B.COOP_TYPE_NAME,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS TOTAL
					FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
					WHERE A.OU_D_ID IN (SELECT S.OU_D_ID 
					                    FROM (SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
					                          FROM MOIUSER.MASTER_DATA A
					                          WHERE A.OU_D_FLAG IN(1,2)
					                          AND LENGTH (A.IN_D_COOP) = 13 
					                          AND LENGTH (A.OU_D_ID) = 13
					                          AND A.IN_D_COOP IS NOT NULL
					                          GROUP BY OU_D_ID) S)
					AND B.COOP_TYPE IN (4,5,6,7)   
					GROUP BY B.COOP_TYPE,B.COOP_TYPE_NAME                           
					ORDER BY 1";

			$cache_key_sql = md5($sql);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql = "";
			$query_sql = null;
//			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
				$query_sql = $this->db->query($sql)->result_array();

//				$ci->cache->save($cache_key_sql, $query_sql, 30000);
				// return $query_sql;
//			}else{
//				$query_sql = $data_cache_sql;
//			}


			$cache_key_sql_c_nfarm = md5($sql_count_nonfarm);
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data_cache_sql_c_nfarm = "";
			$query_sql_c_nfarm = null;
//			if ( ! $data_cache_sql_c_nfarm = $ci->cache->get($cache_key_sql_c_nfarm)) {
				$query_sql_c_nfarm = $this->db->query($sql_count_nonfarm)->result_array();

//				$ci->cache->save($cache_key_sql_c_nfarm, $query_sql_c_nfarm, 30000);
				// return $query_sql_c_nfarm;
//			}else{
//				$query_sql_c_nfarm = $data_cache_sql_c_nfarm;
//			}


			foreach ($query_sql_c_nfarm as $value) {
				// $list_total[] = array('name'=>'ภาคเกษตร '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
				$list_total_type2 = $value['TOTAL'];
			}

			foreach ($query_sql as $value) {
				$list_type_in_out[] = array('name'=>$value['COOP_TYPE_NAME'].' '.number_format($value['TOTAL']).' คน','value'=> intval($value['TOTAL']));
			}


			// foreach ($data as $item)
			// {
			// 	if(!isset($list_type[$item['ORG_NAME']]))
			// 	{
			// 		$list_type[$item['ORG_NAME']]['1'] =0;
			// 		$list_type[$item['ORG_NAME']]['2'] =0;
			// 		$list_type[$item['ORG_NAME']]['3'] =0;
			// 		$list_type[$item['ORG_NAME']]['4'] =0;
			// 		$list_type[$item['ORG_NAME']]['5'] =0;
			// 		$list_type[$item['ORG_NAME']]['6'] =0;
			// 		$list_type[$item['ORG_NAME']]['7'] =0;
			// 	}

			// 	if($item['COOP_TYPE'] == '4')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['4']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['4'];
			// 		$list_type_out_4= $list_type_out_4+$list_type[$item['ORG_NAME']]['4'];
			// 	}
			// 	if($item['COOP_TYPE'] == '5')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['5']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['5'];
			// 		$list_type_out_5= $list_type_out_5+$list_type[$item['ORG_NAME']]['5'];
			// 	}
			// 	if($item['COOP_TYPE'] == '6')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['6']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['6'];
			// 		$list_type_out_6 = $list_type_out_6+$list_type[$item['ORG_NAME']]['6'];
			// 	}
			// 	if($item['COOP_TYPE'] == '7')
			// 	{
			// 		$list_type[$item['ORG_NAME']]['7']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
			// 		$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['7'];
			// 		$list_type_out_7 = $list_type_out_7+$list_type[$item['ORG_NAME']]['7'];
			// 	}
			// }


			// $list_type_in_out[] =  array('name'=>'สหกรณ์ออมทรัพย์ '.number_format($list_type_out_4).' คน','value'=> $list_type_out_4);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์ร้านค้า '.number_format($list_type_out_5).' คน','value'=> $list_type_out_5);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์บริการ '.number_format($list_type_out_6).' คน','value'=> $list_type_out_6);
			// $list_type_in_out[] =  array('name'=>'สหกรณ์เครดิตยูเนี่ยน '.number_format($list_type_out_7).' คน','value'=> $list_type_out_7);


			$output = array();

			$output['list_in_out'] =$list_type_in_out;
			$output['list_total'] =  number_format($list_total_type2);
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));

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
			$type_coop= isset($_GET['type_coop'])? trim($_GET['type_coop']): "0";
			$output = array(
					'type_coop' => $type_coop,
			);
			$output['date'] = $this->changemonth();
			echo $this->load->view('reports3/report7', $output, TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function ajexreport10()
	{
		if(canViewReport())
		{
			$data = getTotalTypeAnimal();
			$total_animal = getCountTypeAnimal();
			$list_animal = array();
			foreach ($data as $item)
			{
				if($item['TYPE_NAME'] != 'อื่น ๆ')
					$list_animal[] =  array('name'=>$item['TYPE_NAME'],'value'=> is_numeric($item['TOT_ANN'])?intval($item['TOT_ANN']):0);
			}
			foreach ($data as $item)
			{
				if($item['TYPE_NAME'] == 'อื่น ๆ')
					$list_animal[] =  array('name'=>$item['TYPE_NAME'],'value'=> is_numeric($item['TOT_ANN'])?intval($item['TOT_ANN']):0);
			}
			$output = array();

			$output['list_animal'] = $list_animal;
			$output['total_animal'] = $total_animal;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));

		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function ajexreport11()
	{
		if(canViewReport())
		{
			$data = getTotalTypeFish();
			$total_animal = getCountTypeFish();
			$list_animal = array();
			foreach ($data as $item)
			{
				$list_animal[] =  array('name'=>$item['TYPE_NAME'],'value'=> is_numeric($item['TOT_ANN'])?intval($item['TOT_ANN']):0);
			}
			$output['list_animal'] = $list_animal;
			$output['total_animal'] = $total_animal;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));
		}
		else {
			redirect('/', 'refresh');
		}
	}

    public function ajaxreport5()
    {
        if(canViewReport())
        {


            try {
                $userId = $this->session->userdata('auth_user_id');
                log_message('info', ' *************** ajaxreport5 userId : '.$userId.' *************** ');

                ini_set('max_execution_time', 0);
                ini_set("memory_limit", '-1');
                $ci =& get_instance();

                try {
                    $data_cache = null;

                    log_message('debug', 'begin pkg_report_mis.rpt_sum_member_eq1_st(:p_out_sum_eq_1, :p_out_sum_avai, :p_out_sum_die); end;');

                    $stmt = oci_parse($this->db->conn_id, "begin pkg_report_mis.rpt_sum_member_eq1_st(:p_out_sum_eq_1, :p_out_sum_avai, :p_out_sum_die); end;");

                    oci_bind_by_name($stmt, ":p_out_sum_eq_1", $sumEq1, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_avai", $sumAvai, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_die", $sumDie, -1, OCI_B_INT);
                    $r = ociexecute($stmt);

                    log_message('debug',"p_out_sum_eq_1 : ".$sumEq1);
                    log_message('debug',"p_out_sum_avai : ".$sumAvai);
                    log_message('debug',"p_out_sum_die : ".$sumDie);


                    $temp_data = array();

                    $temp_data[] = array(
                        'lable'=>'ปกติ  จำนวน '.number_format($sumAvai)." คน",
                        'count'=>intval($sumAvai)
                    );
                    $temp_data[] = array(
                        'lable'=>'ตาย จำนวน '.number_format($sumDie)." คน",
                        'count'=>intval($sumDie)
                    );

                    $output = array();
                    $output['result'] = $temp_data;
                    $output['list_total_type1'] = number_format($sumEq1);
        // 			  $output['all']=$count_all;
        //            $output['query1'] = $sql;
        //            $output['query2'] = $sql2;
        //            $output['query3'] = $sql3;
                    $output['date'] = $this->changemonth();
                    print_r(json_encode($output));
                    die();
                }
                finally {
                    oci_close($ci);
                }

            }
            catch (Exception $e) {
                log_message('error', $e);
                print_r(json_encode($e));
                die();
            }
        }
    }

    // Backup 2018-12-09
//	public function ajexreport5()
//	{
//		if(canViewReport())
//		{
//
//
//			$sql ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					AND A.OU_D_STATUS_TYPE IN (1,11,13)
//					AND A.OU_D_ID IS NOT NULL
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) =1)";
//
//
//
//			$sql2 ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					AND A.OU_D_STATUS_TYPE NOT IN (1,11,13)
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) =1)";
//
//
//
//			$sql3 ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) =1)";
//
//
//			$cache_key_sql = md5($sql);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql = "";
//			$query = null;
////			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
//				$query = $this->db->query($sql)->result_array();
//
////				$ci->cache->save($cache_key_sql, $query, 30000);
//				// return $query;
////			}else{
////				$query = $data_cache_sql;
////			}
//
//			$cache_key_sql2 = md5($sql2);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql2 = "";
//			$query2 = null;
////			if ( ! $data_cache_sql2 = $ci->cache->get($cache_key_sql2)) {
//				$query2 = $this->db->query($sql2)->result_array();
//
////				$ci->cache->save($cache_key_sql2, $query2, 30000);
//				// return $query2;
////			}else{
////				$query2 = $data_cache_sql2;
////			}
//
//			$cache_key_sql3 = md5($sql3);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql3 = "";
//			$query3 = null;
////			if ( ! $data_cache_sql3 = $ci->cache->get($cache_key_sql3)) {
////				$query3 = $this->db->query($sql3)->result_array();
//
//				$ci->cache->save($cache_key_sql3, $query3, 30000);
//				// return $query3;
////			}else{
////				$query3 = $data_cache_sql3;
////			}
//
//
//
//			$temp_data = array();
//
//			$temp_data[] = array(
//					'lable'=>'ปกติ  จำนวน '.number_format($query2[0]['NUM'])." คน",
//					'count'=>intval($query2[0]['NUM'])
//			);
//			$temp_data[] = array(
//					'lable'=>'ตาย จำนวน '.number_format($query3[0]['NUM']-$query2[0]['NUM'])." คน",
//					'count'=>intval($query3[0]['NUM'])-intval($query2[0]['NUM'])
//			);
//
//			$output = array();
//			$output['result'] = $temp_data;
//			$output['list_total_type1'] = number_format($query3[0]['NUM']);
//// 			$output['all']=$count_all;
//			$output['query1'] = $sql;
//			$output['query2'] = $sql2;
//			$output['query3'] = $sql3;
//			$output['date'] = $this->changemonth();
//			print_r(json_encode($output));
//		}
//	}

    public function ajaxreport15()
    {
        if(canViewReport())
        {
            try {
                $userId = $this->session->userdata('auth_user_id');
                log_message('info', ' *************** ajaxreport15 userId : '.$userId.' *************** ');

                ini_set('max_execution_time', 0);
                ini_set("memory_limit", '-1');
                $ci =& get_instance();

                try {
                    $data_cache = null;

                    log_message('debug', 'begin pkg_report_mis.rpt_sum_member_gt1_st(:p_out_sum_gt_1, :p_out_sum_avai, :p_out_sum_die); end;');

                    $stmt = oci_parse($this->db->conn_id, "begin pkg_report_mis.rpt_sum_member_gt1_st(:p_out_sum_gt_1, :p_out_sum_avai, :p_out_sum_die); end;");

                    oci_bind_by_name($stmt, ":p_out_sum_gt_1", $sumGt1, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_avai", $sumAvai, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_die", $sumDie, -1, OCI_B_INT);
                    $r = ociexecute($stmt);

                    log_message('debug',"p_out_sum_gt_1 : ".$sumGt1);
                    log_message('debug',"p_out_sum_avai : ".$sumAvai);
                    log_message('debug',"p_out_sum_die : ".$sumDie);

                    $temp_data = array();

                    $temp_data[] = array(
                            'lable'=>'ปกติ  จำนวน '.number_format($sumAvai)." คน",
                            'count'=>intval($sumAvai)
                    );
                    $temp_data[] = array(
                            'lable'=>'ตาย จำนวน '.number_format($sumDie)." คน",
                            'count'=>intval($sumDie)
                    );

                    $output = array();
                    $output['result'] = $temp_data;
                    $output['list_total_type1'] = number_format($sumGt1);
                    // 			$output['all']=$count_all;
        //			$output['query1'] = $sql;
        //			$output['query2'] = $sql2;
        //			$output['query3'] = $sql3;
                    $output['date'] = $this->changemonth();
                    print_r(json_encode($output));
                    die();
                }
                finally {
                    oci_close($ci);
                }

            }
            catch (Exception $e) {
                log_message('error', $e);
                print_r(json_encode($e));
                die();
            }
        }
    }

    // backup 2018-12-09
//	public function ajexreport15()
//	{
//		if(canViewReport())
//		{
//
//			$sql ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					AND A.OU_D_STATUS_TYPE IN (1,11,13)
//					AND A.OU_D_ID IS NOT NULL
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) >1)";
//
//
//
//
//			$sql2 ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					AND A.OU_D_STATUS_TYPE NOT IN (1,11,13)
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) >1)";
//
//
//
//			$sql3 ="SELECT SUM(AMT) AS num FROM(
//					SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) >1)";
//
//
//			$cache_key_sql = md5($sql);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql = "";
//			$query = null;
////			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
//				$query = $this->db->query($sql)->result_array();
//
////				$ci->cache->save($cache_key_sql, $query, 30000);
//				// return $query;
////			}else{
////				$query = $data_cache_sql;
////			}
//
//			$cache_key_sql2 = md5($sql2);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql2 = "";
//			$query2 = null;
////			if ( ! $data_cache_sql2 = $ci->cache->get($cache_key_sql2)) {
//				$query2 = $this->db->query($sql2)->result_array();
//
//				$ci->cache->save($cache_key_sql2, $query2, 30000);
//				// return $query2;
////			}else{
////				$query2 = $data_cache_sql2;
////			}
//
//			$cache_key_sql3 = md5($sql3);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql3 = "";
//			$query3 = null;
////			if ( ! $data_cache_sql3 = $ci->cache->get($cache_key_sql3)) {
//				$query3 = $this->db->query($sql3)->result_array();
//
////				$ci->cache->save($cache_key_sql3, $query3, 30000);
//				// return $query3;
////			}else{
////				$query3 = $data_cache_sql3;
////			}
//
//
//			$temp_data = array();
//
//			$temp_data[] = array(
//					'lable'=>'ปกติ  จำนวน '.number_format($query2[0]['NUM'])." คน",
//					'count'=>intval($query2[0]['NUM'])
//			);
//			$temp_data[] = array(
//					'lable'=>'ตาย จำนวน '.number_format($query3[0]['NUM']-$query2[0]['NUM'])." คน",
//					'count'=>intval($query3[0]['NUM'])-intval($query2[0]['NUM'])
//			);
//
//			$output = array();
//			$output['result'] = $temp_data;
//			$output['list_total_type1'] = number_format($query3[0]['NUM']);
//			// 			$output['all']=$count_all;
//			$output['query1'] = $sql;
//			$output['query2'] = $sql2;
//			$output['query3'] = $sql3;
//			$output['date'] = $this->changemonth();
//			print_r(json_encode($output));
//
//		}
//	}

	public function ajexreport6 ()
	{
				set_time_limit(-1);
				ini_set("memory_limit", '-1');

		if(canViewReport())
		{
			$cache_key = "Report36";
			$ci =& get_instance();
			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));


			$data_cache = null;

			$count_data_all = array();
//			if ( ! $data_cache = $ci->cache->get($cache_key))
//			{
	// 		$this->db->distinct('COL001');
			$query = $this->db->get($this->db->dbprefix('KHET'));
			$datas = $query->result_array();
			$temp_data = array();

			$sqla_count1 =	"SELECT COOP_INFO.ORG_ORG_ID, SUM(a.TOTAL_COOP)
							FROM COOP_INFO
							LEFT JOIN (
				 				SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) as TOTAL_COOP
				 				FROM (
									SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME
									FROM moiuser.master_data
									WHERE OU_D_FLAG IN (1, 2)
									AND OU_D_STATUS_TYPE NOT IN (1, 11, 13)
									AND IN_D_COOP != '0'
									AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER'
									AND LENGTH (moiuser.master_data.IN_D_COOP) = 13
				 				) tb
								GROUP BY tb.IN_D_COOP
							) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
							GROUP by COOP_INFO.ORG_ORG_ID";

			$temp1 = $this->db->query($sqla_count1)->result_array();

			$sqla_count2 =	"SELECT COOP_INFO.ORG_ORG_ID, SUM(a.TOTAL_COOP)
							FROM COOP_INFO
							LEFT JOIN (
								SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) as TOTAL_COOP
								FROM (
									SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME
			     					FROM moiuser.master_data
			     					WHERE OU_D_FLAG IN (1, 2)
									AND OU_D_STATUS_TYPE IN (1, 11, 13)
									AND IN_D_COOP != '0'
			     					AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER'
									AND LENGTH (moiuser.master_data.IN_D_COOP) = 13
								) tb
								GROUP BY tb.IN_D_COOP
							) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
							GROUP BY COOP_INFO.ORG_ORG_ID";
							// echo print_r($sqla_count2);die();
			$temp2 = $this->db->query($sqla_count2)->result_array();

			$sqla_count3 =	"SELECT SUM(a.TOTAL_COOP)
							FROM COOP_INFO
							LEFT JOIN (
								SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) as TOTAL_COOP
								FROM (
									SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME
			     					FROM moiuser.master_data
			     					WHERE OU_D_FLAG IN (1, 2)
									AND IN_D_COOP != '0'
			     					AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER'
									AND LENGTH (moiuser.master_data.IN_D_COOP) = 13
								) tb
								GROUP BY tb.IN_D_COOP
							) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP";
			$result = $this->db->query($sqla_count3)->result_array();

			/* old from ntk
			$sqla_count1 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_ORG_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_ORG_ID";
			$temp1 = $this->db->query($sqla_count1)->result_array();

			$sqla_count2 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_ORG_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_ORG_ID";
			$temp2 = $this->db->query($sqla_count2)->result_array();

			$sqla_count3 ="select sum(a.TOTAL_COOP)
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			     from moiuser.master_data
			     where  OU_D_FLAG in (1,2) and IN_D_COOP !='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP";
			$result = $this->db->query($sqla_count3)->result_array();
			*/

			$temp_data_sum =array();
			foreach ($temp1 as $temp)
			{
				$temp_data_sum[$temp['ORG_ORG_ID']] = $temp['SUM(A.TOTAL_COOP)'];
			}
			unset($temp1);
			$sum_khet = array();

			$name_khet =array();
			$id_khet = array();
			$list_khet_id = array();
			foreach ($datas as $data)
			{



				// if($data['COL004'] == '99')
				// {
				// 	$name_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 1";
				// 	$id_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 1";
				// }else if($data['COL004'] == '99')
				// {
				// 	$name_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 2";
				// 	$id_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 2";
				// }
				// else
				// {
				// 	$name_khet[$data['COL004']] = $data['COL003'];
				// 	$id_khet[$data['COL004']] = $data['COL003'];
				// }

				if($data['COL004'] == '99')
				{
					$name_khet[$data['COL004']] = $data['COL003'];
					$id_khet[$data['COL004']] = $data['COL003'];
				}else{

					$name_khet[$data['COL004']] = $data['COL003'];
					$id_khet[$data['COL004']] = $data['COL003'];
				}

				if(!in_array($data['COL004'], $list_khet_id))
					$list_khet_id[] = $data['COL004'];

				$org_id = trim($data['COL011']);

				if(!isset($sum_khet[$data['COL004']])){
					$sum_khet[$data['COL004']] = 0;
				}

				$sum_khet[$data['COL004']] += intval($temp_data_sum[$org_id]);
			}



			//TODO
			$temp_data_sum_die =array();
			foreach ($temp2 as $temp)
			{
				$temp_data_sum_die[$temp['ORG_ORG_ID']] = $temp['SUM(A.TOTAL_COOP)'];
			}
			$sum_khet_die = array();


			foreach ($datas as $data)
			{
				$org_id = trim($data['COL011']);
				if(!isset($sum_khet_die[$data['COL004']])){
					$sum_khet_die[$data['COL004']] = 0;
				}
				if(!empty($temp_data_sum_die[$org_id])){
					$sum_khet_die[$data['COL004']] += intval($temp_data_sum_die[$org_id]);
				}

			}

			$merge_data = array();

			$sort_data_khet = Array(99,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);



			$sort_data_sum_khet = array();

			foreach ($sort_data_khet as $khet)
			{
				foreach ($sum_khet as $k=>$v)
				{
					if($khet == $k){
						$sort_data_sum_khet[$k] = $v;
					}
				}
			}

			ksort($sum_khet,1);
			sort($list_khet_id,1);
			foreach ($sort_data_sum_khet as $k=>$v)
			{
				$merge_data[$name_khet[$k]]['1'] = $v;
				$merge_data[$name_khet[$k]]['2'] = $sum_khet_die[$k];
			}


			$output = array();
			$output['khet'] = $merge_data;
			$output['list_total_type1'] = number_format($result[0]['SUM(A.TOTAL_COOP)']);
			$output['query1'] = $sqla_count1;
			$output['query2'] = $sqla_count2;
			$output['query3'] = $sqla_count3;
			$output['list_id_khet'] = $sort_data_khet;
			$output['date'] = $this->changemonth();

			$output['khetid'] = $id_khet;
			$ci->cache->save($cache_key, $output, 30000);
			print_r(json_encode($output));
			die();
//		}
//		print_r(json_encode($data_cache));

	}
		

	}

	public function ajexreport16()
	{
		// 		set_time_limit(-1);
		// 		ini_set("memory_limit", '-1');
		$cache_key = "Report316";
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));




		$data_cache = null;

		$count_data_all = array();
		// 		if ( ! $data_cache = $this->cache->get($cache_key))
			// 		{

		$temp_data = array();

		$sqla_count1 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
		";
		$temp1 = $this->db->query($sqla_count1)->result_array();

		$sqla_count2 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
		";
		$temp2 = $this->db->query($sqla_count2)->result_array();

		$sqla_count3 ="select sum(a.TOTAL_COOP)
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where  OU_D_FLAG in (1,2)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP";
		$result = $this->db->query($sqla_count3)->result_array();

		$temp_data_sum =array();
		foreach ($temp1 as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp1);

		//TODO
		$temp_data_sum_die =array();
		foreach ($temp2 as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum_die[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp2);


		$merge_data = array();
		foreach ($temp_data_sum as $k=>$v)
		{
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$merge_data[$k]['1'] = intval($v);
			$merge_data[$k]['2'] = intval($temp_data_sum_die[$k]);
		}

		$output = array();
		$output['khet'] = $merge_data;
		$output['list_total_type1'] = number_format($result[0]['SUM(A.TOTAL_COOP)']);
		$output['query1'] = $sqla_count1;
		$output['query2'] = $sqla_count2;
		$output['query3'] = $sqla_count3;
		$output['date'] = $this->changemonth();
		print_r(json_encode($output));
	}


    public function ajaxreport12()
    {
        if(canViewReport())
        {

            try {
                $userId = $this->session->userdata('auth_user_id');
                log_message('info', ' *************** ajaxreport15 userId : '.$userId.' *************** ');

                ini_set('max_execution_time', 0);
                ini_set("memory_limit", '-1');
                $ci =& get_instance();

                try {
                    $data_cache = null;

                    log_message('debug', 'begin pkg_report_mis.rpt_sum_member_st(:p_out_sum_all, :p_out_sum_eq1, :p_out_sum_eq2, :p_out_sum_gt3); end;');

                    $stmt = oci_parse($this->db->conn_id, "begin pkg_report_mis.rpt_sum_member_st(:p_out_sum_all, :p_out_sum_eq1, :p_out_sum_eq2, :p_out_sum_gt3); end;");

                    oci_bind_by_name($stmt, ":p_out_sum_all", $sumAll, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_eq1", $sumEq1, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_eq2", $sumEq2, -1, OCI_B_INT);
                    oci_bind_by_name($stmt, ":p_out_sum_gt3", $sumGt3, -1, OCI_B_INT);
                    $r = ociexecute($stmt);

                    log_message('debug',"p_out_sum_all : ".$sumAll);
                    log_message('debug',"p_out_sum_eq1 : ".$sumEq1);
                    log_message('debug',"p_out_sum_eq2 : ".$sumEq2);
                    log_message('debug',"p_out_sum_gt3 : ".$sumGt3);


                    $temp_data = array();

                    $temp_data[] = array(
                        'lable'=>'สมาชิก 2 สหกรณ์ '.number_format($sumEq2)." คน",
                        'count'=>intval($sumEq2)
                    );
                    $temp_data[] = array(
                        'lable'=>'สมาชิก 3 สหกรณ์ขึ้นไป '.number_format($sumGt3)." คน",
                        'count'=>intval($sumGt3)
                    );

                    $output = array();
                    $output['result'] = $temp_data;
                    $output['list_total_type1'] = number_format($sumAll);
                    // 			$output['all']=$count_all;
                    // $output['query1'] = $sql1;
//            $output['query2'] = $sql2;
//            $output['query3'] = $sql3;
                    $output['date'] = $this->changemonth();
                    print_r(json_encode($output));
                    die();
                }
                finally {
                    oci_close($ci);
                }

            }
            catch (Exception $e) {
                log_message('error', $e);
                print_r(json_encode($e));
                die();
            }



        }
    }


//backup 2018-12-09
//	public function ajexreport12()
//	{
//		if(canViewReport())
//		{
//
//			ini_set('max_execution_time', -1);
//			ini_set("memory_limit", "8124M");
//			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//			header("Cache-Control: post-check=0, pre-check=0", false);
//			header("Pragma: no-cache");
//
//			// $sql ="SELECT count(DISTINCT OU_D_ID) AS num from (SELECT DISTINCT OU_D_ID
//			// 		FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
//			// 		WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
//			// 		                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
//			// 		                          FROM MOIUSER.MASTER_DATA
//			// 		                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
//			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13
//			// 		                          AND OU_D_FLAG IN(1,2)
//			// 		                          GROUP BY OU_D_ID
//			// 		                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) > 0 ) S))";
//
//			$sql = "SELECT SUM(AMT) AS num FROM(
//			SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AS AMT
//					FROM MOIUSER.MASTER_DATA A
//					WHERE A.OU_D_FLAG IN(1,2)
//					AND LENGTH (A.IN_D_COOP) = 13
//					AND LENGTH (A.OU_D_ID) = 13
//					AND A.IN_D_COOP IS NOT NULL
//					GROUP BY OU_D_ID
//					HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) >1)";
//			// echo print_r($sql);die();
//			// $query3 = $this->db->query($sql)->result_array();
//
//			$cache_key_sql = md5($sql);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql = "";
//			$query3 = null;
////			if ( ! $data_cache_sql = $ci->cache->get($cache_key_sql)) {
//				$query3 = $this->db->query($sql)->result_array();
//
////				$ci->cache->save($cache_key_sql, $query3, 30000);
//				// return $query3;
////			}else{
////				$query3 = $data_cache_sql;
////			}
//
//			// $sql1 ="SELECT count(DISTINCT OU_D_ID) AS num from (SELECT DISTINCT OU_D_ID
//			// 		FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
//			// 		WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
//			// 		                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
//			// 		                          FROM MOIUSER.MASTER_DATA
//			// 		                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
//			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13
//			// 		                          AND OU_D_FLAG IN(1,2)
//			// 		                          GROUP BY OU_D_ID
//			// 		                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) = 1 ) S))";
//
//			$sql1 = "SELECT SUM(AMT) AS num FROM(
//						SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//						FROM MOIUSER.MASTER_DATA A
//						WHERE A.OU_D_FLAG IN(1,2)
//						AND LENGTH (A.IN_D_COOP) = 13
//						AND LENGTH (A.OU_D_ID) = 13
//						AND A.IN_D_COOP IS NOT NULL
//						GROUP BY OU_D_ID
//						HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) =1)";
//
//			// $result1 = $this->db->query($sql1)->result_array();
//
//			$cache_key_sql1 = md5($sql1);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql1 = "";
//			$result1 = null;
////			if ( ! $data_cache_sql1 = $ci->cache->get($cache_key_sql1)) {
//				$result1 = $this->db->query($sql1)->result_array();
//
////				$ci->cache->save($cache_key_sql1, $result1, 30000);
//				// return $result1;
////			}else{
////				$result1 = $data_cache_sql1;
////			}
//
//			// $sql2 ="SELECT count(DISTINCT OU_D_ID) AS num from (SELECT DISTINCT OU_D_ID
//			// 		FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
//			// 		WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
//			// 		                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
//			// 		                          FROM MOIUSER.MASTER_DATA
//			// 		                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
//			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13
//			// 		                          AND OU_D_FLAG IN(1,2)
//			// 		                          GROUP BY OU_D_ID
//			// 		                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) = 2 ) S))";
//
//			$sql2 = "SELECT SUM(AMT) AS num FROM(
//						SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//						FROM MOIUSER.MASTER_DATA A
//						WHERE A.OU_D_FLAG IN(1,2)
//						AND LENGTH (A.IN_D_COOP) = 13
//						AND LENGTH (A.OU_D_ID) = 13
//						AND A.IN_D_COOP IS NOT NULL
//						GROUP BY OU_D_ID
//						HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) =2)";
//
//			// $result2 = $this->db->query($sql2)->result_array();
//
//			$cache_key_sql2 = md5($sql2);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql2 = "";
//			$result2 = null;
////			if ( ! $data_cache_sql2 = $ci->cache->get($cache_key_sql2)) {
//				$result2 = $this->db->query($sql2)->result_array();
//
////				$ci->cache->save($cache_key_sql2, $result2, 30000);
//				// return $result2;
////			}else{
////				$result2 = $data_cache_sql2;
////			}
//
//			// $sql3 ="SELECT count(DISTINCT OU_D_ID) AS num from (SELECT DISTINCT OU_D_ID
//			// 		FROM MOIUSER.MASTER_DATA A LEFT OUTER JOIN ANALYTICPRD.COOP_INFO B ON (A.IN_D_COOP=B.REGISTRY_NO_2)
//			// 		WHERE A.OU_D_ID IN (SELECT S.OU_D_ID FROM (
//			// 		                          SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
//			// 		                          FROM MOIUSER.MASTER_DATA
//			// 		                          WHERE DECODE(REPLACE(TRANSLATE(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
//			// 		                          AND LENGTH (MOIUSER.MASTER_DATA.IN_D_COOP) = 13
//			// 		                          AND OU_D_FLAG IN(1,2)
//			// 		                          GROUP BY OU_D_ID
//			// 		                          HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) > 2 ) S))";
//
//			$sql3 = "SELECT SUM(AMT) AS num FROM(
//						SELECT OU_D_ID,COUNT(DISTINCT OU_D_ID||IN_D_COOP) AMT
//						FROM MOIUSER.MASTER_DATA A,ANALYTICPRD.COOP_INFO B
//						WHERE A.IN_D_COOP=B.REGISTRY_NO_2
//						AND A.OU_D_FLAG IN(1,2)
//						AND LENGTH (A.IN_D_COOP) = 13
//						AND LENGTH (A.OU_D_ID) = 13
//						AND A.IN_D_COOP IS NOT NULL
//						GROUP BY OU_D_ID
//						HAVING COUNT(DISTINCT OU_D_ID||IN_D_COOP) > 2)";
//			// $result3 = $this->db->query($sql3)->result_array();
//
//			$cache_key_sql3 = md5($sql3);
//			$ci =& get_instance();
//			$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
//			$data_cache_sql3 = "";
//			$result3 = null;
////			if ( ! $data_cache_sql3 = $ci->cache->get($cache_key_sql3)) {
//				$result3 = $this->db->query($sql3)->result_array();
//
//				$ci->cache->save($cache_key_sql3, $result3, 30000);
//				// return $result3;
////			}else{
////				$result3 = $data_cache_sql3;
////			}
//
//			$temp_data = array();
//
//			// $temp_data[] = array(
//			// 		'lable'=>'สมาชิก  1 สหกรณ์ '.number_format($result1[0]['NUM'])." คน",
//			// 		'count'=>intval($result1[0]['NUM'])
//			// );
//			$temp_data[] = array(
//					'lable'=>'สมาชิก 2 สหกรณ์ '.number_format($result2[0]['NUM'])." คน",
//					'count'=>intval($result2[0]['NUM'])
//			);
//			$temp_data[] = array(
//					'lable'=>'สมาชิก 3 สหกรณ์ขึ้นไป '.number_format($result3[0]['NUM'])." คน",
//					'count'=>intval($result3[0]['NUM'])
//			);
//
//			$output = array();
//			$output['result'] = $temp_data;
//			$output['list_total_type1'] = number_format($query3[0]['NUM']);
//			// 			$output['all']=$count_all;
//			// $output['query1'] = $sql1;
//			$output['query2'] = $sql2;
//			$output['query3'] = $sql3;
//			$output['date'] = $this->changemonth();
//			print_r(json_encode($output));
//
//		}
//	}

	public function ajexreport13()
	{
		if(canViewReport())
		{

			// 			echo $this->load->view('auth/page_header', '', TRUE);
			$khet = $this->input->get('khetID');
			$khet = intval($khet);
			$khet_lable ="";

			$div_heigth = "400px";
			$chart_heigth = "80%";

			if ($khet == 99) {
				$khet_lable = "รายงานจำนวนสมาชิกสหกรณ์ตามจังหวัดเขตพื้นที่ตรวจราชการส่วนกลาง";
			}else{
				$khet_lable = "รายงานจำนวนสมาชิกสหกรณ์ตามจังหวัดเขตพื้นที่ตรวจราชการที่  ".$khet;
			}
			

			$cache_key = "khet_$khet";


			$provices_array = getProvinceOfKhetById($khet);




			$provices_array_data =array();
			foreach ($provices_array as $provice_data)
			{
				$provices_array_data[$provice_data['COL011']] = $provice_data['COL007'];
			}

// 			if(! $data_cache = $this->cache->get($cache_key) || true)
// 			{
				set_time_limit(-1);

				$count_result =0;
				$list_data = array();
// 				if($khet !="21" && $khet !="20"){
					$province_of_khet =$this->querycount($khet);
					foreach ($province_of_khet[1] as $data)
					{
						$provivce = $provices_array_data[$data['ORG_ID']];

						if($data['ORG_ID'] == '4553')
						{
							$provivce = "กรุงเทพฯ พื้นที่ 1";

						}else if($data['ORG_ID'] =='4559')
						{
							$provivce = "กรุงเทพฯ พื้นที่ 2";
						}


						$list_data[$provivce]['1'] =!empty(intval($data['SUM(A.TOTAL_COOP)']))?intval($data['SUM(A.TOTAL_COOP)']):0;
						$count_result +=$data['SUM(A.TOTAL_COOP)'];
					}
					foreach ($province_of_khet[2] as $data)
					{
						$provivce = $provices_array_data[$data['ORG_ID']];
						$provivce = $provices_array_data[$data['ORG_ID']];

						if($data['ORG_ID'] == '4553')
						{
							$provivce = "กรุงเทพฯ พื้นที่ 1";

						}else if($data['ORG_ID'] =='4559')
						{
							$provivce = "กรุงเทพฯ พื้นที่ 2";
						}

						$list_data[$provivce]['2'] =!empty(intval($data['SUM(A.TOTAL_COOP)']))?intval($data['SUM(A.TOTAL_COOP)']):0;
						$count_result +=$data['SUM(A.TOTAL_COOP)'];
					}
// 				}
// 				else{
// 					$province_of_khet =$this->querycountBKK($khet);
// 					foreach ($province_of_khet[1] as $data)
// 					{
// 						$amphur = getAmphurByID($data['AMPHUR_ID']);
// 						$list_data[$amphur[0]['amphor_name']]['1'] =!empty(intval($data['SUM(A.TOTAL_COOP)']))?intval($data['SUM(A.TOTAL_COOP)']):0;
// 						$count_result +=$data['SUM(A.TOTAL_COOP)'];
// 					}
// 					foreach ($province_of_khet[2] as $data)
// 					{
// 						$amphur = getAmphurByID($data['AMPHUR_ID']);
// 						$list_data[$amphur[0]['amphor_name']]['2'] =!empty(intval($data['SUM(A.TOTAL_COOP)']))?intval($data['SUM(A.TOTAL_COOP)']):0;
// 						$count_result +=$data['SUM(A.TOTAL_COOP)'];
// 					}
// 				}

				// 				echo "<pre>";
				// 				print_r($list_data);
				// 				echo "</pre>";

				ksort($list_data);

				$data_all = array();
				$data_all['count_result'] = $count_result;
				$data_all['result_data'] = $list_data;
				$this->cache->save($cache_key, $data_all, 30000);
				unset($list_coop_id);
// 			}
//			$data = $this->cache->get($cache_key);
			$output = array();
			// 		echo "<pre>";print_r($result_data);echo "</pre>";
			$output['div_heigth'] = $div_heigth;
			$output['chart_heigth'] = $chart_heigth;
			$output['khet_name'] = $khet_lable;
			$output['list_total_type1'] = number_format($data_all['count_result']);
			$output['result'] = $data_all['result_data'];
			$output['date'] = $this->changemonth();
			echo json_encode($output);
			// 			echo $this->load->view('reports3/report13',$output);
			// 			echo $this->load->view('auth/page_footer', '', TRUE);
		}
	}

	public function index13()
	{
		if(canViewReport())
		{

			$khet_id = $this->input->get('khetID');
			if(!empty($khet_id) && !is_null($khet_id))
			{
				$output = array();
				$output['khetID'] = $khet_id;
				echo $this->load->view('auth/page_header', '', TRUE);
				echo $this->load->view('reports3/report13',$output);
				echo $this->load->view('auth/page_footer', '', TRUE);

			}
		}

	}


	private function querycount($khet)
	{
		$numm = array();
// 		$sqla_count = "select count(*) as num from  moiuser.master_data ";
// 		$sqla_count .=" where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE not in (1,11,13) and  IN_D_COOP in ('$where_in_str') and IN_D_COOP!='0'";
		
		
		
		
		
		$sqla_count =	"SELECT COOP_INFO.ORG_ID, SUM(a.TOTAL_COOP) 
						FROM COOP_INFO 
						LEFT JOIN ( 
							SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
							FROM ( 
								SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
			     				FROM moiuser.master_data 
			     				WHERE OU_D_FLAG IN (1, 2) 
								AND OU_D_STATUS_TYPE NOT IN (1, 11, 13) 
								AND IN_D_COOP != '0' 
			     				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
								AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
							) tb 
							GROUP BY tb.IN_D_COOP 
						) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP 
						WHERE COOP_INFO.ORG_ORG_ID IN (
							SELECT COL011 
							FROM KHET 
							WHERE COL004 = '".$khet."'
						) 
						GROUP BY COOP_INFO.ORG_ID";
		
		
		$temp1 = $this->db->query($sqla_count)->result_array();
	
		$sqla_count =	"SELECT COOP_INFO.ORG_ID, SUM(a.TOTAL_COOP) 
						FROM COOP_INFO 
						LEFT JOIN ( 
							SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
							FROM ( 
								SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
				 				FROM moiuser.master_data 
				 				WHERE OU_D_FLAG IN (1, 2) 
								AND OU_D_STATUS_TYPE IN (1, 11, 13) 
								AND IN_D_COOP != '0' 
				 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
								AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
							) tb 
							GROUP BY tb.IN_D_COOP 
						) a ON COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP 
						WHERE COOP_INFO.ORG_ORG_ID IN (
							SELECT COL011 
							FROM KHET 
							WHERE COL004 = '".$khet."'
						) 
						GROUP BY COOP_INFO.ORG_ID";
		/*
		$sqla_count ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where COOP_INFO.ORG_ORG_ID in (select COL011 from KHET where COL004 ='".$khet."') GROUP by COOP_INFO.ORG_ID";


		$temp1 = $this->db->query($sqla_count)->result_array();

		$sqla_count ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where COOP_INFO.ORG_ORG_ID in (select COL011 from KHET where COL004 ='".$khet."') GROUP by COOP_INFO.ORG_ID";


		*/
		$temp2 = $this->db->query($sqla_count)->result_array();
		$numm['1']=$temp1;
		$numm['2']=$temp2;
		$numm['query2'] = $sqla_count;
		return $numm;
	}
	private function querycountBKK($khet)
	{
		$numm = array();
		// 		$sqla_count = "select count(*) as num from  moiuser.master_data ";
		// 		$sqla_count .=" where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE not in (1,11,13) and  IN_D_COOP in ('$where_in_str') and IN_D_COOP!='0'";





		$sqla_count ="select sum(a.TOTAL_COOP),COOP_INFO.AMPHUR_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where COOP_INFO.ORG_ORG_ID in (select COL011 from KHET where COL004 ='".$khet."') GROUP by COOP_INFO.AMPHUR_ID";


		$temp1 = $this->db->query($sqla_count)->result_array();

		$sqla_count ="select sum(a.TOTAL_COOP),COOP_INFO.AMPHUR_ID
			from COOP_INFO
			left join (
			     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
			     from moiuser.master_data
			     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13) and IN_D_COOP!='0'
			     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13
			) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP where COOP_INFO.ORG_ORG_ID in (select COL011 from KHET where COL004 ='".$khet."') GROUP by COOP_INFO.AMPHUR_ID";



		$temp2 = $this->db->query($sqla_count)->result_array();
		$numm['1']=$temp1;
		$numm['2']=$temp2;
		$numm['query2'] = $sqla_count;
		return $numm;
	}

	public function index14()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);
			$type_coop= isset($_GET['type_coop'])? trim($_GET['type_coop']): "0";
			$output = array(
					'type_coop' => $type_coop,
			);
			echo $this->load->view('reports3/report14', $output, TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function index17()
	{
		// 		set_time_limit(-1);
		// 		ini_set("memory_limit", '-1');


		echo $this->load->view('auth/page_header', '', TRUE);

		// $result = $this->queryreport17();

		// $output = array();
		// $output['khet'] =json_encode($result);
// 		$output['list_total_type1'] = $result[0]['SUM(A.TOTAL_COOP)'];

		echo $this->load->view('reports3/report17','', TRUE);

		echo $this->load->view('auth/page_footer', '', TRUE);

	}

	public function queryreport17 ()
	{

		$cache_key = "Report317excell";
		$ci =& get_instance();
		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$data_cache = null;

		$count_data_all = array();

//				if ( ! $data_cache = $ci->cache->get($cache_key))
//				{
		$temp_data = array();
		
		$sqla_count1 =	"SELECT COOP_INFO.ORG_NAME, SUM(a.TOTAL_COOP) 
						FROM COOP_INFO 
						LEFT JOIN ( 
		  					SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
		  					FROM ( 
			  					SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
				 				FROM moiuser.master_data 
				 				WHERE OU_D_FLAG IN (1, 2) 
			  					AND OU_D_STATUS_TYPE NOT IN (1, 11, 13) 
				 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
			  					AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
		  					) tb
		  					GROUP BY tb.IN_D_COOP 
						) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
	  					GROUP BY COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
						ORDER BY COOP_INFO.ORG_ID";
		$temp1 = $this->db->query($sqla_count1)->result_array();
		
		$sqla_count2 =	"SELECT COOP_INFO.ORG_NAME, SUM(a.TOTAL_COOP) 
						FROM COOP_INFO 
						LEFT JOIN ( 
			  				SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) AS TOTAL_COOP 
			  				FROM ( 
				  				SELECT DISTINCT IN_D_COOP, OU_D_ID, OU_D_PNAME, OU_D_SNAME, OU_D_STATUS_TYPE, IN_PROVICE_NAME 
				 				FROM moiuser.master_data 
				 				WHERE OU_D_FLAG IN (1, 2) 
				  				AND OU_D_STATUS_TYPE IN (1, 11, 13) 
				 				AND DECODE(REPLACE(TRANSLATE(IN_D_COOP, '1234567890', '##########'), '#'), NULL, 'NUMBER', 'NON NUMER') = 'NUMBER' 
				  				AND LENGTH (moiuser.master_data.IN_D_COOP) = 13 
			  				) tb
			  				GROUP BY tb.IN_D_COOP 
						) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
		  				GROUP BY COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
						ORDER BY COOP_INFO.ORG_ID";
		$temp2 = $this->db->query($sqla_count2)->result_array();

		$sqla_count3 ="SELECT COL004, COL003, COL007 FROM KHET ORDER BY ABS(COL004), COL007";
		$result = $this->db->query($sqla_count3)->result_array();
		/*

		$sqla_count1 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
		";
		$temp1 = $this->db->query($sqla_count1)->result_array();

		$sqla_count2 ="select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
		";
		$temp2 = $this->db->query($sqla_count2)->result_array();

		$sqla_count3 ="select COL004,COL003,COL007 from KHET order by ABS(COL004) ,COL007";
		*/


		$temp_data_sum =array();
		foreach ($temp1 as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp1);

		//TODO
		$temp_data_sum_die =array();
		foreach ($temp2 as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum_die[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp2);


		$merge_data = array();
		$total_normal = 0;
		$total_die = 0;
		foreach ($temp_data_sum as $k=>$v)
		{
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$merge_data[$k]['1'] = intval($v);

			$merge_data[$k]['2'] = intval($temp_data_sum_die[$k]);
			$total_normal = $total_normal+intval($v);
			$total_die = $total_die+intval($temp_data_sum_die[$k]);
		}
		$merge_data['ยอดรวม']['1'] = $total_normal;
		$merge_data['ยอดรวม']['2'] = $total_die;

		$sort_data_khet = Array(99,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
		$final_data= array();
		$final_data['กรุงเทพฯ พื้นที่ 1'] =  $merge_data['กรุงเทพฯ พื้นที่ 1'];
		$final_data['กรุงเทพฯ พื้นที่ 2'] =  $merge_data['กรุงเทพฯ พื้นที่ 2'];
		foreach ($sort_data_khet as $khet){


			foreach ($result as $temp){

				$k = $temp['COL007'];
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

				if($temp['COL004'] == $khet)
				{
					
					if ($khet == 99) {
						$final_data[$k] = $merge_data[$k];
						$final_data[$k][] = "ส่วนกลาง";
					}else{
						$final_data[$k] = $merge_data[$k];
						$final_data[$k][] = $khet;
					}

				}

			}
		}

		$final_data['ยอดรวม']['1']= $merge_data['ยอดรวม']['1'];
		$final_data['ยอดรวม']['2']= $merge_data['ยอดรวม']['2'];
		$final_data['ยอดรวม']['3']= "";

		$ci->cache->save($cache_key, $final_data, 30000);

		return $final_data;

//		}

//		return $data_cache;


	}


	public function index1()
	{

		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);

			echo $this->load->view('reports3/report1', '', TRUE);

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

			echo $this->load->view('reports3/report2', '', TRUE);

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

			echo $this->load->view('reports3/report3', '', TRUE);

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

			echo $this->load->view('reports3/report6', '', TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function index16()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);

			echo $this->load->view('reports3/report16', '', TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function index12()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);

			echo $this->load->view('reports3/report12', '', TRUE);

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

			echo $this->load->view('reports3/report5', '', TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function index15()
	{
		if(canViewReport())
		{
			echo $this->load->view('auth/page_header', '', TRUE);

			echo $this->load->view('reports3/report15', '', TRUE);

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
			echo $this->load->view('auth/page_header', '', TRUE);

			echo $this->load->view('reports3/report10', '', TRUE);

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

			echo $this->load->view('reports3/report11', '', TRUE);

			echo $this->load->view('auth/page_footer', '', TRUE);
		}
		else {
			redirect('/', 'refresh');
		}
	}
	public function exportdatacsvreport()
	{

		ob_start();
		// 		print_graph($data);
		$data = array();
		$filename = "รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด";

		$data_khet = $this->queryreport17();
		$date = $this->changemonth();
		$header_excel = array('','','','','','',$date);
		$data[] = $header_excel;
		$header_excel = array('รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด');
		$data[] = $header_excel;
		$header_excel = array('เขตตรวจราชการ','จังหวัด','จำนวนสมาชิกปกติ','จำนวนสมาชิกตาย');
		$data[] = $header_excel;

		$colspan =4;
		$temp_row = null;
		$colspan_array = array();
// 		$colspan_array[] = 3;

		foreach ($data_khet as $key=>$rows) {

			if($rows['3'] != $temp_row && !empty($rows['3']) && $rows['3'] !="")
			{
				$temp_row=$rows['3'];
				$colspan_array[] = $colspan;
				if(sizeof($colspan_array)>1){
					$colspan_array[] = $colspan+1;
				}
			}else if($rows['3'] != $temp_row && empty($rows['3']) && $rows['3'] ==""){
				$temp_row=$rows['3'];
				$colspan_array[] = $colspan;
				if(sizeof($colspan_array)>1){
					$last_array = sizeof($colspan_array)-1;
					$colspan_array[$last_array] = $colspan-1;
				}
			}

			$temp= array();

			$temp[]	=  $rows['3'];
			$temp[]	=  $key;
			$temp[]	=  $rows['1'];
			$temp[]	=  $rows['2'];
			$data[] = $temp;
			$colspan++;
		}

		$temp_merge = array();

		$temp_merge[0] = "A4:A5";
		$temp_merge[1] = "A6:A11";
		$temp_merge[2] = "A12:A15";
		$temp_merge[3] = "A16:A18";
		$temp_merge[4] = "A19:A22";
		$temp_merge[5] = "A23:A27";
		$temp_merge[6] = "A28:A33";
		$temp_merge[7] = "A34:A36";
		$temp_merge[8] = "A37:A39";
		$temp_merge[9] = "A40:A44";
		$temp_merge[10] = "A45:A49";
		$temp_merge[11] = "A50:A52";
		$temp_merge[12] = "A53:A56";
		$temp_merge[13] = "A57:A60";
		$temp_merge[14] = "A61:A64";
		$temp_merge[15] = "A65:A68";
		$temp_merge[16] = "A69:A72";
		$temp_merge[17] = "A73:A77";
		$temp_merge[18] = "A78:A81";

		$countRow = sizeof($data);
		$strFilds1 = 'C3:C'.$countRow;
		$strFilds2 = 'D3:D'.$countRow;
		$strFilds3 = 'A4:A'.$countRow;
		$spreadsheet = new Spreadsheet();

		$spreadsheet->getActiveSheet()->fromArray($data)->getStyle($strFilds1)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED);;
		$spreadsheet->getActiveSheet()->fromArray($data)->getStyle($strFilds2)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED);;
		$spreadsheet->getActiveSheet()->mergeCells('A82:B82');
		$spreadsheet->getActiveSheet()->setCellValue('A82','ยอดรวม');
		if(!empty($temp_merge))
		foreach ($temp_merge as $data_merge)
			$spreadsheet->getActiveSheet()->mergeCells($data_merge);

			$spreadsheet->getActiveSheet()->getStyle($strFilds3)->getAlignment()->applyFromArray(['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,]);


		// 		$writer = new Xlsx($spreadsheet);
		// 		$writer->save('php://output');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด.xlsx"');
		$writer->save("php://output");
	}
	public function ajexreport17() {

		  ini_set('max_execution_time', 0);
		  ini_set("memory_limit", '-1');
		$cache_key = "Report317";
		$ci =& get_instance();
		$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$data_cache = null;

		$count_data_all = array();
//		if ( ! $data_cache = $ci->cache->get($cache_key)) {

		$temp_data = array();
		
		$sqla_count1 =	"SELECT COOP_INFO.ORG_NAME, SUM(a.TOTAL_COOP) 
		  				FROM COOP_INFO 
		  				LEFT JOIN ( 
							SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) AS TOTAL_COOP 
							FROM ( 
								SELECT OU_D_ID,IN_D_COOP,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
                                FROM MOIUSER.MASTER_DATA A
                                WHERE A.OU_D_FLAG IN(1,2)
                                AND LENGTH (A.IN_D_COOP) = 13
                                AND OU_D_STATUS_TYPE NOT IN (1, 11, 13)
                                AND LENGTH (A.OU_D_ID) = 13
                                AND A.IN_D_COOP IS NOT NULL
                                AND A.OU_D_ID IS NOT NULL
                                GROUP BY OU_D_ID,IN_D_COOP
							) tb
							GROUP BY tb.IN_D_COOP 
		  				) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
						GROUP BY COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		  				ORDER BY COOP_INFO.ORG_ID";
		$temp1 = $this->db->query($sqla_count1)->result_array();
		
		$sqla_count2 =	"SELECT COOP_INFO.ORG_NAME, SUM(a.TOTAL_COOP) 
		  				FROM COOP_INFO 
		  				LEFT JOIN ( 
							SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) AS TOTAL_COOP 
							FROM ( 
								SELECT OU_D_ID,IN_D_COOP,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
                                FROM MOIUSER.MASTER_DATA A
                                WHERE A.OU_D_FLAG IN(1,2)
                                AND LENGTH (A.IN_D_COOP) = 13
                                AND OU_D_STATUS_TYPE IN (1, 11, 13)
                                AND LENGTH (A.OU_D_ID) = 13
                                AND A.OU_D_ID IS NOT NULL
                                AND A.IN_D_COOP IS NOT NULL
                                GROUP BY OU_D_ID,IN_D_COOP
							) tb
							GROUP BY tb.IN_D_COOP 
		  				) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
						GROUP BY COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		  				ORDER BY COOP_INFO.ORG_ID";
		$temp2 = $this->db->query($sqla_count2)->result_array();

		$sqla_all =	"SELECT COOP_INFO.ORG_NAME, SUM(a.TOTAL_COOP) 
		  				FROM COOP_INFO 
		  				LEFT JOIN ( 
							SELECT tb.IN_D_COOP, COUNT(DISTINCT tb.OU_D_ID||tb.IN_D_COOP) AS TOTAL_COOP 
							FROM ( 
								SELECT OU_D_ID,IN_D_COOP,COUNT(DISTINCT OU_D_ID||IN_D_COOP)
                                FROM MOIUSER.MASTER_DATA A
                                WHERE A.OU_D_FLAG IN(1,2)
                                AND LENGTH (A.IN_D_COOP) = 13
                                AND LENGTH (A.OU_D_ID) = 13
                                AND A.OU_D_ID IS NOT NULL
                                AND A.IN_D_COOP IS NOT NULL
                                GROUP BY OU_D_ID,IN_D_COOP
							) tb
							GROUP BY tb.IN_D_COOP 
		  				) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
						GROUP BY COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		  				ORDER BY COOP_INFO.ORG_ID";
		$temp_all = $this->db->query($sqla_all)->result_array();
		
		$sqla_count3 ="SELECT COL004, COL003, COL007 FROM KHET ORDER BY ABS(COL004), COL007";
		$result = $this->db->query($sqla_count3)->result_array();

		$temp_data_sum =array();
		// echo print_r($temp1);die();
		foreach ($temp1 as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp1);

		//TODO
		$temp_data_sum_die =array();
		foreach ($temp_all as $temp)
		{
			$k = $temp['ORG_NAME'];
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$temp_data_sum_die[$k] = $temp['SUM(A.TOTAL_COOP)'];
		}
		unset($temp2);
		$total_normal = 0;
		$total_die = 0;
		$merge_data = array();
		// echo print_r($temp_data_sum);die();
		foreach ($temp_data_sum as $k=>$v)
		{
			$k = str_replace("สำนักงานสหกรณ์จังหวัด", "", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
			$k = str_replace("สำนักงานส่งเสริมสหกรณ์ พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);

			$merge_data[$k]['1'] = intval($v);
			$merge_data[$k]['2'] = intval($temp_data_sum_die[$k])-intval($v);
			$total_normal = $total_normal+intval($v);
			$total_die = $total_die+(intval($temp_data_sum_die[$k])-intval($v));
		}

		// echo print_r($merge_data);die();


		$merge_data['ยอดรวม']['1'] = $total_normal;
		$merge_data['ยอดรวม']['2'] = $total_die;


		$sort_data_khet = Array(99,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
		$final_data= array();

		$final_data['กรุงเทพฯ พื้นที่ 1'] =  $merge_data['กรุงเทพฯ พื้นที่ 1'];
		$final_data['กรุงเทพฯ พื้นที่ 1'][] = 1;
		$final_data['กรุงเทพฯ พื้นที่ 2'] =  $merge_data['กรุงเทพฯ พื้นที่ 2'];
		$final_data['กรุงเทพฯ พื้นที่ 2'][] = 2;
		// echo "<pre>";
		// print_r($result);
		// exit();
		foreach ($sort_data_khet as $khet){

		// echo print_r($khet);die();

			foreach ($result as $temp){

				$k = $temp['COL007'];
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);



				if($temp['COL004'] == $khet)
				{
					if ($khet == 99) {
						$final_data[$k] = $merge_data[$k];
						$final_data[$k][] = "ส่วนกลาง"." ";
					}else{
						$final_data[$k] = $merge_data[$k];
						$final_data[$k][] = $khet."";
					}
					
				}

			}
		}



		$final_data['ยอดรวม']['1']= $merge_data['ยอดรวม']['1'];
		$final_data['ยอดรวม']['2']= $merge_data['ยอดรวม']['2'];
		$final_data['ยอดรวม']['3']= null;


		$output = array();
		$output['khet'] = $final_data;

		// echo print_r($final_data);die();



		$output['list_total'] = $total_normal+$total_die;
		$output['query1'] = $sqla_count1;
		$output['query2'] = $sqla_count2;
		$output['date'] = $this->changemonth();
		$output['query3'] = $sqla_count3;
		// echo print_r($output);die();

//        $ci->cache->save($cache_key, $output, 30000);
				// return $to_return;
		print_r(json_encode($output));
		die();
//	}
	

//		print_r(json_encode($data_cache));

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
}
