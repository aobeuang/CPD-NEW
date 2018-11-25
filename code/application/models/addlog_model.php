<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        // $this->CI->load->library('SOMELIBRARY');
        $this->CI->load->helper('user');
		$this->CI->load->helper('log');
    } 


    public function show_404()
    {
        $CI =& get_instance();
        $CI->load->view('my_notfound_view');
        echo $CI->output->get_output();
        exit;
    }


}