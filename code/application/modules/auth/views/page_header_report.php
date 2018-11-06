<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ระบบบูรณาการข้อมูลภาคการเกษตร</title>
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
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
   margin: auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>


<body>

<?php 
$current_url = $_SERVER['REQUEST_URI'];



?>


<?php
$current_url = $_SERVER['REQUEST_URI'];


?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('/')?>"><img src="<?php $this->load->helper('properties_helper');
     	 print_r(getStringSystemProperties("logo", "/assets/default/images/logo.png"))?>"/></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
        <ul class="nav navbar-nav">
        	<?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
            <li class="<?php if ($current_url=="/" || $current_url == "/index.php/") echo "active"?>"><a href="<?php echo site_url('/')?>">หน้าหลัก</a></li>
			<?php endif?>
            <?php $this->load->helper('survey');?>
            
            <?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canAdd())):?>
           	<li class="<?php if (strpos($current_url,"/survey/add_")===0 || strpos($current_url,"/index.php/survey/add_")===0) echo "active"?>"><a href="<?php echo site_url('survey/add_survey')?>">กรอกข้อมูลแบบสำรวจ</a></li>
			<?php endif?>          
           	<?php if  ((!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')) && ($this->session->userdata('auth_role')=="admin" || canViewReport())):
           		if (getStringSystemProperties("disable.phase2") != "yes"):	?>	        
		           <li class="dropdown <?php if (strpos($current_url, "/report3")!==FALSE) echo "active"?>">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">รายงาน MIS ผู้บริหาร <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     		<li class=""><a href="<?php echo site_url('report3/index1')?>">รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)  </a></li>
                     		<li class=""><a href="<?php echo site_url('report3/index2')?>">รายงานจำนวนสมาชิกสหกรณ์ ภาคเกษตร</a></li>
							<li class=""><a href="<?php echo site_url('report3/index3')?>">รายงานจำนวนสมาชิกสหกรณ์ นอกภาคเกษตร</a></li>								
							<li class=""><a href="<?php echo site_url('report3/index6')?>">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ</a></li>
							<li class=""><a href="<?php echo site_url('report3/index17')?>">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด</a></li>
							<li class=""><a href="<?php echo site_url('report3/index12')?>">รายงานจำนวนสมาชิกสหกรณ์ ที่เป็นสมาชิก มากกว่า 1 แห่ง</a></li>
							<li class=""><a href="<?php echo site_url('report3/index5')?>">รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>	
							<li class=""><a href="<?php echo site_url('report3/index15')?>">รายงานสถานภาพสมาชิกสหกรณ์ (โดยนับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>
							<li class=""><a href="<?php echo site_url('report3/index10')?>">รายงานข้อมูลการเลี้ยงสัตว์</a></li>
							<li class=""><a href="<?php echo site_url('report3/index11')?>">รายงานข้อมูลการทำประมง</a></li>                  
		              </ul>
                     </li>  
		            <li class="dropdown <?php if (strpos($current_url, "/report1")!==FALSE) echo "active"?>">     
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">รายงานวิเคราะห์ <span class="caret"></span></a>
 		              <ul class="dropdown-menu" role="menu"> 
							<li class=""><a href="<?php echo site_url('report1/index1')?>">รายงานข้อมูลทั่วไป</a></li>
							<li class=""><a href="<?php echo site_url('report1/index2')?>">รายงานพื้นที่ครอบครอง</a></li>
							<li class=""><a href="<?php echo site_url('report1/index3')?>">รายงานข้อมูลการผลิตทางการเกษตรในรอบปีที่ผ่านมา</a></li>
							<li class=""><a href="<?php echo site_url('report1/index4')?>">รายงานปัญหาที่พบในการประกอบอาชีพ</a></li>
							<li class=""><a href="<?php echo site_url('report1/index5')?>">รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน</a></li>
							<li class=""><a href="<?php echo site_url('report1/index6')?>">รายงานข้อมูลการผลิตปีปัจจุบัน</a></li>
							<li class=""><a href="<?php echo site_url('report1/index7')?>">รายงานข้อมูลการเลี้ยงโคนม</a></li>
							<li class=""><a href="<?php echo site_url('report1/index8')?>">รายงานข้อมูลผลไม้</a></li>
							<li class=""><a href="<?php echo site_url('report1/index9')?>">รายงานข้อมูลพันธ์ข้าว</a></li>
							<li class=""><a href="<?php echo site_url('report1/index10')?>">รายงานข้อมูลการใช้ปุ๋ย</a></li>
							<li class=""><a href="<?php echo site_url('report1/index11')?>">รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</a></li>
		              </ul>
		            </li>
					<li class="dropdown <?php if (strpos($current_url, "/report2")!==FALSE) echo "active"?>">     
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">รายงานข้อมูลสมาชิก <span class="caret"></span></a>
		              <ul class="dropdown-menu" role="menu">
							<!-- <li class=""><a href="<?php //echo site_url('report2/index1')?>">รายงานข้อมูลรายบุคคล</a></li> -->
							<li class=""><a href="<?php echo site_url('report2/index2')?>">รายงานข้อมูลสมาชิกในสหกรณ์</a></li>
							<li class=""><a href="<?php echo site_url('report2/index4')?>">รายงานสรุปยอดสถานะสมาชิกสหกรณ์</a></li>
							<!-- <li class=""><a href="<?php //echo site_url('report2/index3')?>">รายงานข้อมูลจากผู้บันทึก</a></li>		 -->            
		              </ul>
		            </li>		            
		            
           		<?php endif?>
            <?php endif?>               
		</ul>        
        <ul class="nav navbar-nav navbar-right">
        
			<?php if ($this->session->userdata('auth_role')=="admin"):?>
            
            <li class="dropdown <?php if (strpos($current_url, "/admin")!==FALSE 
            		|| strpos($current_url, "/properties")!==FALSE
            		|| strpos($current_url, "/mylogger")!==FALSE
            		|| strpos($current_url, "/sqlcommand")!==FALSE            		
            		) echo "active"?>">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown">ผู้ดูแลระบบ <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo site_url('admin/group_management')?>">การจัดการกลุ่มผู้ใช้งาน</a></li>
                <li><a href="<?php echo site_url('admin/users_management')?>">การจัดการผู้ใช้งานระบบ</a></li>
                <li><a href="<?php echo site_url('properties/properties')?>">การตั้งค่าระบบ</a></li> 
                <li><a href="<?php echo site_url('mylogger/index')?>">บันทึกการทำงานของระบบ</a></li>                 
                <li><a href="<?php echo site_url('sqlcommand/index')?>">คำสั่งการสร้างฐานข้อมูลรายงาน</a></li>  
                <li><a href="<?php echo site_url('admin/suspiciouslog_management')?>">ดูประวัติการดูข้อมูลสมาชิกที่อยู่คนละจังหวัด</a></li>               
               </ul>
            </li>    
            
            <li class="dropdown <?php if (strpos($current_url, "/loginlog")!==FALSE) echo "active"?>">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown">ประวัติการเข้าใช้งาน <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
              	<li><a href="<?php echo site_url('loginlog/formauth')?>">Login Auth</a></li>
                <li><a href="<?php echo site_url('loginlog/formci')?>">Login Session</a></li>
                <li><a href="<?php echo site_url('loginlog/formloginerror')?>">Login Errors</a></li>
                <li><a href="<?php echo site_url('loginlog/formips')?>">IPs On Hold</a></li> 
                <li><a href="<?php echo site_url('loginlog/index')?>">Login Denied</a></li>              
               </ul>
            </li>              
            
            
            <?php endif?>          
        
            <?php if (!empty($this->session->userdata('auth_user_id')) && $this->session->userdata('auth_user_id')):?>
	            <li class="dropdown">
	              <a href="" class="dropdown-toggle" data-toggle="dropdown">คุณ <?php echo $this->session->userdata('auth_username')?> <span class="caret"></span></a>
	              <ul class="dropdown-menu" role="menu">
	                <li><a href="<?php echo site_url("mystuffs/home")?>">ข้อมูลบัญชีผู้ใช้</a></li>
	                <li><a href="<?php echo site_url("mystuffs/home/edit/".$this->session->userdata('auth_user_id'))?>">แก้ไขบัญชีผู้ใช้</a></li>
	                <li class="divider"></li>
	                <li><a href="<?php echo site_url("authen/logout")?>">ออกจากระบบ</a></li>
	              </ul>
	            </li>
	            <!-- li style="border: 1px solid rgb(187, 187, 187); border-radius: 15px; height: 40px; margin-top: 5px; color: rgb(0, 0, 0) ! important;"><a href="<?php echo site_url("search/search_index")?>" id="search-link" style="padding-top: 10px ! important;"><span class="fa fa-search" style="color: rgb(255, 0, 0);"> </span><span style="color: rgb(0, 0, 0);"> ค้นหา</span></a></li-->
	            <!-- li><a href="<?php echo site_url("search/index")?>" id="search-link"><span class="fa fa-search" style="color:#000;"></span></a></li -->
	            
            <?php else:?>
            	<li><a href="<?php echo site_url(LOGIN_PAGE . '?redirect=mystuffs/home')?>">เข้าสู่ระบบ</a></li>
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
		):?>

<div class="container" id="survey-code">

<label>เลือกรหัสแบบสำรวจ</label>&#160;&#160;
<select name="survey_year" id="survey_year" >
<option>เลือกปี</option>
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
    jQuery("#survey_year").change(function () {
        location.href = '<?php echo site_url('survey/selectSurveyYear')?>/'+jQuery(this).val();

        var change_width = $('#survey-code').find('.select2-container--default');
    	console.log(change_width);
    })
})
</script>
<?php endif?>


<div class="container-fluid">
	<div class="msg-div" id="success-box" style="display:none"></div>
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

<div class="container-fluid">
	<div class="msg-div" id="error-box" style="display:none"></div>
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


$('#survey_year').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกรหัสแบบสำรวจ"
		});
});


</script>
</script>
<div class="loader" id ="loader"></div>