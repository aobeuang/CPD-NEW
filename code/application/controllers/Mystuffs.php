<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Community Auth - Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2016, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class Mystuffs extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Force SSL
        //$this->force_ssl();

        // Form and URL helpers always loaded (just for convenience)
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->library('session');
        $this->load->library('grocery_CRUD');
        $this->load->helper('survey');
        
		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
		$this->output->enable_profiler(false);
    }
 
    public function home()
    {
    	if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
    	{
    		$this->is_logged_in();
    		 

        	$page_content = "";
        	$user_id = $this->session->userdata('auth_user_id');
        	
        	$crud = new grocery_CRUD();

			// disable list page and add new edit url that will redirect to user edit page 
        	if (strpos($_SERVER['REQUEST_URI'],'myedit')!==FALSE)
        	{
        		redirect(site_url('mystuffs/home/edit/'.$user_id));
        	}        	
        	
        	if ($crud->getState()=="list" || $crud->getState()=="success")
        	{
        		redirect(site_url('mystuffs/home/read/'.$user_id));
        	}
        	
        	if ($crud->getStateInfo()->primary_key!=$user_id)
        	{
        		die();
        	}
        	
			$crud->set_theme('bootstrap_my_stuff');
			$crud->unset_bootstrap();
			$crud->unset_jquery();
        	
        	$table = $this->db->dbprefix('users');
			$crud->set_table($table);
			$crud->set_primary_key('user_id');
			$crud->where('user_id', $user_id);
			
        	$crud->columns('ORG_ID','province');
      


            $crud->unset_fields('AUTH_LEVEL_NAME', 'created_at', 'modified_at');
        	
        	 
        	$crud->edit_fields('name','username','passwd', 'created_at', 'modified_at','ORG_ID');
        	$crud->fields('name','username','passwd', 'created_at', 'modified_at');
            
            
            
            


         	$crud->display_as('username','ชื่อบัญชีผู้ใช้')
	        	->display_as('name','ชื่อ')
	        	->display_as('last_login','ล็อกอินครั้งล่าสุด')
	        	->display_as('created_at','สร้างเมื่อ')
	        	->display_as('modified_at','แก้ไขเมื่อ')
	        	->display_as('user_id','หมายเลขผู้ใช้')
	        	->display_as('banned','อนุญาตให้ใช้')
	        	->display_as('passwd','รหัสผ่าน')
	        	->display_as('auth_level','บทบาท')
                ->display_as('province','จังหวัด')
	        	->display_as('ORG_ID','เขตพื้นที่')
	        	->display_as('AGENCY','สังกัดหน่วยงาน')
	        	->display_as('email','อีเมล')

	        	
        	;
        	$crud->set_subject('บัญชีผู้ใช้ของคุณ');
        	
        	// $crud->field_type('auth_level','dropdown',
        			// array('1' => 'สมาชิก','6' => 'เจ้าหน้าที่' , '9' => 'แอดมิน'));

        	$crud->field_type('username','readonly');
            $crud->field_type('name','readonly');
        	// $crud->field_type('ORG_ID','readonly');

        	$crud->field_type('last_login','datetime');
        	$crud->field_type('modified_at','hidden');
        	$crud->field_type('created_at','hidden');
        	$crud->field_type('passwd','password');
        	$crud->field_type('passwd_recovery_code','hidden');
        	$crud->field_type('passwd_recovery_date','hidden');
        	$crud->field_type('passwd_modified_at','hidden');        	
        	$crud->callback_before_insert(array($this,'encrypt_password_callback'));
        	$crud->callback_before_update(array($this,'encrypt_password_callback'));
            $crud->callback_edit_field('passwd',array($this,'decrypt_password_callback'));
            // $crud->callback_edit_field('ORG_ID',array($this,'_callback_org'));


        	
        	// set rule
        	$crud->set_rules('passwd','รหัสผ่าน','required');
        	$crud->required_fields('passwd');
        	 
        	// do not allow DELETE and ADD operation
        	$crud->unset_delete();
        	$crud->unset_add();
        	$crud->unset_export();
        	$crud->unset_print();
        	
        	// hide some element 
        	echo "<style>#gcrud-search-form .header-tools, #gcrud-search-form table thead tr.filter-row, #gcrud-search-form .footer-tools div.floatL, #gcrud-search-form .footer-tools div.floatR
{display:none!important;} #field-passwd,#field-auth_level{display:none}</style>";
        	
        	$page_content = $crud->render();
        	
        	$this->_mystuffs_output($page_content);
    	}   	
    	else
    	{
    		redirect(site_url( LOGIN_PAGE . '?redirect=' . "mystuffs/home", $redirect_protocol ));
    	}
    }
    
    function encrypt_password_callback($post_array, $primary_key = null)
    {
    	if (isset($post_array['passwd']) && !empty($post_array['passwd']) && $post_array['passwd']!="nochange")
    		$post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
    	else
    		unset($post_array['passwd']);
    	
    	if (!isset($post_array['user_id']))
    		$post_array = $this->log_activity_before_insert($post_array, $primary_key);
    	else
    		$post_array = $this->log_activity_before_update($post_array, $primary_key);    	
    	
    	return $post_array;
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
        
    
    
    function decrypt_password_callback($value)
    {
    	return "<input type='password' name='passwd' value='nochange' class='form-control' />";
    }    
    
    // -----------------------------------------------------------------------


    public function _mystuff_non_table_output($output = null)
    {
    	echo $this->load->view('auth/page_header', '', TRUE);
    
    	echo $output;
    
    	echo $this->load->view('auth/page_footer', '', TRUE);
    }    
    
    public function _mystuffs_output($output = null)
    {
    	echo $this->load->view('auth/page_header', '', TRUE);
    
    	$this->load->view('table_body.php',$output);
    
    	echo $this->load->view('auth/page_footer', '', TRUE);
    }

    public function _callback_org($value,$primary_key = null)
    {
        $orgname = getOrgByID($value);

        return $orgname->org_name;
    }

    public function _callback_province($value,$row)
    {
        
    }     
}