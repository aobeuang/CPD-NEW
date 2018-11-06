<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collectdata extends MY_Controller {

    public $group_id = null;
    public  $workflow_id = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->helper('form');
        $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));

        $this->load->library('session');
        $this->load->library('grocery_CRUD');


// 		$this->output->enable_profiler($this->config->item('profiling_enabled'));
        $this->output->enable_profiler(FALSE);




    }
    function test()
    {

    }
}