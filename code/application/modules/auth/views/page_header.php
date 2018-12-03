<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ระบบบูรณาการข้อมูลภาคการเกษตร</title>
	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="/assets/default/css/theme.css" />
	<link type="text/css" rel="stylesheet" href="/assets/default/css/bootstrap.min.css" />
	<link href="/assets/default/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/font-awesome/css/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/common.css" />
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/general.css" />

	<script src="/assets/grocery_crud/js/jquery-1.11.1.min.js"></script>
        	
	
	<script src="/assets/default/js/bootstrap.min.js" type="text/javascript"></script>
    <?php if (ENVIRONMENT == 'production'):?>
        <script src="/assets/grocery_crud/themes/bootstrap/build/js/global-libs.min.js"></script>
    <?php else:?>
        <script src="/assets/grocery_crud/themes/bootstrap/js/jquery-plugins/jquery.form.js"></script>
        <script src="/assets/grocery_crud/themes/bootstrap/js/common/cache-library.js"></script>
        <script src="/assets/grocery_crud/themes/bootstrap/js/common/common.js"></script>
    <?php endif?>	
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.th.min.js"></script>
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/css/jquery_plugins/jquery.ui.datetime.css" />
	<script src="/assets/grocery_crud/js/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-th.js"></script>
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/css/jquery_plugins/jquery-ui-timepicker-addon.css" />
	<link rel="stylesheet" href="/assets/default/css/jquery-ui.css">
	<script src="/assets/default/js/jquery-ui.js"></script>
	<link rel="stylesheet" href="/assets/default/css/select2/select2.min.css">
	<script src="/assets/default/js/select2/select2.full.min.js"></script>
	<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
 	<script src='/assets/default/vendors/pdfmake-master/build/pdfmake.min.js'></script>
 	<script src='/assets/default/vendors/pdfmake-master/build/vfs_fonts.js'></script>


	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" />
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<link type="text/css" rel="stylesheet" href="/assets/default/css/style.css" />
	
	<script>
	$(document).ready(function(){
	    $(".dropdown").hover(            
	        function() {
	            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
	            $(this).toggleClass('open');        
	        },
	        function() {
	            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
	            $(this).toggleClass('open');       
	        }
	    );

	    $.get( '<?php echo site_url("authen/ajax_announcement")?>', function( data ) {

		    if (data!="none" && data!='' && data!=' ')
		    {
			    data = '<span class="fa fa-bullhorn" style="color: rgb(255, 0, 0);"> </span> ' + data;
	    	 	$( "#announcement .well" ).html( data );
	    	  	$( "#announcement" ).attr('style','');
		    }
	    });



				    
	});
	</script>	
		
	<?php
		// Add any javascripts
		if( isset( $javascripts ) )
		{
			foreach( $javascripts as $js )
			{
				echo '<script src="' . $js . '"></script>' . "\n";
			}
		}

		if( isset( $final_head ) )
		{
			echo $final_head;
		}
	?>
	
</head>
<body>

<?php 
$current_url = $_SERVER['REQUEST_URI'];



?>


<?php
$current_url = $_SERVER['REQUEST_URI'];


?>
<?php 
	$this->load->helper('user');
    $this->load->helper('survey');
	$user_id = $this->session->userdata('auth_user_id');
	$role_user = $this->session->userdata('auth_role');
	$role = null;
	
		if($role_user == "central_normal")
			$role = 'ผู้ใช้งานส่วนกลางระดับจัดการ';
		if($role_user == "central_manager")
			$role = 'ผู้ใช้งานส่วนกลางระดับบริหาร';
		if($role_user == "notcentral_normal")
			$role = 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ';
		if($role_user == "notcentral_manager")
			$role = 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร';
		if($role_user == "admin_normal")
			$role = 'ผู้ดูแลระบบระดับจัดการ';                    	
		if($role_user == "admin")
			$role = 'ผู้ดูแลระบบระดับบริหาร';


	$user = getUser($user_id);
