<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Authen extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Force SSL
        //$this->force_ssl();
        $this->load->database();
        
        // Form and URL helpers always loaded (just for convenience)
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('log');
        
        $this->load->helper('properties');
        
        $this->load->library('session');
        $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
		//$this->output->enable_profiler($this->config->item('profiling_enabled'));
		$this->output->enable_profiler(false);
        
        
    }

    /**
     * Demonstrate being redirected to login.
     * If you are logged in and request this method,
     * you'll see the message, otherwise you will be
     * shown the login form. Once login is achieved,
     * you will be redirected back to this method.
     */
    public function index()
    {
        if( $this->require_role('admin') )
        {
            echo $this->load->view('auth/page_header', '', TRUE);

            echo '<p>You are logged in!</p>';

            echo $this->load->view('auth/page_footer', '', TRUE);
        }else{
        	echo $this->load->view('auth/page_header', '', TRUE);
        	
        	echo '<p>ยินดีต้อนรับ</p>';
        	
        	echo $this->load->view('auth/page_footer', '', TRUE);
        }
    }
    // -----------------------------------------------------------------------

    /**
     * A basic page that shows verification that the user is logged in or not.
     * If the user is logged in, a link to "Logout" will be in the menu.
     * If they are not logged in, a link to "Login" will be in the menu.
     */
    public function home()
    {
    	
    	
    	
    	// populate user role and groups 
    	if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
     	{
     		//$sql = getSqlByGroup(1);
     		//echo "<pre>";
     		//print_r($sql);
     		//echo "</pre>";
     		 
     		//$this->load->helper('log');
     		//addMessage("test", "success", "haha");
 	    	
 	    	$userID = $this->session->userdata('auth_user_id');
	    	$this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
	        $this->load->helper('properties');
			echo $this->load->view('auth/page_header', '', TRUE);
			
			echo $this->load->view('home', '', TRUE);
			
			echo $this->load->view('auth/page_footer', '', TRUE);
     	}	
     	else 
     	{
     		redirect(site_url("login")."/?redirect=authen/home");
     	}

     	/*
		if($this->session->userdata('auth_user_id')==null && !is_numeric($this->session->userdata('auth_user_id'))){
			echo $this->load->view('auth/page_header', '', TRUE);
			echo '<div id="main-container" class="container col-md-12 col-xs-12"><p style="font-size: 60px;text-align: center;">กรุณาเข้าสู่ระบบ</p></div>';
			echo $this->load->view('auth/page_footer', '', TRUE);
		}*/
        
    }

    
    public function ajax_announcement()
    {
    	if ( ! $temp = $this->cache->get("announcement"))
    	{
	    	$query = $this->db->query("select * from \"".$this->db->dbprefix('announcements')."\" ");
	    	$results = $query->result_array();
	    	if (!empty($results))
	    	{
	    		$this->cache->save('current_announcement_id', $results[0]['announcement_id']);
	    		$this->cache->save('announcement', $results[0]['message']);
				$temp = $results[0]['message']; 
				return $temp;  		
	    	}
	    	else 
	    	{
	    		$this->cache->save('current_announcement_id', 0);
	    		$this->cache->save('announcement', "");
	    		$temp = "none";
	    	}
    	}
    	
    	// no cache
    	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
    	
    	echo $temp;
    }

    /**
     * Most minimal user creation. You will of course make your
     * own interface for adding users, and you may even let users
     * register and create their own accounts.
     *
     * The password used in the $user_data array needs to meet the
     * following default strength requirements:
     *   - Must be at least 8 characters long
     *   - Must be at less than 72 characters long
     *   - Must have at least one digit
     *   - Must have at least one lower case letter
     *   - Must have at least one upper case letter
     *   - Must not have any space, tab, or other whitespace characters
     *   - No backslash, apostrophe or quote chars are allowed
     */

    /**
     * This login method only serves to redirect a user to a 
     * location once they have successfully logged in. It does
     * not attempt to confirm that the user has permission to 
     * be on the page they are being redirected to.
     */
    public function login()
    {
    	
    	
    	if($this->session->userdata('auth_user_id')!=null && is_numeric($this->session->userdata('auth_user_id')))
    	{
    		redirect(site_url("/"));
    	}
    	
        // Method should not be directly accessible
    	if( $this->uri->uri_string() == 'authen/login')
            show_404();

        if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
            $this->require_min_level(1);

        $this->setup_login_form();
        
        
        $html = $this->load->view('auth/page_header', '', TRUE);
        
        $html .= $this->load->view('auth/login_form', '', TRUE);

        $html .= $this->load->view('auth/page_footer', '', TRUE);

        echo $html;
    }

    /**
     * Log out
     */
    public function logout()
    {

    	$this->session->sess_destroy();
    	
    	$this->authentication->logout();
        
        // Set redirect protocol
        $redirect_protocol = USE_SSL ? 'https' : NULL;

        redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
    }
 
    // -----------------------------------------------------------------------
}

