<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Report4 extends MY_Controller {
    
    
    public function __construct()
    {
        parent::__construct();
        //include(APPPATH."third_party/mpdf/mpdf.php");
//        $this->load->database("defaultext", true);
//         $dbext = $this->load->database("defaultext", true);
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
    
    public function index1()
    {
        
        if(canViewReport())
        {
            echo $this->load->view('auth/page_header', '', TRUE);
            
            echo $this->load->view('reports4/report1', '', TRUE);
            
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
            
            echo $this->load->view('reports4/report2', '', TRUE);
            
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
            
            echo $this->load->view('reports4/report4', '', TRUE);
            
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
            
            echo $this->load->view('reports4/report5', '', TRUE);
            
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
            
            echo $this->load->view('reports4/report6', '', TRUE);
            
            echo $this->load->view('auth/page_footer', '', TRUE);
        }
        else {
            redirect('/', 'refresh');
        }
    }
    
    // Report4/report1
    public function queryRiceAreaOrganic() {
        
        
        try {
            
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report41queryRiceAreaOrganic";
            $ci =& get_instance();
            //         $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->dbext = $ci->load->database('defaultext', TRUE);
            $data_cache = null;

            // -------

            $refcur = $this->dbext->get_cursor();
            //             $refcur = oci_new_cursor($this->dbext->conn_id);
            $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_rice_area_organic(:p_cur_result); end;");
            oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);

            $r = ociexecute($stmt);
            oci_execute($refcur, OCI_DEFAULT);

            oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);

            print_r(json_encode($data));

            die();

        }
        catch (Exception $e) {

            print_r(json_encode($e));
            die();
        }
        
        
    }
    
    // Report4/report1
    public function queryRiceAreaOrganicDetail() {
        
        
        try {
            
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report41queryRiceAreaOrganicDetail";
            $ci =& get_instance();
            //         $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->dbext = $ci->load->database('defaultext', TRUE);
            $data_cache = null;
            // -------

            $refcur = $this->dbext->get_cursor();
            //             $refcur = oci_new_cursor($this->dbext->conn_id);
            $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_rice_area_organic_d(:p_cur_result); end;");
            oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);

            $r = ociexecute($stmt);
            oci_execute($refcur, OCI_DEFAULT);

            oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);

            print_r(json_encode($data));

            die();

        }
        catch (Exception $e) {
            print_r(json_encode($e));
            die();
        }
        
        
    }


    // Report4/report2
    public function queryRiceAreaAllRegion() {


        try {

            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report42queryRiceAreaNonOrganicDetail";
            $ci =& get_instance();

            try {
                $ci->dbext = $ci->load->database('defaultext', TRUE);
                $data_cache = null;

//                if ( ! $data_cache = $ci->cache->get($cache_key)) {

                    $refcur = $this->dbext->get_cursor();
                    //             $refcur = oci_new_cursor($this->dbext->conn_id);
                log_message('debug', 'begin analyticrdo.pkg_report.rpt_rice_area_all_region(:p_cur_result); end;');

                    $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_rice_area_all_region(:p_cur_result); end;");
                    oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);

                    $r = ociexecute($stmt);
                    oci_execute($refcur, OCI_DEFAULT);
                log_message('debug', 'executed.');
                    oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                    oci_free_statement($stmt);
                log_message('debug', 'oci_fetch_all.');
                    print_r(json_encode($data));
                    die();
//                }
//                else {
//                    print_r(json_encode($data_cache));
//                }
            }
            finally {

                oci_close($ci);
            }

        }
        catch (Exception $e) {
            log_message("error", $e);
            $error = array("error" => $e);
            print_r(json_encode($error));
            die();
        }
    }

    // Report4/report2
    public function queryRiceAreaAllProvince() {


        try {

            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report42queryRiceAreaNonOrganicDetail";
            $ci =& get_instance();
            $regionName = $this->input->get('regionName');

            try {
                $ci->dbext = $ci->load->database('defaultext', TRUE);
                $data_cache = null;



                    $refcur = $this->dbext->get_cursor();
                    //             $refcur = oci_new_cursor($this->dbext->conn_id);
                    $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_rice_area_all_province(:p_cur_result, :p_region_name); end;");
                    oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);
                    oci_bind_by_name($stmt, ":p_region_name", $regionName, -1, SQLT_CHR  );

                    $r = ociexecute($stmt);
                    oci_execute($refcur, OCI_DEFAULT);

                    oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                    oci_free_statement($stmt);

                    log_message("debug", "output : ".json_encode($data));

                    print_r(json_encode($data));
                    die();

            }
            finally {

                oci_close($ci);
            }

        }
        catch (Exception $e) {
            log_message("error", $e);
            print_r(json_encode($e));
            die();
        }
    }
    
     // Report4/report4
    // Report4/report5
    // Report4/report6
    public function queryFarmer1Type() {


        try {

            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report4queryFarmer1Type";
            $ci =& get_instance();
            $groupCode = $this->input->get('groupCode');

            try {
                $ci->dbext = $ci->load->database('defaultext', TRUE);
                $data_cache = null;



                    $refcur = $this->dbext->get_cursor();
                    //             $refcur = oci_new_cursor($this->dbext->conn_id);
                    $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_farmer1_type(:p_cur_result, :p_group_code); end;");
                    oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);
                    oci_bind_by_name($stmt, ":p_group_code", $groupCode, -1, SQLT_CHR   );

                    $r = ociexecute($stmt);
                    oci_execute($refcur, OCI_DEFAULT);

                    oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                    oci_free_statement($stmt);


//                    $arr = array('a' => $groupCode);
                    print_r(json_encode($data));
//                    print_r(json_encode($arr));
                    die();

            }
            finally {

                oci_close($ci);
            }

        }
        catch (Exception $e) {
            log_message("error", $e);
            print_r(json_encode($e));
            die();
        }
    }

    // Report4/report4
    // Report4/report5
    // Report4/report6
    public function queryFarmer1TypeDetail() {

        try {

            ini_set('max_execution_time', 0);
            ini_set("memory_limit", '-1');
            $cache_key = "Report4queryFarmer1TypeDetail";
            $ci =& get_instance();
            $groupCode = $this->input->get('groupCode');

            try {
                $ci->dbext = $ci->load->database('defaultext', TRUE);
                $data_cache = null;

                $refcur = $this->dbext->get_cursor();
                //             $refcur = oci_new_cursor($this->dbext->conn_id);
                $stmt = oci_parse($this->dbext->conn_id, "begin analyticrdo.pkg_report.rpt_farmer1_type_detail(:p_cur_result, :p_group_code); end;");
                oci_bind_by_name($stmt, ":p_cur_result", $refcur, -1, OCI_B_CURSOR);
                oci_bind_by_name($stmt, ":p_group_code", $groupCode, -1, SQLT_CHR   );

                $r = ociexecute($stmt);
                oci_execute($refcur, OCI_DEFAULT);

                oci_fetch_all($refcur, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                oci_free_statement($stmt);


//                    $arr = array('a' => $groupCode);
                print_r(json_encode($data));
//                    print_r(json_encode($arr));
                die();

            }
            finally {

                oci_close($ci);
            }

        }
        catch (Exception $e) {
            log_message("error", $e);

            print_r(json_encode($e));
            die();
        }
    }

   
}
