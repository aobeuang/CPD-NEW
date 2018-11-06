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
			$data = getTotalCoopReport();
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

			foreach ($data as $item)
			{
				if(!isset($list_type[$item['ORG_NAME']]))
				{
					$list_type[$item['ORG_NAME']]['1'] =0;
					$list_type[$item['ORG_NAME']]['2'] =0;
					$list_type[$item['ORG_NAME']]['3'] =0;
					$list_type[$item['ORG_NAME']]['4'] =0;
					$list_type[$item['ORG_NAME']]['5'] =0;
					$list_type[$item['ORG_NAME']]['6'] =0;
					$list_type[$item['ORG_NAME']]['7'] =0;
				}
				if($item['COOP_TYPE'] == '1')
				{
					$list_type[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['1'];
					$list_type_in_1 = $list_type_in_1+$list_type[$item['ORG_NAME']]['1'];
				}
				if($item['COOP_TYPE'] == '2')
				{
					$list_type[$item['ORG_NAME']]['2']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['2'];
					$list_type_in_2 = $list_type_in_2+$list_type[$item['ORG_NAME']]['2'];
				}
				if($item['COOP_TYPE'] == '3')
				{
					$list_type[$item['ORG_NAME']]['3']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['3'];
					$list_type_in_3 = $list_type_in_3+$list_type[$item['ORG_NAME']]['3'];
				}
				if($item['COOP_TYPE'] == '4')
				{
					$list_type[$item['ORG_NAME']]['4']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['4'];
					$list_type_out_4= $list_type_out_4+$list_type[$item['ORG_NAME']]['4'];
				}
				if($item['COOP_TYPE'] == '5')
				{
					$list_type[$item['ORG_NAME']]['5']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['5'];
					$list_type_out_5= $list_type_out_5+$list_type[$item['ORG_NAME']]['5'];
				}
				if($item['COOP_TYPE'] == '6')
				{
					$list_type[$item['ORG_NAME']]['6']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['6'];
					$list_type_out_6 = $list_type_out_6+$list_type[$item['ORG_NAME']]['6'];
				}
				if($item['COOP_TYPE'] == '7')
				{
					$list_type[$item['ORG_NAME']]['7']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['7'];
					$list_type_out_7 = $list_type_out_7+$list_type[$item['ORG_NAME']]['7'];
				}
			}




			$list_total[] =  array('name'=>'ภาคเกษตร '.number_format($list_total_type1).' คน','value'=> $list_total_type1);
			$list_total[] =  array('name'=>'นอกภาคเกษตร '.number_format($list_total_type2).' คน','value'=> $list_total_type2);


			$list_type_in_out[] =  array('name'=>'สหกรณ์การเกษตร '.number_format($list_type_in_1).' คน','value'=> $list_type_in_1);
			$list_type_in_out[] =  array('name'=>'สหกรณ์ประมง '.number_format($list_type_in_2).' คน','value'=> $list_type_in_2);
			$list_type_in_out[] =  array('name'=>'สหกรณ์นิคม '.number_format($list_type_in_3).' คน','value'=> $list_type_in_3);
			$list_type_in_out[] =  array('name'=>'สหกรณ์ออมทรัพย์ '.number_format($list_type_out_4).' คน','value'=> $list_type_out_4);
			$list_type_in_out[] =  array('name'=>'สหกรณ์ร้านค้า '.number_format($list_type_out_5).' คน','value'=> $list_type_out_5);
			$list_type_in_out[] =  array('name'=>'สหกรณ์บริการ '.number_format($list_type_out_6).' คน','value'=> $list_type_out_6);
			$list_type_in_out[] =  array('name'=>'สหกรณ์เครดิตยูเนี่ยน '.number_format($list_type_out_7).' คน','value'=> $list_type_out_7);


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

			$data = getTotalCoopReport();
			$list_type1 = array();
			$list_total_type1 = 0;


			$list_type_in_1 = 0;
			$list_type_in_2 = 0;
			$list_type_in_3 = 0;

			$list_type_in_out = array();
			foreach ($data as $item)
			{
				if(!isset($list_type[$item['ORG_NAME']]))
				{
					$list_type[$item['ORG_NAME']]['1'] =0;
					$list_type[$item['ORG_NAME']]['2'] =0;
					$list_type[$item['ORG_NAME']]['3'] =0;
					$list_type[$item['ORG_NAME']]['4'] =0;
					$list_type[$item['ORG_NAME']]['5'] =0;
					$list_type[$item['ORG_NAME']]['6'] =0;
					$list_type[$item['ORG_NAME']]['7'] =0;
				}
				if($item['COOP_TYPE'] == '1')
				{
					$list_type[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['1'];
					$list_type_in_1 = $list_type_in_1+$list_type[$item['ORG_NAME']]['1'];
				}
				if($item['COOP_TYPE'] == '2')
				{
					$list_type[$item['ORG_NAME']]['2']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['2'];
					$list_type_in_2 = $list_type_in_2+$list_type[$item['ORG_NAME']]['2'];
				}
				if($item['COOP_TYPE'] == '3')
				{
					$list_type[$item['ORG_NAME']]['3']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type1 = $list_total_type1+$list_type[$item['ORG_NAME']]['3'];
					$list_type_in_3 = $list_type_in_3+$list_type[$item['ORG_NAME']]['3'];
				}

			}

			$list_type_in_out[] =  array('name'=>'สหกรณ์การเกษตร '.number_format($list_type_in_1).' คน','value'=> $list_type_in_1);
			$list_type_in_out[] =  array('name'=>'สหกรณ์ประมง '.number_format($list_type_in_2).' คน','value'=> $list_type_in_2);
			$list_type_in_out[] =  array('name'=>'สหกรณ์นิคม '.number_format($list_type_in_3).' คน','value'=> $list_type_in_3);



			$output = array();

			$output['list_total'] = $list_total_type1;
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


			$data = getTotalCoopReport();
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
			foreach ($data as $item)
			{
				if(!isset($list_type[$item['ORG_NAME']]))
				{
					$list_type[$item['ORG_NAME']]['1'] =0;
					$list_type[$item['ORG_NAME']]['2'] =0;
					$list_type[$item['ORG_NAME']]['3'] =0;
					$list_type[$item['ORG_NAME']]['4'] =0;
					$list_type[$item['ORG_NAME']]['5'] =0;
					$list_type[$item['ORG_NAME']]['6'] =0;
					$list_type[$item['ORG_NAME']]['7'] =0;
				}

				if($item['COOP_TYPE'] == '4')
				{
					$list_type[$item['ORG_NAME']]['4']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['4'];
					$list_type_out_4= $list_type_out_4+$list_type[$item['ORG_NAME']]['4'];
				}
				if($item['COOP_TYPE'] == '5')
				{
					$list_type[$item['ORG_NAME']]['5']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['5'];
					$list_type_out_5= $list_type_out_5+$list_type[$item['ORG_NAME']]['5'];
				}
				if($item['COOP_TYPE'] == '6')
				{
					$list_type[$item['ORG_NAME']]['6']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['6'];
					$list_type_out_6 = $list_type_out_6+$list_type[$item['ORG_NAME']]['6'];
				}
				if($item['COOP_TYPE'] == '7')
				{
					$list_type[$item['ORG_NAME']]['7']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					$list_total_type2 = $list_total_type2+$list_type[$item['ORG_NAME']]['7'];
					$list_type_out_7 = $list_type_out_7+$list_type[$item['ORG_NAME']]['7'];
				}
			}


			$list_type_in_out[] =  array('name'=>'สหกรณ์ออมทรัพย์ '.number_format($list_type_out_4).' คน','value'=> $list_type_out_4);
			$list_type_in_out[] =  array('name'=>'สหกรณ์ร้านค้า '.number_format($list_type_out_5).' คน','value'=> $list_type_out_5);
			$list_type_in_out[] =  array('name'=>'สหกรณ์บริการ '.number_format($list_type_out_6).' คน','value'=> $list_type_out_6);
			$list_type_in_out[] =  array('name'=>'สหกรณ์เครดิตยูเนี่ยน '.number_format($list_type_out_7).' คน','value'=> $list_type_out_7);


			$output = array();

			$output['list_in_out'] = $list_type_in_out;
			$output['list_total'] = $list_total_type2;
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
	public function ajexreport5()
	{
		if(canViewReport())
		{


			$sql ="select count(OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE  in (1,11,13) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";


			$query = $this->db->query($sql)->result_array();
			$sql2 ="select count(DISTINCT OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE  not in (1,11,13) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			$query2 = $this->db->query($sql2)->result_array();



			$sql3 ="select count(DISTINCT OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			$query3 = $this->db->query($sql3)->result_array();



			$temp_data = array();

			$temp_data[] = array(
					'lable'=>'ปกติ  จำนวน '.number_format($query2[0]['NUM'])." คน",
					'count'=>intval($query2[0]['NUM'])
			);
			$temp_data[] = array(
					'lable'=>'ตาย จำนวน '.number_format($query[0]['NUM'])." คน",
					'count'=>intval($query[0]['NUM'])
			);

			$output = array();
			$output['result'] = $temp_data;
			$output['list_total_type1'] = number_format($query3[0]['NUM']);
// 			$output['all']=$count_all;
			$output['query1'] = $sql;
			$output['query2'] = $sql2;
			$output['query3'] = $sql3;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));
		}
	}

	public function ajexreport15()
	{
		if(canViewReport())
		{

			$sql ="select count(OU_D_ID) as num from moiuser.master_data where OU_D_FLAG in(1,2)  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13 and OU_D_STATUS_TYPE   in (1,11,13)";



			$query = $this->db->query($sql)->result_array();
			$sql2 ="select count(OU_D_ID) as num  from moiuser.master_data where  OU_D_FLAG in(1,2)  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13 and OU_D_STATUS_TYPE  not in (1,11,13)";
			$query2 = $this->db->query($sql2)->result_array();


			$sql3 ="select count(OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			$query3 = $this->db->query($sql3)->result_array();



			$temp_data = array();

			$temp_data[] = array(
					'lable'=>'ปกติ  จำนวน '.number_format($query2[0]['NUM'])." คน",
					'count'=>intval($query2[0]['NUM'])
			);
			$temp_data[] = array(
					'lable'=>'ตาย จำนวน '.number_format($query[0]['NUM'])." คน",
					'count'=>intval($query[0]['NUM'])
			);

			$output = array();
			$output['result'] = $temp_data;
			$output['list_total_type1'] = number_format($query3[0]['NUM']);
			// 			$output['all']=$count_all;
			$output['query1'] = $sql;
			$output['query2'] = $sql2;
			$output['query3'] = $sql3;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));

		}
	}

	public function ajexreport6 ()
	{


		if(canViewReport())
		{
			$cache_key = "Report36";
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));


			$data_cache = null;

			$count_data_all = array();
	// 		if ( ! $data_cache = $this->cache->get($cache_key))
	// 		{
	// 		$this->db->distinct('COL001');
			$query = $this->db->get($this->db->dbprefix('KHET'));
			$datas = $query->result_array();
			$temp_data = array();

			$sqla_count1 =	"SELECT COOP_INFO.ORG_ORG_ID, SUM(a.TOTAL_COOP)
							FROM COOP_INFO
							LEFT JOIN (
				 				SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) as TOTAL_COOP
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
								SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) as TOTAL_COOP
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
			$temp2 = $this->db->query($sqla_count2)->result_array();

			$sqla_count3 =	"SELECT SUM(a.TOTAL_COOP)
							FROM COOP_INFO
							LEFT JOIN (
								SELECT tb.IN_D_COOP, COUNT(tb.OU_D_ID) as TOTAL_COOP
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



				if($data['COL004'] == '20')
				{
					$name_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 1";
					$id_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 1";
				}else if($data['COL004'] == '21')
				{
					$name_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 2";
					$id_khet[$data['COL004']] = "กรุงเทพฯ พื้นที่ 2";
				}
				else
				{
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

			$sort_data_khet = Array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);



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

			print_r(json_encode($output));

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

	public function ajexreport12()
	{
		if(canViewReport())
		{



			$sql ="select count(OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			$query3 = $this->db->query($sql)->result_array();

			$sql1 ="select  count(OU_D_ID) as num from moiuser.master_data where OU_D_FLAG in(1,2) and  NUMBER_OF_COOP =1 and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13 ";
			$result1 = $this->db->query($sql1)->result_array();

			$sql2 ="select  count(OU_D_ID) as num from moiuser.master_data where OU_D_FLAG in(1,2) and  NUMBER_OF_COOP =2 and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13 ";
			$result2 = $this->db->query($sql2)->result_array();

			$sql3 ="select  count(OU_D_ID) as num from moiuser.master_data where OU_D_FLAG in(1,2) and  NUMBER_OF_COOP >2 and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13 ";
			$result3 = $this->db->query($sql3)->result_array();

			$temp_data = array();

			$temp_data[] = array(
					'lable'=>'สมาชิก  1 สหกรณ์ '.number_format($result1[0]['NUM'])." คน",
					'count'=>intval($result1[0]['NUM'])
			);
			$temp_data[] = array(
					'lable'=>'สมาชิก 2 สหกรณ์ '.number_format($result2[0]['NUM'])." คน",
					'count'=>intval($result2[0]['NUM'])
			);
			$temp_data[] = array(
					'lable'=>'สมาชิก 3 สหกรณ์ขึ้นไป '.number_format($result3[0]['NUM'])." คน",
					'count'=>intval($result3[0]['NUM'])
			);

			$output = array();
			$output['result'] = $temp_data;
			$output['list_total_type1'] = number_format($query3[0]['NUM']);
			// 			$output['all']=$count_all;
			$output['query1'] = $sql1;
			$output['query2'] = $sql2;
			$output['query3'] = $sql3;
			$output['date'] = $this->changemonth();
			print_r(json_encode($output));

		}
	}

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


			$khet_lable = "รายงานจำนวนสมาชิกสหกรณ์ตามจังหวัดเขตพื้นที่ตรวจราชการที่  ".$khet;

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
			$data = $this->cache->get($cache_key);
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

		$result = $this->queryreport17();

		$output = array();
		$output['khet'] =json_encode($result);
// 		$output['list_total_type1'] = $result[0]['SUM(A.TOTAL_COOP)'];

		echo $this->load->view('reports3/report17',$output);

		echo $this->load->view('auth/page_footer', '', TRUE);

	}

	public function queryreport17 ()
	{

		$cache_key = "Report317";
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$data_cache = null;

		$count_data_all = array();

		// 		if ( ! $data_cache = $this->cache->get($cache_key))
		// 		{
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

		$sort_data_khet = Array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
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
					$final_data[$k] = $merge_data[$k];
					$final_data[$k][] = $khet;
				}

			}
		}

		$final_data['ยอดรวม']['1']= $merge_data['ยอดรวม']['1'];
		$final_data['ยอดรวม']['2']= $merge_data['ยอดรวม']['2'];
		$final_data['ยอดรวม']['3']= "";
		return $final_data;
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

		$temp_merge[0] = "A4:A9";
		$temp_merge[1] = "A10:A13";
		$temp_merge[2] = "A14:A18";
		$temp_merge[3] = "A19:A22";
		$temp_merge[4] = "A23:A26";
		$temp_merge[5] = "A27:A30";
		$temp_merge[6] = "A31:A35";
		$temp_merge[7] = "A36:A40";
		$temp_merge[8] = "A41:A44";
		$temp_merge[9] = "A45:A49";
		$temp_merge[10] = "A50:A52";
		$temp_merge[11] = "A53:A56";
		$temp_merge[12] = "A57:A60";
		$temp_merge[13] = "A61:A64";
		$temp_merge[14] = "A65:A68";
		$temp_merge[15] = "A69:A72";
		$temp_merge[16] = "A73:A77";
		$temp_merge[17] = "A78:A81";

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
	public function ajexreport17()
	{
		//   set_time_limit(-1);
		//   ini_set("memory_limit", '-1');
		$cache_key = "Report317";
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$data_cache = null;

		$count_data_all = array();
		//   if ( ! $data_cache = $this->cache->get($cache_key))
		//   {

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
		$total_normal = 0;
		$total_die = 0;
		$merge_data = array();
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


		$sort_data_khet = Array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
		$final_data= array();

		$final_data['กรุงเทพฯ พื้นที่ 1'] =  $merge_data['กรุงเทพฯ พื้นที่ 1'];
		$final_data['กรุงเทพฯ พื้นที่ 1'][] = 1;
		$final_data['กรุงเทพฯ พื้นที่ 2'] =  $merge_data['กรุงเทพฯ พื้นที่ 2'];
		$final_data['กรุงเทพฯ พื้นที่ 2'][] = 2;
// 		echo "<pre>";
// 		print_r($final_data);
// 		exit();
		foreach ($sort_data_khet as $khet){


			foreach ($result as $temp){

				$k = $temp['COL007'];
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 1", "กรุงเทพฯ พื้นที่ 1", $k);
				$k = str_replace("สำนักงานส่งเสริมสหกรณ์กรุงเทพมหานคร พื้นที่ 2", "กรุงเทพฯ พื้นที่ 2", $k);



				if($temp['COL004'] == $khet)
				{
					$final_data[$k] = $merge_data[$k];
					$final_data[$k][] = $khet."";
				}

			}
		}



		$final_data['ยอดรวม']['1']= $merge_data['ยอดรวม']['1'];
		$final_data['ยอดรวม']['2']= $merge_data['ยอดรวม']['2'];
		$final_data['ยอดรวม']['3']= null;


		$output = array();
		$output['khet'] = $final_data;



		$output['list_total'] = $total_normal+$total_die;
		$output['query1'] = $sqla_count1;
		$output['query2'] = $sqla_count2;
		$output['date'] = $this->changemonth();
// 		$output['query3'] = $sqla_count3;
		print_r(json_encode($output));

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