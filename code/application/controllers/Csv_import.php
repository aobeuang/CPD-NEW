<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends MY_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->database();
    $this->load->helper('url');
        $this->load->helper('file');    
    $this->load->helper('form');
    

    $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));

    $this->load->library('session');

    $this->load->helper('properties');

    $this->load->helper('user');

  $this->load->model('csv_import_model');
  $this->load->library('csvimport');
  ob_start();
 }

 public function index()
 {
  if( $this->require_role('admin') )
    { 
      echo $this->load->view('auth/page_header', '', TRUE);
  $this->load->view('csv_import');
      echo $this->load->view('auth/page_footer', '', TRUE);
 }
}

 public function load_data()
 {
  $result = $this->csv_import_model->select();
  $output = '
   <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
         <table class="table table-bordered table-striped">
          <tr>
           <th>Sr. No</th>
           <th>First Name</th>
           <th>Last Name</th>
           <th>Phone</th>
           <th>Email Address</th>
          </tr>
  ';
  $count = 0;
  if($result->num_rows() > 0)
  {
   foreach($result->result() as $row)
   {
    $count = $count + 1;
    $output .= '
    <tr>
     <td>'.$count.'</td>
     <td>'.$row->first_name.'</td>
     <td>'.$row->last_name.'</td>
     <td>'.$row->phone.'</td>
     <td>'.$row->email.'</td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
   <tr>
       <td colspan="5" align="center">Data not Available</td>
      </tr>
   ';
  }
  $output .= '</table></div>';
  echo $output;
 }

 public function import()
 {
  // $this->input->post($_FILES["csv_file"]["tmp_name"]);die();
header('Content-Type: text/html; charset=UTF-8'); 
  ini_set('max_execution_time', 0);
        ini_set("memory_limit", '8124M');
  $this->db->order_by('user_id', 'DESC'); 
   $this->db->limit(1);
   $query = $this->db->get('users');

  $result = $query->result_array();

  $number = $result[0]['user_id'];

  $this->db->close();
      // connect to the other db
      $this->db = $this->load->database('default', true);

  $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
  $dataed = array();
  $check = null;
    foreach($file_data as $row)
    {

      if (empty($row["username"]) || empty($row["passwd"]) || empty($row["auth_level"]) || empty($row["name"]) || empty($row["province"]) || empty($row["org_id"])) {

        $output = array(
            "message"    => 'ไฟล์ไม่สมบูรณ์',
            "status"  => false
        );
        $check = 1;
        echo print_r($output);
        // die();
      }
    }

    if (empty($check)) {



      foreach($file_data as $row)
        {
          $sname = empty(($row["name"]))? "": $row["sname"];
          $number++;
          $data[] = array(
          'user_id' => $number,
          'username' => $row["username"],
          'name'  => $row["name"].' '.$sname,
          'auth_level'  => $row["auth_level"],
          'passwd'   => $this->hash_passwd($row["passwd"]),
          'banned'   => 2,
          'province'   => $row["province"],
          'ORG_ID'   => $row["org_id"],
          'email'   => $row["email"]
          );
          $dataed = $data;
           // $this->db->insert_batch('users', $data);
           // die();
        }
        // $this->db->insert_batch('users', $data);
        $this->csv_import_model->insert($dataed);

        $output = array(
            "message"    => 'ดำเนินการสำเร็จ',
            "status"  => true
        );

        echo print_r($output);
    }
    
    // echo print_r($data);die();
   
    
 }

 public function hash_passwd( $password, $random_salt = '' )
  {
    // If no salt provided for older PHP versions, make one
    if( ! is_php('5.5') && empty( $random_salt ) )
      $random_salt = $this->random_salt();

    // PHP 5.5+ uses new password hashing function
    if( is_php('5.5') ){
      return password_hash( $password, PASSWORD_BCRYPT, ['cost' => 11] );
    }

    // PHP < 5.5 uses crypt
    else
    {
      return crypt( $password, '$2y$10$' . $random_salt );
    }
  }

  public function random_salt()
  {
    $this->CI->load->library('encryption');

    $salt = substr( bin2hex( $this->CI->encryption->create_key(64) ), 0, 22 );

    return strlen( $salt ) != 22 
      ? substr( md5( mt_rand() ), 0, 22 )
      : $salt;
  }
 
  
}
