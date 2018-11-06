<?php $this->load->helper('form');?>

<div id="main-wrapper">
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">
		
			<form id="searhbox" name="searchbox" method="GET" action='<?php echo site_url("survey/add_survey")?>'>
			
			<div class="container-fluid col-md-12 col-xs-12" >
				
				<h2>ค้นหาข้อมูลแบบสอบถาม</h2>
				
			    <div class="row">

					<div class="container-fluid col-md-9 col-xs-12" >
						
						<nav class="navbar navbar-light bg-light">
						<form id="searhbox" class="form-inline" name="searchbox" method="GET" action='<?php echo site_url("admin/view_survey_by_name")?>'>
		             	<h2>กรุณากรอกชื่อ-นามสกุล</h2>
						<div>
							<input id="citizen_id" name="citizen_id" class="form-control mr-sm-2" type="search" placeholder="ชื่อ-นามสกุล" aria-label="Search" value="<?php if (isset($citizen_id)) echo $citizen_id?>">					   
							<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top:15px">
	          					<span class="glyphicon glyphicon-search"></span> ค้นหา</button>
	          				<input type="hidden" name="step" value="0"/>						
						</div>					
						</form>
						</nav>	
	
						<br/><br/>
						<?php if (!empty($coops)):?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" >2. เลือกสหกรณ์เพื่อเริ่มการกรอกแบบสอบถาม</lable>
								</div>
								<div class="container-fluid col-md-12 col-xs-12" style="margin-left:18px;line-height:30px;" >
									
									<?php foreach ($coops as $k=>$v):?>
										
										<?php if (in_array($v['COOP_ID'], $existing_coop_surveys)):?>
											<a href="<?php echo site_url("admin/add_survey")?>/<?php echo $citizen_id?>/?coop=<?php echo $v['COOP_ID']?>&org=<?php echo $v['ORG_ID']?>"><?php echo $v['COOP_NAME_TH']?> <?php echo $v['PROVINCE_NAME']?>						
												(มีการทำแบบสอบถามแล้ว)
											</a>
										<?php else:?>
											<a href="<?php echo site_url("admin/add_survey")?>/<?php echo $citizen_id?>/?coop=<?php echo $v['COOP_ID']?>&org=<?php echo $v['ORG_ID']?>"><?php echo $v['COOP_NAME_TH']?> <?php echo $v['PROVINCE_NAME']?>						
												(ยังไม่เคยทำแบบสอบถาม)
											</a>						
										<?php endif?>	
				
										
									<?php endforeach;?>
									
								</div>
							</div>
						</div>
						
						<?php else:?>
						
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูลสหกรณที่เป็นสมาชิก!!</lable>
								</div>
								
							</div>
						</div>
						
						<?php endif?>
	
					</div>
				</div>
			</div>
			
	
			</form>
		</div>
	</div>
</div>