?> 
<?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid nav-st">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('/home')?>"><img src="<?php $this->load->helper('properties_helper');
     	 print_r(getStringSystemProperties("logo", "/assets/default/images/logo-white.png"))?>"/></a>
     	<div class="navbar-usrinfo floatR">
     	 	<?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
				<table>
				  <tr>
				    <td>ชื่อผู้ใช้งาน:</td>
				    <td><?php echo $user['name']?></td>
				  </tr>
				  <tr>
				    <td>สิทธิ์การใช้งาน:</td>
				    <td><?php echo $role;?></td>
				  </tr>
				  <tr>
				    <td>เขตพื้นที่:</td>
				    <td><?php 
					    $khet = getOrgByID($user['org_id']);
				    	if ($khet['khet_id'] != 99) {
				    		echo $khet['khet_desc'];
				    	}else{
				    		echo "เขตตรวจราชการที่ 1";
				    	}
				    ?></td>
				  </tr>
				  <tr>
				    <td>หน่วยงาน:</td>
				    <td><?php echo getOrgByID($user['org_id'])['org_name']?></td>
				  </tr>
				  <tr>
				  	<?php
					$source = $user['last_login'];
					// echo print_r($source);
					$date = new DateTime($source);
					$TH_Month = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

					$nMonth = $date->format('n')-1;
					$day = $date->format('j');date("j",strtotime($source));
					$year = $date->format('Y')+543;
					$time = $date->format('H:i:s');
					?>
				    <td>วันที่เข้าสู่ระบบ:</td>
				    <td><?php echo (" $day $TH_Month[$nMonth] $year $time") ?></td>
				    

				  </tr>
				</table>
            <?php else:?>
            <?php endif?>   
     	 </div>
    </div>
  </div>
  <div class="container-fluid nav-nd">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
        <ul class="nav navbar-nav">
        	<?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
            <li class="nav-bar-li <?php if ($current_url=="/" || $current_url == "/index.php/authen/home" || $current_url == "/index.php/home") echo "active"?>">
            	<a href="<?php echo site_url('/home')?>" class="nav-ic ic-home"> หน้าหลัก</a>
            </li>
			<?php endif?>
            <?php $this->load->helper('survey');?>
            
            <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canAdd())):?>
           	<li class="nav-bar-li <?php if (strpos($current_url,"/survey/add_")===0 
           				|| (strpos($current_url,"/index.php/admin/do_survey_1")===0 && !isset($_GET['mode']) )
           				|| strpos($current_url,"/index.php/survey/add_")===0) 
           					
           		
           				echo "active"?>
           	
           	
           	"><a href="#<?php //echo site_url('survey/add_survey')?>" class="nav-ic ic-survey disble-a-gray">กรอกข้อมูลแบบสำรวจ<br>(อยู่ในระหว่างการแก้ไข)</a></li>
			<?php endif?>          
			
			
           	<?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canViewReport())):
           		if (getStringSystemProperties("disable.phase2") != "yes"):	?>	        
		           <li class="dropdown <?php if (strpos($current_url, "/report3")!==FALSE) echo "active"?>">
                     <a href="#" class="dropdown-toggle nav-ic ic-mis" data-toggle="dropdown">รายงาน MIS ผู้บริหาร <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">

                     		<li class=""><a href="<?php echo site_url('report3/index1')?>">รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)</a></li>
                     		<li class=""><a href="<?php echo site_url('report3/index2')?>">รายงานจำนวนสมาชิกสหกรณ์ ภาคเกษตร</a></li>
							<li class=""><a href="<?php echo site_url('report3/index3')?>">รายงานจำนวนสมาชิกสหกรณ์ นอกภาคเกษตร</a></li>								
							<li class=""><a href="<?php echo site_url('report3/index6')?>">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ</a></li>
							<li class=""><a href="<?php echo site_url('report3/index17')?>">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด</a></li>
							<li class=""><a href="<?php echo site_url('report3/index12')?>">รายงานจำนวนสมาชิกสหกรณ์ ที่เป็นสมาชิก มากกว่า 1 แห่ง</a></li>
							<li class=""><a href="<?php echo site_url('report3/index5')?>">รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>	
							<li class=""><a href="<?php echo site_url('report3/index15')?>">รายงานสถานภาพสมาชิกสหกรณ์ (โดยนับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report3/index10')?>">รายงานข้อมูลการเลี้ยงสัตว์ (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report3/index11')?>">รายงานข้อมูลการทำประมง (อยู่ในระหว่างการแก้ไข)</a></li>                
		              </ul>
                     </li>  
                     <?php endif?>
                     
           		<?php endif?>

           		
                     <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canViewReport())):
           		if (getStringSystemProperties("disable.phase2") != "yes"):	?>
		            <li class="dropdown <?php if (strpos($current_url, "/report1")!==FALSE) echo "active"?> ">     
		              <a href="#" class="dropdown-toggle nav-ic ic-analyze disble-a-gray" data-toggle="dropdown" ></span> รายงานวิเคราะห์ <br>(อยู่ในระหว่างการแก้ไข)<span class="caret"></span></a>
 		              <ul class="dropdown-menu" role="menu"> 
							<li class=""><a href="<?php echo site_url('report1/index1')?>">รายงานข้อมูลทั่วไป</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index2')?>">รายงานพื้นที่ครอบครอง (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index3')?>">รายงานข้อมูลการผลิตทางการเกษตรในรอบปีที่ผ่านมา (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index4')?>">รายงานปัญหาที่พบในการประกอบอาชีพ (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index5')?>">รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index6')?>">รายงานข้อมูลการผลิตปีปัจจุบัน (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index7')?>">รายงานข้อมูลการเลี้ยงโคนม (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index8')?>">รายงานข้อมูลผลไม้ (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index9')?>">รายงานข้อมูลพันธ์ข้าว (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index10')?>">รายงานข้อมูลการใช้ปุ๋ย (อยู่ในระหว่างการแก้ไข)</a></li>
							<li class="disble-gray"><a href="<?php echo site_url('report1/index11')?>">รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด (อยู่ในระหว่างการแก้ไข)</a></li>
		              </ul>
		            </li>
					
           		<?php endif?>
            <?php endif?> 
		   <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canViewReport() || canAdd())):
           		if (getStringSystemProperties("disable.phase2") != "yes"):	?>	        
					<li class="dropdown <?php if (strpos($current_url, "/report2")!==FALSE) echo "active"?>">     
		              <a href="#" class="dropdown-toggle nav-ic ic-member-info" data-toggle="dropdown"> รายงานข้อมูลสมาชิก <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo site_url('report2/index1')?>">รายงานข้อมูลรายบุคคล</a></li>
							<li class=""><a href="<?php echo site_url('report2/index2')?>">รายงานข้อมูลสมาชิกในสหกรณ์</a></li>
							<li class=""><a href="<?php echo site_url('report2/index4')?>">รายงานสรุปยอดสถานะสมาชิกสหกรณ์</a></li>
							<!-- <li class=""><a href="<?php //echo site_url('report2/index3')?>">รายงานข้อมูลจากผู้บันทึก</a></li>		             -->
		              </ul>
		            </li>		            
		            
           		<?php endif?>
            <?php endif?>               
		</ul>        
        <ul class="nav navbar-nav navbar-right">
        
			<?php if ($this->session->userdata('auth_role')=="admin"  || $this->session->userdata('auth_role')=="admin_normal"):?>
            
            <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin")):?>
           		<li class="dropdown <?php if (strpos($current_url, "/loginlog/suspiciouslog_management")!==FALSE && strpos($current_url, "/loginlog/suspiciouslogreport_management")!==FALSE ) echo "active"?>">
           		<a href="#" class="dropdown-toggle " data-toggle="dropdown"><span class="glyphicon glyphicon-dashboard"></span> <span class="caret"></span></a>
           		<ul class="dropdown-menu" role="menu">
           			<li><a href="<?php echo site_url('loginlog/suspiciouslog_management')?>">ดูประวัติการเรียกดูข้อมูลสมาชิก</a></li>
           			<li><a href="<?php echo site_url('loginlog/suspiciouslogreport_management')?>">ดูประวัติการเรียกดูข้อมูลสหกรณ์</a></li>
           			<li class=""><a href="<?php echo site_url('admin/logusers')?>">ดูประวัติการเข้าใช้งานระบบ</a></li>
				</ul>
				</li>  
			<?php endif?>  
            
 <!--        <li class="dropdown <?php if (strpos($current_url, "/loginlog")!==FALSE) echo "active"?>">
              	<a href="#" class="dropdown-toggle " data-toggle="dropdown">ประวัติการเข้าใช้งาน <span class="caret"></span></a> 
                <ul class="dropdown-menu" role="menu"> 
	              	<li><a href="<?php echo site_url('loginlog/formauth')?>">Login Auth</a></li>
	                <li><a href="<?php echo site_url('loginlog/formci')?>">Login Session</a></li>
	                <li><a href="<?php echo site_url('loginlog/formloginerror')?>">Login Errors</a></li>
	                <li><a href="<?php echo site_url('loginlog/formips')?>">IPs On Hold</a></li> 
	                <li><a href="<?php echo site_url('loginlog/index')?>">Login Denied</a></li>              
                </ul> 
             </li>               -->
            
            
            <?php endif?>       
            
            
            
            <?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id') && $this->session->userdata('auth_role')=="admin"):?>
            
            <li class="dropdown <?php if ( (strpos($current_url, "/admin")!==FALSE && (strpos($current_url, "survey")===FALSE))
            		|| strpos($current_url, "/properties")!==FALSE
            		|| strpos($current_url, "/mylogger")!==FALSE
            		|| strpos($current_url, "/sqlcommand")!==FALSE
            		|| strpos($current_url, "loginlog/formloginerror")!==FALSE
            		|| strpos($current_url, "loginlog/formips")!==FALSE
            		|| strpos($current_url, "loginlog/index")!==FALSE
            		) echo "active"?>">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <!-- li><a href="<?php echo site_url('admin/group_management')?>">การจัดการกลุ่มผู้ใช้งาน</a></li-->
                <li><a href="<?php echo site_url('admin/users_management')?>">การจัดการผู้ใช้งานระบบ</a></li>
                <li><a href="<?php echo site_url('csv_import')?>">นำเข้าผู้ใช้งานระบบ</a></li>
                <!-- li><a href="<?php //echo site_url('loginlog/formloginerror')?>">รายการผู้ล็อกอินผิดพลาด</a></li>
	            <li><a href="<?php //echo site_url('loginlog/formips')?>">รายการหมายเลข IP ที่ถูก lock ชั่วคราว</a></li> 
	            <li><a href="<?php //echo site_url('loginlog/index')?>">รายการผู้ห้ามล็อกอินเข้าระบบ</a></li -->      
                <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin")):?>
               	<!-- <li><a href="<?php echo site_url('properties/properties')?>">การตั้งค่าระบบ</a></li> --> 
                <!-- li><a href="<?php echo site_url('mylogger/index')?>">บันทึกการทำงานของระบบ</a></li> -->              
               <!--   <li><a href="<?php echo site_url('admin/clear_all_caches')?>">ล้างข้อมูลในหน่วยความจำ</a></li> -->
                
                <!--   <li><a href="<?php echo site_url('sqlcommand/index')?>">คำสั่งการสร้างฐานข้อมูลรายงาน</a></li>  -->
            <!--    <li><a href="<?php echo site_url('admin/suspiciouslog_management')?>">ดูประวัติการดูข้อมูลสมาชิกที่อยู่คนละจังหวัด</a></li>      -->          
              	<?php endif?> 
               </ul>
            </li>    
            
            <?php endif?>
               
       
            <?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
	            <li class="dropdown">
	              <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $user['name']?> <span class="caret"></span></a>
	              <ul class="dropdown-menu" role="menu">
	                <li><a href="<?php echo site_url("mystuffs/home")?>">ข้อมูลบัญชีผู้ใช้</a></li> 
	                <li><a href="<?php echo site_url("admin/changeUsers/".$this->session->userdata('auth_user_id'))?>">เปลี่ยนรหัสผ่าน</a></li>
	                <li class="divider"></li>
	                <li><a href="<?php echo site_url("authen/logout")?>"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</a></li>
	              </ul>
	            </li>
	            <!-- li style="border: 1px solid rgb(187, 187, 187); border-radius: 15px; height: 40px; margin-top: 5px; color: rgb(0, 0, 0) ! important;"><a href="<?php echo site_url("search/search_index")?>" id="search-link" style="padding-top: 10px ! important;"><span class="fa fa-search" style="color: rgb(255, 0, 0);"> </span><span style="color: rgb(0, 0, 0);"> ค้นหา</span></a></li-->
	            <!-- li><a href="<?php echo site_url("search/index")?>" id="search-link"><span class="fa fa-search" style="color:#000;"></span></a></li -->
	            
            <?php else:?>
