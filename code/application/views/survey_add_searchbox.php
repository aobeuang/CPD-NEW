<?php $this->load->helper('form');?>
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
<div id="main-wrapper">
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">

			<form id="searchbox" name="searchbox" method="GET"   action='<?php echo site_url("survey/add_survey")?>'>
			
			<div class="container-fluid col-md-12 col-xs-12" >
				<span>Page Code : SV100</span>
				<h2>เริ่มกรอกข้อมูลเพื่อเก็บข้อมูลแบบสำรวจ</h2>
				
			    <div class="row">

					<div class="container-fluid col-md-9 col-xs-12" >
						
						<nav class="navbar navbar-light bg-light">
						<h2>1. กรุณากรอกหมายเลขบัตรประชาชน</h2>
						<div>
							<input id="citizen_id" name="citizen_id" class="form-control mr-sm-2" type="number" placeholder="หมายเลขบัตรประชาชน" aria-label="Search" maxlength="13" autocomplete="off" value="<?php if (isset($citizen_id)) echo $citizen_id?>">
							<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top:15px">
	          					<span class="glyphicon glyphicon-search"></span> ค้นหา</button>
	          				<input type="hidden" name="step" value="0"/>						
						</div>	
						</nav>	
	
						<br/><br/>
						<?php if (!empty($coops)):?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" >2. เลือกสหกรณ์เพื่อเริ่มการกรอกแบบสอบถาม</lable>
								</div>
								<div class="container-fluid col-md-12 col-xs-12" style="margin-left:18px;line-height:30px;" >

									<?php

										$already_have = array();

									    foreach ($coops as $k=>$v):?>
									    
									    	<?php if (!in_array($v['REGISTRY_NO_2'], $already_have)):?>
									    
											    <?php $already_have[] = $v['REGISTRY_NO_2'];?>
											    
												
												<?php if (in_array($v['REGISTRY_NO_2'], $existing_coop_surveys)):?>
												
													<?php if (canViewSurveyByCoop($v['REGISTRY_NO_2'])):?>
													
														<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo urlencode($citizen_id)?>/?coop=<?php echo $v['REGISTRY_NO_2']?>&step=1&&org=<?php echo $v['ORG_ID']?>&citizen_id=<?php echo urlencode($citizen_id)?>"><span class="glyphicon glyphicon-edit"> <?php echo $v['COOP_NAME_TH']?> <?php echo $v['PROVINCE_NAME']?>						
															(มีการทำแบบสำรวจแล้ว)
														</a>
													
													<?php else:?>
													
														<a href="#" class="nopermission"><span class="glyphicon glyphicon-eye-close"> <?php echo trim($v['COOP_NAME_TH'])?>, <?php echo $v['PROVINCE_NAME']?>						
															(ไม่มีสิทธิเข้าถึงข้อมูลสมาชิก <?php echo $v['ORG_NAME']?>)
														</a>
														
													<?php endif?>
													
												<?php else:?>
													
													<?php if (canViewSurveyByCoop($v['REGISTRY_NO_2'])):?>
													
														<a href="<?php echo site_url("admin/add_survey_1")?>/<?php echo urlencode($citizen_id)?>/?coop=<?php echo $v['REGISTRY_NO_2']?>&step=1&org=<?php echo $v['ORG_ID']?>&citizen_id=<?php echo urlencode($citizen_id)?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $v['COOP_NAME_TH']?>, <?php echo $v['PROVINCE_NAME']?>						
															(ยังไม่เคยทำแบบสำรวจ)
														</a>						
													
													<?php else:?>
		
													
														<a href="#" class="nopermission"><span class="glyphicon glyphicon-eye-close"></span> <?php echo $v['COOP_NAME_TH']?>, <?php echo $v['PROVINCE_NAME']?>						
															(ไม่มีสิทธิเข้าถึงข้อมูลสมาชิก <?php echo $v['ORG_NAME']?>)
														</a>												
													
													<?php endif?>
													
												<?php endif?>	
											<br/>
											
										<?php endif ?>
									<?php endforeach;?>
									
								</div>
							</div>
						</div>
						
						<?php else:?>
						<?php if(isset($_GET['citizen_id'])){ ?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูลสหกรณ์ที่เป็นสมาชิกในฐานข้อมูลสมาชิก!!</lable><br/>
									<a href="<?php
									$citizen_id = "";
									if(isset($_GET['citizen_id'])){ $citizen_id =  $_GET['citizen_id']; }
									echo site_url("admin/do_survey_1/".$citizen_id."/?citizen_id=".$citizen_id."&step=1")?>"><span class="glyphicon glyphicon-plus"> เพิ่มแบบสำรวจโดยกรอกข้อมูลสมาชิกเอง</a>
									
									<br/><br/><br/>
									<?php if (!empty($surveys)):?>
										<label style="font-weight:0;">พบข้อมูลแบบสอบถามสมาชิกดังนี้</label>

										<ul style="list-style: none;list-style: none;padding-left: 0;margin-top:20px">
									
											<?php foreach ($surveys as $k=>$v):?>
											<?php $coop = getCoopByID($v['COOP_ID']);?>
											<?php if (!empty($coop)):?>
											<li style="background-color:#eeffee;padding-top:8px;padding-bottom:8px;padding-left:16px;width:90%;margin-top: 3px;">
												
												
												
												<?php if (canViewSurveyByCoop($coop['REGISTRY_NO_2'])):?>
												
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1"><?php echo $coop['COOP_NAME_TH']?></a>
												<br/>
												
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-eye-open"></span> ดู
												</a>|
	
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $citizen_id?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-edit"></span> แก้ไข
												</a>
												
												<?php else:?>

												<a href="#" class="nopermission"><?php echo $coop['COOP_NAME_TH']?></a>
												<br/>
												
												<a href="#" class="nopermission">
													<span class="glyphicon glyphicon-eye-close"></span> ไม่มีสิทธิเข้าถึงข้อมูลแบบสอบถาม พื้นที่<?php echo $coop['ORG_NAME']?>
												</a>
												
												<?php endif?>
											
											</li>
											<?php endif?>
											<?php endforeach?>
										</ul>
									<?php else:?>
									
									
									<?php endif?>
								</div>
							</div>
						</div>
						<?php }else{ }//echo "กรุณาพิมพ์เพื่อข้อหาข้อมูลก่อน"; } ?>
						<?php endif?>
	
					</div>
				</div>
			</div>
			
	
			</form>
			<script language="javascript">

				function checkID(id)
				{
					var sum;
				    if(id.length != 13) return false;
				    for(i=0, sum=0; i < 12; i++)
				    sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
				    return false; return true;
				}

				function checkPinID(){
					var c;
					var test = $('#citizen_id').val();
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
				}
			
				$(document).ready(function() {

					$('form').on('focus', 'input[type=number]', function (e) {
						  $(this).on('mousewheel.disableScroll', function (e) {
						    e.preventDefault()
						  })
						})
						$('form').on('blur', 'input[type=number]', function (e) {
						  $(this).off('mousewheel.disableScroll')
						})

					
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

					$('#searchbox').submit(function(e){

						
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
							});

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
			</script>



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
