<style>
<!--

-->
/* input[type=number]::-webkit-inner-spin-button,  */
/* input[type=number]::-webkit-outer-spin-button {  */
/*   -webkit-appearance: none!important;  */
/*   margin: 0!important;  */
/* } */

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
input#citizen_id{width: 200px!important;}
</style> 

<?php $this->load->helper('form');?>

<div id="main-wrapper">
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">
		
			<form id="searhbox" name="searchbox" method="GET" action='<?php echo site_url("survey/search_survey_by_id")?>'>
			
			<div class="container-fluid col-md-12 col-xs-12" >
				
				<h2><span class="glyphicon glyphicon-search"></span> ค้นหาแบบสำรวจ</h2>
				
			    <div class="row">

					<div class="container-fluid col-md-9 col-xs-12" >
						
						<nav class="navbar navbar-light bg-light">
						<h2>หมายเลขบัตรประชาชน</h2>
						<div>
							<input id="citizen_id" name="citizen_id" class="form-control mr-sm-2" type="number" placeholder="หมายเลขบัตรประชาชน" aria-label="Search" value="<?php if (isset($citizen_id)) echo $citizen_id?>">					   
							<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top:15px">
	          							<span class="glyphicon glyphicon-search"></span> ค้นหา</button>
	          				<input type="hidden" name="step" value="0"/>						
						</div>	
						</nav>	
	
						<br/><br/>
						<?php if (!empty($surveys)):?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" >พบแบบสำรวจของสมาชิกดังนี้</lable>
								</div>
								<div class="container-fluid col-md-12 col-xs-12" style="" >
									
									<ul style="list-style: none;list-style: none;padding-left: 0;margin-top:20px">
									
									<?php foreach ($surveys as $k=>$v):?>
										
										<li style="background-color:#eeffee;padding-top:8px;padding-bottom:8px;padding-left:16px;width:90%;margin-top: 3px;">
										<?php $coop = getCoopByID($v['COOP_ID'])?>
										<?php // echo "<pre>"; print_r($coop); echo "</pre>"; ?>
										<?php if(!empty($coop)):?>
										
										
											<?php if (canViewSurveyByCoop($coop['REGISTRY_NO_2'])):?>
										
											<?php //echo $v['citizen_firstname']?> <?php //echo $v['citizen_lastname']?><?php if (!empty($v['PROVINCE_NAME'])):?> (<?php echo $v['PROVINCE_NAME']?>)<?php endif?>
											<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1"><?php echo $coop['COOP_NAME_TH']?>, <?php echo $coop['PROVINCE_NAME']?></a>
											<br/>
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-eye-open"></span> ดู
												</a>|
	
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-edit"></span> แก้ไข
													</a>
													
											<?php else:?>
	
												<?php //echo $v['citizen_firstname']?> <?php //echo $v['citizen_lastname']?><?php if (!empty($v['PROVINCE_NAME'])):?> (<?php echo $v['PROVINCE_NAME']?>)<?php endif?>
												<a class="nopermission" href="#"><?php echo $coop['COOP_NAME_TH']?>, <?php echo $coop['PROVINCE_NAME']?></a>
												<br/>
													<a class="nopermission" href="#">
														<span class="glyphicon glyphicon-eye-close"></span> ไม่มีสิทธิเข้าถึง <?php echo $coop['ORG_NAME']?>
													</a>
													
											<?php endif?>		
												
										<?php endif?>
										
										</li>
										
										
										
									<?php endforeach;?>
									
									</ul>
								</div>
							</div>
						</div>
						
						<?php else:?>
						
						<?php if(isset($_GET['citizen_id'])){ ?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูลแบบสำรวจของสมาชิก!!</lable>
								</div>
								
							</div>
						</div>
						<?php }?>
						
						<?php endif?>
	
					</div>
				</div>
			</div>
			
	
			</form>
		</div>
	</div>
</div>



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<script language="javascript">

				$(document).ready(function() {
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

					});

					$('#searhbox').submit(function(e){
						
						var c;
						var test = $('#citizen_id').val();
						console.log(test);

						if(test=='')
					 	{
// 					 		$('#myModal').addClass('show').css("display","block");
							var html = '<div class="" style="font-size:20px;"  >';
							html += '<div class="row">';
							html += '<div class="container-fluid col-md-12 col-xs-12" >';
							html += '<lable for id="coop_member_id" style="font-color:red">กรุณากรอกเลขบัตรประชาชน</lable>';
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
// 					 		$('#myModal').addClass('show').css("display","block");
							var html = '<div class="" style="font-size:20px;"  >';
							html += '<div class="row">';
							html += '<div class="container-fluid col-md-12 col-xs-12" >';
							html += '<lable for id="coop_member_id" style="font-color:red">เลขบัตรประชาชนไม่ถูกต้อง</lable>';
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