<!--             	<li><a href="<?php //echo site_url(LOGIN_PAGE . '?redirect=mystuffs/home')?>">เข้าสู่ระบบ</a></li> -->
            <?php endif?>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>	

<?php if (strpos($current_url,'/login')==FALSE && strpos($current_url,'/admin/')==FALSE):?>
<div class="container" id="announcement" style="display:none">
    <div class="well">
    </div>
</div>
<?php endif  ?>

<?php if (		
		(!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id'))
		&&	(strpos($current_url, "/admin")===FALSE) && (strpos($current_url, "/properties")===FALSE)
		&& (strpos($current_url, "/mylogger")===FALSE) && (strpos($current_url, "/sqlcommand")===FALSE)
		&& (strpos($current_url, "/loginlog")===FALSE) && (strpos($current_url, "/mystuffs")===FALSE)
		&& (strpos($current_url, "/authen")===FALSE ) && (strpos($current_url, "/report2")===FALSE )
		&& (strpos($current_url, "/report1")===FALSE ) && (strpos($current_url, "/report3")===FALSE )
		&& (strpos($current_url, "/home")===FALSE )
		):?>
		
<div class="container" id="survey-code" >

<label>เลือกปี</label>&#160;&#160;
<select name="survey_year" id="survey_year" >
<?php  
	$this->load->helper('survey');
	$all_survey_years = getAllSurveyYears();
	$selected_year = getSelectedSurveyYear();
	if (!empty($all_survey_years))
	{
		foreach ($all_survey_years as $k=>$v)
		{
			$selected = "";
			if ($k==$selected_year)
				$selected = "selected=selected";		
			echo "<option $selected value='$k'>$v</option>";
		}
	}
?>
</select>	
</div>	

<style>
#survey-code .select2-container
{
	min-width: 70px;
}

</style>
<script>

jQuery(function () {

    // remove the below comment in case you need chnage on document ready

    // location.href=jQuery("#selectbox").val();   

       var targetUrl = '<?php echo urlencode($_SERVER['REQUEST_URI']);?>';

    	jQuery("#survey_year").change(function () {

        location.href = '<?php echo site_url('survey/selectSurveyYear')?>/'+jQuery(this).val()+'?targetURL='+targetUrl;

    });

});

</script>
<?php endif?>


<div class="container-fluid">
	<div class="col-sm-12">
		<div class="msg-div" id="success-box" style="display:none"></div>
	</div>
</div>

<div class="modal fade cpd-modal-info" id="message-modal" role="dialog">
	<div class="modal-dialog" style="width: auto;">
	  <div class="modal-content">
	    <!-- <div class="modal-header">
	    	<span class="modal-title" id="ModalTitle" style="display: inline-block;">ข้อความ</span>
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="line-height: 0.6;font-size: 38px;">
	          <span aria-hidden="true">×</span>
	        </button>
	    </div> -->
	    <div class="modal-body">
	    	<span id="msg-modal-txt"></span>
	    </div>
	    <div class="modal-footer" style="text-align: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal">ตกลง</button>
        </div>
	  </div>
	</div>
</div>
<script>
// assumes you're using jQuery
$(document).ready(function() {
$('#success-box').hide();
<?php if($this->session->userdata('success_msg') || (isset($success_msg)&&!empty($success_msg) )){?>
<?php $success = !empty( $success_msg ) ? $success_msg : $this->session->userdata('success_msg');?>
<?php $this->session->set_userdata('success_msg',null);?>
$('#success-box').html('<?php echo $success ?>').show();
<?php } ?>
});

</script>
<div class="page-container">
	<div class="msg-div" id="error-box" style="display:none"></div>
</div>
<div id="pageLoading" class="page-loading">
	<div class="page-loading-con">
		<div><div class="c-loader"></div><span>กำลังโหลด..</span></div>
	</div>
</div>
<script>
// assumes you're using jQuery
$(document).ready(function() {
$('#error-box').hide();
<?php if($this->session->userdata('error_msg') || (isset($error_msg)&&!empty($error_msg)  )){?>
<?php $error = !empty( $error_msg ) ? $error_msg : $this->session->userdata('error_msg');?>
<?php $this->session->set_userdata('error_msg',null);?>
$('#error-box').html('<?php echo $error ?>').show();
<?php } ?>
});


// $('#survey_year').each(function( index ) {
// 	$(this).select2({
// 		  placeholder: "เลือกรหัสแบบสำรวจ"
// 		});
// });


</script>


<style>
#data_respone,#data_respone1,#data_respone2,#data_respone3,#data_respone4,#data_respone5
{
	display:none;
}
.disble-gray a{
	color: #b1b1b1 !important;
}
.disble-a-gray{
	color: #b1b1b1 !important;
	padding: 10px 10px 10px 30px !important;
	pointer-events:none;
    opacity:0.7;
}     
</style>


<?php endif?> 