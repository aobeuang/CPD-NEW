<style>
<!--

-->
 input[type=number]::-webkit-inner-spin-button,  
 input[type=number]::-webkit-outer-spin-button {  
     -webkit-appearance: none!important; 
     -moz-appearance: none!important; 
     appearance: none!important; 
     margin: 0!important;  
 }
 input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>
<?php if(false){ ?>
<div id="main-wrapper">

	<div id="top-container" class="container col-md-12 col-xs-12">
		<div class="success-message hidden"></div>
	</div>
	
	
	
	<div id="main-container" class="container col-md-12 col-xs-12">
	        
		<div id="mainmenu_widget" class="widget">
	 		<div style="width:100%;float:left;">
	        	<div class=""  style="width:90%;margin-left:auto;margin-right:auto">
	        		<div class="container col-md-6 col-xs-12">
	             	<div id="mainmenu_widget" class="widget">
			 		<div style="width:100%;float:left;">
			        	<div class="floatL l5"  style="width:90%;">
			        	<?php /*
			        		<form id="searhbox" name="searchbox" method="GET" action='<?php echo site_url("survey/view_survey")?>'>
				*/ ?>
							<nav class="navbar navbar-light bg-light">
							
							<form id="searhbox_citizen_id" class="form-inline" name="searchbox" method="GET" action='<?php echo site_url("survey/search_survey_by_id")?>'>
			             	<h2><span class="glyphicon glyphicon-search"></span> ค้นหาแบบสำรวจด้วยหมายเลขบัตรประชาชน----</h2>
							<div>
								<input type="hidden" name="step" value="0"/>
								<input id="citizen_id" name="citizen_id" class="form-control mr-sm-2" type="number" placeholder="หมายเลขบัตรประชาชน" aria-label="Search" maxlength="13" autocomplete="off" oncopy="return false" oncut="return false" onpaste="return false">					   
								<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top: -2px;">
								<span class="glyphicon glyphicon-search"></span>
		          					ค้นหา</button>
							</div>					
							</form>
							</nav>	
			           	</div>
			       	</div>
			 		</div>
	             	</div>
	             	
					<div class="container col-md-6 col-xs-12">
					<div id="mainmenu_widget" class="widget">
			 		<div style="width:100%;float:left;">
			        	<div class="floatL l5"  style="width:90%;">
			        	<?php /*
			        		<form id="searhbox" name="searchbox" method="GET" action='<?php echo site_url("survey/view_survey")?>'>
				*/ ?>
							<nav class="navbar navbar-light bg-light">
							<form id="searhbox" class="form-inline" name="searchbox" method="GET" action='<?php echo site_url("survey/search_survey_by_name")?>''>
			             	<h2><span class="glyphicon glyphicon-search"></span> ค้นหาแบบสำรวจด้วยชื่อ-นามสกุล</h2>
							<div>
								<input id="coop_membername" name="coop_membername" class="form-control mr-sm-2" type="search" placeholder="ชื่อ-นามสกุล" aria-label="Search" autocomplete="off" oncopy="return false" oncut="return false" onpaste="return false">					   
								<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="searchname" style="margin-top: -2px;">
								<span class="glyphicon glyphicon-search"></span>
		          					<i class="fa fa-"></i>ค้นหา</button>
							</div>					
							</form>
							</nav>	
							
			           	</div>
			       	</div>
			 		</div>
			 		</div> 
					
					<?php /* if ($this->session->userdata('auth_role')=="admin"):?>
					<div class="container col-md-6 col-xs-12">
					<h2>การจัดการบัญชีผู้ใช้</h2>
					<div>
						<ul class="list-group">
							<li class="list-group-item"><a href="<?php echo site_url('admin/users_management')?>">การจัดการผู้ใช้งานระบบ</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('admin/group_management')?>">การจัดการกลุ่มผู้ใช้งาน</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('properties/properties')?>">การตั้งค่าระบบ</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('mylogger/index')?>">บันทึกการแก้ไขค่าของระบบ</a></li>														
							
						</ul>
					</div>	
					</div>
					<?php endif */ ?>
				
					<?php /* if ($this->session->userdata('auth_role')=="admin"):?>
					<div class="container col-md-6 col-xs-12">
					<h2><span class="glyphicon glyphicon-dashboard"></span> การดูประวัติการเข้าใช้งานระบบ</h2>
					<div>
						<ul class="list-group"> 
							<li class="list-group-item"><a href="<?php echo site_url('admin/suspiciouslog_management')?>">ดูประวัติการดูข้อมูลสมาชิกคนละจังหวัด</a></li>
			<!-- 			<li class="list-group-item"><a href="<?php echo site_url('loginlog/formauth')?>">Login Auth</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('loginlog/formci')?>">Login Session</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('loginlog/formloginerror')?>">Login Errors</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('loginlog/formips')?>">IPs On Hold</a></li>
							<li class="list-group-item"><a href="<?php echo site_url('loginlog/index')?>">Login Denied</a></li>   -->
						</ul>
					</div>	
					</div>	
					<?php endif */ ?>	

				</div>
	       	</div>
	 	</div>

	 	
	 	
	 	
	 	
	</div>    
	

	
</div>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 500px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="height: 45px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>
      
    </div>
  </div>
<script language="javascript">

				$(document).ready(function() {

// 					$('#searhbox').validate({
// 				        rules: {
// 				            field1: {
// 				                required: false,
// 				                email: false,
// 				                alphanumeric: false
// 				            }
// // 		            		,
// // 				            field2: {
// // 				                required: true,
// // 				                minlength: 10,
// // 				                alphanumeric: true
// // 				            },
// // 				            field3: {
// // 				                digits: true,
// // 				                minlength: 3
// // 				            }
// 				        }
// 				    });
					$("#coop_membername").keydown(function (e) {
						console.log(e.key);
						var reg = /^[a-zA-Zก-๗]+$/i;
						var reg_num_thai = /^[๑-๗]+$/i;
						
						if (e.key==' ')
						{
							return true;
						}
						
						if (e.key=='Enter')
						{						
							$('#searhbox button').click();		
							e.preventDefault();
						}
					
						console.log(reg.test(e.key));
						console.log(reg_num_thai.test(e.key));

						if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
						{
							return;
						}else{
							e.preventDefault();
							}

						
					});
				    
// 					$('#coop_membername').keydown(function(e) {
// 						// Allow: backspace, delete, tab, escape, enter and .
// 						if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
// 								// Allow: Ctrl/cmd+A
// 							(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
// 								// Allow: Ctrl/cmd+C
// 							(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
// 								// Allow: Ctrl/cmd+X
// 							(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
// 								// Allow: home, end, left, right
// 							(e.keyCode >= 35 && e.keyCode <= 39)) {
// 							// let it happen, don't do anything
							
// 							return;
							
// 						}
// 						// Ensure that it is a number and stop the keypress
// 						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
// 							return;
// 						}else{
// 							e.preventDefault();
// 							}
					    
// 					});

					
					$("#citizen_id").keydown(function (e) {

						var reg = /^[0-9]+$/i;
						if(reg.test(e.key))
						{
							if($(this).val().length >=13)
							{
								e.preventDefault();
							}
							return;
						}else{
							
							if (e.key=='Enter')
							{
								$('#searhbox_citizen_id button').click();		
								e.preventDefault();
							}
							
							if(e.key ==  '.' || e.shiftKey || (  e.key !=  '0' && e.key !=  '1'  && e.key !=  '2'  && e.key !=  '3' 
								 && e.key !=  '4'  && e.key !=  '5'  && e.key !=  '6'  && e.key !=  '7' 
									 && e.key !=  '8'  && e.key !=  '9'   ) && e.keyCode!=8 ){
								e.preventDefault();
							}

							if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
									// Allow: Ctrl/cmd+A
								(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
									// Allow: Ctrl/cmd+C
								(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
									// Allow: Ctrl/cmd+X
								(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
									// Allow: home, end, left, right
								(e.keyCode >= 35 && e.keyCode <= 39)) {
								// let it happen, don't do anything
								return;
							}


							
							
							e.preventDefault();
							}
// 						if(e.keyCode == 110){
// 							e.preventDefault();
// 						}
// 						// Allow: backspace, delete, tab, escape, enter and .
// 						if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
// 								// Allow: Ctrl/cmd+A
// 							(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
// 								// Allow: Ctrl/cmd+C
// 							(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
// 								// Allow: Ctrl/cmd+X
// 							(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
							
// 								// Allow: home, end, left, right
// 							(e.keyCode >= 35 && e.keyCode <= 39)) {
// 							// let it happen, don't do anything
// 							return;
// 						}
// 						// Ensure that it is a number and stop the keypress
// 						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
// 							e.preventDefault();
// 						}
					});



					$('#searhbox').submit(function(e){
						
						var test = $('#coop_membername').val();
						if (test=='')
						{
 					 		$('.modal-dialog').css('width','350px');
							var html = '<div class="" style="font-size:20px;"  >';
							html += '<div class="row">';
							html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:center;">';
							html += '<lable for id="coop_member_id" style="font-color:red;">กรุณากรอกชื่อหรือนามสกุล</lable>';
							html += '</div>	';			
							html += '</div>';
							html += '</div>';
							$('.modal-body').html(html);
							$('#myModal').modal({
								  keyboard: true
							})
							
					 		return false;
						}
					});					

					
					$('#searhbox_citizen_id').submit(function(e){
						
						var c;
						var test = $('#citizen_id').val();
						var search_name = $('#searhbox').val();
						console.log(test);

						if (test=='')
						{
 					 		$('.modal-dialog').css('width','350px');
							var html = '<div class="" style="font-size:20px;"  >';
							html += '<div class="row">';
							html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:center;">';
							html += '<lable for id="coop_member_id" style="font-color:red;">กรุณากรอกเลขบัตรประชาชน</lable>';
							html += '</div>	';			
							html += '</div>';
							html += '</div>';
							$('.modal-body').html(html);
							$('#myModal').modal({
								  keyboard: true
							})
							
					 		return false;
						}
						
					 	if(!checkID(test))
					 	{
 					 		$('.modal-dialog').css('width','350px');
							var html = '<div class="" style="font-size:20px;"  >';
							html += '<div class="row">';
							html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:center;">';
							html += '<lable for id="coop_member_id" style="font-color:red;">เลขบัตรประชาชนไม่ถูกต้อง</lable>';
							html += '</div>	';			
							html += '</div>';
							html += '</div>';
							$('.modal-body').html(html);
							$('#myModal').modal({
								  keyboard: true
							})
							
					 		return false;
					 	}
						else
						{
							return true;
						}
							});
					});
					
				function checkID(id)
				{
					var sum;
				    if(id.length != 13) return false;
				    for(i=0, sum=0; i < 12; i++)
				    sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
				    return false; return true;
				}

				
			</script>
<?php } ?>
